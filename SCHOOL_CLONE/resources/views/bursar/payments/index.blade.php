```blade
<x-app-layout title="Payments">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Payments</h1>
                <p class="text-muted mb-0">List of all fee payments</p>
            </div>
            <a href="{{ route('bursar.payments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Record Payment
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Reference</th>
                                <th>Term</th>
                                <th>Amount ({{ $currency }})</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->student->user->name }}</td>
                                    <td>{{ $payment->reference_number }}</td>
                                    <td>{{ $payment->term->name }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                    <td>
                                            <span class="badge bg-{{ $payment->status == 'confirmed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('bursar.payments.show', $payment->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $payments->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-money-check-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No payments found.</p>
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
```
