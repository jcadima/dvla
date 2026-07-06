<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;

class AdminLogoComponent extends Component
{
    public $admin_logo;
    public $settings;

    protected $listeners = ['logoUpdated' => 'updateLogo'];

    public function mount()
    {
        $this->admin_logo = Setting::first()->admin_logo;
    }

    public function updateLogo($newLogo)
    {
        $this->admin_logo = $newLogo;
    }

    public function render()
    {
        return view('livewire.admin.admin-logo');
    }
}
