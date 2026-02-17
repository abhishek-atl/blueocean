<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostcodeController;
use App\Http\Controllers\Admin\PostcodeDistrictController;
use App\Http\Controllers\Admin\PostcodeZoneController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TherapistController;
use App\Http\Controllers\Admin\TreatmentController;


Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


Route::get('/therapists', [TherapistController::class, 'index'])->name('therapists.index');
Route::get('/therapist/create', [TherapistController::class, 'addEdit'])->name('therapists.create');
Route::get('/therapist/edit/{id?}', [TherapistController::class, 'addEdit'])->name('therapists.edit');
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



// role permission route
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/role/create', [RoleController::class, 'create'])->name('roles.create');
Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
Route::post('/role/store', [RoleController::class, 'store'])->name('roles.store');
Route::get('/role/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::get('/permissions/{roleId}', [RoleController::class, 'getRolePermissions'])->name('roles.permissions');
Route::post('/permissions/store', [RoleController::class, 'storeRolePermissions'])->name('roles.permissions.store');

Route::get('/treatments', [TreatmentController::class, 'index'])->name('treatments.index');
Route::get('/treatment/create', [TreatmentController::class, 'addEdit'])->name('treatments.create');
Route::get('/treatment/edit/{id}', [TreatmentController::class, 'addEdit'])->name('treatments.edit');
Route::post('/treatment/store', [TreatmentController::class, 'store'])->name('treatments.store');
Route::get('/treatment/destroy/{id}', [TreatmentController::class, 'destroy'])->name('treatments.destroy');


Route::get('/postcode-districts', [PostcodeDistrictController::class, 'index'])->name('postcode_districts.index');

Route::get('/postcodes', [PostcodeController::class, 'index'])->name('postcodes.index');
Route::get('/postcodes/create', [PostcodeController::class, 'createEdit'])->name('postcodes.create');
Route::get('/postcodes/edit/{id}', [PostcodeController::class, 'createEdit'])->name('postcodes.edit');
Route::post('/postcodes/store', [PostcodeController::class, 'store'])->name('postcodes.store');
Route::get('/postcodes/destroy/{id}', [PostcodeController::class, 'destroy'])->name('postcodes.destroy');

Route::get('/postcode-zones', [PostcodeZoneController::class, 'index'])->name('postcode_zones.index');
Route::get('/postcode-zones/create', [PostcodeZoneController::class, 'createEdit'])->name('postcode_zones.create');
Route::get('/postcode-zones/edit/{id?}', [PostcodeZoneController::class, 'createEdit'])->name('postcode_zones.edit');
Route::post('/postcode-zones/store', [PostcodeZoneController::class, 'store'])->name('postcode_zones.store');