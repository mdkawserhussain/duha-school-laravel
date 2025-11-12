<?php

namespace App\Repositories;

class ContactRepository
{
    // Contact repository - no model, just handles contact form data
    public function processContactData(array $data): array
    {
        // Process contact data, could add to database or just return for email
        return $data;
    }
}