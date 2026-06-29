<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentReceived;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $lastWeek = Carbon::now()->subWeek();

        $bookings = Booking::with(['therapist', 'treatment'])
            ->where('status', 'new')
            ->where('created_at', '>=', $lastWeek)
            ->latest()
            ->get();

        $bookingIds = $bookings->pluck('id');
        $totalIncome = Payment::whereIn('booking_id', $bookingIds)
            ->where('status', 'completed')
            ->sum('amount');

        $newUsers = User::where('created_at', '>=', $lastWeek)->count();

        $totalPayout = PaymentReceived::where('is_settled', 1)
            ->sum('therapist_commission');

        return view('admin.modules.dashboard.index', [
            'bookings' => $bookings,
            'totalIncome' => $totalIncome,
            'newUsers' => $newUsers,
            'totalPayout' => $totalPayout,
        ]);
    }
}
