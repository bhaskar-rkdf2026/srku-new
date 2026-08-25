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
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('career', 'Faculty & Staff Recruitment', 'Join Central India\'s Premier Academic Ecosystem as an Educator, Researcher or Leader'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        
        <div class="row g-4 g-lg-5 mb-5">
            
            <!-- Left Info Column -->
            <div class="col-12 col-lg-7">
                <span class="section-subtitle">CURRENT OPENINGS</span>
                <h2 class="section-title mb-3">Build an Inspiring <span>Academic Career</span></h2>
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.95rem;">
                    Sarvepalli Radhakrishnan University invites applications from dynamic, scholarly, and research-oriented academicians for faculty and leadership positions across all departments.
                </p>

                <!-- Vacancies List -->
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="p-4 border rounded-4 bg-light">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="h5 fw-bold text-navy mb-0">Professors / Associate Professors</h4>
                            <span class="badge bg-danger">Multiple Positions</span>
                        </div>
                        <p class="text-muted small mb-2"><strong>Disciplines:</strong> CSE (AI/ML/Data Science), Pharmacy (Pharmaceutics/Pharmacology), Management (Finance/Marketing), Nursing, Law &amp; Agriculture.</p>
                        <small class="text-dark"><strong>Eligibility:</strong> Ph.D. with minimum 8-10 years of teaching/research experience as per UGC/AICTE/PCI norms.</small>
                    </div>

                    <div class="p-4 border rounded-4 bg-light">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="h5 fw-bold text-navy mb-0">Assistant Professors</h4>
                            <span class="badge bg-danger">Multiple Positions</span>
                        </div>
                        <p class="text-muted small mb-2"><strong>Disciplines:</strong> Computer Applications, Mechanical Engineering, Physiotherapy, Nursing &amp; Basic Sciences.</p>
                        <small class="text-dark"><strong>Eligibility:</strong> Master's Degree with NET/GATE/Ph.D. in relevant discipline with strong pedagogical skills.</small>
                    </div>

                    <div class="p-4 border rounded-4 bg-light">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="h5 fw-bold text-navy mb-0">Technical Lab Assistants &amp; Admin Staff</h4>
                            <span class="badge bg-primary">Open</span>
                        </div>
                        <p class="text-muted small mb-2"><strong>Roles:</strong> Computer Lab Administrators, Pharmacy Lab Technicians, Admission Counselors &amp; Office Executives.</p>
                        <small class="text-dark"><strong>Eligibility:</strong> Relevant Diploma / Degree with 2+ years of university lab/administrative experience.</small>
                    </div>
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
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Your Full Name" minlength="2" maxlength="80" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Email Address *</label>
                                <input type="email" name="email" class="form-control form-control-sm" placeholder="yourname@gmail.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control form-control-sm" placeholder="10-digit mobile" pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" required>
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

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
