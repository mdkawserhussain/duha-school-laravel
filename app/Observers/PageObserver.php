<?php

namespace App\Observers;

use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PageObserver
{
    /**
     * Handle the Page "creating" event.
     */
    public function creating(Page $page): void
    {
        // Slug generation is handled in the model's boot method
        // This observer ensures slug is normalized
        if (!empty($page->slug)) {
            $page->slug = Str::slug(trim($page->slug));
        }
    }

    /**
     * Handle the Page "updated" event.
     */
    public function updated(Page $page): void
    {
        $this->clearPageCaches($page);
    }

    /**
     * Handle the Page "saved" event.
     */
    public function saved(Page $page): void
    {
        $this->clearPageCaches($page);
    }

    /**
     * Handle the Page "deleted" event.
     */
    public function deleted(Page $page): void
    {
        $this->clearPageCaches($page);
    }

    /**
     * Handle the Page "restored" event.
     */
    public function restored(Page $page): void
    {
        $this->clearPageCaches($page);
    }

    /**
     * Handle the Page "force deleted" event.
     */
    public function forceDeleted(Page $page): void
    {
        $this->clearPageCaches($page);
    }

    /**
     * Clear page-related caches.
     */
    protected function clearPageCaches(Page $page): void
    {
        try {
            // Clear homepage cache (pages may be featured)
            Cache::forget('homepage_v2_data');

            // Clear page-specific caches
            if ($page->slug) {
                Cache::forget('page_' . md5($page->slug));
            }

            // Clear category caches
            if ($page->page_category) {
                Cache::forget('category_pages_' . md5($page->page_category));
                Cache::forget('category_page_' . md5($page->page_category . '_landing'));
                if ($page->parent_id) {
                    $parent = Page::find($page->parent_id);
                    if ($parent && $parent->slug) {
                        Cache::forget('category_child_page_' . md5($page->page_category . '_' . $page->slug));
                    }
                }
            }

            // Clear menu caches
            Cache::forget('menu_pages_main');
            Cache::forget('menu_pages_footer');
            Cache::forget('root_menu_pages_main');
            Cache::forget('root_menu_pages_footer');

            // Clear all pages cache
            Cache::forget('pages_published_all');
            Cache::forget('featured_pages_5');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error clearing page caches', [
                'error' => $e->getMessage(),
                'page_id' => $page->id ?? null,
            ]);
        }
    }
}