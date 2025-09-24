<?php

return [

    // App identity
    'name' => env('APP_NAME', 'Laravel'),

    // Environment
    'env' => env('APP_ENV', 'production'),

    // Debug flag
    'debug' => (bool) env('APP_DEBUG', false),

    // Base URL
    'url' => env('APP_URL', 'http://localhost'),

    // Timezone / locale
    'timezone' => 'Asia/Manila',
    'locale' => env('APP_LOCALE', 'en'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    // Encryption
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    // Maintenance mode
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store'  => env('APP_MAINTENANCE_STORE', 'database'),
    ],

]; // <— Wala nang 'providers' key dito sa Laravel 12
