<?php
$pageTitle = "Global Alumni Network | 15,000+ Alumni Community | SRKU Bhopal";
$pageDesc = "Join the global alumni community of Sarvepalli Radhakrishnan University (SRKU), Bhopal with 15,000+ graduates leading worldwide in healthcare, technology, corporate and public sectors.";
$pageKeywords = "SRKU Alumni Association, Global Alumni Network Bhopal, RKDF Alumni, University Graduates Portal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';

$regSuccess = false;
$regErr = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_alumni'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $passYear = sanitize($_POST['pass_year'] ?? '');
    $dept = sanitize($_POST['department'] ?? '');
    $company = sanitize($_POST['company'] ?? '');
    $designation = sanitize($_POST['designation'] ?? '');
    
    $msg = "Alumni Registration: Pass Year: $passYear, Dept: $dept, Company: $company, Designation: $designation";
    $res = saveEnquiryLead($name, $email, $phone, 'Alumni Network', $msg, 'Alumni Network Portal');
    if ($res['success']) {
        $regSuccess = true;
    } else {
        $regErr = $res['error'];
    }
}
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('alumni', 'SRKU Global Alumni Network', '15,000+ Alumni Leading Innovations Across Top Global MNCs & Research Centers'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row g-4 g-lg-5">
            
            <!-- Left Info Column -->
            <div class="col-12 col-lg-6">
                <span class="section-subtitle">ALUMNI COMMUNITY</span>
                <h2 class="section-title mb-3">Stay Connected with <span>Your Alma Mater</span></h2>
                <p class="text-dark mb-3" style="line-height:1.8; font-size:0.95rem;">
                    The Sarvepalli Radhakrishnan University Alumni Association brings together thousands of graduates working across diverse sectors globally — from Fortune 500 tech leaders and pharmaceutical scientists to civil servants, doctors, and successful entrepreneurs.
                </p>
                <p class="text-muted mb-4" style="line-height:1.8; font-size:0.93rem;">
                    As an esteemed alumnus, you can mentor current students, participate in annual alumni reunions, deliver guest lectures, and connect with fellow alumni across the world.
                </p>
                
                <div class="bg-light p-4 rounded-4 border">
                    <h4 class="h6 fw-bold text-navy mb-3"><i class="fas fa-handshake text-danger me-2"></i> Alumni Engagement Benefits</h4>
                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small text-muted">
                        <li><i class="fas fa-check text-danger me-2"></i> Access to university digital library &amp; research databases</li>
                        <li><i class="fas fa-check text-danger me-2"></i> Invitations to Annual Alumni Meet &amp; National Convocations</li>
                        <li><i class="fas fa-check text-danger me-2"></i> Networking with corporate recruiters and startup founders</li>
                        <li><i class="fas fa-check text-danger me-2"></i> Mentorship opportunities for graduating batches</li>
                    </ul>
                </div>
            </div>

            <!-- Right Registration Form Column -->
            <div class="col-12 col-lg-6">
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-light">
                    <h3 class="h4 fw-bold text-navy mb-2">Alumni Registration Form</h3>
                    <p class="text-muted small mb-4">Register your latest contact and professional details to stay updated.</p>

                    <?php if ($regSuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> Thank you! Your alumni registration has been submitted successfully.</div>
                    <?php elseif ($regErr): ?>
                        <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-1"></i> <?php echo sanitize($regErr); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>alumni.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-bold mb-1">Full Name *</label>
                            <input type="text" name="name" class="form-control py-2" placeholder="Your Full Name" minlength="2" maxlength="80" pattern="[a-zA-Z\s\.\'-]{2,80}" title="Please enter a valid full name (alphabets only, min 2 characters)" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Email Address *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" title="Please enter a valid email address" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control py-2" placeholder="10-Digit Mobile Number" inputmode="numeric" pattern="[6-9][0-9]{9}" minlength="10" maxlength="10" title="Please enter a valid 10-digit Indian mobile number (starting with 6, 7, 8, or 9)" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Passing Out Year</label>
                                <input type="text" name="pass_year" class="form-control py-2" placeholder="e.g. 2022" inputmode="numeric" pattern="[0-9]{4}" maxlength="4" title="Please enter a valid 4-digit passing year">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Department / Degree</label>
                                <input type="text" name="department" class="form-control py-2" placeholder="e.g. B.Tech CSE / B.Pharm">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Current Organization</label>
                                <input type="text" name="company" class="form-control py-2" placeholder="e.g. TCS / Cipla">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark small fw-bold mb-1">Designation</label>
                                <input type="text" name="designation" class="form-control py-2" placeholder="e.g. Senior Software Engineer">
                            </div>
                        </div>
                        <button type="submit" name="submit_alumni" class="btn btn-srku w-100 py-2 justify-content-center">
                            <i class="fas fa-user-plus me-1"></i> Register as Alumni
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
