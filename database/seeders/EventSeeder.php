<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Annual Science Fair 2025',
                'slug' => 'annual-science-fair-2025',
                'excerpt' => 'Join us for our annual science fair showcasing innovative projects from students across all grade levels.',
                'description' => '<p>Our Annual Science Fair is one of the most anticipated events of the year. Students from all grade levels will showcase their innovative science projects, experiments, and research findings. This event promotes scientific inquiry, critical thinking, and creativity among our students.</p>
                
                <h3>Event Highlights:</h3>
                <ul>
                    <li>Student project presentations</li>
                    <li>Interactive science demonstrations</li>
                    <li>Guest judges from the scientific community</li>
                    <li>Prizes for outstanding projects</li>
                    <li>Open to parents and community members</li>
                </ul>
                
                <p><strong>Date:</strong> March 15, 2025<br>
                <strong>Time:</strong> 9:00 AM - 3:00 PM<br>
                <strong>Location:</strong> School Auditorium and Science Labs</p>',
                'event_date' => Carbon::now()->addMonths(2)->setTime(9, 0),
                'location' => 'School Auditorium',
                'category' => 'Academic',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Quran Memorization Competition',
                'slug' => 'quran-memorization-competition',
                'excerpt' => 'Annual Quran memorization competition for students to showcase their Hifz achievements.',
                'description' => '<p>Our annual Quran Memorization Competition celebrates the achievements of our students in memorizing the Holy Quran. This event recognizes the dedication and effort of our Hifz students and encourages others to follow in their footsteps.</p>
                
                <h3>Competition Categories:</h3>
                <ul>
                    <li>Juz Amma (30th Juz)</li>
                    <li>Selected Surahs</li>
                    <li>Full Quran (Hifz)</li>
                    <li>Recitation with Tajweed</li>
                </ul>
                
                <p><strong>Date:</strong> April 10, 2025<br>
                <strong>Time:</strong> 10:00 AM - 2:00 PM<br>
                <strong>Location:</strong> School Masjid</p>',
                'event_date' => Carbon::now()->addMonths(3)->setTime(10, 0),
                'location' => 'School Masjid',
                'category' => 'Islamic',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Sports Day 2025',
                'slug' => 'sports-day-2025',
                'excerpt' => 'Annual sports day featuring various athletic competitions and team events.',
                'description' => '<p>Join us for our annual Sports Day, a day filled with excitement, competition, and team spirit. Students will participate in various athletic events including track and field, team sports, and fun activities.</p>
                
                <h3>Events Include:</h3>
                <ul>
                    <li>Track and field competitions</li>
                    <li>Football and basketball matches</li>
                    <li>Relay races</li>
                    <li>Fun activities for younger students</li>
                    <li>Award ceremony</li>
                </ul>
                
                <p><strong>Date:</strong> May 20, 2025<br>
                <strong>Time:</strong> 8:00 AM - 4:00 PM<br>
                <strong>Location:</strong> School Sports Ground</p>',
                'event_date' => Carbon::now()->addMonths(4)->setTime(8, 0),
                'location' => 'School Sports Ground',
                'category' => 'Sports',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Parent-Teacher Conference',
                'slug' => 'parent-teacher-conference',
                'excerpt' => 'Scheduled parent-teacher conferences to discuss student progress and academic performance.',
                'description' => '<p>We invite all parents to attend our scheduled parent-teacher conferences. This is an opportunity to meet with your child\'s teachers, discuss academic progress, and address any concerns or questions.</p>
                
                <h3>What to Expect:</h3>
                <ul>
                    <li>Individual meetings with subject teachers</li>
                    <li>Review of academic progress reports</li>
                    <li>Discussion of student strengths and areas for improvement</li>
                    <li>Goal setting for the next term</li>
                </ul>
                
                <p><strong>Date:</strong> February 25, 2025<br>
                <strong>Time:</strong> 2:00 PM - 6:00 PM<br>
                <strong>Location:</strong> School Classrooms</p>
                
                <p><em>Please schedule your appointment in advance through the school office.</em></p>',
                'event_date' => Carbon::now()->addMonths(1)->setTime(14, 0),
                'location' => 'School Classrooms',
                'category' => 'Academic',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Islamic Art Exhibition',
                'slug' => 'islamic-art-exhibition',
                'excerpt' => 'Showcase of Islamic art and calligraphy created by our talented students.',
                'description' => '<p>Our Islamic Art Exhibition celebrates the rich tradition of Islamic art and calligraphy. Students from all grade levels will display their artwork, including Arabic calligraphy, geometric patterns, and Islamic-inspired designs.</p>
                
                <h3>Exhibition Features:</h3>
                <ul>
                    <li>Arabic calligraphy displays</li>
                    <li>Geometric pattern artwork</li>
                    <li>Islamic architecture models</li>
                    <li>Student presentations on Islamic art history</li>
                </ul>
                
                <p><strong>Date:</strong> June 5, 2025<br>
                <strong>Time:</strong> 10:00 AM - 4:00 PM<br>
                <strong>Location:</strong> School Art Gallery</p>',
                'event_date' => Carbon::now()->addMonths(5)->setTime(10, 0),
                'location' => 'School Art Gallery',
                'category' => 'Cultural',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($events as $event) {
            Event::firstOrCreate(
                ['title' => $event['title']],
                $event
            );
        }
    }
}