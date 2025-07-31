@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-red-600">Edit Dokumen Indihome</h2>
        <a href="{{ route('indihome.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-6 h-6'>
                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/>
            </svg>
        </a>
    </div>
    
    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('indihome.update', $document->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">Nama Dokumen</label>
            <input type="text" name="nama_dokumen" class="w-full rounded border-gray-300 bg-white text-gray-900" required value="{{ old('nama_dokumen', $document->nama_dokumen) }}">
        </div>
        
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">Lokasi/Daerah</label>
            <div class="space-y-2">
                <!-- Dropdown untuk lokasi yang sudah ada -->
                <select id="lokasi-dropdown" name="lokasi" class="w-full rounded border-gray-300 bg-white text-gray-900">
                    <option value="">-- Pilih Lokasi yang Sudah Ada --</option>
                    @foreach($lokasiList as $lokasi)
                        <option value="{{ $lokasi }}" @if(old('lokasi', $document->lokasi)==$lokasi) selected @endif>{{ $lokasi }}</option>
                    @endforeach
                </select>
                
                <!-- Input untuk lokasi baru -->
                <div class="flex items-center space-x-2">
                    <input type="text" id="lokasi-input" name="lokasi_new" placeholder="Atau ketik lokasi baru" class="w-full rounded border-gray-300 bg-white text-gray-900" value="{{ old('lokasi_new') }}">
                    <button type="button" id="toggle-lokasi" class="px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                        Lokasi Baru
                    </button>
                </div>
                
                <p class="text-xs text-gray-500">
                    💡 Pilih lokasi yang sudah ada dari dropdown, atau klik "Lokasi Baru" untuk menambah lokasi baru
                </p>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">Koordinat Lokasi</label>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1 text-sm text-gray-600">Latitude</label>
                    <input type="number" id="latitude" name="latitude" step="any" placeholder="Contoh: -6.2088" class="w-full rounded border-gray-300 bg-white text-gray-900" value="{{ old('latitude', $document->latitude) }}">
                    <small class="text-gray-500">Contoh: -6.2088 (Jakarta Selatan)</small>
                </div>
                <div>
                    <label class="block mb-1 text-sm text-gray-600">Longitude</label>
                    <input type="number" id="longitude" name="longitude" step="any" placeholder="Contoh: 106.8456" class="w-full rounded border-gray-300 bg-white text-gray-900" value="{{ old('longitude', $document->longitude) }}">
                    <small class="text-gray-500">Contoh: 106.8456 (Jakarta Selatan)</small>
                </div>
            </div>
            <div class="mt-3">
                <button type="button" onclick="showCoordinatePicker()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors text-sm">
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4 inline mr-1'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                    </svg>
                    Pilih Lokasi di Peta
                </button>
            </div>
            <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-700">
                    <strong>💡 Tips:</strong> Koordinat bersifat opsional. Klik "Pilih Lokasi di Peta" untuk memilih koordinat secara visual, atau dapatkan koordinat dari Google Maps dengan klik kanan pada lokasi dan pilih "What's here?"
                </p>
                <p class="text-xs text-blue-600 mt-2">
                    <strong>Note:</strong> Jika peta tidak muncul, silakan masukkan koordinat secara manual atau hubungi administrator untuk setup Google Maps API.
                </p>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">File Dokumen</label>
            @if($document->file_path)
                <div class="mb-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center gap-2">
                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5 text-green-600'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'/>
                        </svg>
                        <span class="text-sm text-green-700">File saat ini: {{ basename($document->file_path) }}</span>
                    </div>
                    <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm mt-1 inline-block">
                        Lihat file saat ini
                    </a>
                </div>
            @endif
            <input type="file" name="file" class="w-full rounded border-gray-300 bg-white text-gray-900">
            <small class="text-gray-500">Format: pdf, doc, docx, ppt, pptx, xls, xlsx. Max 10MB (kosongkan jika tidak ingin mengubah file)</small>
        </div>
        
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">Keterangan</label>
            <textarea name="keterangan" class="w-full rounded border-gray-300 bg-white text-gray-900" placeholder="Contoh: Pembangunan ODC selesai pada tanggal 30/07/2025">{{ old('keterangan', $document->keterangan) }}</textarea>
        </div>
        
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">Pilih Tanggal Dokumen</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Kalender Interaktif -->
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Kalender</h3>
                        <button type="button" onclick="toggleCalendar()" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/>
                            </svg>
                        </button>
                    </div>
                    <div id="calendarContainer" class="hidden">
                        <div class="flex items-center justify-between mb-3">
                            <button type="button" onclick="previousMonth()" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 19l-7-7 7-7'/>
                                </svg>
                            </button>
                            <span id="currentMonthYear" class="font-semibold text-gray-800"></span>
                            <button type="button" onclick="nextMonth()" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-4 h-4'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 5l7 7-7 7'/>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-xs font-medium text-gray-500 mb-2">
                            <div class="text-center">Su</div>
                            <div class="text-center">Mo</div>
                            <div class="text-center">Tu</div>
                            <div class="text-center">We</div>
                            <div class="text-center">Th</div>
                            <div class="text-center">Fr</div>
                            <div class="text-center">Sa</div>
                        </div>
                        <div id="calendarDays" class="grid grid-cols-7 gap-1"></div>
                    </div>
                    <div class="mt-3">
                        <input type="hidden" id="selectedDate" name="selected_date" value="{{ $document->created_at->format('Y-m-d') }}">
                        <button type="button" onclick="toggleCalendar()" class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                            Pilih Tanggal
                        </button>
                    </div>
                </div>
                
                <!-- Informasi Tanggal -->
                <div class="bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-red-600 text-white rounded-lg p-3 text-center min-w-[70px] shadow-lg">
                            <div class="text-xs font-bold uppercase" id="displayMonth">{{ $document->created_at->format('M') }}</div>
                            <div class="text-2xl font-bold" id="displayDay">{{ $document->created_at->format('d') }}</div>
                            <div class="text-xs" id="displayYear">{{ $document->created_at->format('Y') }}</div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-lg font-semibold text-gray-800" id="displayDayName">{{ $document->created_at->format('l') }}</span>
                            <div class="flex items-center gap-1">
                                <span class="text-sm text-gray-600" id="displayTime">{{ $document->created_at->format('H:i') }}</span>
                                @php
                                    $timezoneAbbr = \App\Helpers\TimeZoneHelper::getTimezoneAbbr($document->longitude);
                                @endphp
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($timezoneAbbr === 'WIB') bg-blue-100 text-blue-800
                                    @elseif($timezoneAbbr === 'WITA') bg-green-100 text-green-800
                                    @elseif($timezoneAbbr === 'WIT') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $timezoneAbbr }}
                                </span>
                            </div>
                            <span class="text-xs text-red-600 font-medium">Dokumen akan tercatat dengan tanggal ini</span>
                        </div>
                    </div>
                    <div class="mt-3 text-right">
                        <div class="text-xs text-gray-500" id="displayDayOfYear">Hari ke-{{ $document->created_at->format('z') + 1 }}</div>
                        <div class="text-xs text-gray-500">dalam tahun {{ $document->created_at->format('Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex gap-3">
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 font-bold shadow">Update Dokumen</button>
            <a href="{{ route('indihome.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 font-bold shadow">Batal</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('lokasi-dropdown');
    const input = document.getElementById('lokasi-input');
    const toggleBtn = document.getElementById('toggle-lokasi');
    let isNewLocation = false;

    // Toggle antara dropdown dan input
    toggleBtn.addEventListener('click', function() {
        if (isNewLocation) {
            // Switch ke dropdown
            dropdown.style.display = 'block';
            input.style.display = 'none';
            input.value = '';
            toggleBtn.textContent = 'Lokasi Baru';
            toggleBtn.className = 'px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm';
            isNewLocation = false;
        } else {
            // Switch ke input
            dropdown.style.display = 'none';
            input.style.display = 'block';
            dropdown.value = '';
            toggleBtn.textContent = 'Pilih Lokasi';
            toggleBtn.className = 'px-3 py-2 bg-blue-200 text-blue-700 rounded hover:bg-blue-300 text-sm';
            isNewLocation = true;
        }
    });

    // Ketika dropdown dipilih, disable input
    dropdown.addEventListener('change', function() {
        if (this.value) {
            input.value = '';
        }
    });

    // Ketika input diketik, disable dropdown
    input.addEventListener('input', function() {
        if (this.value) {
            dropdown.value = '';
        }
    });
});

// Calendar functionality
let currentDate = new Date('{{ $document->created_at->format("Y-m-d") }}');
let selectedDate = new Date('{{ $document->created_at->format("Y-m-d") }}');

function toggleCalendar() {
    const container = document.getElementById('calendarContainer');
    if (container.classList.contains('hidden')) {
        container.classList.remove('hidden');
        renderCalendar();
    } else {
        container.classList.add('hidden');
    }
}

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    // Update month/year display
    document.getElementById('currentMonthYear').textContent = 
        new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
    
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - firstDay.getDay());
    
    const daysContainer = document.getElementById('calendarDays');
    daysContainer.innerHTML = '';
    
    for (let i = 0; i < 42; i++) {
        const date = new Date(startDate);
        date.setDate(startDate.getDate() + i);
        
        const dayElement = document.createElement('div');
        dayElement.className = 'text-center py-2 px-1 cursor-pointer hover:bg-gray-100 rounded';
        
        const isCurrentMonth = date.getMonth() === month;
        const isSelected = date.toDateString() === selectedDate.toDateString();
        const isToday = date.toDateString() === new Date().toDateString();
        
        if (!isCurrentMonth) {
            dayElement.classList.add('text-gray-400');
        }
        
        if (isSelected) {
            dayElement.classList.add('bg-purple-500', 'text-white', 'hover:bg-purple-600');
        } else if (isToday) {
            dayElement.classList.add('bg-red-100', 'text-red-600', 'font-bold');
        }
        
        dayElement.textContent = date.getDate();
        dayElement.onclick = () => selectDate(date);
        
        daysContainer.appendChild(dayElement);
    }
}

