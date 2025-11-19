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

    <!-- Page Hero Section -->
    @php
        $heroImage = $page->hasMedia('hero_image') 
            ? $page->getMediaUrlRelative('hero_image', 'large') 
            : null;
    @endphp

    <x-page-hero 
        :title="$page->title"
        :subtitle="$page->hero_subtitle"
        :badge="$page->hero_badge"
        :heroImage="$heroImage"
    />

    <!-- Page Content -->
    <section class="py-12 sm:py-16 md:py-20 lg:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($page->hasMedia('featured_image'))
            <div class="mb-8 sm:mb-12">
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
                        class="w-full h-64 sm:h-80 md:h-96 object-cover rounded-2xl shadow-modern" 
                        loading="lazy"
                    >
                </picture>
                @endif
            </div>
            @endif

            <div class="prose prose-lg prose-headings:font-display prose-headings:text-aisd-midnight prose-headings:font-bold prose-p:text-gray-700 prose-a:text-aisd-ocean prose-a:font-semibold prose-a:no-underline hover:prose-a:underline prose-strong:text-aisd-midnight prose-ul:text-gray-700 prose-ol:text-gray-700 max-w-none">
                {!! $page->content !!}
            </div>

            <!-- Page Actions -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
                    <div class="text-sm text-gray-600">
                        Last updated: {{ $page->updated_at->format('F j, Y') }}
                    </div>
                    <div class="flex gap-4">
                        <button onclick="window.print()" class="inline-flex items-center justify-center rounded-xl border-2 border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition-all hover:border-gray-400 hover:bg-gray-50 min-h-[44px]">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print Page
                        </button>
                        <button onclick="sharePage()" class="inline-flex items-center justify-center rounded-xl border-2 border-aisd-ocean bg-aisd-ocean px-6 py-3 text-sm font-semibold text-white transition-all hover:bg-aisd-cobalt hover:border-aisd-cobalt min-h-[44px]">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                            Share Page
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
