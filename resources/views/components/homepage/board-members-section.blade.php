<!-- Board Members Section - AISD Style -->
<section class="bg-[#1a1f3a] py-24 text-white" id="board-members">
    <div class="container mx-auto px-6 lg:px-12">
        <!-- Section Header -->
        <div class="flex flex-col gap-6 text-center mb-14">
            <p class="text-xs font-semibold uppercase tracking-[0.5em] text-blue-300/70">Governance</p>
            <h2 class="text-3xl font-bold md:text-4xl lg:text-5xl text-white">Board of Management</h2>
            <p class="mx-auto max-w-3xl text-white/70 leading-relaxed">Dedicated professionals guiding our institution with wisdom, experience, and commitment to excellence in Islamic education.</p>
        </div>

        @php
            $members = \App\Helpers\SiteSettingsHelper::boardMembers();

            // Fallback to hardcoded data if no board members are configured
            if (empty($members)) {
                $members = [
                    [
                        'name' => 'Dr. Ahmed Hassan',
                        'title' => 'CHAIRMAN & PRINCIPAL',
                        'organization' => 'AL-MAGHRIB INTERNATIONAL SCHOOL',
                        'bio' => 'Experienced educator with over 20 years in Islamic and Cambridge curriculum development.',
                        'profile_image_url' => asset('images/placeholder.svg'),
                    ],
                    [
                        'name' => 'Prof. Fatima Khan',
                        'title' => 'VICE CHAIRMAN',
                        'organization' => 'AL-MAGHRIB INTERNATIONAL SCHOOL',
                        'bio' => 'Renowned Islamic studies scholar and curriculum specialist with international recognition.',
                        'profile_image_url' => asset('images/placeholder.svg'),
                    ],
                    [
                        'name' => 'Mr. Omar Abdullah',
                        'title' => 'TREASURER',
                        'organization' => 'AL-MAGHRIB INTERNATIONAL SCHOOL',
                        'bio' => 'Financial expert ensuring sustainable development and resource management for educational excellence.',
                        'profile_image_url' => asset('images/placeholder.svg'),
                    ],
                    [
                        'name' => 'Dr. Aisha Rahman',
                        'title' => 'ACADEMIC DIRECTOR',
                        'organization' => 'AL-MAGHRIB INTERNATIONAL SCHOOL',
                        'bio' => 'Leading academic innovation and maintaining high standards in Cambridge and Islamic education.',
                        'profile_image_url' => asset('images/placeholder.svg'),
                    ],
                ];
            }
        @endphp

        <!-- Board Members Grid -->
        <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($members as $member)
                <div
                    class="group rounded-3xl bg-blue-900/20 border border-blue-400/20 p-6 text-center shadow-card backdrop-blur-xl transition-all hover:bg-blue-800/30 hover:shadow-soft hover:-translate-y-1"
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
                        <div class="absolute inset-0 rounded-full border-2 border-blue-300/40 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>

                    <!-- Name -->
                    <h3 class="mt-6 text-xl font-semibold text-white">{{ $member['name'] }}</h3>

                    <!-- Role Badge -->
                    <p class="mt-2 text-sm uppercase tracking-[0.3em] text-blue-300 font-semibold">
                        {{ $member['title'] }}
                    </p>

                    <!-- Organization -->
                    @if(!empty($member['organization']))
                        <p class="mt-1 text-xs text-white/60 uppercase tracking-wide">
                            {{ $member['organization'] }}
                        </p>
                    @endif

                    <!-- Bio -->
                    <p
                        class="mt-4 text-sm text-white/70 leading-relaxed"
                        x-show="!expanded"
                        x-transition
                    >
                        {{ \Illuminate\Support\Str::limit($member['bio'], 100) }}
                    </p>

                    <p
                        class="mt-4 text-sm text-white/70 leading-relaxed"
                        x-show="expanded"
                        x-transition
                    >
                        {{ $member['bio'] }}
                    </p>

                    @if(strlen($member['bio']) > 100)
                        <button
                            @click="expanded = !expanded"
                            class="mt-2 text-sm font-semibold text-blue-300"
                        >
                            <span x-show="!expanded">Read More</span>
                            <span x-show="expanded">Show Less</span>
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
