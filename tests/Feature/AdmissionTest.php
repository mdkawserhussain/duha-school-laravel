<?php

namespace Tests\Feature;

use App\Models\AdmissionApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
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
            'email' => 'parent@example.com',
            'phone' => '+8801234567890',
            'child_name' => 'Jane Doe',
            'child_dob' => '2015-05-15',
            'grade_applied' => 'Grade 1',
            'message' => 'Looking forward to admission.',
        ];

        $response = $this->post(route('admission.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('admission_applications', [
            'parent_name' => 'John Doe',
            'student_name' => 'Jane Doe',
            'parent_email' => 'parent@example.com',
            'parent_phone' => '+8801234567890',
        ]);
        Queue::assertPushed(\Illuminate\Mail\SendQueuedMailable::class);
    }

    public function test_can_submit_admission_application_with_documents(): void
    {
        Queue::fake();
        Storage::fake('public');

        $file1 = UploadedFile::fake()->create('birth_certificate.pdf', 500, 'application/pdf');
        $file2 = UploadedFile::fake()->image('passport_photo.jpg');

        $data = [
            'parent_name' => 'Sarah Connor',
            'email' => 'sarah@example.com',
            'phone' => '+8801234567891',
            'child_name' => 'John Connor',
            'child_dob' => '2016-02-28',
            'grade_applied' => 'Grade 2',
            'documents' => [$file1, $file2],
        ];

        $response = $this->post(route('admission.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $application = AdmissionApplication::where('parent_email', 'sarah@example.com')->first();
        $this->assertNotNull($application);
        $this->assertCount(2, $application->getMedia('documents'));
        $this->assertEquals('birth_certificate.pdf', $application->getMedia('documents')[0]->file_name);
        $this->assertEquals('passport_photo.jpg', $application->getMedia('documents')[1]->file_name);
    }

    public function test_admission_form_validation_works(): void
    {
        $response = $this->post(route('admission.store'), []);

        $response->assertSessionHasErrors(['parent_name', 'email', 'phone', 'child_name', 'child_dob', 'grade_applied']);
    }

    public function test_documents_validation_rejects_invalid_file_type(): void
    {
        $invalidFile = UploadedFile::fake()->create('script.exe', 500, 'application/x-msdownload');

        $data = [
            'parent_name' => 'Sarah Connor',
            'email' => 'sarah@example.com',
            'phone' => '+8801234567891',
            'child_name' => 'John Connor',
            'child_dob' => '2016-02-28',
            'grade_applied' => 'Grade 2',
            'documents' => [$invalidFile],
        ];

        $response = $this->post(route('admission.store'), $data);

        $response->assertSessionHasErrors(['documents.0']);
    }
}


