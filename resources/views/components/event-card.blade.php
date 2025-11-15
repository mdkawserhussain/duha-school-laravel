@props(['event'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
    @if($event->featured_image)
        <img src="{{ $event->featured_image }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
    @else
        <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
            </svg>
        </div>
    @endif

    <div class="p-6">
        <div class="flex items-center justify-between mb-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                @if($event->category === 'Academic') bg-green-100 text-green-800
                @elseif($event->category === 'Social') bg-blue-100 text-blue-800
                @elseif($event->category === 'Islamic') bg-yellow-100 text-yellow-800
                @elseif($event->category === 'Sports') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ $event->category ?? 'General' }}
            </span>

            @if($event->is_featured)
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                Featured
            </span>
            @endif
        </div>

        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
            <a href="{{ route('events.show', $event) }}" class="hover:text-blue-600 transition duration-300">
                {{ $event->title }}
            </a>
        </h3>

        @if($event->start_at)
        <div class="flex items-center text-sm text-gray-600 mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ $event->start_at->format('M j, Y \a\t g:i A') }}
            @if($event->end_at)
                - {{ $event->end_at->format('g:i A') }}
            @endif
        </div>
        @endif

        @if($event->location)
        <div class="flex items-center text-sm text-gray-600 mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ $event->location }}
        </div>
        @endif

        @if($event->excerpt)
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
            {!! Str::limit(strip_tags($event->excerpt), 120) !!}
        </p>
        @endif

        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition duration-300">
            Read More
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>