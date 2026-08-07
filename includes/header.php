<?php
require_once __DIR__ . '/functions.php';
$helpline = getSetting('helpline', '0755 - 4911204');
$email = getSetting('email', 'exam@srku.edu.in');
$ticker = getSetting('ticker_text', 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for UG, PG & PhD Courses');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? sanitize($pageTitle) . " - " . SITE_NAME : SITE_NAME; ?></title>
    <meta name="description" content="Sarvepalli Radhakrishnan University (SRKU), Bhopal - Premier UGC Recognized University in MP offering UG, PG & Doctoral programs.">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- TOP BAR -->
    <div class="top-bar">
        <div class="top-bar-container">
            <div class="top-bar-left">
                <a href="tel:<?php echo str_replace(' ', '', $helpline); ?>"><i class="fas fa-phone-alt"></i> Helpline: <?php echo sanitize($helpline); ?></a>
                <a href="mailto:<?php echo sanitize($email); ?>"><i class="fas fa-envelope"></i> <?php echo sanitize($email); ?></a>
            </div>
            <div class="top-bar-right">
                <a href="https://erp.srku.edu.in/" target="_blank" class="badge-portal"><i class="fas fa-user-graduate"></i> Student Portal</a>
                <a href="about.php"><i class="fas fa-university"></i> NIRF 2026</a>
                <a href="https://sarswati.aicte.gov.in/" target="_blank"><i class="fas fa-award"></i> AICTE Scholarship</a>
                <a href="<?php echo BASE_URL; ?>admin/login.php"><i class="fas fa-lock"></i> CMS Login</a>
            </div>
        </div>
    </div>

    <!-- MAIN HEADER & NAVIGATION -->
    <header class="main-header">
        <div class="nav-container">
            <a href="<?php echo BASE_URL; ?>" class="logo-brand">
                <div class="logo-icon">SRK</div>
                <div class="logo-text">
                    <h1>Sarvepalli Radhakrishnan</h1>
                    <p>University Bhopal (UGC Recognized)</p>
                </div>
            </a>

            <nav class="nav-menu">
                <div class="nav-item <?php echo (!isset($activeNav) || $activeNav == 'home') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>" class="nav-link">Home</a>
                </div>
                <div class="nav-item <?php echo (isset($activeNav) && $activeNav == 'about') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>about.php" class="nav-link">About Us <i class="fas fa-chevron-down" style="font-size: 11px;"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>about.php" class="dropdown-item">Overview & Profile</a>
                        <a href="<?php echo BASE_URL; ?>page.php?slug=why-srk" class="dropdown-item">Why SRKU</a>
                        <a href="<?php echo BASE_URL; ?>page.php?slug=vision-mission" class="dropdown-item">Vision & Mission</a>
                        <a href="<?php echo BASE_URL; ?>about.php#accreditation" class="dropdown-item">Accreditation</a>
                        <a href="<?php echo BASE_URL; ?>about.php#board" class="dropdown-item">Board of Management</a>
                    </div>
                </div>
                <div class="nav-item <?php echo (isset($activeNav) && $activeNav == 'courses') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>courses.php" class="nav-link">Departments & Courses <i class="fas fa-chevron-down" style="font-size: 11px;"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Engineering" class="dropdown-item">Department of Engineering</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item">Faculty of Pharmacy</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Computer" class="dropdown-item">Computer Applications</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Management" class="dropdown-item">Management Studies</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Nursing" class="dropdown-item">College of Nursing</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item">Allied Sciences</a>
                    </div>
                </div>
                <div class="nav-item">
                    <a href="<?php echo BASE_URL; ?>#research" class="nav-link">Research</a>
                </div>
                <div class="nav-item">
                    <a href="<?php echo BASE_URL; ?>#placement" class="nav-link">Placements</a>
                </div>
                <div class="nav-item <?php echo (isset($activeNav) && $activeNav == 'contact') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>contact.php" class="nav-link">Contact</a>
                </div>
                <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn-apply-nav"><i class="fas fa-paper-plane"></i> Apply Now 2026</a>
            </nav>
        </div>
    </header>

    <!-- LIVE ANNOUNCEMENT TICKER -->
    <div class="ticker-bar">
        <div class="ticker-title"><i class="fas fa-bullhorn" style="margin-right: 6px;"></i> Updates</div>
        <div class="ticker-content">
            <?php echo sanitize($ticker); ?>
        </div>
    </div>
