<x-guest-layout>
    <!-- Red Background Layout to match Dashboard -->
    <div class="min-h-screen bg-red-600 flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Register Form Card -->
            <div class="bg-white rounded-lg p-8 shadow-xl">
                <!-- Logo and Title -->
                <div class="text-center mb-8">
                    <div class="relative inline-block">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-red-500 to-red-700 rounded-full flex items-center justify-center shadow-2xl border-4 border-white transform hover:scale-105 transition-transform duration-300">
                            <img src="/images.png" alt="Telkom Indonesia" class="w-12 h-12 rounded-full">
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-400 rounded-full animate-ping"></div>
                    </div>
                    <h1 class="text-3xl font-bold text-red-600 mb-2">Smart PED</h1>
                    <p class="text-gray-600 text-sm">Platform Digital Terdepan</p>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-gray-700 mb-2 block font-medium" />
                        <x-text-input id="name" 
                            class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                            type="text" 
                            name="name" 
                            :value="old('name')" 
                            required 
                            autofocus 
                            autocomplete="name" 
                            placeholder="Masukkan nama lengkap Anda" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-700 mb-2 block font-medium" />
                        <x-text-input id="email" 
                            class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autocomplete="username" 
                            placeholder="Masukkan email Anda" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 mb-2 block font-medium" />
                        <x-text-input id="password" 
                            class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password" 
                            placeholder="Buat password yang kuat" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 mb-2 block font-medium" />
                        <x-text-input id="password_confirmation" 
                            class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password" 
                            placeholder="Konfirmasi password Anda" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Register Button -->
                    <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        {{ __('REGISTER') }}
                    </button>
                </form>

                <!-- Login Section -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">
                            {{ __('Sudah punya akun?') }}
                        </p>
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors duration-200">
                            {{ __('MASUK KE AKUN') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
