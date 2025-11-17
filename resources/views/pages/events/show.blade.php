@extends('layouts.app')

@section('title', $event->title . ' - Events')
@section('meta-description', Str::limit(strip_tags($event->excerpt), 160))

@push('scripts')
    <x-event-structured-data :event="$event" />
@endpush

@section('content')

    <!-- Page Header -->
    <section class="bg-gray-50 py-8 sm:py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Events', 'url' => route('events.index')],
                ['label' => $event->title, 'url' => null]
            ]" />

            <div class="max-w-4xl">
                @if($event->category)
                <span class="inline-block bg-blue-100 text-blue-800 text-xs sm:text-sm font-medium px-3 py-1 rounded-full mb-3 sm:mb-4">
                    {{ $event->category }}
                </span>
                @endif

                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">{{ $event->title }}</h1>

                <div class="flex flex-wrap items-center gap-3 sm:gap-4 md:gap-6 text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $event->formatted_date }}
                    </div>

                    @if($event->location)
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $event->location }}
                    </div>
                    @endif

                    @if($event->is_featured)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        Featured Event
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Event Content -->
    <section class="py-8 sm:py-12 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2 order-2 lg:order-1">
                    @if($event->featured_image)
                    <div class="mb-8">
                        <img src="{{ $event->featured_image }}" alt="{{ $event->title }}" class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg" loading="lazy">
                    </div>
                    @endif

                    @if($event->excerpt)
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-8">
                        <p class="text-lg text-gray-700 italic">{{ $event->excerpt }}</p>
                    </div>
                    @endif

                    @if($event->content)
                    <div class="prose prose-lg max-w-none">
                        {!! $event->content !!}
                    </div>
                    @endif

                    <!-- Event Actions -->
                    <div class="mt-6 sm:mt-8 pt-6 sm:pt-8 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                            <a href="{{ route('events.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 min-h-[44px] flex items-center justify-center text-center">
                                ← Back to Events
                            </a>

                            @if(!$event->is_past)
                            <a href="{{ route('events.ics', $event) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 min-h-[44px] flex items-center justify-center text-center">
                                📅 Download Calendar (.ics)
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 order-1 lg:order-2">
                    <!-- Event Details -->
                    <div class="bg-gray-50 rounded-lg p-4 sm:p-6 mb-4 sm:mb-6">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Event Details</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date & Time</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $event->formatted_date }}</dd>
                            </div>

                            @if($event->location)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Location</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $event->location }}</dd>
                            </div>
                            @endif

                            @if($event->category)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="text-sm text-gray-900 mt-1">
                                    <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $event->category }}</span>
                                </dd>
                            </div>
                            @endif

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="text-sm text-gray-900 mt-1">
                                    @if($event->is_past)
                                        <span class="text-red-600">Past Event</span>
                                    @else
                                        <span class="text-green-600">Upcoming</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Social Sharing -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 sm:p-6 mb-4 sm:mb-6">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Share This Event</h3>
                        <x-social-share 
                            :url="route('events.show', $event)"
                            :title="$event->title"
                            :description="Str::limit(strip_tags($event->excerpt ?? ''), 160)"
                            :image="$event->getFirstMediaUrl('featured_image')"
                        />
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Need More Information?</h3>
                        <p class="text-gray-600 mb-4">Contact our events coordinator for more details about this event.</p>
                        <div class="space-y-2">
                            <a href="tel:{{ str_replace([' ', '-'], '', config('contact.phone')) }}" class="flex items-center text-blue-600 hover:text-blue-800 transition duration-300">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ config('contact.phone_display') }}
                            </a>
                            <a href="mailto:info@almaghribschool.com" class="flex items-center text-blue-600 hover:text-blue-800 transition duration-300">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                info@almaghribschool.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function addToCalendar() {
            // Basic calendar integration - can be enhanced with proper ICS generation
            const eventTitle = "{{ addslashes($event->title) }}";
            const eventDetails = "{{ addslashes(strip_tags($event->excerpt ?? '')) }}";
            const start = "{{ ($event->start_at ?? $event->event_date) ? ($event->start_at ?? $event->event_date)->format('Ymd\\THis') : '' }}";
            const end = "{{ $event->end_at ? $event->end_at->format('Ymd\\THis') : (($event->start_at ?? $event->event_date) ? ($event->start_at ?? $event->event_date)->addHours(2)->format('Ymd\\THis') : '') }}";

            const googleCalendarUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventTitle)}&details=${encodeURIComponent(eventDetails)}&dates=${start}/${end}`;

            window.open(googleCalendarUrl, '_blank');
        }
    </script>

@endsection