<?php

namespace Caujasutom\LaravelOptimizer\Middleware;

use Closure;

class GzipCompressionMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (!$request->headers->has('Accept-Encoding') || !str_contains($request->headers->get('Accept-Encoding'), 'gzip')) {
            return $response;
        }

        $buffer = $response->getContent();
        $compressedContent = gzencode($buffer, 9);
        $response->setContent($compressedContent);
        $response->headers->set('Content-Encoding', 'gzip');

        return $response;
    }
}
