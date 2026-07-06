<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;
use Livewire\WithFileUploads;
use App\Traits\WithStoreFiles;
use Illuminate\Support\Facades\Log;

class BrandingLogos extends Component
{
    use WithFileUploads;
    use WithStoreFiles;

    public $admin_logo;
    public $logo;
    public $mobile_logo;
    public $footer_logo;
    public $settings = [];

    public function mount()
    {
        $this->settings = Setting::first()->toArray();
    }

    private function processLogo($setting_object, $field)
    {
        Log::channel('cms')->info("Processing logo update for field: {$field}");
        //                  FILE,       OBJECT,     DISK_LOCATION, UPDATE_FIELD
        $this->storeToDisk($this->$field, $setting_object, 'images', $field);

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => "Logo Updated",
        ]);
    }

    public function store_new_logo($field)
    {
        $setting_object = Setting::first();
        $this->processLogo($setting_object, $field);

        // Update the settings array with the new logo URL
        $this->settings[$field] = $setting_object->$field;

        // pass the updated URL to the event
        $newLogoUrl = $setting_object->$field;
        $this->dispatch('logoUpdated', $newLogoUrl);
    }

    public function render()
    {
        return view('livewire.admin.branding-logos.index')->layout('layouts.admin');
    }
} 