<?php


use App\Http\Controllers\Teacher\AssignmentController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\ClassController;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\MarkController;
use Illuminate\Support\Facades\Route;

Route::prefix('teacher')->name('teacher.')->middleware(['auth', 'verified','role:teacher'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('assignments', AssignmentController::class);
    Route::get('assignments/{assignment}/grade', [AssignmentController::class, 'grade'])->name('assignments.grade');
    Route::post('assignments/{assignment}/grade', [AssignmentController::class, 'updateGrades'])->name('assignments.updateGrades');
    Route::resource('classes', ClassController::class)->only(['index', 'show']);
    Route::resource('marks', MarkController::class);
    Route::get('marks/assessment/{assessment}', [MarkController::class, 'create'])->name('marks.create');
    Route::post('marks/assessment/{assessment}', [MarkController::class, 'store'])->name('marks.store');
    Route::get('marks/assessment/{assessment}/edit', [MarkController::class, 'edit'])->name('marks.edit');
    Route::resource('attendance', AttendanceController::class)->only(['index']);
    Route::get('attendance/{class}/mark', [AttendanceController::class, 'mark'])->name('attendance.mark');
    Route::post('attendance/{class}/store', [AttendanceController::class, 'store'])->name('attendance.store');
});
