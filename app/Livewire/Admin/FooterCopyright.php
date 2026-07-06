<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;

class FooterCopyright extends Component
{
    public $settings = [];

    public function mount()
    {
        $this->settings = Setting::first()->toArray();
    }

    public function update_recipient()
    {
        $settings = Setting::first();
        $settings->recipient = $this->settings['recipient'];
        $settings->save();

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => "Email Recipient updated",
        ]);
    }

    public function update_copyright()
    {
        if (!$this->settings) {
            return;
        }
        
        $settings = Setting::first();
        $settings->copyright = $this->settings['copyright'];
        $settings->save();

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => "Copyright updated",
        ]);
    }

    public function render()
    {
        return view('livewire.admin.footer-copyright.index')->layout('layouts.admin');
    }
} 