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

<!-- Mobile Sidebar Overlay Backdrop -->
<div class="admin-sidebar-overlay" id="adminSidebarOverlay"></div>

<div class="d-flex">
    <!-- SIDEBAR (Desktop Fixed, Mobile Off-Canvas Drawer) -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-logo text-center">
            <button class="admin-sidebar-close" id="adminSidebarClose" aria-label="Close Sidebar">
                <i class="fas fa-times"></i>
            </button>
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

            <!-- HOMEPAGE MANAGEMENT SUB-MENU -->
            <div class="sidebar-heading">Homepage Controls</div>
            <a href="manage_homepage.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_homepage.php' ? 'active' : ''; ?>">
                <i class="fas fa-home text-warning"></i> Homepage Sections
            </a>
            <div class="sidebar-submenu">
                <a href="manage_homepage.php?tab=hero" class="sidebar-sub-link <?php echo ($currentAdminPage == 'manage_homepage.php' && ($_GET['tab'] ?? 'hero') == 'hero') ? 'active' : ''; ?>">
                    <i class="fas fa-video"></i> Hero Video
                </a>
                <a href="manage_homepage.php?tab=welcome" class="sidebar-sub-link <?php echo ($currentAdminPage == 'manage_homepage.php' && ($_GET['tab'] ?? '') == 'welcome') ? 'active' : ''; ?>">
                    <i class="fas fa-university"></i> Welcome Section
                </a>
                <a href="manage_homepage.php?tab=stats" class="sidebar-sub-link <?php echo ($currentAdminPage == 'manage_homepage.php' && ($_GET['tab'] ?? '') == 'stats') ? 'active' : ''; ?>">
                    <i class="fas fa-chart-pie"></i> Key Stats Strip
                </a>
                <a href="manage_homepage.php?tab=chancellor" class="sidebar-sub-link <?php echo ($currentAdminPage == 'manage_homepage.php' && ($_GET['tab'] ?? '') == 'chancellor') ? 'active' : ''; ?>">
                    <i class="fas fa-crown"></i> Chancellor Desk
                </a>
                <a href="manage_homepage.php?tab=vc" class="sidebar-sub-link <?php echo ($currentAdminPage == 'manage_homepage.php' && ($_GET['tab'] ?? '') == 'vc') ? 'active' : ''; ?>">
                    <i class="fas fa-user-tie"></i> Vice Chancellor Desk
                </a>
            </div>

            <!-- ACADEMICS & DEPARTMENTS -->
            <div class="sidebar-heading">Academics &amp; Content</div>
            <?php 
            try {
                $dbConn = getDBConnection();
                $deptsCountBadge = (int)$dbConn->query("SELECT COUNT(*) FROM departments")->fetchColumn();
                $galleryCountBadge = (int)$dbConn->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
            } catch(Exception $e) { 
                $deptsCountBadge = 26; 
                $galleryCountBadge = 71;
            }
            ?>
            <a href="manage_departments.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_departments.php' ? 'active' : ''; ?>">
                <i class="fas fa-sitemap"></i> Constituent Units (<?php echo $deptsCountBadge; ?>)
            </a>
            <a href="manage_courses.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_courses.php' ? 'active' : ''; ?>">
                <i class="fas fa-graduation-cap"></i> Courses &amp; Programs
            </a>
            <a href="manage_faculty.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_faculty.php' ? 'active' : ''; ?>">
                <i class="fas fa-chalkboard-teacher"></i> Faculty Directory (1,000+)
            </a>
            <a href="manage_blogs.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_blogs.php' ? 'active' : ''; ?>">
                <i class="fas fa-newspaper"></i> Blogs &amp; Articles
            </a>
            <a href="manage_news.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_news.php' ? 'active' : ''; ?>">
                <i class="fas fa-bullhorn"></i> News &amp; Notices
            </a>
            <a href="manage_gallery.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_gallery.php' ? 'active' : ''; ?>">
                <i class="fas fa-images text-danger"></i> Photo Gallery (<?php echo $galleryCountBadge; ?>)
            </a>

            <!-- ADMISSIONS & SETTINGS -->
            <div class="sidebar-heading">Portal System</div>
            <?php 
            try {
                $dbConn = getDBConnection();
                $newLeadsBadge = (int)$dbConn->query("SELECT COUNT(*) FROM enquiries WHERE status = 'New' OR status IS NULL")->fetchColumn();
            } catch(Exception $e) { $newLeadsBadge = 0; }
            ?>
            <a href="manage_enquiries.php" class="sidebar-nav-link d-flex align-items-center justify-content-between <?php echo $currentAdminPage == 'manage_enquiries.php' ? 'active' : ''; ?>">
                <div><i class="fas fa-user-graduate me-2"></i> Admissions &amp; Enquiries</div>
                <?php if ($newLeadsBadge > 0): ?>
                    <span class="badge bg-warning text-dark fw-bold rounded-pill" style="font-size: 0.7rem;"><?php echo $newLeadsBadge; ?></span>
                <?php endif; ?>
            </a>
            <a href="manage_header_footer.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_header_footer.php' ? 'active' : ''; ?>">
                <i class="fas fa-heading"></i> Header &amp; Footer
            </a>
            <a href="manage_media.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_media.php' ? 'active' : ''; ?>">
                <i class="fas fa-photo-video"></i> Media Library
            </a>
            <a href="manage_settings.php" class="sidebar-nav-link <?php echo $currentAdminPage == 'manage_settings.php' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i> Global Settings
            </a>
            <a href="<?php echo BASE_URL; ?>" target="_blank" class="sidebar-nav-link">
                <i class="fas fa-external-link-alt"></i> Live Website
            </a>
            <a href="logout.php" class="sidebar-nav-link text-danger mt-3">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main flex-fill">
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="admin-sidebar-toggle-btn" id="adminSidebarToggle" aria-label="Open Navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h4 class="fw-bold mb-0 text-navy">Welcome, <?php echo sanitize($_SESSION['admin_user'] ?? 'Admin'); ?></h4>
                    <small class="text-muted">Manage university content, courses, admissions &amp; settings dynamically.</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-sm btn-danger px-2 px-md-3">
                    <i class="fas fa-globe me-1"></i> <span class="d-none d-sm-inline">View Live Site</span>
                </a>
                <a href="logout.php" class="btn btn-sm btn-outline-secondary px-2 px-md-3">
                    <i class="fas fa-sign-out-alt me-1"></i> <span class="d-none d-sm-inline">Logout</span>
                </a>
            </div>
        </div>

        <div class="p-3 p-md-4">
            <?php displayFlashMsg(); ?>
