<?php

namespace Caujasutom\LaravelOptimizer;

use Illuminate\Support\Facades\Storage;

class StaticHtmlCache
{
    /**
     * Class StaticHtmlCache
     * @package Caujasutom\LaravelOptimizer
     *
     * @method void store(string $url, string $content, int $minutes = null)
     * @method string|null retrieve(string $url)
     * @method void delete(string $url)
     */
    public static function cache(): StaticHtmlCache
    {
        return new self();
    }

    /**
     * Stores the generated HTML content for the given URL.
     *
     * @param string $url The URL for which the HTML content is generated.
     * @param string $content The HTML content to be cached.
     * @param int|null $minutes The duration in minutes for which the content should be cached. If not provided, the default environment value will be used.
     * @return void
     */
    public function store(string $url, string $content, int $minutes = null): void
    {
        if ($minutes) {
            $minutes = $minutes * 60;
        }
        $cacheKey = self::getCacheKey($url);
        $minifiedContent = self::minifyHtml($content);
        Storage::put($cacheKey, $minifiedContent, $minutes);
    }

    /**
     * Generates the cache key for a given URL.
     *
     * @param string $url The URL for which to generate the cache key.
     * @return string The cache key for the given URL.
     */
    public static function getCacheKey(string $url): string
    {
        return 'static_cache/' . md5($url) . '.html';
    }

    public static function minifyHtml(string $content): string
    {
        $search = [
            '/>\s+/s',
            '/\s+</s',
            '/(\s)+/s',
            '/>\s+</',
            '/[\r\n]+/'
        ];

        $replace = [
            '>',
            '<',
            '\\1',
            '><',
            ''
        ];

        return preg_replace($search, $replace, $content);
    }

    /**
     * Retrieves the cached HTML content for the given URL.
     *
     * @param string $url The URL for which to retrieve the cached HTML content.
     * @return string|null The cached HTML content for the given URL, or null if it doesn't exist.
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
     * Deletes the cached HTML content for the given URL.
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
