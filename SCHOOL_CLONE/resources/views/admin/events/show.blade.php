<x-app-layout>
    <!-- Custom Styles for AWS-inspired UI -->
    <style>
        :root {
            --aws-navy: #1a2538;
            --aws-dark-navy: #0f172a;
            --aws-orange: #ec7211;
            --aws-orange-hover: #f28a38;
            --aws-border: #4b5563;
            --aws-text-light: #d1d5db;
            --aws-green: #10b981;
            --aws-red: #ef4444;
            --aws-yellow: #facc15;
            --aws-blue: #3b82f6;
            --aws-background: #111827;
        }

        .aws-sidebar {
            background-color: var(--aws-dark-navy);
            color: var(--aws-text-light);
            min-height: 100vh;
            padding: 1.5rem;
            width: 16rem;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
        }

        .aws-sidebar a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--aws-text-light);
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .aws-sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .aws-sidebar a.active {
            background-color: var(--aws-orange);
            color: var(--aws-navy);
        }

        .aws-content {
            margin-left: 16rem;
            padding: 2rem;
            background-color: var(--aws-background);
            min-height: 100vh;
        }

        .aws-card {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--aws-border);
            border-radius: 0.75rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .aws-card:hover {
            transform: translateY(-2px);
        }

        .aws-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: background-color 0.2s, transform 0.1s;
        }

        .aws-btn:hover {
            transform: translateY(-1px);
        }

        .aws-btn:active {
            transform: translateY(0);
        }
    </style>

    <!-- Sidebar -->
    <div class="aws-sidebar">
        <div class="flex items-center mb-8">
            <svg viewBox="0 0 316 316" class="w-8 h-8 mr-2 text-[var(--aws-orange)]" xmlns="http://www.w3.org/2000/svg">
                <path class="fill-[var(--aws-orange)]" d="M60 200 C60 180, 80 160, 158 160 C236 160, 256 180, 256 200 V240 C256 260, 236 280, 158 280 C80 280, 60 260, 60 240 V200 Z"/>
                <path class="fill-[var(--aws-text-light)]" d="M80 200 C80 190, 90 180, 158 180 C226 180, 236 190, 236 200 V230 C236 240, 226 250, 158 250 C90 250, 80 240, 80 230 V200 Z"/>
                <path class="fill-[var(--aws-navy)]" d="M148 120 H168 V160 H148 Z"/>
                <path class="fill-[var(--aws-orange)]" d="M158 80 C150 80, 146 90, 148 100 C150 110, 166 110, 168 100 C170 90, 166 80, 158 80 Z"/>
            </svg>
            <h1 class="text-xl font-semibold">The S.M.S</h1>
        </div>
        <div class="flex items-center mb-6">
            <div class="w-10 h-10 bg-[var(--aws-orange)] rounded-full flex items-center justify-center mr-3">
                <span class="text-[var(--aws-navy)] font-bold">AD</span>
            </div>
            <div>
                <p class="text-sm font-medium">Admin</p>
                <p class="text-xs text-[var(--aws-text-light)] opacity-75">Admin Access</p>
            </div>
        </div>
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Manage Users
            </a>
            <a href="{{ route('admin.events.index') }}" class="active">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Manage Events
            </a>
            <a href="#">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Reports
            </a>
            <a href="#">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Calendar
            </a>
            <a href="#">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Settings
            </a>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="flex items-center px-4 py-3 text-gray-300 hover:bg-slate-700 rounded-lg group hover:text-white transition-colors">
                    <x-icon name="logout" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-yellow-500" />
                    <span class="text-sm font-medium">Logout</span>
                </a>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="aws-content">
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-white leading-tight">
                    {{ $schoolEvent->title }}
                </h2>
                <span class="inline-flex px-3 py-1 text-sm rounded-full {{ \Carbon\Carbon::parse($schoolEvent->event_date)->isPast() ? 'bg-[var(--aws-border)] text-[var(--aws-text-light)]' : 'bg-[var(--aws-green)] text-white' }}">
                    {{ \Carbon\Carbon::parse($schoolEvent->event_date)->isPast() ? 'Past Event' : 'Upcoming Event' }}
                </span>
            </div>
        </x-slot>

        <!-- Status Alert -->
        @if (session('status'))
            <div class="aws-card bg-[var(--aws-green)]/10 border-l-4 border-[var(--aws-green)] text-[var(--aws-text-light)] p-4 mb-6 rounded shadow-sm" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-[var(--aws-green)]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('status') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Event Details Card -->
        <div class="aws-card mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-white">Event Details</h3>
                    <div class="space-x-2">
                        <a href="{{ route('admin.events.edit', $schoolEvent->id) }}" class="aws-btn bg-[var(--aws-yellow)] text-[var(--aws-navy)] hover:bg-[var(--aws-yellow)]/80">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.events.delete', $schoolEvent->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="aws-btn bg-[var(--aws-red)] text-white hover:bg-[var(--aws-red)]/80"
                                    onclick="return confirm('Are you sure you want to delete this event?')">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Event Description -->
                <div class="mb-8">
                    <h4 class="text-md font-medium text-[var(--aws-text-light)] mb-2">Description</h4>
                    <div class="bg-[var(--aws-navy)]/50 p-4 rounded-md text-[var(--aws-text-light)]">
                        {{ $schoolEvent->description }}
                    </div>
                </div>

                <!-- Event Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Event Date & Time -->
                    <div class="bg-[var(--aws-navy)]/50 p-4 rounded-md">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-[var(--aws-orange)] mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <h4 class="text-md font-medium text-[var(--aws-text-light)]">Date & Time</h4>
                        </div>
                        <div class="ml-7">
                            <p class="text-[var(--aws-text-light)] font-medium">
                                {{ \Carbon\Carbon::parse($schoolEvent->event_date)->format('l, M d, Y') }}
                            </p>
                            <p class="text-[var(--aws-text-light)] opacity-75 mt-1">
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
                    <div class="bg-[var(--aws-navy)]/50 p-4 rounded-md">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-[var(--aws-orange)] mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            <h4 class="text-md font-medium text-[var(--aws-text-light)]">Location</h4>
                        </div>
                        <div class="ml-7">
                            <p class="text-[var(--aws-text-light)]">
                                {{ $schoolEvent->location ?? 'Location not specified' }}
                            </p>
                        </div>
                    </div>

                    <!-- Event Organizer -->
                    <div class="bg-[var(--aws-navy)]/50 p-4 rounded-md">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-[var(--aws-orange)] mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <h4 class="text-md font-medium text-[var(--aws-text-light)]">Organizer</h4>
                        </div>
                        <div class="ml-7">
                            <p class="text-[var(--aws-text-light)]">{{ $schoolEvent->organizer->firstName }} {{ $schoolEvent->organizer->lastName }}</p>
                            @if($schoolEvent->organizer->email)
                                <p class="text-[var(--aws-text-light)] opacity-75 mt-1">{{ $schoolEvent->organizer->email }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Created/Updated Information -->
                    <div class="bg-[var(--aws-navy)]/50 p-4 rounded-md">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-[var(--aws-orange)] mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <h4 class="text-md font-medium text-[var(--aws-text-light)]">Event Info</h4>
                        </div>
                        <div class="ml-7">
                            <p class="text-[var(--aws-text-light)] opacity-75 text-sm">Created: {{ $schoolEvent->created_at->format('M d, Y') }}</p>
                            <p class="text-[var(--aws-text-light)] opacity-75 text-sm mt-1">Last Updated: {{ $schoolEvent->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex items-center space-x-4 pt-4 border-t border-[var(--aws-border)]">
                    <a href="{{ route('admin.events.index') }}" class="aws-btn bg-[var(--aws-navy)] text-white border border-[var(--aws-border)] hover:bg-[var(--aws-dark-navy)]">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
