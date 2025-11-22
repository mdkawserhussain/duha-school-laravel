<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreNavigationItemRequest;
use App\Http\Requests\Admin\UpdateNavigationItemRequest;
use App\Models\NavigationItem;
use Illuminate\Http\Request;

class NavigationItemController extends BaseController
{
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
        NavigationItem::create($request->validated());

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
        $navigationItem->update($request->validated());

        return redirect()->route('admin.navigation-items.index')
            ->with('success', 'Navigation item updated successfully.');
    }

    public function destroy(NavigationItem $navigationItem)
    {
        $navigationItem->delete();

        return redirect()->route('admin.navigation-items.index')
            ->with('success', 'Navigation item deleted successfully.');
    }
}
