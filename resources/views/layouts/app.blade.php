<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Al-Maghrib International School'))</title>

        @hasSection('meta-description')
            <meta name="description" content="@yield('meta-description')">
        @else
            <meta name="description" content="Al-Maghrib International School - Providing quality Islamic and Cambridge curriculum education for students from Kindergarten to Grade 12 in Chattogram, Bangladesh">
        @endif

        @hasSection('meta-keywords')
            <meta name="keywords" content="@yield('meta-keywords')">
        @endif

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', config('app.name', 'Al-Maghrib International School'))">
        @hasSection('meta-description')
            <meta property="og:description" content="@yield('meta-description')">
        @endif
        @hasSection('og-image')
            <meta property="og:image" content="@yield('og-image')">
        @else
            <meta property="og:image" content="{{ asset('images/og-default.jpg') }}">
        @endif
        <meta property="og:site_name" content="{{ config('app.name', 'Al-Maghrib International School') }}">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="@yield('title', config('app.name', 'Al-Maghrib International School'))">
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
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
        @stack('scripts')
    </head>
    <body class="font-sans antialiased">
        @if(config('services.google_tag_manager.id'))
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('services.google_tag_manager.id') }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        @endif

        <div class="min-h-screen bg-gray-100" style="margin: 0; padding: 0;">
            <x-navbar :transparent="request()->routeIs('home')" />

            <!-- Page Content -->
            <main class="{{ request()->routeIs('home') ? '' : 'pt-20 lg:pt-24' }}" style="{{ request()->routeIs('home') ? 'margin-top: 0 !important; padding-top: 0 !important;' : '' }}">
                @yield('content')
            </main>

            <x-footer />
        </div>
    </body>
</html>
