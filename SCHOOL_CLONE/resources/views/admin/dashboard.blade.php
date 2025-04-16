<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Users</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['users'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Teachers</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['teachers'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Students</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['students'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Events</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['events'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Upcoming Events</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['upcoming_events'] }}</p>
                </div>
            </div>

            <!-- Admin Modules -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- User Management Module -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Users Management</h3>
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                View All Users
                            </a>
                        </div>
                        
                        <div class="mb-4">
                            <a href="{{ route('admin.users.create') }}" class="text-blue-600 hover:text-blue-800">
                                <span class="mr-1">+</span> Add New User
                            </a>
                        </div>
                        
                        <!-- Recent Users Preview -->
                        <h4 class="font-medium text-gray-700 mb-2">Recently Added Users</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-3 text-left text-xs">Name</th>
                                        <th class="py-2 px-3 text-left text-xs">Role</th>
                                        <th class="py-2 px-3 text-left text-xs">Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentUsers as $user)
                                        <tr class="border-t">
                                            <td class="py-2 px-3 text-sm">{{ $user->firstName }} {{ $user->lastName }}</td>
                                            <td class="py-2 px-3 text-sm">{{ ucfirst($user->role) }}</td>
                                            <td class="py-2 px-3 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Event Management Module -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Events Management</h3>
                            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                View All Events
                            </a>
                        </div>
                        
                        <div class="mb-4">
                            <a href="{{ route('admin.events.create') }}" class="text-green-600 hover:text-green-800">
                                <span class="mr-1">+</span> Add New Event
                            </a>
                        </div>
                        
                        <!-- Upcoming Events Preview -->
                        <h4 class="font-medium text-gray-700 mb-2">Upcoming Events</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-3 text-left text-xs">Event</th>
                                        <th class="py-2 px-3 text-left text-xs">Date</th>
                                        <th class="py-2 px-3 text-left text-xs">Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($upcomingEvents as $event)
                                        <tr class="border-t">
                                            <td class="py-2 px-3 text-sm">{{ $event->title }}</td>
                                            <td class="py-2 px-3 text-sm">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                                            <td class="py-2 px-3 text-sm">{{ $event->location ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                    
                                    @if(count($upcomingEvents) == 0)
                                        <tr class="border-t">
                                            <td colspan="3" class="py-2 px-3 text-sm text-center text-gray-500">No upcoming events</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('admin.users.create') }}" class="block p-4 bg-blue-50 rounded-lg hover:bg-blue-100 text-center">
                            <div class="font-semibold text-blue-700">Add User</div>
                        </a>
                        <a href="{{ route('admin.events.create') }}" class="block p-4 bg-green-50 rounded-lg hover:bg-green-100 text-center">
                            <div class="font-semibold text-green-700">Create Event</div>
                        </a>
                        <!-- Add more quick actions as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>