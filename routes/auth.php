<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'showUserLoginForm'])->name('auth.login');
Route::post('login', [LoginController::class, 'postUserlogin'])->name('auth.login');
Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('auth.register');
Route::post('/postRegister', [RegisterController::class, 'postRegister'])->name('post-register');
Route::get('/account/verify/{token}', [RegisterController::class, 'verifyAccount'])->name('user.verify');
Route::get('/account/send-verification-link/{id}', [RegisterController::class, 'sendVerificationLink'])->name('user.send_verification_link');

Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/post-forgot-password', [ForgotPasswordController::class, 'postForgotPassword'])->name('post-forgot-password');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'getPasswordResetLink'])->name('get-password-reset-link');
Route::post('/post-reset-password', [ForgotPasswordController::class, 'postPasswordResetLink'])->name('post-reset-password');
