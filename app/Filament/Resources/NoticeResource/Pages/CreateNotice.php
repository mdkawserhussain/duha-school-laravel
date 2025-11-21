<?php

namespace App\Filament\Resources\NoticeResource\Pages;

use App\Filament\Resources\NoticeResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateNotice extends CreateRecord
{
    protected static string $resource = NoticeResource::class;

    /**
     * Mutate form data before saving.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure is_published is set and boolean
        $data['is_published'] = isset($data['is_published']) ? (bool) $data['is_published'] : true;
        
        // Ensure is_important is set and boolean
        $data['is_important'] = isset($data['is_important']) ? (bool) $data['is_important'] : false;

        // Ensure excerpt is set (required field in database)
        // If not provided, generate from content
        if (empty($data['excerpt']) || trim($data['excerpt']) === '') {
            $content = strip_tags($data['content'] ?? '');
            $data['excerpt'] = \Illuminate\Support\Str::limit($content, 200);
        }

        // Remove any non-existent fields (status, is_featured if they somehow got in)
        unset($data['status'], $data['is_featured']);

        return $data;
    }

    /**
     * Handle successful creation.
     */
    protected function afterCreate(): void
    {
        // Clear notice-related caches when notice is created
        Cache::forget('homepage_v2_data');
        $this->clearNoticeCaches();
    }

    /**
     * Clear notice-related caches.
     */
    protected function clearNoticeCaches(): void
    {
        try {
            // Clear specific notice cache keys (commonly used)
            $noticeCacheKeys = [
                'notices_recent_5',
                'notices_important_5',
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

            \Illuminate\Support\Facades\Log::info('Notice caches cleared', [
                'cache_driver' => config('cache.default'),
                'homepage_cache_cleared' => true,
                'notice_caches_cleared' => true,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error clearing notice caches', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}