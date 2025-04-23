@extends('teacher.layout')

@section('title', 'Attendance')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-6">Attendance</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($classes as $class)
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium">{{ $class->name }}{{ $class->stream ? ' - ' . $class->stream : '' }}</h3>
                    <a href="{{ route('teacher.attendance.mark', $class->id) }}" class="text-blue-600 hover:underline">Mark Attendance</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
