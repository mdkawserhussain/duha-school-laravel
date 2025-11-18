<!-- Advisor & Board Section - AISD Style -->
<section class="bg-[#0B1533] py-24 text-white" id="advisors">
    <div class="container mx-auto px-6 lg:px-12">
        <!-- Section Header -->
        <div class="flex flex-col gap-6 text-center mb-14">
            <p class="text-xs font-semibold uppercase tracking-[0.5em] text-aisd-gold/70">Advisory Council</p>
            <h2 class="text-3xl font-bold md:text-4xl lg:text-5xl text-white">Advisors</h2>
            <p class="mx-auto max-w-3xl text-white/70 leading-relaxed">Distinguished scholars, Cambridge examiners, and community leaders steward our Islamic ethos and academic rigor.</p>
        </div>

        @php
            $members = \App\Helpers\SiteSettingsHelper::advisors();

            // Fallback to hardcoded data if no advisors are configured
            if (empty($members)) {
                $members = [
                    [
                        'name' => 'Dr. Samira Ameen',
                        'title' => 'Chair, Board of Governors',
                        'description' => 'Former Cambridge examiner & Islamic pedagogy researcher.',
                        'profile_image_url' => asset('images/advisors/samira.svg'),
                        'linkedin_url' => '#',
                        'email' => 'samira.ameen@almaghrib.edu.bd'
                    ],
                    [
                        'name' => 'Sheikh Farid Rahman',
                        'title' => 'Religious Advisor',
                        'description' => 'Graduate of Al-Azhar, leads Quran sciences curriculum.',
                        'profile_image_url' => asset('images/advisors/farid.svg'),
                        'linkedin_url' => '#',
                        'email' => 'farid.rahman@almaghrib.edu.bd'
                    ],
                    [
                        'name' => 'Md. Kawser Hussain',
                        'title' => 'Founder & Advisor',
                        'description' => 'Visionary behind Duha-inspired transformation.',
                        'profile_image_url' => asset('images/advisors/kawser.svg'),
                        'linkedin_url' => '#',
                        'email' => 'kawser.hussain@almaghrib.edu.bd'
                    ],
                    [
                        'name' => 'Ayesha Siddiqua',
                        'title' => 'Academic Director',
                        'description' => 'Leads STEAM integration across Middle & Senior school.',
                        'profile_image_url' => asset('images/advisors/ayesha.svg'),
                        'linkedin_url' => '#',
                        'email' => 'ayesha.siddiqua@almaghrib.edu.bd'
                    ],
                ];
            }
        @endphp

        <!-- Advisors Grid -->
        <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($members as $member)
                <div
                    class="group rounded-3xl bg-white/5 border border-white/10 p-6 text-center shadow-card backdrop-blur-xl transition-all hover:bg-white/10 hover:shadow-soft hover:-translate-y-1"
                    x-data="{ expanded: false }"
                >
                    <!-- Circular Portrait Frame -->
                    <div class="mx-auto h-32 w-32 overflow-hidden rounded-full border-4 border-white/30 shadow-lg relative">
                        <img
                            src="{{ $member['profile_image_url'] }}"
                            alt="{{ $member['name'] }}"
                            class="h-full w-full object-cover transition-transform group-hover:scale-110"
                            loading="lazy"
                        >
                        <!-- Decorative ring -->
                        <div class="absolute inset-0 rounded-full border-2 border-aisd-gold/30 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>

                    <!-- Name -->
                    <h3 class="mt-6 text-xl font-semibold text-white">{{ $member['name'] }}</h3>

                    <!-- Role Badge -->
                    <p class="mt-2 text-sm uppercase tracking-[0.3em] text-aisd-gold font-semibold">
                        {{ $member['title'] }}
                    </p>

                    <!-- Bio -->
                    <p
                        class="mt-4 text-sm text-white/70 leading-relaxed"
                        x-show="!expanded"
                        x-transition
                    >
                        {{ \Illuminate\Support\Str::limit($member['description'], 100) }}
                    </p>

                    <p
                        class="mt-4 text-sm text-white/70 leading-relaxed"
                        x-show="expanded"
                        x-transition
                    >
                        {{ $member['description'] }}
                    </p>

                    @if(strlen($member['description']) > 100)
                        <button
                            @click="expanded = !expanded"
                            class="mt-2 text-sm font-semibold text-aisd-gold"
                        >
                            <span x-show="!expanded">Read More</span>
                            <span x-show="expanded">Show Less</span>
                        </button>
                    @endif

                    <!-- Social Links -->
                    <div class="mt-6 flex items-center justify-center gap-3">
                        @if(!empty($member['linkedin_url']))
                            <a
                                href="{{ $member['linkedin_url'] }}"
                                class="rounded-full bg-white/10 border border-white/20 p-2.5 hover:bg-white/20 hover:border-aisd-gold/50 transition-all group/link"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="LinkedIn profile for {{ $member['name'] }}"
                            >
                                <svg class="h-4 w-4 text-white group-hover/link:text-aisd-gold transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.23 0H1.77C.792 0 0 .775 0 1.732v20.535C0 23.225.792 24 1.77 24h20.46c.978 0 1.77-.775 1.77-1.733V1.732C24 .775 23.208 0 22.23 0zM7.06 20.452H3.56V9h3.5v11.452zM5.31 7.433a2.03 2.03 0 112.03-2.03 2.03 2.03 0 01-2.03 2.03zM20.452 20.452h-3.5v-5.569c0-1.33-.026-3.043-1.855-3.043-1.855 0-2.14 1.453-2.14 2.954v5.658h-3.5V9h3.36v1.561h.047c.468-.888 1.61-1.825 3.314-1.825 3.543 0 4.198 2.333 4.198 5.366v6.35z"/>
                                </svg>
                            </a>
                        @endif

                        @if(!empty($member['email']))
                            <a
                                href="mailto:{{ $member['email'] }}"
                                class="rounded-full bg-white/10 border border-white/20 p-2.5 hover:bg-white/20 hover:border-aisd-gold/50 transition-all group/link"
                                aria-label="Email {{ $member['name'] }}"
                            >
                                <svg class="h-4 w-4 text-white group-hover/link:text-aisd-gold transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
