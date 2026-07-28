{{-- Feature Card Component for Zaitoon Academy --}}
@props([
    'icon' => null,
    'iconBg' => 'bg-za-green-light',
    'iconColor' => 'text-za-green-primary',
    'title' => 'Feature Title',
    'description' => 'Feature description goes here.',
    'link' => null,
    'linkText' => 'Learn More',
    'animate' => true
])

<div 
    @if($animate)
    x-data="{ show: false }"
    x-intersect.once="show = true"
    x-show="show"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-8"
    x-transition:enter-end="opacity-100 translate-y-0"
    style="display: none;"
    @endif
    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 group h-full flex flex-col"
>
    {{-- Icon --}}
    @if($icon)
    <div class="mb-6">
        <div class="w-16 h-16 {{ $iconBg }} rounded-full flex items-center justify-center group-hover:bg-za-green-primary transition-all duration-300 group-hover:scale-110">
            <div class="{{ $iconColor }} group-hover:text-white transition-colors duration-300">
                {!! $icon !!}
            </div>
        </div>
    </div>
    @endif

    {{-- Title --}}
    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-za-green-primary transition-colors duration-300">
        {{ $title }}
    </h3>

    {{-- Description --}}
    <p class="text-gray-600 leading-relaxed mb-6 flex-grow">
        {{ $description }}
    </p>

    {{-- Link --}}
    @if($link)
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
    @endif
</div>
