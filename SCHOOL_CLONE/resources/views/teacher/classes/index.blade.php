@extends('teacher.layout')

@section('title', 'Classes')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-6">Your Classes</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($classSubjects as $classSubject)
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium">{{ $classSubject->class->name }}{{ $classSubject->class->stream ? ' - ' . $classSubject->class->stream : '' }}</h3>
                    <p class="text-gray-600">{{ $classSubject->subject->name }}</p>
                    <a href="{{ route('teacher.classes.show', $classSubject->class->id) }}" class="text-blue-600 hover:underline">View Details</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
