<?php

namespace Caujasutom\LaravelOptimizer\Facades;

use Caujasutom\LaravelOptimizer\StaticHtmlCache;
use Illuminate\Support\Facades\Facade;

/**
 * @method static StaticHtmlCache cache()
 * @method static void store(string $url, string $content, int $minutes = null)
 * @method static string|null retrieve(string $url)
 * @method static void delete(string $url)
 */
class LaravelOptimizer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Caujasutom\LaravelOptimizer\StaticHtmlCache';
    }
}
