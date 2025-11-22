<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdmissionApplication;
use Illuminate\Http\Request;

class AdmissionApplicationController extends BaseController
{
    public function index(Request $request)
    {
        $query = AdmissionApplication::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('parent_name', 'like', "%{$search}%")
                  ->orWhere('parent_email', 'like', "%{$search}%")
                  ->orWhere('parent_phone', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('applying_grade')) {
            $query->where('applying_grade', $request->applying_grade);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.admission-applications.index', compact('applications'));
    }

    public function show(AdmissionApplication $admissionApplication)
    {
        return view('admin.admission-applications.show', ['application' => $admissionApplication]);
    }

    public function update(Request $request, AdmissionApplication $admissionApplication)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,reviewed,accepted,rejected'],
        ]);

        $admissionApplication->update([
            'status' => $request->status,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.admission-applications.show', $admissionApplication)
            ->with('success', 'Application status updated successfully.');
    }
}
