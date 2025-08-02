<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SmartPED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'smart-red': '#e60000',
                        'smart-red-dark': '#cc0000',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Column - Promotional Content -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-red-600 to-red-800 text-white p-8">
            <div class="max-w-md mx-auto flex flex-col justify-center">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold mb-4">
                        SmartPED
                    </h1>
                    <p class="text-xl font-semibold mb-6">
                        Reset Password dengan Aman dan Mudah
                    </p>
                    <p class="text-red-100 leading-relaxed">
                        Jangan khawatir jika Anda lupa password. SmartPED menyediakan sistem reset password yang aman dan mudah untuk mengembalikan akses ke akun Anda.
                    </p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Keamanan Terjamin</h3>
                            <p class="text-sm text-red-100">Proses reset password yang aman dan terverifikasi</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Email Notifikasi</h3>
                            <p class="text-sm text-red-100">Link reset password dikirim ke email Anda</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Proses Cepat</h3>
                            <p class="text-sm text-red-100">Reset password selesai dalam hitungan menit</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Forgot Password Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">SMARTPED</h1>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">Lupa Password?</h2>
                    <p class="text-gray-600">Masukkan email Anda untuk menerima link reset password</p>
    </div>

    <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif
                
                <!-- Forgot Password Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="Masukkan email Anda">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-red-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                        Kirim Link Reset Password
                    </button>
                </form>
                
                <!-- Divider -->
                <div class="my-6 flex items-center">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-4 text-sm text-gray-500">atau</span>
                    <div class="flex-1 border-t border-gray-300"></div>
        </div>

                <!-- Back to Login -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Ingat password Anda? 
                        <a href="{{ route('login') }}" class="text-red-600 hover:text-red-800 font-semibold transition-colors">
                            Kembali ke login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
