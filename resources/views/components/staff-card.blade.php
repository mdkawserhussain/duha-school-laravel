@props(['staff'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
    @if($staff->getFirstMediaUrl('photo'))
        <img src="{{ $staff->getFirstMediaUrl('photo', 'medium') }}" alt="{{ $staff->name }}" class="w-full h-48 object-cover">
    @else
        <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
            </svg>
        </div>
    @endif

    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-1">
            {{ $staff->name }}
        </h3>

        <p class="text-blue-600 font-medium mb-3">
            {{ $staff->position }}
        </p>

        @if($staff->bio)
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
            {!! Str::limit(strip_tags($staff->bio), 120) !!}
        </p>
        @endif

        <div class="mt-4">
            <a href="{{ route('staff.show', $staff->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                View Profile →
            </a>
        </div>

        <div class="flex flex-col space-y-2 mt-4">
            @if($staff->email)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <a href="mailto:{{ $staff->email }}" class="hover:text-blue-600 transition duration-300">
                    {{ $staff->email }}
                </a>
            </div>
            @endif

            @if($staff->phone)
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <a href="tel:{{ $staff->phone }}" class="hover:text-blue-600 transition duration-300">
                    {{ $staff->phone }}
                </a>
            </div>
            @endif
        </div>

        @if($staff->social_links && count($staff->social_links) > 0)
        <div class="flex space-x-3 mt-4">
            @foreach($staff->social_links as $social)
            <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
               class="text-gray-400 hover:text-blue-600 transition duration-300">
                @if($social['platform'] === 'facebook')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                @elseif($social['platform'] === 'twitter')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
                @elseif($social['platform'] === 'linkedin')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
                @elseif($social['platform'] === 'instagram')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.017 0C8.396 0 7.609.035 6.298.129c-1.31.094-2.207.447-2.996.956a5.886 5.886 0 00-2.144 2.144C.447 4.019.094 4.916.0 6.226.035 7.537 0 8.324 0 11.945s.035 4.408.129 5.719c.094 1.31.447 2.207.956 2.996a5.886 5.886 0 002.144 2.144c.789.509 1.686.862 2.996.956 1.31.094 2.097.129 5.718.129s4.408-.035 5.719-.129c1.31-.094 2.207-.447 2.996-.956a5.886 5.886 0 002.144-2.144c.509-.789.862-1.686.956-2.996.094-1.31.129-2.097.129-5.718s-.035-4.408-.129-5.719c-.094-1.31-.447-2.207-.956-2.996a5.886 5.886 0 00-2.144-2.144c-.789-.509-1.686-.862-2.996-.956C16.409.035 15.622 0 12.017 0zm0 2.163c3.532 0 3.957.013 5.356.096 1.303.079 2.0.348 2.455.578.57.288.982.646 1.41 1.074.428.428.786.84 1.074 1.41.23.455.499 1.152.578 2.455.083 1.399.096 1.824.096 5.356 0 3.532-.013 3.957-.096 5.356-.079 1.303-.348 2.0-.578 2.455-.288.57-.646.982-1.074 1.41a3.723 3.723 0 01-1.41 1.074c-.455.23-1.152.499-2.455.578-1.399.083-1.824.096-5.356.096-3.532 0-3.957-.013-5.356-.096-1.303-.079-2.0-.348-2.455-.578a3.723 3.723 0 01-1.41-1.074 3.723 3.723 0 01-1.074-1.41c-.23-.455-.499-1.152-.578-2.455-.083-1.399-.096-1.824-.096-5.356 0-3.532.013-3.957.096-5.356.079-1.303.348-2.0.578-2.455.288-.57.646-.982 1.074-1.41a3.723 3.723 0 011.41-1.074c.455-.23 1.152-.499 2.455-.578 1.399-.083 1.824-.096 5.356-.096zm0 3.826a6.173 6.173 0 100 12.346 6.173 6.173 0 000-12.346zm0 2.163a4.01 4.01 0 110 8.02 4.01 4.01 0 010-8.02zm6.406-2.73a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z"/>
                </svg>
                @endif
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>