<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use App\Models\Social;

class Settings extends Component
{
    use WithFileUploads;

    public $settings = [];
    public $admin_logo;
    public $logo;
    public $mobile_logo;
    public $footer_logo;
    public $socialMediaLinks = [];
    public $link;
    public $facode;

    public function mount()
    {
        $setting = Setting::first();
        if ($setting) {
            $this->settings = $setting->toArray();
        } else {
            $this->settings = [
                'admin_logo' => null,
                'logo' => null,
                'mobile_logo' => null,
                'footer_logo' => null,
                'google_ga' => null,
                'general_scripts' => null,
                'copyright' => null,
                'recipient' => null,
            ];
        }
        $this->socialMediaLinks = Social::all()->toArray();
    }

    public function update_google_ga()
    {
        $setting = Setting::firstOrCreate([]);
        $setting->google_ga = $this->settings['google_ga'];
        $setting->save();
        $this->dispatch('notification', ['type' => 'success', 'message' => 'Google Analytics updated']);
    }

    public function update_general_scripts()
    {
        $setting = Setting::firstOrCreate([]);
        $setting->general_scripts = $this->settings['general_scripts'];
        $setting->save();
        $this->dispatch('notification', ['type' => 'success', 'message' => 'General scripts updated']);
    }

    public function update_copyright()
    {
        $setting = Setting::firstOrCreate([]);
        $setting->copyright = $this->settings['copyright'];
        $setting->save();
        $this->dispatch('notification', ['type' => 'success', 'message' => 'Copyright updated']);
    }

    public function update_recipient()
    {
        $setting = Setting::firstOrCreate([]);
        $setting->recipient = $this->settings['recipient'];
        $setting->save();
        $this->dispatch('notification', ['type' => 'success', 'message' => 'Recipient updated']);
    }

    public function store_new_logo($type)
    {
        $file = $this->$type;
        if ($file && !is_string($file)) {
            $filename = $type . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $filename);

            $setting = Setting::firstOrCreate([]);
            $setting->$type = $filename;
            $setting->save();

            $this->settings[$type] = $filename;
            $this->$type = $filename;
            $this->dispatch('notification', ['type' => 'success', 'message' => 'Logo updated successfully']);
        }
    }

    public function store_media()
    {
        $this->validate([
            'link' => 'required',
            'facode' => 'required',
        ]);

        Social::create([
            'link' => $this->link,
            'facode' => $this->facode,
        ]);

        $this->link = '';
        $this->facode = '';
        $this->socialMediaLinks = Social::all()->toArray();
        $this->dispatch('notification', ['type' => 'success', 'message' => 'Social media link added']);
    }

    public function updateSocialMediaItem($id)
    {
        $index = array_search($id, array_column($this->socialMediaLinks, 'id'));
        if ($index !== false) {
            $social = Social::find($id);
            if ($social) {
                $social->link = $this->socialMediaLinks[$index]['link'];
                $social->facode = $this->socialMediaLinks[$index]['facode'];
                $social->save();
                $this->dispatch('notification', ['type' => 'success', 'message' => 'Social media link updated']);
            }
        }
    }

    public function removeSocialMediaItem($id)
    {
        Social::destroy($id);
        $this->socialMediaLinks = Social::all()->toArray();
        $this->dispatch('notification', ['type' => 'success', 'message' => 'Social media link removed']);
    }

    public function render()
    {
        return view('livewire.admin.settings.index')->layout('layouts.admin');
}
}
