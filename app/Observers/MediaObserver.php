<?php

namespace App\Observers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MediaObserver
{
    /**
     * Handle the Media "created" event.
     * Delete original image after WebP conversions are generated.
     */
    public function created(Media $media): void
    {
        // Only process image files
        if (!str_starts_with($media->mime_type ?? '', 'image/')) {
            return;
        }
        
        // Skip if already WebP
        if ($media->mime_type === 'image/webp' || str_ends_with(strtolower($media->file_name), '.webp')) {
            return;
        }
        
        // Schedule deletion after conversions are generated
        // Use a delay to ensure conversions are complete
        dispatch(function () use ($media) {
            $this->deleteOriginalIfWebPExists($media);
        })->delay(now()->addSeconds(15));
    }
    
    /**
     * Delete original file if WebP conversions exist
     */
    protected function deleteOriginalIfWebPExists(Media $media): void
    {
        try {
            // Refresh media to get latest conversion status
            $media->refresh();
            
            // Check if any WebP conversion exists
            $conversions = ['webp', 'thumb', 'medium'];
            $hasWebPConversion = false;
            
            foreach ($conversions as $conversion) {
                try {
                    $conversionPath = $media->getPath($conversion);
                    if (file_exists($conversionPath)) {
                        $hasWebPConversion = true;
                        break;
                    }
                } catch (\Exception $e) {
                    // Conversion might not exist, continue
                    continue;
                }
            }
            
            // If WebP conversion exists, delete the original
            if ($hasWebPConversion) {
                $originalPath = $media->getPath();
                
                if (file_exists($originalPath) && is_file($originalPath)) {
                    // Delete the original file from disk
                    Storage::disk($media->disk)->delete($media->getPath());
                    Log::info("Deleted original image after WebP conversion: {$media->file_name} (Media ID: {$media->id})");
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to delete original image after WebP conversion (Media ID: {$media->id}): " . $e->getMessage());
        }
    }

    /**
     * Handle the Media "updated" event.
     */
    public function updated(Media $media): void
    {
        //
    }

    /**
     * Handle the Media "deleted" event.
     */
    public function deleted(Media $media): void
    {
        //
    }

    /**
     * Handle the Media "restored" event.
     */
    public function restored(Media $media): void
    {
        //
    }

    /**
     * Handle the Media "force deleted" event.
     */
    public function forceDeleted(Media $media): void
    {
        //
    }
}
