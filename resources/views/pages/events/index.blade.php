@extends('layouts.app')

@php
    $siteName = \App\Helpers\SiteHelper::getSiteName();
@endphp
@section('title', 'Events - ' . $siteName)
@section('meta-description', 'Stay updated with upcoming events and activities at ' . $siteName)

@section('content')

    <!-- Page Header -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">School Events</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Stay connected with our school community through upcoming events, workshops, and celebrations
                </p>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="mb-8 bg-gray-50 rounded-lg p-6">
                <div class="flex flex-col gap-6">
                    <!-- Category Filters -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('events.index', array_merge(request()->except(['category', 'from_date', 'to_date']), ['upcoming' => $upcoming ?? 'all'])) }}"
                               class="px-4 py-2 rounded-full text-sm font-medium {{ !($category ?? null) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                                All Categories
                            </a>
                            <a href="{{ route('events.index', array_merge(request()->except(['category', 'from_date', 'to_date']), ['category' => 'Academic', 'upcoming' => $upcoming ?? 'all'])) }}"
                               class="px-4 py-2 rounded-full text-sm font-medium {{ ($category ?? null) === 'Academic' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                                Academic
                            </a>
                            <a href="{{ route('events.index', array_merge(request()->except(['category', 'from_date', 'to_date']), ['category' => 'Islamic', 'upcoming' => $upcoming ?? 'all'])) }}"
                               class="px-4 py-2 rounded-full text-sm font-medium {{ ($category ?? null) === 'Islamic' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                                Islamic
                            </a>
                            <a href="{{ route('events.index', array_merge(request()->except(['category', 'from_date', 'to_date']), ['category' => 'Sports', 'upcoming' => $upcoming ?? 'all'])) }}"
                               class="px-4 py-2 rounded-full text-sm font-medium {{ ($category ?? null) === 'Sports' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                                Sports
                            </a>
                            <a href="{{ route('events.index', array_merge(request()->except(['category', 'from_date', 'to_date']), ['category' => 'Cultural', 'upcoming' => $upcoming ?? 'all'])) }}"
                               class="px-4 py-2 rounded-full text-sm font-medium {{ ($category ?? null) === 'Cultural' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                                Cultural
                            </a>
                        </div>
                    </div>

                    <!-- Date Range Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                        <form method="GET" action="{{ route('events.index') }}" class="flex flex-col sm:flex-row gap-4">
                            @if($category)
                                <input type="hidden" name="category" value="{{ $category }}">
                            @endif
                            @if($upcoming && $upcoming !== 'all')
                                <input type="hidden" name="upcoming" value="{{ $upcoming }}">
                            @endif
                            
                            <div class="flex-1">
                                <label for="from_date" class="block text-xs text-gray-600 mb-1">From Date</label>
                                <input 
                                    type="date" 
                                    id="from_date" 
                                    name="from_date" 
                                    value="{{ $fromDate ?? '' }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                            
                            <div class="flex-1">
                                <label for="to_date" class="block text-xs text-gray-600 mb-1">To Date</label>
                                <input 
                                    type="date" 
                                    id="to_date" 
                                    name="to_date" 
                                    value="{{ $toDate ?? '' }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                            
                            <div class="flex items-end gap-2">
                                <button 
                                    type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300 whitespace-nowrap"
                                >
                                    Filter
                                </button>
                                @if($fromDate || $toDate)
                                <a 
                                    href="{{ route('events.index', request()->except(['from_date', 'to_date'])) }}"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-300 whitespace-nowrap"
                                >
                                    Clear
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Quick Time Filters -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quick Filters</label>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('events.index', array_merge(request()->except(['upcoming', 'from_date', 'to_date']), ['upcoming' => 'all'])) }}"
                               class="px-4 py-2 rounded-full text-sm font-medium {{ ($upcoming ?? 'all') === 'all' && !$fromDate && !$toDate ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                                All Events
                            </a>
                            <a href="{{ route('events.index', array_merge(request()->except(['upcoming', 'from_date', 'to_date']), ['upcoming' => 'upcoming'])) }}"
                               class="px-4 py-2 rounded-full text-sm font-medium {{ ($upcoming ?? 'all') === 'upcoming' && !$fromDate && !$toDate ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                                Upcoming
                            </a>
                            <a href="{{ route('events.index', array_merge(request()->except(['upcoming', 'from_date', 'to_date']), ['upcoming' => 'past'])) }}"
                               class="px-4 py-2 rounded-full text-sm font-medium {{ ($upcoming ?? 'all') === 'past' && !$fromDate && !$toDate ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                                Past Events
                            </a>
                            <a href="{{ route('events.index', array_merge(request()->except(['upcoming', 'from_date', 'to_date']), ['from_date' => now()->format('Y-m-d'), 'to_date' => now()->addMonth()->format('Y-m-d')])) }}"
                               class="px-4 py-2 rounded-full text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 transition duration-300">
                                Next Month
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Events Grid -->
            @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($events as $event)
                <x-event-card :event="$event" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $events->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No events found</h3>
                <p class="text-gray-600 mb-6">
                    @if($category)
                        No events found in the "{{ $category }}" category.
                    @else
                        There are no upcoming events at this time.
                    @endif
                </p>
                @if($category)
                <a href="{{ route('events.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                    View All Events
                </a>
                @endif
            </div>
            @endif
        </div>
    </section>


@endsection