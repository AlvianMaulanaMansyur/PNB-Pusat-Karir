<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
