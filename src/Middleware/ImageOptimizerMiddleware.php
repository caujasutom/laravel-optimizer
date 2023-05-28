<?php

namespace Caujasutom\LaravelOptimizer\Middleware;

use Closure;


class ImageOptimizerMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $contentType = $response->headers->get('Content-Type');
        if (strpos($contentType, 'image/') === false) {
            return $response;
        }

        $buffer = $response->getContent();
        $optimizedImage = ImageOptimizer::optimize($buffer, $contentType);

        $response->setContent($optimizedImage);

        return $response;
    }
}
