<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WaitDriverRequestApprove extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The OTP code to be sent in the email.
     *
     * @var string
     */
   
    /**
     * Create a new message instance.
     *
     * @param
     */
    public function __construct()
    {
      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Wait For Request Approve')
                    ->view('emails.WaitDriverRequestApprove');

    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
