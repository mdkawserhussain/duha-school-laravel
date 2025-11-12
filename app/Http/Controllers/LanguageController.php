<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'bn'])) {
            $locale = 'en';
        }

        // Store locale in session
        Session::put('locale', $locale);
        app()->setLocale($locale);

        // Redirect back to previous page or home
        return Redirect::back();
    }
}

