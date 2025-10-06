<?php

namespace App\Services\Auth;

use App\Mail\SendOtpVerificationMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterService
{
    public function register(array $data): array
    {
        try {
            // Hash password
            $data['password'] = Hash::make($data['password']);

            // Create the user
            $user = User::create($data);
            session(['pending_email' => $user->email]);
            // Send verification email
            $this->sendVerificationMail($user->email);

            return [
                'success' => true,
                'message' => 'Registration successful. Please verify your email.',
                'redirect' => '/verify-email'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Registration failed. ' . $e->getMessage()
            ];
        }
    }

    private function sendVerificationMail(string $email): void
    {

        // Generate a 6-digit numeric token
        $otp = rand(100000, 999999);

        DB::table('user_tokens')->updateOrInsert(
            ['email' => $email, 'type' => 'email_verification'],
            [
                'token' => Hash::make($otp),
                'created_at' => now(),
            ]
        );

//        dispatch(new SendVerificationEmailJob($email, $otp));

        Mail::to($email)->send(new SendOtpVerificationMail($otp, $email));
    }

}
