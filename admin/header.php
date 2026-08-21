<?php
ob_start();
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
    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/cropped-srku-logo-real-32x32.webp">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <!-- CKEditor 5 Classic CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <style>
        .action-btn-group {
            display: inline-flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 6px !important;
            flex-wrap: nowrap !important;
            white-space: nowrap !important;
        }
        .action-btn-group .btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 32px !important;
            height: 32px !important;
            padding: 0 !important;
            border-radius: 6px !important;
            flex-shrink: 0 !important;
            line-height: 1 !important;
        }
        table td.text-nowrap, table th.text-nowrap {
            white-space: nowrap !important;
        }
        /* Section-Wise Form Styling */
        .admin-form-section {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 22px 24px;
            margin-bottom: 20px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        }
        .admin-form-section-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--srku-blue);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ck-editor__editable_inline {
            min-height: 240px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 0.95rem !important;
            line-height: 1.7 !important;
        }
    </style>
</head>
<body class="bg-light">

<div class="d-flex">
    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="sidebar-logo text-center">
            <a href="index.php" class="brand-badge text-decoration-none">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-logo.webp" alt="SRKU Logo" style="max-height: 42px; width: auto; display: block;" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/images/SRK-logo.webp';">
            </a>
            <h5 class="text-white fw-bold mb-0 mt-2" style="font-size: 0.98rem; letter-spacing: 0.5px;">SRKU Central CMS</h5>
            <small style="color: #ffd700; font-size: 0.72rem; font-weight: 600;"><i class="fas fa-shield-alt text-warning me-1"></i> Admin Portal v2.0</small>
        </div>

        <nav class="nav flex-column my-2">
            <a href="index.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="manage_departments.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_departments.php' ? 'active' : ''; ?>">
                <i class="fas fa-sitemap"></i> Departments (14)
            </a>
            <a href="manage_courses.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_courses.php' ? 'active' : ''; ?>">
                <i class="fas fa-graduation-cap"></i> Courses &amp; Fees (39)
            </a>
            <a href="manage_pages.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_pages.php' ? 'active' : ''; ?>">
                <i class="fas fa-file-alt"></i> Dynamic Pages
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
            <a href="manage_header_footer.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_header_footer.php' ? 'active' : ''; ?>">
                <i class="fas fa-heading"></i> Header &amp; Footer
            </a>
            <a href="manage_media.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_media.php' ? 'active' : ''; ?>">
                <i class="fas fa-photo-video"></i> Media Library
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
                <small class="text-muted">Manage university content, courses, admissions &amp; settings dynamically.</small>
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-sm btn-danger px-3">
                    <i class="fas fa-globe me-1"></i> View Live Site
                </a>
            </div>
        </div>

        <div class="p-4">
            <?php displayFlashMsg(); ?>
