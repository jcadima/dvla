<?php

namespace App\Livewire\Admin\Home;

use App\Models\Home;
use App\Traits\ManagesPageContent;
use Livewire\Component;
use Livewire\WithFileUploads;

class HomeIndex extends Component
{
    use ManagesPageContent;
    use WithFileUploads;

    public $page_file;

    public $newFileUpload = [];

    public $homeData;

    public $title;

    public $meta_description;

    public $page_content;

    public $maxCharacters = 155;

    public function mount()
    {
        $this->homeData = Home::first();

        if ($this->homeData) {
            $this->title = $this->homeData->title ?? '';
            $this->meta_description = $this->homeData->meta_description ?? '';
            $this->page_content = $this->homeData->page_content ?? '';
        } else {
            // If no home record exists, create one with default values
            $this->homeData = Home::create([
                'title' => 'Home',
                'meta_description' => 'DVLA: a deliberately vulnerable Laravel 12 + Livewire 3 application for AppSec training and OSWE exam preparation.',
                'page_content' => '',
            ]);
            $this->title = $this->homeData->title;
            $this->meta_description = $this->homeData->meta_description;
            $this->page_content = $this->homeData->page_content;
        }

        $this->addNewFile();
    }

    public function render()
    {
        // Ensure meta_description is a string
        $metaDescription = is_string($this->meta_description) ? $this->meta_description : '';
        $remainingCharacters = max(0, $this->maxCharacters - strlen($metaDescription));
        $exceeded = strlen($metaDescription) > $this->maxCharacters;

        return view('livewire.admin.home.edit', [
            'remainingCharacters' => $remainingCharacters,
            'exceeded' => $exceeded,
        ])->layout('layouts.admin');
    }

    public function updateHome()
    {
        $this->validate([
            'title' => 'required',
            'meta_description' => 'sometimes',
            'page_content' => 'required',
        ]);

        $this->homeData->update([
            'title' => $this->title,
            'meta_description' => $this->meta_description,
            'page_content' => $this->page_content,
        ]);
        // Dispatch a browser event to trigger Toastr notification
        $this->dispatch('notification', ['type' => 'success', 'message' => 'Homepage saved successfully']);
    }
}
