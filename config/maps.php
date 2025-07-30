<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for Google Maps API integration.
    | You need to get an API key from Google Cloud Console.
    |
    */

    'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Default Map Settings
    |--------------------------------------------------------------------------
    |
    | Default settings for maps display
    |
    */
    
    'default_zoom' => 15,
    'default_center' => [
        'lat' => -6.2088, // Jakarta
        'lng' => 106.8456,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Map Styles
    |--------------------------------------------------------------------------
    |
    | Custom map styles for better visualization
    |
    */
    
    'map_styles' => [
        [
            'featureType' => 'poi',
            'elementType' => 'labels',
            'stylers' => [
                ['visibility' => 'off']
            ]
        ]
    ],
]; 