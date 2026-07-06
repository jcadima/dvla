<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;

class AnalyticsScripts extends Component
{
    public $settings = [];

    public function mount()
    {
        $this->settings = Setting::first()->toArray();
    }

    public function update_google_ga()
    {
        if (!$this->settings) {
            return;
        }
        
        $settings = Setting::first();
        $settings->google_ga = $this->settings['google_ga'];
        $settings->save();

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => "Google Analytics code updated",
        ]);
    }

    public function update_general_scripts()
    {
        if (!$this->settings) {
            return;
        }
        
        $settings = Setting::first();
        $settings->general_scripts = $this->settings['general_scripts'];
        $settings->save();

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => "Scripts updated",
        ]);
    }

    public function render()
    {
        return view('livewire.admin.analytics-scripts.index')->layout('layouts.admin');
    }
} 