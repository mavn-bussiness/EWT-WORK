<x-app-layout>
    <!-- Custom Styles for AWS-inspired UI -->
    <style>
        :root {
            --aws-navy: #1a2538;
            --aws-dark-navy: #0f172a;
            --aws-orange: #ec7211;
            --aws-orange-hover: #f28a38;
            --aws-border: #4b5563;
            --aws-text-light: #d1d5db;
            --aws-green: #10b981;
            --aws-red: #ef4444;
            --aws-yellow: #facc15;
            --aws-blue: #3b82f6;
            --aws-background: #111827;
        }

        .aws-sidebar {
            background-color: var(--aws-dark-navy);
            color: var(--aws-text-light);
            min-height: 100vh;
            padding: 1.5rem;
            width: 16rem;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
        }

        .aws-sidebar a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--aws-text-light);
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .aws-sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .aws-sidebar a.active {
            background-color: var(--aws-orange);
            color: var(--aws-navy);
        }

        .aws-content {
            margin-left: 16rem;
            padding: 2rem;
            background-color: var(--aws-background);
            min-height: 100vh;
        }

        .aws-card {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--aws-border);
            border-radius: 0.75rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .aws-card:hover {
            transform: translateY(-2px);
        }

        .aws-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: background-color 0.2s, transform 0.1s;
        }

        .aws-btn:hover {
            transform: translateY(-1px);
        }

        .aws-btn:active {
            transform: translateY(0);
        }

        .aws-input,
        .aws-textarea,
        .aws-select {
            appearance: none;
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--aws-text-light);
            border: 1px solid var(--aws-border);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            width: 100%;
        }

        .aws-input:hover,
        .aws-textarea:hover,
        .aws-select:hover {
            border-color: var(--aws-orange);
        }

        .aws-input:focus,
        .aws-textarea:focus,
        .aws-select:focus {
            outline: none;
            border-color: var(--aws-orange);
            box-shadow: 0 0 5px rgba(236, 114, 17, 0.3);
        }

        .aws-textarea {
            min-height: 8rem;
            resize: vertical;
        }

        .aws-select-wrapper {
            position: relative;
        }

        .aws-select-wrapper::after {
            content: '\25BC';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--aws-text-light);
            pointer-events: none;
        }

        .aws-label {
            color: var(--aws-text-light);
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }
    </style>

    <!-- Sidebar -->
    <div class="aws-sidebar">
        <div class="flex items-center mb-8">
            <svg viewBox="0 0 316 316" class="w-8 h-8 mr-2 text-[var(--aws-orange)]" xmlns="http://www.w3.org/2000/svg">
                <path class="fill-[var(--aws-orange)]" d="M60 200 C60 180, 80 160, 158 160 C236 160, 256 180, 256 200 V240 C256 260, 236 280, 158 280 C80 280, 60 260, 60 240 V200 Z"/>
                <path class="fill-[var(--aws-text-light)]" d="M80 200 C80 190, 90 180, 158 180 C226 180, 236 190, 236 200 V230 C236 240, 226 250, 158 250 C90 250, 80 240, 80 230 V200 Z"/>
                <path class="fill-[var(--aws-navy)]" d="M148 120 H168 V160 H148 Z"/>
                <path class="fill-[var(--aws-orange)]" d="M158 80 C150 80, 146 90, 148 100 C150 110, 166 110, 168 100 C170 90, 166 80, 158 80 Z"/>
            </svg>
            <h1 class="text-xl font-semibold">The S.M.S</h1>
        </div>
        <div class="flex items-center mb-6">
            <div class="w-10 h-10 bg-[var(--aws-orange)] rounded-full flex items-center justify-center mr-3">
                <span class="text-[var(--aws-navy)] font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
            </div>
            <div>
                <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                <p class="text-xs text-[var(--aws-text-light)] opacity-75">Teacher Access</p>
            </div>
        </div>
        <nav class="space-y-2">
            <a href="{{ route('teacher.dashboard') }}">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('teacher.classes.index') }}">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332-.477-4.5-1.253" />
                </svg>
                Classes
            </a>
            <a href="{{ route('teacher.assignments.index') }}" class="active">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Assignments
            </a>
            <a href="{{ route('teacher.marks.index') }}">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Marks
            </a>
            <a href="{{ route('teacher.attendance.index') }}">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Attendance
            </a>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="flex items-center px-4 py-3 text-gray-300 hover:bg-slate-700 rounded-lg group hover:text-white transition-colors">
                    <x-icon name="logout" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-yellow-500" />
                    <span class="text-sm font-medium">Logout</span>
                </a>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="aws-content">
        <x-slot name="header">
            <h2 class="text-2xl font-semibold text-white leading-tight">
                {{ __('Edit Assignment') }}
            </h2>
        </x-slot>

        <div class="max-w-7xl mx-auto">
            <div class="aws-card p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[var(--aws-orange)]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0l-1.414-1.414a2 2 0 010-2.828L14.586 4.586z" />
                    </svg>
                    Edit Assignment
                </h3>

                <form action="{{ route('teacher.assignments.update', $assignment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="class_id" class="aws-label">Class & Subject</label>
                        <div class="aws-select-wrapper">
                            <select name="class_id" id="class_id" class="aws-select" required>
                                @foreach ($classSubjects as $classSubject)
                                    <option value="{{ $classSubject['class_id'] }}"
                                            data-subject-id="{{ $classSubject['subject_id'] }}"
                                        {{ $classSubject['class_id'] == $assignment->class_id ? 'selected' : '' }}>
                                        {{ $classSubject['display'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="subject_id" id="subject_id" value="{{ $assignment->subject_id }}">
                    </div>

                    <div class="mb-4">
                        <label for="title" class="aws-label">Title</label>
                        <input type="text" name="title" id="title" value="{{ $assignment->title }}" class="aws-input" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="aws-label">Description</label>
                        <textarea name="description" id="description" class="aws-textarea" required>{{ $assignment->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="aws-label">Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ $assignment->due_date->format('Y-m-d') }}" class="aws-input" required>
                    </div>

                    <div class="mb-4">
                        <label for="max_score" class="aws-label">Max Score</label>
                        <input type="number" name="max_score" id="max_score" value="{{ $assignment->max_score }}" class="aws-input" required min="1">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="aws-btn bg-[var(--aws-orange)] text-[var(--aws-navy)] hover:bg-[var(--aws-orange-hover)]">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Assignment
                        </button>
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
            document.getElementById('class_id').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                document.getElementById('subject_id').value = selectedOption.dataset.subjectId;
            });
        </script>
        @if(session('success'))
            <script>
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    style: {
                        background: "linear-gradient(to right, var(--aws-green), var(--aws-blue))"
                    }
                }).showToast();
            </script>
        @endif
        @if(session('error'))
            <script>
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 3000,
                    style: {
                        background: "linear-gradient(to right, var(--aws-red), var(--aws-yellow))"
                    }
                }).showToast();
            </script>
        @endif
    @endpush
</x-app-layout>
