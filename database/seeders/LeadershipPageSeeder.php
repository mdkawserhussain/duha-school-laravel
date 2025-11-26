<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class LeadershipPageSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update Founder & Director's Message page
        $page = Page::updateOrCreate(
            ['slug' => 'founder-director-message'],
            [
                'title' => "Founder & Director's Message",
                'page_category' => 'about-us',
                'is_published' => true,
                'published_at' => now(),
                'content' => $this->getContent(),
                'meta_title' => "Founder & Director's Message - Zaitoon Academy",
                'meta_description' => 'Read the inspiring message from our Founder & Director about the vision, mission, and values that guide Zaitoon Academy.',
            ]
        );
        
        $this->command->info('');
        $this->command->info('📝 To add profile image and metadata:');
        $this->command->info('   1. Go to Admin → Pages');
        $this->command->info('   2. Edit "Founder & Director\'s Message"');
        $this->command->info('   3. Upload profile image');
        $this->command->info('   4. Add custom fields if available');

        $this->command->info('Leadership page created/updated successfully!');
        $this->command->info('Visit: http://127.0.0.1:8000/about-us/founder-director-message');
    }

    private function getContent(): string
    {
        return <<<'HTML'
<h2>In the Name of Allah, the Most Gracious, the Most Merciful</h2>

<p>All praise is due to Allah, who created us as human beings and honored us with the role of His representatives on earth. May endless peace and blessings be upon our beloved Prophet Muhammad (peace be upon him), who illuminated our lives with the guidance of faith, wisdom, and goodness.</p>

<p>At Doha International School, we firmly believe that knowledge is a sacred trust from Allah. As His representatives, we are entrusted with nurturing young minds and guiding them through the light of the Divine Book — the Holy Quran — and the teachings of our beloved Prophet Muhammad (peace be upon him). Our mission is to <strong>"Build the Nations with the Light of Divine Knowledge,"</strong> reflecting our mission to nurture a generation grounded in faith, enriched with knowledge, and empowered to lead with integrity.</p>

<blockquote>
"Build the Nations with the Light of Divine Knowledge" — Our mission is to nurture a generation grounded in faith, enriched with knowledge, and empowered to lead with integrity.
</blockquote>

<p>We aspire to develop our students into successful individuals — both in this world and the Hereafter. To achieve this, we emphasize a balanced approach that cultivates the mind, body, and soul. Alongside their academic and spiritual education, our curriculum integrates both traditional and modern disciplines, including English and computer science. For parents seeking a comprehensive education for their children — one that encompasses becoming a Hafiz of the Quran, a knowledgeable Islamic scholar, and a well-rounded individual— <strong>Zaitoon Academy</strong> is an excellent choice.</p>

<h3>Our Academic Approach</h3>

<p>Our students engage in modern learning experiences such as science experiments, problem-solving, public speaking, coding, and AI — ensuring they are equipped with the skills needed for the future while remaining rooted in Islamic values.</p>

<p>Our vision is to also produce confident, and conscientious young Muslims who bring prosperity and positive change to their families, society, and the nation. Humans.</p>

<p>We warmly welcome you to join us in this noble journey of learning, faith, and excellence.</p>

<p><em>May Allah bless our efforts and guide us all on the straight path. Ameen.</em></p>
HTML;
    }
}
