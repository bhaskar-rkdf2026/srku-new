<?php
$pageTitle = "Grievance / Complaint Form - SRK University Bhopal";
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

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card p-4 p-md-5 border-0 shadow rounded-4" id="complaint">
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
                                <input type="text" name="name" class="form-control py-2" placeholder="Enter your full name" minlength="2" maxlength="80" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Father's Name</label>
                                <input type="text" name="father_name" class="form-control py-2" placeholder="Enter father's name" maxlength="80">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Enrollment Number</label>
                                <input type="text" name="enrollment_number" class="form-control py-2" placeholder="Enter your enrollment number" maxlength="50">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">E-mail ID *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit mobile number" pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" required>
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
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
