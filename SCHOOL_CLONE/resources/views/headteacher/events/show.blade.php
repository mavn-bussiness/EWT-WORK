<x-app-layout>
    <x-slot name="header" class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $schoolEvent->title }}
                </h2>
                <span class="inline-flex px-3 py-1 text-sm rounded-full 
                    {{ \Carbon\Carbon::parse($schoolEvent->event_date)->isPast() ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                    {{ \Carbon\Carbon::parse($schoolEvent->event_date)->isPast() ? 'Past Event' : 'Upcoming Event' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Alert -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Event Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Event Details</h3>
                        @if(!$schoolEvent->is_approved)
                            <form action="{{ route('headteacher.events.approve', $schoolEvent->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Approve Event
                                </button>
                            </form>
                        @else
                            <div class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded">
                                <svg class="w-4 h-4 mr-2 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Approved
                            </div>
                        @endif
                    </div>

                    <!-- Event Description -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-700 mb-2">Description</h4>
                        <div class="bg-gray-50 p-4 rounded-md text-gray-700">
                            {{ $schoolEvent->description }}
                        </div>
                    </div>

                    <!-- Event Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Event Date & Time -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-gray-600 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <h4 class="text-md font-medium text-gray-700">Date & Time</h4>
                            </div>
                            <div class="ml-7">
                                <p class="text-gray-700 font-medium">
                                    {{ \Carbon\Carbon::parse($schoolEvent->event_date)->format('l, M d, Y') }}
                                </p>
                                <p class="text-gray-600 mt-1">
                                    @if($schoolEvent->start_time && $schoolEvent->end_time)
                                        {{ \Carbon\Carbon::parse($schoolEvent->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($schoolEvent->end_time)->format('g:i A') }}
                                    @elseif($schoolEvent->start_time)
                                        Starts at {{ \Carbon\Carbon::parse($schoolEvent->start_time)->format('g:i A') }}
                                    @else
                                        Time not specified
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Event Location -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-gray-600 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <h4 class="text-md font-medium text-gray-700">Location</h4>
                            </div>
                            <div class="ml-7">
                                <p class="text-gray-700">
                                    {{ $schoolEvent->location ?? 'Location not specified' }}
                                </p>
                            </div>
                        </div>

                        <!-- Event Organizer -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-gray-600 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                <h4 class="text-md font-medium text-gray-700">Organizer</h4>
                            </div>
                            <div class="ml-7">
                                <p class="text-gray-700">{{ $schoolEvent->organizer->firstName }} {{ $schoolEvent->organizer->lastName }}</p>
                                @if($schoolEvent->organizer->email)
                                    <p class="text-gray-600 mt-1">{{ $schoolEvent->organizer->email }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Approval Status -->
                        <div class="bg-gray-50 p-4 rounded-md">
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-gray-600 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <h4 class="text-md font-medium text-gray-700">Status</h4>
                            </div>
                            <div class="ml-7">
                                @if($schoolEvent->is_approved)
                                    <p class="text-green-600">
                                        <span class="font-medium">Approved</span>
                                    </p>
                                @else
                                    <p class="text-yellow-600">
                                        <span class="font-medium">Pending Approval</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('headteacher.events.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300 transition-colors">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>