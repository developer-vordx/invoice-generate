<?php

namespace App\Services\Auth;

use App\Jobs\SendVerificationEmailJob;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmailVerificationService
{
    public function verify($request): array
    {
        try {
            $email = session('pending_email');
            $record = DB::table('user_tokens')
                ->where('email', $email)
                ->where('type', 'email_verification')
                ->first();

            if (!$record || !password_verify($request->otp, $record->token)) {
                return [
                    'success' => false,
                    'message' => 'Invalid or expired verification otp.'.$email
                ];
            }

            $user = User::where('email', $email)->first();

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'User not found.'
                ];
            }

            $user->email_verified_at = Carbon::now();
            $user->save();

            DB::table('user_tokens')
                ->where('email', $email)
                ->where('type', 'email_verification')
                ->delete();

            Auth::login($user);

            // Optionally remove session email since it's verified
            session()->forget('pending_email');

            return [
                'success' => true,
                'message' => 'Email verified successfully.'
            ];
        } catch (\Exception $e) {
            Log::error('Email verification failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Something went wrong while verifying your email.'
            ];
        }
    }

    public function send(string $email) : array
    {
        try {
            $user = User::where('email', $email)->first();

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'User not found.'
                ];
            }

            // Generate and store OTP
            $otp = rand(100000, 999999);

            DB::table('user_tokens')->updateOrInsert(
                ['email' => $email, 'type' => 'verification'],
                [
                    'token' => bcrypt($otp),
                    'created_at' => now(),
                ]
            );

            // Dispatch job to send verification email
            dispatch(new SendVerificationEmailJob($email, $otp))->onQueue('emails');

            return [
                'success' => true,
                'message' => 'Verification code sent successfully.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Something went wrong while sending the verification email.'
            ];
        }
    }

}
