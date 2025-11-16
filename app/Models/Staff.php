<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Traits\HasWebPMedia;

class Staff extends Model implements HasMedia
{
    use HasFactory, Searchable, InteractsWithMedia, HasWebPMedia;

    protected $fillable = [
        'name',
        'position',
        'role_title', // Alias for position (for Filament compatibility)
        'bio',
        'email',
        'phone',
        'is_active',
        'sort_order',
        'order', // Alias for sort_order (for Filament compatibility)
        'social_links', // JSON field for social media links
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'social_links' => 'array',
    ];

    // Accessor for role_title (Filament compatibility)
    public function getRoleTitleAttribute()
    {
        return $this->position;
    }

    // Mutator for role_title (Filament compatibility)
    public function setRoleTitleAttribute($value)
    {
        $this->attributes['position'] = $value;
    }

    // Accessor for order (Filament compatibility)
    public function getOrderAttribute()
    {
        return $this->sort_order;
    }

    // Mutator for order (Filament compatibility)
    public function setOrderAttribute($value)
    {
        $this->attributes['sort_order'] = $value;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
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
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->format('webp')
            ->quality(85);

        $this->addMediaConversion('medium')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->format('webp')
            ->quality(85);
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'position' => $this->position,
            'bio' => $this->bio,
            'is_active' => $this->is_active,
        ];
    }

    public function shouldBeSearchable()
    {
        return $this->is_active;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
