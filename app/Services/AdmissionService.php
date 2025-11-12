<?php

namespace App\Services;

use App\Repositories\AdmissionRepository;
use App\Models\AdmissionApplication;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdmissionApplicationReceived;

class AdmissionService
{
    protected AdmissionRepository $admissionRepository;

    public function __construct(AdmissionRepository $admissionRepository)
    {
        $this->admissionRepository = $admissionRepository;
    }

    public function storeApplication(array $data): AdmissionApplication
    {
        $application = $this->admissionRepository->create($data);

        // Send confirmation email
        Mail::to($application->parent_email)->queue(new AdmissionApplicationReceived($application));

        return $application;
    }

    public function getPendingApplications(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->admissionRepository->getPendingApplications();
    }

    public function findApplication(int $id): ?AdmissionApplication
    {
        return $this->admissionRepository->findById($id);
    }
}