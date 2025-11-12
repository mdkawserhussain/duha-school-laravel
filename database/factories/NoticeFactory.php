<?php

namespace Database\Factories;

use App\Models\Notice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notice>
 */
class NoticeFactory extends Factory
{
    protected $model = Notice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['General', 'Academic', 'Admission', 'Event', 'Holiday', 'Important'];

        return [
            'title' => fake()->sentence(5),
            'excerpt' => fake()->sentence(10),
            'content' => fake()->paragraphs(4, true),
            'category' => fake()->randomElement($categories),
            'is_important' => fake()->boolean(30), // 30% chance of being important
            'is_published' => true,
            'published_at' => now()->subDays(fake()->numberBetween(1, 60)),
        ];
    }

    /**
     * Indicate that the notice is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => now()->subDays(fake()->numberBetween(1, 60)),
        ]);
    }

    /**
     * Indicate that the notice is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the notice is important.
     */
    public function important(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_important' => true,
        ]);
    }
}

