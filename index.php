<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/includes/db.php';

// Try to load content from database
$pdo = null;
$dbServices = [];
$dbCourses = [];
$dbProjects = [];
$dbTeamMembers = [];

try {
    $pdo = getPDOConnection();
    
    // Check if tables exist and load content
    $dbServices = $pdo->query("SELECT * FROM services_content ORDER BY order_index, id")->fetchAll();
    $dbCourses = $pdo->query("SELECT * FROM courses_content ORDER BY order_index, id")->fetchAll();
    $dbProjects = $pdo->query("SELECT * FROM projects_content ORDER BY order_index, id")->fetchAll();
    $dbTeamMembers = $pdo->query("SELECT * FROM team_members ORDER BY order_index, id")->fetchAll();
} catch (PDOException $e) {
    // Tables don't exist yet, use defaults only
}

// Default Services
$defaultServices = [
    ['id' => 'resume-building',     'title' => 'Resume Building', 'icon' => 'fa-file-alt', 'description' => 'Professional, ATS-friendly resumes that stand out'],
    ['id' => 'portfolio-website',   'title' => 'Portfolio Website', 'icon' => 'fa-globe', 'description' => 'Stunning personal websites to showcase your work'],
    ['id' => 'branding-kit',        'title' => 'Branding Kit', 'icon' => 'fa-palette', 'description' => 'Complete brand identity for your projects'],
    ['id' => 'ai-automation',       'title' => 'AI Automation', 'icon' => 'fa-robot', 'description' => 'Smart automation solutions for productivity'],
    ['id' => 'web-app-development', 'title' => 'Web/App Development', 'icon' => 'fa-code', 'description' => 'Custom websites and mobile applications'],
    ['id' => 'career-guidance',     'title' => 'Career Guidance', 'icon' => 'fa-compass', 'description' => 'Personalized mentorship and career planning'],
    ['id' => 'social-media-design', 'title' => 'Social Media Design', 'icon' => 'fa-share-alt', 'description' => 'Eye-catching content for your social presence'],
    ['id' => 'freelance-consulting','title' => 'Freelance Consulting', 'icon' => 'fa-handshake', 'description' => 'Expert guidance for freelance projects'],
];

// Default Courses
$defaultCourses = [
    ['id' => 'ai-for-students', 'title' => 'AI for Students', 'icon' => 'fa-brain', 'badge' => 'Free', 'description' => 'Master AI tools and concepts for modern learning'],
    ['id' => 'ui-ux-basics',    'title' => 'UI/UX Basics', 'icon' => 'fa-pen-nib', 'badge' => 'Free', 'description' => 'Design beautiful, user-friendly interfaces'],
    ['id' => 'flutter-basics',  'title' => 'Flutter Basics', 'icon' => 'fa-mobile-alt', 'badge' => 'Free', 'description' => 'Build cross-platform mobile apps from scratch'],
    ['id' => 'career-roadmap',  'title' => 'Career Roadmap', 'icon' => 'fa-road', 'badge' => 'Free', 'description' => 'Navigate your path to success with clarity'],
    ['id' => 'web-development', 'title' => 'Web Development Bootcamp', 'icon' => 'fa-laptop-code', 'badge' => 'Free', 'description' => 'Master full-stack web development in 12 weeks'],
    ['id' => 'data-science',    'title' => 'Data Science Fundamentals', 'icon' => 'fa-chart-bar', 'badge' => 'Free', 'description' => 'Learn data analysis and visualization with Python'],
];

