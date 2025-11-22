<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    /**
     * Get the current user with roles.
     */
    protected function getUser()
    {
        return auth()->user();
    }

    /**
     * Check if user has specific role.
     */
    protected function hasRole(string $role): bool
    {
        return $this->getUser()?->hasRole($role) ?? false;
    }

    /**
     * Check if user has any of the given roles.
     */
    protected function hasAnyRole(array $roles): bool
    {
        return $this->getUser()?->hasAnyRole($roles) ?? false;
    }

    /**
     * Authorize action based on role.
     */
    protected function authorizeRole(string|array $roles): void
    {
        $roles = is_array($roles) ? $roles : [$roles];
        
        if (!$this->hasAnyRole($roles)) {
            abort(403, 'Unauthorized access. You do not have the required role.');
        }
    }
}

