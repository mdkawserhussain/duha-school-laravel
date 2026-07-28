<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Admin\BaseController;
use App\Models\HomePageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VideosController extends BaseController
{
    public function index()
    {
        $section = HomePageSection::where(function($query) {
            $query->where('section_key', 'videos')
                  ->orWhere('section_key', 'recent_videos');
        })
        ->where('section_type', 'videos')
        ->first();

        // Create default section if it doesn't exist
        if (!$section) {
            $section = HomePageSection::create([
                'section_key' => 'videos',
                'section_type' => 'videos',
                'title' => 'Recent Videos',
                'description' => 'Watch our latest videos showcasing student achievements and activities',
                'data' => [
                    'main_video' => [
                        'title' => '',
                        'youtube_id' => '',
                        'thumbnail' => null,
                    ],
                    'recent_videos' => [],
                ],
                'sort_order' => 16,
                'is_active' => true,
            ]);
        }

        $data = $section->data ?? [];
        $mainVideo = data_get($data, 'main_video', ['title' => '', 'youtube_id' => '', 'thumbnail' => null]);
        $recentVideos = data_get($data, 'recent_videos', []);

        return view('admin.homepage.videos.index', [
            'section' => $section,
            'mainVideo' => $mainVideo,
            'recentVideos' => $recentVideos,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'main_video_title' => ['required', 'string', 'max:255'],
            'main_video_youtube_id' => ['required', 'string', 'max:50'],
            'main_video_thumbnail' => ['nullable', 'image', 'max:5120'],
            'recent_videos' => ['required', 'array'],
            'recent_videos.*.title' => ['required', 'string', 'max:255'],
            'recent_videos.*.youtube_id' => ['required', 'string', 'max:50'],
            'recent_videos.*.thumbnail' => ['nullable', 'image', 'max:5120'],
        ]);

        $section = HomePageSection::where(function($query) {
            $query->where('section_key', 'videos')
                  ->orWhere('section_key', 'recent_videos');
        })
        ->where('section_type', 'videos')
        ->firstOrFail();

        $section->title = $validated['title'] ?? null;
        $section->description = $validated['description'] ?? null;
        $section->is_active = $validated['is_active'] ?? true;

        $data = $section->data ?? [];
        
        // Update main video
        $data['main_video'] = [
            'title' => $validated['main_video_title'],
            'youtube_id' => $validated['main_video_youtube_id'],
            'thumbnail' => data_get($data, 'main_video.thumbnail'), // Keep existing thumbnail if not updated
        ];

        // Handle main video thumbnail upload
        if ($request->hasFile('main_video_thumbnail')) {
            $section->clearMediaCollection('main_video_thumbnail');
            $section->addMedia($request->file('main_video_thumbnail'))
                ->usingName('Main Video Thumbnail')
                ->toMediaCollection('main_video_thumbnail');
            $data['main_video']['thumbnail'] = $section->getFirstMediaUrl('main_video_thumbnail');
        }

        // Update recent videos
        $recentVideosData = [];
        foreach ($validated['recent_videos'] as $index => $video) {
            $recentVideosData[] = [
                'title' => $video['title'],
                'youtube_id' => $video['youtube_id'],
                'thumbnail' => data_get($data, "recent_videos.{$index}.thumbnail"), // Keep existing thumbnail
            ];
        }
        $data['recent_videos'] = $recentVideosData;

        // Handle recent video thumbnails
        if ($request->hasFile('recent_videos')) {
            foreach ($request->file('recent_videos') as $index => $thumbnail) {
                if ($thumbnail && isset($recentVideosData[$index])) {
                    $media = $section->getMedia('recent_video_thumbnails')->get($index);
                    if ($media) {
                        $media->delete();
                    }
                    $section->addMedia($thumbnail)
                        ->usingName("Recent Video Thumbnail {$index}")
                        ->toMediaCollection('recent_video_thumbnails');
                    $data['recent_videos'][$index]['thumbnail'] = $section->getMedia('recent_video_thumbnails')->get($index)?->getUrl();
                }
            }
        }

        $section->data = $data;
        $section->save();
        
        // Refresh the model to ensure data is up to date
        $section->refresh();

        $this->clearCache();

        return redirect()->route('admin.homepage.videos.index')
            ->with('success', 'Videos section updated successfully.');
    }

    protected function clearCache(): void
    {
        // Clear homepage cache
        Cache::forget('homepage_v2_data');
        
        // Clear tagged cache if supported
        try {
            Cache::tags(['homepage', 'homepage_sections'])->flush();
        } catch (\Exception $e) {
            // Tags not supported by cache driver, that's okay
        }
        
        // Clear view cache
        \Artisan::call('view:clear');
    }
}
