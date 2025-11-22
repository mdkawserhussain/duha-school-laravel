{{-- Section Wrapper Template for Zaitoon Academy --}}
@props([
    'bgColor' => 'bg-white',
    'bgGradient' => null,
    'bgImage' => null,
    'padding' => 'lg',
    'containerWidth' => 'max-w-7xl',
    'textAlign' => 'left',
    'id' => null
])

@php
    $paddingClasses = [
        'sm' => 'py-8 lg:py-12',
        'md' => 'py-12 lg:py-16',
        'lg' => 'py-16 lg:py-24',
        'xl' => 'py-20 lg:py-32',
    ];
    $py = $paddingClasses[$padding] ?? $paddingClasses['lg'];
    
    $textAlignClasses = [
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
    ];
    $align = $textAlignClasses[$textAlign] ?? $textAlignClasses['left'];
@endphp

<section 
    @if($id) id="{{ $id }}" @endif
    class="relative {{ $bgColor }} {{ $py }} overflow-hidden"
    @if($bgGradient) style="background: {{ $bgGradient }};" @endif
>
    {{-- Background Image --}}
    @if($bgImage)
    <div class="absolute inset-0 z-0">
        <img 
            src="{{ $bgImage }}" 
            alt="Background" 
            class="w-full h-full object-cover opacity-10"
            loading="lazy"
        >
    </div>
    @endif

    {{-- Container --}}
    <div class="relative z-10 {{ $containerWidth }} mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Heading Slot --}}
        @if(isset($heading))
        <div class="{{ $align }} {{ isset($content) ? 'mb-12' : 'mb-8' }}">
            {{ $heading }}
        </div>
        @endif

        {{-- Content Slot --}}
        @if(isset($content))
        <div class="{{ $align }}">
            {{ $content }}
        </div>
        @else
        <div class="{{ $align }}">
            {{ $slot }}
        </div>
        @endif
    </div>
</section>
