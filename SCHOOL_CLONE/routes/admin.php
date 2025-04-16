<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users Management
    Route::get('/users', [AdminController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [AdminController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{id}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    
    // Events Management
    Route::get('/events', [AdminController::class, 'eventIndex'])->name('events.index');
    Route::get('/events/create', [AdminController::class, 'eventCreate'])->name('events.create');
    Route::post('/events', [AdminController::class, 'eventStore'])->name('events.store');
    Route::get('/events/{id}', [AdminController::class, 'eventShow'])->name('events.show');
    Route::get('/events/{id}/edit', [AdminController::class, 'eventEdit'])->name('events.edit');
    Route::patch('/events/{id}', [AdminController::class, 'eventUpdate'])->name('events.update');
    Route::delete('/events/{id}', [AdminController::class, 'eventDestroy'])->name('events.delete');
});