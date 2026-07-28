<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class EventService
{
    protected EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Get published events with caching.
     */
    public function getPublishedEvents(?string $category = null, string $upcoming = 'all', int $perPage = 12, ?string $fromDate = null, ?string $toDate = null): LengthAwarePaginator
    {
        $cacheKey = 'events_published_' . md5(serialize([
            $category,
            $upcoming,
            $perPage,
            $fromDate,
            $toDate,
            request()->get('page', 1),
        ]));
        $cacheTime = 1800; // 30 minutes

        try {
            return Cache::remember($cacheKey, $cacheTime, function () use ($category, $upcoming, $perPage, $fromDate, $toDate) {
                return $this->eventRepository->getPublishedEvents($category, $upcoming, $perPage, $fromDate, $toDate);
            });
        } catch (\Exception $e) {
            Log::error('Error fetching published events', [
                'error' => $e->getMessage(),
                'category' => $category,
                'upcoming' => $upcoming,
            ]);
            
            // Fallback: return empty paginator on error
            return new LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Get upcoming events with caching.
     */
    public function getUpcomingEvents(int $limit = 5): Collection
    {
        $cacheKey = 'events_upcoming_' . $limit;
        $cacheTime = 1800; // 30 minutes

        try {
            return Cache::remember($cacheKey, $cacheTime, function () use ($limit) {
                return $this->eventRepository->getUpcomingEvents($limit);
            });
        } catch (\Exception $e) {
            Log::error('Error fetching upcoming events', [
                'error' => $e->getMessage(),
                'limit' => $limit,
            ]);
            
            // Fallback: return empty collection on error
            return new Collection();
        }
    }

    /**
     * Get featured events with caching.
     */
    public function getFeaturedEvents(int $limit = 3): Collection
    {
        $cacheKey = 'events_featured_' . $limit;
        $cacheTime = 1800; // 30 minutes

        try {
            return Cache::remember($cacheKey, $cacheTime, function () use ($limit) {
                return $this->eventRepository->getFeaturedEvents($limit);
            });
        } catch (\Exception $e) {
            Log::error('Error fetching featured events', [
                'error' => $e->getMessage(),
                'limit' => $limit,
            ]);
            
            // Fallback: return empty collection on error
            return new Collection();
        }
    }

    /**
     * Find published event by ID.
     */
    public function findPublishedEvent(int $id): ?Event
    {
        try {
            return $this->eventRepository->findPublishedEventById($id);
        } catch (\Exception $e) {
            Log::error('Error finding published event by ID', [
                'error' => $e->getMessage(),
                'id' => $id,
            ]);
            
            return null;
        }
    }

    /**
     * Find published event by slug.
     */
    public function findPublishedEventBySlug(string $slug): ?Event
    {
        try {
            return $this->eventRepository->findPublishedEventBySlug($slug);
        } catch (\Exception $e) {
            Log::error('Error finding published event by slug', [
                'error' => $e->getMessage(),
                'slug' => $slug,
            ]);
            
            return null;
        }
    }

    /**
     * Clear all event-related caches.
     */
    public function clearEventCaches(): void
    {
        try {
            // Clear homepage cache (events are displayed there)
            Cache::forget('homepage_v2_data');
            
            // Clear event-specific caches (pattern-based clearing)
            // Note: This is a simplified approach. For Redis, you could use tags.
            $patterns = [
                'events_published_*',
                'events_upcoming_*',
                'events_featured_*',
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
                    Log::warning('Failed to clear event caches by pattern', [
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error clearing event caches', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}