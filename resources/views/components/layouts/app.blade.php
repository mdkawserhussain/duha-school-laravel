<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        @php
            $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
        @endphp
        <meta name="application-name" content="{{ $siteName }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ $siteName }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @vite('resources/css/app.css')

        <noscript>
            @vite('resources/css/fallback.css')
        </noscript>
    </head>

    <body class="antialiased">
        {{ $slot }}

        @vite('resources/js/app.js')
    </body>
</html>
