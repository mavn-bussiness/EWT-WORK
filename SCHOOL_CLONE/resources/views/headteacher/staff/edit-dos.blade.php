<x-app-layout title="Edit Dean of Students">
    <x-card>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Edit Dean of Students</h2>
            </div>
        </x-slot>
        
        <form action="{{ route('headteacher.staff.update.dos', $deanOfStudent) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-input-group label="First Name" name="firstName" :value="$deanOfStudent->user->firstName" required />
                <x-input-group label="Last Name" name="lastName" :value="$deanOfStudent->user->lastName" required />
                <x-input-group label="Email" name="email" type="email" :value="$deanOfStudent->user->email" required />
                <x-input-group label="Phone Number" name="phoneNumber" :value="$deanOfStudent->phoneNumber" required />
                <x-input-group label="Department" name="department" :value="$deanOfStudent->department" required />
            </div>
            
            <div class="mt-6 flex justify-between">
                <a href="{{ route('headteacher.staff.dos') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    Cancel
                </a>
                <div>
                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded mr-2" 
                            onclick="document.getElementById('delete-dos-form').submit();">
                        Delete
                    </button>
                    <x-button type="submit">
                        Update DOS
                    </x-button>
                </div>
            </div>
        </form>
        
        <form id="delete-dos-form" action="{{ route('headteacher.staff.delete.dos', $deanOfStudent) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </x-card>
</x-app-layout>