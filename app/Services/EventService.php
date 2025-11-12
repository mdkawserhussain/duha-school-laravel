<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    protected EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getPublishedEvents(?string $category = null, string $upcoming = 'all', int $perPage = 12, ?string $fromDate = null, ?string $toDate = null): LengthAwarePaginator
    {
        return $this->eventRepository->getPublishedEvents($category, $upcoming, $perPage, $fromDate, $toDate);
    }

    public function getUpcomingEvents(int $limit = 5): Collection
    {
        return $this->eventRepository->getUpcomingEvents($limit);
    }

    public function getFeaturedEvents(int $limit = 3): Collection
    {
        return $this->eventRepository->getFeaturedEvents($limit);
    }

    public function findPublishedEvent(int $id): ?Event
    {
        return $this->eventRepository->findPublishedEventById($id);
    }

    public function findPublishedEventBySlug(string $slug): ?Event
    {
        return $this->eventRepository->findPublishedEventBySlug($slug);
    }

}