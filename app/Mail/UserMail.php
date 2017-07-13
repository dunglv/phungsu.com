<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $email;
    protected $str;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($str, $email)
    {
        $this->str = $str;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.active-user')->from('vietdungit93@gmail.com')->subject('Test email from phung su.com')->with(['str' => $this->str, 'email' => $this->email]);
    }
}
