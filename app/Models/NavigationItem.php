<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class NavigationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'route_name',
        'url',
        'icon',
        'parent_id',
        'sort_order',
        'is_active',
        'is_external',
        'target_blank',
        'section',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'is_external' => 'boolean',
        'target_blank' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(NavigationItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(NavigationItem::class, 'parent_id')->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForSection($query, string $section = 'main')
    {
        return $query->where('section', $section)->orWhere('section', 'both');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    public function scopeRootItems($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getUrlAttribute(): ?string
    {
        if ($this->is_external && $this->url) {
            return $this->url;
        }

        if ($this->route_name) {
            try {
                return route($this->route_name);
            } catch (\Exception $e) {
                return $this->url;
            }
        }

        if ($this->slug) {
            return url($this->slug);
        }

        return $this->url;
    }
}