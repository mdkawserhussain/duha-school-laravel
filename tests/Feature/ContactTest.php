<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_loads(): void
    {
        $response = $this->get(route('contact.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.contact');
    }

    public function test_can_submit_contact_form(): void
    {
        Queue::fake();

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+8801234567890',
            'subject' => 'Test Subject',
            'message' => 'This is a test message',
        ];

        $response = $this->post(route('contact.send'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        Queue::assertPushed(\Illuminate\Mail\SendQueuedMailable::class);
    }

    public function test_contact_form_validation_works(): void
    {
        $response = $this->post(route('contact.send'), []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_contact_form_rate_limiting(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Test message',
        ];

        // Submit 10 times (limit is 10 per minute)
        for ($i = 0; $i < 10; $i++) {
            $this->post(route('contact.send'), $data);
        }

        // 11th attempt should be rate limited
        $response = $this->post(route('contact.send'), $data);
        $response->assertStatus(429);
    }
}

