<?php

use App\Http\Controllers\Bursar\BursarController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:bursar'])->prefix('bursar')->name('bursar.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [BursarController::class, 'dashboard'])->name('dashboard');

    // Fee Management
    Route::get('/fees', [BursarController::class, 'feeIndex'])->name('fees.index');
    Route::post('/fees/payment', [BursarController::class, 'processPayment'])->name('fees.payment');

    // Expense Management
    Route::get('/expenses', [BursarController::class, 'expenseIndex'])->name('expenses.index');
    Route::get('/expenses/create', [BursarController::class, 'createExpense'])->name('expenses.create');
    Route::post('/expenses', [BursarController::class, 'storeExpense'])->name('expenses.store');
    Route::post('/expenses/{expense}/approve', [BursarController::class, 'approveExpense'])->name('expenses.approve');

    // Salary Management
    Route::get('/salaries', [BursarController::class, 'salaryIndex'])->name('salaries.index');
    Route::post('/salaries', [BursarController::class, 'processSalary'])->name('salaries.process');

    // Reports
    Route::get('/reports', [BursarController::class, 'financialReports'])->name('reports.index');
    Route::get('/reports/fees', [BursarController::class, 'generateFeeReport'])->name('reports.fees');
    Route::get('/reports/expenses', [BursarController::class, 'generateExpenseReport'])->name('reports.expenses');
});