<x-layout title="Accounts Clerk Dashboard">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Accounts Clerk Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Financial Records</li>
        </ol>
        
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Total Transactions</div>
                                <div class="fs-4">{{ $stats['total_transactions'] }}</div>
                            </div>
                            <i class="fas fa-exchange-alt fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.transactions.index') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Daily Collection</div>
                                <div class="fs-4">${{ number_format($stats['daily_collection'], 2) }}</div>
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
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Pending Records</div>
                                <div class="fs-4">{{ $stats['pending_records'] }}</div>
                            </div>
                            <i class="fas fa-clock fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.records.pending') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Reports Generated</div>
                                <div class="fs-4">{{ $stats['reports_count'] }}</div>
                            </div>
                            <i class="fas fa-file-alt fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.reports.index') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Transactions and Quick Entry -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-list-alt me-1"></i> Recent Financial Transactions
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Account</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->reference_number }}</td>
                                        <td>{{ $transaction->account->account_name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transaction->type == 'income' ? 'success' : ($transaction->type == 'expense' ? 'danger' : 'info') }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($transaction->amount, 2) }}</td>
                                        <td>{{ $transaction->transaction_category }}</td>
                                        <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No recent transactions</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('bursar.transactions.index') }}" class="btn btn-primary btn-sm">View All Transactions</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-edit me-1"></i> Quick Record Entry
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="{{ route('bursar.fees.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-money-bill-wave me-2"></i> Record Fee Payment
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <a href="{{ route('bursar.expenses.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-invoice me-2"></i> Record Expense
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <a href="{{ route('bursar.transactions.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-exchange-alt me-2"></i> Record Transaction
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <a href="{{ route('bursar.reports.generate') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-chart-bar me-2"></i> Generate Report
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-bell me-1"></i> Notifications
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse($notifications as $notification)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    <p class="mb-0">{{ $notification->message }}</p>
                                </div>
                                @if(!$notification->is_read)
                                <span class="badge bg-danger rounded-pill">New</span>
                                @endif
                            </li>
                            @empty
                            <li class="list-group-item text-center">No new notifications</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Fee Records and Reports -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div><i class="fas fa-tasks me-1"></i> Fee Records by Class</div>
                        <div>
                            <select class="form-select form-select-sm" id="termSelector">
                                @foreach($terms as $term)
                                <option value="{{ $term->id }}" {{ $currentTerm->id == $term->id ? 'selected' : '' }}>
                                    {{ $term->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Class</th>
                                        <th>Total Students</th>
                                        <th>Expected Amount</th>
                                        <th>Collected Amount</th>
                                        <th>Outstanding</th>
                                        <th>Collection Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classRecords as $record)
                                    <tr>
                                        <td>{{ $record->class_name }}</td>
                                        <td>{{ $record->total_students }}</td>
                                        <td>${{ number_format($record->expected_amount, 2) }}</td>
                                        <td>${{ number_format($record->collected_amount, 2) }}</td>
                                        <td>${{ number_format($record->outstanding_amount, 2) }}</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar {{ $record->collection_rate >= 90 ? 'bg-success' : ($record->collection_rate >= 70 ? 'bg-info' : 'bg-warning') }}" 
                                                     role="progressbar" 
                                                     style="width: {{ $record->collection_rate }}%;" 
                                                     aria-valuenow="{{ $record->collection_rate }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">{{ $record->collection_rate }}%</div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('termSelector').addEventListener('change', function() {
            window.location.href = '{{ route("bursar.dashboard") }}?term_id=' + this.value;
        });
    </script>
    @endpush
</x-layout>