<?php

namespace App\Repositories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Collection;

class StaffRepository
{
    public function getActiveStaff(int $perPage = 12): Collection
    {
        return Staff::active()
            ->ordered()
            ->get();
    }

    public function getFeaturedStaff(int $limit = 4): Collection
    {
        return Staff::active()
            ->ordered()
            ->limit($limit)
            ->get();
    }

    public function findStaffById(int $id): ?Staff
    {
        return Staff::active()->find($id);
    }

    public function getAllStaff(): Collection
    {
        return Staff::active()
            ->ordered()
            ->get();
    }
}

