<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AdmissionApplication extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents');
    }
    protected $fillable = [
        'parent_name',
        'parent_email',
        'parent_phone',
        'parent_address',
        'student_name',
        'student_dob',
        'student_gender',
        'current_grade',
        'applying_grade',
        'previous_school',
        'medical_conditions',
        'additional_notes',
        'status',
        'reviewed_at',
    ];

    protected $casts = [
        'student_dob' => 'date',
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

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
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
}
