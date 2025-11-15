<?php

namespace App\Observers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MediaObserver
{
    /**
     * Handle the Media "updated" event.
     * This fires after conversions are generated.
     */
    public function updated(Media $media): void
    {
        // Check if generated_conversions field was just updated (conversions completed)
        if (!$media->wasChanged('generated_conversions')) {
            return;
        }

        // Get generated conversions (returns Collection, convert to array)
        $generatedConversions = $media->getGeneratedConversions();
        
        if ($generatedConversions->isEmpty()) {
            return;
        }

        // Check if any WebP conversion exists by examining the model's conversion definitions
        $hasWebPConversion = $this->hasWebPConversions($media, $generatedConversions->toArray());

        // If WebP conversions exist and original is not WebP, delete original
        if ($hasWebPConversion && $this->shouldDeleteOriginal($media)) {
            $this->deleteOriginalFile($media);
        }
    }

    /**
     * Check if the media has WebP conversions defined and generated.
     */
    protected function hasWebPConversions(Media $media, array $generatedConversions): bool
    {
        $model = $media->model;
        
        if (!$model || !method_exists($model, 'registerMediaConversions')) {
            return false;
        }

        // Check each generated conversion
        foreach ($generatedConversions as $conversionName => $generated) {
            if (!$generated) {
                continue;
            }

            // Get the conversion definition from the model
            try {
                $mediaLibrary = app(\Spatie\MediaLibrary\MediaCollections\Filesystem::class);
                $conversions = $model->getMediaConversions();
                
                if (isset($conversions[$conversionName])) {
                    $conversion = $conversions[$conversionName];
                    
                    // Check if conversion uses WebP format
                    // Spatie stores manipulations as JSON, check for format: 'webp'
                    $manipulations = $conversion->getManipulations();
                    if (isset($manipulations['format']) && strtolower($manipulations['format']) === 'webp') {
                        return true;
                    }
                }
            } catch (\Exception $e) {
                // If we can't check, assume WebP if conversion names suggest it
                if (str_contains(strtolower($conversionName), 'webp')) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if the original file should be deleted.
     */
    protected function shouldDeleteOriginal(Media $media): bool
    {
        $mimeType = $media->mime_type ?? '';
        $fileName = $media->file_name ?? '';
        
        // Don't delete if already WebP
        if (str_contains($mimeType, 'webp') || str_ends_with(strtolower($fileName), '.webp')) {
            return false;
        }

        // Only delete image files (not PDFs, documents, etc.)
        $imageMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/bmp'];
        if (!in_array(strtolower($mimeType), $imageMimeTypes)) {
            return false;
        }

        return true;
    }

    /**
     * Delete the original file from storage.
     */
    protected function deleteOriginalFile(Media $media): void
    {
        try {
            $disk = $media->disk ?? 'public';
            $path = $media->getPath();

            if ($path && Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
                Log::info("Deleted original image after WebP conversion", [
                    'media_id' => $media->id,
                    'file_name' => $media->file_name,
                    'path' => $path,
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Failed to delete original image after WebP conversion", [
                'media_id' => $media->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
