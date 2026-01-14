<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCodeEmail extends Mailable
{//
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $code;
    public function __construct($code)
    {
        $this->code = $code;
    }



    // public function build()
    // {
    //     return $this->subject('Your Verification Code')
    //                 ->view('UserMail.EmailVerificationCode')
    //                 ->with(['code' => $this->code]);
    // }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Code Email (E_Store)',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'UserMail.VerificationCodeEmail',
            with: [
                'code' => $this->code
            ]
        );
        // 'user' => $this->verificationData['user'],
        // return new Content(
        //     view: 'UserMail.EmailVerificationCode',
        // );
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
