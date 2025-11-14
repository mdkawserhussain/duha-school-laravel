<?php

namespace Database\Seeders;

use App\Models\Notice;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notices = [
            [
                'title' => 'Admission Open for Academic Year 2025-2026',
                'excerpt' => 'We are now accepting applications for the academic year 2025-2026. Limited seats available.',
                'content' => '<p>Duha International School is pleased to announce that admissions are now open for the academic year 2025-2026. We welcome applications from students seeking quality Islamic and Cambridge curriculum education.</p>
                
                <h3>Admission Process:</h3>
                <ol>
                    <li>Submit online application form</li>
                    <li>Attend assessment/interview (if required)</li>
                    <li>Submit required documents</li>
                    <li>Receive admission decision</li>
                </ol>
                
                <h3>Required Documents:</h3>
                <ul>
                    <li>Birth certificate</li>
                    <li>Previous school records</li>
                    <li>Passport-sized photographs</li>
                    <li>Medical records</li>
                </ul>
                
                <p>For more information, please contact our admissions office or visit our website.</p>
                
                <p><strong>Deadline:</strong> March 31, 2025</p>',
                'category' => 'Admission',
                'is_important' => true,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'School Holiday - Eid al-Fitr',
                'excerpt' => 'School will be closed for Eid al-Fitr celebrations. Classes will resume on the following week.',
                'content' => '<p>In observance of Eid al-Fitr, Duha International School will be closed from <strong>April 10, 2025 to April 14, 2025</strong>.</p>
                
                <p>Classes will resume on <strong>Monday, April 15, 2025</strong>.</p>
                
                <p>We wish all our students, parents, and staff a blessed and joyous Eid celebration.</p>
                
                <p><em>Eid Mubarak!</em></p>',
                'category' => 'Holiday',
                'is_important' => true,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Mid-Term Examination Schedule',
                'excerpt' => 'Mid-term examinations will be held from February 10-20, 2025. Please review the schedule carefully.',
                'content' => '<p>The mid-term examination schedule for the current academic term has been published. All students are required to review the schedule and prepare accordingly.</p>
                
                <h3>Important Dates:</h3>
                <ul>
                    <li><strong>Examination Period:</strong> February 10-20, 2025</li>
                    <li><strong>Schedule Release:</strong> January 25, 2025</li>
                    <li><strong>Results Publication:</strong> March 1, 2025</li>
                </ul>
                
                <h3>Examination Guidelines:</h3>
                <ul>
                    <li>Students must arrive 15 minutes before the scheduled time</li>
                    <li>Bring all required materials (pens, calculators, etc.)</li>
                    <li>Follow all examination rules and regulations</li>
                    <li>No electronic devices allowed in examination halls</li>
                </ul>
                
                <p>The detailed schedule is available on the school portal and notice boards.</p>',
                'category' => 'Academic',
                'is_important' => true,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Library Hours Extended',
                'excerpt' => 'School library will now be open until 5:00 PM on weekdays to accommodate students.',
                'content' => '<p>We are pleased to announce that the school library hours have been extended to better serve our students.</p>
                
                <h3>New Library Hours:</h3>
                <ul>
                    <li><strong>Sunday - Thursday:</strong> 8:00 AM - 5:00 PM</li>
                    <li><strong>Friday - Saturday:</strong> Closed</li>
                </ul>
                
                <p>The extended hours will allow students more time for research, study, and reading. Library staff will be available to assist students during these hours.</p>
                
                <p>We encourage all students to make use of this valuable resource.</p>',
                'category' => 'General',
                'is_important' => false,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Career Opportunities - Teaching Positions Available',
                'excerpt' => 'We are seeking qualified and dedicated teachers to join our team. Multiple positions available.',
                'content' => '<p>Duha International School is looking for passionate and qualified educators to join our teaching team.</p>
                
                <h3>Available Positions:</h3>
                <ul>
                    <li>Mathematics Teacher (Secondary)</li>
                    <li>Science Teacher (Physics/Chemistry)</li>
                    <li>English Language Teacher</li>
                    <li>Islamic Studies Teacher</li>
                    <li>Arabic Language Teacher</li>
                </ul>
                
                <h3>Requirements:</h3>
                <ul>
                    <li>Relevant teaching qualifications</li>
                    <li>Experience with Cambridge curriculum preferred</li>
                    <li>Strong commitment to Islamic values</li>
                    <li>Excellent communication skills</li>
                </ul>
                
                <p>Interested candidates should submit their applications through our careers portal or email to career@duhaschool.com</p>
                
                <p><strong>Application Deadline:</strong> March 15, 2025</p>',
                'category' => 'Career',
                'is_important' => false,
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($notices as $notice) {
            Notice::firstOrCreate(
                ['title' => $notice['title']],
                $notice
            );
        }
    }
}

