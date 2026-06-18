<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GiftVoucherController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Middleware\AdminMiddleware;

use Illuminate\Support\Facades\Route;

Route::withoutMiddleware([AdminMiddleware::class])->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('auth.login');
    Route::post('login', [LoginController::class, 'login'])->name('auth.login');
    Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');
});

// frontend
Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/treatments', [HomeController::class, 'treatments'])->name('treatments');
Route::get('/treatment/{slug}', [HomeController::class, 'treatmentDetail'])->name('treatment_detail');

Route::get('/join-us', [HomeController::class, 'joinUs'])->name('join_us');
Route::post('/join-us', [HomeController::class, 'joinUsPost'])->name('join_us_post');

// booking
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

// gift card
Route::get('buy-gift-card', [GiftVoucherController::class, 'gifts'])->name('gifts');
Route::post('buy-gift-card', [GiftVoucherController::class, 'giftsPost'])->name('giftsPost');

Route::get('buy-gift-card/payment', [GiftVoucherController::class, 'giftsPayment'])->name('gifts_payment');
Route::post('buy-gift-card/payment', [GiftVoucherController::class, 'giftsPaymentPost'])->name('gifts_payment_post');

Route::post('buy-gift-card/success', [GiftVoucherController::class, 'giftsSuccess'])->name('gifts_success');
Route::get('buy-gift-card/payment/stripe/return', [GiftVoucherController::class, 'giftsPaymentStripeReturn'])->name('gifts_payment_stripe_return');
Route::get('buy-gift-card/payment/paypal/return', [GiftVoucherController::class, 'giftsPaymentPaypalReturn'])->name('gifts_payment_paypal_return');

Route::get('buy-gift-card/payment/success', [GiftVoucherController::class, 'giftsPaymentSuccess'])->name('gifts_payment_success');
Route::get('buy-gift-card/print/gift-card/{id}', [GiftVoucherController::class, 'giftsPaymentPrint'])->name('gifts_payment_print');

Route::post('paypal/order/create', [PaypalPaymentController::class, 'create'])->name('paypal.create');
Route::post('paypal/order/capture', [PaypalPaymentController::class, 'capture'])->name('paypal.capture');

// legal
Route::get('/legal/legal.html', [HomeController::class, 'terms_conditions'])->name('terms_conditions');
