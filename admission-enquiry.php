<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Online Admission Enquiry 2026-27 | UG, PG & PhD Programs | SRKU Bhopal";
$pageDesc = "Apply online for Academic Session 2026-27 at Sarvepalli Radhakrishnan University (SRKU), Bhopal. Direct online enquiry for Engineering, Pharmacy, Nursing, Law, Agriculture and Medical degrees.";
$pageKeywords = "SRKU Admission 2026, Online Admission Form, University Admission Bhopal, Direct Admission Enquiry MP";
$activeNav = "admission";

$enquirySuccess = false;
$enquiryErr = '';
$enquiryMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_enquiry'])) {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['course'] ?? '',
        $_POST['message'] ?? '',
        'Online Admission Form',
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

// Fetch all database courses grouped by level
$allCourses = getCourses();
$selectedCourseParam = sanitize($_GET['course'] ?? '');

$address = getSetting('address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026');
$helpline = getSetting('helpline', '0755 - 4700983, 7024144981');
$email = getSetting('email', 'info@srku.edu.in');

require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('admission-enquiry', 'Online Admission Enquiry 2026-27', 'Begin your academic journey at Sarvepalli Radhakrishnan University, Bhopal'); ?>

<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="row g-4 g-lg-5">
            
            <!-- Left Form Column -->
            <div class="col-12 col-lg-8" id="apply">
                <div class="card p-4 p-md-5 border-0 shadow rounded-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                        <div>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill fw-bold text-uppercase" style="font-size:0.75rem;">
                                <i class="fas fa-graduation-cap me-1"></i> Admissions Open 2026-27
                            </span>
                            <h2 class="h3 fw-bold text-navy mt-2 mb-0">Admission <span>Registration &amp; Enquiry</span></h2>
                        </div>
                        <div class="d-none d-sm-block text-end">
                            <span class="badge bg-navy text-white px-3 py-2 fw-semibold">UGC Approved</span>
                        </div>
                    </div>

                    <p class="text-muted small mb-4">
                        Please provide your contact and academic preferences below. Our central university counseling desk will reach out within 24 hours with eligibility, fee structures, and scholarship details.
                    </p>

                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success d-flex align-items-center gap-3 p-3 rounded-3 mb-4 shadow-sm">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                            <div>
                                <strong class="d-block text-success">Application Received Successfully!</strong>
                                <span class="small text-dark"><?php echo sanitize($enquiryMsg); ?></span>
                            </div>
                        </div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger d-flex align-items-center gap-2 p-3 rounded-3 mb-4">
                            <i class="fas fa-exclamation-circle text-danger"></i>
                            <span><?php echo sanitize($enquiryErr); ?></span>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>admission-enquiry.php#apply" method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Candidate Full Name *</label>
                                <input type="text" name="name" class="form-control py-2" placeholder="Enter candidate's full name" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['name'] ?? ''); ?>" minlength="2" maxlength="80" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Father's / Guardian's Name</label>
                                <input type="text" name="father_name" class="form-control py-2" placeholder="Enter father's / guardian's name" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['father_name'] ?? ''); ?>" maxlength="80">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Mobile Number (WhatsApp) *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted small">+91</span>
                                    <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit mobile number" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['phone'] ?? ''); ?>" pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Email Address *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['email'] ?? ''); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Select Program / Course of Interest *</label>
                            <select name="course" class="form-select py-2" required>
                                <option value="">-- Choose Academic Course (90+ Programs Available) --</option>
                                <?php if (!empty($allCourses)): ?>
                                    <?php 
                                    $levels = ['UG' => 'Undergraduate Degrees (UG)', 'PG' => 'Postgraduate Degrees (PG)', 'Diploma' => 'Diploma & Certificate Courses', 'Doctorate' => 'Ph.D. & Research Programs'];
                                    foreach ($levels as $lvlKey => $lvlLabel): 
                                        $filtered = array_filter($allCourses, fn($c) => stripos((string)($c['level'] ?? ''), $lvlKey) !== false || stripos((string)($c['degree_level'] ?? ''), $lvlKey) !== false);
                                        if (!empty($filtered)):
                                    ?>
                                        <optgroup label="<?php echo $lvlLabel; ?>">
                                            <?php foreach ($filtered as $c): ?>
                                                <option value="<?php echo sanitize($c['course_name']); ?>" <?php echo ($selectedCourseParam == $c['course_name'] || ($selectedCourseParam == $c['slug'])) ? 'selected' : ''; ?>>
                                                    <?php echo sanitize($c['course_name']); ?> (<?php echo sanitize($c['duration']); ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                <?php else: ?>
                                    <option value="B.Tech Computer Science & Engineering">B.Tech Computer Science &amp; Engineering</option>
                                    <option value="Bachelor of Pharmacy (B.Pharm)">Bachelor of Pharmacy (B.Pharm)</option>
                                    <option value="MBA — Master of Business Administration">MBA — Master of Business Administration</option>
                                    <option value="B.Sc. Nursing">B.Sc. Nursing</option>
                                    <option value="B.Sc. (Hons) Agriculture">B.Sc. (Hons) Agriculture</option>
                                    <option value="BPT — Bachelor of Physiotherapy">BPT — Bachelor of Physiotherapy</option>
                                    <option value="LL.B — Bachelor of Laws">LL.B — Bachelor of Laws</option>
                                <?php endif; ?>
                                <option value="Other / General University Program">Other University Programme</option>
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">City / District</label>
                                <input type="text" name="city" class="form-control py-2" placeholder="e.g. Bhopal, Indore, Patna, etc." value="<?php echo $enquirySuccess ? '' : sanitize($_POST['city'] ?? ''); ?>" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">State</label>
                                <input type="text" name="state" class="form-control py-2" placeholder="e.g. Madhya Pradesh, Bihar, UP" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['state'] ?? ''); ?>" maxlength="100">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small mb-1">Specific Query / Academic Background (Optional)</label>
                            <textarea name="message" class="form-control py-2" rows="3" placeholder="Enter any specific queries regarding fee installments, hostel accommodation, bus transport, or direct counseling..."><?php echo $enquirySuccess ? '' : sanitize($_POST['message'] ?? ''); ?></textarea>
                        </div>

                        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                            <button type="submit" name="submit_enquiry" class="btn btn-srku px-5 py-3 fw-bold d-flex align-items-center justify-content-center gap-2 shadow">
                                <i class="fas fa-paper-plane"></i> <span>Submit Admission Form</span>
                            </button>
                            <span class="text-muted small"><i class="fas fa-lock text-success me-1"></i> Your details are 100% confidential.</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Sidebar Column -->
            <div class="col-12 col-lg-4">
                
                <!-- Direct Helpline Card -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-navy text-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center p-2" style="width:48px; height:48px;">
                            <i class="fas fa-headset fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="h6 fw-bold text-warning mb-0">Admission Helpdesk</h4>
                            <small class="text-white-50">Direct Counselor Support</small>
                        </div>
                    </div>

                    <div class="p-3 bg-white bg-opacity-10 rounded-3 mb-3 small">
                        <div class="mb-2">
                            <i class="fas fa-phone-alt text-warning me-2"></i>
                            <strong>Toll-Free / Landline:</strong><br>
                            <span class="text-white-50 ps-4">0755-4700983, 0755-4700980</span>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-mobile-alt text-warning me-2"></i>
                            <strong>Direct Mobile Helpline:</strong><br>
                            <span class="text-white-50 ps-4">7024144981, 7024144982, 7024144983, 7024144984, 7024144986</span>
                        </div>
                        <div>
                            <i class="fas fa-envelope text-warning me-2"></i>
                            <strong>Official Email:</strong><br>
                            <span class="text-white-50 ps-4">info@srku.edu.in, admissions@srku.edu.in</span>
                        </div>
                    </div>

                    <div class="small text-white-50">
                        <i class="far fa-clock text-warning me-1"></i> <strong>Office Hours:</strong> Mon &ndash; Sat: 9:00 AM &ndash; 5:30 PM
                    </div>
                </div>

                <!-- Why Apply at SRKU Box -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                    <h4 class="h6 fw-bold text-navy mb-3"><i class="fas fa-star text-warning me-2"></i> Why Choose SRK University?</h4>
                    <ul class="list-unstyled small text-muted mb-0 d-flex flex-column gap-2">
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-success mt-1"></i>
                            <span><strong>30+ Years Legacy</strong> in professional, medical, technical &amp; legal education.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-success mt-1"></i>
                            <span><strong>26 Constituent Units</strong> with comprehensive multidisciplinary campus.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-success mt-1"></i>
                            <span><strong>750+ Bed Teaching Hospital</strong> for live clinical and healthcare internships.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-success mt-1"></i>
                            <span><strong>Central Placement Cell</strong> with 500+ corporate recruiters.</span>
                        </li>
                    </ul>
                </div>

                <!-- Download Brochure & Prospectus -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-light border">
                    <h5 class="h6 fw-bold text-navy mb-2"><i class="fas fa-file-pdf text-danger me-2"></i> Official Prospectus</h5>
                    <p class="text-muted small mb-3">Download the comprehensive university academic brochure and admission guidelines.</p>
                    <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Prospectus.pdf" target="_blank" class="btn btn-sm btn-outline-danger fw-semibold d-flex align-items-center justify-content-center gap-1">
                        <i class="fas fa-download"></i> <span>Download Prospectus (PDF)</span>
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
