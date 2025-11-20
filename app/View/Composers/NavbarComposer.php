<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

class NavbarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('isActive', function ($item) {
            $currentRoute = Route::currentRouteName();
            $currentPath = Request::path();
            
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
            
            // 3. Check active patterns (wildcards)
            // Assuming active_patterns is not on the model, but if it were:
            // if (isset($itemObj->active_patterns) ...
            
            // 4. Check children for active state (recursive)
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
        });
    }
}
