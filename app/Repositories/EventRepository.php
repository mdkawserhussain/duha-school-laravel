<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class EventRepository
{
    /**
     * Get published events with filters, pagination, and eager loading.
     */
    public function getPublishedEvents(?string $category = null, string $upcoming = 'all', int $perPage = 12, ?string $fromDate = null, ?string $toDate = null): LengthAwarePaginator
    {
        $query = Event::published()
            ->with('media'); // Eager load media relationships

        // Filter by category
        if ($category) {
            $query->where('category', $category);
        }

        // Determine date field to use (start_at or event_date)
        $hasStartAt = Schema::hasColumn('events', 'start_at');
        $dateField = $hasStartAt ? 'start_at' : 'event_date';

        // Filter by date range
        if ($fromDate) {
            $query->where(function ($q) use ($dateField, $fromDate, $hasStartAt) {
                $q->where($dateField, '>=', $fromDate);
                if ($hasStartAt) {
                    $q->orWhere(function ($subQ) use ($fromDate) {
                        $subQ->whereNull('start_at')
                            ->where('event_date', '>=', $fromDate);
                    });
                }
            });
        }

        if ($toDate) {
            $query->where(function ($q) use ($dateField, $toDate, $hasStartAt) {
                $q->where($dateField, '<=', $toDate);
                if ($hasStartAt) {
                    $q->orWhere(function ($subQ) use ($toDate) {
                        $subQ->whereNull('start_at')
                            ->where('event_date', '<=', $toDate);
                    });
                }
            });
        }

        // Filter by upcoming/past (only if no date range is specified)
        if (!$fromDate && !$toDate) {
            if ($upcoming === 'upcoming') {
                $query->upcoming();
            } elseif ($upcoming === 'past') {
                $query->where(function ($q) use ($dateField, $hasStartAt) {
                    $q->where($dateField, '<', now());
                    if ($hasStartAt) {
                        $q->orWhere(function ($subQ) {
                            $subQ->whereNull('start_at')
                                ->where('event_date', '<', now());
                        });
                    }
                });
            }
        }

        // Order by date (prefer start_at, fallback to event_date)
        if ($hasStartAt) {
            $query->orderByRaw('COALESCE(start_at, event_date) DESC');
        } else {
            $query->orderBy('event_date', 'desc');
        }

        return $query->paginate($perPage);
    }

    /**
     * Get upcoming events with eager loading.
     */
    public function getUpcomingEvents(int $limit = 5): Collection
    {
        $hasStartAt = Schema::hasColumn('events', 'start_at');
        
        $query = Event::published()
            ->upcoming()
            ->with('media'); // Eager load media relationships

        // Order by date (prefer start_at, fallback to event_date)
        if ($hasStartAt) {
            $query->orderByRaw('COALESCE(start_at, event_date) ASC');
        } else {
            $query->orderBy('event_date', 'asc');
        }

        return $query->limit($limit)->get();
    }

    /**
     * Get featured events with eager loading.
     */
    public function getFeaturedEvents(int $limit = 3): Collection
    {
        $hasStartAt = Schema::hasColumn('events', 'start_at');
        
        $query = Event::published()
            ->featured()
            ->with('media'); // Eager load media relationships

        // Order by date (prefer start_at, fallback to event_date)
        if ($hasStartAt) {
            $query->orderByRaw('COALESCE(start_at, event_date) ASC');
        } else {
            $query->orderBy('event_date', 'asc');
        }

        return $query->limit($limit)->get();
    }

    /**
     * Find published event by ID with eager loading.
     */
    public function findPublishedEventById(int $id): ?Event
    {
        return Event::published()
            ->with('media')
            ->find($id);
    }

    /**
     * Find published event by slug with eager loading.
     */
    public function findPublishedEventBySlug(string $slug): ?Event
    {
        return Event::published()
            ->with('media')
            ->where('slug', $slug)
            ->first();
    }
}
