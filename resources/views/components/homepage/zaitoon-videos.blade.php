{{-- Zaitoon Academy: Recent Videos (FR-9) --}}
@php
    // Get videos from homepage sections (FR-9.4)
    $homePageSections = $homePageSections ?? collect([]);
    $videoSection = $homePageSections->get('videos') ?? $homePageSections->get('recent_videos');
    $mainVideo = null;
    $recentVideos = [];
    if ($videoSection && isset($videoSection->data)) {
        $mainVideo = $videoSection->data['main_video'] ?? null;
        $recentVideos = $videoSection->data['recent_videos'] ?? [];
    }
    
    // Default video if none provided (FR-9.5)
    if (!$mainVideo) {
        $mainVideo = [
            'title' => 'Upgrade Your Islamic Vocabularies | NUSAIFA AMATULLAH ASMATH & Sayra Binte Gias | Class Two',
            'youtube_id' => 'dQw4w9WgXcQ',
            'thumbnail' => null,
        ];
    }
    
    // Default recent videos
    if (empty($recentVideos)) {
        $recentVideos = [
            [
                'title' => 'Arabic Speech by Afra Binte Aman on My Hobby',
                'youtube_id' => 'dQw4w9WgXcQ'
            ],
            [
                'title' => 'Hadith Memorization Exam | Abrar Md. Muhtadi Amin | Student of Tahfeez Section',
                'youtube_id' => 'dQw4w9WgXcQ'
            ],
            [
                'title' => 'Naat by Mehrima Binte Faruk | Seerah Competition - 2025',
                'youtube_id' => 'dQw4w9WgXcQ'
            ],
            [
                'title' => 'Annual Sports Day Highlights | Zaitoon Academy 2025',
                'youtube_id' => 'dQw4w9WgXcQ'
            ],
            [
                'title' => 'Quran Recitation Competition | Champion Performance',
                'youtube_id' => 'dQw4w9WgXcQ'
            ],
            [
                'title' => 'Science Fair Project Presentation | Grade 5 Students',
                'youtube_id' => 'dQw4w9WgXcQ'
            ],
        ];
    }
    
    // Combine main video with recent videos for switching
    $allVideos = array_merge([$mainVideo], $recentVideos);
@endphp

<section class="py-16 lg:py-20" 
         style="background-color: #f0f9f6;"
         x-data="{ 
             currentVideo: {{ json_encode($mainVideo) }},
             allVideos: {{ json_encode($allVideos) }}
         }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">
            {{-- Left Side: Main Video (58% width) --}}
            <div class="w-full lg:w-[58%]">
                <div class="bg-black rounded-xl overflow-hidden shadow-sm">
                    <div class="aspect-video">
                        <iframe 
                            class="w-full h-full"
                            :src="'https://www.youtube.com/embed/' + currentVideo.youtube_id"
                            :title="currentVideo.title || 'Video'"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
                <h3 class="text-base font-medium text-gray-900 mt-4 leading-relaxed" x-text="currentVideo.title || 'Video Title'"></h3>
            </div>
            
            {{-- Right Side: Recent Videos List (42% width) --}}
            <div class="w-full lg:w-[42%]">
                <h2 class="text-lg font-bold mb-4 tracking-tight" style="color: #0d5a47;">Recent Videos</h2>
                <div class="space-y-2.5">
                    <template x-for="(video, index) in allVideos" :key="index">
                        <button
                            @click="currentVideo = video"
                            class="group w-full flex gap-3 p-2.5 rounded-lg transition-all duration-200 text-left focus:outline-none focus:ring-2 focus:ring-offset-1"
                            :style="currentVideo.youtube_id === video.youtube_id
                                ? 'background-color: #d4f1e5; border: 1px solid #a8e6d2;'
                                : 'background-color: white; border: 1px solid #e5e7eb;'"
                            style="focus:ring-color: #0d5a47;"
                        >
                            <div class="shrink-0 w-32 h-[72px] bg-black rounded-md overflow-hidden">
                                <img 
                                    :src="'https://img.youtube.com/vi/' + (video.youtube_id || 'dQw4w9WgXcQ') + '/mqdefault.jpg'"
                                    :alt="video.title || 'Video ' + (index + 1)"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                >
                            </div>
                            <div class="flex-1 min-w-0 flex items-center">
                                <p class="text-sm leading-snug line-clamp-3 font-medium text-gray-700">
                                    <span x-text="video.title || 'Video Title ' + (index + 1)"></span>
                                </p>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>

