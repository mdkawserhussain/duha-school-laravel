<?php

namespace Tests\Feature;

use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_index_page_loads(): void
    {
        $response = $this->get(route('staff.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.staff.index');
    }

    public function test_staff_detail_page_loads(): void
    {
        $staff = Staff::factory()->active()->create();

        $response = $this->get(route('staff.show', $staff->id));

        $response->assertStatus(200);
        $response->assertViewIs('pages.staff.show');
        $response->assertSee($staff->name);
        $response->assertSee($staff->position);
    }

    public function test_inactive_staff_not_shown_on_index(): void
    {
        Staff::factory()->active()->count(3)->create();
        Staff::factory()->inactive()->count(2)->create();

        $response = $this->get(route('staff.index'));

        $response->assertStatus(200);
        $response->assertViewHas('staff', function ($staff) {
            return $staff->count() === 3;
        });
    }

    public function test_staff_ordered_by_sort_order(): void
    {
        Staff::factory()->active()->create(['name' => 'Third', 'sort_order' => 3]);
        Staff::factory()->active()->create(['name' => 'First', 'sort_order' => 1]);
        Staff::factory()->active()->create(['name' => 'Second', 'sort_order' => 2]);

        $response = $this->get(route('staff.index'));

        $response->assertStatus(200);
        $staff = $response->viewData('staff');
        $this->assertEquals('First', $staff->first()->name);
        $this->assertEquals('Third', $staff->last()->name);
    }
}

