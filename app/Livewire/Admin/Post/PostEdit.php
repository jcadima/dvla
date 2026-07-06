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

class PostEdit extends Component
{
    use ManagesPageContent;

    public $post_file;

    public $post_filesize;

    public $newFileUpload;

    public $selectedCategories = [];

    public $postInstance;

    public $title;

    public $slug;

    public $meta_description;

    public $post_content;

    public $maxCharacters = 155;

    public $container_type = 'container';

    public $status = 'draft';

    public function mount(Post $post)
    {
        $postData = Post::with(['categories', 'file'])->where('id', $post->id)->first();
        $this->postInstance = $post;

        $this->title = $postData->title;
        $this->slug = $postData->slug;
        $this->meta_description = $postData->meta_description;
        $this->post_content = $postData->post_content;
        $this->container_type = $postData->container_type ?? 'container';
        $this->status = $postData->status ?? 'draft';
        $this->post_file = optional($postData->file->first())->filename;
        $this->post_filesize = optional($postData->file->first())->filesize;

        // Load selected categories for many-to-many relationship
        $this->selectedCategories = $postData->categories->pluck('id')->toArray();
    }

    public function render()
    {
        $categories = Category::all();
        $remainingCharacters = max(0, $this->maxCharacters - strlen($this->meta_description ?? ''));
        $exceeded = strlen($this->meta_description ?? '') > $this->maxCharacters;

        return view('livewire.admin.posts.edit', [
            'categories' => $categories,
            'remainingCharacters' => $remainingCharacters,
            'exceeded' => $exceeded,
        ])->layout('layouts.admin');
    }

    public function updatePost()
    {
        $this->validate([
            'title' => 'required',
            'slug' => 'required',
            'meta_description' => 'sometimes',
            'post_content' => 'sometimes',
            'status' => 'required|in:draft,published',
            'selectedCategories' => 'sometimes|array',
            'container_type' => 'required|in:container,narrow',
        ]);

        $this->postInstance->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'meta_description' => $this->meta_description,
            'post_content' => $this->post_content,
            'container_type' => $this->container_type,
            'status' => $this->status,
        ]);

        // Sync categories for many-to-many relationship
        $this->postInstance->categories()->sync($this->selectedCategories);

        if (isset($this->newFileUpload)) {
            $filename = time().'_'.$this->newFileUpload->getClientOriginalName();
            $fileContents = File::get($this->newFileUpload->getRealPath());
            Storage::disk('posts')->put($filename, $fileContents);

            $fileSizeInBytes = $this->newFileUpload->getSize();
            $fileSizeInKB = round($fileSizeInBytes / 1024, 2);

            // Use updateOrCreate to handle both update and create
            PostFile::updateOrCreate(
                ['post_id' => $this->postInstance->id],
                [
                    'filename' => $filename,
                    'filesize' => $fileSizeInKB,
                ]
            );
        }

        Session::flash('notification', ['type' => 'success', 'message' => $this->title.' Post updated']);

        redirect()->route('admin.posts');
    }
}
