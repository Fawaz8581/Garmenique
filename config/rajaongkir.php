<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Raja Ongkir API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the Raja Ongkir API integration.
    | You need to get your API key from https://rajaongkir.com
    |
    */

    'api_key' => env('RAJAONGKIR_API_KEY', ''),

    // Base URL for Raja Ongkir API (starter package by default)
    'base_url' => env('RAJAONGKIR_BASE_URL', 'https://api.rajaongkir.com/starter'),

    // Supported couriers
    'couriers' => [
        'jne' => 'JNE',
        'pos' => 'POS Indonesia',
        'tiki' => 'TIKI',
        'sicepat' => 'SiCepat',
        'jnt' => 'J&T Express'
    ],
]; 