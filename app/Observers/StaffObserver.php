<?php

namespace App\Observers;

use App\Models\Staff;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StaffObserver
{
    /**
     * Handle the Staff "saved" event.
     */
    public function saved(Staff $staff): void
    {
        // Clear staff-related caches when staff is saved
        $this->clearStaffCaches();
    }

    /**
     * Handle the Staff "deleted" event.
     */
    public function deleted(Staff $staff): void
    {
        // Clear staff-related caches when staff is deleted
        $this->clearStaffCaches();
    }

    /**
     * Clear staff-related caches.
     */
    protected function clearStaffCaches(): void
    {
        try {
            // Clear homepage cache FIRST (staff are displayed there)
            // This ensures the homepage will fetch fresh data on next request
            Cache::forget('homepage_v2_data');
            
            // Clear staff-specific caches (pattern-based clearing for Redis)
            if (config('cache.default') === 'redis') {
                try {
                    $redis = Cache::getRedis();
                    $patterns = [
                        'staff_featured_*',
                        'staff_active_*',
                    ];
                    
                    foreach ($patterns as $pattern) {
                        $keys = $redis->keys($pattern);
                        if (!empty($keys)) {
                            $redis->del($keys);
                        }
                    }
                } catch (\Exception $e) {
                    // If pattern clearing fails, log and continue
                    Log::warning('Failed to clear staff caches by pattern', [
                        'error' => $e->getMessage(),
                    ]);
                }
            }
            
            // Log cache clearing for debugging
            Log::info('Staff caches cleared', [
                'cache_driver' => config('cache.default'),
                'homepage_cache_cleared' => true,
            ]);
        } catch (\Exception $e) {
            Log::error('Error clearing staff caches', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}

