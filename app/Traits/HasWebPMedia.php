<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasWebPMedia
{
    /**
     * Get WebP media URL with fallback to original.
     * 
     * @param string $collectionName
     * @param string|null $conversion
     * @return string|null
     */
    public function getWebPMediaUrl(string $collectionName, ?string $conversion = null): ?string
    {
        if (!$this->hasMedia($collectionName)) {
            return null;
        }

        $media = $this->getFirstMedia($collectionName);
        if (!$media) {
            return null;
        }

        // Try WebP conversion first
        if ($media->hasGeneratedConversion('webp')) {
            $webpPath = $media->getPath('webp');
            if ($webpPath) {
                // Extract relative path
                if (str_contains($webpPath, 'storage/app/public/')) {
                    $relativePath = 'storage/' . substr($webpPath, strpos($webpPath, 'storage/app/public/') + strlen('storage/app/public/'));
                    return asset($relativePath);
                } else {
                    // Construct from media attributes
                    $fileName = $media->file_name ?? '';
                    if ($fileName) {
                        $relativePath = 'storage/' . $media->id . '/conversions/' . pathinfo($fileName, PATHINFO_FILENAME) . '.webp';
                        return asset($relativePath);
                    }
                }
            }
        }

        // Fallback to requested conversion or original
        if ($conversion && $media->hasGeneratedConversion($conversion)) {
            $conversionPath = $media->getPath($conversion);
            if ($conversionPath) {
                if (str_contains($conversionPath, 'storage/app/public/')) {
                    $relativePath = 'storage/' . substr($conversionPath, strpos($conversionPath, 'storage/app/public/') + strlen('storage/app/public/'));
                    return asset($relativePath);
                }
            }
        }

        // Fallback to original
        $originalPath = $media->getPath();
        if ($originalPath) {
            if (str_contains($originalPath, 'storage/app/public/')) {
                $relativePath = 'storage/' . substr($originalPath, strpos($originalPath, 'storage/app/public/') + strlen('storage/app/public/'));
                return asset($relativePath);
            } else {
                $fileName = $media->file_name ?? '';
                if ($fileName) {
                    $relativePath = 'storage/' . $media->id . '/' . $fileName;
                    return asset($relativePath);
                }
            }
        }

        return null;
    }

    /**
     * Get WebP media URL for use in <picture> tag with fallback.
     * Returns array with 'webp' and 'fallback' URLs.
     * 
     * @param string $collectionName
     * @param string|null $conversion
     * @return array{webp: string|null, fallback: string|null}
     */
    public function getWebPMediaUrls(string $collectionName, ?string $conversion = null): array
    {
        $webpUrl = $this->getWebPMediaUrl($collectionName, $conversion);
        $fallbackUrl = null;

        if (!$this->hasMedia($collectionName)) {
            return ['webp' => null, 'fallback' => null];
        }

        $media = $this->getFirstMedia($collectionName);
        if ($media) {
            // Get fallback (original or conversion)
            if ($conversion && $media->hasGeneratedConversion($conversion)) {
                $fallbackPath = $media->getPath($conversion);
            } else {
                $fallbackPath = $media->getPath();
            }

            if ($fallbackPath) {
                if (str_contains($fallbackPath, 'storage/app/public/')) {
                    $relativePath = 'storage/' . substr($fallbackPath, strpos($fallbackPath, 'storage/app/public/') + strlen('storage/app/public/'));
                    $fallbackUrl = asset($relativePath);
                } else {
                    $fileName = $media->file_name ?? '';
                    if ($fileName) {
                        $relativePath = 'storage/' . $media->id . '/' . $fileName;
                        $fallbackUrl = asset($relativePath);
                    }
                }
            }
        }

        return [
            'webp' => $webpUrl,
            'fallback' => $fallbackUrl ?: $webpUrl, // Use WebP as fallback if no original
        ];
    }
}

