@extends('admin.layouts.app')

@section('title', 'News Ticker Settings')
@section('page-title', 'News Ticker Settings')

@section('content')
<div class="max-w-4xl">
    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        @if(session('debug_info'))
        <div class="mt-2 text-xs text-green-600">
            <strong>Saved values:</strong> Items Count: {{ session('debug_info.saved_items_count') }}, 
            Enabled: {{ session('debug_info.saved_is_enabled') ? 'Yes' : 'No' }}, 
            Active: {{ session('debug_info.saved_is_active') ? 'Yes' : 'No' }}
        </div>
        @endif
    </div>
    @endif

    @include('admin.partials.cache-clear-button')

    <form action="{{ route('admin.homepage.news-ticker.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Display Settings -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Display Settings</h3>
            <div class="space-y-6">
                <!-- Enable/Disable Toggle -->
                <div class="flex items-center justify-between">
                    <div>
                        <label for="is_enabled" class="block text-sm font-medium text-gray-700">Enable News Ticker</label>
                        <p class="mt-1 text-sm text-gray-500">Show or hide the news ticker on the homepage</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_enabled" id="is_enabled" value="1" {{ old('is_enabled', $settings['is_enabled']) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-za-green-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-za-green-primary"></div>
                    </label>
                </div>

                <!-- Items Count -->
                <div>
                    <label for="items_count" class="block text-sm font-medium text-gray-700">Number of Items to Display <span class="text-red-500">*</span></label>
                    <input type="number" name="items_count" id="items_count" value="{{ old('items_count', $settings['items_count']) }}" min="1" max="50" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    <p class="mt-1 text-sm text-gray-500">Maximum number of news items to show in the ticker (1-50)</p>
                    @error('items_count')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Show Featured Only -->
                <div class="flex items-center justify-between">
                    <div>
                        <label for="show_featured_only" class="block text-sm font-medium text-gray-700">Show Featured Only</label>
                        <p class="mt-1 text-sm text-gray-500">Only display featured notices/announcements in the ticker</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_featured_only" id="show_featured_only" value="1" {{ old('show_featured_only', $settings['show_featured_only']) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-za-green-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-za-green-primary"></div>
                    </label>
                </div>

                <!-- Animation Speed -->
                <div>
                    <label for="animation_speed" class="block text-sm font-medium text-gray-700">Animation Speed (seconds) <span class="text-red-500">*</span></label>
                    <input type="number" name="animation_speed" id="animation_speed" value="{{ old('animation_speed', $settings['animation_speed'] ?? 40) }}" min="10" max="120" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    <p class="mt-1 text-sm text-gray-500">Time in seconds for one complete scroll cycle (lower = faster, 10-120 seconds)</p>
                    @error('animation_speed')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center justify-between">
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700">Active</label>
                        <p class="mt-1 text-sm text-gray-500">Toggle the section visibility on the homepage</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $settings['is_active'] ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-za-green-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-za-green-primary"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-900 mb-3">Quick Links</h3>
            <p class="text-sm text-blue-700 mb-4">Manage the content that appears in the news ticker:</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Manage Announcements
                </a>
                <a href="{{ route('admin.notices.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Manage Notices
                </a>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg" style="background-color: #008236;" onmouseover="this.style.backgroundColor='#0a4536'" onmouseout="this.style.backgroundColor='#008236'">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection

