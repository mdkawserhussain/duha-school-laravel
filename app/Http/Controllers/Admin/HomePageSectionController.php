<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreHomePageSectionRequest;
use App\Http\Requests\Admin\UpdateHomePageSectionRequest;
use App\Models\HomePageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomePageSectionController extends BaseController
{
    public function index(Request $request)
    {
        $query = HomePageSection::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('section_key', 'like', "%{$search}%")
                  ->orWhere('section_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('section_type')) {
            $query->where('section_type', $request->section_type);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        $sections = $query->orderBy('sort_order')->orderBy('section_key')->paginate(15)->withQueryString();

        return view('admin.homepage-sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.homepage-sections.create');
    }

    public function store(StoreHomePageSectionRequest $request)
    {
        $data = $request->validated();
        
        $section = HomePageSection::create($data);

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $section->addMedia($file->getRealPath())
                    ->toMediaCollection('images');
            }
        }

        // Handle background image
        if ($request->hasFile('background_image')) {
            $section->addMediaFromRequest('background_image')
                ->toMediaCollection('background_image');
        }

        // Handle video poster
        if ($request->hasFile('video_poster')) {
            $section->addMediaFromRequest('video_poster')
                ->toMediaCollection('video_poster');
        }

        $this->clearHomepageCache();

        return redirect()->route('admin.homepage-sections.index')
            ->with('success', 'Homepage section created successfully.');
    }

    public function show(HomePageSection $homepageSection)
    {
        return view('admin.homepage-sections.show', ['section' => $homepageSection]);
    }

    public function edit(HomePageSection $homepageSection)
    {
        return view('admin.homepage-sections.edit', ['section' => $homepageSection]);
    }

    public function update(UpdateHomePageSectionRequest $request, HomePageSection $homepageSection)
    {
        $data = $request->validated();
        
        $homepageSection->update($data);

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $homepageSection->addMedia($file->getRealPath())
                    ->toMediaCollection('images');
            }
        }

        // Handle background image
        if ($request->hasFile('background_image')) {
            $homepageSection->clearMediaCollection('background_image');
            $homepageSection->addMediaFromRequest('background_image')
                ->toMediaCollection('background_image');
        }

        // Handle video poster
        if ($request->hasFile('video_poster')) {
            $homepageSection->clearMediaCollection('video_poster');
            $homepageSection->addMediaFromRequest('video_poster')
                ->toMediaCollection('video_poster');
        }

        $this->clearHomepageCache();

        return redirect()->route('admin.homepage-sections.index')
            ->with('success', 'Homepage section updated successfully.');
    }

    public function destroy(HomePageSection $homepageSection)
    {
        $homepageSection->delete();

        $this->clearHomepageCache();

        return redirect()->route('admin.homepage-sections.index')
            ->with('success', 'Homepage section deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:home_page_sections,id'],
        ]);

        foreach ($request->order as $index => $id) {
            HomePageSection::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        $this->clearHomepageCache();

        return redirect()->route('admin.homepage-sections.index')
            ->with('success', 'Section order updated successfully.');
    }

    protected function clearHomepageCache(): void
    {
        Cache::forget('homepage_v2_data');
    }
}
