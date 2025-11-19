<?php

namespace App\Repositories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Collection;

class PageRepository
{
    public function findPublishedPageBySlug(string $slug): ?Page
    {
        return Page::published()
            ->where('slug', $slug)
            ->with(['parent', 'children', 'media'])
            ->first();
    }

    public function findCategoryPage(string $category, string $pageSlug = null): ?Page
    {
        $query = Page::published()
            ->byCategory($category)
            ->with(['children', 'media']);

        if ($pageSlug) {
            $query->where('slug', $pageSlug);
        } else {
            // Return category landing page (parent page with no parent)
            $query->whereNull('parent_id');
        }

        return $query->first();
    }

    public function findCategoryChildPage(string $category, string $pageSlug): ?Page
    {
        $categoryPage = Page::published()
            ->byCategory($category)
            ->whereNull('parent_id')
            ->first();

        if (!$categoryPage) {
            return null;
        }

        return Page::published()
            ->where('parent_id', $categoryPage->id)
            ->where('slug', $pageSlug)
            ->with(['parent', 'children', 'media'])
            ->first();
    }

    public function getPublishedPages(): Collection
    {
        return Page::published()
            ->with('media')
            ->ordered()
            ->get();
    }

    public function getMenuPages(string $section = 'main'): Collection
    {
        return Page::published()
            ->inMenu($section)
            ->ordered()
            ->with(['children' => function ($query) use ($section) {
                $query->published()->inMenu($section)->ordered();
            }, 'media'])
            ->get();
    }

    public function getRootMenuPages(string $section = 'main'): Collection
    {
        return Page::published()
            ->inMenu($section)
            ->whereNull('parent_id')
            ->where('menu_order', '>', 0) // Only include pages with proper menu_order
            ->where(function ($query) {
                // Include pages with category OR standalone pages (Gallery, Blog/News)
                $query->whereNotNull('page_category')
                      ->orWhere(function ($q) {
                          // Standalone pages without category but explicitly in menu
                          $q->whereNull('page_category')
                            ->where('show_in_menu', true)
                            ->where('menu_order', '>', 0);
                      });
            })
            ->ordered()
            ->with(['publishedChildren' => function ($query) use ($section) {
                $query->inMenu($section);
            }, 'media'])
            ->get();
    }

    public function getCategoryPages(string $category): Collection
    {
        return Page::published()
            ->byCategory($category)
            ->ordered()
            ->with(['children', 'media'])
            ->get();
    }

    public function getFeaturedPages(int $limit = 5): Collection
    {
        return Page::published()
            ->featured()
            ->with('media')
            ->limit($limit)
            ->get();
    }
}