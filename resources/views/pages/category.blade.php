@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta-description', $page->meta_description)

@section('content')

    <!-- Category Hero Section -->
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
    <section class="py-12 sm:py-16 md:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg prose-headings:font-display prose-headings:text-aisd-midnight prose-headings:font-bold prose-p:text-gray-700 prose-a:text-aisd-ocean prose-a:font-semibold prose-a:no-underline hover:prose-a:underline prose-strong:text-aisd-midnight prose-ul:text-gray-700 prose-ol:text-gray-700 max-w-none">
                {!! $page->content !!}
            </div>
        </div>
    </section>
    @endif

    <!-- Sub-pages Grid -->
    @if($children && $children->count() > 0)
    <section class="py-12 sm:py-16 md:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($children as $child)
                    <a href="{{ $child->url }}" 
                       class="group bg-white rounded-xl shadow-soft hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 hover:border-aisd-ocean">
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
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        loading="lazy"
                                    >
                                </picture>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-aisd-midnight group-hover:text-aisd-ocean transition-colors mb-2">
                                {{ $child->title }}
                            </h3>
                            @if($child->excerpt)
                                <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                    {{ $child->excerpt }}
                                </p>
                            @endif
                            <span class="inline-flex items-center text-aisd-ocean font-semibold text-sm group-hover:underline">
                                Learn More
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

@endsection
