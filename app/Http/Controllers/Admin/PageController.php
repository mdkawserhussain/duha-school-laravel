<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends BaseController
{
    public function index(Request $request)
    {
        $query = Page::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('page_category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('page_category')) {
            $query->where('page_category', $request->page_category);
        }

        if ($request->filled('is_published')) {
            $query->where('is_published', $request->is_published === '1');
        }

        $pages = $query->orderBy('menu_order')->orderBy('title')->paginate(15)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $data = $request->validated();
        
        // Handle SEO keywords array
        if (isset($data['seo_keywords']) && is_string($data['seo_keywords'])) {
            $data['seo_keywords'] = array_filter(array_map('trim', explode(',', $data['seo_keywords'])));
        }

        $page = Page::create($data);

        if ($request->hasFile('featured_image')) {
            $page->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.show', compact('page'));
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, $id)
    {
        $page = Page::findOrFail($id);
        $data = $request->validated();
        
        // Handle SEO keywords array
        if (isset($data['seo_keywords']) && is_string($data['seo_keywords'])) {
            $data['seo_keywords'] = array_filter(array_map('trim', explode(',', $data['seo_keywords'])));
        }

        $page->update($data);

        if ($request->hasFile('featured_image')) {
            $page->clearMediaCollection('featured_image');
            $page->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
