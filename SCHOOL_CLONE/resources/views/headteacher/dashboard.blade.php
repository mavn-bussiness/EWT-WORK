<x-app-layout title="Headteacher Dashboard">
    <div class="flex flex-col min-h-screen bg-slate-900">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-800 shadow-xl transform transition-transform duration-300 lg:translate-x-0"
             id="sidebar">
            <div class="flex items-center justify-between h-16 px-6 bg-slate-900">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-yellow-500">the S.M.S</span>
                </div>
                <button class="text-gray-400 lg:hidden" onclick="document.getElementById('sidebar').classList.add('-translate-x-full')">
                    <x-icon name="menu" class="w-6 h-6" />
                </button>
            </div>

            <div class="px-4 py-6">
                <div class="mb-8">
                    <div class="flex items-center px-4 py-3 mb-2 bg-slate-700 rounded-lg">
                        <div class="flex-shrink-0 w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                            <span class="text-slate-900 font-bold text-lg">HT</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">Headteacher</p>
                            <p class="text-xs text-gray-400">Admin Access</p>
                        </div>
                    </div>
                </div>

                <nav class="space-y-1">
                    <a href="#" class="flex items-center px-4 py-3 text-white bg-slate-700 rounded-lg group">
                        <x-icon name="dashboard" class="w-5 h-5 mr-3 text-yellow-500" />
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('headteacher.staff.dos') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-slate-700 rounded-lg group hover:text-white transition-colors">
                        <x-icon name="user-plus" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-yellow-500" />
                        <span class="text-sm font-medium">Manage DOS</span>
                    </a>

                    <a href="{{ route('headteacher.staff.bursars') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-slate-700 rounded-lg group hover:text-white transition-colors">
                        <x-icon name="currency-dollar" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-yellow-500" />
                        <span class="text-sm font-medium">Manage Bursars</span>
                    </a>

                    <a href="{{ route('headteacher.announcements.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-slate-700 rounded-lg group hover:text-white transition-colors">
                        <x-icon name="speakerphone" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-yellow-500" />
                        <span class="text-sm font-medium">Announcements</span>
                    </a>

                    <a href="{{ route('headteacher.reports.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-slate-700 rounded-lg group hover:text-white transition-colors">
                        <x-icon name="clipboard-list" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-yellow-500" />
                        <span class="text-sm font-medium">Reports</span>
                    </a>

                    <a href="{{ route('headteacher.events.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-slate-700 rounded-lg group hover:text-white transition-colors">
                        <x-icon name="calendar" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-yellow-500" />
                        <span class="text-sm font-medium">Calendar</span>
                    </a>
                </nav>

                <div class="pt-8 mt-8 border-t border-slate-700">
                    <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-slate-700 rounded-lg group hover:text-white transition-colors">
                        <x-icon name="cog" class="w-5 h-5 mr-3 text-gray-400 group-hover:text-yellow-500" />
                        <span class="text-sm font-medium">Settings</span>
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


                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Navigation -->
            <header class="bg-slate-800 shadow-md">
                <div class="flex items-center justify-between px-6 h-16">
                    <button class="text-gray-400 lg:hidden" onclick="document.getElementById('sidebar').classList.remove('-translate-x-full')">
                        <x-icon name="menu" class="w-6 h-6" />
                    </button>

                    <div class="flex-1 lg:ml-6">
                        <h1 class="text-xl font-semibold text-white">Headteacher Dashboard</h1>
                    </div>

                    <div class="flex items-center">
                        <button class="p-1 mr-4 text-gray-400 rounded-full hover:text-white focus:outline-none">
                            <x-icon name="bell" class="w-6 h-6" />
                        </button>

                        <a href="#" class="flex items-center text-sm text-white">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                <span class="font-medium text-slate-900">HT</span>
                            </div>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 px-6 py-8">
                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-slate-800 rounded-2xl shadow-md p-5 border-l-4 border-blue-500 transition hover:shadow-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-400 uppercase tracking-wide">Teachers</div>
                                <div class="text-3xl font-bold text-white mt-1">{{ $stats['teachers'] }}</div>
                            </div>
                            <div class="text-blue-500 bg-blue-500 bg-opacity-20 p-3 rounded-full">
                                <x-icon name="people" class="h-8 w-8" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-2xl shadow-md p-5 border-l-4 border-green-500 transition hover:shadow-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-400 uppercase tracking-wide">Students</div>
                                <div class="text-3xl font-bold text-white mt-1">{{ $stats['students'] }}</div>
                            </div>
                            <div class="text-green-500 bg-green-500 bg-opacity-20 p-3 rounded-full">
                                <x-icon name="school" class="h-8 w-8" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-2xl shadow-md p-5 border-l-4 border-yellow-500 transition hover:shadow-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-400 uppercase tracking-wide">Pending Reports</div>
                                <div class="text-3xl font-bold text-white mt-1">{{ $stats['pending_reports'] }}</div>
                            </div>
                            <div class="text-yellow-500 bg-yellow-500 bg-opacity-20 p-3 rounded-full">
                                <x-icon name="assignment" class="h-8 w-8" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-2xl shadow-md p-5 border-l-4 border-purple-500 transition hover:shadow-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-400 uppercase tracking-wide">Upcoming Events</div>
                                <div class="text-3xl font-bold text-white mt-1">{{ $stats['upcoming_events'] }}</div>
                            </div>
                            <div class="text-purple-500 bg-purple-500 bg-opacity-20 p-3 rounded-full">
                                <x-icon name="event" class="h-8 w-8" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-white mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('headteacher.announcements.index') }}" class="flex items-center justify-center p-6 bg-gradient-to-r from-yellow-500 to-yellow-600 text-slate-900 rounded-xl shadow-md hover:shadow-lg transition-all">
                            <x-icon name="speakerphone" class="w-6 h-6 mr-3" />
                            <span class="text-lg font-medium">Create Announcement</span>
                        </a>

                        <a href="{{ route('headteacher.reports.index') }}" class="flex items-center justify-center p-6 bg-slate-800 hover:bg-slate-700 text-white rounded-xl shadow-md hover:shadow-lg transition-all border border-gray-700">
                            <x-icon name="clipboard-list" class="w-6 h-6 mr-3" />
                            <span class="text-lg font-medium">Review Reports</span>
                        </a>

                        <a href="{{ route('headteacher.events.index') }}" class="flex items-center justify-center p-6 bg-slate-800 hover:bg-slate-700 text-white rounded-xl shadow-md hover:shadow-lg transition-all border border-gray-700">
                            <x-icon name="calendar" class="w-6 h-6 mr-3" />
                            <span class="text-lg font-medium">Schedule Event</span>
                        </a>
                    </div>
                </div>

                <!-- Content Sections -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Announcements -->
                    <div class="bg-slate-800 rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-700 bg-slate-800">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-semibold text-white">Recent Circulars</h3>
                                <a href="{{ route('headteacher.announcements.index') }}" class="text-sm text-yellow-500 hover:underline">
                                    View all
                                </a>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse($recentAnnouncements as $announcement)
                                    <x-announcement-item :announcement="$announcement" />
                                @empty
                                    <div class="flex flex-col items-center justify-center py-8 text-center">
                                        <div class="bg-slate-700 p-4 rounded-full mb-3">
                                            <x-icon name="speakerphone" class="w-8 h-8 text-gray-400" />
                                        </div>
                                        <p class="text-gray-400">No recent announcements</p>
                                        <a href="{{ route('headteacher.announcements.create') }}" class="mt-3 px-4 py-2 bg-yellow-500 text-slate-900 rounded-lg text-sm font-medium hover:bg-yellow-600 transition-colors">
                                            Create Announcement
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Pending Reports -->
                    <div class="bg-slate-800 rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-700 bg-slate-800">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-semibold text-white">Pending Reports</h3>
                                <a href="{{ route('headteacher.reports.index') }}" class="text-sm text-yellow-500 hover:underline">
                                    View all
                                </a>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse($pendingReports as $report)
                                    <x-report-item :report="$report" />
                                @empty
                                    <div class="flex flex-col items-center justify-center py-8 text-center">
                                        <div class="bg-slate-700 p-4 rounded-full mb-3">
                                            <x-icon name="clipboard-list" class="w-8 h-8 text-gray-400" />
                                        </div>
                                        <p class="text-gray-400">No pending reports</p>
                                        <a href="{{ route('headteacher.reports.index') }}" class="mt-3 px-4 py-2 bg-slate-600 text-white rounded-lg text-sm font-medium hover:bg-slate-500 transition-colors">
                                            View All Reports
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
