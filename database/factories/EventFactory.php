<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Academic', 'Islamic', 'Sports', 'Cultural', 'Community'];
        $eventDate = fake()->dateTimeBetween('now', '+1 year');

        return [
            'title' => fake()->sentence(4),
            'slug' => fn (array $attributes) => Str::slug($attributes['title']) . '-' . fake()->randomNumber(3),
            'excerpt' => fake()->sentence(10),
            'description' => fake()->paragraphs(3, true),
            'content' => fake()->paragraphs(3, true),
            'event_date' => $eventDate,
            'start_at' => $eventDate,
            'location' => fake()->address(),
            'category' => fake()->randomElement($categories),
            'is_featured' => fake()->boolean(20), // 20% chance of being featured
            'is_published' => true,
            'status' => 'published',
            'published_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ];
    }

    /**
     * Indicate that the event is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => now()->subDays(fake()->numberBetween(1, 30)),
            'status' => 'published',
        ]);
    }

    /**
     * Indicate that the event is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
            'status' => 'draft',
        ]);
    }

    /**
     * Indicate that the event is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_date' => fake()->dateTimeBetween('now', '+1 year'),
            'start_at' => fake()->dateTimeBetween('now', '+1 year'),
            'is_published' => true,
            'status' => 'published',
            'published_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ]);
    }

    /**
     * Indicate that the event is in the past.
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'start_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'is_published' => true,
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    /**
     * Indicate that the event is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}

