@extends('teacher.layout')

@section('title', 'Mark Attendance')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-6">Mark Attendance: {{ $class->name }}{{ $class->stream ? ' - ' . $class->stream : '' }}</h2>

        <form action="{{ route('teacher.attendance.store', $class->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
            @csrf

            <div class="mb-4">
                <p><strong>Date:</strong> {{ now()->format('Y-m-d') }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach ($students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <select name="statuses[{{ $student->id }}]" class="border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select</option>
                                    <option value="present" {{ $student->attendance->first()?->status == 'present' ? 'selected' : '' }}>Present</option>
                                    <option value="absent" {{ $student->attendance->first()?->status == 'absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="late" {{ $student->attendance->first()?->status == 'late' ? 'selected' : '' }}>Late</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="text" name="remarks[{{ $student->id }}]"
                                       value="{{ $student->attendance->first()?->remarks ?? '' }}"
                                       class="border-gray-300 rounded-md shadow-sm w-full">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Attendance</button>
            </div>
        </form>
    </div>
@endsection
