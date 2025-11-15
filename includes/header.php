<?php
/**
 * Navigation bar include.
 *
 * Extracted from the original static HTML to keep design identical.
 * NOTE: session_start() should be called in the main page file, not here
 */
?>

<!-- Navigation -->
<nav class="navbar">
    <div class="container">
        <?php
        // Determine logo link based on admin login status
        $logoHref = "../admin/index.php";
        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['admin_id'])) {
            $logoHref = "../admin/dashboard.php";
        }
        ?>
        <?php 
        $currentPage = basename($_SERVER['PHP_SELF']);
        $currentPath = $_SERVER['REQUEST_URI'];
        $isHomePage = (strpos($currentPath, 'index.php') !== false || ($currentPage === 'index.php') || (strpos($currentPath, '/public/') !== false && strpos($currentPath, 'index.php') !== false));
        // Check if we're on the home page (index.php) or root
        if (strpos($currentPath, 'services.php') !== false || strpos($currentPath, 'courses.php') !== false || strpos($currentPath, 'projects.php') !== false) {
            $isHomePage = false;
        }
        ?>
        <?php if (!$isHomePage): ?>
        <a href="javascript:history.back()" class="back-btn" title="Go Back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <?php endif; ?>
        <a class="nav-brand" href="<?php echo htmlspecialchars($logoHref); ?>">RaYnk Labs</a>
        <div class="nav-links" id="navLinks">
            <?php if ($isHomePage): ?>
                <a href="#services">Services</a>
                <a href="#courses">Courses</a>
                <a href="#ai-tools">AI Tools</a>
                <a href="#community">Community</a>
                <a href="#team">Team</a>
                <a href="#contact">Contact</a>
            <?php else: ?>
                <a href="index.php#services">Services</a>
                <a href="index.php#courses">Courses</a>
                <a href="index.php#ai-tools">AI Tools</a>
                <a href="index.php#community">Community</a>
                <a href="index.php#team">Team</a>
                <a href="index.php#contact">Contact</a>
            <?php endif; ?>
        </div>
        <div class="d-flex align-items-center gap-3">
            <button class="theme-toggle-btn" id="themeToggle" title="Toggle Light/Dark Mode">
                <i class="fas fa-moon" id="themeIcon"></i>
            </button>
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

