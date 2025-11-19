<!-- Upcoming Events Section - AISD Style with Date Badges & Category Chips -->
<section class="py-24" id="events" style="background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);">
    <style>
        .category-chip-academic {
            background-color: rgba(72, 187, 120, 0.25) !important;
            color: #2F855A !important;
            border-color: rgba(72, 187, 120, 0.4) !important;
        }
        .category-chip-social {
            background-color: rgba(66, 153, 225, 0.25) !important;
            color: #2B6CB0 !important;
            border-color: rgba(66, 153, 225, 0.4) !important;
        }
        .category-chip-islamic {
            background-color: rgba(237, 137, 54, 0.25) !important;
            color: #C05621 !important;
            border-color: rgba(237, 137, 54, 0.4) !important;
        }
        .category-chip-sports {
            background-color: rgba(229, 62, 62, 0.25) !important;
            color: #C53030 !important;
            border-color: rgba(229, 62, 62, 0.4) !important;
        }
        .category-chip-default {
            background-color: rgba(203, 213, 224, 0.25) !important;
            color: #4A5568 !important;
            border-color: rgba(203, 213, 224, 0.4) !important;
        }
    </style>
    <div class="container mx-auto px-6 lg:px-12">
        <!-- Section Header -->
        <div class="flex flex-col gap-4 sm:gap-6 lg:flex-row lg:items-center lg:justify-between mb-8 sm:mb-12 px-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.5em]" style="color: #173B7A;">Calendar</p>
                <h2 class="mt-2 sm:mt-3 text-2xl sm:text-3xl font-bold md:text-4xl lg:text-5xl" style="color: #0C1B3D;">Upcoming Events & Key Dates</h2>
                <p class="mt-2 sm:mt-3 text-sm sm:text-base max-w-2xl leading-relaxed" style="color: #4a5568;">Stay aligned with admission briefings, community gatherings, and student showcases inspired by Duha's rhythm.</p>
            </div>
            <a href="#calendar" class="inline-flex items-center rounded-full border px-4 sm:px-6 py-3 text-xs sm:text-sm font-semibold tracking-wide backdrop-blur-sm transition-all min-h-[44px] justify-center" style="border-color: #173B7A; background-color: #ffffff; color: #173B7A; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" onmouseover="this.style.backgroundColor='#173B7A'; this.style.color='#ffffff'" onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#173B7A'">
                Download Academic Calendar
                <svg class="ml-2 h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </a>
        </div>

        @php
            // Use dynamic events from the controller if available, otherwise fetch upcoming events
            // This ensures real-time updates when events are modified in the backend
            // The HomeController passes 'upcomingEvents' which is fetched via EventService
            if (isset($upcomingEvents)) {
                // Use events passed from controller (preferred method)
                $events = $upcomingEvents;
            } else {
                // Fallback: fetch directly if controller doesn't provide events
                $orderClause = \Illuminate\Support\Facades\Schema::hasColumn('events', 'start_at') 
                    ? 'COALESCE(start_at, event_date)' 
                    : 'event_date';
                $events = \App\Models\Event::with('media')
                    ->published()
                    ->upcoming()
                    ->orderByRaw($orderClause . ' asc')
                    ->limit(3)
                    ->get();
            }

            // Define category colors
            $categoryColors = [
                'Academic' => [
                    'bg' => 'rgba(72, 187, 120, 0.25)',
                    'text' => '#2F855A',
                    'border' => 'rgba(72, 187, 120, 0.4)'
                ],
                'Social' => [
                    'bg' => 'rgba(66, 153, 225, 0.25)',
                    'text' => '#2B6CB0',
                    'border' => 'rgba(66, 153, 225, 0.4)'
                ],
                'Islamic' => [
                    'bg' => 'rgba(237, 137, 54, 0.25)',
                    'text' => '#C05621',
                    'border' => 'rgba(237, 137, 54, 0.4)'
                ],
                'Sports' => [
                    'bg' => 'rgba(229, 62, 62, 0.25)',
                    'text' => '#C53030',
                    'border' => 'rgba(229, 62, 62, 0.4)'
                ],
                'default' => [
                    'bg' => 'rgba(203, 213, 224, 0.25)',
                    'text' => '#4A5568',
                    'border' => 'rgba(203, 213, 224, 0.4)'
                ]
            ];
        @endphp

        @php
            // Fetch important notices dynamically
            // Use notices passed from controller if available, otherwise fetch directly
            if (isset($importantNotices)) {
                // Use notices passed from controller (preferred method)
                $notices = $importantNotices;
            } else {
                // Fallback: fetch directly if controller doesn't provide notices
                $notices = \App\Models\Notice::with('media')
                    ->published()
                    ->important()
                    ->orderBy('published_at', 'desc')
                    ->limit(3)
                    ->get();
            }
            
            // Ensure notices have media relationships loaded
            if ($notices->isNotEmpty() && !$notices->first()->relationLoaded('media')) {
                $notices->load('media');
            }
        @endphp

        <!-- Two Column Layout -->
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Left Column: Upcoming Events -->
            <div>
                <h3 class="text-2xl font-bold mb-6" style="color: #0C1B3D;">Upcoming Events</h3>
                <div class="space-y-6">
                    @forelse ($events as $event)
                        @php
                            // Get category colors
                            $categoryKey = $event->category ?? 'default';
                            $categoryStyles = '';
                            switch($categoryKey) {
                                case 'Academic':
                                    $categoryStyles = 'background-color: rgba(72, 187, 120, 0.25); color: #2F855A; border-color: rgba(72, 187, 120, 0.4);';
                                    break;
                                case 'Social':
                                    $categoryStyles = 'background-color: rgba(66, 153, 225, 0.25); color: #2B6CB0; border-color: rgba(66, 153, 225, 0.4);';
                                    break;
                                case 'Islamic':
                                    $categoryStyles = 'background-color: rgba(237, 137, 54, 0.25); color: #C05621; border-color: rgba(237, 137, 54, 0.4);';
                                    break;
                                case 'Sports':
                                    $categoryStyles = 'background-color: rgba(229, 62, 62, 0.25); color: #C53030; border-color: rgba(229, 62, 62, 0.4);';
                                    break;
                                default:
                                    $categoryStyles = 'background-color: rgba(203, 213, 224, 0.25); color: #4A5568; border-color: rgba(203, 213, 224, 0.4);';
                            }

                            // Format date and time
                            $start = $event->start_at ?? $event->event_date;
                            $formattedDate = $start ? $start->format('M d, Y') : '';
                            $formattedTime = $event->start_at ? $event->start_at->format('g:i A') : '';
                        @endphp
                        <article class="group flex flex-col gap-4 rounded-2xl border p-5 transition-all hover:-translate-y-1" style="border-color: #d1d5db; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);" onmouseover="this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'" onmouseout="this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                            <!-- Header: Category & Date -->
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-wide category-chip-{{ \Illuminate\Support\Str::slug($categoryKey) }}">
                                    {{ $event->category ?? 'General' }}
                                </span>
                                <div class="text-sm font-medium" style="color: #4a5568;">
                                    {{ $formattedDate }}
                                    @if($formattedTime)
                                        <span class="ml-2">{{ $formattedTime }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Title -->
                            <h4 class="text-xl font-semibold" style="color: #0C1B3D;">{{ $event->title }}</h4>

                            <!-- Location -->
                            @if($event->location)
                                <div class="flex items-center text-sm" style="color: #4a5568;">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                            @endif

                            <!-- Description -->
                            <p class="leading-relaxed text-sm" style="color: #4a5568;">{{ Str::limit(strip_tags($event->excerpt ?? $event->content ?? $event->description), 120) }}</p>

                            <!-- Details Button -->
                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition-all self-start mt-2" style="background-color: #F4C430; color: #0C1B3D; box-shadow: 0 4px 6px rgba(244, 196, 48, 0.2);" onmouseover="this.style.backgroundColor='#ffdc5c'; this.style.boxShadow='0 10px 15px -3px rgba(244, 196, 48, 0.5)'; this.style.transform='scale(1.05)'" onmouseout="this.style.backgroundColor='#F4C430'; this.style.boxShadow='0 4px 6px rgba(244, 196, 48, 0.2)'; this.style.transform='scale(1)'">
                                Details
                                <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="14" height="14">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </article>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">No upcoming events at this time.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Column: Important Notices -->
            <div>
                <h3 class="text-2xl font-bold mb-6" style="color: #0C1B3D;">Important Notices</h3>
                <div class="space-y-6">
                    @forelse ($notices as $notice)
                        <article class="group rounded-2xl border p-5 transition-all hover:-translate-y-1" style="border-color: #d1d5db; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);" onmouseover="this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'" onmouseout="this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                            <!-- Header: Category & Date -->
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($notice->category === 'Academic') bg-green-100 text-green-800
                                    @elseif($notice->category === 'Administrative') bg-blue-100 text-blue-800
                                    @elseif($notice->category === 'Events') bg-yellow-100 text-yellow-800
                                    @elseif($notice->category === 'General') bg-gray-100 text-gray-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $notice->category ?? 'General' }}
                                </span>
                                <div class="text-sm font-medium" style="color: #4a5568;">
                                    {{ $notice->published_at ? $notice->published_at->format('M d, Y') : ($notice->created_at ? $notice->created_at->format('M d, Y') : '') }}
                                </div>
                            </div>

                            <!-- Title -->
                            <h4 class="text-xl font-semibold mb-3" style="color: #0C1B3D;">
                                @if($notice->slug)
                                    <a href="{{ route('notices.show', $notice) }}" class="hover:text-blue-600 transition duration-300">
                                        {{ $notice->title }}
                                    </a>
                                @else
                                    {{ $notice->title }}
                                @endif
                            </h4>

                            <!-- Summary -->
                            @if($notice->excerpt)
                                <p class="leading-relaxed text-sm mb-4" style="color: #4a5568;">{{ Str::limit(strip_tags($notice->excerpt), 150) }}</p>
                            @elseif($notice->content)
                                <p class="leading-relaxed text-sm mb-4" style="color: #4a5568;">{{ Str::limit(strip_tags($notice->content), 150) }}</p>
                            @endif

                            <!-- Read More Link -->
                            @if($notice->slug)
                                <a href="{{ route('notices.show', $notice) }}" class="inline-flex items-center text-sm font-medium transition-all" style="color: #173B7A;" onmouseover="this.style.color='#0F224C'" onmouseout="this.style.color='#173B7A'">
                                    Read More
                                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </article>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">No important notices at this time.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- View All CTAs -->
        <div class="mt-12 grid md:grid-cols-2 gap-6">
            <div class="text-center">
                <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full border-2 px-8 py-4 text-base font-semibold backdrop-blur-sm transition-all" style="border-color: #173B7A; background-color: #ffffff; color: #173B7A; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" onmouseover="this.style.backgroundColor='#173B7A'; this.style.color='#ffffff'; this.style.boxShadow='0 10px 15px -3px rgba(23, 59, 122, 0.3)'" onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#173B7A'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
                    View All Events
                    <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            <div class="text-center">
                <a href="{{ route('notices.index') }}" class="inline-flex items-center rounded-full border-2 px-8 py-4 text-base font-semibold backdrop-blur-sm transition-all" style="border-color: #173B7A; background-color: #ffffff; color: #173B7A; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" onmouseover="this.style.backgroundColor='#173B7A'; this.style.color='#ffffff'; this.style.boxShadow='0 10px 15px -3px rgba(23, 59, 122, 0.3)'" onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#173B7A'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
                    View All Notices
                    <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
