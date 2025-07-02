<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [  AdminAuthController::class, 'showLoginForm'])->name('admin.adminLogin');
Route::post('/admin/login', [ AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::get('/admin/dashboard', [ AdminDashboardController::class, 'AdminDashboard'])->name('adminDashboard');
