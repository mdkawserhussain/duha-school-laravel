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

    /**
     * Map parent navigation slug to page category
     */
    private function getCategoryFromParentSlug(): ?string
    {
        if (!$this->parent_id || !$this->parent) {
            return null;
        }
        
        $parentSlug = $this->parent->slug;
        $slugToCategoryMap = [
            'about' => 'about-us',
            'academic' => 'academics',
            'admission' => 'admissions',
            'facilities' => 'facilities',
            'faculty' => 'faculty',
            'tahfeez' => null, // Standalone page
        ];
        
        return $slugToCategoryMap[$parentSlug] ?? null;
    }

    public function getUrlAttribute(): ?string
    {
        // Access raw database value to avoid infinite recursion
        $rawUrl = $this->attributes['url'] ?? null;
        
        // 1. External URLs take priority
        if ($this->is_external && $rawUrl) {
            return $rawUrl;
        }

        // 2. Try route_name if it exists
        if ($this->route_name) {
            try {
                // Check if route exists before using it
                if (\Illuminate\Support\Facades\Route::has($this->route_name)) {
                    return route($this->route_name);
                }
            } catch (\Exception $e) {
                // Route doesn't exist or error occurred, fall through to slug
            }
        }

        // 2.5. NEW: Check if there's a route with the same name as the slug (e.g., 'about' -> route('about'))
        if ($this->slug) {
            try {
                if (\Illuminate\Support\Facades\Route::has($this->slug)) {
                    return route($this->slug);
                }
            } catch (\Exception $e) {
                // Route doesn't exist, fall through
            }
        }

        // 3. If item has a slug and a parent, try to generate URL from parent's route
        if ($this->slug && $this->parent_id) {
            $parent = $this->parent;
            if ($parent && $parent->route_name) {
                // Extract category from parent route (e.g., 'about.index' -> 'about')
                $parentRoute = $parent->route_name;
                if (str_ends_with($parentRoute, '.index')) {
                    $category = str_replace('.index', '', $parentRoute);
                    $childRoute = $category . '.show';
                    try {
                        // Check if route exists before using it
                        if (\Illuminate\Support\Facades\Route::has($childRoute)) {
                            return route($childRoute, $this->slug);
                        }
                    } catch (\Exception $e) {
                        // Route doesn't exist, fall through to slug-based URL
                    }
                }
            }
        }

        // 4. NEW: Query Page model to find page by slug and use category route
        if ($this->slug) {
            try {
                $page = \App\Models\Page::where('slug', $this->slug)
                    ->where('is_published', true)
                    ->where(function($query) {
                        $query->whereNull('published_at')
                              ->orWhere('published_at', '<=', now());
                    })
                    ->first();

                if ($page && $page->page_category) {
                    // If this is a category landing page (no parent), use index route
                    if (!$page->parent_id) {
                        $categoryRoute = \App\Helpers\PageHelper::getCategoryIndexRoute($page->page_category);
                        if ($categoryRoute && \Illuminate\Support\Facades\Route::has($categoryRoute)) {
                            return route($categoryRoute);
                        }
                    } else {
                        // Use category show route for child pages
                        $categoryRoute = \App\Helpers\PageHelper::getCategoryShowRoute($page->page_category);
                        if ($categoryRoute && \Illuminate\Support\Facades\Route::has($categoryRoute)) {
                            return route($categoryRoute, $this->slug);
                        }
                    }
                }
            } catch (\Exception $e) {
                // Page lookup failed, fall through to parent slug mapping
            }
        }

        // 5. NEW: Map parent slug to category if parent has no route_name
        if ($this->slug && $this->parent_id) {
            $category = $this->getCategoryFromParentSlug();
            if ($category) {
                $categoryRoute = \App\Helpers\PageHelper::getCategoryShowRoute($category);
                if ($categoryRoute && \Illuminate\Support\Facades\Route::has($categoryRoute)) {
                    return route($categoryRoute, $this->slug);
                }
            }
        }

        // 6. Fallback to direct slug-based URL (now works with catch-all route)
        if ($this->slug) {
            return url($this->slug);
        }

        // 7. Final fallback: use url field if provided
        return $rawUrl ?: '#';
    }
}