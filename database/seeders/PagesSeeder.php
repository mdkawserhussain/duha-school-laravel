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
        $this->seedStandalonePages();
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

        // Chairman Message (Alias for Founder-Director Message)
        Page::updateOrCreate(
            ['slug' => 'chairman-message'],
            [
                'title' => 'Chairman\'s Message',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'Chairman Message',
                'menu_order' => 2,
                'show_in_menu' => false, // Hidden since founder-director-message already exists
                'menu_section' => 'main',
                'hero_badge' => 'Hasan Mahmud - Founder & President',
                'excerpt' => 'Message from our Founder & President on the school\'s commitment to Islamic education.',
                'content' => '<div class="text-center mb-8"><p class="text-lg font-semibold text-aisd-midnight">Hasan Mahmud</p><p class="text-gray-600">Founder & President</p></div><p><strong>In the Name of Allah, the Most Gracious, the Most Merciful.</strong></p><p>All praise is due to Allah, who created us as human beings and honored us with the role of His representatives on earth. May endless peace and blessings be upon our beloved Prophet Muhammad (peace and blessings be upon him), who illuminated our lives with the guidance of truth, wisdom, and goodness.</p><p>At Duha International School, we firmly believe that knowledge is a sacred trust from Allah. He has elevated humankind through intellect and learning, guiding us through the light of the Divine Book — the Qur\'an. Inspired by this eternal guidance, we have built the foundation of our education on the essence of Divine knowledge.</p><p>Our motto, <strong>"Build the Nation with the Light of Divine Knowledge,"</strong> reflects our mission to nurture a generation grounded in faith, enriched with knowledge, and empowered to lead with integrity.</p><p>We aspire to develop our students into successful individuals — both in this world and the Hereafter. To achieve this, we emphasize a balanced approach that cultivates the mind, body, and soul. Alongside strong moral and spiritual education, our curriculum integrates both national and international standards.</p><p>Our students engage in modern learning experiences such as science experiments, problem-solving, public speaking, coding, and AI — ensuring they are equipped with the skills needed for the future while remaining rooted in Islamic values.</p><p>Our vision is to raise productive, confident, and conscientious young Muslims who will bring prosperity and positive change to their families, society, nation, and the entire Ummah.</p><p>We warmly welcome you to join us in this noble journey of learning, faith, and excellence.</p>',
                'meta_title' => 'Chairman\'s Message - Duha International School',
                'meta_description' => 'Read the message from Hasan Mahmud, Founder & President of Duha International School.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        // Governing Body
        Page::updateOrCreate(
            ['slug' => 'governing-body'],
            [
                'title' => 'Governing Body',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'Governing Body',
                'menu_order' => 6,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Meet the governing body members who guide Duha International School\'s strategic direction and policies.',
                'content' => '<h2>Governing Body</h2><p>The Governing Body of Duha International School comprises dedicated individuals who bring diverse expertise and a shared commitment to providing quality Islamic education. Our board members guide the school\'s strategic direction, ensuring that we remain true to our mission and vision.</p><h3>Our Responsibilities</h3><ul><li><strong>Strategic Planning:</strong> Setting long-term goals and direction for the school</li><li><strong>Policy Development:</strong> Establishing policies that align with Islamic values and educational excellence</li><li><strong>Financial Oversight:</strong> Ensuring responsible stewardship of school resources</li><li><strong>Quality Assurance:</strong> Monitoring academic standards and student welfare</li><li><strong>Community Engagement:</strong> Building partnerships with parents and the wider community</li></ul><h3>Governance Structure</h3><p>Our governing body meets regularly to review school performance, approve major decisions, and provide guidance to the school leadership. We are committed to transparency, accountability, and continuous improvement in all aspects of school management.</p><p class="mt-6 text-gray-600">For inquiries related to governance matters, please contact the school administration office.</p>',
                'meta_title' => 'Governing Body - Duha International School',
                'meta_description' => 'Meet the governing body members who guide Duha International School\'s strategic direction and policies.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Academic Committee
        Page::updateOrCreate(
            ['slug' => 'academic-committee'],
            [
                'title' => 'Academic Committee',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'Academic Committee',
                'menu_order' => 7,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Learn about our Academic Committee that ensures curriculum quality and academic excellence.',
                'content' => '<h2>Academic Committee</h2><p>The Academic Committee at Duha International School is responsible for maintaining and enhancing the quality of education across all curricula offered at our institution. Our committee comprises experienced educators, curriculum specialists, and academic leaders.</p><h3>Key Responsibilities</h3><ul><li><strong>Curriculum Development:</strong> Ensuring our curricula meet national and international standards while integrating Islamic education</li><li><strong>Academic Standards:</strong> Maintaining high academic standards across all grade levels</li><li><strong>Teacher Development:</strong> Coordinating professional development programs for teaching staff</li><li><strong>Assessment Design:</strong> Developing fair and comprehensive assessment systems</li><li><strong>Educational Innovation:</strong> Introducing modern teaching methodologies and technologies</li><li><strong>Student Progress Monitoring:</strong> Tracking and supporting student academic achievement</li></ul><h3>Areas of Focus</h3><h4>Islamic Curriculum Integration</h4><p>Ensuring seamless integration of Islamic studies with academic subjects, maintaining balance between faith-based and modern education.</p><h4>National & Cambridge Curricula</h4><p>Overseeing the implementation of both National Curriculum (English Version) and Cambridge International Curriculum, ensuring students receive globally recognized education.</p><h4>Hifz Program Oversight</h4><p>Monitoring the Hifzul Quran program to ensure students progress steadily in memorization while maintaining academic excellence.</p><h3>Meeting Schedule</h3><p>The Academic Committee meets monthly to review academic performance, discuss curriculum updates, and plan educational initiatives for continuous improvement.</p>',
                'meta_title' => 'Academic Committee - Duha International School',
                'meta_description' => 'Learn about our Academic Committee that ensures curriculum quality and academic excellence at Duha International School.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Campus Facilities
        Page::updateOrCreate(
            ['slug' => 'campus-facilities'],
            [
                'title' => 'Campus Facilities',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'Campus Facilities',
                'menu_order' => 8,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Explore our modern campus facilities designed to support learning, development, and spiritual growth.',
                'content' => '<h2>Campus Facilities</h2><p>At Duha International School, we provide a range of modern facilities to support our students\' learning, development, and spiritual growth.</p><h3>Academic Facilities</h3><h4>1. Spacious Classrooms</h4><p>Well-lit and air-conditioned rooms equipped with multimedia facilities for interactive learning. Each classroom is designed to accommodate different learning styles and promote student engagement.</p><h4>2. Science Laboratories</h4><p>Fully equipped labs for practical experiments in physics, chemistry, and biology. Students gain hands-on experience with modern scientific equipment and safe laboratory practices.</p><h4>3. Computer Lab</h4><p>State-of-the-art computer facilities with high-speed internet access for ICT education and research. Students learn coding, digital literacy, and technology skills essential for the modern world.</p><h4>4. Library</h4><p>A well-stocked library with a wide range of books, periodicals, and digital resources. Our collection includes Islamic literature, academic references, and age-appropriate reading materials for all students.</p><h3>Spiritual Facilities</h3><h4>5. Prayer Rooms</h4><p>Dedicated spaces for daily prayers, fostering spiritual growth. Separate prayer facilities for male and female students ensure a comfortable environment for worship.</p><h3>Recreational Facilities</h3><h4>6. Playground</h4><p>A large outdoor area for sports and physical activities. Students engage in cricket, football, badminton, and other sports that promote physical fitness and teamwork.</p><h4>10. Recreation Room</h4><p>A dedicated space for creative ideas and activities. This multipurpose room hosts art projects, cultural programs, and indoor games.</p><h3>Support Facilities</h3><h4>7. Cafeteria</h4><p>Providing nutritious and healthy meals for students and staff. Our cafeteria follows strict hygiene standards and offers balanced meal options.</p><h4>8. Medical Room</h4><p>A fully equipped first-aid facility with a qualified medical professional on duty. We ensure prompt medical attention for any health concerns or emergencies.</p><h4>9. Multimedia Room</h4><p>For audio-visual presentations and educational screenings. This facility enhances learning through visual media, documentaries, and educational videos.</p><h4>11. Transport Facility</h4><p>We have transport facilities for far areas (AC bus) and near areas (Non-AC). Safe, reliable, and supervised transportation ensures students travel comfortably to and from school.</p><h3>Safety & Security</h3><p>Our campus is equipped with CCTV surveillance, secure entry points, and trained security personnel to ensure a safe learning environment for all students and staff.</p>',
                'meta_title' => 'Campus Facilities - Duha International School',
                'meta_description' => 'Explore our modern campus facilities including classrooms, labs, library, prayer rooms, playground, and transport services.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // School Uniform
        Page::updateOrCreate(
            ['slug' => 'school-uniform'],
            [
                'title' => 'School Uniform',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'School Uniform',
                'menu_order' => 9,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Information about Duha International School uniform requirements and dress code policy.',
                'content' => '<h2>School Uniform</h2><p>At Duha International School, we believe that a proper uniform creates a sense of belonging, promotes equality, and maintains a focused learning environment. Our uniform policy is designed to reflect Islamic values of modesty while ensuring comfort and practicality for students.</p><h3>Uniform Requirements</h3><h4>Boys\' Uniform</h4><ul><li><strong>Shirt:</strong> White/school-designated color shirt with school logo</li><li><strong>Pants:</strong> Navy blue/school-designated color pants</li><li><strong>Shoes:</strong> Black leather shoes with white/black socks</li><li><strong>Belt:</strong> Black leather belt</li><li><strong>Winter:</strong> School-designated sweater/blazer</li></ul><h4>Girls\' Uniform</h4><ul><li><strong>Tunic/Kameez:</strong> School-designated modest dress with school logo</li><li><strong>Pants/Salwar:</strong> Matching color pants/salwar</li><li><strong>Hijab:</strong> School-designated color hijab (mandatory)</li><li><strong>Shoes:</strong> Black leather shoes with white/black socks</li><li><strong>Winter:</strong> School-designated sweater/cardigan</li></ul><h3>Physical Education (PE) Uniform</h3><ul><li>School-designated tracksuit for boys</li><li>School-designated modest activewear for girls</li><li>White sports shoes</li></ul><h3>Uniform Guidelines</h3><ul><li>All uniforms must be clean, pressed, and in good condition</li><li>School badge/logo must be prominently displayed</li><li>Hair should be neatly groomed; boys should have short hair, girls should tie long hair</li><li>Jewelry should be minimal and modest</li><li>Nail polish and makeup are not permitted</li></ul><h3>Where to Purchase</h3><p>Official school uniforms can be purchased from our authorized tailors:</p><ul><li><strong>Belbond Tailors</strong></li><li><strong>Rabia Tailors</strong></li></ul><p>For new admissions, the school office will provide contact details and sizing information for uniform orders.</p><h3>Special Occasions</h3><p>On special Islamic occasions and cultural programs, traditional Islamic dress is encouraged. The school will inform parents in advance about any specific dress requirements for special events.</p>',
                'meta_title' => 'School Uniform - Duha International School',
                'meta_description' => 'Information about Duha International School uniform requirements and dress code policy for students.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // FAQ
        Page::updateOrCreate(
            ['slug' => 'faq'],
            [
                'title' => 'Frequently Asked Questions (FAQ)',
                'parent_id' => $aboutUs->id,
                'page_category' => 'about-us',
                'menu_title' => 'FAQ',
                'menu_order' => 10,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Find answers to commonly asked questions about Duha International School.',
                'content' => '<h2>Frequently Asked Questions</h2><h3>General Questions</h3><h4>Q1: What makes Duha International School different from other schools?</h4><p>Duha International School uniquely combines Islamic education with modern academic curricula (National and Cambridge). We emphasize character building, Quranic education, and academic excellence in a supportive Islamic environment.</p><h4>Q2: Where is the school located?</h4><p>Duha International School is located in Chattogram, Bangladesh. Please contact our admissions office for the exact address and directions.</p><h4>Q3: What age groups do you accept?</h4><p>We accept students from Pre-Play (3 years) through Grade 9 (15 years), covering early years, primary, and secondary education.</p><h3>Admission Questions</h3><h4>Q4: When does the admission process start?</h4><p>Admissions are open throughout the year, but we recommend applying early as spaces are limited. The main admission period is before the start of the academic year.</p><h4>Q5: What documents are required for admission?</h4><p>Required documents include: Admission form, previous academic records, birth certificate, passport-size photographs, and parent/guardian identification.</p><h4>Q6: Is there an entrance assessment?</h4><p>Yes, students participate in an age-appropriate entrance assessment to evaluate their academic readiness and help us understand their strengths.</p><h3>Curriculum Questions</h3><h4>Q7: What curricula do you offer?</h4><p>We offer three curriculum tracks: National Curriculum (English Version), Cambridge International Curriculum, and Hifzul Quran Program integrated with general education.</p><h4>Q8: Can students switch between curriculum tracks?</h4><p>Switching between curricula may be possible depending on the student\'s grade level and academic performance. Please consult with the academic office for specific cases.</p><h4>Q9: How is Islamic education integrated?</h4><p>Islamic education is integrated into all curricula through daily Quranic studies, Islamic Studies, Arabic language, and character development programs based on Islamic values.</p><h3>Facilities & Services</h3><h4>Q10: Do you provide transportation?</h4><p>Yes, we provide safe transportation services with AC buses for far areas and Non-AC buses for near areas. Transportation fees apply separately.</p><h4>Q11: What are the class timings?</h4><p>Class timings vary by grade level and curriculum. Please refer to our Class Timings page or contact the school office for specific schedules.</p><h4>Q12: Do you provide meals?</h4><p>Yes, our cafeteria provides nutritious and healthy meals. Students can also bring their own lunch from home.</p><h3>Parent Engagement</h3><h4>Q13: How do you communicate with parents?</h4><p>We maintain regular communication through parent-teacher meetings, progress reports, school events, and digital communication platforms.</p><h4>Q14: Can parents visit the school?</h4><p>Yes, parents are welcome to visit. We recommend scheduling an appointment with the admissions office for a proper campus tour and consultation.</p><h3>Financial Questions</h3><h4>Q15: What are the fee structures?</h4><p>Fee structures vary by curriculum and grade level. Please refer to our Fee Structure pages for detailed information on admission fees, tuition fees, and other costs.</p><h4>Q16: Are payment plans available?</h4><p>Please contact our accounts office to discuss payment arrangements and available options.</p><h3>Contact</h3><p>If you have additional questions not answered here, please contact our school office or visit our Contact Us page.</p>',
                'meta_title' => 'FAQ - Duha International School',
                'meta_description' => 'Find answers to commonly asked questions about admissions, curriculum, facilities, and more at Duha International School.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
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

        // Academic Program (Navigation slug: academic-program)
        Page::updateOrCreate(
            ['slug' => 'academic-program'],
            [
                'title' => 'Academic Program',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Academic Program',
                'menu_order' => 5,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Overview of our comprehensive academic programs combining Islamic education with modern curricula.',
                'content' => '<h2>Academic Program at Duha International School</h2><p>Our academic program is designed to provide students with a balanced education that integrates Islamic knowledge with modern academic excellence. We offer multiple curriculum tracks to meet diverse family needs while maintaining high educational standards.</p><h3>Program Structure</h3><p>Our academic year runs from January to December, divided into two semesters with regular assessments, parent-teacher meetings, and progress reports.</p><h3>Curriculum Tracks</h3><ul><li><strong>National Curriculum (English Version):</strong> Government-recognized curriculum preparing students for SSC exams</li><li><strong>Cambridge International Curriculum:</strong> Globally recognized qualification with IGCSE pathway</li><li><strong>Hifzul Quran Program:</strong> Quran memorization integrated with general education</li><li><strong>Islamic Curriculum:</strong> Comprehensive Islamic studies including Quran, Hadith, Fiqh, and Arabic</li></ul><h3>Teaching Methodology</h3><p>We employ modern teaching methods including interactive learning, project-based education, technology integration, hands-on experiments, and collaborative group work.</p>',
                'meta_title' => 'Academic Program - Duha International School',
                'meta_description' => 'Explore our comprehensive academic programs combining Islamic education with National and Cambridge curricula.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Academic Calendar
        Page::updateOrCreate(
            ['slug' => 'academic-calendar'],
            [
                'title' => 'Academic Calendar',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Academic Calendar',
                'menu_order' => 6,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'View our academic calendar including term dates, holidays, exams, and important school events.',
                'content' => '<h2>Academic Calendar 2025</h2><p>Our academic year is structured to provide balanced learning periods with appropriate breaks for students to rest and recharge.</p><h3>Academic Year Structure</h3><ul><li><strong>Academic Year:</strong> January - December</li><li><strong>First Semester:</strong> January - June</li><li><strong>Second Semester:</strong> July - December</li></ul><h3>Term Dates</h3><p><strong>First Term (Spring):</strong> January - March</p><p><strong>Second Term (Summer):</strong> April - June</p><p><strong>Third Term (Autumn):</strong> August - October</p><p><strong>Fourth Term (Winter):</strong> November - December</p><h3>Major Holidays</h3><ul><li>Winter Break: Mid-January</li><li>Eid-ul-Fitr Break: As per Islamic Calendar</li><li>Summer Break: July</li><li>Eid-ul-Adha Break: As per Islamic Calendar</li><li>Victory Day Break: December 16</li></ul><h3>Examination Periods</h3><ul><li>Mid-term Exams: March, September</li><li>Final Exams: June, December</li></ul><h3>Parent-Teacher Meetings</h3><p>Scheduled quarterly after each term assessment period.</p><p><strong>Note:</strong> Calendar dates may be adjusted based on government holidays and Islamic calendar. Updates will be communicated to parents via school communication channels.</p>',
                'meta_title' => 'Academic Calendar - Duha International School',
                'meta_description' => 'View our academic calendar including term dates, holidays, exams, and important school events.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Subjects We Teach
        Page::updateOrCreate(
            ['slug' => 'subjects'],
            [
                'title' => 'Subjects We Teach',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Subjects We Teach',
                'menu_order' => 7,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Comprehensive list of subjects offered at Duha International School across all grade levels.',
                'content' => '<h2>Subjects We Teach</h2><p>Duha International School offers a comprehensive range of subjects across all grade levels, combining core academic subjects with Islamic studies.</p><h3>Islamic Studies</h3><ul><li>Quranic Studies & Tajweed</li><li>Hifzul Quran (memorization)</li><li>Islamic Studies (Aqeedah, Fiqh, Seerah)</li><li>Arabic Language</li><li>Hadith Studies</li></ul><h3>Core Academic Subjects</h3><ul><li>English Language & Literature</li><li>Bangla Language & Literature</li><li>Mathematics</li><li>Science (Physics, Chemistry, Biology)</li><li>Social Studies / Bangladesh & Global Studies</li></ul><h3>Additional Subjects</h3><ul><li>Information & Communication Technology (ICT)</li><li>Arts & Crafts</li><li>Physical Education & Sports</li><li>Life Skills & Moral Education</li></ul><h3>Cambridge Subjects (for Cambridge Track)</h3><ul><li>English as a Second Language</li><li>Mathematics (Core & Extended)</li><li>Sciences (Combined Science / Separate Sciences)</li><li>Global Perspectives</li></ul><p>Subject offerings may vary by grade level and curriculum track. For detailed subject information by grade, please refer to our Grades & Subjects Overview page.</p>',
                'meta_title' => 'Subjects We Teach - Duha International School',
                'meta_description' => 'Comprehensive list of subjects offered at Duha International School including Islamic studies, core academics, and additional subjects.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Tahfeez Program (Navigation slug: tahfeez-program)
        Page::updateOrCreate(
            ['slug' => 'tahfeez-program'],
            [
                'title' => 'Tahfeez Program',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Tahfeez Program',
                'menu_order' => 8,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Our Tahfeez (Quran memorization) program allows students to become Hafiz while pursuing general education.',
                'content' => '<h2>Tahfeez Program</h2><p>The Tahfeez Program at Duha International School is a specialized track for students who wish to complete Hifzul Quran (memorization of the entire Quran) while maintaining their general academic education.</p><h3>Program Features</h3><ul><li><strong>Structured Memorization Schedule:</strong> Daily Hifz sessions with qualified teachers</li><li><strong>Revision System:</strong> Regular Sabaq, Sabqi, and Manzil revision to ensure retention</li><li><strong>Tajweed Excellence:</strong> Emphasis on correct pronunciation and recitation rules</li><li><strong>Academic Integration:</strong> Flexible timetable allowing students to complete general education</li></ul><h3>Curriculum Options</h3><p>Students can pursue Tahfeez alongside:</p><ul><li>National Curriculum (English Version)</li><li>Cambridge International Curriculum</li></ul><h3>Program Duration</h3><p>Typically 4-6 years depending on student\'s starting age, dedication, and memorization pace.</p><h3>Teaching Methodology</h3><ul><li>One-on-one Hifz sessions with qualified Qari/Qariah</li><li>Small group revision classes</li><li>Daily memorization target setting</li><li>Monthly progress assessment</li></ul><h3>Graduation Requirements</h3><ul><li>Complete memorization of 30 Juz of Quran</li><li>Pass oral examination with full recitation</li><li>Demonstrate proficiency in Tajweed rules</li></ul><p>Upon successful completion, students receive Hafiz certification and participate in a special graduation ceremony.</p>',
                'meta_title' => 'Tahfeez Program - Duha International School',
                'meta_description' => 'Learn about our Tahfeez (Quran memorization) program that allows students to become Hafiz while pursuing general education.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        // Tahili Program
        Page::updateOrCreate(
            ['slug' => 'tahili-program'],
            [
                'title' => 'Tahili Program',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Tahili Program',
                'menu_order' => 9,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Our Tahili program focuses on Quranic understanding, interpretation, and application alongside recitation.',
                'content' => '<h2>Tahili Program</h2><p>The Tahili Program at Duha International School focuses on understanding and applying the teachings of the Quran in daily life, complementing the memorization focus of the Tahfeez program.</p><h3>Program Components</h3><h4>1. Quranic Recitation (Tilawah)</h4><p>Proper recitation with correct Tajweed rules, without necessarily memorizing the entire Quran.</p><h4>2. Tafsir (Quranic Interpretation)</h4><p>Age-appropriate understanding of Quranic meanings, contexts, and lessons. Students learn the stories of prophets, moral lessons, and practical guidance from the Quran.</p><h4>3. Thematic Studies</h4><p>Study of Quranic themes such as justice, compassion, patience, gratitude, and social responsibility.</p><h4>4. Practical Application</h4><p>How to apply Quranic teachings in daily life, character development, and decision-making.</p><h3>Learning Outcomes</h3><ul><li>Deep understanding of Quranic message and teachings</li><li>Ability to read Quran with proper Tajweed</li><li>Understanding of context and reasons for revelation (Asbab al-Nuzul)</li><li>Application of Quranic principles in modern life</li><li>Strong moral and ethical foundation based on Quranic values</li></ul><h3>For Whom?</h3><p>The Tahili program is ideal for students who:</p><ul><li>Want to understand the Quran deeply rather than memorize entirely</li><li>Wish to focus more on academic subjects while maintaining strong Islamic education</li><li>Are older students who may find full Hifz challenging alongside academics</li></ul><p>Both Tahfeez and Tahili students receive comprehensive Islamic education; the difference lies in the memorization requirement.</p>',
                'meta_title' => 'Tahili Program - Duha International School',
                'meta_description' => 'Learn about our Tahili program focusing on Quranic understanding, interpretation, and application alongside recitation.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Future Progression
        Page::updateOrCreate(
            ['slug' => 'future-progression'],
            [
                'title' => 'Future Progression',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Future Progression',
                'menu_order' => 10,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Pathways and opportunities available to Duha International School graduates for higher education and career development.',
                'content' => '<h2>Future Progression for Our Students</h2><p>At Duha International School, we prepare students not just for exams, but for life. Our graduates are well-positioned for success in higher education and various career paths.</p><h3>Academic Progression Pathways</h3><h4>National Curriculum Students</h4><ul><li>Progression to Class 9-10 (SSC preparation)</li><li>Admission to renowned colleges in Bangladesh for HSC</li><li>University admission through public/private universities</li><li>Professional education (Medicine, Engineering, Business, etc.)</li></ul><h4>Cambridge Curriculum Students</h4><ul><li>Progression to IGCSE and A-Levels</li><li>International university admissions</li><li>Study abroad opportunities in UK, USA, Canada, Australia</li><li>Globally recognized qualifications</li></ul><h4>Hafiz/Tahfeez Students</h4><ul><li>Continue higher Islamic education at Islamic universities</li><li>Pursue academic degrees with Hifz certificate advantage</li><li>Teaching positions in Islamic institutions</li><li>Leadership roles in Muslim communities</li></ul><h3>Career Readiness</h3><p>Our students develop skills for various career paths:</p><ul><li>Science & Technology fields</li><li>Medical & Healthcare professions</li><li>Engineering & Architecture</li><li>Business & Entrepreneurship</li><li>Education & Research</li><li>Islamic Studies & Da\'wah work</li><li>Arts & Creative industries</li></ul><h3>Support for Progression</h3><ul><li>Career counseling and guidance</li><li>University admission preparation</li><li>Scholarship information and application support</li><li>Alumni network and mentorship</li></ul><h3>Success Stories</h3><p>Our graduates have successfully gained admission to top universities in Bangladesh and abroad, pursuing diverse fields while maintaining strong Islamic values and identity.</p>',
                'meta_title' => 'Future Progression - Duha International School',
                'meta_description' => 'Learn about pathways and opportunities available to Duha International School graduates for higher education and career development.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Duha Curriculum
        Page::updateOrCreate(
            ['slug' => 'curriculum'],
            [
                'title' => 'Duha Curriculum',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Duha Curriculum',
                'menu_order' => 11,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Overview of our unique curriculum framework that integrates Islamic education with modern academic standards.',
                'content' => '<h2>Duha Curriculum Framework</h2><p>The Duha Curriculum represents our unique approach to education - a balanced integration of Islamic knowledge with modern academic excellence.</p><h3>Curriculum Philosophy</h3><p>Our curriculum is built on the motto: <strong>"Build the Nation with the Light of Divine Knowledge"</strong></p><p>We believe education should nurture:</p><ul><li>Strong Islamic faith and character</li><li>Academic excellence and critical thinking</li><li>Physical health and wellbeing</li><li>Social responsibility and leadership</li><li>Creativity and innovation</li></ul><h3>Curriculum Components</h3><h4>1. Islamic Foundation (30% of time)</h4><ul><li>Quran (recitation, memorization, or understanding)</li><li>Islamic Studies</li><li>Arabic Language</li><li>Character development</li></ul><h4>2. Academic Excellence (60% of time)</h4><ul><li>Core subjects (English, Mathematics, Science, Social Studies)</li><li>Language skills (English, Bangla)</li><li>ICT and technology</li></ul><h4>3. Holistic Development (10% of time)</h4><ul><li>Physical Education & Sports</li><li>Arts & Culture</li><li>Life Skills & Community Service</li></ul><h3>Curriculum Standards</h3><p>Our curriculum aligns with:</p><ul><li>National Curriculum of Bangladesh (NCTB)</li><li>Cambridge International Education (CIE)</li><li>Islamic education standards</li></ul><h3>Assessment & Evaluation</h3><p>We use continuous assessment methods including:</p><ul><li>Formative assessments (regular quizzes, classwork)</li><li>Summative assessments (term exams)</li><li>Project-based evaluation</li><li>Oral presentations</li><li>Practical demonstrations</li></ul><p>Our balanced curriculum ensures students excel academically while remaining grounded in Islamic values.</p>',
                'meta_title' => 'Duha Curriculum - Duha International School',
                'meta_description' => 'Overview of our unique curriculum framework integrating Islamic education with modern academic standards.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Exam System
        Page::updateOrCreate(
            ['slug' => 'exam-system'],
            [
                'title' => 'Exam System',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Exam System',
                'menu_order' => 12,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Information about our examination system, assessment methods, and grading policies.',
                'content' => '<h2>Examination System</h2><p>Duha International School employs a comprehensive assessment system designed to accurately measure student learning and progress.</p><h3>Assessment Structure</h3><h4>Continuous Assessment (40%)</h4><ul><li>Class participation and attendance</li><li>Homework and assignments</li><li>Quizzes and short tests</li><li>Project work</li><li>Presentations</li></ul><h4>Term Examinations (60%)</h4><ul><li>Mid-term Exams (20%)</li><li>Final Term Exams (40%)</li></ul><h3>Exam Schedule</h3><p><strong>First Semester:</strong></p><ul><li>Mid-term: March</li><li>Final: June</li></ul><p><strong>Second Semester:</strong></p><ul><li>Mid-term: September</li><li>Final: December</li></ul><h3>Grading System</h3><div class="overflow-x-auto mt-4"><table class="w-full border-collapse border border-gray-300"><thead><tr class="bg-gray-100"><th class="border border-gray-300 px-4 py-2">Marks Range</th><th class="border border-gray-300 px-4 py-2">Grade</th><th class="border border-gray-300 px-4 py-2">Grade Point</th></tr></thead><tbody><tr><td class="border border-gray-300 px-4 py-2">80-100</td><td class="border border-gray-300 px-4 py-2">A+</td><td class="border border-gray-300 px-4 py-2">5.00</td></tr><tr><td class="border border-gray-300 px-4 py-2">70-79</td><td class="border border-gray-300 px-4 py-2">A</td><td class="border border-gray-300 px-4 py-2">4.00</td></tr><tr><td class="border border-gray-300 px-4 py-2">60-69</td><td class="border border-gray-300 px-4 py-2">A-</td><td class="border border-gray-300 px-4 py-2">3.50</td></tr><tr><td class="border border-gray-300 px-4 py-2">50-59</td><td class="border border-gray-300 px-4 py-2">B</td><td class="border border-gray-300 px-4 py-2">3.00</td></tr><tr><td class="border border-gray-300 px-4 py-2">40-49</td><td class="border border-gray-300 px-4 py-2">C</td><td class="border border-gray-300 px-4 py-2">2.00</td></tr><tr><td class="border border-gray-300 px-4 py-2">33-39</td><td class="border border-gray-300 px-4 py-2">D</td><td class="border border-gray-300 px-4 py-2">1.00</td></tr><tr><td class="border border-gray-300 px-4 py-2">0-32</td><td class="border border-gray-300 px-4 py-2">F</td><td class="border border-gray-300 px-4 py-2">0.00</td></tr></tbody></table></div><h3>Progress Reports</h3><p>Parents receive detailed progress reports after each assessment period showing:</p><ul><li>Marks and grades for each subject</li><li>Teacher comments</li><li>Attendance record</li><li>Areas of strength and improvement</li></ul><h3>Special Assessments</h3><ul><li><strong>Hifz Assessments:</strong> Monthly Hifz progress tests</li><li><strong>Tajweed Tests:</strong> Regular Tajweed proficiency checks</li><li><strong>Practical Exams:</strong> For Science, ICT, and Arts subjects</li></ul><p>Our exam system is designed to be fair, comprehensive, and supportive of student learning.</p>',
                'meta_title' => 'Exam System - Duha International School',
                'meta_description' => 'Information about our examination system, assessment methods, grading policies, and progress reporting.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // ZA Policies
        Page::updateOrCreate(
            ['slug' => 'policies'],
            [
                'title' => 'School Policies',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'ZA Policies',
                'menu_order' => 13,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Important school policies and guidelines for students, parents, and staff.',
                'content' => '<h2>School Policies & Guidelines</h2><p>Duha International School maintains clear policies to ensure a safe, respectful, and productive learning environment for all students.</p><h3>Academic Policies</h3><h4>Attendance Policy</h4><ul><li>Minimum 80% attendance required for exam eligibility</li><li>Parents must notify school of absences</li><li>Medical certificates required for extended absences</li></ul><h4>Homework Policy</h4><ul><li>Age-appropriate homework assignments</li><li>Due dates must be respected</li><li>Parents encouraged to monitor homework completion</li></ul><h4>Assessment Policy</h4><ul><li>Fair and transparent assessment methods</li><li>Multiple assessment opportunities</li><li>Feedback provided for improvement</li></ul><h3>Behavioral Policies</h3><h4>Code of Conduct</h4><ul><li>Respect for teachers, staff, and fellow students</li><li>Islamic etiquette in speech and behavior</li><li>No bullying, harassment, or discrimination</li><li>Proper use of school property</li></ul><h4>Discipline Policy</h4><ul><li>Progressive discipline approach</li><li>Parent involvement in behavioral issues</li><li>Counseling and support for struggling students</li></ul><h3>Safety & Security Policies</h3><ul><li>CCTV surveillance for student safety</li><li>Controlled entry and exit points</li><li>Emergency procedures and drills</li><li>Child protection protocols</li></ul><h3>Health & Wellness Policies</h3><ul><li>Nutritious meals in cafeteria</li><li>Medical room with qualified staff</li><li>Medication administration protocols</li><li>Mental health support available</li></ul><h3>Communication Policy</h3><ul><li>Regular parent-teacher meetings</li><li>Digital communication through school platforms</li><li>Emergency contact procedures</li></ul><h3>Technology Policy</h3><ul><li>Acceptable use of school technology</li><li>Mobile phone restrictions during school hours</li><li>Internet safety guidelines</li></ul><p>For detailed policy documents, please contact the school office.</p>',
                'meta_title' => 'School Policies - Duha International School',
                'meta_description' => 'Important school policies and guidelines covering academics, behavior, safety, health, and communication.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Class Routine
        Page::updateOrCreate(
            ['slug' => 'class-routine'],
            [
                'title' => 'Class Routine',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Class Routine',
                'menu_order' => 14,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Daily class schedules and routine information for different grade levels.',
                'content' => '<h2>Class Routine</h2><p>Duha International School follows a structured daily routine designed to maximize learning while ensuring balanced development of students.</p><h3>Daily Schedule Structure</h3><h4>Morning Assembly (15 minutes)</h4><ul><li>Quran recitation</li><li>Islamic Dua</li><li>Announcements</li><li>Motivational talks</li></ul><h4>Academic Sessions</h4><p>Classes are conducted in periods of 40-45 minutes with 5-10 minute breaks between periods.</p><h4>Prayer Time</h4><ul><li>Zuhr prayer break for all students</li><li>Separate prayer facilities for boys and girls</li><li>Supervised prayer time</li></ul><h4>Lunch Break (30-40 minutes)</h4><ul><li>Time for lunch and socialization</li><li>Supervised activities in playground</li></ul><h3>Sample Daily Routine (Primary Level)</h3><div class="overflow-x-auto mt-4"><table class="w-full border-collapse border border-gray-300"><thead><tr class="bg-gray-100"><th class="border border-gray-300 px-4 py-2">Time</th><th class="border border-gray-300 px-4 py-2">Activity</th></tr></thead><tbody><tr><td class="border border-gray-300 px-4 py-2">8:00 - 8:15</td><td class="border border-gray-300 px-4 py-2">Morning Assembly</td></tr><tr><td class="border border-gray-300 px-4 py-2">8:15 - 9:00</td><td class="border border-gray-300 px-4 py-2">Period 1 (Quran/Islamic Studies)</td></tr><tr><td class="border border-gray-300 px-4 py-2">9:00 - 9:45</td><td class="border border-gray-300 px-4 py-2">Period 2 (English)</td></tr><tr><td class="border border-gray-300 px-4 py-2">9:45 - 10:00</td><td class="border border-gray-300 px-4 py-2">Break</td></tr><tr><td class="border border-gray-300 px-4 py-2">10:00 - 10:45</td><td class="border border-gray-300 px-4 py-2">Period 3 (Mathematics)</td></tr><tr><td class="border border-gray-300 px-4 py-2">10:45 - 11:30</td><td class="border border-gray-300 px-4 py-2">Period 4 (Science)</td></tr><tr><td class="border border-gray-300 px-4 py-2">11:30 - 12:10</td><td class="border border-gray-300 px-4 py-2">Lunch & Prayer Break</td></tr><tr><td class="border border-gray-300 px-4 py-2">12:10 - 12:55</td><td class="border border-gray-300 px-4 py-2">Period 5 (Bangla/Arabic)</td></tr><tr><td class="border border-gray-300 px-4 py-2">12:55 - 1:30</td><td class="border border-gray-300 px-4 py-2">Period 6 (Co-curricular)</td></tr></tbody></table></div><p><strong>Note:</strong> Actual routine varies by grade level and curriculum track. Please contact the school office for grade-specific routines.</p><h3>Special Days</h3><ul><li><strong>Friday:</strong> Jumu\'ah prayer arrangements</li><li><strong>Sports Day:</strong> Weekly dedicated sports period</li><li><strong>Library Period:</strong> Weekly library visit</li></ul><p>Class routines are designed to ensure balanced attention to all subjects while prioritizing Islamic education and character development.</p>',
                'meta_title' => 'Class Routine - Duha International School',
                'meta_description' => 'Daily class schedules and routine information for different grade levels at Duha International School.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Sports & Recreation
        Page::updateOrCreate(
            ['slug' => 'sports'],
            [
                'title' => 'Sports & Recreation',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Sports & Recreation',
                'menu_order' => 15,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Sports programs and recreational activities promoting physical fitness and teamwork.',
                'content' => '<h2>Sports & Recreation at Duha International School</h2><p>Physical education and sports are integral parts of our holistic education approach. We believe in developing physically healthy students alongside their academic and spiritual growth.</p><h3>Sports Facilities</h3><ul><li>Large outdoor playground</li><li>Indoor sports facilities</li><li>Sports equipment for various games</li><li>Dedicated PE teachers</li></ul><h3>Sports Offered</h3><h4>Outdoor Sports</h4><ul><li>Cricket</li><li>Football</li><li>Badminton</li><li>Basketball</li><li>Volleyball</li><li>Track & Field</li></ul><h4>Indoor Sports</h4><ul><li>Table Tennis</li><li>Chess</li><li>Carrom</li><li>Indoor games</li></ul><h3>Physical Education Program</h3><ul><li>Weekly PE classes for all students</li><li>Age-appropriate activities</li><li>Skill development and team sports</li><li>Fitness assessments</li></ul><h3>Special Programs</h3><ul><li><strong>Martial Arts:</strong> Weekly self-defense training</li><li><strong>Swimming:</strong> Affiliated with Radisson Blu for swimming lessons</li><li><strong>Yoga & Exercise:</strong> Fitness and flexibility training</li></ul><h3>Annual Sports Day</h3><p>Our annual sports day celebrates athleticism and sportsmanship with:</p><ul><li>Track and field events</li><li>Team sports competitions</li><li>Inter-house competitions</li><li>Awards and recognition</li></ul><h3>Health & Safety</h3><ul><li>Qualified coaches and supervisors</li><li>Safety equipment and first aid</li><li>Regular health check-ups</li><li>Hydration and nutrition guidance</li></ul><p>Through sports, we develop teamwork, discipline, perseverance, and healthy competition while maintaining Islamic values of fair play and respect.</p>',
                'meta_title' => 'Sports & Recreation - Duha International School',
                'meta_description' => 'Sports programs and recreational activities promoting physical fitness, teamwork, and healthy living.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Events & Activities
        Page::updateOrCreate(
            ['slug' => 'events-activities'],
            [
                'title' => 'Events & Activities',
                'parent_id' => $academics->id,
                'page_category' => 'academics',
                'menu_title' => 'Events & Activities',
                'menu_order' => 16,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'School events, extracurricular activities, and special programs throughout the academic year.',
                'content' => '<h2>Events & Activities</h2><p>Duha International School organizes a vibrant calendar of events and activities that enrich student learning and foster a strong school community.</p><h3>Islamic Events</h3><ul><li><strong>Ramadan Programs:</strong> Special Iftar gatherings, Taraweeh, Quran competitions</li><li><strong>Eid Celebrations:</strong> Eid prayers, cultural programs, charity drives</li><li><strong>Islamic Months:</strong> Special programs for Muharram, Rabi-ul-Awwal, etc.</li><li><strong>Hajj Simulation:</strong> Educational program teaching Hajj rituals</li></ul><h3>Academic Events</h3><ul><li>Science Fairs & Exhibitions</li><li>Math Olympiad preparation and competitions</li><li>Spelling Bee contests</li><li>Debate competitions</li><li>Book fairs and reading challenges</li><li>Academic award ceremonies</li></ul><h3>Cultural Programs</h3><ul><li>Annual Cultural Day</li><li>Nasheed performances</li><li>Islamic drama and skits</li><li>Art exhibitions</li><li>Poetry recitations</li></ul><h3>Sports Events</h3><ul><li>Annual Sports Day</li><li>Inter-house competitions</li><li>Inter-school sports meets</li><li>Martial arts demonstrations</li></ul><h3>Community Service</h3><ul><li>Charity drives (food, clothing)</li><li>Environmental clean-up campaigns</li><li>Visit to orphanages</li><li>Iftar distribution in Ramadan</li></ul><h3>Parent Engagement Events</h3><ul><li>Parent-Teacher meetings</li><li>Parenting workshops</li><li>Family days</li><li>Pitha Festival</li><li>Tea with Principal/Director</li></ul><h3>Special Days</h3><ul><li>International Mother Language Day (Feb 21)</li><li>Independence Day (Mar 26)</li><li>Victory Day (Dec 16)</li><li>Teacher Appreciation Day</li><li>International Days celebrations</li></ul><h3>Extracurricular Clubs</h3><ul><li>Quran Club</li><li>Science Club</li><li>Debate & Public Speaking Club</li><li>Arts & Crafts Club</li><li>Technology & Coding Club</li><li>Environmental Club</li></ul><p>Our events and activities are designed to provide students with diverse opportunities for growth, leadership, creativity, and community engagement while staying grounded in Islamic values.</p>',
                'meta_title' => 'Events & Activities - Duha International School',
                'meta_description' => 'School events, extracurricular activities, Islamic programs, and special celebrations throughout the academic year.',
                'is_published' => true,
                'is_featured' => false,
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

        // Create parent variable for child pages
        $facilities = Page::where('slug', 'facilities')->first();

        // Residential Facilities
        Page::updateOrCreate(
            ['slug' => 'residential-facilities'],
            [
                'title' => 'Residential Facilities',
                'parent_id' => $facilities?->id,
                'page_category' => 'facilities',
                'menu_title' => 'Residential Facilities',
                'menu_order' => 1,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Information about residential and boarding facilities for students at Duha International School.',
                'content' => '<h2>Residential Facilities</h2><p>Duha International School is planning to offer residential facilities for students who come from distant areas or require boarding arrangements.</p><h3>Future Residential Program</h3><p>We are in the process of developing comprehensive residential facilities that will provide:</p><ul><li><strong>Safe Accommodation:</strong> Secure dormitories with 24/7 supervision</li><li><strong>Comfortable Living Spaces:</strong> Well-furnished rooms with modern amenities</li><li><strong>Nutritious Meals:</strong> Three meals daily plus snacks, prepared with proper hygiene</li><li><strong>Study Areas:</strong> Dedicated spaces for homework and study sessions</li><li><strong>Recreational Facilities:</strong> Indoor and outdoor activities for residents</li><li><strong>Islamic Environment:</strong> Prayer facilities and Islamic guidance</li><li><strong>Health Services:</strong> 24/7 medical support and emergency care</li><li><strong>Security:</strong> Controlled access, CCTV surveillance, trained security staff</li></ul><h3>Supervision & Care</h3><p>Our residential program will include:</p><ul><li>Dedicated house parents and supervisors</li><li>Gender-segregated accommodation</li><li>Structured daily routine balancing academics and activities</li><li>Regular communication with parents</li><li>Pastoral care and counseling support</li></ul><h3>Current Status</h3><p>Residential facilities are currently under development. For the latest information on availability, fees, and admission procedures for boarding students, please contact our admissions office.</p><p><strong>Contact:</strong> admissions@duhaschool.com</p>',
                'meta_title' => 'Residential Facilities - Duha International School',
                'meta_description' => 'Information about residential and boarding facilities for students at Duha International School.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Support for Learning
        Page::updateOrCreate(
            ['slug' => 'support-learning'],
            [
                'title' => 'Support for Learning and Spiritual Development',
                'parent_id' => $facilities?->id,
                'page_category' => 'facilities',
                'menu_title' => 'Support for Learning',
                'menu_order' => 2,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Comprehensive support services for academic learning and spiritual development of students.',
                'content' => '<h2>Support for Learning and Spiritual Development</h2><p>At Duha International School, we provide comprehensive support to ensure every student succeeds academically and grows spiritually.</p><h3>Academic Support Services</h3><h4>1. Remedial Classes</h4><p>Additional support for students who need extra help with specific subjects. Small group or one-on-one sessions with experienced teachers.</p><h4>2. Advanced Learner Programs</h4><p>Enrichment activities and advanced materials for students excelling in their studies.</p><h4>3. Learning Resource Center</h4><p>Access to educational materials, books, digital resources, and study aids.</p><h4>4. Tutoring Support</h4><p>After-school tutoring sessions for students needing additional academic assistance.</p><h4>5. Special Educational Needs</h4><p>Support for students with learning differences, including individualized learning plans and accommodations.</p><h3>Spiritual Development Support</h3><h4>1. Hifz Support Program</h4><p>Specialized support for students memorizing the Quran, including:</p><ul><li>One-on-one revision sessions</li><li>Memory retention techniques</li><li>Tajweed correction</li><li>Motivation and encouragement</li></ul><h4>2. Islamic Counseling</h4><p>Guidance from qualified Islamic scholars on spiritual matters, character development, and Islamic lifestyle.</p><h4>3. Moral Education Sessions</h4><p>Regular tarbiyah (moral training) sessions focusing on Islamic values, ethics, and character building.</p><h4>4. Prayer Support</h4><p>Assistance with learning proper prayer methods, memorizing duas, and understanding the spiritual significance of worship.</p><h3>Counseling Services</h3><ul><li><strong>Academic Counseling:</strong> Guidance on subject choices, study skills, and career planning</li><li><strong>Personal Counseling:</strong> Support for personal challenges, stress management, and emotional wellbeing</li><li><strong>Behavioral Support:</strong> Positive behavior reinforcement and conflict resolution</li></ul><h3>Parent Support</h3><ul><li>Regular progress updates and reports</li><li>Parent workshops on supporting children\'s learning</li><li>Home-school communication platforms</li><li>Resources for parents to support Islamic education at home</li></ul><h3>Technology Support</h3><ul><li>Digital learning platforms</li><li>Online resources and educational apps</li><li>Technology training for students and parents</li></ul><p>Our comprehensive support system ensures no student is left behind and every student has the resources needed to excel academically and spiritually.</p>',
                'meta_title' => 'Support for Learning & Spiritual Development - Duha International School',
                'meta_description' => 'Comprehensive academic and spiritual support services including remedial classes, Hifz support, counseling, and learning resources.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Parent Teacher Association
        Page::updateOrCreate(
            ['slug' => 'parent-association'],
            [
                'title' => 'Parent Teacher Association (PTA)',
                'parent_id' => $facilities?->id,
                'page_category' => 'facilities',
                'menu_title' => 'Parent Teacher Association',
                'menu_order' => 3,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Learn about our Parent Teacher Association and how parents can actively participate in school activities.',
                'content' => '<h2>Parent Teacher Association (PTA)</h2><p>The Parent Teacher Association at Duha International School serves as a vital bridge between parents and the school, fostering collaboration for the benefit of our students.</p><h3>PTA Mission</h3><p>To promote partnership between parents, teachers, and school administration in supporting student education, character development, and overall school improvement.</p><h3>PTA Objectives</h3><ul><li>Facilitate effective communication between parents and school</li><li>Support school programs and activities</li><li>Organize parent education workshops</li><li>Raise funds for school improvement projects</li><li>Represent parent voice in school decisions</li><li>Build a strong school community</li></ul><h3>PTA Structure</h3><h4>Executive Committee</h4><ul><li>President</li><li>Vice President</li><li>Secretary</li><li>Treasurer</li><li>Class Representatives</li></ul><h4>Sub-Committees</h4><ul><li>Academic Support Committee</li><li>Islamic Activities Committee</li><li>Events & Cultural Committee</li><li>Fundraising Committee</li><li>Communication Committee</li></ul><h3>PTA Activities</h3><h4>Regular Activities</h4><ul><li>Monthly PTA meetings</li><li>Parent-teacher conferences</li><li>School newsletter contributions</li><li>Volunteer coordination</li></ul><h4>Annual Events</h4><ul><li>Welcome Back to School event</li><li>Family Fun Days</li><li>Cultural programs support</li><li>Sports Day participation</li><li>Graduation ceremonies</li><li>Charity drives and community service</li></ul><h3>Parent Workshops</h3><p>The PTA organizes educational workshops on topics such as:</p><ul><li>Parenting in an Islamic way</li><li>Supporting children\'s academic success</li><li>Understanding adolescent development</li><li>Technology and screen time management</li><li>Nutrition and healthy lifestyle</li><li>Mental health awareness</li></ul><h3>How to Get Involved</h3><ul><li><strong>Become a Member:</strong> All parents are automatically PTA members</li><li><strong>Attend Meetings:</strong> Participate in monthly PTA meetings</li><li><strong>Volunteer:</strong> Help with events, activities, and committees</li><li><strong>Class Representative:</strong> Serve as your child\'s class representative</li><li><strong>Share Skills:</strong> Contribute your expertise to school programs</li><li><strong>Provide Feedback:</strong> Share suggestions and concerns</li></ul><h3>Contact PTA</h3><p>To get involved or learn more about PTA activities:</p><ul><li><strong>Email:</strong> pta@duhaschool.com</li><li><strong>Meeting Schedule:</strong> First Friday of each month</li><li><strong>Location:</strong> School Conference Room</li></ul><p>Your involvement makes a difference! Join the PTA and be part of your child\'s educational journey.</p>',
                'meta_title' => 'Parent Teacher Association (PTA) - Duha International School',
                'meta_description' => 'Learn about our Parent Teacher Association, how to get involved, PTA activities, and parent participation opportunities.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Faculty - Main Category Page
        $faculty = Page::updateOrCreate(
            ['slug' => 'faculty'],
            [
                'title' => 'Faculty',
                'page_category' => 'faculty',
                'menu_title' => 'Faculty',
                'menu_order' => 5,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Meet our dedicated faculty members who guide and inspire our students with quality Islamic and academic education.',
                'content' => '<h2>Our Faculty</h2><p>At Duha International School, we are proud of our team of dedicated, qualified, and experienced educators who are committed to providing quality Islamic and academic education to our students.</p><h3>Faculty Excellence</h3><p>Our teaching staff comprises:</p><ul><li>Qualified Islamic scholars (Alim/Fazil and Alimah/Fazilah degrees)</li><li>University graduates in their subject specializations</li><li>Experienced teachers with proven track records</li><li>Teachers trained by Alokito Teachers program</li><li>Hafiz-ul-Quran and Hafizah-tul-Quran for Quran instruction</li></ul><h3>Our Faculty Structure</h3><p>We maintain appropriate gender separation in line with Islamic values while ensuring all students receive excellent education from highly qualified teachers.</p><div class="grid md:grid-cols-2 gap-6 mt-6"><div class="bg-white p-6 rounded-lg shadow-md border border-gray-200"><h4 class="text-xl font-semibold text-aisd-midnight mb-3">Male Faculty</h4><p class="text-gray-600 mb-4">Our male faculty members provide quality instruction in Islamic Studies, Arabic, and general academic subjects for male students.</p><a href="/faculty/male-faculty" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">Meet Our Male Faculty →</a></div><div class="bg-white p-6 rounded-lg shadow-md border border-gray-200"><h4 class="text-xl font-semibold text-aisd-midnight mb-3">Female Faculty</h4><p class="text-gray-600 mb-4">Our female faculty members provide nurturing education in Islamic Studies, Arabic, and general academic subjects for female students.</p><a href="/faculty/female-faculty" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">Meet Our Female Faculty →</a></div></div><h3>Professional Development</h3><p>Our faculty members participate in regular professional development including:</p><ul><li>Teaching methodology workshops</li><li>Classroom management training</li><li>Subject-specific professional development</li><li>Technology integration training</li><li>Islamic pedagogy workshops</li></ul><h3>Commitment to Excellence</h3><p>Our faculty members serve as role models, demonstrating Islamic character, academic excellence, and dedication to student success. They are committed to nurturing both the academic and spiritual growth of every student.</p>',
                'meta_title' => 'Faculty - Duha International School',
                'meta_description' => 'Meet our dedicated faculty members who provide quality Islamic and academic education at Duha International School.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Male Faculty
        Page::updateOrCreate(
            ['slug' => 'male-faculty'],
            [
                'title' => 'Male Faculty',
                'parent_id' => $faculty->id,
                'page_category' => 'faculty',
                'menu_title' => 'Male Faculty',
                'menu_order' => 1,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Meet our dedicated male faculty members who guide and inspire our students.',
                'content' => '<h2>Male Faculty</h2><p>Our male faculty comprises experienced and qualified educators dedicated to providing quality Islamic and academic education.</p><h3>Faculty Qualifications</h3><p>Our male teaching staff includes:</p><ul><li>Qualified Islamic scholars with Alim/Fazil degrees</li><li>University graduates in their subject specializations</li><li>Experienced teachers with proven track records</li><li>Teachers trained by Alokito Teachers program</li><li>Hafiz-ul-Quran for Quran and Tajweed instruction</li></ul><h3>Departments</h3><h4>Islamic Studies Department</h4><ul><li>Quran & Tajweed teachers</li><li>Hifz instructors</li><li>Islamic Studies teachers</li><li>Arabic language teachers</li></ul><h4>Academic Department</h4><ul><li>English language teachers</li><li>Mathematics teachers</li><li>Science teachers (Physics, Chemistry, Biology)</li><li>Social Studies teachers</li><li>Bangla language teachers</li></ul><h4>Specialized Faculty</h4><ul><li>ICT & Technology instructors</li><li>Physical Education teachers</li><li>Arts teachers</li><li>Special Education coordinators</li></ul><h3>Professional Development</h3><p>Our male faculty participate in:</p><ul><li>Regular training workshops</li><li>Subject-specific professional development</li><li>Teaching methodology updates</li><li>Classroom management training</li><li>Technology integration workshops</li></ul><h3>Faculty Responsibilities</h3><ul><li>Delivering quality instruction</li><li>Assessing student progress</li><li>Maintaining discipline with Islamic etiquette</li><li>Communicating with parents</li><li>Participating in school activities</li><li>Continuous self-improvement</li></ul><p>Our male faculty members serve as role models, demonstrating Islamic character, academic excellence, and dedication to student success.</p>',
                'meta_title' => 'Male Faculty - Duha International School',
                'meta_description' => 'Meet our dedicated male faculty members providing quality Islamic and academic education at Duha International School.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Female Faculty
        Page::updateOrCreate(
            ['slug' => 'female-faculty'],
            [
                'title' => 'Female Faculty',
                'parent_id' => $faculty->id,
                'page_category' => 'faculty',
                'menu_title' => 'Female Faculty',
                'menu_order' => 2,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Meet our dedicated female faculty members who nurture and educate our students.',
                'content' => '<h2>Female Faculty</h2><p>Our female faculty consists of qualified, experienced, and compassionate educators committed to nurturing students\' academic and spiritual growth.</p><h3>Faculty Qualifications</h3><p>Our female teaching staff includes:</p><ul><li>Qualified Islamic scholars with Alimah/Fazilah degrees</li><li>University graduates in their subject specializations</li><li>Experienced teachers with proven expertise</li><li>Teachers trained by Alokito Teachers program</li><li>Hafizah-tul-Quran for Quran and Tajweed instruction</li></ul><h3>Departments</h3><h4>Islamic Studies Department</h4><ul><li>Quran & Tajweed teachers (Qariah)</li><li>Hifz instructors</li><li>Islamic Studies teachers</li><li>Arabic language teachers</li></ul><h4>Academic Department</h4><ul><li>English language teachers</li><li>Mathematics teachers</li><li>Science teachers</li><li>Social Studies teachers</li><li>Bangla language teachers</li></ul><h4>Early Years & Primary</h4><ul><li>Pre-school and KG teachers</li><li>Primary grade teachers</li><li>Special Education coordinators</li></ul><h4>Specialized Faculty</h4><ul><li>Arts & Crafts instructors</li><li>Home Economics teachers</li><li>Counseling staff</li></ul><h3>Professional Development</h3><p>Our female faculty engage in:</p><ul><li>Regular training workshops</li><li>Subject-specific professional development</li><li>Early childhood education training</li><li>Classroom management techniques</li><li>Islamic pedagogy workshops</li></ul><h3>Faculty Responsibilities</h3><ul><li>Delivering quality instruction with care</li><li>Nurturing student emotional and spiritual wellbeing</li><li>Assessing and supporting student progress</li><li>Creating positive learning environments</li><li>Building strong relationships with students and parents</li><li>Serving as role models for female students</li></ul><h3>Gender-Separated Environment</h3><p>In line with Islamic values, we maintain appropriate gender separation while ensuring all students receive excellent education from highly qualified teachers of their gender where possible.</p><p>Our female faculty members embody Islamic character, professionalism, and dedication, serving as inspiring role models for our students.</p>',
                'meta_title' => 'Female Faculty - Duha International School',
                'meta_description' => 'Meet our dedicated female faculty members providing nurturing Islamic and academic education at Duha International School.',
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

        // Fees - Index Page (links to both fee structures)
        Page::updateOrCreate(
            ['slug' => 'fees'],
            [
                'title' => 'Fees',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Fees',
                'menu_order' => 4,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Complete fee information for National Curriculum and Cambridge Curriculum programs at Duha International School.',
                'content' => '<h2>Fee Information</h2><p>At Duha International School, we offer transparent and affordable fee structures for both National Curriculum and Cambridge Curriculum programs. Our fees are designed to make quality Islamic education accessible to families.</p><h3>Fee Structures</h3><p>We provide detailed fee information for two curriculum options:</p><div class="grid md:grid-cols-2 gap-6 mt-6"><div class="bg-white p-6 rounded-lg shadow-md border border-gray-200"><h4 class="text-xl font-semibold text-aisd-midnight mb-3">National Curriculum</h4><p class="text-gray-600 mb-4">Complete fee structure for National Curriculum (English Version) including General and Islamic Curriculum options for all grades from Pre-Play through Grade 9.</p><a href="/admissions/fee-structure-national-curriculum" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">View National Curriculum Fees →</a></div><div class="bg-white p-6 rounded-lg shadow-md border border-gray-200"><h4 class="text-xl font-semibold text-aisd-midnight mb-3">Cambridge Curriculum</h4><p class="text-gray-600 mb-4">Complete fee structure for Cambridge and Islamic Curriculum including EYFS, KS-1, and KS-2 for all year levels.</p><a href="/admissions/fee-structure-cambridge-curriculum" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">View Cambridge Curriculum Fees →</a></div></div><h3 class="mt-8">Additional Fees</h3><ul><li><strong>Transport Fees:</strong> Available for both near and far areas. <a href="/admissions/transport-fees-policy" class="text-indigo-600 hover:underline">View transport fees →</a></li><li><strong>Exam Fees:</strong> Included in annual session fees</li><li><strong>Books & Supplies:</strong> Approximate costs provided in detailed fee structures</li><li><strong>Uniform:</strong> Available from Belbond Tailors and Rabia Tailors</li></ul><h3>Payment Information</h3><ul><li>Admission fees are one-time payments</li><li>Session fees are paid yearly</li><li>Monthly tuition fees are paid monthly</li><li>All fees are subject to annual review</li></ul><p class="mt-6 text-gray-600">For detailed fee information specific to your chosen curriculum, please select the appropriate fee structure above or contact our Admissions Office for personalized assistance.</p>',
                'meta_title' => 'Fees - Duha International School',
                'meta_description' => 'Complete fee information for National Curriculum and Cambridge Curriculum programs at Duha International School.',
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

        // Why Us (Why Choose Duha)
        Page::updateOrCreate(
            ['slug' => 'why-us'],
            [
                'title' => 'Why Choose Duha International School',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Why Us?',
                'menu_order' => 2,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Discover what makes Duha International School the ideal choice for your child\'s educational journey.',
                'content' => '<h2>Why Choose Duha International School?</h2><p>Choosing the right school for your child is one of the most important decisions you will make as a parent. At Duha International School, we offer a unique educational experience that combines Islamic values with academic excellence. Here\'s why families choose us:</p><h3>1. Balanced Islamic & Academic Education</h3><p>We provide a unique blend of Islamic education with modern academic curricula. Our students study the Quran, Islamic Studies, and Arabic alongside National Curriculum or Cambridge International programs, preparing them for success in both this world and the Hereafter.</p><h3>2. Hifzul Quran Program</h3><p>Our Hifzul Quran program allows students to memorize the Quran while pursuing their general education. This flexible approach ensures students can achieve both spiritual and academic goals without compromise.</p><h3>3. Qualified & Experienced Teachers</h3><p>Our teaching staff comprises experienced educators trained in both Islamic and general subjects. Teachers affiliated with Alokito Teachers receive ongoing professional development in teaching methodology, classroom management, and modern educational technology.</p><h3>4. Modern Facilities & Resources</h3><p>We provide state-of-the-art facilities including spacious classrooms with multimedia equipment, fully-equipped science labs, computer lab with high-speed internet, well-stocked library, prayer rooms, playground, cafeteria, and medical facilities.</p><h3>5. Character Development Focus</h3><p>Beyond academics, we emphasize character building through Islamic values. Our students develop integrity, empathy, responsibility, leadership skills, and a strong moral compass that guides them throughout life.</p><h3>6. Comprehensive Extracurricular Activities</h3><p>We offer diverse activities including sports, arts, technology, community service, Islamic activities, and leadership programs. These activities promote holistic development and help students discover their talents and passions.</p><h3>7. Safe & Supportive Environment</h3><p>Our school provides a secure, nurturing environment where students feel valued and supported. With CCTV surveillance, trained security personnel, and caring staff, parents can have peace of mind about their children\'s safety and wellbeing.</p><h3>8. Strong Parent-School Partnership</h3><p>We believe in close collaboration with parents through regular meetings, workshops, and events. Our open communication ensures parents stay informed and involved in their child\'s educational journey.</p><h3>9. Multiple Curriculum Options</h3><p>Families can choose from National Curriculum (English Version), Cambridge International Curriculum, or Hifzul Quran Program, each integrated with comprehensive Islamic education. This flexibility allows you to select the path that best suits your child\'s needs and future goals.</p><h3>10. Affordable Quality Education</h3><p>We strive to make quality Islamic education accessible to families. Our transparent fee structure and various curriculum options provide families with choices that fit their educational aspirations and budget.</p><h3>11. Proven Track Record</h3><p>Our students consistently demonstrate academic excellence, strong Islamic values, and leadership qualities. Our alumni go on to succeed in higher education and various fields while maintaining their Islamic identity.</p><p class="text-center text-xl font-bold text-aisd-midnight mt-8">Join the Duha family today and give your child the gift of balanced education that prepares them for a successful future in both worlds!</p>',
                'meta_title' => 'Why Choose Duha International School - Excellence in Islamic Education',
                'meta_description' => 'Discover why Duha International School is the ideal choice for your child - balanced Islamic and academic education, qualified teachers, modern facilities, and character development.',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now(),
            ]
        );

        // Choose & Apply (Enroll Online)
        Page::updateOrCreate(
            ['slug' => 'choose-apply'],
            [
                'title' => 'Enroll Online',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Enroll Online',
                'menu_order' => 3,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'external_url' => '/admission',
                'excerpt' => 'Start your admission journey by enrolling online at Duha International School.',
                'content' => '<h2>Enroll Online at Duha International School</h2><p>We have made the admission process simple and convenient for you. You can now submit your admission application online from the comfort of your home.</p><h3>How to Enroll Online</h3><ol><li><strong>Visit Our Admission Page:</strong> Click the button below to access our online admission form</li><li><strong>Fill Out the Form:</strong> Provide accurate information about your child and family</li><li><strong>Submit Documents:</strong> Upload required documents (birth certificate, previous academic records, photos)</li><li><strong>Submit Application:</strong> Review and submit your completed application</li><li><strong>Confirmation:</strong> You will receive an email confirmation with next steps</li><li><strong>Assessment & Interview:</strong> Our admissions team will contact you to schedule an entrance assessment and family interview</li></ol><div class="text-center mt-8 mb-8"><a href="/admission" class="inline-flex items-center px-8 py-4 bg-[#008236] text-white text-lg font-semibold rounded-xl hover:bg-[#006B2D] transition-colors duration-200 shadow-lg hover:shadow-xl">Start Your Application Now →</a></div><h3>What You\'ll Need</h3><ul><li>Student\'s birth certificate</li><li>Recent passport-size photographs (student and parents)</li><li>Previous academic records (if applicable)</li><li>Parent/guardian identification (NID/Passport)</li><li>Contact information (email, phone number)</li></ul><h3>Need Help?</h3><p>If you need assistance with the online application process, please contact our Admissions Office:</p><ul><li><strong>Phone:</strong> [Contact Number]</li><li><strong>Email:</strong> admissions@duhaschool.com</li><li><strong>Visit:</strong> You can also visit our campus to get help with the application</li></ul><p class="text-center text-xl font-bold text-aisd-midnight mt-8">We look forward to welcoming your child to the Duha family!</p>',
                'meta_title' => 'Enroll Online - Duha International School',
                'meta_description' => 'Start your admission journey by enrolling online at Duha International School. Simple, convenient online application process.',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now(),
            ]
        );

        // Year Group (Student Year Group and Age Range)
        Page::updateOrCreate(
            ['slug' => 'year-group'],
            [
                'title' => 'Student Year Group and Age Range',
                'parent_id' => $admissions->id,
                'page_category' => 'admissions',
                'menu_title' => 'Student Year Group and Age Range',
                'menu_order' => 8,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Find the appropriate year group for your child based on their age at Duha International School.',
                'content' => '<h2>Student Year Group and Age Range Guide</h2><p>At Duha International School, we offer education from early years through secondary level. Use this guide to determine the appropriate year group for your child based on their age.</p><h3>National Curriculum (English Version)</h3><div class="overflow-x-auto mt-4"><table class="w-full border-collapse border border-gray-300"><thead><tr class="bg-gray-100"><th class="border border-gray-300 px-4 py-2 text-left">Grade</th><th class="border border-gray-300 px-4 py-2 text-left">Age Range</th><th class="border border-gray-300 px-4 py-2 text-left">Year Group</th></tr></thead><tbody><tr><td class="border border-gray-300 px-4 py-2">Pre-Play</td><td class="border border-gray-300 px-4 py-2">3 years</td><td class="border border-gray-300 px-4 py-2">Pre-Primary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Play</td><td class="border border-gray-300 px-4 py-2">4 years</td><td class="border border-gray-300 px-4 py-2">Pre-Primary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Nursery</td><td class="border border-gray-300 px-4 py-2">5 years</td><td class="border border-gray-300 px-4 py-2">Pre-Primary</td></tr><tr><td class="border border-gray-300 px-4 py-2">KG</td><td class="border border-gray-300 px-4 py-2">6 years</td><td class="border border-gray-300 px-4 py-2">Pre-Primary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 1</td><td class="border border-gray-300 px-4 py-2">6-7 years</td><td class="border border-gray-300 px-4 py-2">Primary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 2</td><td class="border border-gray-300 px-4 py-2">7-8 years</td><td class="border border-gray-300 px-4 py-2">Primary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 3</td><td class="border border-gray-300 px-4 py-2">8-9 years</td><td class="border border-gray-300 px-4 py-2">Primary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 4</td><td class="border border-gray-300 px-4 py-2">9-10 years</td><td class="border border-gray-300 px-4 py-2">Primary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 5</td><td class="border border-gray-300 px-4 py-2">10-11 years</td><td class="border border-gray-300 px-4 py-2">Primary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 6</td><td class="border border-gray-300 px-4 py-2">11-12 years</td><td class="border border-gray-300 px-4 py-2">Secondary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 7</td><td class="border border-gray-300 px-4 py-2">12-13 years</td><td class="border border-gray-300 px-4 py-2">Secondary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 8</td><td class="border border-gray-300 px-4 py-2">13-14 years</td><td class="border border-gray-300 px-4 py-2">Secondary</td></tr><tr><td class="border border-gray-300 px-4 py-2">Grade 9</td><td class="border border-gray-300 px-4 py-2">14-15 years</td><td class="border border-gray-300 px-4 py-2">Secondary</td></tr></tbody></table></div><h3>Cambridge and Islamic Curriculum</h3><div class="overflow-x-auto mt-4"><table class="w-full border-collapse border border-gray-300"><thead><tr class="bg-gray-100"><th class="border border-gray-300 px-4 py-2 text-left">Year/Stage</th><th class="border border-gray-300 px-4 py-2 text-left">Age Range</th><th class="border border-gray-300 px-4 py-2 text-left">Cambridge Stage</th></tr></thead><tbody><tr><td class="border border-gray-300 px-4 py-2">EYFS Day Care</td><td class="border border-gray-300 px-4 py-2">2-3.5 years</td><td class="border border-gray-300 px-4 py-2">Early Years</td></tr><tr><td class="border border-gray-300 px-4 py-2">Pre-Play</td><td class="border border-gray-300 px-4 py-2">2.5-3.5 years</td><td class="border border-gray-300 px-4 py-2">Early Years Foundation Stage</td></tr><tr><td class="border border-gray-300 px-4 py-2">Play</td><td class="border border-gray-300 px-4 py-2">3.5-4.5 years</td><td class="border border-gray-300 px-4 py-2">EYFS</td></tr><tr><td class="border border-gray-300 px-4 py-2">Nursery</td><td class="border border-gray-300 px-4 py-2">4.5-5.5 years</td><td class="border border-gray-300 px-4 py-2">EYFS</td></tr><tr><td class="border border-gray-300 px-4 py-2">Reception</td><td class="border border-gray-300 px-4 py-2">5.5-6.5 years</td><td class="border border-gray-300 px-4 py-2">EYFS</td></tr><tr><td class="border border-gray-300 px-4 py-2">Year 1</td><td class="border border-gray-300 px-4 py-2">6.5-7.5 years</td><td class="border border-gray-300 px-4 py-2">Key Stage 1</td></tr><tr><td class="border border-gray-300 px-4 py-2">Year 2</td><td class="border border-gray-300 px-4 py-2">7.5-8.5 years</td><td class="border border-gray-300 px-4 py-2">Key Stage 1</td></tr><tr><td class="border border-gray-300 px-4 py-2">Year 3</td><td class="border border-gray-300 px-4 py-2">8.5-9.5 years</td><td class="border border-gray-300 px-4 py-2">Key Stage 2</td></tr><tr><td class="border border-gray-300 px-4 py-2">Year 4</td><td class="border border-gray-300 px-4 py-2">9.5-10.5 years</td><td class="border border-gray-300 px-4 py-2">Key Stage 2</td></tr><tr><td class="border border-gray-300 px-4 py-2">Year 5</td><td class="border border-gray-300 px-4 py-2">10.5-11.5 years</td><td class="border border-gray-300 px-4 py-2">Key Stage 2</td></tr><tr><td class="border border-gray-300 px-4 py-2">Year 6</td><td class="border border-gray-300 px-4 py-2">11.5-12.5 years</td><td class="border border-gray-300 px-4 py-2">Key Stage 2</td></tr></tbody></table></div><h3>Important Notes</h3><ul><li>Age requirements are based on the child\'s age as of January 1st of the academic year</li><li>For students transferring from other schools, grade placement may vary based on academic assessment</li><li>Students joining mid-year may require an evaluation to determine the appropriate year group</li><li>If your child\'s age falls between two year groups, please contact our admissions office for guidance</li></ul><h3>Need Help Determining the Right Year Group?</h3><p>If you\'re unsure which year group is appropriate for your child, or if your child has special circumstances (early/late birthday, transfer from another curriculum), please contact our Admissions Office. We\'ll be happy to assess your child and recommend the best placement.</p><p><strong>Contact Admissions:</strong> admissions@duhaschool.com</p>',
                'meta_title' => 'Student Year Group and Age Range - Duha International School',
                'meta_description' => 'Find the appropriate year group for your child based on their age at Duha International School. Complete age range guide for National and Cambridge curricula.',
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

    protected function seedStandalonePages(): void
    {
        // Tahfeez - Standalone Page (not under any category)
        Page::updateOrCreate(
            ['slug' => 'tahfeez'],
            [
                'title' => 'Tahfeez (Quran Memorization)',
                'parent_id' => null,
                'page_category' => null, // Standalone page
                'menu_title' => 'Tahfeez',
                'menu_order' => 7,
                'show_in_menu' => true,
                'menu_section' => 'main',
                'excerpt' => 'Comprehensive Tahfeez (Quran memorization) program combining Hifz with general academic education.',
                'content' => '<h2>Tahfeez Program at Duha International School</h2><p>The Tahfeez (Hifzul Quran) program at Duha International School offers students the precious opportunity to memorize the entire Quran while pursuing their general academic education.</p><h3>Program Overview</h3><p>Our Tahfeez program is designed to balance Quranic memorization with academic studies, ensuring students excel in both their spiritual and worldly education. This unique approach allows students to become Hafiz (one who has memorized the Quran) while earning recognized academic qualifications.</p><h3>Why Choose Our Tahfeez Program?</h3><ul><li><strong>Qualified Instructors:</strong> Experienced Huffaz (plural of Hafiz) with Ijazah (certification) in Quran recitation and memorization</li><li><strong>Structured Methodology:</strong> Proven memorization techniques ensuring steady progress and long-term retention</li><li><strong>Flexible Integration:</strong> Available alongside both National Curriculum and Cambridge International programs</li><li><strong>Small Class Sizes:</strong> Individualized attention with low student-teacher ratios</li><li><strong>Regular Assessment:</strong> Continuous monitoring of memorization progress and revision</li><li><strong>Supportive Environment:</strong> Islamic atmosphere encouraging spiritual growth</li></ul><h3>Curriculum Tracks</h3><p>Students can pursue Tahfeez with:</p><ul><li><strong>National Curriculum (English Version):</strong> Complete Hifz while preparing for SSC exams</li><li><strong>Cambridge International Curriculum:</strong> Combine Hifz with globally recognized qualifications</li></ul><h3>Daily Schedule</h3><p>A typical day for Tahfeez students includes:</p><ul><li><strong>Morning Session (6:00 AM - 8:00 AM):</strong> New memorization (Sabaq) and immediate revision</li><li><strong>Regular School Hours:</strong> Academic subjects following chosen curriculum</li><li><strong>Afternoon Session:</strong> Revision of recent memorization (Sabqi) and older portions (Manzil)</li></ul><h3>Memorization Method</h3><h4>1. New Memorization (Sabaq)</h4><p>Daily memorization of new verses with proper Tajweed under direct supervision of qualified teacher.</p><h4>2. Recent Revision (Sabqi)</h4><p>Regular revision of recently memorized portions to ensure retention.</p><h4>3. Long-term Revision (Manzil)</h4><p>Systematic revision of earlier memorized Juz (parts) to maintain entire Hifz.</p><h4>4. Tajweed Excellence</h4><p>Continuous focus on proper pronunciation, articulation, and Tajweed rules throughout memorization.</p><h3>Program Duration</h3><p>Typical completion time: <strong>4-6 years</strong></p><p>Duration varies based on:</p><ul><li>Student\'s starting age</li><li>Prior Quranic knowledge</li><li>Daily dedication and consistency</li><li>Memory capacity and retention ability</li></ul><h3>Admission Requirements</h3><ul><li>Ability to read Quran with basic Tajweed</li><li>Commitment to daily attendance and homework</li><li>Parent support and encouragement at home</li><li>Entrance assessment to determine starting point</li></ul><h3>Support Services</h3><ul><li>One-on-one revision sessions</li><li>Extra support for struggling students</li><li>Memory enhancement techniques training</li><li>Parent workshops on supporting Hifz at home</li><li>Regular progress reports</li></ul><h3>Graduation & Certification</h3><p>Upon successful completion, students:</p><ul><li>Receive Hafiz/Hafizah certification</li><li>Participate in special graduation ceremony</li><li>Complete full revision (Dawrah) before graduation</li><li>Pass comprehensive oral examination</li></ul><h3>Beyond Graduation</h3><p>Hafiz students can:</p><ul><li>Continue to higher Islamic education</li><li>Pursue university degrees with Hifz advantage</li><li>Teach Quran in Islamic institutions</li><li>Lead prayers in mosques</li><li>Serve as role models in their communities</li></ul><h3>Parent Involvement</h3><p>Success in Hifz requires strong parent support:</p><ul><li>Ensuring daily home revision</li><li>Attending monthly parent meetings</li><li>Creating conducive home environment</li><li>Encouraging and motivating your child</li><li>Monitoring progress and attendance</li></ul><h3>Admission Process</h3><ol><li><strong>Initial Inquiry:</strong> Contact admissions office for information</li><li><strong>Assessment:</strong> Student Quran reading and Tajweed assessment</li><li><strong>Interview:</strong> Meeting with Hifz coordinator and family</li><li><strong>Enrollment:</strong> Complete admission formalities</li><li><strong>Orientation:</strong> Attend program orientation session</li></ol><h3>Fees & Investment</h3><p>Tahfeez program fees vary by curriculum track chosen. Please refer to our fee structure pages or contact admissions for detailed fee information.</p><h3>Contact Us</h3><p>For more information about our Tahfeez program:</p><ul><li><strong>Email:</strong> tahfeez@duhaschool.com</li><li><strong>Phone:</strong> [Contact Number]</li><li><strong>Visit:</strong> Schedule a visit to meet our Hifz instructors</li></ul><p class="text-center text-xl font-bold text-aisd-midnight mt-8">Give your child the gift of carrying the Quran in their heart - Enroll in our Tahfeez program today!</p>',
                'meta_title' => 'Tahfeez (Quran Memorization) Program - Duha International School',
                'meta_description' => 'Comprehensive Tahfeez program at Duha International School combining Quran memorization (Hifz) with general academic education in National or Cambridge curriculum.',
                'is_published' => true,
                'is_featured' => true,
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
