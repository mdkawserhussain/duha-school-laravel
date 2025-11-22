<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreHomePageContentRequest;
use App\Http\Requests\Admin\UpdateHomePageContentRequest;
use App\Models\HomePageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomePageContentController extends BaseController
{
    public function index(Request $request)
    {
        $query = HomePageContent::query();

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

        $contents = $query->orderBy('sort_order')->orderBy('section_key')->paginate(15)->withQueryString();

        return view('admin.homepage-contents.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.homepage-contents.create');
    }

    public function store(StoreHomePageContentRequest $request)
    {
        $data = $request->validated();
        
        $content = HomePageContent::create($data);

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $content->addMedia($file->getRealPath())
                    ->toMediaCollection('images');
            }
        }

        // Handle background image
        if ($request->hasFile('background_image')) {
            $content->addMediaFromRequest('background_image')
                ->toMediaCollection('background_image');
        }

        $this->clearHomepageCache();

        return redirect()->route('admin.homepage-contents.index')
            ->with('success', 'Homepage content created successfully.');
    }

    public function show(HomePageContent $homepageContent)
    {
        return view('admin.homepage-contents.show', ['content' => $homepageContent]);
    }

    public function edit(HomePageContent $homepageContent)
    {
        return view('admin.homepage-contents.edit', ['content' => $homepageContent]);
    }

    public function update(UpdateHomePageContentRequest $request, HomePageContent $homepageContent)
    {
        $data = $request->validated();
        
        $homepageContent->update($data);

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $homepageContent->addMedia($file->getRealPath())
                    ->toMediaCollection('images');
            }
        }

        // Handle background image
        if ($request->hasFile('background_image')) {
            $homepageContent->clearMediaCollection('background_image');
            $homepageContent->addMediaFromRequest('background_image')
                ->toMediaCollection('background_image');
        }

        $this->clearHomepageCache();

        return redirect()->route('admin.homepage-contents.index')
            ->with('success', 'Homepage content updated successfully.');
    }

    public function destroy(HomePageContent $homepageContent)
    {
        $homepageContent->delete();

        $this->clearHomepageCache();

        return redirect()->route('admin.homepage-contents.index')
            ->with('success', 'Homepage content deleted successfully.');
    }

    protected function clearHomepageCache(): void
    {
        Cache::forget('homepage_v2_data');
    }
}
