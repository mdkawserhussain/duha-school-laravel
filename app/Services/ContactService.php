<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageReceived;

class ContactService
{
    protected ContactRepository $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function sendContactMessage(array $data): bool
    {
        $processedData = $this->contactRepository->processContactData($data);

        // Send email to school admin
        Mail::to(config('mail.admin_email', 'admin@almaghribschool.com'))
            ->queue(new ContactMessageReceived($processedData));

        return true;
    }
}