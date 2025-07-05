<?php

use App\Http\Controllers\Jobseeker\AppliedJobController;
use App\Http\Controllers\Jobseeker\JobSeekerController;
use App\Http\Controllers\jobseeker\JobseekerProfiles;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:employee', 'verified'])->group(function () {
    Route::get('/', [JobSeekerController::class, 'LandingPage'])->name('employee.landing-page');
    // Route untuk halaman dashboard jobseeker

    Route::get('/lowongan', [JobSeekerController::class, 'index'])->name('employee.lowongan');

    Route::get('/job-detail/{id}', [JobSeekerController::class, 'detailLowongan'])->name('job.detail');

    Route::prefix('/id')->group(function () {
        Route::get('/apply-job/{id}', [JobSeekerController::class, 'applyJob'])->name('job-apply');

        Route::post('/apply-job/{id}/form-requirement', [JobSeekerController::class, 'storeStepOne'])->name('job-apply.step-one');

        Route::get('/apply-job/{id}/file-preview', [JobSeekerController::class, 'showPreview'])->name('file-preview');

        Route::post('/apply-job/{id}/file-preview', [JobSeekerController::class, 'storeStepTwo'])->name('job-apply.step-two');

        Route::get('/apply-job/{id}/success', [JobSeekerController::class, 'successApply'])->name('job-apply.success');

        Route::get('/notifikasi',  [NotificationController::class, 'index'])->name('notifikasi.jobseeker');

        Route::get('/activity/applied-jobs', [AppliedJobController::class, 'index'])->name('applied.index');

        Route::post('/report-job/{id}', [JobSeekerController::class, 'reportJob'])->name('report.job');
    });

    Route::prefix('/my-profile')->group(function () {
        Route::get('/', [JobseekerProfiles::class, 'index'])->name('jobseeker.profiles');
        Route::put('/update-photo', [JobseekerProfiles::class, 'updateProfile'])->name('profile.update-profiles');
        Route::put('/summary-update', [JobseekerProfiles::class, 'updateSummary'])->name('profile.update-summary');

        // Route untuk section pendidikan
        Route::prefix('/education')->group(function () {
            Route::post('/add-educations', [JobseekerProfiles::class, 'addEducation'])->name('add.educations');
            Route::put('/edit/{id}', [JobseekerProfiles::class, 'educationUpdate'])->name('education.update');
            Route::delete('/delete/{id}', [JobseekerProfiles::class, 'educationDelete'])->name('education.delete');
        });

        Route::prefix('/work-experience')->group(function () {
            Route::post('/add', [JobseekerProfiles::class, 'addWorkingExperience'])->name('work-experience.add');
            Route::put('/edit/{id}', [JobseekerProfiles::class, 'updateWorkExperience'])->name('work-experience.update');
            Route::delete('/delete/{id}', [JobseekerProfiles::class, 'deleteWorkExperience'])->name('work-experience.delete');
        });

        Route::get('/fetch-skills', [JobseekerProfiles::class, 'fetchSkills'])->name('skill.fetch');
        Route::post('/add-skill', [JobseekerProfiles::class, 'addSkill'])->name('skill.add');
        Route::delete('/delete-skill/{id}', [JobseekerProfiles::class, 'deleteSkill'])->name('skill.delete');
    });
});
