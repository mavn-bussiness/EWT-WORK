```blade
<x-app-layout title="Fee Reminders">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Fee Reminders</h1>
                <p class="text-muted mb-0">Fee reminders scheduled for today</p>
            </div>
            <a href="{{ route('bursar.fees.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Fees
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if($reminders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Term</th>
                                <th>Reminder Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reminders as $reminder)
                                <tr>
                                    <td>{{ $reminder->student->user->name }}</td>
                                    <td>{{ $reminder->term->name }}</td>
                                    <td>{{ $reminder->reminder_date->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('bursar.students.fee-lookup') }}?admission_number={{ $reminder->student->admission_number }}"
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
                        {{ $reminders->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No fee reminders scheduled for today.</p>
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
