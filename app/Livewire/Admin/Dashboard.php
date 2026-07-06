<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Services\PluginManager;
use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;


class Dashboard extends Component
{
    public function render()
    {
        $pluginMessage = null;
        $pluginManager = app(PluginManager::class);
        if ($pluginManager->isEnabled('hello-plugin')) {
            // Dynamically include the plugin class
            $pluginFile = base_path('plugins/HelloPlugin/Plugin.php');
            if (file_exists($pluginFile)) {
                require_once $pluginFile;
                $pluginClass = 'Plugins\\HelloPlugin\\Plugin';
                if (class_exists($pluginClass)) {
                    $plugin = new $pluginClass();
                    $pluginMessage = $plugin->boot();
                }
            }
        }
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalPages = Page::count();
        $totalPlugins = collect($pluginManager->all())->where('enabled', true)->count();
        $totalContacts = Contact::count();
        $recentPosts = Post::orderBy('created_at', 'desc')->take(3)->get();
        $recentPages = Page::orderBy('created_at', 'desc')->take(3)->get();
        $recentActivity = $recentPosts->concat($recentPages)->sortByDesc('created_at')->take(5);
        $postsThisMonth = Post::where('created_at', '>=', now()->startOfMonth())->count();
        $pagesThisMonth = Page::where('created_at', '>=', now()->startOfMonth())->count();
        $usersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();
        $totalCategories = Category::count();
        $recentLogins = DB::table('login_logs')
            ->join('users', 'login_logs.user_id', '=', 'users.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.name', 'roles.name as role', 'login_logs.created_at', 'login_logs.ip_address')
            ->orderByDesc('login_logs.created_at')
            ->limit(5)
            ->get();
        return view('livewire.admin.dashboard.index', [
            'totalUsers' => $totalUsers,
            'totalPosts' => $totalPosts,
            'totalPages' => $totalPages,
            'totalContacts' => $totalContacts,
            'recentActivity' => $recentActivity,
            'recentLogins' => $recentLogins,
            'postsThisMonth' => $postsThisMonth,
            'pagesThisMonth' => $pagesThisMonth,
            'usersThisMonth' => $usersThisMonth,
            'totalCategories' => $totalCategories,
            'pluginMessage' => $pluginMessage
        ])->layout('layouts.admin');
    }
}
