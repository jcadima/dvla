<?php

namespace App\Livewire\Front;

use App\Models\Page;
use App\Models\Setting;
use App\Models\Social;
use Livewire\Component;

class AboutPageComponent extends Component
{
    public $title;

    public $meta_description;

    public $page_content;

    public $page_file;

    public function mount()
    {
        $page = Page::with('file')->where('slug', 'about-us')->first();

        $this->title = $page->title;
        $this->meta_description = $page->meta_description;
        $this->page_content = $page->page_content;
        $this->page_file = optional($page->file->first())->filename;
    }

    public function render()
    {
        $settings = Setting::first();

        return view('livewire.front.about-us', [])->layout('layouts.frontend.pages', [
            'settings' => $settings,
            'socialMediaLinks' => Social::all(),
        ]);
    }
}
