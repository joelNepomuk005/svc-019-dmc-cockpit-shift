<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendmailNewRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $content;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('auth.mails.new_user')->from(env('MAIL_FROM_ADDRESS'))->subject($this->subject)->with('body', $this->content);
    }
}
