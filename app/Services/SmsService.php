<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function sendSmsToTherapist($booking, $new = false)
    {
        $subject = '';
        if (!$new) {
            $subject .= '*UPDATE*';
        }
        $text = $this->buildSMS($booking, $subject);

        $result = $this->sendSms([$booking->therapist[0]->mobile], $this->trimSmsText($text), $this->smsSender());

        if ($result->status === 'success') {
            return true;
        }
        return false;
    }

    public function buildSMS($booking, $subject)
    {
        if ($booking->mmn_date)
            $trainingDay = Carbon::createFromFormat('Y-m-d H:i:s', $booking->mmn_date);
        else
            $trainingDay = Carbon::createFromFormat('Y-m-d H:i:s', $booking->training_day);

        $costing = '(£' . ((int)$booking->cost) . ($booking->travel_supp > 0 ? ' + £' . (int)$booking->travel_supp : '') . ')';
        $details = $booking->travel_supp > 0 ? $costing : '';

        $text = $subject;
        $text .= $trainingDay->format('d/m/y H:i');
        $text .= ' ' . $booking->duration + $booking->extra_duration . 'mins ' . $this->getBookingTotalCost($booking) . $details;
        $text .= ' ' . $booking->name;
        $text .= ' ' . $booking->phone;
        if ($booking->town) {
            $text .= ' at ';
            $text .= $booking->flat_no ? $booking->flat_no . ', ' : '';
            $text .= $booking->street_number . ' ' . $booking->street_name . ', ' . $booking->town . ', ' . strtoupper($booking->postcode) . '.';
        } else {
            $text .= ' at ' . $booking->address . '.';
        }
        $text .= $booking->comments ? ' ' . $booking->comments . '.' : '';
        $text .= ' ' . $booking->treatment->name . '.';
        $text .= $booking->focus_areas ? ' ' . $booking->focus_areas . '.' : '';

        return $text;
    }

    public function sendSms(array $numbers, $message, $from)
    {
        try {
            $testmode = false;
            if (App::environment(['local', 'staging'])) {
                $testmode = true;
                Log::info(print_r($message, true));
                return;
            }
            $username = config('custom.text_local_api_username');
            $password = config('custom.text_local_api_password');
            $textlocal = new Textlocal($username, $password);
            //dd($numbers);

            $modifiedNumbers = [];
            // textGlobar need 44 country code format
            foreach ($numbers as $key => $number) {
                $number = substr($number, -10);
                $modifiedNumbers[$key] = '44' . $number;
            }
            //
            $response = $textlocal->sendSms($modifiedNumbers, $message, $from);
            if (App::environment('local')) {
                Log::info(print_r($response, true));
            }
            $response->status = 'success';
            return $response;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $return = new stdClass;
            $return->status = false;
            return $return;
        }
    }

    public function smsSender()
    {
        return config('custom.textlocal_sender_to_therapists');
    }

    protected function trimSmsText($text)
    {
        if (strlen($text) > 157) {
            $smsText = substr($text, 0, 157) . '...';
        } else {
            $smsText = $text;
        }
        return $smsText;
    }
}
