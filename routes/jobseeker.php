<?php

use App\Http\Controllers\Jobseeker\JobSeekerController;
use App\Http\Controllers\jobseeker\JobseekerProfiles;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:employee', 'verified'])->group(function () {
    // Route untuk halaman dashboard jobseeker
    Route::get('/', [JobSeekerController::class, 'index'])->name('employee.landing-page');

    Route::get('/job-detail/{id}', [JobSeekerController::class, 'detailLowongan'])->name('job.detail');

    Route::prefix('/id')->group(function () {
        Route::get('/apply-job/{id}', [JobSeekerController::class, 'applyJob'])->name('job-apply');

        Route::post('/apply-job/{id}/form-requirement', [JobSeekerController::class, 'storeStepOne'])->name('job-apply.step-one');

        Route::get('/apply-job/{id}/file-preview', [JobSeekerController::class, 'showPreview'])->name('file-preview');

        Route::post('/apply-job/{id}/file-preview', [JobSeekerController::class, 'storeStepTwo'])->name('job-apply.step-two');

        Route::get('/apply-job/{id}/success', [JobSeekerController::class, 'successApply'])->name('job-apply.success');

        // route notifikasi
        Route::get('/notifikasi',  [NotificationController::class, 'index'])->name('notifikasi.jobseeker');
    });
    Route::prefix('/my-profile')->group(function () {
        Route::get('/', [JobseekerProfiles::class, 'index'])->name('jobseeker.profiles');
        Route::put('/update-photo', [JobseekerProfiles::class, 'updateProfile'])->name('profile.update-profiles');
        Route::put('/summary-update', [JobseekerProfiles::class, 'updateSummary'])->name('profile.update-summary');
        Route::post('/education/add-educations', [JobseekerProfiles::class, 'addEducation'])->name('add.educations');
    });
});
