<?php

namespace App\Observers;

use App\Models\Notice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class NoticeObserver
{
    /**
     * Handle the Notice "saving" event.
     * This runs for both creating and updating.
     */
    public function saving(Notice $notice): void
    {
        // Ensure slug is unique and normalized
        // Slug generation is primarily handled in the model's boot method
        // This observer ensures slug is normalized and unique before saving
        if (!empty($notice->slug)) {
            // Normalize slug: ensure it's a valid string
            $slug = is_string($notice->slug) ? trim($notice->slug) : (string) $notice->slug;
            $slug = Str::slug($slug);
            
            // Handle edge case: if slug is empty, generate fallback
            if (empty($slug)) {
                $slug = !empty($notice->title) 
                    ? Str::slug($notice->title) 
                    : 'notice-' . time();
                if (empty($slug)) {
                    $slug = 'notice-' . time();
                }
            }
            
            // Ensure slug is unique (skip if slug hasn't changed and record exists)
            $originalSlug = $slug;
            $count = 1;
            
            while (Notice::where('slug', $slug)
                ->where('id', '!=', $notice->id ?? 0)
                ->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            
            $notice->slug = $slug;
        }
        
        // Ensure boolean fields are properly cast
        if (isset($notice->is_published)) {
            $notice->is_published = (bool) $notice->is_published;
        }
        if (isset($notice->is_important)) {
            $notice->is_important = (bool) $notice->is_important;
        }
    }

    /**
     * Handle the Notice "saved" event.
     */
    public function saved(Notice $notice): void
    {
        // Clear notice-related caches when notice is saved
        $this->clearNoticeCaches();
    }

    /**
     * Handle the Notice "deleted" event.
     */
    public function deleted(Notice $notice): void
    {
        // Clear notice-related caches when notice is deleted
        $this->clearNoticeCaches();
    }

    /**
     * Clear notice-related caches.
     */
    protected function clearNoticeCaches(): void
    {
        try {
            // Clear homepage cache FIRST (notices are displayed there)
            // This ensures the homepage will fetch fresh data on next request
            Cache::forget('homepage_v2_data');
            
            // Clear notice-specific caches to ensure fresh data
            // This includes the cache used by NoticeService methods
            $noticeCacheKeys = [
                'notices_recent_5',   // Used by homepage
                'notices_important_5', // Important notices
            ];
            
            foreach ($noticeCacheKeys as $key) {
                Cache::forget($key);
            }
            
            // Clear notice-specific caches (pattern-based clearing for Redis)
            if (config('cache.default') === 'redis') {
                try {
                    $redis = Cache::getRedis();
                    $patterns = [
                        'notices_published_*',
                        'notices_important_*',
                        'notices_category_*',
                        'notices_recent_*',
                    ];
                    
                    foreach ($patterns as $pattern) {
                        $keys = $redis->keys($pattern);
                        if (!empty($keys)) {
                            $redis->del($keys);
                        }
                    }
                } catch (\Exception $e) {
                    // If pattern clearing fails, log and continue
                    \Illuminate\Support\Facades\Log::warning('Failed to clear notice caches by pattern', [
                        'error' => $e->getMessage(),
                    ]);
                }
            } else {
                // For non-Redis cache drivers (database, file), clear common pagination keys
                // This is a best-effort approach since we can't pattern match with these drivers
                for ($page = 1; $page <= 10; $page++) {
                    for ($perPage = 12; $perPage <= 24; $perPage += 12) {
                        $cacheKey = 'notices_published_' . md5(serialize([$perPage, $page]));
                        Cache::forget($cacheKey);
                    }
                }
                
                // Clear category-based caches
                $categories = ['Academic', 'Administrative', 'Events', 'General'];
                foreach ($categories as $category) {
                    for ($page = 1; $page <= 10; $page++) {
                        for ($perPage = 12; $perPage <= 24; $perPage += 12) {
                            $cacheKey = 'notices_category_' . md5(serialize([$category, $perPage, $page]));
                            Cache::forget($cacheKey);
                        }
                    }
                }
            }
            
            // Log cache clearing for debugging
            \Illuminate\Support\Facades\Log::info('Notice caches cleared', [
                'cache_driver' => config('cache.default'),
                'homepage_cache_cleared' => true,
                'notice_caches_cleared' => true,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error clearing notice caches', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}

