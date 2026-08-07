<?php
$pageTitle = "Contact Us - SRK University";
$activeNav = "contact";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$selectedCourse = sanitize($_GET['course'] ?? '');

$enquirySuccess = false;
$enquiryErr = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $course = sanitize($_POST['course'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if ($name && $email && $phone) {
        try {
            $stmt = $pdo->prepare("INSERT INTO enquiries (name, email, phone, course, message) VALUES (:n, :e, :p, :c, :m)");
            $stmt->execute([
                ':n' => $name,
                ':e' => $email,
                ':p' => $phone,
                ':c' => $course,
                ':m' => $message
            ]);
            $enquirySuccess = true;
        } catch (Exception $ex) {
            $enquiryErr = "Failed to submit enquiry. Please try again.";
        }
    } else {
        $enquiryErr = "Please fill in all mandatory fields.";
    }
}
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <h1 class="fw-bold display-5 mb-2">Contact &amp; Admission Helpline</h1>
        <p class="text-warning fw-semibold lead mb-0">We are here to answer your academic queries 24/7</p>
    </div>
</div>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row g-4 g-lg-5">
            
            <!-- Contact Info -->
            <div class="col-12 col-lg-5">
                <h2 class="text-maroon fw-bold mb-4">Get In Touch</h2>
                
                <div class="d-flex gap-3 align-items-start mb-4">
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:48px; height:48px; font-size:1.2rem;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="h6 text-navy fw-bold mb-1">Campus Address</h4>
                        <p class="text-muted small mb-0"><?php echo getSetting('address'); ?></p>
                    </div>
                </div>

                <div class="d-flex gap-3 align-items-start mb-4">
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:48px; height:48px; font-size:1.2rem;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <h4 class="h6 text-navy fw-bold mb-1">Helpline Numbers</h4>
                        <p class="text-muted small mb-0"><?php echo getSetting('helpline'); ?></p>
                    </div>
                </div>

                <div class="d-flex gap-3 align-items-start mb-4">
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:48px; height:48px; font-size:1.2rem;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 class="h6 text-navy fw-bold mb-1">Email Communications</h4>
                        <p class="text-muted small mb-0"><?php echo getSetting('email'); ?></p>
                    </div>
                </div>

                <div class="bg-light p-4 rounded-4 border mt-4">
                    <h4 class="h6 text-navy fw-bold mb-2">Admission Office Hours</h4>
                    <p class="text-muted small mb-1">Monday - Saturday: 9:00 AM to 5:30 PM</p>
                    <p class="text-muted small mb-0">Sunday: Closed (Online Enquiries Open)</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-12 col-lg-7" id="apply">
                <div class="card p-4 p-md-5 border-0 shadow rounded-4">
                    <h3 class="h4 text-navy fw-bold mb-4">Send Admission Query</h3>

                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> Enquiry submitted successfully! Our team will contact you shortly.</div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger"><?php echo sanitize($enquiryErr); ?></div>
                    <?php endif; ?>

                    <form action="contact.php#apply" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Your Full Name *</label>
                            <input type="text" name="name" class="form-control py-2" placeholder="John Doe" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Email Address *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="john@example.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit Mobile Number" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Course Interested In</label>
                            <input type="text" name="course" class="form-control py-2" value="<?php echo sanitize($selectedCourse); ?>" placeholder="e.g. B.Tech CSE / B.Pharm">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Your Message / Question</label>
                            <textarea name="message" class="form-control py-2" rows="4" placeholder="Enter your detailed query..."></textarea>
                        </div>
                        <button type="submit" name="submit_contact" class="btn btn-srku w-100 py-2 justify-content-center">
                            <i class="fas fa-paper-plane me-1"></i> Send Enquiry Now
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
