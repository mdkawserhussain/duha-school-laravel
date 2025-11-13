<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HomePageSection extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'home_page_sections';

    protected $fillable = [
        'section_key',
        'section_type',
        'title',
        'subtitle',
        'content',
        'description',
        'button_text',
        'button_link',
        'data',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
        $this->addMediaCollection('videos');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->format('webp')
            ->quality(85);

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(400)
            ->sharpen(10)
            ->format('webp')
            ->quality(85);

        $this->addMediaConversion('large')
            ->width(1920)
            ->height(1080)
            ->format('webp')
            ->quality(90)
            ->nonQueued();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeByKey($query, string $key)
    {
        return $query->where('section_key', $key);
    }

    /**
     * Get media URL with proper path handling and conversion support.
     * Returns relative paths that work with any domain/port.
     *
     * @param string $collectionName
     * @param string|null $conversionName
     * @return string|null
     */
    public function getMediaUrl(string $collectionName = 'images', ?string $conversionName = null): ?string
    {
        $media = $this->getFirstMedia($collectionName);
        
        if (!$media) {
            return null;
        }

        // Use asset() for proper URL generation with cache busting
        // This ensures URLs work regardless of APP_URL or domain/port
        $basePath = 'storage/' . $media->id;
        
        if ($conversionName) {
            // Check if conversion exists on disk
            $conversionPath = $media->getPath($conversionName);
            if ($conversionPath && file_exists($conversionPath)) {
                // Get the actual conversion file name
                $conversionFileName = basename($conversionPath);
                // Return path for asset() helper
                return $basePath . '/conversions/' . $conversionFileName;
            }
            // Fallback to original if conversion doesn't exist
            return $basePath . '/' . $media->file_name;
        }

        return $basePath . '/' . $media->file_name;
    }

    /**
     * Boot the model and add event listeners for cache clearing.
     */
    protected static function booted(): void
    {
        // Clear cache when sort_order changes (drag-and-drop reordering)
        static::updating(function ($section) {
            if ($section->isDirty('sort_order')) {
                Cache::forget('homepage_v2_data');
            }
        });
    }
}
