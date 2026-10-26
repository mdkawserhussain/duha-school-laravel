<?php

return [
    /*
    |--------------------------------------------------------------------------
    | School Contact Information
    |--------------------------------------------------------------------------
    |
    | This file contains all contact information for AlMaghrib International School.
    | Update these values as needed.
    |
    */

    'phone' => env('SCHOOL_PHONE', '+8801890-703760'),
    'phone_display' => env('SCHOOL_PHONE_DISPLAY', '+8801890-703760'),
    'email' => [
        'info' => env('SCHOOL_EMAIL_INFO', 'info@duhais.com'),
        'career' => env('SCHOOL_EMAIL_CAREER', 'info@duhais.com'),
        'admission' => env('SCHOOL_EMAIL_ADMISSION', 'info@duhais.com'),
    ],
    'address' => [
        'line1' => env('SCHOOL_ADDRESS_LINE1', 'House 2481/A, P.C Road, Nayabazar Bishwa Road, Halisahar,'),
        'line2' => env('SCHOOL_ADDRESS_LINE2', 'Chittagong'),
        'city' => env('SCHOOL_ADDRESS_CITY', 'Chittagong'),
        'country' => env('SCHOOL_ADDRESS_COUNTRY', 'Bangladesh'),
        'full' => env('SCHOOL_ADDRESS_FULL', 'House 2481/A, P.C Road, Nayabazar Bishwa Road, Halisahar, Chittagong, Bangladesh'),
    ],
    'office_hours' => [
        'weekdays' => 'Sunday - Thursday: 9:00 AM - 3:00 PM',
        'weekend' => 'Friday - Saturday: Closed',
        'short' => 'Sun-Thu: 9AM - 3PM',
    ],
    'social' => [
        'facebook' => env('SCHOOL_FACEBOOK', 'https://www.facebook.com/DUHAINTERNATIONALSCHOOL'),
        'twitter' => env('SCHOOL_TWITTER', ''),
        'instagram' => env('SCHOOL_INSTAGRAM', ''),
    ],
];

