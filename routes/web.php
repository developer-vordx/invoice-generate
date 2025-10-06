<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::view('/', 'auth.login');
Route::get('/verify', function () {
    return view('verify');
})->name('verify.start');


Route::view('/register', 'auth.register')->name('register');
Route::view('/login', 'auth.login')->name('login');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');
Route::view('/verify-email', 'auth.verify-email')->name('verification.notice');


Route::post('/register', [AuthController::class, 'register'])->name('submit.register');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('/login', [AuthController::class, 'login'])->name('submit.login');

Route::post('/email-verify',[VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/verification/send', [VerificationController::class, 'send'])->name('verification.send');

Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');
