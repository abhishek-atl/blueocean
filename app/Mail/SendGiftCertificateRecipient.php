<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendGiftCertificateRecipient extends Mailable
{
    use Queueable, SerializesModels;


    protected $giftCertificate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($giftCertificate)
    {
        $this->giftCertificate = $giftCertificate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.gift_certificate.recipient', [
            'giftCertificate' => $this->giftCertificate
        ])->subject($this->giftCertificate->sender_name . ' has sent a gift');
    }
}
