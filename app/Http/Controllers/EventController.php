<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        try {
            $category = $request->get('category');
            $upcoming = $request->get('upcoming', 'all'); // 'all', 'upcoming', 'past'
            $fromDate = $request->get('from_date');
            $toDate = $request->get('to_date');

            // Service handles caching internally
            $events = $this->eventService->getPublishedEvents($category, $upcoming, 12, $fromDate, $toDate);

            $data = [
                'events' => $events,
                'category' => $category,
                'upcoming' => $upcoming,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
            ];

            return response()
                ->view('pages.events.index', $data)
                ->header('Cache-Control', 'public, max-age=1800');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error displaying events index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return view with empty events on error
            return view('pages.events.index', [
                'events' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12),
                'category' => null,
                'upcoming' => 'all',
                'fromDate' => null,
                'toDate' => null,
            ]);
        }
    }

    public function show(\App\Models\Event $event)
    {
        try {
            // Check if event is published
            if (!$event->is_published || ($event->published_at && $event->published_at > now())) {
                abort(404);
            }

            // Eager load media if not already loaded
            if (!$event->relationLoaded('media')) {
                $event->load('media');
            }

            return view('pages.events.show', compact('event'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error displaying event', [
                'error' => $e->getMessage(),
                'event_id' => $event->id ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'An error occurred while loading the event. Please try again later.');
        }
    }

    public function exportIcs(\App\Models\Event $event)
    {
        if (!$event->is_published || $event->published_at > now()) {
            abort(404);
        }

        $icsContent = $this->generateIcs($event);

        return response($icsContent)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="event-' . $event->id . '.ics"');
    }

    private function generateIcs($event): string
    {
        $startDate = $event->event_date->format('Ymd\THis\Z');
        $endDate = $event->event_date->addHours(2)->format('Ymd\THis\Z'); // Default 2 hour duration
        $created = now()->format('Ymd\THis\Z');
        $uid = 'event-' . $event->id . '@' . parse_url(config('app.url'), PHP_URL_HOST);

        $description = strip_tags($event->excerpt ?? $event->description ?? '');
        $description = str_replace(["\r\n", "\n", "\r"], "\\n", $description);
        $location = $event->location ?? config('contact.address.full');

        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//" . \App\Helpers\SiteHelper::getSiteName() . "//Event Calendar//EN\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:PUBLISH\r\n";
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "UID:{$uid}\r\n";
        $ics .= "DTSTAMP:{$created}\r\n";
        $ics .= "DTSTART:{$startDate}\r\n";
        $ics .= "DTEND:{$endDate}\r\n";
        $ics .= "SUMMARY:" . $this->escapeIcsText($event->title) . "\r\n";
        $ics .= "DESCRIPTION:" . $this->escapeIcsText($description) . "\r\n";
        $ics .= "LOCATION:" . $this->escapeIcsText($location) . "\r\n";
        $ics .= "URL:" . route('events.show', $event) . "\r\n";
        $ics .= "STATUS:CONFIRMED\r\n";
        $ics .= "SEQUENCE:0\r\n";
        $ics .= "END:VEVENT\r\n";
        $ics .= "END:VCALENDAR\r\n";

        return $ics;
    }

    private function escapeIcsText(string $text): string
    {
        return str_replace([',', ';', "\n"], [',,', '\\;', '\\n'], $text);
    }

    public function feed()
    {
        $events = $this->eventService->getPublishedEvents(null, 'upcoming', 20);

        return response()
            ->view('feeds.events', ['events' => $events])
            ->header('Content-Type', 'application/atom+xml; charset=utf-8');
    }
}
