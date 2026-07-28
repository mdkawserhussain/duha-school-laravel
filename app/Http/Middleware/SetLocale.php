<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session, route parameter, or default to config
        $locale = $request->route('locale') 
            ?? Session::get('locale') 
            ?? $request->get('lang')
            ?? config('app.locale', 'en');

        // Validate locale (only allow 'en' or 'bn')
        if (!in_array($locale, ['en', 'bn'])) {
            $locale = 'en';
        }

        // Set application locale
        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}