// Default Team Members
$defaultTeamMembers = [
    [
        'name' => 'Amandeep Singh',
        'role' => 'Founder & CEO',
        'skills' => 'Vision • Strategy • Storytelling',
        'img' => 'assets/images/member1.jpg',
        'icon' => 'fa-user',
        'github' => 'https://github.com/CodeMaster-AJ',
        'linkedin' => 'https://www.linkedin.com/in/amandeep-singh-jadhav-builds',
        'portfolio' => 'https://codemaster-aj.github.io/Portfolio/'
    ],
    [
        'name' => 'Rohit Rathod',
        'role' => 'Founder & COO',
        'skills' => 'Full-Stack • Data Analytics • Figma • Growth',
        'img' => 'assets/images/member2.jpg',
        'icon' => 'fa-user-tie',
        'github' => 'https://github.com/rohitrathod1',
        'linkedin' => 'https://www.linkedin.com/in/rohit-rathod-163292333/',
        'portfolio' => 'https://my-portfolio-2who.onrender.com'
    ],
    [
        'name' => 'Yuvraj Singh',
        'role' => 'CTO & Engineering',
        'skills' => 'PHP • MySQL • DevOps • Backend',
        'img' => 'assets/images/member3.jpg',
        'icon' => 'fa-code',
        'github' => 'https://github.com/',
        'linkedin' => 'https://www.linkedin.com/in/yuvraj-singh-018088308',
        'portfolio' => 'mailto:yuvrajas4074@gmail.com'
    ],
    [
        'name' => 'Kunal Singh',
        'role' => 'Design Director',
        'skills' => 'UI/UX • Figma • Branding • Motion Design',
        'img' => 'assets/images/member4.jpg',
        'icon' => 'fa-palette',
        'github' => '#',
        'linkedin' => 'https://www.linkedin.com/in/kunal-singh-panwar-49240b374',
        'portfolio' => 'mailto:kunalsinghpawar24@gmail.com'
    ],
    [
        'name' => 'Aman Singh',
        'role' => 'Lead Developer',
        'skills' => 'Full-Stack • APIs • Automation • Flutter',
        'img' => 'assets/images/member5.jpg',
        'icon' => 'fa-laptop-code',
        'github' => '#',
        'linkedin' => '#',
        'portfolio' => '#'
    ],
    [
        'name' => 'Narendra Singh',
        'role' => 'Community & Ops',
        'skills' => 'Events • Mentorship • Content • Outreach',
        'img' => 'assets/images/member6.jpg',
        'icon' => 'fa-users',
        'github' => '#',
        'linkedin' => 'https://www.linkedin.com/in/narendra-singh-b9a25631a',
        'portfolio' => '#'
    ],
];

// Merge database content with defaults
$allServices = array_merge($defaultServices, $dbServices);
$allCourses = array_merge($defaultCourses, $dbCourses);
$allProjects = $dbProjects ?: []; // Projects only from DB
$allTeamMembers = array_merge($defaultTeamMembers, $dbTeamMembers);

// Service Modals (for forms)
$serviceModals = array_map(function($s) {
    return ['id' => strtolower(str_replace(' ', '-', $s['title'] ?? $s['name'] ?? '')), 'title' => $s['title'] ?? $s['name'] ?? ''];
}, $allServices);

$courseModals = array_map(function($c) {
    return ['id' => strtolower(str_replace(' ', '-', $c['title'] ?? '')), 'title' => $c['title'] ?? ''];
}, $allCourses);

$aiToolModals = [
    ['id' => 'ai-resume-builder',   'title' => 'AI Resume Builder'],
    ['id' => 'notes-summarizer',    'title' => 'Notes Summarizer'],
    ['id' => 'study-planner',       'title' => 'Study Planner'],
    ['id' => 'skill-roadmap-ai',    'title' => 'Skill Roadmap AI'],
    ['id' => 'assignment-assistant','title' => 'Assignment Assistant'],
];

