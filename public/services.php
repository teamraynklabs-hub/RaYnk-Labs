<?php
declare(strict_types=1);
session_start();

$services = [
    [
        'id' => 1,
        'name' => 'Resume Building',
        'description' => 'Professional, ATS-friendly resumes that stand out. Our expert team crafts compelling resumes that pass automated screening and impress hiring managers.',
        'icon' => 'fa-file-alt',
        'features' => ['ATS Optimization', 'Professional Design', 'Expert Review', 'Free Revisions', 'Quick Turnaround', 'Guaranteed Results']
    ],
    [
        'id' => 2,
        'name' => 'Portfolio Website',
        'description' => 'Stunning personal websites to showcase your work. Build a professional online presence that attracts clients and employers.',
        'icon' => 'fa-globe',
        'features' => ['Responsive Design', 'Custom Domain', 'Fast Hosting', 'SEO Optimized', 'Analytics Dashboard', 'Lifetime Support']
    ],
    [
        'id' => 3,
        'name' => 'Branding Kit',
        'description' => 'Complete branding solutions including logo, color schemes, typography, and brand guidelines. Establish a strong, consistent brand identity.',
        'icon' => 'fa-palette',
        'features' => ['Logo Design', 'Color Palette', 'Typography Guide', 'Brand Story', 'Social Media Kit', 'Unlimited Revisions']
    ],
    [
        'id' => 4,
        'name' => 'AI Automation',
        'description' => 'Automate repetitive tasks with AI-powered solutions. Increase productivity and reduce operational costs significantly.',
        'icon' => 'fa-robot',
        'features' => ['Workflow Automation', 'Data Processing', 'Email Automation', 'Report Generation', 'Integration Setup', 'Training & Support']
    ],
    [
        'id' => 5,
        'name' => 'Web/App Development',
        'description' => 'Custom web and mobile applications built with latest technologies. Scalable, secure, and user-friendly solutions for your business.',
        'icon' => 'fa-code',
        'features' => ['Full Stack Development', 'Mobile Responsive', 'Cloud Deployment', 'API Integration', 'Testing & QA', 'Post-Launch Support']
    ],
    [
        'id' => 6,
        'name' => 'Career Guidance',
        'description' => 'Personalized career mentoring and guidance from industry experts. Navigate your career path with confidence and clarity.',
        'icon' => 'fa-compass',
        'features' => ['Career Assessment', 'Skill Development', 'Mock Interviews', 'Job Search Strategy', 'Salary Negotiation', 'Ongoing Mentorship']
    ],
    [
        'id' => 7,
        'name' => 'Social Media Design',
        'description' => 'Eye-catching graphics and designs optimized for social media. Boost engagement and grow your online presence.',
        'icon' => 'fa-image',
        'features' => ['Post Design', 'Story Templates', 'Video Graphics', 'Banner Design', 'Brand Consistency', 'Revision Rounds']
    ],
    [
        'id' => 8,
        'name' => 'Freelance Consulting',
        'description' => 'Expert consulting for freelancers. Learn how to scale your business, manage clients, and increase earnings.',
        'icon' => 'fa-briefcase',
        'features' => ['Business Strategy', 'Client Management', 'Pricing Strategy', 'Time Management', 'Marketing Tips', 'Network Access']
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services — RaYnk Labs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .services-header {
            background: linear-gradient(135deg, #A26BFF, #3BA7FF);
            padding: 60px 0;
            text-align: center;
            margin-bottom: 50px;
        }
        .services-header h1 {
            font-size: 48px;
            font-weight: 800;
            color: white;
            margin-bottom: 15px;
        }
        .services-header p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
        }
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 50px 0;
        }
        .service-card-full {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(162, 107, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.4s ease;
        }
        .service-card-full:hover {
            transform: translateY(-10px);
            border-color: var(--electric-purple);
            background: rgba(162, 107, 255, 0.1);
            box-shadow: 0 20px 60px rgba(162, 107, 255, 0.3);
        }
        .service-icon {
            font-size: 48px;
            color: var(--electric-purple);
            margin-bottom: 20px;
        }
        .service-card-full h3 {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin: 15px 0;
        }
        .service-card-full p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .features-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .feature-badge {
            background: rgba(162, 107, 255, 0.15);
            color: var(--electric-purple);
            padding: 6px 14px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid rgba(162, 107, 255, 0.3);
        }
        .cta-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: var(--electric-purple);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .service-card-full:hover .cta-button {
            transform: translateX(5px);
            background: var(--neon-blue);
        }
        @media (max-width: 1200px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .services-header {
                padding: 40px 20px;
            }
            .services-header h1 {
                font-size: 32px;
            }
            .services-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .service-card-full {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Services Header -->
    <div class="services-header" style="margin-top: 70px;">
        <div class="container">
            <h1>Our Services</h1>
            <p>Transform your career with our comprehensive service offerings</p>
        </div>
    </div>

    <!-- Services Grid -->
    <section>
        <div class="container">
            <div class="services-grid">
                <?php foreach ($services as $service): ?>
                    <div class="service-card-full">
                        <div class="service-icon">
                            <i class="fas <?= $service['icon'] ?>"></i>
                        </div>
                        <h3><?= htmlspecialchars($service['name']) ?></h3>
                        <p><?= htmlspecialchars($service['description']) ?></p>
                        
                        <div class="features-list">
                            <?php foreach ($service['features'] as $feature): ?>
                                <span class="feature-badge"><i class="fas fa-check-circle me-1"></i><?= htmlspecialchars($feature) ?></span>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" class="cta-button" data-bs-toggle="modal" data-bs-target="#serviceModal">
                            Get Service <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
