
{{-- Enhanced Navbar Component with Alpine.js --}}
@props(['transparent' => false])

{{-- Locale variables removed as language switcher is no longer needed --}}

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
        <div class="flex items-center h-16 lg:h-20 transition-all duration-300 relative">

            {{-- Logo --}}
            <div class="flex-shrink-0 z-10">
                <a
                    href="{{ route('home') }}"
                    class="navbar-logo navbar-focus focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-lg p-1"
                    aria-label="Go to homepage"
                >
                    @php
                        $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
                        $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
                    @endphp
                    <img
                        class="h-8 sm:h-10 lg:h-12 w-auto"
                        src="{{ $logoUrl ?? asset('images/logo.svg') }}"
                        alt="{{ $siteName }} Logo"
                        onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}'"
                    >
                </a>
            </div>

            {{-- Desktop Navigation - Centered --}}
            <div class="hidden lg:flex items-center space-x-1 flex-1 justify-center min-w-0 px-4">
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
            <div class="hidden lg:flex items-center space-x-3 flex-shrink-0 z-10">
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
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 rounded-lg p-2.5 min-w-[44px] min-h-[44px] flex items-center justify-center"
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

                {{-- Logout Button (only for logged-in users) --}}
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50'"
                        >
                            Logout
                        </button>
                    </form>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <div class="lg:hidden flex-shrink-0 ml-auto z-10">
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="inline-flex items-center justify-center p-2.5 rounded-xl text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 min-w-[44px] min-h-[44px]"
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
        x-cloak
        class="mobile-menu fixed inset-y-0 right-0 z-50 w-full max-w-sm bg-white shadow-xl transform transition-transform duration-300 ease-in-out"
        :class="{ 'translate-x-0': mobileMenuOpen, 'translate-x-full': !mobileMenuOpen }"
        style="display: none;"
        id="mobile-menu"
    >
        {{-- Mobile Menu Overlay --}}
        <div 
            x-show="mobileMenuOpen"
            @click="mobileMenuOpen = false"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity duration-300"
            :class="{ 'opacity-100': mobileMenuOpen, 'opacity-0': !mobileMenuOpen }"
            style="display: none;"
        ></div>
        
        <div class="flex flex-col h-full">
            {{-- Mobile Header --}}
            <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-white">
                <span class="text-lg font-semibold text-gray-900">Menu</span>
                <button
                    @click="mobileMenuOpen = false"
                    class="p-2.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 min-w-[44px] min-h-[44px] flex items-center justify-center"
                    aria-label="Close mobile menu"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu Content --}}
            <div class="flex-1 overflow-y-auto py-4 px-4">
                <nav class="space-y-1">
                    {{-- Home --}}
                    <a
                        href="{{ route('home') }}"
                        @click="mobileMenuOpen = false"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 min-h-[48px]"
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
                            class="flex items-center gap-3 px-6 py-3.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 min-h-[48px]"
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
                            class="flex items-center gap-3 px-6 py-3.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 min-h-[48px]"
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
                            class="flex items-center gap-3 px-6 py-3.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 min-h-[48px]"
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
                            class="flex items-center gap-3 px-6 py-3.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 min-h-[48px]"
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
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 min-h-[48px]"
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
                            class="flex items-center gap-3 px-6 py-3.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 min-h-[48px]"
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
                            class="flex items-center gap-3 px-6 py-3.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-xl transition-all duration-200 min-h-[48px]"
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
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 min-h-[48px]"
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
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 min-h-[48px]"
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
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 w-full text-left min-h-[48px]"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>

                    {{-- Mobile Logout (only for logged-in users) --}}
                    @auth
                        <div class="px-4 py-3 border-t border-gray-200 mt-auto">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-base font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 w-full text-left min-h-[48px]"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
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

