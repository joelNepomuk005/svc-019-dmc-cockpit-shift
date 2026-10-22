<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendmail extends Mailable
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
    public function __construct($subject, $content, $user)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('auth.mails.release_user')->from(env('MAIL_FROM_ADDRESS'))->subject($this->subject)->with('body', $this->content, $this->user);
    }


}
