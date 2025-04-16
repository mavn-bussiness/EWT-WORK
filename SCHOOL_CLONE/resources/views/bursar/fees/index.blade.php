<x-layout title="Fee Management">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Fee Management</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('bursar.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Fees</li>
        </ol>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-money-bill me-1"></i>
                All Fees
                <a href="{{ route('bursar.fees.create') }}" class="btn btn-primary btn-sm float-end">Add New Fee</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="feesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Term</th>
                                <th>Total Amount</th>
                                <th>Paid Amount</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fees as $fee)
                                <tr>
                                    <td>{{ $fee->id }}</td>
                                    <td>{{ $fee->student->user->firstName }} {{ $fee->student->user->lastName }}</td>
                                    <td>{{ $fee->term->name }}</td>
                                    <td>{{ number_format($fee->total_amount, 2) }}</td>
                                    <td>{{ number_format($fee->paid_amount, 2) }}</td>
                                    <td>{{ number_format($fee->total_amount - $fee->paid_amount, 2) }}</td>
                                    <td>
                                        @if($fee->status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($fee->status == 'partial')
                                            <span class="badge bg-warning">Partial</span>
                                        @else
                                            <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('bursar.fees.show', $fee->id) }}" class="btn btn-info btn-sm">View</a>
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal" 
                                            data-fee-id="{{ $fee->id }}" 
                                            data-student-name="{{ $fee->student->user->firstName }} {{ $fee->student->user->lastName }}"
                                            data-balance="{{ $fee->total_amount - $fee->paid_amount }}">
                                            Add Payment
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $fees->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Process Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bursar.fees.process-payment') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="fee_id" id="fee_id">
                        <div class="mb-3">
                            <label for="student_name" class="form-label">Student</label>
                            <input type="text" class="form-control" id="student_name" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="balance" class="form-label">Current Balance</label>
                            <input type="text" class="form-control" id="balance" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Payment Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="mobile_money">Mobile Money</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="receipt_number" class="form-label">Receipt Number</label>
                            <input type="text" class="form-control" id="receipt_number" name="receipt_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="transaction_id" class="form-label">Transaction ID (Optional)</label>
                            <input type="text" class="form-control" id="transaction_id" name="transaction_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Process Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const paymentModal = document.getElementById('paymentModal');
                if (paymentModal) {
                    paymentModal.addEventListener('show.bs.modal', function(event) {
                        const button = event.relatedTarget;
                        const feeId = button.getAttribute('data-fee-id');
                        const studentName = button.getAttribute('data-student-name');
                        const balance = button.getAttribute('data-balance');
                        
                        document.getElementById('fee_id').value = feeId;
                        document.getElementById('student_name').value = studentName;
                        document.getElementById('balance').value = balance;
                    });
                }
                
                // Initialize DataTable
                $('#feesTable').DataTable({
                    paging: false,
                    info: false
                });
            });
        </script>
    </x-slot>
</x-layout>