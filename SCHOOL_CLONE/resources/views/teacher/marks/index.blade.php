@extends('teacher.layout')

@section('title', 'Marks')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-6">Assessments</h2>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($assessments as $assessment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->class->name }}{{ $assessment->class->stream ? ' - ' . $assessment->class->stream : '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->subject->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->assessment_date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->max_score }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('teacher.marks.create', $assessment->id) }}" class="text-blue-600 hover:underline">Record Marks</a>
                            <a href="{{ route('teacher.marks.edit', $assessment->id) }}" class="text-green-600 hover:underline ml-2">Edit Marks</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $assessments->links() }}
        </div>
    </div>
@endsection
