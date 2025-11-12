<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            'Principal',
            'Vice Principal',
            'Head of Academics',
            'Head of Islamic Studies',
            'Senior Teacher',
            'Teacher',
            'Administrative Officer',
            'IT Coordinator',
            'Librarian',
            'Counselor',
        ];

        return [
            'name' => fake()->name(),
            'position' => fake()->randomElement($positions),
            'bio' => fake()->paragraphs(2, true),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 100),
            'social_links' => [
                [
                    'platform' => fake()->randomElement(['facebook', 'twitter', 'linkedin', 'instagram']),
                    'url' => fake()->url(),
                ],
            ],
        ];
    }

    /**
     * Indicate that the staff member is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the staff member is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}

