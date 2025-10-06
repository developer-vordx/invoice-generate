<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public string $email;

    public function __construct(string $otp, string $email)
    {
        $this->otp   = $otp;
        $this->email = $email;
    }

    public function build(): self
    {
        return $this->subject('Verify Your Email')
            ->view('emails.verify-email')
            ->with([
                'otp' => $this->otp,
                'email' => $this->email,
            ]);
    }
}
