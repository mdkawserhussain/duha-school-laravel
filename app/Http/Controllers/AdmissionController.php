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
        $application = $this->admissionService->storeApplication($request->validated());

        return redirect()->back()->with('success', 'Your admission application has been submitted successfully. We will contact you soon.');
    }
}
