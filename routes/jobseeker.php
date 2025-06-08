<?php

use App\Http\Controllers\Jobseeker\JobSeekerController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth','role:employee', 'verified'])->group(function () {
    // Route untuk halaman dashboard jobseeker
    Route::get('/', [JobSeekerController::class, 'index'])
        ->name('employee.landing-page');

    Route::get('/job-detail/{id}', [JobSeekerController::class, 'detailLowongan'])->name('job.detail');

    Route::prefix('/id')->group(function (){

        Route::get('/apply-job/{id}', [JobSeekerController::class, 'applyJob'])->name('job-apply');
    });
});
