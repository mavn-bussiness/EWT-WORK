<x-layout title="Financial Reports">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Financial Reports</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('bursar.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Reports</li>
        </ol>

        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-file-invoice-dollar me-1"></i>
                        Fee Reports
                    </div>
                    <div class="card-body">
                        <form action="{{ route('bursar.reports.generate-fee') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="term_id" class="form-label">Term</label>
                                <select class="form-select" id="term_id" name="term_id" required>
                                    <option value="">Select Term</option>
                                    @foreach(App\Models\Term::orderBy('start_date', 'desc')->get() as $term)
                                        <option value="{{ $term->id }}">{{ $term->name }} ({{ $term->start_date->format('M Y') }} - {{ $term->end_date->format('M Y') }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="class_level" class="form-label">Class Level (Optional)</label>
                                <select class="form-select" id="class_level" name="class_level">
                                    <option value="">All Classes</option>
                                    <option value="Form 1">Form 1</option>
                                    <option value="Form 2">Form 2</option>
                                    <option value="Form 3">Form 3</option>
                                    <option value="Form 4">Form 4</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Expense Reports
                    </div>
                    <div class="card-body">
                        <form action="{{ route('bursar.reports.generate-expense') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category (Optional)</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">All Categories</option>
                                    <option value="supplies">Supplies</option>
                                    <option value="utilities">Utilities</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="equipment">Equipment</option>
                                    <option value="transportation">Transportation</option>
                                    <option value="salaries">Salaries</option>
                                    <option value="food">Food</option>
                                    <option value="miscellaneous">Miscellaneous</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-history me-1"></i>
                Previous Reports
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="reportsTable">
                        <thead>
                            <tr>
                                <th>Report Name</th>
                                <th>Type</th>
                                <th>Date Range</th>
                                <th>Generated By</th>
                                <th>Generated On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td>{{ $report->report_name }}</td>
                                    <td>{{ ucfirst($report->report_type) }}</td>
                                    <td>{{ $report->start_date->format('Y-m-d') }} to {{ $report->end_date->format('Y-m-d') }}</td>
                                    <td>{{ $report->generatedBy->firstName }} {{ $report->generatedBy->lastName }}</td>
                                    <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('bursar.reports.show', $report->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('bursar.reports.download', $report->id) }}" class="btn btn-success btn-sm">Download</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $('#reportsTable').DataTable({
                    paging: false,
                    info: false
                });
                
                // Set default dates
                const today = new Date();
                const firstDayMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                
                document.getElementById('start_date').value = formatDate(firstDayMonth);
                document.getElementById('end_date').value = formatDate(today);
                
                function formatDate(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                }
            });
        </script>
    </x-slot>
</x-layout>