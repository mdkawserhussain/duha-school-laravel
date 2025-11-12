<?php

namespace App\Filament\Resources\HomePageSections\Pages;

use App\Filament\Resources\HomePageSections\HomePageSectionResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateHomePageSection extends CreateRecord
{
    protected static string $resource = HomePageSectionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure data is an array (handled by form component)
        if (isset($data['data']) && is_string($data['data'])) {
            $decoded = json_decode($data['data'], true);
            $data['data'] = $decoded !== null ? $decoded : [];
        } elseif (!isset($data['data'])) {
            $data['data'] = [];
        }
        
        // Remove images from data as we'll handle it manually
        unset($data['images']);
        // Keep image_filenames for reference
        // unset($data['image_filenames']); // Keep this to access filenames
        
        return $data;
    }

    protected function afterCreate(): void
    {
        $section = $this->record;
        
        // Log for debugging
        \Log::info('CreateHomePageSection::afterCreate - Section ID: ' . $section->id);
        
        // Handle image uploads from form state
        $formState = $this->form->getRawState();
        \Log::info('Form state images: ', ['images' => $formState['images'] ?? 'not set']);
        
        // Try to get images from the Livewire component's state
        $images = $formState['images'] ?? null;
        
        // Also check for stored filenames
        $imageFilenames = $formState['image_filenames'] ?? null;
        if ($imageFilenames && is_array($imageFilenames)) {
            \Log::info('Found image filenames: ', $imageFilenames);
            // Use filenames to locate files
            if (!$images) {
                $images = $imageFilenames;
            }
        }
        
        // If images is not an array, try to get from component state
        if (!$images && isset($this->data['images'])) {
            $images = $this->data['images'];
            \Log::info('Found images in component data');
        }
        
        // Check if files are in the request (for direct uploads)
        if (!$images && request()->hasFile('data.images')) {
            $uploadedFiles = request()->file('data.images');
            if (is_array($uploadedFiles)) {
                foreach ($uploadedFiles as $index => $file) {
                    if ($file && $file->isValid()) {
                        try {
                            $section->addMediaFromRequest("data.images.$index")
                                ->toMediaCollection('images');
                            \Log::info("Added image $index from request");
                        } catch (\Exception $e) {
                            \Log::error('Failed to add image from request: ' . $e->getMessage());
                        }
                    }
                }
                // Skip the rest if we handled request files
                $images = null;
            }
        }
        
        if (isset($images) && is_array($images) && count($images) > 0) {
            \Log::info('Processing ' . count($images) . ' images');
            foreach ($images as $index => $imagePath) {
                \Log::info("Processing image $index: $imagePath");
                if (is_string($imagePath) && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                    $added = false;
                    
                    // Handle Livewire temporary files
                    if (str_starts_with($imagePath, 'livewire-tmp/')) {
                        // Try full path first
                        $fullPath = storage_path('app/public/' . $imagePath);
                        if (file_exists($fullPath) && is_file($fullPath)) {
                            try {
                                $section->addMedia($fullPath)->toMediaCollection('images');
                                $added = true;
                            } catch (\Exception $e) {
                                \Log::error('Failed to add media from livewire-tmp path: ' . $e->getMessage());
                            }
                        }
                        
                        // Try using Storage disk
                        if (!$added && Storage::disk('public')->exists($imagePath)) {
                            try {
                                $section->addMediaFromDisk($imagePath, 'public')->toMediaCollection('images');
                                $added = true;
                            } catch (\Exception $e) {
                                \Log::error('Failed to add media from disk: ' . $e->getMessage());
                            }
                        }
                    }
                    
                    // If not added yet, try different path formats
                    if (!$added) {
                        $paths = [
                            storage_path('app/public/' . $imagePath),
                            storage_path('app/public/homepage-sections/' . basename($imagePath)),
                            storage_path('app/' . $imagePath),
                            public_path('storage/' . $imagePath),
                            $imagePath,
                        ];
                        
                        foreach ($paths as $path) {
                            if (file_exists($path) && is_file($path)) {
                                try {
                                    $section->addMedia($path)->toMediaCollection('images');
                                    $added = true;
                                    break;
                                } catch (\Exception $e) {
                                    \Log::error('Failed to add media from path ' . $path . ': ' . $e->getMessage());
                                    continue;
                                }
                            }
                        }
                    }
                    
                    // Try using Storage disk for non-livewire paths
                    if (!$added) {
                        $diskPaths = [
                            $imagePath,
                            'homepage-sections/' . basename($imagePath),
                        ];
                        
                        foreach ($diskPaths as $diskPath) {
                            if (Storage::disk('public')->exists($diskPath)) {
                                try {
                                    $section->addMediaFromDisk($diskPath, 'public')->toMediaCollection('images');
                                    $added = true;
                                    break;
                                } catch (\Exception $e) {
                                    \Log::error('Failed to add media from disk path ' . $diskPath . ': ' . $e->getMessage());
                                }
                            }
                        }
                    }
                    
                    if ($added) {
                        \Log::info("Successfully added image: $imagePath");
                    } else {
                        \Log::warning("Failed to add image: $imagePath - tried all paths");
                    }
                } else {
                    \Log::info("Skipping image (URL or invalid): $imagePath");
                }
            }
        } else {
            \Log::warning('No images found in form state or images array is empty');
        }
        
        // Check if images were actually added
        $mediaCount = $section->getMedia('images')->count();
        \Log::info("Total media count after processing: $mediaCount");

        // Clear homepage cache so new slider appears immediately
        cache()->forget('homepage_data');

        Notification::make()
            ->title('Home page section created successfully')
            ->success()
            ->send();
    }
}
