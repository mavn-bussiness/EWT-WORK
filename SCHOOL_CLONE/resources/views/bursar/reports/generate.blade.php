<x-app-layout title="Generate Report">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Generate Report</h1>
                <p class="text-muted mb-0">Create a new financial report</p>
            </div>
            <a href="{{ route('bursar.reports.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Reports
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Fee Report</h5>
                <form action="{{ route('bursar.reports.fees') }}" method="GET" class="mb-5">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date"
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   value="{{ old('start_date') }}" required>
                            @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   value="{{ old('end_date') }}" required>
                            @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="term_id" class="form-label">Term (Optional)</label>
                            <select name="term_id" id="term_id" class="form-select">
                                <option value="">All Terms</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}">{{ $term->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="class_level" class="form-label">Class Level (Optional)</label>
                            <input type="text" name="class_level" id="class_level"
                                   class="form-control" value="{{ old('class_level') }}">
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-chart-line me-1"></i> Generate Fee Report
                            </button>
                        </div>
                    </div>
                </form>

                <h5 class="mb-3">Expense Report</h5>
                <form action="{{ route('bursar.reports.expenses') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date_expense" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date_expense"
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   value="{{ old('start_date') }}" required>
                            @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="end_date_expense" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date_expense"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   value="{{ old('end_date') }}" required>
                            @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="category" class="form-label">Category (Optional)</label>
                            <input type="text" name="category" id="category"
                                   class="form-control" value="{{ old('category') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="account_id" class="form-label">Account (Optional)</label>
                            <select name="account_id" id="account_id" class="form-select">
                                <option value="">All Accounts</option>
                                @foreach(\App\Models\Account::active()->get() as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-chart-line me-1"></i> Generate Expense Report
                            </button>
                        </div>
                    </div>
                </form>
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
