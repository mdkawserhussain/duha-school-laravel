{{-- Zaitoon Academy: Recent News (FR-10) --}}
@php
    // Get recent news/notices (FR-10.4)
    $recentNotices = $recentNotices ?? collect([]);
    $importantNotices = $importantNotices ?? collect([]);
    $news = $recentNotices;
    if ($news->isEmpty() && $importantNotices->isNotEmpty()) {
        $news = $importantNotices;
    }
    // Get more news items for carousel
    $allNews = $news->take(9); // Get 9 items for carousel (3 visible at a time)
    $totalNews = $allNews->count();
@endphp

<section class="py-16 lg:py-24 bg-gray-50"
         x-data="{
             currentIndex: 0,
             totalItems: {{ $totalNews }},
             itemsPerView: 3,
             autoplayInterval: null,
             isPaused: false
         }"
         x-init="
             function updateItemsPerView() {
                 if (window.innerWidth >= 1024) {
                     itemsPerView = 3;
                 } else if (window.innerWidth >= 640) {
                     itemsPerView = 2;
                 } else {
                     itemsPerView = 1;
                 }
             }
             updateItemsPerView();
             window.addEventListener('resize', updateItemsPerView);
             
             // Optional autoplay (FR-10.3)
             if (totalItems > itemsPerView) {
                 autoplayInterval = setInterval(function() {
                     if (!isPaused) {
                         currentIndex = (currentIndex + 1) % (totalItems - itemsPerView + 1);
                     }
                 }, 5000);
             }
             
             $el.addEventListener('mouseenter', function() {
                 isPaused = true;
             });
             $el.addEventListener('mouseleave', function() {
                 isPaused = false;
             });
         ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header (FR-10.1) --}}
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-10 h-10 bg-za-green-primary rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-za-green-primary">
                    Recent News
                </h2>
            </div>
            <p class="text-base sm:text-lg text-gray-600 max-w-3xl mx-auto">
                Stay informed with the latest updates from Zaitoon Academy
            </p>
        </div>
        
        @if($allNews->isNotEmpty())
        {{-- Carousel Container (FR-10.2) --}}
        <div class="relative">
            {{-- Previous Arrow (FR-10.3) --}}
            <button 
                @click="currentIndex = currentIndex > 0 ? currentIndex - 1 : (totalItems - itemsPerView)"
                x-show="totalItems > itemsPerView"
                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-12 z-10 w-12 h-12 rounded-full bg-white shadow-lg hover:bg-za-green-primary hover:text-white flex items-center justify-center transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-za-green-500"
                aria-label="Previous news"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            {{-- News Carousel (FR-10.2) --}}
            <div class="overflow-hidden">
                <div 
                    class="flex transition-transform duration-500 ease-in-out"
                    :style="'transform: translateX(-' + (currentIndex * (100 / itemsPerView)) + '%)'"
                >
                    @foreach($allNews as $item)
                    <div class="w-full sm:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                        <a href="{{ route('notices.show', $item->slug ?? $item->id, false) }}" 
                           class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 block h-full">
                            @if($item->hasMedia('images'))
                            <div class="relative h-48 overflow-hidden">
                                @php
                                    // FIXED: Using proper method with asset()
                                    $webpUrl = $item->getMediaUrl('images', 'webp');
                                    $imageUrl = $item->getMediaUrl('images', 'medium');
                                @endphp
                                <picture>
                                    @if($webpUrl)
                                        <source srcset="{{ $item->getMediaUrl('images', 'webp') }}" type="image/webp">
                                    @endif
                                    <img 
                                        src="{{ $imageUrl }}" 
                                        alt="{{ $item->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                        loading="lazy"
                                    >
                                </picture>
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg">
                                    <p class="text-xs font-semibold text-za-green-primary">
                                        {{ $item->published_at ? $item->published_at->format('d M Y') : 'Date' }}
                                    </p>
                                </div>
                            </div>
                            @else
                            <div class="h-48 bg-za-green-light flex items-center justify-center">
                                <span class="text-za-green-primary">News Image</span>
                            </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-za-green-primary transition-colors line-clamp-2">
                                    {{ $item->title }}
                                </h3>
                                @if($item->content)
                                <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}
                                </p>
                                @endif
                                <div class="flex items-center text-za-green-primary text-sm font-medium">
                                    Read More
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Next Arrow (FR-10.3) --}}
            <button 
                @click="currentIndex = currentIndex < (totalItems - itemsPerView) ? currentIndex + 1 : 0"
                x-show="totalItems > itemsPerView"
                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-12 z-10 w-12 h-12 rounded-full bg-white shadow-lg hover:bg-za-green-primary hover:text-white flex items-center justify-center transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-za-green-500"
                aria-label="Next news"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        
        {{-- Pagination Dots (FR-10.3) --}}
        @if($totalNews > 3)
        <div class="flex justify-center gap-2 mt-8" role="tablist" aria-label="News carousel navigation">
            @for($i = 0; $i < max(1, ceil($totalNews / 3)); $i++)
            <button 
                @click="currentIndex = {{ $i * 3 }}"
                class="w-3 h-3 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-za-green-500"
                :class="Math.floor(currentIndex / 3) === {{ $i }} ? 'bg-za-green-primary' : 'bg-gray-300'"
                :aria-selected="Math.floor(currentIndex / 3) === {{ $i }}"
                aria-label="Go to page {{ $i + 1 }}"
                role="tab"
            >
            </button>
            @endfor
        </div>
        @endif
        
        {{-- View All News Button (FR-10.5) --}}
        <div class="text-center mt-8">
            <a href="{{ route('notices.index', [], false) }}" 
               class="inline-flex items-center justify-center bg-za-green-primary hover:bg-za-green-dark text-white font-semibold px-8 py-3 rounded-lg transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
                View All News
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-xl">
            <p class="text-gray-500">No news available at the moment.</p>
        </div>
        @endif
    </div>
</section>

