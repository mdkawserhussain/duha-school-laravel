<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Admin\BaseController;
use App\Models\HomePageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class IntroductionController extends BaseController
{
    public function index()
    {
        $this->authorizeRole(['admin', 'editor']);

        $section = HomePageSection::firstOrCreate(
            ['section_key' => 'introduction'],
            [
                'section_type' => 'content',
                'title' => 'To create a group of specialized Islamic scholars.',
                'description' => 'Duha International School was established with the vision of providing quality Islamic and modern education. Our curriculum combines traditional Islamic teachings with contemporary academic excellence.',
                'content' => '<p>Duha International School was conceived with a clear vision: to create a group of specialized Islamic scholars who are well-versed in both traditional Islamic knowledge and modern academic disciplines. Our founders recognized the need for an educational institution that bridges the gap between Islamic scholarship and contemporary learning.</p><p>The school commenced its operations with a commitment to excellence in both Islamic and modern education. We believe that true education must encompass both spiritual and intellectual development, preparing students to excel in this world while maintaining strong connections to their faith and values.</p>',
                'button_text' => 'Read More',
                'button_link' => '/about-us',
                'data' => [],
                'sort_order' => 10,
                'is_active' => true,
            ]
        );

        return view('admin.homepage.introduction.index', [
            'section' => $section,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorizeRole(['admin', 'editor']);

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
        ]);

        $section = HomePageSection::where('section_key', 'introduction')->firstOrFail();

        $section->title = $validated['title'] ?? null;
        $section->subtitle = $validated['subtitle'] ?? null;
        $section->description = $validated['description'] ?? null;
        $section->content = $validated['content'] ?? null;
        $section->button_text = $validated['button_text'] ?? null;
        $section->button_link = $validated['button_link'] ?? null;
        $section->is_active = $request->has('is_active') ? (bool) $request->input('is_active') : false;
        $section->save();

        // Handle image uploads
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            if (is_array($files)) {
                foreach ($files as $image) {
                    if ($image && $image->isValid()) {
                        try {
                            $section->addMedia($image)
                                ->usingName('Introduction Image')
                                ->usingFileName($image->getClientOriginalName())
                                ->toMediaCollection('images');
                        } catch (\Exception $e) {
                            \Log::error('Failed to upload image: ' . $e->getMessage());
                            return redirect()->route('admin.homepage.introduction.index')
                                ->with('error', 'Failed to upload one or more images: ' . $e->getMessage());
                        }
                    }
                }
            }
        }
        
        // Refresh the model to ensure data is up to date
        $section->refresh();

        $this->clearCache();

        return redirect()->route('admin.homepage.introduction.index')
            ->with('success', 'Introduction section updated successfully.');
    }

    public function deleteImage(Request $request, $imageId)
    {
        $this->authorizeRole(['admin', 'editor']);

        $section = HomePageSection::where('section_key', 'introduction')->firstOrFail();

        // Find media by ID and verify it belongs to this section and collection
        $media = Media::where('id', $imageId)
            ->where('model_type', HomePageSection::class)
            ->where('model_id', $section->id)
            ->where('collection_name', 'images')
            ->first();

        if (!$media) {
            return redirect()->route('admin.homepage.introduction.index')
                ->with('error', 'Image not found.');
        }

        $media->delete();
        $this->clearCache();

        return redirect()->route('admin.homepage.introduction.index')
            ->with('success', 'Image deleted successfully.');
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
