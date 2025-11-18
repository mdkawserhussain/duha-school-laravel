@props(['disabled' => false, 'error' => false])

@php
    $baseClasses = 'w-full px-3 py-2.5 border rounded-xl text-base transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0 disabled:opacity-50 disabled:cursor-not-allowed bg-white';
    
    $stateClasses = $error 
        ? 'border-red-500 focus:border-red-500 focus:ring-red-500' 
        : 'border-slate-300 focus:border-indigo-600 focus:ring-indigo-500';
    
    $classes = $baseClasses . ' ' . $stateClasses;
@endphp

<select @disabled($disabled) {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</select>

