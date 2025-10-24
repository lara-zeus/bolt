<?php

namespace LaraZeus\Bolt\Mail;

use Filament\Facades\Filament;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\Response;

class FormSubmission extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public Form $form;

    public Response $response;

    /**
     * Create a new message instance.
     */
    public function __construct(Form $form, Response $response)
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
            subject: __('zeus-bolt::response.new_submission_in') . ' ' . $this->form->name,
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
                'url' => url(Filament::getDefaultPanel()->getPath() . '/responses/' . $this->response->id),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
