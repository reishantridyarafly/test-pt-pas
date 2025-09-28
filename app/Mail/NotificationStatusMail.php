<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subjectText;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $subjectText)
    {
        $this->data = $data;
        $this->subjectText = $subjectText;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
            ->view('emails.notification-status')
            ->with('data', $this->data);
    }
}
