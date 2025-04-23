```blade
<x-app-layout title="Fee Report">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Fee Report</h1>
                <p class="text-muted mb-0">From {{ $summary['start_date'] ?? 'N/A' }} to {{ $summary['end_date'] ?? 'N/A' }}</p>
            </div>
            <div>
                <a href="{{ route('bursar.reports.generate') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Generate Report
                </a>
                <a href="{{ route('bursar.reports.download', $summary['report_id']) }}" class="btn btn-primary">
                    <i class="fas fa-download me-1"></i> Download Report
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Total Billed</h5>
                        <p class="h4">{{ number_format($summary['total_billed'], 2) }} {{ config('app.currency', 'USD') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Total Paid</h5>
                        <p class="h4">{{ number_format($summary['total_paid'], 2) }} {{ config('app.currency', 'USD') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Total Outstanding</h5>
                        <p class="h4">{{ number_format($summary['total_outstanding'], 2) }} {{ config('app.currency', 'USD') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Collection Rate</h5>
                        <p class="h4">{{ number_format($summary['collection_rate'], 2) }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fee Details Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                @if($fees->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Term</th>
                                <th>Class Level</th>
                                <th>Total Amount ({{ config('app.currency', 'USD') }})</th>
                                <th>Paid Amount ({{ config('app.currency', 'USD') }})</th>
                                <th>Outstanding ({{ config('app.currency', 'USD') }})</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fees as $fee)
                                <tr>
                                    <td>{{ $fee->student->user->name ?? 'N/A' }}</td>
                                    <td>{{ $fee->term->name ?? 'N/A' }}</td>
                                    <td>{{ $fee->student->class_level ?? 'N/A' }}</td>
                                    <td>{{ number_format($fee->total_amount, 2) }}</td>
                                    <td>{{ number_format($fee->paid_amount, 2) }}</td>
                                    <td>{{ number_format($fee->total_amount - $fee->paid_amount, 2) }}</td>
                                    <td>{{ $fee->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-circle fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No fees found for the selected criteria.</p>
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
