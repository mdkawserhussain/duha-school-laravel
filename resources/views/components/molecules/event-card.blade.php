{{-- Event/News Card Component --}}
@props([
    'image' => null,
    'title' => 'Event Title',
    'date' => null,
    'category' => null,
    'excerpt' => null,
    'link' => '#',
    'linkText' => 'Read More',
    'featured' => false
])

<div class="bg-white rounded-xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 group h-full flex flex-col">
    {{-- Image --}}
    <div class="relative h-48 overflow-hidden {{ $featured ? 'h-64' : 'h-48' }}">
        @if($image)
        <img 
            src="{{ $image }}" 
            alt="{{ $title }}" 
            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
            loading="lazy"
        >
        @else
        <div class="w-full h-full bg-gradient-to-br from-za-green-light to-za-green-200 flex items-center justify-center">
            <svg class="w-16 h-16 text-za-green-primary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        @endif
        
        {{-- Date Badge --}}
        @if($date)
        <div class="absolute top-4 left-4 bg-za-yellow-accent text-za-green-dark font-bold px-3 py-1 rounded-lg text-sm shadow-md">
            {{ $date }}
        </div>
        @endif

        {{-- Category Badge --}}
        @if($category)
        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-za-green-primary font-semibold px-3 py-1 rounded-full text-xs">
            {{ $category }}
        </div>
        @endif

        {{-- Featured Badge --}}
        @if($featured)
        <div class="absolute bottom-4 right-4 bg-za-green-primary text-white font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide">
            Featured
        </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-6 flex-grow flex flex-col">
        {{-- Title --}}
        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-za-green-primary transition-colors duration-300 line-clamp-2">
            <a href="{{ $link }}" class="hover:underline">
                {{ $title }}
            </a>
        </h3>

        {{-- Excerpt --}}
        @if($excerpt)
        <p class="text-gray-600 mb-4 flex-grow line-clamp-3 leading-relaxed">
            {{ $excerpt }}
        </p>
        @endif

        {{-- Read More Link --}}
        <div class="mt-auto">
            <a 
                href="{{ $link }}" 
                class="inline-flex items-center text-za-green-primary font-semibold hover:text-za-yellow-accent transition-colors duration-200 group/link"
            >
                <span>{{ $linkText }}</span>
                <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
