<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\NoticeService;
use App\Services\StaffService;
use Illuminate\Http\Request;

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
        $cacheKey = 'homepage_data';
        $cacheTime = 3600; // 1 hour

        $data = cache()->remember($cacheKey, $cacheTime, function () {
            return [
                'featuredEvents' => $this->eventService->getFeaturedEvents(),
                'recentNotices' => $this->noticeService->getRecentNotices(),
                'featuredStaff' => $this->staffService->getFeaturedStaff(),
                'upcomingEvents' => $this->eventService->getUpcomingEvents(5),
                'visionPage' => \App\Models\Page::where('slug', 'vision')->published()->first(),
                'homePageSections' => \App\Models\HomePageSection::active()
                    ->ordered()
                    ->get()
                    ->keyBy('section_key'),
                'heroSlides' => \App\Models\HomePageSection::active()
                    ->where('section_type', 'hero')
                    ->ordered()
                    ->with('media')
                    ->get(),
            ];
        });

        return response()
            ->view('pages.home', $data)
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
