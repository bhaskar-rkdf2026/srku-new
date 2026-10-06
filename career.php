<?php
$pageTitle = "Careers & Faculty Recruitment | Work at SRKU Bhopal";
$pageDesc = "Explore academic, clinical, research, and administrative career openings at Sarvepalli Radhakrishnan University (SRKU), Bhopal. Apply for Professor, Associate Professor and Staff positions.";
$pageKeywords = "SRKU Careers, Faculty Recruitment Bhopal, University Jobs MP, Teaching Vacancies Bhopal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';

$applySuccess = false;
$applyErr = '';
$applyMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_career'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $position = sanitize($_POST['position'] ?? 'Faculty');
    $dept = sanitize($_POST['department'] ?? 'General');
    $qualification = sanitize($_POST['qualification'] ?? 'N/A');
    $experience = sanitize($_POST['experience'] ?? 'N/A');
    
    $customMsg = "Position: $position | Department: $dept | Qualification: $qualification | Experience: $experience";
    $res = saveEnquiryLead($name, $email, $phone, "Career: $position ($dept)", $customMsg, "Career Portal Application");
    if ($res['success']) {
        $applySuccess = true;
        $applyMsg = "Application submitted successfully! Our HR & Recruitment Cell will review your profile and contact shortlisted candidates.";
    } else {
        $applyErr = $res['error'];
    }
}

// Dynamic Settings for Careers Page
$careerBannerTitle = getSetting('career_banner_title', 'Faculty & Staff Recruitment');
$careerBannerSubtitle = getSetting('career_banner_subtitle', "Join Central India's Premier Academic Ecosystem as an Educator, Researcher or Leader");
$careerSubtitle = getSetting('career_subtitle', 'CURRENT OPENINGS');
$careerTitle = getSetting('career_title', 'Build an Inspiring <span>Academic Career</span>');
$careerDesc = getSetting('career_desc', 'Sarvepalli Radhakrishnan University invites applications from dynamic, scholarly, and research-oriented academicians for faculty and leadership positions across all departments.');

$defaultOpenings = [
    [
        'title' => 'Professors / Associate Professors',
        'badge' => 'Multiple Positions',
        'badge_class' => 'bg-danger',
        'disciplines' => 'CSE (AI/ML/Data Science), Pharmacy (Pharmaceutics/Pharmacology), Management (Finance/Marketing), Nursing, Law & Agriculture.',
        'eligibility' => 'Ph.D. with minimum 8-10 years of teaching/research experience as per UGC/AICTE/PCI norms.'
    ],
    [
        'title' => 'Assistant Professors',
        'badge' => 'Multiple Positions',
        'badge_class' => 'bg-danger',
        'disciplines' => 'Computer Applications, Mechanical Engineering, Physiotherapy, Nursing & Basic Sciences.',
        'eligibility' => "Master's Degree with NET/GATE/Ph.D. in relevant discipline with strong pedagogical skills."
    ],
    [
        'title' => 'Technical Lab Assistants & Admin Staff',
        'badge' => 'Open',
        'badge_class' => 'bg-primary',
        'disciplines' => 'Computer Lab Administrators, Pharmacy Lab Technicians, Admission Counselors & Office Executives.',
        'eligibility' => 'Relevant Diploma / Degree with 2+ years of university lab/administrative experience.'
    ]
];
$careerOpeningsJson = getSetting('career_openings_json', '');
$careerOpenings = !empty($careerOpeningsJson) ? (json_decode($careerOpeningsJson, true) ?: $defaultOpenings) : $defaultOpenings;
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('career', $careerBannerTitle, $careerBannerSubtitle); ?>

