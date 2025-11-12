<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Staff;
use Illuminate\Http\Request;

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
}

