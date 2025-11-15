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
        return 'Manage your site configuration, branding, contact information, SEO, and more';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Store file paths before removing them
        $this->logoPath = $data['logo'] ?? null;
        $this->faviconPath = $data['favicon'] ?? null;
        $this->ogImagePath = $data['og_image'] ?? null;
        
        \Log::info('EditSiteSettings::mutateFormDataBeforeSave: Captured file paths', [
            'logoPath' => $this->logoPath,
            'faviconPath' => $this->faviconPath,
            'ogImagePath' => $this->ogImagePath,
            'logoPathType' => gettype($this->logoPath),
            'logoPathIsArray' => is_array($this->logoPath),
        ]);
        
        // Remove files from data since we'll handle them manually
        unset($data['logo'], $data['favicon'], $data['og_image']);
        
        return $data;
    }

    protected $logoPath = null;
    protected $faviconPath = null;
    protected $ogImagePath = null;

    protected function afterSave(): void
    {
        $settings = $this->record;
        
        // Get file paths from form raw state if not already stored
        $formState = $this->form->getRawState();
        
        \Log::info('EditSiteSettings::afterSave: Starting media upload processing', [
            'logoPath' => $this->logoPath ?? 'not set',
            'formStateLogo' => $formState['logo'] ?? 'not set',
            'faviconPath' => $this->faviconPath ?? 'not set',
            'ogImagePath' => $this->ogImagePath ?? 'not set',
        ]);
        
        // Handle logo upload
        $logoPath = $this->logoPath ?? $formState['logo'] ?? null;
        if ($logoPath) {
            \Log::info('EditSiteSettings::afterSave: Processing logo upload', [
                'logoPath' => $logoPath,
                'isArray' => is_array($logoPath),
                'logoPathType' => gettype($logoPath),
            ]);
            // Extract path from array if needed (Filament uses associative arrays with UUID keys)
            if (is_array($logoPath)) {
                $logoPath = !empty($logoPath[0]) ? $logoPath[0] : reset($logoPath);
                \Log::info('EditSiteSettings::afterSave: Extracted logo path from array', [
                    'extractedPath' => $logoPath,
                ]);
            }
        }
        $this->handleMediaUpload($settings, $logoPath, 'logo');
        
        // Handle favicon upload
        $faviconPath = $this->faviconPath ?? $formState['favicon'] ?? null;
        if ($faviconPath) {
            if (is_array($faviconPath)) {
                $faviconPath = !empty($faviconPath[0]) ? $faviconPath[0] : reset($faviconPath);
            }
            \Log::info('EditSiteSettings::afterSave: Processing favicon upload', [
                'faviconPath' => $faviconPath,
            ]);
        }
        $this->handleMediaUpload($settings, $faviconPath, 'favicon');
        
        // Handle OG image upload
        $ogImagePath = $this->ogImagePath ?? $formState['og_image'] ?? null;
        if ($ogImagePath) {
            if (is_array($ogImagePath)) {
                $ogImagePath = !empty($ogImagePath[0]) ? $ogImagePath[0] : reset($ogImagePath);
            }
            \Log::info('EditSiteSettings::afterSave: Processing OG image upload', [
                'ogImagePath' => $ogImagePath,
            ]);
        }
        $this->handleMediaUpload($settings, $ogImagePath, 'og_image');
        
        // Handle advisors profile images
        $this->handleAdvisorsMedia($settings, $formState['advisors'] ?? null);
        
        // Refresh the model to load new media relationships
        $settings->refresh();
        $settings->load('media');
        
        // Verify media was added
        $hasLogo = $settings->hasMedia('logo');
        $hasFavicon = $settings->hasMedia('favicon');
        $hasOgImage = $settings->hasMedia('og_image');
        
        \Log::info('EditSiteSettings::afterSave: Media verification after upload', [
            'hasLogo' => $hasLogo,
            'hasFavicon' => $hasFavicon,
            'hasOgImage' => $hasOgImage,
            'mediaCount' => $settings->media->count(),
        ]);
        
        // Clear all relevant caches after saving
        SiteSettings::clearCache();
        \Illuminate\Support\Facades\Cache::forget('site_settings');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');

        $message = 'Site settings have been updated and all caches have been cleared.';
        if ($logoPath && !$hasLogo) {
            $message .= ' Warning: Logo upload may have failed. Check logs for details.';
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->body($message)
            ->send();
    }

    protected function handleMediaUpload($settings, $filePath, string $collection): void
    {
        if (!$filePath) {
            \Log::info("handleMediaUpload: No file path provided for collection: {$collection}");
            return;
        }
        
        // Handle array of file paths (Filament uses associative arrays with UUID keys)
        if (is_array($filePath)) {
            // Get the first value from the array (could be numeric or associative with UUID keys)
            if (!empty($filePath[0])) {
                $filePath = $filePath[0];
            } else {
                // Handle associative array (e.g., {"uuid": "path/to/file"})
                $filePath = reset($filePath); // Get first value
            }
        }
        
        if (!$filePath || !is_string($filePath)) {
            \Log::warning("handleMediaUpload: Invalid file path format for collection: {$collection}", [
                'filePath' => $filePath,
                'type' => gettype($filePath),
                'originalFilePath' => is_array($filePath) ? json_encode($filePath) : $filePath,
            ]);
            return;
        }
        
        \Log::info("handleMediaUpload: Processing file for collection: {$collection}", [
            'filePath' => $filePath,
            'isUrl' => filter_var($filePath, FILTER_VALIDATE_URL),
        ]);
        
        // Skip if it's a URL (already uploaded and in media collection)
        if (filter_var($filePath, FILTER_VALIDATE_URL)) {
            \Log::info("handleMediaUpload: File path is a URL, skipping: {$filePath}");
            return;
        }
        
        // Clear existing media in collection
        $settings->clearMediaCollection($collection);
        \Log::info("handleMediaUpload: Cleared existing media in collection: {$collection}");
        
        $added = false;
        $lastError = null;
        
        // First, try using Storage disk (most reliable for Filament uploads)
        // Filament stores files relative to the public disk root
        if (Storage::disk('public')->exists($filePath)) {
            try {
                \Log::info("handleMediaUpload: Attempting addMediaFromDisk with path: {$filePath}");
                $settings->addMediaFromDisk($filePath, 'public')
                    ->toMediaCollection($collection);
                $added = true;
                \Log::info("handleMediaUpload: Successfully added media from disk: {$filePath}");
            } catch (\Exception $e) {
                $lastError = $e->getMessage();
                \Log::error("handleMediaUpload: Failed to add media from disk", [
                    'filePath' => $filePath,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }
        
        // Handle Livewire temporary files (if not already added)
        if (!$added && str_starts_with($filePath, 'livewire-tmp/')) {
            $fullPath = storage_path('app/public/' . $filePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                try {
                    \Log::info("handleMediaUpload: Attempting addMedia from livewire-tmp: {$fullPath}");
                    $settings->addMedia($fullPath)
                        ->toMediaCollection($collection);
                    $added = true;
                    \Log::info("handleMediaUpload: Successfully added media from livewire-tmp");
                } catch (\Exception $e) {
                    $lastError = $e->getMessage();
                    \Log::error("handleMediaUpload: Failed to add media from livewire-tmp", [
                        'fullPath' => $fullPath,
                        'error' => $e->getMessage(),
                    ]);
                }
            } elseif (Storage::disk('public')->exists($filePath)) {
                try {
                    \Log::info("handleMediaUpload: Attempting addMediaFromDisk for livewire-tmp: {$filePath}");
                    $settings->addMediaFromDisk($filePath, 'public')
                        ->toMediaCollection($collection);
                    $added = true;
                    \Log::info("handleMediaUpload: Successfully added media from livewire-tmp disk");
                } catch (\Exception $e) {
                    $lastError = $e->getMessage();
                    \Log::error("handleMediaUpload: Failed to add media from livewire-tmp disk", [
                        'filePath' => $filePath,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
        
        // If not added yet, try different absolute path formats
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
                        \Log::info("handleMediaUpload: Attempting addMedia with absolute path: {$path}");
                        $settings->addMedia($path)
                            ->toMediaCollection($collection);
                        $added = true;
                        \Log::info("handleMediaUpload: Successfully added media from absolute path");
                        break;
                    } catch (\Exception $e) {
                        $lastError = $e->getMessage();
                        \Log::warning("handleMediaUpload: Failed to add media from absolute path", [
                            'path' => $path,
                            'error' => $e->getMessage(),
                        ]);
                        continue;
                    }
                }
            }
        }
        
        // Final verification
        if ($added) {
            $settings->refresh();
            $hasMedia = $settings->hasMedia($collection);
            \Log::info("handleMediaUpload: Media addition verification", [
                'collection' => $collection,
                'hasMedia' => $hasMedia,
            ]);
            
            if (!$hasMedia) {
                \Log::error("handleMediaUpload: Media was added but verification failed!", [
                    'collection' => $collection,
                    'filePath' => $filePath,
                ]);
                $added = false;
            }
        } else {
            \Log::error("handleMediaUpload: Failed to add media to collection", [
                'collection' => $collection,
                'filePath' => $filePath,
                'lastError' => $lastError,
                'storageExists' => Storage::disk('public')->exists($filePath),
            ]);
        }
    }

    protected function handleAdvisorsMedia($settings, $advisorsData): void
    {
        if (!is_array($advisorsData)) {
            return;
        }

        // Clear existing advisors media
        $settings->clearMediaCollection('advisors');

        // Process each advisor's profile image
        foreach ($advisorsData as $advisor) {
            if (isset($advisor['profile_image']) && $advisor['profile_image']) {
                $filePath = $advisor['profile_image'];
                
                // Handle array of file paths
                if (is_array($filePath)) {
                    $filePath = !empty($filePath[0]) ? $filePath[0] : null;
                }
                
                if (!$filePath || !is_string($filePath)) {
                    continue;
                }
                
                // Skip if it's a URL (already uploaded)
                if (filter_var($filePath, FILTER_VALIDATE_URL)) {
                    continue;
                }
                
                $added = false;
                
                // Handle Livewire temporary files
                if (str_starts_with($filePath, 'livewire-tmp/')) {
                    if (Storage::disk('public')->exists($filePath)) {
                        try {
                            $settings->addMediaFromDisk($filePath, 'public')
                                ->toMediaCollection('advisors');
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
                                    ->toMediaCollection('advisors');
                                $added = true;
                                break;
                            } catch (\Exception $e) {
                                continue;
                            }
                        }
                    }
                }
                
                // If file exists in storage disk
                if (!$added && Storage::disk('public')->exists($filePath)) {
                    try {
                        $settings->addMediaFromDisk($filePath, 'public')
                            ->toMediaCollection('advisors');
                        $added = true;
                    } catch (\Exception $e) {
                        // Log error but don't fail
                    }
                }
            }
        }
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