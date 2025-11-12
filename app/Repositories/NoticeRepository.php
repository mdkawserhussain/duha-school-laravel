<?php

namespace App\Repositories;

use App\Models\Notice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class NoticeRepository
{
    public function getPublishedNotices(int $perPage = 12): LengthAwarePaginator
    {
        return Notice::published()
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    public function getImportantNotices(int $limit = 5): Collection
    {
        return Notice::published()
            ->important()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getNoticesByCategory(string $category, int $perPage = 12): LengthAwarePaginator
    {
        return Notice::published()
            ->byCategory($category)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    public function findPublishedNoticeById(int $id): ?Notice
    {
        return Notice::published()->find($id);
    }

    public function findPublishedNoticeBySlug(string $slug): ?Notice
    {
        return Notice::published()->where('slug', $slug)->first();
    }

    public function getRecentNotices(int $limit = 5): Collection
    {
        return Notice::published()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }
}