<?php

use App\Models\Page;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;

beforeEach(function () {
    Setting::create(['recipient' => 'email@artisanbreach.com']);
});

it('shows a published page to guests', function () {
    Page::create([
        'title' => 'Published Page',
        'slug' => 'published-page',
        'meta_description' => 'Meta description',
        'page_content' => 'Some content',
        'status' => 'published',
    ]);

    $this->get('/published-page')->assertStatus(200)->assertSee('Published Page');
});

it('returns 404 for a draft page to guests', function () {
    Page::create([
        'title' => 'Draft Page',
        'slug' => 'draft-page',
        'meta_description' => 'Meta description',
        'page_content' => 'Some content',
        'status' => 'draft',
    ]);

    $this->get('/draft-page')->assertStatus(404);
});

it('returns 404 for a nonexistent page', function () {
    $this->get('/does-not-exist')->assertStatus(404);
});

it('shows a draft page to a logged-in admin', function () {
    $adminRole = Role::create(['name' => 'Administrator']);
    $admin = User::factory()->create(['role_id' => $adminRole->id]);

    Page::create([
        'title' => 'Draft Page',
        'slug' => 'draft-page',
        'meta_description' => 'Meta description',
        'page_content' => 'Some content',
        'status' => 'draft',
    ]);

    $this->actingAs($admin)->get('/draft-page')->assertStatus(200)->assertSee('Draft Page');
});

it('routes /about-us through PageComponent and honours its draft status', function () {
    Page::create([
        'title' => 'About Us',
        'slug' => 'about-us',
        'meta_description' => 'Meta description',
        'page_content' => 'Some content',
        'status' => 'draft',
    ]);

    $this->get('/about-us')->assertStatus(404);

    $adminRole = Role::create(['name' => 'Administrator']);
    $admin = User::factory()->create(['role_id' => $adminRole->id]);
    $this->actingAs($admin)->get('/about-us')->assertStatus(200)->assertSee('About Us');
});

it('shows the published about-us page to guests', function () {
    Page::create([
        'title' => 'About Us',
        'slug' => 'about-us',
        'meta_description' => 'Meta description',
        'page_content' => 'Some content',
        'status' => 'published',
    ]);

    $this->get('/about-us')->assertStatus(200)->assertSee('About Us');
});
