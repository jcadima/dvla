<?php

namespace App\Livewire\Admin\Page;

use App\Models\Page;
use App\Models\PageFile;
use App\Traits\ManagesPageContent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PageCreate extends Component
{
    use ManagesPageContent, WithFileUploads;

    public $maxCharacters = 155;

    public $page_file;

    public $page_id;

    public $title;

    public $slug;

    public $meta_description;

    public $page_content;

    public $container_type = 'container';

    public $status = 'draft';

    protected $rules = [
        'title' => 'required',
        'slug' => 'required|unique:pages,slug',
        'meta_description' => 'sometimes',
        'page_content' => 'sometimes',
        'page_file' => 'nullable|mimes:jpg,jpeg,png|max:5024',
        'status' => 'required|in:draft,published',
    ];

    public function render()
    {
        $descriptionLength = strlen($this->meta_description ?? '');

        return view('livewire.admin.pages.create', [
            'remainingCharacters' => max(0, $this->maxCharacters - $descriptionLength),
            'exceeded' => $descriptionLength > $this->maxCharacters,
        ])->layout('layouts.admin');
    }

    public function store()
    {
        $this->validate();

        $page = $this->createPage();

        if ($this->page_file) {
            $this->attachFile($page);
        }

        Session::flash('notification', [
            'type' => 'success',
            'message' => $this->title.' Page created',
        ]);

        return redirect()->route('admin.pages');
    }

    private function createPage(): Page
    {
        return Page::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'meta_description' => $this->meta_description,
            'page_content' => $this->page_content,
            'container_type' => $this->container_type,
            'status' => $this->status,
        ]);
    }

    private function attachFile(Page $page): void
    {
        $filename = time().'_'.$this->page_file->getClientOriginalName();

        Storage::disk('pages')->put(
            $filename,
            File::get($this->page_file->getRealPath())
        );

        PageFile::create([
            'page_id' => $page->id,
            'filename' => $filename,
            'filesize' => $this->getFileSizeInKB(),
        ]);
    }

    private function getFileSizeInKB(): float
    {
        return round($this->page_file->getSize() / 1024, 2);
    }
}
