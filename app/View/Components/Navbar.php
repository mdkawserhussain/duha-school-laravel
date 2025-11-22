<?php

namespace App\View\Components;

use App\Helpers\AnnouncementHelper;
use App\Helpers\SiteSettingsHelper;
use App\Services\NavigationService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Navbar extends Component
{
    public string $primaryColor;
    public Collection $announcements;
    public Collection $navigationItems;
    public bool $transparent;

    /**
     * Create a new component instance.
     */
    public function __construct(bool $transparent = false)
    {
        $this->transparent = $transparent;
        $this->primaryColor = $this->getPrimaryColor();
        $this->announcements = $this->getAnnouncements();
        $this->navigationItems = $this->getNavigationItems();
    }

    protected function getPrimaryColor(): string
    {
        $color = SiteSettingsHelper::primaryColor();
        if (!str_starts_with($color, '#')) {
            $color = '#' . ltrim($color, '#');
        }
        return $color;
    }

    protected function getAnnouncements(): Collection
    {
        try {
            if (!app()->bound('exception') && 
                !str_contains(request()->path() ?? '', 'errors') &&
                !str_contains(request()->path() ?? '', '_dusk') &&
                !str_contains(request()->path() ?? '', 'telescope')) {
                return AnnouncementHelper::getSafe();
            }
        } catch (\Throwable $e) {
            // Fail silently
        }
        return collect([]);
    }

    protected function getNavigationItems(): Collection
    {
        try {
            if (!app()->bound('exception')) {
                $navigationService = app(NavigationService::class);
                $items = $navigationService->getActiveNavigation('main');
                
                // Pre-calculate active state for all items
                return $items->map(function ($item) {
                    $item->isActive = $this->checkActiveState($item);
                    
                    if (!empty($item->children)) {
                        foreach ($item->children as $child) {
                            $child->isActive = $this->checkActiveState($child);
                        }
                    }
                    
                    return $item;
                });
            }
        } catch (\Throwable $e) {
            // Fail silently
        }
        return collect([]);
    }

    /**
     * Check if a navigation item is active.
     */
    protected function checkActiveState($item): bool
    {
        $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();
        $currentPath = \Illuminate\Support\Facades\Request::path();
        
        // Convert to object if array (for compatibility)
        $itemObj = is_array($item) ? (object) $item : $item;
        
        $route = $itemObj->route_name ?? ($itemObj->route ?? null);
        $url = $itemObj->url ?? null;
        
        // 1. Check if it's a direct route match
        if ($route && $route === $currentRoute) {
            return true;
        }
        
        // 2. Check if it's a path match (for non-named routes)
        if ($url && $url !== '#') {
            $path = ltrim(parse_url($url, PHP_URL_PATH), '/');
            if ($path === $currentPath || str_starts_with($currentPath, $path . '/')) {
                return true;
            }
        }
        
        // 3. Check children for active state (recursive)
        $children = $itemObj->children ?? [];
        if (count($children) > 0) {
            foreach ($children as $child) {
                $childObj = is_array($child) ? (object) $child : $child;
                $childRoute = $childObj->route_name ?? ($childObj->route ?? null);
                
                // Check child route
                if ($childRoute && ($childRoute === $currentRoute || str_starts_with($currentRoute, $childRoute . '.'))) {
                    return true;
                }
                
                // Check child URL
                $childUrl = $childObj->url ?? null;
                if ($childUrl && $childUrl !== '#') {
                    $childPath = ltrim(parse_url($childUrl, PHP_URL_PATH), '/');
                    if ($childPath === $currentPath || str_starts_with($currentPath, $childPath . '/')) {
                        return true;
                    }
                }
            }
        }
        
        return false;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
