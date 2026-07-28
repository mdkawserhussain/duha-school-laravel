<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use Illuminate\Console\Command;

class SanitizeAnnouncements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'announcements:sanitize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sanitize all announcement data to ensure valid UTF-8 encoding';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Sanitizing announcement data...');

        $announcements = Announcement::all();
        $sanitized = 0;
        $errors = 0;

        foreach ($announcements as $announcement) {
            try {
                $originalMessage = $announcement->getRawOriginal('message');
                $originalLinkText = $announcement->getRawOriginal('link_text');

                // Use the accessor to get sanitized values
                $sanitizedMessage = $announcement->message;
                $sanitizedLinkText = $announcement->link_text;

                // Check if sanitization changed anything
                $needsUpdate = false;
                if ($originalMessage !== $sanitizedMessage) {
                    $needsUpdate = true;
                    $this->warn("  Sanitizing message for announcement #{$announcement->id}");
                }
                if ($originalLinkText !== $sanitizedLinkText) {
                    $needsUpdate = true;
                    $this->warn("  Sanitizing link_text for announcement #{$announcement->id}");
                }

                if ($needsUpdate) {
                    // Update using mutators (which will sanitize)
                    $announcement->message = $originalMessage;
                    $announcement->link_text = $originalLinkText;
                    $announcement->save();
                    $sanitized++;
                    $this->info("  ✓ Sanitized announcement #{$announcement->id}");
                }
            } catch (\Throwable $e) {
                $errors++;
                $this->error("  ✗ Error sanitizing announcement #{$announcement->id}: " . $e->getMessage());
            }
        }

        $this->info("\nSanitization complete!");
        $this->info("  Total announcements: {$announcements->count()}");
        $this->info("  Sanitized: {$sanitized}");
        $this->info("  Errors: {$errors}");

        return Command::SUCCESS;
    }
}
