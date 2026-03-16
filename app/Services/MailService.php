<?php

namespace App\Services;

use App\Mail\PostcodeNotCovered;
use App\Mail\SendBookingMailToAdmin;
use App\Mail\SendBookingMailToClient;
use App\Mail\SendBookingMailToTherapist;
use App\Mail\SendBookingSmsFailedMailToAdmin;
use Illuminate\Support\Facades\Mail;

class MailService
{


    public function __construct()
    {
        // Initialize any dependencies or configurations if needed
    }

    public function sendPostcodeNotCoveredMail($postcode)
    {
        //$email = $this->settingService->getByParams(['where' => ['param_key' => 'admin_email']])->first()->value;
        $email = 'webmaster@blueocean.uk';
        Mail::to($email)->send(new PostcodeNotCovered($postcode));
    }

    public function sendBookingMailToClient($booking, $email)
    {
        Mail::to($email)->send(new SendBookingMailToClient($booking));
    }

    public function sendBookingMailToTherapist($booking)
    {
        Mail::to($booking->therapist->email)->send(new SendBookingMailToTherapist($booking));
    }

    public function sendBookingMailToAdmin($booking)
    {
        Mail::to(config('mail.to.admin_address'))->send(new SendBookingMailToAdmin($booking));
    }

    public function sendBookingSmsFailedToAdmin($booking)
    {
        Mail::to(config('mail.to.admin_address'))->send(new SendBookingSmsFailedMailToAdmin($booking));
    }
}
