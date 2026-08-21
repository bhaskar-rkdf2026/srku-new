<?php
$pageTitle = "About Us - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('about', 'About Sarvepalli Radhakrishnan University', 'Excellence in Higher Education, Research Innovation & Value-Based Leadership'); ?>

<!-- Overview Section -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            
            <div class="col-12 col-lg-6">
                <span class="section-subtitle">UNIVERSITY OVERVIEW</span>
                <h2 class="text-maroon fw-bold mb-3">Pioneering World-Class Higher Education in Central India</h2>
                <p class="text-dark mb-3" style="line-height:1.8;">
                    Sarvepalli Radhakrishnan University (SRKU) Bhopal was established under the Madhya Pradesh Niji Vishwavidyalaya (Sthapana Avam Sanchalan) Adhiniyam, with the vision of offering high-quality technical, medical, pharmaceutical, managerial, agricultural, and legal education to students across India and abroad.
                </p>
                <p class="text-muted mb-4" style="line-height:1.8;">
                    Recognized under Section 2(f) of the UGC Act 1956, SRKU features sprawling green campus infrastructure, 42+ state-of-the-art laboratories, digital classrooms, super-specialty teaching hospital, comprehensive digital library resources, and extensive sports facilities.
                </p>
                <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                    <li class="fw-semibold"><i class="fas fa-check-circle text-danger me-2"></i> Statutory Recognition by UGC, AICTE, PCI, INC, BCI &amp; NMC</li>
                    <li class="fw-semibold"><i class="fas fa-check-circle text-danger me-2"></i> 42+ High-Tech Research &amp; Computing Laboratories</li>
                    <li class="fw-semibold"><i class="fas fa-check-circle text-danger me-2"></i> 94% Placement Assistance with 120+ Corporate Recruiters</li>
                    <li class="fw-semibold"><i class="fas fa-check-circle text-danger me-2"></i> 750+ Bed On-Campus Teaching Hospital</li>
                </ul>
            </div>

            <div class="col-12 col-lg-6">
                <div class="bg-light rounded-4 p-4 p-md-5 border shadow-sm">
                    <h3 class="text-navy fw-bold mb-4"><i class="fas fa-sitemap text-danger me-2"></i> Quick Explore</h3>
                    <div class="d-flex flex-column gap-3">
                        <a href="<?php echo BASE_URL; ?>page.php?slug=why-srk" class="card text-decoration-none p-3 border-0 shadow-sm rounded-3">
                            <strong class="text-maroon fs-6"><i class="fas fa-star me-2 text-warning"></i> Why SRK University?</strong>
                            <span class="small text-muted">Discover key USPs, rankings, and infrastructure that set us apart.</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>page.php?slug=vision-mission" class="card text-decoration-none p-3 border-0 shadow-sm rounded-3">
                            <strong class="text-maroon fs-6"><i class="fas fa-bullseye me-2 text-danger"></i> Vision &amp; Mission Statement</strong>
                            <span class="small text-muted">Our institutional charter, core values, and long-term academic roadmap.</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>page.php?slug=board-of-management" class="card text-decoration-none p-3 border-0 shadow-sm rounded-3">
                            <strong class="text-maroon fs-6"><i class="fas fa-user-tie me-2 text-primary"></i> Board of Management</strong>
                            <span class="small text-muted">Leadership messages from Chancellor, Vice-Chancellor, and Deans.</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>departments.php" class="card text-decoration-none p-3 border-0 shadow-sm rounded-3">
                            <strong class="text-maroon fs-6"><i class="fas fa-university me-2 text-success"></i> Constituent Colleges &amp; Faculties</strong>
                            <span class="small text-muted">Explore 14 faculties across Engineering, Pharmacy, Medicine &amp; Management.</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ACCREDITATION SECTION -->
<section class="py-5 bg-light" id="accreditation">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">CREDIBILITY &amp; BENCHMARKS</span>
            <h2 class="fw-bold text-navy">Accreditation &amp; Statutory Approvals</h2>
            <p class="text-muted">Committed to maintaining the highest national and international education benchmarks</p>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4">
                    <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px; font-size:1.8rem;">
                        <i class="fas fa-university"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">UGC Recognized</h3>
                    <p class="text-muted small mb-0">Established by MP State Legislature Act &amp; Recognized by the University Grants Commission (UGC) under Section 2(f).</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4">
                    <div class="bg-warning-subtle text-warning rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px; font-size:1.8rem;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">AICTE Approved</h3>
                    <p class="text-muted small mb-0">All engineering, technology, management, and MCA programmes are strictly approved by AICTE New Delhi.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4">
                    <div class="bg-success-subtle text-success rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px; font-size:1.8rem;">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">PCI, INC, BCI &amp; NMC</h3>
                    <p class="text-muted small mb-0">Pharmacy Council of India (PCI), Indian Nursing Council (INC), Bar Council of India (BCI) &amp; NMC approved.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LEADERSHIP SECTION -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">GOVERNANCE &amp; MENTORSHIP</span>
            <h2 class="fw-bold text-navy">University Leadership</h2>
            <p class="text-muted">Guiding SRKU towards academic and research supremacy</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="d-flex gap-3 align-items-center mb-3">
                        <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/ruchichaubey.webp"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                             class="rounded-circle border border-3 border-danger" style="width:80px; height:80px; object-fit:cover;" alt="Chancellor">
                        <div>
                            <h4 class="h5 fw-bold text-navy mb-1">Hon'ble Chancellor</h4>
                            <span class="badge bg-danger-subtle text-danger">Sarvepalli Radhakrishnan University</span>
                        </div>
                    </div>
                    <p class="text-muted small mb-0" style="line-height:1.7;">
                        "Education is the cornerstone of societal progress. At SRKU, our endeavor is to nurture young intellects with critical inquiry, scientific temperament, and ethical responsibility to serve humanity with distinction."
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="d-flex gap-3 align-items-center mb-3">
                        <div class="bg-navy text-gold rounded-circle d-flex align-items-center justify-content-center" style="width:80px; height:80px; font-size:2rem;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h4 class="h5 fw-bold text-navy mb-1">Vice-Chancellor Desk</h4>
                            <span class="badge bg-primary-subtle text-primary">Office of the Vice-Chancellor</span>
                        </div>
                    </div>
                    <p class="text-muted small mb-0" style="line-height:1.7;">
                        "SRKU stands as a testament to transformative education. Through interdisciplinary curriculum, cutting-edge labs, and industry tie-ups, we prepare our scholars to thrive in the dynamic global economy."
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
