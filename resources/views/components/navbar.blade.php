{{-- Enhanced Navbar Component with Alpine.js --}}
{{-- Props are now handled by the View Component class --}}

{{-- Static wrapper with x-data - never receives dynamic classes --}}
<header
    x-data="{ 
        mobileMenuOpen: false,
        transparent: {{ $transparent ? 'true' : 'false' }},
        scrolled: false
    }"
    @keydown.window.tab="
        if (mobileMenuOpen) {
            const menu = document.getElementById('mobile-menu');
            if (menu) {
                const focusable = menu.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex=\'-1\'])');
                if (focusable.length) {
                    const first = focusable[0];
                    const last = focusable[focusable.length - 1];
                    if ($event.shiftKey) {
                        if (document.activeElement === first) {
                            $event.preventDefault();
                            last.focus();
                        }
                    } else {
                        if (document.activeElement === last) {
                            $event.preventDefault();
                            first.focus();
                        }
                    }
                }
            }
        }
    "
    x-init="
        // Watch mobile menu state to lock/unlock body scroll
        $watch('mobileMenuOpen', value => {
            if (value) {
                document.body.classList.add('overflow-hidden');
                document.documentElement.classList.add('overflow-hidden');
                // Focus first element
                setTimeout(() => {
                    const menu = document.getElementById('mobile-menu');
                    if (menu) {
                        const focusable = menu.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex=\'-1\'])');
                        if (focusable.length) focusable[0].focus();
                    }
                }, 100);
            } else {
                document.body.classList.remove('overflow-hidden');
                document.documentElement.classList.remove('overflow-hidden');
            }
        });
        
        function handleScroll() {
            scrolled = window.pageYOffset > 50;
        }
        
        handleScroll();
        window.addEventListener('scroll', () => handleScroll());
    "
    class="fixed top-0 left-0 w-full z-[9999]"
    style="z-index: 9999;"
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
            'bg-white shadow-md': !transparent,
            'bg-transparent': transparent
        }"
        :style="(transparent) ? 'background-color: {{ $primaryColor }}' : ''"
        role="navigation"
        aria-label="Main navigation"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16 lg:h-20 relative">
                {{-- Logo --}}
                <div class="flex-shrink-0 z-10">
                    <a
                        href="{{ route('home') }}"
                        class="navbar-logo navbar-focus focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg p-1"
                        :class="{
                            'focus:ring-white': transparent,
                            'focus:ring-gray-900': !transparent
                        }"
                        aria-label="Go to homepage"
                    >
                        @php
                            $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
                            $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
                        @endphp
                        <img
                            class="h-8 sm:h-10 lg:h-12 w-auto transition-all duration-300"
                            src="{{ $logoUrl ?? asset('images/logo.svg') }}"
                            alt="{{ $siteName }} Logo"
                            onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}'"
                        >
                    </a>
                </div>

                {{-- Desktop Navigation - Centered (only on xl screens and above) --}}
                <div class="hidden xl:flex items-center gap-1 2xl:gap-2 flex-1 justify-center min-w-0 px-4 2xl:px-6">
                    {{-- Dynamic Navigation Items --}}
                    @foreach($navigationItems as $navItem)
                        @php
                            // Navigation Items already filtered at repository level (is_active = true, section = 'main')
                            $children = $navItem->children ?? collect([]);
                            $hasChildren = $children->count() > 0;
                            
                            // Get URL from NavigationItem (handles route_name, url, slug, external)
                            $navUrl = $navItem->url ?? '#';
                            
                            // Check active state - improved detection
                            // Check active state using View Composer helper
                            $activeState = $navItem->isActive ?? false;
                            
                            // Link attributes
                            $linkAttrs = '';
                            if ($navItem->is_external || $navItem->target_blank) {
                                $linkAttrs = 'target="_blank" rel="noopener noreferrer"';
                            }
                        @endphp

                        @if($hasChildren)
                            {{-- Dropdown Menu Item --}}
                            <div class="relative" x-data="{ open: false }">
                                <button
                                    @click="open = !open"
                                    @keydown.escape="open = false"
                                    class="nav-link flex items-center gap-1 px-2 2xl:px-3 py-2 text-xs 2xl:text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors whitespace-nowrap"
                                    :class="{
                                        'text-white hover:bg-white/10 focus:ring-white': transparent,
                                        'text-gray-900 hover:bg-gray-100 focus:ring-gray-900': !transparent,
                                        'bg-white/20 font-semibold': transparent && {{ $activeState ? 'true' : 'false' }},
                                        'bg-gray-100 font-semibold': !transparent && {{ $activeState ? 'true' : 'false' }}
                                    }"
                                    :aria-expanded="open"
                                    aria-haspopup="true"
                                >
                                    @if($navItem->icon && !str_starts_with($navItem->icon, 'heroicon'))
                                        <span class="inline-block mr-2">{!! $navItem->icon !!}</span>
                                    @endif
                                    <span>{{ $navItem->title }}</span>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div
                                    x-show="open"
                                    @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute left-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl min-w-[220px] z-50 py-1"
                                    style="display: none;"
                                >
                                    {{-- Parent Link (if route_name or url exists) --}}
                                    @if($navItem->route_name || $navItem->url)
                                        <a
                                            href="{{ $navUrl }}"
                                            class="block px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50 transition-colors border-b border-gray-100"
                                            @click="open = false"
                                            {!! $linkAttrs !!}
                                        >
                                            {{ $navItem->title }}
                                        </a>
                                    @endif

                                    {{-- Child Navigation Items --}}
                                    @foreach($children as $child)
                                        @php
                                            $childUrl = $child->url ?? '#';
                                            $childLinkAttrs = '';
                                            if ($child->is_external || $child->target_blank) {
                                                $childLinkAttrs = 'target="_blank" rel="noopener noreferrer"';
                                            }
                                            
                                            // Check active state for child
                                            $childActive = false;
                                            if ($child->route_name) {
                                                try {
                                                    $childActive = request()->routeIs($child->route_name);
                                                } catch (\Exception $e) {
                                                    // Route doesn't exist
                                                }
                                            }
                                        @endphp
                                        <a
                                            href="{{ $childUrl }}"
                                            class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors {{ $childActive ? 'bg-gray-50 font-medium' : '' }}"
                                            @click="open = false"
                                            {!! $childLinkAttrs !!}
                                            aria-current="{{ $childActive ? 'page' : null }}"
                                        >
                                            @if($child->icon && !str_starts_with($child->icon, 'heroicon'))
                                                <span class="inline-block mr-2">{!! $child->icon !!}</span>
                                            @endif
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            {{-- Simple Link Menu Item --}}
                            <a
                                href="{{ $navUrl }}"
                                class="nav-link flex items-center gap-1 px-2 2xl:px-3 py-2 text-xs 2xl:text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors whitespace-nowrap"
                                :class="{
                                    'text-white hover:bg-white/10 focus:ring-white': transparent,
                                    'text-gray-900 hover:bg-gray-100 focus:ring-gray-900': !transparent,
                                    'bg-white/20 font-semibold': transparent && {{ $activeState ? 'true' : 'false' }},
                                    'bg-gray-100 font-semibold': !transparent && {{ $activeState ? 'true' : 'false' }}
                                }"
                                aria-current="{{ $activeState ? 'page' : null }}"
                                {!! $linkAttrs !!}
                            >
                                @if($navItem->icon && !str_starts_with($navItem->icon, 'heroicon'))
                                    <span>{!! $navItem->icon !!}</span>
                                @endif
                                <span>{{ $navItem->title }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Right Side --}}
                <div class="hidden lg:flex items-center space-x-3 flex-shrink-0 z-10">
                    {{-- Logout Button (only for logged-in users) --}}
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button
                                type="submit"
                                class="px-4 py-2.5 rounded-lg text-base font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"
                                :class="{
                                    'text-white hover:bg-white/10 focus:ring-white': transparent,
                                    'text-gray-900 hover:bg-gray-100 focus:ring-gray-900': !transparent
                                }"
                            >
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>

                {{-- Mobile Menu Button (show on screens below xl) --}}
                <div class="xl:hidden flex-shrink-0 ml-auto z-10">
                    <button
                        @click.stop="mobileMenuOpen = !mobileMenuOpen; $dispatch('mobile-menu-toggle', { open: mobileMenuOpen })"
                        class="inline-flex items-center justify-center p-2.5 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 min-w-[44px] min-h-[44px]"
                        :class="{
                            'text-white hover:bg-white/10 focus:ring-white': transparent,
                            'text-gray-900 hover:bg-gray-100 focus:ring-gray-900': !transparent
                        }"
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
</header>

