<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\TariffPlan;
use App\Models\Treatment;
use App\Services\BookingService;
use App\Services\DatabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BookingController extends Controller
{

    protected $bookingService;
    protected $databaseService;

    public function __construct(
        BookingService $bookingService,
        DatabaseService $databaseService
    ) {
        $this->bookingService = $bookingService;
        $this->databaseService = $databaseService;
    }

    public function checkPostcode(Request $request)
    {
        $postcode = $request->postcode;

        $postcode = $this->bookingService->checkPostalCodeCovered($postcode);
        $therapists = $this->bookingService->getTherapistsByPostcode($postcode->postcode, $count = true);

        $result = true;
        $message = '';
        if (!$postcode) {
            $result = false;
            $message = 'Sorry, we do not cover this area yet.';
        } elseif ($therapists == 0) {
            $result = false;
            $message = 'Sorry, we do not have any therapists in your area at the moment.';
        }

        return response()->json([
            'data' => [
                'result' => $result,
                'message' => $message,
                'postcode_id' => $postcode->id ?? null,
                'supplement' => $postcode->supplement ?? 0,
                'count' => $therapists
            ]
        ]);
    }

    public function bookingPostcode()
    {
        return view('frontend.modules.booking.postcode');
    }

    public function bookingInfo(Request $request)
    {

        if ($request->isMethod('post')) {
            $request->session()->put('booking', $request->except('_token'));
            $request->session()->put('booking.begin', microtime(true));
            return redirect()->to(route('bookingInfo'));
        }

        if (!$request->session()->has('booking')) {
            return redirect(route('bookingPostcode'))->with('message', 'Sorry, your session has expired. Please try again.');
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

        $postcode = $this->bookingService->checkPostalCodeCovered(session('booking.postcode'));
        $therapists = $this->bookingService->getTherapistsByPostcode($postcode->postcode);

        return view('frontend.modules.booking.booking_info', [
            'treatments' => $treatments,
            'durations' => $durations,
            'blockedIp' => $blockedIp,
            'therapists' => $therapists
        ]);
    }

    public function getDays(Request $request)
    {
        $days = $this->bookingService->getDays();
        $view = View::make('frontend.modules.booking.partials.days', [
            'days' => $days
        ])->render();
        return response()->json([
            'view' => $view
        ]);
    }

    public function getTime(Request $request)
    {
        $timezone = new \DateTimeZone("Europe/London");
        $post_date = new \DateTime($request->date, $timezone);
        $now = new \DateTime('now', $timezone);
        $lockedTime = $this->bookingService->checkLockedTime($now, $post_date, $request->now);

        if ($lockedTime) {
            return View::make('frontend.modules.booking.partials.time', [
                'time_today' => true
            ]);
        }
        if ($now->format('Y-m-d') != $post_date->format('Y-m-d')) {
            return View::make('frontend.modules.booking.partials.time', [
                'timeSlots' => $this->bookingService->getTime(),
                'busy_time' => null,
                'now' => null,
                'time_today' => false,
            ]);
        }
        $now_check = null;
        if ($request->now == 'now') {
            if (($post_date->format('i') == '00' || $post_date->format('i') == '30') && $post_date->format('H:i') !== '00:00') {
                $now_check = 'first';
            } else {
                $now_check = 'now';
            }
        }

        $todayBookings = null;
        if ($request->id) {
            $todayBookings = $this->bookingService->getToDayBooking($request->id, $request->date, $request->duration);
        }
        return View::make('frontend.modules.booking.partials.time', [
            'timeSlots' => $request->now == 'now' ? $this->bookingService->getPrepareTime(true) : $this->bookingService->getPrepareTime(),
            'busy_time' => $todayBookings,
            'now' => $now_check ? $now_check : null,
            'time_today' => false,
        ]);
    }

    public function getFreeTherapists($date, $duration = 2, $name = null, $asap = false, $timeAviability = null)
    {

    }
}
