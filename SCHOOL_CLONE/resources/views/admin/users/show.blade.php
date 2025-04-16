<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-lg font-semibold">User Information</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                Edit
                            </a>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <div class="flex flex-col items-center">
                                @if ($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="h-40 w-40 object-cover rounded-full">
                                @else
                                    <div class="h-40 w-40 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-600 text-4xl font-bold">{{ strtoupper(substr($user->firstName, 0, 1)) }}{{ strtoupper(substr($user->lastName, 0, 1)) }}</span>
                                    </div>
                                @endif
                                
                                <div class="mt-4 text-center">
                                    <h3 class="font-bold text-lg">{{ $user->firstName }} {{ $user->lastName }}</h3>
                                    <p class="text-gray-600">{{ ucfirst($user->role) }}</p>
                                    
                                    <div class="mt-2">
                                        @if ($user->is_active)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Active</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-md mb-4">Personal Information</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">First Name</p>
                                        <p class="font-medium">{{ $user->firstName }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Last Name</p>
                                        <p class="font-medium">{{ $user->lastName }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Other Name</p>
                                        <p class="font-medium">{{ $user->otherName ?? 'N/A' }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="font-medium">{{ $user->email ?? 'N/A' }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Role</p>
                                        <p class="font-medium">{{ ucfirst($user->role) }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Status</p>
                                        <p class="font-medium">{{ $user->is_active ? 'Active' : 'Inactive' }}</p>
                                    </div>
                                </div>
                                
                                <h4 class="font-semibold text-md mt-6 mb-4">System Information</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Created At</p>
                                        <p class="font-medium">{{ $user->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Last Updated</p>
                                        <p class="font-medium">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800">
                                    &larr; Back to Users List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>