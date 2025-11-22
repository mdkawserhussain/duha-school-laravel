@extends('admin.layouts.app')

@section('title', $page->title)
@section('page-title', 'View Page')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $page->title }}</h2>
            <p class="mt-1 text-sm text-gray-500">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $page->is_published ? 'Published' : 'Draft' }}
                </span>
                @if($page->is_featured)
                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    Featured
                </span>
                @endif
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.pages.edit', $page->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit</a>
            <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Back</a>
        </div>
    </div>

    @if($page->hasMedia('featured_image'))
    <div class="bg-white shadow rounded-lg p-6">
        <img src="{{ $page->getFirstMediaUrl('featured_image', 'large') }}" alt="{{ $page->title }}" class="w-full h-auto rounded-lg">
    </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            @if($page->page_category)
            <div>
                <dt class="text-sm font-medium text-gray-500">Category</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('-', ' ', $page->page_category)) }}</dd>
            </div>
            @endif
            <div>
                <dt class="text-sm font-medium text-gray-500">Slug</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $page->slug }}</dd>
            </div>
            @if($page->published_at)
            <div>
                <dt class="text-sm font-medium text-gray-500">Published At</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $page->published_at->format('F j, Y g:i A') }}</dd>
            </div>
            @endif
        </dl>
    </div>

    @if($page->excerpt)
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Excerpt</h3>
        <p class="text-gray-700">{{ $page->excerpt }}</p>
    </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Content</h3>
        <div class="prose max-w-none">
            {!! $page->content !!}
        </div>
    </div>

    @if($page->meta_title || $page->meta_description)
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>
        <dl class="space-y-2">
            @if($page->meta_title)
            <div>
                <dt class="text-sm font-medium text-gray-500">Meta Title</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $page->meta_title }}</dd>
            </div>
            @endif
            @if($page->meta_description)
            <div>
                <dt class="text-sm font-medium text-gray-500">Meta Description</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $page->meta_description }}</dd>
            </div>
            @endif
            @if($page->seo_keywords && is_array($page->seo_keywords) && count($page->seo_keywords) > 0)
            <div>
                <dt class="text-sm font-medium text-gray-500">SEO Keywords</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ implode(', ', $page->seo_keywords) }}</dd>
            </div>
            @endif
        </dl>
    </div>
    @endif
</div>
@endsection

