<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::withoutMiddleware([AdminMiddleware::class])->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('auth.login');
    Route::post('login', [LoginController::class, 'login'])->name('auth.login');
    Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');
});



Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/booking-postcode', [BookingController::class, 'bookingPostcode'])->name('bookingPostcode');
Route::post('/booking-postcode', [BookingController::class, 'bookingPostcode'])->name('bookingPostcodePost');
Route::get('/booking-info', [BookingController::class, 'bookingInfo'])->name('bookingInfo');
Route::post('/booking-info', [BookingController::class, 'bookingInfo'])->name('bookingInfoPost');
Route::get('/booking/checkout', [BookingController::class, 'bookingCheckout'])->name('bookingCheckout');
Route::post('/booking/checkout', [BookingController::class, 'bookingCheckoutPost'])->name('bookingCheckoutPost');
Route::get('/booking/success', [BookingController::class, 'bookingSuccess'])->name('bookingSuccess');


Route::post('/check-postal-code', [BookingController::class, 'checkPostcode'])->name('checkPostcode');
Route::post('get-days', [BookingController::class, 'getDays'])->name('getDays');
Route::post('/get-time', [BookingController::class, 'getTime'])->name('getTime');
Route::post('/free-therapists', [BookingController::class, 'getFreeTherapists'])->name('getFreeTherapists');
Route::post('/therapist', [BookingController::class, 'therapistInfo'])->name('therapistInfo');
Route::post('/booking-charges', [BookingController::class, 'charges'])->name('bookingCharges');




Route::get('/legal/legal.html', [HomeController::class, 'terms_conditions'])->name('terms_conditions');
