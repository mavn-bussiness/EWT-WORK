<x-app-layout title="Chief Bursar Dashboard">
    <div class="container-fluid px-4 py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Financial Dashboard</h1>
                <p class="text-muted mb-0">Welcome back, Chief Bursar</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary btn-sm" onclick="refreshDashboard()">
                    <i class="fas fa-sync-alt me-1"></i> Refresh
                </button>
                <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="quickActions" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bolt me-1"></i> Quick Actions
                    </button>
                    <ul class="dropdown-menu shadow-sm" aria-labelledby="quickActions">
                        <li><a class="dropdown-item" href="{{ route('bursar.budgets.create') }}"><i class="fas fa-plus-circle me-2"></i>Create Budget</a></li>
                        <li><a class="dropdown-item" href="{{ route('bursar.fees.structure') }}"><i class="fas fa-money-bill-alt me-2"></i>Manage Fee Structure</a></li>
                        <li><a class="dropdown-item" href="{{ route('bursar.reports.generate') }}"><i class="fas fa-chart-line me-2"></i>Generate Reports</a></li>
                        <li><a class="dropdown-item" href="{{ route('bursar.expenses.pending') }}"><i class="fas fa-tasks me-2"></i>Pending Approvals</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-primary border-4 shadow-sm h-100 animate__animated animate__fadeIn" role="button" aria-label="Total Collection">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-bold small">Total Collection</h6>
                                <h3 class="mb-0">${{ number_format($stats['total_collected'] ?? 0, 2) }}</h3>
                            </div>
                            <div class="icon-circle bg-primary-light text-primary">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <a href="{{ route('bursar.reports.fees') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-success border-4 shadow-sm h-100 animate__animated animate__fadeIn" role="button" aria-label="Total Expenses">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-bold small">Total Expenses</h6>
                                <h3 class="mb-0">${{ number_format($stats['total_expenses'] ?? 0, 2) }}</h3>
                            </div>
                            <div class="icon-circle bg-success-light text-success">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <a href="{{ route('bursar.reports.expenses') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-warning border-4 shadow-sm h-100 animate__animated animate__fadeIn" role="button" aria-label="Pending Approvals">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-bold small">Pending Approvals</h6>
                                <h3 class="mb-0">{{ $stats['pending_approvals'] ?? 0 }}</h3>
                            </div>
                            <div class="icon-circle bg-warning-light text-warning">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                        </div>
                        <a href="{{ route('bursar.expenses.pending') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-danger border-4 shadow-sm h-100 animate__animated animate__fadeIn" role="button" aria-label="Fee Arrears">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-bold small">Fee Arrears</h6>
                                <h3 class="mb-0">${{ number_format($stats['fee_arrears'] ?? 0, 2) }}</h3>
                            </div>
                            <div class="icon-circle bg-danger-light text-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                        <a href="{{ route('bursar.fees.arrears') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-xl-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Financial Overview</h5>
                            <div class="d-flex align-items-center gap-2">
                                <select class="form-select form-select-sm" id="periodSelect" onchange="updateFinancialChart(this.value)">
                                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>This Month</option>
                                    <option value="quarter" {{ $period === 'quarter' ? 'selected' : '' }}>This Quarter</option>
                                    <option value="year" {{ $period === 'year' ? 'selected' : '' }}>This Year</option>
                                </select>
                                <button class="btn btn-sm btn-outline-secondary" onclick="exportChart('financialOverview', 'Financial_Overview')">
                                    <i class="fas fa-download me-1"></i> Export
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="chart-container" style="height: 350px;">
                            <canvas id="financialOverview" aria-label="Financial Overview Chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Expenses by Category</h5>
                            <button class="btn btn-sm btn-outline-secondary" onclick="exportChart('expensesPieChart', 'Expenses_by_Category')">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="chart-container" style="height: 350px;">
                            <canvas id="expensesPieChart" aria-label="Expenses by Category Chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget vs Actual -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Budget vs Actual (Current Term)</h5>
                    <input type="text" class="form-control form-control-sm w-auto" id="budgetFilter" placeholder="Filter by category..." onkeyup="filterBudgetTable()">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="budgetTable">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col" class="text-end">Budgeted</th>
                            <th scope="col" class="text-end">Actual</th>
                            <th scope="col" class="text-end">Variance</th>
                            <th scope="col">% Used</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($budgetVsActual as $item)
                            <tr>
                                <td>{{ $item['category'] }}</td>
                                <td class="text-end">${{ number_format($item['budgeted'] ?? 0, 2) }}</td>
                                <td class="text-end">${{ number_format($item['actual'] ?? 0, 2) }}</td>
                                <td class="text-end">${{ number_format($item['variance'] ?? 0, 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                            <div class="progress-bar {{ $item['percentage'] > 100 ? 'bg-danger' : ($item['percentage'] > 90 ? 'bg-warning' : 'bg-success') }}"
                                                 role="progressbar"
                                                 style="width: {{ min($item['percentage'] ?? 0, 100) }}%"
                                                 aria-valuenow="{{ $item['percentage'] ?? 0 }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted">{{ round($item['percentage'] ?? 0) }}%</small>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pending Approvals and Reports -->
        <div class="row g-4">
            <div class="col-xl-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pending Approvals</h5>
                            <span class="badge bg-warning rounded-pill">{{ $stats['pending_approvals'] ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($pendingExpenses->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($pendingExpenses as $expense)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $expense->expense_number }}</h6>
                                                <small class="text-muted">{{ $expense->category }} • {{ $expense->expense_date->format('M d, Y') }}</small>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-light text-dark me-2">${{ number_format($expense->amount ?? 0, 2) }}</span>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary" title="Quick Approve" onclick="openApproveModal({{ $expense->id }}, '{{ $expense->expense_number }}', {{ $expense->amount }})">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <a href="{{ route('bursar.expenses.show', $expense->id) }}" class="btn btn-outline-secondary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('bursar.expenses.reject', $expense->id) }}" class="btn btn-outline-danger" title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No pending approvals</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Recent Reports</h5>
                    </div>
                    <div class="card-body">
                        @if($latestReports->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($latestReports as $report)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $report->report_name }}</h6>
                                                <small class="text-muted">{{ ucfirst($report->report_type) }} • {{ $report->created_at->format('M d, Y') }}</small>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('bursar.reports.view', $report->id) }}" class="btn btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('bursar.reports.download', $report->id) }}" class="btn btn-outline-secondary" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No reports generated yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Approve Expense Modal -->
        <div class="modal fade" id="approveExpenseModal" tabindex="-1" aria-labelledby="approveExpenseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveExpenseModalLabel">Approve Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to approve <strong id="expenseNumber"></strong> for <strong id="expenseAmount"></strong>?</p>
                        <input type="hidden" id="expenseId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" onclick="submitApproval()">Approve</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            :root {
                --primary: #0d6efd;
                --success: #198754;
                --warning: #ffc107;
                --danger: #dc3545;
            }
            .icon-circle {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                transition: transform 0.2s;
            }
            .card:hover .icon-circle {
                transform: scale(1.1);
            }
            .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
            .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
            .bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }
            .bg-danger-light { background-color: rgba(220, 53, 69, 0.1); }
            .chart-container {
                position: relative;
                min-height: 250px;
            }
            .list-group-item {
                border-left: 0;
                border-right: 0;
                transition: background-color 0.2s;
            }
            .list-group-item:hover {
                background-color: #f8f9fa;
            }
            .list-group-item:first-child {
                border-top: 0;
            }
            .list-group-item:last-child {
                border-bottom: 0;
            }
            .btn-group .btn {
                transition: all 0.2s;
            }
            .btn-group .btn:hover {
                transform: translateY(-1px);
            }
            .animate__fadeIn {
                animation-duration: 0.5s;
            }
            @media (max-width: 768px) {
                .card-body h3 {
                    font-size: 1.5rem;
                }
                .icon-circle {
                    width: 40px;
                    height: 40px;
                }
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/3rQfS8O7O3vY+QRb9vJ+kL8kJ6b8f7f7f8f8f7f8f7f8f7f8f7f8f7f8f7f8f7f8f7f8f7f8f7" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
        <script>
            // Initialize Charts
            let financialChart, expensesPieChart;

            document.addEventListener('DOMContentLoaded', function () {
                // Financial Overview Chart
                const financialCtx = document.getElementById('financialOverview').getContext('2d');
                financialChart = new Chart(financialCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($financialOverviewData['labels'] ?? []),
                        datasets: [
                            {
                                label: 'Income',
                                data: @json($financialOverviewData['income'] ?? []),
                                backgroundColor: 'rgba(25, 135, 84, 0.2)',
                                borderColor: 'rgba(25, 135, 84, 1)',
                                borderWidth: 1,
                                borderRadius: 4
                            },
                            {
                                label: 'Expenses',
                                data: @json($financialOverviewData['expenses'] ?? []),
                                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                                borderColor: 'rgba(220, 53, 69, 1)',
                                borderWidth: 1,
                                borderRadius: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: { size: 12 },
                                    padding: 15
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': $' + (context.raw || 0).toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.05)' },
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });

                // Expenses Pie Chart
                const pieCtx = document.getElementById('expensesPieChart').getContext('2d');
                expensesPieChart = new Chart(pieCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($expensesPieData['labels'] ?? []),
                        datasets: [{
                            data: @json($expensesPieData['data'] ?? []),
                            backgroundColor: [
                                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                                '#5a5c69', '#858796', '#3a3b45', '#f8f9fc', '#d1d3e2'
                            ],
                            borderWidth: 0,
                            hoverOffset: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    font: { size: 12 },
                                    padding: 15
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: $${value.toLocaleString()} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            });

            // Update Financial Chart
            function updateFinancialChart(period) {
                fetch(`/bursar/financial-data?period=${period}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(response => response.json())
                    .then(data => {
                        financialChart.data.labels = data.labels;
                        financialChart.data.datasets[0].data = data.income;
                        financialChart.data.datasets[1].data = data.expenses;
                        financialChart.update();
                    })
                    .catch(error => console.error('Error updating chart:', error));
            }

            // Export Chart as PNG
            function exportChart(chartId, filename) {
                const canvas = document.getElementById(chartId);
                const link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = `${filename}.png`;
                link.click();
            }

            // Filter Budget Table
            function filterBudgetTable() {
                const filter = document.getElementById('budgetFilter').value.toLowerCase();
                const rows = document.querySelectorAll('#budgetTable tbody tr');
                rows.forEach(row => {
                    const category = row.cells[0].textContent.toLowerCase();
                    row.style.display = category.includes(filter) ? '' : 'none';
                });
            }

            // Refresh Dashboard
            function refreshDashboard() {
                window.location.reload(); // Simple reload; replace with AJAX for live data
            }

            // Approve Expense Modal
            function openApproveModal(id, number, amount) {
                document.getElementById('expenseId').value = id;
                document.getElementById('expenseNumber').textContent = number;
                document.getElementById('expenseAmount').textContent = `$${Number(amount).toLocaleString()}`;
                new bootstrap.Modal(document.getElementById('approveExpenseModal')).show();
            }

            function submitApproval() {
                const expenseId = document.getElementById('expenseId').value;
                fetch('{{ route("bursar.expenses.approve", ":id") }}'.replace(':id', expenseId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('approveExpenseModal')).hide();
                            refreshDashboard();
                        } else {
                            alert('Error approving expense: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to approve expense.');
                    });
            }
        </script>
    @endpush
</x-app-layout>
