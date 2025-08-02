<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Challenge - SmartPED</title>
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
                        Two-Factor Authentication
                    </p>
                    <p class="text-red-100 leading-relaxed">
                        Untuk keamanan tambahan, silakan masukkan kode autentikasi dari aplikasi authenticator Anda atau kode recovery yang telah kami kirimkan.
                    </p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Keamanan Maksimal</h3>
                            <p class="text-sm text-red-100">Proteksi tambahan untuk akun Anda</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Akses Terverifikasi</h3>
                            <p class="text-sm text-red-100">Hanya Anda yang dapat mengakses akun</p>
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
                            <p class="text-sm text-red-100">Verifikasi selesai dalam hitungan detik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Two-Factor Challenge Form -->
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
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">Two-Factor Challenge</h2>
                    <p class="text-gray-600">Silakan konfirmasi akses ke akun Anda dengan memasukkan kode autentikasi yang disediakan oleh aplikasi authenticator Anda.</p>
                </div>
                
                <!-- Two-Factor Challenge Form -->
                <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Autentikasi
                        </label>
                        <input type="text" 
                               id="code" 
                               name="code" 
                               required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="Masukkan kode 6 digit">
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="recovery_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Recovery
                        </label>
                        <input type="text" 
                               id="recovery_code" 
                               name="recovery_code" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="Atau masukkan kode recovery">
                        @error('recovery_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-red-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                        Konfirmasi
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
                        <a href="{{ route('login') }}" class="text-red-600 hover:text-red-800 font-semibold transition-colors">
                            Kembali ke Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 