<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Head Teacher') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- First Name -->
                            <div>
                                <x-input-label for="firstName" :value="__('First Name')" />
                                <x-text-input id="firstName" class="block mt-1 w-full" type="text" name="firstName" :value="old('firstName')" required autofocus />
                                <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
                            </div>

                            <!-- Last Name -->
                            <div>
                                <x-input-label for="lastName" :value="__('Last Name')" />
                                <x-text-input id="lastName" class="block mt-1 w-full" type="text" name="lastName" :value="old('lastName')" required />
                                <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Other Name -->
                        <div class="mb-6">
                            <x-input-label for="otherName" :value="__('Other Name')" />
                            <x-text-input id="otherName" class="block mt-1 w-full" type="text" name="otherName" :value="old('otherName')" />
                            <x-input-error :messages="$errors->get('otherName')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Hidden Role field - always headteacher -->
                        <input type="hidden" name="role" value="headteacher">
                        
                        <!-- Password info notice -->
                        <div class="mb-6">
                            <p class="text-sm text-gray-500">A default password will be generated from the user's first and last name.</p>
                        </div>

                        <!-- Profile Photo -->
                        <div class="mb-6">
                            <x-input-label for="profile_photo" :value="__('Profile Photo')" />
                            <input id="profile_photo" type="file" name="profile_photo" class="block w-full text-sm text-gray-500 mt-1
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 underline mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Create Head Teacher') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>