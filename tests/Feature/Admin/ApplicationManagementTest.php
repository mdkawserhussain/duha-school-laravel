<?php

namespace Tests\Feature\Admin;

use App\Models\AdmissionApplication;
use App\Models\CareerApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ApplicationManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'admin']);
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('admin');
    }

    public function test_can_view_admission_application(): void
    {
        $application = AdmissionApplication::factory()->create([
            'parent_name' => 'Jane Smith',
            'student_name' => 'Tommy Smith',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.admission-applications.show', $application));

        $response->assertStatus(200);
        $response->assertSee('Tommy Smith');
        $response->assertSee('Jane Smith');
        $response->assertSee(route('admin.admission-applications.update', $application));
    }

    public function test_can_view_admission_application_with_attached_documents(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $application = AdmissionApplication::factory()->create([
            'parent_name' => 'Jane Smith',
            'student_name' => 'Tommy Smith',
            'status' => 'pending',
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->create('report_card.pdf', 200, 'application/pdf');
        $application->addMedia($file)->toMediaCollection('documents');

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.admission-applications.show', $application));

        $response->assertStatus(200);
        $response->assertSee('Supporting Documents');
        $response->assertSee('report_card.pdf');
        $response->assertSee('View / Download');
    }

    public function test_can_update_admission_application_status(): void
    {
        $application = AdmissionApplication::factory()->create([
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->patch(route('admin.admission-applications.update', $application), [
                'status' => 'accepted',
            ]);

        $response->assertRedirect(route('admin.admission-applications.show', $application));
        $this->assertDatabaseHas('admission_applications', [
            'id' => $application->id,
            'status' => 'accepted',
        ]);
    }

    public function test_can_view_career_application(): void
    {
        $application = CareerApplication::factory()->create([
            'full_name' => 'John Applicant',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.career-applications.show', $application));

        $response->assertStatus(200);
        $response->assertSee('John Applicant');
        $response->assertSee(route('admin.career-applications.update', $application));
    }

    public function test_can_update_career_application_status(): void
    {
        $application = CareerApplication::factory()->create([
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->patch(route('admin.career-applications.update', $application), [
                'status' => 'shortlisted',
            ]);

        $response->assertRedirect(route('admin.career-applications.show', $application));
        $this->assertDatabaseHas('career_applications', [
            'id' => $application->id,
            'status' => 'shortlisted',
        ]);
    }
}
