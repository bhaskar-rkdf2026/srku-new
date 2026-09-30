<?php
$pageTitle = "Research & Innovation | 1,400+ Publications & Patents | SRKU Bhopal";
$pageDesc = "Explore groundbreaking research, 1,400+ indexed publications, multidisciplinary labs, and doctoral research at Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = "SRKU Research, Innovation Cell, Publications Bhopal, Patents, PhD Research Labs MP";
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
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>phd-admission.php" class="btn btn-srku shadow-sm"><i class="fas fa-user-graduate me-1"></i> Ph.D. Admissions 2026</a>
                    <a href="<?php echo BASE_URL; ?>incubation-center.php" class="btn btn-outline-danger"><i class="fas fa-lightbulb me-1"></i> Incubation Centre</a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     alt="SRKU Research Labs" class="img-fluid rounded-4 border border-4 border-danger shadow">
            </div>
        </div>

        <!-- Ph.D. Admission & Official Forms Download Section -->
        <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-5 border-top border-4 border-danger">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-6">
                    <span class="section-subtitle"><i class="fas fa-graduation-cap text-danger me-1"></i> DOCTORAL PROGRAMMES</span>
                    <h3 class="h4 fw-bold text-navy mb-2">Ph.D. Admission 2026 &amp; Official Forms</h3>
                    <p class="text-muted small mb-4" style="line-height: 1.8;">
                        Download the official prescribed application and entrance examination forms for Ph.D. admissions across Engineering, Pharmacy, Management, Computer Applications, Medical, and Science.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?php echo BASE_URL . getSetting('phd_app_pdf', 'assets/uploads/pdf/phd-application-form.pdf'); ?>" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold" download>
                            <i class="fas fa-file-alt me-1"></i> Ph.D. Application Form
                        </a>
                        <a href="<?php echo BASE_URL . getSetting('phd_entrance_pdf', 'assets/uploads/pdf/phd-entrance-form.pdf'); ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" download>
                            <i class="fas fa-file-signature me-1"></i> Ph.D. Entrance Form
                        </a>
                        <a href="<?php echo BASE_URL; ?>phd-admission.php" class="btn btn-outline-navy btn-sm rounded-pill px-3 fw-bold">
                            View Admission Portal &rarr;
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="row row-cols-1 row-cols-sm-2 g-2">
                        <div class="col">
                            <a href="<?php echo BASE_URL; ?>document/phd-admission-policy" class="p-3 bg-light rounded-3 border text-navy text-decoration-none d-block hover-shadow h-100" style="transition:all 0.2s ease;">
                                <div class="small fw-bold text-danger mb-1"><i class="fas fa-gavel me-1"></i> Policy</div>
                                <div class="small fw-semibold text-dark">Ph.D. Admission Policy &rarr;</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="<?php echo BASE_URL; ?>document/phd-scholars-pursuing" class="p-3 bg-light rounded-3 border text-navy text-decoration-none d-block hover-shadow h-100" style="transition:all 0.2s ease;">
                                <div class="small fw-bold text-primary mb-1"><i class="fas fa-users me-1"></i> Enrolled</div>
                                <div class="small fw-semibold text-dark">Currently Enrolled Scholars &rarr;</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="<?php echo BASE_URL; ?>document/phd-scholars-completed" class="p-3 bg-light rounded-3 border text-navy text-decoration-none d-block hover-shadow h-100" style="transition:all 0.2s ease;">
                                <div class="small fw-bold text-warning mb-1"><i class="fas fa-award me-1"></i> Completed</div>
                                <div class="small fw-semibold text-dark">Ph.D. Awarded Scholars &rarr;</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="<?php echo BASE_URL; ?>phd-admission.php#apply" class="p-3 bg-danger-subtle rounded-3 border border-danger-subtle text-danger text-decoration-none d-block hover-shadow h-100" style="transition:all 0.2s ease;">
                                <div class="small fw-bold text-danger mb-1"><i class="fas fa-paper-plane me-1"></i> Apply Online</div>
                                <div class="small fw-semibold text-danger">Ph.D. Online Pre-Reg &rarr;</div>
                            </a>
                        </div>
                    </div>
                </div>
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
        <!-- Research Policies & Statutory Guidelines Grid -->
        <div class="mt-5 pt-4 border-top">
            <div class="text-center mb-4">
                <span class="section-subtitle">STATUTORY FRAMEWORK &amp; FUNDING</span>
                <h3 class="h3 fw-bold text-navy">Research Policies &amp; Institutional Guidelines</h3>
                <p class="text-muted small">Official policies governing scientific integrity, ethical clearances, seed grants, consultancy, and patent disclosures at SRKU.</p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <div class="col">
                    <a href="<?php echo BASE_URL; ?>document/university-research-policy" class="text-decoration-none text-dark d-block h-100">
                        <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow bg-light" style="transition:all 0.2s ease;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-danger-subtle text-danger rounded-3 p-3"><i class="fas fa-file-contract fa-lg"></i></div>
                                <h5 class="fw-bold text-navy mb-0">University Research Policy</h5>
                            </div>
                            <p class="text-muted small mb-3">Institutional code of research ethics, publication incentives, patent disclosures, and IPR management.</p>
                            <span class="small fw-bold text-danger d-flex align-items-center gap-1">Download Research Policy &rarr;</span>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="<?php echo BASE_URL; ?>document/seed-money-research-policy" class="text-decoration-none text-dark d-block h-100">
                        <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow bg-light" style="transition:all 0.2s ease;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-success-subtle text-success rounded-3 p-3"><i class="fas fa-seedling fa-lg"></i></div>
                                <h5 class="fw-bold text-navy mb-0">Seed Money Research Policy</h5>
                            </div>
                            <p class="text-muted small mb-3">Institutional seed funding grants to faculty and researchers for high-impact preliminary scientific investigations.</p>
                            <span class="small fw-bold text-success d-flex align-items-center gap-1">Download Seed Money Policy &rarr;</span>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="<?php echo BASE_URL; ?>document/consultancy-projects" class="text-decoration-none text-dark d-block h-100">
                        <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow bg-light" style="transition:all 0.2s ease;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-primary-subtle text-primary rounded-3 p-3"><i class="fas fa-project-diagram fa-lg"></i></div>
                                <h5 class="fw-bold text-navy mb-0">Policy for Consultancy</h5>
                            </div>
                            <p class="text-muted small mb-3">Industrial testing, corporate training, technical solutions, and university-industry revenue sharing.</p>
                            <span class="small fw-bold text-primary d-flex align-items-center gap-1">Download Consultancy Policy &rarr;</span>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="<?php echo BASE_URL; ?>document/constitution-of-research-advisory-committee" class="text-decoration-none text-dark d-block h-100">
                        <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow bg-light" style="transition:all 0.2s ease;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-warning-subtle text-warning rounded-3 p-3"><i class="fas fa-microscope fa-lg"></i></div>
                                <h5 class="fw-bold text-navy mb-0">Research Advisory Committee (RAC)</h5>
                            </div>
                            <p class="text-muted small mb-3">Constitution and mandate of doctoral research review panels, guide allocations, and progress monitoring.</p>
                            <span class="small fw-bold text-warning d-flex align-items-center gap-1">View RAC Guidelines &rarr;</span>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="<?php echo BASE_URL; ?>document/ethics-board" class="text-decoration-none text-dark d-block h-100">
                        <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow bg-light" style="transition:all 0.2s ease;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-info-subtle text-info rounded-3 p-3"><i class="fas fa-balance-scale fa-lg"></i></div>
                                <h5 class="fw-bold text-navy mb-0">Institutional Ethics Board</h5>
                            </div>
                            <p class="text-muted small mb-3">Ethics clearances for human and animal trials, anti-plagiarism verification, and bioethics protocols.</p>
                            <span class="small fw-bold text-info d-flex align-items-center gap-1">View Ethics Board Norms &rarr;</span>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="<?php echo BASE_URL; ?>document/central-facilities-research" class="text-decoration-none text-dark d-block h-100">
                        <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow bg-light" style="transition:all 0.2s ease;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-danger-subtle text-danger rounded-3 p-3"><i class="fas fa-atom fa-lg"></i></div>
                                <h5 class="fw-bold text-navy mb-0">Central Research Facilities</h5>
                            </div>
                            <p class="text-muted small mb-3">High-end analytical instrumentation, central computing cluster, animal house, and advanced labs.</p>
                            <span class="small fw-bold text-danger d-flex align-items-center gap-1">View Central Labs &rarr;</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
