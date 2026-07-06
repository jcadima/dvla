<?php

namespace App\Livewire\Front;

use App\Models\Category;
use App\Models\IndexBlog;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Social;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public $category = null;

    protected $queryString = ['category'];

    // Properties for blog update
    public $title;

    public $meta_description;

    public $heading1;

    public $heading2;

    public $heading3;

    public $banner_image;

    public $blogInstance;

    public function mount()
    {
        $this->blogInstance = IndexBlog::first();
        if ($this->blogInstance) {
            $this->title = $this->blogInstance->title;
            $this->meta_description = $this->blogInstance->meta_description;
            $this->heading1 = $this->blogInstance->heading1;
            $this->heading2 = $this->blogInstance->heading2;
            $this->heading3 = $this->blogInstance->heading3;
            $this->banner_image = $this->blogInstance->banner_image;
        }
    }

    public function updateBlog()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'heading1' => 'nullable|string|max:255',
            'heading2' => 'nullable|string|max:255',
            'heading3' => 'nullable|string|max:255',
            'banner_image' => 'nullable|string|max:255',
        ]);

        if (! $this->blogInstance) {
            $this->blogInstance = IndexBlog::create([
                'title' => $this->title,
                'meta_description' => $this->meta_description,
                'heading1' => $this->heading1,
                'heading2' => $this->heading2,
                'heading3' => $this->heading3,
                'banner_image' => $this->banner_image,
            ]);
        } else {
            $this->blogInstance->update([
                'title' => $this->title,
                'meta_description' => $this->meta_description,
                'heading1' => $this->heading1,
                'heading2' => $this->heading2,
                'heading3' => $this->heading3,
                'banner_image' => $this->banner_image,
            ]);
        }

        // Dispatch a browser event to trigger notification
        $this->dispatch('notification', ['type' => 'success', 'message' => 'Blog updated successfully']);
    }

    public function render()
    {
        $query = Post::query();
        // Only show published posts unless admin is previewing
        if (! request()->query('preview') || ! Auth::check() || ! Auth::user()->hasRole('Administrator')) {
            $query->where('status', 'published');
        }
        if ($this->category) {
            $query->whereHas('categories', function ($q) {
                $q->where('slug', $this->category);
            });
        }
        $categories = Category::all();
        $blogPage = IndexBlog::first();
        $title = $blogPage->title ?? 'Blog';
        $meta_description = $blogPage->meta_description ?? '';

        // Use the posts_per_page setting from the blog configuration
        $postsPerPage = $blogPage->posts_per_page ?? 8;
        $posts = $query->latest()->paginate($postsPerPage);

        return view('livewire.front.blog-index', [
            'posts' => $posts,
            'categories' => $categories,
            'title' => $title,
            'meta_description' => $meta_description,
        ])->layout('layouts.frontend.blog', [
            'title' => $title,
            'meta_description' => $meta_description,
            'settings' => Setting::first(),
            'socialMediaLinks' => Social::first(),
        ]);
    }
}
