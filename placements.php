<?php
$pageTitle = "Training & Corporate Placements | 120+ Top Recruiters | SRKU Bhopal";
$pageDesc = "Explore career placements at Sarvepalli Radhakrishnan University (SRKU), Bhopal with 120+ leading corporate recruitment partners, 12 LPA highest package, and dedicated Corporate Relations Cell.";
$pageKeywords = "SRKU Placements, Placement Record, Highest Package, Top Recruiters Bhopal, Campus Placement Drives MP";
$activeNav = "placements";
require_once __DIR__ . '/includes/header.php';

$highestPackage = getSetting('highest_package', '12 LPA');
$placementRecord = getSetting('placement_record', '94%');
$recruitingPartners = getSetting('recruiting_partners', '120+');
$offersCount = getSetting('offers_count', '1,500+');
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('placements', 'Training & Corporate Placements', 'Corporate Relations Cell • 94.2% Placement Record • 12 LPA Highest Package • 120+ Corporate Recruiters'); ?>

<style>
/* Scoped Styling for Placements Flagship Page */
.placement-stat-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 28px 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(11, 31, 68, 0.05);
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    position: relative;
    overflow: hidden;
}
.placement-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #dc2626, #b91c1c);
    transition: height 0.25s ease;
}
.placement-stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 32px rgba(11, 31, 68, 0.12);
    border-color: #cbd5e1;
}
.placement-stat-card:hover::before {
    height: 6px;
}
.stat-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin-bottom: 16px;
}
.stat-card-num {
    font-size: 2.25rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0b1f44;
    margin-bottom: 6px;
    letter-spacing: -0.5px;
}
.stat-card-label {
    font-size: 0.88rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}

/* Star Student Cards */
.star-student-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    padding: 24px 20px;
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
}
.star-student-card:hover {
    transform: translateY(-5px);
    border-color: #cbd5e1;
    box-shadow: 0 12px 28px rgba(11, 31, 68, 0.1);
}
.student-avatar {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #f1f5f9;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.company-badge-pill {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 700;
    color: #0b1f44;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* Sector Card */
.sector-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 28px 24px;
    height: 100%;
    transition: all 0.3s ease;
}
.sector-card:hover {
    border-color: #dc2626;
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
}
.sector-tag {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    margin: 3px 2px;
    background: #f1f5f9;
    color: #1e293b;
    border: 1px solid #e2e8f0;
}

/* Pillar Card */
.pillar-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 24px;
    height: 100%;
    transition: all 0.25s ease;
}
.pillar-card:hover {
    border-color: #0b1f44;
    background: #f8fafc;
}

