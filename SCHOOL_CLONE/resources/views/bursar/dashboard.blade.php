<x-layout title="Bursar Dashboard">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Bursar Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Monthly Collection</div>
                                <div class="fs-4">${{ number_format($stats['total_collected'], 2) }}</div>
                            </div>
                            <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.fees.index') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Pending Expenses</div>
                                <div class="fs-4">{{ $stats['pending_expenses'] }}</div>
                            </div>
                            <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.expenses.index') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Unpaid Fees</div>
                                <div class="fs-4">{{ $stats['unpaid_fees'] }}</div>
                            </div>
                            <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.fees.index') }}?status=unpaid">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Staff Salaries</div>
                                <div class="fs-4">{{ $stats['upcoming_salaries'] }}</div>
                            </div>
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('bursar.salaries.index') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Monthly Revenue
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Expense Distribution
                    </div>
                    <div class="card-body">
                        <canvas id="expenseChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-money-bill-alt me-1"></i>
                        Recent Payments
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
                                    @foreach($recentPayments as $payment)
                                        <tr>
                                            <td>{{ $payment->receipt_number }}</td>
                                            <td>{{ $payment->fee->student->user->firstName }} {{ $payment->fee->student->user->lastName }}</td>
                                            <td>${{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                        </tr>
                                    @endforeach
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
                        <i class="fas fa-clock me-1"></i>
                        Pending Expenses
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Expense #</th>
                                        <th>Payee</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingExpenses as $expense)
                                        <tr>
                                            <td>{{ $expense->expense_number }}</td>
                                            <td>{{ $expense->payee }}</td>
                                            <td>${{ number_format($expense->amount, 2) }}</td>
                                            <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                                            <td>
                                                @if(Auth::user()->can_approve_expenses)
                                                    <a href="{{ route('bursar.expenses.approve', $expense->id) }}" class="btn btn-success btn-sm">Approve</a>
                                                    <a href="{{ route('bursar.expenses.reject', $expense->id) }}" class="btn btn-danger btn-sm">Reject</a>
                                                @else
                                                    <span class="badge bg-warning">Awaiting Approval</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
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

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-calendar-alt me-1"></i>
                Quick Actions
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('bursar.fees.create') }}" class="btn btn-primary w-100 py-3">
                            <i class="fas fa-plus-circle mb-2 d-block fs-3"></i>
                            Add New Fee
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('bursar.expenses.create') }}" class="btn btn-warning w-100 py-3">
                            <i class="fas fa-file-invoice mb-2 d-block fs-3"></i>
                            Record Expense
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('bursar.reports.index') }}" class="btn btn-info w-100 py-3">
                            <i class="fas fa-chart-line mb-2 d-block fs-3"></i>
                            Generate Reports
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('bursar.salaries.index') }}" class="btn btn-success w-100 py-3">
                            <i class="fas fa-money-check-alt mb-2 d-block fs-3"></i>
                            Process Salaries
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
        <script>
            // Sample data for charts (these would be populated from the controller with real data)
            document.addEventListener('DOMContentLoaded', function() {
                // Revenue Chart - Last 6 months
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const currentMonth = new Date().getMonth();
                const last6Months = Array.from({length: 6}, (_, i) => {
                    const monthIndex = (currentMonth - 5 + i) % 12;
                    return monthNames[monthIndex < 0 ? monthIndex + 12 : monthIndex];
                });
                
                // Sample revenue data - would come from the database
                const revenueData = [25000, 32000, 18000, 27000, 22000, {{ $stats['total_collected'] }}];
                
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                new Chart(revenueCtx, {
                    type: 'bar',
                    data: {
                        labels: last6Months,
                        datasets: [{
                            label: 'Revenue ($)',
                            data: revenueData,
                            backgroundColor: 'rgba(0, 123, 255, 0.5)',
                            borderColor: 'rgba(0, 123, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
                
                // Expense Chart
                const expenseCtx = document.getElementById('expenseChart').getContext('2d');
                new Chart(expenseCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Salaries', 'Supplies', 'Utilities', 'Maintenance', 'Other'],
                        datasets: [{
                            data: [45, 20, 15, 10, 10],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            }
                        }
                    }
                });
            });
        </script>
    </x-slot>
</x-layout>