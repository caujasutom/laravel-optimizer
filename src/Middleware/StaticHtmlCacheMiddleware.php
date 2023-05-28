<?php

namespace Caujasutom\LaravelOptimizer\Middleware;

use Closure;
use Caujasutom\LaravelOptimizer\StaticHtmlCache;

class StaticHtmlCacheMiddleware
{
    public function handle($request, Closure $next, int $ttl = null)
    {
        $url = $request->url();
        $cachedContent = StaticHtmlCache::retrieve($url);

        if ($cachedContent) {
            return response($cachedContent);
        }

        $response = $next($request);
        $content = $response->getContent();

        StaticHtmlCache::store($url, $content, $ttl);

        return $response;
    }
}
