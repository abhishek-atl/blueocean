<?php

namespace App\Http\Controllers;

use App\Exports\AccountUserExport;
use App\Http\Requests\Auth\AccountRequest;
use App\Models\PaymentReceived;
use App\Models\StripeEventsLog;
use App\Models\TherapistsMandate;
use App\Models\UserProfile;

use App\Services\BookingMailService;
use App\Services\BookingService;
use App\Services\MailService;
use App\Services\PaymentService;
use App\Services\SmsService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Stripe;

class AccountController extends Controller
{

    protected BookingService $bookingService;
    protected UserService $userService;
    protected PaymentService $paymentService;
    protected BookingMailService $bookingMailService;
    protected MailService $mailService;
    protected SmsService $smsService;

    public function __construct(
        BookingService $bookingService,
        UserService $userService,
        PaymentService $paymentService,
        MailService $mailService,
        BookingMailService $bookingMailService,
        SmsService $smsService
    ) {
        $this->bookingService = $bookingService;
        $this->userService = $userService;
        $this->paymentService = $paymentService;
        $this->mailService = $mailService;
        $this->bookingMailService = $bookingMailService;
        $this->smsService = $smsService;
    }

    // common to client and therapists
    public function rateBooking(Request $request)
    {
        if (Auth::user()->hasRole('Customer')) // rate to therapist
            $result = $this->userService->rateTherapist($request->booking_id, $request->evaluation);
        elseif (Auth::user()->hasRole('Therapist')) // rate to customer
            $result = $this->userService->rateCustomer($request->booking_id, $request->evaluation);
        return $result;
    }

    public function bookings(Request $request)
    {
        if (Auth::user()->hasRole('Customer'))
            $view = $this->client_bookings($request);
        elseif (Auth::user()->hasRole('Therapist'))
            $view = $this->therapist_bookings($request);
        return $view;
    }

    //*******************************************************************************/
    // Client  functions
    //*******************************************************************************/
    public function account(Request $request)
    {
        abort_if(!Auth::user()->hasRole('Customer'), 403);
        $user = Auth::user();
        $user->load(['user_profile']);
        $isEdit = true;
        return view('frontend.modules.account.my_account', [
            'userDetail' => $user,
            'isEdit' => $isEdit,
        ]);
    }

    public function accountPost(AccountRequest $request)
    {
        abort_if(!Auth::user()->hasRole('Customer'), 403);
        $email = Auth::user()->email;

        $params = $request->except(['_token', 'proengsoft_jsvalidation']);

        Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        $userProfile = UserProfile::where('user_id', Auth::user()->id)->first();
        $userProfile->update([
            'mobile' => $request->input('mobile'),
            'flat_no' => $request->input('flat_no'),
            'street_number' => $request->input('street_number'),
            'street_name' => $request->input('street_name'),
            'town' => $request->input('town'),
            'postcode' => $request->input('postcode'),
        ]);

        if ($email != $request->email) {
            $result = $this->userService->sendVerificationLink(Auth::id());
            Auth::user()->update([
                'email_verified_at' => null
            ]);
            $this->userService->logout($request);
            return redirect(route('auth.login'))->with('success', 'A verification link has been sent to your email address. Please check your email.');
        }

        return redirect()->back()->with('success', 'User details save successfully');
    }

    public function accountPasswordPost(Request $request)
    {
        abort_if(!Auth::user()->hasRole('Customer'), 403);
        $params = [];
        $params['password'] = bcrypt($request->password);
        Auth::user()->update($params);
        return redirect()->back()->with('success', 'User details save successfully');
    }

    public function accountDataDownload(Request $request)
    {
        abort_if(!Auth::user()->hasRole('client'), 403);
        if (isset($request->btnDownloadProfileData))
            return Excel::download(new AccountUserExport('profile'), 'my_profile_data.xlsx');
        elseif (isset($request->btnDownloadBookingData))
            return Excel::download(new AccountUserExport('booking'), 'my_booking_data.xlsx');
        return false;
    }


    //*******************************************************************************/
    // Therapist functions
    //*******************************************************************************/

