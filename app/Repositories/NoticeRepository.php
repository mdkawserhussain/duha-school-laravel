<?php

namespace App\Repositories;

use App\Models\Notice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class NoticeRepository
{
    /**
     * Get published notices with pagination and eager loading.
     */
    public function getPublishedNotices(int $perPage = 12): LengthAwarePaginator
    {
        return Notice::published()
            ->with('media') // Eager load media relationships
            ->orderBy('published_at', 'desc')
            ->orderBy('is_important', 'desc') // Important notices first
            ->paginate($perPage);
    }

    /**
     * Get important notices with eager loading.
     */
    public function getImportantNotices(int $limit = 5): Collection
    {
        return Notice::published()
            ->important()
            ->with('media') // Eager load media relationships
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get notices by category with pagination and eager loading.
     */
    public function getNoticesByCategory(string $category, int $perPage = 12): LengthAwarePaginator
    {
        return Notice::published()
            ->byCategory($category)
            ->with('media') // Eager load media relationships
            ->orderBy('published_at', 'desc')
            ->orderBy('is_important', 'desc') // Important notices first
            ->paginate($perPage);
    }

    /**
     * Find published notice by ID.
     */
    public function findPublishedNoticeById(int $id): ?Notice
    {
        return Notice::published()
            ->with('media') // Eager load media relationships
            ->find($id);
    }

    /**
     * Find published notice by slug.
     */
    public function findPublishedNoticeBySlug(string $slug): ?Notice
    {
        return Notice::published()
            ->with('media') // Eager load media relationships
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Get recent notices with eager loading.
     */
    public function getRecentNotices(int $limit = 5): Collection
    {
        return Notice::published()
            ->with('media') // Eager load media relationships
            ->orderBy('published_at', 'desc')
            ->orderBy('is_important', 'desc') // Important notices first
            ->limit($limit)
            ->get();
    }
}