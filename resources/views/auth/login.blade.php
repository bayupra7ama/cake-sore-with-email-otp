<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="mt-6">
            <div class="flex items-center justify-center">
                <span class="text-sm text-gray-500">atau</span>
            </div>

            <a href="{{ route('google.login') }}"
                class="mt-3 w-full inline-flex items-center justify-center gap-3
              border border-gray-300 rounded-md px-4 py-2
              text-sm font-medium text-gray-700
              hover:bg-gray-100 transition">

                <!-- Icon Google (SVG, tidak perlu library) -->
                <svg class="w-5 h-5" viewBox="0 0 48 48">
                    <path fill="#EA4335"
                        d="M24 9.5c3.2 0 5.4 1.4 6.6 2.6l4.8-4.8C32.6 4.3 28.7 2.5 24 2.5 14.9 2.5 7.3 8.6 4.8 16.8l5.8 4.5C12.4 14.8 17.7 9.5 24 9.5z" />
                    <path fill="#4285F4"
                        d="M46.1 24.5c0-1.6-.1-2.7-.4-3.9H24v7.4h12.8c-.3 1.9-1.7 4.8-4.9 6.7l5.6 4.3c3.3-3.1 5.2-7.7 5.2-14.5z" />
                    <path fill="#FBBC05"
                        d="M10.6 28.3c-.5-1.5-.8-3.1-.8-4.8s.3-3.3.8-4.8l-5.8-4.5C3.2 16.8 2.5 20.2 2.5 23.5s.7 6.7 2.3 9.3l5.8-4.5z" />
                    <path fill="#34A853"
                        d="M24 44.5c4.7 0 8.6-1.5 11.5-4.1l-5.6-4.3c-1.5 1-3.5 1.7-5.9 1.7-6.3 0-11.6-5.3-13.4-12.5l-5.8 4.5C7.3 38.4 14.9 44.5 24 44.5z" />
                </svg>

                <span>Login dengan Google</span>
            </a>
        </div>

    </form>
</x-guest-layout>
