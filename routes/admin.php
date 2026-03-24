<?php

use App\Http\Controllers\Admin\CustomerController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostcodeController;
use App\Http\Controllers\Admin\PostcodeDistrictController;
use App\Http\Controllers\Admin\PostcodeZoneController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TherapistController;
use App\Http\Controllers\Admin\TreatmentController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PostCommentController;
use App\Http\Controllers\Admin\PostTagController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\TariffPlanController;
use App\Http\Controllers\Admin\GiftCertificateController;
use App\Http\Controllers\Admin\BlacklistController;
use App\Http\Middleware\AdminMiddleware;

Route::middleware([AdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'createEdit'])->name('bookings.create');
    Route::get('/bookings/edit/{id}', [BookingController::class, 'createEdit'])->name('bookings.edit');
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/destroy/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'createEdit'])->name('payments.create');
    Route::get('/payments/edit/{id}', [PaymentController::class, 'createEdit'])->name('payments.edit');
    Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/destroy/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    // Therapists
    Route::get('/therapists', [TherapistController::class, 'index'])->name('therapists.index');
    Route::get('/therapist/create', [TherapistController::class, 'createEdit'])->name('therapists.create');
    Route::get('/therapist/edit/{id?}', [TherapistController::class, 'createEdit'])->name('therapists.edit');
    Route::post('/therapist/store', [TherapistController::class, 'store'])->name('therapists.store');
    Route::get('/therapist/destroy/{id}', [TherapistController::class, 'destroy'])->name('therapists.destroy');

    Route::get('/therapists/profile/{id?}', [TherapistController::class, 'therapistProfile'])->name('therapists.profile');
    Route::post('/therapists/profile', [TherapistController::class, 'therapistProfileStore'])->name('therapists.profileStore');

    Route::get('/therapists/treatments/{id?}', [TherapistController::class, 'treatments'])->name('therapists.treatments');
    Route::post('/therapists/treatments/{id?}', [TherapistController::class, 'treatmentsStore'])->name('therapists.treatmentsStore');

    Route::get('/therapists/postcodes/{id?}', [TherapistController::class, 'postcodes'])->name('therapists.postcodes');
    Route::post('/therapists/postcodes/{id?}', [TherapistController::class, 'postcodesStore'])->name('therapists.postcodesStore');

    Route::get('/therapists/schedules/{id?}', [TherapistController::class, 'schedules'])->name('therapists.schedules');
    Route::post('therapists/schedules/{id?}', [TherapistController::class, 'schedulesStore'])->name('therapists.schedulesStore');

    Route::get('/therapists/fees/{id?}', [TherapistController::class, 'fees'])->name('therapists.fees');
    Route::post('/therapists/fees/{id?}', [TherapistController::class, 'feesStore'])->name('therapists.feesStore');

    Route::get('/holidays/{id}', [TherapistController::class, 'holidays'])->name('therapists.holidays');

    // Treatments
    Route::get('/treatments', [TreatmentController::class, 'index'])->name('treatments.index');
    Route::get('/treatments/create', [TreatmentController::class, 'createEdit'])->name('treatments.create');
    Route::get('/treatments/edit/{id}', [TreatmentController::class, 'createEdit'])->name('treatments.edit');
    Route::post('/treatments/store', [TreatmentController::class, 'store'])->name('treatments.store');
    Route::get('/treatments/destroy/{id}', [TreatmentController::class, 'destroy'])->name('treatments.destroy');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'createEdit'])->name('users.create');
    Route::get('/users/edit/{id}', [UserController::class, 'createEdit'])->name('users.edit');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'createEdit'])->name('customers.create');
    Route::get('/customers/edit/{id}', [CustomerController::class, 'createEdit'])->name('customers.edit');
    Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');


    // Role and Permissions
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('roles.create');
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/role/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/role/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/permissions/{roleId}', [RoleController::class, 'getRolePermissions'])->name('roles.permissions');
    Route::post('/permissions/store', [RoleController::class, 'storeRolePermissions'])->name('roles.permissions.store');

    // post districts
    Route::get('/postcode-districts', [PostcodeDistrictController::class, 'index'])->name('postcode_districts.index');

    // postcodes
    Route::get('/postcodes', [PostcodeController::class, 'index'])->name('postcodes.index');
    Route::get('/postcodes/create', [PostcodeController::class, 'createEdit'])->name('postcodes.create');
    Route::get('/postcodes/edit/{id}', [PostcodeController::class, 'createEdit'])->name('postcodes.edit');
    Route::post('/postcodes/store', [PostcodeController::class, 'store'])->name('postcodes.store');
    Route::get('/postcodes/destroy/{id}', [PostcodeController::class, 'destroy'])->name('postcodes.destroy');

    // postcode zones
    Route::get('/postcode-zones', [PostcodeZoneController::class, 'index'])->name('postcode_zones.index');
    Route::get('/postcode-zones/create', [PostcodeZoneController::class, 'createEdit'])->name('postcode_zones.create');
    Route::get('/postcode-zones/edit/{id?}', [PostcodeZoneController::class, 'createEdit'])->name('postcode_zones.edit');
    Route::post('/postcode-zones/store', [PostcodeZoneController::class, 'store'])->name('postcode_zones.store');

    // Posts
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'createEdit'])->name('posts.create');
    Route::get('/posts/edit/{id}', [PostController::class, 'createEdit'])->name('posts.edit');
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/destroy/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Post Comments
    Route::get('/post-comments', [PostCommentController::class, 'index'])->name('post_comments.index');
    Route::get('/post-comments/create', [PostCommentController::class, 'createEdit'])->name('post_comments.create');
    Route::get('/post-comments/edit/{id}', [PostCommentController::class, 'createEdit'])->name('post_comments.edit');
    Route::post('/post-comments/store', [PostCommentController::class, 'store'])->name('post_comments.store');
    Route::get('/post-comments/destroy/{id}', [PostCommentController::class, 'destroy'])->name('post_comments.destroy');

    // Post Tags
    Route::get('/post-tags', [PostTagController::class, 'index'])->name('post_tags.index');
    Route::get('/post-tags/create', [PostTagController::class, 'createEdit'])->name('post_tags.create');
    Route::get('/post-tags/edit/{id}', [PostTagController::class, 'createEdit'])->name('post_tags.edit');
    Route::post('/post-tags/store', [PostTagController::class, 'store'])->name('post_tags.store');
    Route::get('/post-tags/destroy/{id}', [PostTagController::class, 'destroy'])->name('post_tags.destroy');

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/create', [ReviewController::class, 'createEdit'])->name('reviews.create');
    Route::get('/reviews/edit/{id}', [ReviewController::class, 'createEdit'])->name('reviews.edit');
    Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/destroy/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // FAQs
    Route::get('/faqs', [FAQController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/create', [FAQController::class, 'createEdit'])->name('faqs.create');
    Route::get('/faqs/edit/{id}', [FAQController::class, 'createEdit'])->name('faqs.edit');
    Route::post('/faqs/store', [FAQController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/destroy/{id}', [FAQController::class, 'destroy'])->name('faqs.destroy');

    // Tariff Plans
    Route::get('/tariff-plans', [TariffPlanController::class, 'index'])->name('tariff_plans.index');
    Route::get('/tariff-plans/create', [TariffPlanController::class, 'createEdit'])->name('tariff_plans.create');
    Route::get('/tariff-plans/edit/{id}', [TariffPlanController::class, 'createEdit'])->name('tariff_plans.edit');
    Route::post('/tariff-plans/store', [TariffPlanController::class, 'store'])->name('tariff_plans.store');
    Route::get('/tariff-plans/destroy/{id}', [TariffPlanController::class, 'destroy'])->name('tariff_plans.destroy');

    // Gift Certificates
    Route::get('/gift-certificates', [GiftCertificateController::class, 'index'])->name('gift_certificates.index');
    Route::get('/gift-certificates/create', [GiftCertificateController::class, 'createEdit'])->name('gift_certificates.create');
    Route::get('/gift-certificates/edit/{id}', [GiftCertificateController::class, 'createEdit'])->name('gift_certificates.edit');
    Route::post('/gift-certificates/store', [GiftCertificateController::class, 'store'])->name('gift_certificates.store');
    Route::get('/gift-certificates/destroy/{id}', [GiftCertificateController::class, 'destroy'])->name('gift_certificates.destroy');

    // Blacklists
    Route::get('/blacklists', [BlacklistController::class, 'index'])->name('blacklists.index');
    Route::get('/blacklists/create', [BlacklistController::class, 'createEdit'])->name('blacklists.create');
    Route::get('/blacklists/edit/{id}', [BlacklistController::class, 'createEdit'])->name('blacklists.edit');
    Route::post('/blacklists/store', [BlacklistController::class, 'store'])->name('blacklists.store');
    Route::get('/blacklists/destroy/{id}', [BlacklistController::class, 'destroy'])->name('blacklists.destroy');
});
