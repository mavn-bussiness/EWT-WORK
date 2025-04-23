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
            <a href="{{ route('admin.users.index') }}" class="active">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Manage Users
            </a>
            <a href="{{ route('admin.events.index') }}">
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
            <h2 class="text-2xl font-semibold text-white leading-tight">
                {{ __('User Details') }}
            </h2>
        </x-slot>

        <!-- User Details Card -->
        <div class="aws-card">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-lg font-semibold text-white">User Information</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="aws-btn bg-[var(--aws-yellow)] text-[var(--aws-navy)] hover:bg-[var(--aws-yellow)]/80">
                            Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="aws-btn bg-[var(--aws-red)] text-white hover:bg-[var(--aws-red)]/80">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Profile Section -->
                    <div class="md:col-span-1">
                        <div class="flex flex-col items-center">
                            @if ($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="h-40 w-40 object-cover rounded-full border-4 border-[var(--aws-border)]">
                            @else
                                <div class="h-40 w-40 rounded-full bg-[var(--aws-border)] flex items-center justify-center">
                                    <span class="text-[var(--aws-text-light)] text-4xl font-bold">{{ strtoupper(substr($user->firstName, 0, 1)) }}{{ strtoupper(substr($user->lastName, 0, 1)) }}</span>
                                </div>
                            @endif

                            <div class="mt-4 text-center">
                                <h3 class="font-bold text-lg text-white">{{ $user->firstName }} {{ $user->lastName }}</h3>
                                <p class="text-[var(--aws-text-light)]">{{ ucfirst($user->role) }}</p>

                                <div class="mt-2">
                                    @if ($user->is_active)
                                        <span class="px-2 py-1 bg-[var(--aws-green)]/20 text-[var(--aws-green)] rounded text-xs">Active</span>
                                    @else
                                        <span class="px-2 py-1 bg-[var(--aws-red)]/20 text-[var(--aws-red)] rounded text-xs">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information Section -->
                    <div class="md:col-span-2">
                        <div class="bg-[rgba(255,255,255,0.05)] p-4 rounded-lg">
                            <h4 class="font-semibold text-md text-white mb-4">Personal Information</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-[var(--aws-text-light)] opacity-75">First Name</p>
                                    <p class="font-medium text-[var(--aws-text-light)]">{{ $user->firstName }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-[var(--aws-text-light)] opacity-75">Last Name</p>
                                    <p class="font-medium text-[var(--aws-text-light)]">{{ $user->lastName }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-[var(--aws-text-light)] opacity-75">Other Name</p>
                                    <p class="font-medium text-[var(--aws-text-light)]">{{ $user->otherName ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-[var(--aws-text-light)] opacity-75">Email</p>
                                    <p class="font-medium text-[var(--aws-text-light)]">{{ $user->email ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-[var(--aws-text-light)] opacity-75">Role</p>
                                    <p class="font-medium text-[var(--aws-text-light)]">{{ ucfirst($user->role) }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-[var(--aws-text-light)] opacity-75">Status</p>
                                    <p class="font-medium text-[var(--aws-text-light)]">{{ $user->is_active ? 'Active' : 'Inactive' }}</p>
                                </div>
                            </div>

                            <h4 class="font-semibold text-md text-white mt-6 mb-4">System Information</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-[var(--aws-text-light)] opacity-75">Created At</p>
                                    <p class="font-medium text-[var(--aws-text-light)]">{{ $user->created_at->format('M d, Y H:i') }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-[var(--aws-text-light)] opacity-75">Last Updated</p>
                                    <p class="font-medium text-[var(--aws-text-light)]">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('admin.users.index') }}" class="text-[var(--aws-orange)] hover:text-[var(--aws-orange-hover)]">
                                ← Back to Users List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
