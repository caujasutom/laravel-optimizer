<?php

namespace Caujasutom\LaravelOptimizer;

use Caujasutom\LaravelOptimizer\Middleware\GzipCompressionMiddleware;
use Caujasutom\LaravelOptimizer\Middleware\StaticHtmlCacheMiddleware;

use Caujasutom\LaravelOptimizer\Middleware\HtmlMinifyMiddleware;
use Illuminate\Support\ServiceProvider;

class LaravelOptimizerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('html.minify', HtmlMinifyMiddleware::class);
        $router->aliasMiddleware('static.html.cache', StaticHtmlCacheMiddleware::class);
        $router->aliasMiddleware('gzip.compress', GzipCompressionMiddleware::class);
        $this->publishes([
            __DIR__ . '/config/laravel_optimizer.php' => config_path('laravel_optimizer.php'),
        ], 'config');

    }
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/laravel_optimizer.php', 'laravel_optimizer');
    }
}
