<?php

namespace App\Livewire\Admin\Blog;

use App\Models\IndexBlog;
use Livewire\Component;

class BlogIndex extends Component
{
    public $title;

    public $meta_description;

    public $maxCharacters = 155;

    public $blogInstance;

    public $posts_per_page;

    public function mount()
    {
        $this->loadBlogData();
    }

    public function loadBlogData()
    {
        try {
            $this->blogInstance = IndexBlog::first();

            if ($this->blogInstance) {
                $this->title = $this->blogInstance->title ?? '';
                $this->meta_description = $this->blogInstance->meta_description ?? '';
                $this->posts_per_page = $this->blogInstance->posts_per_page ?? 8;
            } else {
                // No record exists, leave properties empty
                $this->title = '';
                $this->meta_description = '';
                $this->posts_per_page = 8;
            }
        } catch (\Exception $e) {
            // If database connection fails, leave properties empty
            $this->title = '';
            $this->meta_description = '';
            $this->posts_per_page = 8;
        }
    }

    public function render()
    {
        $remainingCharacters = max(0, $this->maxCharacters - strlen($this->meta_description ?? ''));
        $exceeded = strlen($this->meta_description ?? '') > $this->maxCharacters;

        return view('livewire.admin.blog-index.edit', [
            'remainingCharacters' => $remainingCharacters,
            'exceeded' => $exceeded,
        ])->layout('layouts.admin');
    }

    public function updateBlog()
    {
        $this->validate([
            'title' => 'required',
            'meta_description' => 'sometimes',
            'posts_per_page' => 'required|integer|min:1|max:50',
        ]);

        if (! $this->blogInstance) {
            $this->blogInstance = IndexBlog::create([
                'title' => $this->title,
                'meta_description' => $this->meta_description,
                'posts_per_page' => $this->posts_per_page,
            ]);
        } else {
            $this->blogInstance->update([
                'title' => $this->title,
                'meta_description' => $this->meta_description,
                'posts_per_page' => $this->posts_per_page,
            ]);
        }

        // Refresh the data to ensure form shows updated values
        $this->loadBlogData();

        // Dispatch a browser event to trigger Toastr notification
        $this->dispatch('notification', ['type' => 'success', 'message' => 'Blog updated']);
    }
}
