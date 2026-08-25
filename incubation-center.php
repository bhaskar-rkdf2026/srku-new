<?php
$pageTitle = "SRKU Incubation Centre & Startups - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "research";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('incubation-center', 'Incubation & Startup Centre', 'Fostering Innovation, Student Entrepreneurship, Atmanirbhar Bharat & Viksit Bharat'); ?>

<!-- Main Incubation Overview -->
<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm border mb-0">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-navy text-decoration-none"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>research-innovation.php" class="text-navy text-decoration-none">Research &amp; Innovation</a></li>
                <li class="breadcrumb-item active text-danger fw-bold" aria-current="page">Incubation Centre</li>
            </ol>
        </nav>

        <div class="row g-4 g-lg-5 mb-5 align-items-center">
            <div class="col-12 col-lg-7">
                <span class="section-subtitle">
                    <i class="fas fa-rocket text-danger me-1"></i> ENTREPRENEURSHIP &amp; INNOVATION CELL
                </span>
                <h2 class="section-title mb-3">
                    Building Ventures with <span>Local Expertise &amp; Global Impact</span>
                </h2>
                <p class="text-dark mb-3" style="line-height: 1.8; font-size: 1rem;">
                    The <strong>Incubation Centre at Sarvepalli Radhakrishnan University (SRKU), Bhopal</strong> has been established to promote new ideas and startups across Madhya Pradesh and Central India. The centre incubates high-impact business ideas designed for regional fitment, market demand, and sustainable technological innovation.
                </p>
                <div class="p-3 bg-white rounded-3 border-start border-4 border-danger shadow-sm mb-4">
                    <strong class="text-navy d-block mb-1"><i class="fas fa-bullseye text-danger me-1"></i> Our Core Aim:</strong>
                    <p class="text-muted small mb-0">
                        To establish and foster innovation and entrepreneurship by supporting innovative business ideas that lead to viable, scalable business enterprises &mdash; actively promoting the national spirit of self-reliance: <strong>&lsquo;Atmanirbhar Bharat&rsquo;</strong> and <strong>&lsquo;Viksit Bharat&rsquo;</strong>.
                    </p>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/incubation-centre.pdf" target="_blank" class="btn btn-srku px-4 py-2 shadow-sm rounded-pill fw-bold">
                        <i class="fas fa-file-pdf me-2"></i> Download Official Policy (PDF)
                    </a>
                    <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-outline-danger px-4 py-2 rounded-pill fw-bold">
                        <i class="fas fa-paper-plane me-2"></i> Submit Startup Proposal
                    </a>
                </div>
            </div>

            <!-- Right Official Document Card -->
            <div class="col-12 col-lg-5">
                <div class="card p-4 p-md-5 border-0 shadow rounded-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #7A0B0D 0%, #16233f 100%);">
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="fas fa-lightbulb fa-6x"></i>
                    </div>
                    <div class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 align-self-start">
                        <i class="fas fa-certificate me-1"></i> Official University Cell
                    </div>
                    <h3 class="h4 fw-bold mb-3">SRKU Incubation Ecosystem</h3>
                    <p class="small text-white-50 mb-4" style="line-height: 1.7;">
                        Supporting pre-company stage incubatees, proof-of-concept validation, prototype laboratories, legal compliance, and seed funding support.
                    </p>
                    <ul class="list-unstyled small text-white-50 d-flex flex-column gap-2 mb-4">
                        <li><i class="fas fa-check-circle text-warning me-2"></i> Initial Focus: Handmade Soaps, Sanitizers &amp; Mobile Apps</li>
                        <li><i class="fas fa-check-circle text-warning me-2"></i> Pipeline: Solar Energy, Ayurveda &amp; Homoeopathy Startups</li>
                        <li><i class="fas fa-check-circle text-warning me-2"></i> Capacity Building &amp; VC Investor Pitch Days</li>
                    </ul>
                    <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/incubation-centre.pdf" target="_blank" class="btn btn-warning text-dark fw-bold rounded-pill w-100 py-2">
                        <i class="fas fa-download me-1"></i> View Official Circular (PDF)
                    </a>
                </div>
            </div>
        </div>

        <!-- 5 Thrust Areas Grid -->
        <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-5">
            <div class="text-center max-w-700 mx-auto mb-4">
                <span class="section-subtitle">KEY FOCUS SECTORS</span>
                <h2 class="section-title">Preferred <span>Thrust Areas</span> for Incubation</h2>
                <p class="text-muted small">Promoting technology-based innovation across priority domains aligned with industrial pragmatism.</p>
            </div>

            <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-3 text-center">
                
                <!-- 1. Agriculture -->
                <div class="col">
                    <div class="p-3 py-4 rounded-4 bg-light h-100 border hover-shadow" style="transition: all 0.25s ease;">
                        <div class="bg-success-subtle text-success rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px; font-size: 1.4rem;">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h4 class="h6 fw-bold text-navy mb-2">Agriculture &amp; Allied Fields</h4>
                        <p class="text-muted small mb-0" style="font-size: 0.82rem;">Smart farming, organic processing &amp; bio-fertilizers.</p>
                    </div>
                </div>

                <!-- 2. Energy & Environment -->
                <div class="col">
                    <div class="p-3 py-4 rounded-4 bg-light h-100 border hover-shadow" style="transition: all 0.25s ease;">
                        <div class="bg-warning-subtle text-warning rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px; font-size: 1.4rem;">
                            <i class="fas fa-solar-panel"></i>
                        </div>
                        <h4 class="h6 fw-bold text-navy mb-2">Energy &amp; Sustainability</h4>
                        <p class="text-muted small mb-0" style="font-size: 0.82rem;">Solar panel tech, waste management &amp; green energy.</p>
                    </div>
                </div>

                <!-- 3. Healthcare -->
                <div class="col">
                    <div class="p-3 py-4 rounded-4 bg-light h-100 border hover-shadow" style="transition: all 0.25s ease;">
                        <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px; font-size: 1.4rem;">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h4 class="h6 fw-bold text-navy mb-2">Healthcare &amp; Pharma</h4>
                        <p class="text-muted small mb-0" style="font-size: 0.82rem;">Ayurveda, Homoeopathy formulation &amp; clinical sanitizers.</p>
                    </div>
                </div>

                <!-- 4. Computer Application -->
                <div class="col">
                    <div class="p-3 py-4 rounded-4 bg-light h-100 border hover-shadow" style="transition: all 0.25s ease;">
                        <div class="bg-primary-subtle text-primary rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px; font-size: 1.4rem;">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4 class="h6 fw-bold text-navy mb-2">Computer Application</h4>
                        <p class="text-muted small mb-0" style="font-size: 0.82rem;">Mobile apps, enterprise software &amp; AI solutions.</p>
                    </div>
                </div>

                <!-- 5. E-Commerce -->
                <div class="col">
                    <div class="p-3 py-4 rounded-4 bg-light h-100 border hover-shadow" style="transition: all 0.25s ease;">
                        <div class="bg-info-subtle text-info rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px; font-size: 1.4rem;">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h4 class="h6 fw-bold text-navy mb-2">E-Commerce &amp; Retail</h4>
                        <p class="text-muted small mb-0" style="font-size: 0.82rem;">Direct-to-consumer platforms &amp; supply chain portals.</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Incubation Policy & Guidelines Section -->
        <div class="row g-4 mb-5">
            <div class="col-12 col-lg-6">
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white h-100">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fas fa-gavel text-danger fa-lg"></i>
                        <h3 class="h5 fw-bold text-navy mb-0">Incubation Policy &amp; Guidelines</h3>
                    </div>
                    <p class="text-muted small mb-3" style="line-height: 1.8;">
                        SRKU incubation centre is primarily responsible for nurturing startup-incubatees, as well as for identifying promising pre-company stage incubatees through its collaborated entrepreneurship network.
                    </p>
                    <ul class="list-unstyled text-dark small d-flex flex-column gap-3 mb-0" style="line-height: 1.7;">
                        <li><i class="fas fa-angle-right text-danger me-2"></i> <strong>Capacity Building:</strong> Helping early-stage ventures in capacity building, market fitment, and scaling.</li>
                        <li><i class="fas fa-angle-right text-danger me-2"></i> <strong>Guideline Standard:</strong> Policy serves as the standard operational framework for idea incubation.</li>
                        <li><i class="fas fa-angle-right text-danger me-2"></i> <strong>Periodical Review:</strong> Procedures and amendments are periodically reviewed by the academic committee.</li>
                        <li><i class="fas fa-angle-right text-danger me-2"></i> <strong>Admitted Startups Responsibility:</strong> Incubatees must stay updated on guidelines and compliance terms.</li>
                    </ul>
                </div>
            </div>

            <!-- PDF Viewer & Download Frame -->
            <div class="col-12 col-lg-6">
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h6 fw-bold text-navy mb-0"><i class="fas fa-file-pdf text-danger me-2"></i> Official Document Preview</h3>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/incubation-centre.pdf" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            <i class="fas fa-external-link-alt me-1"></i> Open Full PDF
                        </a>
                    </div>
                    <div class="flex-grow-1 rounded-3 overflow-hidden border" style="min-height: 300px;">
                        <iframe src="<?php echo BASE_URL; ?>assets/uploads/pdf/incubation-centre.pdf#toolbar=0" width="100%" height="100%" style="min-height: 320px; border:0;"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Incubation Cell Committee / Team Members -->
        <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2 pb-3 border-bottom">
                <div>
                    <span class="section-subtitle">ADVISORY &amp; EXECUTION BOARD</span>
                    <h3 class="h4 fw-bold text-navy mb-0">Incubation Centre Team Members</h3>
                </div>
                <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-bold">
                    <i class="fas fa-users me-1"></i> Executive Committee
                </span>
            </div>

            <?php
            $teamMembers = [
                ['name' => 'Dr. Sushil Singh', 'role' => 'Centre Co-ordinator', 'highlight' => true],
                ['name' => 'Dr. Hemant Gadekar', 'role' => 'Member'],
                ['name' => 'Dr. Rakesh Pandey', 'role' => 'Member'],
                ['name' => 'Dr. Devendra Kumar Dhote', 'role' => 'Member'],
                ['name' => 'Dr. M.C. Prashant', 'role' => 'Member'],
                ['name' => 'Dr. Archana Selvan', 'role' => 'Member'],
                ['name' => 'Dr. Brijendra Singh', 'role' => 'Member'],
                ['name' => 'Dr. Varsha Namdeo', 'role' => 'Member'],
                ['name' => 'Dr. Chinmay Bhatt', 'role' => 'Member'],
                ['name' => 'Dr. Sanjeev Shrivastava', 'role' => 'Member'],
                ['name' => 'Dr. Nilesh Diwakar', 'role' => 'Member'],
                ['name' => 'Dr. E. Vijay', 'role' => 'Member'],
                ['name' => 'Dr. Jyoti Yadav', 'role' => 'Member'],
                ['name' => 'Dr. Amitabh Shrivastava', 'role' => 'Member'],
            ];
            ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                <?php foreach ($teamMembers as $m): ?>
                    <div class="col">
                        <div class="p-3 rounded-4 <?php echo !empty($m['highlight']) ? 'bg-danger text-white shadow-sm' : 'bg-light border text-navy'; ?> d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 <?php echo !empty($m['highlight']) ? 'bg-white text-danger' : 'bg-danger-subtle text-danger'; ?>" style="width: 44px; height: 44px; font-size: 1.1rem;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 0.92rem;"><?php echo sanitize($m['name']); ?></h6>
                                <small class="<?php echo !empty($m['highlight']) ? 'text-white-50 fw-semibold' : 'text-muted'; ?>" style="font-size: 0.78rem;"><?php echo sanitize($m['role']); ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
