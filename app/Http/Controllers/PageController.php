<?php

namespace App\Http\Controllers;

use App\Services\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function show($slug = null)
    {
        // Handle routes without parameters by using the route name
        if ($slug === null) {
            $routeName = request()->route()->getName();
            $slugMap = [
                'campus.show' => 'campus',
                'privacy.show' => 'privacy-policy',
                'terms.show' => 'terms-of-service',
            ];
            $slug = $slugMap[$routeName] ?? null;
        }

        if (!$slug) {
            abort(404);
        }

        $page = $this->pageService->findPublishedPageBySlug($slug);

        if (!$page) {
            abort(404);
        }

        // If page has children, show category landing page
        if ($page->children()->count() > 0) {
            $children = $page->publishedChildren;
            return view('pages.category', compact('page', 'children'));
        }

        return view('pages.page', compact('page'));
    }

    public function category(string $pageSlug = null)
    {
        // Extract category from route URI or route name
        $routeName = request()->route()->getName();
        $routePath = request()->path();
        
        // Map route names to page categories
        $routeToCategoryMap = [
            'about.index' => 'about-us',
            'about.show' => 'about-us',
            'academics.index' => 'academics',
            'academics.show' => 'academics',
            'facilities.index' => 'facilities',
            'facilities.show' => 'facilities',
            'activities.index' => 'activities-programs',
            'activities.show' => 'activities-programs',
            'admissions.index' => 'admissions',
            'admissions.show' => 'admissions',
            'parent-engagement.index' => 'parent-engagement',
            'parent-engagement.show' => 'parent-engagement',
        ];
        
        // Try to get category from route name first
        $pageCategory = $routeToCategoryMap[$routeName] ?? null;
        
        // If not found, extract from route path (e.g., /about-us -> about-us)
        if (!$pageCategory) {
            $pathSegments = explode('/', trim($routePath, '/'));
            $firstSegment = $pathSegments[0] ?? null;
            
            // Map route path segments to page categories
            $pathToCategoryMap = [
                'about-us' => 'about-us',
                'academics' => 'academics',
                'facilities' => 'facilities',
                'activities-programs' => 'activities-programs',
                'admissions' => 'admissions',
                'parent-engagement' => 'parent-engagement',
            ];
            
            $pageCategory = $pathToCategoryMap[$firstSegment] ?? $firstSegment;
        }

        if (!$pageCategory) {
            abort(404);
        }

        if ($pageSlug) {
            // Show specific child page
            $page = $this->pageService->findCategoryChildPage($pageCategory, $pageSlug);
            if (!$page) {
                abort(404);
            }
            return view('pages.page', compact('page'));
        }

        // Show category landing page
        $page = $this->pageService->findCategoryPage($pageCategory);
        if (!$page) {
            // If no category landing page exists, try to get first child page as landing
            $children = $this->pageService->getCategoryPages($pageCategory);
            if ($children && $children->count() > 0) {
                $firstChild = $children->first();
                $page = $firstChild;
                return view('pages.page', compact('page'));
            }
            abort(404);
        }

        $children = $this->pageService->getCategoryPages($pageCategory);
        return view('pages.category', compact('page', 'children'));
    }

    public function gallery()
    {
        // For media gallery - could be expanded later
        return view('pages.gallery');
    }
}
