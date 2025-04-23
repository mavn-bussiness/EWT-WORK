<x-layout title="Cashier Dashboard">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Cashier Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Fee Collection</li>
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
                                <div class="small">Receipts Issued</div>
                                <div class="fs-4">{{ $stats['receipts_count'] }}</div>
                            </div>
                            <i class="fas fa-receipt fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.payments.index') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Students Served</div>
                                <div class="fs-4">{{ $stats['students_served'] }}</div>
                            </div>
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.students.index') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Cash in Hand</div>
                                <div class="fs-4">${{ number_format($stats['cash_in_hand'], 2) }}</div>
                            </div>
                            <i class="fas fa-cash-register fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.cash.summary') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Fee Collection and Recent Payments -->
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
                                    <input type="text" class="form-control" id="receipt_number" name="receipt_number" value="{{ $nextReceiptNumber }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="transaction_id" class="form-label">Transaction ID (Optional)</label>
                                    <input type="text" class="form-control" id="transaction_id" name="transaction_id">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Process Payment</button>
                            <button type="reset" class="btn btn-secondary">Clear Form</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-list-alt me-1"></i> Recent Payments
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Receipt #</th>
                                        <th>Student</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->receipt_number }}</td>
                                        <td>{{ $payment->fee->student->user->firstName }} {{ $payment->fee->student->user->lastName }}</td>
                                        <td>${{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                        <td>{{ $payment->created_at->format('H:i') }}</td>
                                        <td>
                                            <a href="{{ route('bursar.payments.receipt', $payment->id) }}" class="btn btn-info btn-sm" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No recent payments</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('bursar.payments.index') }}" class="btn btn-primary btn-sm">View All Payments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Fee Structure and Student Lookup -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-search me-1"></i> Student Fee Lookup
                    </div>
                    <div class="card-body">
                        <form action="{{ route('bursar.students.fee-lookup') }}" method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Student Admission Number" name="admission_number">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                        
                        @if(isset($feeDetails))
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Term</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feeDetails as $fee)
                                    <tr>
                                        <td>{{ $fee->term->name }}</td>
                                        <td>${{ number_format($fee->total_amount, 2) }}</td>
                                        <td>${{ number_format($fee->paid_amount, 2) }}</td>
                                        <td>${{ number_format($fee->total_amount - $fee->paid_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $fee->status == 'paid' ? 'success' : ($fee->status == 'partial' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($fee->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-file-invoice-dollar me-1"></i> Current Fee Structure
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Class Level</th>
                                        <th>Tuition</th>
                                        <th>Boarding</th>
                                        <th>Development</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feeStructures as $structure)
                                    <tr>
                                        <td>{{ $structure->class_level }}</td>
                                        <td>${{ number_format($structure->tuition, 2) }}</td>
                                        <td>${{ number_format($structure->boarding ?? 0, 2) }}</td>
                                        <td>${{ number_format($structure->development ?? 0, 2) }}</td>
                                        <td>${{ number_format($structure->tuition + ($structure->boarding ?? 0) + ($structure->development ?? 0), 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Daily Cash Summary -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-money-bill-wave me-1"></i> Daily Cash Summary
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-header">Cash In</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <tr>
                                                    <td>Opening Balance:</td>
                                                    <td class="text-end">${{ number_format($cashSummary['opening_balance'] ?? 0, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Cash Receipts:</td>
                                                    <td class="text-end">${{ number_format($cashSummary['cash_receipts'] ?? 0, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Other Income:</td>
                                                    <td class="text-end">${{ number_format($cashSummary['other_income'] ?? 0, 2) }}</td>
                                                </tr>
                                                <tr class="fw-bold">
                                                    <td>Total Cash In:</td>
                                                    <td class="text-end">${{ number_format(($cashSummary['opening_balance'] ?? 0) + ($cashSummary['cash_receipts'] ?? 0) + ($cashSummary['other_income'] ?? 0), 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-header">Cash Out</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <tr>
                                                    <td>Petty Cash Expenses:</td>
                                                    <td class="text-end">${{ number_format($cashSummary['petty_cash'] ?? 0, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bank Deposits:</td>
                                                    <td class="text-end">${{ number_format($cashSummary['bank_deposits'] ?? 0, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Other Expenses:</td>
                                                    <td class="text-end">${{ number_format($cashSummary['other_expenses'] ?? 0, 2) }}</td>
                                                </tr>
                                                <tr class="fw-bold">
                                                    <td>Total Cash Out:</td>
                                                    <td class="text-end">${{ number_format(($cashSummary['petty_cash'] ?? 0) + ($cashSummary['bank_deposits'] ?? 0) + ($cashSummary['other_expenses'] ?? 0), 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="fs-5">
                                <strong>Closing Balance: ${{ number_format($stats['cash_in_hand'], 2) }}</strong>
                            </div>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#endDayModal">
                                <i class="fas fa-check-circle me-1"></i> End Day Processing
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- End Day Modal -->
    <div class="modal fade" id="endDayModal" tabindex="-1" aria-labelledby="endDayModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="endDayModalLabel">End Day Processing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('bursar.cash.endday') }}" method="POST" id="endDayForm">
                        @csrf
                        <p>Please confirm your cash summary for today:</p>
                        
                        <div class="mb-3">
                            <label for="total_collected" class="form-label">Total Amount Collected</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" id="total_collected" name="total_collected" value="{{ number_format($stats['today_collection'], 2) }}" readonly>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cash_in_hand" class="form-label">Closing Cash in Hand</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" id="cash_in_hand" name="cash_in_hand" value="{{ number_format($stats['cash_in_hand'], 2) }}" readonly>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bank_deposit" class="form-label">Bank Deposit Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="bank_deposit" name="bank_deposit" min="0" step="0.01" max="{{ $stats['cash_in_hand'] }}">
                            </div>
                            <div class="form-text">Amount to be deposited to bank from today's collection</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" form="endDayForm">Complete End Day Processing</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Dynamic loading of fee items when student is selected
        document.getElementById('student_id').addEventListener('change', function() {
            const studentId = this.value;
            const feeSelect = document.getElementById('fee_id');
            
            if (studentId) {
                feeSelect.disabled = true;
                feeSelect.innerHTML = '<option value="">Loading...</option>';
                
                fetch('/bursar/students/' + studentId + '/fees')
                    .then(response => response.json())
                    .then(data => {
                        feeSelect.innerHTML = '<option value="">Select Fee Item</option>';
                        
                        data.forEach(fee => {
                            const balance = fee.total_amount - fee.paid_amount;
                            if (balance > 0) {
                                const option = document.createElement('option');
                                option.value = fee.id;
                                option.textContent = `${fee.term.name} - Balance: $${balance.toFixed(2)}`;
                                option.dataset.balance = balance;
                                feeSelect.appendChild(option);
                            }
                        });
                        
                        feeSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching fee data:', error);
                        feeSelect.innerHTML = '<option value="">Error loading fees</option>';
                        feeSelect.disabled = false;
                    });
            } else {
                feeSelect.innerHTML = '<option value="">Select student first</option>';
                feeSelect.disabled = true;
            }
        });
        
        // Auto-fill amount when fee is selected
        document.getElementById('fee_id').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            if (option && option.dataset.balance) {
                document.getElementById('amount').value = option.dataset.balance;
            } else {
                document.getElementById('amount').value = '';
            }
        });
    </script>
    @endpush
</x-layout>