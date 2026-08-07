<?php
$pageTitle = "Home - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "home";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

// Handle Form Submission for Enquiry
$enquirySuccess = false;
$enquiryErr = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_enquiry'])) {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $course  = trim($_POST['course'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if (!$name || !$email || !$phone) {
        $enquiryErr = 'Please fill all required fields.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO enquiries (name, email, phone, course, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $phone, $course, $message]);
        $enquirySuccess = true;
    }
}
?>

<!-- ═══════════════════════════════════════════════════════
     HERO SECTION — 100VH FULLSCREEN VIMEO VIDEO BG
═══════════════════════════════════════════════════════ -->
<section class="hero-section">

    <iframe class="hero-bg-video"
            src="https://player.vimeo.com/video/1213199411?muted=1&amp;autoplay=1&amp;loop=1&amp;background=1&amp;app_id=122963"
            frameborder="0" allow="autoplay; fullscreen; picture-in-picture" title="SRKU Hero"></iframe>

    <div class="hero-overlay"></div>

    <div class="container-xl">
        <div class="hero-content">
            <h1 class="hero-h1">
                SRK University, Bhopal<br>
                <span class="gold-line">UGC-Recognized</span>
                University in MP
            </h1>
            <p class="hero-desc my-3">
                Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership.
                If you are looking for the <b>best placement university in MP</b>, our rigorous research, multi-disciplinary
                collaboration, and industry-aligned pedagogy deliver unmatched career growth.
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="#apply" class="btn-hero-yellow">Apply Now</a>
                <a href="courses.php" class="btn-hero-outline">Explore Programme</a>
            </div>
        </div>
    </div>

    <!-- Floating stat card 1 — White glass (Top Right) -->
    <div class="hero-stat-card-1 d-none d-xl-flex">
        <div class="icon-box">
            <svg viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M528 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h480c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm8 336c0 4.411-3.589 8-8 8H48c-4.411 0-8-3.589-8-8V112c0-4.411 3.589-8 8-8h480c4.411 0 8 3.589 8 8v288zM170 270v-28c0-6.627-5.373-12-12-12h-28c-6.627 0-12 5.373-12 12v28c0 6.627 5.373 12 12 12h28c6.627 0 12-5.373 12-12zm96 0v-28c0-6.627-5.373-12-12-12h-28c-6.627 0-12 5.373-12 12v28c0 6.627 5.373 12 12 12h28c6.627 0 12-5.373 12-12zm96 0v-28c0-6.627-5.373-12-12-12h-28c-6.627 0-12 5.373-12 12v28c0 6.627 5.373 12 12 12h28c6.627 0 12-5.373 12-12z"/></svg>
        </div>
        <div>
            <h3 class="stat-num mb-0">42+</h3>
            <p class="stat-lbl mb-0">HIGH-TECH LABS</p>
        </div>
    </div>

    <!-- Floating stat card 2 — Maroon (Bottom Right) -->
    <div class="hero-stat-card-2 d-none d-xl-flex">
        <div class="icon-box"><i class="fas fa-bell"></i></div>
        <div>
            <h3 class="stat-num mb-0">94%</h3>
            <p class="stat-lbl mb-0">PLACEMENT RECORD</p>
        </div>
    </div>

    <!-- Live ticker pinned to bottom of hero -->
    <div class="hero-ticker">
        <div class="hero-ticker-label">LIVE UPDATES</div>
        <div class="hero-ticker-track">
            <span class="hero-ticker-content">
                12 LPA highest package recorded this season &nbsp;&bull;&nbsp;
                NAAC accredited university with industry-focused curriculum &nbsp;&bull;&nbsp;
                Admissions Open 2026-27 for UG &amp; PG &nbsp;&bull;&nbsp;
                UGC Recognized Premier University in Madhya Pradesh &nbsp;&bull;&nbsp;
                Apply Now for Engineering, Pharmacy, Management, Nursing &amp; Allied Sciences &nbsp;&bull;&nbsp;
                New B.Tech AI &amp; Data Science programme launched &nbsp;&bull;&nbsp;
            </span>
        </div>
    </div>

</section>

<!-- ═══════════════════════════════════════════════════════
     STATS STRIP (Bootstrap Row)
