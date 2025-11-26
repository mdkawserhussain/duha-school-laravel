<?php

namespace App\Services;

use App\Repositories\PageRepository;
use App\Models\Page;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PageService
{
    protected PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function findPublishedPageBySlug(string $slug): ?Page
    {
        $cacheKey = 'page_' . md5($slug);
        $cacheTime = 3600; // 1 hour

        return Cache::remember($cacheKey, $cacheTime, function () use ($slug) {
            return $this->pageRepository->findPublishedPageBySlug($slug);
        });
    }

    public function findCategoryPage(string $category, string $pageSlug = null): ?Page
    {
        $cacheKey = 'category_page_' . md5($category . '_' . ($pageSlug ?? 'landing'));
        $cacheTime = 3600;

        return Cache::remember($cacheKey, $cacheTime, function () use ($category, $pageSlug) {
            return $this->pageRepository->findCategoryPage($category, $pageSlug);
        });
    }

    public function findCategoryChildPage(string $category, string $pageSlug): ?Page
    {
        $cacheKey = 'category_child_page_' . md5($category . '_' . $pageSlug);
        $cacheTime = 3600;

        return Cache::remember($cacheKey, $cacheTime, function () use ($category, $pageSlug) {
            return $this->pageRepository->findCategoryChildPage($category, $pageSlug);
        });
    }
    /**
     * Find a page by slug regardless of publication status.
     */
    public function findBySlug(string $slug): ?Page
    {
        $cacheKey = 'page_all_' . md5($slug);
        $cacheTime = 3600;

        return Cache::remember($cacheKey, $cacheTime, function () use ($slug) {
            return $this->pageRepository->findBySlug($slug);
        });
    }

    /**
     * Get a published page by slug (wrapper for findPublishedPageBySlug).
     */
    public function getPublishedPage(string $slug): ?Page
    {
        return $this->findPublishedPageBySlug($slug);
    }

    public function getPublishedPages(): Collection
    {
        $cacheKey = 'pages_published_all';
        $cacheTime = 3600;

        return Cache::remember($cacheKey, $cacheTime, function () {
            return $this->pageRepository->getPublishedPages();
        });
    }

    public function getMenuPages(string $section = 'main'): Collection
    {
        $cacheKey = 'menu_pages_' . $section;
        $cacheTime = 3600;

        return Cache::remember($cacheKey, $cacheTime, function () use ($section) {
            return $this->pageRepository->getMenuPages($section);
        });
    }

    public function getRootMenuPages(string $section = 'main'): Collection
    {
        $cacheKey = 'root_menu_pages_' . $section;
        $cacheTime = 3600;

        return Cache::remember($cacheKey, $cacheTime, function () use ($section) {
            return $this->pageRepository->getRootMenuPages($section);
        });
    }

    public function getCategoryPages(string $category): Collection
    {
        $cacheKey = 'category_pages_' . md5($category);
        $cacheTime = 3600;

        return Cache::remember($cacheKey, $cacheTime, function () use ($category) {
            return $this->pageRepository->getCategoryPages($category);
        });
    }

    public function getFeaturedPages(int $limit = 5): Collection
    {
        $cacheKey = 'featured_pages_' . $limit;
        $cacheTime = 3600;

        return Cache::remember($cacheKey, $cacheTime, function () use ($limit) {
            return $this->pageRepository->getFeaturedPages($limit);
        });
    }
}