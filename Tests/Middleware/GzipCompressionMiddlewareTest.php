<?php

namespace Tests\Middleware;

use Caujasutom\LaravelOptimizer\Middleware\GzipCompressionMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orchestra\Testbench\TestCase;

class GzipCompressionMiddlewareTest extends TestCase
{
    public function testResponseIsGzipped()
    {
        $middleware = new GzipCompressionMiddleware();

        $request = Request::create('/test', 'GET', [], [], [], ['HTTP_ACCEPT_ENCODING' => 'gzip']);
        $response = new Response('Hello World', 200, ['Content-Type' => 'text/plain']);

        $result = $middleware->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertEquals('gzip', $result->headers->get('Content-Encoding'));
        $this->assertNotEquals('Hello World', $result->getContent());
    }
}