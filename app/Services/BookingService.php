<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Postcode;
use App\Models\Setting;
use App\Models\TherapistHoliday;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService extends BaseService
{

    protected $booking;

    public function __construct(Booking $booking)
    {
        parent::__construct($booking);
        $this->booking = $booking;
    }

    /* 
    * Check if postcode is covered for service
    */
    public function checkPostalCodeCovered($postcode)
    {
        // First try to find the postcode with initial 4 characters
        // Other formats needs to be considered
        $shortPostcode = substr($postcode, 0, 4);
        $postcode = Postcode::where('postcode', $shortPostcode)
            ->where('active', 1)
            ->first();
        return $postcode;
    }

    /**
     * Get therapists by postcode
     */
    public function getTherapistsByPostcode($postcode, $count = false)
    {
        $query = User::whereHas('postcodes', function ($query) use ($postcode) {
            $query->where('postcode', $postcode);
        });

        if ($count) {
            return $query->count();
        } else {
            return $query->get();
        }
    }

    /**
     * Get next 15 days starting from today or tomorrow based on current time.
     * If current time is 22:31 or later, start from tomorrow, otherwise from today.
     *
     * @return array Array of dates with day info (number, month, day name, full date)
     */
    public function getBookableDays()
    {
        $now = Carbon::now();
        $cutoffTime = Carbon::now()->setTime(22, 31, 0);
        $dates = [];

        // Determine start date based on current time
        $startDate = $now >= $cutoffTime ? $now->addDay()->startOfDay() : $now->startOfDay();

        // Generate next 15 days
        for ($i = 0; $i < 15; $i++) {
            $currentDate = (clone $startDate)->addDays($i);

            $dates[] = [
                'number' => $currentDate->format('d'),
                'month' => $currentDate->format('M'),
                'day' => $currentDate->format('D'),
                'full' => $currentDate->format('Y-m-d'),
                'timestamp' => $currentDate->timestamp,
            ];
        }
        return $dates;
    }

    /**
     * Get available time slots every 30 minutes from now to 22:00
     * If current time is greater than 22:00, time slots start from 07:00 the next day
     *
     * @return array Array of time slots in 'H:i' format
     */
    public function getAvailableTimeSlots()
    {
        $now = Carbon::now()->addHour();
        $endTime = Carbon::now()->setTime(22, 30, 0);
        $timeSlots = [];

        // If current time is after 22:30, start from 07:00 tomorrow
        if ($now > $endTime) {
            $startTime = $now->addDay()->setTime(7, 0, 0);
        } else {
            // Start from current time, rounded to nearest 30-minute interval
            $startTime = clone $now;
            $minute = (int)$startTime->format('i');

            // Round up to next 30-minute interval
            if ($minute > 0 && $minute < 30) {
                $startTime->setTime($startTime->format('H'), 30, 0);
            } elseif ($minute > 30) {
                $startTime->addHour()->setTime($startTime->format('H'), 0, 0);
            }
        }

        // Set end time to 22:00 on the start date
        $endTimeSlot = (clone $startTime)->setTime(22, 30, 0);

        // Generate 30-minute intervals
        while ($startTime <= $endTimeSlot) {
            $timeSlots[] = $startTime->format('H:i');
            $startTime->addMinutes(30);
        }
        return $timeSlots;
    }

    /**
     * Get available therapists for a given date and time
     * Considers therapist schedules, holidays, and existing bookings
     *
     * @param string|\DateTime $date The date to check (format: 'Y-m-d' or DateTime object)
     * @param string $time The time to check (format: 'H:i', e.g., '09:00')
     * @param int $duration Duration of the appointment in minutes (optional, default: 60)
     * @param array $therapistIds Optional array of specific therapist IDs to check
     * @return \Illuminate\Database\Eloquent\Collection Available therapists
     */
    public function getFreeTherapists($date, $time, $duration = 60, $therapistIds = [])
    {
        // Base query for therapists
        $query = User::where('user_type', User::TYPE_THERAPIST)
            ->where('active', 1)
            ->with(['therapist_profile', 'user_profile'])
            ->whereHas('schedule');

        // Filter by specific therapist IDs if provided
        if (!empty($therapistIds)) {
            $query->whereIn('id', $therapistIds);
        }
        $therapists = $query->get();

        $startDateTime = null;
        $endDateTime = null;
        $scheduleDay = null;
        if ($date && $time) {
            $timeParts = explode(':', $time);
            $startDateTime = clone $date;
            $startDateTime->setTime((int)$timeParts[0], (int)$timeParts[1], 0);

            // Calculate end time
            $endDateTime = clone $startDateTime;
            $endDateTime->modify("+{$duration} minutes");


            // Get day of week (mon, tue, wed, etc.)
            $dayOfWeek = strtolower($date->format('D'));
            $dayMap = ['mon' => 'mon', 'tue' => 'tue', 'wed' => 'wed', 'thu' => 'thu', 'fri' => 'fri', 'sat' => 'sat', 'sun' => 'sun'];
            $scheduleDay = $dayMap[$dayOfWeek];
        }

        // Filter therapists based on schedule, holidays, and bookings
        $availableTherapists = $therapists->filter(function ($therapist) use (
            $date,
            $startDateTime,
            $endDateTime,
            $scheduleDay,
            $duration
        ) {
            // Check 1: Is therapist on holiday?
            if ($startDateTime && $endDateTime) {
                $isOnHoliday = TherapistHoliday::where('user_id', $therapist->id)
                    ->where('start_date', '<=', $endDateTime)
                    ->where('end_date', '>=', $startDateTime)
                    ->exists();

                if ($isOnHoliday) {
                    return false;
                }
            }

            // Check 2: Does therapist have working hours for this day?
            if ($scheduleDay) {
                $schedule = $therapist->schedule;
                if (!$schedule || empty($schedule->{$scheduleDay})) {
                    return false;
                }

                $workingHours = $schedule->{$scheduleDay};
                if (!$this->isTimeWithinWorkingHours($startDateTime, $endDateTime, $workingHours)) {
                    return false;
                }
            }

            // Check 3: Are there conflicting bookings?
            if ($startDateTime && $endDateTime) {
                $hasConflictingBooking = DB::table('bookings')
                    ->where('user_id', $therapist->id)
                    ->where(function ($query) use ($startDateTime, $endDateTime) {
                        // Check if there's any overlap with existing bookings
                        $query->whereBetween('appointment_start', [$startDateTime, $endDateTime])
                            ->orWhereBetween('appointment_finish', [$startDateTime, $endDateTime])
                            ->orWhere(function ($q) use ($startDateTime, $endDateTime) {
                                $q->where('appointment_start', '<', $startDateTime)
                                    ->where('appointment_finish', '>', $endDateTime);
                            });
                    })
                    ->whereIn('status', ['new', 'processing']) // Only consider active bookings
                    ->exists();

                if ($hasConflictingBooking) {
                    return false;
                }
            }

            return true;
        });

        return $availableTherapists->values();
    }


    public function getTime()
    {

        return $time = [
            1 => '07:00',
            2 => '07:30',
            3 => '08:00',
            4 => '08:30',
            5 => '09:00',
            6 => '09:30',
            7 => '10:00',
            8 => '10:30',
            9 => '11:00',
            10 => '11:30',
            11 => '12:00',
            12 => '12:30',
            13 => '13:00',
            14 => '13:30',
            15 => '14:00',
            16 => '14:30',
            17 => '15:00',
            18 => '15:30',
            19 => '16:00',
            20 => '16:30',
            21 => '17:00',
            22 => '17:30',
            23 => '18:00',
            24 => '18:30',
            25 => '19:00',
            26 => '19:30',
            27 => '20:00',
            28 => '20:30',
            29 => '21:00',
            30 => '21:30',
            31 => '22:00',
            32 => '22:30',
            33 => '23:00',
            34 => '23:30',
        ];
    }

    /**
     * Check if a given time falls within working hours
     *
     * @param \DateTime $startDateTime
     * @param \DateTime $endDateTime
     * @param string $workingHours Format: "HH:MM-HH:MM" e.g., "09:00-17:00"
     * @return bool
     */
    private function isTimeWithinWorkingHours(\DateTime $startDateTime, \DateTime $endDateTime, $workingHours)
    {
        // Parse working hours (e.g., "09:00-17:00")
        $hours = explode('-', $workingHours);
        if (count($hours) !== 2) {
            return false;
        }

        $workStart = \DateTime::createFromFormat('H:i', trim($hours[0]));
        $workEnd = \DateTime::createFromFormat('H:i', trim($hours[1]));

        if (!$workStart || !$workEnd) {
            return false;
        }

        // Set the date to the start/end time
        $workStart->setDate(
            $startDateTime->format('Y'),
            $startDateTime->format('m'),
            $startDateTime->format('d')
        );
        $workEnd->setDate(
            $startDateTime->format('Y'),
            $startDateTime->format('m'),
            $startDateTime->format('d')
        );

        // Check if appointment falls within working hours
        return $startDateTime >= $workStart && $endDateTime <= $workEnd;
    }

    public function getTherapistBookings($therapist, $status = 'new', $search = null)
    {
        $qb = Booking::whereRaw('1=1');
        $qb->whereStatus($status);
        $qb->whereDate('appointment_start', '>=', Carbon::now()->startOfWeek());
        if ($search) {
            $qb->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->orWhere('phone', 'like', '%' . $search . '%');
                $query->orWhere('postcode', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $qb->whereRelation('therapist', 'id', '=', $therapist->id);
        $qb->orderBy('appointment_start', 'desc');
        $bookings = $qb->paginate(10);
        return $bookings;
    }

    public function markForCancel($booking)
    {
        $booking->cancellation_requested_at = now();
        $booking->save();
        return $booking;
    }

    public function lateBooking($booking)
    {
        $start = Carbon::createFromDate($booking->appointment_start)->addMinutes(30);
        $finish = Carbon::createFromDate($booking->appointment_end)->addMinutes(30);
        $booking->update([
            'appointment_start' => $start,
            'appointment_end' => $finish,
        ]);
        return $booking;
    }

    public function extendBooking($booking)
    {
        $extCost = Setting::select('param_value')->where('param_key', 'extend_cost')->first()->param_value;
        $newExtensionMin = session('booking.extend_time', 30);
        $multiple = ($newExtensionMin / 30);
        $charge =  $multiple * $extCost;

        $feeToTmrCost = $booking->therapist->extend_cost;
        if (!$feeToTmrCost)
            $feeToTmrCost = 0;

        if ($feeToTmrCost > 0) {
            $feeTMRExt = $multiple * $feeToTmrCost;
            $feeTherapistExt = $charge - $feeTMRExt;
        } else {
            $feeTherapistExt = $feeTMRExt = $charge / 2; // split 50 50
        }

        $extendTime = Carbon::createFromDate($booking->appointment_end)->addMinutes((int)$newExtensionMin);
        $extraDuration = $booking->extra_duration + $newExtensionMin;
        $cost = (float) $booking->cost + (float) $charge;
        $feeTmr = $booking->fee_tmr + $feeTMRExt;
        $feeTherapist = $booking->fee_therapist + $feeTherapistExt;

        $feeTmrExt = $booking->fee_tmr_extension + $feeTMRExt;
        $feeTherapistExt = $booking->fee_therapist_extension + $feeTherapistExt;

        $booking->update([
            'fee_tmr' => $feeTmr,
            'fee_therapist' => $feeTherapist,
            'fee_tmr_extension' => $feeTmrExt,
            'fee_therapist_extension' => $feeTherapistExt,
            'training_finish' => $extendTime,
            'extra_duration' => $extraDuration,
            'cost' => $cost
        ]);

        $prevPayment = $booking->payment->amount;
        $booking->payment->update([
            'amount' => (float) $prevPayment +  ((float) $charge * 100)
        ]);
        return $booking;
    }
}
