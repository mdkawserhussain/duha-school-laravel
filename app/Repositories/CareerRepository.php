<?php

namespace App\Repositories;

use App\Models\CareerApplication;

class CareerRepository
{
    public function create(array $data): CareerApplication
    {
        return CareerApplication::create($data);
    }

    public function getPendingApplications(): \Illuminate\Database\Eloquent\Collection
    {
        return CareerApplication::pending()->orderBy('created_at', 'desc')->get();
    }

    public function findById(int $id): ?CareerApplication
    {
        return CareerApplication::find($id);
    }
}