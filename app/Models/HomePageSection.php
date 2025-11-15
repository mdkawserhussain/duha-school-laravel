<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Traits\HasWebPMedia;

class HomePageSection extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasWebPMedia;

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
        $this->addMediaCollection('video_poster')->singleFile();
        $this->addMediaCollection('background_image')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // Default WebP conversion - converts original file to WebP
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(90)
            ->performOnCollections('images', 'background_image', 'video_poster')
            ->nonQueued(); // Process immediately

        // Responsive conversions
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->format('webp')
            ->quality(85)
            ->performOnCollections('images', 'background_image', 'video_poster');

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(400)
            ->sharpen(10)
            ->format('webp')
            ->quality(85)
            ->performOnCollections('images', 'background_image', 'video_poster');

        $this->addMediaConversion('large')
            ->width(1920)
            ->height(1080)
            ->format('webp')
            ->quality(90)
            ->performOnCollections('images', 'background_image')
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
     * Uses Spatie's built-in method to return full URLs.
     *
     * @param string $collectionName
     * @param string|null $conversionName
     * @return string|null
     */
    public function getMediaUrl(string $collectionName = 'images', ?string $conversionName = null): ?string
    {
        if (!$this->hasMedia($collectionName)) {
            return null;
        }

        // Use Spatie's built-in method which returns proper full URLs
        // This handles conversions, path generation, and URL formatting correctly
        // Empty string means no conversion, null is converted to empty string
        $conversion = $conversionName ?? '';
        return $this->getFirstMediaUrl($collectionName, $conversion);
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
