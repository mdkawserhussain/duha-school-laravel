<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Staff;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap for the website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        // Homepage
        $sitemap->add(Url::create(route('home'))
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        // Static pages
        $staticPages = [
            ['route' => 'admission.index', 'priority' => 0.9],
            ['route' => 'careers.index', 'priority' => 0.8],
            ['route' => 'contact.index', 'priority' => 0.8],
            ['route' => 'campus.show', 'priority' => 0.7],
            ['route' => 'events.index', 'priority' => 0.9],
            ['route' => 'notices.index', 'priority' => 0.9],
            ['route' => 'staff.index', 'priority' => 0.8],
            ['route' => 'privacy.show', 'priority' => 0.3],
            ['route' => 'terms.show', 'priority' => 0.3],
        ];

        foreach ($staticPages as $page) {
            try {
                $sitemap->add(Url::create(route($page['route']))
                    ->setPriority($page['priority'])
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            } catch (\Exception $e) {
                // Route might not exist, skip it
                continue;
            }
        }

        // Dynamic pages
        Page::published()->get()->each(function ($page) use ($sitemap) {
            $url = match($page->slug) {
                'principal', 'vision' => route('about.show', $page->slug),
                'curriculum', 'policies' => route('academic.show', $page->slug),
                default => null,
            };

            if ($url) {
                $sitemap->add(Url::create($url)
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate($page->updated_at));
            }
        });

        // Events
        Event::published()->get()->each(function ($event) use ($sitemap) {
            $sitemap->add(Url::create(route('events.show', $event))
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate($event->updated_at));
        });

        // Notices
        Notice::published()->get()->each(function ($notice) use ($sitemap) {
            $sitemap->add(Url::create(route('notices.show', $notice))
                ->setPriority(0.6)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate($notice->updated_at));
        });

        // Staff
        Staff::active()->get()->each(function ($staff) use ($sitemap) {
            $sitemap->add(Url::create(route('staff.show', $staff))
                ->setPriority(0.5)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate($staff->updated_at));
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at ' . public_path('sitemap.xml'));
    }
}

