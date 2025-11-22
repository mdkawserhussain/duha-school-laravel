@extends('admin.layouts.app')

@section('title', 'Hero Slider')
@section('page-title', 'Hero Slider Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Hero Slider</h2>
            <p class="mt-1 text-sm text-gray-600">Manage homepage hero slides</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.hero-slider.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                New Slide
            </a>
        </div>
    </div>

    <!-- Slides List -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="divide-y divide-gray-200">
            @forelse($slides as $slide)
            <div class="p-6 hover:bg-gray-50">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        @if($slide['image_url'])
                        <img src="{{ $slide['image_url'] }}" alt="Slide image" class="h-24 w-40 object-cover rounded-lg">
                        @else
                        <div class="h-24 w-40 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 text-xs">No Image</span>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $slide['title'] ?: 'Untitled Slide' }}</h3>
                                @if($slide['subtitle'])
                                <p class="text-sm text-gray-500 mt-1">{{ $slide['subtitle'] }}</p>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $slide['is_active'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $slide['is_active'] ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="text-xs text-gray-500">Order: {{ $slide['sort_order'] }}</span>
                            </div>
                        </div>
                        @if($slide['description'])
                        <p class="text-sm text-gray-600 mt-2">{{ Str::limit($slide['description'], 100) }}</p>
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.hero-slider.edit', $slide['id']) }}" class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                            Edit
                        </a>
                        <form action="{{ route('admin.hero-slider.toggle-active', $slide['id']) }}" method="POST" class="inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="px-3 py-1.5 bg-gray-600 text-white text-sm rounded-lg hover:bg-gray-700">
                                {{ $slide['is_active'] ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.hero-slider.duplicate', $slide['id']) }}" method="POST" class="inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="px-3 py-1.5 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700">
                                Duplicate
                            </button>
                        </form>
                        <form action="{{ route('admin.hero-slider.destroy', $slide['id']) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <p class="text-sm text-gray-500">No hero slides found. <a href="{{ route('admin.hero-slider.create') }}" class="text-za-green-primary hover:text-za-green-dark">Create one</a></p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

