<?php

namespace Caujasutom\LaravelOptimizer\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GzipCompressionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$response->isSuccessful()) {
            return $response;
        }

        $acceptEncoding = $request->headers->get('Accept-Encoding', '');

        if (str_contains($acceptEncoding, 'gzip')) {
            $contentType = $response->headers->get('Content-Type', '');

            if (str_starts_with($contentType, 'text/')) {
                $buffer = $response->getContent();
                $compressionLevel = config('laravel_optimizer.gzip_compression.level', 9);
                $compressedContent = gzencode($buffer, $compressionLevel);
                $response->setContent($compressedContent);
                $response->headers->set('Content-Encoding', 'gzip');
                $response->headers->set('Content-Length', (string)strlen($compressedContent));
            }
        }

        return $response;
    }
}