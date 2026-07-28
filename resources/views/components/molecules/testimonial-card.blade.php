{{-- Testimonial Card Component --}}
@props([
    'quote' => 'This is a testimonial quote.',
    'author' => 'John Doe',
    'role' => 'Parent',
    'avatar' => null,
    'rating' => 5
])

<div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 h-full flex flex-col">
    {{-- Quote Icon --}}
    <div class="mb-4">
        <svg class="w-10 h-10 text-za-yellow-accent opacity-50" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
        </svg>
    </div>

    {{-- Quote Text --}}
    <blockquote class="text-gray-700 leading-relaxed mb-6 flex-grow italic text-lg">
        "{{ $quote }}"
    </blockquote>

    {{-- Rating Stars --}}
    @if($rating > 0)
    <div class="flex gap-1 mb-4">
        @for($i = 1; $i <= 5; $i++)
            <svg 
                class="w-5 h-5 {{ $i <= $rating ? 'text-za-yellow-accent' : 'text-gray-300' }}" 
                fill="currentColor" 
                viewBox="0 0 20 20"
            >
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @endfor
    </div>
    @endif

    {{-- Author Info --}}
    <div class="flex items-center gap-4 border-t border-gray-100 pt-6">
        {{-- Avatar --}}
        <div class="flex-shrink-0">
            @if($avatar)
            <img 
                src="{{ $avatar }}" 
                alt="{{ $author }}" 
                class="w-14 h-14 rounded-full object-cover border-2 border-za-green-light"
                loading="lazy"
            >
            @else
            <div class="w-14 h-14 rounded-full bg-za-green-primary text-white flex items-center justify-center font-bold text-lg">
                {{ strtoupper(substr($author, 0, 1)) }}
            </div>
            @endif
        </div>

        {{-- Name & Role --}}
        <div>
            <p class="font-bold text-gray-900">{{ $author }}</p>
            <p class="text-sm text-gray-600">{{ $role }}</p>
        </div>
    </div>
</div>
