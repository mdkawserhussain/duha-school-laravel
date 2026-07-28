<?php

namespace App\Services;

use App\Repositories\NoticeRepository;
use App\Models\Notice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NoticeService
{
    protected NoticeRepository $noticeRepository;

    public function __construct(NoticeRepository $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
    }

    /**
     * Get published notices with caching.
     */
    public function getPublishedNotices(int $perPage = 12): LengthAwarePaginator
    {
        $cacheKey = 'notices_published_' . md5(serialize([
            $perPage,
            request()->get('page', 1),
        ]));
        $cacheTime = 1800; // 30 minutes

        try {
            return Cache::remember($cacheKey, $cacheTime, function () use ($perPage) {
                return $this->noticeRepository->getPublishedNotices($perPage);
            });
        } catch (\Exception $e) {
            Log::error('Error fetching published notices', [
                'error' => $e->getMessage(),
                'per_page' => $perPage,
            ]);
            
            // Fallback: return empty paginator on error
            return new LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Get important notices with caching.
     */
    public function getImportantNotices(int $limit = 5): Collection
    {
        $cacheKey = 'notices_important_' . $limit;
        $cacheTime = 1800; // 30 minutes

        try {
            return Cache::remember($cacheKey, $cacheTime, function () use ($limit) {
                return $this->noticeRepository->getImportantNotices($limit);
            });
        } catch (\Exception $e) {
            Log::error('Error fetching important notices', [
                'error' => $e->getMessage(),
                'limit' => $limit,
            ]);
            
            // Fallback: return empty collection on error
            return new Collection();
        }
    }

    /**
     * Get notices by category with caching.
     */
    public function getNoticesByCategory(string $category, int $perPage = 12): LengthAwarePaginator
    {
        $cacheKey = 'notices_category_' . md5(serialize([
            $category,
            $perPage,
            request()->get('page', 1),
        ]));
        $cacheTime = 1800; // 30 minutes

        try {
            return Cache::remember($cacheKey, $cacheTime, function () use ($category, $perPage) {
                return $this->noticeRepository->getNoticesByCategory($category, $perPage);
            });
        } catch (\Exception $e) {
            Log::error('Error fetching notices by category', [
                'error' => $e->getMessage(),
                'category' => $category,
                'per_page' => $perPage,
            ]);
            
            // Fallback: return empty paginator on error
            return new LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Find published notice by ID.
     */
    public function findPublishedNotice(int $id): ?Notice
    {
        try {
            return $this->noticeRepository->findPublishedNoticeById($id);
        } catch (\Exception $e) {
            Log::error('Error finding published notice by ID', [
                'error' => $e->getMessage(),
                'id' => $id,
            ]);
            
            return null;
        }
    }

    /**
     * Find published notice by slug.
     */
    public function findPublishedNoticeBySlug(string $slug): ?Notice
    {
        try {
            return $this->noticeRepository->findPublishedNoticeBySlug($slug);
        } catch (\Exception $e) {
            Log::error('Error finding published notice by slug', [
                'error' => $e->getMessage(),
                'slug' => $slug,
            ]);
            
            return null;
        }
    }

    /**
     * Get recent notices with caching.
     */
    public function getRecentNotices(int $limit = 5): Collection
    {
        $cacheKey = 'notices_recent_' . $limit;
        $cacheTime = 1800; // 30 minutes

        try {
            return Cache::remember($cacheKey, $cacheTime, function () use ($limit) {
                return $this->noticeRepository->getRecentNotices($limit);
            });
        } catch (\Exception $e) {
            Log::error('Error fetching recent notices', [
                'error' => $e->getMessage(),
                'limit' => $limit,
            ]);
            
            // Fallback: return empty collection on error
            return new Collection();
        }
    }

    /**
     * Clear all notice-related caches.
     */
    public function clearNoticeCaches(): void
    {
        try {
            // Clear homepage cache (notices are displayed there)
            Cache::forget('homepage_v2_data');
            
            // Clear notice-specific caches (pattern-based clearing)
            $patterns = [
                'notices_published_*',
                'notices_important_*',
                'notices_category_*',
                'notices_recent_*',
            ];
            
            // Try to clear by pattern if using Redis
            if (config('cache.default') === 'redis') {
                try {
                    $redis = Cache::getRedis();
                    foreach ($patterns as $pattern) {
                        $keys = $redis->keys($pattern);
                        if (!empty($keys)) {
                            $redis->del($keys);
                        }
                    }
                } catch (\Exception $e) {
                    // If pattern clearing fails, log and continue
                    Log::warning('Failed to clear notice caches by pattern', [
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error clearing notice caches', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}