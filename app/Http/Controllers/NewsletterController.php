<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscribeRequest;
use App\Services\NewsletterService;

class NewsletterController extends Controller
{
    protected NewsletterService $newsletterService;

    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    public function subscribe(NewsletterSubscribeRequest $request)
    {
        $subscriber = $this->newsletterService->subscribe($request->email, $request->name);

        return response()->json([
            'success' => true,
            'message' => 'Successfully subscribed to our newsletter!'
        ]);
    }
}
