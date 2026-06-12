<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TherapistApplication extends Mailable
{
    use Queueable, SerializesModels;

    protected array $application;

    /**
     * Create a new message instance.
     */
    public function __construct(array $application)
    {
        $this->application = $application;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Therapist Application',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.therapist_application',
            with: [
                'application' => $this->application,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        foreach (['cv', 'photo'] as $key) {
            if (!empty($this->application[$key]) && file_exists($this->application[$key])) {
                $attachments[] = Attachment::fromPath($this->application[$key]);
            }
        }

        return $attachments;
    }
}
