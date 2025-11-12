<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = [
            [
                'name' => 'Dr. Muhammad Abdullah',
                'position' => 'Principal',
                'bio' => 'Dr. Muhammad Abdullah brings over 20 years of experience in Islamic education and international curriculum management. He holds a Ph.D. in Islamic Education and has served in various leadership roles in educational institutions across the region. His vision focuses on integrating Islamic values with modern educational practices.',
                'email' => 'principal@almaghribschool.com',
                'phone' => '+880-31-1234567',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Mrs. Fatima Rahman',
                'position' => 'Vice Principal',
                'bio' => 'Mrs. Fatima Rahman has been with Al-Maghrib International School since its inception. She holds a Master\'s degree in Education and specializes in curriculum development. She is passionate about student welfare and academic excellence.',
                'email' => 'viceprincipal@almaghribschool.com',
                'phone' => '+880-31-1234568',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Ustadh Ahmad Hassan',
                'position' => 'Head of Islamic Studies',
                'bio' => 'Ustadh Ahmad Hassan is a renowned Islamic scholar with extensive knowledge in Quranic studies, Hadith, and Islamic jurisprudence. He has memorized the entire Quran and holds Ijazah in multiple Qira\'at. He is dedicated to instilling Islamic values in our students.',
                'email' => 'islamicstudies@almaghribschool.com',
                'phone' => '+880-31-1234569',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Mr. John Smith',
                'position' => 'Head of Academics',
                'bio' => 'Mr. John Smith is an experienced educator with expertise in Cambridge International Curriculum. He holds a Master\'s degree in Education and has been instrumental in developing our academic programs. He ensures that our students receive world-class education standards.',
                'email' => 'academics@almaghribschool.com',
                'phone' => '+880-31-1234570',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Mrs. Sarah Khan',
                'position' => 'Head of Primary School',
                'bio' => 'Mrs. Sarah Khan specializes in early childhood and primary education. With over 15 years of experience, she creates nurturing learning environments for young students. She holds a Master\'s degree in Early Childhood Education and is passionate about holistic child development.',
                'email' => 'primary@almaghribschool.com',
                'phone' => '+880-31-1234571',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Mr. David Williams',
                'position' => 'Head of Science Department',
                'bio' => 'Mr. David Williams brings extensive experience in science education and laboratory management. He holds a Master\'s degree in Physics and has been teaching for over 18 years. He is committed to making science accessible and exciting for all students.',
                'email' => 'science@almaghribschool.com',
                'phone' => '+880-31-1234572',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($staff as $member) {
            Staff::firstOrCreate(
                ['email' => $member['email']],
                $member
            );
        }
    }
}

