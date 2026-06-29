<?php

namespace App\Services;

use App\Mail\SendBookingEmailToAdmin;
use App\Mail\SendBookingEmailToClient;
use App\Mail\SendBookingEmailToTherapist;
use App\Mail\SendBookingSmsFailedEmailToAdmin;
use App\Mail\SendCancellationMailAdmin;
use App\Mail\SendCancellationMailClient;
use App\Mail\SendCancellationMailTherapist;
use App\Mail\SendCancellationRequestMailToAdmin;
use App\Mail\SendExtendEmailToClient;
use App\Mail\SendReconfirmMailAdmin;
use App\Mail\SendReconfirmMailClient;
use App\Mail\SendReconfirmMailTherapist;
use Illuminate\Support\Facades\Mail;

class BookingMailService
{

    public function __construct()
    {
    }

    /***********************************************************/
    // Booking Confirmations
    /***********************************************************/
    public function sendBookingMailToClient($booking, $email)
    {
        Mail::to($email)->send(new SendBookingEmailToClient($booking));
    }

    public function sendBookingMailToAdmin($booking)
    {
        Mail::to(config('mail.to.admin_address'))->send(new SendBookingEmailToAdmin($booking));
    }

    public function sendBookingMailToTherapist($booking)
    {
        Mail::to($booking->therapist[0]->email)->send(new SendBookingEmailToTherapist($booking));
    }

    /***********************************************************/
    // Booking Reconfirm
    /***********************************************************/

    public function sendReconfirmMailClient($booking)
    {
        Mail::to($booking->email)->send(new SendReconfirmMailClient($booking));
    }

    public function sendReconfirmMailAdmin($booking)
    {
        Mail::to(config('mail.to.admin_address'))->send(new SendReconfirmMailAdmin($booking));
    }

    public function sendReconfirmMailTherapist($booking)
    {
        Mail::to($booking->therapist->email)->send(new SendReconfirmMailTherapist($booking));
    }

    /***********************************************************/
    // Booking cancels
    /***********************************************************/

    public function sendCancellationRequestMailToAdmin($booking)
    {
        Mail::to(config('mail.to.admin_address'))->send(new SendCancellationRequestMailToAdmin($booking));
    }

    public function sendCancellationMailToClient($booking, $giftCode=null)
    {
        Mail::to($booking->email)->send(new SendCancellationMailClient($booking, $giftCode));
    }

    public function sendCancellationMailToAdmin($booking)
    {
        Mail::to(config('mail.to.admin_address'))->send(new SendCancellationMailAdmin($booking));
    }

    public function sendCancellationMailToTherapist($booking)
    {
        Mail::to($booking->therapist[0]->email)->send(new SendCancellationMailTherapist($booking));
    }

    /***********************************************************/
    // Booking general
    /***********************************************************/
    public function sendBookingSmsFailedToAdmin($booking)
    {
        Mail::to(config('mail.to.admin_address'))->send(new SendBookingSmsFailedEmailToAdmin($booking));
    }

    public function sendExtendEmailToClient($booking)
    {
        $url = url(route('booking_extend', ['id' => $booking->id]));
        Mail::to($booking->email)->send(new SendExtendEmailToClient($booking, $url));
    }
}
