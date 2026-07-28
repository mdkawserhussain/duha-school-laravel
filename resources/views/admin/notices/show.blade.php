@extends('admin.layouts.app')

@section('title', $notice->title)
@section('page-title', 'View Notice')

@section('content')
@if(!isset($notice) || !$notice || !isset($notice->id) || !$notice->id)
    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-red-800 mb-2">Error: Notice Not Found</h3>
        <p class="text-red-600 mb-4">The notice you're trying to view could not be found or is invalid.</p>
        <a href="{{ route('admin.notices.index') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Back to Notices
        </a>
    </div>
@else
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $notice->title }}</h2>
            <p class="mt-1 text-sm text-gray-500">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $notice->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $notice->is_published ? 'Published' : 'Draft' }}
                </span>
                @if($notice->is_important)
                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    Important
                </span>
                @endif
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.notices.edit', $notice->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit</a>
            <a href="{{ route('admin.notices.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Back</a>
        </div>
    </div>

    @if($notice->hasMedia('featured_image'))
    <div class="bg-white shadow rounded-lg p-6">
        <img src="{{ $notice->getFirstMediaUrl('featured_image', 'large') }}" alt="{{ $notice->title }}" class="w-full h-auto rounded-lg">
    </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            @if($notice->category)
            <div>
                <dt class="text-sm font-medium text-gray-500">Category</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $notice->category }}</dd>
            </div>
            @endif
            <div>
                <dt class="text-sm font-medium text-gray-500">Published At</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $notice->published_at ? $notice->published_at->format('F j, Y g:i A') : 'Not published' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Slug</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $notice->slug }}</dd>
            </div>
        </dl>
    </div>

    @if($notice->excerpt)
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Excerpt</h3>
        <p class="text-gray-700">{{ $notice->excerpt }}</p>
    </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Content</h3>
        <div class="prose max-w-none">
            {!! $notice->content !!}
        </div>
    </div>
</div>
@endif
@endsection

