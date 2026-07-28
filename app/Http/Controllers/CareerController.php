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
        $application = $this->careerService->storeApplication($request->validated());

        return redirect()->back()->with('success', 'Your career application has been submitted successfully. We will contact you soon.');
    }
}
