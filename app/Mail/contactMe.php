<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class contactMe extends Mailable
{
    use Queueable, SerializesModels;

    public $mySender;

    public $mySubject;

    public $myContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mySender, $mySubject, $myContent)
    {
        $this->mySender  = $mySender;
        $this->mySubject  = $mySubject;
        $this->myContent = $myContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mySubject)
            ->view('mails.index')
            ->with([
                'sender' => $this->mySender,
                'content' => $this->myContent
            ]);
    }
}
