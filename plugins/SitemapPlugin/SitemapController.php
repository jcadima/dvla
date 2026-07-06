<?php

namespace Plugins\SitemapPlugin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Page;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $posts = Post::orderBy('updated_at', 'DESC')->get();
        $pages = Page::orderBy('updated_at', 'DESC')->get();
        return response()->view('plugins.sitemap-plugin.sitemap', compact('pages', 'posts'))
                         ->header('Content-Type', 'text/xml');
    }
} 