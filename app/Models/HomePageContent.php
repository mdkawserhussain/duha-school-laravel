<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HomePageContent extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'home_page_contents';

    /**
     * Prevent saving without required fields
     */
    protected static function booted(): void
    {
        static::creating(function ($content) {
            if (empty($content->section_key) || empty($content->section_type)) {
                // Log the stack trace to identify where this is being called from
                \Log::error('Attempted to create HomePageContent without required fields', [
                    'section_key' => $content->section_key ?? 'null',
                    'section_type' => $content->section_type ?? 'null',
                    'attributes' => $content->getAttributes(),
                    'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10)
                ]);
                throw new \Exception('Cannot create HomePageContent without section_key and section_type. Check logs for details.');
            }
        });
    }

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
        $this->addMediaCollection('background_image')->singleFile();
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

    public function scopeByType($query, string $type)
    {
        return $query->where('section_type', $type);
    }
}
