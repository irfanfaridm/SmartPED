/**
 * OpenLayers Map Implementation for SmartPED
 * This file provides map functionality using OpenLayers as an alternative to Google Maps
 */

// Initialize map variables
let olMap, olMarker, olPopup;
let olOverviewMap;

/**
 * Initialize a single location map
 * @param {number} lat - Latitude
 * @param {number} lng - Longitude
 * @param {string} title - Map title
 * @param {string} location - Location description
 */
function initOpenLayersMap(lat, lng, title, location) {
    // Create map container if not exists
    const mapContainer = document.getElementById('olMap');
    if (!mapContainer) return;
    
    // Clear previous map instance
    mapContainer.innerHTML = '';
    
    // Create map
    olMap = new ol.Map({
        target: 'olMap',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([lng, lat]),
            zoom: 15
        })
    });
    
    // Add marker
    const markerFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([lng, lat])),
        name: title,
        description: location
    });
    
    const vectorSource = new ol.source.Vector({
        features: [markerFeature]
    });
    
    const markerStyle = new ol.style.Style({
        image: new ol.style.Circle({
            radius: 8,
            fill: new ol.style.Fill({color: '#e60000'}),
            stroke: new ol.style.Stroke({
                color: '#ffffff',
                width: 2
            })
        })
    });
    
    const vectorLayer = new ol.layer.Vector({
        source: vectorSource,
        style: markerStyle
    });
    
    olMap.addLayer(vectorLayer);
    
    // Add popup
    olPopup = new ol.Overlay({
        element: document.createElement('div'),
        positioning: 'bottom-center',
        stopEvent: false,
        offset: [0, -10]
    });
    
    olPopup.getElement().className = 'ol-popup';
    olPopup.getElement().innerHTML = `
        <div class="bg-white rounded-lg shadow-lg p-3 max-w-xs">
            <h4 class="font-bold text-gray-800">${title}</h4>
            <p class="text-sm text-gray-600">${location}</p>
            <p class="text-xs text-gray-500 mt-1">${lat.toFixed(6)}, ${lng.toFixed(6)}</p>
        </div>
    `;
    
    olMap.addOverlay(olPopup);
    olPopup.setPosition(ol.proj.fromLonLat([lng, lat]));
    
    // Add click interaction
    olMap.on('click', function(evt) {
        const feature = olMap.forEachFeatureAtPixel(evt.pixel, function(feature) {
            return feature;
        });
        
        if (feature) {
            const coordinates = feature.getGeometry().getCoordinates();
            olPopup.setPosition(coordinates);
        } else {
            olPopup.setPosition(undefined);
        }
    });
    
    // Add hover effect
    olMap.on('pointermove', function(evt) {
        const pixel = olMap.getEventPixel(evt.originalEvent);
        const hit = olMap.hasFeatureAtPixel(pixel);
        olMap.getTargetElement().style.cursor = hit ? 'pointer' : '';
    });
}

/**
 * Initialize overview map with multiple markers
 * @param {Array} documents - Array of documents with latitude and longitude
 */
