<?php

namespace App\Services;

use App\Repositories\CareerRepository;
use App\Models\CareerApplication;
use Illuminate\Support\Facades\Mail;
use App\Mail\CareerApplicationReceived;

class CareerService
{
    protected CareerRepository $careerRepository;

    public function __construct(CareerRepository $careerRepository)
    {
        $this->careerRepository = $careerRepository;
    }

    public function storeApplication(array $data): CareerApplication
    {
        // Handle file upload for resume
        if (isset($data['resume'])) {
            $data['resume_path'] = $data['resume']->store('resumes', 'public');
            unset($data['resume']);
        }

        $application = $this->careerRepository->create($data);

        // Send confirmation email
        Mail::to($application->email)->queue(new CareerApplicationReceived($application));

        return $application;
    }

    public function getPendingApplications(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->careerRepository->getPendingApplications();
    }

    public function findApplication(int $id): ?CareerApplication
    {
        return $this->careerRepository->findById($id);
    }
}