@props(['size' => 'md'])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold text-white transition-all duration-300 min-h-[44px] rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 shadow-primary hover:shadow-primary-hover hover:from-indigo-700 hover:to-violet-700 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base sm:px-8 sm:py-4',
        'lg' => 'px-8 py-4 text-lg sm:px-10 sm:py-5',
    ];
    
    $classes = $baseClasses . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
    {{ $slot }}
</button>
