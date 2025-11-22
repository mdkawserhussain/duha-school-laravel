<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomePageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HeroSliderController extends BaseController
{
    public function index()
    {
        $slides = HomePageSection::where('section_type', 'hero')
            ->orderBy('sort_order')
            ->get()
            ->map(function ($slide) {
                $data = $slide->data ?? [];
                return [
                    'id' => $slide->id,
                    'title' => $slide->title,
                    'subtitle' => $slide->subtitle,
                    'description' => $slide->description,
                    'button_text' => $slide->button_text,
                    'button_link' => $slide->button_link,
                    'badge' => data_get($data, 'badge'),
                    'is_active' => $slide->is_active,
                    'sort_order' => $slide->sort_order,
                    'image_url' => $slide->getFirstMediaUrl('images', 'large') ?: $slide->getFirstMediaUrl('images'),
                    'video_url' => data_get($data, 'video_url'),
                    'video_poster' => $slide->getFirstMediaUrl('video_poster', 'large') ?: $slide->getFirstMediaUrl('video_poster'),
                    'secondary_button_text' => data_get($data, 'secondary_button_text'),
                    'secondary_button_link' => data_get($data, 'secondary_button_link'),
                    'features' => data_get($data, 'features', []),
                    'stats_cards' => data_get($data, 'stats_cards', []),
                    'stats_pills' => data_get($data, 'stats_pills', []),
                ];
            });

        return view('admin.hero-slider.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'url', 'max:255'],
            'badge' => ['nullable', 'string', 'max:100'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'secondary_button_text' => ['nullable', 'string', 'max:100'],
            'secondary_button_link' => ['nullable', 'url', 'max:255'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
            'video_poster' => ['nullable', 'image', 'max:5120'],
            'features' => ['nullable', 'array'],
            'stats_cards' => ['nullable', 'array'],
            'stats_pills' => ['nullable', 'array'],
        ]);

        $slide = new HomePageSection();
        $slide->section_type = 'hero';
        $slide->section_key = 'hero_' . time();
        $slide->sort_order = HomePageSection::where('section_type', 'hero')->max('sort_order') + 1;
        $slide->title = $validated['title'] ?? null;
        $slide->subtitle = $validated['subtitle'] ?? null;
        $slide->description = $validated['description'] ?? null;
        $slide->button_text = $validated['button_text'] ?? null;
        $slide->button_link = $validated['button_link'] ?? null;
        $slide->is_active = $validated['is_active'] ?? true;

        $data = [];
        if (isset($validated['badge'])) $data['badge'] = $validated['badge'];
        if (isset($validated['video_url'])) $data['video_url'] = $validated['video_url'];
        if (isset($validated['secondary_button_text'])) $data['secondary_button_text'] = $validated['secondary_button_text'];
        if (isset($validated['secondary_button_link'])) $data['secondary_button_link'] = $validated['secondary_button_link'];
        if (isset($validated['features'])) $data['features'] = $validated['features'];
        if (isset($validated['stats_cards'])) $data['stats_cards'] = $validated['stats_cards'];
        if (isset($validated['stats_pills'])) $data['stats_pills'] = $validated['stats_pills'];
        $slide->data = $data;

        $slide->save();

        if ($request->hasFile('image')) {
            $slide->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        if ($request->hasFile('video_poster')) {
            $slide->addMediaFromRequest('video_poster')
                ->toMediaCollection('video_poster');
        }

        $this->clearCache();

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'Hero slide created successfully.');
    }

    public function edit(HomePageSection $slide)
    {
        if ($slide->section_type !== 'hero') {
            abort(404);
        }

        $data = $slide->data ?? [];
        $slideData = [
            'id' => $slide->id,
            'title' => $slide->title,
            'subtitle' => $slide->subtitle,
            'description' => $slide->description,
            'button_text' => $slide->button_text,
            'button_link' => $slide->button_link,
            'badge' => data_get($data, 'badge'),
            'is_active' => $slide->is_active,
            'sort_order' => $slide->sort_order,
            'image_url' => $slide->getFirstMediaUrl('images', 'large') ?: $slide->getFirstMediaUrl('images'),
            'video_url' => data_get($data, 'video_url'),
            'video_poster' => $slide->getFirstMediaUrl('video_poster', 'large') ?: $slide->getFirstMediaUrl('video_poster'),
            'secondary_button_text' => data_get($data, 'secondary_button_text'),
            'secondary_button_link' => data_get($data, 'secondary_button_link'),
            'features' => data_get($data, 'features', []),
            'stats_cards' => data_get($data, 'stats_cards', []),
            'stats_pills' => data_get($data, 'stats_pills', []),
        ];

        return view('admin.hero-slider.edit', ['slide' => $slide, 'slideData' => $slideData]);
    }

    public function update(Request $request, HomePageSection $slide)
    {
        if ($slide->section_type !== 'hero') {
            abort(404);
        }

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'url', 'max:255'],
            'badge' => ['nullable', 'string', 'max:100'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'secondary_button_text' => ['nullable', 'string', 'max:100'],
            'secondary_button_link' => ['nullable', 'url', 'max:255'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
            'video_poster' => ['nullable', 'image', 'max:5120'],
            'features' => ['nullable', 'array'],
            'stats_cards' => ['nullable', 'array'],
            'stats_pills' => ['nullable', 'array'],
        ]);

        $slide->title = $validated['title'] ?? null;
        $slide->subtitle = $validated['subtitle'] ?? null;
        $slide->description = $validated['description'] ?? null;
        $slide->button_text = $validated['button_text'] ?? null;
        $slide->button_link = $validated['button_link'] ?? null;
        $slide->is_active = $validated['is_active'] ?? true;

        $data = $slide->data ?? [];
        if (isset($validated['badge'])) $data['badge'] = $validated['badge'];
        if (isset($validated['video_url'])) $data['video_url'] = $validated['video_url'];
        if (isset($validated['secondary_button_text'])) $data['secondary_button_text'] = $validated['secondary_button_text'];
        if (isset($validated['secondary_button_link'])) $data['secondary_button_link'] = $validated['secondary_button_link'];
        if (isset($validated['features'])) $data['features'] = $validated['features'];
        if (isset($validated['stats_cards'])) $data['stats_cards'] = $validated['stats_cards'];
        if (isset($validated['stats_pills'])) $data['stats_pills'] = $validated['stats_pills'];
        $slide->data = $data;

        $slide->save();

        if ($request->hasFile('image')) {
            $slide->clearMediaCollection('images');
            $slide->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        if ($request->hasFile('video_poster')) {
            $slide->clearMediaCollection('video_poster');
            $slide->addMediaFromRequest('video_poster')
                ->toMediaCollection('video_poster');
        }

        $this->clearCache();

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(HomePageSection $slide)
    {
        if ($slide->section_type !== 'hero') {
            abort(404);
        }

        $slide->delete();
        $this->clearCache();

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'Hero slide deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:home_page_sections,id'],
        ]);

        foreach ($request->order as $index => $id) {
            HomePageSection::where('id', $id)
                ->where('section_type', 'hero')
                ->update(['sort_order' => $index + 1]);
        }

        $this->clearCache();

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'Slide order updated successfully.');
    }

    public function toggleActive(HomePageSection $slide)
    {
        if ($slide->section_type !== 'hero') {
            abort(404);
        }

        $slide->is_active = !$slide->is_active;
        $slide->save();
        $this->clearCache();

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'Slide status updated successfully.');
    }

    public function duplicate(HomePageSection $slide)
    {
        if ($slide->section_type !== 'hero') {
            abort(404);
        }

        $newSlide = $slide->replicate();
        $newSlide->section_key = 'hero_' . time();
        $newSlide->sort_order = HomePageSection::where('section_type', 'hero')->max('sort_order') + 1;
        $newSlide->save();

        // Copy media
        if ($slide->hasMedia('images')) {
            foreach ($slide->getMedia('images') as $media) {
                $newSlide->addMedia($media->getPath())
                    ->toMediaCollection('images');
            }
        }

        if ($slide->hasMedia('video_poster')) {
            foreach ($slide->getMedia('video_poster') as $media) {
                $newSlide->addMedia($media->getPath())
                    ->toMediaCollection('video_poster');
            }
        }

        $this->clearCache();

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'Slide duplicated successfully.');
    }

    protected function clearCache(): void
    {
        Cache::forget('homepage_v2_data');
    }
}
