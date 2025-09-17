<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Enquiry $enquiry
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->enquiry->email, $this->enquiry->name),
            subject: 'New Enquiry'
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'mail.enquiry-created',
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
