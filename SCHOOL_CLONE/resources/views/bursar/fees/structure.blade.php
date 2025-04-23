```blade
<x-app-layout title="Fee Structures">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Fee Structures</h1>
                <p class="text-muted mb-0">Manage fee structures by class and term</p>
            </div>
            <a href="{{ route('bursar.fees.structure.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Create Fee Structure
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if($feeStructures->isNotEmpty())
                    @foreach($feeStructures as $classLevel => $structures)
                        <h5 class="mb-3">{{ $classLevel }}</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-hover">
                                <thead class="table-light">
                                <tr>
                                    <th>Term</th>
                                    <th>Tuition ({{ $currency }})</th>
                                    <th>Boarding ({{ $currency }})</th>
                                    <th>Development ({{ $currency }})</th>
                                    <th>Total ({{ $currency }})</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($structures as $structure)
                                    <tr>
                                        <td>{{ $structure->term->name }}</td>
                                        <td>{{ number_format($structure->tuition, 2) }}</td>
                                        <td>{{ $structure->boarding ? number_format($structure->boarding, 2) : '-' }}</td>
                                        <td>{{ $structure->development ? number_format($structure->development, 2) : '-' }}</td>
                                        <td>{{ number_format($structure->total_amount, 2) }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('bursar.fees.structure.edit', $structure->id) }}"
                                                   class="btn btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('bursar.fees.structure.destroy', $structure->id) }}"
                                                      method="POST" onsubmit="return confirm('Are you sure you want to delete this fee structure?');">
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
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-money-bill-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No fee structures found.</p>
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
