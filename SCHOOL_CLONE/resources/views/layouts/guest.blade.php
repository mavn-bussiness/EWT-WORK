<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'School Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-blue-100 to-blue-200 dark:from-gray-800 dark:to-gray-900">
    <div>
        <a href="/">
            <x-application-logo class="w-24 h-24 fill-current text-blue-600" />
        </a>
    </div>

    <h1 class="text-3xl font-bold text-blue-800 dark:text-blue-400 mt-2">
        School Management System
    </h1>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="w-full sm:max-w-md mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="w-full sm:max-w-md mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg border-t-4 border-blue-600">
        {{ $slot }}
    </div>

    <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
        &copy; {{ date('Y') }} School Management System. All rights reserved.
    </div>
</div>
</body>
</html>
