<?php

namespace App\Http\Controllers;

use App\Services\PageService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index()
    {
        // Try to fetch dynamic page with slug "about"
        $page = $this->pageService->findPublishedPageBySlug('about');
        
        // If no page found, create default data structure
        if (!$page) {
            // Create a simple object with default values
            $page = (object) [
                'title' => 'Welcome to Duha International School',
                'hero_subtitle' => 'Duha International School is committed to ensuring a high standard of education, combining modern curriculum with moral values to prepare students for a bright future.',
                'content' => '<p>Duha International School was conceived, founded, and promoted by Dr. Muhammad Aminul Hoque, Associate Professor and Former Chairman of the Department of Da\'wah & Islamic Studies at the International Islamic University Chittagong. Duha International School commenced operations in a hired building at Jalalabad Housing Society in West Khulshi, Chattogram Metropolitan, on March 1, 2023.</p><p>The academy aims to provide a balanced education that integrates general education with Islamic values. It strives to create an environment where students can develop their intellectual, physical, and spiritual potential to the fullest.</p><p>Our curriculum is designed to meet the challenges of the 21st century while keeping our students rooted in their cultural and religious heritage. We believe in nurturing future leaders who are not only academically competent but also morally upright.</p>',
                'data' => [
                    'mission_vision' => 'Growing a generation of students who are intellectually competent, spiritually mature, and socially responsible leaders for the community and the nation.',
                    'core_values' => [
                        'Islamic Faith & Culture',
                        'Prophetic Character',
                        'Lifelong Learning',
                        'Quality Community',
                        'Skill-based Learning',
                        'Intellectual Development'
                    ],
                    'specialties' => [
                        'Hifzul Quran with schooling',
                        'Special proficiency in Arabic Language',
                        'Modern education integrated with moral values',
                        'Certificate of Hifzul Quran'
                    ],
                    'facilities' => [
                        ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'title' => 'Cambridge & National Curriculum'],
                        ['icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Computer & Language Lab'],
                        ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Adult Learning Center'],
                        ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Modern Library with WiFi'],
                        ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Uninterruptible Power Supply'],
                        ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Counseling & Career Guidelines'],
                    ],
                    'salient_facilities' => [
                        'We use female-prophetic soft spoken tone',
                        'A fun & parliamentary style present school, we expected to show their best character this style quran',
                        'All our pupils are expected to be clean and smart, both in school and on their way to and from school',
                        'Duha International School encourages students to read, write & speak naturally by creating a natural environment where different languages such as English & Arabic',
                        'We offer both Cambridge & National Curriculum',
                        'A safe and secure playground for playing board boys where they can play under surveillance',
                        'A well-ventilated school with better ambience of the information on a click',
                        'Dedicated teachers monitor & help you to provide mental, physical & child growth in school',
                        'Video camera equipped campus',
                        'Pure water supply from centrally operated water plant',
                        '24 hours uninterrupted power supply',
                        'Well maintained sanitary facility',
                        'A rich digital process library',
                        'A full time special doctor on the premises',
                        'Spacious indoor playground',
                        'Computer Lab',
                        'Language Lab',
                        'Math Lab',
                        'Student careers & Counseling',
                        'Residential & Day care facilities for boys & girls'
                    ]
                ]
            ];
        }

        return view('pages.about', compact('page'));
    }
}
