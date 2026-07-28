<?php

namespace App\Services;

use App\Repositories\StaffRepository;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Collection;

class StaffService
{
    protected StaffRepository $staffRepository;

    public function __construct(StaffRepository $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    public function getActiveStaff(int $perPage = 12): Collection
    {
        return $this->staffRepository->getActiveStaff($perPage);
    }

    public function getFeaturedStaff(int $limit = 4): Collection
    {
        return $this->staffRepository->getFeaturedStaff($limit);
    }

    public function findStaffById(int $id): ?Staff
    {
        return $this->staffRepository->findStaffById($id);
    }

    public function getAllStaff(): Collection
    {
        return $this->staffRepository->getAllStaff();
    }
}

