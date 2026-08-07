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
    <title><?php echo isset($pageTitle) ? sanitize($pageTitle) : "Home - Sarvepalli Radhakrishnan University, Bhopal"; ?></title>
    <meta name="description" content="SRK University, Bhopal - UGC-Recognized Premier University in MP. Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership.">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- TOP HEADER BAR -->
    <div class="top-bar">
        <div class="top-bar-container">
            <div class="top-bar-left">
                <a href="https://erp.srku.edu.in/" target="_blank" class="badge-portal"><i class="fas fa-user-graduate"></i> Student Portal</a>
                <a href="<?php echo BASE_URL; ?>about.php#faculties"><i class="fas fa-chalkboard-teacher"></i> Faculty</a>
                <a href="<?php echo BASE_URL; ?>about.php#alumni"><i class="fas fa-user-friends"></i> Alumni</a>
                <a href="https://sarswati.aicte.gov.in/" target="_blank"><i class="fas fa-award"></i> AICTE SCHOLARSHIP</a>
            </div>
            <div class="top-bar-right">
                <a href="tel:07554911204"><i class="fas fa-phone-alt"></i> Help Line: <?php echo sanitize($helpline); ?></a>
                <a href="mailto:<?php echo sanitize($email); ?>"><i class="fas fa-envelope"></i> <?php echo sanitize($email); ?></a>
                <span class="badge-tag">Admissions Open 2026-27</span>
                <a href="<?php echo BASE_URL; ?>admin/login.php" style="color: var(--accent-gold); font-weight: 700;"><i class="fas fa-lock"></i> Admin CMS</a>
            </div>
        </div>
    </div>

    <!-- MAIN NAVIGATION -->
    <header class="main-header glass-header">
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
                    <a href="<?php echo BASE_URL; ?>about.php" class="nav-link">About <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>page.php?slug=why-srk" class="dropdown-item">Why SRK</a>
                        <a href="<?php echo BASE_URL; ?>page.php?slug=vision-mission" class="dropdown-item">Vision & Mission</a>
                        <a href="<?php echo BASE_URL; ?>about.php#accreditation" class="dropdown-item">Accreditation</a>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/NIRF-2026.pdf" target="_blank" class="dropdown-item">NIRF 2026</a>
                        <a href="<?php echo BASE_URL; ?>about.php#board" class="dropdown-item">Board of Management</a>
                        <a href="<?php echo BASE_URL; ?>about.php#constituent" class="dropdown-item">Constituent Unit</a>
                        <a href="<?php echo BASE_URL; ?>about.php#committees" class="dropdown-item">All Committee</a>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/university-ordinance.pdf" target="_blank" class="dropdown-item">University Ordinance</a>
                    </div>
                </div>

                <div class="nav-item <?php echo (isset($activeNav) && $activeNav == 'departments') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>courses.php" class="nav-link">Departments <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Engineering" class="dropdown-item">Department of Engineering</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item">Sri Sai College of Pharmacy</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item">Department of Pharmacy RKDF</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Computer" class="dropdown-item">Department of Computer Application</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item">R.N. Kapoor Memorial Institute</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item">Sarvepalli Radhakrishnan College of Pharmacy</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Management" class="dropdown-item">Department of Management</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Management" class="dropdown-item">Department of Business Management</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item">Dr. APJ Abdul Kalam College of Pharmacy</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Nursing" class="dropdown-item">RKDF College of Nursing</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item">Department of Allied Sciences</a>
                    </div>
                </div>

                <div class="nav-item <?php echo (isset($activeNav) && $activeNav == 'courses') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>courses.php" class="nav-link">Courses <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Engineering" class="dropdown-item">Faculty of Engineering</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Computer" class="dropdown-item">Faculty of Computer Application</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Nursing" class="dropdown-item">Faculty of Nursing</a>
                        <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item">Faculty of Allied Science & Humanities</a>
                    </div>
                </div>

                <div class="nav-item">
                    <a href="<?php echo BASE_URL; ?>contact.php#apply" class="nav-link">Admission</a>
                </div>
                <div class="nav-item">
                    <a href="<?php echo BASE_URL; ?>#research" class="nav-link">Research</a>
                </div>
                <div class="nav-item">
                    <a href="<?php echo BASE_URL; ?>#placement" class="nav-link">Placement</a>
                </div>
                <div class="nav-item <?php echo (isset($activeNav) && $activeNav == 'contact') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>contact.php" class="nav-link">Contact Us</a>
                </div>
                <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-apply-nav"><i class="fas fa-paper-plane"></i> Apply Now</a>
            </nav>
        </div>
    </header>

    <!-- LIVE ANNOUNCEMENT TICKER -->
    <div class="ticker-bar">
        <div class="ticker-title"><i class="fas fa-bullhorn" style="margin-right: 6px;"></i> LIVE UPDATES</div>
        <div class="ticker-content">
            <?php echo sanitize($ticker); ?>
        </div>
    </div>
