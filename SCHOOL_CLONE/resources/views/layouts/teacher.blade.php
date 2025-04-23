<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-blue-800 text-white p-4">
        <h1 class="text-2xl font-bold mb-6">Teacher Dashboard</h1>
        <nav>
            <ul>
                <li class="mb-2"><a href="{{ route('teacher.dashboard') }}" class="block p-2 hover:bg-blue-700 rounded">Dashboard</a></li>
                <li class="mb-2"><a href="{{ route('teacher.classes.index') }}" class="block p-2 hover:bg-blue-700 rounded">Classes</a></li>
                <li class="mb-2"><a href="{{ route('teacher.assignments.grade') }}" class="block p-2 hover:bg-blue-700 rounded">Assignments</a></li>
                <li class="mb-2"><a href="{{ route('teacher.marks.create') }}" class="block p-2 hover:bg-blue-700 rounded">Marks</a></li>
                <li class="mb-2"><a href="{{ route('teacher.attendance.mark') }}" class="block p-2 hover:bg-blue-700 rounded">Attendance</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6 overflow-auto">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>
</body>
</html>
