<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class PluginManager
{
    // Path to the plugins directory
    protected $pluginPath = 'plugins';
    // File where enabled plugin slugs are stored
    protected $enabledFile = 'plugins_enabled.json';

    /**
     * Get all plugins (with manifest info and enabled status)
     */
    public function all()
    {
        $plugins = [];
        $pluginDirs = File::directories(base_path($this->pluginPath));
        foreach ($pluginDirs as $dir) {
            $manifestPath = $dir . '/manifest.json';
            if (File::exists($manifestPath)) {
                $manifest = json_decode(File::get($manifestPath), true);
                $manifest['enabled'] = $this->isEnabled($manifest['slug']);
                $plugins[] = $manifest;
            }
        }
        return $plugins;
    }

    /**
     * Check if a plugin is enabled by slug
     */
    public function isEnabled($slug)
    {
        $enabled = $this->getEnabled();
        return in_array($slug, $enabled);
    }

    /**
     * Enable a plugin by slug
     */
    public function enable($slug)
    {
        $enabled = $this->getEnabled();
        if (!in_array($slug, $enabled)) {
            $enabled[] = $slug;
            $this->saveEnabled($enabled);
        }
    }

    /**
     * Disable a plugin by slug
     */
    public function disable($slug)
    {
        $enabled = $this->getEnabled();
        $enabled = array_filter($enabled, fn($s) => $s !== $slug);
        $this->saveEnabled($enabled);
    }

    /**
     * Get the list of enabled plugin slugs
     */
    protected function getEnabled()
    {
        $path = storage_path('app/' . $this->enabledFile);
        if (!File::exists($path)) {
            return [];
        }
        return json_decode(File::get($path), true) ?: [];
    }

    /**
     * Save the list of enabled plugin slugs
     */
    protected function saveEnabled($enabled)
    {
        $path = storage_path('app/' . $this->enabledFile);
        File::put($path, json_encode(array_values($enabled)));
    }

    /**
     * Boot all enabled plugins by dynamically loading their Plugin.php and calling boot().
     *
     * This method is called at the top of routes/web.php to allow plugins to register routes or perform other boot-time logic.
     *
     * For each enabled plugin:
     *   - Build the path to its Plugin.php file
     *   - Require the file (so the class is available)
     *   - Build the fully qualified class name (e.g., Plugins\HelloPlugin\Plugin)
     *   - Instantiate the class and call its boot() method if it exists
     *
     * This allows plugins to register routes, event listeners, or perform other setup when the app boots.
     */
    public function bootEnabledPlugins()
    {
        $plugins = $this->all();
        foreach ($plugins as $plugin) {
            if ($plugin['enabled']) {
                // Build the path to the plugin's Plugin.php file
                $pluginFile = base_path('plugins/' . ucfirst(str_replace('-', '', $plugin['slug'])) . '/Plugin.php');
                if (file_exists($pluginFile)) {
                    require_once $pluginFile;
                    // Build the fully qualified class name, e.g., Plugins\HelloPlugin\Plugin
                    $pluginClass = 'Plugins\\' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $plugin['slug']))) . '\\Plugin';
                    if (class_exists($pluginClass)) {
                        $instance = new $pluginClass();
                        // Call the boot() method if it exists
                        if (method_exists($instance, 'boot')) {
                            $instance->boot();
                        }
                    }
                }
            }
        }
    }
} 