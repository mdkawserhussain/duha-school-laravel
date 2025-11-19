<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing pages (optional - comment out if you want to preserve existing pages)
        // Page::truncate();

        $this->seedAboutUsPages();
        $this->seedAcademicsPages();
        $this->seedFacilitiesPages();
        $this->seedActivitiesPages();
        $this->seedAdmissionsPages();
        $this->seedParentEngagementPages();
        $this->seedFuturePages();
    }

    protected function seedAboutUsPages(): void
    {
        // About Us - Main Category Page
        $aboutUs = Page::updateOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'About Us',
                'page_category' => 'about-us',
                'menu_title' => 'About Us',
                'menu_order' => 2,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Learn about Duha International School\'s mission, vision, and commitment to providing quality Islamic education.',
                'content' => '<p>Welcome to Duha International Islamic School where we build the nation with the light of the divine knowledge.</p><p>Duha International School, located in Chattogram, Bangladesh, is committed to providing quality education rooted in Islamic values. We strive to nurture our students\' academic, moral, and spiritual growth in a supportive and engaging environment.</p><p>We want to create a generation that will not be self-centered but will work for humanity. They will be the treasure on whom everyone will rely and be proud of. Also, they will be exemplary in knowledge, behavior, character and good deeds.</p><p>We all want to see the students of Duha International School as an ideal human being!</p>',
                'meta_title' => 'About Us - Duha International School',
                'meta_description' => 'Learn about Duha International School\'s mission, vision, and commitment to providing quality Islamic education in Chattogram, Bangladesh.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        // Vision, Mission & Core Values
        Page::updateOrCreate(
            ['slug' => 'vision-mission-core-values'],
            [
                'title' => 'Vision, Mission & Core Values',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'Vision, Mission & Core Values',
                'menu_order' => 1,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Our vision, mission, and core values guide everything we do at Duha International School.',
                'content' => '<h2>Our Vision</h2><p>Build the nation with the light of divine knowledge.</p><h2>Our Mission</h2><p>We want to create a generation that will not be self-centered but will work for humanity. They will be the treasure on whom everyone will rely and be proud of. Also, they will be exemplary in knowledge, behavior, character and good deeds.</p><p>We all want to see the students of Duha International School as an ideal human being!</p><h2>Our Core Values</h2><h3>1. Academic Progress</h3><p>We are committed to academic excellence that prepares students for success in both this world and the Hereafter.</p><h3>2. Extra Curriculum Activities</h3><p>We believe in holistic development through diverse extracurricular programs.</p><h3>3. Life Orientation</h3><p>We guide students in developing life skills and personal growth.</p><h3>4. Social and Moral Values</h3><p>We instill Islamic values, ethics, and etiquette to guide behavior, relationships, and responsibilities as compassionate and ethical individuals.</p><h3>5. Life Style Development</h3><p>We promote a balanced lifestyle that integrates Islamic principles with modern living.</p><h3>6. Language Skills</h3><p>Developing multilingual proficiency in Arabic, English, and Bangla, enabling students to connect with Islamic, national, and global communities.</p><h3>7. Quality Academic Education</h3><p>Offering a robust academic curriculum that aligns with the National Curriculum of Bangladesh, and BC providing students with a strong foundation in all core subjects.</p><h3>8. Qualified Teachers</h3><p>A team of experienced and dedicated teachers proficient in both Islamic and general subjects, ensuring that students receive a balanced and high-quality education that meets academic and spiritual needs. We are affiliated with Alokito Teachers got training on the foundation of teaching, classroom management, classroom observation feedback, and computer training.</p>',
                'meta_title' => 'Vision, Mission & Core Values - Duha International School',
                'meta_description' => 'Learn about Duha International School\'s vision, mission, and core values that guide our educational philosophy.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Founder & Director's Message
        Page::updateOrCreate(
            ['slug' => 'founder-director-message'],
            [
                'title' => 'Founder & Director\'s Message',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'Founder & Director\'s Message',
                'menu_order' => 2,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'hero_badge' => 'Hasan Mahmud - Founder & President',
                'excerpt' => 'Message from our Founder & Director on the school\'s commitment to Islamic education.',
                'content' => '<div class="text-center mb-8"><p class="text-lg font-semibold text-aisd-midnight">Hasan Mahmud</p><p class="text-gray-600">Founder & President</p></div><p><strong>In the Name of Allah, the Most Gracious, the Most Merciful.</strong></p><p>All praise is due to Allah, who created us as human beings and honored us with the role of His representatives on earth. May endless peace and blessings be upon our beloved Prophet Muhammad (peace and blessings be upon him), who illuminated our lives with the guidance of truth, wisdom, and goodness.</p><p>At Duha International School, we firmly believe that knowledge is a sacred trust from Allah. He has elevated humankind through intellect and learning, guiding us through the light of the Divine Book — the Qur\'an. Inspired by this eternal guidance, we have built the foundation of our education on the essence of Divine knowledge.</p><p>Our motto, <strong>"Build the Nation with the Light of Divine Knowledge,"</strong> reflects our mission to nurture a generation grounded in faith, enriched with knowledge, and empowered to lead with integrity.</p><p>We aspire to develop our students into successful individuals — both in this world and the Hereafter. To achieve this, we emphasize a balanced approach that cultivates the mind, body, and soul. Alongside strong moral and spiritual education, our curriculum integrates both national and international standards.</p><p>Our students engage in modern learning experiences such as science experiments, problem-solving, public speaking, coding, and AI — ensuring they are equipped with the skills needed for the future while remaining rooted in Islamic values.</p><p>Our vision is to raise productive, confident, and conscientious young Muslims who will bring prosperity and positive change to their families, society, nation, and the entire Ummah.</p><p>We warmly welcome you to join us in this noble journey of learning, faith, and excellence.</p>',
                'meta_title' => 'Founder & Director\'s Message - Duha International School',
                'meta_description' => 'Read the message from Hasan Mahmud, Founder & President of Duha International School.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        // Principal's Message
        Page::updateOrCreate(
            ['slug' => 'principal-message'],
            [
                'title' => 'Principal\'s Message',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'Principal\'s Message',
                'menu_order' => 3,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'hero_badge' => 'Hasina Mohammed - Principal',
                'hero_subtitle' => '"Our foundation is morality. Our goal is leadership."',
                'excerpt' => 'Message from Principal Hasina Mohammed on character-building and leadership development.',
                'content' => '<div class="text-center mb-8"><p class="text-lg font-semibold text-aisd-midnight">Hasina Mohammed</p><p class="text-gray-600">Principal</p></div><p class="text-xl font-bold text-aisd-midnight mb-6 text-center">"Our foundation is morality. Our goal is leadership."</p><p>Welcome to Duha International school--a place where we believe that a truly excellent education is built on a strong foundation of morality and character. While academic achievement is vital, we know that to succeed in the wider world, our students need more than just good grades; they need a well-developed moral compass.</p><p>At DIS, we intentionally weave the teaching of core values into every aspect of school life, from the classroom to the sports field. Our focus is on cultivating traits that matter most: integrity, empathy, respect, responsibility, and perseverance. We are not just teaching students what to think, but how to be thoughtful, ethical, and engaged members of their community.</p><p>We believe that moral education is the bedrock of leadership. By fostering an environment where students learn to make principled decisions, treat others with kindness, and own their actions, we are preparing them to be confident, contributing citizens and the compassionate leaders of tomorrow.</p><p>Choosing a school is choosing a culture. If you seek a supportive community where your child\'s character will be nurtured with the same dedication as their intellectual growth, we invite you to join us. We look forward to partnering with you in this most important endeavor of shaping great minds and good hearts.</p>',
                'meta_title' => 'Principal\'s Message - Duha International School',
                'meta_description' => 'Read the message from Principal Hasina Mohammed on character-building and leadership development at Duha International School.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        // Key Features
        Page::updateOrCreate(
            ['slug' => 'key-features'],
            [
                'title' => 'Key Features',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'Key Features',
                'menu_order' => 4,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Discover the key features that make Duha International School unique in providing quality Islamic education.',
                'content' => '<h2>Key Features of Duha International School</h2><h3>1. Balanced Curriculum</h3><p>Integration of Islamic education with national and international curricula, ensuring students excel both academically and spiritually.</p><h3>2. Qualified Teaching Staff</h3><p>Experienced and dedicated teachers trained in both Islamic and general subjects, affiliated with Alokito Teachers for continuous professional development.</p><h3>3. Modern Facilities</h3><p>Well-equipped classrooms, science laboratories, computer labs, library, prayer rooms, playground, and multimedia facilities.</p><h3>4. Comprehensive Activities</h3><p>Wide range of extracurricular activities including Islamic activities, sports, arts, technology, and community service.</p><h3>5. Multilingual Education</h3><p>Proficiency development in Arabic, English, and Bangla, enabling students to connect with Islamic, national, and global communities.</p><h3>6. Character Building</h3><p>Strong emphasis on Islamic values, ethics, and moral development alongside academic excellence.</p><h3>7. Parent Engagement</h3><p>Regular parent-teacher meetings, workshops, and events fostering strong home-school partnerships.</p><h3>8. Transport Facilities</h3><p>Safe and reliable transport services for students in both near and far areas with AC and Non-AC options.</p>',
                'meta_title' => 'Key Features - Duha International School',
                'meta_description' => 'Discover the key features that make Duha International School unique in providing quality Islamic education.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Our Team (Future)
        Page::updateOrCreate(
            ['slug' => 'our-team'],
            [
                'title' => 'Our Team',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'Our Team',
                'menu_order' => 5,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Meet the dedicated team of educators and staff at Duha International School.',
                'content' => '<p>Our team page is coming soon. We are working on showcasing our dedicated educators and staff members who make Duha International School a place of excellence.</p>',
                'meta_title' => 'Our Team - Duha International School',
                'meta_description' => 'Meet the dedicated team of educators and staff at Duha International School.',
                'is_published' => false, // Future page - not published yet
                'is_featured' => false,
                'published_at' => null,
            ]
        );
    }

    protected function seedAcademicsPages(): void
    {
        // Academics - Main Category Page
        $academics = Page::updateOrCreate(
            ['slug' => 'academics'],
            [
                'title' => 'Academics',
                'page_category' => 'academics',
                'menu_title' => 'Academics',
                'menu_order' => 3,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Explore our comprehensive academic programs including Islamic Curriculum, National Curriculum, and Cambridge International Curriculum.',
                'content' => '<p>At Duha International School, we offer a comprehensive range of academic programs designed to provide students with both Islamic knowledge and modern academic excellence. Our curriculum integrates religious education with national and international standards, ensuring students receive a well-rounded education that prepares them for success in this world and the Hereafter.</p><p>We offer three main curriculum tracks:</p><ul><li><strong>Hifzul Quran Program:</strong> Quran memorization alongside general education</li><li><strong>Islamic Curriculum:</strong> Full Islamic studies with Quranic studies, Arabic, and character building</li><li><strong>National Curriculum (English Version):</strong> Government-recognized curriculum with English medium instruction</li><li><strong>Cambridge and Islamic Curriculum:</strong> Internationally recognized Cambridge curriculum integrated with Islamic studies</li></ul>',
                'meta_title' => 'Academics - Duha International School',
                'meta_description' => 'Explore our comprehensive academic programs including Islamic Curriculum, National Curriculum, and Cambridge International Curriculum.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        // Hifzul Quran Program
        Page::updateOrCreate(
            ['slug' => 'hifzul-quran-program'],
            [
                'title' => 'Hifzul Quran Program',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Hifzul Quran Program',
                'menu_order' => 1,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Quran memorization program designed to balance Hifz with general education, available with both National and Cambridge curricula.',
                'content' => '<p>The Hifzul Quran Program at Duha International School is a foundational component of the Islamic curriculum, allowing students to engage in Quran memorization alongside their general education, whether they are following the National Curriculum or the British (Cambridge) Curriculum. This program is designed to be gradual, enabling students to balance their academic studies with the long-term process of memorizing the Quran.</p><h3>Key Features:</h3><h4>a) Structured Memorization</h4><p>Students follow a carefully organized schedule for memorizing the Quran at a steady, achievable pace. Daily practice sessions ensure retention and gradual progress, allowing students to balance Hifz with their academic subjects.</p><h4>b) Tajweed and Pronunciation</h4><p>Emphasizing precision and beauty in recitation, the program incorporates Tajweed classes to teach Quranic pronunciation rules from the beginning. Regular sessions reinforce proper recitation, ensuring accuracy and fluency.</p><h4>c) Revision and Retention</h4><p>To help students retain their memorized portions, the program includes frequent revision sessions, strengthening long-term memorization and building the confidence needed to recite by heart.</p><h4>d) Spiritual and Moral Development</h4><p>Alongside memorization, students are taught the meanings and significance of Quranic verses. This approach fosters a deep spiritual connection and a moral foundation, guiding students\' character and understanding.</p><p>The Hifzul Quran Program\'s flexible structure ensures that students can progress in their Quranic memorization journey while excelling in their general education, nurturing both their academic and spiritual growth.</p>',
                'meta_title' => 'Hifzul Quran Program - Duha International School',
                'meta_description' => 'Learn about our Hifzul Quran Program that allows students to memorize the Quran while completing their general education.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        // Islamic Curriculum
        Page::updateOrCreate(
            ['slug' => 'islamic-curriculum'],
            [
                'title' => 'Islamic Curriculum',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Islamic Curriculum',
                'menu_order' => 2,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Comprehensive Islamic studies program including Quranic studies, Islamic studies, Arabic language, and character building.',
                'content' => '<p>The Islamic Curriculum at Duha International School integrates religious education into students\' daily lives, providing a strong foundation in Islamic knowledge and values.</p><h3>Quranic Studies</h3><p>Besides Hifz, all students engage in Quranic studies, which include Tajweed, Tafsir (interpretation) based on their age, and selected memorization for those not enrolled in the full Hifz program. This ensures all students gain a foundational knowledge of the Quran.</p><h3>Islamic Studies</h3><p>The curriculum covers Aqeedah (Islamic beliefs), Fiqh (jurisprudence), and the Seerah (life of the Prophet Muhammad), Hadith and Daily Duas. These subjects instill Islamic principles, covering both belief and practice.</p><h3>Arabic Language</h3><p>Recognizing Arabic as the language of the Quran, students receive formal instruction in Arabic. The goal is to enable students to understand and engage with Islamic texts, fostering a connection to the classical language of Islam.</p><h3>Character Building</h3><p>The Islamic curriculum emphasizes character development through the study of Islamic etiquette, morals, and values, teaching students compassion, integrity, and responsibility.</p><h3>Multilingual Development</h3><p>Alongside English and Bangla, students have the opportunity to learn Arabic, which is essential for connecting with the Islamic heritage and understanding the Quranic language.</p>',
                'meta_title' => 'Islamic Curriculum - Duha International School',
                'meta_description' => 'Explore our comprehensive Islamic Curriculum including Quranic studies, Islamic studies, Arabic language, and character building.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // National Curriculum English Version
        Page::updateOrCreate(
            ['slug' => 'national-curriculum-english-version'],
            [
                'title' => 'National Curriculum (English Version)',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'National Curriculum (English Version)',
                'menu_order' => 3,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Government-recognized National Curriculum with English medium instruction, preparing students for SSC exams.',
                'content' => '<p>The National Curriculum (English Version) offers a government-recognized academic path while delivering Instruction in English to ensure language fluency and prepare students for a globalized world.</p><h3>Primary to Secondary Education</h3><p>This curriculum follows the structure set by the National Curriculum of Bangladesh, covering core subjects like Mathematics, English, Bangla, Science, and Social Studies. By using English as the medium of instruction, students gain fluency in an internationally recognized language, while also meeting national academic standards.</p><h3>Secondary School Certificate (SSC) Exams</h3><p>The curriculum prepares students for the SSC exams, a government certification required for higher education within Bangladesh and often recognized in other countries. The exams assess core competencies, including English, Mathematics, Science, and Social Studies.</p><h3>Islamic Studies</h3><p>Recognizing the importance of Islamic education, the school complements the national curriculum with Islamic studies, covering Quranic studies, Fiqh, Seerah, and Aqeedah.</p>',
                'meta_title' => 'National Curriculum (English Version) - Duha International School',
                'meta_description' => 'Learn about our National Curriculum (English Version) that prepares students for SSC exams while maintaining Islamic education.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Cambridge and Islamic Curriculum
        Page::updateOrCreate(
            ['slug' => 'cambridge-islamic-curriculum'],
            [
                'title' => 'Cambridge + Islamic Curriculum',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Cambridge + Islamic Curriculum',
                'menu_order' => 4,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Internationally recognized Cambridge curriculum integrated with comprehensive Islamic studies for global qualifications.',
                'content' => '<p>The Cambridge and Islamic curriculum at Duha International School is designed to prepare students for globally recognized qualifications while grounding them in Islamic knowledge.</p><h3>Cambridge International Examinations</h3><p>The Cambridge curriculum is widely respected worldwide and is designed to develop critical thinking, research skills, and academic rigor. Core subjects include English, Mathematics, Sciences, and Social Studies.</p><h3>Islamic Integration</h3><p>To create a balanced education, the Cambridge curriculum is offered alongside a full Islamic studies program. Students study the Quran, Hadith, Fiqh, and Islamic and religious knowledge, ensuring they gain a strong understanding of both programs.</p><h3>Arabic Language</h3><p>Arabic is included as part of the curriculum, with instruction focusing on developing both conversational and Quranic comprehension skills.</p><h3>Holistic Development</h3><p>This curriculum aims to prepare students not only for academic success but also for a future as knowledgeable, confident, and moral individuals who can contribute meaningfully to both their communities and the global society.</p>',
                'meta_title' => 'Cambridge + Islamic Curriculum - Duha International School',
                'meta_description' => 'Explore our Cambridge International Curriculum integrated with comprehensive Islamic studies for globally recognized qualifications.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );
    }

    protected function seedFacilitiesPages(): void
    {
        // Facilities - Main Category Page
        Page::updateOrCreate(
            ['slug' => 'facilities'],
            [
                'title' => 'Facilities',
                'page_category' => 'facilities',
                'menu_title' => 'Facilities',
                'menu_order' => 4,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Discover our modern facilities designed to support learning, development, and spiritual growth.',
                'content' => '<p>At Duha International School, we provide a range of modern facilities to support our students\' learning, development, and spiritual growth.</p><h3>1. Spacious Classrooms</h3><p>Well-lit and air-conditioned rooms equipped with multimedia facilities for interactive learning.</p><h3>2. Science Laboratories</h3><p>Fully equipped labs for practical experiments in physics, chemistry, and biology.</p><h3>3. Computer Lab</h3><p>State-of-the-art computer facilities with high speed internet access for ICT education and research.</p><h3>4. Library</h3><p>A well-stocked library with a wide range of books, periodicals, and digital resources.</p><h3>5. Prayer Rooms</h3><p>Dedicated spaces for daily prayers, fostering spiritual growth.</p><h3>6. Playground</h3><p>A large outdoor area for sports and physical activities.</p><h3>7. Cafeteria</h3><p>Providing nutritious and healthy meals for students and staff.</p><h3>8. Medical Room</h3><p>A fully equipped first-aid facility with a qualified doctor on duty.</p><h3>9. Multimedia Room</h3><p>For audio-visual presentations and educational screenings.</p><h3>10. Recreation Room</h3><p>A dedicated space for creative ideas and activities.</p><h3>11. Transport Facility</h3><p>We have transport facilities for far area (AC bus), near (Non-AC).</p>',
                'meta_title' => 'Facilities - Duha International School',
                'meta_description' => 'Discover our modern facilities including classrooms, labs, library, prayer rooms, playground, and transport services.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );
    }

    protected function seedActivitiesPages(): void
    {
        // Activities & Programs - Main Category Page
        $activities = Page::updateOrCreate(
            ['slug' => 'activities-programs'],
            [
                'title' => 'Activities & Programs',
                'page_category' => 'activities-programs',
                'menu_title' => 'Activities & Programs',
                'menu_order' => 5,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Explore our diverse range of activities and programs including Islamic activities, academic enrichment, sports, arts, and technology.',
                'content' => '<p>At Duha International School, we offer a comprehensive range of activities and programs designed to develop students\' academic, spiritual, physical, and social skills. Our programs include Islamic activities, academic enrichment, arts and culture, sports, community service, and technology innovation.</p>',
                'meta_title' => 'Activities & Programs - Duha International School',
                'meta_description' => 'Explore our diverse activities and programs including Islamic activities, academic enrichment, sports, arts, and technology.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Islamic Activities
        Page::updateOrCreate(
            ['slug' => 'islamic-activities'],
            [
                'title' => 'Islamic Activities',
                'parent_id' => $activities->id,
                'page_category' => 'activities-programs',
                'menu_title' => 'Islamic Activities',
                'menu_order' => 1,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Our comprehensive Islamic activities program including daily recitation, Tajweed, Tafsir, Hajj simulation, and more.',
                'content' => '<h3>1. Daily Recitation and Memorization</h3><p>Regular sessions for Quran memorization and recitation.</p><h3>2. Tajweed Classes</h3><p>Focus on correct pronunciation and articulation in Quranic recitation.</p><h3>3. Tafsir Classes</h3><p>Understanding the meanings and context of Quranic verses.</p><h3>4. Tajweed Classes in Ramadan</h3><p>Focus on correct pronunciation and articulation in Quranic recitation. (Only women)</p><h3>5. Hajj Simulation</h3><p>Students learn how to perform Hajj.</p><h3>6. Special Prayer</h3><p>Students learn how to pray (Janaza prayer, prayer for rain, Eclipses prayer)</p><h3>7. Prophet Seerah</h3><p>We arrange different programs and activities to continue the teaching of our Prophet to gain a deeper understanding of his character, morals, leadership, and how he responded to various situations with patience, wisdom, and faith.</p><h3>8. Quran Recitation Contests</h3><p>Annual competition showcasing students\' recitation skills.</p><h3>9. Islamic Knowledge Quizzes</h3><p>Contests to deepen knowledge of Islamic teachings.</p><h3>10. Adhan Competitions</h3><p>Competitions focusing on the beauty and accuracy of the call to prayer.</p><h3>11. Prayer Month</h3><p>We focus on teaching the importance of Salah throughout the month. Different workshops are held to promote Discipline and Time Management, Spiritual Connection, Mindfulness and Focus, Cleanliness and Purity to our students.</p><h3>12. Monthly Planner</h3><p>Our students get a monthly planner that records the progress of their daily prayer, Dua, Dhikr, Quran recitation, helping parents, good deeds of the day etc.</p><h3>13. Moral Club as Tarbiyah Session</h3><p>Our students attend Moral club and Tarbiyah sessions regularly, contributing to our students\' Ethical and Moral Values, Self-Discipline, Empathy and Compassion, Positive Attitudes, Personal Growth.</p>',
                'meta_title' => 'Islamic Activities - Duha International School',
                'meta_description' => 'Explore our comprehensive Islamic activities program including daily recitation, Tajweed, Tafsir, Hajj simulation, and more.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Academic Enrichment
        Page::updateOrCreate(
            ['slug' => 'academic-enrichment'],
            [
                'title' => 'Academic Enrichment',
                'parent_id' => $activities->id,
                'page_category' => 'activities-programs',
                'menu_title' => 'Academic Enrichment',
                'menu_order' => 2,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Academic enrichment programs including science fairs, Olympiad preparation, debate clubs, and language proficiency.',
                'content' => '<h3>1. Science Fairs and Exhibitions</h3><p>Hands-on science presentations and experiments.</p><h3>2. Olympiad Preparation</h3><p>Training for local and international Math, English, ICT, and Arabic competitions.</p><h3>3. Debate Club and Competitions</h3><p>Developing critical thinking and public speaking.</p><h3>4. Language Proficiency Programs</h3><p>Our students are trained in English, Arabic, and Bangla simultaneously every day. Our highly qualified educators specialize in teaching English, Arabic, and Bangla with personalized attention. Engaging classes, multimedia resources, and real-life practice help students master each language confidently.</p><h3>5. Book Fair</h3><p>Through multiple book fairs arranged throughout the year, we Develop Literacy Skills, foster a Love for Learning, build research Skills, enhance creativity, and Imagination.</p><h3>6. In-house & Inter-school Competitions</h3><p>Our students showcase their talents in academics, arts, sports, and cultural activities, fostering confidence, teamwork, and leadership. In-house Competitions like Debates & Quiz Contests, Talent Shows & Cultural Festivals, Science & Math Olympiads, Art & Craft Exhibitions etc. And Inter-school Championships like Sports Meets & Athletics Events, Science & Technology Fairs, Literary & Creative Writing Contests etc.</p>',
                'meta_title' => 'Academic Enrichment - Duha International School',
                'meta_description' => 'Explore our academic enrichment programs including science fairs, Olympiad preparation, debate clubs, and language proficiency.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Arts, Culture & Nasheed
        Page::updateOrCreate(
            ['slug' => 'arts-culture-nasheed'],
            [
                'title' => 'Arts, Culture & Nasheed',
                'parent_id' => $activities->id,
                'page_category' => 'activities-programs',
                'menu_title' => 'Arts, Culture & Nasheed',
                'menu_order' => 3,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Arts and culture programs including art and craft competitions, Nasheed groups, and Islamic-themed drama.',
                'content' => '<h3>1. Art and Craft</h3><p>Various competitions in art and craft.</p><h3>2. Nasheed Group</h3><p>Group singing of Islamic songs.</p><h3>3. Islamic-Themed Drama</h3><p>Theatrical performances rooted in Islamic stories and values.</p>',
                'meta_title' => 'Arts, Culture & Nasheed - Duha International School',
                'meta_description' => 'Explore our arts and culture programs including art and craft competitions, Nasheed groups, and Islamic-themed drama.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Sports & Physical Education
        Page::updateOrCreate(
            ['slug' => 'sports-physical-education'],
            [
                'title' => 'Sports & Physical Education',
                'parent_id' => $activities->id,
                'page_category' => 'activities-programs',
                'menu_title' => 'Sports & Physical Education',
                'menu_order' => 4,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Comprehensive sports and physical education program including indoor/outdoor sports, martial arts, swimming, and more.',
                'content' => '<h3>1. Indoor Games</h3><p>Activities such as table tennis, and carrom.</p><h3>2. Outdoor Sports</h3><p>Engaging in cricket, football, badminton, and basketball.</p><h3>3. Annual Sports Day</h3><p>Celebrating sportsmanship and physical activity with all students.</p><h3>4. Martial Arts</h3><p>For teaching students defence and physical fitness, we have a weekly martial arts program.</p><h3>5. Swimming Program (Affiliated with Radisson Blu)</h3><p>Weekly swimming classes for the student</p><h3>6. Physical Development</h3><p>Regular check-up of gross motor and fine motor, balance, body weight and height check-up, and synchronization.</p><h3>7. Healthy Diet</h3><p>Maintaining and following healthy food diet every day.</p><h3>8. Refreshment Day</h3><p>Students enjoys different activities like splash day, water games and indoor activities.</p><h3>9. Lifestyle: Arts and Culture</h3><p>Our dedicated programs and supportive environment empower students to excel academically and personally through Holistic Education, Nutrition education, fitness programs, and mental health support, Life skills, leadership training, and extracurricular activities, Volunteering and social projects fostering compassion and social responsibility. Modern classrooms and technology to inspire creativity and curiosity.</p>',
                'meta_title' => 'Sports & Physical Education - Duha International School',
                'meta_description' => 'Explore our comprehensive sports and physical education program including indoor/outdoor sports, martial arts, swimming, and more.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Life Skills & Community Service
        Page::updateOrCreate(
            ['slug' => 'life-skills-community-service'],
            [
                'title' => 'Life Skills & Community Service',
                'parent_id' => $activities->id,
                'page_category' => 'activities-programs',
                'menu_title' => 'Life Skills & Community Service',
                'menu_order' => 5,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Life skills development and community service programs including public speaking, leadership, first aid, charity drives, and environmental campaigns.',
                'content' => '<h2>Life Skills Development</h2><h3>1. Public Speaking Workshops</h3><p>Building confidence in communication.</p><h3>2. Leadership Programs</h3><p>Training sessions to develop leadership qualities.</p><h3>3. First Aid Training</h3><p>Basic safety and emergency response skills.</p><h3>4. Fire Extinguisher Demonstrative</h3><p>We believe in empowering our students with essential life skills. That\'s why we host engaging Fire Extinguisher Demonstrations regularly! Knowing how to handle fire emergencies can save lives. Our demonstrations ensure students are not just learners but prepared protectors in their community. We offer hands-on experience with proper fire extinguisher usage, Safety awareness and emergency preparedness, Interactive sessions led by safety experts, Building confidence and responsibility among students.</p><h3>5. Basic Life Skills like Cooking</h3><p>Our comprehensive curriculum is designed to equip students with vital life skills that set them up for success in the real world. We include Communication Skills, Financial Literacy, Critical Thinking & Problem Solving, Time Management & Organization, Cooking, Healthy Lifestyle & Well-being, and Teamwork & Leadership.</p><h3>6. Temporary Shop</h3><p>We organize an exciting Temporary Shop, where our students get the chance to showcase their talents and entrepreneurial skills. They get the opportunity of Hands-on experience in running a business, Opportunities to sell homemade crafts, snacks, and more, Encouragement of teamwork and innovation, and Safe and supervised environment for all students.</p><h2>Community Service</h2><h3>1. Charity Drives</h3><p>Collecting and donating to those in need. (Iftar distribution, Clothes distribution, Food sharing, and donating to the less fortunate)</p><h3>2. Environmental Campaigns</h3><p>Activities promoting ecological responsibility. (construction of broken houses in any natural disaster, Labor day- distributions of essentials things to our community)</p><h3>3. Community Clean-Ups</h3><p>Initiatives to keep local surrounding clean and green.</p><h3>4. International Contribution</h3><p>Initiatives to keep the local surroundings clean and green.</p>',
                'meta_title' => 'Life Skills & Community Service - Duha International School',
                'meta_description' => 'Explore our life skills development and community service programs including public speaking, leadership, first aid, charity drives, and environmental campaigns.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Technology & Innovation
        Page::updateOrCreate(
            ['slug' => 'technology-innovation'],
            [
                'title' => 'Technology & Innovation',
                'parent_id' => $activities->id,
                'page_category' => 'activities-programs',
                'menu_title' => 'Technology & Innovation',
                'menu_order' => 6,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Technology and innovation programs including annual tech fairs and digital media workshops.',
                'content' => '<h3>1. Annual Tech Fair</h3><p>Showcasing student projects in robotics, coding, and tech.</p><h3>2. Digital Media Workshops</h3><p>Training in video editing, graphic design, and digital content creation.</p>',
                'meta_title' => 'Technology & Innovation - Duha International School',
                'meta_description' => 'Explore our technology and innovation programs including annual tech fairs and digital media workshops.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Annual Cultural Program
        Page::updateOrCreate(
            ['slug' => 'annual-cultural-program'],
            [
                'title' => 'Annual Cultural Program',
                'parent_id' => $activities->id,
                'page_category' => 'activities-programs',
                'menu_title' => 'Annual Cultural Program',
                'menu_order' => 7,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Our vibrant annual cultural programs showcasing Quran recitations, Nasheed performances, Islamic dramas, and more.',
                'content' => '<p>At DIS, we believe in nurturing not only academic excellence but also fostering a deep connection to our Islamic heritage and culture. Our vibrant cultural programs provide a platform for students to express their faith, creativity, and talents. faith, and community!</p><h3>Our Cultural Programs Include:</h3><ul><li>Beautiful Quran Recitations</li><li>Soulful Nasheed Performances</li><li>Heartfelt Dua Recitations</li><li>Chanting of Surahs and Islamic Verses</li><li>Engaging Dramas and Skits</li><li>Joyful Songs and Cultural Presentations</li><li>Interactive Activities that Celebrate Our Heritage</li><li>And many more!!</li></ul><p>These events are designed to inspire confidence, teamwork, and a love for our deen, while allowing students to showcase their unique talents in a supportive environment.</p><p class="text-center text-xl font-bold text-aisd-midnight mt-8">Join us at Duha International School, where education meets culture, faith, and community!</p>',
                'meta_title' => 'Annual Cultural Program - Duha International School',
                'meta_description' => 'Discover our vibrant annual cultural programs showcasing Quran recitations, Nasheed performances, Islamic dramas, and more.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );
    }

    protected function seedAdmissionsPages(): void
    {
        // Admissions - Main Category Page
        $admissions = Page::updateOrCreate(
            ['slug' => 'admissions'],
            [
                'title' => 'Admissions',
                'page_category' => 'admissions',
                'menu_title' => 'Admissions',
                'menu_order' => 6,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Learn about our admissions process, fee structures, class timings, and grade requirements for enrollment.',
                'content' => '<p>We welcome applications from families who share our vision of education. Join us at Duha International School for a balanced education that nurtures both faith and academic excellence!</p><p>Our admissions process is designed to be thorough yet welcoming, ensuring that both the school and the family are aligned in their educational goals and values.</p>',
                'meta_title' => 'Admissions - Duha International School',
                'meta_description' => 'Learn about our admissions process, fee structures, class timings, and grade requirements for enrollment at Duha International School.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        // Admission Procedure
        Page::updateOrCreate(
            ['slug' => 'admission-procedure'],
            [
                'title' => 'Admission Procedure',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Admission Procedure',
                'menu_order' => 1,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Step-by-step guide to our admissions process including information gathering, application submission, assessment, and interview.',
                'content' => '<p>We welcome applications from families who share our vision of education. The admissions process includes:</p><h3>1. Information Gathering</h3><p>Interested families can obtain detailed information about the admissions process by visiting our Facebook page, website or contacting the Admissions Office directly. Parents are encouraged to provide key details such as their child\'s name, age, and previous school attended to facilitate the process.</p><h3>2. Application Submission</h3><p>Families can collect the admission form from the school. Once filled out, the completed application form must be submitted to the Admissions Office along with any required documents, such as admission confirmation, previous academic records and identification.</p><h3>3. Entrance Assessment</h3><p>After submitting the application, students will be invited to participate in an entrance assessment. This assessment evaluates their academic readiness and helps us understand their strengths and areas for improvement.</p><h3>4. Family Interview</h3><p>Following the entrance assessment, families will have a personal interview with school administration. This meeting allows parents to learn more about our educational philosophy and share their aspirations for their child\'s education, and understand our school rules and regulations to ensure alignment with their values and expectations.</p><p class="text-center text-xl font-bold text-aisd-midnight mt-8">Join us at Duha International School for a balanced education that nurtures both faith and academic excellence!</p>',
                'meta_title' => 'Admission Procedure - Duha International School',
                'meta_description' => 'Learn about our step-by-step admissions process including information gathering, application submission, assessment, and interview.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Fee Structure – National Curriculum
        Page::updateOrCreate(
            ['slug' => 'fee-structure-national-curriculum'],
            [
                'title' => 'Fee Structure – National Curriculum',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Fee Structure – National Curriculum',
                'menu_order' => 2,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Complete fee structure for National Curriculum (English Version) including General and Islamic Curriculum options.',
                'content' => '<h2>National Curriculum English Version (General and Islamic Curriculum)</h2><h3>Preschool</h3><h4>Pre-play (3 years) & Play (4 years)</h4><ul><li>Admission form: 500/-</li><li>Admission Fee - Free</li><li>Session fee (Including books) - 15,000/- (Yearly)</li><li>Monthly Tuition Fee - 3,000/-</li></ul><h3>Nursery (5 years) & KG (6 years)</h3><ul><li>Admission form: 500/-</li><li>Admission Fee - 20,000/- (Once)</li><li>Session fee - 15,000/- (Yearly)</li><li>Monthly Tuition Fee (General Curriculum) - 3,000/-</li><li>Monthly Tuition Fee (Islamic Curriculum) - 4,000/-</li><li>Convocation Fee (KG only) - 4,000/-</li><li>Books and notebooks cost - 5,000/- approx</li><li>Stationary and other supplies - 3,000/- approx</li><li>Uniform - From Belbond Tailors, Rabia Tailors</li><li>Exam Fee - 2,000/- (Yearly for two terms)</li><li>Other program cost - 3,000/- (Yearly)</li></ul><h3>Primary - Grade 1 and 2 (6,7 years) & Grade 3 and 4 (8,9 years)</h3><ul><li>Admission form: 500/-</li><li>Admission Fee - 20,000/- (Once)</li><li>Session fee - 15,000/- (Yearly)</li><li>Monthly Tuition Fee (General Curriculum) - 3,500/-</li><li>Monthly Tuition Fee (Islamic Curriculum) - 4,500/-</li><li>Books and notebooks cost - 6,000/- approx</li><li>Stationary and other supplies - 3,000/- approx</li><li>Uniform - From Belbond Tailors, Rabia Tailors</li><li>Exam Fee - 2,000/- (Yearly for two terms)</li><li>Other program cost - 3,000/- (Yearly)</li></ul><h3>Secondary - Grade 5 (10 years)</h3><ul><li>Admission form: 500/-</li><li>Admission Fee - 20,000/- (Once)</li><li>Session fee - 15,000/- (Yearly)</li><li>Uniform - From Belbond Tailors, Rabia Tailors</li><li>Exam Fee - 2,000/- (Yearly for two terms)</li><li>Other program cost - 3,000/- (Yearly)</li></ul><h3>Grade 6 and 7 (11, 12 years)</h3><ul><li>Admission form: 500/-</li><li>Admission Fee - 20,000/- (Once)</li><li>Session fee - 15,000/- (Yearly)</li><li>Monthly Tuition Fee (General Curriculum) - 4,000/- to 4,200/-</li><li>Monthly Tuition Fee (Islamic Curriculum) - 5,000/- to 5,200/-</li><li>Convocation Fee - 4,000/-</li><li>Books and notebooks cost - 5,000/- to 6,000/- approx</li><li>Stationary and other supplies - 3,000/- approx</li><li>Uniform - From Belbond Tailors, Rabia Tailors</li><li>Exam Fee - 2,000/- (Yearly for two terms)</li><li>Other program cost - 3,000/- (Yearly)</li></ul><h3>Grade 8 (13, 14 years) & Grade 9 (14, 15 years)</h3><ul><li>Admission form: 500/-</li><li>Admission Fee - 20,000/- (Once)</li><li>Session fee - 15,000/- (Yearly)</li><li>Monthly Tuition Fee (General Curriculum) - 4,500/- to 5,000/-</li><li>Monthly Tuition Fee (Islamic Curriculum) - 5,500/-</li><li>Books and notebooks cost - 5,000/- approx</li><li>Stationary and other supplies - 3,000/- approx</li><li>Uniform - From Belbond Tailors, Rabia Tailors</li><li>Exam Fee - 2,000/- (Yearly for two terms)</li><li>Other program cost - 3,000/- (Yearly)</li></ul>',
                'meta_title' => 'Fee Structure – National Curriculum - Duha International School',
                'meta_description' => 'Complete fee structure for National Curriculum (English Version) including General and Islamic Curriculum options for all grades.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Fee Structure – Cambridge Curriculum
        Page::updateOrCreate(
            ['slug' => 'fee-structure-cambridge-curriculum'],
            [
                'title' => 'Fee Structure – Cambridge Curriculum',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Fee Structure – Cambridge Curriculum',
                'menu_order' => 3,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Complete fee structure for Cambridge and Islamic Curriculum including EYFS, KS-1, and KS-2.',
                'content' => '<h2>Cambridge and Islamic Curriculum</h2><h3>Early Year Foundation Stage (EYFS)</h3><h4>EYFS Day care (2 years to 3.5 years)</h4><ul><li>Admission form: 1000/-</li><li>Admission Fee - Free</li><li>Session fee (Including stationary) - 20,000/- (Yearly)</li><li>Monthly Tuition Fee - 7,000/-</li></ul><h4>PrePlay (2.5 years to 3.5 years)</h4><ul><li>Admission form: 1000/-</li><li>Admission Fee - Free</li><li>Session fee (Including stationary) - 20,000/- (Yearly)</li><li>Monthly Tuition Fee - 5,000/-</li></ul><h4>Play (3.5 years to 4.5 years)</h4><ul><li>Admission form: 1000/-</li><li>Admission Fee - 20,000/- (Once)</li><li>Session fee - 20,000/- (Yearly)</li><li>Monthly Tuition Fee - 5,500/-</li><li>Books and notebooks cost - 10,000/- approx</li><li>Stationary and other supplies - 5,000/- approx</li><li>Uniform - From Belbond Tailors, Rabia Tailors</li><li>Exam Fee - 3,000/- (Yearly for three terms)</li><li>Other program cost - 3,000/- (Yearly)</li></ul><h3>Nursery (4.5 years to 5.5 years) & Reception (5.5 years to 6.5 years)</h3><ul><li>Admission form: 1000/-</li><li>Admission Fee - 20,000/- (Once)</li><li>Session fee - 20,000/- (Yearly)</li><li>Monthly Tuition Fee - 6,000/-</li><li>Convocation Fee (Reception only) - 5,000/-</li><li>Books and notebooks cost - 10,000/- approx</li><li>Stationary and other supplies - 5,000/- approx</li><li>Uniform - From Belbond Tailors, Rabia Tailors</li><li>Exam Fee - 3,000/- (Yearly for three terms)</li><li>Other program cost - 3,000/- (Yearly)</li></ul><h3>KS-1 & KS-2 - Year 1 to Year 6 (6.5 years to 12.5 years)</h3><ul><li>Admission form: 1000/-</li><li>Admission Fee - 20,000/- (Once)</li><li>Session fee - 20,000/- (Yearly)</li><li>Monthly Tuition Fee - 6,500/- to 7,000/-</li><li>Books and notebooks cost - 15,000/- approx</li><li>Stationary and other supplies - 5,000/- approx</li><li>Uniform - From Belbond Tailors, Rabia Tailors</li><li>Exam Fee - 3,000/- (Yearly for three terms)</li><li>Other program cost - 3,000/- (Yearly)</li></ul>',
                'meta_title' => 'Fee Structure – Cambridge Curriculum - Duha International School',
                'meta_description' => 'Complete fee structure for Cambridge and Islamic Curriculum including EYFS, KS-1, and KS-2 for all year levels.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Class Timings
        Page::updateOrCreate(
            ['slug' => 'class-timings'],
            [
                'title' => 'Class Timings',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Class Timings',
                'menu_order' => 4,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Complete class timing schedule for National and Islamic Curriculum, and Cambridge and Islamic Curriculum.',
                'content' => '<h2>National and Islamic Curriculum Timing</h2><table class="w-full border-collapse border border-gray-300 mt-4 mb-8"><thead><tr class="bg-gray-100"><th class="border border-gray-300 px-4 py-2">Class</th><th class="border border-gray-300 px-4 py-2">Shift</th><th class="border border-gray-300 px-4 py-2">Timing</th><th class="border border-gray-300 px-4 py-2">Duration</th></tr></thead><tbody><tr><td class="border border-gray-300 px-4 py-2">Pre-Play</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">8:00am - 8:40am</td><td class="border border-gray-300 px-4 py-2">2 hrs</td></tr><tr><td class="border border-gray-300 px-4 py-2">Play</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">8:00am - 10:00am</td><td class="border border-gray-300 px-4 py-2">3 hrs</td></tr><tr><td class="border border-gray-300 px-4 py-2">Nursery</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">8:00am - 03:00pm</td><td class="border border-gray-300 px-4 py-2">7 hrs</td></tr><tr><td class="border border-gray-300 px-4 py-2">KG</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">8:00am - 11:00am / 10:00am - 1:30am</td><td class="border border-gray-300 px-4 py-2">3 hrs / 3 hrs 30 min</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 1-2</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">8:00am - 11:40am</td><td class="border border-gray-300 px-4 py-2">3 hrs 40 min</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 3-5</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">9:00am - 1:30am / 8:00am - 1:00pm</td><td class="border border-gray-300 px-4 py-2">4 hrs 30 min</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 6-8</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">8:40am - 1:40pm / 8:40am - 3:00pm</td><td class="border border-gray-300 px-4 py-2">5 hrs / 6 hrs 20 min</td></tr></tbody></table><h2>Cambridge and Islamic Curriculum Timing</h2><table class="w-full border-collapse border border-gray-300 mt-4 mb-8"><thead><tr class="bg-gray-100"><th class="border border-gray-300 px-4 py-2">Class</th><th class="border border-gray-300 px-4 py-2">Shift</th><th class="border border-gray-300 px-4 py-2">Timing</th><th class="border border-gray-300 px-4 py-2">Duration</th></tr></thead><tbody><tr><td class="border border-gray-300 px-4 py-2">EYFS Day Care</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">8:00am - 11:00am</td><td class="border border-gray-300 px-4 py-2">3 hrs</td></tr><tr><td class="border border-gray-300 px-4 py-2">PrePlay</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">8:00am - 10:00pm</td><td class="border border-gray-300 px-4 py-2">2 hrs</td></tr><tr><td class="border border-gray-300 px-4 py-2">Play</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">10:00am - 1:30am</td><td class="border border-gray-300 px-4 py-2">3 hrs 30 min</td></tr><tr><td class="border border-gray-300 px-4 py-2">Nursery</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">10:00am - 1:30pm</td><td class="border border-gray-300 px-4 py-2">3 hrs 30 min</td></tr><tr><td class="border border-gray-300 px-4 py-2">Reception</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">8:00am - 11:40am</td><td class="border border-gray-300 px-4 py-2">3 hrs 40 min</td></tr><tr><td class="border border-gray-300 px-4 py-2">Year 1-2</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">9:00am - 1:30am / 8:00am - 1:00pm</td><td class="border border-gray-300 px-4 py-2">4 hrs 30 min</td></tr><tr><td class="border border-gray-300 px-4 py-2">Year 3-6</td><td class="border border-gray-300 px-4 py-2">Morning</td><td class="border border-gray-300 px-4 py-2">8:40am - 1:40pm / 8:40am - 3:00pm</td><td class="border border-gray-300 px-4 py-2">5 hrs / 6 hrs 20 min</td></tr></tbody></table>',
                'meta_title' => 'Class Timings - Duha International School',
                'meta_description' => 'Complete class timing schedule for National and Islamic Curriculum, and Cambridge and Islamic Curriculum.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Grades & Subjects Overview
        Page::updateOrCreate(
            ['slug' => 'grades-subjects'],
            [
                'title' => 'Grades & Subjects Overview',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Grades & Subjects Overview',
                'menu_order' => 5,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Complete overview of subjects offered at each grade level from Pre-Play through Secondary.',
                'content' => '<h2>Pre-Play (3 years)</h2><h3>Basic Subjects</h3><ul><li>Fine Motor Activities</li><li>Islamiat Life Style</li><li>Development</li><li>Viva</li><li>Gross Motor Activities</li><li>English</li><li>Sensory Tactile Activities</li><li>Bangla</li><li>Basic Knowledge and Learning Skills</li><li>Math - English Numbers</li><li>Rhymes and Conversation</li></ul><h3>Co-Subjects</h3><ul><li>Art & Craft</li><li>Social and Emotional Skills</li></ul><h2>Play (4 years)</h2><h3>Basic Subjects</h3><ul><li>English</li><li>Bangla</li><li>Mathematics (English & Bangla Number)</li><li>Basic Skills and Concept</li><li>Rhymes and Conversation</li></ul><h3>Co-Subjects</h3><ul><li>Art & Craft</li></ul><h2>Nursery (5 years)</h2><h3>Basic Subjects</h3><ul><li>English</li><li>Bangla</li><li>Learning Skills</li><li>Mathematics (English & Bangla Number)</li></ul><h3>Co-Subjects</h3><ul><li>Social Studies and General Knowledge</li><li>Arts and Crafts</li><li>Arabic</li><li>Rhymes and Conversation</li><li>Science</li></ul><h2>Kindergarten (6 years)</h2><h3>Basic Subjects</h3><ul><li>English</li><li>Bangla</li><li>Mathematics (English & Bangla Number)</li><li>Learning Skills</li><li>Science</li></ul><h3>Co-Subjects</h3><ul><li>Social Studies and General Knowledge</li><li>Arts and Crafts</li><li>Arabic</li><li>Rhymes and Conversation</li></ul><h2>Grade 1 and 2 (6,7 years)</h2><h3>Basic Subjects</h3><ul><li>Bangla</li><li>English</li><li>Mathematics</li><li>Science</li></ul><h3>Co-Subjects</h3><ul><li>BGS (Bangladesh and Global Studies)</li><li>Arts and Crafts</li><li>ICT</li><li>Arabic</li></ul><h2>Grade 3, 4 and 5 (8-10 years)</h2><h3>Basic Subjects</h3><ul><li>Bangla</li><li>English</li><li>Mathematics</li><li>Science</li></ul><h3>Co-Subjects</h3><ul><li>BGS</li><li>Arts and Crafts</li><li>IME (Islamic Moral Education)</li><li>ICT</li><li>Arabic</li></ul><h2>Grade 6, 7 and 8 (11-14 years) - Islamic Curriculum</h2><h3>Basic Subjects</h3><ul><li>Bangla</li><li>Arabic Handwriting</li><li>English</li><li>Sahih Quran Shikhha</li><li>History and Social Science</li><li>Hifz</li><li>Islamic Studies</li><li>Arts and Culture</li><li>Digital Technology</li><li>Life and Livelihood</li><li>Well Being</li><li>Arabic</li><li>Arabic Language</li><li>Science</li><li>Quranic Studies</li><li>Mathematics</li></ul>',
                'meta_title' => 'Grades & Subjects Overview - Duha International School',
                'meta_description' => 'Complete overview of subjects offered at each grade level from Pre-Play through Secondary at Duha International School.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Transport Fees & Policy
        Page::updateOrCreate(
            ['slug' => 'transport-fees-policy'],
            [
                'title' => 'Transport Fees & Policy',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Transport Fees & Policy',
                'menu_order' => 6,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Transport service fees and policy for students including AC and Non-AC options for near and far areas.',
                'content' => '<h3>Transport Fees</h3><ul><li><strong>One Shift:</strong> 1,500/-</li><li><strong>Near area - Non AC:</strong> 3,000/-</li><li><strong>Both Shift (Morning and evening):</strong> 3,000/-</li><li><strong>Far area - AC:</strong> 4,000/-</li></ul><p>We have transport facilities for far area (AC bus) and near area (Non-AC).</p>',
                'meta_title' => 'Transport Fees & Policy - Duha International School',
                'meta_description' => 'Transport service fees and policy for students including AC and Non-AC options for near and far areas.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Download Admission Form (PDF)
        Page::updateOrCreate(
            ['slug' => 'download-admission-form'],
            [
                'title' => 'Download Admission Form (PDF)',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Download Admission Form (PDF)',
                'menu_order' => 7,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Download the admission form in PDF format to begin your application process.',
                'content' => '<p>Please download the admission form from the link below. Once completed, submit it to our Admissions Office along with the required documents.</p><p><a href="/storage/admission-form.pdf" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors duration-200" download>Download Admission Form (PDF)</a></p><p class="mt-4 text-gray-600">If you have any questions about the admission process, please contact our Admissions Office.</p>',
                'meta_title' => 'Download Admission Form (PDF) - Duha International School',
                'meta_description' => 'Download the admission form in PDF format to begin your application process at Duha International School.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );
    }

    protected function seedParentEngagementPages(): void
    {
        // Parent Engagement - Main Category Page
        Page::updateOrCreate(
            ['slug' => 'parent-engagement'],
            [
                'title' => 'Parent Engagement',
                'page_category' => 'parent-engagement',
                'menu_title' => 'Parent Engagement',
                'menu_order' => 7,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Learn about our parent engagement programs including parent-teacher meetings, workshops, and special events.',
                'content' => '<p>At Duha International School, we believe that a strong partnership between home and school is essential for student success. Our parent engagement programs are designed to foster communication, collaboration, and shared responsibility for our students\' development.</p><h3>1. Regular Parent-Teacher Meetings</h3><p>Routine meetings to discuss students\' progress and areas for improvement.</p><h3>2. Parenting Workshops with an Islamic Perspective</h3><p>Workshops that offer guidance on parenting within an Islamic framework, addressing topics such as character building, spiritual development, and nurturing positive habits at home conducted by special, renowned scholars and doctors.</p><h3>3. Parent-Student Events</h3><p>Special events that bring parents and students together, such as a Pitha Festival celebrating traditional foods, Temporary shop Days where students showcase and sell handmade goods, and Tea Time with the Principal and Director, offering a relaxed space for open dialogue and feedback on school matters.</p><p>These activities strengthen the home-school partnership, promoting a supportive community for students\' development.</p>',
                'meta_title' => 'Parent Engagement - Duha International School',
                'meta_description' => 'Learn about our parent engagement programs including parent-teacher meetings, workshops, and special events.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );
    }

    protected function seedFuturePages(): void
    {
        // Gallery (Future - photos/videos)
        // Published with placeholder content so it appears in menu structure
        Page::updateOrCreate(
            ['slug' => 'gallery'],
            [
                'title' => 'Gallery',
                'page_category' => null, // No category - standalone page
                'menu_title' => 'Gallery',
                'menu_order' => 8,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'View photos and videos from school events, activities, and daily life at Duha International School.',
                'content' => '<div class="text-center py-12"><h2 class="text-3xl font-bold text-aisd-midnight mb-4">Gallery Coming Soon</h2><p class="text-gray-600 text-lg">We are working on showcasing photos and videos from school events, activities, and daily life at Duha International School.</p><p class="text-gray-500 mt-4">This page will be updated soon with our photo and video gallery.</p></div>',
                'meta_title' => 'Gallery - Duha International School',
                'meta_description' => 'View photos and videos from school events, activities, and daily life at Duha International School.',
                'is_published' => true, // Published to show in menu (with placeholder content)
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Blog / News (Future)
        // Published with placeholder content so it appears in menu structure
        Page::updateOrCreate(
            ['slug' => 'blog-news'],
            [
                'title' => 'Blog / News',
                'page_category' => null, // No category - standalone page
                'menu_title' => 'Blog / News',
                'menu_order' => 9,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Stay updated with the latest news, articles, and updates from Duha International School.',
                'content' => '<div class="text-center py-12"><h2 class="text-3xl font-bold text-aisd-midnight mb-4">Blog / News Coming Soon</h2><p class="text-gray-600 text-lg">We are working on our blog and news section to share the latest news, articles, and updates from Duha International School.</p><p class="text-gray-500 mt-4">This page will be updated soon with blog posts and news articles.</p></div>',
                'meta_title' => 'Blog / News - Duha International School',
                'meta_description' => 'Stay updated with the latest news, articles, and updates from Duha International School.',
                'is_published' => true, // Published to show in menu (with placeholder content)
                'is_featured' => false,
                'published_at' => now(),
            ]
        );
    }
}
