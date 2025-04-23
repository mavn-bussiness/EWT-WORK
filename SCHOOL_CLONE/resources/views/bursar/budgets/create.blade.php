<x-app-layout title="Create Budget">
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1 h3 fw-bold">Create Budget</h1>
                <p class="text-muted mb-0">Add a new budget for a term</p>
            </div>
            <a href="{{ route('bursar.budgets.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Budgets
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('bursar.budgets.store') }}" method="POST">
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
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <h5 class="mt-3">Budget Items</h5>
                            <div id="budget-items">
                                <div class="row g-3 mb-3 budget-item">
                                    <div class="col-md-6">
                                        <label class="form-label">Item Name</label>
                                        <input type="text" name="items[0][name]"
                                               class="form-control @error('items.0.name') is-invalid @enderror"
                                               value="{{ old('items.0.name') }}" required>
                                        @error('items.0.name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Allocated Amount ({{ $currency }})</label>
                                        <input type="number" name="items[0][allocated_amount]" step="0.01"
                                               class="form-control @error('items.0.allocated_amount') is-invalid @enderror"
                                               value="{{ old('items.0.allocated_amount') }}" required>
                                        @error('items.0.allocated_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-outline-danger w-100" onclick="removeItem(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-2" onclick="addItem()">
                                <i class="fas fa-plus me-1"></i> Add Item
                            </button>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Budget
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
        <script>
            let itemCount = 1;

            function addItem() {
                const container = document.getElementById('budget-items');
                const itemHtml = `
                    <div class="row g-3 mb-3 budget-item">
                        <div class="col-md-6">
                            <label class="form-label">Item Name</label>
                            <input type="text" name="items[${itemCount}][name]"
                                   class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Allocated Amount ({{ $currency }})</label>
                            <input type="number" name="items[${itemCount}][allocated_amount]" step="0.01"
                                   class="form-control" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-danger w-100" onclick="removeItem(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>`;
                container.insertAdjacentHTML('beforeend', itemHtml);
                itemCount++;
            }

            function removeItem(button) {
                if (document.querySelectorAll('.budget-item').length > 1) {
                    button.closest('.budget-item').remove();
                }
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
