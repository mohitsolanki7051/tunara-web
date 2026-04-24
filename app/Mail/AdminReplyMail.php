<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $userName,
        public string $replyMessage,
        public string $originalSubject
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Re: ' . $this->originalSubject . ' — Tunara Support');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.admin-reply');
    }
}
