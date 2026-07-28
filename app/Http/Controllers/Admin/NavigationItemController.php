<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreNavigationItemRequest;
use App\Http\Requests\Admin\UpdateNavigationItemRequest;
use App\Models\NavigationItem;
use App\Services\NavigationService;
use Illuminate\Http\Request;

class NavigationItemController extends BaseController
{
    protected NavigationService $navigationService;

    public function __construct(NavigationService $navigationService)
    {
        $this->navigationService = $navigationService;
    }

    public function index(Request $request)
    {
        $query = NavigationItem::with('parent')->withCount('children');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        $items = $query->orderBy('sort_order')->orderBy('title')->paginate(15)->withQueryString();

        return view('admin.navigation-items.index', compact('items'));
    }

    public function create()
    {
        $parents = NavigationItem::whereNull('parent_id')->orderBy('title')->get();
        return view('admin.navigation-items.create', compact('parents'));
    }

    public function store(StoreNavigationItemRequest $request)
    {
        $navigationItem = NavigationItem::create($request->validated());

        // Refresh the model to ensure data is up to date
        $navigationItem->refresh();

        // Explicitly clear navigation cache (observer should also handle this, but this ensures it)
        $this->navigationService->clearNavigationCache($navigationItem->section ?? null);

        return redirect()->route('admin.navigation-items.index')
            ->with('success', 'Navigation item created successfully.');
    }

    public function show(NavigationItem $navigationItem)
    {
        $navigationItem->load('parent', 'children');
        return view('admin.navigation-items.show', ['item' => $navigationItem]);
    }

    public function edit(NavigationItem $navigationItem)
    {
        $parents = NavigationItem::whereNull('parent_id')
            ->where('id', '!=', $navigationItem->id)
            ->orderBy('title')
            ->get();
        return view('admin.navigation-items.edit', ['item' => $navigationItem, 'parents' => $parents]);
    }

    public function update(UpdateNavigationItemRequest $request, NavigationItem $navigationItem)
    {
        // Store old section before update to clear its cache
        $oldSection = $navigationItem->section;
        
        $navigationItem->update($request->validated());

        // Refresh the model to ensure data is up to date
        $navigationItem->refresh();

        // Clear cache for both old and new sections (in case section changed)
        $this->navigationService->clearNavigationCache($oldSection);
        if ($navigationItem->section !== $oldSection) {
            $this->navigationService->clearNavigationCache($navigationItem->section);
        }

        return redirect()->route('admin.navigation-items.index')
            ->with('success', 'Navigation item updated successfully.');
    }

    public function destroy(NavigationItem $navigationItem)
    {
        // Store section before deletion to clear its cache
        $section = $navigationItem->section;
        
        $navigationItem->delete();

        // Explicitly clear navigation cache (observer should also handle this, but this ensures it)
        $this->navigationService->clearNavigationCache($section ?? null);

        return redirect()->route('admin.navigation-items.index')
            ->with('success', 'Navigation item deleted successfully.');
    }
}
