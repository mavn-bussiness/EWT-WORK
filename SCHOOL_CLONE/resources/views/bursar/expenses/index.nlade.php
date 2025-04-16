<x-layout title="Expense Management">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Expense Management</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('bursar.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Expenses</li>
        </ol>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-money-bill-wave me-1"></i>
                All Expenses
                <a href="{{ route('bursar.expenses.create') }}" class="btn btn-primary btn-sm float-end">Add New Expense</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="expensesTable">
                        <thead>
                            <tr>
                                <th>Expense #</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Payee</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Recorded By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_number }}</td>
                                    <td>{{ $expense->account->name }}</td>
                                    <td>{{ number_format($expense->amount, 2) }}</td>
                                    <td>{{ $expense->payee }}</td>
                                    <td>{{ $expense->category }}</td>
                                    <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                                    <td>
                                        @if($expense->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($expense->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $expense->recordedBy->firstName }} {{ $expense->recordedBy->lastName }}</td>
                                    <td>
                                        <a href="{{ route('bursar.expenses.show', $expense->id) }}" class="btn btn-info btn-sm">View</a>
                                        @if($expense->status == 'pending' && Auth::user()->can_approve_expenses)
                                            <a href="{{ route('bursar.expenses.approve', $expense->id) }}" class="btn btn-success btn-sm">Approve</a>
                                            <a href="{{ route('bursar.expenses.reject', $expense->id) }}" class="btn btn-danger btn-sm">Reject</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $expenses->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $('#expensesTable').DataTable({
                    paging: false,
                    info: false
                });
            });
        </script>
    </x-slot>
</x-layout>