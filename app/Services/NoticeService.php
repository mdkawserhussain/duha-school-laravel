<?php

namespace App\Services;

use App\Repositories\NoticeRepository;
use App\Models\Notice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class NoticeService
{
    protected NoticeRepository $noticeRepository;

    public function __construct(NoticeRepository $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
    }

    public function getPublishedNotices(int $perPage = 12): LengthAwarePaginator
    {
        return $this->noticeRepository->getPublishedNotices($perPage);
    }

    public function getImportantNotices(int $limit = 5): Collection
    {
        return $this->noticeRepository->getImportantNotices($limit);
    }

    public function getNoticesByCategory(string $category, int $perPage = 12): LengthAwarePaginator
    {
        return $this->noticeRepository->getNoticesByCategory($category, $perPage);
    }

    public function findPublishedNotice(int $id): ?Notice
    {
        return $this->noticeRepository->findPublishedNoticeById($id);
    }

    public function findPublishedNoticeBySlug(string $slug): ?Notice
    {
        return $this->noticeRepository->findPublishedNoticeBySlug($slug);
    }

    public function getRecentNotices(int $limit = 5): Collection
    {
        return $this->noticeRepository->getRecentNotices($limit);
    }
}