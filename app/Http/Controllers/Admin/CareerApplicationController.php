<?php

namespace App\Http\Controllers\Admin;

use App\Models\CareerApplication;
use Illuminate\Http\Request;

class CareerApplicationController extends BaseController
{
    public function index(Request $request)
    {
        $query = CareerApplication::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('position_applied', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('position_applied')) {
            $query->where('position_applied', $request->position_applied);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.career-applications.index', compact('applications'));
    }

    public function show(CareerApplication $careerApplication)
    {
        return view('admin.career-applications.show', ['application' => $careerApplication]);
    }

    public function update(Request $request, CareerApplication $careerApplication)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,reviewed,shortlisted,rejected'],
        ]);

        $careerApplication->update([
            'status' => $request->status,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.career-applications.show', $careerApplication)
            ->with('success', 'Application status updated successfully.');
    }
}
