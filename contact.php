<?php
$pageTitle = "Contact Us & Admission Helpline - SRK University Bhopal";
$activeNav = "contact";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$selectedCourse = sanitize($_GET['course'] ?? '');

$enquirySuccess = false;
$enquiryErr = '';
$enquiryMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['course'] ?? '',
        $_POST['message'] ?? '',
        'Contact & Admissions Page'
    );
    if ($res['success']) {
        $enquirySuccess = true;
        $enquiryMsg = $res['message'];
    } else {
        $enquiryErr = $res['error'];
    }
}

$address = getSetting('address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026');
$helpline = getSetting('helpline', '0755 - 4911204');
$email = getSetting('email', 'exam@srku.edu.in');
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('contact', 'Contact & Admission Office', 'We are here to assist you with admissions, examinations & campus queries'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row g-4 g-lg-5">
            
            <!-- Contact Info Column -->
            <div class="col-12 col-lg-5">
                <span class="section-subtitle">CAMPUS CONNECT</span>
                <h2 class="section-title mb-4">Get in Touch with <span>SRKU</span></h2>
                
                <div class="d-flex gap-3 align-items-start mb-4">
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px; height:50px; font-size:1.3rem;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="h6 text-navy fw-bold mb-1">Campus Address</h4>
                        <p class="text-muted small mb-2"><?php echo sanitize($address); ?></p>
                        <a href="https://maps.app.goo.gl/9YWMY8vVN6PpJBBz8" target="_blank" class="btn btn-sm btn-outline-danger fw-semibold d-inline-flex align-items-center gap-1 rounded-pill px-3 py-1">
                            <i class="fas fa-directions text-danger"></i> <span>Get Directions on Google Maps ↗</span>
                        </a>
                    </div>
                </div>

                <div class="d-flex gap-3 align-items-start mb-4">
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px; height:50px; font-size:1.3rem;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <h4 class="h6 text-navy fw-bold mb-1">University Helpline</h4>
                        <p class="text-muted small mb-0"><?php echo sanitize($helpline); ?></p>
                    </div>
                </div>

                <div class="d-flex gap-3 align-items-start mb-4">
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px; height:50px; font-size:1.3rem;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 class="h6 text-navy fw-bold mb-1">Official Email</h4>
                        <p class="text-muted small mb-0"><?php echo sanitize($email); ?></p>
                    </div>
                </div>

                <div class="bg-light p-4 rounded-4 border">
                    <h5 class="h6 text-navy fw-bold mb-3"><i class="far fa-clock text-danger me-2"></i> Admission Office Hours</h5>
                    <p class="text-muted small mb-1"><strong>Monday - Saturday:</strong> 9:00 AM to 5:30 PM</p>
                    <p class="text-muted small mb-0"><strong>Sunday:</strong> Closed (Online Form Open 24/7)</p>
                </div>
            </div>

            <!-- Contact Form Column -->
            <div class="col-12 col-lg-7" id="apply">
                <div class="card p-4 p-md-5 border-0 shadow rounded-4">
                    <h3 class="h4 text-navy fw-bold mb-2">Send Admission Query</h3>
                    <p class="text-muted small mb-4">Our senior counselor will get in touch with you shortly.</p>

                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> Enquiry submitted successfully! Our counseling team will contact you shortly.</div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger"><?php echo sanitize($enquiryErr); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>contact.php#apply" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Full Name *</label>
                            <input type="text" name="name" class="form-control py-2" placeholder="Enter your full name" minlength="2" maxlength="80" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Email Address *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit Mobile Number" pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Course / Faculty Interested In</label>
                            <input type="text" name="course" class="form-control py-2" value="<?php echo sanitize($selectedCourse); ?>" placeholder="e.g. B.Tech Computer Science / B.Pharm / MBA / Nursing">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Your Message / Query</label>
                            <textarea name="message" class="form-control py-2" rows="4" placeholder="Enter your query regarding eligibility, fees, or admission..."></textarea>
                        </div>
                        <button type="submit" name="submit_contact" class="btn btn-srku w-100 py-2 justify-content-center">
                            <i class="fas fa-paper-plane me-1"></i> Submit Enquiry Now
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Google Maps Interactive Campus Location Section -->
<section class="py-0 position-relative">
    <div class="position-absolute top-0 start-50 translate-middle-x mt-3 z-3 bg-white shadow-lg rounded-pill px-4 py-2 d-none d-md-flex align-items-center gap-3 border">
        <span class="small fw-bold text-navy"><i class="fas fa-map-marker-alt text-danger me-1"></i> Sarvepalli Radhakrishnan University, Bhopal</span>
        <a href="https://maps.app.goo.gl/9YWMY8vVN6PpJBBz8" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
            <i class="fas fa-location-arrow me-1"></i> Open Google Maps App ↗
        </a>
    </div>
    <iframe src="https://maps.google.com/maps?q=23.1677811,77.4663127&hl=en&z=16&output=embed" 
            width="100%" height="450" style="border:0; display:block;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade" loading="lazy"></iframe>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
