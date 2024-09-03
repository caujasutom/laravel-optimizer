<?php

namespace Tests;

use Caujasutom\LaravelOptimizer\StaticHtmlCache;
use Illuminate\Support\Facades\Storage;
use Orchestra\Testbench\TestCase;

class StaticHtmlCacheTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function testStoreAndRetrieveCache()
    {
        $url = 'http://example.com';
        $content = '<html><body>Hello World</body></html>';

        $cache = new StaticHtmlCache();
        $cache->store($url, $content);

        $this->assertTrue(Storage::exists(StaticHtmlCache::getCacheKey($url)));
        $this->assertEquals($content, $cache->retrieve($url));
    }

    public function testDeleteCache()
    {
        $url = 'http://example.com';
        $content = '<html><body>Hello World</body></html>';

        $cache = new StaticHtmlCache();
        $cache->store($url, $content);
        $cache->delete($url);

        $this->assertFalse(Storage::exists(StaticHtmlCache::getCacheKey($url)));
    }
}