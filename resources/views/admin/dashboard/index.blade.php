@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
        @foreach($stats as $key => $stat)
        <a href="{{ $stat['url'] }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if($stat['color'] === 'green')
                            <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        @elseif($stat['color'] === 'blue')
                            <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @elseif($stat['color'] === 'purple')
                            <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        @else
                            <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">{{ $stat['label'] }}</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ number_format($stat['count']) }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-xs text-gray-500">{{ $stat['description'] }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('admin.events.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900">New Event</span>
                </a>
                <a href="{{ route('admin.notices.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900">New Notice</span>
                </a>
                <a href="{{ route('admin.pages.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900">New Page</span>
                </a>
                <a href="{{ route('admin.hero-slider.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-900">Manage Hero</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Recent Events -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Events</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentEvents as $event)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            @if(isset($event) && $event && isset($event->id) && $event->id)
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="text-sm font-medium text-gray-900 hover:text-za-green-primary">
                                {{ $event->title }}
                            </a>
                            @else
                            <span class="text-sm font-medium text-gray-900">{{ $event->title ?? 'Untitled Event' }}</span>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">
                                @if($event->start_at)
                                    {{ $event->start_at->format('M d, Y') }}
                                @else
                                    No date set
                                @endif
                            </p>
                        </div>
                        <div class="ml-4">
                            @if($event->is_published)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Draft
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-sm text-gray-500">
                    No events yet
                </div>
                @endforelse
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-za-green-primary hover:text-za-green-dark">
                    View all events →
                </a>
            </div>
        </div>

        <!-- Recent Notices -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Notices</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentNotices as $notice)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            @if(isset($notice) && $notice && isset($notice->id) && $notice->id)
                            <a href="{{ route('admin.notices.edit', $notice->id) }}" class="text-sm font-medium text-gray-900 hover:text-za-green-primary">
                                {{ $notice->title }}
                            </a>
                            @else
                            <span class="text-sm font-medium text-gray-900">{{ $notice->title ?? 'Untitled Notice' }}</span>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">
                                @if($notice->published_at)
                                    {{ $notice->published_at->format('M d, Y') }}
                                @else
                                    Not published
                                @endif
                            </p>
                        </div>
                        <div class="ml-4">
                            @if($notice->is_published)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Draft
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-sm text-gray-500">
                    No notices yet
                </div>
                @endforelse
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                <a href="{{ route('admin.notices.index') }}" class="text-sm font-medium text-za-green-primary hover:text-za-green-dark">
                    View all notices →
                </a>
            </div>
        </div>
    </div>

    @if(auth()->user()->hasAnyRole(['admin', 'admissions_officer']))
    <!-- Recent Applications -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Admission Applications</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recentApplications as $application)
            <div class="p-4 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('admin.admission-applications.show', $application) }}" class="text-sm font-medium text-gray-900 hover:text-za-green-primary">
                            {{ $application->name }}
                        </a>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $application->email }} • {{ $application->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($application->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-sm text-gray-500">
                No applications yet
            </div>
            @endforelse
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <a href="{{ route('admin.admission-applications.index') }}" class="text-sm font-medium text-za-green-primary hover:text-za-green-dark">
                View all applications →
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

