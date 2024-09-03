<?php

namespace Caujasutom\LaravelOptimizer\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HtmlMinifyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $contentType = $response->headers->get('Content-Type', '');
        if (!str_contains($contentType, 'text/html')) {
            return $response;
        }

        $buffer = $response->getContent();
        $minifiedHtml = $this->minifyContent($buffer);
        $response->setContent($minifiedHtml);

        return $response;
    }

    public function minifyContent(string $content): string
    {
        $content = preg_replace('/>\s+</', '><', $content);
        $content = preg_replace('/>\s+/', '>', $content);
        $content = preg_replace('/\s+</', '<', $content);
        return trim($content);
    }
}