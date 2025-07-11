<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\DetailAkunController;
use App\Http\Controllers\ManajemenEventController;
use App\Http\Controllers\ManajemenLowonganController;
use Illuminate\Support\Facades\Route;

// ============================
// Login
// ============================

Route::get('/admin/login', [AdminauthController::class, 'showLoginForm'])->name('admin.adminLogin');
Route::post('/admin/login', [AdminauthController::class, 'login'])->name('admin.login.submit');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::post('/logout', [AdminauthController::class, 'destroy'])->name('admin.logout');

    Route::get('/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

    // ===================
    // Verifikasi
    // ===================
    Route::get('/verifikasi-akun', [AdminController::class, 'verifikasiAkun'])->name('admin.verifikasi-akun');
    Route::put('/verifikasi-akun/{id}', [AdminController::class, 'updateStatus'])->name('admin.verifikasi.update');

    Route::get('/detail-akun/{id}', [DetailAkunController::class, 'show'])->name('detail-akun.show');

    #Route::get('/manajemen-lowongan', [ManajemenLowonganController::class, 'index'])->name('manajemen-lowongan.index');

    Route::get('/manajemen-lowongan', [ManajemenLowonganController::class, 'manajemenLowongan'])->name('admin.manajemen-lowongan');

    Route::get('/tambah-lowongan', [ManajemenLowonganController::class, 'create'])->name('tambah-lowongan.create');
    Route::middleware(['auth'])->group(function () {
        Route::post('/lowongan', [ManajemenLowonganController::class, 'store'])->name('admin.store-lowongan');
    });

    Route::get('/manajemen-lowongan', [ManajemenLowonganController::class, 'index'])
        ->name('admin.manajemen-lowongan');

    Route::get('/detail-lowongan/{slug}', [ManajemenLowonganController::class, 'detail'])
        ->name('admin.detail-lowongan');

    Route::delete('/{slug}/destroy-lowongan', [ManajemenLowonganController::class, 'destroy'])
        ->name('admin.destroy-lowongan');

    Route::get('/edit-lowongan/{slug}', [ManajemenLowonganController::class, 'edit'])->name('admin.edit-lowongan');
    Route::put('/update-lowongan/{slug}', [ManajemenLowonganController::class, 'update'])->name('admin.update-lowongan');

    Route::get('/verifikasi/employer', [AdminController::class, 'verifikasiEmployer'])->name('admin.verifikasi-employer');
    Route::get('/verifikasi/employee', [AdminController::class, 'verifikasiEmployee'])->name('admin.verifikasi-employee');

    Route::delete('/verifikasi/{id}', [AdminController::class, 'destroy'])->name('admin.verifikasi.destroy');
    Route::delete('/verifikasi/{id}', [AdminController::class, 'destroy'])->name('admin.verifikasi.destroy');

    Route::get('/employer/create', [AdminController::class, 'create'])->name('admin.employer.create');

    // ===================
    // Event
    // ===================
    Route::post('/event/store', [ManajemenEventController::class, 'store'])->name('admin.event.store');
    Route::get('/event', [ManajemenEventController::class, 'manajemenevent'])->name('admin.manajemenevent');
    Route::get('/event/create', [ManajemenEventController::class, 'create'])->name('admin.event.create');
    Route::get('/event/{id}/detail', [ManajemenEventController::class, 'detailEvent'])->name('admin.event.detail');
    Route::get('/event/{id}/edit', [ManajemenEventController::class, 'editEvent'])->name('admin.event.edit');
    Route::put('/event/{id}', [ManajemenEventController::class, 'update'])->name('admin.event.update');
    Route::delete('/event/{id}', [ManajemenEventController::class, 'destroy'])->name('admin.event.destroy');
});