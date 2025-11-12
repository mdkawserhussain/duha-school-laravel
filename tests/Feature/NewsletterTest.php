<?php

namespace Tests\Feature;

use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_subscribe_to_newsletter(): void
    {
        Queue::fake();

        $data = [
            'email' => 'subscriber@example.com',
            'name' => 'John Doe',
        ];

        $response = $this->post(route('newsletter.subscribe'), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('subscribers', [
            'email' => 'subscriber@example.com',
            'name' => 'John Doe',
            'is_active' => true,
        ]);
        Queue::assertPushed(\Illuminate\Mail\SendQueuedMailable::class);
    }

    public function test_newsletter_subscription_requires_email(): void
    {
        $response = $this->post(route('newsletter.subscribe'), []);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_newsletter_subscription_validates_email_format(): void
    {
        $response = $this->post(route('newsletter.subscribe'), [
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_duplicate_email_subscription_updates_existing(): void
    {
        $subscriber = Subscriber::factory()->create([
            'email' => 'existing@example.com',
            'is_active' => false,
        ]);

        $this->post(route('newsletter.subscribe'), [
            'email' => 'existing@example.com',
            'name' => 'Updated Name',
        ]);

        $this->assertDatabaseHas('subscribers', [
            'email' => 'existing@example.com',
            'name' => 'Updated Name',
            'is_active' => true,
        ]);
    }

    public function test_newsletter_rate_limiting(): void
    {
        $data = ['email' => 'test@example.com'];

        // Submit 3 times (limit is 3 per minute)
        for ($i = 0; $i < 3; $i++) {
            $this->post(route('newsletter.subscribe'), $data);
        }

        // 4th attempt should be rate limited
        $response = $this->post(route('newsletter.subscribe'), $data);
        $response->assertStatus(429);
    }
}

