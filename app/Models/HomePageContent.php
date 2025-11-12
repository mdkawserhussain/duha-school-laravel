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
