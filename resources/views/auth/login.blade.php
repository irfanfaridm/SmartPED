<x-guest-layout>

    <div class="flex flex-col items-center mb-6">
        <img src="/images.png" alt="Telkom Indonesia" class="w-16 h-16 mb-2 rounded-full">
        <span class="text-2xl font-bold text-primary">Smart PED</span>
    </div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-primary shadow-sm focus:ring-primary dark:focus:ring-primary dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-primary hover:text-primary-dark rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 btn-register">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Register Section -->
    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                {{ __('Belum punya akun?') }}
            </p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" 
                   class="btn-register inline-flex items-center px-6 py-3 rounded-lg font-semibold text-sm uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                    {{ __('Daftar Akun Baru') }}
                </a>
            @endif
        </div>
    </div>
</x-guest-layout>
