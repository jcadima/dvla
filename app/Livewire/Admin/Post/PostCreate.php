<?php

namespace App\Livewire\Admin\Post;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostFile;
use App\Traits\ManagesPageContent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostCreate extends Component
{
    use ManagesPageContent;
    use WithFileUploads;

    public $maxCharacters = 155;

    public $post_file;

    public $post_id;

    public $title;

    public $slug;

    public $meta_description;

    public $post_content;

    public $selectedCategories = [];

    public $container_type = 'container';

    public $status = 'draft';

    protected $rules = [
        'title' => 'required',
        'slug' => 'required',
        'meta_description' => 'sometimes',
        'post_content' => 'sometimes',
        'post_file' => 'nullable|mimes:jpg,jpeg,png|max:5024',
        'status' => 'required|in:draft,published',
    ];

    public function render()
    {
        $categories = Category::all();
        $remainingCharacters = max(0, $this->maxCharacters - strlen($this->meta_description ?? ''));
        $exceeded = strlen($this->meta_description ?? '') > $this->maxCharacters;

        return view('livewire.admin.posts.create', [
            'categories' => $categories,
            'remainingCharacters' => $remainingCharacters,
            'exceeded' => $exceeded,
        ])->layout('layouts.admin');

    }

    public function store()
    {
        $this->validate();

        $post = Post::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'meta_description' => $this->meta_description,
            'post_content' => $this->post_content,
            'container_type' => $this->container_type,
            'status' => $this->status,
        ]);

        // Sync categories for many-to-many relationship
        if (! empty($this->selectedCategories)) {
            $post->categories()->sync($this->selectedCategories);
        }

        if (isset($this->post_file)) {
            $filename = time().'_'.$this->post_file->getClientOriginalName();
            $fileContents = File::get($this->post_file->getRealPath());
            Storage::disk('posts')->put($filename, $fileContents);

            // Get file size in bytes
            $fileSizeInBytes = round($this->post_file->getSize(), 2);

            // Convert to kilobytes
            $fileSizeInKB = round($fileSizeInBytes / 1024, 2);

            PostFile::create([
                'post_id' => $post->id,
                'filename' => $filename,
                'filesize' => $fileSizeInKB,
            ]);
        }

        Session::flash('notification', ['type' => 'success', 'message' => $this->title.' Post created']);

        return redirect()->route('admin.posts');
    }
}
