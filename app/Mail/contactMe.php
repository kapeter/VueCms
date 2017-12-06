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
    public function __construct($data)
    {
        $this->mySender = [
            'address' => $data['email'],
            'name' => $data['name']
        ];
        $this->mySubject = '来自kapeter.com的邮件 - '.$data['subject'];
        $this->myContent = $data['content'];
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
