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
        @if(isset($documentsWithCoords) && $documentsWithCoords->count() > 0)
        // Make documents available to OpenLayers script
        const documentsWithCoords = @json($documentsWithCoords);
        
        // Initialize overview map with all document locations
        if (documentsWithCoords && documentsWithCoords.length > 0) {
            setTimeout(() => {
                initOpenLayersOverviewMap(documentsWithCoords);
            }, 500);
        }
        @endif
        
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