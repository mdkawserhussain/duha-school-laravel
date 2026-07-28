<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminCacheController extends Controller
{
    public function clearHomepageCache(Request $request)
    {
        Cache::forget('homepage_v2_data');
        
        // Also try to clear tagged cache if supported
        try {
            Cache::tags(['homepage', 'homepage_sections'])->flush();
        } catch (\Exception $e) {
            // Tags not supported, that's okay
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Homepage cache cleared successfully.',
        ]);
    }
}
