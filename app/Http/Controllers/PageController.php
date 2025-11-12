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

        return view('pages.page', compact('page'));
    }

    public function gallery()
    {
        // For media gallery - could be expanded later
        return view('pages.gallery');
    }
}
