<h1>Laravel Optimizer Package</h1>  
<p>
The Laravel Optimizer package is a collection of middlewares and helpers designed to optimize and improve the performance of your Laravel applications. It includes HTML minification,  static HTML caching, image optimization, and Gzip compression.
</p>  
<h2>Table of Contents</h2>  
<ol>  
<li><a href="#installation">Installation</a></li>  
<li><a href="#configuration">Configuration</a></li>  
<li><a href="#middlewares">Middlewares</a>  
<ol>  
<li><a href="#html-minify-middleware">HTML Minify Middleware</a></li>  
<li><a href="#static-html-cache-middleware">Static HTML Cache Middleware</a></li>  
<li><a href="#image-optimizer-middleware">Image Optimizer Middleware</a></li>  
<li><a href="#gzip-compression-middleware">Gzip Compression Middleware</a></li>  
</ol>  
</li>  
<li><a href="#helpers">Helpers</a></li>  
</ol>  
<h2 id="installation">Installation</h2>  
<p> To install the Laravel Optimizer package, run the following command in your project's root directory: </p>  
<pre><code>composer require caujasutom/laravel-optimizer</code></pre>  
<p> After installing the package, publish the configuration file by running the following command: </p>  
<pre><code>php artisan vendor:publish --provider="Caujasutom\LaravelOptimizer\LaravelOptimizerServiceProvider"
</code></pre>  
<h2 id="configuration">Configuration</h2>  
<p>
The configuration file <code>config/laravel_optimizer.php</code> contains the default  
settings for the package. You can modify these settings to suit your needs.
</p>  
<pre><code><?php return [ 'html_minify' => [ // ... ],
'static_html_cache' => [ // ... ],
'image_optimization' => [ 'quality' => 85, // Default image quality for optimization. ],
'gzip_compression' => [ 'level' => 9, // Default compression level for Gzip. ],
];</code></pre>  
<h2 id="middlewares">Middlewares</h2>  
<h3 id="html-minify-middleware">1. HTML Minify Middleware</h3>  
<p> The <code>HtmlMinifyMiddleware</code> minifies HTML content by removing unnecessary whitespace and line breaks. To use this middleware, add it to your <code>app/Http/Kernel.php</code> file. </p>  
<pre><code>protected $middlewareGroups = [
    'web' => [
        // ...
        \Caujasutom\LaravelOptimizer\Middleware\HtmlMinifyMiddleware::class,
    ],
];</code></pre>  
<h3 id="static-html-cache-middleware">2. Static HTML Cache Middleware</h3>  
<p> The <code>StaticHtmlCacheMiddleware</code> caches the generated HTML content
for a specified duration. To use this middleware, add it to a specific route or route group in your <code>routes/web.php</code>  
file. </p>  
<pre><code>Route::middleware(['static.html.cache:60'])
    ->group(function () {
        Route::get('/', 'HomeController@index');
});</code></pre>  
<p>
The number (60 in the example above) represents the cache duration
in minutes. Adjust this value as needed.
</p>  
<h3 id="image-optimizer-middleware">3. Image Optimizer Middleware</h3>  
<p>
The <code>ImageOptimizerMiddleware</code> optimizes images by compressing them without losing quality. To use this middleware,  
add it to your <code>app/Http/Kernel.php</code> file.
</p>  
<pre><code>protected $middlewareGroups = [
    'web' => [
        // ...
        \Caujasutom\LaravelOptimizer\Middleware\ImageOptimizerMiddleware::class,
        ],
    // ... 
];</code></pre>  
<h3 id="gzip-compression-middleware">4. Gzip Compression Middleware</h3>  
<p>
The <code>GzipCompressionMiddleware</code> compresses the response content using Gzip compression. To use this middleware, add it to your <code>app/Http/Kernel.php</code> file.
</p>  
<pre><code>protected $middlewareGroups = [
    'web' => [
        // ...
        \Caujasutom\LaravelOptimizer\Middleware\GzipCompressionMiddleware::class,
    ],
    // ... 
];</code></pre>  
<h2 id="helpers">Helpers</h2>  
<p>
The package provides helper  functions
to simplify the use of the <code>StaticHtmlCache</code> class. The following functions are available:
</p>  
<ul>  
<li><code>cache_key($key)</code>: Generates a cache key for the given key string.</li>  
<li><code>cache_path($cacheKey)</code>: Returns the file path for the given cache key.</li>  
<li><code>cache_exists($cacheKey)</code>: Checks if a cache file exists for the given cache key.</li>  
<li><code>cache_get($cacheKey)</code>: Retrieves the cached content for the given cache key.</li>  
<li><code>cache_put($cacheKey, $content, $minutes)</code>: Stores the given content in the cache for the specified  
duration.  
</li>  
<li><code>cache_clear()</code>: Clears all the cached files.</li>  
</ul>  
<p> These helper functions can be used in your application to interact with the static HTML cache. </p>
