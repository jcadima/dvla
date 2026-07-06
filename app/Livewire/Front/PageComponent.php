<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Social;
use App\Models\Setting;
use App\Models\Page;

class PageComponent extends Component
{
    public $title;
    public $meta_description;
    public $page_content;
    public $page_file;


    public function mount($slug)
    {
        $page = Page::with('file')->where('slug', $slug)->first();

        $this->title = $page->title;
        $this->meta_description = $page->meta_description;
        $this->page_content = $page->page_content;
        $this->page_file = optional($page->file->first())->filename;
    }


    public function render()
    {
        $settings   = Setting::first();

        return view('livewire.front.page-component', [])->layout('layouts.frontend.pages', [
            'settings'   => $settings,
            'socialMediaLinks' => Social::all(),
        ]);
    }
}
