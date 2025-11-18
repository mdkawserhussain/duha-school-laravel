{{-- Enhanced Navbar Component with Alpine.js --}}
@props(['transparent' => false])

@php
    // Get primary color from site settings
    $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
    if (!str_starts_with($primaryColor, '#')) {
        $primaryColor = '#' . ltrim($primaryColor, '#');
    }
    
    // Completely disable announcements during exception rendering
    $announcements = collect([]);
    try {
        if (!app()->bound('exception') && 
            !str_contains(request()->path() ?? '', 'errors') &&
            !str_contains(request()->path() ?? '', '_dusk') &&
            !str_contains(request()->path() ?? '', 'telescope')) {
            $announcements = \App\Helpers\AnnouncementHelper::getSafe();
        }
    } catch (\Throwable $e) {
        $announcements = collect([]);
    }
@endphp

{{-- Static wrapper with x-data - never receives dynamic classes --}}
<header
    x-data="{ 
        mobileMenuOpen: false,
        transparent: {{ $transparent ? 'true' : 'false' }},
        scrolled: false
    }"
    x-init="
        const header = $el;
        const announcementBar = header.querySelector('.announcement-bar');
        
        function updatePosition() {
            if (announcementBar && !scrolled) {
                const height = announcementBar.offsetHeight;
                header.style.top = height + 'px';
            } else {
                header.style.top = '0';
            }
        }
        
        function handleScroll() {
            scrolled = window.pageYOffset > 50;
            updatePosition();
        }
        
        if (announcementBar) {
            updatePosition();
            new ResizeObserver(() => updatePosition()).observe(announcementBar);
        }
        
        handleScroll();
        window.addEventListener('scroll', () => handleScroll());
    "
    class="fixed top-0 left-0 w-full z-50"
    role="banner"
>
    {{-- Top Announcement Bar --}}
    @if($announcements->isNotEmpty() && request()->routeIs('home'))
    <div 
        class="announcement-bar" 
        x-show="!scrolled"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
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

    {{-- Inner nav with scroll-based styling --}}
    <nav
        class="transition-all duration-300"
        :class="{
            'bg-white/95 backdrop-blur-md shadow-lg': scrolled || !transparent,
            'bg-transparent': transparent && !scrolled
        }"
        :style="(scrolled || !transparent) ? 'background-color: {{ $primaryColor }}' : ''"
        role="navigation"
        aria-label="Main navigation"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16 lg:h-20 relative">
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
                            class="h-8 sm:h-10 lg:h-12 w-auto transition-all duration-300"
                            :class="transparent && !scrolled ? 'brightness-0 invert' : ''"
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
                        :class="transparent && !scrolled && window.location.href.includes('home') ? 'bg-white/10 text-white font-semibold' : (!transparent || scrolled) && window.location.href.includes('home') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
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
                        :class="transparent && !scrolled && window.location.href.includes('admission') ? 'bg-white/10 text-white font-semibold' : (!transparent || scrolled) && window.location.href.includes('admission') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
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
                        :class="transparent && !scrolled && window.location.href.includes('careers') ? 'bg-white/10 text-white font-semibold' : (!transparent || scrolled) && window.location.href.includes('careers') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                        aria-current="{{ request()->routeIs('careers.*') ? 'page' : null }}"
                    >
                        Career
                    </a>

                    {{-- Contact --}}
                    <a
                        href="{{ route('contact.index') }}"
                        class="nav-link px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10 focus:ring-white/50' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50 focus:ring-indigo-500'"
                        :class="transparent && !scrolled && window.location.href.includes('contact') ? 'bg-white/10 text-white font-semibold' : (!transparent || scrolled) && window.location.href.includes('contact') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                        aria-current="{{ request()->routeIs('contact.*') ? 'page' : null }}"
                    >
                        Contact
                    </a>
                </div>

                {{-- Right Side --}}
                <div class="hidden lg:flex items-center space-x-3 flex-shrink-0 z-10">
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
                        @click.stop="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center p-2.5 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 min-w-[44px] min-h-[44px]"
                        :class="transparent && !scrolled ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50'"
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
    </nav>

    {{-- Mobile Menu Overlay - Sibling of nav, click-away on backdrop only --}}
    <div
        x-show="mobileMenuOpen"
        x-cloak
        @click.away="mobileMenuOpen = false"
        @keydown.escape.window="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        style="display: none;"
    >
        {{-- Mobile Menu Panel --}}
        <div
            @click.stop
            class="fixed inset-y-0 right-0 w-full max-w-sm bg-white shadow-2xl overflow-y-auto z-[60] transform transition-transform duration-300 ease-in-out"
            :class="mobileMenuOpen ? 'translate-x-0' : 'translate-x-full'"
            :style="scrolled ? 'background-color: {{ $primaryColor }}' : ''"
        >
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
                            :class="window.location.href.includes('home') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
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
                            :class="window.location.href.includes('admission') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
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
                            :class="window.location.href.includes('careers') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
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
                            :class="window.location.href.includes('contact') ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Contact
                        </a>

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
    </div>
</header>
