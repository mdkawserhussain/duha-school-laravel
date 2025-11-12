<?php

namespace App\Services;

use App\Repositories\NewsletterRepository;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\NewsletterSubscriptionConfirmation;
use Newsletter;

class NewsletterService
{
    protected NewsletterRepository $newsletterRepository;

    public function __construct(NewsletterRepository $newsletterRepository)
    {
        $this->newsletterRepository = $newsletterRepository;
    }

    public function subscribe(string $email, ?string $name = null): Subscriber
    {
        // Store in local database
        $subscriber = $this->newsletterRepository->subscribe($email, $name);

        // Sync with Mailchimp if configured
        if (config('services.mailchimp.api_key') && config('services.mailchimp.list_id')) {
            try {
                $mergeFields = $name ? ['FNAME' => $name] : [];
                Newsletter::subscribeOrUpdate($email, $mergeFields, config('services.mailchimp.list_id'), [
                    'double_optin' => true,
                ]);
            } catch (\Exception $e) {
                // Log error but don't fail the subscription
                Log::error('Mailchimp subscription failed: ' . $e->getMessage(), [
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Send confirmation email (queued)
        Mail::to($subscriber->email)->queue(new NewsletterSubscriptionConfirmation($subscriber));

        return $subscriber;
    }

    public function unsubscribe(string $email): bool
    {
        $result = $this->newsletterRepository->unsubscribe($email);

        // Unsubscribe from Mailchimp if configured
        if ($result && config('services.mailchimp.api_key') && config('services.mailchimp.list_id')) {
            try {
                Newsletter::unsubscribe($email, config('services.mailchimp.list_id'));
            } catch (\Exception $e) {
                Log::error('Mailchimp unsubscribe failed: ' . $e->getMessage(), [
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $result;
    }

    public function getActiveSubscribers(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->newsletterRepository->getActiveSubscribers();
    }

    public function isSubscribed(string $email): bool
    {
        return $this->newsletterRepository->isSubscribed($email);
    }
}