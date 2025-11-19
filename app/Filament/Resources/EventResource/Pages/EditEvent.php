<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => route('events.show', $this->record))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->is_published ?? false),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Mutate form data before saving.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure excerpt is set (required field in database)
        // If not provided, generate from content
        if (empty($data['excerpt']) || trim($data['excerpt']) === '') {
            $content = strip_tags($data['content'] ?? $data['description'] ?? $this->record->content ?? $this->record->description ?? '');
            $data['excerpt'] = \Illuminate\Support\Str::limit($content, 200);
        }

        // Ensure description is set if it's also required (fallback to excerpt or content)
        if (empty($data['description']) || trim($data['description']) === '') {
            $data['description'] = $data['excerpt'] ?? strip_tags($data['content'] ?? $this->record->content ?? '');
        }

        // Ensure event_date is set (required field in database, NOT NULL)
        // Use start_at if provided, otherwise preserve existing event_date or use published_at
        if (empty($data['event_date'])) {
            if (!empty($data['start_at'])) {
                $data['event_date'] = $data['start_at'];
            } elseif (!empty($this->record->event_date)) {
                // Preserve existing event_date if available
                $data['event_date'] = $this->record->event_date;
            } elseif (!empty($data['published_at'])) {
                $data['event_date'] = $data['published_at'];
            } elseif (!empty($this->record->start_at)) {
                // Fallback to existing start_at
                $data['event_date'] = $this->record->start_at;
            } else {
                $data['event_date'] = now();
            }
        }

        // Sync is_published with status field (published() scope requires is_published = true)
        // When status is 'published', set is_published = true
        // When status is 'draft' or 'archived', set is_published = false
        if (isset($data['status'])) {
            $data['is_published'] = ($data['status'] === 'published');
        } elseif (!isset($data['is_published'])) {
            // If status is not provided and is_published is not set, preserve existing value
            // or sync from existing status if status field exists on record
            if (!empty($this->record->status)) {
                $data['is_published'] = ($this->record->status === 'published');
            } else {
                // Preserve existing is_published value if no status is provided
                $data['is_published'] = $this->record->is_published ?? false;
            }
        }

        return $data;
    }
}
