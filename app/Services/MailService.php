<?php

namespace App\Services;

use App\Mail\Auth\ForgotPassword;
use App\Mail\Auth\PasswordChangedNotification;
use App\Mail\Auth\SendUserEmailVerificationMail;
use App\Mail\PostcodeNotCovered;
use App\Mail\SendBookingMailToAdmin;
use App\Mail\SendBookingMailToClient;
use App\Mail\SendBookingMailToTherapist;
use App\Mail\SendBookingSmsFailedMailToAdmin;
use App\Mail\SendGiftCertificateAdmin;
use App\Mail\SendGiftCertificateRecipient;
use App\Mail\SendGiftCertificateSender;
use App\Mail\TherapistApplication;
use Illuminate\Support\Facades\Mail;

class MailService
{


    public function __construct()
    {
        // Initialize any dependencies or configurations if needed
    }

    public function sendMailVerifyEmail($user, $token)
    {
        $url = route('user.verify', ['token' => $token]);
        $mail = new SendUserEmailVerificationMail($user, $url);
        Mail::to($user)->send($mail);
    }

    public function forgotPassword($user, $token)
    {
        $url = route('get-password-reset-link', ['token' => $token, 'email' => urlencode($user->email)]);
        $mail = new ForgotPassword($user, $url);
        Mail::to($user)->send($mail);
    }

    // Password changed email
    public function adminPasswordChanged($user)
    {
        $mail = new PasswordChangedNotification($user);
        Mail::to($user)->send($mail);
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

    public function sendTherapistApplicationMail(array $application)
    {
        Mail::to(config('mail.to.admin_address'))->send(new TherapistApplication($application));
    }

    public function sendMailGiftCertificateAdmin($giftCertificate)
    {
        $email = config('mail.to.admin_address');
        Mail::to($email)->send(new SendGiftCertificateAdmin($giftCertificate));
    }

    public function sendMailGiftCertificateSender($giftCertificate)
    {
        Mail::to($giftCertificate->sender_email)->send(new SendGiftCertificateSender($giftCertificate));
    }

    public function sendMailGiftCertificateRecipient($giftCertificate)
    {
        Mail::to($giftCertificate->recipient_email)->send(new SendGiftCertificateRecipient($giftCertificate));
    }
}
