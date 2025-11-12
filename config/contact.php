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

    'phone' => env('SCHOOL_PHONE', '+880-1766-500001'),
    'phone_display' => env('SCHOOL_PHONE_DISPLAY', '+880-1766-500001, +880-1835-318137'),
    'email' => [
        'info' => env('SCHOOL_EMAIL_INFO', 'info@almaghribinternationalschool.com'),
        'career' => env('SCHOOL_EMAIL_CAREER', 'career@almaghribinternationalschool.com'),
        'admission' => env('SCHOOL_EMAIL_ADMISSION', 'admission@almaghribinternationalschool.com'),
    ],
    'address' => [
        'line1' => env('SCHOOL_ADDRESS_LINE1', 'House-131/1, Road-01, South Khulshi'),
        'line2' => env('SCHOOL_ADDRESS_LINE2', 'Chittagong'),
        'city' => env('SCHOOL_ADDRESS_CITY', 'Chittagong'),
        'country' => env('SCHOOL_ADDRESS_COUNTRY', 'Bangladesh'),
        'full' => env('SCHOOL_ADDRESS_FULL', 'House-131/1, Road-01, South Khulshi, Chittagong, Bangladesh'),
    ],
    'office_hours' => [
        'weekdays' => 'Sunday - Thursday: 9:00 AM - 3:00 PM',
        'weekend' => 'Friday - Saturday: Closed',
        'short' => 'Sun-Thu: 9AM - 3PM',
    ],
    'social' => [
        'facebook' => env('SCHOOL_FACEBOOK', 'https://facebook.com/almaghribschool'),
        'twitter' => env('SCHOOL_TWITTER', ''),
        'instagram' => env('SCHOOL_INSTAGRAM', ''),
    ],
];

