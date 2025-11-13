<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (empty($query)) {
            return redirect()->route('home');
        }

        $results = [
            'events' => collect(),
            'notices' => collect(),
            'pages' => collect(),
            'staff' => collect(),
        ];

        // Use Scout search if configured, otherwise fallback to database search
        $useScout = config('scout.driver') !== null
            && config('scout.driver') !== 'null'
            && config('scout.driver') !== 'collection';

        if ($useScout) {
            // Scout search with proper filtering
            try {
                $results['events'] = Event::search($query)
                    ->where('is_published', true)
                    ->get()
                    ->filter(function ($event) {
                        return $event->is_published && $event->published_at <= now();
                    });

                $results['notices'] = Notice::search($query)
                    ->where('is_published', true)
                    ->get()
                    ->filter(function ($notice) {
                        return $notice->is_published && $notice->published_at <= now();
                    });

                $results['pages'] = Page::search($query)
                    ->where('is_published', true)
                    ->get()
                    ->filter(function ($page) {
                        return $page->is_published && $page->published_at <= now();
                    });

                $results['staff'] = Staff::search($query)
                    ->where('is_active', true)
                    ->get()
                    ->filter(function ($staff) {
                        return $staff->is_active;
                    });
            } catch (\Exception $e) {
                // Fallback to database search if Scout fails
                \Log::warning('Scout search failed, falling back to database search: ' . $e->getMessage());
                $useScout = false;
            }
        }

        if (!$useScout) {
            // Fallback to database search
            $results['events'] = Event::published()
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('excerpt', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('location', 'like', "%{$query}%");
                })
                ->orderBy('event_date', 'desc')
                ->limit(20)
                ->get();

            $results['notices'] = Notice::published()
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('excerpt', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->orderBy('published_at', 'desc')
                ->limit(20)
                ->get();

            $results['pages'] = Page::published()
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->orderBy('updated_at', 'desc')
                ->limit(20)
                ->get();

            $results['staff'] = Staff::active()
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('position', 'like', "%{$query}%")
                      ->orWhere('bio', 'like', "%{$query}%");
                })
                ->orderBy('name', 'asc')
                ->limit(20)
                ->get();
        }

        $totalResults = $results['events']->count()
            + $results['notices']->count()
            + $results['pages']->count()
            + $results['staff']->count();

        return view('pages.search', [
            'query' => $query,
            'results' => $results,
            'totalResults' => $totalResults,
            'usingScout' => $useScout,
        ]);
    }

    public function autocomplete(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (empty($query) || strlen($query) < 2) {
            return response()->json(['suggestions' => []]);
        }

        $suggestions = [];

        // Use Scout search if configured
        $useScout = config('scout.driver') !== null
            && config('scout.driver') !== 'null'
            && config('scout.driver') !== 'collection';

        if ($useScout) {
            try {
                // Get suggestions from different models
                $events = Event::search($query)
                    ->where('is_published', true)
                    ->take(5)
                    ->get()
                    ->filter(function ($event) {
                        return $event->is_published && $event->published_at <= now();
                    })
                    ->map(function ($event) {
                        return [
                            'type' => 'event',
                            'title' => $event->title,
                            'url' => route('events.show', $event),
                            'excerpt' => Str::limit(strip_tags($event->excerpt ?? $event->description), 100),
                        ];
                    });

                $notices = Notice::search($query)
                    ->where('is_published', true)
                    ->take(5)
                    ->get()
                    ->filter(function ($notice) {
                        return $notice->is_published && $notice->published_at <= now();
                    })
                    ->map(function ($notice) {
                        return [
                            'type' => 'notice',
                            'title' => $notice->title,
                            'url' => route('notices.show', $notice),
                            'excerpt' => Str::limit(strip_tags($notice->excerpt ?? $notice->content), 100),
                        ];
                    });

                $pages = Page::search($query)
                    ->where('is_published', true)
                    ->take(3)
                    ->get()
                    ->filter(function ($page) {
                        return $page->is_published && $page->published_at <= now();
                    })
                    ->map(function ($page) {
                        return [
                            'type' => 'page',
                            'title' => $page->title,
                            'url' => route($page->slug . '.show'),
                            'excerpt' => Str::limit(strip_tags($page->content), 100),
                        ];
                    });

                $staff = Staff::search($query)
                    ->where('is_active', true)
                    ->take(3)
                    ->get()
                    ->filter(function ($staff) {
                        return $staff->is_active;
                    })
                    ->map(function ($staff) {
                        return [
                            'type' => 'staff',
                            'title' => $staff->name,
                            'url' => route('staff.show', $staff->id),
                            'excerpt' => $staff->position,
                        ];
                    });

                $suggestions = collect([...$events, ...$notices, ...$pages, ...$staff])->take(10);

            } catch (\Exception $e) {
                \Log::warning('Scout autocomplete failed, falling back to database search: ' . $e->getMessage());
                $useScout = false;
            }
        }

        if (!$useScout) {
            // Fallback to database search
            $events = Event::published()
                ->where('title', 'like', "%{$query}%")
                ->take(5)
                ->get()
                ->map(function ($event) {
                    return [
                        'type' => 'event',
                        'title' => $event->title,
                        'url' => route('events.show', $event),
                        'excerpt' => Str::limit(strip_tags($event->excerpt ?? $event->description), 100),
                    ];
                });

            $notices = Notice::published()
                ->where('title', 'like', "%{$query}%")
                ->take(5)
                ->get()
                ->map(function ($notice) {
                    return [
                        'type' => 'notice',
                        'title' => $notice->title,
                        'url' => route('notices.show', $notice),
                        'excerpt' => Str::limit(strip_tags($notice->excerpt ?? $notice->content), 100),
                    ];
                });

            $pages = Page::published()
                ->where('title', 'like', "%{$query}%")
                ->take(3)
                ->get()
                ->map(function ($page) {
                    return [
                        'type' => 'page',
                        'title' => $page->title,
                        'url' => route($page->slug . '.show'),
                        'excerpt' => Str::limit(strip_tags($page->content), 100),
                    ];
                });

            $staff = Staff::active()
                ->where('name', 'like', "%{$query}%")
                ->take(3)
                ->get()
                ->map(function ($staff) {
                    return [
                        'type' => 'staff',
                        'title' => $staff->name,
                        'url' => route('staff.show', $staff->id),
                        'excerpt' => $staff->position,
                    ];
                });

            $suggestions = collect([...$events, ...$notices, ...$pages, ...$staff])->take(10);
        }

        return response()->json([
            'suggestions' => $suggestions->values(),
            'query' => $query
        ]);
    }
}

