@extends('admin.layouts.app')

@section('title', $event->title)
@section('page-title', 'View Event')

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h2>
            <p class="mt-1 text-sm text-gray-500">
                @php
                    $status = $event->status ?? ($event->is_published ? 'published' : 'draft');
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                    {{ $status === 'published' ? 'bg-green-100 text-green-800' : 
                       ($status === 'draft' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($status) }}
                </span>
                @if($event->is_featured)
                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    Featured
                </span>
                @endif
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.events.edit', $event->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Edit
            </a>
            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Back to List
            </a>
        </div>
    </div>

    <!-- Featured Image -->
    @if($event->hasMedia('featured_image'))
    <div class="bg-white shadow rounded-lg p-6">
        <img src="{{ $event->getFirstMediaUrl('featured_image', 'large') }}" alt="{{ $event->title }}" class="w-full h-auto rounded-lg">
    </div>
    @endif

    <!-- Event Details -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Event Details</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500">Start Date & Time</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    {{ $event->start_at ? $event->start_at->format('F j, Y g:i A') : ($event->event_date ? $event->event_date->format('F j, Y') : 'Not set') }}
                </dd>
            </div>
            @if($event->end_at)
            <div>
                <dt class="text-sm font-medium text-gray-500">End Date & Time</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $event->end_at->format('F j, Y g:i A') }}</dd>
            </div>
            @endif
            @if($event->location)
            <div>
                <dt class="text-sm font-medium text-gray-500">Location</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $event->location }}</dd>
            </div>
            @endif
            @if($event->category)
            <div>
                <dt class="text-sm font-medium text-gray-500">Category</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $event->category }}</dd>
            </div>
            @endif
            <div>
                <dt class="text-sm font-medium text-gray-500">Slug</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $event->slug }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Published At</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $event->published_at ? $event->published_at->format('F j, Y g:i A') : 'Not published' }}</dd>
            </div>
        </dl>
    </div>

    <!-- Excerpt -->
    @if($event->excerpt)
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Excerpt</h3>
        <p class="text-gray-700">{{ $event->excerpt }}</p>
    </div>
    @endif

    <!-- Content -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Content</h3>
        <div class="prose max-w-none">
            {!! $event->content !!}
        </div>
    </div>

    <!-- Gallery -->
    @if($event->hasMedia('gallery'))
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Gallery</h3>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($event->getMedia('gallery') as $media)
            <div class="relative">
                <img src="{{ $media->getUrl('medium') }}" alt="Gallery image" class="w-full h-32 object-cover rounded-lg">
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

