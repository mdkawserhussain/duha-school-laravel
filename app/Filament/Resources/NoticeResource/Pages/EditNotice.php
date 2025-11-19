<?php

namespace App\Filament\Resources\NoticeResource\Pages;

use App\Filament\Resources\NoticeResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditNotice extends EditRecord
{
    protected static string $resource = NoticeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Notice updated')
            ->body('The notice has been saved successfully.')
            ->duration(3000)
            ->send();
    }

    protected function beforeSave(): void
    {
        // Ensure slug is generated if empty
        if (empty($this->data['slug']) && !empty($this->data['title'])) {
            $this->data['slug'] = \Illuminate\Support\Str::slug($this->data['title']);
        }
    }

    protected function afterSave(): void
    {
        // Clear only specific cache keys - faster than view:clear
        \Illuminate\Support\Facades\Cache::forget('notices_cache');
        \Illuminate\Support\Facades\Cache::forget('homepage_v2_data');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
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
}