```blade
<x-app-layout title="Budgets">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Budgets</h1>
                <p class="text-muted mb-0">List of budgets by term</p>
            </div>
            <a href="{{ route('bursar.budgets.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Create Budget
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if($budgets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Term</th>
                                <th>Total Amount ({{ $currency }})</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($budgets as $budget)
                                <tr>
                                    <td>{{ $budget->title }}</td>
                                    <td>{{ $budget->term->name }}</td>
                                    <td>{{ number_format($budget->items->sum('allocated_amount'), 2) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('bursar.budgets.edit', $budget->id) }}"
                                               class="btn btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('bursar.budgets.destroy', $budget->id) }}"
                                                  method="POST" onsubmit="return confirm('Are you sure you want to delete this budget?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $budgets->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-wallet fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No budgets found.</p>
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