function selectDate(date) {
    selectedDate = date;
    updateDateDisplay();
    renderCalendar();
}

function updateDateDisplay() {
    const monthNames = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    
    document.getElementById('displayMonth').textContent = monthNames[selectedDate.getMonth()];
    document.getElementById('displayDay').textContent = selectedDate.getDate().toString().padStart(2, '0');
    document.getElementById('displayYear').textContent = selectedDate.getFullYear();
    document.getElementById('displayDayName').textContent = dayNames[selectedDate.getDay()];
    document.getElementById('displayTime').textContent = new Date().toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
    
    // Calculate day of year
    const start = new Date(selectedDate.getFullYear(), 0, 0);
    const diff = selectedDate - start;
    const oneDay = 1000 * 60 * 60 * 24;
    const dayOfYear = Math.floor(diff / oneDay);
    document.getElementById('displayDayOfYear').textContent = `Hari ke-${dayOfYear + 1}`;
    
    // Update hidden input
    document.getElementById('selectedDate').value = selectedDate.toISOString().split('T')[0];
}

function previousMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
}

// Initialize calendar
document.addEventListener('DOMContentLoaded', function() {
    updateDateDisplay();
});

// Coordinate Picker Modal
function showCoordinatePicker() {
    const modal = document.createElement('div');
    modal.id = 'coordinatePickerModal';
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
    modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden m-4">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Pilih Lokasi di Peta</h3>
                <button onclick="closeCoordinatePicker()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <div id="coordinateMap" class="w-full h-96 rounded-lg mb-4 bg-gray-100 flex items-center justify-center">
                    <div class="text-center">
                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-12 h-12 text-gray-400 mx-auto mb-2'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/>
                        </svg>
                        <p class="text-gray-500">Memuat peta...</p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        Klik pada peta untuk memilih lokasi
                    </div>
                    <button onclick="confirmCoordinate()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                        Konfirmasi Lokasi
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    
    // Initialize coordinate picker map
    setTimeout(() => {
        initCoordinateMap();
    }, 100);
}

