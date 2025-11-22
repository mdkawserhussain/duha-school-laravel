<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreNoticeRequest;
use App\Http\Requests\Admin\UpdateNoticeRequest;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends BaseController
{
    public function index(Request $request)
    {
        $query = Notice::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_published')) {
            $query->where('is_published', $request->is_published === '1');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('is_important')) {
            $query->where('is_important', true);
        }

        $notices = $query->orderBy('published_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(StoreNoticeRequest $request)
    {
        $notice = Notice::create($request->validated());

        if ($request->hasFile('featured_image')) {
            $notice->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice created successfully.');
    }

    public function show($id)
    {
        $notice = Notice::findOrFail($id);
        return view('admin.notices.show', compact('notice'));
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(UpdateNoticeRequest $request, $id)
    {
        $notice = Notice::findOrFail($id);
        $notice->update($request->validated());

        if ($request->hasFile('featured_image')) {
            $notice->clearMediaCollection('featured_image');
            $notice->addMediaFromRequest('featured_image')
                ->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.notices.show', $notice->id)
            ->with('success', 'Notice updated successfully.');
    }

    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->delete();

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice deleted successfully.');
    }
}
