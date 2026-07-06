<?php

namespace App\Livewire\Admin\Post;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;
    #[Url]
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Post::query();
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        $posts = $query->latest()->paginate(10);
        
        return view('livewire.admin.posts.index', [
            'posts' => $posts,
            'showStatus' => true,
        ])->layout('layouts.admin');
    }
}
