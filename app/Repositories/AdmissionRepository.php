<?php

namespace App\Repositories;

use App\Models\AdmissionApplication;

class AdmissionRepository
{
    public function create(array $data): AdmissionApplication
    {
        return AdmissionApplication::create($data);
    }

    public function getPendingApplications(): \Illuminate\Database\Eloquent\Collection
    {
        return AdmissionApplication::pending()->orderBy('created_at', 'desc')->get();
    }

    public function findById(int $id): ?AdmissionApplication
    {
        return AdmissionApplication::find($id);
    }
}