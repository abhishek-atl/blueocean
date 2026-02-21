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
use App\Http\Controllers\Admin\UserController;

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

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
