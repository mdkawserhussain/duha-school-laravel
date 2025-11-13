<?php

namespace App\Filament\Resources\HomePageSections\Pages;

use App\Filament\Resources\HomePageSections\HomePageSectionResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;
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
        
        return $data;
    }

    protected function afterCreate(): void
    {
        $section = $this->record;
        
        // Handle image uploads from form state
        $formState = $this->form->getRawState();
        if (isset($formState['images']) && is_array($formState['images'])) {
            foreach ($formState['images'] as $imagePath) {
                if (is_string($imagePath) && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                    // Handle Livewire temporary files
                    if (str_starts_with($imagePath, 'livewire-tmp/')) {
                        $fullPath = storage_path('app/public/' . $imagePath);
                        if (file_exists($fullPath) && is_file($fullPath)) {
                            $section->addMedia($fullPath)->toMediaCollection('images');
                        } elseif (Storage::disk('public')->exists($imagePath)) {
                            $section->addMediaFromDisk($imagePath, 'public')->toMediaCollection('images');
                        }
                    } else {
                        // Handle files in homepage-sections directory
                        $possiblePaths = [
                            'homepage-sections/' . basename($imagePath),
                            $imagePath,
                        ];
                        
                        foreach ($possiblePaths as $testPath) {
                            $fullPath = storage_path('app/public/' . $testPath);
                            if (file_exists($fullPath) && is_file($fullPath)) {
                                $section->addMedia($fullPath)->toMediaCollection('images');
                                break;
                            } elseif (Storage::disk('public')->exists($testPath)) {
                                $section->addMediaFromDisk($testPath, 'public')->toMediaCollection('images');
                                break;
                            }
                        }
                    }
                }
            }
        }

        // Clear homepage cache after creation
        Cache::forget('homepage_v2_data');

        Notification::make()
            ->title('Home page section created successfully')
            ->success()
            ->send();
    }
}
