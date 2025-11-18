<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => route('pages.show', $this->record->slug))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->is_published ?? false),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Mutate form data before filling the form (when loading existing page).
     * Map is_published to status field for the form.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Map is_published (boolean) to status (string) for the form
        if (isset($data['is_published'])) {
            $data['status'] = $data['is_published'] ? 'published' : 'draft';
        } else {
            $data['status'] = 'draft';
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove file upload fields from data as we'll handle them manually
        unset($data['hero_image'], $data['featured_image']);

        // Sync is_published with status field (published() scope requires is_published = true)
        // When status is 'published', set is_published = true
        // When status is 'draft', set is_published = false
        if (isset($data['status'])) {
            $data['is_published'] = ($data['status'] === 'published');
        } elseif (!isset($data['is_published'])) {
            // If status is not provided and is_published is not set, preserve existing value
            $data['is_published'] = $this->record->is_published ?? false;
        }

        // Remove status field as it doesn't exist in database
        unset($data['status']);
        
        return $data;
    }

    protected function afterSave(): void
    {
        $page = $this->record;
        $formState = $this->form->getRawState();

        // Handle hero_image upload
        if (isset($formState['hero_image']) && !empty($formState['hero_image'])) {
            $this->handleMediaUpload($page, $formState['hero_image'], 'hero_image');
        }

        // Handle featured_image upload
        if (isset($formState['featured_image']) && !empty($formState['featured_image'])) {
            $this->handleMediaUpload($page, $formState['featured_image'], 'featured_image');
        }
    }

    protected function handleMediaUpload($page, $filePath, string $collection): void
    {
        if (!$filePath) {
            return;
        }

        // Handle array of file paths (Filament uses associative arrays with UUID keys)
        if (is_array($filePath)) {
            if (empty($filePath)) {
                return;
            }
            // Get the first value from the array
            if (!empty($filePath[0])) {
                $filePath = $filePath[0];
            } else {
                $filePath = reset($filePath); // Get first value from associative array
            }
        }

        if (!$filePath || !is_string($filePath)) {
            return;
        }

        // Skip if it's a URL (already uploaded and in media collection)
        if (filter_var($filePath, FILTER_VALIDATE_URL)) {
            return;
        }

        // Clear existing media in collection (for single file collections)
        $page->clearMediaCollection($collection);

        // Handle Livewire temporary files
        if (str_starts_with($filePath, 'livewire-tmp/')) {
            $fullPath = storage_path('app/public/' . $filePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                $page->addMedia($fullPath)->toMediaCollection($collection);
            } elseif (Storage::disk('public')->exists($filePath)) {
                $page->addMediaFromDisk($filePath, 'public')->toMediaCollection($collection);
            }
        } else {
            // Handle files in pages directory
            $possiblePaths = [
                'pages/' . basename($filePath),
                $filePath,
            ];

            foreach ($possiblePaths as $testPath) {
                $fullPath = storage_path('app/public/' . $testPath);
                if (file_exists($fullPath) && is_file($fullPath)) {
                    $page->addMedia($fullPath)->toMediaCollection($collection);
                    break;
                } elseif (Storage::disk('public')->exists($testPath)) {
                    $page->addMediaFromDisk($testPath, 'public')->toMediaCollection($collection);
                    break;
                }
            }
        }
    }
}