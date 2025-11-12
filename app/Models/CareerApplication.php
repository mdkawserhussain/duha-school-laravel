<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'position_applied',
        'cover_letter',
        'resume_path',
        'experience',
        'education',
        'skills',
        'status',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', '!=', 'pending');
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', 'shortlisted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function markAsReviewed($status = 'reviewed')
    {
        $this->update([
            'status' => $status,
            'reviewed_at' => now(),
        ]);
    }

    public function getResumeUrlAttribute()
    {
        return $this->resume_path ? asset('storage/' . $this->resume_path) : null;
    }
}
