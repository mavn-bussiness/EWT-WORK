<?php

use App\Http\Controllers\Bursar\BursarController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:bursar'])->prefix('bursar')->name('bursar.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [BursarController::class, 'dashboard'])->name('dashboard');
    Route::get('/refresh-dashboard', [BursarController::class, 'refreshDashboard'])->name('refresh.dashboard');
    Route::get('/financial-data', [BursarController::class, 'getFinancialData'])->name('financial.data');

    // Fee Management
    Route::get('/fees', [BursarController::class, 'feeIndex'])->name('fees.index');
    Route::post('/fees/payment', [BursarController::class, 'processPayment'])->name('fees.payment');
    Route::get('/fees/arrears', [BursarController::class, 'feeArrears'])->name('fees.arrears');
    Route::get('/fees/reminders', [BursarController::class, 'feeReminders'])->name('fees.reminders');

    // Fee Structure Management
    Route::get('/fees/structures', [BursarController::class, 'feeStructureIndex'])->name('fees.structure');
    Route::get('/fees/structures/create', [BursarController::class, 'createFeeStructure'])->name('fees.structure.create');
    Route::post('/fees/structures', [BursarController::class, 'storeFeeStructure'])->name('fees.structure.store');
    Route::get('/fees/structures/{feeStructure}/edit', [BursarController::class, 'editFeeStructure'])->name('fees.structure.edit');
    Route::put('/fees/structures/{feeStructure}', [BursarController::class, 'updateFeeStructure'])->name('fees.structure.update');
    Route::delete('/fees/structures/{feeStructure}', [BursarController::class, 'destroyFeeStructure'])->name('fees.structure.destroy');

    // Budget Management
    Route::get('/budgets', [BursarController::class, 'budgetIndex'])->name('budgets.index');
    Route::get('/budgets/create', [BursarController::class, 'createBudget'])->name('budgets.create');
    Route::post('/budgets', [BursarController::class, 'storeBudget'])->name('budgets.store');
    Route::get('/budgets/{budget}/edit', [BursarController::class, 'editBudget'])->name('budgets.edit');
    Route::put('/budgets/{budget}', [BursarController::class, 'updateBudget'])->name('budgets.update');
    Route::delete('/budgets/{budget}', [BursarController::class, 'destroyBudget'])->name('budgets.destroy');

    // Expense Management
    Route::get('/expenses', [BursarController::class, 'expenseIndex'])->name('expenses.index');
    Route::get('/expenses/pending', [BursarController::class, 'pendingExpenses'])->name('expenses.pending');
    Route::get('/expenses/create', [BursarController::class, 'createExpense'])->name('expenses.create');
    Route::post('/expenses', [BursarController::class, 'storeExpense'])->name('expenses.store');
    Route::get('/expenses/{expense}', [BursarController::class, 'showExpense'])->name('expenses.show');
    Route::post('/expenses/{expense}/approve', [BursarController::class, 'approveExpense'])->name('expenses.approve');
    Route::post('/expenses/{expense}/reject', [BursarController::class, 'rejectExpense'])->name('expenses.reject');

    // Salary Management
    Route::get('/salaries', [BursarController::class, 'salaryIndex'])->name('salaries.index');
    Route::post('/salaries', [BursarController::class, 'processSalary'])->name('salaries.process');

    // Transaction Management
    Route::get('/transactions', [BursarController::class, 'transactionIndex'])->name('transactions.index');
    Route::get('/transactions/create', [BursarController::class, 'createTransaction'])->name('transactions.create');
    Route::post('/transactions', [BursarController::class, 'storeTransaction'])->name('transactions.store');
    Route::get('/records/pending', [BursarController::class, 'pendingRecords'])->name('records.pending');

    // Report Management
    Route::get('/reports', [BursarController::class, 'financialReports'])->name('reports.index');
    Route::get('/reports/generate', [BursarController::class, 'generateReport'])->name('reports.generate');
    Route::get('/reports/fees', [BursarController::class, 'generateFeeReport'])->name('reports.fees');
    Route::get('/reports/expenses', [BursarController::class, 'generateExpenseReport'])->name('reports.expenses');
    Route::get('/reports/{report}', [BursarController::class, 'viewReport'])->name('reports.view');
    Route::get('/reports/{report}/download', [BursarController::class, 'downloadReport'])->name('reports.download');

    // Payment Management
    Route::get('/payments', [BursarController::class, 'paymentIndex'])->name('payments.index');
    Route::get('/payments/today', [BursarController::class, 'paymentsToday'])->name('payments.today');
    Route::get('/payments/{payment}/receipt', [BursarController::class, 'paymentReceipt'])->name('payments.receipt');

    // Student Management
    Route::get('/students', [BursarController::class, 'studentIndex'])->name('students.index');
    Route::get('/students/fee-lookup', [BursarController::class, 'studentFeeLookup'])->name('students.fee-lookup');
    Route::get('/students/{student}/fees', [BursarController::class, 'getStudentFees'])->name('students.fees');

    // Cash Management
    Route::get('/cash/summary', [BursarController::class, 'cashSummary'])->name('cash.summary');
    Route::post('/cash/endday', [BursarController::class, 'endDayProcessing'])->name('cash.endday');

    // Task Management
    Route::get('/tasks', [BursarController::class, 'taskIndex'])->name('tasks.index');
    Route::post('/tasks/{task}/toggle', [BursarController::class, 'toggleTask'])->name('tasks.toggle');
});
