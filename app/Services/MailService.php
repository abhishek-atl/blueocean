<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{


    public function __construct()
    {
        // Initialize any dependencies or configurations if needed
    }

    public function sendBookingConfirmationEmail($booking)
    {
        // Logic to send booking confirmation email
    }

    public function sendPostcodeNotCoveredMail($postcode)
    {
        //$email = $this->settingService->getByParams(['where' => ['param_key' => 'admin_email']])->first()->value;
        $email = 'webmaster@blueocean.uk';
        Mail::to($email)->send(new PostcodeNotCovered($postcode));
    }
}
