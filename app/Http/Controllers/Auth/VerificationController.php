<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MailVerificationRequest;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    protected $verificationService;

    public function __construct(EmailVerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    public function verify(MailVerificationRequest $request)
    {
        $response = $this->verificationService->verify($request);

        if ($response['success']) {
            return redirect('/docs-verification')->with('success', $response['message']);
        }

        return redirect()->route('verification.notice')->with('error', $response['message']);
    }

    public function send(Request $request)
    {
        $email = session('pending_email');

        if (!$email) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Email not found in session.'], 400)
                : back()->with('error', 'Email not found in session.');
        }

        $response = $this->verificationService->send($email);

        return $request->expectsJson()
            ? response()->json($response)
            : back()->with($response['success'] ? 'success' : 'error', $response['message']);
    }
}
