<?php

/**
 * Application Configuration
 */

return [
    'app_name' => 'Bike Rental System',
    'app_env' => getenv('APP_ENV') ?: 'production',
    'debug' => getenv('APP_DEBUG') === 'true',
    
    'pagination' => [
        'per_page' => 10,
        'max_per_page' => 100,
    ],

    'bike_types' => [
        'mountain' => 'Mountain Bike',
        'road' => 'Road Bike',
        'cruiser' => 'Cruiser',
        'hybrid' => 'Hybrid',
        'bmx' => 'BMX',
        'electric' => 'Electric',
    ],

    'price_ranges' => [
        ['min' => 0, 'max' => 20, 'label' => 'Under $20'],
        ['min' => 20, 'max' => 40, 'label' => '$20 - $40'],
        ['min' => 40, 'max' => 60, 'label' => '$40 - $60'],
        ['min' => 60, 'max' => PHP_INT_MAX, 'label' => '$60+'],
    ],
];
