<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SiteSettings extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'site_name',
        'site_description',
        'contact_email',
        'contact_phone',
        'address',
    ];

    /**
     * Resolve the current site settings record.
     * Uses the most recently updated record to avoid issues when multiple rows exist.
     */
    public static function current(): ?self
    {
        return static::query()->orderByDesc('updated_at')->first();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
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

    /**
     * Get the logo URL with a robust fallback.
     */
    public static function getLogoUrl(?string $conversion = null): string
    {
        $settings = static::current();

        if ($settings && $settings->hasMedia('logo')) {
            $url = $settings->getFirstMediaUrl('logo', $conversion ?? '');
            if ($url) {
                return $url;
            }
        }

        // Fallback placeholder to avoid broken image if no local asset exists.
        return 'https://via.placeholder.com/200x60?text=School+Logo';
    }
}
