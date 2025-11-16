<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../includes/db.php';

if (empty($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$pdo = getPDOConnection();

// Create tables if they don't exist
$createTables = "
CREATE TABLE IF NOT EXISTS `services_content` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `icon` VARCHAR(100) NOT NULL,
  `features` TEXT,
  `order_index` INT DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `courses_content` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `icon` VARCHAR(100) NOT NULL,
  `badge` VARCHAR(50) DEFAULT 'Free',
  `duration` VARCHAR(50),
  `level` VARCHAR(50),
  `order_index` INT DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `projects_content` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `tech` TEXT,
  `url` VARCHAR(500),
  `icon` VARCHAR(100) NOT NULL,
  `status` VARCHAR(50) DEFAULT 'Coming Soon',
  `order_index` INT DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `team_members` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL,
  `skills` TEXT NOT NULL,
  `image` VARCHAR(500),
  `icon` VARCHAR(100),
  `github` VARCHAR(500),
  `linkedin` VARCHAR(500),
  `portfolio` VARCHAR(500),
  `order_index` INT DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

try {
    $statements = explode(';', $createTables);
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
} catch (PDOException $e) {
    // Tables might already exist, continue
}

// Handle form submissions
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add_service') {
        $stmt = $pdo->prepare("INSERT INTO services_content (title, description, icon, features, order_index) VALUES (?, ?, ?, ?, ?)");
        $features = json_encode(explode(',', $_POST['features'] ?? ''));
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $features, $_POST['order_index'] ?? 0]);
        $message = 'Service added successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'update_service') {
        $stmt = $pdo->prepare("UPDATE services_content SET title=?, description=?, icon=?, features=?, order_index=? WHERE id=?");
        $features = json_encode(explode(',', $_POST['features'] ?? ''));
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $features, $_POST['order_index'] ?? 0, $_POST['id']]);
        $message = 'Service updated successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'delete_service') {
        $stmt = $pdo->prepare("DELETE FROM services_content WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $message = 'Service deleted successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'add_course') {
        $stmt = $pdo->prepare("INSERT INTO courses_content (title, description, icon, badge, duration, level, order_index) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $_POST['badge'] ?? 'Free', $_POST['duration'], $_POST['level'], $_POST['order_index'] ?? 0]);
        $message = 'Course added successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'update_course') {
        $stmt = $pdo->prepare("UPDATE courses_content SET title=?, description=?, icon=?, badge=?, duration=?, level=?, order_index=? WHERE id=?");
        $stmt->execute([$_POST['title'], $_POST['description'], $_POST['icon'], $_POST['badge'] ?? 'Free', $_POST['duration'], $_POST['level'], $_POST['order_index'] ?? 0, $_POST['id']]);
        $message = 'Course updated successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'delete_course') {
        $stmt = $pdo->prepare("DELETE FROM courses_content WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $message = 'Course deleted successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'add_project') {
        $stmt = $pdo->prepare("INSERT INTO projects_content (name, description, tech, url, icon, status, order_index) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['description'], $_POST['tech'], $_POST['url'], $_POST['icon'], $_POST['status'] ?? 'Coming Soon', $_POST['order_index'] ?? 0]);
        $message = 'Project added successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'update_project') {
        $stmt = $pdo->prepare("UPDATE projects_content SET name=?, description=?, tech=?, url=?, icon=?, status=?, order_index=? WHERE id=?");
        $stmt->execute([$_POST['name'], $_POST['description'], $_POST['tech'], $_POST['url'], $_POST['icon'], $_POST['status'] ?? 'Coming Soon', $_POST['order_index'] ?? 0, $_POST['id']]);
        $message = 'Project updated successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'delete_project') {
        $stmt = $pdo->prepare("DELETE FROM projects_content WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $message = 'Project deleted successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'add_team') {
        $stmt = $pdo->prepare("INSERT INTO team_members (name, role, skills, image, icon, github, linkedin, portfolio, order_index) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['role'], $_POST['skills'], $_POST['image'], $_POST['icon'], $_POST['github'], $_POST['linkedin'], $_POST['portfolio'], $_POST['order_index'] ?? 0]);
        $message = 'Team member added successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'update_team') {
        $stmt = $pdo->prepare("UPDATE team_members SET name=?, role=?, skills=?, image=?, icon=?, github=?, linkedin=?, portfolio=?, order_index=? WHERE id=?");
        $stmt->execute([$_POST['name'], $_POST['role'], $_POST['skills'], $_POST['image'], $_POST['icon'], $_POST['github'], $_POST['linkedin'], $_POST['portfolio'], $_POST['order_index'] ?? 0, $_POST['id']]);
        $message = 'Team member updated successfully!';
        $messageType = 'success';
    }
    
    if ($action === 'delete_team') {
        $stmt = $pdo->prepare("DELETE FROM team_members WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $message = 'Team member deleted successfully!';
        $messageType = 'success';
    }
}

// Fetch all content
$services = $pdo->query("SELECT * FROM services_content ORDER BY order_index, id")->fetchAll();
$courses = $pdo->query("SELECT * FROM courses_content ORDER BY order_index, id")->fetchAll();
$projects = $pdo->query("SELECT * FROM projects_content ORDER BY order_index, id")->fetchAll();
$teamMembers = $pdo->query("SELECT * FROM team_members ORDER BY order_index, id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Content • Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --gradient: linear-gradient(135deg, #3BA7FF, #A26BFF);
            --bg: #0f0f1e;
            --card: rgba(20, 20, 40, 0.8);
            --border: rgba(59, 167, 255, 0.3);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
        }
        
        body {
            background: var(--bg);
            color: var(--text-primary);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .admin-nav {
            background: rgba(10, 10, 30, 0.95);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
            padding: 12px 0;
        }
        
        .brand {
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
        }
        
        .content-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(59, 167, 255, 0.1);
        }
        
        .btn-action {
            margin: 5px;
        }
        
        .modal-content {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 16px;
        }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border);
            color: white;
            padding: 12px 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #3BA7FF;
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(59, 167, 255, 0.25);
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .input-group-text {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border);
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Horizontal Scroll Tabs for Mobile */
        .nav-pills {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            padding-bottom: 15px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
            margin: 0 -10px;
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .nav-pills::-webkit-scrollbar {
            display: none;
        }
        
        .nav-pills .nav-item {
            flex: 0 0 auto;
            white-space: nowrap;
        }
        
        .nav-pills .nav-link {
            border-radius: 12px;
            margin: 4px;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            padding: 12px 20px;
            font-weight: 500;
            white-space: nowrap;
            border: 1px solid var(--border);
        }
        
        .nav-pills .nav-link:hover {
            color: var(--text-primary);
            background: rgba(59, 167, 255, 0.1);
            border-color: #3BA7FF;
        }
        
        .nav-pills .nav-link.active {
            background: var(--gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 167, 255, 0.3);
            border-color: transparent;
        }
        
        /* Scroll indicator for tabs */
        .tabs-container {
            position: relative;
            margin: 0 -15px;
            padding: 0 15px;
        }
        
        .tabs-container::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 40px;
            background: linear-gradient(90deg, transparent, var(--bg));
            pointer-events: none;
            z-index: 1;
        }
        
        .tabs-container::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 40px;
            background: linear-gradient(270deg, transparent, var(--bg));
            pointer-events: none;
            z-index: 1;
        }
        
        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        
        .alert {
            border-radius: 12px;
            border: none;
        }
        
        .stats-badge {
            background: var(--gradient);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .brand {
                font-size: 1.3rem;
            }
            
            .admin-profile {
                text-align: center;
                margin-top: 10px;
            }
            
            .content-card {
                padding: 15px;
            }
            
            .btn-action {
                margin: 2px;
                font-size: 0.85rem;
                padding: 6px 12px;
            }
            
            .modal-dialog {
                margin: 10px;
            }
            
            .nav-pills {
                padding-bottom: 20px;
                margin-bottom: 10px;
            }
            
            .nav-pills .nav-link {
                font-size: 0.85rem;
                padding: 10px 16px;
            }
            
            h2 {
                font-size: 1.5rem;
            }
            
            h4 {
                font-size: 1.3rem;
            }
            
            .tabs-container {
                margin: 0 -10px;
                padding: 0 10px;
            }
        }
        
        @media (max-width: 576px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 15px;
            }
            
            .d-flex.justify-content-between h4 {
                text-align: center;
            }
            
            .content-card h5 {
                font-size: 1.1rem;
            }
            
            .modal-content {
                margin: 10px;
            }
            
            .nav-pills .nav-link {
                padding: 8px 14px;
                font-size: 0.8rem;
            }
            
            /* Enhanced scroll for very small devices */
            .nav-pills {
                padding-bottom: 25px;
            }
            
            .tabs-container::after,
            .tabs-container::before {
                width: 30px;
            }
        }
        
        /* For Content Tabs Specific Styling */
        #contentTabs.nav-pills {
            justify-content: flex-start;
        }
        
        #contentTabs .nav-link {
            display: flex;
            align-items: center;
            min-width: max-content;
        }
        
        /* Smooth scrolling animation */
        .nav-pills {
            scroll-behavior: smooth;
        }
        
        /* Active tab indicator for better UX */
        .nav-pills .nav-link.active {
            position: relative;
            z-index: 2;
        }
        
        /* Hide scrollbar but keep functionality on all devices */
        @media (min-width: 769px) {
            .nav-pills {
                flex-wrap: wrap;
                justify-content: center;
                overflow-x: visible;
                padding-bottom: 10px;
                margin: 0;
                padding-left: 0;
                padding-right: 0;
            }
            
            .tabs-container::after,
            .tabs-container::before {
                display: none;
            }
        }
        
        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <nav class="navbar admin-nav navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand brand" href="dashboard.php">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars text-white"></i>
                </span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarAdmin">
                <div class="admin-profile ms-auto text-lg-end">
                    <span class="text-white-50 me-3">
                        <i class="fas fa-user me-1"></i> <?= htmlspecialchars($_SESSION['admin_email']) ?>
                    </span>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <h2 class="text-center mb-4">Manage Content</h2>
        
        <?php if ($message): ?>
        <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <i class="fas fa-<?= $messageType === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-3 justify-content-center mb-3">
                    <span class="stats-badge">
                        <i class="fas fa-briefcase me-1"></i> <?= count($services) ?> Services
                    </span>
                    <span class="stats-badge">
                        <i class="fas fa-graduation-cap me-1"></i> <?= count($courses) ?> Courses
                    </span>
                    <span class="stats-badge">
                        <i class="fas fa-project-diagram me-1"></i> <?= count($projects) ?> Projects
                    </span>
                    <span class="stats-badge">
                        <i class="fas fa-users me-1"></i> <?= count($teamMembers) ?> Team Members
                    </span>
                </div>
            </div>
        </div>

        <div class="tabs-container">
            <ul class="nav nav-pills justify-content-center mb-4" id="contentTabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#services">
                        <i class="fas fa-briefcase me-2"></i>Services
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#courses">
                        <i class="fas fa-graduation-cap me-2"></i>Courses
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#projects">
                        <i class="fas fa-project-diagram me-2"></i>Projects
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#team">
                        <i class="fas fa-users me-2"></i>Team Members
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <!-- Services Tab -->
            <div class="tab-pane fade show active" id="services">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="fas fa-briefcase me-2"></i>Services
                    </h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                        <i class="fas fa-plus me-2"></i>Add Service
                    </button>
                </div>
                
                <?php if (empty($services)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-briefcase fa-3x text-white-50 mb-3"></i>
                    <p class="text-white-50">No services found. Add your first service to get started.</p>
                </div>
                <?php else: ?>
                <div class="row">
                    <?php foreach ($services as $service): ?>
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="content-card">
                            <div class="d-flex align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1"><?= htmlspecialchars($service['title']) ?></h5>
                                    <p class="text-white-50 small mb-2">
                                        <i class="fas fa-sort-numeric-down me-1"></i>Order: <?= $service['order_index'] ?>
                                    </p>
                                </div>
                                <i class="fas <?= htmlspecialchars($service['icon']) ?> fa-lg text-primary"></i>
                            </div>
                            <p class="text-white-50 small mb-3"><?= htmlspecialchars(substr($service['description'], 0, 100)) ?>...</p>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm btn-warning btn-action" onclick="editService(<?= htmlspecialchars(json_encode($service)) ?>)">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                    <input type="hidden" name="action" value="delete_service">
                                    <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger btn-action">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Courses Tab -->
            <div class="tab-pane fade" id="courses">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Courses
                    </h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                        <i class="fas fa-plus me-2"></i>Add Course
                    </button>
                </div>
                
                <?php if (empty($courses)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-graduation-cap fa-3x text-white-50 mb-3"></i>
                    <p class="text-white-50">No courses found. Add your first course to get started.</p>
                </div>
                <?php else: ?>
                <div class="row">
                    <?php foreach ($courses as $course): ?>
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="content-card">
                            <div class="d-flex align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1"><?= htmlspecialchars($course['title']) ?></h5>
                                    <div class="d-flex flex-wrap gap-2 mt-1">
                                        <span class="badge bg-<?= $course['badge'] === 'Premium' ? 'warning' : 'success' ?>">
                                            <?= htmlspecialchars($course['badge']) ?>
                                        </span>
                                        <?php if ($course['level']): ?>
                                        <span class="badge bg-info"><?= htmlspecialchars($course['level']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <i class="fas <?= htmlspecialchars($course['icon']) ?> fa-lg text-primary"></i>
                            </div>
                            <p class="text-white-50 small mb-2">
                                <?php if ($course['duration']): ?>
                                <i class="fas fa-clock me-1"></i><?= htmlspecialchars($course['duration']) ?>
                                <?php endif; ?>
                            </p>
                            <p class="text-white-50 small mb-3"><?= htmlspecialchars(substr($course['description'], 0, 100)) ?>...</p>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm btn-warning btn-action" onclick="editCourse(<?= htmlspecialchars(json_encode($course)) ?>)">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                    <input type="hidden" name="action" value="delete_course">
                                    <input type="hidden" name="id" value="<?= $course['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger btn-action">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Projects Tab -->
            <div class="tab-pane fade" id="projects">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="fas fa-project-diagram me-2"></i>Projects
                    </h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                        <i class="fas fa-plus me-2"></i>Add Project
                    </button>
                </div>
                
                <?php if (empty($projects)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-project-diagram fa-3x text-white-50 mb-3"></i>
                    <p class="text-white-50">No projects found. Add your first project to get started.</p>
                </div>
                <?php else: ?>
                <div class="row">
                    <?php foreach ($projects as $project): ?>
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="content-card">
                            <div class="d-flex align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1"><?= htmlspecialchars($project['name']) ?></h5>
                                    <span class="badge bg-<?= $project['status'] === 'Live' ? 'success' : 'secondary' ?>">
                                        <?= htmlspecialchars($project['status']) ?>
                                    </span>
                                </div>
                                <i class="fas <?= htmlspecialchars($project['icon']) ?> fa-lg text-primary"></i>
                            </div>
                            <p class="text-white-50 small mb-3"><?= htmlspecialchars(substr($project['description'], 0, 100)) ?>...</p>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm btn-warning btn-action" onclick="editProject(<?= htmlspecialchars(json_encode($project)) ?>)">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                    <input type="hidden" name="action" value="delete_project">
                                    <input type="hidden" name="id" value="<?= $project['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger btn-action">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Team Tab -->
            <div class="tab-pane fade" id="team">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="fas fa-users me-2"></i>Team Members
                    </h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeamModal">
                        <i class="fas fa-plus me-2"></i>Add Team Member
                    </button>
                </div>
                
                <?php if (empty($teamMembers)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-white-50 mb-3"></i>
                    <p class="text-white-50">No team members found. Add your first team member to get started.</p>
                </div>
                <?php else: ?>
                <div class="row">
                    <?php foreach ($teamMembers as $member): ?>
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="content-card">
                            <div class="d-flex align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1"><?= htmlspecialchars($member['name']) ?></h5>
                                    <p class="text-white-50 small mb-0"><?= htmlspecialchars($member['role']) ?></p>
                                </div>
                                <?php if ($member['icon']): ?>
                                <i class="fas <?= htmlspecialchars($member['icon']) ?> fa-lg text-primary"></i>
                                <?php endif; ?>
                            </div>
                            <p class="text-white-50 small mb-3">
                                <strong>Skills:</strong> <?= htmlspecialchars($member['skills']) ?>
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm btn-warning btn-action" onclick="editTeam(<?= htmlspecialchars(json_encode($member)) ?>)">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this team member?')">
                                    <input type="hidden" name="action" value="delete_team">
                                    <input type="hidden" name="id" value="<?= $member['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger btn-action">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Rest of your modals and JavaScript remain exactly the same -->
    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_service">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon (FontAwesome class, e.g., fa-file-alt)</label>
                            <input type="text" class="form-control" name="icon" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Features (comma separated)</label>
                            <input type="text" class="form-control" name="features" placeholder="Feature 1, Feature 2, Feature 3">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order Index</label>
                            <input type="number" class="form-control" name="order_index" value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Course Modal -->
    <div class="modal fade" id="addCourseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Course</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_course">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon (FontAwesome class)</label>
                            <input type="text" class="form-control" name="icon" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Badge</label>
                            <select class="form-select" name="badge">
                                <option value="Free">Free</option>
                                <option value="Premium">Premium</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Duration</label>
                            <input type="text" class="form-control" name="duration" placeholder="e.g., 8 Weeks">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Level</label>
                            <input type="text" class="form-control" name="level" placeholder="e.g., Beginner">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order Index</label>
                            <input type="number" class="form-control" name="order_index" value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Project Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_project">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tech Stack (comma separated)</label>
                            <input type="text" class="form-control" name="tech" placeholder="React.js, Node.js, MongoDB">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL</label>
                            <input type="url" class="form-control" name="url" placeholder="https://example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon (FontAwesome class)</label>
                            <input type="text" class="form-control" name="icon" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="Live">Live</option>
                                <option value="Coming Soon">Coming Soon</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order Index</label>
                            <input type="number" class="form-control" name="order_index" value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Team Modal -->
    <div class="modal fade" id="addTeamModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Team Member</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_team">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" name="role" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Skills (comma separated)</label>
                            <input type="text" class="form-control" name="skills" placeholder="PHP, Laravel, React" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image Path</label>
                            <input type="text" class="form-control" name="image" placeholder="assets/images/member1.jpg">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon (FontAwesome class)</label>
                            <input type="text" class="form-control" name="icon" placeholder="fa-user">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">GitHub URL</label>
                            <input type="url" class="form-control" name="github" placeholder="https://github.com/username">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">LinkedIn URL</label>
                            <input type="url" class="form-control" name="linkedin" placeholder="https://linkedin.com/in/username">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Portfolio URL</label>
                            <input type="url" class="form-control" name="portfolio" placeholder="https://portfolio.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order Index</label>
                            <input type="number" class="form-control" name="order_index" value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Team Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 mt-5">
        <small class="text-white-50">&copy;
            <?= date('Y') ?> RaYnk Labs • Content Management Panel
        </small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editService(service) {
            // Create edit modal dynamically
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'editServiceModal';
            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Service</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="action" value="update_service">
                                <input type="hidden" name="id" value="${service.id}">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="${service.title}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3" required>${service.description}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Icon</label>
                                    <input type="text" class="form-control" name="icon" value="${service.icon}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Features (comma separated)</label>
                                    <input type="text" class="form-control" name="features" value="${service.features ? JSON.parse(service.features).join(', ') : ''}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Order Index</label>
                                    <input type="number" class="form-control" name="order_index" value="${service.order_index}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Service</button>
                            </div>
                        </form>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            modal.addEventListener('hidden.bs.modal', () => modal.remove());
        }

        function editCourse(course) {
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'editCourseModal';
            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Course</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="action" value="update_course">
                                <input type="hidden" name="id" value="${course.id}">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="${course.title}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3" required>${course.description}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Icon</label>
                                    <input type="text" class="form-control" name="icon" value="${course.icon}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Badge</label>
                                    <select class="form-select" name="badge">
                                        <option value="Free" ${course.badge === 'Free' ? 'selected' : ''}>Free</option>
                                        <option value="Premium" ${course.badge === 'Premium' ? 'selected' : ''}>Premium</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Duration</label>
                                    <input type="text" class="form-control" name="duration" value="${course.duration || ''}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Level</label>
                                    <input type="text" class="form-control" name="level" value="${course.level || ''}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Order Index</label>
                                    <input type="number" class="form-control" name="order_index" value="${course.order_index}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Course</button>
                            </div>
                        </form>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            modal.addEventListener('hidden.bs.modal', () => modal.remove());
        }

        function editProject(project) {
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'editProjectModal';
            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Project</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="action" value="update_project">
                                <input type="hidden" name="id" value="${project.id}">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="${project.name}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3" required>${project.description}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tech Stack</label>
                                    <input type="text" class="form-control" name="tech" value="${project.tech || ''}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">URL</label>
                                    <input type="url" class="form-control" name="url" value="${project.url || ''}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Icon</label>
                                    <input type="text" class="form-control" name="icon" value="${project.icon}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="Live" ${project.status === 'Live' ? 'selected' : ''}>Live</option>
                                        <option value="Coming Soon" ${project.status === 'Coming Soon' ? 'selected' : ''}>Coming Soon</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Order Index</label>
                                    <input type="number" class="form-control" name="order_index" value="${project.order_index}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Project</button>
                            </div>
                        </form>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            modal.addEventListener('hidden.bs.modal', () => modal.remove());
        }

        function editTeam(member) {
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'editTeamModal';
            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Team Member</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="action" value="update_team">
                                <input type="hidden" name="id" value="${member.id}">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="${member.name}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control" name="role" value="${member.role}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Skills (comma separated)</label>
                                    <input type="text" class="form-control" name="skills" value="${member.skills}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Image Path</label>
                                    <input type="text" class="form-control" name="image" value="${member.image || ''}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Icon</label>
                                    <input type="text" class="form-control" name="icon" value="${member.icon || ''}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">GitHub URL</label>
                                    <input type="url" class="form-control" name="github" value="${member.github || ''}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">LinkedIn URL</label>
                                    <input type="url" class="form-control" name="linkedin" value="${member.linkedin || ''}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Portfolio URL</label>
                                    <input type="url" class="form-control" name="portfolio" value="${member.portfolio || ''}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Order Index</label>
                                    <input type="number" class="form-control" name="order_index" value="${member.order_index}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Team Member</button>
                            </div>
                        </form>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            modal.addEventListener('hidden.bs.modal', () => modal.remove());
        }

        // Mobile menu enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const navToggler = document.querySelector('.navbar-toggler');
            if (navToggler) {
                navToggler.innerHTML = '<i class="fas fa-bars text-white"></i>';
            }
            
            // Add active state to tab buttons
            const tabButtons = document.querySelectorAll('#contentTabs .nav-link');
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>