@props(['news' => []])

<div class="bg-zaitoon-primary text-white border-b border-white/10">
    <div class="max-w-7xl mx-auto flex">
        <!-- Label -->
        <div class="bg-zaitoon-secondary text-zaitoon-primary font-bold px-6 py-3 flex items-center z-10 relative uppercase tracking-wider text-sm">
            Latest News
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
        </div>

        <!-- Ticker -->
        <div class="flex-1 overflow-hidden relative flex items-center bg-zaitoon-dark/50">
            <div class="animate-marquee-scroll whitespace-nowrap flex items-center py-3">
                @foreach($news as $item)
                    <a href="{{ $item['url'] ?? '#' }}" class="mx-8 text-sm font-medium hover:text-zaitoon-secondary transition-colors flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-zaitoon-secondary"></span>
                        {{ $item['title'] }}
                        <span class="text-xs text-gray-400 ml-2">({{ $item['date'] ?? 'Just Now' }})</span>
                    </a>
                @endforeach
                <!-- Duplicate for seamless loop -->
                @foreach($news as $item)
                    <a href="{{ $item['url'] ?? '#' }}" class="mx-8 text-sm font-medium hover:text-zaitoon-secondary transition-colors flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-zaitoon-secondary"></span>
                        {{ $item['title'] }}
                        <span class="text-xs text-gray-400 ml-2">({{ $item['date'] ?? 'Just Now' }})</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
