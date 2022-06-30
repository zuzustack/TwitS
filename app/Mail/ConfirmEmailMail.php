<?php

namespace App\Mail;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class ConfirmEmailMail extends Mailable
{
    use Queueable, SerializesModels;
    private $token,$username;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username){
        $this->token = Str::random(5);
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Confirmation')
                    ->view('email.confirmEmail')
                    ->with([
                        'token' => $this->token,
                        'username' => $this->username
                    ]);
    }
}
