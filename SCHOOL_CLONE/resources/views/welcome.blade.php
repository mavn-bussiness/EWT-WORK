<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The S.M.S - School Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-[var(--aws-navy)] to-[var(--aws-dark-navy)] text-white min-h-screen font-inter flex flex-col">

<header class="w-full bg-[var(--aws-dark-navy)] border-b border-[var(--aws-border)] shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center">
            <svg viewBox="0 0 316 316" class="w-8 h-8 mr-2 text-[var(--aws-orange)]" xmlns="http://www.w3.org/2000/svg">
                <path class="fill-[var(--aws-orange)]" d="M60 200 C60 180, 80 160, 158 160 C236 160, 256 180, 256 200 V240 C256 260, 236 280, 158 280 C80 280, 60 260, 60 240 V200 Z"/>
                <path class="fill-[var(--aws-text-light)]" d="M80 200 C80 190, 90 180, 158 180 C226 180, 236 190, 236 200 V230 C236 240, 226 250, 158 250 C90 250, 80 240, 80 230 V200 Z"/>
                <path class="fill-[var(--aws-navy)]" d="M148 120 H168 V160 H148 Z"/>
                <path class="fill-[var(--aws-orange)]" d="M158 80 C150 80, 146 90, 148 100 C150 110, 166 110, 168 100 C170 90, 166 80, 158 80 Z"/>
            </svg>
            <h1 class="text-xl font-semibold text-white">The S.M.S</h1>
        </div>

        @if (Route::has('login'))
            <nav class="flex gap-3">
                @auth
                    <a href="{{
                        match(true) {
                            Auth::user()->hasRole('headteacher') => route('headteacher.dashboard'),
                            Auth::user()->hasRole('dos') => route('dos.dashboard'),
                            Auth::user()->hasRole('bursar') => route('bursar.dashboard'),
                            Auth::user()->hasRole('teacher') => route('teacher.dashboard'),
                            default => route('dashboard')
                        }
                    }}" class="aws-btn-primary bg-[var(--aws-orange)] hover:bg-[var(--aws-orange-hover)] text-[var(--aws-navy)]">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="aws-btn-secondary bg-white/10 hover:bg-white/20 text-[var(--aws-text-light)] border-[var(--aws-border)]">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="aws-btn-primary bg-[var(--aws-orange)] hover:bg-[var(--aws-orange-hover)] text-[var(--aws-navy)]">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </div>
</header>

<main class="flex-1 flex items-center justify-center py-12 px-4">
    <div class="max-w-5xl w-full bg-white/5 backdrop-blur-md border border-[var(--aws-border)] rounded-2xl p-12 shadow-2xl text-center space-y-8">
        <div class="space-y-4">
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                Welcome to <span class="text-[var(--aws-orange)]">The School Management System</span>
            </h1>
            <p class="text-lg sm:text-xl text-[var(--aws-text-light)]">
                Smart Schools, Smooth Systems
            </p>
        </div>

        <a href="{{
            Auth::check()
                ? match(true) {
                    Auth::user()->hasRole('headteacher') => route('headteacher.dashboard'),
                    Auth::user()->hasRole('dos') => route('dos.dashboard'),
                    Auth::user()->hasRole('bursar') => route('bursar.dashboard'),
                    Auth::user()->hasRole('teacher') => route('teacher.dashboard'),
                    default => route('dashboard')
                }
                : route('login')
        }}"
           class="aws-btn-primary inline-flex items-center text-lg font-semibold px-8 py-3 bg-[var(--aws-orange)] hover:bg-[var(--aws-orange-hover)] text-[var(--aws-navy)] rounded-full shadow-md transition">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Launch Dashboard
        </a>
    </div>
</main>

<footer class="mt-auto bg-[var(--aws-dark-navy)] border-t border-[var(--aws-border)] py-6">
    <div class="max-w-7xl mx-auto text-center text-[var(--aws-text-light)] text-sm">
        &copy; {{ date('Y') }} Group Q. All rights reserved.
    </div>
</footer>

<!-- Custom CSS for AWS-inspired styling -->
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
    }

    .aws-btn-primary {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.1s;
    }

    .aws-btn-primary:hover {
        transform: translateY(-1px);
    }

    .aws-btn-primary:active {
        transform: translateY(0);
    }

    .aws-btn-secondary {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid var(--aws-border);
        cursor: pointer;
        transition: background-color 0.2s, transform 0.1s;
    }

    .aws-btn-secondary:hover {
        transform: translateY(-1px);
    }

    .aws-btn-secondary:active {
        transform: translateY(0);
    }
</style>

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
</body>
</html>
