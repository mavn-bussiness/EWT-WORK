@extends('teacher.layout')

@section('title', 'Grade Assignment')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-6">Grade Assignment: {{ $assignment->title }}</h2>

        <form action="{{ route('teacher.assignments.updateGrades', $assignment->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
            @csrf

            <div class="mb-4">
                <p><strong>Class:</strong> {{ $assignment->class->name }}{{ $assignment->class->stream ? ' - ' . $assignment->class->stream : '' }}</p>
                <p><strong>Subject:</strong> {{ $assignment->subject->name }}</p>
                <p><strong>Max Score:</strong> {{ $assignment->max_score }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach ($studentAssignments as $studentAssignment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $studentAssignment->student->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number" name="scores[{{ $studentAssignment->student->id }}]"
                                       value="{{ $studentAssignment->score ?? '' }}"
                                       class="border-gray-300 rounded-md shadow-sm w-20"
                                       min="0" max="{{ $assignment->max_score }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $studentAssignment->grade ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="text" name="remarks[{{ $studentAssignment->student->id }}]"
                                       value="{{ $studentAssignment->remarks ?? '' }}"
                                       class="border-gray-300 rounded-md shadow-sm w-full">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Grades</button>
            </div>
        </form>
    </div>
@endsection
