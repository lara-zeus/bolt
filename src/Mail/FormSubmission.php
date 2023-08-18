<?php

namespace LaraZeus\Bolt\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormSubmission extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $form;

    public $response;

    /**
     * Create a new message instance.
     */
    public function __construct($form, $response)
    {
        $this->form = $form;
        $this->response = $response;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Form Submission',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'zeus::emails.form-submission',
            with: [
                'url' => url(config('filament.path') . '/responses/' . $this->response->id),
            ],
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
