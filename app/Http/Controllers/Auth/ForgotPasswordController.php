<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\Auth\PasswordResetService;

class ForgotPasswordController extends Controller
{
    protected $service;

    public function __construct(PasswordResetService $service)
    {
        $this->service = $service;
    }


    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $response = $this->service->sendResetLink($request->validated());

        return back()->with($response['success'] ? 'success' : 'error', $response['message']);
    }
}
