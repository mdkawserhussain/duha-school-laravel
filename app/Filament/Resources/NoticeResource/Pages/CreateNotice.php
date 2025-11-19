<?php

namespace App\Filament\Resources\NoticeResource\Pages;

use App\Filament\Resources\NoticeResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateNotice extends CreateRecord
{
    protected static string $resource = NoticeResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Notice created')
            ->body('The notice has been created successfully.')
            ->duration(3000)
            ->send();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure slug is generated if empty
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        }

        // Ensure slug is properly formatted
        if (!empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['slug']);
        }

        // Ensure excerpt is not null
        if (empty($data['excerpt'])) {
            $data['excerpt'] = \Illuminate\Support\Str::limit(strip_tags($data['content'] ?? ''), 200);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Clear only specific cache keys - faster than view:clear
        \Illuminate\Support\Facades\Cache::forget('notices_cache');
        \Illuminate\Support\Facades\Cache::forget('homepage_v2_data');
    }
}