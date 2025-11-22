<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Staff;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SearchService
{
    /**
     * Perform a search across multiple models.
     */
    public function search(string $query, int $limit = 20): array
    {
        $results = [
            'events' => collect(),
            'notices' => collect(),
            'pages' => collect(),
            'staff' => collect(),
        ];

        if (empty($query)) {
            return $results;
        }

        if ($this->shouldUseScout()) {
            try {
                $results['events'] = $this->searchScout(Event::class, $query)
                    ->where('is_published', true)
                    ->filter(fn ($item) => $item->published_at <= now());

                $results['notices'] = $this->searchScout(Notice::class, $query)
                    ->where('is_published', true)
                    ->filter(fn ($item) => $item->published_at <= now());

                $results['pages'] = $this->searchScout(Page::class, $query)
                    ->where('is_published', true)
                    ->filter(fn ($item) => $item->published_at <= now());

                $results['staff'] = $this->searchScout(Staff::class, $query)
                    ->where('is_active', true);
                    
                return $results;
            } catch (\Exception $e) {
                \Log::warning('Scout search failed, falling back to database search: ' . $e->getMessage());
            }
        }

        // Database Fallback
        $results['events'] = Event::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%");
            })
            ->orderBy('event_date', 'desc')
            ->limit($limit)
            ->get();

        $results['notices'] = Notice::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        $results['pages'] = Page::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get();

        $results['staff'] = Staff::active()
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('position', 'like', "%{$query}%")
                  ->orWhere('bio', 'like', "%{$query}%");
            })
            ->orderBy('name', 'asc')
            ->limit($limit)
            ->get();

        return $results;
    }

    /**
     * Get autocomplete suggestions.
     */
    public function autocomplete(string $query, int $limit = 10): Collection
    {
        if (empty($query) || strlen($query) < 2) {
            return collect([]);
        }

        if ($this->shouldUseScout()) {
            try {
                $events = $this->searchScout(Event::class, $query)
                    ->where('is_published', true)
                    ->filter(fn ($item) => $item->published_at <= now())
                    ->take(5)
                    ->map(fn ($item) => $this->mapSuggestion($item, 'event'));

                $notices = $this->searchScout(Notice::class, $query)
                    ->where('is_published', true)
                    ->filter(fn ($item) => $item->published_at <= now())
                    ->take(5)
                    ->map(fn ($item) => $this->mapSuggestion($item, 'notice'));

                $pages = $this->searchScout(Page::class, $query)
                    ->where('is_published', true)
                    ->filter(fn ($item) => $item->published_at <= now())
                    ->take(3)
                    ->map(fn ($item) => $this->mapSuggestion($item, 'page'));

                $staff = $this->searchScout(Staff::class, $query)
                    ->where('is_active', true)
                    ->take(3)
                    ->map(fn ($item) => $this->mapSuggestion($item, 'staff'));

                return collect([...$events, ...$notices, ...$pages, ...$staff])->take($limit);
            } catch (\Exception $e) {
                \Log::warning('Scout autocomplete failed, falling back to database search: ' . $e->getMessage());
            }
        }

        // Database Fallback
        $events = Event::published()
            ->where('title', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn ($item) => $this->mapSuggestion($item, 'event'));

        $notices = Notice::published()
            ->where('title', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(fn ($item) => $this->mapSuggestion($item, 'notice'));

        $pages = Page::published()
            ->where('title', 'like', "%{$query}%")
            ->take(3)
            ->get()
            ->map(fn ($item) => $this->mapSuggestion($item, 'page'));

        $staff = Staff::active()
            ->where('name', 'like', "%{$query}%")
            ->take(3)
            ->get()
            ->map(fn ($item) => $this->mapSuggestion($item, 'staff'));

        return collect([...$events, ...$notices, ...$pages, ...$staff])->take($limit);
    }

    protected function shouldUseScout(): bool
    {
        return config('scout.driver') !== null
            && config('scout.driver') !== 'null'
            && config('scout.driver') !== 'collection';
    }

    protected function searchScout(string $modelClass, string $query): Collection
    {
        return $modelClass::search($query)->get();
    }

    protected function mapSuggestion($item, string $type): array
    {
        $url = '#';
        $excerpt = '';

        switch ($type) {
            case 'event':
                $url = route('events.show', $item);
                $excerpt = Str::limit(strip_tags($item->excerpt ?? $item->description), 100);
                break;
            case 'notice':
                $url = route('notices.show', $item);
                $excerpt = Str::limit(strip_tags($item->excerpt ?? $item->content), 100);
                break;
            case 'page':
                $url = route($item->slug . '.show');
                $excerpt = Str::limit(strip_tags($item->content), 100);
                break;
            case 'staff':
                $url = route('staff.show', $item->id);
                $excerpt = $item->position;
                break;
        }

        return [
            'type' => $type,
            'title' => $item->title ?? $item->name,
            'url' => $url,
            'excerpt' => $excerpt,
        ];
    }
}