{{-- Mobile Menu Dropdown (inline accordion - show on screens below xl) --}}
<div 
    x-data="{ mobileMenuOpen: false }"
    @mobile-menu-toggle.window="mobileMenuOpen = $event.detail.open"
    class="xl:hidden"
>
    <div
        x-show="mobileMenuOpen"
        x-cloak
        @keydown.escape.window="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="fixed top-16 left-0 right-0 bg-white shadow-lg border-t border-gray-200 max-h-[calc(100vh-4rem)] overflow-y-auto"
        style="z-index: 9998;"
        id="mobile-menu"
        role="navigation"
        aria-label="Mobile navigation"
    >
        <div class="py-4 px-4">
            <nav class="space-y-1">
                        {{-- Dynamic Navigation Items --}}
                        @foreach($navigationItems as $navItem)
                            @php
                                // Navigation Items already filtered at repository level (is_active = true, section = 'main')
                                $children = $navItem->children ?? collect([]);
                                $hasChildren = $children->count() > 0;
                                
                                // Get URL from NavigationItem (handles route_name, url, slug, external)
                                $navUrl = $navItem->url ?? '#';
                                
                                // Check active state for mobile
                                $isActiveMobile = false;
                                
                                // Check active state using View Composer helper
                                $isActiveMobile = $navItem->isActive ?? false;
                                
                                // Link attributes
                                $linkAttrs = '';
                                if ($navItem->is_external || $navItem->target_blank) {
                                    $linkAttrs = 'target="_blank" rel="noopener noreferrer"';
                                }
                            @endphp

                            @if($hasChildren)
                                {{-- Navigation Item with Children --}}
                                <div x-data="{ open: false }" class="space-y-1">
                                    <button
                                        @click="open = !open"
                                        class="flex items-center justify-between w-full px-4 py-3 text-base font-medium rounded-lg text-gray-900 hover:bg-gray-100 transition-colors"
                                        :class="{{ $isActiveMobile ? 'true' : 'false' }} ? 'bg-gray-100 font-semibold' : ''"
                                    >
                                        <span class="flex items-center gap-2">
                                            @if($navItem->icon && !str_starts_with($navItem->icon, 'heroicon'))
                                                <span>{!! $navItem->icon !!}</span>
                                            @endif
                                            <span>{{ $navItem->title }}</span>
                                        </span>
                                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div 
                                        x-show="open"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-96"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 max-h-96"
                                        x-transition:leave-end="opacity-0 max-h-0"
                                        class="pl-4 space-y-1 ml-4 overflow-hidden border-l-2 border-gray-200"
                                    >
                                        {{-- Parent Link (if route_name or url exists) --}}
                                        @if($navItem->route_name || $navItem->url)
                                            <a
                                                href="{{ $navUrl }}"
                                                @click="mobileMenuOpen = false"
                                                class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors text-gray-800 hover:bg-gray-100 border-b border-gray-100"
                                                {!! $linkAttrs !!}
                                            >
                                                {{ $navItem->title }}
                                            </a>
                                        @endif
                                        {{-- Child Navigation Items --}}
                                        @foreach($children as $child)
                                            @php
                                                $childUrl = $child->url ?? '#';
                                                $childLinkAttrs = '';
                                                if ($child->is_external || $child->target_blank) {
                                                    $childLinkAttrs = 'target="_blank" rel="noopener noreferrer"';
                                                }
                                                
                                                // Check active state for child
                                                $childActive = false;
                                                if ($child->route_name) {
                                                    try {
                                                        $childActive = request()->routeIs($child->route_name);
                                                    } catch (\Exception $e) {
                                                        // Route doesn't exist
                                                    }
                                                }
                                            @endphp
                                            <a
                                                href="{{ $childUrl }}"
                                                @click="mobileMenuOpen = false"
                                                class="block px-4 py-2.5 text-sm rounded-lg transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ $childActive ? 'font-medium bg-gray-50' : '' }}"
                                                {!! $childLinkAttrs !!}
                                                aria-current="{{ $childActive ? 'page' : null }}"
                                            >
                                                @if($child->icon && !str_starts_with($child->icon, 'heroicon'))
                                                    <span class="inline-block mr-2">{!! $child->icon !!}</span>
                                                @endif
                                                {{ $child->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                {{-- Simple Link Menu Item --}}
                                <a
                                    href="{{ $navUrl }}"
                                    @click="mobileMenuOpen = false"
                                    class="block px-4 py-3 text-base font-medium rounded-lg transition-colors text-gray-900 hover:bg-gray-100"
                                    :class="{{ $isActiveMobile ? 'true' : 'false' }} ? 'bg-gray-100 font-semibold' : ''"
                                    {!! $linkAttrs !!}
                                >
                                    <span class="flex items-center gap-2">
                                        @if($navItem->icon && !str_starts_with($navItem->icon, 'heroicon'))
                                            <span>{!! $navItem->icon !!}</span>
                                        @endif
                                        <span>{{ $navItem->title }}</span>
                                    </span>
                                </a>
                            @endif
                        @endforeach

                        {{-- Mobile Logout (only for logged-in users) --}}
                        @auth
                            <div class="px-2 py-3 mt-auto border-t border-gray-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="block w-full text-left px-4 py-3 text-base font-medium rounded-lg transition-colors text-gray-900 hover:bg-gray-100"
                                    >
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @endauth
            </nav>
        </div>
    </div>
</div>
