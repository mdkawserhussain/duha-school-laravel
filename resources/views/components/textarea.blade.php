@props(['disabled' => false, 'error' => false, 'rows' => 4])

@php
    $baseClasses = 'w-full px-3 py-2.5 border rounded-xl text-base transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0 resize-y disabled:opacity-50 disabled:cursor-not-allowed';
    
    $stateClasses = $error 
        ? 'border-red-500 focus:border-red-500 focus:ring-red-500' 
        : 'border-slate-300 focus:border-indigo-600 focus:ring-indigo-500';
    
    $classes = $baseClasses . ' ' . $stateClasses;
@endphp

<textarea @disabled($disabled) {{ $attributes->merge(['class' => $classes, 'rows' => $rows]) }}>{{ $slot }}</textarea>

