<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use Livewire\Component;

class SitemapSettings extends Component
{
    public $settings = [];

    public $sitemapMode = 'all';

    public $includePosts = true;

    public $includePages = true;

    public $includeStaticRoutes = true;

    public $includedRoutes = [];

    public $excludedRoutes = [];

    public $availableRoutes = [];

    public $availablePages = [];

    public $availablePosts = [];

    protected $rules = [
        'sitemapMode' => 'required|in:all,custom',
        'includePosts' => 'boolean',
        'includePages' => 'boolean',
        'includeStaticRoutes' => 'boolean',
        'includedRoutes' => 'array',
        'excludedRoutes' => 'array',
    ];

    public function mount()
    {
        $settings = Setting::first();
        if ($settings) {
            $this->settings = $settings->toArray();
            $this->sitemapMode = $settings->sitemap_mode ?? 'all';
            $this->includePosts = $settings->sitemap_include_posts ?? true;
            $this->includePages = $settings->sitemap_include_pages ?? true;
            $this->includeStaticRoutes = $settings->sitemap_include_static_routes ?? true;
            $this->includedRoutes = $settings->sitemap_included_routes ?? [];
            $this->excludedRoutes = $settings->sitemap_excluded_routes ?? [];
        }

        $this->loadAvailableRoutes();
    }

    public function loadAvailableRoutes()
    {
        // Load available pages
        $this->availablePages = Page::select('id', 'title', 'slug')
            ->orderBy('title')
            ->get()
            ->map(function ($page) {
                return [
                    'id' => $page->id,
                    'title' => $page->title,
                    'route' => '/'.$page->slug,
                    'type' => 'page',
                ];
            })
            ->toArray();

        // Load available posts
        $this->availablePosts = Post::select('id', 'title', 'slug')
            ->orderBy('title')
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'route' => '/blog/'.$post->slug,
                    'type' => 'post',
                ];
            })
            ->toArray();

        // Define static routes
        $this->availableRoutes = [
            ['id' => 'home', 'title' => 'Home Page', 'route' => '/', 'type' => 'static'],
            ['id' => 'blog', 'title' => 'Blog Index', 'route' => '/blog', 'type' => 'static'],
            ['id' => 'about', 'title' => 'About Us', 'route' => '/about-us', 'type' => 'static'],
            ['id' => 'contact', 'title' => 'Contact Us', 'route' => '/contact', 'type' => 'static'],
            ['id' => 'privacy', 'title' => 'Privacy Policy', 'route' => '/privacy-policy', 'type' => 'static'],
        ];
    }

    public function updateSitemapSettings()
    {
        $this->validate();

        $settings = Setting::first();
        if (! $settings) {
            $settings = new Setting;
        }

        $settings->sitemap_mode = $this->sitemapMode;
        $settings->sitemap_include_posts = $this->includePosts;
        $settings->sitemap_include_pages = $this->includePages;
        $settings->sitemap_include_static_routes = $this->includeStaticRoutes;
        $settings->sitemap_included_routes = $this->includedRoutes;
        $settings->sitemap_excluded_routes = $this->excludedRoutes;
        $settings->save();

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Sitemap settings updated successfully!',
        ]);
    }

    public function addIncludedRoute($route)
    {
        if (! in_array($route, $this->includedRoutes)) {
            $this->includedRoutes[] = $route;
        }
    }

    public function removeIncludedRoute($route)
    {
        $this->includedRoutes = array_filter($this->includedRoutes, function ($item) use ($route) {
            return $item !== $route;
        });
    }

    public function addExcludedRoute($route)
    {
        if (! in_array($route, $this->excludedRoutes)) {
            $this->excludedRoutes[] = $route;
        }
    }

    public function removeExcludedRoute($route)
    {
        $this->excludedRoutes = array_filter($this->excludedRoutes, function ($item) use ($route) {
            return $item !== $route;
        });
    }

    public function render()
    {
        return view('livewire.admin.sitemap-settings')->layout('layouts.admin');
    }
}