function initOpenLayersOverviewMap(documents) {
    if (!documents || documents.length === 0) return;
    
    // Create map container if not exists
    const mapContainer = document.getElementById('olOverviewMap');
    if (!mapContainer) return;
    
    // Clear previous map instance
    mapContainer.innerHTML = '';
    
    // Create map
    olOverviewMap = new ol.Map({
        target: 'olOverviewMap',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([106.8456, -6.2088]), // Default to Jakarta
            zoom: 10
        })
    });
    
    // Add markers for each document
    const features = documents.map(doc => {
        return new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([parseFloat(doc.longitude), parseFloat(doc.latitude)])),
            name: doc.nama_dokumen,
            description: doc.lokasi,
            id: doc.id
        });
    });
    
    const vectorSource = new ol.source.Vector({
        features: features
    });
    
    const markerStyle = new ol.style.Style({
        image: new ol.style.Circle({
            radius: 6,
            fill: new ol.style.Fill({color: '#e60000'}),
            stroke: new ol.style.Stroke({
                color: '#ffffff',
                width: 2
            })
        })
    });
    
    const vectorLayer = new ol.layer.Vector({
        source: vectorSource,
        style: markerStyle
    });
    
    olOverviewMap.addLayer(vectorLayer);
    
    // Create popup overlay
    const popupElement = document.createElement('div');
    popupElement.className = 'ol-popup';
    
    const popup = new ol.Overlay({
        element: popupElement,
        positioning: 'bottom-center',
        stopEvent: false,
        offset: [0, -10]
    });
    
    olOverviewMap.addOverlay(popup);
    
    // Add click interaction
    olOverviewMap.on('click', function(evt) {
        const feature = olOverviewMap.forEachFeatureAtPixel(evt.pixel, function(feature) {
            return feature;
        });
        
        if (feature) {
            const coordinates = feature.getGeometry().getCoordinates();
            popupElement.innerHTML = `
                <div class="bg-white rounded-lg shadow-lg p-3 max-w-xs">
                    <h4 class="font-bold text-gray-800">${feature.get('name')}</h4>
                    <p class="text-sm text-gray-600">${feature.get('description')}</p>
                    <button onclick="showOpenLayersMap(${ol.proj.transform(coordinates, 'EPSG:3857', 'EPSG:4326')[1]}, ${ol.proj.transform(coordinates, 'EPSG:3857', 'EPSG:4326')[0]}, '${feature.get('name')}', '${feature.get('description')}')" 
                            class="mt-2 bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition-colors">
                        Detail
                    </button>
                </div>
            `;
            popup.setPosition(coordinates);
        } else {
            popup.setPosition(undefined);
        }
    });
    
    // Add hover effect
    olOverviewMap.on('pointermove', function(evt) {
        const pixel = olOverviewMap.getEventPixel(evt.originalEvent);
        const hit = olOverviewMap.hasFeatureAtPixel(pixel);
        olOverviewMap.getTargetElement().style.cursor = hit ? 'pointer' : '';
    });
    
    // Fit view to show all markers
    if (features.length > 0) {
        const extent = vectorSource.getExtent();
        olOverviewMap.getView().fit(extent, {
            padding: [50, 50, 50, 50],
            maxZoom: 15
        });
    }
}

/**
 * Show map modal with OpenLayers
 * @param {number} lat - Latitude
 * @param {number} lng - Longitude
 * @param {string} title - Map title
 * @param {string} location - Location description
 */
function showOpenLayersMap(lat, lng, title, location) {
    // Show modal
    document.getElementById('olMapModal').classList.remove('hidden');
    document.getElementById('olMapTitle').textContent = title;
    document.getElementById('olMapLocation').textContent = location;
    document.getElementById('olGoogleMapsLink').href = `https://maps.google.com/?q=${lat},${lng}`;
    
    // Initialize map after modal is shown
    setTimeout(() => {
        initOpenLayersMap(lat, lng, title, location);
    }, 100);
}

/**
 * Close map modal
 */
function closeOpenLayersMap() {
    document.getElementById('olMapModal').classList.add('hidden');
    if (olMap) {
        olMap = null;
    }
}

/**
 * Initialize coordinate picker map for document creation/editing
 */
