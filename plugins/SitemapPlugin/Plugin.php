<?php

namespace Plugins\SitemapPlugin;

use Illuminate\Support\Facades\Route;

class Plugin
{
    public function boot()
    {
        // Register the sitemap route only if plugin is enabled
        Route::middleware('web')->get('/sitemap.xml', [SitemapController::class, 'sitemap']);
    }
} 