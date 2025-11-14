<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $siteName = \App\Helpers\SiteHelper::getSiteName();
            $siteDescription = \App\Helpers\SiteHelper::getSiteDescription();
        @endphp
        <title>@yield('title', $siteName)</title>
        
        @hasSection('meta-description')
            <meta name="description" content="@yield('meta-description')">
        @else
            <meta name="description" content="{{ $siteName }} - {{ $siteDescription }}">
        @endif

        @hasSection('meta-keywords')
            <meta name="keywords" content="@yield('meta-keywords')">
        @endif

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', $siteName)">
        @hasSection('meta-description')
            <meta property="og:description" content="@yield('meta-description')">
        @endif
        @hasSection('og-image')
            <meta property="og:image" content="@yield('og-image')">
        @else
            <meta property="og:image" content="{{ asset('images/og-default.jpg') }}">
        @endif
        <meta property="og:site_name" content="{{ $siteName }}">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="@yield('title', $siteName)">
        @hasSection('meta-description')
            <meta name="twitter:description" content="@yield('meta-description')">
        @endif
        @hasSection('og-image')
            <meta name="twitter:image" content="@yield('og-image')">
        @endif

        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Google Analytics -->
        @if(config('services.google_analytics.id'))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.google_analytics.id') }}');
        </script>
        @endif

        <!-- Google Tag Manager -->
        @if(config('services.google_tag_manager.id'))
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ config('services.google_tag_manager.id') }}');</script>
        <!-- End Google Tag Manager -->
        @endif

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])

        <noscript>
            @vite('resources/css/fallback.css')
        </noscript>
        
    </head>
    <body class="font-sans antialiased">
        @if(config('services.google_tag_manager.id'))
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('services.google_tag_manager.id') }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        @endif

        <div class="min-h-screen">
            <x-header />

            <!-- Page Content -->
            <main id="main-content">
                @yield('content')
            </main>

            <x-footer />
        </div>
        
        <!-- Simple Vanilla JS Lightbox -->
        <div id="lightbox-overlay" class="lightbox-overlay" style="display: none;">
            <div class="lightbox-container">
                <img id="lightbox-image" src="" alt="" />
                <button id="lightbox-close" class="lightbox-close">&times;</button>
                <div id="lightbox-counter" class="lightbox-counter"></div>
            </div>
        </div>
        
        <script>
            // Simple Vanilla JS Lightbox Implementation
            document.addEventListener('DOMContentLoaded', function() {
                const overlay = document.getElementById('lightbox-overlay');
                const image = document.getElementById('lightbox-image');
                const closeBtn = document.getElementById('lightbox-close');
                const counter = document.getElementById('lightbox-counter');
                
                let currentImages = [];
                let currentIndex = 0;
                
                // Find all lightbox links
                const lightboxLinks = document.querySelectorAll('a[data-lightbox]');
                
                lightboxLinks.forEach((link, index) => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Get all images in the same gallery
                        const gallery = this.getAttribute('data-lightbox');
                        currentImages = Array.from(document.querySelectorAll(`a[data-lightbox="${gallery}"]`));
                        currentIndex = currentImages.indexOf(this);
                        
                        showLightbox(this.href, this.getAttribute('data-title') || '');
                    });
                });
                
                function showLightbox(src, title) {
                    image.src = src;
                    image.alt = title;
                    updateCounter();
                    overlay.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
                
                function hideLightbox() {
                    overlay.style.display = 'none';
                    document.body.style.overflow = '';
                }
                
                function updateCounter() {
                    if (currentImages.length > 1) {
                        counter.textContent = `${currentIndex + 1} of ${currentImages.length}`;
                        counter.style.display = 'block';
                    } else {
                        counter.style.display = 'none';
                    }
                }
                
                function showNext() {
                    if (currentIndex < currentImages.length - 1) {
                        currentIndex++;
                        const nextLink = currentImages[currentIndex];
                        showLightbox(nextLink.href, nextLink.getAttribute('data-title') || '');
                    }
                }
                
                function showPrev() {
                    if (currentIndex > 0) {
                        currentIndex--;
                        const prevLink = currentImages[currentIndex];
                        showLightbox(prevLink.href, prevLink.getAttribute('data-title') || '');
                    }
                }
                
                // Event listeners
                closeBtn.addEventListener('click', hideLightbox);
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) {
                        hideLightbox();
                    }
                });
                
                // Keyboard navigation
                document.addEventListener('keydown', function(e) {
                    if (overlay.style.display === 'flex') {
                        switch(e.key) {
                            case 'Escape':
                                hideLightbox();
                                break;
                            case 'ArrowLeft':
                                showPrev();
                                break;
                            case 'ArrowRight':
                                showNext();
                                break;
                        }
                    }
                });
            });
        </script>
        
        @stack('scripts')
    </body>
</html>
