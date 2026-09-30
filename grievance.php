<?php
$pageTitle = "Student Grievance Redressal Cell | Confidential Portal | SRKU Bhopal";
$pageDesc = "Submit academic, administrative, hostel or examination grievances securely to the official Student Grievance Redressal Cell at Sarvepalli Radhakrishnan University as per UGC regulations.";
$pageKeywords = "SRKU Grievance Cell, Student Complaint Portal, UGC Grievance Redressal Bhopal, SRKU Student Support";
$activeNav = "grievance";
require_once __DIR__ . '/includes/header.php';

$complaintSuccess = false;
$complaintErr = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_complaint'])) {
    $res = saveComplaint(
        $_POST['name'] ?? '',
        $_POST['father_name'] ?? '',
        $_POST['enrollment_number'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['institute_name'] ?? '',
        $_POST['course_name'] ?? '',
        $_POST['year_semester'] ?? '',
        $_POST['complaint_type'] ?? '',
        $_POST['complaint_details'] ?? ''
    );
    if ($res['success']) {
        $complaintSuccess = true;
    } else {
        $complaintErr = $res['error'];
    }
}
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('grievance', 'Sarvepalli Radhakrishnan University Complaint Form', 'Register your grievance and our administration will address it promptly'); ?>

<section class="py-5 bg-light-subtle">
    <div class="container-xl py-3">
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card p-4 p-md-5 border-0 shadow rounded-4 bg-white" id="complaint">
                    <h2 class="section-title mb-2">Register Your <span>Complaint</span></h2>
                    <p class="text-muted small mb-4">Please fill out the form below with accurate details. Our grievance cell will review and respond promptly.</p>

                    <?php if ($complaintSuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> Your complaint has been registered successfully. Our grievance cell will review it and contact you shortly.</div>
                    <?php elseif ($complaintErr): ?>
                        <div class="alert alert-danger"><?php echo sanitize($complaintErr); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>grievance.php#complaint" method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Your Name *</label>
                                <input type="text" name="name" class="form-control py-2" placeholder="Enter your full name" minlength="2" maxlength="80" pattern="[a-zA-Z\s\.\'-]{2,80}" title="Please enter a valid full name (alphabets only, min 2 characters)" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Father's Name</label>
                                <input type="text" name="father_name" class="form-control py-2" placeholder="Enter father's name" maxlength="80" pattern="[a-zA-Z\s\.\'-]{2,80}" title="Please enter a valid father's name (alphabets only)">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Enrollment Number</label>
                                <input type="text" name="enrollment_number" class="form-control py-2" placeholder="Enter your enrollment number" maxlength="50">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">E-mail ID *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" title="Please enter a valid email address" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control py-2" placeholder="10-Digit Mobile Number" inputmode="numeric" pattern="[6-9][0-9]{9}" minlength="10" maxlength="10" title="Please enter a valid 10-digit Indian mobile number (starting with 6, 7, 8, or 9)" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Institute Name</label>
                                <input type="text" name="institute_name" class="form-control py-2" placeholder="Enter your institute name" maxlength="150">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Course Name</label>
                                <input type="text" name="course_name" class="form-control py-2" placeholder="Enter your course name" maxlength="150">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Year / Semester</label>
                                <input type="text" name="year_semester" class="form-control py-2" placeholder="e.g. 2nd Year / 4th Semester" maxlength="50">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Type Of Complaint</label>
                            <select name="complaint_type" class="form-select py-2">
                                <option value="">-- Please choose an option --</option>
                                <option>Academic</option>
                                <option>Administrative</option>
                                <option>Examination</option>
                                <option>Hostel &amp; Accommodation</option>
                                <option>Fee &amp; Finance</option>
                                <option>Faculty / Staff Behaviour</option>
                                <option>Infrastructure &amp; Facilities</option>
                                <option>Ragging / Harassment</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small mb-1">About Your Complaint *</label>
                            <textarea name="complaint_details" class="form-control py-2" rows="5" placeholder="Describe your complaint in detail" minlength="10" required></textarea>
                        </div>
                        <button type="submit" name="submit_complaint" class="btn btn-srku px-5 py-2">
                            <i class="fas fa-paper-plane me-1"></i> Register Complaint
                        </button>
                    </form>
                </div>
            </div>

            <!-- Side Helpdesk & Statutory Committee Links -->
            <div class="col-12 col-lg-4">
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-headset text-danger me-2"></i> Grievance Helpdesk</h5>
                    <p class="text-muted small mb-3">For urgent grievances, anti-ragging complaints, or administrative assistance, contact the central university helpline:</p>
                    <div class="p-3 bg-light rounded-3 border mb-3 small">
                        <div class="fw-bold text-navy mb-1"><i class="fas fa-phone-alt text-danger me-2"></i> University Helpline:</div>
                        <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', getSetting('helpline', '07554911204')); ?>" class="text-decoration-none text-navy fw-semibold"><?php echo htmlspecialchars(getSetting('helpline', '0755 - 4911204')); ?></a>
                    </div>
                    <div class="p-3 bg-light rounded-3 border mb-3 small">
                        <div class="fw-bold text-navy mb-1"><i class="fas fa-envelope text-danger me-2"></i> Nodal Redressal Email:</div>
                        <a href="mailto:<?php echo getSetting('email', 'exam@srku.edu.in'); ?>" class="text-decoration-none text-danger fw-semibold"><?php echo htmlspecialchars(getSetting('email', 'exam@srku.edu.in')); ?></a>
                    </div>
                    <div class="p-3 bg-light rounded-3 border small">
                        <div class="fw-bold text-navy mb-1"><i class="fas fa-map-marker-alt text-danger me-2"></i> Campus Location:</div>
                        <span class="text-muted"><?php echo htmlspecialchars(getSetting('address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026')); ?></span>
                    </div>
                </div>

                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-shield-alt text-danger me-2"></i> Statutory Cells &amp; Committees</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="<?php echo BASE_URL; ?>document/student-grievance-committee" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="fas fa-balance-scale text-danger me-2"></i> Grievance Redressal Policy</span>
                            <i class="fas fa-external-link-alt text-muted small"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>document/anti-ragging" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="fas fa-ban text-danger me-2"></i> Anti-Ragging Committee &amp; Squad</span>
                            <i class="fas fa-external-link-alt text-muted small"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>document/women-grievance-committee" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="fas fa-female text-danger me-2"></i> Women Grievance Committee (ICC)</span>
                            <i class="fas fa-external-link-alt text-muted small"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>document/sc-st-grievance-committee" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="fas fa-hands-helping text-warning me-2"></i> SC / ST Grievance Committee</span>
                            <i class="fas fa-external-link-alt text-muted small"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>document/obc-minority" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="fas fa-users text-info me-2"></i> OBC &amp; Minority Grievance Cell</span>
                            <i class="fas fa-external-link-alt text-muted small"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>document/equal-opportunity-cell" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                            <span class="fw-semibold"><i class="fas fa-universal-access text-success me-2"></i> Equal Opportunity Cell</span>
                            <i class="fas fa-external-link-alt text-muted small"></i>
                        </a>
                    </div>
                </div>

                <div class="card p-4 border-0 shadow-sm rounded-4 text-white" style="background: linear-gradient(135deg, #16233f, #7A0B0D);">
                    <h6 class="fw-bold text-warning mb-2"><i class="fas fa-user-shield me-2"></i> 100% Confidential</h6>
                    <p class="small text-white-50 mb-0" style="line-height: 1.6;">
                        All submissions are encrypted and forwarded exclusively to the University Grievance Redressal Committee under UGC (Redress of Grievances of Students) Regulations, 2019.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     STATUTORY COMMITTEES & GRIEVANCE POLICIES SECTION
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-white border-top" id="statutory-policies">
    <div class="container-xl py-3">
        <div class="text-center mb-5" style="max-width: 800px; margin: auto;">
            <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-1 rounded-pill small text-uppercase mb-2">
                <i class="fas fa-shield-alt me-1"></i> UGC &amp; Statutory Regulatory Compliance
            </span>
            <h2 class="section-title mt-2">Official Statutory <span>Committees &amp; Policies</span></h2>
            <p class="text-muted small">
                In strict adherence to UGC, AICTE, and Apex Regulatory Council guidelines, Sarvepalli Radhakrishnan University has constituted dedicated cells and committees to ensure a safe, inclusive, zero-tolerance campus environment.
            </p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- 1. Grievance Redressal Policy -->
            <div class="col">
                <div class="card h-100 border rounded-4 p-4 shadow-sm hover-lift d-flex flex-column justify-content-between" style="border-top: 4px solid var(--srku-maroon) !important;">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="bg-danger-subtle text-danger p-3 rounded-3">
                                <i class="fas fa-balance-scale fa-lg"></i>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill small">Active 2026</span>
                        </div>
                        <h5 class="fw-bold text-navy mb-2">Policy for Grievance Redressal</h5>
                        <p class="text-muted small mb-3">Comprehensive framework, tier-wise redressal timelines, and student ombudsman mechanisms as per UGC Regulations.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                        <a href="<?php echo BASE_URL; ?>document/policy-for-grievance-redressal" class="btn btn-sm btn-outline-danger rounded-pill fw-semibold flex-grow-1">
                            <i class="fas fa-file-alt me-1"></i> View Document
                        </a>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/2026/updated-docs/Policy-for-grievance-redressal.pdf" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3" title="Download PDF">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. Anti-Ragging Committee & Squad -->
            <div class="col">
                <div class="card h-100 border rounded-4 p-4 shadow-sm hover-lift d-flex flex-column justify-content-between" style="border-top: 4px solid #dc3545 !important;">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="bg-danger-subtle text-danger p-3 rounded-3">
                                <i class="fas fa-ban fa-lg"></i>
                            </div>
                            <span class="badge bg-danger text-white px-2 py-1 rounded-pill small">Zero Tolerance</span>
                        </div>
                        <h5 class="fw-bold text-navy mb-2">Anti-Ragging Committee &amp; Squad</h5>
                        <p class="text-muted small mb-3">Official constitution order, squad members, flying squad monitoring, and UGC 24x7 anti-ragging toll-free directives.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                        <a href="<?php echo BASE_URL; ?>document/anti-ragging" class="btn btn-sm btn-outline-danger rounded-pill fw-semibold flex-grow-1">
                            <i class="fas fa-file-alt me-1"></i> View Document
                        </a>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/2026/updated-docs/Anti-Ragging-and-Squad.pdf" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3" title="Download PDF">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 3. Internal Complaint Committee (ICC / Women) -->
            <div class="col">
                <div class="card h-100 border rounded-4 p-4 shadow-sm hover-lift d-flex flex-column justify-content-between" style="border-top: 4px solid #e83e8c !important;">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="p-3 rounded-3" style="background: rgba(232, 62, 140, 0.1); color: #e83e8c;">
                                <i class="fas fa-female fa-lg"></i>
                            </div>
                            <span class="badge bg-purple-subtle text-purple px-2 py-1 rounded-pill small">POSH Act 2013</span>
                        </div>
                        <h5 class="fw-bold text-navy mb-2">Internal Complaint Committee (ICC)</h5>
                        <p class="text-muted small mb-3">Prevention, prohibition and redressal of sexual harassment of women employees and students across university units.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                        <a href="<?php echo BASE_URL; ?>document/internal-complaint-committee" class="btn btn-sm btn-outline-danger rounded-pill fw-semibold flex-grow-1">
                            <i class="fas fa-file-alt me-1"></i> View Document
                        </a>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/2026/updated-docs/Internal-Complaint-Committee.pdf" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3" title="Download PDF">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 4. SC / ST Grievance Committee -->
            <div class="col">
                <div class="card h-100 border rounded-4 p-4 shadow-sm hover-lift d-flex flex-column justify-content-between" style="border-top: 4px solid #fd7e14 !important;">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="p-3 rounded-3" style="background: rgba(253, 126, 20, 0.1); color: #fd7e14;">
                                <i class="fas fa-hands-helping fa-lg"></i>
                            </div>
                            <span class="badge bg-warning-subtle text-dark border px-2 py-1 rounded-pill small">Social Welfare</span>
                        </div>
                        <h5 class="fw-bold text-navy mb-2">SC &amp; ST Grievance Committee</h5>
                        <p class="text-muted small mb-3">Safeguarding constitutional rights, addressing complaints of discrimination, and facilitating welfare scholarships for SC/ST students.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                        <a href="<?php echo BASE_URL; ?>document/sc-st-grievance-committee" class="btn btn-sm btn-outline-danger rounded-pill fw-semibold flex-grow-1">
                            <i class="fas fa-file-alt me-1"></i> View Document
                        </a>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/2026/updated-docs/SCandST-Grievance-Committee.pdf" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3" title="Download PDF">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 5. OBC & Minority Grievance Cell -->
            <div class="col">
                <div class="card h-100 border rounded-4 p-4 shadow-sm hover-lift d-flex flex-column justify-content-between" style="border-top: 4px solid #0d6efd !important;">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="bg-primary-subtle text-primary p-3 rounded-3">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                            <span class="badge bg-primary-subtle text-primary border px-2 py-1 rounded-pill small">Minority Support</span>
                        </div>
                        <h5 class="fw-bold text-navy mb-2">OBC &amp; Minority Grievance Cell</h5>
                        <p class="text-muted small mb-3">Redressal of grievances, scholarship counseling, and academic empowerment for Other Backward Classes and minority community students.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                        <a href="<?php echo BASE_URL; ?>document/obc-minority" class="btn btn-sm btn-outline-danger rounded-pill fw-semibold flex-grow-1">
                            <i class="fas fa-file-alt me-1"></i> View Document
                        </a>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/2026/updated-docs/OBC-and-Minority-Grievance.pdf" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3" title="Download PDF">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 6. Equal Opportunity Cell -->
            <div class="col">
                <div class="card h-100 border rounded-4 p-4 shadow-sm hover-lift d-flex flex-column justify-content-between" style="border-top: 4px solid #198754 !important;">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="bg-success-subtle text-success p-3 rounded-3">
                                <i class="fas fa-universal-access fa-lg"></i>
                            </div>
                            <span class="badge bg-success-subtle text-success border px-2 py-1 rounded-pill small">Inclusive Campus</span>
                        </div>
                        <h5 class="fw-bold text-navy mb-2">Equal Opportunity Cell</h5>
                        <p class="text-muted small mb-3">Promoting diversity, equity, accessibility for differently-abled students, and non-discriminatory participation in campus life.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                        <a href="<?php echo BASE_URL; ?>document/equal-opportunity-cell" class="btn btn-sm btn-outline-danger rounded-pill fw-semibold flex-grow-1">
                            <i class="fas fa-file-alt me-1"></i> View Document
                        </a>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/2026/updated-docs/Equal-Opportunity-Cell.pdf" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3" title="Download PDF">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
