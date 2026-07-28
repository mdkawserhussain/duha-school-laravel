<?php

namespace Tests\Unit;

use App\Models\Notice;
use App\Repositories\NoticeRepository;
use App\Services\NoticeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoticeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected NoticeService $noticeService;
    protected NoticeRepository $noticeRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->noticeRepository = new NoticeRepository();
        $this->noticeService = new NoticeService($this->noticeRepository);
    }

    public function test_can_get_published_notices(): void
    {
        Notice::factory()->count(5)->published()->create();
        Notice::factory()->count(3)->draft()->create();

        $notices = $this->noticeService->getPublishedNotices();

        $this->assertEquals(5, $notices->total());
    }

    public function test_can_get_important_notices(): void
    {
        Notice::factory()->count(3)->published()->important()->create();
        Notice::factory()->count(2)->published()->create(['is_important' => false]);

        $notices = $this->noticeService->getImportantNotices(5);

        $this->assertCount(3, $notices);
        $notices->each(function ($notice) {
            $this->assertTrue($notice->is_important);
        });
    }

    public function test_can_get_recent_notices(): void
    {
        Notice::factory()->count(10)->published()->create();

        $notices = $this->noticeService->getRecentNotices(5);

        $this->assertCount(5, $notices);
    }
}

