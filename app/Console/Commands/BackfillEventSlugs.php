<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BackfillEventSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:backfill-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill missing slugs for existing events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting event slug backfill...');

        $events = Event::whereNull('slug')
            ->orWhere('slug', '')
            ->get();

        if ($events->isEmpty()) {
            $this->info('No events need slug backfilling.');
            return 0;
        }

        $this->info("Found {$events->count()} events without slugs.");

        $bar = $this->output->createProgressBar($events->count());
        $bar->start();

        $updated = 0;
        foreach ($events as $event) {
            if (empty($event->title)) {
                $this->warn("Skipping event ID {$event->id} - no title");
                $bar->advance();
                continue;
            }

            $slug = $this->generateUniqueSlug($event->title, $event->id);
            $event->slug = $slug;
            $event->saveQuietly(); // Save without triggering events
            $updated++;

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully backfilled slugs for {$updated} events.");

        return 0;
    }

    /**
     * Generate a unique slug for the given title.
     */
    protected function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        $query = Event::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $query = Event::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            $counter++;
        }

        return $slug;
    }
}
