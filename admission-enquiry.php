<?php
$pageTitle = "Admission Enquiry Form - SRK University Bhopal";
$activeNav = "admission";
require_once __DIR__ . '/includes/header.php';

$enquirySuccess = false;
$enquiryErr = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_enquiry'])) {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['course'] ?? '',
        '',
        'Admission Enquiry Page',
        $_POST['father_name'] ?? '',
        $_POST['city'] ?? '',
        $_POST['state'] ?? ''
    );
    if ($res['success']) {
        $enquirySuccess = true;
    } else {
        $enquiryErr = $res['error'];
    }
}
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('admission-enquiry', 'Admission Enquiry Form', 'Fill in your details and our admission counselor will get in touch with you shortly'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card p-4 p-md-5 border-0 shadow rounded-4" id="apply">
                    <h2 class="section-title mb-2">Admission <span>Enquiry</span> Form</h2>
                    <p class="text-muted small mb-4">Please fill out the form below. Our senior counselor will get in touch with you within 24 hours.</p>

                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> Thank you! Your admission enquiry has been submitted successfully. Our team will contact you shortly.</div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger"><?php echo sanitize($enquiryErr); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>admission-enquiry.php#apply" method="POST">
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
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Courses</label>
                            <select name="course" class="form-select py-2">
                                <option value="">-- Please choose an option --</option>
                                <option>B.Tech Computer Science &amp; Engineering</option>
                                <option>B.Tech Artificial Intelligence &amp; Data Science</option>
                                <option>Bachelor of Pharmacy (B.Pharm)</option>
                                <option>Diploma in Pharmacy (D.Pharm)</option>
                                <option>MBA — Master of Business Administration</option>
                                <option>MCA — Master of Computer Applications</option>
                                <option>B.Sc. Nursing</option>
                                <option>LL.B — Bachelor of Laws</option>
                                <option>B.Sc. (Hons) Agriculture</option>
                                <option>BPT — Bachelor of Physiotherapy</option>
                                <option>Other University Programme</option>
                            </select>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Mail ID *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit mobile number" pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">City</label>
                                <input type="text" name="city" class="form-control py-2" placeholder="Enter your city" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">State</label>
                                <input type="text" name="state" class="form-control py-2" placeholder="Enter your state" maxlength="100">
                            </div>
                        </div>
                        <button type="submit" name="submit_enquiry" class="btn btn-srku px-5 py-2">
                            <i class="fas fa-paper-plane me-1"></i> Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
