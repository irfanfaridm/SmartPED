{{-- OpenLayers Map Component --}}

{{-- Include OpenLayers CSS and JS in the head section --}}
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@7.3.0/ol.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/openlayers-map.css') }}" type="text/css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/ol@7.3.0/dist/ol.js"></script>
    <script src="{{ asset('js/openlayers-map.js') }}"></script>
@endpush

{{-- Map Modal --}}
<div id="olMapModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900" id="olMapTitle">Lokasi Dokumen</h3>
                <button onclick="closeOpenLayersMap()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <div id="olMap" class="w-full h-96 rounded-lg"></div>
                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <span id="olMapLocation"></span>
                    </div>
                    <a id="olGoogleMapsLink" href="#" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                        Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Map Initialization Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make documents available to OpenLayers script globally
        window.documentsWithCoords = @json($documentsWithCoords ?? collect());
        
        // Always initialize map, with or without coordinates
        const checkOpenLayers = setInterval(() => {
            if (typeof ol !== 'undefined' && typeof initOpenLayersOverviewMap !== 'undefined' && typeof initOpenLayersEmptyMap !== 'undefined') {
                clearInterval(checkOpenLayers);
                setTimeout(() => {
                    console.log('Checking documents:', window.documentsWithCoords);
                    console.log('Documents length:', window.documentsWithCoords ? window.documentsWithCoords.length : 0);
                    console.log('Documents data:', JSON.stringify(window.documentsWithCoords));
                    
                    if (window.documentsWithCoords && window.documentsWithCoords.length > 0) {
                        console.log('Initializing map with coordinates');
                        // Initialize map with document coordinates
                        initOpenLayersOverviewMap(window.documentsWithCoords);
                        
                        // Double-check after a short delay to ensure overlay is removed
                        setTimeout(() => {
                            const mapContainer = document.getElementById('olOverviewMap');
                            if (mapContainer) {
                                const existingOverlays = mapContainer.querySelectorAll('.absolute.inset-0');
                                if (existingOverlays.length > 0) {
                                    console.log('Removing existing overlays after coordinate detection');
                                    existingOverlays.forEach(overlay => overlay.remove());
                                }
                            }
                        }, 500);
                    } else {
                        console.log('Initializing empty map');
                        // Initialize empty map (default to Indonesia)
                        initOpenLayersEmptyMap();
                    }
                }, 100);
            }
        }, 100);
        
        // Timeout after 5 seconds
        setTimeout(() => {
            clearInterval(checkOpenLayers);
            console.warn('OpenLayers failed to load within timeout');
            
            // Hide loading indicator and show timeout message
            const loadingIndicator = document.getElementById('olMapLoading');
            if (loadingIndicator) {
                loadingIndicator.innerHTML = `
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8 mx-auto mb-2 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>Timeout memuat peta</p>
                        <p class="text-sm mt-1">Silakan refresh halaman</p>
                    </div>
                `;
            }
        }, 5000);
        
        // Close modal when clicking outside
        const mapModal = document.getElementById('olMapModal');
        if (mapModal) {
            mapModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeOpenLayersMap();
                }
            });
        }
    });
</script>