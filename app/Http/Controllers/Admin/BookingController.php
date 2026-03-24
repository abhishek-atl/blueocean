<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\TariffPlan;
use App\Models\Treatment;
use App\Models\User;

use App\Services\DatabaseService;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    protected $databaseService;

    public function __construct(
        DatabaseService $databaseService
    ) {
        $this->databaseService = $databaseService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');

        $params['with'] = ['therapist', 'treatment'];

        if (null != $request->get('search')) {
            $params['like'] = ['name' => $request->get('search')];
        }

        $bookings = $this->databaseService->getByParams(Booking::class, $params);

        return view('admin.modules.booking.index', [
            'bookings' => $bookings,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $booking = null;
        if ($id) {
            $booking = $this->databaseService->find(Booking::class, $id);
            $booking->load(['therapist', 'treatment']);
        }

        $therapists = $this->databaseService->getByParams(User::class, [
            'all' => true,
            'where' => ['user_type' => 'Therapist']
        ]);

        $treatments = $this->databaseService->getByParams(Treatment::class, ['all' => true]);
        $tariffPlans = $this->databaseService->getByParams(TariffPlan::class, ['where' => ['active' => true]]);

        return view('admin.modules.booking.create_edit', [
            'booking' => $booking,
            'therapists' => $therapists,
            'treatments' => $treatments,
            'tariffPlans' => $tariffPlans
        ]);
    }

    public function store(StoreBookingRequest $request)
    {
        $params = $request->except('_token');

        $bookingDateTime = now();
        $duration = (int) $request->duration;
        $appointmentStart = Carbon::createFromFormat(config('custom.format.date_time'), $request->appointment_start);
        $appointmentFinish = $appointmentStart->copy()->addMinutes($duration);

        $params['booking_datetime'] = $bookingDateTime;
        $params['appointment_start'] = $appointmentStart;
        $params['appointment_finish'] = $appointmentFinish;
        $params['client_ip_address'] = $request->ip();

        if (isset($params['id'])) {
            $booking = $this->databaseService->find(Booking::class, $params['id']);
            $booking->update($params);
            $message = 'Booking updated successfully.';
        } else {
            $booking = Booking::create($params);
            $message = 'Booking added successfully.';
        }

        if ($request->input('btnStay') === 'Save and stay') {
            return redirect()
                ->route('admin.bookings.edit', ['id' => $booking->id])
                ->with('status', $message);
        } else {
            return redirect()
                ->route('admin.bookings.index')
                ->with('status', $message);
        }

        return redirect()
            ->route('admin.bookings.edit', ['id' => $booking->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $booking = $this->databaseService->find(Booking::class, $id);
        $booking->delete();

        return redirect()
            ->back()
            ->with('status', 'Booking deleted successfully.');
    }
}
