<?php

namespace App\Helpers;

class PageHelper
{
    /**
     * Map page_category to route name prefix
     */
    public static function categoryToRouteName(string $pageCategory): ?string
    {
        $categoryMap = [
            'about-us' => 'about',
            'academics' => 'academics',
            'facilities' => 'facilities',
            'activities-programs' => 'activities',
            'admissions' => 'admissions',
            'parent-engagement' => 'parent-engagement',
            'faculty' => 'faculty',
        ];

        return $categoryMap[$pageCategory] ?? null;
    }

    /**
     * Get route name for category index
     */
    public static function getCategoryIndexRoute(string $pageCategory): ?string
    {
        $routeName = self::categoryToRouteName($pageCategory);
        return $routeName ? $routeName . '.index' : null;
    }

    /**
     * Get route name for category show
     */
    public static function getCategoryShowRoute(string $pageCategory): ?string
    {
        $routeName = self::categoryToRouteName($pageCategory);
        return $routeName ? $routeName . '.show' : null;
    }
}

