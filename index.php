<?php
$pageTitle = "Sarvepalli Radhakrishnan University, Bhopal (MP) - UGC Recognized";
$activeNav = "home";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$tickerText = getSetting('ticker_text', 'Admissions Open 2026-27 for B.Tech, MBBS, B.Pharm, MBA, Nursing, Law, Agriculture & Paramedical | UGC Recognized under Section 2(f) | AICTE & PCI Approved | 94% Placement Assistance');
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

// Handle Form Submission for Admission Enquiry
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
        'Homepage Admission Counseling Section'
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
     HERO BANNER — OFFICIAL UNIVERSITY HERO
═══════════════════════════════════════════════════════ -->
<section class="hero-section position-relative">
    <video class="hero-bg-video" autoplay muted loop playsinline poster="<?php echo BASE_URL; ?>assets/uploads/2026/07/campus-1.webp">
        <source src="<?php echo BASE_URL; ?>assets/images/C0036.mp4" type="video/mp4">
        <source src="<?php echo BASE_URL; ?>assets/upload/2026/06/C0036.mp4" type="video/mp4">
    </video>

    <div class="hero-overlay"></div>

    <div class="container-xl position-relative z-3 py-4">
        <div class="hero-content">
            
            <div class="hero-badge">
                <i class="fas fa-bullhorn text-warning"></i> Admissions Open for Academic Session 2026-27
            </div>

            <h1 class="hero-h1">
                Sarvepalli Radhakrishnan<br>
                <span class="highlight-gold">University, Bhopal</span>
            </h1>

            <p class="hero-desc">
                Established under Madhya Pradesh State Legislature Act &amp; recognized under Section 2(f) of the UGC Act 1956. Empowering over 15,000+ graduates with industry-driven education, 42+ advanced laboratories, and a 750-bed multi-specialty teaching hospital.
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn-hero-yellow">Apply Now</a>
                <a href="<?php echo BASE_URL; ?>courses.php" class="btn-hero-outline">Explore Programmes</a>
            </div>

            <!-- Quick Action Tiles directly on Hero -->
            <div class="hero-quick-tiles">
                <a href="#apply" class="hero-quick-tile">
                    <i class="fas fa-user-check"></i>
                    <div>
                        <p class="tile-title">Admissions 2026-27</p>
                        <p class="tile-sub">Apply Online Today</p>
                    </div>
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php" class="hero-quick-tile">
                    <i class="fas fa-university"></i>
                    <div>
                        <p class="tile-title">14 Constituent Units</p>
                        <p class="tile-sub">Engg, Pharma, Medical, Law</p>
                    </div>
                </a>
                <a href="<?php echo BASE_URL; ?>facilities.php" class="hero-quick-tile">
                    <i class="fas fa-hospital"></i>
                    <div>
                        <p class="tile-title">750+ Bed Hospital</p>
                        <p class="tile-sub">On-Campus Medical Care</p>
                    </div>
                </a>
                <a href="<?php echo BASE_URL; ?>placements.php" class="hero-quick-tile">
                    <i class="fas fa-chart-line"></i>
                    <div>
                        <p class="tile-title">94% Placement Rate</p>
                        <p class="tile-sub">120+ Hiring Partners</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     LIVE NOTIFICATION TICKER
═══════════════════════════════════════════════════════ -->
<div class="live-ticker-bar">
    <div class="ticker-tag"><i class="fas fa-bell me-1"></i> Official Updates</div>
    <div class="ticker-marquee">
        <span class="ticker-text">
            <?php echo sanitize($tickerText); ?> &nbsp;&bull;&nbsp;
            Highest Salary Package: <strong><?php echo sanitize($highestPackage); ?></strong> &nbsp;&bull;&nbsp;
            120+ Corporate Recruiters &nbsp;&bull;&nbsp;
            Statutory Approvals by UGC, AICTE, PCI, INC, BCI, NMC &amp; MPNRC &nbsp;&bull;&nbsp;
            Academic Calendar 2026-27 &amp; Semester Schedules Released &nbsp;&bull;&nbsp;
        </span>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     CAMPUS AT A GLANCE — KEY INSTITUTIONAL METRICS
═══════════════════════════════════════════════════════ -->
<section class="stats-strip">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-0 text-center">
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($totalLabs); ?></div>
                <div class="stat-txt">High-Tech Labs</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($placementRecord); ?></div>
                <div class="stat-txt">Placement Rate</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">14+</div>
                <div class="stat-txt">Faculties &amp; Institutes</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($recruitingPartners); ?></div>
                <div class="stat-txt">Corporate Recruiters</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">750+</div>
                <div class="stat-txt">Bed Teaching Hospital</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">15,000+</div>
                <div class="stat-txt">Alumni Worldwide</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ABOUT SARVEPALLI RADHAKRISHNAN UNIVERSITY
