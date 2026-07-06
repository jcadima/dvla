<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use App\Models\MaintenanceSetting;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use App\Mail\MaintenancePassphraseMail;

class MaintenanceMode extends Component
{
    public $secret;
    public $isMaintenanceMode;

    public function mount()
    {
        $this->secret = $this->getStoredSecret();
        $this->isMaintenanceMode = $this->isMaintenanceMode();
    }

    public function render()
    {
        return view('livewire.admin.maintenance.index', [
            'secret' => $this->secret,
            'isMaintenanceMode' => $this->isMaintenanceMode()
        ])->layout('layouts.admin', []);
    }

    public function enableMaintenanceMode()
    {
        $this->validate([
            'secret' => 'required|string'
        ]);

        $this->saveSecret($this->secret);
        $this->activateMaintenanceMode();

        if (!$this->notifyAdmin()) {
            return;
        }

        session()->flash('message', 'Maintenance mode enabled with secret: ' . $this->secret . '. Passphrase and access URL sent to your email.');
        $this->refreshState();
    }

    public function disableMaintenanceMode()
    {
        Artisan::call('up');
        $this->saveSecret(null);

        $this->dispatch('notification', ['type' => 'success', 'message' => 'Maintenance Mode Disabled']);
        $this->refreshState();
    }

    public function isMaintenanceMode(): bool
    {
        return file_exists(storage_path('framework/down'));
    }

    private function getStoredSecret(): ?string
    {
        $setting = MaintenanceSetting::first();
        return $setting?->secret;
    }

    private function saveSecret(?string $secret): void
    {
        $setting = MaintenanceSetting::first();
        $setting->secret = $secret;
        $setting->save();
    }

    private function activateMaintenanceMode(): void
    {
        Artisan::call('down', [
            '--secret' => $this->secret
        ]);
    }

    private function notifyAdmin(): bool
    {
        $recipient = $this->getAdminEmail();
        $accessUrl = $this->buildAccessUrl();

        try {
            $this->sendMaintenanceEmail($recipient, $accessUrl);
            return true;
        } catch (\Exception $e) {
            session()->flash('message', 'Maintenance mode enabled, but failed to send email: ' . $e->getMessage());
            $this->refreshState();
            return false;
        }
    }

    private function getAdminEmail(): string
    {
        return Setting::first()->recipient;
    }

    private function buildAccessUrl(): string
    {
        return url('/') . '/' . $this->secret;
    }

    private function sendMaintenanceEmail(string $recipient, string $accessUrl): void
    {
        $mail = new MaintenancePassphraseMail($this->secret, $accessUrl);

        if (config('app.env') === 'docker') {
            Mail::to($recipient)->send($mail);
        } else {
            Mail::to($recipient)->queue($mail);
        }
    }

    private function refreshState(): void
    {
        $this->mount();
    }
}
