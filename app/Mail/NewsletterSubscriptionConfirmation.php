<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscriptionConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Subscriber $subscriber)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Thanks for subscribing to our newsletter')
            ->view('emails.newsletter.confirmation', [
                'subscriber' => $this->subscriber,
            ]);
    }
}
