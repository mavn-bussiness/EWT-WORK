@extends('teacher.layout')

@section('title', 'Class Details')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-6">{{ $class->name }}{{ $class->stream ? ' - ' . $class->stream : '' }}</h2>

        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Subjects</h3>
            <div class="flex flex-wrap gap-4">
                @foreach ($subjects as $subject)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <p class="font-medium">{{ $subject->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <h3 class="text-xl font-semibold mb-4">Students</h3>
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->user->email }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
