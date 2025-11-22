<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles {
        HasRoles::hasRole as traitHasRole;
        HasRoles::hasAnyRole as traitHasAnyRole;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Override hasRole to always return true for 'admin' role
     * This makes all users effectively admins
     */
    public function hasRole($roles, string $guard = null): bool
    {
        // If checking for admin role, always return true
        if (is_string($roles) && $roles === 'admin') {
            return true;
        }
        if (is_array($roles) && in_array('admin', $roles)) {
            return true;
        }
        
        // For other roles, use the trait implementation
        return $this->traitHasRole($roles, $guard);
    }

    /**
     * Override hasAnyRole to always return true if 'admin' is in the list
     * This makes all users effectively admins
     */
    public function hasAnyRole($roles, string $guard = null): bool
    {
        // If checking for admin role, always return true
        if (is_string($roles) && $roles === 'admin') {
            return true;
        }
        if (is_array($roles) && in_array('admin', $roles)) {
            return true;
        }
        
        // For other roles, use the trait implementation
        return $this->traitHasAnyRole($roles, $guard);
    }
}
