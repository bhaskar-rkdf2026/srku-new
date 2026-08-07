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
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="bg-light">

<div class="d-flex">
    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="sidebar-logo">
            <h5>SRKU CMS Admin</h5>
            <small>Control Panel v2.0</small>
        </div>

        <nav class="nav flex-column my-2">
            <a href="index.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="manage_pages.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_pages.php' ? 'active' : ''; ?>">
                <i class="fas fa-file-alt"></i> Manage Pages
            </a>
            <a href="manage_courses.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_courses.php' ? 'active' : ''; ?>">
                <i class="fas fa-graduation-cap"></i> Courses &amp; Fees
            </a>
            <a href="manage_banners.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_banners.php' ? 'active' : ''; ?>">
                <i class="fas fa-images"></i> Hero Banners
            </a>
            <a href="manage_news.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_news.php' ? 'active' : ''; ?>">
                <i class="fas fa-bullhorn"></i> News &amp; Ticker
            </a>
            <a href="manage_enquiries.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_enquiries.php' ? 'active' : ''; ?>">
                <i class="fas fa-envelope-open-text"></i> Leads &amp; Queries
            </a>
            <a href="manage_settings.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_settings.php' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i> Site Settings
            </a>
            <a href="<?php echo BASE_URL; ?>" target="_blank" class="sidebar-nav-link">
                <i class="fas fa-external-link-alt"></i> Live Website
            </a>
            <a href="logout.php" class="sidebar-nav-link text-danger mt-4">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main flex-fill">
        <div class="admin-topbar">
            <div>
                <h4 class="fw-bold mb-0 text-navy">Welcome, <?php echo sanitize($_SESSION['admin_user'] ?? 'Admin'); ?></h4>
                <small class="text-muted">Manage your university web content &amp; leads dynamically.</small>
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-sm btn-danger px-3">
                    <i class="fas fa-globe me-1"></i> View Site
                </a>
            </div>
        </div>

        <div class="p-4">
            <?php displayFlashMsg(); ?>
