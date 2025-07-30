@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen pb-12 bg-gradient-to-br from-white via-red-50 to-white">
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <span class="text-3xl text-red-600"><svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-8 h-8'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 7V3a1 1 0 011-1h8a1 1 0 011 1v4M7 7h10M7 7v14a1 1 0 001 1h8a1 1 0 001-1V7M7 7h10' /></svg></span>
                <div>
                    <h2 class="text-2xl font-bold text-red-600 tracking-tight">Daftar Dokumen Indihome</h2>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="bg-red-600 text-white rounded px-2 py-1 text-xs font-bold">
                            {{ now()->format('d M Y') }}
                        </div>
                        <span class="text-xs text-gray-500">{{ now()->format('l') }}</span>
                    </div>
                </div>
                @if($documents->count() > 0)
                    <div class="flex items-center gap-3">
                        <div class="bg-red-600 text-white rounded-lg p-2 text-center min-w-[50px]">
                            <div class="text-xs font-bold">{{ $documents->first()->created_at->format('M') }}</div>
                            <div class="text-sm font-bold">{{ $documents->first()->created_at->format('d') }}</div>
                        </div>
                        <div class="text-sm text-gray-500">
                            Terakhir diperbarui: {{ $documents->first()->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @endif
            </div>
            <a href="{{ route('indihome.create') }}"
               class="px-7 py-3 rounded-xl font-bold text-red-600 bg-white border-2 border-red-500 shadow-lg flex items-center gap-2 hover:bg-gradient-to-r hover:from-red-600 hover:to-red-400 hover:text-white hover:border-red-600 transition-all duration-200">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 4v16m8-8H4'/></svg>
                Upload Baru
            </a>
        </div>
        <form method="GET" action="" class="mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-3">
                    <label for="lokasi" class="font-semibold text-gray-700">Filter Lokasi:</label>
                    <select name="lokasi" id="lokasi" class="rounded border-gray-300 px-3 py-2 focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
                        <option value="">Semua Lokasi</option>
                        @foreach($lokasiList as $lokasi)
                            <option value="{{ $lokasi }}" @if(request('lokasi')==$lokasi) selected @endif>{{ $lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-3">
                    <label for="tanggal" class="font-semibold text-gray-700">Filter Tanggal:</label>
                    <div class="flex items-center gap-2">
                        <div class="bg-red-600 text-white rounded-lg p-1 text-center min-w-[40px]">
                            <div class="text-xs font-bold">{{ now()->format('d') }}</div>
                        </div>
                        <select name="tanggal" id="tanggal" class="rounded border-gray-300 px-3 py-2 focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
                            <option value="">Semua Tanggal</option>
                            <option value="hari_ini" @if(request('tanggal')=='hari_ini') selected @endif>Hari Ini</option>
                            <option value="minggu_ini" @if(request('tanggal')=='minggu_ini') selected @endif>Minggu Ini</option>
                            <option value="bulan_ini" @if(request('tanggal')=='bulan_ini') selected @endif>Bulan Ini</option>
                            <option value="tahun_ini" @if(request('tanggal')=='tahun_ini') selected @endif>Tahun Ini</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow">
                <div class="bg-green-600 text-white rounded-lg p-2 text-center min-w-[50px]">
                    <div class="text-xs font-bold">{{ now()->format('M') }}</div>
                    <div class="text-sm font-bold">{{ now()->format('d') }}</div>
                </div>
                <div class="flex items-center gap-2">
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        <!-- Peta Lokasi Dokumen -->
        @if($documents->where('latitude', '!=', null)->where('longitude', '!=', null)->count() > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-red-600'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                </svg>
                Peta Lokasi Dokumen
            </h3>
            <div id="overviewMap" class="w-full h-64 rounded-lg border border-gray-200"></div>
        </div>
        @endif
        
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
        <div class="overflow-x-auto rounded-lg mt-2">
            <table class="min-w-full table-auto border border-gray-200 bg-white text-base font-sans">
                <thead class="sticky top-0 z-10 shadow-sm">
                    <tr class="bg-gradient-to-r from-red-100 to-red-50">
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Nama Dokumen</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Lokasi</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Koordinat</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">File</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Keterangan</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">User</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Tanggal Selesai</th>
                        <th class="px-5 py-4 text-left text-gray-700 font-extrabold text-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr class="even:bg-gray-50 hover:bg-red-50 hover:shadow-lg transition-all duration-150">
                        <td class="border-t px-5 py-4 border-gray-200 text-base">{{ $doc->nama_dokumen }}</td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">{{ $doc->lokasi }}</td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">
                            @if($doc->latitude && $doc->longitude)
                                <div class="flex items-center gap-2">
                                    <button onclick="showMap({{ $doc->latitude }}, {{ $doc->longitude }}, '{{ $doc->nama_dokumen }}', '{{ $doc->lokasi }}')" class="text-red-600 hover:text-red-800 transition-all duration-150 flex items-center gap-1 font-semibold">
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 11a3 3 0 11-6 0 3 3 0 016 0z'/></svg>
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
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4'/></svg>
                                Download
                            </a>
                        </td>
                        <td class="border-t px-5 py-4 border-gray-200 text-base">{{ $doc->keterangan }}</td>
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
                                    <span class="text-xs text-gray-500">{{ $doc->created_at->format('H:i') }}</span>
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
                        <td colspan="8" class="text-center py-10 text-gray-400 text-lg">Belum ada dokumen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Google Maps -->
<div id="mapModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900" id="mapTitle">Lokasi Dokumen</h3>
                <button onclick="closeMap()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <div id="map" class="w-full h-96 rounded-lg"></div>
                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <span id="mapLocation"></span>
                    </div>
                    <a id="googleMapsLink" href="#" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                        Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let map, marker;

function showMap(lat, lng, title, location) {
    document.getElementById('mapModal').classList.remove('hidden');
    document.getElementById('mapTitle').textContent = title;
    document.getElementById('mapLocation').textContent = location;
    document.getElementById('googleMapsLink').href = `https://maps.google.com/?q=${lat},${lng}`;
    
    // Initialize map after modal is shown
    setTimeout(() => {
        initMap(lat, lng, title);
    }, 100);
}

function closeMap() {
    document.getElementById('mapModal').classList.add('hidden');
    if (map) {
        map = null;
    }
}

function initMap(lat, lng, title) {
    // Check if Google Maps API is loaded
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        document.getElementById('map').innerHTML = `
            <div class="text-center p-8">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-12 h-12 text-red-400 mx-auto mb-4'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z'/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Google Maps Tidak Tersedia</h3>
                <p class="text-gray-500 mb-4">API key Google Maps belum dikonfigurasi.</p>
                <a href="https://maps.google.com/?q=${lat},${lng}" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                    Buka di Google Maps
                </a>
            </div>
        `;
        return;
    }
    
    try {
        const position = { lat: parseFloat(lat), lng: parseFloat(lng) };
        
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: position,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{ visibility: "off" }]
                }
            ]
        });
        
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: title,
            animation: google.maps.Animation.DROP
        });
        
        const infoWindow = new google.maps.InfoWindow({
            content: `<div class="p-2">
                <h3 class="font-semibold">${title}</h3>
                <p class="text-sm text-gray-600">Koordinat: ${lat}, ${lng}</p>
            </div>`
        });
        
        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });
        
        // Auto open info window
        infoWindow.open(map, marker);
    } catch (error) {
        console.error('Error initializing map:', error);
        document.getElementById('map').innerHTML = `
            <div class="text-center p-8">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-12 h-12 text-red-400 mx-auto mb-4'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z'/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Error Memuat Peta</h3>
                <p class="text-gray-500">Terjadi kesalahan saat memuat peta Google Maps.</p>
            </div>
        `;
    }
}

