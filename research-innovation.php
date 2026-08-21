<?php
$pageTitle = "Research & Innovation - Sarvepalli Radhakrishnan University Bhopal";
$activeNav = "research";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('research-innovation', 'Research & Innovation Cell', 'Fostering Groundbreaking Discoveries, Patents & Interdisciplinary Science'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5 mb-5">
            <div class="col-12 col-lg-6">
                <span class="section-subtitle">DISCOVERY &amp; EXCELLENCE</span>
                <h2 class="section-title mb-3">Pioneering Solutions for <span>Global Challenges</span></h2>
                <p class="text-dark mb-3" style="line-height:1.8; font-size:0.95rem;">
                    Research at Sarvepalli Radhakrishnan University is driven by a deep commitment to addressing pressing societal, medical, environmental, and technological challenges through cutting-edge inquiry and translational research.
                </p>
                <p class="text-muted mb-4" style="line-height:1.8; font-size:0.93rem;">
                    Our faculty and doctoral scholars actively publish in prestigious high-impact peer-reviewed journals indexed in Scopus, Web of Science, and PubMed, securing national and international patents across nanomedicine, artificial intelligence, renewable energy, and agricultural biotechnology.
                </p>
                <div class="d-flex gap-3">
                    <a href="<?php echo BASE_URL; ?>incubation-center.php" class="btn btn-srku"><i class="fas fa-lightbulb me-1"></i> Incubation Centre</a>
                    <a href="<?php echo BASE_URL; ?>page.php?slug=admission" class="btn btn-outline-danger"><i class="fas fa-user-graduate me-1"></i> Ph.D. Admissions</a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     alt="SRKU Research Labs" class="img-fluid rounded-4 border border-4 border-danger shadow">
            </div>
        </div>

        <!-- Research Pillars -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.6rem;">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">Patents &amp; Intellectual Property</h3>
                    <p class="text-muted small mb-0" style="line-height:1.7;">
                        Dedicated IPR Cell assisting faculty and student innovators from patent search, drafting to commercial licensing.
                    </p>
                </div>
            </div>

            <div class="col">
                <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.6rem;">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">Central Instrumentation Facility</h3>
                    <p class="text-muted small mb-0" style="line-height:1.7;">
                        Advanced analytical equipment including HPLC, FTIR Spectrophotometer, UV-Vis Spectrometer, and PCR suites.
                    </p>
                </div>
            </div>

            <div class="col">
                <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.6rem;">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">Ph.D. Doctoral Programmes</h3>
                    <p class="text-muted small mb-0" style="line-height:1.7;">
                        Doctoral research across Engineering, Pharmaceutical Sciences, Management, Computer Applications, Law, and Life Sciences.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
