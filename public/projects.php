<?php
declare(strict_types=1);
session_start();

$projects = [
    [
        'id' => 1,
        'name' => 'Business Name Generator',
        'description' => 'AI-powered tool that generates creative and unique business names based on your industry and preferences. Perfect for startups and entrepreneurs looking for the perfect brand name.',
        'tech' => 'React.js, Node.js, MongoDB, AI APIs',
        'url' => 'https://book-irql.onrender.com',
        'icon' => 'fa-lightbulb',
        'status' => 'Live'
    ],
    [
        'id' => 2,
        'name' => 'Spotify Clone',
        'description' => 'Full-featured music streaming application with playlist management, user authentication, and real-time playback controls. Features a modern UI built with React and integrates with music APIs.',
        'tech' => 'React.js, Node.js, Express, PostgreSQL',
        'url' => 'https://spotify-clone-r4o0.onrender.com',
        'icon' => 'fa-music',
        'status' => 'Live'
    ],
    [
        'id' => 3,
        'name' => 'URL Shortener',
        'description' => 'Efficient URL shortening service that converts long URLs into short, shareable links. Includes analytics, custom slugs, and expiration settings for better link management.',
        'tech' => 'Next.js, Vercel, Firebase, Tailwind CSS',
        'url' => 'https://url-shortner-self-seven.vercel.app',
        'icon' => 'fa-link',
        'status' => 'Live'
    ],
    [
        'id' => 4,
        'name' => 'Portfolio Builder',
        'description' => 'Drag-and-drop portfolio creation platform that helps developers and designers showcase their work. Includes templates, analytics, and SEO optimization.',
        'tech' => 'Vue.js, Laravel, MySQL, Bootstrap',
        'url' => '#',
        'icon' => 'fa-briefcase',
        'status' => 'Coming Soon'
    ],
    [
        'id' => 5,
        'name' => 'AI Learning Assistant',
        'description' => 'Smart learning companion that uses AI to personalize study materials, create quizzes, and provide instant doubt-solving assistance for students across all subjects.',
        'tech' => 'Python, Flask, TensorFlow, React',
        'url' => '#',
        'icon' => 'fa-graduation-cap',
        'status' => 'Coming Soon'
    ],
    [
        'id' => 6,
        'name' => 'Social Analytics Dashboard',
        'description' => 'Comprehensive analytics platform for social media managers. Track engagement, analyze trends, and optimize content performance across multiple platforms in real-time.',
        'tech' => 'React.js, Django, PostgreSQL, D3.js',
        'url' => '#',
        'icon' => 'fa-chart-line',
        'status' => 'Coming Soon'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Projects — RaYnk Labs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .project-header {
            background: linear-gradient(135deg, #3BA7FF, #A26BFF);
            padding: 60px 0;
            text-align: center;
            margin-bottom: 50px;
        }
        .project-header h1 {
            font-size: 48px;
            font-weight: 800;
            color: white;
            margin-bottom: 15px;
        }
        .project-header p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
        }
        .projects-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 50px 0;
        }
        .project-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(59, 167, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .project-card:hover {
            transform: translateY(-10px);
            border-color: var(--neon-blue);
            background: rgba(59, 167, 255, 0.1);
            box-shadow: 0 20px 60px rgba(59, 167, 255, 0.3);
        }
        .project-icon {
            font-size: 48px;
            color: var(--neon-blue);
            margin-bottom: 15px;
        }
        .project-status {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 15px;
            width: fit-content;
        }
        .status-live {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            border: 1px solid #4CAF50;
        }
        .status-coming {
            background: rgba(255, 193, 7, 0.2);
            color: #FFC107;
            border: 1px solid #FFC107;
        }
        .project-card h3 {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin: 15px 0;
        }
        .project-card p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 15px;
            line-height: 1.6;
            flex-grow: 1;
            margin-bottom: 15px;
        }
        .tech-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 15px 0;
        }
        .tech-tag {
            background: rgba(59, 167, 255, 0.15);
            color: var(--neon-blue);
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }
        .project-link {
            display: inline-block;
            margin-top: auto;
            padding: 12px 30px;
            background: var(--neon-blue);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
        }
        .project-card:hover .project-link {
            background: var(--electric-purple);
            transform: translateX(5px);
        }
        .project-link.disabled {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            cursor: not-allowed;
        }
        @media (max-width: 1200px) {
            .projects-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .project-header {
                padding: 40px 20px;
            }
            .project-header h1 {
                font-size: 32px;
            }
            .projects-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .project-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Project Header -->
    <div class="project-header" style="margin-top: 70px;">
        <div class="container">
            <h1>Our Projects</h1>
            <p>Showcasing innovation and excellence through real-world applications</p>
        </div>
    </div>

    <!-- Projects Grid -->
    <section class="projects">
        <div class="container">
            <div class="projects-container">
                <?php foreach ($projects as $project): ?>
                    <div class="project-card">
                        <div class="project-icon">
                            <i class="fas <?= $project['icon'] ?>"></i>
                        </div>
                        <h3><?= htmlspecialchars($project['name']) ?></h3>
                        <p><?= htmlspecialchars($project['description']) ?></p>
                        
                        <div class="tech-stack">
                            <?php 
                            $techs = explode(', ', $project['tech']);
                            foreach (array_slice($techs, 0, 3) as $tech): 
                            ?>
                                <span class="tech-tag"><?= htmlspecialchars($tech) ?></span>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="project-status <?= $project['status'] === 'Live' ? 'status-live' : 'status-coming' ?>">
                                <i class="fas <?= $project['status'] === 'Live' ? 'fa-check-circle' : 'fa-clock' ?>"></i>
                                <?= $project['status'] ?>
                            </span>
                        </div>
                        
                        <?php if ($project['status'] === 'Live'): ?>
                            <a href="<?= htmlspecialchars($project['url']) ?>" target="_blank" class="project-link">
                                View Project <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        <?php else: ?>
                            <span class="project-link disabled">
                                Coming Soon <i class="fas fa-hourglass-end ms-2"></i>
                            </span>
                        <?php endif; ?>
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
