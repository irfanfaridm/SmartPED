@extends('layouts.app')

@section('content')
@include('components.openlayers-map')
<div class="flex justify-center items-center min-h-screen pb-12 bg-gradient-to-br from-white via-red-50 to-white">
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <span class="text-3xl text-red-600">
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-8 h-8'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 7V3a1 1 0 011-1h8a1 1 0 011 1v4M7 7h10M7 7v14a1 1 0 001 1h8a1 1 0 001-1V7M7 7h10' />
                    </svg>
                </span>
                <div>
                    <h2 class="text-2xl font-bold text-red-600 tracking-tight">Daftar Dokumen Indihome</h2>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="bg-red-600 text-white rounded px-2 py-1 text-xs font-bold">
                            {{ now()->format('d M Y') }}
                        </div>
                        <span class="text-xs text-gray-500">{{ now()->format('l') }}</span>
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            WIB
                        </span>
                    </div>
                </div>
                @if($documents->count() > 0)
                    <div class="flex items-center gap-3">
                        <div class="bg-red-600 text-white rounded-lg p-2 text-center min-w-[50px]">
                            <div class="text-xs font-bold">{{ $documents->first()->created_at->format('M') }}</div>
                            <div class="text-sm font-bold">{{ $documents->first()->created_at->format('d') }}</div>
                        </div>
                        <div class="text-sm text-gray-500">
                            Terakhir diperbarui: {{ $documents->first()->created_at->format('d/m/Y H:i') }} WIB
                        </div>
                    </div>
                @endif
            </div>
            <a href="{{ route('indihome.create') }}"
               class="px-7 py-3 rounded-xl font-bold text-red-600 bg-white border-2 border-red-500 shadow-lg flex items-center gap-2 hover:bg-gradient-to-r hover:from-red-600 hover:to-red-400 hover:text-white hover:border-red-600 transition-all duration-200">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 4v16m8-8H4'/>
                </svg>
                Upload Baru
            </a>
        </div>

        <!-- Search Bar -->
        <div class="mb-6 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-center gap-2 mb-3">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-red-600'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700">Cari Dokumen</h3>
            </div>
            
            <form method="GET" action="" class="flex flex-col md:flex-row gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-gray-400'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/>
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" placeholder="Cari dokumen berdasarkan nama, lokasi, atau keterangan..." 
                               class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 hover:border-gray-400" 
                               value="{{ request('search') }}">
                        @if(request('search'))
                            <button type="button" onclick="clearSearch()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
                
                <!-- Search Button -->
                <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 font-semibold flex items-center gap-2 shadow-sm">
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/>
                    </svg>
                    Cari
                </button>
            </form>
        </div>

        <!-- Filter Options -->
        <div class="mb-6 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-center gap-2 mb-3">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-red-600'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z'/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700">Filter Dokumen</h3>
            </div>
            
            <form method="GET" action="" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Location Filter -->
                    <div class="space-y-2">
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4 text-red-600'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                            </svg>
                            Filter Lokasi
                        </label>
                        <div class="relative">
                            <select name="lokasi" id="lokasi" 
                                    class="w-full appearance-none bg-white border border-gray-300 rounded-lg px-4 py-3 pr-10 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 hover:border-gray-400" 
                                    onchange="this.form.submit()">
                                <option value="" class="text-gray-500">Pilih lokasi...</option>
                                @foreach($lokasiList as $lokasi)
                                    <option value="{{ $lokasi }}" @if(request('lokasi') == $lokasi) selected @endif class="text-gray-700">{{ $lokasi }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-gray-400'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Project Type Filter -->
                    <div class="space-y-2">
                        <label for="project_type" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4 text-red-600'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'/>
                            </svg>
                            Jenis Proyek
                        </label>
                        <div class="relative">
                            <select name="project_type" id="project_type" 
                                    class="w-full appearance-none bg-white border border-gray-300 rounded-lg px-4 py-3 pr-10 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 hover:border-gray-400" 
                                    onchange="this.form.submit()">
                                <option value="" class="text-gray-500">Pilih jenis proyek...</option>
                                @foreach($projectTypes as $key => $value)
                                    <option value="{{ $key }}" @if(request('project_type') == $key) selected @endif class="text-gray-700">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-gray-400'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Implementation Status Filter -->
                    <div class="space-y-2">
                        <label for="implementation_status" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4 text-red-600'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'/>
                            </svg>
                            Status Implementasi
                        </label>
                        <div class="relative">
                            <select name="implementation_status" id="implementation_status" 
                                    class="w-full appearance-none bg-white border border-gray-300 rounded-lg px-4 py-3 pr-10 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 hover:border-gray-400" 
                                    onchange="this.form.submit()">
                                <option value="" class="text-gray-500">Pilih status...</option>
                                @foreach($implementationStatuses as $key => $value)
                                    <option value="{{ $key }}" @if(request('implementation_status') == $key) selected @endif class="text-gray-700">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-gray-400'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Document Category Filter -->
                    <div class="space-y-2">
                        <label for="document_category" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4 text-red-600'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'/>
                            </svg>
                            Kategori Dokumen
                        </label>
                        <div class="relative">
                            <select name="document_category" id="document_category" 
                                    class="w-full appearance-none bg-white border border-gray-300 rounded-lg px-4 py-3 pr-10 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 hover:border-gray-400" 
                                    onchange="this.form.submit()">
                                <option value="" class="text-gray-500">Pilih kategori...</option>
                                @foreach($documentCategories as $key => $value)
                                    <option value="{{ $key }}" @if(request('document_category') == $key) selected @endif class="text-gray-700">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-gray-400'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Site Code Filter -->
                    <div class="space-y-2">
                        <label for="site_code" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4 text-red-600'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 11a3 3 0 11-6 0 3 3 0 016 0z'/>
                            </svg>
                            Kode Site
                        </label>
                        <input type="text" name="site_code" id="site_code" placeholder="Contoh: TSEL BOO821" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 hover:border-gray-400" 
                               value="{{ request('site_code') }}">
                    </div>

                    <!-- Date Filter -->
                    <div class="space-y-2">
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4 text-red-600'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'/>
                            </svg>
                            Filter Tanggal
                        </label>
                        <div class="flex items-center gap-3">
                            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg p-2 text-center min-w-[50px] shadow-sm">
                                <div class="text-xs font-bold">{{ now()->format('M') }}</div>
                                <div class="text-lg font-bold">{{ now()->format('d') }}</div>
                            </div>
                            <div class="relative flex-1">
                                <select name="tanggal" id="tanggal" 
                                        class="w-full appearance-none bg-white border border-gray-300 rounded-lg px-4 py-3 pr-10 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 hover:border-gray-400" 
                                        onchange="this.form.submit()">
                                    <option value="" class="text-gray-500">Pilih periode...</option>
                                    <option value="hari_ini" @if(request('tanggal') == 'hari_ini') selected @endif class="text-gray-700">Hari Ini</option>
                                    <option value="minggu_ini" @if(request('tanggal') == 'minggu_ini') selected @endif class="text-gray-700">Minggu Ini</option>
                                    <option value="bulan_ini" @if(request('tanggal') == 'bulan_ini') selected @endif class="text-gray-700">Bulan Ini</option>
                                    <option value="tahun_ini" @if(request('tanggal') == 'tahun_ini') selected @endif class="text-gray-700">Tahun Ini</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-gray-400'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Filters Display -->
                @if(request('lokasi') || request('tanggal') || request('project_type') || request('implementation_status') || request('document_category') || request('site_code'))
                    <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-gray-200">
                        <span class="text-sm font-medium text-gray-600">Filter Aktif:</span>
                        @if(request('lokasi'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                                </svg>
                                {{ request('lokasi') }}
                                <button type="button" onclick="removeFilter('lokasi')" class="ml-1 text-red-600 hover:text-red-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if(request('project_type'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'/>
                                </svg>
                                {{ $projectTypes[request('project_type')] ?? request('project_type') }}
                                <button type="button" onclick="removeFilter('project_type')" class="ml-1 text-purple-600 hover:text-purple-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if(request('implementation_status'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'/>
                                </svg>
                                {{ $implementationStatuses[request('implementation_status')] ?? request('implementation_status') }}
                                <button type="button" onclick="removeFilter('implementation_status')" class="ml-1 text-green-600 hover:text-green-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if(request('document_category'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'/>
                                </svg>
                                {{ $documentCategories[request('document_category')] ?? request('document_category') }}
                                <button type="button" onclick="removeFilter('document_category')" class="ml-1 text-indigo-600 hover:text-indigo-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if(request('site_code'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 11a3 3 0 11-6 0 3 3 0 016 0z'/>
                                </svg>
                                {{ request('site_code') }}
                                <button type="button" onclick="removeFilter('site_code')" class="ml-1 text-blue-600 hover:text-blue-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if(request('tanggal'))
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'/>
                                </svg>
                                @switch(request('tanggal'))
                                    @case('hari_ini')
                                        Hari Ini
                                        @break
                                    @case('minggu_ini')
                                        Minggu Ini
                                        @break
                                    @case('bulan_ini')
                                        Bulan Ini
                                        @break
                                    @case('tahun_ini')
                                        Tahun Ini
                                        @break
                                    @default
                                        {{ request('tanggal') }}
                                @endswitch
                                <button type="button" onclick="removeFilter('tanggal')" class="ml-1 text-blue-600 hover:text-blue-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-3 h-3'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        <button type="button" onclick="clearAllFilters()" class="text-sm text-gray-500 hover:text-gray-700 underline">
                            Hapus Semua Filter
                        </button>
                    </div>
                @endif

                <!-- Preserve search parameter -->
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('project_type'))
                    <input type="hidden" name="project_type" value="{{ request('project_type') }}">
                @endif
                @if(request('implementation_status'))
                    <input type="hidden" name="implementation_status" value="{{ request('implementation_status') }}">
                @endif
                @if(request('document_category'))
                    <input type="hidden" name="document_category" value="{{ request('document_category') }}">
                @endif
                @if(request('site_code'))
                    <input type="hidden" name="site_code" value="{{ request('site_code') }}">
                @endif
            </form>
        </div>

        <!-- Search Results Info -->
        @if(request('search') || request('lokasi') || request('tanggal') || request('project_type') || request('implementation_status') || request('document_category') || request('site_code'))
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-blue-600'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/>
                        </svg>
                        <span class="text-blue-800 font-medium">
                            Hasil Pencarian: {{ $documents->count() }} dokumen ditemukan
                        </span>
                    </div>
                    <a href="{{ route('indihome.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Hapus Filter
                    </a>
                </div>
                @if(request('search'))
                    <div class="mt-2 text-sm text-blue-700">
                        <strong>Kata kunci:</strong> "{{ request('search') }}"
                    </div>
                @endif
                @if(request('lokasi'))
                    <div class="mt-1 text-sm text-blue-700">
                        <strong>Lokasi:</strong> {{ request('lokasi') }}
                    </div>
                @endif
                @if(request('project_type'))
                    <div class="mt-1 text-sm text-blue-700">
                        <strong>Jenis Proyek:</strong> {{ $projectTypes[request('project_type')] ?? request('project_type') }}
                    </div>
                @endif
                @if(request('implementation_status'))
                    <div class="mt-1 text-sm text-blue-700">
                        <strong>Status:</strong> {{ $implementationStatuses[request('implementation_status')] ?? request('implementation_status') }}
                    </div>
                @endif
                @if(request('document_category'))
                    <div class="mt-1 text-sm text-blue-700">
                        <strong>Kategori:</strong> {{ $documentCategories[request('document_category')] ?? request('document_category') }}
                    </div>
                @endif
                @if(request('site_code'))
                    <div class="mt-1 text-sm text-blue-700">
                        <strong>Kode Site:</strong> {{ request('site_code') }}
                    </div>
                @endif
                @if(request('tanggal'))
                    <div class="mt-1 text-sm text-blue-700">
                        <strong>Periode:</strong> 
                        @switch(request('tanggal'))
                            @case('hari_ini')
                                Hari Ini
                                @break
                            @case('minggu_ini')
                                Minggu Ini
                                @break
                            @case('bulan_ini')
                                Bulan Ini
                                @break
                            @case('tahun_ini')
                                Tahun Ini
                                @break
                            @default
                                {{ request('tanggal') }}
                        @endswitch
                    </div>
                @endif
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow">
                <div class="bg-green-600 text-white rounded-lg p-2 text-center min-w-[50px]">
                    <div class="text-xs font-bold">{{ now()->format('M') }}</div>
                    <div class="text-sm font-bold">{{ now()->format('d') }}</div>
                </div>
                <div class="flex items-center gap-2">
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        <!-- Daftar Semua Lokasi Dokumen -->
        @php
            $allLocations = $documents->groupBy('lokasi')->map(function($docs, $location) {
                return [
                    'lokasi' => $location,
                    'count' => $docs->count(),
                    'documents' => $docs,
                    'hasCoordinates' => $docs->where('latitude', '!=', null)->where('longitude', '!=', null)->count() > 0,
                    'coordinates' => $docs->where('latitude', '!=', null)->where('longitude', '!=', null)->first()
                ];
            });
        @endphp
        
        @if($allLocations->count() > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-red-600'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                </svg>
                Daftar Semua Lokasi Dokumen
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($allLocations as $locationData)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold text-gray-800 text-lg">{{ $locationData['lokasi'] }}</h4>
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $locationData['count'] }} dokumen
                        </span>
                    </div>
                    
                    <div class="space-y-2">
                        @if($locationData['hasCoordinates'])
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4 text-green-600'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                                </svg>
                                <span>Koordinat tersedia</span>
                            </div>
                            <button onclick="showOpenLayersMap({{ $locationData['coordinates']->latitude }}, {{ $locationData['coordinates']->longitude }}, '{{ $locationData['lokasi'] }}', '{{ $locationData['lokasi'] }}')" 
                                    class="text-red-600 hover:text-red-800 transition-colors text-sm font-medium flex items-center gap-1">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 11a3 3 0 11-6 0 3 3 0 016 0z'/>
                                </svg>
                                Lihat di Peta
                            </button>
                        @else
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4 text-gray-400'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                                </svg>
                                <span>Koordinat belum tersedia</span>
                            </div>
                        @endif
                        
                        <div class="text-xs text-gray-500">
                            Dokumen terbaru: {{ $locationData['documents']->first()->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Peta Lokasi Dokumen -->
        @php
            $documentsWithCoords = $documents->where('latitude', '!=', null)->where('longitude', '!=', null);
        @endphp
        <!-- Peta Lokasi Dokumen - Always Visible -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-red-600'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                </svg>
                Peta Lokasi Dokumen
            </h3>
            
            @if($documentsWithCoords->count() > 0)
                <!-- Map with coordinates -->
                <div id="olOverviewMap" class="w-full h-64 rounded-lg border border-gray-200 bg-gray-50 relative">
                    <div id="olMapLoading" class="absolute inset-0 flex items-center justify-center bg-gray-50 text-gray-500">
                        <div class="text-center">
                            <svg class="animate-spin h-8 w-8 mx-auto mb-2 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p>Memuat peta...</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Map without coordinates - show default map -->
                <div id="olOverviewMap" class="w-full h-64 rounded-lg border border-gray-200 bg-gray-50 relative">
                    <div id="olMapLoading" class="absolute inset-0 flex items-center justify-center bg-gray-50 text-gray-500">
                        <div class="text-center">
                            <svg class="animate-spin h-8 w-8 mx-auto mb-2 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p>Memuat peta...</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Statistik Dokumen -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Total Dokumen</p>
                        <p class="text-2xl font-bold">{{ $documents->count() }}</p>
                    </div>
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-8 h-8 opacity-80'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'/>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Hari Ini</p>
                        <p class="text-2xl font-bold">{{ $documents->where('created_at', '>=', now()->startOfDay())->count() }}</p>
                        <div class="flex items-center gap-1 mt-1">
                            <div class="bg-white bg-opacity-20 rounded px-1 text-xs">
                                {{ now()->format('d') }}
                            </div>
                            <span class="text-xs opacity-80">{{ now()->format('M') }}</span>
                        </div>
                    </div>
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-8 h-8 opacity-80'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'/>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Minggu Ini</p>
                        <p class="text-2xl font-bold">{{ $documents->where('created_at', '>=', now()->startOfWeek())->count() }}</p>
                    </div>
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-8 h-8 opacity-80'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'/>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-4 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Bulan Ini</p>
                        <p class="text-2xl font-bold">{{ $documents->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                    </div>
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-8 h-8 opacity-80'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Statistik Lokasi -->
        @php
            $totalLocations = $documents->pluck('lokasi')->unique()->count();
            $locationsWithCoords = $documents->where('latitude', '!=', null)->where('longitude', '!=', null)->pluck('lokasi')->unique()->count();
            $locationsWithoutCoords = $totalLocations - $locationsWithCoords;
        @endphp
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-red-600'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                </svg>
                Ringkasan Lokasi Dokumen
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white p-4 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Total Lokasi</p>
                            <p class="text-2xl font-bold">{{ $totalLocations }}</p>
                        </div>
                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-8 h-8 opacity-80'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                        </svg>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white p-4 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Dengan Koordinat</p>
                            <p class="text-2xl font-bold">{{ $locationsWithCoords }}</p>
                        </div>
                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-8 h-8 opacity-80'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'/>
                        </svg>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-4 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Tanpa Koordinat</p>
                            <p class="text-2xl font-bold">{{ $locationsWithoutCoords }}</p>
                        </div>
                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-8 h-8 opacity-80'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z'/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg mt-2">
            <table class="min-w-full table-auto border border-gray-200 bg-white text-base font-sans">
                <thead class="sticky top-0 z-10 shadow-sm">
                    <tr class="bg-gradient-to-r from-red-100 to-red-50">
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Nama Dokumen</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Lokasi</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Kode Site</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Jenis Proyek</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Status</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Kategori</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Koordinat</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">File</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">User</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Tanggal</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr class="even:bg-gray-50 hover:bg-red-50 hover:shadow-lg transition-all duration-150">
                        <td class="border-t px-5 py-4 border-gray-200 text-base">
                            <div class="font-semibold text-gray-800">{{ $doc->nama_dokumen }}</div>
                            @if($doc->keterangan)
                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($doc->keterangan, 50) }}</div>
                            @endif
                        </td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">{{ $doc->lokasi }}</td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">
                            @if($doc->site_code)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $doc->site_code }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">
                            @if($doc->project_type)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($doc->project_type == 'edge_otn') bg-purple-100 text-purple-800
                                    @elseif($doc->project_type == 'mini_olt') bg-green-100 text-green-800
                                    @elseif($doc->project_type == 'ftth') bg-blue-100 text-blue-800
                                    @elseif($doc->project_type == 'bts_upgrade') bg-orange-100 text-orange-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $doc->project_type_label }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">
                            @if($doc->implementation_status)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($doc->implementation_status == 'completed') bg-green-100 text-green-800
                                    @elseif($doc->implementation_status == 'implementation') bg-blue-100 text-blue-800
                                    @elseif($doc->implementation_status == 'testing') bg-yellow-100 text-yellow-800
                                    @elseif($doc->implementation_status == 'planning') bg-gray-100 text-gray-800
                                    @elseif($doc->implementation_status == 'on_hold') bg-orange-100 text-orange-800
                                    @elseif($doc->implementation_status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $doc->implementation_status_label }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">
                            @if($doc->document_category)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $doc->document_category_label }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">
                            @if($doc->latitude && $doc->longitude)
                                <div class="flex items-center gap-2">
                                    <button onclick="showOpenLayersMap({{ $doc->latitude }}, {{ $doc->longitude }}, '{{ $doc->nama_dokumen }}', '{{ $doc->lokasi }}')" class="text-red-600 hover:text-red-800 transition-all duration-150 flex items-center gap-1 font-semibold">
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4'>
                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 11a3 3 0 11-6 0 3 3 0 016 0z'/>
                                        </svg>
                                        Lihat Peta
                                    </button>
                                    <span class="text-gray-500 text-sm">
                                        {{ number_format($doc->latitude, 6) }}, {{ number_format($doc->longitude, 6) }}
                                    </span>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="border-t px-5 py-4 border-gray-200">
                            <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="text-red-600 underline font-semibold flex items-center gap-1 hover:text-red-800 transition-all duration-150">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4'/>
                                </svg>
                                Download
                            </a>
                        </td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">{{ $doc->user->name ?? '-' }}</td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">
                            <div class="flex items-center gap-3">
                                <div class="bg-red-600 text-white rounded-lg p-2 text-center min-w-[60px] shadow-sm">
                                    <div class="text-xs font-bold">{{ $doc->created_at->format('M') }}</div>
                                    <div class="text-lg font-bold">{{ $doc->created_at->format('d') }}</div>
                                    <div class="text-xs">{{ $doc->created_at->format('Y') }}</div>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-700">{{ $doc->created_at->format('l') }}</span>
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs text-gray-500">{{ $doc->created_at->format('H:i') }}</span>
                                        @php
                                            $timezoneAbbr = \App\Helpers\TimeZoneHelper::getTimezoneAbbr($doc->longitude);
                                        @endphp
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($timezoneAbbr === 'WIB') bg-blue-100 text-blue-800
                                            @elseif($timezoneAbbr === 'WITA') bg-green-100 text-green-800
                                            @elseif($timezoneAbbr === 'WIT') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $timezoneAbbr }}
                                        </span>
                                    </div>
                                    @if($doc->created_at->format('Y-m-d') !== now()->format('Y-m-d'))
                                        <span class="text-xs text-blue-600 font-medium">Tanggal Kustom</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('indihome.edit', $doc->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('indihome.destroy', $doc->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Hapus">
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'>
                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center py-10 text-gray-400 text-lg">Belum ada dokumen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal OpenLayers Map sudah diinclude di components.openlayers-map -->

<!-- Script untuk OpenLayers sudah diinclude di components.openlayers-map -->

<script>
// Clear search function
function clearSearch() {
    document.getElementById('search').value = '';
    window.location.href = '{{ route("indihome.index") }}';
}

// Remove specific filter
function removeFilter(filterName) {
    const url = new URL(window.location);
    url.searchParams.delete(filterName);
    window.location.href = url.toString();
}

// Clear all filters
function clearAllFilters() {
    window.location.href = '{{ route("indihome.index") }}';
}

// Auto-submit search on Enter key
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
    }
    
    // Add hover effects to dropdowns
    const selects = document.querySelectorAll('select');
    selects.forEach(select => {
        select.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-red-500', 'ring-opacity-50');
        });
        
        select.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-red-500', 'ring-opacity-50');
        });
    });
});
</script>

@endsection