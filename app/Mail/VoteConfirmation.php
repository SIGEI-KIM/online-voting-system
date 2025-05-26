<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoteConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $electionTitle;
    public $votedFor;

    /**
     * Create a new message instance.
     */
    public function __construct(string $electionTitle, string $votedFor)
    {
        $this->electionTitle = $electionTitle;
        $this->votedFor = $votedFor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vote Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.vote_confirmation',
            with: [
                'election' => $this->electionTitle,
                'candidate' => $this->votedFor,
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