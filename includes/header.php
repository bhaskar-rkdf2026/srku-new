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
                <a href="https://erp.srku.edu.in/" target="_blank" class="top-link">STUDENT PORTAL</a>
                <a href="<?php echo BASE_URL; ?>about.php#faculties" class="top-link">FACULTY</a>
                <a href="<?php echo BASE_URL; ?>about.php#alumni" class="top-link">ALUMNI</a>
                <a href="https://sarswati.aicte.gov.in/" target="_blank" class="top-link">AICTE SCHOLARSHIP</a>
            </div>
            <div class="top-bar-right">
                <span class="top-info"><i class="fas fa-phone-alt"></i> Help Line Number: <?php echo sanitize($helpline); ?></span>
                <a href="mailto:<?php echo sanitize($email); ?>" class="top-info"><i class="fas fa-envelope"></i> <?php echo sanitize($email); ?></a>
                <a href="<?php echo BASE_URL; ?>admin/login.php" style="color: var(--accent-yellow); font-weight: 700; margin-left: 10px;"><i class="fas fa-lock"></i> Admin CMS</a>
            </div>
        </div>
    </div>

    <!-- MAIN NAVIGATION -->
    <header class="main-header glass-header">
        <div class="nav-container">
            <a href="<?php echo BASE_URL; ?>" class="logo-brand">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-logo.webp" 
                     alt="SRK University Bhopal Logo" 
                     style="height: 52px; width: auto; object-fit: contain;"
                     onerror="this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/srk-logo-real.webp';">
            </a>

            <nav class="nav-menu">
                <div class="nav-item <?php echo (!isset($activeNav) || $activeNav == 'home') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>" class="nav-link">Home</a>
                </div>

                <!-- ABOUT DROPDOWN -->
                <div class="nav-item <?php echo (isset($activeNav) && $activeNav == 'about') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>about.php" class="nav-link">About <i class="fas fa-chevron-down nav-arrow"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>page.php?slug=why-srk" class="dropdown-item">Why SRK</a>
                        <a href="<?php echo BASE_URL; ?>page.php?slug=vision-mission" class="dropdown-item">Vision & Mission</a>
                        
                        <div class="dropdown-submenu">
                            <a href="<?php echo BASE_URL; ?>about.php#accreditation" class="dropdown-item flex-between">Accreditation <i class="fas fa-chevron-right"></i></a>
                            <div class="sub-dropdown">
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/NIRF-2026.pdf" target="_blank" class="dropdown-item">NIRF 2026</a>
                            </div>
                        </div>

                        <a href="<?php echo BASE_URL; ?>about.php#board" class="dropdown-item">Board of Management</a>
                        <a href="<?php echo BASE_URL; ?>about.php#constituent" class="dropdown-item">Constituent Unit</a>
                        
                        <div class="dropdown-submenu">
                            <a href="#" class="dropdown-item flex-between">All Committee <i class="fas fa-chevron-right"></i></a>
                            <div class="sub-dropdown">
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Institutional-Development-Plan.pdf" target="_blank" class="dropdown-item">Institutional Development Plan</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/EOA_Report_2020-21-1.pdf" target="_blank" class="dropdown-item">Council Of Technical Education</a>
                            </div>
                        </div>

                        <div class="dropdown-submenu">
                            <a href="#" class="dropdown-item flex-between">Act & Statutes <i class="fas fa-chevron-right"></i></a>
                            <div class="sub-dropdown">
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Student_Grievance_Committee.pdf" target="_blank" class="dropdown-item">Student Grievance Committee</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/AntiRagging.pdf" target="_blank" class="dropdown-item">Anti Ragging</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/SC_ST_Grievance_committee.pdf" target="_blank" class="dropdown-item">SC-ST Grievance Committee</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/OBC-Minority.pdf" target="_blank" class="dropdown-item">OBC Minority</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/women-grievance-committee.pdf" target="_blank" class="dropdown-item">Women Grievance Committee</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/EqualOppurtunityCell.pdf" target="_blank" class="dropdown-item">Equal Oppurtunity Cell</a>
                            </div>
                        </div>

                        <div class="dropdown-submenu">
                            <a href="#" class="dropdown-item flex-between">University Ordinance <i class="fas fa-chevron-right"></i></a>
                            <div class="sub-dropdown">
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/university-ordinance.pdf" target="_blank" class="dropdown-item">University Ordinance</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/ordinance-93-100.pdf" target="_blank" class="dropdown-item">Subsequent Ordinance 93-100</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DEPARTMENTS MEGAMENU -->
                <div class="nav-item <?php echo (isset($activeNav) && $activeNav == 'departments') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>courses.php" class="nav-link">Departments <i class="fas fa-chevron-down nav-arrow"></i></a>
                    <div class="megamenu-panel">
                        <div class="megamenu-grid">
                            <div>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Engineering" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Department of Engineering</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Sri Sai College of Pharmacy</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Department of Pharmacy RKDF Polytechnic</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Department of Pharmacy RKDF College</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Computer" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Department of Computer Application</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> R.N. Kapoor Memorial Institute</a>
                            </div>
                            <div>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Sarvepalli Radhakrishnan College of Pharmacy</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Management" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Department of management</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Management" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Department of Business management</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Dr. APJ Abdul Kalam College of Pharmacy</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Nursing" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> RKDF College of Nursing</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Department of Allied Sciences</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COURSES MEGAMENU -->
                <div class="nav-item <?php echo (isset($activeNav) && $activeNav == 'courses') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>courses.php" class="nav-link">Courses <i class="fas fa-chevron-down nav-arrow"></i></a>
                    <div class="megamenu-panel">
                        <div class="megamenu-grid">
                            <div>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Engineering" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Engineering</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Computer" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Computer Application</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Nursing" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Nursing</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Allied Science & Humanities</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Paramedical Sciences</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Agriculture</a>
                            </div>
                            <div>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Law</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Dental Sciences</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Ayurveda</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Homeopathy</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Management" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Management</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Pharmacy" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Pharmacy</a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=Allied" class="dropdown-item"><i class="far fa-arrow-alt-circle-right"></i> Faculty of Medicine</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACADEMICS DROPDOWN -->
                <div class="nav-item">
                    <a href="#" class="nav-link">Academics <i class="fas fa-chevron-down nav-arrow"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Details-of-Academic-Programmes.pdf" target="_blank" class="dropdown-item">Details of Academic Programmes</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Academic-Calendar.pdf" target="_blank" class="dropdown-item">Academic Calendar</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/statutes-ordinances-pertaining-to-academics-examination.pdf" target="_blank" class="dropdown-item">Statutes Ordinances</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Constituent-unitsDepartment.pdf" target="_blank" class="dropdown-item">School/ Department/ Centres</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/department-wise-faculty-details.pdf" target="_blank" class="dropdown-item">Faculty/ Staff Details</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/IQAC.pdf" target="_blank" class="dropdown-item">Internal Quality Assurance Cell</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/UniversityLibrary.pdf" target="_blank" class="dropdown-item">Library</a>
                        <a href="<?php echo BASE_URL; ?>about.php#facilities" class="dropdown-item">Facilities</a>
                        <a href="<?php echo BASE_URL; ?>courses.php#placements" class="dropdown-item">Placements</a>
                    </div>
                </div>

                <!-- ADMISSION DROPDOWN -->
                <div class="nav-item">
                    <a href="<?php echo BASE_URL; ?>contact.php#apply" class="nav-link">Admission <i class="fas fa-chevron-down nav-arrow"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>about.php#student-life" class="dropdown-item">Student Life</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Prospectus.pdf" target="_blank" class="dropdown-item">Prospectus</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Admission-ProcessGuidelines.pdf" target="_blank" class="dropdown-item">Admission Process Guidelines</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Fee-Refund-Policy-2024-25.pdf" target="_blank" class="dropdown-item">Fee Refund Policy 2024-25</a>
                    </div>
                </div>

                <!-- ADMINISTRATION DROPDOWN -->
                <div class="nav-item">
                    <a href="#" class="nav-link">Administration <i class="fas fa-chevron-down nav-arrow"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/OfficersofUniversity.pdf" target="_blank" class="dropdown-item">Officers of University</a>
                        <div class="dropdown-submenu">
                            <a href="#" class="dropdown-item flex-between">Authority Of University <i class="fas fa-chevron-right"></i></a>
                            <div class="sub-dropdown">
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Governing-Body.pdf" target="_blank" class="dropdown-item">Governing Body</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Board-of-Management.pdf" target="_blank" class="dropdown-item">Board of Management</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Finance-Committee.pdf" target="_blank" class="dropdown-item">Finance Committee</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/ACADEMIC-COUNCIL-20.pdf.pdf" target="_blank" class="dropdown-item">Academic Councils</a>
                                <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/BoardofStudies.pdf" target="_blank" class="dropdown-item">Board Of Studies</a>
                            </div>
                        </div>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Internal-Complaint-Committee.pdf" target="_blank" class="dropdown-item">Internal Complaint Committee</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/AcademicLeadership.pdf" target="_blank" class="dropdown-item">Academic Leadership</a>
                    </div>
                </div>

                <!-- RESEARCH DROPDOWN -->
                <div class="nav-item">
                    <a href="#" class="nav-link">Research <i class="fas fa-chevron-down nav-arrow"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/researchdevelopmentcell.pdf" target="_blank" class="dropdown-item">Research & Development Cell</a>
                        <a href="<?php echo BASE_URL; ?>page.php?slug=incubation-center" class="dropdown-item">Incubation Centre</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/university_research_policy.pdf" target="_blank" class="dropdown-item">Research Policy</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Central-Facilities-for-Research-and-Development.pdf" target="_blank" class="dropdown-item">Central Facilities</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Constitution-of-Ethics-Board.pdf" target="_blank" class="dropdown-item">Ethics Board</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/consultancy-projects.pdf" target="_blank" class="dropdown-item">Consultancy Projects</a>
                        <a href="<?php echo BASE_URL; ?>assets/upload/2026/07/Admission_policy_for_Ph.D.Programme.pdf" target="_blank" class="dropdown-item">Ph.D. Admission Policy</a>
                    </div>
                </div>

                <div class="nav-item">
                    <a href="<?php echo BASE_URL; ?>#blogs" class="nav-link">Blogs</a>
                </div>

                <a href="<?php echo BASE_URL; ?>contact.php" class="btn-contact-nav">Contact Us</a>
            </nav>
        </div>
    </header>

