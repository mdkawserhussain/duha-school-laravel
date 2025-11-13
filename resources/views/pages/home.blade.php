@extends('layouts.app')

@section('title', 'Welcome to Al-Maghrib International School')
@section('meta-description', 'Islamic and Cambridge curriculum school providing quality education in Chattogram, Bangladesh')

@push('scripts')
    <x-organization-structured-data />
    @vite(['resources/js/homepage.js'])
@endpush

@section('content')
<main id="main-content" role="main" style="margin-top: 0; padding-top: 0;">
    <x-home.hero
        :badge="$hero['badge'] ?? null"
        :heading="$hero['heading'] ?? null"
        :description="$hero['description'] ?? null"
        :primary-action="$hero['primaryAction'] ?? null"
        :secondary-action="$hero['secondaryAction'] ?? null"
        :stats="$hero['stats'] ?? []"
        :hero-slides="$heroSlides ?? null"
    />

    <x-home.info-panels :panels="$featurePanels" />

    <x-home.stat-highlight :items="$statHighlights" />

    <!-- Upcoming Events Section -->
    @if($upcomingEvents && $upcomingEvents->count() > 0)
    <section class="section-modern bg-gradient-to-br from-slate-50 to-indigo-50/30 scroll-fade-in section-bg-tilt-right" aria-labelledby="upcoming-events-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12">
                <div class="mb-6 md:mb-0">
                    <h2 id="upcoming-events-heading" class="heading-modern text-gradient mb-2">Upcoming Events</h2>
                    <p class="heading-modern-subtitle">Stay connected with our latest activities and celebrations</p>
                </div>
                <a href="{{ route('events.index') }}" class="btn-modern-primary self-start md:self-auto">
                    View All Events
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            
            <!-- Desktop Grid - Show 3-5 events -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
                @foreach($upcomingEvents->take(5) as $index => $event)
                <article class="event-card stagger-item group" style="transition-delay: {{ $index * 100 }}ms" tabindex="0">
                    <a href="{{ route('events.show', $event) }}" class="block focus-visible-modern h-full flex flex-col">
                        <div class="relative overflow-hidden rounded-t-2xl">
                            @if($event->hasMedia('cover_image'))
                                <img src="{{ $event->getFirstMediaUrl('cover_image', 'medium') }}"
                                     alt="{{ $event->title }}"
                                     class="w-full h-48 md:h-56 object-cover transition-transform duration-500 group-hover:scale-110"
                                     loading="lazy">
                            @else
                                <div class="w-full h-48 md:h-56 gradient-indigo-violet"></div>
                            @endif
                            <div class="event-date-badge">
                                <div class="text-xs font-normal opacity-90">{{ $event->event_date->format('M') }}</div>
                                <div class="text-xl font-bold">{{ $event->event_date->format('d') }}</div>
                                <div class="text-xs font-normal opacity-90">{{ $event->event_date->format('Y') }}</div>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col bg-white">
                            <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $event->title }}</h3>
                            <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-1">{{ strip_tags($event->description) }}</p>
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                                <span class="text-sm font-semibold text-indigo-600">Learn More →</span>
                                <time datetime="{{ $event->event_date->format('Y-m-d') }}" class="text-xs text-slate-500">
                                    {{ $event->event_date->format('F j, Y') }}
                                </time>
                            </div>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Vision & Mission Section -->
    @php
        $visionPage = $visionPage ?? \App\Models\Page::where('slug', 'vision')->published()->first();
    @endphp
    @if($visionPage)
    <section class="section-modern vision-section scroll-fade-in section-bg-angle-right" aria-labelledby="vision-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left Column: Content -->
                <div class="space-y-6">
                    <div class="vision-icon">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 id="vision-heading" class="heading-modern text-slate-900" style="letter-spacing: -0.02em; line-height: 1.3;">{{ $visionPage->title }}</h2>
                    <div class="text-slate-700 leading-relaxed text-lg md:text-xl" style="letter-spacing: 0.01em; line-height: 1.8;">
                        {!! $visionPage->content !!}
                    </div>
                    <div class="flex items-center gap-4 pt-4">
                        <div class="vision-icon">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 mb-1">Our Mission</h3>
                            <p class="text-slate-600 text-sm">Empowering students with knowledge, character, and faith</p>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Image & Video -->
                <div class="space-y-6">
                    @if($visionPage->hasMedia('featured_image'))
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <img src="{{ $visionPage->getFirstMediaUrl('featured_image', 'large') }}"
                                 alt="{{ $visionPage->title }}"
                                 class="w-full h-64 md:h-80 object-cover"
                                 loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        </div>
                    @else
                        <div class="w-full h-64 md:h-80 rounded-3xl shadow-2xl gradient-violet-pink"></div>
                    @endif
                    <button class="btn-modern-primary w-full flex items-center justify-center gap-3" aria-label="Watch our vision video">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <span class="font-semibold">Watch Our Vision Video</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Competition Section -->
    @php
        $competitionSection = $homePageSections['video_2'] ?? null;
    @endphp
    <section class="section-modern animated-bg text-white scroll-fade-in relative section-bg-skew-left" aria-labelledby="competition-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    @if($competitionSection && isset($competitionSection->data['youtube_url']))
                        <div class="aspect-video bg-slate-900 flex items-center justify-center">
                            <button class="play-button-large w-20 h-20 bg-white bg-opacity-90 rounded-full flex items-center justify-center hover:bg-opacity-100 transition focus-visible-modern" aria-label="Play competition video">
                                <svg class="w-10 h-10 text-indigo-600" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="aspect-video gradient-violet-pink"></div>
                    @endif
                </div>
                <div>
                    <h2 id="competition-heading" class="heading-modern text-white mb-6">
                        {{ $competitionSection->title ?? 'Relieve the Spirit of Inter-School Quran Competition' }}
                    </h2>
                    @if($competitionSection && $competitionSection->subtitle)
                    <p class="text-xl text-indigo-100 mb-6 leading-relaxed">{{ $competitionSection->subtitle }}</p>
                    @endif
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 border-2 border-white rounded-full flex items-center justify-center animate-bounce">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <span class="text-lg">Scroll to explore more</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Al-Maghrib Section -->
    @php
        $whyChoose = $homePageSections['why_choose'] ?? null;
    @endphp
    @if($whyChoose)
    <section class="section-modern bg-white scroll-fade-in section-bg-tilt-left" aria-labelledby="why-choose-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 id="why-choose-heading" class="heading-modern text-gradient mb-6">{{ $whyChoose->title ?? 'Why Choose Al-Maghrib' }}</h2>
                    <div class="text-slate-700 leading-relaxed text-lg md:text-xl space-y-4" style="letter-spacing: 0.01em; line-height: 1.8;">
                        {!! $whyChoose->content ?? $whyChoose->description !!}
                    </div>
                </div>
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    @if($whyChoose->hasMedia('images'))
                        <img src="{{ $whyChoose->getFirstMediaUrl('images', 'large') }}"
                             alt="{{ $whyChoose->title }}"
                             class="w-full h-auto transition-transform duration-500 hover:scale-105"
                             loading="lazy">
                    @else
                        <div class="gradient-pink-amber w-full h-96"></div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Your Children, Our Responsibility Section -->
    @php
        $childrenResponsibility = $homePageSections['children_responsibility'] ?? null;
    @endphp
    @if($childrenResponsibility)
    <section class="section-modern animated-bg text-white scroll-fade-in relative" aria-labelledby="responsibility-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl order-2 lg:order-1">
                    @if($childrenResponsibility->hasMedia('images'))
                        <img src="{{ $childrenResponsibility->getFirstMediaUrl('images', 'large') }}"
                             alt="{{ $childrenResponsibility->title }}"
                             class="w-full h-auto transition-transform duration-500 hover:scale-105"
                             loading="lazy">
                    @else
                        <div class="gradient-amber-emerald w-full h-96"></div>
                    @endif
                </div>
                <div class="order-1 lg:order-2">
                    <h2 id="responsibility-heading" class="heading-modern text-white mb-6">
                        {{ $childrenResponsibility->title ?? 'Your Children, Our Responsibility' }}
                    </h2>
                    <div class="leading-relaxed space-y-4 text-indigo-100 text-lg md:text-xl" style="letter-spacing: 0.01em; line-height: 1.8;">
                        {!! $childrenResponsibility->content ?? $childrenResponsibility->description !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Our Values Section -->
    @php
        $valuesSection = $homePageSections['values'] ?? null;
        $values = $valuesSection && isset($valuesSection->data['values']) ? $valuesSection->data['values'] : [];
    @endphp
    @if($valuesSection && count($values) > 0)
    <section class="section-modern bg-gradient-to-br from-slate-50 to-emerald-50/20 scroll-fade-in section-bg-angle-left" aria-labelledby="values-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 id="values-heading" class="heading-modern text-gradient mb-4">{{ $valuesSection->title ?? 'Our Values' }}</h2>
                @if($valuesSection->description)
                <p class="heading-modern-subtitle max-w-2xl mx-auto">{{ $valuesSection->description }}</p>
                @endif
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($values as $index => $value)
                <div class="modern-card text-center stagger-item" style="transition-delay: {{ $index * 50 }}ms" tabindex="0">
                    <p class="text-slate-900 font-semibold text-base md:text-lg">{{ $value }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Advisors Section -->
    @php
        $advisorsSection = $homePageSections['advisors'] ?? null;
        $advisors = $advisorsSection && isset($advisorsSection->data['advisors']) ? $advisorsSection->data['advisors'] : [];
    @endphp
    @if($advisorsSection && count($advisors) > 0)
    <section class="section-modern bg-white scroll-fade-in section-bg-skew-right" aria-labelledby="advisors-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 id="advisors-heading" class="heading-modern text-gradient mb-4">{{ $advisorsSection->title ?? 'Here are Our Advisors' }}</h2>
                @if($advisorsSection->subtitle)
                <p class="heading-modern-subtitle max-w-3xl mx-auto">{{ $advisorsSection->subtitle }}</p>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @foreach($advisors as $index => $advisor)
                <article class="profile-card stagger-item" style="transition-delay: {{ $index * 100 }}ms" tabindex="0">
                    <div class="relative p-6 text-center">
                        <!-- Avatar -->
                        <div class="mb-4">
                            @if(isset($advisor['photo_url']))
                                <img src="{{ $advisor['photo_url'] }}"
                                     alt="{{ $advisor['name'] ?? 'Advisor photo' }}"
                                     class="profile-avatar mx-auto"
                                     loading="lazy">
                            @else
                                <div class="profile-avatar mx-auto gradient-indigo-violet flex items-center justify-center">
                                    <svg class="w-16 h-16 md:w-20 md:h-20 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Default Content -->
                        <div class="profile-default">
                            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $advisor['name'] ?? '' }}</h3>
                            <p class="text-indigo-600 font-semibold mb-3">{{ $advisor['title'] ?? '' }}</p>
                        </div>
                        
                        <!-- Hover Reveal -->
                        <div class="profile-hover-reveal">
                            <h3 class="text-xl font-bold mb-2">{{ $advisor['name'] ?? '' }}</h3>
                            <p class="text-indigo-200 font-semibold mb-3">{{ $advisor['title'] ?? '' }}</p>
                            <p class="text-white/90 text-sm leading-relaxed">{{ $advisor['description'] ?? 'Dedicated advisor committed to excellence in education.' }}</p>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Board of Management Section -->
    @php
        $boardSection = $homePageSections['board_management'] ?? null;
        $boardMembers = $boardSection && isset($boardSection->data['members']) ? $boardSection->data['members'] : [];
        $featuredStaff = $featuredStaff ?? collect();
    @endphp
    <section class="section-modern bg-gradient-to-br from-slate-50 to-violet-50/20 scroll-fade-in section-bg-tilt-right" aria-labelledby="board-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 id="board-heading" class="heading-modern text-gradient mb-4">{{ $boardSection->title ?? 'Board of Management' }}</h2>
                <p class="heading-modern-subtitle max-w-2xl mx-auto">Leading with vision, integrity, and dedication</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @if(count($boardMembers) > 0)
                    @foreach($boardMembers as $index => $member)
                    <article class="profile-card stagger-item" style="transition-delay: {{ $index * 100 }}ms" tabindex="0">
                        <div class="relative p-6 text-center">
                            <!-- Avatar -->
                            <div class="mb-4">
                                @if(isset($member['photo_url']))
                                    <img src="{{ $member['photo_url'] }}"
                                         alt="{{ $member['name'] ?? 'Board member photo' }}"
                                         class="profile-avatar mx-auto"
                                         loading="lazy">
                                @else
                                    <div class="profile-avatar mx-auto gradient-violet-pink flex items-center justify-center">
                                        <svg class="w-16 h-16 md:w-20 md:h-20 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Default Content -->
                            <div class="profile-default">
                                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $member['name'] ?? '' }}</h3>
                                <p class="text-violet-600 font-semibold mb-2">{{ $member['title'] ?? '' }}</p>
                                <p class="text-slate-600 text-sm">{{ $member['organization'] ?? 'AL-MAGHRIB INTERNATIONAL SCHOOL' }}</p>
                            </div>
                            
                            <!-- Hover Reveal -->
                            <div class="profile-hover-reveal" style="background: linear-gradient(135deg, #7C3AED 0%, #EC4899 100%);">
                                <h3 class="text-xl font-bold mb-2">{{ $member['name'] ?? '' }}</h3>
                                <p class="text-violet-200 font-semibold mb-3">{{ $member['title'] ?? '' }}</p>
                                <p class="text-white/90 text-sm mb-2">{{ $member['organization'] ?? 'AL-MAGHRIB INTERNATIONAL SCHOOL' }}</p>
                                @if(isset($member['bio']) && $member['bio'])
                                <p class="text-white/80 text-xs leading-relaxed mt-3">{{ $member['bio'] }}</p>
                                @endif
                            </div>
                        </div>
                    </article>
                    @endforeach
                @elseif($featuredStaff->count() > 0)
                    @foreach($featuredStaff->take(3) as $index => $staff)
                    <article class="profile-card stagger-item" style="transition-delay: {{ $index * 100 }}ms" tabindex="0">
                        <div class="relative p-6 text-center">
                            <div class="mb-4">
                                @if($staff->hasMedia('photo'))
                                    <img src="{{ $staff->getFirstMediaUrl('photo', 'medium') }}"
                                         alt="{{ $staff->name }}"
                                         class="profile-avatar mx-auto"
                                         loading="lazy">
                                @else
                                    <div class="profile-avatar mx-auto gradient-violet-pink flex items-center justify-center">
                                        <svg class="w-16 h-16 md:w-20 md:h-20 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="profile-default">
                                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $staff->name }}</h3>
                                <p class="text-violet-600 font-semibold mb-2">{{ $staff->position }}</p>
                                <p class="text-slate-600 text-sm">AL-MAGHRIB INTERNATIONAL SCHOOL</p>
                            </div>
                            <div class="profile-hover-reveal" style="background: linear-gradient(135deg, #7C3AED 0%, #EC4899 100%);">
                                <h3 class="text-xl font-bold mb-2">{{ $staff->name }}</h3>
                                <p class="text-violet-200 font-semibold mb-3">{{ $staff->position }}</p>
                                <p class="text-white/90 text-sm">AL-MAGHRIB INTERNATIONAL SCHOOL</p>
                            </div>
                        </div>
                    </article>
                    @endforeach
                @else
                    @foreach([
                        ['name' => 'MD MOHIBULLAH HELAL', 'title' => 'CHAIRMAN & PRINCIPAL'],
                        ['name' => 'MD NEAZUL HOQUE', 'title' => 'CEO & ACADEMIC DIRECTOR'],
                        ['name' => 'MOHAMMAD EMDAD ULLAH', 'title' => 'VICE PRINCIPAL']
                    ] as $index => $member)
                    <article class="profile-card stagger-item" style="transition-delay: {{ $index * 100 }}ms" tabindex="0">
                        <div class="relative p-6 text-center">
                            <div class="mb-4">
                                <div class="profile-avatar mx-auto gradient-violet-pink flex items-center justify-center">
                                    <svg class="w-16 h-16 md:w-20 md:h-20 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="profile-default">
                                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $member['name'] }}</h3>
                                <p class="text-violet-600 font-semibold mb-2">{{ $member['title'] }}</p>
                                <p class="text-slate-600 text-sm">AL-MAGHRIB INTERNATIONAL SCHOOL</p>
                            </div>
                            <div class="profile-hover-reveal" style="background: linear-gradient(135deg, #7C3AED 0%, #EC4899 100%);">
                                <h3 class="text-xl font-bold mb-2">{{ $member['name'] }}</h3>
                                <p class="text-violet-200 font-semibold mb-3">{{ $member['title'] }}</p>
                                <p class="text-white/90 text-sm">AL-MAGHRIB INTERNATIONAL SCHOOL</p>
                            </div>
                        </div>
                    </article>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Call-to-Action Section -->
    <section class="section-modern gradient-indigo-violet text-white scroll-fade-in relative overflow-hidden" aria-labelledby="cta-heading">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <h2 id="cta-heading" class="heading-modern text-white mb-6">Ready to Begin Your Journey?</h2>
            <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                Join Al-Maghrib International School and give your child the gift of balanced education that nurtures both mind and soul.
            </p>
            <div 
                x-data="{ loading: false, success: false }"
                class="flex flex-col sm:flex-row gap-4 justify-center items-center"
            >
                <a 
                    href="{{ route('admission.index') }}"
                    @click="loading = true; setTimeout(() => { loading = false; success = true; setTimeout(() => success = false, 3000); }, 1500)"
                    class="btn-modern bg-white text-indigo-600 hover:bg-indigo-50 min-w-[200px]"
                >
                    <span x-show="!loading && !success">Apply for Admission</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                    <span x-show="success && !loading" class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Redirecting...
                    </span>
                </a>
                <a 
                    href="{{ route('contact.index') }}"
                    class="btn-modern bg-transparent border-2 border-white text-white hover:bg-white/10"
                >
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Back to Top Button -->
    <div 
        x-data="{ show: false }"
        x-init="
            window.addEventListener('scroll', () => {
                show = (window.pageYOffset || document.documentElement.scrollTop) > 300;
            });
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-8 right-8 z-50 gradient-indigo-violet text-white rounded-full p-4 shadow-2xl hover:shadow-3xl transition-all duration-300 cursor-pointer focus:outline-none focus:ring-4 focus:ring-indigo-300 min-w-[48px] min-h-[48px] flex items-center justify-center"
        role="button"
        tabindex="0"
        aria-label="Back to top"
        @keydown.enter="window.scrollTo({ top: 0, behavior: 'smooth' })"
        @keydown.space.prevent="window.scrollTo({ top: 0, behavior: 'smooth' })"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </div>
</main>

@endsection
