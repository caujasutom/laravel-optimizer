<?php

namespace Caujasutom\LaravelOptimizer;



use Illuminate\Support\Facades\Storage;

class StaticHtmlCache
{
    public static function getCacheKey(string $url): string
    {
        return 'static_cache/' . md5($url) . '.html';
    }

    public static function store(string $url, string $content, int $ttl = null): void
    {
        $cacheKey = self::getCacheKey($url);
        $minifiedContent = self::minifyHtml($content);
        Storage::put($cacheKey, $minifiedContent, $ttl);
    }

    public static function retrieve(string $url): ?string
    {
        $cacheKey = self::getCacheKey($url);

        if (Storage::exists($cacheKey)) {
            return Storage::get($cacheKey);
        }

        return null;
    }

    public static function delete(string $url): void
    {
        $cacheKey = self::getCacheKey($url);
        Storage::delete($cacheKey);
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
}