// Close modal when clicking outside
document.getElementById('mapModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMap();
    }
});

// Initialize overview map
document.addEventListener('DOMContentLoaded', function() {
    const documentsWithCoords = @json($documents->where('latitude', '!=', null)->where('longitude', '!=', null));
    
    if (documentsWithCoords.length > 0) {
        setTimeout(() => {
            initOverviewMap(documentsWithCoords);
        }, 500);
    }
});

function initOverviewMap(documents) {
    if (documents.length === 0) return;
    
    // Calculate bounds
    const bounds = new google.maps.LatLngBounds();
    const markers = [];
    
    const overviewMap = new google.maps.Map(document.getElementById('overviewMap'), {
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [
            {
                featureType: "poi",
                elementType: "labels",
                stylers: [{ visibility: "off" }]
            }
        ]
    });
    
    documents.forEach((doc, index) => {
        const position = { lat: parseFloat(doc.latitude), lng: parseFloat(doc.longitude) };
        bounds.extend(position);
        
        const marker = new google.maps.Marker({
            position: position,
            map: overviewMap,
            title: doc.nama_dokumen,
            label: {
                text: (index + 1).toString(),
                color: 'white',
                fontWeight: 'bold'
            },
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 8,
                fillColor: '#DC2626',
                fillOpacity: 1,
                strokeColor: '#FFFFFF',
                strokeWeight: 2
            }
        });
        
        const infoWindow = new google.maps.InfoWindow({
            content: `<div class="p-2">
                <h3 class="font-semibold">${doc.nama_dokumen}</h3>
                <p class="text-sm text-gray-600">${doc.lokasi}</p>
                <p class="text-xs text-gray-500">${doc.created_at}</p>
            </div>`
        });
        
        marker.addListener('click', () => {
            infoWindow.open(overviewMap, marker);
        });
        
        markers.push(marker);
    });
    
    // Fit map to bounds
    overviewMap.fitBounds(bounds);
    
    // Add some padding to bounds
    overviewMap.addListener('bounds_changed', function() {
        if (overviewMap.getZoom() > 15) {
            overviewMap.setZoom(15);
        }
    });
}
</script>

<!-- Google Maps API -->
<script>
// Load Google Maps API with error handling
function loadGoogleMapsAPI() {
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key={{ config('maps.google_maps_api_key') }}&callback=handleMapsAPILoad`;
    script.async = true;
    script.defer = true;
    script.onerror = function() {
        console.error('Failed to load Google Maps API');
    };
    document.head.appendChild(script);
}

function handleMapsAPILoad() {
    console.log('Google Maps API loaded successfully');
}

// Load API when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadGoogleMapsAPI();
});
</script>

@endsection 