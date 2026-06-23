<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// input post code
Route::get('/booking-postcode', [BookingController::class, 'bookingPostcode'])->name('bookingPostcode');
Route::post('/check-postal-code', [BookingController::class, 'checkPostcode'])->name('checkPostcode');
Route::post('/booking-postcode-submit', [BookingController::class, 'bookingPostcodeSubmit'])->name('bookingPostcodeSubmit');

// massage informaion
Route::get('/booking-info', [BookingController::class, 'bookingInfo'])->name('bookingInfo');
Route::post('get-days', [BookingController::class, 'getDays'])->name('getDays');
Route::post('/get-time', [BookingController::class, 'getTime'])->name('getTime');
Route::post('/free-therapists', [BookingController::class, 'getFreeTherapists'])->name('getFreeTherapists');
Route::post('/therapist', [BookingController::class, 'therapistInfo'])->name('therapistInfo');
Route::post('/booking-info-submit', [BookingController::class, 'bookingInfoSubmit'])->name('bookingInfoSubmit');

Route::get('/booking/checkout', [BookingController::class, 'bookingCheckout'])->name('bookingCheckout');
Route::post('/booking/checkout', [BookingController::class, 'bookingCheckoutPost'])->name('bookingCheckoutPost');

Route::get('/booking/success', [BookingController::class, 'bookingSuccess'])->name('bookingSuccess');

Route::post('/booking-create-payment-session', [BookingController::class, 'createStripeSession'])->name('bookingCreateStripeSession');
Route::get('/booking-return-from-strip', [BookingController::class, 'returnFromStripe'])->name('bookingReturnFromStripe');

Route::post('/booking-charges', [BookingController::class, 'charges'])->name('bookingCharges');
Route::post('/update-payment-method', [BookingController::class, 'updatePaymentMethod'])->name('updatePaymentMethod');
Route::post('/check-promo-code', [BookingController::class, 'checkPromocode'])->name('checkPromocode');
Route::post('/check-gift-code', [BookingController::class, 'checkGiftcode'])->name('checkGiftcode');
