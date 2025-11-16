@extends('layouts.app')

@php
    $siteName = \App\Helpers\SiteHelper::getSiteName();
@endphp
@section('title', 'Notices - ' . $siteName)
@section('meta-description', 'Stay updated with important announcements and notices from ' . $siteName)

@section('content')

    <!-- Page Header -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">School Notices</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Important announcements, updates, and information for our school community
                </p>
            </div>
        </div>
    </section>

    <!-- Notices Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('notices.index') }}"
                           class="px-4 py-2 rounded-full text-sm font-medium {{ !$category ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                            All Notices
                        </a>
                        <a href="{{ route('notices.index', ['category' => 'Academic']) }}"
                           class="px-4 py-2 rounded-full text-sm font-medium {{ $category === 'Academic' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                            Academic
                        </a>
                        <a href="{{ route('notices.index', ['category' => 'Administrative']) }}"
                           class="px-4 py-2 rounded-full text-sm font-medium {{ $category === 'Administrative' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                            Administrative
                        </a>
                        <a href="{{ route('notices.index', ['category' => 'Events']) }}"
                           class="px-4 py-2 rounded-full text-sm font-medium {{ $category === 'Events' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                            Events
                        </a>
                        <a href="{{ route('notices.index', ['category' => 'General']) }}"
                           class="px-4 py-2 rounded-full text-sm font-medium {{ $category === 'General' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition duration-300">
                            General
                        </a>
                    </div>

                    @if($category)
                    <div class="text-sm text-gray-600">
                        Showing notices in: <span class="font-medium">{{ $category }}</span>
                        <a href="{{ route('notices.index') }}" class="text-blue-600 hover:text-blue-800 ml-2">Clear filter</a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Notices Grid -->
            @if($notices->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($notices as $notice)
                <x-notice-card :notice="$notice" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $notices->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No notices found</h3>
                <p class="text-gray-600 mb-6">
                    @if($category)
                        No notices found in the "{{ $category }}" category.
                    @else
                        There are no notices at this time.
                    @endif
                </p>
                @if($category)
                <a href="{{ route('notices.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                    View All Notices
                </a>
                @endif
            </div>
            @endif
        </div>
    </section>


@endsection