@extends('teacher.layout')

@section('title', 'Assignments')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Assignments</h2>
            <a href="{{ route('teacher.assignments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Assignment</a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($assignments as $assignment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->class->name }}{{ $assignment->class->stream ? ' - ' . $assignment->class->stream : '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->subject->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->due_date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $assignment->max_score }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('teacher.assignments.edit', $assignment->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <a href="{{ route('teacher.assignments.grade', $assignment->id) }}" class="text-green-600 hover:underline ml-2">Grade</a>
                            <form action="{{ route('teacher.assignments.destroy', $assignment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $assignments->links() }}
        </div>
    </div>
@endsection
