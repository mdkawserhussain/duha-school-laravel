<?php

namespace Database\Seeders;

use App\Models\HomePageSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * SEEDER: Hero Slider – Populate default active slides with images for development/demo
 *
 * This seeder creates 3 beautiful, school-themed hero slides with images.
 * Uses HomePageSection model with section_type='hero' and 'images' media collection.
 */
class HeroSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎨 Seeding Hero Slides...');

        // Ensure demo directory exists
        $demoPath = storage_path('app/public/demo/heroes');
        if (!file_exists($demoPath)) {
            Storage::disk('public')->makeDirectory('demo/heroes');
            $this->command->info('📁 Created demo/heroes directory');
        }

        $slides = [
            [
                'section_key' => 'hero_seed_1',
                'title' => 'Welcome to Al-Maghrib International School',
                'subtitle' => 'Excellence in Education',
                'description' => 'Join us for a world-class education that combines Cambridge curriculum with Islamic values. Nurturing future leaders through academic excellence and character development.',
                'button_text' => 'Enroll Now',
                'button_link' => '/admission',
                'sort_order' => 1,
                'image_url' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1920&h=1080&fit=crop&q=80',
                'image_filename' => 'hero-1-school-building.jpg',
            ],
            [
                'section_key' => 'hero_seed_2',
                'title' => 'Cambridge Curriculum with Islamic Values',
                'subtitle' => 'Holistic Education',
                'description' => 'Experience the best of both worlds - internationally recognized Cambridge curriculum integrated with comprehensive Islamic education and character development.',
                'button_text' => 'Learn More',
                'button_link' => '/about',
                'sort_order' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920&h=1080&fit=crop&q=80',
                'image_filename' => 'hero-2-students-learning.jpg',
            ],
            [
                'section_key' => 'hero_seed_3',
                'title' => 'State-of-the-Art Campus',
                'subtitle' => 'Modern Facilities',
                'description' => 'Our campus features cutting-edge facilities, modern classrooms, science labs, and recreational areas designed to inspire learning and creativity.',
                'button_text' => 'Schedule a Visit',
                'button_link' => '/contact',
                'sort_order' => 3,
                'image_url' => 'https://images.unsplash.com/photo-1497486751825-1233686d5d80?w=1920&h=1080&fit=crop&q=80',
                'image_filename' => 'hero-3-campus-facilities.jpg',
            ],
        ];

        foreach ($slides as $slideData) {
            $this->createHeroSlide($slideData);
        }

        // Clear hero slider cache
        Cache::forget('homepage_data');
        $this->command->info('🗑️  Cleared homepage cache');

        $this->command->info('✅ Hero slides seeded successfully!');
    }

    /**
     * Create or update a hero slide with image
     */
    protected function createHeroSlide(array $data): void
    {
        // Check if slide exists by section_key (idempotent)
        $slide = HomePageSection::where('section_key', $data['section_key'])
            ->where('section_type', 'hero')
            ->first();

        if (!$slide) {
            $slide = HomePageSection::create([
                'section_key' => $data['section_key'],
                'section_type' => 'hero',
                'title' => $data['title'],
                'subtitle' => $data['subtitle'],
                'description' => $data['description'],
                'button_text' => $data['button_text'],
                'button_link' => $data['button_link'],
                'data' => [
                    'academic_highlights' => [
                        'Academic: Cambridge Early Years Foundation Stage (Play, Nursery and Reception)',
                        'Islamic Studies',
                        'Cambridge Primary - Key Stage 1 & 2 (Class 1 to 6)',
                        'Character Development Curriculum',
                        'Hifz Curriculum',
                    ],
                ],
                'sort_order' => $data['sort_order'],
                'is_active' => true,
            ]);
            $this->command->info("✨ Created slide: {$data['title']}");
        } else {
            // Update existing slide
            $slide->update([
                'title' => $data['title'],
                'subtitle' => $data['subtitle'],
                'description' => $data['description'],
                'button_text' => $data['button_text'],
                'button_link' => $data['button_link'],
                'sort_order' => $data['sort_order'],
                'is_active' => true,
            ]);
            $this->command->info("🔄 Updated slide: {$data['title']}");
        }

        // Download and attach image if not already attached
        if (!$slide->hasMedia('images')) {
            $this->downloadAndAttachImage($slide, $data['image_url'], $data['image_filename']);
        } else {
            $this->command->info("📷 Image already attached for: {$data['title']}");
        }
    }

    /**
     * Download image from URL and attach to slide
     */
    protected function downloadAndAttachImage(HomePageSection $slide, string $imageUrl, string $filename): void
    {
        try {
            $demoPath = storage_path('app/public/demo/heroes');
            $localPath = $demoPath . '/' . $filename;

            // Download image if not exists locally
            if (!file_exists($localPath)) {
                $this->command->info("⬇️  Downloading image: {$filename}");

                $response = Http::timeout(30)->get($imageUrl);

                if ($response->successful()) {
                    file_put_contents($localPath, $response->body());
                    $this->command->info("✅ Downloaded: {$filename}");
                } else {
                    $this->command->warn("⚠️  Failed to download image from: {$imageUrl}");
                    // Create a placeholder image instead
                    $this->createPlaceholderImage($localPath, $filename);
                }
            } else {
                $this->command->info("📁 Using existing image: {$filename}");
            }

            // Attach image to slide using Spatie Media Library
            if (file_exists($localPath)) {
                $slide->addMedia($localPath)
                    ->usingName(Str::before($filename, '.'))
                    ->usingFileName($filename)
                    ->toMediaCollection('images');

                $this->command->info("📎 Attached image to: {$slide->title}");
            }
        } catch (\Exception $e) {
            $this->command->error("❌ Error attaching image: " . $e->getMessage());
            // Create placeholder as fallback
            $this->createPlaceholderImage($localPath ?? storage_path('app/public/demo/heroes/' . $filename), $filename);
            if (file_exists($localPath)) {
                try {
                    $slide->addMedia($localPath)
                        ->usingName(Str::before($filename, '.'))
                        ->usingFileName($filename)
                        ->toMediaCollection('images');
                } catch (\Exception $e2) {
                    $this->command->error("❌ Failed to attach placeholder: " . $e2->getMessage());
                }
            }
        }
    }

    /**
     * Create a simple placeholder image using GD
     */
    protected function createPlaceholderImage(string $path, string $filename): void
    {
        try {
            $width = 1920;
            $height = 1080;

            $image = imagecreatetruecolor($width, $height);

            // Create gradient background (blue to dark blue)
            $color1 = imagecolorallocate($image, 30, 64, 175); // Blue
            $color2 = imagecolorallocate($image, 15, 23, 42); // Dark blue

            for ($i = 0; $i < $height; $i++) {
                $ratio = $i / $height;
                $r = (int)(30 + (15 - 30) * $ratio);
                $g = (int)(64 + (23 - 64) * $ratio);
                $b = (int)(175 + (42 - 175) * $ratio);
                $color = imagecolorallocate($image, $r, $g, $b);
                imageline($image, 0, $i, $width, $i, $color);
            }

            // Add text
            $textColor = imagecolorallocate($image, 255, 255, 255);
            $text = 'Hero Slide Image';
            $fontSize = 5;
            $textX = ($width - imagefontwidth($fontSize) * strlen($text)) / 2;
            $textY = $height / 2;
            imagestring($image, $fontSize, $textX, $textY, $text, $textColor);

            // Save as JPEG
            imagejpeg($image, $path, 85);
            imagedestroy($image);

            $this->command->info("🎨 Created placeholder: {$filename}");
        } catch (\Exception $e) {
            $this->command->error("❌ Failed to create placeholder: " . $e->getMessage());
        }
    }
}