/* Step Card */
.step-item-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 30px 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    height: 100%;
    position: relative;
    transition: all 0.3s ease;
}
.step-item-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    border-color: #dc2626;
}
.step-item-num {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #dc2626, #991b1b);
    color: #ffffff;
    font-weight: 800;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 18px;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

/* Accordion Custom */
.placement-accordion .accordion-item {
    border: 1px solid #e2e8f0;
    border-radius: 12px !important;
    margin-bottom: 12px;
    overflow: hidden;
}
.placement-accordion .accordion-button {
    font-weight: 700;
    color: #0b1f44;
    padding: 16px 20px;
    background: #ffffff;
    font-size: 0.98rem;
}
.placement-accordion .accordion-button:not(.collapsed) {
    background-color: #fef2f2;
    color: #dc2626;
    box-shadow: none;
}
.placement-accordion .accordion-button::after {
    filter: grayscale(1);
}
.placement-accordion .accordion-button:not(.collapsed)::after {
    filter: none;
}
.placement-accordion .accordion-body {
    padding: 18px 20px;
    font-size: 0.93rem;
    line-height: 1.7;
    color: #475569;
}
</style>

<!-- 1. KEY METRIC STATISTICS BAR -->
<section class="py-5" style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%); border-bottom: 1px solid #e2e8f0;">
    <div class="container-xl">
        <div class="row g-4 text-center">
            
            <div class="col-6 col-lg-3 reveal">
                <div class="placement-stat-card">
                    <div class="stat-card-icon bg-danger-subtle text-danger mx-auto">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="stat-card-num text-danger">₹12.0 LPA</div>
                    <p class="stat-card-label">Highest Package</p>
                    <small class="text-muted d-block mt-2" style="font-size: 12px;">Amazon Web Services (AWS)</small>
                </div>
            </div>

            <div class="col-6 col-lg-3 reveal">
                <div class="placement-stat-card">
                    <div class="stat-card-icon bg-success-subtle text-success mx-auto">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-card-num text-success">94.2%</div>
                    <p class="stat-card-label">Placement Record</p>
                    <small class="text-muted d-block mt-2" style="font-size: 12px;">Consistent Track Record</small>
                </div>
            </div>

            <div class="col-6 col-lg-3 reveal">
                <div class="placement-stat-card">
                    <div class="stat-card-icon bg-primary-subtle text-primary mx-auto">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-card-num text-navy">120+</div>
                    <p class="stat-card-label">Corporate Recruiters</p>
                    <small class="text-muted d-block mt-2" style="font-size: 12px;">MNCs &amp; Conglomerates</small>
                </div>
            </div>

            <div class="col-6 col-lg-3 reveal">
                <div class="placement-stat-card">
                    <div class="stat-card-icon bg-warning-subtle text-warning mx-auto">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div class="stat-card-num text-navy">1,500+</div>
                    <p class="stat-card-label">Offers Rolled Out</p>
                    <small class="text-muted d-block mt-2" style="font-size: 12px;">Jobs &amp; Paid Internships</small>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 2. CORPORATE RELATIONS DESK & OVERVIEW -->
<section class="py-5">
    <div class="container-xl py-lg-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-6 reveal">
                <span class="section-subtitle"><i class="fas fa-briefcase text-danger me-1"></i> DIRECTORATE OF CORPORATE RELATIONS</span>
                <h2 class="section-title mb-3">Empowering Talent, <span>Connecting Global Opportunities</span></h2>
                <p class="text-dark mb-3" style="line-height:1.8; font-size:0.96rem;">
                    The Training and Placement (T&amp;P) Cell at <strong>Sarvepalli Radhakrishnan University (SRKU)</strong> operates as an agile, full-time career advancement engine. Our mission is to bridge academia and global industry standards, equipping students with rigorous technical, behavioral, and leadership faculties.
                </p>
                <p class="text-muted mb-4" style="line-height:1.8; font-size:0.93rem;">
                    Starting from the pre-final year, every student undergoes intensive modules in Quantitative Aptitude, Full-Stack Coding, Clinical Protocols, Case Studies, Group Discussions, and 1-on-1 Mock Technical Interviews conducted by senior industry architects.
                </p>

                <!-- Key Value Badges -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light border">
                            <i class="fas fa-check-circle text-danger fs-5"></i>
                            <span class="small fw-semibold text-dark">Semester-Long Paid Internships</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light border">
                            <i class="fas fa-check-circle text-danger fs-5"></i>
                            <span class="small fw-semibold text-dark">360° Soft Skills &amp; Coding Drills</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light border">
                            <i class="fas fa-check-circle text-danger fs-5"></i>
                            <span class="small fw-semibold text-dark">One Student, One Dream Offer</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light border">
                            <i class="fas fa-check-circle text-danger fs-5"></i>
                            <span class="small fw-semibold text-dark">On-Campus &amp; Pooled Drives</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/placement-cell.pdf" target="_blank" class="btn btn-srku">
                        <i class="fas fa-file-download me-1"></i> Download Placement Brochure
                    </a>
                    <a href="#recruiter-section" class="btn btn-srku-outline-maroon">
                        <i class="fas fa-handshake me-1"></i> Recruiter Partnership Desk
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-6 reveal">
                <div class="position-relative p-2">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/placement-hero-DCAhDTqD.jpg"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/graduates.webp';"
                         alt="SRKU Placements Convocation" class="img-fluid rounded-4 border border-4 border-danger shadow-lg w-100" style="object-fit:cover; max-height: 480px;">
                    
                    <!-- Floating Highlight Overlay -->
                    <div class="position-absolute bottom-0 start-0 m-4 p-3 bg-white rounded-3 shadow border d-none d-sm-flex align-items-center gap-3" style="max-width: 320px;">
                        <div class="bg-danger text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                            <i class="fas fa-user-graduate fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-navy small">10,000+ Alumni in Top MNCs</div>
                            <div class="text-muted" style="font-size: 11.5px;">Working across USA, UK, UAE &amp; Pan-India</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. TOP RECRUITERS MARQUEE (Continuous Infinite Logo Track) -->
