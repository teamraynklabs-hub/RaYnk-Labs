<?php
declare(strict_types=1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RaYnk Labs — Learn • Earn • Grow • Innovate</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/alert.php'; ?>

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
                <a href="/projects/RaYnk-Labs/public/services.php" class="btn btn-primary">Explore Services</a>
                <a href="#team" class="btn btn-secondary">Meet Team</a>
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

    <!-- Meetups & Podcasts Section -->
    <section class="meetups" id="meetups">
        <div class="container">
            <h2 class="section-title">Meetups & Podcasts</h2>
            <p class="section-subtitle">Stay connected with our community events</p>
            <div class="meetups-grid">
                <div class="event-card">
                    <div class="event-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Weekly Tech Meetup</h3>
                    <p>Every Thursday • Online & Offline</p>
                    <p class="text-muted small">Join our community for weekly tech discussions, project showcases, and networking.</p>
                    <a href="https://link.raynklabs.com/meetup" target="_blank" class="btn btn-outline mt-3">Join Now</a>
                </div>
                <div class="event-card">
                    <div class="event-icon">
                        <i class="fas fa-presentation"></i>
                    </div>
                    <h3>Masterclass Series</h3>
                    <p>Monthly • Expert Sessions</p>
                    <p class="text-muted small">Learn from industry experts and experienced developers in our exclusive masterclasses.</p>
                    <a href="https://link.raynklabs.com/masterclass" target="_blank" class="btn btn-outline mt-3">Register</a>
                </div>
                <div class="event-card">
                    <div class="event-icon">
                        <i class="fas fa-microphone"></i>
                    </div>
                    <h3>Student Innovators Podcast</h3>
                    <p>Bi-weekly • Audio Series</p>
                    <p class="text-muted small">Stories of student innovations, startup journeys, and career insights.</p>
                    <a href="https://link.raynklabs.com/podcast" target="_blank" class="btn btn-outline mt-3">Subscribe</a>
                </div>
            </div>
        </div>
        <div class="wave-divider">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
    </section>

    <!-- Turning Point Section -->
    <section class="tp-section" id="turning-point">
        <div class="container">
            <div class="tp-content">
                <div class="tp-text">
                    <div class="tp-badge">
                        <span class="badge-text">🚀 Innovation at Core</span>
                    </div>
                    <h2>Turning Point App</h2>
                    <p class="tp-description">An all-in-one platform designed to revolutionize how students learn, collaborate, and grow in the digital age.</p>
                    
                    <div class="tp-features">
                        <div class="tp-feature">
                            <i class="fas fa-chart-line"></i>
                            <div>
                                <h4>Smart Analytics</h4>
                                <p>Track your learning progress and growth metrics</p>
                            </div>
                        </div>
                        <div class="tp-feature">
                            <i class="fas fa-users"></i>
                            <div>
                                <h4>Community Hub</h4>
                                <p>Connect with thousands of like-minded learners</p>
                            </div>
                        </div>
                        <div class="tp-feature">
                            <i class="fas fa-tasks"></i>
                            <div>
                                <h4>Project Management</h4>
                                <p>Organize your ideas and collaborate seamlessly</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="https://app.raynklabs.com" target="_blank" class="btn btn-primary">Launch App</a>
                </div>
                <div class="tp-mockup">
                    <div class="phone-mockup">
                        <div class="mockup-screen">
                            <div style="padding: 20px; text-align: center;">
                                <i class="fas fa-mobile-alt" style="font-size: 48px; color: #3BA7FF;"></i>
                                <p style="margin-top: 15px; color: rgba(255,255,255,0.7);">Coming Soon</p>
                            </div>
                        </div>
                    </div>
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
                $teamMembers = [
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

                foreach ($teamMembers as $member):
                    $imagePath = __DIR__ . '/../' . $member['img'];
                    $imageExists = file_exists($imagePath);
                    $imageSrc = $imageExists ? '../' . $member['img'] : null;
                ?>
                <div class="team-card">
                    <div class="team-photo">
                        <?php if ($imageExists): ?>
                            <img src="<?= htmlspecialchars($imageSrc) ?>" alt="<?= htmlspecialchars($member['name']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="photo-placeholder">
                                <i class="fas <?= htmlspecialchars($member['icon']) ?>"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h3><?= htmlspecialchars($member['name']) ?></h3>
                    <p class="team-role"><?= htmlspecialchars($member['role']) ?></p>
                    <div class="team-skills">
                        <?php foreach (array_map('trim', explode('•', $member['skills'])) as $skill): ?>
                            <span class="skill-badge"><?= htmlspecialchars($skill) ?></span>
                        <?php endforeach; ?>
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
                    <form class="contact-form" action="../includes/process_form.php" method="POST">
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

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.js"></script>
</body>
</html>
