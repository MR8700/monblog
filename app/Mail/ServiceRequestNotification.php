<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServiceRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $serviceRequest;
    public $type; // 'admin' or 'client'

    /**
     * Create a new message instance.
     */
    public function __construct(ServiceRequest $serviceRequest, $type = 'admin')
    {
        $this->serviceRequest = $serviceRequest;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->type === 'admin' 
            ? "Nouvelle demande de service : " . $this->serviceRequest->service_type
            : "Confirmation de votre demande de service - DigitalSpace";

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.service-request-notification',
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
