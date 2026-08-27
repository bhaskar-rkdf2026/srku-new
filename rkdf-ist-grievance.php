<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Online Grievance Redressal Portal | RKDF IST | SRKU";
$pageDesc = "Submit online grievance for RKDF Institute of Science & Technology, Sarvepalli Radhakrishnan University Bhopal.";
$activeNav = "departments";

$submitted = false;
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_grievance'])) {
    $submitted = true;
    $msg = "Your grievance has been submitted securely to the Grievance Redressal Committee. Reference ID: GRV-" . rand(10000, 99999) . ". You will be contacted within 48 hours.";
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="py-5 bg-navy text-white text-center">
    <div class="container-xl py-2">
        <span class="badge bg-danger px-3 py-1 mb-2">Student &amp; Staff Welfare</span>
        <h1 class="fw-bold display-6 mb-2">Grievance Redressal Portal</h1>
        <p class="text-warning mb-0">RKDF Institute of Science &amp; Technology &bull; Sarvepalli Radhakrishnan University</p>
    </div>
</div>

<div class="container-xl py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white">
                
                <?php if ($submitted): ?>
                    <div class="alert alert-success d-flex align-items-center gap-3 p-4 rounded-4 mb-4">
                        <i class="fas fa-shield-alt fa-2x text-success"></i>
                        <div>
                            <h5 class="fw-bold mb-1">Grievance Logged Securely</h5>
                            <p class="mb-0 small"><?php echo sanitize($msg); ?></p>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-science-and-technology" class="btn btn-srku px-4 py-2">Back to RKDF IST</a>
                    </div>
                <?php else: ?>
                    
                    <div class="border-bottom pb-3 mb-4">
                        <h4 class="fw-bold text-navy mb-1">Submit Grievance / Complaint</h4>
                        <p class="text-muted small mb-0">All complaints are treated with utmost confidentiality under AICTE/UGC guidelines.</p>
                    </div>

                    <form method="POST" action="">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Applicant Name *</label>
                                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Enrollment / Employee No. *</label>
                                <input type="text" name="reg_no" class="form-control" placeholder="e.g. SRKU/IST/2024/..." required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Contact Mobile *</label>
                                <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Email Address *</label>
                                <input type="email" name="email" class="form-control" placeholder="email@domain.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Grievance Category *</label>
                                <select name="category" class="form-select" required>
                                    <option value="Academic Grievance">Academic &amp; Examinations</option>
                                    <option value="Anti Ragging">Anti-Ragging Incident</option>
                                    <option value="Women Grievance / ICC">Women Grievance / Internal Complaints</option>
                                    <option value="SC/ST/OBC Redressal">SC / ST / OBC &amp; Minority Redressal</option>
                                    <option value="Hostel & Facilities">Hostel, Mess &amp; Campus Amenities</option>
                                    <option value="Finance & Fees">Accounts &amp; Fee Issues</option>
                                    <option value="Other">Other Issues</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Designation / Role</label>
                                <select name="role" class="form-select">
                                    <option value="Student">Student</option>
                                    <option value="Parent">Parent</option>
                                    <option value="Faculty">Faculty / Staff Member</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Detailed Description of Grievance *</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="Provide complete details including dates, branch, and any relevant facts..." required></textarea>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-4 small text-muted border">
                            <i class="fas fa-lock text-success me-1"></i> Your personal details will remain confidential and accessible only to the designated statutory grievance committee members.
                        </div>

                        <div class="text-end">
                            <button type="submit" name="submit_grievance" class="btn btn-danger btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i> Submit Confidential Grievance
                            </button>
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
