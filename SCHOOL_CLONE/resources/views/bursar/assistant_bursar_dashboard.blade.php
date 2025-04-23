<x-layout title="Assistant Bursar Dashboard">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Assistant Bursar Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Financial Operations</li>
        </ol>
        
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Today's Collection</div>
                                <div class="fs-4">${{ number_format($stats['today_collection'], 2) }}</div>
                            </div>
                            <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.payments.today') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Pending Expenses</div>
                                <div class="fs-4">{{ $stats['pending_expenses'] }}</div>
                            </div>
                            <i class="fas fa-clipboard-list fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.expenses.index') }}?status=pending">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Fee Reminders</div>
                                <div class="fs-4">{{ $stats['fee_reminders'] }}</div>
                            </div>
                            <i class="fas fa-bell fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.fees.reminders') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Overdue Fees</div>
                                <div class="fs-4">${{ number_format($stats['overdue_fees'], 2) }}</div>
                            </div>
                            <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.fees.index') }}?status=overdue">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Transactions and Approvals -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-money-bill-wave me-1"></i> Recent Fee Payments
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Receipt #</th>
                                        <th>Student</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Method</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->receipt_number }}</td>
                                        <td>{{ $payment->fee->student->user->firstName }} {{ $payment->fee->student->user->lastName }}</td>
                                        <td>${{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No recent payments</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('bursar.fees.index') }}" class="btn btn-primary btn-sm">View All Payments</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-file-invoice me-1"></i> Expenses for Approval
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pendingExpenses as $expense)
                                    <tr>
                                        <td>{{ $expense->expense_number }}</td>
                                        <td>{{ $expense->category }}</td>
                                        <td>${{ number_format($expense->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-warning">Pending</span>
                                        </td>
                                        <td>
                                            @if(Auth::user()->bursar->canApproveAmount($expense->amount))
                                                <a href="{{ route('bursar.expenses.show', $expense->id) }}" class="btn btn-primary btn-sm">View</a>
                                                <a href="{{ route('bursar.expenses.approve', $expense->id) }}" class="btn btn-success btn-sm">Approve</a>
                                                <a href="{{ route('bursar.expenses.reject', $expense->id) }}" class="btn btn-danger btn-sm">Reject</a>
                                            @else
                                                <span class="badge bg-info">Above Limit</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No pending expenses</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('bursar.expenses.index') }}" class="btn btn-primary btn-sm">View All Expenses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Payment Collection & Expense Management -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-cash-register me-1"></i> Quick Fee Collection
                    </div>
                    <div class="card-body">
                        <form action="{{ route('bursar.fees.payment') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Select Student</label>
                                <select class="form-select" id="student_id" name="student_id" required>
                                    <option value="">Select Student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->user->firstName }} {{ $student->user->lastName }} ({{ $student->admissionNumber }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fee_id" class="form-label">Fee Item</label>
                                <select class="form-select" id="fee_id" name="fee_id" required disabled>
                                    <option value="">Select student first</option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="amount" class="form-label">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select class="form-select" id="payment_method" name="payment_method" required>
                                        <option value="cash">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="mobile_money">Mobile Money</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="receipt_number" class="form-label">Receipt Number</label>
                                    <input type="text" class="form-control" id="receipt_number" name="receipt_number" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="transaction_id" class="form-label">Transaction ID (Optional)</label>
                                    <input type="text" class="form-control" id="transaction_id" name="transaction_id">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Process Payment</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-plus-circle me-1"></i> Record New Expense
                    </div>
                    <div class="card-body">
                        <form action="{{ route('bursar.expenses.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="account_id" class="form-label">Account</label>
                                    <select class="form-select" id="account_id" name="account_id" required>
                                        <option value="">Select Account</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="budget_item_id" class="form-label">Budget Item (Optional)</label>
                                    <select class="form-select" id="budget_item_id" name="budget_item_id">
                                        <option value="">Select Budget Item</option>
                                        @foreach($budgetItems as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->budget->title }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Completing assistant_bursar_dashboard.blade.php -->
<!-- The form was cut off, so I'll complete it -->

<div class="col-md-6">
    <label for="amount" class="form-label">Amount</label>
    <div class="input-group">
        <span class="input-group-text">$</span>
        <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" required>
    </div>
</div>
<div class="col-md-6">
    <label for="category" class="form-label">Category</label>
    <select class="form-select" id="category" name="category" required>
        <option value="">Select Category</option>
        <option value="supplies">Supplies</option>
        <option value="maintenance">Maintenance</option>
        <option value="utilities">Utilities</option>
        <option value="transport">Transport</option>
        <option value="other">Other</option>
    </select>
</div>
</div>
<div class="row mb-3">
    <div class="col-md-6">
        <label for="expense_date" class="form-label">Date</label>
        <input type="date" class="form-control" id="expense_date" name="expense_date" required value="{{ date('Y-m-d') }}">
    </div>
    <div class="col-md-6">
        <label for="payment_method" class="form-label">Payment Method</label>
        <select class="form-select" id="payment_method" name="payment_method" required>
            <option value="cash">Cash</option>
            <option value="bank_transfer">Bank Transfer</option>
            <option value="mobile_money">Mobile Money</option>
        </select>
    </div>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" name="description" rows="2"></textarea>
</div>
<div class="row mb-3">
    <div class="col-md-6">
        <label for="receipt_number" class="form-label">Receipt Number</label>
        <input type="text" class="form-control" id="receipt_number" name="receipt_number">
    </div>
    <div class="col-md-6">
        <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" id="has_receipt" name="has_receipt" value="1">
            <label class="form-check-label" for="has_receipt">Receipt Available</label>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-primary">Record Expense</button>
</form>
</div>
</div>
</div>
</div>

<!-- Task Management Section -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-tasks me-1"></i> Tasks and Reminders
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse($tasks as $task)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $task->title }}</strong>
                            <p class="mb-0 text-muted small">{{ Str::limit($task->description, 100) }}</p>
                        </div>
                        <div>
                            <span class="badge bg-primary rounded-pill">{{ $task->due_date->format('M d') }}</span>
                            <a href="{{ route('bursar.tasks.toggle', $task->id) }}" class="btn btn-sm {{ $task->is_completed ? 'btn-success' : 'btn-outline-success' }}">
                                <i class="fas {{ $task->is_completed ? 'fa-check-circle' : 'fa-circle' }}"></i>
                            </a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center">No tasks or reminders</li>
                    @endforelse
                </ul>
                <div class="mt-3">
                    <a href="{{ route('bursar.tasks.index') }}" class="btn btn-primary btn-sm">Manage Tasks</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
    // Student and fee item AJAX
    document.getElementById('student_id').addEventListener('change', function() {
        const studentId = this.value;
        const feeSelect = document.getElementById('fee_id');
        
        if (studentId) {
            fetch(`/api/students/${studentId}/fees`)
                .then(response => response.json())
                .then(data => {
                    feeSelect.disabled = false;
                    feeSelect.innerHTML = '<option value="">Select Fee</option>';
                    
                    data.forEach(fee => {
                        const option = document.createElement('option');
                        option.value = fee.id;
                        option.textContent = `${fee.term_name} - $${fee.total_amount} (Balance: $${fee.balance})`;
                        feeSelect.appendChild(option);
                    });
                });
        } else {
            feeSelect.disabled = true;
            feeSelect.innerHTML = '<option value="">Select student first</option>';
        }
    });
</script>
@endpush
</x-layout>