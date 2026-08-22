<?php
$pageTitle = "Home - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "home";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$tickerText = getSetting('ticker_text', 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for Engineering, Pharmacy, Nursing, Management & Medicine | 94% Placement Record');
$totalLabs = getSetting('total_labs', '42+');
$placementRecord = getSetting('placement_record', '94%');
$highestPackage = getSetting('highest_package', '12 LPA');
$recruitingPartners = getSetting('recruiting_partners', '120+');
$totalAlumni = getSetting('total_alumni', '15,000+');
$heroTitle = getSetting('hero_title', 'SRK University, Bhopal');
$heroSubtitle = getSetting('hero_subtitle', 'UGC-Recognized University in MP');
$heroDesc = getSetting('hero_desc', 'Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership. If you are looking for the best placement university in MP, our rigorous research, multi-disciplinary collaboration, and industry-aligned pedagogy deliver unmatched career growth.');
$chancellorName = getSetting('chancellor_name', 'Dr. Sadhna Kapoor');
$chancellorTitle = getSetting('chancellor_title', 'Chancellor');
$chancellorQuote = getSetting('chancellor_quote', 'We bridge academic brilliance with industrial pragmatism.');
$chancellorMsg = getSetting('chancellor_msg', 'Dr. Sadhna Kapoor is the Chancellor of SRK University, Bhopal. A visionary and selfless leader with exceptional entrepreneurial, interpersonal, social and administrative skills, she is passionate about technology and innovation, community development, social service, and interdisciplinary teaching and research.');
$chancellorMsg2 = getSetting('chancellor_msg2', 'Under her stewardship, SRK University has been recognised for its global academic collaborations, reflecting a sustained dedication to educational innovation and excellence.');

// Handle Form Submission for Enquiry
$enquirySuccess = false;
$enquiryErr = '';
$enquiryMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_enquiry'])) {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['course'] ?? '',
        $_POST['message'] ?? '',
        'Homepage Admission Section'
    );
    if ($res['success']) {
        $enquirySuccess = true;
        $enquiryMsg = $res['message'];
    } else {
        $enquiryErr = $res['error'];
    }
}
?>

<!-- ═══════════════════════════════════════════════════════
     HERO SECTION — 100% FULLSCREEN HTML5 VIDEO
═══════════════════════════════════════════════════════ -->
<section class="hero-section position-relative">

    <video class="hero-bg-video" autoplay muted loop playsinline poster="<?php echo BASE_URL; ?>assets/images/campus-1.webp">
        <source src="<?php echo BASE_URL; ?>assets/images/C0036.mp4" type="video/mp4">
        <source src="<?php echo BASE_URL; ?>assets/upload/2026/06/C0036.mp4" type="video/mp4">
    </video>

    <div class="hero-overlay"></div>

    <div class="container-fluid px-4 px-lg-5 position-relative z-3">
        <div class="hero-content px-0">
            <h1 class="hero-h1">
                <?php echo sanitize($heroTitle); ?><br>
                <span class="gold-line"><?php echo sanitize($heroSubtitle); ?></span>
            </h1>
            <p class="hero-desc my-3">
                <?php echo sanitize($heroDesc); ?>
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn-hero-yellow">Apply Now</a>
                <a href="<?php echo BASE_URL; ?>courses.php" class="btn-hero-outline">Explore Programmes</a>
            </div>
        </div>
    </div>

    <!-- Hero Floating Stats Stack (Uniform Flex Container) -->
    <div class="hero-stats-floating d-none d-xl-flex">
        <!-- Stat Card 1 — White Glass -->
        <div class="hero-stat-card hero-stat-card-white">
            <div class="icon-box">
                <i class="fas fa-microscope"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-num mb-0"><?php echo sanitize($totalLabs); ?></h3>
                <p class="stat-lbl mb-0">HIGH-TECH LABS</p>
            </div>
        </div>

        <!-- Stat Card 2 — Brand Red -->
        <div class="hero-stat-card hero-stat-card-red">
            <div class="icon-box">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-num mb-0"><?php echo sanitize($placementRecord); ?></h3>
                <p class="stat-lbl mb-0">PLACEMENT RECORD</p>
            </div>
        </div>
    </div>

    <!-- Live ticker pinned to bottom of hero -->
    <div class="hero-ticker">
        <div class="hero-ticker-label">LIVE UPDATES</div>
        <div class="hero-ticker-track">
            <span class="hero-ticker-content">
                <?php echo sanitize($tickerText); ?> &nbsp;&bull;&nbsp;
                Highest Package: <?php echo sanitize($highestPackage); ?> &nbsp;&bull;&nbsp;
                <?php echo sanitize($recruitingPartners); ?> Corporate Recruitment Partners &nbsp;&bull;&nbsp;
                UGC Recognized &amp; AICTE Approved Premier University in Madhya Pradesh &nbsp;&bull;&nbsp;
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
                <div class="stat-val"><?php echo sanitize($totalLabs); ?></div>
                <div class="stat-txt">High-Tech Labs</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($placementRecord); ?></div>
                <div class="stat-txt">Placement Record</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($recruitingPartners); ?></div>
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
                <div class="d-flex gap-3">
                    <a href="<?php echo BASE_URL; ?>about.php" class="btn btn-srku"><i class="fas fa-arrow-right me-1"></i> Read More</a>
                    <a href="<?php echo BASE_URL; ?>page.php?slug=why-srk" class="btn btn-outline-danger"><i class="fas fa-star me-1"></i> Why Choose SRKU</a>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="position-relative">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/campus-1.webp"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         alt="SRKU Main Campus" class="welcome-img">
                    <div class="row g-2 mt-3 text-center">
                        <div class="col-4">
                            <div class="welcome-badge"><strong><?php echo sanitize($totalLabs); ?></strong><small>HIGH-TECH LABS</small></div>
                        </div>
                        <div class="col-4">
                            <div class="welcome-badge"><strong><?php echo sanitize($placementRecord); ?></strong><small>Placement Rate</small></div>
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
     STATUTORY APPROVALS & TRUST BADGES (Official University Seal)
