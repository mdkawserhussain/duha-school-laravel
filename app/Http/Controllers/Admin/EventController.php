<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EventController extends BaseController
{
    public function index(Request $request)
    {
        $query = Event::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'published') {
                $query->where('is_published', true)->where('published_at', '<=', now());
            } elseif ($status === 'draft') {
                $query->where(function ($q) {
                    $q->where('is_published', false)->orWhereNull('published_at');
                });
            } elseif ($status === 'archived') {
                $query->where('is_published', false);
            }
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        // Upcoming filter
        if ($request->filled('upcoming')) {
            if (Schema::hasColumn('events', 'start_at')) {
                $query->where('start_at', '>', now());
            } else {
                $query->where('event_date', '>', now());
            }
        }

        // Sort
        $sortField = Schema::hasColumn('events', 'start_at') ? 'start_at' : 'event_date';
        $sortDirection = $request->get('sort', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $events = $query->paginate(15)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        
        // Handle status and is_published
        $data['is_published'] = $data['status'] === 'published';
        
        // Ensure event_date is set
        if (empty($data['event_date']) && !empty($data['start_at'])) {
            $data['event_date'] = $data['start_at'];
        } elseif (empty($data['event_date'])) {
            $data['event_date'] = now();
        }

        $event = Event::create($data);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $event->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image');
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $event->addMedia($file->getRealPath())
                    ->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        $data = $request->validated();
        
        // Handle status and is_published
        $data['is_published'] = $data['status'] === 'published';
        
        // Ensure event_date is set
        if (empty($data['event_date']) && !empty($data['start_at'])) {
            $data['event_date'] = $data['start_at'];
        }

        $event->update($data);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $event->clearMediaCollection('featured_image');
            $event->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image');
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $event->addMedia($file->getRealPath())
                    ->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
