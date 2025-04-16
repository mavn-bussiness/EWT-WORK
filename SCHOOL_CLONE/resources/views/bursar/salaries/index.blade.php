<x-layout title="Salary Management">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Salary Management</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('bursar.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Salaries</li>
        </ol>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-money-check-alt me-1"></i>
                Process Salary Payment
            </div>
            <div class="card-body">
                <form action="{{ route('bursar.salaries.process') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Staff Member</label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">Select Staff Member</option>
                                    @foreach(App\Models\User::whereIn('role', ['teacher', 'headteacher', 'dos', 'bursar'])->orderBy('firstName')->get() as $user)
                                        <option value="{{ $user->id }}">{{ $user->firstName }} {{ $user->lastName }} ({{ ucfirst($user->role) }})</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="month_year" class="form-label">Month/Year</label>
                                <input type="month" class="form-control @error('month_year') is-invalid @enderror" id="month_year" name="month_year" required>
                                @error('month_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="gross_amount" class="form-label">Gross Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('gross_amount') is-invalid @enderror" id="gross_amount" name="gross_amount" step="0.01" min="0" required>
                                    @error('gross_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="deductions" class="form-label">Deductions</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('deductions') is-invalid @enderror" id="deductions" name="deductions" step="0.01" min="0" required>
                                    @error('deductions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="net_amount" class="form-label">Net Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="net_amount" step="0.01" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cheque">Cheque</option>
                            <option value="cash">Cash</option>
                            <option value="mobile_money">Mobile Money</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"></textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Process Salary Payment</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-history me-1"></i>
                Recent Salary Payments
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="salariesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Staff Member</th>
                                <th>Month/Year</th>
                                <th>Gross Amount</th>
                                <th>Deductions</th>
                                <th>Net Amount</th>
                                <th>Payment Method</th>
                                <th>Payment Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salaries as $salary)
                                <tr>
                                    <td>{{ $salary->id }}</td>
                                    <td>{{ $salary->user->firstName }} {{ $salary->user->lastName }}</td>
                                    <td>{{ $salary->month_year }}</td>
                                    <td>{{ number_format($salary->gross_amount, 2) }}</td>
                                    <td>{{ number_format($salary->deductions, 2) }}</td>
                                    <td>{{ number_format($salary->net_amount, 2) }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $salary->payment_method)) }}</td>
                                    <td>{{ $salary->payment_date->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('bursar.salaries.show', $salary->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('bursar.salaries.print', $salary->id) }}" class="btn btn-secondary btn-sm" target="_blank">Print Slip</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $salaries->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $('#salariesTable').DataTable({
                    paging: false,
                    info: false
                });
                
                // Set default month/year
                const today = new Date();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const year = today.getFullYear();
                document.getElementById('month_year').value = `${year}-${month}`;
                
                // Calculate net amount
                $('#gross_amount, #deductions').on('input', function() {
                    const gross = parseFloat($('#gross_amount').val()) || 0;
                    const deductions = parseFloat($('#deductions').val()) || 0;
                    $('#net_amount').val((gross - deductions).toFixed(2));
                });
            });
        </script>
    </x-slot>
</x-layout>