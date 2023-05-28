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

    public function store(string $url, string $content, int $minutes = null): void
    {
        if ($minutes) {
            $minutes = $minutes * 60;
        }
        $cacheKey = self::getCacheKey($url);
        $minifiedContent = self::minifyHtml($content);
        Storage::put($cacheKey, $minifiedContent, $minutes);
    }

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

    public function retrieve(string $url): ?string
    {
        $cacheKey = self::getCacheKey($url);

        if (Storage::exists($cacheKey)) {
            return Storage::get($cacheKey);
        }

        return null;
    }

    public function delete(string $url): void
    {
        $cacheKey = self::getCacheKey($url);
        Storage::delete($cacheKey);
    }
}
