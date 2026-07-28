@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta-description', $page->meta_description)

@section('content')

    {{-- Category Hero Section with Gradient Background and Animations --}}
    @php
        $heroImage = $page->hasMedia('hero_image') 
            ? $page->getMediaUrlRelative('hero_image', 'large') 
            : null;
    @endphp

    <section class="relative bg-gradient-to-br from-[#E8F5E9] via-white to-[#E8F5E9] py-20 lg:py-28 overflow-hidden">
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-[#7AB91E]/10 to-transparent skew-x-12 transform origin-top-right"></div>
        <div class="absolute bottom-0 left-0 w-1/4 h-1/2 bg-gradient-to-t from-[#008236]/5 to-transparent rounded-tr-full"></div>
        <div class="absolute top-10 right-10 w-32 h-32 bg-[#008236]/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-10 w-40 h-40 bg-[#7AB91E]/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>

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
    </section>

    <!-- Breadcrumbs -->
    @if($page->parent || $page->page_category)
    <nav class="bg-gray-50 border-b border-gray-200" aria-label="Breadcrumb">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-aisd-ocean transition-colors">
                        Home
                    </a>
                </li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700 font-medium">{{ $page->title }}</span>
                </li>
            </ol>
        </div>
    </nav>
    @endif

    <!-- Category Introduction -->
    @if($page->content)
    <section class="py-12 sm:py-16 md:py-20 bg-white relative overflow-hidden">
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-[#E8F5E9]/20 rounded-full opacity-20 -translate-x-32 -translate-y-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#008236]/5 rounded-full opacity-20 translate-x-48 translate-y-48"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
                 class="prose prose-lg prose-headings:font-display prose-headings:text-[#008236] prose-headings:font-bold prose-p:text-gray-700 prose-a:text-[#008236] prose-a:font-semibold prose-a:no-underline hover:prose-a:underline prose-strong:text-[#008236] prose-ul:text-gray-700 prose-ol:text-gray-700 max-w-none opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                 :class="{ 'opacity-100 translate-y-0': show }">
                {!! $page->content !!}
            </div>
        </div>
    </section>
    @endif

    <!-- Sub-pages Grid -->
    @if($children && $children->count() > 0)
    <section class="py-12 sm:py-16 md:py-20 bg-[#F9FAFB] relative overflow-hidden">
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-[#E8F5E9]/20 rounded-full opacity-20 -translate-x-32 -translate-y-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#008236]/5 rounded-full opacity-20 translate-x-48 translate-y-48"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($children as $index => $child)
                    <a href="{{ $child->url }}" 
                       x-data="{ show: false }" 
                       x-init="setTimeout(() => show = true, {{ 300 + ($index * 100) }})"
                       class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-500 ease-in-out overflow-hidden border border-gray-100 hover:border-[#008236] hover:scale-105 opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                       :class="{ 'opacity-100 translate-y-0': show }">
                        @if($child->hasMedia('featured_image'))
                            <div class="relative h-48 overflow-hidden">
                                @php
                                    $featuredImage = $child->getMediaUrlRelative('featured_image', 'medium');
                                    $webpUrl = $child->getWebPMediaUrl('featured_image', 'medium');
                                @endphp
                                <picture>
                                    @if($webpUrl)
                                        <source srcset="{{ $webpUrl }}" type="image/webp">
                                    @endif
                                    <img 
                                        src="{{ $featuredImage }}" 
                                        alt="{{ $child->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        loading="lazy"
                                    >
                                </picture>
                                {{-- Overlay on hover --}}
                                <div class="absolute inset-0 bg-[#008236]/0 group-hover:bg-[#008236]/10 transition-colors duration-500"></div>
                            </div>
                        @else
                            {{-- Placeholder with icon --}}
                            <div class="relative h-48 bg-gradient-to-br from-[#E8F5E9] to-white flex items-center justify-center group-hover:from-[#008236]/10 group-hover:to-[#E8F5E9] transition-all duration-500">
                                <div class="w-16 h-16 rounded-full bg-[#E8F5E9] flex items-center justify-center group-hover:bg-[#008236] group-hover:scale-110 transition-all duration-500">
                                    <svg class="w-8 h-8 text-[#008236] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-[#008236] group-hover:text-[#006a2b] transition-colors duration-300 mb-2">
                                {{ $child->title }}
                            </h3>
                            @if($child->excerpt)
                                <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                    {{ $child->excerpt }}
                                </p>
                            @endif
                            <span class="inline-flex items-center text-[#008236] font-semibold text-sm group-hover:underline transition-all duration-300">
                                Learn More
                                <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

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

@endsection
