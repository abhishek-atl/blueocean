<?php

namespace App\Services;

use App\Models\Postcode;
use App\Models\TariffPlan;
use App\Models\TherapistHoliday;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BookingService
{

    public function checkPostalCodeCovered($postcode)
    {
        $shortPostcode = substr($postcode, 0, 4);
        $postcode = Postcode::where('postcode', $shortPostcode)
            ->where('active', 1)
            ->first();
        return $postcode;
    }

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

    public function getDays()
    {
        $timezone = new \DateTimeZone("Europe/London");
        $now = new \DateTime('now', $timezone);
        $dateN = clone($now);
        $check = clone($now);
        $check->setTime('22', '31', '00');
        for ($i = 0; $i < 18; $i += 1) {
            if ($i == 0 && $now < $check) {
                $day = $dateN;
            } else {
                $day = $dateN->modify('+1 day');
            }
            $date[] = ['number' => $day->format('d'), 'month' => $day->format('M'), 'day' => $day->format('D'), 'full' => $day->format('d-m-Y')];
        }
        return $date;
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

    public function checkLockedTime($now, $bookingDate, $mmn)
    {
        // check for the past date
        if ($now->format('Y-m-d') > $bookingDate->format('Y-m-d')) {
            return true;
        }

        // if quick booking, check for the time, should not be after 10 and before 7
        if ($mmn == 'now') {
            if ($now->format('H') > 22 || $now->format('H') < 7)
                return true;
        }

        // revisit
        $bookingDate->setTime('23', '59', '59');
        if ($now > $bookingDate) {
            return true;
        }
        return false;
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
    public function getFreeTherapistsOnDateTime($date, $time, $duration = 60, $therapistIds = null)
    {
        // Convert date to DateTime object if string
        if (is_string($date)) {
            $date = new \DateTime($date);
        }

        // Parse time
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

        // Base query for therapists
        $query = User::where('user_type', self::TYPE_THERAPIST)
            ->where('active', 1)
            ->whereHas('schedule');

        // Filter by specific therapist IDs if provided
        if (!empty($therapistIds)) {
            $query->whereIn('id', $therapistIds);
        }

        $therapists = $query->get();

        // Filter therapists based on schedule, holidays, and bookings
        $availableTherapists = $therapists->filter(function ($therapist) use (
            $date,
            $startDateTime,
            $endDateTime,
            $scheduleDay,
            $duration
        ) {
            // Check 1: Is therapist on holiday?
            $isOnHoliday = TherapistHoliday::where('user_id', $therapist->id)
                ->where('start_date', '<=', $endDateTime)
                ->where('end_date', '>=', $startDateTime)
                ->exists();

            if ($isOnHoliday) {
                return false;
            }

            // Check 2: Does therapist have working hours for this day?
            $schedule = $therapist->schedule;
            if (!$schedule || empty($schedule->{$scheduleDay})) {
                return false;
            }

            $workingHours = $schedule->{$scheduleDay};
            if (!$this->isTimeWithinWorkingHours($startDateTime, $endDateTime, $workingHours)) {
                return false;
            }

            // Check 3: Are there conflicting bookings?
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

            return true;
        });

        return $availableTherapists->values();
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


}
