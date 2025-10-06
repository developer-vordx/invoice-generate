<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\IDVerificationRequest;
use App\Services\Auth\IDVerificationService;

class IDVerificationController extends Controller
{

    protected $idVerificationService;

    public function __construct(IDVerificationService $idVerificationService)
    {
        $this->idVerificationService = $idVerificationService;
    }
    public function submit(IDVerificationRequest $request)
    {

        $result = $this->idVerificationService->verify($request);

        if ($result['success']) {

            return redirect('/dashboard');
        }

        return back()->with('error', $result['message']);
    }
}
