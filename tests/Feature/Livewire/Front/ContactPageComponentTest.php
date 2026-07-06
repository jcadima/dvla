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
    ]);

    Setting::create(['recipient' => 'email@artisanbreach.com']);
});

it('renders the contact page at /contact', function () {
    $this->get('/contact')->assertStatus(200)->assertSee('Contact Us');
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