═══════════════════════════════════════════════════════ -->
<div class="stats-strip py-2">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-5 g-0 text-center">
            <div class="col stat-box">
                <div class="stat-val">42+</div>
                <div class="stat-txt">High-Tech Labs</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">94%</div>
                <div class="stat-txt">Placement Record</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">120+</div>
                <div class="stat-txt">Corporate Recruiters</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">15,000+</div>
                <div class="stat-txt">Global Alumni</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">25+</div>
                <div class="stat-txt">Years of Excellence</div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     WELCOME SECTION (Bootstrap 2-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            
            <div class="col-12 col-lg-6">
                <span class="section-subtitle">WELCOME TO SRK UNIVERSITY</span>
                <h2 class="section-title mb-3">Empowering Minds, <span>Shaping Futures</span><br>through Academic Excellence</h2>
                <p class="text-dark mb-3" style="line-height:1.8; font-size:0.95rem;">
                    Sarvepalli Radhakrishnan University (SRKU), Bhopal is a premier educational institution committed to delivering cutting-edge technical, pharmaceutical, management, and scientific education.
                </p>
                <p class="text-muted mb-4" style="line-height:1.8; font-size:0.93rem;">
                    Recognized by the University Grants Commission (UGC) under Section 2(f), AICTE, PCI, and statutory councils, SRKU provides an innovative ecosystem blending rigorous research, multidisciplinary collaboration, and industry-aligned pedagogy.
                </p>
                <a href="about.php" class="btn btn-srku"><i class="fas fa-arrow-right me-1"></i> Read More</a>
            </div>

            <div class="col-12 col-lg-6">
                <div class="position-relative">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/campus-1.webp"
                         onerror="this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp'"
                         alt="SRKU Main Campus" class="welcome-img">
                    <div class="row g-2 mt-3 text-center">
                        <div class="col-4">
                            <div class="welcome-badge"><strong>42+</strong><small>HIGH-TECH LABS</small></div>
                        </div>
                        <div class="col-4">
                            <div class="welcome-badge"><strong>94%</strong><small>Placement Rate</small></div>
                        </div>
                        <div class="col-4">
                            <div class="welcome-badge"><strong>2026-27</strong><small>Admissions Open</small></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     EXPLORE PROGRAMMES SECTION (Bootstrap 4-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream">
    <div class="container-xl py-3">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-2">
            <div>
                <span class="section-subtitle">ACADEMIC EXCELLENCE</span>
                <h2 class="section-title mb-0">Explore Programmes <span>Offered</span></h2>
            </div>
            <a href="courses.php" class="btn-card-apply fs-6">View All Programmes <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp" class="prog-img" alt="Engineering"
                         onerror="this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp'">
                    <div class="prog-body">
                        <h3 class="prog-title">Department of Engineering</h3>
                        <p class="prog-desc">B.Tech &amp; M.Tech in CSE, Mechanical, Civil &amp; Electrical with AI &amp; IoT specializations.</p>
                        <a href="courses.php?dept=Engineering" class="btn-card-apply">Explore Department &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-COP.webp" class="prog-img" alt="Pharmacy">
                    <div class="prog-body">
                        <h3 class="prog-title">Sri Sai College of Pharmacy</h3>
                        <p class="prog-desc">PCI &amp; AICTE approved B.Pharm, D.Pharm and M.Pharm programs with modern drug testing labs.</p>
                        <a href="courses.php?dept=Pharmacy" class="btn-card-apply">Explore Department &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/MCA-SRKUniversityFacultyofComputerApplication.webp" class="prog-img" alt="Computer">
                    <div class="prog-body">
                        <h3 class="prog-title">Dept. of Computer Application</h3>
                        <p class="prog-desc">BCA, MCA, B.Sc CS courses for modern software development &amp; cloud computing.</p>
                        <a href="courses.php?dept=Computer" class="btn-card-apply">Explore Department &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/rkdf-college-of-nursing1.webp" class="prog-img" alt="Nursing">
                    <div class="prog-body">
                        <h3 class="prog-title">RKDF College of Nursing</h3>
                        <p class="prog-desc">INC &amp; MPNRC recognized B.Sc Nursing, Post Basic Nursing, and GNM with clinical training.</p>
                        <a href="courses.php?dept=Nursing" class="btn-card-apply">Explore Department &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/MBA.webp" class="prog-img" alt="Management">
                    <div class="prog-body">
                        <h3 class="prog-title">Department of Management</h3>
                        <p class="prog-desc">MBA, BBA, Commerce with Dual Specializations in Marketing, HR, Finance &amp; Analytics.</p>
                        <a href="courses.php?dept=Management" class="btn-card-apply">Explore Department &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/R.N.-KAPOOR-MEMORIAL-PHARMACY.webp" class="prog-img" alt="APJ Kalam Pharmacy">
                    <div class="prog-body">
                        <h3 class="prog-title">Dr. APJ Abdul Kalam Pharmacy</h3>
                        <p class="prog-desc">Premier pharma research institute with state-of-the-art pharmacology &amp; chemistry labs.</p>
                        <a href="courses.php?dept=Pharmacy" class="btn-card-apply">Explore Department &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SARVEPALLI-RADHAKRISHANAN-COLLEGE-OF-ALLIED-HEALTHCARE-SCIENCES.webp" class="prog-img" alt="Allied Sciences">
                    <div class="prog-body">
                        <h3 class="prog-title">Dept. of Allied Sciences</h3>
                        <p class="prog-desc">B.Sc, M.Sc in Biotechnology, Microbiology, Medical Lab Technology &amp; Physics.</p>
                        <a href="courses.php?dept=Allied" class="btn-card-apply">Explore Department &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-COLLEGE-OF-AYURVEDA.webp" class="prog-img" alt="Law">
                    <div class="prog-body">
                        <h3 class="prog-title">Faculty of Law</h3>
                        <p class="prog-desc">LL.B and LL.M degree programs preparing legal professionals for courts, advocacy, and corporate law.</p>
                        <a href="courses.php?dept=Law" class="btn-card-apply">Explore Department &rarr;</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     PROMINENT INSTITUTES / FACULTIES (Bootstrap Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-4">
            <span class="section-subtitle">CONSTITUENT UNITS</span>
            <h2 class="section-title">Prominent Institutes under <span>SRK University</span></h2>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            <div class="col"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-cogs"></i></div><div class="faculty-info"><h4>Faculty of Engineering</h4></div></div></div>
            <div class="col"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-pills"></i></div><div class="faculty-info"><h4>Faculty of Pharmacy</h4></div></div></div>
            <div class="col"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-laptop-code"></i></div><div class="faculty-info"><h4>Computer Applications</h4></div></div></div>
            <div class="col"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-user-md"></i></div><div class="faculty-info"><h4>Faculty of Nursing</h4></div></div></div>
            <div class="col"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-chart-bar"></i></div><div class="faculty-info"><h4>Business Management</h4></div></div></div>
            <div class="col"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-atom"></i></div><div class="faculty-info"><h4>Allied Sciences</h4></div></div></div>
            <div class="col"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-balance-scale"></i></div><div class="faculty-info"><h4>Faculty of Law</h4></div></div></div>
            <div class="col"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-graduation-cap"></i></div><div class="faculty-info"><h4>Dr. APJ Kalam College</h4></div></div></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CHANCELLOR MESSAGE (Bootstrap 2-col Layout)
═══════════════════════════════════════════════════════ -->
<section class="chancellor-section py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-md-5 col-lg-4">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/ruchichaubey.webp"
                     onerror="this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp'"
                     class="chancellor-photo" alt="Chancellor SRK University">
            </div>
            <div class="col-12 col-md-7 col-lg-8">
                <h2 class="text-white fw-bold mb-2">Message From Chancellor Desk</h2>
                <div class="text-gold fw-bold mb-3 text-uppercase" style="letter-spacing:1px; font-size:0.88rem;">Leadership &amp; Governance</div>
                <p class="fst-italic text-light border-start border-3 border-warning ps-3 mb-4" style="font-size:1.02rem; line-height:1.8;">
                    "At Sarvepalli Radhakrishnan University, our mission is to foster an academic environment that cultivates critical thinking, research innovation, and professional integrity. We empower our students to become technology leaders, entrepreneurs, and responsible global citizens."
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="about.php#board" class="btn-srku-gold"><i class="fas fa-user-tie"></i> Read Full Message</a>
                    <a href="page.php?slug=vision-mission" class="btn-srku-outline"><i class="fas fa-bullseye"></i> Vision &amp; Mission</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CAMPUS FACILITIES (Bootstrap 3-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="text-center mb-4">
            <span class="section-subtitle">CAMPUS LIFE &amp; INFRASTRUCTURE</span>
            <h2 class="section-title">World-Class Campus <span>Facilities</span></h2>
            <p class="text-muted small">Equipped with state-of-the-art infrastructure for learning, living, and innovating.</p>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/library.webp" class="prog-img" alt="Library">
                    <div class="prog-body"><h3 class="prog-title">Central Digital Library</h3><p class="prog-desc mb-0">50,000+ books, international journals, e-books, and 24/7 digital resource access.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp" class="prog-img" alt="Labs">
                    <div class="prog-body"><h3 class="prog-title">42+ Advanced Research Labs</h3><p class="prog-desc mb-0">High-performance computing, Robotics, Pharmaceutics testing, and AI innovation units.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Operation-Theatre.webp" class="prog-img" alt="Lecture Halls">
                    <div class="prog-body"><h3 class="prog-title">Air-Conditioned Auditoriums</h3><p class="prog-desc mb-0">Smart audio-visual lecture halls hosting national seminars, workshops, and guest lectures.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/sports.webp" class="prog-img" alt="Sports">
                    <div class="prog-body"><h3 class="prog-title">Sports Complex &amp; Gymnasium</h3><p class="prog-desc mb-0">Cricket stadium, basketball courts, indoor badminton arenas, and modern fitness gym.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/hostel.webp" class="prog-img" alt="Hostel">
                    <div class="prog-body"><h3 class="prog-title">Hostels &amp; Hygienic Dining</h3><p class="prog-desc mb-0">Secured hostels for boys &amp; girls with Wi-Fi, 24/7 security, medical support, and nutritious mess.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/INFRA-STRUCTURE-SRKU-05.webp" class="prog-img" alt="Healthcare">
                    <div class="prog-body"><h3 class="prog-title">Medical &amp; Healthcare Center</h3><p class="prog-desc mb-0">On-campus 100-bed hospital providing round-the-clock emergency care, pharmacy, and check-ups.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     PLACEMENT & TOP RECRUITERS
═══════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-6">
                <span class="section-subtitle">CAREER &amp; PLACEMENT CELL</span>
                <h2 class="section-title mb-3">Unmatched Placement <span>Track Record</span></h2>
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.94rem;">
                    Our dedicated Corporate Relations Cell conducts year-round campus recruitment drives, soft skills training, mock interviews, and industry internships connecting students to 120+ top companies.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> TCS</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> Infosys</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> Amazon</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> Wipro</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> HCL</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> L&amp;T</div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/placement-hero-DCAhDTqD.jpg"
                     onerror="this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/graduates.webp'"
                     alt="Campus Placement" class="img-fluid rounded border border-4 border-danger shadow">
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     GALLERY SECTION (Bootstrap 5-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream">
    <div class="container-xl py-2">
        <div class="text-center mb-4">
            <span class="section-subtitle">CAMPUS LIFE</span>
            <h2 class="section-title">Life at <span>SRK University</span></h2>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-2">
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-01.webp" class="gallery-img" alt="Gallery 1"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-03.webp" class="gallery-img" alt="Gallery 2"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-06.webp" class="gallery-img" alt="Gallery 3"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-07.webp" class="gallery-img" alt="Gallery 4"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-10.webp" class="gallery-img" alt="Gallery 5"></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ADMISSION FORM SECTION (Bootstrap Maroon 2-col Form)
═══════════════════════════════════════════════════════ -->
<section class="enquiry-section py-5" id="apply">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            
            <div class="col-12 col-lg-5 text-white">
                <span class="section-subtitle text-warning">ADMISSION SESSION 2026-27</span>
                <h2 class="text-white fw-bold mb-3">Apply For <span class="text-warning">Admissions 2026</span></h2>
                <p class="text-white-50 mb-4" style="line-height:1.7;">
                    Fill out your details and our counselor will call you within 24 hours. Seats are limited — apply early!
                </p>
                <ul class="list-unstyled text-white-50 d-flex flex-column gap-2">
                    <li><i class="fas fa-check-circle text-warning me-2"></i> UGC Recognized &amp; AICTE Approved</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> 94% Campus Placement Rate</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> Scholarship &amp; Financial Aid Available</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> Industry-Integrated Curriculum</li>
                </ul>
            </div>

            <div class="col-12 col-lg-7">
                <div class="enquiry-form-box">
                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> Thank you! Our team will contact you shortly.</div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger"><?php echo sanitize($enquiryErr); ?></div>
                    <?php endif; ?>

                    <form action="#apply" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Full Name *</label>
                            <input type="text" name="name" class="form-control py-2" placeholder="Enter your full name" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Email Address *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Phone Number *</label>
                                <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit mobile" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Interested Course</label>
                            <select name="course" class="form-select py-2">
                                <option value="">-- Select Course --</option>
                                <option>B.Tech Computer Science</option>
                                <option>Bachelor of Pharmacy (B.Pharm)</option>
                                <option>MBA — Master of Business Administration</option>
                                <option>MCA — Master of Computer Applications</option>
                                <option>B.Sc Nursing</option>
                                <option>LL.B — Bachelor of Law</option>
                                <option>Other Programme</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Message / Query</label>
                            <textarea name="message" class="form-control py-2" rows="3" placeholder="Specify your qualification or query"></textarea>
                        </div>
                        <button type="submit" name="submit_enquiry" class="btn btn-warning w-100 py-2 fw-bold text-dark">
                            <i class="fas fa-paper-plane me-1"></i> Submit Admission Enquiry
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CTA BANNER (Bootstrap Layout)
═══════════════════════════════════════════════════════ -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-dark));">
    <div class="container-xl py-2">
        <h2 class="fw-bold mb-2">Admissions Open for Session 2026-27</h2>
        <p class="text-white-50 mb-4" style="font-size:1.05rem;">Take the first step towards a rewarding global career with SRK University Bhopal.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="#apply" class="btn btn-srku-gold px-4 py-2"><i class="fas fa-edit me-1"></i> Apply Now</a>
            <a href="tel:07554911204" class="btn btn-srku-outline px-4 py-2"><i class="fas fa-phone-alt me-1"></i> Call Helpline</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
