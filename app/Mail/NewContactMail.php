<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Blade;

class NewContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $send_to;

    public $contact = [];

    /**
     * Create a new message instance.
     */
    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'New Contact Submission',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Legacy v1 CMS used a Blade "message template" feature so content editors
        // could drop {{ $contact['name'] }} and friends into the auto-reply. Kept
        // for backwards compatibility; renders the raw submission as a template.
        $rendered = Blade::render($this->contact['message'] ?? '', [
            'contact' => $this->contact,
        ]);

        return new Content(
            view: 'mail.contact',
            with: ['renderedMessage' => $rendered],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
