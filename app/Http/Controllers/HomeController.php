<?php

namespace App\Http\Controllers;

use App\Models\HomePageSection;
use App\Services\EventService;
use App\Services\NoticeService;
use App\Services\StaffService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    protected EventService $eventService;
    protected NoticeService $noticeService;
    protected StaffService $staffService;

    public function __construct(EventService $eventService, NoticeService $noticeService, StaffService $staffService)
    {
        $this->eventService = $eventService;
        $this->noticeService = $noticeService;
        $this->staffService = $staffService;
    }

    public function index()
    {
        $cacheKey = 'homepage_v2_data';
        $cacheTime = 3600; // 1 hour

        $data = cache()->remember($cacheKey, $cacheTime, function () {
            // Eager load media relationships to ensure images are available
            $sections = HomePageSection::active()
                ->ordered()
                ->with('media')
                ->get();
            $sectionsByKey = $sections->keyBy('section_key');
            $heroSlides = $sections->where('section_type', 'hero')->values();

            // Fetch events dynamically from EventService
            // This ensures we get the latest events from the database
            // The EventService handles its own caching, but we want fresh data here
            // when the homepage cache is regenerated
            $upcomingEvents = $this->eventService->getUpcomingEvents(3);
            
            // Ensure events have media relationships loaded
            if ($upcomingEvents->isNotEmpty() && !$upcomingEvents->first()->relationLoaded('media')) {
                $upcomingEvents->load('media');
            }

            // Fetch important notices for the news-events-section component
            $importantNotices = $this->noticeService->getImportantNotices(3);
            
            // Ensure important notices have media relationships loaded
            if ($importantNotices->isNotEmpty() && !$importantNotices->first()->relationLoaded('media')) {
                $importantNotices->load('media');
            }

            return [
                'hero' => $this->mapHeroBlock($heroSlides, $sectionsByKey),
                'featurePanels' => $this->mapFeaturePanels($sectionsByKey),
                'statHighlights' => $this->mapStatHighlights($sectionsByKey),
                'featuredEvents' => $this->eventService->getFeaturedEvents(),
                'recentNotices' => $this->noticeService->getRecentNotices(),
                'importantNotices' => $importantNotices, // Important notices for news-events-section
                'featuredStaff' => $this->staffService->getFeaturedStaff(),
                'upcomingEvents' => $upcomingEvents, // Dynamically fetched events
                'visionPage' => \App\Models\Page::where('slug', 'vision')->published()->first(),
                'homePageSections' => $sectionsByKey,
                'heroSlides' => $heroSlides,
            ];
        });

        return response()
            ->view('pages.home', $data)
            ->header('Cache-Control', 'public, max-age=3600');
    }

    protected function mapHeroBlock(Collection $heroSlides, Collection $sections): array
    {
        $primary = $heroSlides->first();

        $headline = trim(collect([
            optional($primary)->title,
            optional($primary)->subtitle,
        ])->filter()->join(' '));

        $description = optional($primary)->description
            ?: config('homepage.hero.default_description');

        $badge = data_get($primary, 'data.badge')
            ?: config('homepage.hero.default_badge');

        return [
            'badge' => $badge,
            'heading' => $headline ?: 'Welcome to ' . \App\Helpers\SiteHelper::getSiteName(),
            'description' => $description,
            'primaryAction' => [
                'label' => optional($primary)->button_text ?: 'Apply Now',
                'url' => optional($primary)->button_link ?: route('admission.index'),
            ],
            'secondaryAction' => [
                'label' => 'Explore Campus Life',
                'url' => route('about.show', ['page' => 'vision']),
            ],
            'stats' => $this->mapHeroStats($sections),
        ];
    }

    protected function mapHeroStats(Collection $sections): array
    {
        $stats = data_get($sections->get('hero_stats'), 'data.stats');

        if (is_array($stats) && count($stats)) {
            return collect($stats)
                ->map(fn ($stat) => [
                    'value' => Arr::get($stat, 'value'),
                    'label' => Arr::get($stat, 'label'),
                ])
                ->filter(fn ($stat) => filled($stat['value']) && filled($stat['label']))
                ->values()
                ->all();
        }

        return config('homepage.hero_stats');
    }

    protected function mapFeaturePanels(Collection $sections): array
    {
        $targets = ['info_enrollment', 'info_events', 'info_notice'];

        return collect($targets)
            ->map(function (string $key) use ($sections) {
                $section = $sections->get($key);

                return [
                    'title' => $section?->title,
                    'description' => $section?->description ?: $section?->content,
                    'button' => filled($section?->button_link) ? [
                        'label' => $section->button_text ?? 'Learn more',
                        'url' => $section->button_link,
                    ] : null,
                    'icon' => Arr::get($section?->data, 'icon'),
                ];
            })
            ->filter(fn ($panel) => filled($panel['title']))
            ->values()
            ->all();
    }

    protected function mapStatHighlights(Collection $sections): array
    {
        $section = $sections->get('stat_highlights');

        if ($section && $section->is_active) {
            $highlights = data_get($section, 'data.highlights', []);

            if (is_array($highlights) && count($highlights)) {
                return collect($highlights)
                    ->map(fn ($highlight) => [
                        'value' => Arr::get($highlight, 'value'),
                        'label' => Arr::get($highlight, 'label'),
                    ])
                    ->filter(fn ($highlight) => filled($highlight['value']) && filled($highlight['label']))
                    ->values()
                    ->all();
            }
        }

        // Fallback to default values if no section found
        return config('homepage.stat_highlights');
    }
}