function initOpenLayersCoordinatePicker() {
    // Create map container if not exists
    const mapContainer = document.getElementById('olCoordinateMap');
    if (!mapContainer) return;
    
    // Clear previous map instance
    mapContainer.innerHTML = '';
    
    // Default to Jakarta center
    const defaultPosition = [106.8456, -6.2088];
    
    // Create map
    const coordinateMap = new ol.Map({
        target: 'olCoordinateMap',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat(defaultPosition),
            zoom: 10
        })
    });
    
    // Create marker source and layer
    const markerSource = new ol.source.Vector();
    
    const markerStyle = new ol.style.Style({
        image: new ol.style.Circle({
            radius: 8,
            fill: new ol.style.Fill({color: '#e60000'}),
            stroke: new ol.style.Stroke({
                color: '#ffffff',
                width: 2
            })
        })
    });
    
    const markerLayer = new ol.layer.Vector({
        source: markerSource,
        style: markerStyle
    });
    
    coordinateMap.addLayer(markerLayer);
    
    // Add click interaction to place marker
    coordinateMap.on('click', function(evt) {
        // Clear previous markers
        markerSource.clear();
        
        // Add new marker
        const coordinates = evt.coordinate;
        const lonLat = ol.proj.transform(coordinates, 'EPSG:3857', 'EPSG:4326');
        
        const feature = new ol.Feature({
            geometry: new ol.geom.Point(coordinates)
        });
        
        markerSource.addFeature(feature);
        
        // Update selected coordinates
        window.selectedLng = lonLat[0];
        window.selectedLat = lonLat[1];
        
        // Show coordinates in info box
        const infoBox = document.getElementById('olCoordinateInfo');
        if (infoBox) {
            infoBox.innerHTML = `
                <div class="p-2 bg-white bg-opacity-90 rounded shadow-sm">
                    <p class="font-semibold">Lokasi Dipilih</p>
                    <p class="text-sm">Lat: ${selectedLat.toFixed(6)}</p>
                    <p class="text-sm">Lng: ${selectedLng.toFixed(6)}</p>
                </div>
            `;
        }
    });
    
    return coordinateMap;
}

/**
 * Show coordinate picker modal with OpenLayers
 */
function showOpenLayersCoordinatePicker() {
    // Create modal if not exists
    if (!document.getElementById('olCoordinatePickerModal')) {
        const modal = document.createElement('div');
        modal.id = 'olCoordinatePickerModal';
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
        modal.innerHTML = `
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Pilih Lokasi di Peta</h3>
                    <button onclick="closeOpenLayersCoordinatePicker()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <div id="olCoordinateMap" class="w-full h-96 rounded-lg border border-gray-200"></div>
                    <div id="olCoordinateInfo" class="absolute top-20 right-8 z-10"></div>
                </div>
                <div class="flex justify-between items-center p-4 border-t">
                    <div class="text-sm text-gray-600">
                        Klik pada peta untuk memilih lokasi
                    </div>
                    <button onclick="confirmOpenLayersCoordinate()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                        Konfirmasi Lokasi
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    } else {
        document.getElementById('olCoordinatePickerModal').classList.remove('hidden');
    }
    
    // Initialize coordinate picker map
    setTimeout(() => {
        initOpenLayersCoordinatePicker();
    }, 100);
}

/**
 * Close coordinate picker modal
 */
function closeOpenLayersCoordinatePicker() {
    const modal = document.getElementById('olCoordinatePickerModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

/**
 * Confirm selected coordinates and update form fields
 */
function confirmOpenLayersCoordinate() {
    if (window.selectedLat && window.selectedLng) {
        document.getElementById('latitude').value = window.selectedLat.toFixed(6);
        document.getElementById('longitude').value = window.selectedLng.toFixed(6);
        closeOpenLayersCoordinatePicker();
    } else {
        alert('Silakan pilih lokasi di peta terlebih dahulu');
    }
}

// Document ready handler
document.addEventListener('DOMContentLoaded', function() {
    // Initialize overview map if container exists
    const overviewMapContainer = document.getElementById('olOverviewMap');
    if (overviewMapContainer && typeof documentsWithCoords !== 'undefined' && documentsWithCoords.length > 0) {
        initOpenLayersOverviewMap(documentsWithCoords);
    }
    
    // Close modal when clicking outside
    const mapModal = document.getElementById('olMapModal');
    if (mapModal) {
        mapModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeOpenLayersMap();
            }
        });
    }
    
    // Close coordinate picker when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.id === 'olCoordinatePickerModal') {
            closeOpenLayersCoordinatePicker();
        }
    });
});