<?php

namespace App\Services;

use App\Models\Postcode;
use App\Models\TariffPlan;
use App\Models\User;

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

    public function getToDayBooking($id, $date, $duration)
    {
        $all_time = $this->getTime();
        $tariff = TariffPlan::where('duration', $duration)->first();
        $holidays = $this->getTherapistHolidays($id, $date, $all_time, $tariff->duration);

        $timezone = new \DateTimeZone("Europe/London");
        $dat = new \DateTime($date, $timezone);
        $schedule = $this->getTherapistSchedule($id, $dat, $all_time, $tariff->duration);
        $date = new \DateTime($dat->format('Y-m-d') . ' 07:00', $timezone);
        $tn = $date;
        $tnt = new \DateTime($date->format('Y-m-d') . ' 04:00', $timezone);
        $tnt->modify('+1 day');

        $er = $this->em->getRepository(Bookings::class);
        $qb = $er->createQueryBuilder('booking');
        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->lte('booking.trainingDay', ':begin'),
                $qb->expr()->gte('booking.trainingDay', ':end')
            )
        )
            ->innerJoin('booking.therapists', 'therapist', 'WITH', 'therapist.id = :id')
            ->andWhere('booking.status = :status')
            ->setParameter('begin', $tnt)
            ->setParameter('id', $id)
            ->setParameter('status', 'new')
            ->setParameter('end', $tn);
        $result = $qb->getQuery()->getResult();
        $array = [];
        $check = 0;
        if (!empty($result)) {
            foreach ($result as $value) {
                $time = $value->getTrainingDay();
                $finish = $value->getTrainingFinish();
                $finish->modify("+30 minutes");
                $finishTime = $finish->format('H:i');
                $time->modify("-" . ($tariff->getDuration() + 30) . " minutes");
                if ($finish->format('H') == '23' || $finish->format('H') == '00' || $finish->format('H') == '01' || $finish->format('H') == '02' || $finish->format('H') == '03') {
                    $finishTime = '23:30';
                }
                $array[] = [$time->format('H:i'), $finishTime];
            }
        }
        $prepare = [];
        foreach ($array as $value) {
            $start_key = array_search($value[0], $all_time);
            $finish_key = array_search($value[1], $all_time);
            foreach ($all_time as $key => $value) {
                if ($key >= $start_key && $key <= $finish_key)
                    $prepare[] = $value;
            }
        }
        if ($schedule) {
            $prepare = array_merge($schedule, $prepare);
        }
        if ($holidays) {
            $prepare = array_merge($holidays, $prepare);
        }
        return $prepare;
    }

    private function getTherapistSchedule($id, $date, $all_time, $duration)
    {
        $therapist = $this->em->getRepository(Therapists::class)->find($id);
        $day = strtolower($date->format('D'));
        if ($therapist && $therapist->getSchedule()) {
            switch ($day) {
                case 'mon':
                    $schedule = $therapist->getSchedule()->getMon();
                    break;
                case 'tue':
                    $schedule = $therapist->getSchedule()->getTue();
                    break;
                case 'wed':
                    $schedule = $therapist->getSchedule()->getWed();
                    break;
                case 'thu':
                    $schedule = $therapist->getSchedule()->getThu();
                    break;
                case 'fri':
                    $schedule = $therapist->getSchedule()->getFri();
                    break;
                case 'sat':
                    $schedule = $therapist->getSchedule()->getSat();
                    break;
                case 'sun':
                    $schedule = $therapist->getSchedule()->getSun();
                    break;
            }
            $array = explode(',', $schedule);
            $max_hour = max($array);
            $prepare_time = [];
            $dat = new \DateTime($max_hour);
            $i = 0;
            switch ($duration) {
                case '60':
                    $time = $dat->modify('-30 minutes');
                    $find_key = array_search($time->format('H:i'), $all_time);
                    foreach ($all_time as $key => $value) {
                        if ($key < $find_key)
                            $prepare_time[$i] = $value;
                        $i += 1;
                    }
                    break;
                case '90':
                    $time = $dat->modify('-60 minutes');
                    $find_key = array_search($time->format('H:i'), $all_time);
                    foreach ($all_time as $key => $value) {
                        if ($key < $find_key)
                            $prepare_time[$i] = $value;
                        $i += 1;
                    }
                    break;
                case '120':
                    $time = $dat->modify('-90 minutes');
                    $find_key = array_search($time->format('H:i'), $all_time);
                    foreach ($all_time as $key => $value) {
                        if ($key < $find_key)
                            $prepare_time[$i] = $value;
                        $i += 1;
                    }
                    break;
                case '150':
                    $time = $dat->modify('-120 minutes');
                    $find_key = array_search($time->format('H:i'), $all_time);
                    foreach ($all_time as $key => $value) {
                        if ($key < $find_key)
                            $prepare_time[$i] = $value;
                        $i += 1;
                    }
                    break;
                case '180':
                    $time = $dat->modify('-150 minutes');
                    $find_key = array_search($time->format('H:i'), $all_time);
                    foreach ($all_time as $key => $value) {
                        if ($key < $find_key)
                            $prepare_time[$i] = $value;
                        $i += 1;
                    }
                    break;
                case '210':
                    $time = $dat->modify('-180 minutes');
                    $find_key = array_search($time->format('H:i'), $all_time);
                    foreach ($all_time as $key => $value) {
                        if ($key < $find_key)
                            $prepare_time[$i] = $value;
                        $i += 1;
                    }
                    break;
            }
            $result = array_diff($array, $prepare_time);
            $result1 = array_diff($all_time, $array);
            $result2 = array_merge($result, $result1);
            return $result2;
        }
        return $all_time;
    }

    public function getTherapistHolidays($id, $date, $all_time, $duration)
    {
        $prepareDate = $date;
        $result_time = null;
        $therapist = User::find($id);

        $timezone = new \DateTimeZone("Europe/London");
        $dat = new \DateTime($date, $timezone);
        $date = new \DateTime($dat->format('Y-m-d') . ' 01:00', $timezone);
        $tn = $date;
        $tnt = new \DateTime($date->format('Y-m-d') . ' 23:59', $timezone);

        $result = $therapist->holidays()->where('start_date', '>=', $tn)->where('end_date', '<=', $tn)->get();
        dd($result);
        foreach ($result as $value) {
            $date1 = $value->getStartDate();
            $date2 = $value->getEndDate();

            if ($date1->format('d-m-Y') == $prepareDate && $date2->format('d-m-Y') != $prepareDate) {
                $result_time = $this->getPrepareStartDateTime($value->getStartDate(), $all_time, $duration);
            } elseif ($date2->format('d-m-Y') == $prepareDate && $date1->format('d-m-Y') != $prepareDate) {
                $result_time = $this->getPrepareEndDateTime($value->getEndDate(), $all_time);
            } elseif ($date2->format('d-m-Y') == $prepareDate && $date1->format('d-m-Y') == $prepareDate) {
                if ($date1->format('H:i') != '00:00') {
                    $date1 = $value->getStartDate()->modify('-' . $duration . ' minutes');
                }
                $date2 = $value->getEndDate();
                $result_time = array_filter($all_time, function ($v, $k) use ($date1, $date2) {
                    return $v > $date1->format('H:i') && $v < $date2->format('H:i');
                }, ARRAY_FILTER_USE_BOTH);
            } else {
                $result_time = $all_time;
            }
        }
        return $result_time;
    }

    private function getPrepareStartDateTime($dat, $all_time, $duration)
    {
        $i = 0;
        if ($dat->format('H') < 6) {
            $find_key = array_search($dat->format('H:i'), $all_time);
            foreach ($all_time as $key => $value) {
                if ($key >= $find_key)
                    $prepare_time[$i] = $value;
                $i += 1;
            }
            return $prepare_time;
        }

        switch ($duration) {
            case '60':
                $time = $dat->modify('-30 minutes');
                $find_key = array_search($time->format('H:i'), $all_time);
                foreach ($all_time as $key => $value) {
                    if ($key >= $find_key)
                        $prepare_time[$i] = $value;
                    $i += 1;
                }
                break;
            case '90':
                $time = $dat->modify('-60 minutes');
                $find_key = array_search($time->format('H:i'), $all_time);
                foreach ($all_time as $key => $value) {
                    if ($key >= $find_key)
                        $prepare_time[$i] = $value;
                    $i += 1;
                }
                break;
            case '120':
                $time = $dat->modify('-90 minutes');
                $find_key = array_search($time->format('H:i'), $all_time);
                foreach ($all_time as $key => $value) {
                    if ($key >= $find_key)
                        $prepare_time[$i] = $value;
                    $i += 1;
                }
                break;
            case '150':
                $time = $dat->modify('-120 minutes');
                $find_key = array_search($time->format('H:i'), $all_time);
                foreach ($all_time as $key => $value) {
                    if ($key >= $find_key)
                        $prepare_time[$i] = $value;
                    $i += 1;
                }
                break;
            case '180':
                $time = $dat->modify('-150 minutes');
                $find_key = array_search($time->format('H:i'), $all_time);
                foreach ($all_time as $key => $value) {
                    if ($key >= $find_key)
                        $prepare_time[$i] = $value;
                    $i += 1;
                }
                break;
            case '210':
                $time = $dat->modify('-180 minutes');
                $find_key = array_search($time->format('H:i'), $all_time);
                foreach ($all_time as $key => $value) {
                    if ($key >= $find_key)
                        $prepare_time[$i] = $value;
                    $i += 1;
                }
                break;
        }
        return $prepare_time;
    }

    private function getPrepareEndDateTime($now, $array_time)
    {
        $i = 1;
        $prepare_time = [];
        if ($now->format('i') > 30) {
            $now_time = $now->format('H');
            $find_key = array_search($now_time . ':30', $array_time);
            foreach ($array_time as $key => $value) {
                if ($key < $find_key)
                    $prepare_time[$i] = $value;
                $i += 1;
            }
        } else {

            $now_time = $now->format('H');
            $find_key = array_search($now_time . ':00', $array_time);
            foreach ($array_time as $key => $value) {
                if ($key < $find_key)
                    $prepare_time[$i] = $value;
                $i += 1;
            }
        }
        return $prepare_time;
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

    public function getPrepareTime($massage_now = false)
    {
        $timezone = new \DateTimeZone("Europe/London");
        $now = new \DateTime('now', $timezone);
        $check = clone($now);
        $check->setTime('22', '31', '00');
        $i = 1;
        $array_time = $this->getTime();
        if ($now > $check) {
            $now->setTime('06', '00', '00');
        } else {
            $now->modify('+60 minutes');
        }
        $prepare_time = [];
        ($massage_now && $now->format('i') != 30) ? $prepare_time[0] = $now->format('H:i') : '';
        if ($now->format('i') > 30) {
            $now_time = $now->format('H');
            $find_key = array_search($now_time . ':30', $array_time);
            foreach ($array_time as $key => $value) {
                if ($key > $find_key)
                    $prepare_time[$i] = $value;
                $i += 1;
            }
        } else {
            $now_time = $now->format('H');
            $find_key = array_search($now_time . ':00', $array_time);
            foreach ($array_time as $key => $value) {
                if ($key > $find_key)
                    $prepare_time[$i] = $value;
                $i += 1;
            }
        }
        return $prepare_time;
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
}
