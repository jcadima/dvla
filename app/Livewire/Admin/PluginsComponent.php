<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\PluginManager;

class PluginsComponent extends Component
{
    public $plugins = [];
    public $ga_tracking_code = '';

    public function mount(PluginManager $manager)
    {
        $this->plugins = $manager->all();
        $this->loadGATrackingCode();
    }

    public function loadGATrackingCode()
    {
        $path = storage_path('app/plugin_google_analytics.json');
        if (file_exists($path)) {
            $settings = json_decode(file_get_contents($path), true);
            $this->ga_tracking_code = $settings['tracking_code'] ?? '';
        }
    }

    public function saveGATrackingCode()
    {
        $data = ['tracking_code' => $this->ga_tracking_code];
        file_put_contents(storage_path('app/plugin_google_analytics.json'), json_encode($data));
        session()->flash('message', 'Google Analytics tracking code updated!');
    }

    public function enable($slug)
    {
        app(PluginManager::class)->enable($slug);
        $this->plugins = app(PluginManager::class)->all();
        session()->flash('message', 'Plugin enabled!');
    }

    public function disable($slug)
    {
        app(PluginManager::class)->disable($slug);
        $this->plugins = app(PluginManager::class)->all();
        session()->flash('message', 'Plugin disabled!');
    }

    public function render()
    {

        return view('livewire.admin.plugins-component', [])->layout('layouts.admin', []);
    }
}
