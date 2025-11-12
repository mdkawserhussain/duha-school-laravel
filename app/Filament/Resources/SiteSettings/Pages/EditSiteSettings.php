<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingsResource;
use App\Models\SiteSettings;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditSiteSettings extends EditRecord
{
    protected static string $resource = SiteSettingsResource::class;

    public function getTitle(): string
    {
        return 'Edit Site Settings';
    }

    public function getSubheading(): ?string
    {
        return 'Manage your site configuration, logo, and contact information';
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $settings = SiteSettings::first();
        if ($settings && $settings->hasMedia('logo')) {
            // Return empty array so Filament doesn't try to load the media URL as a file path
            $data['logo'] = null;
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Store logo path before removing it
        $this->logoPath = $data['logo'] ?? null;
        // Also check for stored filename
        $this->logoFilename = $data['logo_filename'] ?? null;
        // Remove logo from data since we'll handle it manually
        unset($data['logo']);
        unset($data['logo_filename']);
        return $data;
    }

    protected $logoPath = null;
    protected $logoFilename = null;

    protected function afterSave(): void
    {
        $settings = $this->record;
        $logo = $this->logoPath;
        
        // If no logo in saved state, try to get from raw form state
        if (!$logo) {
            try {
                $formState = $this->form->getRawState();
                $logo = $formState['logo'] ?? null;
            } catch (\Exception $e) {
                // Form state might not be available, continue
            }
        }
        
        // Also check if there's a file in the request (for Livewire file uploads)
        if (!$logo && request()->hasFile('data.logo')) {
            $uploadedFile = request()->file('data.logo');
            if ($uploadedFile && $uploadedFile->isValid()) {
                $settings->clearMediaCollection('logo');
                $settings->addMediaFromRequest('data.logo')
                    ->toMediaCollection('logo');
                
                Notification::make()
                    ->title('Settings saved successfully')
                    ->success()
                    ->send();
                return;
            }
        }
        
        // Handle file upload from path
        if ($logo || $this->logoFilename) {
            $settings->clearMediaCollection('logo');
            
            // Use filename if available, otherwise use logo path
            $filePath = $this->logoFilename ?? $logo;
            
            // Handle array of file paths
            if (is_array($filePath)) {
                $filePath = (isset($filePath[0]) && !empty($filePath[0])) ? $filePath[0] : null;
            }
            
            // Skip if no valid file path
            if (!$filePath) {
                Notification::make()
                    ->title('Settings saved successfully')
                    ->success()
                    ->send();
                return;
            }
            
            // If it's a string path, try to add the media
            if (is_string($filePath) && !filter_var($filePath, FILTER_VALIDATE_URL)) {
                $added = false;
                
                // Handle Livewire temporary files - try to get the actual file
                if (str_starts_with($filePath, 'livewire-tmp/')) {
                    // Try to get the file from storage
                    $fullPath = storage_path('app/public/' . $filePath);
                    if (file_exists($fullPath) && is_file($fullPath)) {
                        try {
                            $settings->addMedia($fullPath)
                                ->toMediaCollection('logo');
                            $added = true;
                        } catch (\Exception $e) {
                            \Log::error('Failed to add media from livewire-tmp path: ' . $e->getMessage());
                        }
                    }
                    
                    // Also try using Storage disk
                    if (!$added && Storage::disk('public')->exists($filePath)) {
                        try {
                            $settings->addMediaFromDisk($filePath, 'public')
                                ->toMediaCollection('logo');
                            $added = true;
                        } catch (\Exception $e) {
                            \Log::error('Failed to add media from disk: ' . $e->getMessage());
                        }
                    }
                } else {
                    // Handle files in logos directory (after Filament moves them)
                    // Try with and without 'logos/' prefix
                    $possiblePaths = [];
                    
                    if (str_starts_with($filePath, 'logos/')) {
                        $possiblePaths[] = $filePath;
                        $possiblePaths[] = str_replace('logos/', '', $filePath);
                    } else {
                        $possiblePaths[] = 'logos/' . $filePath;
                        $possiblePaths[] = $filePath;
                    }
                    
                    foreach ($possiblePaths as $testPath) {
                        $fullPath = storage_path('app/public/' . $testPath);
                        if (file_exists($fullPath) && is_file($fullPath)) {
                            try {
                                $settings->addMedia($fullPath)
                                    ->toMediaCollection('logo');
                                $added = true;
                                \Log::info('Successfully added logo from: ' . $fullPath);
                                break;
                            } catch (\Exception $e) {
                                \Log::error('Failed to add media from path ' . $fullPath . ': ' . $e->getMessage());
                            }
                        }
                        
                        // Also try using Storage disk
                        if (!$added && Storage::disk('public')->exists($testPath)) {
                            try {
                                $settings->addMediaFromDisk($testPath, 'public')
                                    ->toMediaCollection('logo');
                                $added = true;
                                \Log::info('Successfully added logo from disk: ' . $testPath);
                                break;
                            } catch (\Exception $e) {
                                \Log::error('Failed to add media from disk ' . $testPath . ': ' . $e->getMessage());
                            }
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
                                \Log::error('Failed to add media from path ' . $path . ': ' . $e->getMessage());
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
                        \Log::error('Failed to add media from storage disk: ' . $e->getMessage());
                    }
                }
                
                // Log if still not added
                if (!$added) {
                    \Log::warning('Logo file not found or could not be added to media library. File path: ' . $filePath);
                }
            }
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_website')
                ->label('View Website')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(route('home'), shouldOpenInNewTab: true),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
}
