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

        .aws-stat-card {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--aws-border);
            border-radius: 0.75rem;
            backdrop-filter: blur(10px);
            transition: transform 0.2s;
        }

        .aws-stat-card:hover {
            transform: translateY(-2px);
        }

        .aws-select {
            appearance: none;
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--aws-text-light);
            border: 1px solid var(--aws-border);
            border-radius: 0.5rem;
            padding: 0.5rem 2rem 0.5rem 1rem;
            font-size: 0.875rem;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .aws-select:hover {
            border-color: var(--aws-orange);
        }

        .aws-select:focus {
            outline: none;
            border-color: var(--aws-orange);
            box-shadow: 0 0 5px rgba(236, 114, 17, 0.3);
        }

        .aws-select-wrapper {
            position: relative;
        }

        .aws-select-wrapper::after {
            content: '\25BC';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--aws-text-light);
            pointer-events: none;
        }

        .aws-progress {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            height: 1rem;
        }

        .aws-progress-bar {
            border-radius: 0.5rem;
            transition: width 0.3s ease;
        }

        .aws-list-group-item {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--aws-border);
            color: var(--aws-text-light);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: background-color 0.2s;
        }

        .aws-list-group-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .aws-badge {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
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
                <span class="text-[var(--aws-navy)] font-bold">AC</span>
            </div>
            <div>
                <p class="text-sm font-medium">Accounts Clerk</p>
                <p class="text-xs text-[var(--aws-text-light)] opacity-75">Accounts Clerk Access</p>
            </div>
        </div>
        <nav class="space-y-2">
            <a href="{{ route('bursar.dashboard') }}" class="active">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('bursar.fees.index') }}">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.657 0 3 .895 3 2s-1.343 2-3 2m0 0v6m0-6c-1.657 0-3-.895-3-2s1.343-2 3-2z" />
                </svg>
                Manage Fees
            </a>
            <a href="{{ route('bursar.expenses.index') }}">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v_clause: "M12 8c-1.657 0-3-.895-3-2s1.343-2 3-2m0 0v6m0-6c1.657 0 3 .895 3 2s-1.343 2-3 2m0 0v6m0-6c-1.657 0-3-.895-3-2s1.343-2 3-2z" />
                </svg>
                Manage Expenses
            </a>
            <a href="{{ route('bursar.transactions.index') }}">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2m-1 11h12a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2zm-5-9h4" />
                </svg>
                Transactions
            </a>
            <a href="{{ route('bursar.reports.index') }}">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Reports
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="aws-content">
        <x-slot name="header">
            <h2 class="text-2xl font-semibold text-white leading-tight">
                {{ __('Accounts Clerk Dashboard') }}
            </h2>
        </x-slot>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="aws-stat-card p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-[var(--aws-text-light)] opacity-75">Total Transactions</p>
                        <p class="text-2xl font-semibold text-white">{{ $stats['total_transactions'] }}</p>
                    </div>
                    <svg class="w-8 h-8 text-[var(--aws-blue)] opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2m-1 11h12a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2zm-5-9h4" />
                    </svg>
                </div>
                <a href="{{ route('bursar.transactions.index') }}" class="text-[var(--aws-orange)] hover:text-[var(--aws-orange-hover)] text-sm mt-2 block">View Details →</a>
            </div>
            <div class="aws-stat-card p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-[var(--aws-text-light)] opacity-75">Daily Collection</p>
                        <p class="text-2xl font-semibold text-white">{{ config('app.currency', 'UGX') }} {{ number_format($stats['daily_collection'], 2) }}</p>
                    </div>
                    <svg class="w-8 h-8 text-[var(--aws-green)] opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3-.895-3-2s1.343-2 3-2m0 0v6m0-6c1.657 0 3 .895 3 2s-1.343 2-3 2m0 0v6" />
                    </svg>
                </div>
                <a href="{{ route('bursar.payments.today') }}" class="text-[var(--aws-orange)] hover:text-[var(--aws-orange-hover)] text-sm mt-2 block">View Details →</a>
            </div>
            <div class="aws-stat-card p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-[var(--aws-text-light)] opacity-75">Pending Records</p>
                        <p class="text-2xl font-semibold text-white">{{ $stats['pending_records'] }}</p>
                    </div>
                    <svg class="w-8 h-8 text-[var(--aws-yellow)] opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 4a8 8 0 100 16 8 8 0 000-16z" />
                    </svg>
                </div>
                <a href="{{ route('bursar.records.pending') }}" class="text-[var(--aws-orange)] hover:text-[var(--aws-orange-hover)] text-sm mt-2 block">View Details →</a>
            </div>
            <div class="aws-stat-card p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-[var(--aws-text-light)] opacity-75">Reports Generated</p>
                        <p class="text-2xl font-semibold text-white">{{ $stats['reports_count'] }}</p>
                    </div>
                    <svg class="w-8 h-8 text-[var(--aws-blue)] opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <a href="{{ route('bursar.reports.index') }}" class="text-[var(--aws-orange)] hover:text-[var(--aws-orange-hover)] text-sm mt-2 block">View Details →</a>
            </div>
        </div>

        <!-- Recent Transactions and Quick Entry -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-2">
                <div class="aws-card">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[var(--aws-orange)]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Recent Financial Transactions
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="aws-table min-w-full">
                                <thead>
                                <tr>
                                    <th class="text-xs text-[var(--aws-text-light)]">Reference</th>
                                    <th class="text-xs text-[var(--aws-text-light)]">Account</th>
                                    <th class="text-xs text-[var(--aws-text-light)]">Type</th>
                                    <th class="text-xs text-[var(--aws-text-light)]">Amount</th>
                                    <th class="text-xs text-[var(--aws-text-light)]">Category</th>
                                    <th class="text-xs text-[var(--aws-text-light)]">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($recentTransactions as $transaction)
                                    <tr>
                                        <td class="text-sm text-[var(--aws-text-light)]">{{ $transaction->reference_number }}</td>
                                        <td class="text-sm text-[var(--aws-text-light)]">{{ $transaction->account->account_name }}</td>
                                        <td class="text-sm">
                                                <span class="aws-badge {{ $transaction->type == 'income' ? 'bg-[var(--aws-green)]/20 text-[var(--aws-green)]' : 'bg-[var(--aws-red)]/20 text-[var(--aws-red)]' }}">
                                                    {{ ucfirst($transaction->type) }}
                                                </span>
                                        </td>
                                        <td class="text-sm text-[var(--aws-text-light)]">{{ config('app.currency', 'UGX') }} {{ number_format($transaction->amount, 2) }}</td>
                                        <td class="text-sm text-[var(--aws-text-light)]">{{ $transaction->transaction_category }}</td>
                                        <td class="text-sm text-[var(--aws-text-light)]">{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-sm text-[var(--aws-text-light)] text-center py-4">No recent transactions</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('bursar.transactions.index') }}" class="aws-btn bg-[var(--aws-orange)] text-[var(--aws-navy)] hover:bg-[var(--aws-orange-hover)]">
                                View All Transactions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-1">
                <div class="aws-card mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[var(--aws-orange)]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Quick Record Entry
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('bursar.fees.index') }}" class="aws-list-group-item flex justify-between items-center p-3">
                                <span>
                                    <svg class="w-4 h-4 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3-.895-3-2s1.343-2 3-2m0 0v6m0-6c1.657 0 3 .895 3 2s-1.343 2-3 2m0 0v6" />
                                    </svg>
                                    Record Fee Payment
                                </span>
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <a href="{{ route('bursar.expenses.create') }}" class="aws-list-group-item flex justify-between items-center p-3">
                                <span>
                                    <svg class="w-4 h-4 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Record Expense
                                </span>
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <a href="{{ route('bursar.transactions.create') }}" class="aws-list-group-item flex justify-between items-center p-3">
                                <span>
                                    <svg class="w-4 h-4 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2m-1 11h12a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2zm-5-9h4" />
                                    </svg>
                                    Record Transaction
                                </span>
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <a href="{{ route('bursar.reports.generate') }}" class="aws-list-group-item flex justify-between items-center p-3">
                                <span>
                                    <svg class="w-4 h-4 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Generate Report
                                </span>
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="aws-card">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[var(--aws-orange)]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405M9 17H4l1.405-1.405M12 3v18m0-9H7.757l-1.436 1.436M12 12h4.243l1.436-1.436" />
                            </svg>
                            Notifications
                        </h3>
                        <div class="space-y-2">
                            @forelse($notifications as $notification)
                                <div class="aws-list-group-item flex justify-between items-center p-3">
                                    <div>
                                        <p class="text-xs text-[var(--aws-text-light)] opacity-75">{{ $notification->created_at->diffForHumans() }}</p>
                                        <p class="text-sm text-[var(--aws-text-light)]">{{ $notification->message }}</p>
                                    </div>
                                    @if(!$notification->is_read)
                                        <span class="aws-badge bg-[var(--aws-red)]/20 text-[var(--aws-red)]">New</span>
                                    @endif
                                </div>
                            @empty
                                <div class="text-sm text-[var(--aws-text-light)] text-center py-4">No new notifications</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fee Records -->
        <div class="aws-card">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[var(--aws-orange)]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Fee Records by Class
                    </h3>
                    <div class="aws-select-wrapper">
                        <select class="aws-select" id="termSelector">
                            @foreach($terms as $term)
                                <option value="{{ $term->id }}" {{ $currentTerm->id == $term->id ? 'selected' : '' }}>
                                    {{ $term->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="aws-table min-w-full">
                        <thead>
                        <tr>
                            <th class="text-xs text-[var(--aws-text-light)]">Class</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Total Students</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Expected Amount</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Collected Amount</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Outstanding</th>
                            <th class="text-xs text-[var(--aws-text-light)]">Collection Rate</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($classRecords as $record)
                            <tr>
                                <td class="text-sm text-[var(--aws-text-light)]">{{ $record->class_name }}</td>
                                <td class="text-sm text-[var(--aws-text-light)]">{{ $record->total_students }}</td>
                                <td class="text-sm text-[var(--aws-text-light)]">{{ config('app.currency', 'UGX') }} {{ number_format($record->expected_amount, 2) }}</td>
                                <td class="text-sm text-[var(--aws-text-light)]">{{ config('app.currency', 'UGX') }} {{ number_format($record->collected_amount, 2) }}</td>
                                <td class="text-sm text-[var(--aws-text-light)]">{{ config('app.currency', 'UGX') }} {{ number_format($record->outstanding_amount, 2) }}</td>
                                <td class="text-sm text-[var(--aws-text-light)]">
                                    <div class="aws-progress">
                                        <div class="aws-progress-bar {{ $record->collection_rate >= 90 ? 'bg-[var(--aws-green)]' : ($record->collection_rate >= 70 ? 'bg-[var(--aws-blue)]' : 'bg-[var(--aws-yellow)]') }}"
                                             style="width: {{ $record->collection_rate }}%;">
                                            {{ $record->collection_rate }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            document.getElementById('termSelector').addEventListener('change', function() {
                window.location.href = '{{ route("bursar.dashboard") }}?term_id=' + this.value;
            });
        </script>
        @if(session('success'))
            <script>
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    style: {
                        background: "linear-gradient(to right, var(--aws-green), var(--aws-blue))"
                    }
                }).showToast();
            </script>
        @endif
        @if(session('error'))
            <script>
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 3000,
                    style: {
                        background: "linear-gradient(to right, var(--aws-red), var(--aws-yellow))"
                    }
                }).showToast();
            </script>
        @endif
    @endpush
</x-app-layout>
