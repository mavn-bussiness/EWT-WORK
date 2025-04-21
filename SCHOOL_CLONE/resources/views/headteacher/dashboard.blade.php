<x-app-layout title="Headteacher Dashboard">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <x-stat-card title="Teachers" :value="$stats['teachers']" icon="people" color="blue" />
        <x-stat-card title="Students" :value="$stats['students']" icon="school" color="green" />
        <x-stat-card title="Pending Reports" :value="$stats['pending_reports']" icon="assignment" color="yellow" />
        <x-stat-card title="Upcoming Events" :value="$stats['upcoming_events']" icon="event" color="purple" />
    </div>

    <div class="flex flex-wrap gap-4 mb-6">
        <a href="{{ route('headteacher.staff.dos') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Manage DOS</span>
        </a>
        <a href="{{ route('headteacher.staff.bursars') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Manage Bursars</span>
        </a>
        <a href="{{ route('headteacher.announcements.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            <span>Manage Announcements</span>
        </a>
        <a href="{{ route('headteacher.reports.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>View Reports</span>
        </a>
        <a href="{{ route('headteacher.events.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>School Calendar</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-card>
            <x-slot name="header">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">Recent Circulars</h3>
                    <a href="{{ route('headteacher.announcements.index') }}" class="text-sm text-blue-600 hover:underline">
                        View all
                    </a>
                </div>
            </x-slot>
            <div class="space-y-4">
                @forelse($recentAnnouncements as $announcement)
                    <x-announcement-item :announcement="$announcement" />
                @empty
                    <p class="text-gray-500 text-center py-4">No recent announcements</p>
                @endforelse
            </div>
        </x-card>

        <x-card>
            <x-slot name="header">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">Pending Reports</h3>
                    <a href="{{ route('headteacher.reports.index') }}" class="text-sm text-blue-600 hover:underline">
                        View all
                    </a>
                </div>
            </x-slot>
            <div class="space-y-4">
                @forelse($pendingReports as $report)
                    <x-report-item :report="$report" />
                @empty
                    <p class="text-gray-500 text-center py-4">No pending reports</p>
                @endforelse
            </div>
        </x-card>
    </div>
</x-app-layout>