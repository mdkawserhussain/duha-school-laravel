<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Principal\'s Message',
                'slug' => 'principal',
                'content' => '<div class="prose max-w-none">
                    <h2>Welcome to Duha International School</h2>
                    <p>As the Principal of Duha International School, I am delighted to welcome you to our institution. Our school is dedicated to providing a comprehensive education that combines the best of Islamic values with the Cambridge International Curriculum.</p>
                    
                    <h3>Our Mission</h3>
                    <p>At Duha International School, we strive to nurture well-rounded individuals who are not only academically excellent but also morally upright and socially responsible. We believe in fostering a love for learning while instilling Islamic values that guide our students throughout their lives.</p>
                    
                    <h3>Academic Excellence</h3>
                    <p>Our Cambridge curriculum ensures that our students receive a world-class education that is recognized globally. We prepare our students for international examinations while maintaining a strong foundation in Islamic studies and Arabic language.</p>
                    
                    <h3>Holistic Development</h3>
                    <p>Education at Duha goes beyond academics. We focus on character building, leadership skills, and community service. Our students are encouraged to participate in various extracurricular activities, sports, and community initiatives.</p>
                    
                    <h3>Our Commitment</h3>
                    <p>We are committed to providing a safe, nurturing, and inclusive environment where every student can thrive. Our dedicated faculty and staff work tirelessly to ensure that each child receives personalized attention and support.</p>
                    
                    <p>I invite you to explore our website, visit our campus, and discover what makes Duha International School a unique place for your child\'s educational journey.</p>
                    
                    <p><strong>May Allah guide us all in our pursuit of knowledge and excellence.</strong></p>
                </div>',
                'meta_title' => 'Principal\'s Message - Duha International School',
                'meta_description' => 'Read the Principal\'s welcome message and learn about our mission, values, and commitment to providing quality Islamic and Cambridge curriculum education.',
                'seo_keywords' => ['principal', 'message', 'welcome', 'mission', 'values'],
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Vision & Mission',
                'slug' => 'vision',
                'content' => '<div class="prose max-w-none">
                    <h2>Our Vision</h2>
                    <p>To be a leading international school that produces well-rounded, morally upright, and academically excellent individuals who contribute positively to society while maintaining strong Islamic values and identity.</p>
                    
                    <h2>Our Mission</h2>
                    <p>Duha International School is committed to providing a comprehensive education that:</p>
                    <ul>
                        <li>Integrates Islamic values with Cambridge International Curriculum</li>
                        <li>Fosters critical thinking, creativity, and problem-solving skills</li>
                        <li>Develops strong character and moral values</li>
                        <li>Prepares students for global citizenship while maintaining Islamic identity</li>
                        <li>Creates a nurturing and inclusive learning environment</li>
                        <li>Encourages community service and social responsibility</li>
                    </ul>
                    
                    <h2>Our Core Values</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <h3 class="text-xl font-semibold mb-2">Excellence</h3>
                            <p>We strive for excellence in all aspects of education and character development.</p>
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg">
                            <h3 class="text-xl font-semibold mb-2">Integrity</h3>
                            <p>We uphold the highest standards of honesty, ethics, and moral conduct.</p>
                        </div>
                        <div class="p-4 bg-yellow-50 rounded-lg">
                            <h3 class="text-xl font-semibold mb-2">Respect</h3>
                            <p>We treat everyone with dignity and respect, fostering a culture of mutual understanding.</p>
                        </div>
                        <div class="p-4 bg-purple-50 rounded-lg">
                            <h3 class="text-xl font-semibold mb-2">Innovation</h3>
                            <p>We embrace innovative teaching methods and technologies to enhance learning.</p>
                        </div>
                    </div>
                </div>',
                'meta_title' => 'Vision & Mission - Duha International School',
                'meta_description' => 'Learn about our vision, mission, and core values that guide Duha International School in providing quality education.',
                'seo_keywords' => ['vision', 'mission', 'values', 'goals', 'objectives'],
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Curriculum',
                'slug' => 'curriculum',
                'content' => '<div class="prose max-w-none">
                    <h2>Our Curriculum</h2>
                    <p>Duha International School offers a comprehensive curriculum that combines the Cambridge International Curriculum with Islamic Studies, ensuring our students receive a well-rounded education.</p>
                    
                    <h3>Cambridge International Curriculum</h3>
                    <p>We follow the Cambridge International Curriculum, which is recognized worldwide for its academic rigor and international perspective. This curriculum prepares students for:</p>
                    <ul>
                        <li>Cambridge IGCSE (International General Certificate of Secondary Education)</li>
                        <li>Cambridge AS and A Levels</li>
                        <li>International university admissions</li>
                    </ul>
                    
                    <h3>Core Subjects</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-blue-100">
                                    <th class="border border-gray-300 px-4 py-2">Grade Level</th>
                                    <th class="border border-gray-300 px-4 py-2">Core Subjects</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-semibold">Primary (Grades 1-5)</td>
                                    <td class="border border-gray-300 px-4 py-2">English, Mathematics, Science, Islamic Studies, Arabic, Social Studies, Art, Physical Education</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-semibold">Middle School (Grades 6-8)</td>
                                    <td class="border border-gray-300 px-4 py-2">English, Mathematics, Science, Islamic Studies, Arabic, History, Geography, Computer Studies, Art, Physical Education</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-semibold">High School (Grades 9-12)</td>
                                    <td class="border border-gray-300 px-4 py-2">Cambridge IGCSE subjects, Islamic Studies, Arabic, Advanced Mathematics, Sciences, Languages, Social Sciences</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <h3>Islamic Studies Program</h3>
                    <p>Our Islamic Studies program includes:</p>
                    <ul>
                        <li>Quranic Studies and Memorization</li>
                        <li>Islamic History and Civilization</li>
                        <li>Fiqh (Islamic Jurisprudence)</li>
                        <li>Aqeedah (Islamic Creed)</li>
                        <li>Seerah (Prophetic Biography)</li>
                        <li>Arabic Language</li>
                    </ul>
                    
                    <h3>Assessment and Evaluation</h3>
                    <p>We use a combination of:</p>
                    <ul>
                        <li>Continuous assessment through assignments and projects</li>
                        <li>Regular examinations and tests</li>
                        <li>Cambridge International examinations</li>
                        <li>Portfolio assessments</li>
                        <li>Practical assessments for science and arts subjects</li>
                    </ul>
                    
                    <h3>Extracurricular Activities</h3>
                    <p>Beyond academics, we offer various extracurricular activities including sports, arts, debate, science clubs, and community service programs.</p>
                </div>',
                'meta_title' => 'Curriculum - Duha International School',
                'meta_description' => 'Explore our comprehensive curriculum combining Cambridge International Curriculum with Islamic Studies for grades 1-12.',
                'seo_keywords' => ['curriculum', 'cambridge', 'igcse', 'islamic studies', 'education'],
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'School Policies',
                'slug' => 'policies',
                'content' => '<div class="prose max-w-none">
                    <h2>School Policies</h2>
                    <p>Duha International School maintains comprehensive policies to ensure a safe, respectful, and productive learning environment for all students, staff, and parents.</p>
                    
                    <h3>Admission Policy</h3>
                    <ul>
                        <li>Admissions are open to students of all backgrounds who respect our Islamic values</li>
                        <li>Students must meet age requirements for their grade level</li>
                        <li>Previous academic records and assessments may be required</li>
                        <li>Parents/guardians must agree to support the school\'s policies and values</li>
                    </ul>
                    
                    <h3>Attendance Policy</h3>
                    <ul>
                        <li>Regular attendance is mandatory for all students</li>
                        <li>Absences must be reported to the school office</li>
                        <li>Medical certificates are required for extended absences</li>
                        <li>Excessive absences may affect academic progress and promotion</li>
                    </ul>
                    
                    <h3>Dress Code</h3>
                    <ul>
                        <li>Students must wear the official school uniform</li>
                        <li>Uniforms must be clean, neat, and properly worn</li>
                        <li>Modest dress is required in accordance with Islamic principles</li>
                        <li>Additional guidelines are provided in the student handbook</li>
                    </ul>
                    
                    <h3>Behavioral Expectations</h3>
                    <ul>
                        <li>Respect for teachers, staff, and fellow students</li>
                        <li>Punctuality and responsibility</li>
                        <li>Honesty and integrity in all academic work</li>
                        <li>Respect for school property and facilities</li>
                        <li>Adherence to Islamic values and principles</li>
                    </ul>
                    
                    <h3>Academic Integrity</h3>
                    <ul>
                        <li>Plagiarism and cheating are strictly prohibited</li>
                        <li>Students must complete their own work</li>
                        <li>Proper citation is required for research projects</li>
                        <li>Violations may result in academic penalties</li>
                    </ul>
                    
                    <h3>Discipline Policy</h3>
                    <ul>
                        <li>Progressive discipline approach focusing on correction and guidance</li>
                        <li>Clear communication with parents regarding behavioral issues</li>
                        <li>Support services available for students needing additional help</li>
                        <li>Serious violations may result in suspension or expulsion</li>
                    </ul>
                    
                    <h3>Parental Involvement</h3>
                    <ul>
                        <li>Regular parent-teacher conferences</li>
                        <li>Open communication channels with school administration</li>
                        <li>Parent volunteer opportunities</li>
                        <li>Support for school events and activities</li>
                    </ul>
                    
                    <h3>Health and Safety</h3>
                    <ul>
                        <li>Medical information must be updated regularly</li>
                        <li>Emergency contact information must be current</li>
                        <li>Health and safety protocols are strictly enforced</li>
                        <li>Emergency procedures are practiced regularly</li>
                    </ul>
                    
                    <p><strong>Note:</strong> For detailed information on any policy, please contact the school administration or refer to the complete student handbook.</p>
                </div>',
                'meta_title' => 'School Policies - Duha International School',
                'meta_description' => 'Review our comprehensive school policies including admission, attendance, dress code, behavior, and academic integrity policies.',
                'seo_keywords' => ['policies', 'rules', 'guidelines', 'admission', 'attendance'],
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Visit Our Campus',
                'slug' => 'campus',
                'content' => '<div class="prose max-w-none">
                    <h2>Welcome to Our Campus</h2>
                    <p>Duha International School is located in the heart of Chittagong, providing a modern and conducive learning environment for our students.</p>
                    
                    <h3>Campus Facilities</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Modern Classrooms</h4>
                            <p>Well-equipped classrooms with smart boards and modern teaching aids to enhance the learning experience.</p>
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Science Laboratories</h4>
                            <p>State-of-the-art laboratories for Physics, Chemistry, and Biology with all necessary equipment and safety measures.</p>
                        </div>
                        <div class="p-4 bg-yellow-50 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Library & Resource Center</h4>
                            <p>Extensive collection of books, digital resources, and quiet study areas for students.</p>
                        </div>
                        <div class="p-4 bg-purple-50 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Sports Facilities</h4>
                            <p>Spacious playground, basketball court, and indoor sports facilities for physical education and extracurricular activities.</p>
                        </div>
                        <div class="p-4 bg-pink-50 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Masjid</h4>
                            <p>Beautiful on-campus masjid for daily prayers and Islamic activities.</p>
                        </div>
                        <div class="p-4 bg-indigo-50 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Computer Labs</h4>
                            <p>Fully equipped computer laboratories with high-speed internet for technology education.</p>
                        </div>
                    </div>
                    
                    <h3>Location</h3>
                    <p><strong>Address:</strong> House-131/1, Road-01, South Khulshi, Chittagong, Bangladesh</p>
                    <p><strong>Phone:</strong> +880-1766-500001, +880-1835-318137</p>
                    <p><strong>Email:</strong> info@duhainternationalschool.com</p>
                    
                    <h3>Office Hours</h3>
                    <ul>
                        <li><strong>Sunday - Thursday:</strong> 9:00 AM - 5:00 PM</li>
                        <li><strong>Friday - Saturday:</strong> Closed</li>
                    </ul>
                    
                    <h3>Schedule a Visit</h3>
                    <p>We welcome prospective students and parents to visit our campus. Please contact our admissions office to schedule a tour. Our friendly staff will be happy to show you around and answer any questions you may have.</p>
                </div>',
                'meta_title' => 'Visit Our Campus - Duha International School',
                'meta_description' => 'Explore our modern campus facilities including classrooms, laboratories, library, sports facilities, and more. Schedule a visit today.',
                'seo_keywords' => ['campus', 'facilities', 'visit', 'tour', 'location'],
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<div class="prose max-w-none">
                    <h2>Privacy Policy</h2>
                    <p><strong>Last Updated:</strong> ' . now()->format('F d, Y') . '</p>
                    
                    <p>Duha International School ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p>
                    
                    <h3>Information We Collect</h3>
                    <p>We may collect information that you provide directly to us, including:</p>
                    <ul>
                        <li>Name and contact information (email, phone number, address)</li>
                        <li>Student information for admission applications</li>
                        <li>Employment information for career applications</li>
                        <li>Any other information you choose to provide</li>
                    </ul>
                    
                    <h3>How We Use Your Information</h3>
                    <p>We use the information we collect to:</p>
                    <ul>
                        <li>Process admission and career applications</li>
                        <li>Respond to your inquiries and requests</li>
                        <li>Improve our website and services</li>
                        <li>Comply with legal obligations</li>
                    </ul>
                    
                    <h3>Information Sharing</h3>
                    <p>We do not sell, trade, or rent your personal information to third parties. We may share your information only in the following circumstances:</p>
                    <ul>
                        <li>With your consent</li>
                        <li>To comply with legal obligations</li>
                        <li>To protect our rights and safety</li>
                        <li>With service providers who assist us in operating our website</li>
                    </ul>
                    
                    <h3>Data Security</h3>
                    <p>We implement appropriate security measures to protect your personal information. However, no method of transmission over the internet is 100% secure.</p>
                    
                    <h3>Your Rights</h3>
                    <p>You have the right to:</p>
                    <ul>
                        <li>Access your personal information</li>
                        <li>Correct inaccurate information</li>
                        <li>Request deletion of your information</li>
                    </ul>
                    
                    <h3>Contact Us</h3>
                    <p>If you have questions about this Privacy Policy, please contact us at:</p>
                    <p><strong>Email:</strong> info@duhainternationalschool.com<br>
                    <strong>Phone:</strong> +880-1766-500001</p>
                </div>',
                'meta_title' => 'Privacy Policy - Duha International School',
                'meta_description' => 'Read our privacy policy to understand how we collect, use, and protect your personal information.',
                'seo_keywords' => ['privacy', 'policy', 'data protection', 'privacy rights'],
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => '<div class="prose max-w-none">
                    <h2>Terms of Service</h2>
                    <p><strong>Last Updated:</strong> ' . now()->format('F d, Y') . '</p>
                    
                    <p>Please read these Terms of Service ("Terms") carefully before using the Duha International School website.</p>
                    
                    <h3>Acceptance of Terms</h3>
                    <p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.</p>
                    
                    <h3>Use License</h3>
                    <p>Permission is granted to temporarily download one copy of the materials on our website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
                    <ul>
                        <li>Modify or copy the materials</li>
                        <li>Use the materials for any commercial purpose</li>
                        <li>Attempt to decompile or reverse engineer any software</li>
                        <li>Remove any copyright or other proprietary notations</li>
                    </ul>
                    
                    <h3>User Accounts</h3>
                    <p>If you create an account on our website, you are responsible for maintaining the security of your account and password. You agree to accept responsibility for all activities that occur under your account.</p>
                    
                    <h3>Prohibited Uses</h3>
                    <p>You may not use our website:</p>
                    <ul>
                        <li>In any way that violates any applicable law or regulation</li>
                        <li>To transmit any malicious code or viruses</li>
                        <li>To impersonate or attempt to impersonate the school or any person</li>
                        <li>To engage in any automated use of the system</li>
                    </ul>
                    
                    <h3>Intellectual Property</h3>
                    <p>All content on this website, including text, graphics, logos, images, and software, is the property of Duha International School and is protected by copyright and other intellectual property laws.</p>
                    
                    <h3>Disclaimer</h3>
                    <p>The materials on our website are provided on an "as is" basis. We make no warranties, expressed or implied, and hereby disclaim all other warranties including implied warranties of merchantability or fitness for a particular purpose.</p>
                    
                    <h3>Limitation of Liability</h3>
                    <p>In no event shall Duha International School or its suppliers be liable for any damages arising out of the use or inability to use the materials on our website.</p>
                    
                    <h3>Revisions</h3>
                    <p>We may revise these terms of service at any time without notice. By using this website, you are agreeing to be bound by the then current version of these terms of service.</p>
                    
                    <h3>Contact Information</h3>
                    <p>If you have any questions about these Terms of Service, please contact us at:</p>
                    <p><strong>Email:</strong> info@duhainternationalschool.com<br>
                    <strong>Phone:</strong> +880-1766-500001</p>
                </div>',
                'meta_title' => 'Terms of Service - Duha International School',
                'meta_description' => 'Read our terms of service to understand the rules and regulations for using our website.',
                'seo_keywords' => ['terms', 'service', 'agreement', 'legal', 'conditions'],
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}


