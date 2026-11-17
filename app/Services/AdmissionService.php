<?php

namespace App\Services;

use App\Repositories\AdmissionRepository;
use App\Models\AdmissionApplication;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdmissionApplicationReceived;
use Illuminate\Http\UploadedFile;

class AdmissionService
{
    protected AdmissionRepository $admissionRepository;

    public function __construct(AdmissionRepository $admissionRepository)
    {
        $this->admissionRepository = $admissionRepository;
    }

    public function storeApplication(array $data, array $files = []): AdmissionApplication
    {
        $application = $this->admissionRepository->create($data);

        // Attach optional supporting documents uploaded on the public form
        // to the 'documents' media collection (Spatie Media Library).
        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $application->addMedia($file)
                    ->toMediaCollection('documents');
            }
        }

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