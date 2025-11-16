<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscribeRequest;
use App\Mail\NewsletterSubscriptionConfirmation;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(NewsletterSubscribeRequest $request): JsonResponse
    {
        $data = $request->validated();

        $subscriber = Subscriber::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'] ?? null,
                'is_active' => true,
                'unsubscribed_at' => null,
            ]
        );

        Mail::to($subscriber->email)->queue(new NewsletterSubscriptionConfirmation($subscriber));

        return response()->json([
            'message' => 'Subscription successful.',
        ]);
    }
}
