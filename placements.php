<?php
$pageTitle = "Training & Placements - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "placements";
require_once __DIR__ . '/includes/header.php';

$highestPackage = getSetting('highest_package', '12 LPA');
$placementRecord = getSetting('placement_record', '94%');
$recruitingPartners = getSetting('recruiting_partners', '120+');
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('placements', 'Training & Corporate Placements', '94% Placement Record &bull; 12 LPA Highest Package &bull; 120+ Corporate Recruiters'); ?>

<!-- Stats Strip -->
<div class="stats-strip py-3">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-4 g-0 text-center">
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($placementRecord); ?></div>
                <div class="stat-txt">Overall Placement Rate</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($highestPackage); ?></div>
                <div class="stat-txt">Highest Salary Package</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">4.5 LPA</div>
                <div class="stat-txt">Average Package</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($recruitingPartners); ?></div>
                <div class="stat-txt">Corporate Hiring Partners</div>
            </div>
        </div>
    </div>
</div>

<!-- Overview Section -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-6">
                <span class="section-subtitle">CORPORATE RELATIONS DESK</span>
                <h2 class="section-title mb-3">Connecting Talent with <span>Global Opportunities</span></h2>
                <p class="text-dark mb-3" style="line-height:1.8; font-size:0.95rem;">
                    The Training and Placement Cell at Sarvepalli Radhakrishnan University operates as a vital bridge between budding scholars and the corporate realm. Our rigorous 360-degree training framework prepares students for the competitive hiring standards of leading multinationals.
                </p>
                <p class="text-muted mb-4" style="line-height:1.8; font-size:0.93rem;">
                    From the second year onwards, students undergo continuous modules in Quantitative Aptitude, Logical Reasoning, Soft Skills, Technical Coding, Group Discussion, and Mock Technical Interviews conducted by senior industry leaders.
                </p>
                <div class="d-flex gap-3">
                    <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku"><i class="fas fa-user-graduate me-1"></i> Register for Placements</a>
                    <a href="<?php echo BASE_URL; ?>courses.php" class="btn btn-outline-danger"><i class="fas fa-search me-1"></i> Explore Programmes</a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/placement-hero-DCAhDTqD.jpg"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/graduates.webp';"
                     alt="SRKU Placements" class="img-fluid rounded-4 border border-4 border-danger shadow">
            </div>
        </div>
    </div>
</section>

<!-- Top Recruiters Grid -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">OUR RECRUITMENT PARTNERS</span>
            <h2 class="fw-bold text-navy">Top Corporate Recruiters</h2>
            <p class="text-muted">Over 120+ leading IT, Engineering, Pharmaceutical, Hospital, and Financial conglomerates hire from SRKU.</p>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 text-center">
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-building text-danger me-2"></i> TCS</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-building text-danger me-2"></i> Infosys</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-building text-danger me-2"></i> Wipro</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-building text-danger me-2"></i> Amazon</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-pills text-danger me-2"></i> Cipla</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-pills text-danger me-2"></i> Sun Pharma</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-cogs text-danger me-2"></i> L&amp;T</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-laptop text-danger me-2"></i> HCL Tech</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-university text-danger me-2"></i> HDFC Bank</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-hospital text-danger me-2"></i> Apollo</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-car text-danger me-2"></i> Mahindra</div></div>
            <div class="col"><div class="card p-3 border-0 shadow-sm rounded-3 h-100 d-flex align-items-center justify-content-center fw-bold text-navy"><i class="fas fa-flask text-danger me-2"></i> Lupin Ltd</div></div>
        </div>
    </div>
</section>

<!-- Placement Process 4 Steps -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">HOW IT WORKS</span>
            <h2 class="fw-bold text-navy">Our 4-Stage Placement Ecosystem</h2>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4 text-center">
            <div class="col">
                <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="bg-danger text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:55px; height:55px; font-size:1.4rem;">1</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Skill Enhancement</h4>
                    <p class="text-muted small mb-0">Aptitude, domain coding, technical drills, and corporate etiquette training.</p>
                </div>
            </div>
            <div class="col">
                <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="bg-danger text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:55px; height:55px; font-size:1.4rem;">2</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Pre-Placement Talks</h4>
                    <p class="text-muted small mb-0">Direct interaction between students and HR executives to understand job profiles.</p>
                </div>
            </div>
            <div class="col">
                <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="bg-danger text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:55px; height:55px; font-size:1.4rem;">3</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Written &amp; Tech Tests</h4>
                    <p class="text-muted small mb-0">Online proctored coding assessments, clinical tests, and GD rounds.</p>
                </div>
            </div>
            <div class="col">
                <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="bg-danger text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:55px; height:55px; font-size:1.4rem;">4</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Offer Letters</h4>
                    <p class="text-muted small mb-0">Final selection, offer rollout, and pre-joining onboarding support.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recruiter Invitation Card -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-dark));">
    <div class="container-xl py-2">
        <h2 class="fw-bold mb-2">Invite SRKU For Campus Recruitment</h2>
        <p class="text-white-50 mb-4">Corporate HRs and Talent Acquisition Managers are invited to partner with SRKU for pool drives and internship hiring.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="mailto:<?php echo sanitize(getSetting('email')); ?>" class="btn btn-srku-gold px-4 py-2"><i class="fas fa-envelope me-1"></i> Email T&amp;P Cell</a>
            <a href="tel:<?php echo preg_replace('/[^0-9]/', '', getSetting('helpline')); ?>" class="btn btn-srku-outline px-4 py-2"><i class="fas fa-phone-alt me-1"></i> Contact Placement Officer</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
