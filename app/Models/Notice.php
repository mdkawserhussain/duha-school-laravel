<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Traits\HasWebPMedia;

class Notice extends Model implements HasMedia
{
    use HasFactory, Searchable, InteractsWithMedia, HasWebPMedia;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($notice) {
            if (empty($notice->slug) && !empty($notice->title)) {
                $notice->slug = static::generateUniqueSlug($notice->title);
            }
        });

        static::updating(function ($notice) {
            // Regenerate slug if title changed and slug is empty or null
            if ($notice->isDirty('title') && (empty($notice->slug) || is_null($notice->slug))) {
                $notice->slug = static::generateUniqueSlug($notice->title);
            }
        });

        static::saving(function ($notice) {
            // Ensure slug is always set when saving (fallback for any missed cases)
            if (empty($notice->slug) && !empty($notice->title)) {
                $notice->slug = static::generateUniqueSlug($notice->title);
            }
        });
    }

    protected static function generateUniqueSlug(string $title): string
    {
        // Normalize title: trim and ensure it's not empty
        $title = trim($title);
        if (empty($title)) {
            $title = 'notice-' . time();
        }
        
        // Generate slug from title
        $slug = Str::slug($title);
        
        // Handle edge case: if slug is empty (e.g., only special characters), generate fallback
        if (empty($slug)) {
            $slug = 'notice-' . time();
        }
        
        $originalSlug = $slug;
        $counter = 1;

        // Ensure slug is unique
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'is_important',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_important' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'category' => $this->category,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }

    public function shouldBeSearchable()
    {
        return $this->is_published && $this->published_at && $this->published_at <= now();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // Default WebP conversion - converts original file to WebP
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(90)
            ->performOnCollections('featured_image', 'gallery')
            ->nonQueued(); // Process immediately

        // Responsive conversions
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->format('webp')
            ->quality(85)
            ->performOnCollections('featured_image', 'gallery');

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(400)
            ->sharpen(10)
            ->format('webp')
            ->quality(85)
            ->performOnCollections('featured_image', 'gallery');

        // Large conversion for featured images
        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->format('webp')
            ->quality(90)
            ->performOnCollections('featured_image')
            ->nonQueued();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
