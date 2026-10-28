<?php

namespace App\Http\Controllers;

use App\Services\CareerService;
use App\Http\Requests\StoreCareerApplicationRequest;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    protected CareerService $careerService;

    public function __construct(CareerService $careerService)
    {
        $this->careerService = $careerService;
    }

    public function index()
    {
        return view('pages.careers');
    }

    public function store(StoreCareerApplicationRequest $request)
    {
        $validated = $request->validated();

        // Map the public form's field names onto the database columns
        // (career_applications table / admin panel expectations).
        // The resume file is passed through; CareerService stores it.
        $application = $this->careerService->storeApplication([
            'full_name'        => $validated['applicant_name'],
            'email'            => $validated['email'],
            'phone'            => $validated['phone'],
            'position_applied' => $validated['job_title'],
            'cover_letter'     => $validated['cover_letter'],
            'resume'           => $validated['resume'],
            'experience'       => $validated['experience'] ?? null,
            'education'        => $validated['education'] ?? null,
            'skills'           => $validated['skills'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Your career application has been submitted successfully. We will contact you soon.');
    }
}
