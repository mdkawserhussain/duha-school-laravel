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

class Event extends Model implements HasMedia
{
    use HasFactory, Searchable, InteractsWithMedia, HasWebPMedia;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug) && !empty($event->title)) {
                $event->slug = static::generateUniqueSlug($event->title);
            }
        });

        static::updating(function ($event) {
            // Only regenerate slug if title changed and slug is empty
            if ($event->isDirty('title') && empty($event->slug)) {
                $event->slug = static::generateUniqueSlug($event->title);
            }
        });
    }

    protected static function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

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
        'description',
        'content',
        'event_date',
        'start_at',
        'end_at',
        'location',
        'category',
        'is_featured',
        'status',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

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
            ->nonQueued(); // Process immediately

        // Responsive conversions
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
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'description' => $this->description,
            'location' => $this->location,
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

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getIsUpcomingAttribute()
    {
        return $this->event_date->isFuture();
    }

    public function getIsPastAttribute()
    {
        return $this->event_date->isPast();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
