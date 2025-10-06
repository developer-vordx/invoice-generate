<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\PasswordResetService;

class ResetPasswordController extends Controller
{
    protected $service;

    public function __construct(PasswordResetService $service)
    {
        $this->service = $service;
    }


    public function reset(ResetPasswordRequest $request)
    {
        $response = $this->service->resetPassword($request->validated());

        return redirect()->route('login')->with($response['success'] ? 'success' : 'error', $response['message']);
    }
}
