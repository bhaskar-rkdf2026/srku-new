<?php
require_once __DIR__ . '/functions.php';
$helpline = getSetting('helpline', '0755 - 4911204');
$email = getSetting('email', 'exam@srku.edu.in');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? sanitize($pageTitle) : "Home - Sarvepalli Radhakrishnan University, Bhopal"; ?></title>
    <meta name="description" content="SRK University, Bhopal - UGC-Recognized Premier University in MP offering Engineering, Pharmacy, Nursing, Management & Allied Sciences.">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800;900&family=Roboto+Slab:ital,wght@1,400;1,600&display=swap" rel="stylesheet">
    <!-- Custom SRKU Styles (brand colors, hero, etc.) -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>

<!-- ═══════ TOP BAR ═══════ -->
<div class="srku-topbar">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-none d-md-flex gap-3">
                <a href="https://erp.srku.edu.in/" target="_blank" class="topbar-link">STUDENT PORTAL</a>
                <a href="<?php echo BASE_URL; ?>about.php#faculties" class="topbar-link">FACULTY</a>
                <a href="<?php echo BASE_URL; ?>about.php#alumni" class="topbar-link">ALUMNI</a>
                <a href="https://sarswati.aicte.gov.in/" target="_blank" class="topbar-link">AICTE SCHOLARSHIP</a>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="topbar-info"><i class="fas fa-phone-alt me-1"></i><?php echo sanitize($helpline); ?></span>
                <a href="mailto:<?php echo sanitize($email); ?>" class="topbar-info"><?php echo sanitize($email); ?></a>
                <a href="<?php echo BASE_URL; ?>admin/login.php" class="topbar-link text-warning fw-bold"><i class="fas fa-lock me-1"></i>Admin</a>
            </div>
        </div>
    </div>
</div>

