@extends('admin.layouts.app')

@section('title', 'Notices & Chairman Settings')
@section('page-title', 'Notices & Chairman Settings')

@section('content')
<div class="max-w-4xl">
    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @include('admin.partials.cache-clear-button')

    <form action="{{ route('admin.homepage.notices-chairman.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Notices Display Settings -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Notices Display Settings</h3>
            <div class="space-y-6">
                <!-- Show Notices Toggle -->
                <div class="flex items-center justify-between">
                    <div>
                        <label for="show_notices" class="block text-sm font-medium text-gray-700">Show Notices</label>
                        <p class="mt-1 text-sm text-gray-500">Display recent notices in the notices & chairman section</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_notices" id="show_notices" value="1" {{ old('show_notices', $settings['show_notices']) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-za-green-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-za-green-primary"></div>
                    </label>
                </div>

                <!-- Notices Count -->
                <div>
                    <label for="notices_count" class="block text-sm font-medium text-gray-700">Number of Notices to Display <span class="text-red-500">*</span></label>
                    <input type="number" name="notices_count" id="notices_count" value="{{ old('notices_count', $settings['notices_count']) }}" min="1" max="20" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    <p class="mt-1 text-sm text-gray-500">Maximum number of notices to show (1-20)</p>
                    @error('notices_count')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Chairman Display Settings -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Chairman Message Display Settings</h3>
            <div class="space-y-6">
                <!-- Show Chairman Toggle -->
                <div class="flex items-center justify-between">
                    <div>
                        <label for="show_chairman" class="block text-sm font-medium text-gray-700">Show Chairman Message</label>
                        <p class="mt-1 text-sm text-gray-500">Display chairman's message in the notices & chairman section</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_chairman" id="show_chairman" value="1" {{ old('show_chairman', $settings['show_chairman']) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-za-green-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-za-green-primary"></div>
                    </label>
                </div>

                <!-- Chairman Excerpt Limit -->
                <div>
                    <label for="chairman_excerpt_limit" class="block text-sm font-medium text-gray-700">Chairman Message Excerpt Limit <span class="text-red-500">*</span></label>
                    <input type="number" name="chairman_excerpt_limit" id="chairman_excerpt_limit" value="{{ old('chairman_excerpt_limit', $settings['chairman_excerpt_limit']) }}" min="50" max="500" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    <p class="mt-1 text-sm text-gray-500">Maximum number of characters to display for chairman's message excerpt (50-500)</p>
                    @error('chairman_excerpt_limit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-900 mb-3">Quick Links</h3>
            <p class="text-sm text-blue-700 mb-4">Manage the content that appears in this section:</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.notices.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    Manage Notices
                </a>
                <a href="{{ route('admin.staff.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Manage Staff (Chairman)
                </a>
            </div>
            <p class="text-xs text-blue-600 mt-3">Note: The chairman message is automatically pulled from staff members with "Chairman" or "Principal" in their position title.</p>
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

