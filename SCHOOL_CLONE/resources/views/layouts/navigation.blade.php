<nav x-data="{ open: false }" class="bg-[var(--aws-navy)] border-b border-[var(--aws-border)] sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo Section -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center">
                    <span class="text-xl font-bold text-[var(--aws-orange)]">the S.M.S</span>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden space-x-8 sm:flex sm:ml-10">
                    @php
                        $user = Auth::user();
                        $role = $user->roles->first()->name ?? 'user';
                        $dashboardRoutes = [
                            'headteacher' => 'headteacher.dashboard',
                            'dos' => 'dos.dashboard',
                            'bursar' => 'bursar.dashboard',
                            'teacher' => 'teacher.dashboard',
                            'user' => 'dashboard'
                        ];
                        $activeRoutes = array_values($dashboardRoutes);
                    @endphp

                    <x-nav-link
                        :href="route($dashboardRoutes[$role])"
                        :active="in_array(Route::currentRouteName(), $activeRoutes)"
                        class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                    >
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if($role === 'headteacher')
                        <x-nav-link
                            :href="route('headteacher.staff.dos')"
                            :active="request()->routeIs('headteacher.staff.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Staff Management') }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('headteacher.reports.index')"
                            :active="request()->routeIs('headteacher.reports.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Reports') }}
                        </x-nav-link>
                    @elseif($role === 'dos')
                        <x-nav-link
                            :href="route('dos.students.index')"
                            :active="request()->routeIs('dos.students.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Students') }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('dos.classes.index')"
                            :active="request()->routeIs('dos.classes.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Classes') }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('dos.subjects.index')"
                            :active="request()->routeIs('dos.subjects.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Subjects') }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('dos.timetable.index')"
                            :active="request()->routeIs('dos.timetable.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Timetable') }}
                        </x-nav-link>
                    @elseif($role === 'bursar')
                        <x-nav-link
                            :href="route('bursar.fees.index')"
                            :active="request()->routeIs('bursar.fees.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Fees') }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('bursar.payments.index')"
                            :active="request()->routeIs('bursar.payments.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Payments') }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('bursar.budgets.index')"
                            :active="request()->routeIs('bursar.budgets.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Budgets') }}
                        </x-nav-link>
                    @elseif($role === 'teacher')
                        <x-nav-link
                            :href="route('teacher.subjects.index')"
                            :active="request()->routeIs('teacher.subjects.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Subjects') }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('teacher.assignments.index')"
                            :active="request()->routeIs('teacher.assignments.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Assignments') }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('teacher.attendance.index')"
                            :active="request()->routeIs('teacher.attendance.*')"
                            class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:border-[var(--aws-orange)] px-1 pt-1 border-b-2 border-transparent"
                        >
                            {{ __('Attendance') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                            <div class="flex items-center">
                                @if($user->profile_photo_path)
                                    <img class="h-8 w-8 rounded-full mr-2" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                                @else
                                    <div class="h-8 w-8 rounded-full bg-[var(--aws-orange)] flex items-center justify-center mr-2">
                                        <span class="font-medium text-[var(--aws-navy)]">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <div>{{ $user->name }}</div>
                                    <div class="text-xs text-[var(--aws-text-light)] opacity-75">{{ ucfirst($role) }}</div>
                                </div>
                                <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-gray-700">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('password.change')" class="hover:bg-gray-700">
                            {{ __('Change Password') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();"
                                             class="hover:bg-gray-700">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-[var(--aws-text-light)] hover:text-[var(--aws-orange)] hover:bg-[var(--aws-dark-gray)]">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route($dashboardRoutes[$role])" :active="in_array(Route::currentRouteName(), $activeRoutes)"
                                   class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if($role === 'headteacher')
                <x-responsive-nav-link :href="route('headteacher.staff.dos')" :active="request()->routeIs('headteacher.staff.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Staff Management') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('headteacher.reports.index')" :active="request()->routeIs('headteacher.reports.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Reports') }}
                </x-responsive-nav-link>
            @elseif($role === 'dos')
                <!-- DOS mobile menu items -->
                <x-responsive-nav-link :href="route('dos.students.index')" :active="request()->routeIs('dos.students.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Students') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dos.classes.index')" :active="request()->routeIs('dos.classes.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Classes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dos.subjects.index')" :active="request()->routeIs('dos.subjects.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Subjects') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dos.timetable.index')" :active="request()->routeIs('dos.timetable.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Timetable') }}
                </x-responsive-nav-link>
            @elseif($role === 'bursar')
                <!-- Bursar mobile menu items -->
                <x-responsive-nav-link :href="route('bursar.fees.index')" :active="request()->routeIs('bursar.fees.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Fees') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bursar.payments.index')" :active="request()->routeIs('bursar.payments.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Payments') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bursar.budgets.index')" :active="request()->routeIs('bursar.budgets.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Budgets') }}
                </x-responsive-nav-link>
            @elseif($role === 'teacher')
                <!-- Teacher mobile menu items -->
                <x-responsive-nav-link :href="route('teacher.subjects.index')" :active="request()->routeIs('teacher.subjects.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Subjects') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('teacher.assignments.index')" :active="request()->routeIs('teacher.assignments.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Assignments') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('teacher.attendance.index')" :active="request()->routeIs('teacher.attendance.*')"
                                       class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Attendance') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Mobile profile section -->
        <div class="pt-4 pb-1 border-t border-[var(--aws-border)]">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    @if($user->profile_photo_path)
                        <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                    @else
                        <div class="h-10 w-10 rounded-full bg-[var(--aws-orange)] flex items-center justify-center">
                            <span class="font-medium text-[var(--aws-navy)]">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <div class="ml-3">
                    <div class="font-medium text-[var(--aws-text-light)]">{{ $user->name }}</div>
                    <div class="text-sm text-gray-400">{{ $user->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('password.change')" class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                    {{ __('Change Password') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();"
                                           class="text-[var(--aws-text-light)] hover:text-[var(--aws-orange)]">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
