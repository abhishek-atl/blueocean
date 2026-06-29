<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendHolidayUpdateToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $holiday;

    protected $action;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($holiday, $action)
    {
        $this->holiday = $holiday;
        $this->action = $action;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $subject = $this->holiday->therapist->first_name . ' booked time off';
        if ($this->action == 'delete') {
            $subject = $this->holiday->therapist->first_name . ' cancelled the time off';
        }
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.holiday_update_admin',
            with: [
                'holiday' => $this->holiday,
                'action' => $this->action
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
