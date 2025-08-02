<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SmartPED</title>
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
                    <!-- Telkom Logo in Left Column -->
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                            <img src="/images.png" alt="Telkom Indonesia" class="w-12 h-12 rounded-full">
                        </div>
                        <h1 class="text-4xl font-bold">
                            SmartPED
                        </h1>
                    </div>
                    <p class="text-xl font-semibold mb-6">
                        Platform Dokumentasi & Manajemen Proyek Telekomunikasi
                    </p>
                    <p class="text-red-100 leading-relaxed">
                        SmartPED membantu tim telekomunikasi mengelola dokumen, memantau lokasi proyek, dan mengoptimalkan implementasi infrastruktur untuk efisiensi operasional yang lebih baik.
                    </p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Manajemen Dokumen</h3>
                            <p class="text-sm text-red-100">Upload dan kelola dokumen proyek dengan mudah</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Lokasi Proyek</h3>
                            <p class="text-sm text-red-100">Pantau lokasi dan status implementasi proyek</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Analisis Data</h3>
                            <p class="text-sm text-red-100">Visualisasi dan analisis performa proyek</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mr-3 shadow-lg">
                            <img src="/images.png" alt="Telkom Indonesia" class="w-12 h-12 rounded-full">
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">SMARTPED</h1>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">Daftar Akun Baru</h2>
                    <p class="text-gray-600">Buat akun untuk mulai menggunakan SmartPED</p>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               id="name" 
                            name="name" 
                               value="{{ old('name') }}"
                            required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="Masukkan nama lengkap Anda">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <input type="password" 
                               id="password" 
                            name="password" 
                            required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="Buat password yang kuat">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                            name="password_confirmation" 
                            required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="Konfirmasi password Anda">
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="terms" 
                               name="terms" 
                               required
                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            Saya setuju dengan 
                            <a href="#" class="text-red-600 hover:text-red-800 font-semibold">Syarat & Ketentuan</a>
                            dan 
                            <a href="#" class="text-red-600 hover:text-red-800 font-semibold">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full bg-red-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 flex items-center">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-4 text-sm text-gray-500">atau</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>
                
                <!-- Login Link -->
                    <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-red-600 hover:text-red-800 font-semibold transition-colors">
                            Masuk sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
