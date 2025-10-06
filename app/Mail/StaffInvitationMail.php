<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;

class StaffInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $url;

    public function __construct($user,$password)
    {
        $this->user = $user;
        $this->password = $password;

        $this->url = URL::temporarySignedRoute(
            'staff.accept.invitation',
            now()->addDays(2),
            ['user' => $user->id]
        );
    }

    public function build()
    {
        return $this->subject('You are invited to join as staff')
            ->view('emails.staff_invitation')
            ->with([
                'user' => $this->user,
                'url' => $this->url,
                'password' => $this->password,
            ]);
    }
}
