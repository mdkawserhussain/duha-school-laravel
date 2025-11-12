@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta-description', $page->meta_description)

@section('content')

    <!-- Page Header -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => $page->title, 'url' => null]
            ]" />

            <div class="max-w-4xl">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $page->title }}</h1>
                @if($page->excerpt)
                <p class="text-xl text-gray-600">{{ $page->excerpt }}</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Page Content -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($page->hasMedia('featured_image'))
            <div class="mb-8">
                <img src="{{ $page->getFirstMediaUrl('featured_image', 'medium') }}" alt="{{ $page->title }}" class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg" loading="lazy">
            </div>
            @endif

            <div class="prose prose-lg max-w-none">
                {!! $page->content !!}
            </div>

            <!-- Page Actions -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
                    <div class="text-sm text-gray-600">
                        Last updated: {{ $page->updated_at->format('F j, Y') }}
                    </div>
                    <div class="flex gap-4">
                        <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                            🖨️ Print Page
                        </button>
                        <button onclick="sharePage()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                            📤 Share Page
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