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
    $allNews = $news->take(12); // Get 12 items for carousel (4 visible at a time)
    $totalNews = $allNews->count();
@endphp

<section class="py-16 lg:py-24 bg-gray-50"
         x-data="{
             currentIndex: 0,
             totalItems: {{ $totalNews }},
             itemsPerView: 4,
             autoplayInterval: null,
             isPaused: false,
             init() {
                 this.updateItemsPerView();
                 window.addEventListener('resize', () => this.updateItemsPerView());
                 if (this.totalItems > this.itemsPerView) {
                     this.startAutoplay();
                 }
                 this.$el.addEventListener('mouseenter', () => { this.isPaused = true; });
                 this.$el.addEventListener('mouseleave', () => { this.isPaused = false; });
             },
             updateItemsPerView() {
                 if (window.innerWidth >= 1280) {
                     this.itemsPerView = 4;
                 } else if (window.innerWidth >= 1024) {
                     this.itemsPerView = 3;
                 } else if (window.innerWidth >= 640) {
                     this.itemsPerView = 2;
                 } else {
                     this.itemsPerView = 1;
                 }
             },
             startAutoplay() {
                 this.autoplayInterval = setInterval(() => {
                     if (!this.isPaused) {
                         this.currentIndex = (this.currentIndex + 1) % (this.totalItems - this.itemsPerView + 1);
                     }
                 }, 5000);
             }
         }"
         ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header (FR-10.1) --}}
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="text-4xl" role="img" aria-label="News icon">📰</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-800">
                    Recent News
                </h2>
            </div>
            <p class="text-sm sm:text-base text-gray-500 max-w-3xl mx-auto">
                Stay updated with the latest announcements, updates, and happenings from our institution.
            </p>
        </div>
        
        @if($allNews->isNotEmpty())
        {{-- Carousel Container (FR-10.2) --}}
        <div class="relative">
            {{-- Previous Arrow (FR-10.3) --}}
            <button 
                @click="currentIndex = currentIndex > 0 ? currentIndex - 1 : (totalItems - itemsPerView)"
                x-show="totalItems > itemsPerView"
                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-12 z-10 w-12 h-12 rounded-full bg-indigo-600 text-white shadow-lg hover:bg-indigo-700 flex items-center justify-center transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-indigo-500"
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
                    <div class="w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 shrink-0 px-3">
                        <a href="{{ route('notices.show', $item->slug ?? $item->id, false) }}" 
                           class="group bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 block h-full">
                            @if($item->hasMedia('images'))
                            <div class="relative h-44 overflow-hidden">
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
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        loading="lazy"
                                    >
                                </picture>
                            </div>
                            @else
                            <div class="h-44 bg-za-green-light flex items-center justify-center">
                                <span class="text-za-green-primary">News Image</span>
                            </div>
                            @endif
                            <div class="p-5">
                                <h3 class="text-base font-bold mb-2 line-clamp-2 leading-snug" style="color: #008236;">
                                    {{ $item->title }}
                                </h3>
                                @if($item->content)
                                <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}
                                </p>
                                @endif
                                <div class="flex items-center justify-between text-xs">
                                    <span class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $item->published_at ? $item->published_at->format('d M Y') : 'Date' }}
                                    </span>
                                    <span class="flex items-center text-za-green-primary font-medium">
                                        Read More →
                                    </span>
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
                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-12 z-10 w-12 h-12 rounded-full bg-indigo-600 text-white shadow-lg hover:bg-indigo-700 flex items-center justify-center transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                aria-label="Next news"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        
        {{-- Pagination Dots (FR-10.3) --}}
        @if($totalNews > 4)
        <div class="flex justify-center gap-2 mt-8" role="tablist" aria-label="News carousel navigation">
            @php
                $totalPages = max(1, ceil($totalNews / 4));
            @endphp
            @for($i = 0; $i < $totalPages; $i++)
            <button 
                @click="currentIndex = {{ $i * 4 }}; if (currentIndex > totalItems - itemsPerView) { currentIndex = totalItems - itemsPerView; }"
                class="h-2 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                :class="(currentIndex >= {{ $i * 4 }} && currentIndex < {{ ($i + 1) * 4 }}) ? 'bg-za-green-primary w-8' : 'bg-gray-300 w-2'"
                :aria-selected="(currentIndex >= {{ $i * 4 }} && currentIndex < {{ ($i + 1) * 4 }})"
                aria-label="Go to page {{ $i + 1 }}"
                role="tab"
                style="min-width: 0.5rem;"
            >
            </button>
            @endfor
        </div>
        @endif
        
        {{-- View All News Button (FR-10.5) --}}
        <div class="text-center mt-10">
            <a href="{{ route('notices.index', [], false) }}" 
               class="inline-flex items-center justify-center bg-za-green-primary hover:bg-za-green-dark text-white font-semibold px-8 py-3 rounded-full transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg"
               style="background-color: #008236;">
                View All News
            </a>
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-xl">
            <p class="text-gray-500">No news available at the moment.</p>
        </div>
        @endif
    </div>
</section>