function closeCoordinatePicker() {
    const modal = document.getElementById('coordinatePickerModal');
    if (modal) {
        modal.remove();
    }
}

let coordinateMap, coordinateMarker, selectedLat, selectedLng;

function initCoordinateMap() {
    // Check if Google Maps API is loaded
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        document.getElementById('coordinateMap').innerHTML = `
            <div class="text-center p-8">
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-12 h-12 text-red-400 mx-auto mb-4'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z'/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Google Maps Tidak Tersedia</h3>
                <p class="text-gray-500 mb-4">API key Google Maps belum dikonfigurasi atau tidak valid.</p>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>• Silakan masukkan koordinat secara manual</p>
                    <p>• Atau dapatkan koordinat dari Google Maps</p>
                    <p>• Hubungi administrator untuk setup API key</p>
                </div>
            </div>
        `;
        return;
    }
    
    try {
        // Default to Jakarta center
        const defaultPosition = { lat: -6.2088, lng: 106.8456 };
        
        coordinateMap = new google.maps.Map(document.getElementById('coordinateMap'), {
            zoom: 10,
            center: defaultPosition,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        
        // Add click listener to map
        coordinateMap.addListener('click', function(event) {
            const position = event.latLng;
            selectedLat = position.lat();
            selectedLng = position.lng();
            
            // Remove existing marker
            if (coordinateMarker) {
                coordinateMarker.setMap(null);
            }
            
            // Add new marker
            coordinateMarker = new google.maps.Marker({
                position: position,
                map: coordinateMap,
                animation: google.maps.Animation.DROP
            });
            
            // Show coordinates
            const infoWindow = new google.maps.InfoWindow({
                content: `<div class="p-2">
                    <p class="font-semibold">Lokasi Dipilih</p>
                    <p class="text-sm">Lat: ${selectedLat.toFixed(6)}</p>
                    <p class="text-sm">Lng: ${selectedLng.toFixed(6)}</p>
                </div>`
            });
            infoWindow.open(coordinateMap, coordinateMarker);
        });
    } catch (error) {
        console.error('Error initializing map:', error);
        document.getElementById('coordinateMap').innerHTML = `
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

function confirmCoordinate() {
    if (selectedLat && selectedLng) {
        document.getElementById('latitude').value = selectedLat.toFixed(6);
        document.getElementById('longitude').value = selectedLng.toFixed(6);
        closeCoordinatePicker();
    } else {
        alert('Silakan pilih lokasi di peta terlebih dahulu');
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.id === 'coordinatePickerModal') {
        closeCoordinatePicker();
    }
});
</script>

<!-- Google Maps API for coordinate picker -->
<script>
// Load Google Maps API with error handling
function loadGoogleMapsAPI() {
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key={{ config('maps.google_maps_api_key') }}&callback=handleMapsAPILoad`;
    script.async = true;
    script.defer = true;
    script.onerror = function() {
        console.error('Failed to load Google Maps API');
        // Show fallback message if needed
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