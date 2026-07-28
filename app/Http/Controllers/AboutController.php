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
                'hero_subtitle' => 'Duha International School, established in 2020 under the leadership of its Founder and Director, Hasan Mahmud, is committed to delivering high-quality education that combines a modern English-medium curriculum with strong moral and Islamic values. Our mission is to nurture confident, disciplined, and capable students who are prepared for a bright and successful future.',
                'content' => '<section style="font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.8; color: #333; max-width: 800px; margin: auto; padding: 20px;">

  

    <p style="margin-bottom: 20px;">
        <strong>Established in 2020</strong> under the visionary leadership of <strong>Founder and Director Hasan Mahmud</strong>, Duha International School (DIS) is a premier English-medium institution located in the heart of Chattogram. 
    </p>

    <p style="margin-bottom: 30px;">
        From our very beginning at the Port Connecting Road campus in Halishahar, we have been driven by a singular commitment: providing accessible, high-quality education that balances contemporary academic excellence with deep-rooted moral and cultural values.
    </p>

    <h3 style="color: #1a4d80; margin-top: 40px; margin-bottom: 15px;">Our Vision & Philosophy</h3>
    <p style="margin-bottom: 25px;">
        The school was established to create a safe, student-centered learning environment that transcends traditional schooling. Our philosophy integrates general education with traditional Islamic values, ensuring that our students develop their intellectual, physical, and spiritual potential to the fullest. We aim to meet the complex challenges of the 21st century while ensuring our learners remain grounded in their religious heritage.
    </p>

    <h3 style="color: #1a4d80; margin-top: 40px; margin-bottom: 15px;">Academic Excellence & 21st-Century Skills</h3>
    <p style="margin-bottom: 15px;">
        Our curriculum is meticulously designed to build a strong foundation in <strong>English, Mathematics, Science, ICT, and Languages</strong>. We utilize activity-based lessons and interactive classrooms to ensure a supportive atmosphere where children receive balanced development in:
    </p>

    <ul style="margin-bottom: 30px; padding-left: 20px;">
        <li style="margin-bottom: 10px;"><strong>Academics:</strong> Fostering intellectual curiosity, critical thinking, and academic competence.</li>
        <li style="margin-bottom: 10px;"><strong>Character & Morality:</strong> Nurturing compassion, responsibility, and upright moral standing.</li>
        <li style="margin-bottom: 10px;"><strong>Creativity & Leadership:</strong> Developing the confidence and leadership qualities necessary for future success.</li>
        <li style="margin-bottom: 10px;"><strong>Life Skills:</strong> Equipping students with the adaptability and creativity required for the modern world.</li>
    </ul>

    <h3 style="color: #1a4d80; margin-top: 40px; margin-bottom: 15px;">Commitment to Continuous Growth</h3>
    <p style="margin-bottom: 25px;">
        Duha International School is steadily growing in both reputation and enrollment by maintaining a focus on professional teaching practices and continuous institutional improvement. We believe in the power of meaningful engagement—working closely with parents and the local community to create a holistic ecosystem for our learners.
    </p>

    <h3 style="color: #1a4d80; margin-top: 40px; margin-bottom: 15px;">Nurturing Future Leaders</h3>
    <p style="margin-bottom: 40px;">
        At DIS, we don\'t just teach; we inspire. Our experienced faculty is dedicated to nurturing future leaders who are not only academically competitive on a global scale but also morally steadfast and socially responsible.
    </p>

    <div style="background-color: #f9f9f9; border-left: 5px solid #1a4d80; padding: 25px; margin-top: 40px; border-radius: 5px;">
        <h4 style="margin-top: 0; color: #1a4d80;">Campus Information & Contact</h4>
        
        <p style="margin: 5px 0;">
            <strong>📍 Address:</strong> House 2481/A, P.C Road, Nayabazar Bishwa Road, Halisahar, Chattogram, BD.
        </p>
        
        <p style="margin: 5px 0;">
            <strong>📞 Phone:</strong> <a href="tel:+01890703760" style="text-decoration: none; color: #333;">+01890703760</a>
        </p>
        
        <p style="margin: 5px 0;">
            <strong>📧 Email:</strong> <a href="mailto:info@duhais.com" style="text-decoration: none; color: #333;">info@duhais.com</a>
        </p>
        
        <p style="margin: 5px 0;">
            <strong>🌐 Website:</strong> <a href="https://www.duhais.com" target="_blank" style="color: #1a4d80; text-decoration: none; font-weight: bold;">www.duhais.com</a>
        </p>
    </div>

</section>',
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
