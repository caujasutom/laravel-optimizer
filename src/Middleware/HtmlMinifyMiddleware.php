<?php

namespace Caujasutom\LaravelOptimizer\Middleware;

use Closure;

class HtmlMinifyMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $contentType = $response->headers->get('Content-Type');
        if (strpos($contentType, 'text/html') === false) {
            return $response;
        }

        $buffer = $response->getContent();

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

        $minifiedHtml = preg_replace($search, $replace, $buffer);
        $response->setContent($minifiedHtml);

        return $response;
    }
}