<?php

namespace Tests\Middleware;

use Caujasutom\LaravelOptimizer\Middleware\HtmlMinifyMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orchestra\Testbench\TestCase;

class HtmlMinifyMiddlewareTest extends TestCase
{
    public function testHtmlIsMinified()
    {
        $middleware = new HtmlMinifyMiddleware();

        $request = Request::create('/test');
        $response = new Response('<html lang="cs">   <body>   Hello   </body>   </html>', 200, ['Content-Type' => 'text/html']);

        $result = $middleware->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertEquals('<html lang="cs"><body>Hello</body></html>', $result->getContent());
    }
}