@extends('admin.layouts.app')

@section('title', $content->title ?: $content->section_key)
@section('page-title', 'View Homepage Content')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $content->title ?: $content->section_key }}</h2>
            <p class="mt-1 text-sm text-gray-500">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $content->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $content->is_active ? 'Active' : 'Inactive' }}
                </span>
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.homepage-contents.edit', $content) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit</a>
            <a href="{{ route('admin.homepage-contents.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Back</a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500">Section Key</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $content->section_key }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Section Type</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($content->section_type) }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Sort Order</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $content->sort_order }}</dd>
            </div>
        </dl>
    </div>

    @if($content->content)
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Content</h3>
        <div class="prose max-w-none">
            {!! $content->content !!}
        </div>
    </div>
    @endif

    @if($content->data && count($content->data) > 0)
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Data</h3>
        <pre class="bg-gray-50 p-4 rounded-lg overflow-x-auto text-sm"><code>{{ json_encode($content->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
    </div>
    @endif
</div>
@endsection