    public function stripeWebhook(Request $request)
    {

        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey(config('custom.stripe_secret_key'));

        // If you are testing your webhook locally with the Stripe CLI you
        // can find the endpoint's secret by running `stripe listen`
        // Otherwise, find your endpoint's secret in your webhook settings in the Developer Dashboard
        $endpoint_secret = 'whsec_IOOicrBEtei7Mu7BnkHtpWeQjneHrGN8';
        $payload = @file_get_contents('php://input');

        //$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        // try {
        //     $event = \Stripe\Webhook::constructEvent(
        //         $payload,
        //         $sig_header,
        //         $endpoint_secret
        //     );
        // } catch (\UnexpectedValueException $e) {
        //     // Invalid payload
        //     http_response_code(400);
        //     echo json_encode(['Error parsing payload: ' => $e->getMessage()]);
        //     exit();
        // } catch (\Stripe\Exception\SignatureVerificationException $e) {
        //     // Invalid signature
        //     http_response_code(400);
        //     echo json_encode(['Error verifying webhook signature: ' => $e->getMessage()]);
        //     exit();
        // }

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        // Handle the event
        $customer = null;
        if ($event->data && $event->data->object && $event->data->object->customer) {
            $customer = $event->data->object->customer;
        }
        StripeEventsLog::create([
            'event_id' => $event->id,
            'customer' => $customer,
            'payload' => $payload,
            'event_type' => $event->type,
        ]);
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->paymentService->checkoutSessionCompleted($session);
                break;
            case 'mandate.updated':
                $paymentIntent = $event->data->object;
                $this->paymentService->updateMandateStatus($paymentIntent);
                break;
            case 'charge.succeeded':
                $charge = $event->data->object;
                $this->paymentService->paymentStatus($charge);
                break;
            case 'charge.failed':
                $charge = $event->data->object;
                $this->paymentService->paymentStatusfailed($charge);
                break;
            case 'charge.dispute.created':
                $dispute = $event->data->object;
                $this->paymentService->paymentDisputeCreated($dispute);
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        http_response_code(200);
    }

