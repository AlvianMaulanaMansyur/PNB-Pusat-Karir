<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminauthController;
use App\Http\Controllers\DetailAkunController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\ManajemenEventController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ManajemenLowonganController;
use App\Http\Controllers\TambahLowonganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\Resume\ExperienceController;
use App\Http\Controllers\Resume\PersonalDetailsController;
use Illuminate\Support\Facades\Storage;

// ========================
// Admin Auth & Dashboard
// ========================
Route::get('/admin/login', [AdminauthController::class, 'showLoginForm'])->name('admin.adminLogin');
Route::post('/admin/login', [AdminauthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
Route::post('/admin/logout', [AdminauthController::class, 'destroy'])->name('admin.logout');

// ============================
// Admin - Verifikasi & Akun
// ============================
Route::get('/admin/verifikasi-akun', [AdminController::class, 'verifikasiAkun'])->name('admin.verifikasi-akun');
Route::put('/admin/verifikasi-akun/{id}', [AdminController::class, 'updateStatus'])->name('admin.verifikasi.update');

Route::get('/admin/detail-akun/{id}', [DetailAkunController::class, 'show'])->name('detail-akun.show');

#Route::get('/admin/manajemen-lowongan', [ManajemenLowonganController::class, 'index'])->name('manajemen-lowongan.index');

Route::get('/admin/manajemen-lowongan', [ManajemenLowonganController::class, 'manajemenLowongan'])->name('admin.manajemen-lowongan');

Route::get('/admin/tambah-lowongan', [ManajemenLowonganController::class, 'create'])->name('tambah-lowongan.create');
Route::middleware(['auth'])->group(function () {
    Route::post('/lowongan', [ManajemenLowonganController::class, 'store'])->name('admin.store-lowongan');
});

Route::get('/admin/manajemen-lowongan', [ManajemenLowonganController::class, 'index'])
    ->name('admin.manajemen-lowongan');

Route::get('/admin/detail-lowongan/{slug}', [ManajemenLowonganController::class, 'detail'])
    ->name('admin.detail-lowongan');

Route::delete('/admin/{slug}/destroy-lowongan', [ManajemenLowonganController::class, 'destroy'])
    ->name('admin.destroy-lowongan');

Route::get('/admin/edit-lowongan/{slug}', [ManajemenLowonganController::class, 'edit'])->name('admin.edit-lowongan');
Route::put('/admin/update-lowongan/{slug}', [ManajemenLowonganController::class, 'update'])->name('admin.update-lowongan');


Route::get('/verifikasi/employer', [AdminController::class, 'verifikasiEmployer'])->name('admin.verifikasi-employer');
Route::get('/verifikasi/employee', [AdminController::class, 'verifikasiEmployee'])->name('admin.verifikasi-employee');

Route::delete('/verifikasi/{id}', [AdminController::class, 'destroy'])->name('admin.verifikasi.destroy');
Route::delete('/admin/verifikasi/{id}', [AdminController::class, 'destroy'])->name('admin.verifikasi.destroy');

// ==========================
// Admin - Employer Creation
// ==========================
Route::get('/admin/employer/create', [AdminController::class, 'create'])->name('admin.employer.create');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/employer/create', [AdminController::class, 'create'])->name('admin.employer.create');
    Route::post('/employer/store', [AdminController::class, 'store'])->name('admin.employer.store');
});

// ===================
// Admin - Event
// ===================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::post('/event/store', [ManajemenEventController::class, 'store'])->name('admin.event.store');
    Route::get('/event', [ManajemenEventController::class, 'manajemenevent'])->name('admin.manajemenevent');
    Route::get('/event/create', [ManajemenEventController::class, 'create'])->name('admin.event.create');
    Route::get('/event/{id}/detail', [ManajemenEventController::class, 'detailEvent'])->name('admin.event.detail');
    Route::get('/event/{id}/edit', [ManajemenEventController::class, 'editEvent'])->name('admin.event.edit');
    Route::put('/event/{id}', [ManajemenEventController::class, 'update'])->name('admin.event.update');
    Route::delete('/admin/event/{id}', [ManajemenEventController::class, 'destroy'])->name('admin.event.destroy');
});

