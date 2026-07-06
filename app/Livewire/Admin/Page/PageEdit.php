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

class PageEdit extends Component
{
    use ManagesPageContent;
    use WithFileUploads;

    public $page_file;

    public $page_filesize;

    public $newFileUpload;

    public $pageInstance;

    public $title;

    public $slug;

    public $meta_description;

    public $page_content;

    public $container_type = 'container';

    public $status = 'draft';

    public $maxCharacters = 155;

    public function mount(Page $page)
    {
        $pageData = Page::with('file')->where('id', $page->id)->get();
        $this->pageInstance = $page;

        $this->title = $pageData[0]->title;
        $this->slug = $pageData[0]->slug;
        $this->meta_description = $pageData[0]->meta_description;
        $this->page_content = $pageData[0]->page_content;
        $this->container_type = $pageData[0]->container_type ?? 'container';
        $this->status = $pageData[0]->status ?? 'draft';
        $this->page_file = optional($pageData[0]->file->first())->filename;
        $this->page_filesize = optional($pageData[0]->file->first())->filesize;
    }

    public function render()
    {
        $remainingCharacters = max(0, $this->maxCharacters - strlen($this->meta_description));
        $exceeded = strlen($this->meta_description) > $this->maxCharacters;

        return view('livewire.admin.pages.edit', [
            'remainingCharacters' => $remainingCharacters,
            'exceeded' => $exceeded,
        ])->layout('layouts.admin');
    }

    public function updatePage()
    {
        $this->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,slug,'.$this->pageInstance->id,
            'meta_description' => 'sometimes',
            'page_content' => 'sometimes',
            'status' => 'required|in:draft,published',
        ]);

        $this->pageInstance->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'meta_description' => $this->meta_description,
            'page_content' => $this->page_content,
            'container_type' => $this->container_type,
            'status' => $this->status,
        ]);

        if (isset($this->newFileUpload)) {
            $filename = time().'_'.$this->newFileUpload->getClientOriginalName();
            $fileContents = File::get($this->newFileUpload->getRealPath());
            Storage::disk('pages')->put($filename, $fileContents);

            $fileSizeInBytes = $this->newFileUpload->getSize();
            $fileSizeInKB = round($fileSizeInBytes / 1024, 2);

            // Use updateOrCreate to handle both update and create
            PageFile::updateOrCreate(
                ['page_id' => $this->pageInstance->id],
                [
                    'filename' => $filename,
                    'filesize' => $fileSizeInKB,
                ]
            );
        }

        Session::flash('notification', ['type' => 'success', 'message' => $this->title.' Page updated']);

        redirect()->route('admin.pages');
    }
}
