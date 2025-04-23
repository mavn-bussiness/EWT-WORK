```blade
<x-app-layout title="Pending Expenses">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Pending Expenses</h1>
                <p class="text-muted mb-0">Expenses awaiting approval</p>
            </div>
            <a href="{{ route('bursar.expenses.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Expenses
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if($expenses->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($expenses as $expense)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $expense->expense_number }}</h6>
                                        <small class="text-muted">{{ $expense->category }} • {{ $expense->expense_date->format('M d, Y') }}</small>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-light text-dark me-2">{{ $currency }} {{ number_format($expense->amount, 2) }}</span>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="Approve"
                                                    onclick="openApproveModal({{ $expense->id }}, '{{ $expense->expense_number }}', {{ $expense->amount }})">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <a href="{{ route('bursar.expenses.show', $expense->id) }}"
                                               class="btn btn-outline-secondary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('bursar.expenses.reject', $expense->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger" title="Reject"
                                                        onclick="return confirm('Are you sure you want to reject this expense?');">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        {{ $expenses->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No pending expenses.</p>
                    </div>
                @endif
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <style>
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
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            function openApproveModal(id, number, amount) {
                document.getElementById('expenseId').value = id;
                document.getElementById('expenseNumber').textContent = number;
                document.getElementById('expenseAmount').textContent = '{{ $currency }} ' + Number(amount).toLocaleString();
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
                            Toastify({
                                text: data.message,
                                duration: 3000,
                                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
                            }).showToast();
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            Toastify({
                                text: 'Error approving expense: ' + (data.message || 'Unknown error'),
                                duration: 3000,
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)"
                            }).showToast();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Toastify({
                            text: 'Failed to approve expense.',
                            duration: 3000,
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)"
                        }).showToast();
                    });
            }
        </script>
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
