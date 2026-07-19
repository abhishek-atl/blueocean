<?php

namespace App\Services;

use App\Models\Setting;
use Carbon\Carbon;
use GuzzleHttp\Client;
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

    public function sendSms(string $message, $numbers = null, $from = null)
    {
        if ($numbers == null) {
            $adminMobile = Setting::where(['param_key' => 'admin_mobile'])->first()->param_value;
            $numbers = [$adminMobile];
        }

        if ($from === null) {
            $from = $this->smsSender();
        }
        try {
            $client = new Client([
                'verify' => false,
                'headers' => [
                    'X-AUTH-KEY' => config('custom.sms_api_key'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
            $response = $client->post(config('custom.sms_api_url'), [
                'json' => [
                    'message_body' => $this->trimSmsText($message),
                    'from' => $from,
                    'to' => [
                        [
                            'phone' => $numbers,
                        ],
                    ],
                ],
            ]);
            return $response;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function smsSender()
    {
        return config('custom.sms_sender');
    }

    protected function trimSmsText($text)
    {
        if (strlen($text) > 70) {
            $smsText = substr($text, 0, 70) . '...';
        } else {
            $smsText = $text;
        }
        return $smsText;
    }
}
