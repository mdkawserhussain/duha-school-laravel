<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Str;

class EventObserver
{
    /**
     * Handle the Event "creating" event.
     */
    public function creating(Event $event): void
    {
        // Slug generation is handled in the model's boot method
        // This observer ensures slug is normalized and unique
        if (!empty($event->slug)) {
            // Normalize slug: ensure it's a valid string
            $slug = is_string($event->slug) ? trim($event->slug) : (string) $event->slug;
            $slug = Str::slug($slug);
            
            // Handle edge case: if slug is empty, generate fallback
            if (empty($slug)) {
                $slug = !empty($event->title) 
                    ? Str::slug($event->title) 
                    : 'event-' . time();
                if (empty($slug)) {
                    $slug = 'event-' . time();
                }
            }
            
            $event->slug = $slug;
        }
    }

    /**
     * Handle the Event "updating" event.
     */
    public function updating(Event $event): void
    {
        // Normalize slug if it exists
        if (!empty($event->slug)) {
            $slug = is_string($event->slug) ? trim($event->slug) : (string) $event->slug;
            $slug = Str::slug($slug);
            
            if (empty($slug)) {
                $slug = !empty($event->title) 
                    ? Str::slug($event->title) 
                    : 'event-' . time();
                if (empty($slug)) {
                    $slug = 'event-' . time();
                }
            }
            
            $event->slug = $slug;
        }
    }

    /**
     * Handle the Event "saving" event.
     */
    public function saving(Event $event): void
    {
        // Ensure slug is unique and normalized
        if (!empty($event->slug)) {
            // Normalize slug first
            $slug = is_string($event->slug) ? trim($event->slug) : (string) $event->slug;
            $slug = Str::slug($slug);
            
            if (empty($slug)) {
                $slug = !empty($event->title) 
                    ? Str::slug($event->title) 
                    : 'event-' . time();
                if (empty($slug)) {
                    $slug = 'event-' . time();
                }
            }
            
            // Ensure slug is unique
            $originalSlug = $slug;
            $count = 1;
            
            while (Event::where('slug', $slug)
                ->where('id', '!=', $event->id ?? 0)
                ->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            
            $event->slug = $slug;
        }
    }

    /**
     * Handle the Event "saved" event.
     */
    public function saved(Event $event): void
    {
        // Clear event-related caches when event is saved
        $this->clearEventCaches();
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        // Clear event-related caches when event is deleted
        $this->clearEventCaches();
    }

    /**
     * Clear event-related caches.
     */
    protected function clearEventCaches(): void
    {
        try {
            // Clear homepage cache FIRST (events are displayed there)
            // This ensures the homepage will fetch fresh data on next request
            \Illuminate\Support\Facades\Cache::forget('homepage_v2_data');
            
            // Clear event-specific caches to ensure fresh data
            // This includes the cache used by EventService::getUpcomingEvents()
            $cache = \Illuminate\Support\Facades\Cache::getFacadeRoot();
            
            // Clear specific event cache keys
            $eventCacheKeys = [
                'events_upcoming_3',  // Used by homepage
                'events_upcoming_5',  // Common limit
                'events_featured_3',   // Featured events
            ];
            
            foreach ($eventCacheKeys as $key) {
                \Illuminate\Support\Facades\Cache::forget($key);
            }
            
            // Clear event-specific caches (pattern-based clearing for Redis)
            if (config('cache.default') === 'redis') {
                try {
                    $redis = \Illuminate\Support\Facades\Cache::getRedis();
                    $patterns = [
                        'events_published_*',
                        'events_upcoming_*',
                        'events_featured_*',
                    ];
                    
                    foreach ($patterns as $pattern) {
                        $keys = $redis->keys($pattern);
                        if (!empty($keys)) {
                            $redis->del($keys);
                        }
                    }
                } catch (\Exception $e) {
                    // If pattern clearing fails, log and continue
                    \Illuminate\Support\Facades\Log::warning('Failed to clear event caches by pattern', [
                        'error' => $e->getMessage(),
                    ]);
                }
            } else {
                // For non-Redis cache drivers (database, file), clear common pagination keys
                // This is a best-effort approach since we can't pattern match with these drivers
                for ($page = 1; $page <= 10; $page++) {
                    for ($perPage = 12; $perPage <= 24; $perPage += 12) {
                        // Clear category-based caches
                        $categories = ['Academic', 'Social', 'Islamic', 'Sports', 'Cultural'];
                        foreach ($categories as $category) {
                            $cacheKey = 'events_published_' . md5(serialize([$category, 'all', $perPage, null, null, $page]));
                            \Illuminate\Support\Facades\Cache::forget($cacheKey);
                            $cacheKey = 'events_published_' . md5(serialize([$category, 'upcoming', $perPage, null, null, $page]));
                            \Illuminate\Support\Facades\Cache::forget($cacheKey);
                            $cacheKey = 'events_published_' . md5(serialize([$category, 'past', $perPage, null, null, $page]));
                            \Illuminate\Support\Facades\Cache::forget($cacheKey);
                        }
                        // Clear without category
                        $cacheKey = 'events_published_' . md5(serialize([null, 'all', $perPage, null, null, $page]));
                        \Illuminate\Support\Facades\Cache::forget($cacheKey);
                        $cacheKey = 'events_published_' . md5(serialize([null, 'upcoming', $perPage, null, null, $page]));
                        \Illuminate\Support\Facades\Cache::forget($cacheKey);
                        $cacheKey = 'events_published_' . md5(serialize([null, 'past', $perPage, null, null, $page]));
                        \Illuminate\Support\Facades\Cache::forget($cacheKey);
                    }
                }
            }
            
            // Log cache clearing for debugging
            \Illuminate\Support\Facades\Log::info('Event caches cleared', [
                'homepage_cache_cleared' => true,
                'event_caches_cleared' => true,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error clearing event caches', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}