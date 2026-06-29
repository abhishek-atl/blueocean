<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendHolidayUpdateToTherapist extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $holiday;

    protected $action;

    public function __construct($holiday, $action)
    {
        $this->holiday = $holiday;
        $this->action = $action;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Time Off Confirmation - TheMassageRooms';
        if ($this->action == 'delete') {
            $subject = 'Time Off Cancellation Confirmation - TheMassageRooms';
        }
        return $this->view('mail.holiday_update_therapist', [
            'holiday' => $this->holiday,
            'action' => $this->action
        ])->subject($subject);
    }
}