<section class="py-5">
    <div class="container-xl py-3">
        
        <div class="row g-4 g-lg-5 mb-5">
            
            <!-- Left Info Column -->
            <div class="col-12 col-lg-7">
                <span class="section-subtitle"><?php echo sanitize($careerSubtitle); ?></span>
                <h2 class="section-title mb-3"><?php echo $careerTitle; ?></h2>
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.95rem;">
                    <?php echo nl2br(sanitize($careerDesc)); ?>
                </p>

                <!-- Vacancies List -->
                <div class="d-flex flex-column gap-3 mb-4">
                    <?php foreach ($careerOpenings as $op): ?>
                    <div class="p-4 border rounded-4 bg-light">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="h5 fw-bold text-navy mb-0"><?php echo sanitize($op['title'] ?? 'Opening'); ?></h4>
                            <span class="badge <?php echo sanitize($op['badge_class'] ?? 'bg-danger'); ?>"><?php echo sanitize($op['badge'] ?? 'Active'); ?></span>
                        </div>
                        <p class="text-muted small mb-2"><strong>Disciplines:</strong> <?php echo sanitize($op['disciplines'] ?? ''); ?></p>
                        <small class="text-dark"><strong>Eligibility:</strong> <?php echo sanitize($op['eligibility'] ?? ''); ?></small>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right Application Form Column -->
            <div class="col-12 col-lg-5" id="apply">
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-light">
                    <h3 class="h4 fw-bold text-navy mb-2">Online Application Form</h3>
                    <p class="text-muted small mb-4">Submit your resume details for consideration by the Recruitment Cell.</p>

                    <?php if ($applySuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> <?php echo sanitize($applyMsg); ?></div>
                    <?php elseif ($applyErr): ?>
                        <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-1"></i> <?php echo sanitize($applyErr); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>career.php#apply" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-bold mb-1">Full Name *</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Your Full Name" minlength="2" maxlength="80" pattern="[a-zA-Z\s\.\'-]{2,80}" title="Please enter a valid full name (alphabets only, min 2 characters)" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Email Address *</label>
                                <input type="email" name="email" class="form-control form-control-sm" placeholder="yourname@gmail.com" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" title="Please enter a valid email address" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control form-control-sm" placeholder="10-Digit Mobile Number" inputmode="numeric" pattern="[6-9][0-9]{9}" minlength="10" maxlength="10" title="Please enter a valid 10-digit Indian mobile number (starting with 6, 7, 8, or 9)" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Position Applied For</label>
                                <select name="position" class="form-select form-select-sm">
                                    <option>Professor</option>
                                    <option>Associate Professor</option>
                                    <option>Assistant Professor</option>
                                    <option>Lab Technician</option>
                                    <option>Admin / Counselor</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Department</label>
                                <input type="text" name="department" class="form-control form-control-sm" placeholder="e.g. Engineering / Pharmacy">
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Highest Qualification</label>
                                <input type="text" name="qualification" class="form-control form-control-sm" placeholder="e.g. Ph.D. / M.Tech">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Experience (Years)</label>
                                <input type="text" name="experience" class="form-control form-control-sm" placeholder="e.g. 5 Years">
                            </div>
                        </div>
                        <button type="submit" name="submit_career" class="btn btn-srku w-100 py-2 justify-content-center">
                            <i class="fas fa-paper-plane me-1"></i> Submit Job Application
                        </button>
                    </form>
                </div>
            </div>

        <!-- HR & Faculty Welfare Policies -->
        <div class="mt-5 pt-4 border-top">
            <div class="text-center mb-4">
                <span class="section-subtitle">HR COMPLIANCE &amp; BENEFITS</span>
                <h3 class="h3 fw-bold text-navy">University HR &amp; Staff Welfare Policies</h3>
                <p class="text-muted small">Standard operating procedures, appraisal systems, and faculty welfare policies governing employment at SRKU.</p>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <a href="<?php echo BASE_URL; ?>document/hr-policy" class="text-decoration-none text-dark d-block h-100">
                        <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow bg-light" style="transition:all 0.2s ease;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-danger-subtle text-danger rounded-3 p-3"><i class="fas fa-user-tie fa-lg"></i></div>
                                <h5 class="fw-bold text-navy mb-0">Human Resource (HR) Policy</h5>
                            </div>
                            <p class="text-muted small mb-3">Recruitment norms, leave regulations, code of professional conduct, and cadre progression rules.</p>
                            <span class="small fw-bold text-danger d-flex align-items-center gap-1">Download HR Policy &rarr;</span>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="<?php echo BASE_URL; ?>document/performance-appraisal-policy" class="text-decoration-none text-dark d-block h-100">
                        <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow bg-light" style="transition:all 0.2s ease;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-success-subtle text-success rounded-3 p-3"><i class="fas fa-chart-line fa-lg"></i></div>
                                <h5 class="fw-bold text-navy mb-0">Performance Appraisal Policy</h5>
                            </div>
                            <p class="text-muted small mb-3">UGC benchmarked API scores, annual PBAS evaluation, teaching outcome metrics, and rewards.</p>
                            <span class="small fw-bold text-success d-flex align-items-center gap-1">Download Appraisal Policy &rarr;</span>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="<?php echo BASE_URL; ?>document/welfare-policy" class="text-decoration-none text-dark d-block h-100">
                        <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow bg-light" style="transition:all 0.2s ease;">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-primary-subtle text-primary rounded-3 p-3"><i class="fas fa-heartbeat fa-lg"></i></div>
                                <h5 class="fw-bold text-navy mb-0">Staff &amp; Student Welfare Policy</h5>
                            </div>
                            <p class="text-muted small mb-3">Teaching hospital healthcare access, group medical coverage, staff quarters, and emergency aid.</p>
                            <span class="small fw-bold text-primary d-flex align-items-center gap-1">Download Welfare Policy &rarr;</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
