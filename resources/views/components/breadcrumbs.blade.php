@props(['items'])

<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach($items as $index => $item)
            <li class="inline-flex items-center {{ $loop->last ? 'aria-current=page' : '' }}">
                @if($index > 0)
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                @endif
                @if($item['url'] ?? null)
                    <a href="{{ $item['url'] }}" class="text-gray-700 hover:text-blue-600 transition duration-300 {{ $loop->last ? 'ml-1 md:ml-2' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-gray-500 ml-1 md:ml-2">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

