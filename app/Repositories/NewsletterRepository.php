<?php

namespace App\Repositories;

use App\Models\Subscriber;

class NewsletterRepository
{
    public function subscribe(string $email, ?string $name = null): Subscriber
    {
        $subscriber = Subscriber::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'is_active' => true,
                'subscribed_at' => now(),
            ]
        );

        // Update existing subscriber if resubscribing
        if ($subscriber->wasRecentlyCreated === false) {
            $subscriber->update([
                'name' => $name ?? $subscriber->name,
                'is_active' => true,
                'subscribed_at' => now(),
            ]);
        }

        return $subscriber->fresh();
    }

    public function unsubscribe(string $email): bool
    {
        $subscriber = Subscriber::where('email', $email)->first();
        if ($subscriber) {
            $subscriber->unsubscribe();
            return true;
        }
        return false;
    }

    public function getActiveSubscribers(): \Illuminate\Database\Eloquent\Collection
    {
        return Subscriber::active()->get();
    }

    public function isSubscribed(string $email): bool
    {
        return Subscriber::where('email', $email)->where('is_active', true)->exists();
    }
}