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
            'title' => 'Upgrade Your Islamic Vocabularies',
            'youtube_id' => 'dQw4w9WgXcQ', // Placeholder
            'thumbnail' => null,
        ];
    }
    
    // Default recent videos
    if (empty($recentVideos)) {
        $recentVideos = [
            ['title' => 'Video Title 1', 'youtube_id' => 'dQw4w9WgXcQ'],
            ['title' => 'Video Title 2', 'youtube_id' => 'dQw4w9WgXcQ'],
            ['title' => 'Video Title 3', 'youtube_id' => 'dQw4w9WgXcQ'],
        ];
    }
    
    // Combine main video with recent videos for switching
    $allVideos = array_merge([$mainVideo], $recentVideos);
@endphp

<section class="py-16 lg:py-24 bg-white" 
         x-data="{ 
             currentVideo: {{ json_encode($mainVideo) }},
             allVideos: {{ json_encode($allVideos) }}
         }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Side: Main Video (2/3 width) (FR-9.1) --}}
            <div class="lg:col-span-2">
                <h2 class="text-2xl sm:text-3xl font-bold text-za-green-primary mb-4">Recent Videos</h2>
                <div class="bg-gray-900 rounded-xl overflow-hidden shadow-2xl aspect-video">
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
                <h3 class="text-lg font-semibold text-gray-900 mt-4" x-text="currentVideo.title || 'Video Title'"></h3>
            </div>
            
            {{-- Right Side: Recent Videos List (1/3 width) (FR-9.2) --}}
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-za-green-primary mb-4">Recent Videos</h2>
                <div class="space-y-4">
                    <template x-for="(video, index) in allVideos" :key="index">
                        <button 
                            @click="currentVideo = video"
                            class="group w-full flex gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors text-left focus:outline-none focus:ring-2 focus:ring-za-green-primary"
                            :class="currentVideo.youtube_id === video.youtube_id ? 'bg-za-green-50 border-2 border-za-green-primary' : ''"
                        >
                            <div class="flex-shrink-0 w-32 h-20 bg-gray-900 rounded-lg overflow-hidden">
                                <img 
                                    :src="'https://img.youtube.com/vi/' + (video.youtube_id || 'dQw4w9WgXcQ') + '/mqdefault.jpg'"
                                    :alt="video.title || 'Video ' + (index + 1)"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                    loading="lazy"
                                >
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 group-hover:text-za-green-primary transition-colors line-clamp-2"
                                    :class="currentVideo.youtube_id === video.youtube_id ? 'text-za-green-primary' : ''">
                                    <span x-text="video.title || 'Video Title ' + (index + 1)"></span>
                                </h3>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>

