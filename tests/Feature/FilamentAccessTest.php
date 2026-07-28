<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FilamentAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'editor']);
        Role::create(['name' => 'admissions_officer']);
    }

    public function test_unauthenticated_user_cannot_access_filament(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_without_role_cannot_access_filament(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_filament(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
    }

    public function test_editor_can_access_content_resources(): void
    {
        $user = User::factory()->create();
        $user->assignRole('editor');

        $response = $this->actingAs($user)->get('/admin/events');

        $response->assertStatus(200);
    }

    public function test_admissions_officer_can_access_admissions(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admissions_officer');

        $response = $this->actingAs($user)->get('/admin/admission-applications');

        $response->assertStatus(200);
    }
}

