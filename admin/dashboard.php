<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../includes/db.php';

if (empty($_SESSION['admin_id'])) {
    header('Location: /projects/RaYnk-Labs/admin/index.php');
    exit;
}

$pdo = getPDOConnection();


$formFields = [
    'service' => ['origin_title', 'name', 'email', 'phone', 'message'],
    'course' => ['origin_title', 'name', 'email', 'phone', 'message'],
    'ai_tool' => ['origin_title', 'name', 'email', 'phone', 'message'],
    'community' => ['origin_title', 'name', 'email', 'phone', 'stream', 'skills', 'message'],
    'meetup' => ['origin_title', 'name', 'email', 'phone', 'message'],
    'contact' => ['name', 'email', 'phone', 'message'],
    'turning_point' => ['name', 'email', 'phone', 'message']
];

$types = [
    'service' => 'Services',
    'course' => 'Courses',
    'ai_tool' => 'AI Tools',
    'community' => 'Community',
    'meetup' => 'Meetups',
    'contact' => 'Contact',
    'turning_point' => 'Turning Point'
];

$fetchSubmissions = function (PDO $pdo, string $type): array {
    $stmt = $pdo->prepare("SELECT * FROM submissions WHERE type = ? ORDER BY created_at DESC");
    $stmt->execute([$type]);
    return $stmt->fetchAll();
};

$submissions = [];
$total = 0;
foreach ($types as $key => $label) {
    $submissions[$key] = $fetchSubmissions($pdo, $key);
    $total += count($submissions[$key]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RaYnk Labs • Admin Dashboard</title>

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

        .stats-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            transition: 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-8px);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-pills .nav-link {
            border-radius: 12px;
            margin: 4px;
            color: #ccc;
        }

        .nav-pills .nav-link.active {
            background: var(--gradient);
            color: white;
        }

        /* Horizontal Scroll Area */
        .table-scroll {
            width: 100%;
            overflow-x: auto !important;
            overflow-y: hidden;
            white-space: nowrap;
            border-radius: 12px;
            padding-bottom: 10px;
        }

        .table {
            --bs-table-bg: transparent;
            min-width: 1100px;
            /* force scroll on small screens */
        }

        .table th,
        .table td {
            padding: 12px 10px;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .table thead {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Mobile Improvements */
        @media (max-width: 768px) {
            .stats-number {
                font-size: 2rem;
            }

            .nav-pills {
                flex-wrap: nowrap;
                overflow-x: auto;
                padding-bottom: 10px;
            }

            .nav-pills .nav-link {
                white-space: nowrap;
                font-size: 0.9rem;
            }

            .table th,
            .table td {
                font-size: 0.75rem;
                padding: 8px 6px;
            }

            .table {
                min-width: 900px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar admin-nav sticky-top">
        <div class="container-fluid d-flex justify-content-between">
            <a class="navbar-brand brand fs-4" href="/projects/RaYnk-Labs/public/index.php">
                <i class="fas fa-arrow-left me-2"></i>RaYnk Labs
            </a>

            <div class="admin-profile text-end">
                <span class="text-white-50 small">
                    <i class="fas fa-user"></i>
                    <?= $_SESSION['admin_email'] ?>
                </span>

                <a href="/projects/RaYnk-Labs/admin/logout.php" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <main class="container py-4">

        <h2 class="text-center mb-4">Admin Dashboard</h2>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <p class="text-white-50">Total Submissions</p>
                    <h3 class="stats-number">
                        <?= $total ?>
                    </h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <p class="text-white-50">Manage Content</p>
                    <a href="manage_content.php" class="btn btn-primary mt-3">
                        <i class="fas fa-cog"></i> Manage Services, Courses, Projects & Team
                    </a>
                </div>
            </div>
        </div>

        <div id="client-details" style="margin-top: 60px; padding-top: 40px; border-top: 2px solid var(--border);">
            <h3 class="text-center mb-4">
                <i class="fas fa-users me-2"></i>Client Submissions by Type
            </h3>
            <p class="text-center text-white-50 mb-4">View all client submissions organized by service type</p>
            
            <ul class="nav nav-pills justify-content-center mb-4 flex-wrap">
                <?php $c=0; foreach ($types as $type => $label): ?>
                <li class="nav-item">
                    <button class="nav-link <?= $c===0?'active':'' ?>" data-bs-toggle="pill"
                        data-bs-target="#tab-<?= $type ?>">
                        <i class="fas fa-<?= $type === 'service' ? 'briefcase' : ($type === 'course' ? 'graduation-cap' : ($type === 'ai_tool' ? 'robot' : ($type === 'community' ? 'users' : ($type === 'meetup' ? 'calendar' : ($type === 'contact' ? 'envelope' : 'star'))))) ?> me-2"></i>
                        <?= $label ?>
                        <span class="badge bg-light text-dark ms-2">
                            <?= count($submissions[$type]) ?>
                        </span>
                    </button>
                </li>
                <?php $c++; endforeach; ?>
            </ul>
        </div>

        <div class="tab-content">
            <?php $i=0; foreach ($types as $type => $label): ?>
            <div class="tab-pane fade <?= $i===0?'show active':'' ?>" id="tab-<?= $type ?>">
                <div class="card" style="background: var(--card); border: 1px solid var(--border);">
                    <div class="card-header" style="background: rgba(255, 255, 255, 0.05); border-bottom: 1px solid var(--border);">
                        <h5 class="mb-0">
                            <i class="fas fa-<?= $type === 'service' ? 'briefcase' : ($type === 'course' ? 'graduation-cap' : ($type === 'ai_tool' ? 'robot' : ($type === 'community' ? 'users' : ($type === 'meetup' ? 'calendar' : ($type === 'contact' ? 'envelope' : 'star'))))) ?> me-2"></i>
                            <?= $label ?> Submissions
                            <span class="badge bg-primary ms-2"><?= count($submissions[$type]) ?> Total</span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if(empty($submissions[$type])): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-white-50 mb-3"></i>
                            <p class="text-white-50">No submissions found for <?= $label ?></p>
                        </div>
                        <?php else: ?>
                        <div class="table-scroll">
                            <table class="table table-dark table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <?php foreach ($formFields[$type] as $field): ?>
                                        <th>
                                            <i class="fas fa-<?= $field === 'name' ? 'user' : ($field === 'email' ? 'envelope' : ($field === 'phone' ? 'phone' : ($field === 'message' ? 'comment' : 'tag'))) ?> me-1"></i>
                                            <?= ucwords(str_replace('_',' ', $field)) ?>
                                        </th>
                                        <?php endforeach; ?>
                                        <th><i class="fas fa-calendar me-1"></i>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rowNum = 1; foreach ($submissions[$type] as $row): ?>
                                    <tr>
                                        <td><strong><?= $rowNum++ ?></strong></td>
                                        <?php foreach ($formFields[$type] as $f): ?>
                                        <td style="max-width: 200px; word-wrap: break-word;">
                                            <?= htmlspecialchars($row[$f] ?? '-') ?>
                                        </td>
                                        <?php endforeach; ?>
                                        <td>
                                            <small>
                                                <i class="fas fa-clock me-1"></i>
                                                <?= date("d M Y", strtotime($row['created_at'])) ?><br>
                                                <span class="text-white-50"><?= date("H:i", strtotime($row['created_at'])) ?></span>
                                            </small>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php $i++; endforeach; ?>
        </div>

    </main>

    <footer class="text-center">
        <small class="text-white-50">&copy;
            <?= date('Y') ?> RaYnk Labs • Admin Panel
        </small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>