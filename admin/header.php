<?php
require_once __DIR__ . '/../includes/functions.php';
checkAdminLogin();

$currentAdminPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin CMS Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">
    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <h3 style="color: var(--accent-gold); font-family: var(--font-heading); font-size: 1.2rem;">SRKU CMS Admin</h3>
            <small style="color: #94a3b8;">Control Panel v2.0</small>
        </div>

        <nav class="sidebar-menu">
            <a href="index.php" class="sidebar-link <?php echo $currentAdminPage == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="manage_pages.php" class="sidebar-link <?php echo $currentAdminPage == 'manage_pages.php' ? 'active' : ''; ?>">
                <i class="fas fa-file-alt"></i> Manage Pages
            </a>
            <a href="manage_courses.php" class="sidebar-link <?php echo $currentAdminPage == 'manage_courses.php' ? 'active' : ''; ?>">
                <i class="fas fa-graduation-cap"></i> Courses & Fees
            </a>
            <a href="manage_banners.php" class="sidebar-link <?php echo $currentAdminPage == 'manage_banners.php' ? 'active' : ''; ?>">
                <i class="fas fa-images"></i> Hero Banners
            </a>
            <a href="manage_news.php" class="sidebar-link <?php echo $currentAdminPage == 'manage_news.php' ? 'active' : ''; ?>">
                <i class="fas fa-bullhorn"></i> News & Ticker
            </a>
            <a href="manage_enquiries.php" class="sidebar-link <?php echo $currentAdminPage == 'manage_enquiries.php' ? 'active' : ''; ?>">
                <i class="fas fa-envelope-open-text"></i> Leads & Queries
            </a>
            <a href="manage_settings.php" class="sidebar-link <?php echo $currentAdminPage == 'manage_settings.php' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i> Site Settings
            </a>
            <a href="<?php echo BASE_URL; ?>" target="_blank" class="sidebar-link">
                <i class="fas fa-external-link-alt"></i> Visit Live Website
            </a>
            <a href="logout.php" class="sidebar-link" style="color: #f87171; margin-top: 30px;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        <div class="admin-header">
            <div>
                <h2 style="font-family: var(--font-heading); color: var(--dark-navy);">Welcome, <?php echo sanitize($_SESSION['admin_user'] ?? 'Admin'); ?></h2>
                <small style="color: var(--text-muted);">Manage your university web content & leads dynamically.</small>
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn-primary" style="font-size: 0.85rem; padding: 8px 16px;">
                    <i class="fas fa-globe"></i> View Site
                </a>
            </div>
        </div>

        <?php displayFlashMsg(); ?>
