<?php

namespace App\Http\Middleware;

use App\Helpers\SiteSettingsHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip maintenance check for admin routes
        if ($request->is('admin*')) {
            return $next($request);
        }

        // Check if maintenance mode is enabled
        if (SiteSettingsHelper::isMaintenanceMode()) {
            return response()->view('maintenance', [
                'message' => SiteSettingsHelper::maintenanceMessage(),
                'websiteName' => SiteSettingsHelper::websiteName(),
            ], 503);
        }

        return $next($request);
    }
}
