<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\CvGeneratorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Auth\AdminauthController;
use App\Http\Controllers\DetailAkunController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\ManajemenLowonganController;
use App\Http\Controllers\TambahLowonganController;
use App\Http\Controllers\Resume\ExperienceController;
use App\Http\Controllers\Resume\PersonalDetailsController;
use App\Http\Controllers\ResumeController;

Route::get('/admin/login', [AdminauthController::class, 'showLoginForm'])->name('admin.adminLogin');
Route::post('/admin/login', [AdminauthController::class, 'login'])->name('admin.login.submit');

Route::put('/admin/verifikasi-akun/{id}', [AdminController::class, 'updateStatus'])->name('admin.verifikasi.update');

Route::get('/admin/verifikasi-akun', [AdminController::class, 'verifikasiAkun'])->name('admin.verifikasi-akun');

Route::get('/admin/detail-akun/{id}', [DetailAkunController::class, 'show'])->name('detail-akun.show');

#Route::get('/admin/manajemen-lowongan', [ManajemenLowonganController::class, 'index'])->name('manajemen-lowongan.index');

Route::get('/admin/tambah-lowongan', [TambahLowonganController::class, 'create'])->name('tambah-lowongan.create');

Route::post('/admin/storelowongan', [AdminController::class, 'storeLowongan'])
            ->name('admin.storelowongan');

Route::get('/admin/manajemen-lowongan', [AdminController::class, 'manajemenlowongan'])
            ->name('admin.manajemen-lowongan');

Route::delete('/admin/{slug}/destroy-lowongan', [AdminController::class, 'destroylowongan'])
            ->name('admin.destroy-lowongan');

Route::get('/admin/edit-lowongan/{slug}', [AdminController::class, 'editlowongan'])->name('admin.edit-lowongan');
        Route::put('/admin/update-lowongan/{slug}', [AdminController::class, 'updatelowongan'])->name('admin.update-lowongan');


Route::get('/verifikasi/employer', [AdminController::class, 'verifikasiEmployer'])->name('admin.verifikasi-employer');
Route::get('/verifikasi/employee', [AdminController::class, 'verifikasiEmployee'])->name('admin.verifikasi-employee');

Route::delete('/verifikasi/{id}', [AdminController::class, 'destroy'])->name('admin.verifikasi.destroy');
Route::delete('/admin/verifikasi/{id}', [AdminController::class, 'destroy'])->name('admin.verifikasi.destroy');

Route::get('/admin/employer/create', [AdminController::class, 'create'])->name('admin.employer.create');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/employer/create', [AdminController::class, 'create'])->name('admin.employer.create');
    Route::post('/employer/store', [AdminController::class, 'store'])->name('admin.employer.store');

});
// Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
Route::middleware(['auth', 'role:employee'])->group(function () {
    // Rute resource untuk CRUD dasar resume
    Route::resource('resumes', ResumeController::class);

    // Rute untuk mengupdate bagian JSON spesifik
    Route::post('resumes/{resume}/personal-details', [PersonalDetailsController::class, 'update'])
        ->name('resumes.personal-details.update');

    Route::prefix('resumes/{resume}/experience')->group(function () {
        Route::post('/', [ExperienceController::class, 'store'])->name('resumes.experience.store');
        Route::get('/{experienceId}', [ExperienceController::class, 'show'])->name('resumes.experience.show');
        Route::put('/{experienceId}', [ExperienceController::class, 'update'])->name('resumes.experience.update');
        Route::delete('/{experienceId}', [ExperienceController::class, 'destroy'])->name('resumes.experience.destroy');
    });

    // Rute untuk export
    Route::get('/resumes/{resume:slug}/export/json', [ResumeController::class, 'exportJson'])
        ->name('resumes.export.json');
    Route::get('/resumes/{resume:slug}/export/pdf', [ResumeController::class, 'exportPdf'])
        ->name('resumes.export.pdf');
    Route::get('/resumes/{resume:slug}/view/pdf', [ResumeController::class, 'showPdf'])
        ->name('resumes.view.pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:employer')->group(function () {
        Route::get('employer/dashboard', [EmployerController::class, 'index'])
            ->name('employer.dashboard');

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
});
require __DIR__ . '/jobseeker.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