$meetupModals = [
    ['id' => 'weekly-tech-meetup', 'title' => 'Weekly Tech Meetup'],
    ['id' => 'masterclass-series', 'title' => 'Masterclass Series'],
    ['id' => 'student-podcast',    'title' => 'Student Innovators Podcast'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RaYnk Labs — Learn • Earn • Grow • Innovate</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/alert.php'; ?>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>
        <div class="container hero-content">
            <h1 class="hero-title fade-in">RaYnk Labs — Learn • Earn • Grow • Innovate</h1>
            <p class="hero-subtitle fade-in-delay">A student-led innovation lab building tools, education, and opportunities for youth.</p>
            <div class="hero-buttons fade-in-delay-2">
                <a href="#services" class="btn btn-primary">Explore Services</a>
                <a href="#community" class="btn btn-secondary">Join Community</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="mouse"></div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <h2 class="section-title">Who We Are</h2>
            <p class="about-text">RaYnk Labs is a student-led innovation hub dedicated to empowering young minds through cutting-edge education, real-world projects, and community-driven growth. We believe in learning by doing, earning while growing, and innovating for tomorrow.</p>
            <div class="about-grid">
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3>Innovation</h3>
                    <p>Building tomorrow's solutions today</p>
                </div>
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Learning</h3>
                    <p>Hands-on education for real skills</p>
                </div>
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Community</h3>
                    <p>Connect, collaborate, and grow together</p>
                </div>
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Opportunities</h3>
                    <p>Real projects, real impact, real growth</p>
                </div>
            </div>
        </div>
        <div class="wave-divider">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <h2 class="section-title">Our Services</h2>
            <div class="services-grid">
                <?php foreach ($allServices as $service): 
                    $serviceId = isset($service['id']) ? $service['id'] : strtolower(str_replace(' ', '-', $service['title'] ?? ''));
                    $serviceTitle = $service['title'] ?? '';
                    $serviceIcon = isset($service['icon']) ? (strpos($service['icon'], 'fa-') === 0 ? $service['icon'] : 'fa-' . $service['icon']) : 'fa-star';
                    $serviceDesc = $service['description'] ?? 'Professional service to help you grow';
                    $modalId = 'serviceModal-' . strtolower(str_replace(' ', '-', $serviceTitle));
                ?>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas <?= htmlspecialchars($serviceIcon) ?>"></i>
                    </div>
                    <h3><?= htmlspecialchars($serviceTitle) ?></h3>
                    <p><?= htmlspecialchars($serviceDesc) ?></p>
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">Get Service</button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="courses" id="courses">
        <div class="container">
            <h2 class="section-title">Our Courses</h2>
            <p class="section-subtitle">Learn from practical, student-friendly micro-courses</p>
            <div class="courses-grid">
                <?php foreach ($allCourses as $course): 
                    $courseTitle = $course['title'] ?? '';
                    $courseIcon = isset($course['icon']) ? (strpos($course['icon'], 'fa-') === 0 ? $course['icon'] : 'fa-' . $course['icon']) : 'fa-graduation-cap';
                    $courseBadge = $course['badge'] ?? 'Free';
                    $courseDesc = $course['description'] ?? 'Learn new skills and grow your career';
                    $modalId = 'courseModal-' . strtolower(str_replace(' ', '-', $courseTitle));
                ?>
                <div class="course-card">
                    <div class="course-badge"><?= htmlspecialchars($courseBadge) ?></div>
                    <div class="course-icon">
                        <i class="fas <?= htmlspecialchars($courseIcon) ?>"></i>
                    </div>
                    <h3><?= htmlspecialchars($courseTitle) ?></h3>
                    <p><?= htmlspecialchars($courseDesc) ?></p>
                    <button type="button" class="btn-enroll" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">Enroll Now</button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="wave-divider wave-flip">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
    </section>

    <!-- AI Tools Section -->
    <section class="ai-tools" id="ai-tools">
        <div class="container">
            <h2 class="section-title">AI-Powered Tools</h2>
            <p class="section-subtitle">Smart tools to supercharge your productivity</p>
            <div class="tools-grid">
                <div class="tool-card glow">
                    <div class="tool-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3>AI Resume Builder</h3>
                    <p>Create professional resumes in minutes with AI assistance</p>
                    <button type="button" class="tool-link" data-bs-toggle="modal" data-bs-target="#aiToolModal-ai-resume-builder">Try Now <i class="fas fa-arrow-right"></i></button>
                </div>
                <div class="tool-card glow">
                    <div class="tool-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>Notes Summarizer</h3>
                    <p>Instantly summarize your study notes with AI</p>
                    <button type="button" class="tool-link" data-bs-toggle="modal" data-bs-target="#aiToolModal-notes-summarizer">Try Now <i class="fas fa-arrow-right"></i></button>
                </div>
                <div class="tool-card glow">
                    <div class="tool-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Study Planner</h3>
                    <p>Smart schedules optimized for your learning style</p>
                    <button type="button" class="tool-link" data-bs-toggle="modal" data-bs-target="#aiToolModal-study-planner">Try Now <i class="fas fa-arrow-right"></i></button>
                </div>
                <div class="tool-card glow">
                    <div class="tool-icon">
                        <i class="fas fa-route"></i>
                    </div>
                    <h3>Skill Roadmap AI</h3>
                    <p>Personalized learning paths for any skill</p>
                    <button type="button" class="tool-link" data-bs-toggle="modal" data-bs-target="#aiToolModal-skill-roadmap-ai">Try Now <i class="fas fa-arrow-right"></i></button>
                </div>
                <div class="tool-card glow">
                    <div class="tool-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3>Assignment Assistant</h3>
                    <p>AI-powered help for your assignments</p>
                    <button type="button" class="tool-link" data-bs-toggle="modal" data-bs-target="#aiToolModal-assignment-assistant">Try Now <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section class="community" id="community">
        <div class="container">
            <div class="community-content">
                <div class="community-text">
                    <h2 class="section-title">RaYnk Innovators Club</h2>
                    <p class="community-description">Join a vibrant community of student innovators, creators, and learners. Connect, collaborate, and grow together.</p>
                    <div class="community-features">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Student-to-student learning</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Weekly tech meetups</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Exclusive podcasts</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>24/7 peer support</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-large" data-bs-toggle="modal" data-bs-target="#communityModal">Join Community — Free</button>
                </div>
                <div class="community-visual">
                    <div class="community-circle"></div>
                    <div class="community-icons">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Meetups & Podcasts Section -->
    <section class="meetups" id="meetups">
        <div class="container">
            <h2 class="section-title">Meetups & Podcasts</h2>
            <div class="meetups-grid">
                <div class="event-card">
                    <div class="event-badge">Free</div>
                    <div class="event-image">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <h3>Weekly Tech Meetup</h3>
                    <p class="event-date">Every Saturday, 6 PM IST</p>
                    <p>Join fellow students for tech discussions, project showcases, and networking</p>
                    <button type="button" class="btn-event" data-bs-toggle="modal" data-bs-target="#meetupModal-weekly-tech-meetup">Register</button>
                </div>
                <div class="event-card">
                    <div class="event-badge">Free</div>
                    <div class="event-image">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Masterclass Series</h3>
                    <p class="event-date">Monthly Sessions</p>
                    <p>Expert-led sessions on advanced topics in tech and entrepreneurship</p>
                    <button type="button" class="btn-event" data-bs-toggle="modal" data-bs-target="#meetupModal-masterclass-series">Register</button>
                </div>
                <div class="event-card">
                    <div class="event-badge">Free</div>
                    <div class="event-image">
                        <i class="fas fa-podcast"></i>
                    </div>
                    <h3>Student Innovators Podcast</h3>
                    <p class="event-date">Weekly Episodes</p>
                    <p>Stories, insights, and journeys of successful student entrepreneurs</p>
                    <button type="button" class="btn-event" data-bs-toggle="modal" data-bs-target="#meetupModal-student-podcast">Listen Now</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Turning Point App Section -->
    <section class="turning-point" id="turning-point">
    <div class="container">
        <div class="tp-content">

            <div class="tp-text">
                <h2>Turning Point App</h2>
                <p class="tp-description">
                    Your all-in-one platform for career growth, skill development, and scholarship opportunities.
                </p>

                <div class="tp-features">
                    <div class="tp-feature">
                        <i class="fas fa-graduation-cap"></i>
                        <div>
                            <h4>Scholarship Programs</h4>
                            <p>Access exclusive scholarship opportunities</p>
                        </div>
                    </div>

                    <div class="tp-feature">
                        <i class="fas fa-chart-line"></i>
                        <div>
                            <h4>Skill Tracking</h4>
                            <p>Monitor your progress and growth</p>
                        </div>
                    </div>

                    <div class="tp-feature">
                        <i class="fas fa-briefcase"></i>
                        <div>
                            <h4>Career Resources</h4>
                            <p>Tools and guidance for your career journey</p>
                        </div>
                    </div>
                </div>

                <a href="https://turning-point-01.onrender.com/" target="_blank" class="btn btn-primary btn-large">
                    <i class="fas fa-arrow-right"></i> Explore Turning Point
                </a>
            </div>

            <div class="phone-frame">
    
    <!-- Website inside screen -->
    <div class="iframe-screen">
        <iframe src="https://turning-point-01.onrender.com/" scrolling="no"></iframe>
    </div>

    <!-- Mobile mockup image -->
    <img src="assets/images/mocup.png" class="mockup-overlay">

</div>


        </div>
    </div>
</section>


    <!-- Team Section -->
<section class="team" id="team">
    <div class="container">
        <h2 class="section-title">Meet Our Team</h2>
        <p class="section-subtitle">Passionate students building the future</p>
        <div class="team-grid">
            <?php
            foreach ($allTeamMembers as $member):
                // Handle both default format (img) and database format (image)
                $imgPath = $member['img'] ?? $member['image'] ?? '';
                $imagePath = $imgPath ? __DIR__ . '/' . $imgPath : null;
                $imageExists = $imagePath && file_exists($imagePath);
                $imageSrc = $imageExists ? $imgPath : null;
                $memberIcon = $member['icon'] ?? 'fa-user';
                $memberSkills = $member['skills'] ?? '';
            ?>
            <div class="team-card">
                <div class="team-photo">
                    <?php if ($imageExists): ?>
                        <img src="<?= htmlspecialchars($imageSrc) ?>" alt="<?= htmlspecialchars($member['name']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="photo-placeholder">
                            <i class="fas <?= htmlspecialchars($memberIcon) ?>"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <h3><?= htmlspecialchars($member['name']) ?></h3>
                <p class="team-role"><?= htmlspecialchars($member['role']) ?></p>
                <div class="team-skills">
                    <?php 
                    // Handle both formats: "Skill1 • Skill2" and "Skill1, Skill2"
                    $skills = strpos($memberSkills, '•') !== false ? explode('•', $memberSkills) : explode(',', $memberSkills);
                    foreach ($skills as $skill): 
                        $skill = trim($skill);
                        if (!empty($skill)):
                    ?>
                        <span class="skill-badge"><?= htmlspecialchars($skill) ?></span>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
                <div class="team-links mt-3">
                    <?php if ($member['github'] !== '#'): ?>
                        <a href="<?= $member['github'] ?>" target="_blank" title="GitHub" class="team-link"><i class="fab fa-github"></i></a>
                    <?php endif; ?>
                    <?php if ($member['linkedin'] !== '#'): ?>
                        <a href="<?= $member['linkedin'] ?>" target="_blank" title="LinkedIn" class="team-link"><i class="fab fa-linkedin"></i></a>
                    <?php endif; ?>
                    <?php if ($member['portfolio'] !== '#' && !str_starts_with($member['portfolio'], 'mailto:')): ?>
                        <a href="<?= $member['portfolio'] ?>" target="_blank" title="Portfolio" class="team-link"><i class="fas fa-globe"></i></a>
                    <?php elseif (str_starts_with($member['portfolio'], 'mailto:')): ?>
                        <a href="<?= $member['portfolio'] ?>" title="Email" class="team-link"><i class="fas fa-envelope"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="wave-divider">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
</section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <h2 class="section-title">Get In Touch</h2>
            <div class="contact-content">
                <div class="contact-form-wrapper">
                    <form class="contact-form" action="includes/process_form.php" method="POST">
                        <input type="hidden" name="type" value="contact">
                        <input type="hidden" name="origin_title" value="Contact Form">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="Your Phone" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
                <div class="join-options">
                    <h3>Join RaYnk Labs</h3>
                    <div class="join-buttons">
                        <button type="button" class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#joinStudentModal">Join as Student</button>
                        <button type="button" class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#joinMentorModal">Join as Mentor</button>
                        <button type="button" class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#joinTeamModal">Join Team</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<!-- ==================== ALL MODALS (UPDATED COMMUNITY MODAL) ==================== -->

<?php foreach ($allServices as $service): 
    $serviceTitle = $service['title'] ?? '';
    $modalId = 'serviceModal-' . strtolower(str_replace(' ', '-', $serviceTitle));
?>
<div class="modal fade" id="<?= $modalId ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Request: <?= htmlspecialchars($serviceTitle); ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="includes/process_form.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="service">
                    <input type="hidden" name="origin_title" value="<?= htmlspecialchars($serviceTitle); ?>">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" class="form-control" name="name" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="tel" class="form-control" name="phone" required></div>
                    <div class="mb-3"><label class="form-label">Project Details</label><textarea class="form-control" name="message" rows="4" required></textarea></div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php foreach ($allCourses as $course): 
    $courseTitle = $course['title'] ?? '';
    $modalId = 'courseModal-' . strtolower(str_replace(' ', '-', $courseTitle));
?>
<div class="modal fade" id="<?= $modalId ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Enroll: <?= htmlspecialchars($courseTitle); ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="includes/process_form.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="course">
                    <input type="hidden" name="origin_title" value="<?= htmlspecialchars($courseTitle); ?>">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" class="form-control" name="name" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="tel" class="form-control" name="phone" required></div>
                    <div class="mb-3"><label class="form-label">Learning Goals</label><textarea class="form-control" name="message" rows="4" required></textarea></div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Maybe Later</button>
                    <button type="submit" class="btn btn-primary">Submit Enrollment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php foreach ($aiToolModals as $tool): ?>
<div class="modal fade" id="aiToolModal-<?= $tool['id']; ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Access: <?= htmlspecialchars($tool['title']); ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="includes/process_form.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="ai_tool">
                    <input type="hidden" name="origin_title" value="<?= htmlspecialchars($tool['title']); ?>">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" class="form-control" name="name" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="tel" class="form-control" name="phone" required></div>
                    <div class="mb-3"><label class="form-label">How will you use this tool?</label><textarea class="form-control" name="message" rows="4" required></textarea></div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Request Access</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php foreach ($meetupModals as $event): ?>
<div class="modal fade" id="meetupModal-<?= $event['id']; ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title"><?= htmlspecialchars($event['title']); ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="includes/process_form.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="meetup">
                    <input type="hidden" name="origin_title" value="<?= htmlspecialchars($event['title']); ?>">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" class="form-control" name="name" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="tel" class="form-control" name="phone" required></div>
                    <div class="mb-3"><label class="form-label">How would you like to participate?</label><textarea class="form-control" name="message" rows="4" required></textarea></div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit Interest</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<div class="modal fade" id="turningPointModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Turning Point App</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="includes/process_form.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="turning_point">
                    <input type="hidden" name="origin_title" value="Turning Point App">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" class="form-control" name="name" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="tel" class="form-control" name="phone" required></div>
                    <div class="mb-3"><label class="form-label">What do you want to explore?</label><textarea class="form-control" name="message" rows="4" required></textarea></div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Interest</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- UPDATED COMMUNITY MODAL — SKILLS INPUT -->
<div class="modal fade" id="communityModal" tabindex="-1" aria-labelledby="communityModalLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold" id="communityModalLabel">
                    Join: RaYnk Innovators Club
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="includes/process_form.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="community">
                    <input type="hidden" name="origin_title" value="RaYnk Innovators Club">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Full Name *</label>
                            <input type="text" class="form-control bg-secondary-subtle text-white border-0" name="name" placeholder="Your full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email *</label>
                            <input type="email" class="form-control bg-secondary-subtle text-white border-0" name="email" placeholder="your@email.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone *</label>
                            <input type="tel" class="form-control bg-secondary-subtle text-white border-0" name="phone" placeholder="+91 98765 43210" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Stream/Field *</label>
                            <input type="text" class="form-control bg-secondary-subtle text-white border-0" name="stream" placeholder="e.g., Computer Science, Commerce" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-primary mb-2">
                                <i class="fas fa-code"></i> Your Skills *
                            </label>
                            <input type="text" class="form-control bg-secondary-subtle text-white border-0" name="custom_skills" 
                                   placeholder="e.g., PHP, Laravel, React, Flutter, Python, Data Science" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">How do you want to contribute? *</label>
                            <textarea class="form-control bg-secondary-subtle text-white border-0" name="message" rows="4" 
                                      placeholder="Tell us how you can contribute to the community..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-5 fw-bold">
                        <i class="fas fa-paper-plane"></i> Join Community
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JOIN AS STUDENT MODAL -->
<div class="modal fade" id="joinStudentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">Join as Student</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="includes/process_form.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="community">
                    <input type="hidden" name="origin_title" value="Join as Student">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" class="form-control bg-secondary-subtle text-white border-0" name="name" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control bg-secondary-subtle text-white border-0" name="email" required></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="tel" class="form-control bg-secondary-subtle text-white border-0" name="phone" required></div>
                    <div class="mb-3"><label class="form-label">What are your learning goals?</label><textarea class="form-control bg-secondary-subtle text-white border-0" name="message" rows="4" placeholder="Tell us about your interests..." required></textarea></div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JOIN AS MENTOR MODAL -->
<div class="modal fade" id="joinMentorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">Join as Mentor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="includes/process_form.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="community">
                    <input type="hidden" name="origin_title" value="Join as Mentor">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" class="form-control bg-secondary-subtle text-white border-0" name="name" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control bg-secondary-subtle text-white border-0" name="email" required></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="tel" class="form-control bg-secondary-subtle text-white border-0" name="phone" required></div>
                    <div class="mb-3"><label class="form-label">What can you mentor on?</label><textarea class="form-control bg-secondary-subtle text-white border-0" name="message" rows="4" placeholder="Share your expertise..." required></textarea></div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JOIN TEAM MODAL -->
<div class="modal fade" id="joinTeamModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">Join Our Team</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="includes/process_form.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="type" value="community">
                    <input type="hidden" name="origin_title" value="Join Team">
                    <div class="mb-3"><label class="form-label">Full Name</label><input type="text" class="form-control bg-secondary-subtle text-white border-0" name="name" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control bg-secondary-subtle text-white border-0" name="email" required></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="tel" class="form-control bg-secondary-subtle text-white border-0" name="phone" required></div>
                    <div class="mb-3"><label class="form-label">Why do you want to join our team?</label><textarea class="form-control bg-secondary-subtle text-white border-0" name="message" rows="4" placeholder="Tell us about yourself..." required></textarea></div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