// ===================
// Employer Routes
// ===================
Route::middleware(['auth', 'role:employer'])->prefix('employer')->group(function () {
    Route::get('/', fn() => view('employer.dashboard'))->name('employer.home');
    Route::get('dashboard', [EmployerController::class, 'index'])->name('employer.dashboard');

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

    Route::get('notifications', [EmployerController::class, 'notifications'])->name('employer.notifications');
    Route::delete('/notifikasi/{id}', [EmployerController::class, 'destroyNotification'])->name('employer.notifikasi.destroy');
});

// ===================
// Resume (Employee)
// ===================
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::resource('resumes', ResumeController::class);

    Route::post('resumes/{resume}/personal-details', [PersonalDetailsController::class, 'update'])
        ->name('resumes.personal-details.update');

    Route::prefix('resumes/{resume}/experience')->group(function () {
        Route::post('/', [ExperienceController::class, 'store'])->name('resumes.experience.store');
        Route::get('/{experienceId}', [ExperienceController::class, 'show'])->name('resumes.experience.show');
        Route::put('/{experienceId}', [ExperienceController::class, 'update'])->name('resumes.experience.update');
        Route::delete('/{experienceId}', [ExperienceController::class, 'destroy'])->name('resumes.experience.destroy');
    });

    Route::get('/resumes/{resume:slug}/export/json', [ResumeController::class, 'exportJson'])->name('resumes.export.json');
    Route::get('/resumes/{resume:slug}/export/pdf', [ResumeController::class, 'exportPdf'])->name('resumes.export.pdf');
    Route::get('/resumes/{resume:slug}/view/pdf', [ResumeController::class, 'showPdf'])->name('resumes.view.pdf');
});

// ===================
// Profile (Auth umum)
// ===================
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
            Route::get('{slug}/pelamar-lowongan/{jobId}/{userId}/detail', [EmployerController::class, 'detailPelamar'])
                ->name('employer.detail-pelamar');


            Route::get('{slug}/kelola-interview', [EmployerController::class, 'showInterviewApplicants'])->name('employer.kelolawawancara');
            Route::patch('{slug}/update-interview', [EmployerController::class, 'updateInterviewDate'])->name('employer.updateInterviewDate');

            // Route notifikasi (PENTING: harus di sini, bukan di dalam closure lain)
            Route::get('notifications', [EmployerController::class, 'notifications'])->name('employer.notifications');
            Route::delete('/notifikasi/{id}', [EmployerController::class, 'destroyNotification'])->name('employer.notifikasi.destroy');

            Route::get('cari-pelamar', [EmployerController::class, 'caripelamar'])->name('employer.temukan-kandidat');
            Route::get('{slug}/kandidat/{id}', [EmployerController::class, 'detailKandidat'])->name('employer.detail-kandidat');



            Route::post('send-invitation/{jobId}/{userId}', [MailController::class, 'inviteApplicants'])->name('employer.send-invitation');

            Route::get('/download/cv/{filename}', function ($filename) {
                $path = 'cv/' . $filename;

                if (!Storage::disk('public')->exists($path)) {
                    abort(404);
                }

                return Storage::download('public/' . $path);
            })->name('cv.download');

            Route::get('/download/sertif/{filename}', function ($filename) {
                $path = '/private/sertifikat/' . $filename;

                if (!Storage::exists($path)) {
                    abort(404);
                }

                return Storage::download($path);
            })->name('sertifikat.download');

            // Route dashboard default employer (boleh juga digabung di atas)
            Route::get('/', function () {
                return view('employer.dashboard');
            })->name('employer.home');
        });
    });
});

// ===================
// Route Include
// ===================
require __DIR__ . '/jobseeker.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
