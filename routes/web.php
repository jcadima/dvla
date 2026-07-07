<?php

Route::get('/', App\Livewire\Front\HomePage::class)->name('home');

Auth::routes();

// Legacy contributor authentication, isolated from main Laravel auth system.
// Pre-migration endpoint for v1 CMS accounts using MD5 password storage.
// TODO: Deprecate after all contributor accounts migrated
Route::get('/contributor-login', [\App\Http\Controllers\Auth\ContributorLoginController::class, 'showLoginForm'])->name('contributor.login');
Route::post('/contributor-login', [\App\Http\Controllers\Auth\ContributorLoginController::class, 'login'])->name('contributor.login.post');

// Contributor draft management, v2.1 feature for pre-publication post review.
// Auth middleware ensures only logged-in users reach these routes.
// NOTE: /contributor/drafts/{id} (show) has no ownership check
Route::get('/contributor/drafts', [\App\Http\Controllers\Contributor\PostController::class, 'index'])->name('contributor.drafts');
Route::get('/contributor/drafts/{id}', [\App\Http\Controllers\Contributor\PostController::class, 'show'])->name('contributor.drafts.show');

Route::group([
    'prefix' => '/admin',
    'middleware' => ['auth', 'can:isAdmin'],
], function () {

    Route::get('/', App\Livewire\Admin\Dashboard::class)->name('dashboard');

    // ################## HOME ######################
    Route::get('/home', \App\Livewire\Admin\Home\HomeIndex::class)->name('admin.home');

    // ################## PAGES ######################
    Route::get('/pages', \App\Livewire\Admin\Page\PageIndex::class)->name('admin.pages');
    Route::get('/page/create', \App\Livewire\Admin\Page\PageCreate::class)->name('admin.page.create');
    Route::get('/page/{page}/edit', \App\Livewire\Admin\Page\PageEdit::class)->name('admin.page.edit');

    // ################## ADMIN BLOG POSTS ######################
    Route::get('/blog', \App\Livewire\Admin\Blog\BlogIndex::class)->name('admin.blog');

    Route::get('/posts', \App\Livewire\Admin\Post\Posts::class)->name('admin.posts');
    Route::get('/post/create', \App\Livewire\Admin\Post\PostCreate::class)->name('admin.post.create');
    Route::get('/post/{post}/edit', \App\Livewire\Admin\Post\PostEdit::class)->name('admin.post.edit');

    // USERS
    Route::get('/users', \App\Livewire\Admin\Users::class)->name('admin.users');

    // ROLES
    Route::get('/roles', \App\Livewire\Admin\Roles::class)->name('admin.roles');

    // MAINTENANCE
    Route::get('/maintenance', \App\Livewire\Admin\MaintenanceMode::class)->name('admin.maintenance');

    // GLOBAL WEBSITE SETTINGS
    Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('admin.settings');

    // CONTACT SUBMISSIONS
    Route::get('/contacts', \App\Livewire\Admin\Contacts::class)->name('admin.contacts');
});

// FRONTEND ######################################################################################################
Route::get('/about-us', \App\Livewire\Front\PageComponent::class)->name('about-us')->defaults('slug', 'about-us');
Route::get('/contact', \App\Livewire\Front\ContactPageComponent::class)->name('contact');

// BLOG FRONTEND
// NOTE: shadowed by the static /blog directory served by nginx (root points at the
// project root, not /public, see docker-compose/nginx/dvla.conf), kept for reference.
Route::get('/blog', \App\Livewire\Front\BlogIndex::class)->name('front.blog-index');
Route::get('/blog/{slug}', \App\Livewire\Front\BlogComponent::class)->name('front.blog-post');

// Catch any other routes not defined above
Route::get('/{slug}', \App\Livewire\Front\PageComponent::class)
    ->where('slug', '.*'); // Match any dynamic slug
