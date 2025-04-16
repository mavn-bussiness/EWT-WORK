<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- First Name -->
                            <div>
                                <x-input-label for="firstName" :value="__('First Name')" />
                                <x-text-input id="firstName" class="block mt-1 w-full" type="text" name="firstName" :value="old('firstName', $user->firstName)" required autofocus />
                                <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
                            </div>

                            <!-- Last Name -->
                            <div>
                                <x-input-label for="lastName" :value="__('Last Name')" />
                                <x-text-input id="lastName" class="block mt-1 w-full" type="text" name="lastName" :value="old('lastName', $user->lastName)" required />
                                <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Other Name -->
                        <div class="mb-6">
                            <x-input-label for="otherName" :value="__('Other Name')" />
                            <x-text-input id="otherName" class="block mt-1 w-full" type="text" name="otherName" :value="old('otherName', $user->otherName)" />
                            <x-input-error :messages="$errors->get('otherName')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div class="mb-6">
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                                <option value="teacher" {{ old('role', $user->role) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                <option value="parent" {{ old('role', $user->role) == 'parent' ? 'selected' : '' }}>Parent</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="headteacher" {{ old('role', $user->role) == 'headteacher' ? 'selected' : '' }}>Head Teacher</option>
                                <option value="bursar" {{ old('role', $user->role) == 'bursar' ? 'selected' : '' }}>Bursar</option>
                                <option value="dos" {{ old('role', $user->role) == 'dos' ? 'selected' : '' }}>DOS</option>
                                <option value="librarian" {{ old('role', $user->role) == 'librarian' ? 'selected' : '' }}>Librarian</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                            <p class="text-sm text-gray-500 mt-1">Leave blank to keep current password</p>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Current Profile Photo -->
                        @if ($user->profile_photo)
                        <div class="mb-6">
                            <x-input-label :value="__('Current Profile Photo')" />
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="h-20 w-20 object-cover rounded-full">
                            </div>
                        </div>
                        @endif

                        <!-- Profile Photo -->
                        <div class="mb-6">
                            <x-input-label for="profile_photo" :value="__('New Profile Photo')" />
                            <input id="profile_photo" type="file" name="profile_photo" class="block w-full text-sm text-gray-500 mt-1
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                        </div>

                        <!-- Is Active -->
                        <div class="mb-6">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="is_active" {{ $user->is_active ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Active') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 underline mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Update User') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>