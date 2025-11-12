<?php

namespace Database\Factories;

use App\Models\AdmissionApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdmissionApplication>
 */
class AdmissionApplicationFactory extends Factory
{
    protected $model = AdmissionApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $grades = ['Pre-K', 'Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'];

        return [
            'parent_name' => fake()->name(),
            'parent_email' => fake()->unique()->safeEmail(),
            'parent_phone' => fake()->phoneNumber(),
            'parent_address' => fake()->address(),
            'student_name' => fake()->name(),
            'student_dob' => fake()->dateTimeBetween('-15 years', '-3 years'),
            'student_gender' => fake()->randomElement(['Male', 'Female']),
            'current_grade' => fake()->randomElement($grades),
            'applying_grade' => fake()->randomElement($grades),
            'previous_school' => fake()->company() . ' School',
            'medical_conditions' => fake()->boolean(20) ? fake()->sentence() : null,
            'additional_notes' => fake()->boolean(40) ? fake()->paragraph() : null,
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
     * Indicate that the application is accepted.
     */
    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'accepted',
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

