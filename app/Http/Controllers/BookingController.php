<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\Booking;
use App\Models\Postcode;
use App\Models\TariffPlan;
use App\Models\Treatment;
use App\Models\User;
use App\Services\BookingService;
use App\Services\DatabaseService;
use App\Services\FormatService;
use App\Services\MailService;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class BookingController extends Controller
{

    protected $bookingService;
    protected $databaseService;
    protected $formatService;
    protected $mailService;
    protected $smsService;

    public function __construct(
        BookingService $bookingService,
        DatabaseService $databaseService,
        FormatService $formatService,
        MailService $mailService,
        SmsService $smsService,
    ) {
        $this->bookingService = $bookingService;
        $this->databaseService = $databaseService;
        $this->formatService = $formatService;
        $this->mailService = $mailService;
        $this->smsService = $smsService;
    }

    public function bookingPostcode(Request $request)
    {
        $request->session()->forget('booking');

        if ($request->isMethod('post')) {
            $request->session()->put('booking', $request->except('_token'));
            $request->session()->put('booking.begin', microtime(true));
            return redirect()->to(route('bookingInfo'));
        }
        return view('frontend.modules.booking.postcode');
    }

    public function bookingInfo(Request $request)
    {
        if (!$request->session()->has('booking')) {
            return redirect(route('bookingPostcode'))->with('message', 'Sorry, your session has expired. Please try again.');
        }

        if ($request->isMethod('post')) {

            $request->session()->put('booking.duration', $request->duration);
            $request->session()->put('booking.treatment', $request->treatment);
            $request->session()->put('booking.date', $request->date);
            $request->session()->put('booking.time', $request->time);
            $request->session()->put('booking.therapist_id', $request->therapist_id);

            return redirect(route('bookingCheckout'));
            if (Auth::user())
                return redirect(route('bookingCheckout'));
            else
                return redirect(route('login'));
        }

        $params = [
            'where' => ['active' => 1],
            'order_by' => 'id',
            'all' => true
        ];
        $treatments = $this->databaseService->getByParams(Treatment::class, $params);
        $durations = $this->databaseService->getByParams(TariffPlan::class, $params);

        // block booking if ip is black listed
        $ip = $request->getClientIp();
        $params = [
            'where' => ['ip_address' => $ip],
            'first' => true
        ];
        $blockedIp = $this->databaseService->getByParams(Blacklist::class, $params);

        return view('frontend.modules.booking.booking_info', [
            'treatments' => $treatments,
            'durations' => $durations,
            'blockedIp' => $blockedIp,
        ]);
    }

    public function bookingCheckout(Request $request)
    {
        if (!$request->session()->has('booking')) {
            return redirect(route('bookingPostcode'))->with('message', 'Sorry, your session has expired. Please try again.');
        }

        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->session()->get('booking.date') . ' ' . $request->session()->get('booking.time'));

        $request->session()->forget([
            'booking.discount_amount',
            'booking.gift_voucher_code',
            'booking.gift_voucher_amount'
        ]);

        $duration = $this->databaseService->find(TariffPlan::class, $request->session()->get('booking.duration'));
        $treatment = $this->databaseService->find(Treatment::class, $request->session()->get('booking.treatment'));
        $therapist = $this->databaseService->find(User::class, $request->session()->get('booking.therapist_id'));
        $paymentMethod = $request->session()->get('booking.payment_method');

        $data = [];
        $data['name'] = Auth::user() ? Auth::user()->first_name . ' ' . Auth::user()->last_name : session('booking.name', '');
        $data['mobile'] = Auth::user() ? Auth::user()->mobile : session('booking.mobile', '');
        $data['flat_no'] = session('booking.flat_no', '');
        $data['street_number'] = session('booking.street_number', '');
        $data['street_name'] = session('booking.street_name', '');
        $data['town'] = session('booking.town');
        $data['postcode'] = session('booking.postcode');
        $data['email'] = null;

        if (Auth::user()) {
            $data['email'] = Auth::user()->email;
        } elseif (session('booking.email')) {
            $data['email'] = session('booking.email');
        }

        return view('frontend.modules.booking.checkout', [
            'spk' => config('custom.stripe_public_key'),
            'duration' => $duration,
            'treatment' => $treatment,
            'therapist' => $therapist,
            'dateTime' => $dateTime,
            'paymentMethod' => $paymentMethod,

            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'postcode' => $data['postcode'],
            'flat_no' => $data['flat_no'],
            'street_number' => $data['street_number'],
            'street_name' => $data['street_name'],
            'town' => $data['town'],
            'email' => $data['email'],
        ]);
    }

    public function bookingCheckoutPost(Request $request)
    {
        if (!$request->session()->has('booking')) {
            return redirect(route('bookingPostcode'))->with('message', 'Sorry, your session has expired. Please try again.');
        }

        $this->charges($request);

        $trainingDate = Carbon::createFromFormat('Y-m-d H:i', session('booking.date') . ' ' . session('booking.time'));
        $trainingFinish = clone($trainingDate);
        $trainingFinish->modify('+' . intval($request->session_duration) . ' minutes');
        $sessionCost = $this->formatService->parseFloat(session('booking.session_cost'));
        $travelSupp = $this->formatService->parseFloat(session('booking.travel_supp'));
        $discountAmount = $this->formatService->parseFloat(session('booking.discount_amount'));
        $totalCost = $this->formatService->parseFloat($sessionCost - $discountAmount);

        $therapist = $this->databaseService->find(User::class, session('booking.therapist_id'));
        $feeColumn = 'fee_therapist_' . (int) $request->session_duration;
        $feeTmr = $therapist->$feeColumn;
        if ($feeTmr) {
            $feeTmr = $this->formatService->parseFloat($feeTmr);
        } else {
            $tariffPlan = $this->databaseService->find(TariffPlan::class, session('booking.duration'));
            $feeTmr = $this->formatService->parseFloat($tariffPlan->fee);
        }
        $feeTherapist = $sessionCost - $feeTmr;
        if ($discountAmount) {
            $feeTmr = $feeTmr - $discountAmount;
        }

        $mobile = $request->mobile;
        if (substr($mobile, 0, 3) == '+44') {
            $mobile = str_replace('+44', 0, $mobile);
        }
        $mobile = str_replace(' ', '', $mobile);

        // gift card
        $giftDiscountAmount = $this->formatService->parseFloat(session('booking.gift_voucher_amount'));
        $giftDiscountRemainingAmount = null;
        $giftVoucherCode = session('booking.gift_voucher_code');


        $params = [];
        $params['treatment_id'] = session('booking.treatment');
        $params['therapist_id'] = $therapist->id;
        $params['booking_datetime'] = Carbon::createFromFormat('Y-m-d H:i', session('booking.date') . ' ' . session('booking.time'));
        $params['appointment_start'] = $trainingDate;
        $params['appointment_finish'] = $trainingFinish;

        $params['name'] = $request->name;
        $params['phone'] = $mobile;
        $params['postcode'] = $request->postcode;
        $params['flat_no'] = $request->flat_no;
        $params['street_number'] = $request->street_number;
        $params['street_name'] = $request->street_name;
        $params['town'] = $request->town;
        $params['comments'] = $request->comment;
        $params['email'] = $request->email;
        $params['duration'] = (int) $request->session_duration;

        $params['amount'] = $totalCost;
        $params['payable_amount'] = $sessionCost;
        $params['fee_platform'] = $feeTmr;
        $params['fee_therapist'] = $feeTherapist;

        $params['discount_amount'] = $discountAmount;
        $params['discount_code'] = $request->discount_code;
        $params['gift_discount_amount'] = $giftDiscountAmount;
        $params['gift_discount_remaining_amount'] = $giftDiscountRemainingAmount;
        $params['gift_discount_code'] = $giftVoucherCode;

        $params['client_ip_address'] = $request->getClientIp();
        $params['travel_supp'] = $travelSupp;
        $params['therapist_conf_sms'] = 0;
        $params['status'] = 'processing';
        $params['device'] = 'desktop';

        $booking = $this->databaseService->save(Booking::class, $params);

        session(['bookingId' => $booking->id]);

        return redirect(route('bookingSuccess'));
    }

    public function bookingSuccess(Request $request)
    {
        $request->session()->forget('booking');
        if ($request->session()->has('bookingId')) {

            $booking = $this->databaseService->find(Booking::class, $request->session()->get('bookingId'));
            $booking->load(['treatment', 'therapist', 'payment']);
            $booking->update([
                'status' => 'new'
            ]);

            if (Auth::user()) {
                //$this->mailService->sendBookingMailToClient($booking, Auth::user()->email);
            } else if ($booking->email) {
                //$this->mailService->sendBookingMailToClient($booking, $booking->email);
            }

            //$this->mailService->sendBookingMailToTherapist($booking);
            //$this->mailService->sendBookingMailToAdmin($booking);

            try {
                //$status = $this->smsService->sendSmsToTherapist($booking, $new = true);
                $status = 1;
                $booking->update(['therapist_conf_sms' => $status]);
            } catch (\Exception $e) {
                //$this->mailService->sendBookingSmsFailedToAdmin($booking);
            }

            $bookingId = $request->session()->get('bookingId');
            $request->session()->forget('bookingId');
            return view('frontend.modules.booking.success', [
                'booking' => $booking,
                'bookingId' => $bookingId
            ]);
        } else {
            return redirect()->to(route('home'));
        }
    }

    public function charges(Request $request)
    {
        try {

            $duration = $this->databaseService->find(TariffPlan::class, $request->session()->get('booking.duration'));
            $postcode = $this->databaseService->find(Postcode::class, $request->session()->get('booking.postcode_id'));

            $session_cost = $duration->amount;
            $travel_supplement = (int) $postcode->travel_supp;
            $discount_amount = session('booking.discount_amount', 0);
            $gift_voucher_amount = session('booking.gift_voucher_amount', 0);

            $total_cost = ($session_cost + $travel_supplement) - ($discount_amount + $gift_voucher_amount);

            $request->session()->put('booking.session_cost', $session_cost);
            $request->session()->put('booking.travel_supp', $travel_supplement);
            $request->session()->put('booking.discount_amount', $discount_amount);
            $request->session()->put('booking.gift_voucher_amount', $gift_voucher_amount);
            $request->session()->put('booking.total_cost', $total_cost);

            $response = ['result' => 1, 'data' => session('booking')];
        } catch (\Exception $e) {
            $response = ['result' => 0, 'data' => []];
        }
        return response()->json($response);
    }

    public function checkPostcode(Request $request)
    {
        $result = true;
        $message = '';
        $therapistsCount = null;

        $postcode = $this->bookingService->checkPostalCodeCovered($request->postcode);
        if (!$postcode) {
            $result = false;
            $message = 'Sorry, we do not cover this area yet.';
            $this->mailService->sendPostcodeNotCoveredMail($request->postcode);
        } else {
            $therapistsCount = $this->bookingService->getTherapistsByPostcode($postcode->postcode, $count = true);
            if ($therapistsCount == 0) {
                $result = false;
                $message = 'Sorry, we do not have any therapists in your area at the moment.';
            }
        }

        return response()->json([
            'data' => [
                'result' => $result,
                'message' => $message,
                'postcode_id' => $postcode->id ?? null,
                'supplement' => $postcode->supplement ?? 0,
                'count' => $therapistsCount
            ]
        ]);
    }


    public function getDays(Request $request)
    {
        $days = $this->bookingService->getBookableDays();
        $view = View::make('frontend.modules.booking.partials.days', [
            'days' => $days
        ])->render();
        return response()->json([
            'view' => $view
        ]);
    }

    public function getTime(Request $request)
    {
        $timeSlots = $this->bookingService->getAvailableTimeSlots();
        return View::make('frontend.modules.booking.partials.time', [
            'timeSlots' => $timeSlots,
        ]);
    }

    public function getFreeTherapists(Request $request)
    {
        $therapists = $this->bookingService->getFreeTherapists($date = null, $time = null);
        $therapistView = View::make('frontend.modules.booking.partials.therapists', [
            'therapists' => $therapists,
        ])->render();

        return response()->json([
            'therapists' => $therapistView,
        ]);
    }

    public function therapistInfo(Request $request)
    {
        $therapist = $this->databaseService->getByParams(User::class, [
            'where' => ['id' => $request->therapist_id],
            'first' => true
        ]);
        $therapist->load(['treatments', 'user_profile', 'therapist_profile']);
        $view = View::make('frontend.modules.booking.partials.therapist_info', [
            'therapist' => $therapist
        ])->render();
        return response()->json([
            'view' => $view
        ]);
    }
}
