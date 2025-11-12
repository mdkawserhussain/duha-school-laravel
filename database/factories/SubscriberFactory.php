<?php

namespace Database\Factories;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriber>
 */
class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->optional()->name(),
            'is_active' => true,
            'subscribed_at' => now()->subDays(fake()->numberBetween(1, 365)),
        ];
    }

    /**
     * Indicate that the subscriber is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'subscribed_at' => now()->subDays(fake()->numberBetween(1, 365)),
        ]);
    }

    /**
     * Indicate that the subscriber is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'subscribed_at' => now()->subDays(fake()->numberBetween(1, 365)),
        ]);
    }
}

