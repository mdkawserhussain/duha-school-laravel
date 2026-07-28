@props(['items' => []])

@if(count($items) > 0)
<nav class="bg-gray-50 border-b border-gray-200" aria-label="Breadcrumb">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <ol class="flex items-center space-x-2 text-sm">
            @foreach($items as $index => $item)
                @if($index < count($items) - 1)
                    <li>
                        <a href="{{ $item['url'] ?? '#' }}" 
                           class="text-gray-500 hover:text-aisd-ocean transition-colors">
                            {{ $item['title'] ?? 'Home' }}
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                @else
                    <li>
                        <span class="text-gray-700 font-medium" aria-current="page">
                            {{ $item['title'] ?? 'Current Page' }}
                        </span>
                    </li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>
@endif