<?php

namespace Database\Factories;

use App\Models\CareerApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CareerApplication>
 */
class CareerApplicationFactory extends Factory
{
    protected $model = CareerApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            'Mathematics Teacher',
            'English Teacher',
            'Science Teacher',
            'Islamic Studies Teacher',
            'Arabic Teacher',
            'IT Teacher',
            'Administrative Assistant',
            'Accountant',
            'Security Guard',
            'Maintenance Staff',
        ];

        return [
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'position_applied' => fake()->randomElement($positions),
            'cover_letter' => fake()->paragraphs(3, true),
            'resume_path' => 'resumes/' . fake()->uuid() . '.pdf',
            'experience' => fake()->paragraph(),
            'education' => fake()->sentence(),
            'skills' => fake()->words(5, true),
            'status' => 'pending',
            'reviewed_at' => null,
        ];
    }

    /**
     * Indicate that the application is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'reviewed_at' => null,
        ]);
    }

    /**
     * Indicate that the application is shortlisted.
     */
    public function shortlisted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'shortlisted',
            'reviewed_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ]);
    }

    /**
     * Indicate that the application is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'reviewed_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ]);
    }

    /**
     * Indicate that the application is reviewed.
     */
    public function reviewed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'reviewed',
            'reviewed_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ]);
    }
}

