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
        
        // Remove files from data since we'll handle them manually
        unset($data['logo'], $data['favicon'], $data['og_image']);
        
        return $data;
    }

    protected $logoPath = null;
    protected $faviconPath = null;
    protected $ogImagePath = null;
    protected $hasChanges = false;

    protected function afterSave(): void
    {
        $settings = $this->record;
        
        // Get file paths from form raw state if not already stored
        $formState = $this->form->getRawState();
        
        // Track if any files were actually processed
        $filesProcessed = false;
        
        // Handle logo upload - only if file path is provided and is not a URL (already uploaded)
        $logoPath = $this->logoPath ?? $formState['logo'] ?? null;
        if ($logoPath && (is_array($logoPath) || (is_string($logoPath) && !filter_var($logoPath, FILTER_VALIDATE_URL)))) {
            if (is_array($logoPath)) {
                $logoPath = !empty($logoPath[0]) ? $logoPath[0] : reset($logoPath);
            }
            if ($logoPath && !filter_var($logoPath, FILTER_VALIDATE_URL)) {
                $this->handleMediaUpload($settings, $logoPath, 'logo');
                $filesProcessed = true;
            }
        }
        
        // Handle favicon upload - only if file path is provided and is not a URL
        $faviconPath = $this->faviconPath ?? $formState['favicon'] ?? null;
        if ($faviconPath && (is_array($faviconPath) || (is_string($faviconPath) && !filter_var($faviconPath, FILTER_VALIDATE_URL)))) {
            if (is_array($faviconPath)) {
                $faviconPath = !empty($faviconPath[0]) ? $faviconPath[0] : reset($faviconPath);
            }
            if ($faviconPath && !filter_var($faviconPath, FILTER_VALIDATE_URL)) {
                $this->handleMediaUpload($settings, $faviconPath, 'favicon');
                $filesProcessed = true;
            }
        }
        
        // Handle OG image upload - only if file path is provided and is not a URL
        $ogImagePath = $this->ogImagePath ?? $formState['og_image'] ?? null;
        if ($ogImagePath && (is_array($ogImagePath) || (is_string($ogImagePath) && !filter_var($ogImagePath, FILTER_VALIDATE_URL)))) {
            if (is_array($ogImagePath)) {
                $ogImagePath = !empty($ogImagePath[0]) ? $ogImagePath[0] : reset($ogImagePath);
            }
            if ($ogImagePath && !filter_var($ogImagePath, FILTER_VALIDATE_URL)) {
                $this->handleMediaUpload($settings, $ogImagePath, 'og_image');
                $filesProcessed = true;
            }
        }
        
        // Handle advisors profile images - only if data exists
        $advisorsData = $formState['advisors'] ?? null;
        if ($advisorsData && is_array($advisorsData)) {
            $advisorsChanged = $this->handleAdvisorsMedia($settings, $advisorsData);
            if ($advisorsChanged) {
                $filesProcessed = true;
            }
        }
        
        // Only refresh if files were processed
        if ($filesProcessed) {
            $settings->refresh();
            $settings->load('media');
        }
        
        // Verify media was added only if files were processed
        $hasLogo = $settings->hasMedia('logo');
        $hasFavicon = $settings->hasMedia('favicon');
        $hasOgImage = $settings->hasMedia('og_image');
        
        // Only clear caches if settings were actually changed (model was dirty before save)
        if ($this->record->wasChanged() || $filesProcessed) {
            SiteSettings::clearCache();
            \Illuminate\Support\Facades\Cache::forget('site_settings');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
        }

        $message = 'Site settings have been updated' . ($filesProcessed || $this->record->wasChanged() ? ' and all caches have been cleared.' : '.');
        if ($logoPath && !filter_var($logoPath, FILTER_VALIDATE_URL) && !$hasLogo) {
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
            return;
        }
        
        // Handle array of file paths (Filament uses associative arrays with UUID keys)
        if (is_array($filePath)) {
            // Check if array is empty
            if (empty($filePath)) {
                return;
            }
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
                'type' => gettype($filePath),
            ]);
            return;
        }
        
        // Skip if it's a URL (already uploaded and in media collection)
        if (filter_var($filePath, FILTER_VALIDATE_URL)) {
            return;
        }
        
        // Clear existing media in collection
        $settings->clearMediaCollection($collection);
        
        $added = false;
        $lastError = null;
        
        // First, try using Storage disk (most reliable for Filament uploads)
        // Filament stores files relative to the public disk root
        if (Storage::disk('public')->exists($filePath)) {
            try {
                $settings->addMediaFromDisk($filePath, 'public')
                    ->toMediaCollection($collection);
                $added = true;
            } catch (\Exception $e) {
                $lastError = $e->getMessage();
                \Log::error("handleMediaUpload: Failed to add media from disk", [
                    'filePath' => $filePath,
                    'collection' => $collection,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        
        // Handle Livewire temporary files (if not already added)
        if (!$added && str_starts_with($filePath, 'livewire-tmp/')) {
            $fullPath = storage_path('app/public/' . $filePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                try {
                    $settings->addMedia($fullPath)
                        ->toMediaCollection($collection);
                    $added = true;
                } catch (\Exception $e) {
                    $lastError = $e->getMessage();
                    \Log::error("handleMediaUpload: Failed to add media from livewire-tmp", [
                        'fullPath' => $fullPath,
                        'collection' => $collection,
                        'error' => $e->getMessage(),
                    ]);
                }
            } elseif (Storage::disk('public')->exists($filePath)) {
                try {
                    $settings->addMediaFromDisk($filePath, 'public')
                        ->toMediaCollection($collection);
                    $added = true;
                } catch (\Exception $e) {
                    $lastError = $e->getMessage();
                    \Log::error("handleMediaUpload: Failed to add media from livewire-tmp disk", [
                        'filePath' => $filePath,
                        'collection' => $collection,
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
                        $settings->addMedia($path)
                            ->toMediaCollection($collection);
                        $added = true;
                        break;
                    } catch (\Exception $e) {
                        $lastError = $e->getMessage();
                        continue;
                    }
                }
            }
        }
        
        // Final verification and trigger WebP conversion
        if ($added) {
            $hasMedia = $settings->hasMedia($collection);
            
            if ($hasMedia) {
                // Get the media and ensure WebP conversion is generated
                $media = $settings->getFirstMedia($collection);
                if ($media && !$media->hasGeneratedConversion('webp')) {
                    try {
                        $media->performConversions(['webp']);
                    } catch (\Exception $e) {
                        // Conversion will happen asynchronously, which is fine
                    }
                }
            } else {
                \Log::error("handleMediaUpload: Media was added but verification failed!", [
                    'collection' => $collection,
                    'filePath' => $filePath,
                ]);
            }
        } elseif ($lastError) {
            \Log::error("handleMediaUpload: Failed to add media to collection", [
                'collection' => $collection,
                'filePath' => $filePath,
                'error' => $lastError,
            ]);
        }
    }

    protected function handleAdvisorsMedia($settings, $advisorsData): bool
    {
        if (!is_array($advisorsData) || empty($advisorsData)) {
            return false;
        }

        $hasNewImages = false;

        // Process each advisor's profile image
        foreach ($advisorsData as $advisor) {
            if (isset($advisor['profile_image']) && $advisor['profile_image']) {
                $filePath = $advisor['profile_image'];
                
                // Handle array of file paths
                if (is_array($filePath)) {
                    if (empty($filePath)) {
                        continue;
                    }
                    $filePath = !empty($filePath[0]) ? $filePath[0] : reset($filePath);
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
                            $hasNewImages = true;
                        } catch (\Exception $e) {
                            \Log::warning("handleAdvisorsMedia: Failed to add advisor image", [
                                'filePath' => $filePath,
                                'error' => $e->getMessage(),
                            ]);
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
                                $hasNewImages = true;
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
                        $hasNewImages = true;
                    } catch (\Exception $e) {
                        \Log::warning("handleAdvisorsMedia: Failed to add advisor image from disk", [
                            'filePath' => $filePath,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }
        }
        
        return $hasNewImages;
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