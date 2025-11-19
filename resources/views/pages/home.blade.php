@extends('layouts.app')

@php
    $siteName = \App\Helpers\SiteHelper::getSiteName();
@endphp
@section('title', 'Welcome to ' . $siteName)
@section('meta-description', 'Islamic and Cambridge curriculum school providing quality education in Chattogram, Bangladesh')

@push('scripts')
    <x-organization-structured-data />
    @vite(['resources/js/homepage.js'])
@endpush

@section('content')
<!-- Include Component-Based Homepage Sections -->

<!-- Hero Section -->
@include('components.homepage.hero-section')

<!-- Achievements Deck -->
@include('components.homepage.achievements-section')

<!-- Stats Section -->
@include('components.homepage.stats-section')

<!-- Upcoming Events -->
@include('components.homepage.news-events-section')

<!-- Vision & Mission -->
@include('components.homepage.vision-section')

<!-- Parallax Experience -->
@include('components.homepage.parallax-section')

<!-- Competitions -->
@include('components.homepage.competitions-section')

<!-- Advisors & Board -->
@include('components.homepage.advisors-section')

<!-- Board Members -->
@include('components.homepage.board-members-section')

<!-- Programs Section -->
@include('components.homepage.programs-section')



@endsection
