<?php

namespace App\Helpers;

use App\Models\Announcement;
use Illuminate\Support\Collection;

class AnnouncementHelper
{
    /**
     * Safely get active announcements for display
     * Completely isolated to prevent breaking error pages
     */
    public static function getSafe(): Collection
    {
        // Never load in error contexts
        if (self::isErrorContext()) {
            return collect([]);
        }

        try {
            return Announcement::getActive();
        } catch (\Throwable $e) {
            return collect([]);
        }
    }

    /**
     * Check if we're in an error context
     */
    protected static function isErrorContext(): bool
    {
        // Always return true if we can't safely check - fail safe
        try {
            // Check multiple conditions
            if (app()->runningInConsole() || app()->runningUnitTests()) {
                return true;
            }

            // Check if exception is bound (most important check)
            if (app()->bound('exception')) {
                return true;
            }

            // Check request path
            if (function_exists('request') && request()) {
                $path = request()->path();
                if (str_contains($path, '_dusk') || 
                    str_contains($path, 'telescope') || 
                    str_contains($path, 'errors')) {
                    return true;
                }
            }

            // Check if we're in an exception handler context
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);
            foreach ($backtrace as $trace) {
                if (isset($trace['class']) && 
                    (str_contains($trace['class'], 'ExceptionHandler') || 
                     str_contains($trace['class'], 'Exception') ||
                     str_contains($trace['file'] ?? '', 'exceptions'))) {
                    return true;
                }
            }
        } catch (\Throwable $e) {
            // If anything fails, assume error context
            return true;
        }

        return false;
    }
}

