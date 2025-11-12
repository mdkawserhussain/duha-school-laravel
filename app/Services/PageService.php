<?php

namespace App\Services;

use App\Repositories\PageRepository;
use App\Models\Page;

class PageService
{
    protected PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function findPublishedPageBySlug(string $slug): ?Page
    {
        return $this->pageRepository->findPublishedPageBySlug($slug);
    }

    public function getPublishedPages(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->pageRepository->getPublishedPages();
    }
}