    public function mandates()
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);
        $user = Auth::user();
        $mandate = $user->mandate;
        $lastPayment = PaymentReceived::where('therapist_id', $user->therapist->id)->latest()->first();
        return view('frontend.modules.account.therapist_mandates', [
            'spk' => config('custom.stripe_public_key'),
            'mandate' => $mandate,
            'lastPayment' => $lastPayment
        ]);
    }

    public function createMandateSetupStripeSession()
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);

        $user = Auth::user();

        \Stripe\Stripe::setApiKey(config('custom.stripe_secret_key'));
        $stripeCustomer = $this->paymentService->createStripeCustomer($user);
        if ($stripeCustomer) {
            $successUrl = route('mandate_setup_success') . '?session_id={CHECKOUT_SESSION_ID}';
            $cancelUrl = route('mandates');
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['bacs_debit'],
                'mode' => 'setup',
                'customer' => $stripeCustomer->id,
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ]);
            return response()->redirectTo($session->url);
        }
    }

    public function mandateSetupSuccess(Request $request)
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);
        return redirect()->route('mandates')->with('success', 'Mandate submitted successfully');
    }

    function mandateCancel()
    {
        $therapist = Auth::user()->therapist;
        $mandate = TherapistsMandate::where('therapist_id', $therapist->id)->first();
        $stripe = new \Stripe\StripeClient(config('custom.stripe_secret_key'));
        $stripe->paymentMethods->detach($mandate->payment_method_id, []);
        $mandate->stripe_status = 'inactive';
        $mandate->is_enabled = 0;
        $mandate->save();
        return redirect()->route('mandates')->with('success', 'Mandate cancelled successfully');
    }


    public function profile(Request $request)
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);
        $user = Auth::user();
        $user->load('therapist.treatments:name');
        return view('frontend.modules.account.therapist_profile', [
            'therapist' => $user->therapist,
            'treatments' => $user->therapist->treatments
        ]);
    }

    public function postcodes()
    {
        $user = Auth::user();
        $user->load('therapist.postcodes');

        $params = [];
        $params['order_by'] = request('order_by') ? request('order_by') : 'id';
        $params['order'] = request('order') ? request('order') : 'asc';
        $params['with'] = ['postcodes.zone'];
        $districts = $this->postalDistrictRepository->getByParams($params);

        return view('frontend.modules.account.therapist_postcodes', [
            'therapist' => $user->therapist,
            'districts' => $districts
        ]);
    }

    public function schedules()
    {
        $therapist = Auth::user()->therapist;
        $therapist->load('schedule');
        $timeSlots = $this->bookingService->getTime();
        $days =
            [
                'mon' => 'Monday',
                'tue' => 'Tuesday',
                'wed' => 'Wednesday',
                'thu' => 'Thursdays',
                'fri' => 'Friday',
                'sat' => 'Saturday',
                'sun' => 'Sunday'
            ];
        return view('frontend.modules.account.therapist_schedules', [
            'therapist' => $therapist,
            'timeSlots' => $timeSlots,
            'days' => $days
        ]);
    }

    public function schedulesPost(Request $request)
    {
        $therapist = Auth::user()->therapist;
        $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        $daysSchedule = $request->only($days);

        if (!$therapist->schedule_id) {
            $schedule = $this->scheduleRepository->save([
                'mon' => '',
            ]);
            $scheduleId = $schedule->id;
        } else {
            $scheduleId = $therapist->schedule_id;
        }

        foreach ($days as $day) {
            $newSchedules = isset($daysSchedule[$day]) ? implode(',', $daysSchedule[$day]) : null;
            $this->scheduleRepository->save([
                $day => $newSchedules,
                'id' => $scheduleId
            ]);
        }
        $therapist->schedule_id = $scheduleId;
        $therapist->save();

        $email = $this->settingRepository->getByParams(['where' => ['param_key' => 'therapist_update_email']])->first()->value;
        $this->mailService->sendScheduleUpdateToAdmin($email, $therapist);

        return redirect()->back()->with('success_msg', 'Schedule updated successfully');
    }


    private function therapist_bookings($request)
    {
        $therapist = Auth::user()->therapist;
        $status = $request->get('type', 'new');
        $bookings = $this->bookingService->getTherapistBookings($therapist, $status, $request->get('search_bookings'));
        $bookings->appends(['type' => $status, 'search_bookings' => $request->get('search_bookings')]);
        $cancelledBookings = $this->bookingService->getTherapistBookings($therapist, 'cancelled', $request->get('search_bookings'));
        return view('frontend.modules.account.therapist_bookings', [
            'bookings' => $bookings,
            'cancelledBookings' => $cancelledBookings,
        ]);
    }

    private function client_bookings($request)
    {
        $request->session()->forget('booking');
        $params = [];
        $params['where'] = ['user_id' => Auth::user()->id];
        $params['order_by'] = 'appointment_start';
        $params['order'] = 'desc';
        $params['per_page'] = 10;

        if ($request->get('type') && $request->get('type') == 'cancelled') {
            $params['where']['status'] = 'cancelled';
        } else {
            $params['where']['status'] = 'new';
        }

        $bookings = $this->bookingService->getByParams($params);

        $cancelledBookings = null;
        if (!$request->get('type')) {
            $params = [];
            $params['where']['user_id'] = Auth::user()->id;
            $params['where']['status'] = 'cancelled';
            $cancelledBookings = $this->bookingService->getByParams($params);
        }

        return view('frontend.modules.account.my_bookings', [
            'bookings' => $bookings,
            'cancelledBookings' => $cancelledBookings,
        ]);
    }

    public function late(Request $request)
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);
        $booking = $this->bookingService->getById($request->booking_id);
        abort_if(!$booking, 404);

        $booking = $this->bookingService->lateBooking($booking);
        $booking->late_reason = $request->late_reason;
        $booking->save();

        // if ($booking->email) {
        //     $this->bookingMailService->sendReconfirmMailClient($booking, $booking->email);
        // }
        // $this->bookingMailService->sendReconfirmMailTherapist($booking);
        // $this->bookingMailService->sendReconfirmMailAdmin($booking);
        // try {
        //     $this->smsService->sendLateSmsToAdmin($booking);
        // } catch (\Exception $e) {
        // }

        return $booking->training_day->format('H:i');
    }

    public function extend(Request $request)
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);
        $booking = $this->bookingService->getById($request->booking_id);
        abort_if(!$booking, 404);

        if ($booking->payment->payment_type == 'stripe' || $booking->payment->payment_type == 'gift_voucher') {
            $booking->is_extension_paid = 0;
            $booking->save();
            $this->smsService->sendExtendSmsToClient($booking);
            if ($booking->email)
                $this->bookingMailService->sendExtendEmailToClient($booking);
        } else {
            session(['booking.extend_time' =>  $request->duration]);
            $booking = $this->bookingService->extendBooking($booking);
            session()->forget('booking.extend_time');
            $booking->refresh();
            if ($booking->email) {
                $this->bookingMailService->sendReconfirmMailClient($booking);
            }
            $this->bookingMailService->sendReconfirmMailTherapist($booking);
            // $this->bookingMailService->sendReconfirmMailAdmin($booking);
            $this->smsService->sendSmsToTherapist($booking);
        }
        $booking->load('payment');
        return $booking;
    }


    public function cancel(Request $request)
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);
        $booking = $this->bookingService->getById($request->booking_id);
        abort_if(!$booking, 404);

        $booking = $this->bookingService->markForCancel($booking);
        $booking->cancel_reason = $request->cancel_reason;
        $booking->save();
        $this->bookingMailService->sendCancellationRequestMailToAdmin($booking);
        $this->smsService->sendCancellationRequestSMSToAdmin($booking);
        return $booking;
    }

    public function bookingUpdate(Request $request)
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);
        $booking = $this->bookingService->getById($request->booking_id);
        abort_if(!$booking, 404);

        $this->smsService->sendBookingUpdateSmsToAdmin($booking, $request->update);
        return $booking;
    }

    public function calendar(Request $request)
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);
        $therapist = Auth::user()->therapist;
        $upcomingHoldiays = $therapist->holidays()
            ->whereDate('start_date', '>=', now())
            ->selectRaw('start_date as start, end_date as end, "backgroud" as display')->get();

        $events = '[';
        foreach ($upcomingHoldiays as $holiday) {
            $start = Carbon::createFromDate($holiday->start)->format('Y-m-d');
            $end = Carbon::createFromDate($holiday->end)->format('Y-m-d');
            $start = $holiday->start;
            $end = $holiday->end;
            $events .= '{start:\'' . $start . '\',';
            $events .= 'end:\'' . $end . '\',';
            //            $events .= 'display: \'background\',';
            $events .= 'color : \'#ffc299\'},';
        }
        $events .= ']';

        return view('frontend.modules.account.therapist_calendar', [
            'events' => $events
        ]);
    }

    public function calendarPost(Request $request)
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);
        $therapist = Auth::user()->therapist;

        if ($request->type == 'add') {
            $params = [];
            $params['therapists_id'] = $therapist->id;
            $params['start_date'] = Carbon::createFromFormat(config('custom.format.date_time'), $request->start_date);
            $params['end_date'] = Carbon::createFromFormat(config('custom.format.date_time'), $request->end_date);
            $holiday = $this->therapistsHolidayRepository->save($params);
            $holiday->load('therapist');

            $email = $this->settingRepository->getByParams(['where' => ['param_key' => 'therapist_update_email']])->first()->value;
            $this->mailService->SendHolidayUpdateToAdmin($email, $holiday, $request->type);
            $this->mailService->SendHolidayUpdateToTherapist($holiday, $request->type);
        } elseif ($request->type == 'delete') {
            $holiday = $this->therapistsHolidayRepository->getById($request->id);
            abort_if(!$holiday, 404);
            $holiday->load('therapist');
            $this->therapistsHolidayRepository->delete($holiday->id);
            $email = $this->settingRepository->getByParams(['where' => ['param_key' => 'therapist_update_email']])->first()->value;
            $this->mailService->SendHolidayUpdateToAdmin($email, $holiday, $request->type);
            $this->mailService->SendHolidayUpdateToTherapist($holiday, $request->type);
            //$this->smsService->sendHolidayCancelSmsToAdmin($holiday);
            return $holiday;
        }
        return $holiday;
    }

    public function holidays(Request $request)
    {
        abort_if(!Auth::user()->hasRole('therapist'), 403);
        $therapist = Auth::user()->therapist;
        $holidays = $therapist->holidays()->orderBy('start_date', 'desc')->paginate(10);
        return view('frontend.modules.account.therapist_holidays', [
            'holidays' => $holidays
        ]);
    }
}
