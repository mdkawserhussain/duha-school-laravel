<?php

namespace Tests\Feature;

use App\Models\Notice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoticeTest extends TestCase
{
    use RefreshDatabase;

    public function test_notices_index_page_loads(): void
    {
        $response = $this->get(route('notices.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.notices.index');
    }

    public function test_notice_detail_page_loads(): void
    {
        $notice = Notice::factory()->published()->create();

        $response = $this->get(route('notices.show', $notice));

        $response->assertStatus(200);
        $response->assertViewIs('pages.notices.show');
        $response->assertSee($notice->title);
    }

    public function test_draft_notices_not_shown_on_index(): void
    {
        Notice::factory()->published()->count(3)->create();
        Notice::factory()->draft()->count(2)->create();

        $response = $this->get(route('notices.index'));

        $response->assertStatus(200);
        $response->assertViewHas('notices', function ($notices) {
            return $notices->count() === 3;
        });
    }

    public function test_important_notices_displayed(): void
    {
        Notice::factory()->published()->important()->create([
            'title' => 'Important Notice',
        ]);

        $response = $this->get(route('notices.index'));

        $response->assertStatus(200);
        $response->assertSee('Important Notice');
    }
}

