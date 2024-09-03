<?php

use Caujasutom\LaravelOptimizer\StaticHtmlCache;

// Store static cache for a given URL and content.
if (!function_exists('store_static_cache')) {
    function store_static_cache(string $url, string $content, int $minutes = null): void
    {
        StaticHtmlCache::cache()->store($url, $content, $minutes);
    }
}

// Retrieve static cache for a given URL.
if (!function_exists('retrieve_static_cache')) {
    function retrieve_static_cache(string $url): ?string
    {
        return StaticHtmlCache::cache()->retrieve($url);
    }
}

// Delete static cache for a given URL.
if (!function_exists('delete_static_cache')) {
    function delete_static_cache(string $url): void
    {
        StaticHtmlCache::cache()->delete($url);
    }
}