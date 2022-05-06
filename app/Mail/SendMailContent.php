<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailContent extends Mailable
{
    use Queueable, SerializesModels;

    public $content,$topic;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content,$topic)
    {
        //
        $this->content=$content;
        $this->topic=$topic;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("This Week Content")->markdown('email.sendMailContent');
    }
}
