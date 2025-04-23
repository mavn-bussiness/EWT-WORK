<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-[var(--aws-navy)] to-[var(--aws-dark-navy)] flex items-center justify-center p-4 sm:p-6">
        <div class="backdrop-blur-lg bg-white/10 border border-[var(--aws-border)] rounded-2xl shadow-2xl w-full max-w-md p-8 sm:p-10 transition-all duration-300">
            <!-- Branding -->
            <div class="text-center mb-8">
                <div class="flex justify-center items-center mb-4">
                    <svg viewBox="0 0 316 316" class="w-10 h-10 mr-2 text-[var(--aws-orange)]" xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-[var(--aws-orange)]" d="M60 200 C60 180, 80 160, 158 160 C236 160, 256 180, 256 200 V240 C256 260, 236 280, 158 280 C80 280, 60 260, 60 240 V200 Z"/>
                        <path class="fill-[var(--aws-text-light)]" d="M80 200 C80 190, 90 180, 158 180 C226 180, 236 190, 236 200 V230 C236 240, 226 250, 158 250 C90 250, 80 240, 80 230 V200 Z"/>
                        <path class="fill-[var(--aws-navy)]" d="M148 120 H168 V160 H148 Z"/>
                        <path class="fill-[var(--aws-orange)]" d="M158 80 C150 80, 146 90, 148 100 C150 110, 166 110, 168 100 C170 90, 166 80, 158 80 Z"/>
                    </svg>
                    <h1 class="text-2xl font-semibold text-white">The S.M.S</h1>
                </div>
                <p class="text-sm text-[var(--aws-text-light)]">Sign in to continue</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-6 text-sm text-[var(--aws-green)] font-medium" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="aws-label text-[var(--aws-text-light)] font-medium" />
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        class="aws-input bg-white/5 border-[var(--aws-border)] text-white placeholder-[var(--aws-text-light)] focus:ring-2 focus:ring-[var(--aws-orange)] transition-all duration-200 w-full rounded-lg"
                        placeholder="Enter your email"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-[var(--aws-red)] text-sm" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="aws-label text-[var(--aws-text-light)] font-medium" />
                    <x-text-input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="aws-input bg-white/5 border-[var(--aws-border)] text-white placeholder-[var(--aws-text-light)] focus:ring-2 focus:ring-[var(--aws-orange)] transition-all duration-200 w-full rounded-lg"
                        placeholder="Enter your password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-[var(--aws-red)] text-sm" />
                </div>

                <!-- Remember Me + Forgot Password -->
                <div class="flex items-center justify-between text-sm">
                    <label for="remember_me" class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="form-checkbox h-4 w-4 text-[var(--aws-orange)] bg-white/10 border-[var(--aws-border)] rounded focus:ring-[var(--aws-orange)]"
                            name="remember"
                        >
                        <span class="ml-2 text-[var(--aws-text-light)]">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            class="text-[var(--aws-orange)] hover:text-[var(--aws-orange-hover)] transition-colors duration-200"
                            href="{{ route('password.request') }}"
                        >
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <div>
                    <x-primary-button
                        class="aws-btn-primary w-full bg-[var(--aws-orange)] hover:bg-[var(--aws-orange-hover)] text-[var(--aws-navy)] font-semibold py-3 rounded-lg transition-all duration-200"
                    >
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom CSS for AWS-inspired styling -->
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
        }

        .aws-label {
            font-size: 0.875rem;
            line-height: 1.25rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .aws-input {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--aws-border);
            padding: 0.75rem 1rem;
            font-size: 1rem;
            line-height: 1.5rem;
            color: #ffffff;
            outline: none;
            transition: border-color 0.2s, background-color 0.2s, box-shadow 0.2s;
        }

        .aws-input:focus {
            border-color: var(--aws-orange);
            background-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 0 2px rgba(236, 114, 17, 0.3);
        }

        .aws-input::placeholder {
            color: var(--aws-text-light);
            opacity: 0.7;
        }

        .aws-btn-primary {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.5rem;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
        }

        .aws-btn-primary:hover {
            transform: translateY(-1px);
        }

        .aws-btn-primary:active {
            transform: translateY(0);
        }
    </style>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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
</x-guest-layout>
