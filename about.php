<?php
$pageTitle = "About Us - SRK University";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <h1 class="fw-bold display-5 mb-2">About SRK University</h1>
        <p class="text-warning fw-semibold lead mb-0">Excellence in Higher Education, Innovation &amp; Character Building</p>
    </div>
</div>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            
            <div class="col-12 col-lg-6">
                <h2 class="text-maroon fw-bold mb-3">Welcome to Sarvepalli Radhakrishnan University</h2>
                <p class="text-dark mb-3" style="line-height:1.8;">
                    Sarvepalli Radhakrishnan University (SRKU) Bhopal was established with the vision of offering high-quality technical, medical, pharmaceutical, and managerial education to students from across India and abroad.
                </p>
                <p class="text-muted mb-4" style="line-height:1.8;">
                    Recognized under Section 2(f) of the UGC Act 1956, SRKU boasts lush green sprawling campus infrastructure, state-of-the-art laboratories, digital classrooms, comprehensive library resources, and dedicated sports facilities.
                </p>
                <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                    <li class="fw-semibold"><i class="fas fa-check-circle text-warning me-2"></i> Recognized by UGC, AICTE, PCI, INC &amp; Statutory Bodies</li>
                    <li class="fw-semibold"><i class="fas fa-check-circle text-warning me-2"></i> 42+ High Tech Laboratories &amp; Research Units</li>
                    <li class="fw-semibold"><i class="fas fa-check-circle text-warning me-2"></i> 94% Placement Assistance with Top MNC Companies</li>
                </ul>
            </div>

            <div class="col-12 col-lg-6">
                <div class="bg-light rounded-4 p-4 p-md-5 border">
                    <h3 class="text-navy fw-bold mb-4">University Governance &amp; Statues</h3>
                    <div class="d-flex flex-column gap-3">
                        <a href="page.php?slug=why-srk" class="card text-decoration-none p-3 border-0 shadow-sm rounded-3">
                            <strong class="text-maroon fs-6">Why SRK University?</strong>
                            <span class="small text-muted">Discover what makes us the top academic hub in Central India.</span>
                        </a>
                        <a href="page.php?slug=vision-mission" class="card text-decoration-none p-3 border-0 shadow-sm rounded-3">
                            <strong class="text-maroon fs-6">Vision &amp; Mission Statement</strong>
                            <span class="small text-muted">Our long-term academic roadmap and institutional values.</span>
                        </a>
                        <a href="courses.php" class="card text-decoration-none p-3 border-0 shadow-sm rounded-3">
                            <strong class="text-maroon fs-6">Constituent Colleges &amp; Departments</strong>
                            <span class="small text-muted">Engineering, Pharmacy, Nursing, Management &amp; Science institutes.</span>
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
            <h2 class="fw-bold text-navy">Accreditation &amp; Approvals</h2>
            <p class="text-muted">Committed to maintaining the highest national education standards</p>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4">
                    <i class="fas fa-university fa-3x text-maroon mb-3"></i>
                    <h3 class="h5 fw-bold text-navy mb-2">UGC Recognition</h3>
                    <p class="text-muted small mb-0">Established by MP State Legislature Act &amp; Recognized by University Grants Commission (UGC) under Section 2(f).</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4">
                    <i class="fas fa-award fa-3x text-warning mb-3"></i>
                    <h3 class="h5 fw-bold text-navy mb-2">NIRF 2026 Participation</h3>
                    <p class="text-muted small mb-0">Regular participant in National Institutional Ranking Framework (NIRF) reporting quality benchmarks.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4">
                    <i class="fas fa-certificate fa-3x text-maroon mb-3"></i>
                    <h3 class="h5 fw-bold text-navy mb-2">AICTE &amp; PCI Approved</h3>
                    <p class="text-muted small mb-0">All technical engineering and pharmaceutical programs strictly follow AICTE &amp; PCI guidelines.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
