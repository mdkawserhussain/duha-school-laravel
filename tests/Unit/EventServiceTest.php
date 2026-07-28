<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Repositories\EventRepository;
use App\Services\EventService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class EventServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EventService $eventService;
    protected EventRepository $eventRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventRepository = new EventRepository();
        $this->eventService = new EventService($this->eventRepository);
    }

    public function test_can_get_published_events(): void
    {
        Event::factory()->count(5)->published()->create();
        Event::factory()->count(3)->create(['is_published' => false]);

        $events = $this->eventService->getPublishedEvents();

        $this->assertInstanceOf(LengthAwarePaginator::class, $events);
        $this->assertEquals(5, $events->total());
    }

    public function test_can_filter_events_by_category(): void
    {
        Event::factory()->count(3)->published()->create(['category' => 'Academic']);
        Event::factory()->count(2)->published()->create(['category' => 'Sports']);

        $events = $this->eventService->getPublishedEvents('Academic');

        $this->assertEquals(3, $events->total());
        $events->each(function ($event) {
            $this->assertEquals('Academic', $event->category);
        });
    }

    public function test_can_filter_upcoming_events(): void
    {
        Event::factory()->count(3)->published()->upcoming()->create();
        Event::factory()->count(2)->published()->create(['event_date' => now()->subDays(5)]);

        $events = $this->eventService->getPublishedEvents(null, 'upcoming');

        $this->assertEquals(3, $events->total());
    }
}

