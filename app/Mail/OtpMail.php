<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Otp Request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: ["otp"=>$this->code]
        );
    }

    /**
     * @return array<string,string>
     */
    public function attachments(): array
    {
        return [];
    }
}
