@props(['striped' => false, 'hover' => true])

@php
    $tableClasses = 'min-w-full divide-y divide-slate-200';
    $theadClasses = 'bg-slate-50';
    $tbodyClasses = 'bg-white divide-y divide-slate-200' . ($striped ? ' [&>tr:nth-child(even)]:bg-slate-50' : '');
    $trClasses = $hover ? 'hover:bg-slate-50 transition-colors duration-150' : '';
    $thClasses = 'px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider';
    $tdClasses = 'px-6 py-4 whitespace-nowrap text-sm text-slate-900';
@endphp

<div class="overflow-hidden rounded-xl border border-slate-200 shadow-sm">
    <table {{ $attributes->merge(['class' => $tableClasses]) }}>
        @if(isset($header))
        <thead class="{{ $theadClasses }}">
            <tr>
                {{ $header }}
            </tr>
        </thead>
        @endif
        @if(isset($body))
        <tbody class="{{ $tbodyClasses }}">
            {{ $body }}
        </tbody>
        @endif
    </table>
</div>

