<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GreetingEmail extends Mailable
{
    use Queueable, SerializesModels;

    private User $user;
    private string $password;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->markdown('emails.users.greeting')
            ->subject('Բարի գալուստ ' . config('app.name'))
            ->with([
                'name' => $this->user->display_name,
                'email' => $this->user->email,
                'password' => $this->password,
                'url' => url('/')
            ]);
    }
}
