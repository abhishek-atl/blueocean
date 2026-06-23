<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\GiftVoucherController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaypalPaymentController;


use Illuminate\Support\Facades\Route;


include __DIR__ . '/auth.php';

include __DIR__ . '/booking.php';

// frontend
Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/treatments', [HomeController::class, 'treatments'])->name('treatments');
Route::get('/treatment/{slug}', [HomeController::class, 'treatmentDetail'])->name('treatment_detail');

Route::get('/join-us', [HomeController::class, 'joinUs'])->name('join_us');
Route::post('/join-us', [HomeController::class, 'joinUsPost'])->name('join_us_post');

Route::get('/legal/legal.html', [HomeController::class, 'terms_conditions'])->name('terms_conditions');


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
