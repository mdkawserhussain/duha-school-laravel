@extends('layouts.app')

@php
    $siteName = \App\Helpers\SiteSettingsHelper::websiteName() ?? 'Zaitoon Academy';
@endphp
@section('title', 'Welcome to ' . $siteName)
@section('meta-description', 'Islamic and Cambridge curriculum school providing quality education in Chattogram, Bangladesh')

@push('scripts')
    <x-organization-structured-data />
    @vite(['resources/js/homepage.js'])
@endpush

@section('content')
<!-- Zaitoon Academy Homepage Design -->

<!-- Hero Section with Green Background and Yellow Curve -->
@include('components.homepage.zaitoon-hero')

<!-- News Ticker/Announcement Bar -->
@include('components.homepage.zaitoon-news-ticker')

<!-- Introduction Section: Islamic Scholars -->
@include('components.homepage.zaitoon-introduction')

<!-- Recent Notices & Chairman's Message (Two Columns) -->
@include('components.homepage.zaitoon-notices-chairman')

<!-- Explore Our Services -->
@include('components.homepage.zaitoon-services')

{{-- Academic Programs (Removed as requested) --}}
{{-- @include('components.homepage.zaitoon-programs') --}}

<!-- Campus Activities & Events -->
@include('components.homepage.zaitoon-events')

<!-- Recent Videos -->
@include('components.homepage.zaitoon-videos')

<!-- Recent News -->
@include('components.homepage.zaitoon-news')

<!-- Testimonials -->
@include('components.homepage.zaitoon-testimonials')

<!-- Partners -->
@include('components.homepage.zaitoon-partners')

@endsection
