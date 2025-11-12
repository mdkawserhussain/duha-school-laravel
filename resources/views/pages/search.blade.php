@extends('layouts.app')

@section('title', 'Search Results' . ($query ? ' - ' . $query : '') . ' - Al-Maghrib International School')
@section('meta-description', 'Search results for: ' . $query)

@section('content')

    <!-- Page Header -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Search', 'url' => null]
            ]" />

            <div class="max-w-4xl mx-auto mt-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Search Results</h1>
                
                <!-- Search Form -->
                <form action="{{ route('search') }}" method="GET" class="mb-8">
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $query }}" 
                            placeholder="Search events, notices, pages..." 
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                            Search
                        </button>
                    </div>
                </form>

                @if($query)
                    <p class="text-lg text-gray-600 mb-8">
                        Found <strong>{{ $totalResults }}</strong> result{{ $totalResults !== 1 ? 's' : '' }} for "<strong>{{ $query }}</strong>"
                    </p>
                @endif
            </div>
        </div>
    </section>

    <!-- Search Results -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($totalResults === 0)
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">No results found</h2>
                    <p class="text-gray-600 mb-8">Try different keywords or browse our sections</p>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('events.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">Browse Events</a>
                        <a href="{{ route('notices.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">Browse Notices</a>
                    </div>
                </div>
            @else
                <!-- Events Results -->
                @if($results['events']->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Events ({{ $results['events']->count() }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($results['events'] as $event)
                        <x-event-card :event="$event" />
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Notices Results -->
                @if($results['notices']->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Notices ({{ $results['notices']->count() }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($results['notices'] as $notice)
                        <x-notice-card :notice="$notice" />
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Pages Results -->
                @if($results['pages']->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Pages ({{ $results['pages']->count() }})</h2>
                    <div class="space-y-4">
                        @foreach($results['pages'] as $page)
                        <div class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition duration-300">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                <a href="{{ route('about.show', $page->slug) }}" class="hover:text-blue-600 transition duration-300">
                                    {{ $page->title }}
                                </a>
                            </h3>
                            @if($page->meta_description)
                            <p class="text-gray-600">{{ Str::limit($page->meta_description, 150) }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Staff Results -->
                @if($results['staff']->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Staff ({{ $results['staff']->count() }})</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($results['staff'] as $staff)
                        <x-staff-card :staff="$staff" />
                        @endforeach
                    </div>
                </div>
                @endif
            @endif
        </div>
    </section>

@endsection

