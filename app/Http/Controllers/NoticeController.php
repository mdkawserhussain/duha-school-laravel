<?php

namespace App\Http\Controllers;

use App\Services\NoticeService;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    protected NoticeService $noticeService;

    public function __construct(NoticeService $noticeService)
    {
        $this->noticeService = $noticeService;
    }

    public function index(Request $request)
    {
        try {
            $category = $request->get('category');
            
            // Service handles caching internally
            $notices = $category 
                ? $this->noticeService->getNoticesByCategory($category)
                : $this->noticeService->getPublishedNotices();

            $data = [
                'notices' => $notices,
                'category' => $category,
            ];

            return response()
                ->view('pages.notices.index', $data)
                ->header('Cache-Control', 'public, max-age=1800');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error displaying notices index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return view with empty notices on error
            return view('pages.notices.index', [
                'notices' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12),
                'category' => null,
            ]);
        }
    }

    public function show(\App\Models\Notice $notice)
    {
        try {
            // Ensure notice is published
            if (!$notice->is_published || ($notice->published_at && $notice->published_at->isFuture())) {
                abort(404);
            }

            // Fetch related notices
            $relatedNotices = \App\Models\Notice::published()
                ->where('id', '!=', $notice->id)
                ->when($notice->category, function($query) use ($notice) {
                    return $query->where('category', $notice->category);
                })
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();

            return view('pages.notices.show', compact('notice', 'relatedNotices'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error displaying notice', [
                'error' => $e->getMessage(),
                'notice_id' => $notice->id ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'An error occurred while loading the notice. Please try again later.');
        }
    }
}
