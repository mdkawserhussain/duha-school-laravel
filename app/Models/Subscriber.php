<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'name',
        'is_active',
        'subscribed_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'subscribed_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function unsubscribe()
    {
        $this->update(['is_active' => false]);
    }

    public function resubscribe()
    {
        $this->update(['is_active' => true]);
    }
}
