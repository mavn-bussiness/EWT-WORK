<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Event Details</h3>
                        <div class="space-x-2">
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                Edit
                            </a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this event?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-md font-medium mb-2">Description:</h4>
                        <p class="text-gray-600">{{ $event->description }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-md font-medium mb-2">Date:</h4>
                            <p class="text-gray-600">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <h4 class="text-md font-medium mb-2">Time:</h4>
                            <p class="text-gray-600">
                                @if($event->start_time && $event->end_time)
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                @elseif($event->start_time)
                                    Starts at {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                @else
                                    Not specified
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-md font-medium mb-2">Location:</h4>
                            <p class="text-gray-600">{{ $event->location ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <h4 class="text-md font-medium mb-2">Organizer:</h4>
                            <p class="text-gray-600">{{ $event->organizer->firstName }} {{ $event->organizer->lastName }}</p>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('admin.events.index') }}" class="px-4 py-2 bg-gray-300 rounded-md text-gray-800 hover:bg-gray-400">
                            Back to Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>