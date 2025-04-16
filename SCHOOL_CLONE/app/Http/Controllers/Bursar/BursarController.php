<?php

namespace App\Http\Controllers\Bursar;


use App\Http\Controllers\Controller;
use App\Models\{
    Fee, Payment, Student, FeeStructure, Expense, Budget,
    BudgetItem, Account, FinancialTransaction, SalaryPayment,
    FeeArrear, FeeReminder, Scholarship, User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BursarController extends Controller
{
    // Fee Management
    public function feeIndex()
    {
        $fees = Fee::with(['student.user', 'term'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('bursar.fees.index', compact('fees'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'fee_id' => 'required|exists:fees,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,bank_transfer,mobile_money',
            'receipt_number' => 'required|string|unique:payments',
            'transaction_id' => 'nullable|string',
        ]);

        $fee = Fee::findOrFail($request->fee_id);

        // Check if payment exceeds balance
        if (($fee->paid_amount + $request->amount) > $fee->total_amount) {
            return back()->with('error', 'Payment amount exceeds fee balance.');
        }

        // Record payment
        $payment = Payment::create([
            'fee_id' => $request->fee_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'receipt_number' => $request->receipt_number,
            'transaction_id' => $request->transaction_id,
            'received_by' => Auth::id(),
            'payment_date' => now(),
        ]);

        // Update fee status
        $fee->paid_amount += $request->amount;
        if ($fee->paid_amount >= $fee->total_amount) {
            $fee->status = 'paid';
        } elseif ($fee->paid_amount > 0) {
            $fee->status = 'partial';
        }
        $fee->save();

        // Record financial transaction
        FinancialTransaction::create([
            'account_id' => Account::where('account_type', 'cash')->first()->id,
            'amount' => $request->amount,
            'type' => 'income',
            'reference_number' => 'FEE-' . $payment->id,
            'transaction_category' => 'school_fees',
            'description' => 'Fee payment for ' . $fee->student->user->firstName,
            'transaction_date' => now(),
            'recorded_by' => Auth::id(),
            'is_approved' => true,
        ]);

        return redirect()->route('bursar.fees.index')
            ->with('success', 'Payment processed successfully. Receipt #' . $request->receipt_number);
    }

    // Expense Management
    public function expenseIndex()
    {
        $expenses = Expense::with(['account', 'recordedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('bursar.expenses.index', compact('expenses'));
    }

    public function createExpense()
    {
        $accounts = Account::where('is_active', true)->get();
        $budgetItems = BudgetItem::with('budget')
            ->whereHas('budget', function($q) {
                $q->where('is_approved', true);
            })
            ->get();

        return view('bursar.expenses.create', compact('accounts', 'budgetItems'));
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0',
            'payee' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'category' => 'required|string',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'receipt_number' => 'nullable|string',
            'has_receipt' => 'boolean',
            'budget_item_id' => 'nullable|exists:budget_items,id',
        ]);

        $expense = Expense::create([
            'expense_number' => 'EXP-' . strtoupper(uniqid()),
            'account_id' => $request->account_id,
            'budget_item_id' => $request->budget_item_id,
            'amount' => $request->amount,
            'payee' => $request->payee,
            'payment_method' => $request->payment_method,
            'category' => $request->category,
            'expense_date' => $request->expense_date,
            'description' => $request->description,
            'receipt_number' => $request->receipt_number,
            'has_receipt' => $request->has_receipt ?? false,
            'recorded_by' => Auth::id(),
            'status' => Auth::user()->can_approve_expenses ? 'approved' : 'pending',
        ]);

        // If expense is approved, record transaction
        if ($expense->status === 'approved') {
            $this->recordExpenseTransaction($expense);
        }

        return redirect()->route('bursar.expenses.index')
            ->with('success', 'Expense recorded successfully.');
    }

    protected function recordExpenseTransaction(Expense $expense)
    {
        FinancialTransaction::create([
            'account_id' => $expense->account_id,
            'amount' => $expense->amount,
            'type' => 'expense',
            'reference_number' => $expense->expense_number,
            'transaction_category' => $expense->category,
            'description' => $expense->description,
            'transaction_date' => $expense->expense_date,
            'recorded_by' => $expense->recorded_by,
            'approved_by' => Auth::id(),
            'is_approved' => true,
        ]);

        // Update budget item if exists
        if ($expense->budget_item_id) {
            $item = BudgetItem::find($expense->budget_item_id);
            $item->used_amount += $expense->amount;
            $item->save();
        }
    }

    // Salary Management
    public function salaryIndex()
    {
        $salaries = SalaryPayment::with(['user'])
            ->orderBy('payment_date', 'desc')
            ->paginate(20);

        return view('bursar.salaries.index', compact('salaries'));
    }

    public function processSalary(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gross_amount' => 'required|numeric|min:0',
            'deductions' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'month_year' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $netAmount = $request->gross_amount - $request->deductions;

        $salary = SalaryPayment::create([
            'user_id' => $request->user_id,
            'gross_amount' => $request->gross_amount,
            'deductions' => $request->deductions,
            'net_amount' => $netAmount,
            'payment_date' => now(),
            'payment_method' => $request->payment_method,
            'month_year' => $request->month_year,
            'notes' => $request->notes,
            'processed_by' => Auth::id(),
        ]);

        // Record financial transaction
        FinancialTransaction::create([
            'account_id' => Account::where('account_type', 'bank')->first()->id,
            'amount' => $netAmount,
            'type' => 'expense',
            'reference_number' => 'SAL-' . $salary->id,
            'transaction_category' => 'salaries',
            'description' => 'Salary payment for ' . $salary->month_year,
            'transaction_date' => now(),
            'recorded_by' => Auth::id(),
            'approved_by' => Auth::id(),
            'is_approved' => true,
        ]);

        return redirect()->route('bursar.salaries.index')
            ->with('success', 'Salary payment processed successfully.');
    }

    // Reports
    public function financialReports()
    {
        $reports = FinancialReport::orderBy('created_at', 'desc')
            ->paginate(15);

        return view('bursar.reports.index', compact('reports'));
    }

    public function generateFeeReport(Request $request)
    {
        $request->validate([
            'term_id' => 'required|exists:terms,id',
            'class_level' => 'nullable|string',
        ]);

        $fees = Fee::with(['student.user', 'term', 'payments'])
            ->where('term_id', $request->term_id)
            ->when($request->class_level, function($query) use ($request) {
                return $query->whereHas('student', function($q) use ($request) {
                    $q->where('class_level', $request->class_level);
                });
            })
            ->get();

        $term = Term::find($request->term_id);

        // Store report
        FinancialReport::create([
            'report_name' => 'Fee Report - ' . $term->name . ($request->class_level ? ' - ' . $request->class_level : ''),
            'report_type' => 'fees',
            'start_date' => $term->start_date,
            'end_date' => $term->end_date,
            'generated_by' => Auth::id(),
        ]);

        return view('bursar.reports.fee-report', compact('fees', 'term'));
    }

    // Dashboard
    public function dashboard()
    {
        $stats = [
            'total_collected' => Payment::whereBetween('created_at', [now()->startOfMonth(), now()])->sum('amount'),
            'pending_expenses' => Expense::where('status', 'pending')->count(),
            'unpaid_fees' => Fee::where('status', '!=', 'paid')->count(),
            'upcoming_salaries' => User::whereIn('role', ['teacher', 'headteacher', 'dos', 'bursar'])->count(),
        ];

        $recentPayments = Payment::with(['fee.student.user'])
            ->latest()
            ->take(5)
            ->get();

        $pendingExpenses = Expense::with(['account'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('bursar.dashboard', compact('stats', 'recentPayments', 'pendingExpenses'));
    }
}