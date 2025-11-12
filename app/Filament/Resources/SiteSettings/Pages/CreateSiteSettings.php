<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingsResource;
use App\Models\SiteSettings;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateSiteSettings extends CreateRecord
{
    protected static string $resource = SiteSettingsResource::class;

    public function getTitle(): string
    {
        return 'Create Site Settings';
    }

    public function getSubheading(): ?string
    {
        return 'Set up your site configuration, logo, and contact information';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Store logo path before removing it
        $this->logoPath = $data['logo'] ?? null;
        // Remove logo from data since we'll handle it manually
        unset($data['logo']);
        return $data;
    }

    protected $logoPath = null;

    protected function afterCreate(): void
    {
        $settings = $this->record;
        $logo = $this->logoPath;
        
        // If no logo in saved state, try to get from raw form state
        if (!$logo) {
            $formState = $this->form->getRawState();
            $logo = $formState['logo'] ?? null;
        }
        
        // Handle file upload
        if ($logo) {
            // Handle array of file paths
            if (is_array($logo)) {
                $filePath = (isset($logo[0]) && !empty($logo[0])) ? $logo[0] : null;
            } else {
                $filePath = $logo;
            }
            
            // Skip if no valid file path
            if (!$filePath) {
                Notification::make()
                    ->title('Settings created successfully')
                    ->success()
                    ->send();
                return;
            }
            
            // If it's a string path, try to add the media
            if (is_string($filePath) && !filter_var($filePath, FILTER_VALIDATE_URL)) {
                $added = false;
                
                // Handle Livewire temporary files
                if (str_starts_with($filePath, 'livewire-tmp/')) {
                    // File is in Livewire temp directory
                    if (Storage::disk('public')->exists($filePath)) {
                        try {
                            $settings->addMediaFromDisk($filePath, 'public')
                                ->toMediaCollection('logo');
                            $added = true;
                        } catch (\Exception $e) {
                            // Try alternative method
                        }
                    }
                }
                
                // If not added yet, try different path formats
                if (!$added) {
                    $paths = [
                        storage_path('app/public/' . $filePath),
                        storage_path('app/' . $filePath),
                        public_path('storage/' . $filePath),
                        $filePath,
                    ];
                    
                    foreach ($paths as $path) {
                        if (file_exists($path) && is_file($path)) {
                            try {
                                $settings->addMedia($path)
                                    ->toMediaCollection('logo');
                                $added = true;
                                break;
                            } catch (\Exception $e) {
                                // Continue to next path
                                continue;
                            }
                        }
                    }
                }
                
                // If file exists in storage disk (for non-livewire-tmp files)
                if (!$added && Storage::disk('public')->exists($filePath)) {
                    try {
                        $settings->addMediaFromDisk($filePath, 'public')
                            ->toMediaCollection('logo');
                        $added = true;
                    } catch (\Exception $e) {
                        // Log error but don't fail
                    }
                }
            }
        }

        Notification::make()
            ->title('Settings created successfully')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
}
