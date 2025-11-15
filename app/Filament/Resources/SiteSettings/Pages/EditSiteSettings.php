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

    protected function afterSave(): void
    {
        $settings = $this->record;
        
        // Get file paths from form raw state if not already stored
        $formState = $this->form->getRawState();
        
        // Handle logo upload
        $this->handleMediaUpload($settings, $this->logoPath ?? $formState['logo'] ?? null, 'logo');
        
        // Handle favicon upload
        $this->handleMediaUpload($settings, $this->faviconPath ?? $formState['favicon'] ?? null, 'favicon');
        
        // Handle OG image upload
        $this->handleMediaUpload($settings, $this->ogImagePath ?? $formState['og_image'] ?? null, 'og_image');
        
        // Clear cache after saving
        SiteSettings::clearCache();

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->body('Site settings have been updated and cache has been cleared.')
            ->send();
    }

    protected function handleMediaUpload($settings, $filePath, string $collection): void
    {
        if (!$filePath) {
            return;
        }
        
        // Handle array of file paths
        if (is_array($filePath)) {
            $filePath = !empty($filePath[0]) ? $filePath[0] : null;
        }
        
        if (!$filePath || !is_string($filePath)) {
            return;
        }
        
        // Skip if it's a URL (already uploaded)
        if (filter_var($filePath, FILTER_VALIDATE_URL)) {
            return;
        }
        
        // Clear existing media in collection
        $settings->clearMediaCollection($collection);
        
        $added = false;
        
        // Handle Livewire temporary files
        if (str_starts_with($filePath, 'livewire-tmp/')) {
            if (Storage::disk('public')->exists($filePath)) {
                try {
                    $settings->addMediaFromDisk($filePath, 'public')
                        ->toMediaCollection($collection);
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
                            ->toMediaCollection($collection);
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
                    ->toMediaCollection($collection);
                $added = true;
            } catch (\Exception $e) {
                // Log error but don't fail
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
