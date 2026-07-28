<?php

namespace Tests\Feature;

use App\Models\CareerApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CareerTest extends TestCase
{
    use RefreshDatabase;

    public function test_careers_page_loads(): void
    {
        $response = $this->get(route('careers.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.careers');
    }

    public function test_can_submit_career_application(): void
    {
        Queue::fake();

        $data = [
            'full_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+8801234567890',
            'position_applied' => 'Mathematics Teacher',
            'cover_letter' => 'I am interested in this position.',
            'experience' => '5 years teaching experience',
            'education' => 'MSc in Mathematics',
            'skills' => 'Teaching, Communication',
        ];

        $response = $this->post(route('careers.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('career_applications', [
            'full_name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
        Queue::assertPushed(\Illuminate\Mail\SendQueuedMailable::class);
    }

    public function test_career_form_validation_works(): void
    {
        $response = $this->post(route('careers.store'), []);

        $response->assertSessionHasErrors(['full_name', 'email', 'position_applied']);
    }

    public function test_career_application_status_defaults_to_pending(): void
    {
        $data = [
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'position_applied' => 'Teacher',
        ];

        $this->post(route('careers.store'), $data);

        $this->assertDatabaseHas('career_applications', [
            'full_name' => 'John Doe',
            'status' => 'pending',
        ]);
    }
}