<section class="py-5 bg-light border-top border-bottom">
    <div class="container-xl py-2">
        <div class="text-center mb-4 reveal">
            <span class="section-subtitle">STRATEGIC CORPORATE ALLIANCES</span>
            <h2 class="fw-bold text-navy">Top Multinational Recruitment Partners</h2>
            <p class="text-muted small mb-0" style="max-width: 650px; margin: auto;">Over 120+ leading IT, Engineering, Pharmaceutical, Hospital, and Financial conglomerates actively recruit SRKU graduates each academic year.</p>
        </div>
    </div>
    <?php
    $dbPlacements = getPlacementCompanies(1);
    $placementRecruiterLogos = [];
    foreach ($dbPlacements as $dp) {
        $logoUrl = $dp['logo_url'];
        if (!empty($logoUrl) && strpos($logoUrl, 'http') !== 0) {
            $logoUrl = BASE_URL . ltrim($logoUrl, '/');
        }
        $placementRecruiterLogos[] = [
            'name' => $dp['company_name'],
            'logo' => $logoUrl,
            'package' => $dp['package_offered']
        ];
    }
    // Fallback if db is small
    if (empty($placementRecruiterLogos)) {
        $placementRecruiterLogos = [
            ['name' => 'Amazon AWS', 'logo' => BASE_URL . 'assets/images/recruiters/amazon.webp', 'package' => '12.0 LPA'],
            ['name' => 'Sun Pharma', 'logo' => BASE_URL . 'assets/images/recruiters/sunpharma.svg', 'package' => '8.2 LPA'],
            ['name' => 'Cipla', 'logo' => BASE_URL . 'assets/images/recruiters/cipla.svg', 'package' => '8.0 LPA'],
            ['name' => 'TCS', 'logo' => BASE_URL . 'assets/images/recruiters/tcs.svg', 'package' => '7.5 LPA'],
            ['name' => 'Cognizant', 'logo' => BASE_URL . 'assets/images/recruiters/cognizant.webp', 'package' => '7.2 LPA'],
            ['name' => 'HCL Technologies', 'logo' => BASE_URL . 'assets/images/recruiters/hcl.svg', 'package' => '7.0 LPA'],
            ['name' => 'Infosys', 'logo' => BASE_URL . 'assets/images/recruiters/infosys.webp', 'package' => '6.8 LPA'],
            ['name' => 'Wipro', 'logo' => BASE_URL . 'assets/images/recruiters/wipro.webp', 'package' => '6.5 LPA']
        ];
    }
    $repeatCount = max(2, (int)ceil(16 / max(1, count($placementRecruiterLogos))));
    ?>
    <div class="recruiter-marquee" style="margin-top:0;">
        <div class="recruiter-marquee__viewport">
            <div class="recruiter-marquee__track">
                <?php for ($r = 0; $r < $repeatCount; $r++): ?>
                    <?php foreach ($placementRecruiterLogos as $logo): ?>
                        <div class="recruiter-marquee__item">
                            <?php if (!empty($logo['logo'])): ?>
                                <img src="<?php echo htmlspecialchars($logo['logo']); ?>"
                                     alt="<?php echo sanitize($logo['name']); ?>" loading="eager" decoding="async" style="max-height: 48px; width: auto; object-fit: contain;"
                                     onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='inline-block';">
                                <span class="fw-bold text-navy px-3 py-1 bg-white rounded border shadow-sm" style="display:none;"><?php echo sanitize($logo['name']); ?></span>
                            <?php else: ?>
                                <span class="fw-bold text-navy px-3 py-1 bg-white rounded border shadow-sm"><?php echo sanitize($logo['name']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<!-- 4. SECTOR-WISE RECRUITING CONGLOMERATES -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5 reveal">
            <span class="section-subtitle">DIVERSE HIRING DOMAINS</span>
            <h2 class="fw-bold text-navy">Recruitment Across High-Growth Sectors</h2>
            <p class="text-muted small" style="max-width: 650px; margin: auto;">SRKU's multi-disciplinary academic ecosystem powers campus placement drives across core engineering, health sciences, management, and technology.</p>
        </div>

        <div class="row g-4">
            <!-- Sector 1: IT & Cloud -->
            <div class="col-12 col-md-6 col-lg-3 reveal">
                <div class="sector-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                            <i class="fas fa-laptop-code fs-4"></i>
                        </div>
                        <h3 class="h6 fw-bold text-navy mb-0">IT, Software &amp; Cloud Computing</h3>
                    </div>
                    <p class="text-muted small mb-3">Software engineering, full-stack development, cloud architecture, and cybersecurity roles.</p>
                    <div>
                        <span class="sector-tag">Amazon AWS</span>
                        <span class="sector-tag">TCS</span>
                        <span class="sector-tag">Infosys</span>
                        <span class="sector-tag">Wipro</span>
                        <span class="sector-tag">Cognizant</span>
                        <span class="sector-tag">HCL</span>
                        <span class="sector-tag">Capgemini</span>
                    </div>
                </div>
            </div>

            <!-- Sector 2: Pharma & Healthcare -->
            <div class="col-12 col-md-6 col-lg-3 reveal">
                <div class="sector-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-danger-subtle text-danger p-3 rounded-circle">
                            <i class="fas fa-pills fs-4"></i>
                        </div>
                        <h3 class="h6 fw-bold text-navy mb-0">Pharmaceutical &amp; Healthcare</h3>
                    </div>
                    <p class="text-muted small mb-3">Drug formulation, clinical research, hospital care, QA/QC testing, and regulatory affairs.</p>
                    <div>
                        <span class="sector-tag">Sun Pharma</span>
                        <span class="sector-tag">Cipla</span>
                        <span class="sector-tag">Lupin</span>
                        <span class="sector-tag">Dr. Reddy's</span>
                        <span class="sector-tag">Apollo Hospitals</span>
                        <span class="sector-tag">Medanta</span>
                    </div>
                </div>
            </div>

            <!-- Sector 3: Core Engineering -->
            <div class="col-12 col-md-6 col-lg-3 reveal">
                <div class="sector-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-warning-subtle text-warning p-3 rounded-circle">
                            <i class="fas fa-cogs fs-4"></i>
                        </div>
                        <h3 class="h6 fw-bold text-navy mb-0">Core Engg &amp; Manufacturing</h3>
                    </div>
                    <p class="text-muted small mb-3">Civil construction, mechanical robotics, electrical grids, electronics, and smart mobility.</p>
                    <div>
                        <span class="sector-tag">L&amp;T</span>
                        <span class="sector-tag">Tata Motors</span>
                        <span class="sector-tag">BHEL</span>
                        <span class="sector-tag">Crompton</span>
                        <span class="sector-tag">Ashok Leyland</span>
                        <span class="sector-tag">Jindal Steel</span>
                    </div>
                </div>
            </div>

            <!-- Sector 4: Management & BFSI -->
            <div class="col-12 col-md-6 col-lg-3 reveal">
                <div class="sector-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-success-subtle text-success p-3 rounded-circle">
                            <i class="fas fa-chart-pie fs-4"></i>
                        </div>
                        <h3 class="h6 fw-bold text-navy mb-0">Banking, Finance &amp; Retail</h3>
                    </div>
                    <p class="text-muted small mb-3">Corporate banking, market analytics, supply chain management, logistics, and fintech.</p>
                    <div>
                        <span class="sector-tag">HDFC Bank</span>
                        <span class="sector-tag">ICICI Bank</span>
                        <span class="sector-tag">Axis Bank</span>
                        <span class="sector-tag">Aditya Birla</span>
                        <span class="sector-tag">Reliance</span>
                        <span class="sector-tag">Bajaj Finserv</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. HALL OF FAME / STAR PLACED STUDENTS SPOTLIGHT -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 reveal">
            <div>
                <span class="section-subtitle"><i class="fas fa-award text-warning me-1"></i> HALL OF FAME</span>
                <h2 class="fw-bold text-navy mb-1">Star Placements Spotlight</h2>
                <p class="text-muted small mb-0">Celebrating stellar achievements of our students placed in leading national and global organizations.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <span class="badge bg-danger text-white px-3 py-2 fw-bold">Recent Placement Batch</span>
            </div>
        </div>

        <div class="row g-4">
            <!-- Student 1 -->
            <div class="col-12 col-sm-6 col-lg-4 reveal">
                <div class="star-student-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="company-badge-pill">
                            <i class="fab fa-amazon text-warning"></i> Amazon AWS
                        </div>
                        <span class="badge bg-danger text-white fw-bold">₹12.0 LPA</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 52px; height: 52px; font-size: 1.1rem;">
                            AS
                        </div>
                        <div>
                            <h4 class="h6 fw-bold text-navy mb-0">Aman Sharma</h4>
                            <small class="text-muted">B.Tech - Computer Science &amp; Engg</small>
                        </div>
                    </div>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Placed as <strong>Cloud Support Associate</strong> at Amazon Web Services after rigorous training in AWS Cloud Practitioner and Full-Stack development.
                    </p>
                </div>
            </div>

            <!-- Student 2 -->
            <div class="col-12 col-sm-6 col-lg-4 reveal">
                <div class="star-student-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="company-badge-pill">
                            <i class="fas fa-pills text-danger"></i> Sun Pharma
                        </div>
                        <span class="badge bg-danger text-white fw-bold">₹8.2 LPA</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 52px; height: 52px; font-size: 1.1rem;">
                            PP
                        </div>
                        <div>
                            <h4 class="h6 fw-bold text-navy mb-0">Priya Patel</h4>
                            <small class="text-muted">Bachelor of Pharmacy (B.Pharm)</small>
                        </div>
                    </div>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Selected as <strong>Quality Control Officer (Formulations)</strong> at Sun Pharmaceutical Industries through pool campus drive.
                    </p>
                </div>
            </div>

            <!-- Student 3 -->
            <div class="col-12 col-sm-6 col-lg-4 reveal">
                <div class="star-student-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="company-badge-pill">
                            <i class="fas fa-university text-primary"></i> HDFC Bank
                        </div>
                        <span class="badge bg-danger text-white fw-bold">₹7.5 LPA</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 52px; height: 52px; font-size: 1.1rem;">
                            RV
                        </div>
                        <div>
                            <h4 class="h6 fw-bold text-navy mb-0">Rohit Verma</h4>
                            <small class="text-muted">Master of Business Admin (MBA)</small>
                        </div>
                    </div>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Joined HDFC Bank as <strong>Assistant Manager (Corporate Portfolio)</strong> following pre-placement corporate talks and case study presentations.
                    </p>
                </div>
            </div>

            <!-- Student 4 -->
            <div class="col-12 col-sm-6 col-lg-4 reveal">
                <div class="star-student-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="company-badge-pill">
                            <i class="fas fa-microchip text-primary"></i> TCS
                        </div>
                        <span class="badge bg-danger text-white fw-bold">₹7.5 LPA</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 52px; height: 52px; font-size: 1.1rem;">
                            SM
                        </div>
                        <div>
                            <h4 class="h6 fw-bold text-navy mb-0">Sneha Mishra</h4>
                            <small class="text-muted">M.Tech - Artificial Intelligence</small>
                        </div>
                    </div>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Placed with Tata Consultancy Services (TCS Digital) as <strong>Systems Engineer</strong> focusing on ML model deployment and data analytics.
                    </p>
                </div>
            </div>

            <!-- Student 5 -->
            <div class="col-12 col-sm-6 col-lg-4 reveal">
                <div class="star-student-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="company-badge-pill">
                            <i class="fas fa-hard-hat text-warning"></i> L&amp;T
                        </div>
                        <span class="badge bg-danger text-white fw-bold">₹7.0 LPA</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 52px; height: 52px; font-size: 1.1rem;">
                            RT
                        </div>
                        <div>
                            <h4 class="h6 fw-bold text-navy mb-0">Rahul Tiwari</h4>
                            <small class="text-muted">B.Tech - Mechanical Engineering</small>
                        </div>
                    </div>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Selected as <strong>Graduate Engineer Trainee (GET)</strong> by Larsen &amp; Toubro Heavy Engineering after domain technical evaluation.
                    </p>
                </div>
            </div>

            <!-- Student 6 -->
            <div class="col-12 col-sm-6 col-lg-4 reveal">
                <div class="star-student-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="company-badge-pill">
                            <i class="fas fa-hospital text-danger"></i> Apollo Hospitals
                        </div>
                        <span class="badge bg-danger text-white fw-bold">₹6.5 LPA</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 52px; height: 52px; font-size: 1.1rem;">
                            NG
                        </div>
                        <div>
                            <h4 class="h6 fw-bold text-navy mb-0">Neha Gupta</h4>
                            <small class="text-muted">B.Sc - Nursing Science</small>
                        </div>
                    </div>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Joined Apollo Hospitals as <strong>Critical Care Specialist</strong> following clinical rotations at RKDF Medical Hospital.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. 4-STAGE PLACEMENT ECOSYSTEM -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5 reveal">
            <span class="section-subtitle"><i class="fas fa-route text-danger me-1"></i> STEP-BY-STEP PATHWAY</span>
            <h2 class="fw-bold text-navy">Our 4-Stage Placement Ecosystem</h2>
            <p class="text-muted small" style="max-width: 650px; margin: auto;">From classroom fundamentals to premier corporate cubicles, our structured lifecycle ensures every student is corporate-ready.</p>
        </div>

        <div class="row g-4 text-center">
            <!-- Stage 1 -->
            <div class="col-12 col-sm-6 col-lg-3 reveal">
                <div class="step-item-card">
                    <div class="step-item-num">1</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Skill Enhancement</h4>
                    <p class="text-muted small mb-0">
                        Intensive modules in Quantitative Aptitude, logical reasoning, data structures, full-stack programming, and professional business communication.
                    </p>
                </div>
            </div>

            <!-- Stage 2 -->
            <div class="col-12 col-sm-6 col-lg-3 reveal">
                <div class="step-item-card">
                    <div class="step-item-num">2</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Pre-Placement Talks</h4>
                    <p class="text-muted small mb-0">
                        Corporate HR leaders and technical leads interact directly with students to present organizational culture, compensation bands, and job descriptions.
                    </p>
                </div>
            </div>

            <!-- Stage 3 -->
            <div class="col-12 col-sm-6 col-lg-3 reveal">
                <div class="step-item-card">
                    <div class="step-item-num">3</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Written &amp; Tech Tests</h4>
                    <p class="text-muted small mb-0">
                        Proctored online coding tests, domain assessments, case studies, and Group Discussion (GD) rounds tailored to hiring benchmarks.
                    </p>
                </div>
            </div>

            <!-- Stage 4 -->
            <div class="col-12 col-sm-6 col-lg-3 reveal">
                <div class="step-item-card">
                    <div class="step-item-num">4</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Final Offer Rollout</h4>
                    <p class="text-muted small mb-0">
                        1-on-1 technical and HR interviews, instant selection letters, pre-joining orientation, and seamless background verification support.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 7. 4-PILLAR CAREER READINESS CURRICULUM -->
<section class="py-5 bg-light border-top border-bottom">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5 mb-5">
            <div class="col-12 col-lg-6 reveal">
                <span class="section-subtitle">COMPREHENSIVE TRAINING MODULES</span>
                <h2 class="fw-bold text-navy mb-3">Structured Career Readiness Curriculum</h2>
                <p class="text-muted" style="line-height: 1.8;">
                    At SRKU, employability training is integrated into regular academic timetables rather than being an afterthought. Our Training &amp; Placement Cell collaborates with industry training partners and top certification platforms to impart industry-grade competency.
                </p>
            </div>
            <div class="col-12 col-lg-6 reveal">
                <div class="p-4 bg-white rounded-4 border shadow-sm">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-certificate text-danger fs-3"></i>
                        <h4 class="h5 fw-bold text-navy mb-0">Certified Corporate Pedagogy</h4>
                    </div>
                    <p class="small text-muted mb-0">
                        Over 250+ hours of dedicated aptitude and technical bootcamp sessions before on-campus drives commence each academic year.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-3 reveal">
                <div class="pillar-card">
                    <div class="text-danger mb-3"><i class="fas fa-brain fa-2x"></i></div>
                    <h4 class="h6 fw-bold text-navy mb-2">Quantitative &amp; Aptitude</h4>
                    <p class="text-muted small mb-0">Speed mathematics, data interpretation, deductive logic, numerical puzzles, and spatial reasoning drills.</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3 reveal">
                <div class="pillar-card">
                    <div class="text-danger mb-3"><i class="fas fa-code fa-2x"></i></div>
                    <h4 class="h6 fw-bold text-navy mb-2">Technical Mastery</h4>
                    <p class="text-muted small mb-0">Data Structures &amp; Algorithms, Python, Java, Cloud Computing, Full-Stack, Pharma QA/QC, and AutoCAD.</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3 reveal">
                <div class="text-danger mb-3"><i class="fas fa-comments fa-2x"></i></div>
                <h4 class="h6 fw-bold text-navy mb-2">Soft Skills &amp; Grooming</h4>
                <p class="text-muted small mb-0">Executive communication, email etiquette, presentation skills, LinkedIn personal branding, and body language.</p>
            </div>

            <div class="col-12 col-md-6 col-lg-3 reveal">
                <div class="pillar-card">
                    <div class="text-danger mb-3"><i class="fas fa-users-cog fa-2x"></i></div>
                    <h4 class="h6 fw-bold text-navy mb-2">Mock Interview Panels</h4>
                    <p class="text-muted small mb-0">Simulated corporate technical rounds, group discussion bootcamps, and resume roasting by senior alumni.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. FREQUENTLY ASKED QUESTIONS (FAQ ACCORDION) -->
<section class="py-5">
    <div class="container-xl py-3" style="max-width: 920px;">
        <div class="text-center mb-5 reveal">
            <span class="section-subtitle"><i class="fas fa-question-circle text-danger me-1"></i> HAVE QUESTIONS?</span>
            <h2 class="fw-bold text-navy">Placement FAQs</h2>
            <p class="text-muted small">Common questions regarding campus recruitment drives, student eligibility, and internship policies.</p>
        </div>

        <div class="accordion placement-accordion reveal" id="placementFaqAccordion">
            
            <!-- FAQ 1 -->
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                        When do campus placement drives begin for students at SRKU?
                    </button>
                </h3>
                <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#placementFaqAccordion">
                    <div class="accordion-body">
                        Campus recruitment drives typically commence at the beginning of the 7th semester for 4-year undergraduate degree courses (B.Tech, B.Pharm) and in the final year for postgraduate programmes (MBA, MCA, M.Tech). Pre-placement training workshops start well ahead in the 5th semester.
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                        What is SRKU's highest package and overall placement track record?
                    </button>
                </h3>
                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#placementFaqAccordion">
                    <div class="accordion-body">
                        The highest international/national package offered stands at <strong>₹12.0 LPA</strong> by Amazon Web Services (AWS), with an overall placement rate exceeding <strong>94.2%</strong> across engineering, pharmaceutical, management, and paramedical disciplines.
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                        Does SRKU facilitate industrial summer internships before final placement?
                    </button>
                </h3>
                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#placementFaqAccordion">
                    <div class="accordion-body">
                        Yes, industrial internships are an integral part of the curriculum. The T&amp;P cell assists students in securing paid and credit-based summer internships at leading companies like BHEL, Sun Pharma, Cipla, TCS, L&amp;T, and local government undertakings.
                    </div>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                        Are pharmacy, nursing, and healthcare students placed on campus?
                    </button>
                </h3>
                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#placementFaqAccordion">
                    <div class="accordion-body">
                        Absolutely. SRKU houses 6 dedicated Pharmacy colleges, RKDF Medical College Hospital, and Nursing institutes. Multinational pharma manufacturers (Sun Pharma, Cipla, Lupin, Dr. Reddy's) and multi-specialty hospitals (Apollo, Medanta, Bansal Hospital) conduct regular dedicated recruitment drives.
                    </div>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                        What is the university's "One Student, One Dream Offer" policy?
                    </button>
                </h3>
                <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#placementFaqAccordion">
                    <div class="accordion-body">
                        To maximize career opportunities for all peers, once a candidate receives a core placement offer, they are permitted to appear only for designated "Dream Category" recruitment drives offering compensation substantially higher than their current offer.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 9. RECRUITER INVITATION & T&P CONTACT DESK -->
<section id="recruiter-section" class="py-5 text-white position-relative" style="background: linear-gradient(135deg, #0b1f44 0%, #1e3a8a 100%);">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4">
            
            <div class="col-12 col-lg-7">
                <span class="badge bg-danger text-white px-3 py-2 fw-bold mb-3"><i class="fas fa-handshake me-1"></i> CORPORATE HR PARTNERSHIP</span>
                <h2 class="h2 fw-bold text-white mb-3">Invite SRKU For Campus Recruitment</h2>
                <p class="text-white-50 mb-4" style="line-height: 1.8;">
                    Corporate HR heads, Talent Acquisition Executives, and Technical Recruiters are warmly invited to partner with Sarvepalli Radhakrishnan University for on-campus, pooled, and virtual recruitment drives. Our campus infrastructure includes state-of-the-art computer labs with 500+ high-speed terminals, auditoriums, and interview boardrooms.
                </p>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="mailto:<?php echo sanitize(getSetting('email', 'exam@srku.edu.in')); ?>?subject=Campus%20Recruitment%20Invitation%20-%20SRKU%20Bhopal" class="btn btn-warning fw-bold text-dark px-4 py-2">
                        <i class="fas fa-envelope me-1"></i> Send Hiring Invitation
                    </a>
                    <a href="tel:07554911204" class="btn btn-outline-light px-4 py-2 fw-semibold">
                        <i class="fas fa-phone-alt me-1"></i> Call T&amp;P Desk (0755 - 4911204)
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="p-4 rounded-4 bg-white text-dark shadow-lg">
                    <h4 class="h5 fw-bold text-navy mb-3"><i class="fas fa-id-card text-danger me-2"></i> Training &amp; Placement Secretariat</h4>
                    
                    <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                        <div class="bg-light p-2 rounded-3 text-danger"><i class="fas fa-map-marker-alt fs-5"></i></div>
                        <div>
                            <div class="fw-bold text-navy small">Campus Address</div>
                            <small class="text-muted">T&amp;P Cell, Admin Block, NH-12, Hoshangabad Road, Misrod, Bhopal (MP) - 462026</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                        <div class="bg-light p-2 rounded-3 text-danger"><i class="fas fa-envelope-open-text fs-5"></i></div>
                        <div>
                            <div class="fw-bold text-navy small">Official Placement Email</div>
                            <small class="text-muted"><a href="mailto:exam@srku.edu.in" class="text-danger fw-semibold text-decoration-none">exam@srku.edu.in</a> / <a href="mailto:info@srku.edu.in" class="text-danger fw-semibold text-decoration-none">info@srku.edu.in</a></small>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-light p-2 rounded-3 text-danger"><i class="fas fa-clock fs-5"></i></div>
                        <div>
                            <div class="fw-bold text-navy small">Operating Hours</div>
                            <small class="text-muted">Monday - Saturday: 09:30 AM to 05:30 PM IST</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="<?php echo BASE_URL; ?>assets/js/reveal.js" defer></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
