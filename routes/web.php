<?php

use App\Http\Controllers\CvController;
use App\Http\Controllers\CvGeneratorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AdminauthController;
use App\Http\Controllers\EmployerController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/admin/login', [AdminauthController::class, 'showLoginForm'])->name('admin.adminLogin');
Route::post('/admin/login', [AdminauthController::class, 'login'])->name('admin.login.submit');

// Route::middleware('auth')->group(function () {
//     Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
// });

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

    // Route::get('/employer', function () {
    //     return view('employer.dashboard');
    // });

    // Route::middleware('role:employer')->group(function () {
    //     Route::get('employer/dashboard', [EmployerController::class, 'index'])
    //         ->name('employer.dashboard');

    //     // Tambah Lowongan
    //     Route::get('/employer/tambahlowongan', [EmployerController::class, 'tambahlowongan'])
    //         ->name('employer.tambahlowongan');
    //     Route::post('/employer/storelowongan', [EmployerController::class, 'storelowongan'])
    //         ->name('employer.storelowongan');

    //     Route::get('/employer/manajemen-lowongan', [EmployerController::class, 'manajemenlowongan'])
    //         ->name('employer.manajemen-lowongan');

    //     Route::delete('/employer/{slug}/destroy-lowongan', [EmployerController::class, 'destroylowongan'])
    //         ->name('employer.destroy-lowongan');

    //     Route::get('/employer/edit-lowongan/{slug}', [EmployerController::class, 'editlowongan'])->name('employer.edit-lowongan');
    //     Route::put('/employer/update-lowongan/{slug}', [EmployerController::class, 'updatelowongan'])->name('employer.update-lowongan');

    //     Route::get('/employer/{slug}/edit-profile', [EmployerController::class, 'editprofile'])->name('employer.edit-profile');
    //     Route::put('/employer/{slug}', [EmployerController::class, 'update'])->name('employer.update');

    //     Route::get('/employer/{slug}/pelamar-lowongan', [EmployerController::class, 'showApplicants'])->name('employer.pelamar-lowongan');
    //     // web.php
    //     Route::patch('/employer/pelamar-lowongan/{slug}/status', [EmployerController::class, 'updateStatus'])->name('employer.updateStatus');

    //     Route::get('/employer/{slug}/kelola-interview', [EmployerController::class, 'showInterviewApplicants'])->name('employer.kelolawawancara');
    //     Route::patch('/employer/{slug}/update-interview', [EmployerController::class, 'updateInterviewDate'])->name('employer.updateInterviewDate');

    //     // Route::get('/employer/{slug}/pelamar-lowongan', [EmployerController::class, 'filterstatus'])->name('employer.pelamar-lowongan');
    //     Route::get('/employer', function () {
    //         return view('employer.dashboard');

    //         Route::middleware(['role:employer'])->prefix('employer')->group(function () {
    //             // Route notifikasi
    //             Route::get('notifications', [EmployerController::class, 'notifications'])->name('employer.notifications');
    //         });
    //     });
    // });
    Route::middleware('role:employer')->prefix('employer')->group(function () {
    Route::get('dashboard', [EmployerController::class, 'index'])->name('employer.dashboard');

    // Tambah Lowongan
    Route::get('tambahlowongan', [EmployerController::class, 'tambahlowongan'])->name('employer.tambahlowongan');
    Route::post('storelowongan', [EmployerController::class, 'storelowongan'])->name('employer.storelowongan');

    Route::get('manajemen-lowongan', [EmployerController::class, 'manajemenlowongan'])->name('employer.manajemen-lowongan');

    Route::delete('{slug}/destroy-lowongan', [EmployerController::class, 'destroylowongan'])->name('employer.destroy-lowongan');

    Route::get('edit-lowongan/{slug}', [EmployerController::class, 'editlowongan'])->name('employer.edit-lowongan');
    Route::put('update-lowongan/{slug}', [EmployerController::class, 'updatelowongan'])->name('employer.update-lowongan');

    Route::get('{slug}/edit-profile', [EmployerController::class, 'editprofile'])->name('employer.edit-profile');
    Route::put('{slug}', [EmployerController::class, 'update'])->name('employer.update');

    Route::get('{slug}/pelamar-lowongan', [EmployerController::class, 'showApplicants'])->name('employer.pelamar-lowongan');
    Route::patch('pelamar-lowongan/{slug}/status', [EmployerController::class, 'updateStatus'])->name('employer.updateStatus');

    Route::get('{slug}/kelola-interview', [EmployerController::class, 'showInterviewApplicants'])->name('employer.kelolawawancara');
    Route::patch('{slug}/update-interview', [EmployerController::class, 'updateInterviewDate'])->name('employer.updateInterviewDate');

    // Route notifikasi (PENTING: harus di sini, bukan di dalam closure lain)
    Route::get('notifications', [EmployerController::class, 'notifications'])->name('employer.notifications');
    Route::delete('/notifikasi/{id}', [EmployerController::class, 'destroyNotification'])->name('employer.notifikasi.destroy');


    // Route dashboard default employer (boleh juga digabung di atas)
    Route::get('/', function () {
        return view('employer.dashboard');
    })->name('employer.home');
});

});

require __DIR__ . '/jobseeker.php';
require __DIR__ . '/auth.php';
