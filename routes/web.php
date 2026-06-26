<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\GiftVoucherController;
use App\Http\Controllers\GooglePlacesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;


include __DIR__ . '/auth.php';
include __DIR__ . '/booking.php';

Route::group([
    'middleware' => [AdminMiddleware::class]
], function () {

    // client
    Route::get('/my-account', [AccountController::class, 'account'])->name('account');
    Route::post('/my-account', [AccountController::class, 'accountPost'])->name('accountPost');

    Route::post('/my-account-password', [AccountController::class, 'accountPasswordPost'])->name('accountPasswordPost');
    Route::post('/my-account-download', [AccountController::class, 'accountDataDownload'])->name('accountDataDownload');

    // client, therapist
    Route::get('/my-bookings', [AccountController::class, 'bookings'])->name('bookings');
    Route::post('/rate', [AccountController::class, 'rateBooking'])->name('rate_booking');

    // therapist
    Route::get('/mandates', [AccountController::class, 'mandates'])->name('mandates');
    Route::post('/mandate-setup', [AccountController::class, 'createMandateSetupStripeSession'])->name('mandate_setup');
    Route::get('/mandate-setup-success', [AccountController::class, 'mandateSetupSuccess'])->name('mandate_setup_success');
    Route::post('/mandate-cancel', [AccountController::class, 'mandateCancel'])->name('mandate_cancel');

    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::get('/postcodes', [AccountController::class, 'postcodes'])->name('postcodes');
    Route::get('/schedules', [AccountController::class, 'schedules'])->name('schedules');
    Route::post('/schedules', [AccountController::class, 'schedulesPost'])->name('schedulesPost');
    Route::get('/calendar', [AccountController::class, 'calendar'])->name('calendar');
    Route::post('/calendar', [AccountController::class, 'calendarPost'])->name('calendarPost');
    Route::get('/holidays', [AccountController::class, 'holidays'])->name('holidays');
    Route::post('/late', [AccountController::class, 'late'])->name('late');
    Route::post('/cancel', [AccountController::class, 'cancel'])->name('cancel');
    Route::post('/extend', [AccountController::class, 'extend'])->name('extend');
    Route::post('/booking-update', [AccountController::class, 'bookingUpdate'])->name('booking_update');
});

// frontend
Route::get('/', [HomeController::class, 'home'])->name('home');

// treatments
Route::get('/treatments', [HomeController::class, 'treatments'])->name('treatments');
Route::get('/treatment/{slug}', [HomeController::class, 'treatmentDetail'])->name('treatment_detail');

// therapists
Route::get('/therapists', [HomeController::class, 'therapists'])->name('therapists');
Route::get('/therapist/{slug}', [HomeController::class, 'therapistDetail'])->name('therapist_detail');

// Join Us
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

Route::post('google-places', [GooglePlacesController::class, 'autoComplete'])->name('googleAutoComplete');
Route::get('google-places/details', [GooglePlacesController::class, 'placeDetails'])->name('googlePlaceDetails');
