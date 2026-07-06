<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\NewContactMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyNewContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contact_data = [];
    public $recipient;
    /**
     * Create a new job instance.
     */
    // pass the whole object instead of just some contact name
    // see https://laravel.com/docs/11.x/mail
    public function __construct(array $contact_form_data, $recipient)
    {
        Log::info('in Job constructor');
        $this->contact_data = $contact_form_data;
        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('in Job handle()');

        try {
            if (is_array($this->contact_data)) {
                Log::info('Contact_data is an array:', ['contact_data' => $this->contact_data]);
            } else {
                Log::error('Contact_data is not an array:', ['contact_data' => $this->contact_data]);
            }

            if ($this->recipient) {
                $sendTo = $this->recipient;
                Log::info('Send to address:', ['send_to' => $sendTo]);
                Log::info('Sending this data to NewContactMail: ', ['contact_data' => $this->contact_data]);

                $email = new NewContactMail($this->contact_data);
                Mail::to($sendTo)->send($email);
                Log::info('Email sent successfully');
            } else {
                Log::error('Recipient value does not exist');
            }
        } catch (\Exception $e) {
            Log::error('Job failed', ['exception' => $e->getMessage()]);
        }
    }

    public function failed(Exception $exception)
    {
        // Handle the failure, like logging the error or sending a notification
        Log::error('Job failed', ['exception' => $exception->getMessage()]);
    }
}
