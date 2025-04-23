<x-app-layout title="Expense Report">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Expense Report</h1>
                <p class="text-muted mb-0">From {{ $summary['start_date'] ?? 'N/A' }} to {{ $summary['end_date'] ?? 'N/A' }}</p>
            </div>
            <div>
                <a href="{{ route('bursar.reports.generate') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Generate Report
                </a>
                <a href="{{ route('bursar.reports.download', $summary['report_id']) }}" class="btn btn-primary">
                    <i class="fas fa-download me-1"></i> Download Report
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Total Expenses</h5>
                        <p class="h4">{{ number_format($summary['total_expenses'], 2) }} {{ config('app.currency', 'USD') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-muted mb-3">Category Summary</h5>
                        @if($summary['category_summary']->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Category</th>
                                        <th>Total ({{ config('app.currency', 'USD') }})</th>
                                        <th>Count</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($summary['category_summary'] as $category => $data)
                                        <tr>
                                            <td>{{ $category ?: 'Uncategorized' }}</td>
                                            <td>{{ number_format($data['total'], 2) }}</td>
                                            <td>{{ $data['count'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No categories found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Expense Details Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                @if($expenses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Amount ({{ config('app.currency', 'USD') }})</th>
                                <th>Account</th>
                                <th>Budget Item</th>
                                <th>Recorded By</th>
                                <th>Expense Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->description ?? 'N/A' }}</td>
                                    <td>{{ $expense->category ?: 'Uncategorized' }}</td>
                                    <td>{{ number_format($expense->amount, 2) }}</td>
                                    <td>{{ $expense->account->name ?? 'N/A' }}</td>
                                    <td>{{ $expense->budgetItem->name ?? 'N/A' }}</td>
                                    <td>{{ $expense->recordedBy->name ?? 'N/A' }}</td>
                                    <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-circle fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No expenses found for the selected criteria.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        @if(session('success'))
            <script>
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
                }).showToast();
            </script>
        @endif
        @if(session('error'))
            <script>
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 3000,
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)"
                }).showToast();
            </script>
        @endif
    @endpush
</x-app-layout>