═══════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            
            <!-- Left: Institutional Overview -->
            <div class="col-12 col-lg-6">
                <span class="section-subtitle">ABOUT SRK UNIVERSITY</span>
                <h2 class="section-title mb-3">Excellence in Higher Education, <span>Research &amp; Healthcare</span></h2>
                
                <p class="text-dark mb-3" style="line-height:1.8; font-size:0.96rem;">
                    Sarvepalli Radhakrishnan University (SRKU), Bhopal is established under the MP Niji Vishwavidyalaya Adhiniyam and recognized under Section 2(f) of the University Grants Commission (UGC) Act, 1956. Located on NH-12 Hoshangabad Road, Bhopal, SRKU offers comprehensive academic programs across Engineering, Pharmacy, Medicine, Nursing, Law, Agriculture, Management, and Paramedical Sciences.
                </p>

                <p class="text-muted mb-4" style="line-height:1.8; font-size:0.93rem;">
                    With state-of-the-art campus infrastructure, 42+ accredited research laboratories, 750-bed multi-specialty teaching hospital, digital central library, and distinguished faculty members, the university provides an ideal platform for academic rigor, ethical grounding, and corporate placement success.
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light border rounded-3 d-flex align-items-center gap-3 shadow-sm">
                            <i class="fas fa-university text-danger fa-2x"></i>
                            <div>
                                <h6 class="fw-bold text-navy mb-0">UGC &amp; AICTE Approved</h6>
                                <small class="text-muted">Statutory Recognition</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light border rounded-3 d-flex align-items-center gap-3 shadow-sm">
                            <i class="fas fa-hospital text-danger fa-2x"></i>
                            <div>
                                <h6 class="fw-bold text-navy mb-0">On-Campus Hospital</h6>
                                <small class="text-muted">750+ Bed Multi-Specialty</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>about.php" class="btn btn-srku"><i class="fas fa-arrow-right me-1"></i> Read University Profile</a>
                    <a href="<?php echo BASE_URL; ?>page.php?slug=why-srk" class="btn btn-outline-danger"><i class="fas fa-star me-1"></i> Why Choose SRKU</a>
                </div>
            </div>

            <!-- Right: Campus Infrastructure Showcase -->
            <div class="col-12 col-lg-6">
                <div class="position-relative">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/campus-1.webp" 
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         class="img-fluid rounded-4 shadow-lg border border-3 border-white" alt="SRKU Campus Infrastructure">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     STATUTORY APPROVALS & RECOGNITION SEALS
═══════════════════════════════════════════════════════ -->
<section class="statutory-strip">
    <div class="container-xl">
        <div class="row align-items-center g-3 text-center text-md-start">
            <div class="col-12 col-md-3">
                <span class="text-uppercase text-danger fw-bold small" style="letter-spacing:1px;"><i class="fas fa-shield-alt me-1"></i> Recognized &amp; Approved</span>
                <h6 class="fw-bold text-navy mb-0">Apex Statutory Councils</h6>
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
     CONSTITUENT FACULTIES & ACADEMIC DISCIPLINES
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="text-center mb-5" style="max-width:720px; margin:auto;">
            <span class="section-subtitle">ACADEMIC DISCIPLINES</span>
            <h2 class="section-title">Constituent Faculties &amp; <span>Institutes</span></h2>
            <p class="text-muted small">Offering UGC recognized undergraduate, postgraduate, diploma and doctoral degrees across diverse disciplines.</p>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            <div class="col">
                <a href="<?php echo BASE_URL; ?>department-detail.php?slug=department-of-engineering" class="faculty-card-academic">
                    <div class="icon-box"><i class="fas fa-cogs"></i></div>
                    <div><h4>Faculty of Engineering &amp; Technology</h4><small class="text-muted">B.Tech, M.Tech, Diploma</small></div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo BASE_URL; ?>department-detail.php?slug=department-of-pharmacy" class="faculty-card-academic">
                    <div class="icon-box"><i class="fas fa-pills"></i></div>
                    <div><h4>Faculty of Pharmacy (PCI Approved)</h4><small class="text-muted">B.Pharm, D.Pharm, M.Pharm</small></div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo BASE_URL; ?>department-detail.php?slug=department-of-computer-application" class="faculty-card-academic">
                    <div class="icon-box"><i class="fas fa-laptop-code"></i></div>
                    <div><h4>Computer Applications &amp; IT</h4><small class="text-muted">BCA, MCA, PGDCA</small></div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-college-of-nursing" class="faculty-card-academic">
                    <div class="icon-box"><i class="fas fa-user-md"></i></div>
                    <div><h4>Faculty of Nursing (INC Approved)</h4><small class="text-muted">B.Sc Nursing, Post Basic, M.Sc</small></div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo BASE_URL; ?>department-detail.php?slug=department-of-management" class="faculty-card-academic">
                    <div class="icon-box"><i class="fas fa-chart-bar"></i></div>
                    <div><h4>Faculty of Business Management</h4><small class="text-muted">MBA (Dual Specialization), BBA</small></div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-agriculture" class="faculty-card-academic">
                    <div class="icon-box"><i class="fas fa-seedling"></i></div>
                    <div><h4>Faculty of Agriculture Sciences</h4><small class="text-muted">B.Sc (Hons) Agriculture, M.Sc</small></div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-law" class="faculty-card-academic">
                    <div class="icon-box"><i class="fas fa-balance-scale"></i></div>
                    <div><h4>Faculty of Law (BCI Approved)</h4><small class="text-muted">LL.B, BA LL.B, LL.M</small></div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-paramedical-sciences" class="faculty-card-academic">
                    <div class="icon-box"><i class="fas fa-heartbeat"></i></div>
                    <div><h4>Paramedical &amp; Physiotherapy</h4><small class="text-muted">BPT, MPT, BMLT, DMLT, X-Ray</small></div>
                </a>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo BASE_URL; ?>departments.php" class="btn btn-outline-danger px-4 py-2 fw-bold">
                <i class="fas fa-th me-1"></i> View All 14 Constituent Colleges &amp; Departments
            </a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     UNIVERSITY LEADERSHIP DESK
