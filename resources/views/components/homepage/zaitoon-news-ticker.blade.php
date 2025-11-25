{{-- Zaitoon Academy News Ticker --}}
@php
    // Get news ticker settings from HomePageSection
    $homePageSections = $homePageSections ?? collect([]);
    $newsTickerSection = $homePageSections->get('news_ticker');
    
    // Get settings with defaults
    $isEnabled = true;
    $itemsCount = 10;
    $showFeaturedOnly = false;
    $animationSpeed = 40;
    
    if ($newsTickerSection) {
        $data = $newsTickerSection->data ?? [];
        // Ensure proper type casting (handle string "1" from checkboxes)
        $isEnabled = filter_var(data_get($data, 'is_enabled', true), FILTER_VALIDATE_BOOLEAN);
        $itemsCount = (int) data_get($data, 'items_count', 10);
        $showFeaturedOnly = filter_var(data_get($data, 'show_featured_only', false), FILTER_VALIDATE_BOOLEAN);
        $animationSpeed = (int) data_get($data, 'animation_speed', 40);
        
        // Check if section is active
        if (!$newsTickerSection->is_active || !$isEnabled) {
            return;
        }
    }
    
    // Pull news items from Notice model
    $newsItems = collect([]);
    try {
        if (!app()->bound('exception')) {
            $query = \App\Models\Notice::query();
            
            if ($showFeaturedOnly) {
                $query->where('is_featured', true);
            } else {
                $query->where(function($q) {
                    $q->where('is_featured', true)
                      ->orWhere('is_published', true);
                });
            }
            
            $newsItems = $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'DESC')
                ->limit($itemsCount)
            ->get();
        }
    } catch (\Throwable $e) {
        $newsItems = collect([]);
    }
    
    // Add placeholder news if empty
    if ($newsItems->isEmpty()) {
        $newsItems = collect([
            (object)['id' => 1, 'title' => '📚 New Academic Year Registration Open - Enroll Now!', 'published_at' => now(), 'slug' => '#'],
            (object)['id' => 2, 'title' => '🎓 Outstanding Results in Cambridge Examinations 2024', 'published_at' => now()->subDays(1), 'slug' => '#'],
            (object)['id' => 3, 'title' => '🕌 Ramadan Schedule: Special Prayer Times Announced', 'published_at' => now()->subDays(2), 'slug' => '#'],
            (object)['id' => 4, 'title' => '🏆 Students Win National Quran Competition', 'published_at' => now()->subDays(3), 'slug' => '#'],
            (object)['id' => 5, 'title' => '📢 Parent-Teacher Conference Scheduled for Next Week', 'published_at' => now()->subDays(4), 'slug' => '#'],
            (object)['id' => 6, 'title' => '🌟 New Science Lab Facilities Now Open', 'published_at' => now()->subDays(5), 'slug' => '#'],
            (object)['id' => 7, 'title' => '📖 Arabic Language Competition Registration Starts', 'published_at' => now()->subDays(6), 'slug' => '#'],
            (object)['id' => 8, 'title' => '🎨 Annual Art Exhibition Featuring Student Work', 'published_at' => now()->subDays(7), 'slug' => '#'],
        ]);
    }
@endphp

@if($newsItems->isNotEmpty())
<style>
    @keyframes ticker-scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    
    .ticker-wrapper {
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    
    .ticker-content {
        display: inline-flex;
        white-space: nowrap;
        will-change: transform;
    }
    
    .ticker-content:hover {
        animation-play-state: paused;
    }
</style>

<section 
    class="text-white py-3 overflow-hidden relative"
    style="background-color: #008236;"
    role="region"
    aria-label="Latest news ticker"
>
    <div class="px-6 lg:px-12">
        <div class="flex items-center gap-4">
            {{-- "Latest:" Label in Box --}}
            <div class="flex-shrink-0">
                <span class="bg-white/20 px-3 py-1 rounded text-white font-semibold text-xs uppercase tracking-wide">
                    Latest:
                </span>
            </div>
            
            {{-- Scrolling News Items --}}
            <div class="ticker-wrapper flex-1">
                <div class="ticker-content" style="animation: ticker-scroll {{ $animationSpeed }}s linear infinite;">
                    {{-- Repeat news items 4 times for smooth continuous scroll --}}
                    @foreach(range(1, 4) as $iteration)
                        @foreach($newsItems as $notice)
                            @if($notice && $notice->title)
                            <span class="inline-flex items-center gap-2 px-6">
                                {{-- Date Box --}}
                                @if($notice->published_at)
                                <span class="bg-white/20 px-2 py-0.5 rounded text-xs font-medium whitespace-nowrap">
                                    {{ $notice->published_at->format('d-M-Y') }}
                                </span>
                                @endif
                                {{-- Title --}}
                                <a 
                                    href="{{ route('notices.show', $notice->slug ?? $notice->id, false) }}" 
                                    class="text-white hover:text-yellow-300 transition-colors text-sm whitespace-nowrap"
                                    aria-label="Read notice: {{ $notice->title }}"
                                >
                                    {{ $notice->title }}
                                </a>
                                {{-- Separator --}}
                                <span class="text-yellow-300 mx-2">•</span>
                            </span>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
