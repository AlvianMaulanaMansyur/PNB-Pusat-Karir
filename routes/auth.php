<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\LocationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthenticationChecker;
use Illuminate\Support\Facades\Route;

Route::get('/get-countries', [LocationController::class, 'getCountries']);
Route::get('/get-cities', [LocationController::class, 'getCities']);

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminauthController::class, 'showLoginForm'])->name('admin.adminLogin');
    Route::post('/admin/login', [AdminauthController::class, 'login'])->name('admin.login.submit');
    // route untuk menampilkan halaman register jobseeker
    Route::get('register-jobseeker', [RegisteredUserController::class, 'JobSeeker'])
        ->name('jobseeker-register');

    // route untuk menyimpan data Jobseeker ke database
    Route::post('register-jobseeker', [RegisteredUserController::class, 'JobSeekerDataStore']);

    // route untuk halaman form register employer
    Route::get('register', [RegisteredUserController::class, 'employer'])
    ->name('register-employer');

    // route untuk menyimpan data Employer ke database
    Route::post('register', [RegisteredUserController::class, 'EmployerDataStore']);

    // Route untuk login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
    // API untuk mengecek username dan email terdaftar atau tidak
    Route::get('/AuthCheker', [AuthenticationChecker::class, 'CheckerShowForm'])->name('account-checker');
    Route::post('/AuthCheker', [AuthenticationChecker::class, 'CheckerFormStore']);

});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});