<?php

namespace App\Http\Controllers;

use App\Services\StaffService;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    protected StaffService $staffService;

    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }

    public function index()
    {
        $cacheKey = 'staff_directory';
        $cacheTime = 3600; // 1 hour

        $staff = cache()->remember($cacheKey, $cacheTime, function () {
            return $this->staffService->getAllStaff();
        });

        return response()
            ->view('pages.staff.index', compact('staff'))
            ->header('Cache-Control', 'public, max-age=3600');
    }

    public function show($id)
    {
        $staff = $this->staffService->findStaffById($id);

        if (!$staff) {
            abort(404);
        }

        return view('pages.staff.show', compact('staff'));
    }
}

