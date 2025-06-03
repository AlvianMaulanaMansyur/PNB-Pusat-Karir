<?php

use App\Http\Controllers\Jobseeker\JobSeekerController;
use Illuminate\Support\Facades\Route;



Route::get('/', [JobSeekerController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('employee.landing-page');
?>

