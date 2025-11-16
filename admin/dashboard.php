<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../includes/db.php';

if (empty($_SESSION['admin_id'])) {
    header('Location: index.php');
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

        .stats-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 25px 20px;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(59, 167, 255, 0.15);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 10px 0;
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

        /* Horizontal Scroll Area */
        .table-scroll {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            border-radius: 12px;
            padding-bottom: 10px;
        }

        .table {
            --bs-table-bg: transparent;
            min-width: 1100px;
            margin-bottom: 0;
        }

        .table th,
        .table td {
            padding: 14px 12px;
            font-size: 0.9rem;
            vertical-align: middle;
            border-color: rgba(255, 255, 255, 0.1);
        }

        .table thead {
            background: rgba(255, 255, 255, 0.05);
        }

        .table tbody tr {
            transition: background 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(59, 167, 255, 0.05);
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
        }

        .card-header {
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid var(--border);
            padding: 20px;
        }

        .badge {
            font-weight: 600;
            padding: 6px 10px;
        }

        /* Mobile Improvements */
        @media (max-width: 768px) {
            .stats-number {
                font-size: 2rem;
            }
            
            .stats-card {
                padding: 20px 15px;
            }

            .nav-pills {
                padding-bottom: 20px;
                margin-bottom: 10px;
            }

            .nav-pills .nav-link {
                white-space: nowrap;
                font-size: 0.85rem;
                padding: 10px 16px;
            }

            .table th,
            .table td {
                font-size: 0.75rem;
                padding: 10px 8px;
            }

            .table {
                min-width: 900px;
            }
            
            .brand {
                font-size: 1.3rem;
            }
            
            .admin-profile {
                text-align: center;
                margin-top: 10px;
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
            
            h2 {
                font-size: 1.5rem;
            }
            
            .stats-card {
                margin-bottom: 15px;
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

        /* For Dashboard Page Specific Styling */
        #submissionTabs.nav-pills {
            justify-content: flex-start;
        }

        #submissionTabs .nav-link {
            display: flex;
            align-items: center;
            min-width: max-content;
        }

        #submissionTabs .badge {
            margin-left: 8px;
            font-size: 0.7rem;
            padding: 4px 8px;
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

        /* Custom scrollbar for webkit browsers */
        .table-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .table-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background: var(--gradient);
            border-radius: 10px;
        }

        .table-scroll::-webkit-scrollbar-thumb:hover {
            opacity: 0.8;
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
            <a class="navbar-brand brand" href="../index.php">
                <i class="fas fa-arrow-left me-2"></i>RaYnk Labs
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
                <span class="navbar-toggler-icon text-white">
                    <i class="fas fa-bars"></i>
                </span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarAdmin">
                <div class="admin-profile ms-auto text-lg-end">
                    <span class="text-white-50 me-3">
                        <i class="fas fa-user me-1"></i>
                        <?= htmlspecialchars($_SESSION['admin_email']) ?>
                    </span>

                    <a href="logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">

        <h2 class="text-center mb-4">Admin Dashboard</h2>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <p class="text-white-50 mb-2">Total Submissions</p>
                    <h3 class="stats-number">
                        <?= $total ?>
                    </h3>
                    <small class="text-white-50">All form submissions</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <p class="text-white-50 mb-2">Manage Content</p>
                    <a href="manage_content.php" class="btn btn-primary mt-3">
                        <i class="fas fa-cog me-2"></i> Manage Content
                    </a>
                    <p class="text-white-50 small mt-2">Services, Courses, Projects & Team</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <p class="text-white-50 mb-2">Quick Actions</p>
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-outline-primary" onclick="refreshData()">
                            <i class="fas fa-sync-alt me-2"></i> Refresh Data
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="client-details" style="margin-top: 60px; padding-top: 40px; border-top: 2px solid var(--border);">
            <h3 class="text-center mb-3">
                <i class="fas fa-users me-2"></i>Client Submissions by Type
            </h3>
            <p class="text-center text-white-50 mb-4">View all client submissions organized by service type</p>
            
            <div class="tabs-container">
                <ul class="nav nav-pills justify-content-center mb-4" id="submissionTabs">
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
        </div>

        <div class="tab-content">
            <?php $i=0; foreach ($types as $type => $label): ?>
            <div class="tab-pane fade <?= $i===0?'show active':'' ?>" id="tab-<?= $type ?>">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 d-flex align-items-center">
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
                                        <td style="max-width: 200px; word-wrap: break-word; white-space: normal;">
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

    <footer class="text-center py-4 mt-5">
        <small class="text-white-50">&copy;
            <?= date('Y') ?> RaYnk Labs • Admin Panel
        </small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function refreshData() {
            const refreshBtn = event.target;
            const originalText = refreshBtn.innerHTML;
            refreshBtn.innerHTML = '<span class="loading"></span> Refreshing...';
            refreshBtn.disabled = true;
            
            setTimeout(() => {
                location.reload();
            }, 1000);
        }
        
        // Mobile menu enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const navToggler = document.querySelector('.navbar-toggler');
            if (navToggler) {
                navToggler.innerHTML = '<i class="fas fa-bars text-white"></i>';
            }
        });
    </script>
</body>

</html>