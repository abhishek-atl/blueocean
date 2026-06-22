<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminPasswordChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $user
     */
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.auth.admin_password_changed')
                    ->subject('Password Changed!')
                    ->with([
                        'user' => $this->user
                    ]);
    }
}
