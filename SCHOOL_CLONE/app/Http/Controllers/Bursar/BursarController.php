<?php

namespace App\Http\Controllers\Bursar;

use App\Http\Controllers\Controller;
use App\Models\{
    Fee, Payment, Student, FeeStructure, Expense, Budget,
    BudgetItem, Account, FinancialTransaction, SalaryPayment,
    FeeArrear, FeeReminder, Scholarship, User, Term, FinancialReport
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BursarController extends Controller
{
//

    // Dashboard methods
    public function dashboard(Request $request)
    {
        $userRole = Auth::user()->bursar->role;

        switch ($userRole) {
            case 'chief_bursar':
                return $this->chiefBursarDashboard($request);
            case 'assistant_bursar':
                return $this->assistantBursarDashboard();
            case 'accounts_clerk':
                return $this->accountsClerkDashboard($request);
            case 'cashier':
                return $this->cashierDashboard();
            default:
                abort(403, 'Unauthorized access');
        }
    }

    protected function chiefBursarDashboard(Request $request)
    {
        $period = $request->query('period', 'year');
        $currency = config('app.currency', 'UGX');

        $stats = [
            'total_collected' => Payment::whereBetween('created_at', [now()->startOfMonth(), now()])->sum('amount'),
            'total_expenses' => Expense::where('status', 'approved')
                ->whereBetween('expense_date', [now()->startOfMonth(), now()])
                ->sum('amount'),
            'pending_approvals' => Expense::where('status', 'pending')->count(),
            'fee_arrears' => Fee::where('status', '!=', 'paid')
                ->sum(DB::raw('total_amount - paid_amount')),
        ];

        $pendingExpenses = Expense::with(['account'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $latestReports = FinancialReport::with('generatedBy')
            ->latest()
            ->take(5)
            ->get();

        $budgetVsActual = BudgetItem::with('budget')
            ->whereHas('budget', function($q) {
                $q->where('is_approved', true)
                    ->when(Term::current(), function($query, $currentTerm) {
                        $query->where('term_id', $currentTerm->id);
                    }, function($query) {
                        $query->where('term_id', Term::latest()->first()->id ?? null);
                    });
            })
            ->get()
            ->map(function($item) {
                $used = $item->used_amount;
                $budgeted = $item->allocated_amount;
                return [
                    'category' => $item->name,
                    'budgeted' => $budgeted,
                    'actual' => $used,
                    'variance' => $budgeted - $used,
                    'percentage' => ($budgeted > 0) ? ($used / $budgeted * 100) : 0
                ];
            });

        $financialOverviewData = $this->getFinancialOverviewData($period);
        $expensesPieData = $this->getExpensesByCategoryData();

        return view('bursar.chief_bursar_dashboard', compact(
            'stats', 'pendingExpenses', 'latestReports', 'budgetVsActual',
            'financialOverviewData', 'expensesPieData', 'period', 'currency'
        ));
    }

    protected function assistantBursarDashboard()
    {
        $stats = [
            'today_collection' => Payment::whereDate('payment_date', today())->sum('amount'),
            'pending_expenses' => Expense::where('status', 'pending')->count(),
            'fee_reminders' => FeeReminder::whereDate('reminder_date', today())->count(),
            'overdue_fees' => FeeArrear::where('is_cleared', false)->sum('amount'),
        ];

        $recentPayments = Payment::with(['fee.student.user'])
            ->whereDate('payment_date', today())
            ->latest()
            ->take(5)
            ->get();

        $pendingExpenses = Expense::with(['account'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $students = Student::with('user')->active()->get();
        $accounts = Account::active()->get();
        $budgetItems = BudgetItem::with('budget')->get();
        $tasks = Auth::user()->tasks()->incomplete()->orderBy('due_date')->get();

        return view('bursar.dashboard.assistant_bursar', compact(
            'stats', 'recentPayments', 'pendingExpenses', 'students',
            'accounts', 'budgetItems', 'tasks'
        ));
    }

    protected function accountsClerkDashboard(Request $request)
    {
        $term_id = $request->query('term_id', Term::current()->id ?? null);

        $stats = [
            'total_transactions' => FinancialTransaction::count(),
            'daily_collection' => Payment::whereDate('payment_date', today())->sum('amount'),
            'pending_records' => FinancialTransaction::where('is_approved', false)->count(),
            'reports_count' => FinancialReport::count(),
        ];

        $recentTransactions = FinancialTransaction::with(['account'])
            ->latest()
            ->take(10)
            ->get();

        $classRecords = Student::selectRaw('
                class_level as class_name,
                COUNT(*) as total_students,
                SUM(fee_structures.total_amount) as expected_amount,
                SUM(fees.paid_amount) as collected_amount,
                SUM(fee_structures.total_amount - fees.paid_amount) as outstanding_amount,
                (SUM(fees.paid_amount) / SUM(fee_structures.total_amount) * 100) as collection_rate
            ')
            ->leftJoin('fees', 'students.id', '=', 'fees.student_id')
            ->leftJoin('fee_structures', function($join) use ($term_id) {
                $join->on('fees.fee_structure_id', '=', 'fee_structures.id')
                    ->where('fee_structures.term_id', $term_id);
            })
            ->groupBy('class_level')
            ->get();

        $terms = Term::orderBy('start_date', 'desc')->get();
        $currentTerm = Term::find($term_id) ?? Term::current();
        $notifications = Auth::user()->notifications()->unread()->latest()->take(5)->get();

        return view('bursar.dashboard.accounts_clerk', compact(
            'stats', 'recentTransactions', 'classRecords', 'terms',
            'currentTerm', 'notifications'
        ));
    }

    protected function cashierDashboard()
    {
        $stats = [
            'today_collection' => Payment::whereDate('payment_date', today())->sum('amount'),
            'receipts_count' => Payment::whereDate('payment_date', today())->count(),
            'students_served' => Payment::whereDate('payment_date', today())
                ->distinct('fee_id')
                ->count('fee_id'),
            'cash_in_hand' => $this->calculateCashInHand(),
        ];

        $recentPayments = Payment::with(['fee.student.user'])
            ->whereDate('payment_date', today())
            ->latest()
            ->take(5)
            ->get();

        $students = Student::with('user')->active()->get();
        $feeStructures = FeeStructure::where('term_id', Term::current()->id ?? null)
            ->get()
            ->groupBy('class_level');

        $cashSummary = $this->getDailyCashSummary();
        $nextReceiptNumber = 'RC-' . strtoupper(uniqid());

        return view('bursar.dashboard.cashier', compact(
            'stats', 'recentPayments', 'students', 'feeStructures',
            'cashSummary', 'nextReceiptNumber'
        ));
    }

    // Fee Management
    public function feeIndex(Request $request)
    {
        $status = $request->query('status');
        $fees = Fee::with(['student.user', 'term'])
            ->when($status === 'overdue', function($query) {
                $query->where('status', '!=', 'paid')
                    ->whereHas('arrears', function($q) {
                        $q->where('is_cleared', false);
                    });
            })
            ->latest()
            ->paginate(15);

        $feeStructures = FeeStructure::with('term')
            ->orderBy('term_id', 'desc')
            ->get()
            ->groupBy('class_level');

        $students = Student::with('user')->active()->get();
        $terms = Term::orderBy('start_date', 'desc')->get();

        return view('bursar.fees.index', compact(
            'fees', 'feeStructures', 'students', 'terms'
        ));
    }

    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'fee_id' => 'required|exists:fees,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money',
            'transaction_id' => 'nullable|string|max:100',
            'receipt_number' => 'required|string|max:50',
            'notes' => 'nullable|string|max:255'
        ]);

        $fee = Fee::findOrFail($validated['fee_id']);

        DB::transaction(function() use ($validated, $fee) {
            $payment = new Payment();
            $payment->fee_id = $fee->id;
            $payment->amount = $validated['amount'];
            $payment->payment_method = $validated['payment_method'];
            $payment->transaction_id = $validated['transaction_id'] ?? null;
            $payment->receipt_number = $validated['receipt_number'];
            $payment->received_by = Auth::id();
            $payment->payment_date = now();
            $payment->notes = $validated['notes'] ?? null;
            $payment->save();

            $fee->paid_amount += $validated['amount'];
            $fee->status = $fee->paid_amount >= $fee->total_amount ? 'paid' : ($fee->paid_amount > 0 ? 'partial' : 'unpaid');
            $fee->save();

            $transaction = new FinancialTransaction();
            $transaction->account_id = Account::where('account_type', 'bank')->first()->id;
            $transaction->amount = $validated['amount'];
            $transaction->type = 'income';
            $transaction->reference_number = $payment->receipt_number;
            $transaction->transaction_category = 'fees';
            $transaction->description = 'Fee payment for ' . $fee->student->user->name;
            $transaction->transaction_date = now();
            $transaction->recorded_by = Auth::id();
            $transaction->is_approved = true;
            $transaction->save();
        });

        return redirect()->route('bursar.fees.index')
            ->with('success', 'Payment of ' . number_format($validated['amount'], 2) . ' processed successfully.');
    }

    public function feeArrears()
    {
        $arrears = FeeArrear::with(['student.user', 'term'])
            ->where('is_cleared', false)
            ->latest()
            ->paginate(15);

        return view('bursar.fees.arrears', compact('arrears'));
    }

    public function feeReminders()
    {
        $reminders = FeeReminder::with(['student.user', 'term'])
            ->whereDate('reminder_date', today())
            ->latest()
            ->paginate(15);

        return view('bursar.fees.reminders', compact('reminders'));
    }

    // Fee Structure Management
    public function feeStructureIndex()
    {
        $feeStructures = FeeStructure::with('term')
            ->orderBy('term_id', 'desc')
            ->get()
            ->groupBy('class_level');

        $terms = Term::orderBy('start_date', 'desc')->get();
        $currency = config('app.currency', 'UGX');

        return view('bursar.fees.structure', compact('feeStructures', 'terms','currency'));
    }

    public function createFeeStructure()
    {
        $terms = Term::orderBy('start_date', 'desc')->get();
        $currency = config('app.currency', 'UGX');
        return view('bursar.fees.structure_create', compact('terms','currency'));
    }

    public function storeFeeStructure(Request $request)
    {
        $validated = $request->validate([
            'term_id' => 'required|exists:terms,id',
            'class_level' => 'required|string|max:50',
            'tuition' => 'required|numeric|min:0',
            'boarding' => 'nullable|numeric|min:0',
            'development' => 'nullable|numeric|min:0',
        ]);

        $total_amount = $validated['tuition'] + ($validated['boarding'] ?? 0) + ($validated['development'] ?? 0);

        FeeStructure::create(array_merge($validated, ['total_amount' => $total_amount]));

        return redirect()->route('bursar.fees.structure')
            ->with('success', 'Fee structure created successfully.');
    }

    public function editFeeStructure(FeeStructure $feeStructure)
    {
        $terms = Term::orderBy('start_date', 'desc')->get();
        return view('bursar.fees.structure_edit', compact('feeStructure', 'terms'));
    }

    public function updateFeeStructure(Request $request, FeeStructure $feeStructure)
    {
        $validated = $request->validate([
            'term_id' => 'required|exists:terms,id',
            'class_level' => 'required|string|max:50',
            'tuition' => 'required|numeric|min:0',
            'boarding' => 'nullable|numeric|min:0',
            'development' => 'nullable|numeric|min:0',
        ]);

        $total_amount = $validated['tuition'] + ($validated['boarding'] ?? 0) + ($validated['development'] ?? 0);

        $feeStructure->update(array_merge($validated, ['total_amount' => $total_amount]));

        return redirect()->route('bursar.fees.structure')
            ->with('success', 'Fee structure updated successfully.');
    }

    public function destroyFeeStructure(FeeStructure $feeStructure)
    {
        $feeStructure->delete();
        return redirect()->route('bursar.fees.structure')
            ->with('success', 'Fee structure deleted successfully.');
    }

    // Budget Management
    public function budgetIndex()
    {
        $budgets = Budget::with('term')->latest()->paginate(15);
        return view('bursar.budgets.index', compact('budgets'));
    }

    public function createBudget()
    {
        $terms = Term::orderBy('start_date', 'desc')->get();
        $accounts = Account::active()->get();
        $currency = config('app.currency', 'UGX');
        return view('bursar.budgets.create', compact('terms', 'accounts','currency'));
    }

    public function storeBudget(Request $request)
    {
        $validated = $request->validate([
            'term_id' => 'required|exists:terms,id',
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'items' => 'required|array',
            'items.*.name' => 'required|string|max:100',
            'items.*.allocated_amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function() use ($validated) {
            $budget = Budget::create([
                'term_id' => $validated['term_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'created_by' => Auth::id(),
            ]);

            foreach ($validated['items'] as $item) {
                BudgetItem::create([
                    'budget_id' => $budget->id,
                    'name' => $item['name'],
                    'allocated_amount' => $item['allocated_amount'],
                    'used_amount' => 0,
                ]);
            }
        });

        return redirect()->route('bursar.budgets.index')
            ->with('success', 'Budget created successfully.');
    }

    public function editBudget(Budget $budget)
    {
        $terms = Term::orderBy('start_date', 'desc')->get();
        $accounts = Account::active()->get();
        $budget->load('items');
        return view('bursar.budgets.edit', compact('budget', 'terms', 'accounts'));
    }

    public function updateBudget(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'term_id' => 'required|exists:terms,id',
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'items' => 'required|array',
            'items.*.id' => 'nullable|exists:budget_items,id',
            'items.*.name' => 'required|string|max:100',
            'items.*.allocated_amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function() use ($validated, $budget) {
            $budget->update([
                'term_id' => $validated['term_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
            ]);

            $existingIds = collect($validated['items'])->pluck('id')->filter();
            $budget->items()->whereNotIn('id', $existingIds)->delete();

            foreach ($validated['items'] as $item) {
                if (isset($item['id'])) {
                    BudgetItem::where('id', $item['id'])->update([
                        'name' => $item['name'],
                        'allocated_amount' => $item['allocated_amount'],
                    ]);
                } else {
                    BudgetItem::create([
                        'budget_id' => $budget->id,
                        'name' => $item['name'],
                        'allocated_amount' => $item['allocated_amount'],
                        'used_amount' => 0,
                    ]);
                }
            }
        });

        return redirect()->route('bursar.budgets.index')
            ->with('success', 'Budget updated successfully.');
    }

    public function destroyBudget(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('bursar.budgets.index')
            ->with('success', 'Budget deleted successfully.');
    }

    // Expense Management
    public function expenseIndex(Request $request)
    {
        $userRole = Auth::user()->bursar->role;
        $userId = Auth::id();
        $status = $request->query('status');

        $expenses = Expense::with(['account', 'budgetItem', 'recordedBy', 'approvedBy'])
            ->when($status === 'pending', function($query) {
                $query->where('status', 'pending');
            })
            ->when($userRole != 'chief_bursar', function($query) use ($userId) {
                return $query->where('recorded_by', $userId)
                    ->orWhere('approved_by', $userId);
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total_expenses' => Expense::where('status', 'approved')->sum('amount'),
            'pending_expenses' => Expense::where('status', 'pending')->count(),
            'today_expenses' => Expense::whereDate('expense_date', today())->sum('amount'),
            'rejected_expenses' => Expense::where('status', 'rejected')->count()
        ];

        return view('bursar.expenses.index', compact('expenses', 'stats'));
    }

    public function pendingExpenses()
    {
        $currency = config('app.currency', 'UGX');
        $expenses = Expense::with(['account', 'recordedBy'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('bursar.expenses.pending', compact('expenses','currency'));
    }

    public function createExpense()
    {
        $accounts = Account::active()->get();
        $budgetItems = BudgetItem::whereHas('budget', function($query) {
            $query->where('is_approved', true);
        })->get();

        return view('bursar.expenses.create', compact('accounts', 'budgetItems'));
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'budget_item_id' => 'nullable|exists:budget_items,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'category' => 'required|string',
            'payee' => 'required|string|max:100',
            'expense_date' => 'required|date',
            'description' => 'required|string',
            'receipt_number' => 'nullable|string|max:50',
            'has_receipt' => 'boolean'
        ]);

        $expense = new Expense();
        $expense->fill($validated);
        $expense->expense_number = 'EXP-' . strtoupper(uniqid());
        $expense->recorded_by = Auth::id();
        $expense->status = Auth::user()->bursar->can_approve_expenses ? 'approved' : 'pending';

        if (Auth::user()->bursar->can_approve_expenses) {
            $expense->approved_by = Auth::id();
        }

        $expense->save();

        if ($expense->status === 'approved' && $expense->budget_item_id) {
            $budgetItem = BudgetItem::find($expense->budget_item_id);
            $budgetItem->used_amount += $expense->amount;
            $budgetItem->save();
        }

        return redirect()->route('bursar.expenses.index')
            ->with('success', 'Expense recorded successfully.');
    }

    public function showExpense(Expense $expense)
    {
        $expense->load(['account', 'budgetItem', 'recordedBy', 'approvedBy']);
        return view('bursar.expenses.show', compact('expense'));
    }

    public function approveExpense(Request $request, Expense $expense)
    {
        if ($expense->status !== 'pending') {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Expense is already ' . $expense->status . '.'], 400)
                : redirect()->route('bursar.expenses.index')->with('error', 'Expense is already ' . $expense->status . '.');
        }

        if (!Auth::user()->bursar->can_approve_expenses) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'You do not have permission to approve expenses.'], 403)
                : redirect()->route('bursar.expenses.index')->with('error', 'You do not have permission to approve expenses.');
        }

        if ($expense->recorded_by == Auth::id()) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'You cannot approve your own expenses.'], 403)
                : redirect()->route('bursar.expenses.index')->with('error', 'You cannot approve your own expenses.');
        }

        $expense->status = 'approved';
        $expense->approved_by = Auth::id();
        $expense->save();

        if ($expense->budget_item_id) {
            $budgetItem = BudgetItem::find($expense->budget_item_id);
            $budgetItem->used_amount += $expense->amount;
            $budgetItem->save();
        }

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => 'Expense approved successfully.'])
            : redirect()->route('bursar.expenses.index')->with('success', 'Expense approved successfully.');
    }

    public function rejectExpense(Request $request, Expense $expense)
    {
        if ($expense->status !== 'pending') {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Expense is already ' . $expense->status . '.'], 400)
                : redirect()->route('bursar.expenses.index')->with('error', 'Expense is already ' . $expense->status . '.');
        }

        if (!Auth::user()->bursar->can_approve_expenses) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'You do not have permission to reject expenses.'], 403)
                : redirect()->route('bursar.expenses.index')->with('error', 'You do not have permission to reject expenses.');
        }

        if ($expense->recorded_by == Auth::id()) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'You cannot reject your own expenses.'], 403)
                : redirect()->route('bursar.expenses.index')->with('error', 'You cannot reject your own expenses.');
        }

        $expense->status = 'rejected';
        $expense->approved_by = Auth::id();
        $expense->save();

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => 'Expense rejected successfully.'])
            : redirect()->route('bursar.expenses.index')->with('success', 'Expense rejected successfully.');
    }

    // Salary Management
    public function salaryIndex()
    {
        $currentMonth = now()->format('F Y');

        $salaryPayments = SalaryPayment::with(['user', 'processedBy'])
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->latest()
            ->paginate(15);

        $staffUsers = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['teacher', 'bursar', 'admin', 'staff']);
        })->get();

        $stats = [
            'total_paid' => SalaryPayment::whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('net_amount'),
            'total_staff' => $staffUsers->count(),
            'paid_staff' => SalaryPayment::whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->distinct('user_id')
                ->count(),
            'pending_staff' => $staffUsers->count() - SalaryPayment::whereMonth('payment_date', now()->month)
                    ->whereYear('payment_date', now()->year)
                    ->distinct('user_id')
                    ->count()
        ];

        return view('bursar.salaries.index', compact('salaryPayments', 'staffUsers', 'currentMonth', 'stats'));
    }

    public function processSalary(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'gross_amount' => 'required|numeric|min:0',
            'deductions' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'month_year' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $netAmount = $validated['gross_amount'] - $validated['deductions'];

        $existingPayment = SalaryPayment::where('user_id', $validated['user_id'])
            ->where('month_year', $validated['month_year'])
            ->first();

        if ($existingPayment) {
            return redirect()->route('bursar.salaries.index')
                ->with('error', 'Salary has already been processed for this staff member for ' . $validated['month_year']);
        }

        DB::transaction(function() use ($validated, $netAmount) {
            $payment = new SalaryPayment();
            $payment->user_id = $validated['user_id'];
            $payment->gross_amount = $validated['gross_amount'];
            $payment->deductions = $validated['deductions'];
            $payment->net_amount = $netAmount;
            $payment->payment_date = $validated['payment_date'];
            $payment->payment_method = $validated['payment_method'];
            $payment->transaction_id = 'SAL-' . strtoupper(uniqid());
            $payment->month_year = $validated['month_year'];
            $payment->notes = $validated['notes'];
            $payment->processed_by = Auth::id();
            $payment->save();

            $transaction = new FinancialTransaction();
            $transaction->account_id = Account::where('account_type', 'bank')->first()->id;
            $transaction->amount = $netAmount;
            $transaction->type = 'expense';
            $transaction->reference_number = $payment->transaction_id;
            $transaction->transaction_category = 'salary';
            $transaction->description = 'Salary payment for ' . User::find($validated['user_id'])->name . ' - ' . $validated['month_year'];
            $transaction->transaction_date = $validated['payment_date'];
            $transaction->recorded_by = Auth::id();
            $transaction->is_approved = true;
            $transaction->save();
        });

        return redirect()->route('bursar.salaries.index')
            ->with('success', 'Salary processed successfully.');
    }

    // Transaction Management
    public function transactionIndex()
    {
        $transactions = FinancialTransaction::with(['account', 'recordedBy'])
            ->latest()
            ->paginate(15);

        return view('bursar.transactions.index', compact('transactions'));
    }

    public function createTransaction()
    {
        $accounts = Account::active()->get();
        return view('bursar.transactions.create', compact('accounts'));
    }

    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:income,expense',
            'transaction_category' => 'required|string|max:50',
            'description' => 'required|string',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:50',
        ]);

        $transaction = new FinancialTransaction();
        $transaction->fill($validated);
        $transaction->reference_number = $validated['reference_number'] ?? 'TRN-' . strtoupper(uniqid());
        $transaction->recorded_by = Auth::id();
        $transaction->is_approved = Auth::user()->bursar->can_approve_expenses;
        $transaction->save();

        return redirect()->route('bursar.transactions.index')
            ->with('success', 'Transaction recorded successfully.');
    }

    public function pendingRecords()
    {
        $transactions = FinancialTransaction::with(['account', 'recordedBy'])
            ->where('is_approved', false)
            ->latest()
            ->paginate(15);

        return view('bursar.records.pending', compact('transactions'));
    }

    // Reports
    public function financialReports()
    {
        $reports = FinancialReport::with('generatedBy')->latest()->paginate(15);
        $reportTypes = ['income', 'expense', 'balance', 'summary', 'fees', 'salary', 'custom'];

        return view('bursar.reports.index', compact('reports', 'reportTypes'));
    }

    public function generateReport()
    {
        $terms = Term::orderBy('start_date', 'desc')->get();
        $reportTypes = ['income', 'expense', 'balance', 'summary', 'fees', 'salary', 'custom'];
        return view('bursar.reports.generate', compact('terms', 'reportTypes'));
    }


    public function generateFeeReport(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'term_id' => 'nullable|exists:terms,id',
            'class_level' => 'nullable|string'
        ]);

        $fees = Fee::with(['student.user', 'term'])
            ->whereBetween('created_at', [$validated['start_date'], $validated['end_date']])
            ->when($request->term_id, function($query) use ($request) {
                return $query->where('term_id', $request->term_id);
            })
            ->when($request->class_level, function($query) use ($request) {
                return $query->whereHas('student', function($q) use ($request) {
                    $q->where('class_level', $request->class_level);
                });
            })
            ->get();

        $totalBilled = $fees->sum('total_amount');
        $totalPaid = $fees->sum('paid_amount');
        $totalOutstanding = $totalBilled - $totalPaid;
        $collectionRate = $totalBilled > 0 ? ($totalPaid / $totalBilled * 100) : 0;

        $report = new FinancialReport();
        $report->report_name = 'Fee Report: ' . $validated['start_date'] . ' to ' . $validated['end_date'];
        $report->report_type = 'fees';
        $report->start_date = $validated['start_date'];
        $report->end_date = $validated['end_date'];
        $report->generated_by = Auth::id();
        $report->file_path = null;
        $report->save();

        $summary = [
            'total_billed' => $totalBilled,
            'total_paid' => $totalPaid,
            'total_outstanding' => $totalOutstanding,
            'collection_rate' => $collectionRate,
            'report_id' => $report->id,
            'start_date' => $validated['start_date'], // Added
            'end_date' => $validated['end_date'],     // Added
        ];

        return view('bursar.reports.fee-report', compact('fees', 'summary'));
    }

    public function generateExpenseReport(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'category' => 'nullable|string',
            'account_id' => 'nullable|exists:accounts,id'
        ]);

        $expenses = Expense::with(['account', 'budgetItem', 'recordedBy'])
            ->where('status', 'approved')
            ->whereBetween('expense_date', [$validated['start_date'], $validated['end_date']])
            ->when($request->category, function($query) use ($request) {
                return $query->where('category', $request->category);
            })
            ->when($request->account_id, function($query) use ($request) {
                return $query->where('account_id', $request->account_id);
            })
            ->get();

        $totalExpenses = $expenses->sum('amount');
        $categorySummary = $expenses->groupBy('category')
            ->map(function($items) {
                return [
                    'total' => $items->sum('amount'),
                    'count' => $items->count()
                ];
            });

        $report = new FinancialReport();
        $report->report_name = 'Expense Report: ' . $validated['start_date'] . ' to ' . $validated['end_date'];
        $report->report_type = 'expense';
        $report->start_date = $validated['start_date'];
        $report->end_date = $validated['end_date'];
        $report->generated_by = Auth::id();
        $report->file_path = null;
        $report->save();

        $summary = [
            'total_expenses' => $totalExpenses,
            'category_summary' => $categorySummary,
            'report_id' => $report->id,
            'start_date' => $validated['start_date'], // Added
            'end_date' => $validated['end_date'],     // Added
        ];

        return view('bursar.reports.expense_report', compact('expenses', 'summary'));
    }

    public function viewReport(FinancialReport $report)
    {
        $report->load('generatedBy');
        return view('bursar.reports.view', compact('report'));
    }

    public function downloadReport(FinancialReport $report)
    {
        if ($report->file_path && Storage::exists($report->file_path)) {
            return Storage::download($report->file_path);
        }
        return redirect()->route('bursar.reports.index')
            ->with('error', 'Report file not found.');
    }

    // Payment Management
    public function paymentIndex()
    {
        $payments = Payment::with(['fee.student.user', 'receivedBy'])
            ->latest()
            ->paginate(15);

        return view('bursar.payments.index', compact('payments'));
    }

    public function paymentsToday()
    {
        $payments = Payment::with(['fee.student.user', 'receivedBy'])
            ->whereDate('payment_date', today())
            ->latest()
            ->paginate(15);

        return view('bursar.payments.today', compact('payments'));
    }

    public function paymentReceipt(Payment $payment)
    {
        $payment->load(['fee.student.user', 'receivedBy']);
        return view('bursar.payments.receipt', compact('payment'));
    }

    // Student Management
    public function studentIndex()
    {
        $students = Student::with('user')->active()->paginate(15);
        return view('bursar.students.index', compact('students'));
    }

    public function studentFeeLookup(Request $request)
    {
        $validated = $request->validate([
            'admission_number' => 'required|string'
        ]);

        $student = Student::where('admission_number', $validated['admission_number'])
            ->with('user')
            ->firstOrFail();

        $feeDetails = Fee::with('term')
            ->where('student_id', $student->id)
            ->get();

        return view('bursar.students.fee_lookup', compact('student', 'feeDetails'));
    }

    public function getStudentFees(Student $student)
    {
        $fees = Fee::where('student_id', $student->id)
            ->with('term')
            ->get()
            ->map(function($fee) {
                return [
                    'id' => $fee->id,
                    'term' => $fee->term->name,
                    'total_amount' => $fee->total_amount,
                    'paid_amount' => $fee->paid_amount,
                    'balance' => $fee->total_amount - $fee->paid_amount,
                ];
            });

        return response()->json($fees);
    }

    // Cash Management
    public function cashSummary()
    {
        $cashSummary = $this->getDailyCashSummary();
        $stats = ['cash_in_hand' => $this->calculateCashInHand()];
        return view('bursar.cash.summary', compact('cashSummary', 'stats'));
    }

    public function endDayProcessing(Request $request)
    {
        $validated = $request->validate([
            'total_collected' => 'required|numeric|min:0',
            'cash_in_hand' => 'required|numeric|min:0',
            'bank_deposit' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        DB::transaction(function() use ($validated) {
            $cashAccount = Account::where('account_type', 'cash')->first();
            if (!$cashAccount) {
                throw new \Exception('No cash account found.');
            }

            $transaction = new FinancialTransaction();
            $transaction->account_id = Account::where('account_type', 'bank')->first()->id;
            $transaction->amount = $validated['bank_deposit'];
            $transaction->type = 'expense';
            $transaction->reference_number = 'DEP-' . strtoupper(uniqid());
            $transaction->transaction_category = 'bank_deposit';
            $transaction->description = 'End of day bank deposit';
            $transaction->transaction_date = now();
            $transaction->recorded_by = Auth::id();
            $transaction->is_approved = true;
            $transaction->save();

            $cashAccount->current_balance = $validated['cash_in_hand'] - $validated['bank_deposit'];
            $cashAccount->save();
        });

        return redirect()->route('bursar.dashboard')
            ->with('success', 'End of day processing completed successfully.');
    }

    // Task Management
    public function taskIndex()
    {
        $tasks = Auth::user()->tasks()->orderBy('due_date')->paginate(15);
        return view('bursar.tasks.index', compact('tasks'));
    }

    public function toggleTask(Request $request, $taskId)
    {
        $task = Auth::user()->tasks()->findOrFail($taskId);
        $task->is_completed = !$task->is_completed;
        $task->save();

        return redirect()->back()->with('success', 'Task status updated.');
    }

    // AJAX Endpoints
    public function getFinancialData(Request $request)
    {
        $period = $request->query('period', 'year');
        return response()->json($this->getFinancialOverviewData($period));
    }

    public function refreshDashboard()
    {
        $stats = [
            'total_collected' => Payment::whereBetween('created_at', [now()->startOfMonth(), now()])->sum('amount'),
            'total_expenses' => Expense::where('status', 'approved')
                ->whereBetween('expense_date', [now()->startOfMonth(), now()])
                ->sum('amount'),
            'pending_approvals' => Expense::where('status', 'pending')->count(),
            'fee_arrears' => Fee::where('status', '!=', 'paid')
                ->sum(DB::raw('total_amount - paid_amount')),
        ];

        $pendingExpenses = Expense::with(['account'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $latestReports = FinancialReport::with('generatedBy')
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'stats' => $stats,
            'pendingExpenses' => $pendingExpenses,
            'latestReports' => $latestReports,
        ]);
    }

    // Helper methods
    protected function getFinancialOverviewData($period = 'year')
    {
        $labels = [];
        $incomeData = [];
        $expenseData = [];

        if ($period === 'month') {
            for ($i = 3; $i >= 0; $i--) {
                $weekStart = now()->subWeeks($i)->startOfWeek();
                $weekEnd = $weekStart->copy()->endOfWeek();
                $labels[] = "Week " . (4 - $i);
                $incomeData[] = Payment::whereBetween('payment_date', [$weekStart, $weekEnd])->sum('amount');
                $expenseData[] = Expense::where('status', 'approved')
                    ->whereBetween('expense_date', [$weekStart, $weekEnd])
                    ->sum('amount');
            }
        } elseif ($period === 'quarter') {
            for ($i = 2; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $labels[] = $month->format('M');
                $incomeData[] = Payment::whereMonth('payment_date', $month->month)
                    ->whereYear('payment_date', $month->year)
                    ->sum('amount');
                $expenseData[] = Expense::where('status', 'approved')
                    ->whereMonth('expense_date', $month->month)
                    ->whereYear('expense_date', $month->year)
                    ->sum('amount');
            }
        } else {
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $labels[] = $month->format('M');
                $incomeData[] = Payment::whereMonth('payment_date', $month->month)
                    ->whereYear('payment_date', $month->year)
                    ->sum('amount');
                $expenseData[] = Expense::where('status', 'approved')
                    ->whereMonth('expense_date', $month->month)
                    ->whereYear('expense_date', $month->year)
                    ->sum('amount');
            }
        }

        return [
            'labels' => $labels,
            'income' => $incomeData,
            'expenses' => $expenseData
        ];
    }

    protected function getExpensesByCategoryData()
    {
        $expenses = Expense::where('status', 'approved')
            ->whereBetween('expense_date', [now()->startOfMonth(), now()])
            ->get()
            ->groupBy('category');

        $labels = [];
        $data = [];

        foreach ($expenses as $category => $items) {
            $labels[] = $category;
            $data[] = $items->sum('amount');
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    protected function calculateCashInHand()
    {
        $cashAccount = Account::where('account_type', 'cash')->first();
        $openingBalance = $cashAccount ? $cashAccount->current_balance : 0;

        $todayCollection = Payment::whereDate('payment_date', today())
            ->where('payment_method', 'cash')
            ->sum('amount');

        $todayExpenses = Expense::whereDate('expense_date', today())
            ->where('payment_method', 'cash')
            ->where('status', 'approved')
            ->sum('amount');

        return $openingBalance + $todayCollection - $todayExpenses;
    }

    protected function getDailyCashSummary()
    {
        $cashAccount = Account::where('account_type', 'cash')->first();
        $openingBalance = $cashAccount ? $cashAccount->current_balance : 0;

        return [
            'opening_balance' => $openingBalance,
            'cash_receipts' => Payment::whereDate('payment_date', today())
                ->where('payment_method', 'cash')
                ->sum('amount'),
            'other_income' => FinancialTransaction::whereDate('transaction_date', today())
                ->where('type', 'income')
                ->whereNotIn('transaction_category', ['fees'])
                ->sum('amount'),
            'petty_cash' => Expense::whereDate('expense_date', today())
                ->where('payment_method', 'cash')
                ->where('status', 'approved')
                ->sum('amount'),
            'bank_deposits' => FinancialTransaction::whereDate('transaction_date', today())
                ->where('transaction_category', 'bank_deposit')
                ->sum('amount'),
            'other_expenses' => FinancialTransaction::whereDate('transaction_date', today())
                ->where('type', 'expense')
                ->whereNotIn('transaction_category', ['expense', 'salary'])
                ->sum('amount')
        ];
    }
}
