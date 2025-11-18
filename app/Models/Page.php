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

class Page extends Model implements HasMedia
{
    use HasFactory, Searchable, InteractsWithMedia, HasWebPMedia;

    protected $fillable = [
        'title',
        'slug',
        'hero_badge',
        'hero_subtitle',
        'content',
        'meta_title',
        'meta_description',
        'seo_keywords',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'seo_keywords' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug) && !empty($page->title)) {
                $page->slug = static::generateUniqueSlug($page->title);
            }
        });

        static::updating(function ($page) {
            // Regenerate slug if title changed and slug is empty or null
            if ($page->isDirty('title') && (empty($page->slug) || is_null($page->slug))) {
                $page->slug = static::generateUniqueSlug($page->title);
            }
        });

        static::saving(function ($page) {
            // Ensure slug is always set when saving (fallback for any missed cases)
            if (empty($page->slug) && !empty($page->title)) {
                $page->slug = static::generateUniqueSlug($page->title);
            }
        });
    }

    protected static function generateUniqueSlug(string $title): string
    {
        // Normalize title: trim and ensure it's not empty
        $title = trim($title);
        if (empty($title)) {
            $title = 'page-' . time();
        }
        
        // Generate slug from title
        $slug = Str::slug($title);
        
        // Handle edge case: if slug is empty (e.g., only special characters), generate fallback
        if (empty($slug)) {
            $slug = 'page-' . time();
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')->singleFile();
        $this->addMediaCollection('hero_image')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // Default WebP conversion - converts original file to WebP
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(90)
            ->performOnCollections('featured_image', 'hero_image', 'gallery')
            ->nonQueued(); // Process immediately

        // Responsive conversions
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->format('webp')
            ->quality(85)
            ->performOnCollections('featured_image', 'hero_image', 'gallery');

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(400)
            ->sharpen(10)
            ->format('webp')
            ->quality(85)
            ->performOnCollections('featured_image', 'hero_image', 'gallery');

        // Large conversion for hero images
        $this->addMediaConversion('large')
            ->width(1920)
            ->height(1080)
            ->format('webp')
            ->quality(90)
            ->performOnCollections('hero_image')
            ->nonQueued();
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'meta_description' => $this->meta_description,
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

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
