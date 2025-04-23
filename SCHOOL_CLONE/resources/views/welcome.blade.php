<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-[#1e293b] via-[#111827] to-[#0f172a] text-white min-h-screen font-inter">

<header class="w-full bg-[#0f172a] shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-white"> the S.M.S</h1>

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
                    }}" class="aws-btn-primary">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="aws-btn-secondary">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="aws-btn-primary">Register</a>
                    @endif
                @endauth
            </nav>
        @endif
    </div>
</header>

<main class="flex-1 flex items-center justify-center py-20 px-4">
    <div class="max-w-5xl w-full bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-12 shadow-2xl text-center space-y-8">

        <div class="space-y-2">
            <h1 class="text-5xl font-extrabold tracking-tight leading-tight">
                Welcome to <span class="text-yellow-400"> the School Management System</span>
            </h1>
            <p class="text-xl text-gray-300">
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
           class="inline-block text-lg font-semibold px-8 py-3 bg-yellow-500 hover:bg-yellow-600 rounded-full shadow-md transition">
            🚀 Launch Dashboard
        </a>
    </div>
</main>

<footer class="mt-auto bg-[#0f172a] border-t border-white/10 py-6">
    <div class="max-w-7xl mx-auto text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} Group Q . All rights reserved.
    </div>
</footer>

</body>
</html>
