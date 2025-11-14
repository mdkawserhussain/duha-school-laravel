
{{-- Enhanced Navbar Component with Alpine.js --}}
@props(['transparent' => false])

@php
$currentLocale = app()->getLocale();
$locales = [
    'en' => ['name' => 'English', 'flag' => '🇬🇧'],
    'bn' => ['name' => 'বাংলা', 'flag' => '🇧🇩'],
];
@endphp

<nav
    x-data="navbarComponent({{ $transparent ? 'true' : 'false' }})"
    class="navbar {{ $transparent ? 'navbar-transparent' : 'navbar-scrolled' }}"
    :class="{ 'navbar-scrolled': scrolled && !transparent, 'navbar-transparent': transparent && !scrolled }"
    x-init="init()"
    role="navigation"
    aria-label="Main navigation"
>
    {{-- Top Announcement Bar --}}
    @php
        // Completely disable announcements during exception rendering
        $announcements = collect([]);
        try {
            // Only load if we're absolutely sure we're not in an error context
            if (!app()->bound('exception') && 
                !str_contains(request()->path() ?? '', 'errors') &&
                !str_contains(request()->path() ?? '', '_dusk') &&
                !str_contains(request()->path() ?? '', 'telescope')) {
                $announcements = \App\Helpers\AnnouncementHelper::getSafe();
            }
        } catch (\Throwable $e) {
            // Silently fail - never break the page
            $announcements = collect([]);
        }
    @endphp
    
    @if($announcements->isNotEmpty())
    <div class="announcement-bar" x-show="!scrolled">
        <div class="marquee-wrapper">
            <div class="marquee-content">
                @foreach($announcements as $announcement)
                    @if($announcement && !empty($announcement->message))
                    <span>
                        @if(!empty($announcement->link))
                            <a href="{{ e($announcement->link ?? '') }}" class="hover:underline text-white" {{ empty($announcement->link_text) ? 'style="text-decoration: underline;"' : '' }}>
                                {{ e($announcement->message ?? '') }}
                                @if(!empty($announcement->link_text))
                                    <span class="ml-2 font-semibold">{{ e($announcement->link_text ?? '') }} &rarr;</span>
                                @endif
                            </a>
                        @else
                            {{ e($announcement->message ?? '') }}
                        @endif
                    </span>
                    {{-- Repeat for seamless loop --}}
                    <span>
                        @if(!empty($announcement->link))
                            <a href="{{ e($announcement->link ?? '') }}" class="hover:underline text-white" {{ empty($announcement->link_text) ? 'style="text-decoration: underline;"' : '' }}>
                                {{ e($announcement->message ?? '') }}
                                @if(!empty($announcement->link_text))
                                    <span class="ml-2 font-semibold">{{ e($announcement->link_text ?? '') }} &rarr;</span>
                                @endif
                            </a>
                        @else
                            {{ e($announcement->message ?? '') }}
                        @endif
                    </span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Main Navbar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20 transition-all duration-300">

            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a
                    href="{{ route('home') }}"
                    class="navbar-logo navbar-focus focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-lg p-1"
                    aria-label="Go to homepage"
                >
                    @php
                        $logoUrl = \App\Models\SiteSettings::getLogoUrl();
                    @endphp
                    <img
                        class="h-10 lg:h-12 w-auto"
                        src="{{ $logoUrl }}"
                        @php
                            $siteName = \App\Helpers\SiteHelper::getSiteName();
                        @endphp
                        alt="{{ $siteName }} Logo"
                        onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}'"
                    >
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex items-center space-x-1 flex-1 justify-center">
                {{-- Home --}}
                <a
                    href="{{ route('home') }}"
                    class="nav-link px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2"
                    :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10 focus:ring-white/50' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50 focus:ring-indigo-500'"
                    :class="transparent && !scrolled && isActive('home') ? 'bg-white/10 text-white font-semibold' : (!transparent || scrolled) && isActive('home') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                    aria-current="{{ request()->routeIs('home') ? 'page' : null }}"
                >
                    Home
                </a>

                {{-- About Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        @keydown.escape="open = false"
                        class="nav-link flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10 focus:ring-white/50' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50 focus:ring-indigo-500'"
                        :aria-expanded="open"
                        aria-haspopup="true"
                    >
                        About
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        class="dropdown-menu"
                        :class="{ 'open': open }"
                        style="display: none;"
                    >
                        <div class="p-2">
                            <a
                                href="{{ route('about.show', 'principal') }}"
                                class="dropdown-item"
                                @click="open = false"
                            >
                                <div class="dropdown-item-icon bg-indigo-100">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Principal's Message</div>
                                    <div class="text-xs text-gray-500">Meet our leadership</div>
                                </div>
                            </a>
                            <a
                                href="{{ route('about.show', 'vision') }}"
                                class="dropdown-item"
                                @click="open = false"
                            >
                                <div class="dropdown-item-icon bg-purple-100">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Vision & Mission</div>
                                    <div class="text-xs text-gray-500">Our guiding principles</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Academics Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        @keydown.escape="open = false"
                        class="nav-link flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10 focus:ring-white/50' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50 focus:ring-indigo-500'"
                        :aria-expanded="open"
                        aria-haspopup="true"
                    >
                        Academics
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        class="dropdown-menu"
                        :class="{ 'open': open }"
                        style="display: none;"
                    >
                        <div class="p-2">
                            <a
                                href="{{ route('academic.show', 'curriculum') }}"
                                class="dropdown-item"
                                @click="open = false"
                            >
                                <div class="dropdown-item-icon bg-green-100">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Curriculum</div>
                                    <div class="text-xs text-gray-500">Academic programs</div>
                                </div>
                            </a>
                            <a
                                href="{{ route('academic.show', 'policies') }}"
                                class="dropdown-item"
                                @click="open = false"
                            >
                                <div class="dropdown-item-icon bg-blue-100">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Policies</div>
                                    <div class="text-xs text-gray-500">Academic guidelines</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Admission --}}
                <a
                    href="{{ route('admission.index') }}"
                    class="nav-link px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2"
                    :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10 focus:ring-white/50' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50 focus:ring-indigo-500'"
                    :class="transparent && !scrolled && isActive('admission.*') ? 'bg-white/10 text-white font-semibold' : (!transparent || scrolled) && isActive('admission.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                    aria-current="{{ request()->routeIs('admission.*') ? 'page' : null }}"
                >
                    Admission
                </a>

                {{-- News & Media Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        @keydown.escape="open = false"
                        class="nav-link flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10 focus:ring-white/50' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50 focus:ring-indigo-500'"
                        :aria-expanded="open"
                        aria-haspopup="true"
                    >
                        News & Media
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        class="dropdown-menu"
                        :class="{ 'open': open }"
                        style="display: none;"
                    >
                        <div class="p-2">
                            <a
                                href="{{ route('events.index') }}"
                                class="dropdown-item"
                                @click="open = false"
                            >
                                <div class="dropdown-item-icon bg-pink-100">
                                    <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Events</div>
                                    <div class="text-xs text-gray-500">School activities</div>
                                </div>
                            </a>
                            <a
                                href="{{ route('notices.index') }}"
                                class="dropdown-item"
                                @click="open = false"
                            >
                                <div class="dropdown-item-icon bg-yellow-100">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Notices</div>
                                    <div class="text-xs text-gray-500">Important announcements</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Career --}}
                <a
                    href="{{ route('careers.index') }}"
                    class="nav-link px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2"
                    :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10 focus:ring-white/50' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50 focus:ring-indigo-500'"
                    :class="transparent && !scrolled && isActive('careers.*') ? 'bg-white/10 text-white font-semibold' : (!transparent || scrolled) && isActive('careers.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                    aria-current="{{ request()->routeIs('careers.*') ? 'page' : null }}"
                >
                    Career
                </a>

                {{-- Contact --}}
                <a
                    href="{{ route('contact.index') }}"
                    class="nav-link px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2"
                    :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10 focus:ring-white/50' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50 focus:ring-indigo-500'"
                    :class="transparent && !scrolled && isActive('contact.*') ? 'bg-white/10 text-white font-semibold' : (!transparent || scrolled) && isActive('contact.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                    aria-current="{{ request()->routeIs('contact.*') ? 'page' : null }}"
                >
                    Contact
                </a>
            </div>

            {{-- Right Side --}}
            <div class="hidden lg:flex items-center space-x-3">
                {{-- Search --}}
                <div class="relative" x-data="searchComponent()">
                    <button
                        @click="toggleSearch()"
                        class="search-button navbar-focus transition-all duration-300"
                        :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50'"
                        aria-label="Open search"
                        :aria-expanded="isOpen"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    {{-- Search Modal --}}
                    <div
                        x-show="isOpen"
                        @keydown.escape="closeSearch()"
                        class="search-modal"
                        :class="{ 'open': isOpen }"
                        style="display: none;"
                    >
                        <div class="search-modal-content">
                            <button
                                @click="closeSearch()"
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 rounded-lg p-1"
                                aria-label="Close search"
                            >
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <div class="mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">Search</h2>
                                <p class="text-gray-600">Find events, notices, pages, and staff</p>
                            </div>

                            <form @submit.prevent="performSearch()" class="mb-4">
                                <div class="relative">
                                    <input
                                        x-model="query"
                                        @input.debounce.300ms="search()"
                                        type="text"
                                        placeholder="Start typing to search..."
                                        class="search-input"
                                        autocomplete="off"
                                        x-ref="searchInput"
                                    >
                                    <div class="search-input-icon">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <button
                                        type="submit"
                                        class="search-submit"
                                        :class="{ 'text-indigo-600': query.length > 0, 'text-gray-400': query.length === 0 }"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            {{-- Search Results --}}
                            <div x-show="results.length > 0" class="search-results">
                                <div class="space-y-2">
                                    <template x-for="result in results" :key="result.url">
                                        <a
                                            :href="result.url"
                                            @click="closeSearch()"
                                            class="search-result-item"
                                        >
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="search-result-type"
                                                        :class="getTypeColor(result.type)"
                                                    >
                                                        <span x-text="result.type.charAt(0).toUpperCase()"></span>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="text-sm font-medium text-gray-900 truncate" x-text="result.title"></h3>
                                                    <p class="text-sm text-gray-500 mt-1" x-text="result.excerpt"></p>
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-2"
                                                        :class="getTypeBadge(result.type)"
                                                        x-text="result.type"
                                                    ></span>
                                                </div>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>

                            <div x-show="query.length > 0 && results.length === 0 && !loading" class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your search terms.</p>
                            </div>

                            <div x-show="loading" class="text-center py-8">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto"></div>
                                <p class="mt-2 text-sm text-gray-500">Searching...</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Language Switcher --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        @keydown.escape="open = false"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10 focus:ring-white/50' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 focus:ring-indigo-500'"
                        :aria-expanded="open"
                        aria-label="Change language"
                    >
                        <span class="text-lg">{{ $locales[$currentLocale]['flag'] ?? '🌐' }}</span>
                        <span class="hidden sm:inline">{{ $locales[$currentLocale]['name'] ?? strtoupper($currentLocale) }}</span>
                        <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        class="language-dropdown"
                        :class="{ 'open': open }"
                        style="display: none;"
                    >
                        <div class="p-2">
                            @foreach($locales as $code => $locale)
                                <a
                                    href="{{ route('language.switch', $code) }}"
                                    class="language-option"
                                    :class="{ 'active': '{{ $currentLocale }}' === '{{ $code }}' }"
                                    @click="open = false"
                                >
                                    <span class="text-xl" x-text="'{{ $locale['flag'] }}'"></span>
                                    <span x-text="'{{ $locale['name'] }}'"></span>
                                    @if($currentLocale === $code)
                                        <svg class="h-4 w-4 ml-auto text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Auth Links --}}
                @auth
                    <a
                        href="{{ url('/admin') }}"
                        class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Admin
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Logout
                        </button>
                    </form>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Register
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <div class="lg:hidden">
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    :aria-expanded="mobileMenuOpen"
                    aria-controls="mobile-menu"
                    aria-label="Toggle mobile menu"
                >
                    <svg class="block h-6 w-6" :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div
        x-show="mobileMenuOpen"
        @click.away="mobileMenuOpen = false"
        @keydown.escape="mobileMenuOpen = false"
        class="mobile-menu"
        :class="{ 'open': mobileMenuOpen }"
        style="display: none;"
        id="mobile-menu"
    >
        <div class="mobile-menu-overlay"></div>
        <div class="flex flex-col h-full">
            {{-- Mobile Header --}}
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <span class="text-lg font-semibold text-gray-900">Menu</span>
                <button
                    @click="mobileMenuOpen = false"
                    class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                    aria-label="Close mobile menu"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu Content --}}
            <div class="flex-1 overflow-y-auto py-6 px-4">
                <nav class="space-y-2">
                    {{-- Home --}}
                    <a
                        href="{{ route('home') }}"
                        @click="mobileMenuOpen = false"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200"
                        :class="{ 'bg-indigo-100 text-indigo-700 font-semibold': isActive('home') }"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Home
                    </a>

                    {{-- About Section --}}
                    <div class="space-y-1">
                        <div class="px-4 py-2 text-sm font-semibold text-gray-500 uppercase tracking-wide">About</div>
                        <a
                            href="{{ route('about.show', 'principal') }}"
                            @click="mobileMenuOpen = false"
                            class="flex items-center gap-3 px-6 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200"
                        >
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            Principal's Message
                        </a>
                        <a
                            href="{{ route('about.show', 'vision') }}"
                            @click="mobileMenuOpen = false"
                            class="flex items-center gap-3 px-6 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200"
                        >
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            Vision & Mission
                        </a>
                    </div>

                    {{-- Academics Section --}}
                    <div class="space-y-1">
                        <div class="px-4 py-2 text-sm font-semibold text-gray-500 uppercase tracking-wide">Academics</div>
                        <a
                            href="{{ route('academic.show', 'curriculum') }}"
                            @click="mobileMenuOpen = false"
                            class="flex items-center gap-3 px-6 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200"
                        >
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            Curriculum
                        </a>
                        <a
                            href="{{ route('academic.show', 'policies') }}"
                            @click="mobileMenuOpen = false"
                            class="flex items-center gap-3 px-6 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200"
                        >
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            Policies
                        </a>
                    </div>

                    {{-- Other Links --}}
                    <a
                        href="{{ route('admission.index') }}"
                        @click="mobileMenuOpen = false"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200"
                        :class="{ 'bg-indigo-100 text-indigo-700 font-semibold': isActive('admission.*') }"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Admission
                    </a>

                    {{-- News & Media Section --}}
                    <div class="space-y-1">
                        <div class="px-4 py-2 text-sm font-semibold text-gray-500 uppercase tracking-wide">News & Media</div>
                        <a
                            href="{{ route('events.index') }}"
                            @click="mobileMenuOpen = false"
                            class="flex items-center gap-3 px-6 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200"
                        >
                            <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            Events
                        </a>
                        <a
                            href="{{ route('notices.index') }}"
                            @click="mobileMenuOpen = false"
                            class="flex items-center gap-3 px-6 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200"
                        >
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                </svg>
                            </div>
                            Notices
                        </a>
                    </div>

                    <a
                        href="{{ route('careers.index') }}"
                        @click="mobileMenuOpen = false"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200"
                        :class="{ 'bg-indigo-100 text-indigo-700 font-semibold': isActive('careers.*') }"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Career
                    </a>

                    <a
                        href="{{ route('contact.index') }}"
                        @click="mobileMenuOpen = false"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200"
                        :class="{ 'bg-indigo-100 text-indigo-700 font-semibold': isActive('contact.*') }"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contact
                    </a>

                    {{-- Mobile Search --}}
                    <button
                        @click="mobileMenuOpen = false; $nextTick(() => { $dispatch('open-search') })"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 w-full text-left"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>

                    {{-- Mobile Language Switcher --}}
                    <div class="px-4 py-3 border-t border-gray-200 mt-4">
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Language</div>
                        <div class="space-y-2">
                            @foreach($locales as $code => $locale)
                                <a
                                    href="{{ route('language.switch', $code) }}"
                                    @click="mobileMenuOpen = false"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200"
                                    :class="{ 'bg-indigo-100 text-indigo-700 font-semibold': '{{ $currentLocale }}' === '{{ $code }}' }"
                                >
                                    <span class="text-xl">{{ $locale['flag'] }}</span>
                                    <span>{{ $locale['name'] }}</span>
                                    @if($currentLocale === $code)
                                        <svg class="h-4 w-4 ml-auto text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Mobile Auth --}}
                    <div class="px-4 py-3 border-t border-gray-200">
                        @auth
                            <a
                                href="{{ url('/admin') }}"
                                @click="mobileMenuOpen = false"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Admin
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button
                                    type="submit"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 w-full text-left"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        @else
                            <a
                                href="{{ route('login') }}"
                                @click="mobileMenuOpen = false"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    @click="mobileMenuOpen = false"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium bg-gradient-to-r from-indigo-600 to-purple-600 text-white transition-all duration-200 mt-2"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </nav>
            </div>
        </div>
    </div>
