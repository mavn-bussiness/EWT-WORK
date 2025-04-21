<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Event: ') . $schoolEvent->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.events.update', $schoolEvent->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-label for="title" :value="__('Title')" class="required" />
                            <x-input id="title" type="text" name="title" :value="old('title', $schoolEvent->title)" class="block mt-1 w-full" required autofocus />
                        </div>

                        <div class="mb-4">
                            <x-label for="description" :value="__('Description')" class="required" />
                            <textarea id="description" name="description" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required rows="4">{{ old('description', $schoolEvent->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <x-label for="event_date" :value="__('Event Date')" class="required" />
                            <x-input id="event_date" type="date" name="event_date" :value="old('event_date', $schoolEvent->event_date->format('Y-m-d'))" class="block mt-1 w-full" required />
                        </div>

                        <div class="mb-4">
                            <x-label for="start_time" :value="__('Start Time')" />
                            <x-input id="start_time" type="time" name="start_time" :value="old('start_time', $schoolEvent->start_time ? $schoolEvent->start_time->format('H:i') : '')" class="block mt-1 w-full" />
                        </div>

                        <div class="mb-4">
                            <x-label for="end_time" :value="__('End Time')" />
                            <x-input id="end_time" type="time" name="end_time" :value="old('end_time', $schoolEvent->end_time ? $schoolEvent->end_time->format('H:i') : '')" class="block mt-1 w-full" />
                        </div>

                        <div class="mb-4">
                            <x-label for="location" :value="__('Location')" />
                            <x-input id="location" type="text" name="location" :value="old('location', $schoolEvent->location)" class="block mt-1 w-full" />
                        </div>

                        <div class="mb-4">
                            <x-label for="organizer_id" :value="__('Organizer')" class="required" />
                            <select id="organizer_id" name="organizer_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                <option value="">Select Organizer</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('organizer_id', $schoolEvent->organizer_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->firstName }} {{ $user->lastName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 bg-gray-300 rounded-md text-gray-800 hover:bg-gray-400 mr-2">
                                Cancel
                            </a>
                            <x-button class="ml-3">
                                {{ __('Update Event') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>