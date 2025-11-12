<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository
{
    public function findPublishedPageBySlug(string $slug): ?Page
    {
        return Page::published()->where('slug', $slug)->first();
    }

    public function getPublishedPages(): \Illuminate\Database\Eloquent\Collection
    {
        return Page::published()->orderBy('title')->get();
    }
}