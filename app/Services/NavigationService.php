<?php

namespace App\Services;

use App\Repositories\NavigationRepository;
use App\Models\NavigationItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class NavigationService
{
    protected NavigationRepository $navigationRepository;

    public function __construct(NavigationRepository $navigationRepository)
    {
        $this->navigationRepository = $navigationRepository;
    }

    public function getActiveNavigation(string $section = 'main'): Collection
    {
        $cacheKey = 'navigation_' . $section;
        $cacheTime = 3600; // 1 hour

        return Cache::remember($cacheKey, $cacheTime, function () use ($section) {
            return $this->navigationRepository->getActiveNavigation($section);
        });
    }

    public function getAllNavigationItems(string $section = 'main'): Collection
    {
        $cacheKey = 'navigation_all_' . $section;
        $cacheTime = 3600;

        return Cache::remember($cacheKey, $cacheTime, function () use ($section) {
            return $this->navigationRepository->getAllNavigationItems($section);
        });
    }

    public function getRootItems(string $section = 'main'): Collection
    {
        $cacheKey = 'navigation_root_' . $section;
        $cacheTime = 3600;

        return Cache::remember($cacheKey, $cacheTime, function () use ($section) {
            return $this->navigationRepository->getRootItems($section);
        });
    }

    public function findById(int $id): ?NavigationItem
    {
        return $this->navigationRepository->findById($id);
    }

    public function clearNavigationCache(string $section = null): void
    {
        if ($section) {
            Cache::forget('navigation_' . $section);
            Cache::forget('navigation_all_' . $section);
            Cache::forget('navigation_root_' . $section);
        } else {
            Cache::forget('navigation_main');
            Cache::forget('navigation_all_main');
            Cache::forget('navigation_root_main');
            Cache::forget('navigation_footer');
            Cache::forget('navigation_all_footer');
            Cache::forget('navigation_root_footer');
        }
    }
}
