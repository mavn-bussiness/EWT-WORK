@extends('teacher.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-6">Welcome, {{ Auth::user()->name }}</h2>

        @if (isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $error }}
            </div>
        @else
            <!-- Classes Overview -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Your Classes</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($classSubjects as $classSubject)
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h4 class="text-lg font-medium">{{ $classSubject->class->name }}{{ $classSubject->class->stream ? ' - ' . $classSubject->class->stream : '' }}</h4>
                            <p class="text-gray-600">{{ $classSubject->subject->name }}</p>
                            <a href="{{ route('teacher.classes.show', $classSubject->class->id) }}" class="text-blue-600 hover:underline">View Details</a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Upcoming Assignments -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Upcoming Assignments</h3>
                <div class="bg-white rounded-lg shadow overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($assignments as $assignment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->class->name }}{{ $assignment->class->stream ? ' - ' . $assignment->class->stream : '' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->subject->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->due_date->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Upcoming Assessments -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Upcoming Assessments</h3>
                <div class="bg-white rounded-lg shadow overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($assessments as $assessment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->class->name }}{{ $assessment->class->stream ? ' - ' . $assessment->class->stream : '' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->subject->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessment_date->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($attendancePending)
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    You have pending attendance to mark for today.
                </div>
            @endif
        @endif
    </div>
@endsection
