<?php

namespace Plugins\GoogleAnalyticsPlugin;

class Plugin
{
    protected $settingsFile = 'plugin_google_analytics.json';

    public function boot()
    {
        $path = storage_path('app/' . $this->settingsFile);
        if (file_exists($path)) {
            $settings = json_decode(file_get_contents($path), true);
            if (!empty($settings['tracking_code'])) {
                return $settings['tracking_code'];
            }
        }
        return null;
    }
} 