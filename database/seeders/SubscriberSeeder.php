<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscribers = [
            [
                'email' => 'parent1@example.com',
                'name' => 'Ahmed Rahman',
                'is_active' => true,
                'subscribed_at' => Carbon::now()->subMonths(3),
            ],
            [
                'email' => 'parent2@example.com',
                'name' => 'Fatima Ali',
                'is_active' => true,
                'subscribed_at' => Carbon::now()->subMonths(2),
            ],
            [
                'email' => 'parent3@example.com',
                'name' => 'Hassan Khan',
                'is_active' => true,
                'subscribed_at' => Carbon::now()->subMonths(1),
            ],
            [
                'email' => 'parent4@example.com',
                'name' => 'Aisha Mahmud',
                'is_active' => true,
                'subscribed_at' => Carbon::now()->subWeeks(2),
            ],
            [
                'email' => 'parent5@example.com',
                'name' => 'Omar Hossain',
                'is_active' => true,
                'subscribed_at' => Carbon::now()->subWeeks(1),
            ],
            [
                'email' => 'parent6@example.com',
                'name' => 'Zainab Chowdhury',
                'is_active' => false,
                'subscribed_at' => Carbon::now()->subMonths(6),
            ],
            [
                'email' => 'parent7@example.com',
                'name' => 'Yusuf Ahmed',
                'is_active' => true,
                'subscribed_at' => Carbon::now()->subDays(5),
            ],
            [
                'email' => 'parent8@example.com',
                'name' => 'Maryam Islam',
                'is_active' => true,
                'subscribed_at' => Carbon::now()->subDays(3),
            ],
        ];

        foreach ($subscribers as $subscriber) {
            Subscriber::firstOrCreate(
                ['email' => $subscriber['email']],
                $subscriber
            );
        }
    }
}

