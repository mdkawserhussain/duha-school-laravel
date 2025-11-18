<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove file upload fields from data as we'll handle them manually
        unset($data['hero_image'], $data['featured_image']);

        // Sync is_published with status field (published() scope requires is_published = true)
        // When status is 'published', set is_published = true
        // When status is 'draft', set is_published = false
        if (isset($data['status'])) {
            $data['is_published'] = ($data['status'] === 'published');
        } else {
            // If status is not provided, default to draft (is_published = false)
            $data['is_published'] = false;
        }

        // Remove status field as it doesn't exist in database
        unset($data['status']);
        
        return $data;
    }

    protected function afterCreate(): void
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