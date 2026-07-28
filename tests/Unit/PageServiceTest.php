<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Repositories\PageRepository;
use App\Services\PageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PageService $pageService;
    protected PageRepository $pageRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pageRepository = new PageRepository();
        $this->pageService = new PageService($this->pageRepository);
    }

    public function test_can_find_published_page_by_slug(): void
    {
        $page = Page::factory()->published()->create([
            'slug' => 'test-page',
        ]);

        $found = $this->pageService->findPublishedPageBySlug('test-page');

        $this->assertNotNull($found);
        $this->assertEquals($page->id, $found->id);
    }

    public function test_cannot_find_draft_page_by_slug(): void
    {
        Page::factory()->draft()->create([
            'slug' => 'draft-page',
        ]);

        $found = $this->pageService->findPublishedPageBySlug('draft-page');

        $this->assertNull($found);
    }

    public function test_cannot_find_nonexistent_page(): void
    {
        $found = $this->pageService->findPublishedPageBySlug('nonexistent');

        $this->assertNull($found);
    }
}

