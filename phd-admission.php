<?php
$pageTitle = "Ph.D. Admission 2026 - Sarvepalli Radhakrishnan University Bhopal";
$activeNav = "admission";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$selectedDept = sanitize($_GET['dept'] ?? '');

$enquirySuccess = false;
$enquiryErr = '';
$enquiryMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_phd_lead'])) {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        'Ph.D. in ' . ($_POST['discipline'] ?? 'Doctoral Research'),
        $_POST['message'] ?? '',
        'Ph.D. Admission Portal',
        $_POST['father_name'] ?? '',
        $_POST['city'] ?? '',
        $_POST['state'] ?? ''
    );
    if ($res['success']) {
        $enquirySuccess = true;
        $enquiryMsg = $res['message'];
    } else {
        $enquiryErr = $res['error'];
    }
}
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('phd-admission', 'Doctor of Philosophy (Ph.D.) Admissions 2026', 'UGC Recognized Doctoral Research Programmes Across Engineering, Pharmacy, Management, Medical, Science & Law'); ?>

<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm border mb-0">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-navy text-decoration-none"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>research-innovation.php" class="text-navy text-decoration-none">Research</a></li>
                <li class="breadcrumb-item active text-danger fw-bold" aria-current="page">Ph.D. Admission</li>
            </ol>
        </nav>

        <!-- Official Downloadable PDF Forms Banner (Top Action Bar) -->
        <div class="card p-4 p-lg-5 border-0 shadow rounded-4 text-white mb-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #7A0B0D 0%, #16233f 100%);">
            <div class="position-absolute end-0 bottom-0 p-4 opacity-10 d-none d-lg-block">
                <i class="fas fa-graduation-cap fa-10x"></i>
            </div>
            <div class="row align-items-center g-4 position-relative z-2">
                <div class="col-12 col-lg-7">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="fas fa-certificate me-1"></i> UGC-Regulated Doctoral Programmes
                    </span>
                    <h2 class="h2 fw-bold text-white mb-3">Download Official Ph.D. Application &amp; Entrance Forms</h2>
                    <p class="text-white-50 mb-4" style="line-height: 1.7; font-size: 0.98rem;">
                        Candidates seeking admission to Doctor of Philosophy (Ph.D.) programmes for the academic session 2026-27 can download the prescribed official application forms below.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-application-form.pdf" target="_blank" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm">
                            <i class="fas fa-file-pdf me-2"></i> Ph.D. Application Form (PDF)
                        </a>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-entrance-form.pdf" target="_blank" class="btn btn-outline-light fw-bold px-4 py-2 rounded-pill">
                            <i class="fas fa-file-signature me-2"></i> Ph.D. Entrance Exam Form (PDF)
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="p-4 rounded-4 bg-white text-navy shadow-sm">
                        <h5 class="fw-bold text-navy mb-3"><i class="fas fa-info-circle text-danger me-2"></i> Key Documents &amp; Policies</h5>
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                            <li><a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-admission-policy.pdf" target="_blank" class="text-navy text-decoration-none hover-text-danger d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border"><span class="fw-semibold"><i class="fas fa-gavel text-danger me-2"></i> Ph.D. Admission Policy</span> <i class="fas fa-download text-muted"></i></a></li>
                            <li><a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-scholars-pursuing.pdf" target="_blank" class="text-navy text-decoration-none hover-text-danger d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border"><span class="fw-semibold"><i class="fas fa-users text-primary me-2"></i> Currently Enrolled Scholars</span> <i class="fas fa-download text-muted"></i></a></li>
                            <li><a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-scholars-completed.pdf" target="_blank" class="text-navy text-decoration-none hover-text-danger d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border"><span class="fw-semibold"><i class="fas fa-award text-warning me-2"></i> Ph.D. Awarded Scholars</span> <i class="fas fa-download text-muted"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 g-lg-5 mb-5">
            
            <!-- Left: Eligibility, Selection & Disciplines -->
            <div class="col-12 col-lg-7">
                
                <!-- Eligibility Criteria Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <span class="section-subtitle"><i class="fas fa-check-circle text-danger me-1"></i> ADMISSION GUIDELINES</span>
                    <h3 class="h4 fw-bold text-navy mb-3">Eligibility Criteria for Ph.D. Admission</h3>
                    <p class="text-muted small mb-4" style="line-height: 1.8;">
                        Admission to Doctor of Philosophy (Ph.D.) programmes is governed strictly by the UGC (Minimum Standards and Procedure for Award of Ph.D. Degree) Regulations and University Ordinances.
                    </p>
                    
                    <div class="d-flex flex-column gap-3">
                        <div class="p-3 rounded-3 bg-light border-start border-4 border-danger">
                            <h6 class="fw-bold text-navy mb-1"><i class="fas fa-graduation-cap text-danger me-2"></i> Master&rsquo;s Degree Qualification</h6>
                            <p class="text-muted small mb-0">Candidate must hold a Master&rsquo;s degree (M.Tech, M.Pharm, MBA, MCA, M.Sc, M.A., LL.M., MD/MS) or equivalent professional degree with at least <strong>55% aggregate marks</strong> (or equivalent CGPA).</p>
                        </div>
                        <div class="p-3 rounded-3 bg-light border-start border-4 border-warning">
                            <h6 class="fw-bold text-navy mb-1"><i class="fas fa-percentage text-warning me-2"></i> Relaxation for Reserved Categories</h6>
                            <p class="text-muted small mb-0">A relaxation of <strong>5% marks</strong> (from 55% to 50%) or equivalent grade is allowed for candidates belonging to SC / ST / OBC (non-creamy layer) / Differently-Abled categories.</p>
                        </div>
                        <div class="p-3 rounded-3 bg-light border-start border-4 border-success">
                            <h6 class="fw-bold text-navy mb-1"><i class="fas fa-award text-success me-2"></i> UGC-NET / GATE / GPAT Exemption</h6>
                            <p class="text-muted small mb-0">Candidates who have qualified UGC-NET (including JRF), CSIR-NET (including JRF), SLET, GATE, GPAT, or teacher fellowship holders are exempted from the University Ph.D. Entrance Test (DET) and can directly appear for the Research Interview.</p>
                        </div>
                    </div>
                </div>

                <!-- 4-Step Admission Procedure -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <span class="section-subtitle">STEP-BY-STEP ADMISSION PROCESS</span>
                    <h3 class="h4 fw-bold text-navy mb-4">How to Apply for Ph.D.</h3>

                    <div class="row row-cols-1 row-cols-sm-2 g-3">
                        <div class="col">
                            <div class="p-3 rounded-3 bg-light border h-100">
                                <div class="badge bg-danger text-white rounded-circle mb-2" style="width: 28px; height: 28px; line-height: 18px;">1</div>
                                <h6 class="fw-bold text-navy mb-1">Application Submission</h6>
                                <p class="text-muted small mb-0">Download and fill the official Ph.D. Application &amp; Entrance Form along with attested academic documents.</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 rounded-3 bg-light border h-100">
                                <div class="badge bg-danger text-white rounded-circle mb-2" style="width: 28px; height: 28px; line-height: 18px;">2</div>
                                <h6 class="fw-bold text-navy mb-1">Entrance Examination</h6>
                                <p class="text-muted small mb-0">Appear for the Doctoral Entrance Test (DET) consisting of Research Methodology (50%) &amp; Subject Knowledge (50%).</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 rounded-3 bg-light border h-100">
                                <div class="badge bg-danger text-white rounded-circle mb-2" style="width: 28px; height: 28px; line-height: 18px;">3</div>
                                <h6 class="fw-bold text-navy mb-1">Research Interview &amp; Viva</h6>
                                <p class="text-muted small mb-0">Present your proposed research plan / synopsis before the Departmental Research Committee (DRC).</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 rounded-3 bg-light border h-100">
                                <div class="badge bg-danger text-white rounded-circle mb-2" style="width: 28px; height: 28px; line-height: 18px;">4</div>
                                <h6 class="fw-bold text-navy mb-1">Course Work &amp; Registration</h6>
                                <p class="text-muted small mb-0">Complete mandatory Pre-Ph.D. coursework, Research Ethics training, and formal Research Advisory Committee (RAC) registration.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ph.D. Disciplines Grid -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white">
                    <span class="section-subtitle">RESEARCH DOMAINS</span>
                    <h3 class="h4 fw-bold text-navy mb-3">Available Doctoral Research Disciplines</h3>
                    
                    <?php
                    $phdDisciplines = [
                        ['icon' => 'fa-cogs', 'name' => 'Engineering & Technology', 'subs' => 'CSE, Mechanical, Civil, Electrical, EC'],
                        ['icon' => 'fa-pills', 'name' => 'Pharmaceutical Sciences', 'subs' => 'Pharmaceutics, Pharmacology, Pharmacognosy, Q.A.'],
                        ['icon' => 'fa-chart-line', 'name' => 'Management & Commerce', 'subs' => 'Finance, Marketing, HR, Business Analytics'],
                        ['icon' => 'fa-laptop-code', 'name' => 'Computer Applications & IT', 'subs' => 'Artificial Intelligence, Cloud, Data Science, Cyber Security'],
                        ['icon' => 'fa-stethoscope', 'name' => 'Medical & Healthcare Sciences', 'subs' => 'Medical Anatomy, Biochemistry, Pathology, Dental'],
                        ['icon' => 'fa-balance-scale', 'name' => 'Law & Legal Studies', 'subs' => 'Constitutional Law, Criminal Law, Corporate Law'],
                        ['icon' => 'fa-seedling', 'name' => 'Agricultural Sciences', 'subs' => 'Agronomy, Horticulture, Plant Pathology, Soil Science'],
                        ['icon' => 'fa-atom', 'name' => 'Basic & Applied Sciences', 'subs' => 'Physics, Chemistry, Mathematics, Biotechnology, Zoology']
                    ];
                    ?>

                    <div class="row row-cols-1 row-cols-sm-2 g-3">
                        <?php foreach ($phdDisciplines as $d): ?>
                            <div class="col">
                                <div class="p-3 rounded-3 bg-light border d-flex gap-3 align-items-start">
                                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; font-size: 1.1rem;">
                                        <i class="fas <?php echo $d['icon']; ?>"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-navy mb-1" style="font-size: 0.92rem;"><?php echo $d['name']; ?></h6>
                                        <small class="text-muted d-block" style="font-size: 0.78rem;"><?php echo $d['subs']; ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

            <!-- Right: Online Pre-Registration Form & Helpline -->
            <div class="col-12 col-lg-5" id="apply">
                
                <!-- Online Lead Capture Form -->
                <div class="card p-4 p-md-5 border-0 shadow rounded-4 bg-white mb-4 sticky-top" style="top: 20px; z-index: 10;">
                    <h3 class="h4 text-navy fw-bold mb-2">Ph.D. Pre-Registration Enquiry</h3>
                    <p class="text-muted small mb-4">Submit your research interest for doctoral counseling and entrance schedule.</p>

                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> <?php echo sanitize($enquiryMsg); ?></div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger"><?php echo sanitize($enquiryErr); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>phd-admission.php#apply" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Candidate Full Name *</label>
                            <input type="text" name="name" class="form-control py-2" placeholder="e.g. Dr. / Mr. / Ms. Name" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark small mb-1">Email Address *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="your@email.com" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark small mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit mobile" pattern="[0-9]{10}" maxlength="10" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Target Research Discipline *</label>
                            <select name="discipline" class="form-select py-2" required>
                                <option value="">-- Select Research Faculty --</option>
                                <option value="Computer Science & Engineering">Computer Science &amp; Engineering</option>
                                <option value="Mechanical Engineering">Mechanical Engineering</option>
                                <option value="Civil Engineering">Civil Engineering</option>
                                <option value="Pharmaceutical Sciences">Pharmaceutical Sciences</option>
                                <option value="Management Studies">Management Studies</option>
                                <option value="Commerce">Commerce</option>
                                <option value="Law & Legal Studies">Law &amp; Legal Studies</option>
                                <option value="Medical & Health Sciences">Medical &amp; Health Sciences</option>
                                <option value="Agricultural Sciences">Agricultural Sciences</option>
                                <option value="Biotechnology & Life Sciences">Biotechnology &amp; Life Sciences</option>
                                <option value="Chemistry / Physics / Mathematics">Chemistry / Physics / Mathematics</option>
                            </select>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark small mb-1">City</label>
                                <input type="text" name="city" class="form-control py-2" placeholder="e.g. Bhopal">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold text-dark small mb-1">State</label>
                                <input type="text" name="state" class="form-control py-2" placeholder="e.g. Madhya Pradesh">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Proposed Research Topic / Area</label>
                            <textarea name="message" class="form-control py-2" rows="3" placeholder="Brief outline of your research interest, NET/GATE status..."></textarea>
                        </div>
                        <button type="submit" name="submit_phd_lead" class="btn btn-srku w-100 py-3 fw-bold shadow">
                            <i class="fas fa-paper-plane me-1"></i> Submit Ph.D. Enquiry
                        </button>
                    </form>

                    <!-- Direct Doctoral Helpline -->
                    <div class="mt-4 pt-3 border-top text-center">
                        <small class="text-muted d-block mb-1">Ph.D. Research Cell Contact Desk:</small>
                        <a href="tel:7024144981" class="fw-bold text-danger text-decoration-none fs-6">
                            <i class="fas fa-phone-alt me-1"></i> 7024144981 / 0755-4700980
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
