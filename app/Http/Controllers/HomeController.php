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
            $sections = HomePageSection::active()->ordered()->get();
            $sectionsByKey = $sections->keyBy('section_key');
            $heroSlides = $sections->where('section_type', 'hero')->values();

            return [
                'hero' => $this->mapHeroBlock($heroSlides, $sectionsByKey),
                'featurePanels' => $this->mapFeaturePanels($sectionsByKey),
                'statHighlights' => $this->mapStatHighlights($sectionsByKey),
                'featuredEvents' => $this->eventService->getFeaturedEvents(),
                'recentNotices' => $this->noticeService->getRecentNotices(),
                'featuredStaff' => $this->staffService->getFeaturedStaff(),
                'upcomingEvents' => $this->eventService->getUpcomingEvents(5),
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
            ?: 'Igniting young minds with a harmonised Cambridge and Islamic curriculum designed for the future.';

        $badge = data_get($primary, 'data.badge')
            ?: 'One School Serving the Purposes of Here & Hereafter';

        return [
            'badge' => $badge,
            'heading' => $headline ?: 'Welcome to Al-Maghrib International School',
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

        return [
            ['value' => '2012', 'label' => 'Founded'],
            ['value' => '750+', 'label' => 'Students'],
            ['value' => '120+', 'label' => 'Expert Faculty'],
            ['value' => '3', 'label' => 'Campuses'],
        ];
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
        return [
            [
                'value' => 'Cambridge | Edexcel',
                'label' => 'Dual International Curriculum Tracks',
            ],
            [
                'value' => 'Hifzul Qur\'an',
                'label' => 'Structured memorisation with daily coaching',
            ],
            [
                'value' => 'STEAM Labs',
                'label' => 'Robotics, coding & design thinking from primary years',
            ],
            [
                'value' => 'Whole-child focus',
                'label' => 'Character, wellness & co-curricular growth',
            ],
        ];
    }
}