</nav>

{{-- Alpine.js Components --}}
<script>
function navbarComponent(transparent = false) {
    return {
        transparent: transparent,
        scrolled: false,
        mobileMenuOpen: false,

        init() {
            this.handleScroll();
            window.addEventListener('scroll', () => this.handleScroll());
        },

        handleScroll() {
            this.scrolled = window.pageYOffset > 50;
        },

        isActive(routePattern) {
            return window.location.href.includes(routePattern.replace('.*', ''));
        }
    }
}

function searchComponent() {
    return {
        isOpen: false,
        query: '',
        results: [],
        loading: false,

        toggleSearch() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.$nextTick(() => {
                    this.$refs.searchInput.focus();
                });
            } else {
                this.query = '';
                this.results = [];
            }
        },

        closeSearch() {
            this.isOpen = false;
            this.query = '';
            this.results = [];
        },

        async search() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }

            this.loading = true;
            try {
                const response = await fetch(`/api/search/autocomplete?q=${encodeURIComponent(this.query)}`);
                const data = await response.json();
                this.results = data.suggestions || [];
            } catch (error) {
                console.error('Search error:', error);
                this.results = [];
            } finally {
                this.loading = false;
            }
        },

        performSearch() {
            if (this.query.trim()) {
                window.location.href = `/search?q=${encodeURIComponent(this.query.trim())}`;
            }
        },

        getTypeColor(type) {
            const colors = {
                event: 'bg-pink-500',
                notice: 'bg-yellow-500',
                page: 'bg-blue-500',
                staff: 'bg-green-500'
            };
            return colors[type] || 'bg-gray-500';
        },

        getTypeBadge(type) {
            const badges = {
                event: 'bg-pink-100 text-pink-800',
                notice: 'bg-yellow-100 text-yellow-800',
                page: 'bg-blue-100 text-blue-800',
                staff: 'bg-green-100 text-green-800'
            };
            return badges[type] || 'bg-gray-100 text-gray-800';
        }
    }
}
</script>

