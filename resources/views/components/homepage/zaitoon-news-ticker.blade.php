{{-- Zaitoon Academy News Ticker (FR-4) --}}
@php
    // Pull news items from Notice model (FR-4.4)
    $newsItems = collect([]);
    try {
        if (!app()->bound('exception')) {
            $newsItems = \App\Models\Notice::where(function($query) {
                $query->where('is_featured', true)
                      ->orWhere('is_published', true);
            })
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'DESC')
            ->limit(10)
            ->get();
        }
    } catch (\Throwable $e) {
        $newsItems = collect([]);
    }
@endphp

@if($newsItems->isNotEmpty())
<section 
    class="bg-za-green-primary text-white py-2 overflow-hidden relative"
    style="background-color: #1a5e4a;"
    x-data="{ isPaused: false }"
    @mouseenter="isPaused = true"
    @mouseleave="isPaused = false"
    role="region"
    aria-label="Latest news ticker"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4">
            {{-- "Latest:" Label (FR-4.2) --}}
            <div class="flex-shrink-0">
                <span class="text-white font-semibold text-xs uppercase tracking-wide">Latest:</span>
            </div>
            
            {{-- Scrolling News Items (FR-4.3, FR-4.5) --}}
            <div class="flex-1 overflow-hidden">
                <div 
                    class="marquee-content inline-block whitespace-nowrap"
                    :style="isPaused ? 'animation-play-state: paused;' : 'animation-play-state: running;'"
                >
                    @foreach($newsItems as $notice)
                        @if($notice && $notice->title)
                        <span class="inline-block px-8">
                            <a 
                                href="{{ route('notices.show', $notice->slug ?? $notice->id, false) }}" 
                                class="text-white hover:text-za-yellow-accent transition-colors text-xs"
                                aria-label="Read notice: {{ $notice->title }}"
                            >
                                {{ $notice->title }}
                            </a>
                        </span>
                        @endif
                    @endforeach
                    {{-- Duplicate for seamless loop (FR-4.5) --}}
                    @foreach($newsItems as $notice)
                        @if($notice && $notice->title)
                        <span class="inline-block px-8">
                            <a 
                                href="{{ route('notices.show', $notice->slug ?? $notice->id, false) }}" 
                                class="text-white hover:text-za-yellow-accent transition-colors text-xs"
                                aria-label="Read notice: {{ $notice->title }}"
                            >
                                {{ $notice->title }}
                            </a>
                        </span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    @keyframes marquee-scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    
    .marquee-content {
        animation: marquee-scroll 20s linear infinite;
        display: inline-block;
    }
    
    .marquee-content:hover {
        animation-play-state: paused;
    }
</style>
@endpush
@endif

