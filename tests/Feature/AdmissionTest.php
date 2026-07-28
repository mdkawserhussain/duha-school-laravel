<?php

namespace Tests\Feature;

use App\Models\AdmissionApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AdmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admission_form_page_loads(): void
    {
        $response = $this->get(route('admission.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.admission');
    }

    public function test_can_submit_admission_application(): void
    {
        Queue::fake();

        $data = [
            'parent_name' => 'John Doe',
            'parent_email' => 'parent@example.com',
            'parent_phone' => '+8801234567890',
            'parent_address' => '123 Test Street',
            'student_name' => 'Jane Doe',
            'student_dob' => '2015-05-15',
            'student_gender' => 'female',
            'current_grade' => 'Kindergarten',
            'applying_grade' => 'Grade 1',
            'previous_school' => 'Test School',
        ];

        $response = $this->post(route('admission.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('admission_applications', [
            'parent_name' => 'John Doe',
            'student_name' => 'Jane Doe',
        ]);
        Queue::assertPushed(\Illuminate\Mail\SendQueuedMailable::class);
    }

    public function test_admission_form_validation_works(): void
    {
        $response = $this->post(route('admission.store'), []);

        $response->assertSessionHasErrors(['parent_name', 'parent_email', 'student_name']);
    }
}

