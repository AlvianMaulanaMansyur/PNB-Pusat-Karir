<?php
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::resource('resumes', ResumeController::class);
    Route::post('/resumes/store-from-profile', [ResumeController::class, 'storeFromProfile'])
    ->name('resumes.storeFromProfile');
    Route::get('/resumes/{resume:slug}/export/json', [ResumeController::class, 'exportJson'])->name('resumes.export.json');
    Route::get('/resumes/{resume:slug}/export/pdf', [ResumeController::class, 'exportPdf'])->name('resumes.export.pdf');
    Route::get('/resumes/{resume:slug}/view/pdf', [ResumeController::class, 'showPdf'])->name('resumes.view.pdf');
});