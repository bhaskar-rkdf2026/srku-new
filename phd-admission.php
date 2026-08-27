<?php
$pageTitle = "Ph.D. Admissions 2026-27 | Doctoral Research Entrance & Guidelines | SRKU Bhopal";
$pageDesc = "Apply for Ph.D. Entrance Examination 2026 at Sarvepalli Radhakrishnan University (SRKU), Bhopal. Check eligibility, UGC minimum standards compliance, research domains, syllabus and interview guidelines.";
$pageKeywords = "PhD Admission Bhopal, Doctoral Program MP, SRKU PhD Entrance Exam, UGC Net Qualified PhD, Research Fellowship Bhopal";
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
                        <a href="<?php echo BASE_URL; ?>phd-application-form.php" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm">
                            <i class="fas fa-file-alt me-2"></i> Ph.D. Application Form &amp; Checklist
                        </a>
                        <a href="<?php echo BASE_URL; ?>phd-entrance-form.php" class="btn btn-outline-light fw-bold px-4 py-2 rounded-pill">
                            <i class="fas fa-file-signature me-2"></i> Ph.D. Entrance Exam Form
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="p-4 rounded-4 bg-white text-navy shadow-sm">
                        <h5 class="fw-bold text-navy mb-3"><i class="fas fa-info-circle text-danger me-2"></i> Key Documents &amp; Policies</h5>
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                            <li><a href="<?php echo BASE_URL; ?>document/phd-admission-policy" class="text-navy text-decoration-none hover-text-danger d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border"><span class="fw-semibold"><i class="fas fa-gavel text-danger me-2"></i> Ph.D. Admission Policy</span> <i class="fas fa-chevron-right text-muted"></i></a></li>
                            <li><a href="<?php echo BASE_URL; ?>document/phd-scholars-pursuing" class="text-navy text-decoration-none hover-text-danger d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border"><span class="fw-semibold"><i class="fas fa-users text-primary me-2"></i> Currently Enrolled Scholars</span> <i class="fas fa-chevron-right text-muted"></i></a></li>
                            <li><a href="<?php echo BASE_URL; ?>document/phd-scholars-completed" class="text-navy text-decoration-none hover-text-danger d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border"><span class="fw-semibold"><i class="fas fa-award text-warning me-2"></i> Ph.D. Awarded Scholars</span> <i class="fas fa-chevron-right text-muted"></i></a></li>
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
                        Admission to Doctor of Philosophy (Ph.D.) programmes is governed strictly by the UGC, AICTE, and relevant statutory regulatory council norms and University Ordinances.
                    </p>
                    
                    <div class="d-flex flex-column gap-3">
                        <div class="p-3 rounded-3 bg-light border-start border-4 border-danger">
                            <h6 class="fw-bold text-navy mb-1"><i class="fas fa-graduation-cap text-danger me-2"></i> Master&rsquo;s Degree Qualification</h6>
                            <p class="text-muted small mb-0">Candidate must hold a Master&rsquo;s degree (M.Tech, M.Pharm, MBA, MCA, M.Sc, M.A., LL.M., MD/MS) or equivalent postgraduate qualification in the relevant discipline <strong>as per AICTE, UGC &amp; Statutory Council norms</strong>.</p>
                        </div>
                        <div class="p-3 rounded-3 bg-light border-start border-4 border-warning">
                            <h6 class="fw-bold text-navy mb-1"><i class="fas fa-shield-alt text-warning me-2"></i> Statutory Guidelines &amp; Category Relaxation</h6>
                            <p class="text-muted small mb-0">Eligibility relaxation and reservation policies are applicable for reserved categories (SC / ST / OBC / Differently-Abled) strictly <strong>as per AICTE, UGC &amp; State Government norms</strong>.</p>
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
                                <p class="text-muted small mb-0">Appear for the Doctoral Entrance Test (DET) covering Research Methodology &amp; Subject Knowledge as per university norms.</p>
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
                        ['icon' => 'fa-cogs', 'name' => 'Engineering & Technology', 'subs' => 'CSE, Mechanical, Civil, Electrical, EC & allied disciplines'],
                        ['icon' => 'fa-pills', 'name' => 'Pharmaceutical Sciences', 'subs' => 'Pharmaceutics, Pharmacology, Pharmacognosy, Q.A. & many more'],
                        ['icon' => 'fa-chart-line', 'name' => 'Management & Commerce', 'subs' => 'Finance, Marketing, HR, Business Analytics & allied domains'],
                        ['icon' => 'fa-laptop-code', 'name' => 'Computer Applications & IT', 'subs' => 'AI/ML, Cloud, Data Science, Cyber Security & many more'],
                        ['icon' => 'fa-stethoscope', 'name' => 'Medical & Healthcare Sciences', 'subs' => 'Medical Anatomy, Biochemistry, Pathology, Dental & allied areas'],
                        ['icon' => 'fa-balance-scale', 'name' => 'Law & Legal Studies', 'subs' => 'Constitutional Law, Criminal Law, Corporate Law & many more'],
                        ['icon' => 'fa-seedling', 'name' => 'Agricultural Sciences', 'subs' => 'Agronomy, Horticulture, Plant Pathology, Soil Science & many more'],
                        ['icon' => 'fa-atom', 'name' => 'Basic & Applied Sciences', 'subs' => 'Physics, Chemistry, Mathematics, Biotechnology, Zoology & allied areas']
                    ];
                    ?>

                    <div class="row row-cols-1 row-cols-sm-2 g-3">
                        <?php foreach ($phdDisciplines as $d): ?>
                            <div class="col">
                                <div class="h-100 p-3 rounded-3 bg-light border d-flex gap-3 align-items-start">
                                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; font-size: 1.1rem;">
                                        <i class="fas <?php echo $d['icon']; ?>"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold text-navy mb-1" style="font-size: 0.92rem;"><?php echo $d['name']; ?></h6>
                                        <small class="text-muted d-block" style="font-size: 0.78rem;"><?php echo $d['subs']; ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-3 p-3 rounded-3 bg-light border d-flex align-items-center gap-3 text-muted small">
                        <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div>
                            <strong class="text-navy">Interdisciplinary &amp; Emerging Areas:</strong> Ph.D. guidance and research supervisors are also available across interdisciplinary, multidisciplinary &amp; allied emerging fields.
                        </div>
                    </div>
                </div>

                <!-- Ph.D. Departments & Doctoral Programmes -->
                <?php
                $doctorateCourses = getCourses(null, 'Doctorate');
                if (!empty($doctorateCourses)):
                ?>
                    <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mt-4">
                        <span class="section-subtitle"><i class="fas fa-university text-danger me-1"></i> DOCTORAL PROGRAMMES &amp; DEPARTMENTS</span>
                        <h3 class="h4 fw-bold text-navy mb-2">Doctorate Programmes by Constituent Departments</h3>
                        <p class="text-muted small mb-4">Doctor of Philosophy (Ph.D.) research is conducted across recognized constituent institutes and advanced research laboratories with doctoral guides and supervisor mentorship across wide-ranging research topics.</p>

                        <div class="d-flex flex-column gap-4">
                            <?php foreach ($doctorateCourses as $doc): 
                                $deptInfo = !empty($doc['dept_slug']) ? getDepartmentBySlug($doc['dept_slug']) : null;
                                $docSpecs = !empty($doc['specializations']) ? array_map('trim', explode(',', $doc['specializations'])) : [];
                            ?>
                                <div class="p-3 p-md-4 rounded-4 bg-light border position-relative">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                                        <span class="badge bg-white text-navy border px-2 py-1 rounded-pill small fw-bold">
                                            <i class="fas fa-building text-danger me-1"></i> <?php echo sanitize($doc['department']); ?>
                                        </span>
                                        <?php if (!empty($deptInfo['approvals'])): ?>
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-pill small fw-semibold">
                                                <i class="fas fa-certificate me-1"></i> <?php echo sanitize($deptInfo['approvals']); ?> Approved
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <h5 class="fw-bold text-navy mb-2">
                                        <a href="<?php echo BASE_URL; ?>course/<?php echo urlencode($doc['slug'] ?: $doc['id']); ?>" class="text-navy text-decoration-none hover-text-danger">
                                            <?php echo sanitize($doc['course_name']); ?>
                                        </a>
                                    </h5>

                                    <p class="text-muted small mb-3">
                                        <?php echo sanitize($doc['description']); ?>
                                    </p>

                                    <!-- Meta Details -->
                                    <div class="row g-2 mb-3 small">
                                        <div class="col-12 col-sm-6">
                                            <div class="p-2 rounded-3 bg-white border h-100">
                                                <span class="text-muted d-block" style="font-size: 0.75rem;"><i class="far fa-clock text-danger me-1"></i> Duration</span>
                                                <strong class="text-navy"><?php echo sanitize($doc['duration']); ?></strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="p-2 rounded-3 bg-white border h-100">
                                                <span class="text-muted d-block" style="font-size: 0.75rem;"><i class="fas fa-user-check text-success me-1"></i> Eligibility</span>
                                                <strong class="text-navy"><?php echo sanitize($doc['eligibility']); ?></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Research Thrust Areas -->
                                    <div class="mb-3">
                                        <span class="text-muted d-block small mb-1 fw-semibold"><i class="fas fa-microscope text-warning me-1"></i> Key Research Thrust Areas:</span>
                                        <div class="d-flex flex-wrap gap-1 align-items-center">
                                            <?php foreach ($docSpecs as $sp): ?>
                                                <span class="badge bg-white text-secondary border fw-normal" style="font-size: 0.76rem;">
                                                    <?php echo sanitize($sp); ?>
                                                </span>
                                            <?php endforeach; ?>
                                            <span class="badge bg-white text-secondary border fw-normal" style="font-size: 0.76rem;">
                                                &amp; Many More Specializations
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Action Links -->
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-2 border-top">
                                        <?php if (!empty($doc['dept_slug'])): ?>
                                            <a href="<?php echo BASE_URL; ?>department/<?php echo urlencode($doc['dept_slug']); ?>" class="text-navy text-decoration-none small fw-bold hover-text-danger">
                                                <i class="fas fa-university me-1 text-danger"></i> View Department Profile
                                            </a>
                                        <?php else: ?>
                                            <span></span>
                                        <?php endif; ?>

                                        <div class="d-flex gap-2">
                                            <a href="<?php echo BASE_URL; ?>course/<?php echo urlencode($doc['slug'] ?: $doc['id']); ?>" class="btn btn-sm btn-outline-navy px-3 rounded-pill fw-semibold">
                                                Programme Details
                                            </a>
                                            <a href="#apply" class="btn btn-sm btn-danger px-3 rounded-pill fw-semibold">
                                                Apply Now <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

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
                                <option value="">-- Select Research Faculty / Discipline --</option>
                                <option value="Engineering & Technology">Engineering &amp; Technology (CSE, ME, CE, EE, EC &amp; allied)</option>
                                <option value="Pharmaceutical Sciences">Pharmaceutical Sciences (Pharmaceutics, Pharmacology &amp; allied)</option>
                                <option value="Management & Commerce">Management &amp; Commerce</option>
                                <option value="Computer Applications & IT">Computer Applications &amp; IT / Data Science</option>
                                <option value="Nursing & Healthcare Sciences">Nursing &amp; Healthcare Sciences</option>
                                <option value="Medical & Dental Sciences">Medical &amp; Dental Sciences</option>
                                <option value="Law & Legal Studies">Law &amp; Legal Studies</option>
                                <option value="Agricultural Sciences">Agricultural Sciences</option>
                                <option value="Basic & Applied Sciences">Basic &amp; Applied Sciences (Physics, Chemistry, Maths, Biotech)</option>
                                <option value="Interdisciplinary & Allied Areas">Interdisciplinary &amp; Allied Areas (and many more)</option>
                                <option value="Other Specialized Research Area">Other Specialized Research Domain</option>
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
