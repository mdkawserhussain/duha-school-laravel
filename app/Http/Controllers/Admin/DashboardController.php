<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdmissionApplication;
use App\Models\CareerApplication;
use App\Models\Event;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Staff;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function index()
    {
        $user = auth()->user();
        $stats = [];

        // Content stats (admin and editor)
        if ($user->hasAnyRole(['admin', 'editor'])) {
            $stats['pages'] = [
                'count' => Page::where('is_published', true)->count(),
                'label' => 'Total Pages',
                'description' => 'Published content pages',
                'url' => route('admin.pages.index'),
                'color' => 'green',
            ];

            $stats['events'] = [
                'count' => Event::where('is_published', true)
                    ->where('start_at', '>=', now())
                    ->count(),
                'label' => 'Upcoming Events',
                'description' => 'Events scheduled for the future',
                'url' => route('admin.events.index'),
                'color' => 'blue',
            ];

            $stats['staff'] = [
                'count' => Staff::where('is_active', true)->count(),
                'label' => 'Active Staff',
                'description' => 'Currently active staff members',
                'url' => route('admin.staff.index'),
                'color' => 'purple',
            ];
        }

        // Application stats (admin and admissions_officer)
        if ($user->hasAnyRole(['admin', 'admissions_officer'])) {
            $stats['admissions'] = [
                'count' => AdmissionApplication::where('status', 'pending')->count(),
                'label' => 'Pending Admissions',
                'description' => 'Admission applications awaiting review',
                'url' => route('admin.admission-applications.index'),
                'color' => 'yellow',
            ];

            $stats['careers'] = [
                'count' => CareerApplication::where('status', 'pending')->count(),
                'label' => 'Pending Career Apps',
                'description' => 'Job applications to review',
                'url' => route('admin.career-applications.index'),
                'color' => 'yellow',
            ];
        }

        // Recent activity - ensure models have IDs and required fields
        $recentEvents = Event::latest()->take(5)->get()->filter(function($event) {
            return $event && $event->id && $event->exists;
        })->values();
        $recentNotices = Notice::latest()->take(5)->get()->filter(function($notice) {
            return $notice && $notice->id && $notice->exists;
        })->values();
        $recentApplications = AdmissionApplication::latest()->take(5)->get()->filter(function($app) {
            return $app && $app->id && $app->exists;
        })->values();

        return view('admin.dashboard.index', compact('stats', 'recentEvents', 'recentNotices', 'recentApplications'));
    }
}
