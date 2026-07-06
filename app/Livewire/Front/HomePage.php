<?php

namespace App\Livewire\Front;

use App\Models\Home;
use App\Models\Setting;
use App\Models\Social;
use Livewire\Component;

class HomePage extends Component
{
    public $socialMediaLinks;

    public $title;

    public $meta_description;

    public $page_content;

    public function render()
    {
        $homepageData = Home::firstOrFail();
        $this->title = $homepageData->title;
        $this->meta_description = $homepageData->meta_description;
        $this->page_content = $homepageData->page_content;

        return view('livewire.front.homepage', [
        ])->layout('layouts.frontend.home', [
            'settings' => Setting::first(),
            'socialMediaLinks' => Social::all(),
        ]);
    }
}
