<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_events_index_page_loads(): void
    {
        $response = $this->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.events.index');
    }

    public function test_event_detail_page_loads(): void
    {
        $event = Event::factory()->published()->create();

        $response = $this->get(route('events.show', $event));

        $response->assertStatus(200);
        $response->assertViewIs('pages.events.show');
        $response->assertSee($event->title);
    }

    public function test_ics_export_works(): void
    {
        $event = Event::factory()->published()->create([
            'event_date' => now()->addDays(7),
        ]);

        $response = $this->get(route('events.ics', $event));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/calendar; charset=utf-8');
        $this->assertStringContainsString('BEGIN:VCALENDAR', $response->getContent());
        $this->assertStringContainsString($event->title, $response->getContent());
    }

    public function test_event_filtering_by_category(): void
    {
        Event::factory()->count(3)->published()->create(['category' => 'Academic']);
        Event::factory()->count(2)->published()->create(['category' => 'Sports']);

        $response = $this->get(route('events.index', ['category' => 'Academic']));

        $response->assertStatus(200);
        $response->assertSee('Academic');
    }
}

