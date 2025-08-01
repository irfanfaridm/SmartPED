<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - SmartPED</title>
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
                        Verifikasi Email untuk Keamanan Akun
                    </p>
                    <p class="text-red-100 leading-relaxed">
                        Untuk memastikan keamanan akun Anda, kami perlu memverifikasi alamat email Anda. Silakan cek email Anda dan klik link verifikasi yang telah kami kirim.
                    </p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Email Verifikasi</h3>
                            <p class="text-sm text-red-100">Link verifikasi dikirim ke email Anda</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Keamanan Terjamin</h3>
                            <p class="text-sm text-red-100">Proses verifikasi yang aman dan terpercaya</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Akses Penuh</h3>
                            <p class="text-sm text-red-100">Setelah verifikasi, akses semua fitur SmartPED</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Verify Email Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">SMARTPED</h1>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">Verifikasi Email</h2>
                    <p class="text-gray-600">Terima kasih telah mendaftar! Sebelum memulai, dapatkah Anda memverifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan kepada Anda? Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan email yang lain.</p>
                </div>
                
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        Link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                    </div>
                @endif
                
                <!-- Verify Email Form -->
                <form method="POST" action="{{ route('verification.send') }}" class="space-y-6">
                    @csrf
                    
                    <button type="submit" 
                            class="w-full bg-red-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>
                
                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        Logout
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
                        Sudah verifikasi email? 
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
