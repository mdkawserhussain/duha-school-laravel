@props(['notice'])

<div class="event-card bg-white rounded-2xl shadow-md overflow-hidden border border-slate-200/80 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
    @if($notice->hasMedia('featured_image'))
        <img src="{{ $notice->getFirstMediaUrl('featured_image', 'medium') }}" alt="{{ $notice->title }}" class="w-full h-40 sm:h-48 object-cover" loading="lazy">
    @else
        <div class="w-full h-40 sm:h-48 bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center">
            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
        </div>
    @endif

    <div class="p-4 sm:p-6">
        <div class="flex flex-wrap items-center gap-2 mb-2 sm:mb-3">
            <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium
                @if($notice->category === 'Academic') bg-green-100 text-green-800
                @elseif($notice->category === 'Administrative') bg-blue-100 text-blue-800
                @elseif($notice->category === 'Events') bg-yellow-100 text-yellow-800
                @elseif($notice->category === 'General') bg-gray-100 text-gray-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ $notice->category ?? 'General' }}
            </span>

            @if($notice->is_important)
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                Important
            </span>
            @endif
        </div>

        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3 line-clamp-2">
            @if($notice->slug)
            <a href="{{ route('notices.show', $notice) }}" class="hover:text-blue-600 transition duration-300 min-h-[44px] flex items-center">
                {{ $notice->title }}
            </a>
            @else
            <span class="min-h-[44px] flex items-center">{{ $notice->title }}</span>
            @endif
        </h3>

        <div class="flex items-center text-sm text-gray-600 mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ $notice->published_at->format('M j, Y') }}
        </div>

        @if($notice->content)
        <p class="text-gray-600 text-sm mb-3 sm:mb-4 line-clamp-3">
            {!! Str::limit(strip_tags($notice->content), 150) !!}
        </p>
        @endif

        @if($notice->slug)
        <a href="{{ route('notices.show', $notice) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition duration-300 min-h-[44px] py-2">
            Read More
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
        @else
        <span class="inline-flex items-center text-gray-400 font-medium min-h-[44px] py-2">
            Read More (unavailable)
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </span>
        @endif
    </div>
</div>