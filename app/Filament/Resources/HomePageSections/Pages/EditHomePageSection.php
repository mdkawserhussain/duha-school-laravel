<?php

namespace App\Filament\Resources\HomePageSections\Pages;

use App\Filament\Resources\HomePageSections\HomePageSectionResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class EditHomePageSection extends EditRecord
{
    protected static string $resource = HomePageSectionResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Convert data array to JSON string for textarea display
        if (isset($data['data']) && is_array($data['data'])) {
            // For parallax section, extract background_image and use_default_image to top level
            if (isset($data['section_key']) && $data['section_key'] === 'parallax_experience') {
                // These fields are now handled by the form directly
            }
            
            $data['data'] = json_encode($data['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        
        // Don't populate images field - it's handled by Spatie Media Library
        $data['images'] = null;
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure data is an array (handled by form component)
        if (isset($data['data']) && is_string($data['data'])) {
            $decoded = json_decode($data['data'], true);
            $data['data'] = $decoded !== null ? $decoded : [];
        }
        
        // Handle parallax section specific fields
        if (isset($data['section_key']) && $data['section_key'] === 'parallax_experience') {
            // Ensure data is an array
            if (!isset($data['data']) || !is_array($data['data'])) {
                $data['data'] = [];
            }
            
            // Move parallax fields to data array
            if (isset($data['parallax_background_image'])) {
                $data['data']['background_image'] = $data['parallax_background_image'];
                unset($data['parallax_background_image']);
            }
            
            if (isset($data['parallax_use_default_image'])) {
                $data['data']['use_default_image'] = $data['parallax_use_default_image'];
                unset($data['parallax_use_default_image']);
            }
        }
        
        // Remove images from data as we'll handle it manually
        unset($data['images']);
        
        return $data;
    }

    protected function afterSave(): void
    {
        $section = $this->record;
        
        // Handle image uploads from form state
        $formState = $this->form->getRawState();
        if (isset($formState['images']) && is_array($formState['images'])) {
            // Clear existing images if new ones are being uploaded
            // Note: In a real scenario, you might want to merge instead of replace
            // $section->clearMediaCollection('images');
            
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

        // Clear homepage cache after update
        Cache::forget('homepage_v2_data');

        Notification::make()
            ->title('Home page section updated successfully')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->after(function () {
                    // Clear homepage cache after deletion
                    Cache::forget('homepage_v2_data');
                }),
        ];
    }
}