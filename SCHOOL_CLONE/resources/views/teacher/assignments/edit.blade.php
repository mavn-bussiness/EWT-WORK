@extends('teacher.layout')

@section('title', 'Edit Assignment')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-6">Edit Assignment</h2>

        <form action="{{ route('teacher.assignments.update', $assignment->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="class_subject" class="block text-sm font-medium text-gray-700">Class & Subject</label>
                <select name="class_id" id="class_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @foreach ($classSubjects as $classSubject)
                        <option value="{{ $classSubject['class_id'] }}"
                                data-subject-id="{{ $classSubject['subject_id'] }}"
                            {{ $classSubject['class_id'] == $assignment->class_id ? 'selected' : '' }}>
                            {{ $classSubject['display'] }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="subject_id" id="subject_id" value="{{ $assignment->subject_id }}">
                <script>
                    document.getElementById('class_id').addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        document.getElementById('subject_id').value = selectedOption.dataset.subjectId;
                    });
                </script>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ $assignment->title }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ $assignment->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                <input type="date" name="due_date" id="due_date" value="{{ $assignment->due_date->format('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="max_score" class="block text-sm font-medium text-gray-700">Max Score</label>
                <input type="number" name="max_score" id="max_score" value="{{ $assignment->max_score }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required min="1">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Assignment</button>
            </div>
        </form>
    </div>
@endsection
