<?php

return [
    // Time-to-live for static cache in minutes.
    'static_cache_ttl' => env('LARAVEL_OPTIMIZER_STATIC_CACHE_TTL', 60),

    // Path for storing cache files.
    'cache_path' => env('LARAVEL_OPTIMIZER_CACHE_PATH', 'static_cache/'),

    // Compression level for gzip (0-9).
    'compression_level' => env('LARAVEL_OPTIMIZER_COMPRESSION_LEVEL', 9),

    // Gzip compression settings
    'gzip_compression' => [
        'level' => env('LARAVEL_OPTIMIZER_GZIP_COMPRESSION_LEVEL', 9), // Default compression level for Gzip.
    ],

    // Minification settings
    'minification' => [
        'enabled' => env('LARAVEL_OPTIMIZER_MINIFICATION_ENABLED', true),
        'patterns' => [
            '/>\s+/s',
            '/\s+</s',
            '/(\s)+/s',
            '/>\s+</',
            '/[\r\n]+/'
        ],
        'replacements' => [
            '>',
            '<',
            '\\1',
            '><',
            ''
        ],
    ],
];