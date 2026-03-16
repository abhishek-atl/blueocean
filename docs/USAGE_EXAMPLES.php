<?php

/**
 * USAGE EXAMPLES for getFreeTherapistsOnDateTime()
 *
 * This function finds available therapists for a given date, time, and duration.
 * It automatically considers:
 * - Therapist working schedules
 * - Therapist holidays
 * - Existing bookings
 */

// Example 1: Get available therapists for today at 10:00 AM (60 minutes default)
$bookingService = new \App\Services\BookingService();
$availableTherapists = $bookingService->getFreeTherapistsOnDateTime('2024-03-15', '10:00');
// Returns: Collection of User models for free therapists

// Example 2: Get available therapists with specific duration (90 minutes)
$availableTherapists = $bookingService->getFreeTherapistsOnDateTime('2024-03-15', '14:30', 90);

// Example 3: Using DateTime object instead of string
$date = new \DateTime('2024-03-15');
$availableTherapists = $bookingService->getFreeTherapistsOnDateTime($date, '09:00', 60);

// Example 4: Check availability only for specific therapists
$specificTherapistIds = [1, 2, 5];
$availableTherapists = $bookingService->getFreeTherapistsOnDateTime('2024-03-15', '11:00', 60, $specificTherapistIds);

// Example 5: Use in controller to display available therapists
namespace App\Http\Controllers;

use App\Services\BookingService;

class BookingController extends Controller
{
    public function getAvailableTherapists(BookingService $bookingService)
    {
        $date = request('date'); // e.g., '2024-03-15'
        $time = request('time'); // e.g., '10:00'
        $duration = request('duration', 60); // default 60 minutes

        $availableTherapists = $bookingService->getFreeTherapistsOnDateTime(
            $date,
            $time,
            $duration
        );

        return response()->json([
            'status' => 'success',
            'count' => $availableTherapists->count(),
            'therapists' => $availableTherapists->map(function ($therapist) {
                return [
                    'id' => $therapist->id,
                    'name' => $therapist->name,
                    'profile' => $therapist->therapist_profile,
                ];
            }),
        ]);
    }
}

// Example 6: Working with the returned collection
$availableTherapists = $bookingService->getFreeTherapistsOnDateTime('2024-03-15', '10:00', 60);

if ($availableTherapists->isEmpty()) {
    echo "No available therapists for this time slot";
} else {
    foreach ($availableTherapists as $therapist) {
        echo $therapist->name . " is available\n";
    }
}

/**
 * HOW THE FUNCTION WORKS:
 *
 * 1. VALIDATES SCHEDULE
 *    - Checks if therapist has working hours for the requested day
 *    - Verifies the appointment time falls within working hours
 *
 * 2. CHECKS HOLIDAYS
 *    - Excludes therapists who are on holiday during the appointment
 *    - Holiday period must not overlap with the appointment time
 *
 * 3. CHECKS EXISTING BOOKINGS
 *    - Excludes therapists with conflicting bookings
 *    - Only considers active bookings (status: 'new' or 'processing')
 *    - Detects any overlap with existing appointments
 *
 * PARAMETERS:
 * - $date (string|DateTime): Date in 'Y-m-d' format or DateTime object
 * - $time (string): Time in 'H:i' format (e.g., '09:00', '14:30')
 * - $duration (int): Appointment duration in minutes (default: 60)
 * - $therapistIds (array): Optional array of therapist IDs to filter by
 *
 * RETURNS:
 * - Illuminate\Database\Eloquent\Collection of available User models (therapists)
 *
 * DATABASE REQUIREMENTS:
 * - therapist_schedule table: Contains 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun' columns
 *   Format: "HH:MM-HH:MM" (e.g., "09:00-17:00")
 * - therapists_holidays table: Contains 'user_id', 'start_date', 'end_date'
 * - bookings table: Contains 'user_id', 'appointment_start', 'appointment_finish', 'status'
 */
