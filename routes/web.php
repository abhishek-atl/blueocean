<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('auth.login');
Route::post('login', [LoginController::class, 'login'])->name('auth.login');
Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');


Route::get('/', [HomeController::class, 'home'])->name('home');

Route::post('/check-postal-code', [BookingController::class, 'checkPostcode'])->name('checkPostcode');
Route::get('/booking-postcode', [BookingController::class, 'bookingPostcode'])->name('bookingPostcode');
Route::get('/booking-info', [BookingController::class, 'bookingInfo'])->name('bookingInfo');
Route::post('/booking-info', [BookingController::class, 'bookingInfo'])->name('bookingInfoPost');


Route::post('get-days', [BookingController::class, 'getDays'])->name('getDays');
Route::post('/get-time', [BookingController::class, 'getTime'])->name('getTime');