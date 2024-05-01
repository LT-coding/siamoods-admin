<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriberEmail extends Mailable
{
    use Queueable, SerializesModels;

    private string $email;
    private string $unsubscribeUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(string $email, string $unsubscribeUrl)
    {
        $this->email = $email;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->markdown('emails.site.subscribe')
            ->subject(config('app.name') . ' Welcome to Our Newsletter!')
            ->with([
                'email' => $this->email,
                'unsubscribeUrl' => $this->unsubscribeUrl
            ]);
    }
}
