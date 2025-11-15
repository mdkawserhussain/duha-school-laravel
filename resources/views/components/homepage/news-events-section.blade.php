<!-- Upcoming Events Section - AISD Style with Date Badges & Category Chips -->
<section class="py-24" id="events" style="background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);">
    <div class="container mx-auto px-6 lg:px-12">
        <!-- Section Header -->
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between mb-12">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.5em]" style="color: #173B7A;">Calendar</p>
                <h2 class="mt-3 text-3xl font-bold md:text-4xl lg:text-5xl" style="color: #0C1B3D;">Upcoming Events & Key Dates</h2>
                <p class="mt-3 max-w-2xl leading-relaxed" style="color: #4a5568;">Stay aligned with admission briefings, community gatherings, and student showcases inspired by Duha's rhythm.</p>
            </div>
            <a href="#calendar" class="inline-flex items-center rounded-full border px-6 py-3 text-sm font-semibold tracking-wide backdrop-blur-sm transition-all" style="border-color: #173B7A; background-color: #ffffff; color: #173B7A; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" onmouseover="this.style.backgroundColor='#173B7A'; this.style.color='#ffffff'" onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#173B7A'">
                Download Academic Calendar
                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </a>
        </div>

        @php
            $events = [
                [
                    'date' => 'Dec 06',
                    'title' => 'Winter Quran Summit',
                    'copy' => 'Community-wide hifz recitation & nasheed evening.',
                    'tag' => 'Community',
                    'tagColor' => 'rgba(244, 196, 48, 0.25)',
                    'tagTextColor' => '#F4C430',
                    'tagBorderColor' => 'rgba(244, 196, 48, 0.4)'
                ],
                [
                    'date' => 'Jan 12',
                    'title' => 'STEM Expo & Robotics',
                    'copy' => 'Secondary students pitch prototypes to industry mentors.',
                    'tag' => 'STEM',
                    'tagColor' => 'rgba(110, 193, 245, 0.25)',
                    'tagTextColor' => '#6EC1F5',
                    'tagBorderColor' => 'rgba(110, 193, 245, 0.4)'
                ],
                [
                    'date' => 'Feb 05',
                    'title' => 'Admissions Open House',
                    'copy' => 'Campus tour plus parent Q&A with the Principal.',
                    'tag' => 'Admissions',
                    'tagColor' => 'rgba(255, 255, 255, 0.15)',
                    'tagTextColor' => '#ffffff',
                    'tagBorderColor' => 'rgba(255, 255, 255, 0.3)'
                ],
            ];
        @endphp

        <!-- Events Grid -->
        <div class="grid gap-6">
            @foreach ($events as $event)
                <article class="group flex flex-col gap-6 rounded-3xl border p-6 transition-all hover:-translate-y-1 sm:flex-row sm:items-center sm:justify-between" style="border-color: #d1d5db; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);" onmouseover="this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'" onmouseout="this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                    <!-- Left: Date Badge & Content -->
                    <div class="flex items-center gap-4 sm:gap-6">
                        <!-- Date Badge -->
                        <div class="flex-shrink-0 rounded-2xl border px-5 py-4 text-center" style="background: linear-gradient(135deg, #173B7A, #0F224C); border-color: #173B7A; box-shadow: 0 4px 6px rgba(23, 59, 122, 0.2);">
                            <span class="text-2xl font-bold block" style="color: #ffffff;">{{ $event['date'] }}</span>
                        </div>

                        <!-- Event Details -->
                        <div class="flex-1">
                            <!-- Category Chip -->
                            <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-wide" style="background-color: {{ $event['tagColor'] }}; color: {{ $event['tagTextColor'] }}; border-color: {{ $event['tagBorderColor'] }};">
                                {{ $event['tag'] }}
                            </span>

                            <!-- Title -->
                            <h3 class="mt-3 text-2xl font-semibold" style="color: #0C1B3D;">{{ $event['title'] }}</h3>

                            <!-- Description -->
                            <p class="mt-2 leading-relaxed" style="color: #4a5568;">{{ $event['copy'] }}</p>
                        </div>
                    </div>

                    <!-- Right: Arrow Button -->
                    <button class="group/btn inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-semibold transition-all sm:flex-shrink-0" style="background-color: #F4C430; color: #0C1B3D; box-shadow: 0 4px 6px rgba(244, 196, 48, 0.2);" onmouseover="this.style.backgroundColor='#ffdc5c'; this.style.boxShadow='0 10px 15px -3px rgba(244, 196, 48, 0.5)'; this.style.transform='scale(1.05)'" onmouseout="this.style.backgroundColor='#F4C430'; this.style.boxShadow='0 4px 6px rgba(244, 196, 48, 0.2)'; this.style.transform='scale(1)'">
                        Details
                        <svg class="h-3.5 w-3.5 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                </article>
            @endforeach
        </div>

        <!-- View All Events CTA -->
        <div class="mt-12 text-center">
            <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-full border-2 px-8 py-4 text-base font-semibold backdrop-blur-sm transition-all" style="border-color: #173B7A; background-color: #ffffff; color: #173B7A; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" onmouseover="this.style.backgroundColor='#173B7A'; this.style.color='#ffffff'; this.style.boxShadow='0 10px 15px -3px rgba(23, 59, 122, 0.3)'" onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#173B7A'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
                View All Events
                <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
