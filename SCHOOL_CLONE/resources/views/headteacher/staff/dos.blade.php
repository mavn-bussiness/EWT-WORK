<x-app-layout title="Dean of Students Management">
    @if($dosList->isEmpty())
        <x-card>
            <x-slot name="header">
                <h2 class="text-xl font-semibold">Register New Dean of Students</h2>
            </x-slot>
            
            <form action="{{ route('headteacher.staff.register.dos') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input-group label="First Name" name="firstName" required />
                    <x-input-group label="Last Name" name="lastName" required />
                    <x-input-group label="Email" name="email" type="email" required />
                    <x-input-group label="Phone Number" name="phoneNumber" required />
                    <x-input-group label="Department" name="department" required />
                </div>
                
                <div class="mt-6 flex justify-end">
                    <x-button type="submit">
                        Register DOS
                    </x-button>
                </div>
            </form>
        </x-card>
    @endif

    <x-card class="mt-6">
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Current Dean of Students</h2>
                @if($dosList->isNotEmpty())
                    <span class="text-sm text-gray-500">Only one DOS can exist at a time</span>
                @endif
            </div>
        </x-slot>
        
        @if($dosList->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($dosList as $dos)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $dos->user->firstName }} {{ $dos->user->lastName }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $dos->department }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $dos->phoneNumber }}<br>
                                    {{ $dos->user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-status-badge :status="$dos->user->is_active ? 'active' : 'inactive'" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('headteacher.staff.edit.dos', $dos) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <form action="{{ route('headteacher.staff.delete.dos', $dos) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this DOS?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No Dean of Students registered yet. Use the form above to register one.</p>
        @endif
    </x-card>
</x-app-layout>