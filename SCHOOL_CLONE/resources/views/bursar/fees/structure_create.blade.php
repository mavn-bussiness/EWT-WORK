```blade
<x-app-layout title="Create Fee Structure">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Create Fee Structure</h1>
                <p class="text-muted mb-0">Add a new fee structure for a class and term</p>
            </div>
            <a href="{{ route('bursar.fees.structure') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Fee Structures
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('bursar.fees.structure.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="term_id" class="form-label">Term</label>
                            <select name="term_id" id="term_id" class="form-select @error('term_id') is-invalid @enderror" required>
                                <option value="">Select Term</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}">{{ $term->name }}</option>
                                @endforeach
                            </select>
                            @error('term_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="class_level" class="form-label">Class Level</label>
                            <input type="text" name="class_level" id="class_level"
                                   class="form-control @error('class_level') is-invalid @enderror"
                                   value="{{ old('class_level') }}" required>
                            @error('class_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="tuition" class="form-label">Tuition ({{ $currency }})</label>
                            <input type="number" name="tuition" id="tuition" step="0.01"
                                   class="form-control @error('tuition') is-invalid @enderror"
                                   value="{{ old('tuition') }}" required>
                            @error('tuition')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="boarding" class="form-label">Boarding ({{ $currency }})</label>
                            <input type="number" name="boarding" id="boarding" step="0.01"
                                   class="form-control @error('boarding') is-invalid @enderror"
                                   value="{{ old('boarding') }}">
                            @error('boarding')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="development" class="form-label">Development ({{ $currency }})</label>
                            <input type="number" name="development" id="development" step="0.01"
                                   class="form-control @error('development') is-invalid @enderror"
                                   value="{{ old('development') }}">
                            @error('development')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Fee Structure
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
```
