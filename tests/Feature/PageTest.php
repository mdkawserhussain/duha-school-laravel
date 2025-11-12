<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_dynamic_page_renders(): void
    {
        $page = Page::factory()->published()->create([
            'slug' => 'test-page',
            'title' => 'Test Page',
        ]);

        $response = $this->get(route('about.show', 'test-page'));

        $response->assertStatus(200);
        $response->assertSee('Test Page');
    }

    public function test_draft_page_returns_404(): void
    {
        $page = Page::factory()->draft()->create([
            'slug' => 'draft-page',
        ]);

        $response = $this->get(route('about.show', 'draft-page'));

        $response->assertStatus(404);
    }

    public function test_privacy_policy_page_loads(): void
    {
        Page::factory()->published()->create([
            'slug' => 'privacy-policy',
            'title' => 'Privacy Policy',
        ]);

        $response = $this->get(route('privacy.show'));

        $response->assertStatus(200);
    }

    public function test_terms_of_service_page_loads(): void
    {
        Page::factory()->published()->create([
            'slug' => 'terms-of-service',
            'title' => 'Terms of Service',
        ]);

        $response = $this->get(route('terms.show'));

        $response->assertStatus(200);
    }
}

