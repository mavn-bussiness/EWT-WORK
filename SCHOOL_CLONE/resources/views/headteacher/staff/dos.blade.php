<x-app-layout title="Dean of Students Management">
    <x-card>
        <x-slot name="header">
            <h2 class="text-xl font-semibold">Dean of Students Management</h2>
        </x-slot>

        @if($currentDos)
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="font-medium text-lg mb-2">Current Dean of Students</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="font-medium">Name</p>
                    <p>{{ $currentDos->user->firstName }} {{ $currentDos->user->lastName }}</p>
                </div>
                <div>
                    <p class="font-medium">Department</p>
                    <p>{{ $currentDos->dos_department }}</p>
                </div>
                <div class="flex items-end">
                    <form action="{{ route('headteacher.staff.demote.dos', $currentDos) }}" method="POST">
                        @csrf @method('DELETE')
                        <x-button type="submit" variant="danger">Demote to Teacher</x-button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-6">
            <h3 class="font-medium text-lg mb-4">Promote Teacher to DOS</h3>
            <form action="{{ route('headteacher.staff.promote.dos') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input-group label="Select Teacher" name="teacher_id" type="select" required>
                        <option value="">-- Select Teacher --</option>
                        @foreach($teacherUsers as $user)
                        <option value="{{ $user->teacher_id }}">
                            {{ $user->firstName }} {{ $user->lastName }}
                        </option>
                        @endforeach
                    </x-input-group>

                    <x-input-group label="DOS Department" name="department" required />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-button type="submit">
                        {{ $currentDos ? 'Change DOS' : 'Assign DOS' }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-card>
</x-app-layout>