<?php

namespace App\Livewire\Front;

use App\Jobs\NotifyNewContact;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Social;
use Livewire\Component;

class ContactPageComponent extends Component
{
    // Page data
    public $page_id;

    public $title;

    public $meta_description;

    public $page_content;

    public $page_file;

    public $send_to;

    public $formData = [];

    // Contact Form
    protected $rules = [
        'page_id' => 'required',
        'formData.name' => 'required|string',
        'formData.email' => 'required|email',
        'formData.phone' => 'sometimes|string',
        'formData.message' => 'required|string',
    ];

    public function mount()
    {
        $page = Page::with('file')->where('slug', 'contact')->first();

        $this->page_id = $page->id;
        $this->title = $page->title;
        $this->meta_description = $page->meta_description;
        $this->page_content = $page->page_content;
        $this->page_file = optional($page->file->first())->filename;
    }

    public function render()
    {
        return view('livewire.front.contact', [])->layout('layouts.frontend.pages', [
            'settings' => Setting::first(),
            'socialMediaLinks' => Social::all(),
        ]);
    }

    public function submitContact()
    {
        $this->validate();
        // Add send_to field from Settings and add as a new field
        $send_to = Setting::first()->recipient;

        $contact_form_data = [
            'name' => $this->formData['name'],
            'email' => $this->formData['email'],
            'phone' => $this->formData['phone'],
            'message' => $this->formData['message'],
        ];

        // Submit data to DB
        Contact::create([
            'page_id' => $this->page_id,
            'contact_data' => $contact_form_data,
        ]);

        // Conditional dispatch based on environment
        if (env('APP_ENV') === 'docker') {
            NotifyNewContact::dispatch($contact_form_data, $send_to); // DEV
        } else {
            NotifyNewContact::dispatch($contact_form_data, $send_to)->onQueue('emails'); // PRODUCTION
        }

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Message Sent',
        ]);
    }
}
