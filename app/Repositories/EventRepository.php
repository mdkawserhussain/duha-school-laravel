<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EventRepository
{
    public function getPublishedEvents(?string $category = null, string $upcoming = 'all', int $perPage = 12, ?string $fromDate = null, ?string $toDate = null): LengthAwarePaginator
    {
        $query = Event::published();

        // Filter by category
        if ($category) {
            $query->where('category', $category);
        }

        // Filter by date range
        if ($fromDate) {
            $query->where('event_date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->where('event_date', '<=', $toDate);
        }

        // Filter by upcoming/past (only if no date range is specified)
        if (!$fromDate && !$toDate) {
            if ($upcoming === 'upcoming') {
                $query->upcoming();
            } elseif ($upcoming === 'past') {
                $query->where('event_date', '<', now());
            }
        }

        return $query->orderBy('event_date', 'desc')
            ->paginate($perPage);
    }

    public function getUpcomingEvents(int $limit = 5): Collection
    {
        return Event::published()
            ->upcoming()
            ->orderBy('event_date', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getFeaturedEvents(int $limit = 3): Collection
    {
        return Event::published()
            ->featured()
            ->orderBy('event_date', 'asc')
            ->limit($limit)
            ->get();
    }

    public function findPublishedEventById(int $id): ?Event
    {
        return Event::published()->find($id);
    }

    public function findPublishedEventBySlug(string $slug): ?Event
    {
        return Event::published()->where('slug', $slug)->first();
    }
}
