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
        }
        body {
            background: var(--bg);
            color: white;
            min-height: 100vh;
        }
        .admin-nav {
            background: rgba(10, 10, 30, 0.95);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
        }
        .brand {
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .content-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .btn-action {
            margin: 5px;
        }
        .modal-content {
            background: var(--bg);
            border: 1px solid var(--border);
        }
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border);
            color: white;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #3BA7FF;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar admin-nav sticky-top">
        <div class="container-fluid d-flex justify-content-between">
            <a class="navbar-brand brand fs-4" href="dashboard.php">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
            <div class="admin-profile text-end">
                <span class="text-white-50 small">
                    <i class="fas fa-user"></i> <?= $_SESSION['admin_email'] ?>
                </span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm ms-2">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <h2 class="text-center mb-4">Manage Content</h2>
        
        <?php if ($message): ?>
        <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <ul class="nav nav-pills justify-content-center mb-4">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#services">Services</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#courses">Courses</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#projects">Projects</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#team">Team Members</button></li>
        </ul>

        <div class="tab-content">
            <!-- Services Tab -->
            <div class="tab-pane fade show active" id="services">
                <div class="d-flex justify-content-between mb-3">
                    <h4>Services</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                        <i class="fas fa-plus"></i> Add Service
                    </button>
                </div>
                <div class="row">
                    <?php foreach ($services as $service): ?>
                    <div class="col-md-6 mb-3">
                        <div class="content-card">
                            <h5><?= htmlspecialchars($service['title']) ?></h5>
                            <p class="text-white-50 small"><?= htmlspecialchars(substr($service['description'], 0, 100)) ?>...</p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning" onclick="editService(<?= htmlspecialchars(json_encode($service)) ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this service?')">
                                    <input type="hidden" name="action" value="delete_service">
                                    <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Courses Tab -->
            <div class="tab-pane fade" id="courses">
                <div class="d-flex justify-content-between mb-3">
                    <h4>Courses</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                        <i class="fas fa-plus"></i> Add Course
                    </button>
                </div>
                <div class="row">
                    <?php foreach ($courses as $course): ?>
                    <div class="col-md-6 mb-3">
                        <div class="content-card">
                            <h5><?= htmlspecialchars($course['title']) ?></h5>
                            <p class="text-white-50 small"><?= htmlspecialchars(substr($course['description'], 0, 100)) ?>...</p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning" onclick="editCourse(<?= htmlspecialchars(json_encode($course)) ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this course?')">
                                    <input type="hidden" name="action" value="delete_course">
                                    <input type="hidden" name="id" value="<?= $course['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Projects Tab -->
            <div class="tab-pane fade" id="projects">
                <div class="d-flex justify-content-between mb-3">
                    <h4>Projects</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                        <i class="fas fa-plus"></i> Add Project
                    </button>
                </div>
                <div class="row">
                    <?php foreach ($projects as $project): ?>
                    <div class="col-md-6 mb-3">
                        <div class="content-card">
                            <h5><?= htmlspecialchars($project['name']) ?></h5>
                            <p class="text-white-50 small"><?= htmlspecialchars(substr($project['description'], 0, 100)) ?>...</p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning" onclick="editProject(<?= htmlspecialchars(json_encode($project)) ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this project?')">
                                    <input type="hidden" name="action" value="delete_project">
                                    <input type="hidden" name="id" value="<?= $project['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Team Tab -->
            <div class="tab-pane fade" id="team">
                <div class="d-flex justify-content-between mb-3">
                    <h4>Team Members</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeamModal">
                        <i class="fas fa-plus"></i> Add Team Member
                    </button>
                </div>
                <div class="row">
                    <?php foreach ($teamMembers as $member): ?>
                    <div class="col-md-6 mb-3">
                        <div class="content-card">
                            <h5><?= htmlspecialchars($member['name']) ?></h5>
                            <p class="text-white-50 small"><?= htmlspecialchars($member['role']) ?></p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning" onclick="editTeam(<?= htmlspecialchars(json_encode($member)) ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this team member?')">
                                    <input type="hidden" name="action" value="delete_team">
                                    <input type="hidden" name="id" value="<?= $member['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1">
        <div class="modal-dialog">
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
    </script>
</body>
</html>

