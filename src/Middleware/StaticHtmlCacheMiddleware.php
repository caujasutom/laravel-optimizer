<?php

namespace Caujasutom\LaravelOptimizer\Middleware;

use Caujasutom\LaravelOptimizer\Facades\LaravelOptimizer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StaticHtmlCacheMiddleware
{
    public function handle(Request $request, Closure $next, ?int $minutes = null): Response
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