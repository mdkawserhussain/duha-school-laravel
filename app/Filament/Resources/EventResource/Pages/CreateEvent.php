<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    /**
     * Mutate form data before saving.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure excerpt is set (required field in database)
        // If not provided, generate from content
        if (empty($data['excerpt']) || trim($data['excerpt']) === '') {
            $content = strip_tags($data['content'] ?? $data['description'] ?? '');
            $data['excerpt'] = \Illuminate\Support\Str::limit($content, 200);
        }

        // Ensure description is set if it's also required (fallback to excerpt or content)
        if (empty($data['description']) || trim($data['description']) === '') {
            $data['description'] = $data['excerpt'] ?? strip_tags($data['content'] ?? '');
        }

        // Ensure event_date is set (required field in database, NOT NULL)
        // Use start_at if provided, otherwise use published_at, or fallback to now()
        if (empty($data['event_date'])) {
            if (!empty($data['start_at'])) {
                $data['event_date'] = $data['start_at'];
            } elseif (!empty($data['published_at'])) {
                $data['event_date'] = $data['published_at'];
            } else {
                $data['event_date'] = now();
            }
        }

        // Sync is_published with status field (published() scope requires is_published = true)
        // When status is 'published', set is_published = true
        // When status is 'draft' or 'archived', set is_published = false
        if (isset($data['status'])) {
            $data['is_published'] = ($data['status'] === 'published');
        } else {
            // If status is not provided, default to draft (is_published = false)
            $data['is_published'] = false;
        }

        return $data;
    }
}
