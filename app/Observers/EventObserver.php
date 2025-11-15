<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Str;

class EventObserver
{
    /**
     * Handle the Event "creating" event.
     */
    public function creating(Event $event): void
    {
        if (empty($event->slug)) {
            $event->slug = Str::slug($event->title);
        }
    }

    /**
     * Handle the Event "updating" event.
     */
    public function updating(Event $event): void
    {
        if (empty($event->slug) && !empty($event->title)) {
            $event->slug = Str::slug($event->title);
        }
    }

    /**
     * Handle the Event "saving" event.
     */
    public function saving(Event $event): void
    {
        // Ensure slug is unique
        if (!empty($event->slug)) {
            $originalSlug = $event->slug;
            $count = 1;
            
            while (Event::where('slug', $event->slug)
                ->where('id', '!=', $event->id ?? 0)
                ->exists()) {
                $event->slug = $originalSlug . '-' . $count;
                $count++;
            }
        }
    }
}