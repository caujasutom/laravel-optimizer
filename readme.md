<h1>Laravel Optimizer Package</h1>  
<p>
The Laravel Optimizer package is a collection of middlewares and helpers designed to optimize and improve the performance of your Laravel applications. It includes HTML minification,  static HTML caching, and Gzip compression.
</p>  
<h2>Table of Contents</h2>  
<ol>  
    <li><a href="#installation">Installation</a></li>  
    <li><a href="#configuration">Configuration</a></li>  
    <li>
        <a href="#middlewares">Middlewares</a>  
        <ol>  
            <li><a href="#html-minify-middleware">HTML Minify Middleware</a></li>  
            <li><a href="#static-html-cache-middleware">Static HTML Cache Middleware</a></li>  
            <li><a href="#gzip-compression-middleware">Gzip Compression Middleware</a></li>  
        </ol>  
    </li>
    <li><a href="#helpers">Helpers</a></li>
    <li><a href="#examples">Examples</a></li>
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
<pre><code>&lt;?php 
return [
    // ...
    'gzip_compression' => [
        'level' => 9, // Default compression level for Gzip.
    ],
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

<p>
    These helper functions can be used in your application to interact with the static HTML cache.
</p>
<h3><code>LaravelOptimizer::cache()->store()</code></h3>
<p>Stores the generated HTML content for the given URL.</p>
<pre><code>LaravelOptimizer::cache()->store($url, $content, $minutes = null);</code></pre>
<p>Parameters:</p>
<table>
    <tr>
        <th>Parameter</th>
        <th>Type</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>$url</code></td>
        <td>string</td>
        <td>The URL for which the HTML content is generated.</td>
    </tr>
    <tr>
        <td><code>$content</code></td>
        <td>string</td>
        <td>The HTML content to be cached.</td>
    </tr>
    <tr>
        <td><code>$minutes</code></td>
        <td>int|null</td>
        <td>The duration in minutes for which the content should be cached. If not provided, the default environment value will be used.</td>
    </tr>
</table>

<h3><code>LaravelOptimizer::cache()->retrieve($url)</code></h3>
<p>Retrieves the cached HTML content for the given URL.</p>
<pre><code>LaravelOptimizer::cache()->retrieve($url);</code></pre>
<p>Parameters:</p>
<table>
    <tr>
        <th>Parameter</th>
        <th>Type</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>$url</code></td>
        <td>string</td>
        <td>The URL for which to retrieve the cached HTML content.</td>
    </tr>
</table>
<p>Returns:</p>
<table>
    <tr>
        <th>Type</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>string|null</td>
        <td>The cached HTML content for the given URL, or null if it doesn't exist.</td>
    </tr>
</table>

<h3><code>LaravelOptimizer::cache()->delete($url)</code></h3>
<p>Deletes the cached HTML content for the given URL.</p>
<pre><code>LaravelOptimizer::cache()->delete($url);</code></pre>
<p>Parameters:</p>
<table>
    <tr>
        <th>Parameter</th>
        <th>Type</th>
        <th>Description</th>
    </tr>
    <tr>
        <td><code>$url</code></td>
        <td>string</td>
        <td>The URL for which to delete the cached HTML content.</td>
    </tr>
</table>
<h2 id="examples">Examples</h2>

````
<?php
namespace App\Http\Controllers;

use Caujasutom\LaravelOptimizer\LaravelOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ArticlesController extends Controller
{
    /**
    * Display a listing of articles.
    * 
    * @return \Illuminate\Http\Response
    */
    
    public function index()
    {
    
    // Check if cached HTML content exists for this URL
    $cachedContent = LaravelOptimizer::cache()->retrieve(request()->url());
    if ($cachedContent) {
    
        // If cached content exists, return it
        return response($cachedContent);
        
    } else {
    
        // If cached content doesn't exist, generate and cache new content
        $articles = Post::all() // Fetch articles from the database or any other source
        
        // Render the articles view
        $htmlContent = View::make('articles.index', ['articles' => $articles])->render();
        
        // Cache the generated HTML content for this URL
        LaravelOptimizer::cache()->store(request()->url(), $htmlContent);
        
        return response($htmlContent);
        }
    }
}
````
<p>In this example, we have an <code>ArticlesController</code> with an <code>index</code> function. This function is responsible for displaying a listing of articles.</p>
<p>Here's the breakdown of the function:</p>
<ol>
    <li>First, it checks if there is cached HTML content available for the current URL using the <code>LaravelOptimizer::cache()->retrieve(request()->url())</code> method.</li>
    <li>If cached content exists, it returns the cached HTML content as the response.</li>
    <li>If cached content doesn't exist, it fetches the articles from the database or any other source.</li>
    <li>It then renders the <code>articles.index</code> view with the fetched articles using <code>View::make()</code> and <code>render()</code> methods.</li>
    <li>The generated HTML content is stored in the variable <code>$htmlContent</code>.</li>
    <li>The generated HTML content is cached using <code>LaravelOptimizer::cache()->store(request()->url(), $htmlContent)</code> method.</li>
    <li>Finally, it returns the generated HTML content as the response.</li>
</ol>
