<x-app-layout>
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

        .aws-table th,
        .aws-table td {
            padding: 0.75rem 1rem;
            text-align: left;
        }

        .aws-table thead {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .aws-table tbody tr {
            border-top: 1px solid var(--aws-border);
            transition: background-color 0.2s;
        }

        .aws-table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
            background-color: var(--aws-border);
            color: var(--aws-text-light);
        }

        .modal-content {
            background-color: var(--aws-background);
            border: 1px solid var(--aws-border);
            color: var(--aws-text-light);
        }

        .modal-header {
            background-color: var(--aws-red);
            color: white;
            border-bottom: 1px solid var(--aws-border);
        }

        .modal-footer {
            border-top: 1px solid var(--aws-border);
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background-color: rgba(255, 255, 255, 0.05);
            border-top: 1px solid var(--aws-border);
            border-radius: 0 0 0.75rem 0.75rem;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .pagination .page-item {
            margin: 0;
        }

        .pagination .page-link {
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--aws-text-light);
            border: 1px solid var(--aws-border);
            border-radius: 0.5rem;
            margin: 0;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
        }

        .pagination .page-link:hover {
            background-color: var(--aws-orange);
            color: var(--aws-navy);
            border-color: var(--aws-orange);
            transform: scale(1.05);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--aws-orange);
            color: var(--aws-navy);
            border-color: var(--aws-orange);
            box-shadow: 0 0 10px rgba(236, 114, 17, 0.5);
        }

        .pagination .page-item.disabled .page-link {
            background-color: rgba(255, 255, 255, 0.02);
            color: var(--aws-text-light);
            opacity: 0.5;
            border-color: var(--aws-border);
        }

        .pagination-stats {
            color: var(--aws-text-light);
            font-size: 0.9rem;
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
                {{ __('User Management') }}
            </h2>
        </x-slot>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="aws-card bg-[var(--aws-green)]/10 border-l-4 border-[var(--aws-green)] text-[var(--aws-text-light)] p-4 mb-6 rounded shadow-sm" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-[var(--aws-green)]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="ml-auto text-[var(--aws-text-light)] hover:text-white" data-bs-dismiss="alert" aria-label="Close">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Users Table -->
        <div class="aws-card">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-white">All Users</h3>
                    <a href="{{ route('admin.users.create') }}" class="aws-btn bg-[var(--aws-orange)] text-[var(--aws-navy)] hover:bg-[var(--aws-orange-hover)]">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New User
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table id="usersTable" class="aws-table min-w-full">
                        <thead>
                        <tr>
                            <th class="text-xs text-[var(--aws-text-light)]">ID</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Name</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Email</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Role</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Status</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Created</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="text-sm text-[var(--aws-text-light)]">
                                    <span class="font-medium">{{ $user->id }}</span>
                                </td>
                                <td class="text-sm text-[var(--aws-text-light)]">
                                    <div class="flex items-center">
                                        <div class="avatar-circle mr-2">
                                            {{ substr($user->firstName, 0, 1) }}{{ substr($user->lastName, 0, 1) }}
                                        </div>
                                        <span>{{ $user->firstName }} {{ $user->lastName }}</span>
                                    </div>
                                </td>
                                <td class="text-sm text-[var(--aws-text-light)]">{{ $user->email }}</td>
                                <td class="text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs rounded-full
                                            {{ $user->role === 'admin' ? 'bg-[var(--aws-red)]/20 text-[var(--aws-red)]' :
                                            ($user->role === 'teacher' ? 'bg-[var(--aws-blue)]/20 text-[var(--aws-blue)]' :
                                            ($user->role === 'headteacher' ? 'bg-[var(--aws-orange)]/20 text-[var(--aws-orange)]' :
                                            ($user->role === 'dos' ? 'bg-[var(--aws-yellow)]/20 text-[var(--aws-yellow)]' : 'bg-[var(--aws-border)]/20 text-[var(--aws-text-light)]')))}}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                </td>
                                <td class="text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs rounded-full
                                            {{ $user->is_active ? 'bg-[var(--aws-green)]/20 text-[var(--aws-green)]' : 'bg-[var(--aws-red)]/20 text-[var(--aws-red)]' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                </td>
                                <td class="text-sm text-[var(--aws-text-light)]">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="aws-btn bg-[var(--aws-blue)]/20 text-[var(--aws-blue)] hover:bg-[var(--aws-blue)]/30" data-bs-toggle="tooltip" title="View User">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="aws-btn bg-[var(--aws-yellow)]/20 text-[var(--aws-yellow)] hover:bg-[var(--aws-yellow)]/30" data-bs-toggle="tooltip" title="Edit User">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <button type="button" class="aws-btn bg-[var(--aws-red)]/20 text-[var(--aws-red)] hover:bg-[var(--aws-red)]/30"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->firstName }} {{ $user->lastName }}"
                                                data-user-url="{{ route('admin.users.destroy', $user->id) }}"
                                                data-bs-toggle="tooltip"
                                                title="Delete User">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-container">
                    <!-- Items Per Page Dropdown -->
                    <div class="items-per-page">
                        <select id="items-per-page" onchange="updateItemsPerPage(this.value)">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                        </select>
                    </div>

                    <!-- Right side with stats and pagination -->
                    <div class="flex flex-col items-end gap-2">
                        <!-- Pagination Stats -->
                        <div class="pagination-stats">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                        </div>

                        <!-- Custom Horizontal Pagination Links -->
                        <div class="pagination">
                            <!-- Previous Page Link -->
                            @if ($users->onFirstPage())
                                <span class="page-item disabled">
                                    <span class="page-link">&laquo; Previous</span>
                                </span>
                            @else
                                <a class="page-item" href="{{ $users->previousPageUrl() }}">
                                    <span class="page-link">&laquo; Previous</span>
                                </a>
                            @endif

                            <!-- First Page and Ellipsis -->
                            @if($users->currentPage() > 3)
                                <a class="page-item" href="{{ $users->url(1) }}">
                                    <span class="page-link">1</span>
                                </a>

                                @if($users->currentPage() > 4)
                                    <span class="page-item disabled">
                                        <span class="page-link">&hellip;</span>
                                    </span>
                                @endif
                            @endif

                            <!-- Page Number Links -->
                            @foreach(range(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page)
                                @if ($page == $users->currentPage())
                                    <span class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </span>
                                @else
                                    <a class="page-item" href="{{ $users->url($page) }}">
                                        <span class="page-link">{{ $page }}</span>
                                    </a>
                                @endif
                            @endforeach

                            <!-- Last Page and Ellipsis -->
                            @if($users->currentPage() < $users->lastPage() - 2)
                                @if($users->currentPage() < $users->lastPage() - 3)
                                    <span class="page-item disabled">
                                        <span class="page-link">&hellip;</span>
                                    </span>
                                @endif

                                <a class="page-item" href="{{ $users->url($users->lastPage()) }}">
                                    <span class="page-link">{{ $users->lastPage() }}</span>
                                </a>
                            @endif

                            <!-- Next Page Link -->
                            @if ($users->hasMorePages())
                                <a class="page-item" href="{{ $users->nextPageUrl() }}">
                                    <span class="page-link">Next &raquo;</span>
                                </a>
                            @else
                                <span class="page-item disabled">
                                    <span class="page-link">Next &raquo;</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        <!-- Single Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <svg class="h-12 w-12 text-[var(--aws-yellow)] mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 4a8 8 0 100 16 8 8 0 000-16z" />
                            </svg>
                        </div>
                        <p class="text-center text-lg">Are you sure you want to delete user:</p>
                        <p class="text-center font-bold text-lg" id="delete-user-name"></p>
                        <p class="text-center text-[var(--aws-text-light)] opacity-75 text-sm">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="aws-btn bg-[var(--aws-border)] text-[var(--aws-text-light)] hover:bg-[var(--aws-border)]/80" data-bs-dismiss="modal">
                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Cancel
                        </button>
                        <form id="delete-user-form" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="aws-btn bg-[var(--aws-red)] text-white hover:bg-[var(--aws-red)]/80">
                                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

            <x-slot:scripts>
                <script>
                    $(document).ready(function() {
                        // Initialize DataTable WITHOUT pagination, ordering only
                        const table = $('#usersTable').DataTable({
                            responsive: true,
                            paging: false,  // Disable DataTables pagination
                            searching: true,
                            ordering: true,
                            info: false,    // Hide "Showing X to Y of Z entries"
                            language: {
                                search: "<i class='fas fa-search'></i>",
                                searchPlaceholder: "Search users..."
                            },
                            dom: "<'row'<'col-sm-12'f>>" +
                                "<'row'<'col-sm-12'tr>>",
                        });

                        // Initialize tooltips
                        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });

                        // Auto hide alerts after 5 seconds
                        setTimeout(function() {
                            $('.alert').alert('close');
                        }, 5000);

                        // Handle delete modal data population
                        $('#deleteModal').on('show.bs.modal', function (event) {
                            const button = $(event.relatedTarget);
                            const userId = button.data('user-id');
                            const userName = button.data('user-name');
                            const userUrl = button.data('user-url');

                            const modal = $(this);
                            modal.find('#delete-user-name').text(userName);
                            modal.find('#delete-user-form').attr('action', userUrl);
                        });
                    });

                    // Function to update items per page
                    function updateItemsPerPage(perPage) {
                        const url = new URL(window.location.href);
                        url.searchParams.set('per_page', perPage);
                        window.location.href = url.toString();
                    }
                </script>
            </x-slot:scripts>
</x-app-layout>
