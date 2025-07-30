@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-[60vh]">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-gradient-to-r from-red-600 to-red-400 shadow-xl rounded-2xl p-8 flex flex-col items-center mb-8 relative overflow-hidden">
            <img src="/images.png" alt="Welcome" class="w-24 h-24 mb-4 drop-shadow-lg animate-bounce" style="background:white;border-radius:50%;padding:8px;"/>
            <h3 class="text-2xl font-extrabold mb-2 text-white drop-shadow">Selamat Datang di <span class="text-yellow-200">Smart PED</span></h3>
            <p class="text-white mb-4 text-lg">Anda login sebagai <span class="font-semibold text-yellow-200">{{ Auth::user()->name }}</span>.</p>
            <div class="w-full border-t border-red-200 my-4 opacity-50"></div>
            <p class="text-red-100">Silakan pilih menu di atas untuk mulai menggunakan aplikasi.</p>
            <div class="absolute right-4 bottom-4 opacity-20 text-8xl select-none pointer-events-none">📊</div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

            <!-- Total Dokumen -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:scale-105 transition-transform duration-300 border-t-4 border-red-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Dokumen</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalDocuments }}</p>
                    </div>
                    <div class="text-3xl text-red-600">📄</div>
                </div>
                <div class="mt-4">
                    <span class="text-green-600 text-sm font-medium">+{{ $hemGrowthPercentage + $qeGrowthPercentage ?? '0' }}%</span>
                    <span class="text-gray-500 text-sm">dari bulan lalu</span>
                </div>
            </div>

            <!-- Dokumen HEM -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:scale-105 transition-transform duration-300 border-t-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Dokumen HEM</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $hemDocuments }}</p>
                    </div>
                    <div class="text-3xl text-blue-600">📋</div>
                </div>
                <div class="mt-4">
                    <span class="text-green-600 text-sm font-medium">+{{ $hemGrowthPercentage ?? '0' }}%</span>
                    <span class="text-gray-500 text-sm">dari bulan lalu</span>
                </div>
            </div>

            <!-- Dokumen QE -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:scale-105 transition-transform duration-300 border-t-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Dokumen QE</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $qeDocuments }}</p>
                    </div>
                    <div class="text-3xl text-green-600">✅</div>
                </div>
                <div class="mt-4">
                    <span class="text-green-600 text-sm font-medium">+{{ $qeGrowthPercentage ?? '0' }}%</span>
                    <span class="text-gray-500 text-sm">dari bulan lalu</span>
                </div>
            </div>

            <!-- Dokumen INDIHOME -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:scale-105 transition-transform duration-300 border-t-4 border-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Dokumen INDIHOME</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $indihomeDocuments }}</p>
                    </div>
                    <div class="text-3xl text-purple-600">🏠</div>
                </div>
                <div class="mt-4">
                    <span class="text-green-600 text-sm font-medium">+{{ $indihomeGrowthPercentage ?? '0' }}%</span>
                    <span class="text-gray-500 text-sm">dari bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Recent Activities & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <span class="text-red-600 mr-2">📊</span>
                    Aktivitas Terbaru
                </h3>
                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-{{ $activity['color'] }}-500 rounded-full"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $activity['message'] }}</p>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500">Belum ada aktivitas</p>
                                <p class="text-xs text-gray-400">Upload dokumen pertama Anda</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <span class="text-red-600 mr-2">⚡</span>
                    Aksi Cepat
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <a href="{{ route('hem.create') }}" class="flex flex-col items-center p-4 bg-gradient-to-br from-red-50 to-red-100 rounded-lg hover:from-red-100 hover:to-red-200 transition-all duration-200">
                        <div class="text-2xl mb-2">📤</div>
                        <p class="text-sm font-medium text-red-700">Upload HEM</p>
                    </a>
                    <a href="{{ route('hem.index') }}" class="flex flex-col items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all duration-200">
                        <div class="text-2xl mb-2">📋</div>
                        <p class="text-sm font-medium text-blue-700">Lihat HEM</p>
                    </a>
                    <a href="{{ route('qe.create') }}" class="flex flex-col items-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-lg hover:from-green-100 hover:to-green-200 transition-all duration-200">
                        <div class="text-2xl mb-2">✅</div>
                        <p class="text-sm font-medium text-green-700">Upload QE</p>
                    </a>
                    <a href="{{ route('qe.index') }}" class="flex flex-col items-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-lg hover:from-green-100 hover:to-green-200 transition-all duration-200">
                        <div class="text-2xl mb-2">📋</div>
                        <p class="text-sm font-medium text-green-700">Lihat QE</p>
                    </a>
                    <a href="{{ route('indihome.create') }}" class="flex flex-col items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg hover:from-purple-100 hover:to-purple-200 transition-all duration-200">
                        <div class="text-2xl mb-2">🏠</div>
                        <p class="text-sm font-medium text-purple-700">Upload INDIHOME</p>
                    </a>
                    <a href="{{ route('indihome.index') }}" class="flex flex-col items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg hover:from-purple-100 hover:to-purple-200 transition-all duration-200">
                        <div class="text-2xl mb-2">📋</div>
                        <p class="text-sm font-medium text-purple-700">Lihat INDIHOME</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="mt-8 bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <span class="text-red-600 mr-2">🔧</span>
                Status Sistem
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <span class="text-sm font-medium text-green-700">Database</span>
                    <span class="text-green-600">🟢 Online</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <span class="text-sm font-medium text-green-700">Storage</span>
                    <span class="text-green-600">🟢 Normal</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <span class="text-sm font-medium text-green-700">Backup</span>
                    <span class="text-green-600">🟢 Aktif</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
