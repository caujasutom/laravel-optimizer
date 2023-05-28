<?php

namespace Caujasutom\LaravelOptimizer\Middleware;

use Caujasutom\LaravelOptimizer\Facades\LaravelOptimizer;
use Closure;

class StaticHtmlCacheMiddleware
{
    public function handle($request, Closure $next, int $minutes = null)
    {
        $url = $request->url();
        $cachedContent = LaravelOptimizer::retrieve($url);

        if ($cachedContent) {
            return response($cachedContent);
        }

        $response = $next($request);
        $content = $response->getContent();

        LaravelOptimizer::store($url, $content, $minutes);

        return $response;
    }
}
