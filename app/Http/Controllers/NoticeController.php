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
        $category = $request->get('category');
        
        $notices = $category 
            ? $this->noticeService->getNoticesByCategory($category)
            : $this->noticeService->getPublishedNotices();

        return view('pages.notices.index', compact('notices', 'category'));
    }

    public function show($id)
    {
        $notice = $this->noticeService->findPublishedNotice($id);

        if (!$notice) {
            abort(404);
        }

        return view('pages.notices.show', compact('notice'));
    }
}
