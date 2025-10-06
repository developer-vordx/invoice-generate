<?php

namespace App\Jobs;

use App\Mail\SendOtpVerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmailJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected string $email;
    protected string $otp;

    public function __construct(string $email, string $otp)
    {
        $this->email = $email;
        $this->otp   = $otp;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new SendOtpVerificationMail($this->otp, $this->email));
    }
}
