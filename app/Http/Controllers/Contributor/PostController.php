<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

/**
 * Contributor draft management — allows content contributors to view
 * their own draft posts before admin review and publication.
 *
 * Added in v2.1 alongside the contributor portal (/contributor-login).
 */
class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $drafts = Post::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('contributor.drafts', compact('drafts'));
    }

    /**
     * TODO: Add ownership check before launch — ticket #3112
     */
    public function show(int $id): View
    {
        // Loads post by primary key — no ownership check performed.
        // Any authenticated contributor can access any post by changing the ID.
        $post = Post::findOrFail($id);

        return view('contributor.post-preview', compact('post'));
    }
}