═══════════════════════════════════════════════════════ -->
<div class="py-4 border-top border-bottom bg-light">
    <div class="container-xl">
        <div class="row align-items-center g-3 text-center">
            <div class="col-12 col-md-3 text-md-start">
                <span class="text-uppercase text-danger fw-bold small" style="letter-spacing:1px;"><i class="fas fa-shield-alt me-1"></i> Recognized &amp; Approved By</span>
                <h6 class="fw-bold text-navy mb-0">Apex Statutory Councils of India</h6>
            </div>
            <div class="col-12 col-md-9">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-end gap-2">
                    <span class="badge bg-white text-dark border px-3 py-2 fw-semibold shadow-sm"><i class="fas fa-check-circle text-success me-1"></i> UGC Sec. 2(f)</span>
                    <span class="badge bg-white text-dark border px-3 py-2 fw-semibold shadow-sm"><i class="fas fa-check-circle text-success me-1"></i> AICTE Approved</span>
                    <span class="badge bg-white text-dark border px-3 py-2 fw-semibold shadow-sm"><i class="fas fa-check-circle text-success me-1"></i> PCI Recognized</span>
                    <span class="badge bg-white text-dark border px-3 py-2 fw-semibold shadow-sm"><i class="fas fa-check-circle text-success me-1"></i> INC &amp; MPNRC</span>
                    <span class="badge bg-white text-dark border px-3 py-2 fw-semibold shadow-sm"><i class="fas fa-check-circle text-success me-1"></i> Bar Council of India</span>
                    <span class="badge bg-white text-dark border px-3 py-2 fw-semibold shadow-sm"><i class="fas fa-check-circle text-success me-1"></i> National Medical Comm.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     EXPLORE PROGRAMMES SECTION (Bootstrap 4-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream">
    <div class="container-xl py-3">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-2">
            <div>
                <span class="section-subtitle">CONSTITUENT UNITS</span>
                <h2 class="section-title mb-0">A Guide to the University's <span>Constituent Units</span></h2>
            </div>
            <a href="<?php echo BASE_URL; ?>departments.php" class="btn-card-apply fs-6">View all Constituent Unit <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp" class="prog-img" alt="RKDF Institute of Science & Technology">
                    <div class="prog-body">
                        <h3 class="prog-title">RKDF Institute of Science &amp; Technology</h3>
                        <p class="prog-desc">Empowering minds in research &amp; science, engineering for tomorrow's leaders.</p>
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-science-technology" class="btn-card-apply">Explore &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-COP.webp" class="prog-img" alt="SRK College of Pharmacy"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/R.N.-KAPOOR-MEMORIAL-PHARMACY.webp';">
                    <div class="prog-body">
                        <h3 class="prog-title">SRK College of Pharmacy</h3>
                        <p class="prog-desc">Shaping allied pharmacy leadership and skill training.</p>
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-college-of-pharmacy" class="btn-card-apply">Explore &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SARVEPALLI-RADHAKRISHANAN-COLLEGE-OF-ALLIED-HEALTHCARE-SCIENCES.webp" class="prog-img" alt="SRK College of Allied Healthcare Sciences">
                    <div class="prog-body">
                        <h3 class="prog-title">SRK College of Allied Healthcare Sciences</h3>
                        <p class="prog-desc">Delivering quality allied healthcare education with skilled clinical training.</p>
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-paramedical-sciences" class="btn-card-apply">Explore &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/RKDF-POLYTECHNIC-PHARMACY.webp" class="prog-img" alt="RKDF Polytechnic Pharmacy College"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body">
                        <h3 class="prog-title">RKDF Polytechnic Pharmacy</h3>
                        <p class="prog-desc">Providing industry-aligned diploma pharmacy education and practical training.</p>
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-polytechnic-pharmacy" class="btn-card-apply">Explore &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Pharmacy-Homeopathy.webp" class="prog-img" alt="SRK Homeopathic Medical College"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body">
                        <h3 class="prog-title">SRK Homeopathic Medical College</h3>
                        <p class="prog-desc">Nurturing holistic healing through a foundation in Homeopathic medicine.</p>
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=srk-homeopathic-medical-college" class="btn-card-apply">Explore &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/R.N.-KAPOOR-MEMORIAL-PHARMACY.webp" class="prog-img" alt="Dr. APJ College of Pharmacy">
                    <div class="prog-body">
                        <h3 class="prog-title">Dr. APJ College of Pharmacy</h3>
                        <p class="prog-desc">Building future pharmacists with a foundation in advanced research skills.</p>
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=dr-apj-abdul-kalam-college-of-pharmacy" class="btn-card-apply">Explore &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-COLLEGE-OF-AYURVEDA.webp" class="prog-img" alt="SRK College of Ayurveda"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body">
                        <h3 class="prog-title">SRK College of Ayurveda</h3>
                        <p class="prog-desc">Preserving Ayurvedic wisdom through a foundation in traditional and modern research.</p>
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=srk-college-of-ayurveda" class="btn-card-apply">Explore &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/RKDF-MEDICAL-COLLEGE.webp" class="prog-img" alt="SRK Medical College"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/Operation-Theatre.webp';">
                    <div class="prog-body">
                        <h3 class="prog-title">SRK Medical College</h3>
                        <p class="prog-desc">Comprehensive medical education preparing skilled, ethical clinical physicians.</p>
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-medicine" class="btn-card-apply">Explore &rarr;</a>
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
            <span class="section-subtitle">WHY CHOOSE SRKU</span>
            <h2 class="section-title">Foundations of Academic <span>Excellence</span> in Central India</h2>
            <p class="text-muted small mb-0">Discover why we are consistently ranked among the top engineering colleges in MP and premier management hubs.</p>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-science-technology" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-cogs"></i></div><div class="faculty-info"><h4>Faculty of Engineering</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-medicine" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-stethoscope"></i></div><div class="faculty-info"><h4>Faculty of Medicine</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-management" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-chart-bar"></i></div><div class="faculty-info"><h4>Business &amp; Management</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-paramedical-sciences" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-user-md"></i></div><div class="faculty-info"><h4>Paramedical Sciences</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-law" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-balance-scale"></i></div><div class="faculty-info"><h4>Law &amp; Governance</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-allied-science-and-humanities" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-atom"></i></div><div class="faculty-info"><h4>Allied Science &amp; Humanities</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-agriculture" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-seedling"></i></div><div class="faculty-info"><h4>Faculty of Agriculture</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-science-technology-mca" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-laptop-code"></i></div><div class="faculty-info"><h4>Computer Application</h4></div></div></a></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ADMISSION PATHWAYS (UG / PG / PhD / Diploma)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-2">
            <div>
                <span class="section-subtitle">COURSES &amp; PROGRAMS</span>
                <h2 class="section-title mb-0">How to Get Admission in <span>SRK University</span> Bhopal?</h2>
                <p class="text-muted small mb-0">Choose your trajectory from over 140+ meticulously designed programs and find the pathway that fits your goals.</p>
            </div>
            <a href="<?php echo BASE_URL; ?>courses.php" class="btn-card-apply fs-6">View all 140+ programs <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-user-graduate"></i></div>
                    <h3>UG</h3>
                    <p>B.Tech, BCA, BBA, B.Pharm, BA LL.B, MBBS &amp; more foundation degree programs.</p>
                </div>
            </div>
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-user-tie"></i></div>
                    <h3>PG</h3>
                    <p>M.Tech, MBA, MCA, M.Pharm, LL.M &amp; specialized postgraduate degrees.</p>
                </div>
            </div>
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-microscope"></i></div>
                    <h3>PHD</h3>
                    <p>Doctoral Research across Engineering, Pharmacy, Management &amp; Sciences.</p>
                </div>
            </div>
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-certificate"></i></div>
                    <h3>Diploma &amp; Certificate</h3>
                    <p>Professional Development and short-term certification programs.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CHANCELLOR MESSAGE (matches live srku.edu.in design)
═══════════════════════════════════════════════════════ -->
<section class="chancellor-v2">
    <div class="chancellor-v2__inner">
        <div class="chancellor-v2__media">
            <img class="chancellor-v2__photo"
                 src="<?php echo BASE_URL; ?>assets/uploads/2026/08/Chancelloer-480x503-1.jpg"
                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/ruchichaubey.webp';"
                 alt="<?php echo sanitize($chancellorName); ?>, Chancellor of SRK University, Bhopal">
            <div class="chancellor-v2__quote">
                <p class="chancellor-v2__quote-text">&ldquo;<?php echo sanitize($chancellorQuote); ?>&rdquo;</p>
                <p class="chancellor-v2__quote-name"><?php echo strtoupper(sanitize($chancellorName)); ?> &middot; <?php echo sanitize($chancellorTitle); ?></p>
            </div>
        </div>
        <div class="chancellor-v2__content">
            <p class="chancellor-v2__eyebrow">Chancellor&rsquo;s Message</p>
            <h2 class="chancellor-v2__title">A legacy of <em>excellence.</em><br>A vision for tomorrow.</h2>
            <p class="chancellor-v2__body"><?php echo sanitize($chancellorMsg); ?></p>
            <p class="chancellor-v2__body"><?php echo sanitize($chancellorMsg2); ?></p>
            <div class="chancellor-v2__accred">
                <div class="chancellor-v2__accred-item"><span class="chancellor-v2__accred-name">UGC</span><span class="chancellor-v2__accred-tag">Recognised</span></div>
                <div class="chancellor-v2__accred-item"><span class="chancellor-v2__accred-name">NAAC</span><span class="chancellor-v2__accred-tag">A+ Grade</span></div>
                <div class="chancellor-v2__accred-item"><span class="chancellor-v2__accred-name">AICTE</span><span class="chancellor-v2__accred-tag">Approved</span></div>
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
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/library.webp" class="prog-img" alt="Library"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Central Digital Library</h3><p class="prog-desc mb-0">50,000+ books, international journals, e-books, and 24/7 digital resource access.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp" class="prog-img" alt="Labs"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">42+ Advanced Research Labs</h3><p class="prog-desc mb-0">High-performance computing, Robotics, Pharmaceutics testing, and AI innovation units.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Operation-Theatre.webp" class="prog-img" alt="Lecture Halls"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Air-Conditioned Auditoriums</h3><p class="prog-desc mb-0">Smart audio-visual lecture halls hosting national seminars, workshops, and guest lectures.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/sports.webp" class="prog-img" alt="Sports"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Sports Complex &amp; Gymnasium</h3><p class="prog-desc mb-0">Cricket ground, basketball courts, indoor badminton arenas, and modern fitness gym.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/hostel.webp" class="prog-img" alt="Hostel"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Hostels &amp; Hygienic Dining</h3><p class="prog-desc mb-0">Secured hostels for boys &amp; girls with Wi-Fi, 24/7 security, and nutritious dining.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/INFRA-STRUCTURE-SRKU-05.webp" class="prog-img" alt="Healthcare"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Medical &amp; Healthcare Center</h3><p class="prog-desc mb-0">On-campus 750+ bed hospital providing round-the-clock emergency care, pharmacy, and check-ups.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     LABS DRIVING INDUSTRY INNOVATION
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-6 order-lg-2">
                <span class="section-subtitle">INNOVATION &amp; RESEARCH</span>
                <h2 class="section-title mb-3">Labs <span>Driving</span> Industry Innovation</h2>
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.94rem;">
                    Innovative faculty and staff members work with industry partners to produce ready-to-deploy solutions across our 42+ advanced research labs.
                </p>
                <div class="row row-cols-3 g-3 text-center">
                    <div class="col"><div class="student-life-stat"><span class="num">42+</span><span class="lbl">Patents Filed</span></div></div>
                    <div class="col"><div class="student-life-stat"><span class="num">120+</span><span class="lbl">Research Labs</span></div></div>
                    <div class="col"><div class="student-life-stat"><span class="num">&#8377;12Cr+</span><span class="lbl">Annual Grants</span></div></div>
                </div>
            </div>
            <div class="col-12 col-lg-6 order-lg-1">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     alt="Labs Driving Industry Innovation" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     PLACEMENT & TOP RECRUITERS
═══════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-4">
            <span class="section-subtitle">DISCOVER SUCCESS</span>
            <h2 class="section-title mb-0">A direct pipeline to <span>industry leadership</span></h2>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-3 text-center mb-4">
            <div class="col"><div class="student-life-stat"><span class="num">&#8377;42 LPA</span><span class="lbl">Highest International Package</span></div></div>
            <div class="col"><div class="student-life-stat"><span class="num">500+</span><span class="lbl">Global Corporate Partners</span></div></div>
            <div class="col"><div class="student-life-stat"><span class="num">15,000+</span><span class="lbl">Alumni in Leadership</span></div></div>
        </div>
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-6">
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.94rem;">
                    Our dedicated Corporate Relations Cell conducts year-round campus recruitment drives, soft skills training, mock interviews, and industry internships connecting students to 500+ top national and global MNCs.
                </p>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> TATA</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> Infosys</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> Amazon</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> Wipro</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> Cognizant</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> Sun Pharma</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> L&amp;T</div>
                    <div class="rec-logo"><i class="fas fa-building text-danger"></i> HDFC Bank</div>
                </div>
                <a href="<?php echo BASE_URL; ?>placements.php" class="btn btn-srku"><i class="fas fa-chart-line me-1"></i> View Full Placement Report</a>
            </div>
            <div class="col-12 col-lg-6">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/placement-hero-DCAhDTqD.jpg"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/graduates.webp';"
                     alt="Campus Placement" class="img-fluid rounded-4 border border-4 border-danger shadow">
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     STUDENT LIFE AT SRK (matches live srku.edu.in design)
═══════════════════════════════════════════════════════ -->
<section class="student-life-v2">
    <div class="student-life-v2__inner">
        <p class="student-life-v2__eyebrow">Student Life at SRK</p>
        <h2 class="student-life-v2__title">Experience <em>an Unmatched University</em><br>Campus Life in Bhopal</h2>
        <p class="student-life-v2__desc">A campus that thinks, builds, and celebrates together.<br>200 lush acres, 120+ active student clubs, and 18 annual fests create an unforgettable student journey.</p>

        <div class="student-life-v2__row">
            <div class="student-life-v2__media">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/alumni-hero-TzGn9_DY-3.jpg"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     alt="Annual Cultural Fest at SRK University">
                <div class="student-life-v2__badge">
                    <span class="student-life-v2__badge-tag">Featured</span>
                    <span class="student-life-v2__badge-title">Annual Cultural Fest</span>
                </div>
            </div>
            <div class="student-life-v2__grid">
                <div class="student-life-v2__box student-life-v2__box--maroon">
                    <i class="fas fa-star"></i>
                    <h3>42+</h3>
                    <p>Active Clubs</p>
                </div>
                <div class="student-life-v2__box student-life-v2__box--gray">
                    <i class="fas fa-trophy"></i>
                    <h3>120+</h3>
                    <p>Sports</p>
                </div>
                <div class="student-life-v2__box student-life-v2__box--cream">
                    <i class="fas fa-bed"></i>
                    <h3>4,500+</h3>
                    <p>Hostel Beds</p>
                </div>
                <div class="student-life-v2__box student-life-v2__box--maroon">
                    <i class="fas fa-music"></i>
                    <h3>18</h3>
                    <p>Annual Fests</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     GALLERY SECTION (Bootstrap 5-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream">
    <div class="container-xl py-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="section-subtitle">CAMPUS LIFE</span>
                <h2 class="section-title mb-0">Life at <span>SRK University</span></h2>
            </div>
            <a href="<?php echo BASE_URL; ?>gallery.php" class="btn-card-apply">View Full Gallery &rarr;</a>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-2">
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-01.webp" class="gallery-img" alt="Gallery 1" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-03.webp" class="gallery-img" alt="Gallery 2" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-06.webp" class="gallery-img" alt="Gallery 3" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-07.webp" class="gallery-img" alt="Gallery 4" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-10.webp" class="gallery-img" alt="Gallery 5" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
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
                    Fill out your details and our admission counselor will call you within 24 hours. Seats are limited — apply early!
                </p>
                <ul class="list-unstyled text-white-50 d-flex flex-column gap-2">
                    <li><i class="fas fa-check-circle text-warning me-2"></i> UGC Recognized &amp; AICTE/PCI Approved</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> 94% Campus Placement Record</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> Scholarship &amp; Fee Concessions Available</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> Modern On-Campus Hostels &amp; Transport</li>
                </ul>
            </div>

            <div class="col-12 col-lg-7">
                <div class="enquiry-form-box">
                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> Thank you! Your admission enquiry has been submitted successfully. Our team will contact you shortly.</div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger"><?php echo sanitize($enquiryErr); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>#apply" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Full Name *</label>
                            <input type="text" name="name" class="form-control py-2" placeholder="Enter your full name" minlength="2" maxlength="80" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Email Address *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Phone Number *</label>
                                <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit mobile number" pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Interested Programme</label>
                            <select name="course" class="form-select py-2">
                                <option value="">-- Select Course --</option>
                                <option>B.Tech Computer Science &amp; Engineering</option>
                                <option>B.Tech Artificial Intelligence &amp; Data Science</option>
                                <option>Bachelor of Pharmacy (B.Pharm)</option>
                                <option>Diploma in Pharmacy (D.Pharm)</option>
                                <option>MBA — Master of Business Administration</option>
                                <option>MCA — Master of Computer Applications</option>
                                <option>B.Sc. Nursing</option>
                                <option>LL.B — Bachelor of Laws</option>
                                <option>B.Sc. (Hons) Agriculture</option>
                                <option>BPT — Bachelor of Physiotherapy</option>
                                <option>Other University Programme</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Message / Query</label>
                            <textarea name="message" class="form-control py-2" rows="3" placeholder="Specify your qualification or question"></textarea>
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
     RECENT NEWS & BLOGS
═══════════════════════════════════════════════════════ -->
<?php $homeNews = getNews(null, 3); ?>
<?php if (!empty($homeNews)): ?>
<section class="py-5 bg-cream">
    <div class="container-xl py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-2">
            <div>
                <span class="section-subtitle">RECENT NEWS</span>
                <h2 class="section-title mb-0">Information About All the <span>News &amp; Events</span> of University</h2>
            </div>
            <a href="<?php echo BASE_URL; ?>blogs.php" class="btn-card-apply fs-6">View All News <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($homeNews as $n): ?>
                <div class="col">
                    <div class="prog-card">
                        <img src="<?php echo !empty($n['image_url']) ? BASE_URL . sanitize($n['image_url']) : BASE_URL . 'assets/uploads/2026/07/001.webp'; ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                             class="prog-img" alt="<?php echo sanitize($n['title']); ?>">
                        <div class="prog-body">
                            <div class="small text-muted mb-1"><i class="far fa-calendar-alt me-1"></i> <?php echo date('d M Y', strtotime($n['publish_date'] ?: $n['created_at'])); ?></div>
                            <h3 class="prog-title"><?php echo sanitize($n['title']); ?></h3>
                            <p class="prog-desc"><?php echo substr(strip_tags($n['content']), 0, 100) . '...'; ?></p>
                            <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($n['slug'] ?: $n['id']); ?>" class="btn-card-apply">Read More &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════
     CTA BANNER
═══════════════════════════════════════════════════════ -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-dark));">
    <div class="container-xl py-2">
        <h2 class="fw-bold mb-2">Admissions Open for Academic Session 2026-27</h2>
        <p class="text-white-50 mb-4" style="font-size:1.05rem;">Take the first step towards a rewarding global career with SRK University Bhopal.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="#apply" class="btn btn-srku-gold px-4 py-2"><i class="fas fa-edit me-1"></i> Apply Now</a>
            <a href="tel:<?php echo preg_replace('/[^0-9]/', '', getSetting('helpline')); ?>" class="btn btn-srku-outline px-4 py-2"><i class="fas fa-phone-alt me-1"></i> Call Helpline</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
