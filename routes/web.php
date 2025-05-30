<?php

use App\Http\Controllers\CvController;
use App\Http\Controllers\CvGeneratorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('layouts.jobseeker');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/cv', [CvGeneratorController::class, 'index'])->name('cv-generator.index');
    // Route::get('/cv/{step}', [CvGeneratorController::class, 'showStep'])->name('cv-generator.step');
    Route::post('/upload-dokumen', [CvGeneratorController::class, 'uploadDokumen'])->name('upload.dokumen');

    Route::post('/save-session-realtime', [CvGeneratorController::class, 'saveSessionRealtime'])->name('save.session.realtime');

    Route::get('/load-session-data/{slug}', [CvGeneratorController::class, 'loadSessionData'])
        ->name('load.session.data');



    // Route utama untuk menampilkan dashboard CV (dengan daftar CV)
    Route::get('/cv', [CvGeneratorController::class, 'index'])->name('cv.dashboard');

    // web.php
    Route::get('/cv/create-new', [CvGeneratorController::class, 'createNewCV'])->name('cv.create-new');

    Route::get('/cv/{slug}/personal-information', [CvGeneratorController::class, 'showPersonalInformationForm'])->name('cv.personal-info');
    // Route untuk menyimpan informasi pribadi ke database (seperti yang sudah kita buat sebelumnya)
    Route::post('cv/{slug}/save-personal-information', [CvGeneratorController::class, 'savePersonalInformation'])->name('save.personal.information');
    Route::get('/cv/{cv:slug}/personal-informations/load', [CvGeneratorController::class, 'loadPersonalInformations'])->name('cv.personal-information.load');

    Route::post('/upload-profile-photo', [CvGeneratorController::class, 'uploadProfilePhoto'])
        ->name('upload.profile.photo');


    // routes/web.php
    Route::post('/cv/{slug}/update-title', [CvGeneratorController::class, 'updateCvTitle'])
        ->name('cv.update.title');

    Route::get('/cv/{slug}/edit', [CvGeneratorController::class, 'edit'])->name('cv.edit');
    Route::delete('/cv/{slug}', [CvGeneratorController::class, 'destroy'])->name('cv.destroy');
    Route::get('/cv/{slug}/download', [CvGeneratorController::class, 'download'])->name('cv.download');

    Route::get('/cv/{slug}/work-experiences', [CvGeneratorController::class, 'showWorkExperienceForm'])
        ->name('cv.experiences');


    Route::post('/cv/{cv:slug}/work-experiences', [CvGeneratorController::class, 'storeWorkExperiences'])->name('cv.pengalaman_kerja.store');
    Route::get('/cv/{cv:slug}/work-experiences/load', [CvGeneratorController::class, 'loadWorkExperiences'])->name('cv.pengalaman_kerja.load');

    Route::get('/cv/{slug}/educations', [CvGeneratorController::class, 'showEducationForm'])
        ->name('cv.educations');

    Route::post('/cv/{cv:slug}/educations/store', [CvGeneratorController::class, 'storeEducations'])->name('cv.educations.store');
    Route::get('/cv/{cv:slug}/educations/load', [CvGeneratorController::class, 'loadEducations'])->name('cv.educations.load');

    Route::get('/cv/{slug}/organizations', [CvGeneratorController::class, 'showOrganizationForm'])
        ->name('cv.organizations');
    Route::post('/cv/{cv:slug}/organizations/store', [CvGeneratorController::class, 'storeOrganizations'])->name('cv.organizations.store');
    Route::get('/cv/{cv:slug}/organizations/load', [CvGeneratorController::class, 'loadOrganizations'])->name('cv.organizations.load');

    Route::get('/cv/{slug}/other-experiences', [CvGeneratorController::class, 'showOtherExperienceForm'])
        ->name('cv.other-experiences');
    Route::post('/cv/{cv:slug}/other-experiences/store', [CvGeneratorController::class, 'storeOtherExperiences'])
        ->name('cv.other-experiences.store');
    Route::get('/cv/{cv:slug}/other-experiences/load', [CvGeneratorController::class, 'loadOtherExperiences'])
        ->name('cv.other-experiences.load');

    Route::get('/cv/{cv:slug}/review', [CvGeneratorController::class, 'showReviewPage'])
        ->name('cv.review');
    Route::post('/cv/{slug}/download', [CvGeneratorController::class, 'downloadCv'])->name('cv.download');
});

// -------employer
Route::get('/employer', function () {
    return view('employer.dashboard');
});
// Tambah Lowongan
Route::get('/employer/tambah-lowongan', function () {
    return view('employer.tambah-lowongan');
});
// manajemen Lowongan
Route::get('/employer/manage-lowongan', function () {
    return view('employer.manage-lowongan');
});
// manajemen Lowongan
Route::get('/employer/edit-profile', function () {
    return view('employer.edit-profile');
})->name('employer.edit-profile');
// manajemen pelamar
Route::get('/employer/pelamar-lowongan', function () {
    return view('employer.pelamar-lowongan');
})->name('employer.pelamar-lowongan');
// edit-lowongan
Route::get('/employer/edit-lowongan', function () {
    return view('employer.edit-lowongan');
})->name('employer.edit-lowongan');
// kelola-interview
Route::get('/employer/kelola-interview', function () {
    return view('employer.kelola-interview');
})->name('employer.kelola-interview');


require __DIR__.'/auth.php';
