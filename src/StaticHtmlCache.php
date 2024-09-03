<?php

namespace Caujasutom\LaravelOptimizer;

use Caujasutom\LaravelOptimizer\Middleware\HtmlMinifyMiddleware;
use Illuminate\Support\Facades\Storage;

/**
 * Class StaticHtmlCache
 * Handles caching of static HTML content.
 */
class StaticHtmlCache
{
    /**
     * Get a new instance of the StaticHtmlCache.
     *
     * @return StaticHtmlCache
     */
    public static function cache(): StaticHtmlCache
    {
        return new self();
    }

    /**
     * Store the generated HTML content for the given URL.
     *
     * @param string $url The URL for which the HTML content is generated.
     * @param string $content The HTML content to be cached.
     * @param int|null $minutes The duration in minutes for which the content should be cached.
     * @return void
     */
    public function store(string $url, string $content, ?int $minutes = null): void
    {
        $minutes = $minutes ?? config('laravel_optimizer.static_cache_ttl');
        $cacheKey = self::getCacheKey($url);

        $minifiedContent = config('laravel_optimizer.minification.enabled')
            ? (new HtmlMinifyMiddleware())->minifyContent($content)
            : $content;

        Storage::put($cacheKey, $minifiedContent, ['visibility' => 'public']);
    }

    /**
     * Generate the cache key for a given URL.
     *
     * @param string $url The URL for which to generate the cache key.
     * @return string The cache key for the given URL.
     */
    public static function getCacheKey(string $url): string
    {
        $cachePath = config('laravel_optimizer.cache_path');
        return $cachePath . md5($url) . '.html';
    }

    /**
     * Retrieve the cached HTML content for the given URL.
     *
     * @param string $url The URL for which to retrieve the cached HTML content.
     * @return string|null The cached HTML content, or null if it doesn't exist.
     */
    public function retrieve(string $url): ?string
    {
        $cacheKey = self::getCacheKey($url);

        if (Storage::exists($cacheKey)) {
            return Storage::get($cacheKey);
        }

        return null;
    }

    /**
     * Delete the cached HTML content for the given URL.
     *
     * @param string $url The URL for which to delete the cached HTML content.
     * @return void
     */
    public function delete(string $url): void
    {
        $cacheKey = self::getCacheKey($url);
        Storage::delete($cacheKey);
    }
}