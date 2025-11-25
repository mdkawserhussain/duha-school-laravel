<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasWebPMedia
{
    /**
     * Extract relative web path from absolute file system path.
     * Converts storage/app/public paths to storage/ relative paths for asset().
     * 
     * @param string $absolutePath
     * @return string|null
     */
    protected function extractRelativePath(string $absolutePath): ?string
    {
        if (empty($absolutePath)) {
            return null;
        }

        // Normalize path separators
        $absolutePath = str_replace('\\', '/', $absolutePath);
        
        // Get the storage/app/public base path
        $storagePublicPath = storage_path('app/public');
        $storagePublicPath = str_replace('\\', '/', $storagePublicPath);
        
        // Check if path is within storage/app/public
        if (str_contains($absolutePath, $storagePublicPath)) {
            // Extract the relative portion after storage/app/public
            $relativePath = substr($absolutePath, strlen($storagePublicPath));
            // Remove leading slash and prepend 'storage/'
            $relativePath = 'storage/' . ltrim($relativePath, '/');
            return $relativePath;
        }
        
        return null;
    }

    /**
     * Get media URL using relative path extraction and asset().
     * Works regardless of APP_URL configuration.
     * 
     * @param string $collectionName
     * @param string|null $conversion
     * @return string|null
     */
    public function getMediaUrlRelative(string $collectionName, ?string $conversion = null): ?string
    {
        if (!$this->hasMedia($collectionName)) {
            return null;
        }

        $media = $this->getFirstMedia($collectionName);
        if (!$media) {
            return null;
        }

        // Try to get the requested conversion first
        if ($conversion && $media->hasGeneratedConversion($conversion)) {
            $conversionPath = $media->getPath($conversion);
            if ($conversionPath) {
                $relativePath = $this->extractRelativePath($conversionPath);
                if ($relativePath) {
                    return asset($relativePath);
                }
            }
        }

        // Try WebP conversion if available
        if ($media->hasGeneratedConversion('webp')) {
            $webpPath = $media->getPath('webp');
            if ($webpPath) {
                $relativePath = $this->extractRelativePath($webpPath);
                if ($relativePath) {
                    return asset($relativePath);
                }
            }
        }

        // Fallback to original
        $originalPath = $media->getPath();
        if ($originalPath) {
            $relativePath = $this->extractRelativePath($originalPath);
            if ($relativePath) {
                return asset($relativePath);
            }
            
            // Last resort: construct from media attributes
            $fileName = $media->file_name ?? '';
            if ($fileName) {
                if ($conversion) {
                    // For conversions, use the conversion name as the file extension
                    $fileBaseName = pathinfo($fileName, PATHINFO_FILENAME);
                    $relativePath = 'storage/' . $media->id . '/conversions/' . $fileBaseName . '-' . $conversion . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                } else {
                    $relativePath = 'storage/' . $media->id . '/' . $fileName;
                }
                return asset($relativePath);
            }
        }

        return null;
    }

    /**
     * Get WebP media URL with fallback to original.
     * Uses relative path extraction for consistent URL generation.
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
                $relativePath = $this->extractRelativePath($webpPath);
                if ($relativePath) {
                    return asset($relativePath);
                }
            }
        }

        // Fallback to requested conversion or original
        if ($conversion && $media->hasGeneratedConversion($conversion)) {
            $conversionPath = $media->getPath($conversion);
            if ($conversionPath) {
                $relativePath = $this->extractRelativePath($conversionPath);
                if ($relativePath) {
                    return asset($relativePath);
                }
            }
        }

        // Fallback to original
        $originalPath = $media->getPath();
        if ($originalPath) {
            $relativePath = $this->extractRelativePath($originalPath);
            if ($relativePath) {
                return asset($relativePath);
            }
            
            // Last resort: construct from media attributes
            $fileName = $media->file_name ?? '';
            if ($fileName) {
                $relativePath = 'storage/' . $media->id . '/' . $fileName;
                return asset($relativePath);
            }
        }

        return null;
    }

    /**
     * Get WebP media URL for use in <picture> tag with fallback.
     * Returns array with 'webp' and 'fallback' URLs.
     * Uses relative path extraction for consistent URL generation.
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
                $relativePath = $this->extractRelativePath($fallbackPath);
                if ($relativePath) {
                    $fallbackUrl = asset($relativePath);
                } else {
                    // Last resort: construct from media attributes
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

    /**
     * Get media URL - convenience method that uses getMediaUrlRelative.
     * This method provides a consistent API across models.
     * 
     * @param string $collectionName
     * @param string|null $conversion
     * @return string|null
     */
    public function getMediaUrl(string $collectionName = 'images', ?string $conversionName = null): ?string
    {
        return $this->getMediaUrlRelative($collectionName, $conversionName);
    }
}

