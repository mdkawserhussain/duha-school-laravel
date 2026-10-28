<?php

namespace App\Http\Controllers;

use App\Services\AdmissionService;
use App\Http\Requests\StoreAdmissionApplicationRequest;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    protected AdmissionService $admissionService;

    public function __construct(AdmissionService $admissionService)
    {
        $this->admissionService = $admissionService;
    }

    public function index()
    {
        return view('pages.admission');
    }

    public function store(StoreAdmissionApplicationRequest $request)
    {
        $validated = $request->validated();

        // Map the public form's field names onto the database columns
        // (admission_applications table / admin panel expectations).
        $application = $this->admissionService->storeApplication([
            'parent_name'      => $validated['parent_name'],
            'parent_email'     => $validated['email'],
            'parent_phone'     => $validated['phone'],
            'student_name'     => $validated['child_name'],
            'student_dob'      => $validated['child_dob'],
            'applying_grade'   => $validated['grade_applied'],
            'additional_notes' => $validated['message'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Your admission application has been submitted successfully. We will contact you soon.');
    }
}
