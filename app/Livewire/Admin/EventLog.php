<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use App\Helpers\LoggingHelper;

class EventLog extends Component
{
    public $logs = [];
    public $maxLines = 100;
    public $loggingEnabled = true;

    public function mount()
    {
        // Get logging status from cache or default to false
        $this->loggingEnabled = Cache::get('cms_logging_enabled', false);
        $this->logs = $this->readLog();
    }

    public function toggleLogging()
    {
        $this->loggingEnabled = !$this->loggingEnabled;
        
        // Store in cache for immediate effect
        Cache::put('cms_logging_enabled', $this->loggingEnabled, now()->addDays(30));
        
        // Also try to store in database if available
        try {
            \DB::table('settings')->updateOrInsert(
                ['id' => 1], // Assuming single settings record
                ['logging_enabled' => $this->loggingEnabled]
            );
        } catch (\Exception $e) {
            // If database is not available, just use cache
            // Note: We can't use LoggingHelper here as it would be disabled
            \Log::channel('cms')->info('Could not update logging setting in database, using cache only');
        }

        $status = $this->loggingEnabled ? 'enabled' : 'disabled';
        // Use direct logging here since we're toggling the system
        \Log::channel('cms')->info("CMS logging {$status} by admin");
    }

    public function readLog()
    {
        $logPath = storage_path('logs/cms.log');
        if (!file_exists($logPath)) {
            return [];
        }
        $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lines = array_slice($lines, -$this->maxLines);
        $parsed = [];
        foreach ($lines as $line) {
            // Try to parse full Laravel log format: [YYYY-MM-DD HH:MM:SS] local.level: message {context}
            if (preg_match('/^\[(.*?)\] (\w+)\.(\w+): (.*)$/', $line, $matches)) {
                $parsed[] = [
                    'timestamp' => $matches[1],
                    'env' => $matches[2],
                    'level' => $matches[3],
                    'message' => $matches[4],
                ];
            }
            // Try to parse format: [YYYY-MM-DD HH:MM:SS] level: message
            elseif (preg_match('/^\[(.*?)\] (\w+): (.*)$/', $line, $matches)) {
                $parsed[] = [
                    'timestamp' => $matches[1],
                    'env' => '',
                    'level' => $matches[2],
                    'message' => $matches[3],
                ];
            }
            // Try to parse format: [YYYY-MM-DD HH:MM:SS] message
            elseif (preg_match('/^\[(.*?)\] (.*)$/', $line, $matches)) {
                $parsed[] = [
                    'timestamp' => $matches[1],
                    'env' => '',
                    'level' => '',
                    'message' => $matches[2],
                ];
            }
            // Fallback: just show the line as message
            else {
                $parsed[] = [
                    'timestamp' => '',
                    'env' => '',
                    'level' => '',
                    'message' => $line,
                ];
            }
        }
        return array_reverse($parsed); // Most recent first
    }

    public function render()
    {
        return view('livewire.admin.event-log', [
            'logs' => $this->logs
        ])->layout('layouts.admin');
    }
} 