<!-- ═══════ MAIN NAVBAR (Bootstrap 5.3) ═══════ -->
<nav class="navbar navbar-expand-xl srku-navbar sticky-top" id="mainNav">
    <div class="container-xl">

        <!-- Logo -->
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
            <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-logo.webp"
                 alt="SRK University Bhopal"
                 height="52"
                 onerror="this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/srk-logo-real.webp'">
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Items -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto align-items-xl-center gap-xl-1">

                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link srku-nav-link <?php echo (!isset($activeNav) || $activeNav == 'home') ? 'active' : ''; ?>"
                       href="<?php echo BASE_URL; ?>">Home</a>
                </li>

                <!-- About (Dropdown) -->
                <li class="nav-item dropdown">
                    <a class="nav-link srku-nav-link dropdown-toggle <?php echo (isset($activeNav) && $activeNav == 'about') ? 'active' : ''; ?>"
                       href="<?php echo BASE_URL; ?>about.php" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        About
                    </a>
                    <ul class="dropdown-menu srku-dropdown">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>page.php?slug=why-srk">Why SRK</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>page.php?slug=vision-mission">Vision &amp; Mission</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>about.php#board">Board of Management</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>about.php#constituent">Constituent Units</a></li>
                        <!-- Accreditation sub-dropdown -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Accreditation</a>
                            <ul class="dropdown-menu srku-dropdown">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/NIRF-2026.pdf" target="_blank">NIRF 2026</a></li>
                            </ul>
                        </li>
                        <!-- All Committee sub-dropdown -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">All Committee</a>
                            <ul class="dropdown-menu srku-dropdown">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Student_Grievance_Committee.pdf" target="_blank">Student Grievance Committee</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/AntiRagging.pdf" target="_blank">Anti Ragging</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/SC_ST_Grievance_committee.pdf" target="_blank">SC-ST Grievance</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/women-grievance-committee.pdf" target="_blank">Women Grievance</a></li>
                            </ul>
                        </li>
                        <!-- University Ordinance sub-dropdown -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">University Ordinance</a>
                            <ul class="dropdown-menu srku-dropdown">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/university-ordinance.pdf" target="_blank">University Ordinance</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/ordinance-93-100.pdf" target="_blank">Subsequent Ordinance 93-100</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Departments (Mega-style dropdown) -->
                <li class="nav-item dropdown">
                    <a class="nav-link srku-nav-link dropdown-toggle <?php echo (isset($activeNav) && $activeNav == 'departments') ? 'active' : ''; ?>"
                       href="<?php echo BASE_URL; ?>courses.php" role="button" data-bs-toggle="dropdown">
                        Departments
                    </a>
                    <div class="dropdown-menu srku-megamenu p-3">
                        <div class="row g-0">
                            <div class="col-6">
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Engineering"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Department of Engineering</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Sri Sai College of Pharmacy</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>RKDF Polytechnic Pharmacy</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Computer"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Dept. of Computer Application</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>R.N. Kapoor Memorial Institute</a>
                            </div>
                            <div class="col-6">
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Sarvepalli Radhakrishnan Pharmacy</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Management"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Department of Management</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Dr. APJ Abdul Kalam Pharmacy</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Nursing"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>RKDF College of Nursing</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Allied"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Department of Allied Sciences</a>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- Courses (Mega-style dropdown) -->
                <li class="nav-item dropdown">
                    <a class="nav-link srku-nav-link dropdown-toggle <?php echo (isset($activeNav) && $activeNav == 'courses') ? 'active' : ''; ?>"
                       href="<?php echo BASE_URL; ?>courses.php" role="button" data-bs-toggle="dropdown">
                        Courses
                    </a>
                    <div class="dropdown-menu srku-megamenu p-3">
                        <div class="row g-0">
                            <div class="col-6">
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Engineering"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Faculty of Engineering</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Computer"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Faculty of Computer Application</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Nursing"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Faculty of Nursing</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Allied"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Faculty of Allied Science</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Allied"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Faculty of Agriculture</a>
                            </div>
                            <div class="col-6">
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Allied"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Faculty of Law</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Allied"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Faculty of Dental Sciences</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Allied"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Faculty of Ayurveda</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Management"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Faculty of Management</a>
                                <a class="dropdown-item py-1" href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy"><i class="far fa-arrow-alt-circle-right me-2 text-danger"></i>Faculty of Pharmacy</a>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- Academics Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link srku-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Academics</a>
                    <ul class="dropdown-menu srku-dropdown">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Details-of-Academic-Programmes.pdf" target="_blank">Academic Programmes</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Academic-Calendar.pdf" target="_blank">Academic Calendar</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/statutes-ordinances-pertaining-to-academics-examination.pdf" target="_blank">Statutes &amp; Ordinances</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/department-wise-faculty-details.pdf" target="_blank">Faculty Details</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/IQAC.pdf" target="_blank">IQAC</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/UniversityLibrary.pdf" target="_blank">Library</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>about.php#facilities">Facilities</a></li>
                    </ul>
                </li>

                <!-- Admission Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link srku-nav-link dropdown-toggle" href="<?php echo BASE_URL; ?>contact.php" role="button" data-bs-toggle="dropdown">Admission</a>
                    <ul class="dropdown-menu srku-dropdown">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>about.php#student-life">Student Life</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Prospectus.pdf" target="_blank">Prospectus</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Admission-ProcessGuidelines.pdf" target="_blank">Admission Guidelines</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Fee-Refund-Policy-2024-25.pdf" target="_blank">Fee Refund Policy</a></li>
                    </ul>
                </li>

                <!-- Administration Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link srku-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">Administration</a>
                    <ul class="dropdown-menu srku-dropdown">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/OfficersofUniversity.pdf" target="_blank">Officers of University</a></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Authority of University</a>
                            <ul class="dropdown-menu srku-dropdown">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Governing-Body.pdf" target="_blank">Governing Body</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Board-of-Management.pdf" target="_blank">Board of Management</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Finance-Committee.pdf" target="_blank">Finance Committee</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/ACADEMIC-COUNCIL-20.pdf.pdf" target="_blank">Academic Councils</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Internal-Complaint-Committee.pdf" target="_blank">Internal Complaint Committee</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/AcademicLeadership.pdf" target="_blank">Academic Leadership</a></li>
                    </ul>
                </li>

                <!-- Research Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link srku-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Research</a>
                    <ul class="dropdown-menu srku-dropdown">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/researchdevelopmentcell.pdf" target="_blank">R&amp;D Cell</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>page.php?slug=incubation-center">Incubation Centre</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/university_research_policy.pdf" target="_blank">Research Policy</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/consultancy-projects.pdf" target="_blank">Consultancy Projects</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Admission_policy_for_Ph.D.Programme.pdf" target="_blank">Ph.D. Admission Policy</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link srku-nav-link" href="<?php echo BASE_URL; ?>#blogs">Blogs</a>
                </li>

            </ul><!-- /.navbar-nav -->

            <!-- Contact Us Button -->
            <a href="<?php echo BASE_URL; ?>contact.php" class="btn srku-btn-contact ms-xl-3">Contact Us</a>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-xl -->
</nav>

<script>
// Bootstrap 5 sub-dropdown hover fix
document.querySelectorAll('.dropdown-submenu').forEach(function(el) {
    el.addEventListener('mouseenter', function() {
        var submenu = this.querySelector('.dropdown-menu');
        if (submenu) submenu.classList.add('show');
    });
    el.addEventListener('mouseleave', function() {
        var submenu = this.querySelector('.dropdown-menu');
        if (submenu) submenu.classList.remove('show');
    });
});
</script>