═══════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5" style="max-width:720px; margin:auto;">
            <span class="section-subtitle">GOVERNANCE &amp; MENTORSHIP</span>
            <h2 class="section-title">Message from the <span>Leadership Desk</span></h2>
        </div>

        <div class="row g-4">
            <!-- Chancellor Desk -->
            <div class="col-12 col-md-6">
                <div class="leadership-box">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/ruchichaubey.webp" 
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                             class="leadership-photo" alt="Dr. Sunil Kapoor - Chancellor">
                        <div>
                            <h4 class="h5 fw-bold text-navy mb-1">Dr. Sunil Kapoor</h4>
                            <p class="text-danger fw-bold small mb-0">Founder Chairman &amp; Hon'ble Chancellor</p>
                            <small class="text-muted">Sarvepalli Radhakrishnan University</small>
                        </div>
                    </div>
                    <div class="leadership-quote">
                        "At Sarvepalli Radhakrishnan University, our mission is to foster an academic environment that cultivates critical thinking, research innovation, and professional integrity. We empower our students to become healthcare pioneers, technology leaders, and responsible global citizens."
                    </div>
                    <div class="d-flex gap-2 mt-auto">
                        <a href="<?php echo BASE_URL; ?>page.php?slug=board-of-management" class="btn btn-sm btn-outline-danger"><i class="fas fa-user-tie me-1"></i> Full Profile</a>
                        <a href="<?php echo BASE_URL; ?>page.php?slug=vision-mission" class="btn btn-sm btn-light border"><i class="fas fa-bullseye me-1"></i> Vision &amp; Mission</a>
                    </div>
                </div>
            </div>

            <!-- Vice-Chancellor Desk -->
            <div class="col-12 col-md-6">
                <div class="leadership-box">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-navy text-gold rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:90px; height:90px; font-size:2.2rem; border:3px solid var(--srku-gold);">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h4 class="h5 fw-bold text-navy mb-1">Office of the Vice-Chancellor</h4>
                            <p class="text-danger fw-bold small mb-0">Vice-Chancellor Desk</p>
                            <small class="text-muted">Academic &amp; Research Administration</small>
                        </div>
                    </div>
                    <div class="leadership-quote">
                        "Higher education at SRKU is anchored in experiential learning, modern laboratory research, and multi-disciplinary academic flexibility. We continuously collaborate with leading national and international universities and industrial partners to deliver benchmark education."
                    </div>
                    <div class="d-flex gap-2 mt-auto">
                        <a href="<?php echo BASE_URL; ?>about.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-university me-1"></i> About University</a>
                        <a href="<?php echo BASE_URL; ?>courses.php" class="btn btn-sm btn-light border"><i class="fas fa-graduation-cap me-1"></i> Academic Courses</a>
                    </div>
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
                     alt="SRKU Campus Placement" class="img-fluid rounded-4 border shadow">
            </div>
        </div>

        <!-- Recruiter Logos Grid -->
        <div class="text-center mb-3">
            <h6 class="fw-bold text-navy text-uppercase" style="letter-spacing:1px;">Prominent Corporate Recruitment Partners</h6>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
            <div class="col"><div class="recruiter-badge"><i class="fas fa-building"></i> TCS</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-building"></i> Infosys</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-building"></i> Wipro</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-building"></i> Amazon</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-pills"></i> Cipla</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-pills"></i> Sun Pharma</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-cogs"></i> L&amp;T Infotech</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-laptop"></i> HCL Tech</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-university"></i> HDFC Bank</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-hospital"></i> Apollo Health</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-car"></i> Mahindra</div></div>
            <div class="col"><div class="recruiter-badge"><i class="fas fa-flask"></i> Lupin Ltd</div></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ADMISSIONS 2026-27 COUNSELING & APPLICATION FORM
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream">
    <div class="container-xl py-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="section-subtitle">STUDENT LIFE</span>
                <h2 class="section-title mb-0">Experience an Unmatched University <span>Campus Life</span> in Bhopal</h2>
                <p class="text-muted small mb-0">A campus that thrives, builds, and celebrates together — 220-acre campus, 120+ active clubs, and 18 annual fests keep an unmatched student journey alive.</p>
            </div>
            <a href="<?php echo BASE_URL; ?>gallery.php" class="btn-card-apply">View Full Gallery &rarr;</a>
        </div>
        <div class="row row-cols-2 row-cols-md-4 g-3 mb-4 text-center">
            <div class="col"><div class="student-life-stat"><span class="num">42+</span><span class="lbl">Active Clubs</span></div></div>
            <div class="col"><div class="student-life-stat"><span class="num">120+</span><span class="lbl">Sports</span></div></div>
            <div class="col"><div class="student-life-stat"><span class="num">4,500+</span><span class="lbl">Hostel Beds</span></div></div>
            <div class="col"><div class="student-life-stat"><span class="num">42+</span><span class="lbl">Annual Fests</span></div></div>
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
            
            <!-- Left Info Column -->
            <div class="col-12 col-lg-5">
                <span class="section-subtitle text-warning">ADMISSION DESK 2026-27</span>
                <h2 class="text-white fw-bold mb-3">Begin Your Academic Journey at <span class="text-warning">SRKU Bhopal</span></h2>
                
                <p class="text-white-50 mb-4" style="line-height:1.75;">
                    Submit your application or enquiry to receive personalized guidance from our senior academic counseling team. Admissions are conducted on merit basis as per regulatory norms.
                </p>

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-start gap-3">
                        <i class="fas fa-phone-alt text-warning fa-lg mt-1"></i>
                        <div>
                            <strong class="text-white">Admission Helpline:</strong>
                            <div class="text-white-50"><?php echo sanitize(getSetting('helpline', '0755 - 4911204')); ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <i class="fas fa-envelope text-warning fa-lg mt-1"></i>
                        <div>
                            <strong class="text-white">Email Address:</strong>
                            <div class="text-white-50"><?php echo sanitize(getSetting('email', 'exam@srku.edu.in')); ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <i class="fas fa-map-marker-alt text-warning fa-lg mt-1"></i>
                        <div>
                            <strong class="text-white">Campus Location:</strong>
                            <div class="text-white-50"><?php echo sanitize(getSetting('address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026')); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Column -->
            <div class="col-12 col-lg-7">
                <div class="admission-form-card">
                    <h4 class="fw-bold text-navy mb-1"><i class="fas fa-edit text-danger me-2"></i> Admission Enquiry 2026-27</h4>
                    <p class="text-muted small mb-4">Fill out the details below and our counseling desk will contact you within 24 hours.</p>

                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> <?php echo sanitize($enquiryMsg); ?></div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-1"></i> <?php echo sanitize($enquiryErr); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>#apply" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Candidate Full Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter student's full name" minlength="2" maxlength="80" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" class="form-control" placeholder="yourname@gmail.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">10-Digit Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control" placeholder="Mobile Number" pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Programme of Interest *</label>
                            <select name="course" class="form-select" required>
                                <option value="">-- Select Degree / Course --</option>
                                <option>B.Tech Computer Science &amp; Engineering</option>
                                <option>B.Tech Artificial Intelligence &amp; Data Science</option>
                                <option>Bachelor of Pharmacy (B.Pharm)</option>
                                <option>Diploma in Pharmacy (D.Pharm)</option>
                                <option>Master of Business Administration (MBA)</option>
                                <option>Master of Computer Applications (MCA)</option>
                                <option>B.Sc. Nursing</option>
                                <option>Bachelor of Laws (LL.B / BA LL.B)</option>
                                <option>B.Sc. (Hons) Agriculture</option>
                                <option>Bachelor of Physiotherapy (BPT)</option>
                                <option>Other University Degree</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Query / Message (Optional)</label>
                            <textarea name="message" class="form-control" rows="2" placeholder="Mention qualifying marks or specific admission queries"></textarea>
                        </div>
                        <button type="submit" name="submit_enquiry" class="btn btn-srku w-100 justify-content-center py-2 fw-bold">
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
