<?php

namespace App\Mail;

use App\Models\CareerApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CareerApplicationReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public CareerApplication $application;

    /**
     * Create a new message instance.
     */
    public function __construct(CareerApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Career Application Received - AlMaghrib International School',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.career-application-received',
            with: [
                'application' => $this->application,
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
