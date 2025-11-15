<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SiteSettings extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        // Website Information
        'website_name',
        'website_tagline',
        'website_description',
        'site_name', // Keep for backward compatibility
        'site_description', // Keep for backward compatibility
        
        // Logo and Favicon
        'logo_path',
        'favicon_path',
        
        // Contact Information
        'primary_email',
        'secondary_email',
        'primary_phone',
        'secondary_phone',
        'physical_address',
        'business_hours',
        'contact_email', // Keep for backward compatibility
        'contact_phone', // Keep for backward compatibility
        'address', // Keep for backward compatibility
        
        // Social Media Links
        'social_media_links',
        
        // Localization
        'default_currency',
        'default_language',
        'supported_languages',
        'timezone',
        
        // SEO Settings
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        
        // Maintenance Mode
        'maintenance_mode',
        'maintenance_message',
        'maintenance_scheduled_at',
        'maintenance_scheduled_until',
        
        // Additional Settings
        'footer_text',
        'copyright_notice',
        'primary_color',
        'secondary_color',
        'accent_color',
        'google_analytics_id',
        'custom_css',
        'custom_js',
        'email_notification_preferences',
        'advisors',
    ];

    protected $casts = [
        'social_media_links' => 'array',
        'supported_languages' => 'array',
        'email_notification_preferences' => 'array',
        'advisors' => 'array',
        'maintenance_mode' => 'boolean',
        'maintenance_scheduled_at' => 'datetime',
        'maintenance_scheduled_until' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();
        
        // Clear cache on save/update/delete
        static::saved(function () {
            static::clearCache();
        });
        
        static::deleted(function () {
            static::clearCache();
        });
    }

    /**
     * Get or create singleton instance (cached for 1 hour).
     */
    public static function getSettings(): self
    {
        return Cache::remember('site_settings', 3600, function () {
            return static::firstOrCreate([], [
                'website_name' => 'Duha International School',
                'default_currency' => 'USD',
                'default_language' => 'en',
                'timezone' => 'UTC',
                'primary_color' => '#0F4C81',
                'secondary_color' => '#1E3A8A',
                'accent_color' => '#F4C430',
            ]);
        });
    }

    /**
     * Clear the settings cache.
     */
    public static function clearCache(): void
    {
        Cache::forget('site_settings');
    }

    /**
     * Resolve the current site settings record (backward compatibility).
     * Uses singleton pattern.
     */
    public static function current(): ?self
    {
        return static::getSettings();
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('favicon')->singleFile();
        $this->addMediaCollection('og_image')->singleFile();
        $this->addMediaCollection('advisors');
    }

    /**
     * Register media conversions.
     */
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

        // Advisor profile image conversion
        $this->addMediaConversion('advisor')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->format('webp')
            ->quality(85);
    }

    /**
     * Get the logo URL with fallback.
     * Uses relative paths with asset() for better compatibility.
     */
    public static function getLogoUrl(?string $conversion = null): string
    {
        $settings = static::getSettings();

        if ($settings && $settings->hasMedia('logo')) {
            $media = $settings->getFirstMedia('logo');
            if ($media) {
                // Use relative path with asset() instead of getFirstMediaUrl()
                $mediaPath = $media->getPath();
                
                // Extract relative path from storage/app/public
                if ($mediaPath && str_contains($mediaPath, 'storage/app/public/')) {
                    $relativePath = 'storage/' . substr($mediaPath, strpos($mediaPath, 'storage/app/public/') + strlen('storage/app/public/'));
                    return asset($relativePath);
                } else {
                    // Fallback: construct from media attributes
                    $fileName = $media->file_name ?? '';
                    if ($fileName) {
                        $relativePath = 'storage/' . $media->id . '/' . $fileName;
                        return asset($relativePath);
                    }
                }
            }
        }

        return asset('images/logo.svg');
    }

    /**
     * Accessor: Get logo URL.
     * Uses relative paths with asset() for better compatibility.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if ($this->hasMedia('logo')) {
            $media = $this->getFirstMedia('logo');
            if ($media) {
                // Use relative path with asset() instead of getFirstMediaUrl()
                $mediaPath = $media->getPath();
                
                // Extract relative path from storage/app/public
                if ($mediaPath && str_contains($mediaPath, 'storage/app/public/')) {
                    $relativePath = 'storage/' . substr($mediaPath, strpos($mediaPath, 'storage/app/public/') + strlen('storage/app/public/'));
                    return asset($relativePath);
                } else {
                    // Fallback: construct from media attributes
                    $fileName = $media->file_name ?? '';
                    if ($fileName) {
                        $relativePath = 'storage/' . $media->id . '/' . $fileName;
                        return asset($relativePath);
                    }
                }
            }
        }
        
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            // Use asset() for relative paths
            if (str_starts_with($this->logo_path, 'storage/') || str_starts_with($this->logo_path, '/storage/')) {
                return asset($this->logo_path);
            } else {
                return asset('storage/' . ltrim($this->logo_path, '/'));
            }
        }
        
        return null;
    }

    /**
     * Accessor: Get favicon URL.
     * Uses relative paths with asset() for better compatibility.
     */
    public function getFaviconUrlAttribute(): ?string
    {
        if ($this->hasMedia('favicon')) {
            $media = $this->getFirstMedia('favicon');
            if ($media) {
                $mediaPath = $media->getPath();
                if ($mediaPath && str_contains($mediaPath, 'storage/app/public/')) {
                    $relativePath = 'storage/' . substr($mediaPath, strpos($mediaPath, 'storage/app/public/') + strlen('storage/app/public/'));
                    return asset($relativePath);
                } else {
                    $fileName = $media->file_name ?? '';
                    if ($fileName) {
                        $relativePath = 'storage/' . $media->id . '/' . $fileName;
                        return asset($relativePath);
                    }
                }
            }
        }
        
        if ($this->favicon_path && Storage::disk('public')->exists($this->favicon_path)) {
            if (str_starts_with($this->favicon_path, 'storage/') || str_starts_with($this->favicon_path, '/storage/')) {
                return asset($this->favicon_path);
            } else {
                return asset('storage/' . ltrim($this->favicon_path, '/'));
            }
        }
        
        return null;
    }

    /**
     * Accessor: Get OG image URL.
     * Uses relative paths with asset() for better compatibility.
     */
    public function getOgImageUrlAttribute(): ?string
    {
        if ($this->hasMedia('og_image')) {
            $media = $this->getFirstMedia('og_image');
            if ($media) {
                $mediaPath = $media->getPath();
                if ($mediaPath && str_contains($mediaPath, 'storage/app/public/')) {
                    $relativePath = 'storage/' . substr($mediaPath, strpos($mediaPath, 'storage/app/public/') + strlen('storage/app/public/'));
                    return asset($relativePath);
                } else {
                    $fileName = $media->file_name ?? '';
                    if ($fileName) {
                        $relativePath = 'storage/' . $media->id . '/' . $fileName;
                        return asset($relativePath);
                    }
                }
            }
        }
        
        if ($this->og_image && Storage::disk('public')->exists($this->og_image)) {
            if (str_starts_with($this->og_image, 'storage/') || str_starts_with($this->og_image, '/storage/')) {
                return asset($this->og_image);
            } else {
                return asset('storage/' . ltrim($this->og_image, '/'));
            }
        }
        
        return null;
    }

    /**
     * Accessor: Get website name (with backward compatibility).
     */
    public function getWebsiteNameAttribute($value): string
    {
        return $value ?? $this->attributes['site_name'] ?? 'Duha International School';
    }

    /**
     * Accessor: Get website description (with backward compatibility).
     */
    public function getWebsiteDescriptionAttribute($value): ?string
    {
        return $value ?? $this->attributes['site_description'] ?? null;
    }

    /**
     * Accessor: Get primary email (with backward compatibility).
     */
    public function getPrimaryEmailAttribute($value): ?string
    {
        return $value ?? $this->attributes['contact_email'] ?? null;
    }

    /**
     * Accessor: Get primary phone (with backward compatibility).
     */
    public function getPrimaryPhoneAttribute($value): ?string
    {
        return $value ?? $this->attributes['contact_phone'] ?? null;
    }

    /**
     * Accessor: Get physical address (with backward compatibility).
     */
    public function getPhysicalAddressAttribute($value): ?string
    {
        return $value ?? $this->attributes['address'] ?? null;
    }
}
