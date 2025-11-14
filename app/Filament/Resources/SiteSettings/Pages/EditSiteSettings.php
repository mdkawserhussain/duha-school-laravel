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
        
        // Get logo from form raw state (FileUpload stores it here when dehydrated=false)
        try {
            $formState = $this->form->getRawState();
            $logo = $formState['logo'] ?? null;
            
            // Also check stored filename
            if (!$logo) {
                $logo = $formState['logo_filename'] ?? null;
            }
            
            // Handle logo upload
            if ($logo) {
                // Clear existing logo
                $settings->clearMediaCollection('logo');
                
                // Handle array of file paths
                if (is_array($logo)) {
                    $logo = !empty($logo[0]) ? $logo[0] : null;
                }
                
                if ($logo && is_string($logo) && !filter_var($logo, FILTER_VALIDATE_URL)) {
                    $added = false;
                    
                    // Try different path formats
                    $possiblePaths = [];
                    
                    // Livewire temporary files
                    if (str_starts_with($logo, 'livewire-tmp/')) {
                        $possiblePaths[] = storage_path('app/public/' . $logo);
                        $possiblePaths[] = $logo;
                    } 
                    // Files in logos directory
                    else {
                        if (str_starts_with($logo, 'logos/')) {
                            $possiblePaths[] = storage_path('app/public/' . $logo);
                            $possiblePaths[] = $logo;
                        } else {
                            $possiblePaths[] = storage_path('app/public/logos/' . $logo);
                            $possiblePaths[] = storage_path('app/public/' . $logo);
                            $possiblePaths[] = 'logos/' . $logo;
                            $possiblePaths[] = $logo;
                        }
                    }
                    
                    // Try each path
                    foreach ($possiblePaths as $testPath) {
                        // Try direct file path
                        if (is_string($testPath) && file_exists($testPath) && is_file($testPath)) {
                            try {
                                $settings->addMedia($testPath)->toMediaCollection('logo');
                                $added = true;
                                \Log::info('Successfully added logo from: ' . $testPath);
                                break;
                            } catch (\Exception $e) {
                                \Log::debug('Failed to add media from path: ' . $testPath . ' - ' . $e->getMessage());
                            }
                        }
                        
                        // Try Storage disk
                        if (!$added && is_string($testPath) && Storage::disk('public')->exists($testPath)) {
                            try {
                                $settings->addMediaFromDisk($testPath, 'public')->toMediaCollection('logo');
                                $added = true;
                                \Log::info('Successfully added logo from disk: ' . $testPath);
                                break;
                            } catch (\Exception $e) {
                                \Log::debug('Failed to add media from disk: ' . $testPath . ' - ' . $e->getMessage());
                            }
                        }
                    }
                    
                    if (!$added) {
                        \Log::warning('Logo file not found. Attempted paths: ' . implode(', ', $possiblePaths));
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error handling logo upload: ' . $e->getMessage());
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
