<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminauthController;
use App\Http\Controllers\DetailAkunController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\ManajemenEventController;
use App\Http\Controllers\TambahLowonganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\Resume\ExperienceController;
use App\Http\Controllers\Resume\PersonalDetailsController;

// ========================
// Admin Auth & Dashboard
// ========================
Route::get('/admin/login', [AdminauthController::class, 'showLoginForm'])->name('admin.adminLogin');
Route::post('/admin/login', [AdminauthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

// ============================
// Admin - Verifikasi & Akun
// ============================
Route::get('/admin/verifikasi-akun', [AdminController::class, 'verifikasiAkun'])->name('admin.verifikasi-akun');
Route::put('/admin/verifikasi-akun/{id}', [AdminController::class, 'updateStatus'])->name('admin.verifikasi.update');

Route::get('/admin/detail-akun/{id}', [DetailAkunController::class, 'show'])->name('detail-akun.show');

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

// ======================
// Admin - Lowongan
// ======================
Route::get('/admin/tambah-lowongan', [TambahLowonganController::class, 'create'])->name('tambah-lowongan.create');
Route::post('/admin/storelowongan', [AdminController::class, 'storeLowongan'])->name('admin.storelowongan');

Route::get('/admin/manajemen-lowongan', [AdminController::class, 'manajemenlowongan'])->name('admin.manajemen-lowongan');
Route::delete('/admin/{slug}/destroy-lowongan', [AdminController::class, 'destroylowongan'])->name('admin.destroy-lowongan');

Route::get('/admin/edit-lowongan/{slug}', [AdminController::class, 'editlowongan'])->name('admin.edit-lowongan');
Route::put('/admin/update-lowongan/{slug}', [AdminController::class, 'updatelowongan'])->name('admin.update-lowongan');

// ===================
// Admin - Event
// ===================
Route::get('/event', [ManajemenEventController::class, 'manajemenevent'])->name('admin.manajemenevent');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/event', [ManajemenEventController::class, 'manajemenevent'])->name('admin.manajemenevent');
    Route::get('/event/create', [ManajemenEventController::class, 'create'])->name('admin.event.create');
    Route::get('/event/{id}/detail', [AdminController::class, 'detailEvent'])->name('admin.event.detail');
    Route::get('/event/{id}/edit', [AdminController::class, 'editEvent'])->name('admin.event.edit');
    Route::put('/event/{id}', [AdminController::class, 'updateEvent'])->name('admin.event.update');
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
});

// ===================
// Route Include
// ===================
require __DIR__ . '/jobseeker.php';
require __DIR__ . '/auth.php';