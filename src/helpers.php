<?php

use Caujasutom\LaravelOptimizer\StaticHtmlCache;

if (!function_exists('store_static_cache')) {
    function store_static_cache(string $url, string $content, int $ttl = null): void
    {
        StaticHtmlCache::store($url, $content, $ttl);
    }
}

if (!function_exists('retrieve_static_cache')) {
    function retrieve_static_cache(string $url): ?string
    {
        return StaticHtmlCache::retrieve($url);
    }
}

if (!function_exists('delete_static_cache')) {
    function delete_static_cache(string $url): void
    {
        StaticHtmlCache::delete($url);
    }
}