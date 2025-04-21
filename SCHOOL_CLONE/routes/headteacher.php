<?php

use App\Http\Controllers\Headteacher\HeadteacherController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:headteacher'])
    ->prefix('headteacher')
    ->name('headteacher.')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [HeadteacherController::class, 'dashboard'])->name('dashboard');
        
        
        // Staff Management
        Route::prefix('staff')->name('staff.')->group(function () {
            // DOS Routes
            Route::get('/dos', [HeadteacherController::class, 'dosIndex'])->name('dos');
            Route::post('/dos/register', [HeadteacherController::class, 'registerDos'])->name('register.dos');
            Route::get('/dos/{deanOfStudent}/edit', [HeadteacherController::class, 'editDos'])->name('edit.dos');
            Route::put('/dos/{deanOfStudent}', [HeadteacherController::class, 'updateDos'])->name('update.dos');
            Route::delete('/dos/{deanOfStudent}', [HeadteacherController::class, 'deleteDos'])->name('delete.dos');
            Route::post('/dos/promote', [HeadteacherController::class, 'promoteToDos'])->name('promote.dos');
            Route::delete('/dos/{teacher}/demote', [HeadteacherController::class, 'demoteDos'])->name('demote.dos');
            
            // Bursar Routes
            Route::get('/bursars', [HeadteacherController::class, 'bursarsIndex'])->name('bursars');
            Route::post('/bursars/register', [HeadteacherController::class, 'registerBursar'])->name('register.bursar');
            Route::get('/bursars/{bursar}/edit', [HeadteacherController::class, 'editBursar'])->name('edit.bursar');
            Route::put('/bursars/{bursar}', [HeadteacherController::class, 'updateBursar'])->name('update.bursar');
            Route::delete('/bursars/{bursar}', [HeadteacherController::class, 'deleteBursar'])->name('delete.bursar');
        });

        // Circulars/Announcements
        Route::prefix('announcements')->name('announcements.')->group(function () {
            Route::get('/', [HeadteacherController::class, 'announcementsIndex'])->name('index');
            Route::post('/upload', [HeadteacherController::class, 'uploadCircular'])->name('upload');
            Route::delete('/{announcement}', [HeadteacherController::class, 'deleteAnnouncement'])->name('delete');
        });

        // Report Management
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [HeadteacherController::class, 'viewStaffReports'])->name('index');
            Route::get('/{report}', [HeadteacherController::class, 'showReport'])->name('show');
            Route::post('/{report}/comment', [HeadteacherController::class, 'commentOnReport'])->name('comment');
            Route::get('/performance', [HeadteacherController::class, 'generateStaffPerformanceReport'])->name('performance');
        });

        // School Calendar Management
        Route::prefix('events')->name('events.')->group(function () {
            Route::get('/', [HeadteacherController::class, 'manageSchoolEvents'])->name('index');
            Route::get('/{event}/show',[HeadteacherController::class,'showEvent'])->name('show');
            Route::post('/', [HeadteacherController::class, 'storeEvent'])->name('store');
            Route::post('/{event}/approve', [HeadteacherController::class, 'approveSchoolEvent'])->name('approve');
        });
    });