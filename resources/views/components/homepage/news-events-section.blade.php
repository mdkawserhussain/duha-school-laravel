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
            $orderClause = \Illuminate\Support\Facades\Schema::hasColumn('events', 'start_at') ? 'COALESCE(start_at, event_date)' : 'event_date';
            $events = $upcomingEvents ?? \App\Models\Event::with('media')->published()->upcoming()->orderByRaw($orderClause . ' asc')->limit(3)->get();
            
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

        <!-- Events Grid -->
        <div class="grid gap-6">
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
                    
                    // Format date
                    $start = $event->start_at ?? $event->event_date;
                    $formattedDate = $start ? $start->format('M d') : '';
                @endphp
                <article class="group flex flex-col gap-4 sm:gap-6 rounded-3xl border p-4 sm:p-6 transition-all hover:-translate-y-1 sm:flex-row sm:items-center sm:justify-between" style="border-color: #d1d5db; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);" onmouseover="this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'" onmouseout="this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                    <!-- Left: Date Badge & Content -->
                    <div class="flex items-start sm:items-center gap-3 sm:gap-4 md:gap-6">
                        <!-- Date Badge -->
                        <div class="shrink-0 rounded-2xl border px-4 py-3 sm:px-5 sm:py-4 text-center" style="background: linear-gradient(135deg, #173B7A, #0F224C); border-color: #173B7A; box-shadow: 0 4px 6px rgba(23, 59, 122, 0.2);">
                            <span class="text-xl sm:text-2xl font-bold block" style="color: #ffffff;">{{ $formattedDate }}</span>
                        </div>

                        <!-- Event Details -->
                        <div class="flex-1 min-w-0">
                            <!-- Category Chip -->
                            <span class="inline-flex items-center rounded-full border px-2.5 sm:px-3 py-1 text-xs font-semibold uppercase tracking-wide category-chip-{{ \Illuminate\Support\Str::slug($categoryKey) }}">
                                {{ $event->category ?? 'General' }}
                            </span>

                            <!-- Title -->
                            <h3 class="mt-2 sm:mt-3 text-lg sm:text-xl md:text-2xl font-semibold" style="color: #0C1B3D;">{{ $event->title }}</h3>

                            <!-- Description -->
                            <p class="mt-1.5 sm:mt-2 text-sm sm:text-base leading-relaxed" style="color: #4a5568;">{{ Str::limit(strip_tags($event->excerpt ?? $event->content ?? $event->description), 100) }}</p>
                        </div>
                    </div>

                    <!-- Right: Arrow Button -->
                    <a href="{{ route('events.show', $event) }}" class="group/btn inline-flex items-center justify-center gap-2 rounded-full px-5 sm:px-6 py-3 text-xs sm:text-sm font-semibold transition-all sm:shrink-0 min-h-[44px] w-full sm:w-auto" style="background-color: #F4C430; color: #0C1B3D; box-shadow: 0 4px 6px rgba(244, 196, 48, 0.2);" onmouseover="this.style.backgroundColor='#ffdc5c'; this.style.boxShadow='0 10px 15px -3px rgba(244, 196, 48, 0.5)'; this.style.transform='scale(1.05)'" onmouseout="this.style.backgroundColor='#F4C430'; this.style.boxShadow='0 4px 6px rgba(244, 196, 48, 0.2)'; this.style.transform='scale(1)'">
                            Details
                        <svg class="h-3.5 w-3.5 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </article>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500">No upcoming events at this time.</p>
                </div>
            @endforelse
        </div>

        <!-- View All Events CTA -->
        <div class="mt-8 sm:mt-12 text-center px-4">
            <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center rounded-full border-2 px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-semibold backdrop-blur-sm transition-all min-h-[44px] w-full sm:w-auto" style="border-color: #173B7A; background-color: #ffffff; color: #173B7A; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" onmouseover="this.style.backgroundColor='#173B7A'; this.style.color='#ffffff'; this.style.boxShadow='0 10px 15px -3px rgba(23, 59, 122, 0.3)'" onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#173B7A'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
                View All Events
                <svg class="ml-2 sm:ml-3 h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
