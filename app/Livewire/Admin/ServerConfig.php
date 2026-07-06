<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ServerConfig extends Component
{
    public $info = [];

    public function mount()
    {
        $this->info = [
            'php_version' => phpversion(),
            'laravel_version' => App::version(),
            'os' => php_uname(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? php_sapi_name(),
            'base_path' => base_path(),
            'storage_path' => storage_path(),
            'logs_path' => storage_path('logs'),
            'env_path' => base_path('.env'),
            'config_path' => config_path(),
            'public_path' => public_path(),
            'disk_free' => disk_free_space(base_path()),
            'disk_total' => disk_total_space(base_path()),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'php_extensions' => get_loaded_extensions(),
            'env_vars' => $this->getMaskedEnvVars(),
        ];
    }

    protected function getMaskedEnvVars()
    {
        $env = $_ENV;
        $sensitive = ['APP_KEY', 'DB_PASSWORD', 'DB_USERNAME', 'MAIL_PASSWORD', 'MAIL_USERNAME', 'REDIS_PASSWORD', 'SESSION_DRIVER', 'CACHE_DRIVER'];
        foreach ($env as $key => &$value) {
            if (in_array($key, $sensitive)) {
                $value = '********';
            }
        }
        return $env;
    }

    public function render()
    {
        return view('livewire.admin.server-config', [
            'info' => $this->info
        ])->layout('layouts.admin');
    }
} 