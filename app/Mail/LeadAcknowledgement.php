<?php

namespace App\Mail;

use App\Models\Lead;
use App\Support\SiteContent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadAcknowledgement extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{subject: string, greeting: string, body: string, closing: string}  $copy
     */
    public function __construct(public Lead $lead, public array $copy) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: SiteContent::replaceTokens($this->copy['subject'], $this->lead),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.lead-acknowledgement',
            with: [
                'greeting' => SiteContent::replaceTokens($this->copy['greeting'], $this->lead),
                'body' => SiteContent::replaceTokens($this->copy['body'], $this->lead),
                'closing' => SiteContent::replaceTokens($this->copy['closing'], $this->lead),
                'lead' => $this->lead,
            ],
        );
    }
}
