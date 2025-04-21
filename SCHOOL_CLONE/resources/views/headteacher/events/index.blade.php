<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('School Events Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">School Events</h3>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left">Title</th>
                                    <th class="py-3 px-4 text-left">Date</th>
                                    <th class="py-3 px-4 text-left">Time</th>
                                    <th class="py-3 px-4 text-left">Location</th>
                                    <th class="py-3 px-4 text-left">Organizer</th>
                                    <th class="py-3 px-4 text-left">Status</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr class="border-t">
                                        <td class="py-3 px-4">{{ $event->title }}</td>
                                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                                        <td class="py-3 px-4">
                                            @if($event->start_time)
                                                {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                                @if($event->end_time)
                                                    - {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                                @endif
                                            @else
                                                All Day
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">{{ $event->location ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ $event->organizer->firstName }} {{ $event->organizer->lastName }}</td>
                                        <td class="py-3 px-4">
                                            @if($event->is_approved)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Approved</span>
                                            @else
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('headteacher.events.show', $event->id) }}" class="text-blue-600 hover:text-blue-800">
                                                    View
                                                </a>
                                                @if(!$event->is_approved)
                                                    <form action="{{ route('headteacher.events.approve', $event->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-800">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                @if(count($events) == 0)
                                    <tr class="border-t">
                                        <td colspan="7" class="py-3 px-4 text-center text-gray-500">No events found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>