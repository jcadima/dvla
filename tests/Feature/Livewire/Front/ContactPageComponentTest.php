<?php

use App\Jobs\NotifyNewContact;
use App\Livewire\Front\ContactPageComponent;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\Bus;
use Livewire\Livewire;

beforeEach(function () {
    $this->page = Page::create([
        'title' => 'Contact Us',
        'slug' => 'contact',
        'meta_description' => 'Meta Description for Contact us page',
        'page_content' => '',
        'status' => 'published',
    ]);

    Setting::create(['recipient' => 'email@artisanbreach.com']);
});

it('renders the contact page at /contact', function () {
    $this->get('/contact')->assertStatus(200)->assertSee('Contact Us');
});

it('returns 404 for the contact page to guests when it is a draft', function () {
    $this->page->update(['status' => 'draft']);

    $this->get('/contact')->assertStatus(404);
});

it('shows the draft contact page to a logged-in admin', function () {
    $this->page->update(['status' => 'draft']);

    $adminRole = \App\Models\Role::create(['name' => 'Administrator']);
    $admin = \App\Models\User::factory()->create(['role_id' => $adminRole->id]);

    $this->actingAs($admin)->get('/contact')->assertStatus(200)->assertSee('Contact Us');
});

it('validates required fields before submitting', function () {
    Livewire::test(ContactPageComponent::class)
        ->call('submitContact')
        ->assertHasErrors([
            'formData.name' => 'required',
            'formData.email' => 'required',
            'formData.message' => 'required',
        ]);
});

it('stores the contact submission and dispatches the notification job', function () {
    Bus::fake();

    Livewire::test(ContactPageComponent::class)
        ->set('formData.name', 'Jane Doe')
        ->set('formData.email', 'jane@example.com')
        ->set('formData.phone', '555-1234')
        ->set('formData.message', 'Hello there')
        ->call('submitContact')
        ->assertDispatched('notification');

    $this->assertDatabaseHas('contacts', [
        'page_id' => $this->page->id,
    ]);

    $contact = Contact::first();
    expect($contact->contact_data)->toMatchArray([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '555-1234',
        'message' => 'Hello there',
    ]);

    Bus::assertDispatched(NotifyNewContact::class);
});
