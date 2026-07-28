@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta-description', $page->meta_description)

@section('content')

    @php
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
        ];
        
        if ($page->parent) {
            if ($page->parent->parent) {
                $breadcrumbs[] = ['title' => $page->parent->parent->title, 'url' => $page->parent->parent->url];
            }
            $breadcrumbs[] = ['title' => $page->parent->title, 'url' => $page->parent->url];
        } elseif ($page->page_category) {
            $categoryTitle = ucfirst(str_replace('-', ' ', $page->page_category));
            $categoryRoute = \App\Helpers\PageHelper::getCategoryIndexRoute($page->page_category);
            try {
                $categoryUrl = $categoryRoute ? route($categoryRoute) : $page->url;
            } catch (\Exception $e) {
                $categoryUrl = $page->url;
            }
            $breadcrumbs[] = ['title' => $categoryTitle, 'url' => $categoryUrl];
        }
        
        $breadcrumbs[] = ['title' => $page->title, 'url' => $page->url];
    @endphp

    <!-- Breadcrumbs -->
    @if(count($breadcrumbs) > 1)
        <x-breadcrumbs :items="$breadcrumbs" />
    @endif

    {{-- Hero Section with Gradient Background and Animations --}}
    <section class="relative bg-gradient-to-br from-[#E8F5E9] via-white to-[#E8F5E9] py-20 lg:py-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center space-y-6">
                @if($page->hero_badge)
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" 
                     class="inline-flex items-center gap-2 rounded-full px-4 py-2 mb-6 text-xs font-semibold uppercase tracking-wider bg-white/80 border border-[#008236]/20 text-[#008236] backdrop-blur-sm opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                     :class="{ 'opacity-100 translate-y-0': show }">
                    <span class="w-2 h-2 rounded-full bg-[#008236]"></span>
                    {{ $page->hero_badge }}
                </div>
                @endif

                <h1 x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
                    class="text-4xl lg:text-6xl font-bold text-[#008236] opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                    :class="{ 'opacity-100 translate-y-0': show }">
                    {{ $page->title }}
                </h1>

                @if($page->hero_subtitle)
                <p x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)" 
                   class="text-gray-600 text-lg leading-relaxed max-w-3xl mx-auto opacity-0 transform translate-y-8 transition-all duration-1000 delay-300 ease-out"
                   :class="{ 'opacity-100 translate-y-0': show }">
                    {{ $page->hero_subtitle }}
                </p>
                @endif
            </div>
        </div>
        
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-[#7AB91E]/10 to-transparent skew-x-12 transform origin-top-right"></div>
        <div class="absolute bottom-0 left-0 w-1/4 h-1/2 bg-gradient-to-t from-[#008236]/5 to-transparent rounded-tr-full"></div>
    </section>

    <!-- Page Content -->
    <section class="py-12 sm:py-16 md:py-20 lg:py-24 relative overflow-hidden" style="background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);">
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-[#E8F5E9]/20 rounded-full opacity-20 -translate-x-32 -translate-y-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#008236]/5 rounded-full opacity-20 translate-x-48 translate-y-48"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            @if($page->hasMedia('featured_image'))
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
                 class="mb-8 sm:mb-12 opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                 :class="{ 'opacity-100 translate-y-0': show }">
                @php
                    $featuredImage = $page->getMediaUrlRelative('featured_image', 'large');
                @endphp
                @if($featuredImage)
                <picture>
                    @php
                        $webpUrl = $page->getWebPMediaUrl('featured_image', 'large');
                    @endphp
                    @if($webpUrl)
                        <source srcset="{{ $webpUrl }}" type="image/webp">
                    @endif
                    <img 
                        src="{{ $featuredImage }}" 
                        alt="{{ $page->title }}"
                        class="w-full h-64 sm:h-80 md:h-96 object-cover rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-500" 
                        loading="lazy"
                    >
                </picture>
                @endif
            </div>
            @endif

            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)" 
                 class="prose prose-lg prose-headings:font-display prose-headings:text-[#008236] prose-headings:font-bold prose-p:text-gray-700 prose-a:text-[#008236] prose-a:font-semibold prose-a:no-underline hover:prose-a:underline prose-strong:text-[#008236] prose-ul:text-gray-700 prose-ol:text-gray-700 max-w-none opacity-0 transform translate-y-8 transition-all duration-1000 delay-300 ease-out"
                 :class="{ 'opacity-100 translate-y-0': show }">
                {!! $page->content !!}
            </div>

            <!-- Page Actions -->
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 700)" 
                 class="mt-12 pt-8 border-t border-gray-200 opacity-0 transform translate-y-8 transition-all duration-1000 delay-500 ease-out"
                 :class="{ 'opacity-100 translate-y-0': show }">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
                    <div class="text-sm text-gray-600">
                        Last updated: {{ $page->updated_at->format('F j, Y') }}
                    </div>
                    <div class="flex gap-4">
                        <button onclick="window.print()" class="inline-flex items-center justify-center rounded-xl border-2 border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition-all hover:border-gray-400 hover:bg-gray-50 hover:scale-105 min-h-[44px] shadow-sm hover:shadow-md">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print Page
                        </button>
                        <button onclick="sharePage()" class="inline-flex items-center justify-center rounded-xl border-2 border-[#008236] bg-[#008236] px-6 py-3 text-sm font-semibold text-white transition-all hover:bg-[#006a2b] hover:border-[#006a2b] hover:scale-105 min-h-[44px] shadow-lg hover:shadow-xl">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                            Share Page
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Wave decoration at bottom for smooth transition to footer --}}
        <div class="absolute bottom-0 left-0 w-full overflow-hidden pointer-events-none" style="line-height: 0; transform: translateY(1px);">
            <svg viewBox="0 0 1440 60" preserveAspectRatio="none" class="relative block w-full" style="height: 60px;">
                <path d="M0,0 L0,30 Q360,60 720,30 T1440,30 L1440,0 Z" fill="#ffffff"></path>
            </svg>
        </div>
    </section>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @media (prefers-reduced-motion: reduce) {
            .animate-float,
            [x-data] {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>

    <script>
        function sharePage() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $page->title }}',
                    text: '{{ Str::limit(strip_tags($page->content), 100) }}',
                    url: window.location.href,
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(function() {
                    alert('Page link copied to clipboard!');
                });
            }
        }
    </script>

@endsection
