<?php

use App\Http\Controllers\CvController;
use App\Http\Controllers\CvGeneratorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AdminauthController;
use App\Http\Controllers\DetailAkunController;
use App\Http\Controllers\ManajemenLowonganController;
use App\Http\Controllers\TambahLowonganController;

Route::get('/admin/login', [AdminauthController::class, 'showLoginForm'])->name('admin.adminLogin');
Route::post('/admin/login', [AdminauthController::class, 'login'])->name('admin.login.submit');

Route::get('/admin/detail-akun/{id}', [DetailAkunController::class, 'show'])->name('detail-akun.show');

Route::get('/admin/manajemen-lowongan', [ManajemenLowonganController::class, 'index'])->name('manajemen-lowongan.index');

Route::get('/admin/tambah-lowongan', [TambahLowonganController::class, 'create'])->name('tambah-lowongan.create');

// Route::middleware('auth')->group(function () {
//     Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
// });


Route::get('/dashboard', function () {
    return view('layouts.jobseeker');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
