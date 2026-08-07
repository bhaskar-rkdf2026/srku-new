<?php
$pageTitle = "Contact Us";
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

<div style="background: linear-gradient(135deg, var(--dark-navy), var(--primary-maroon)); color: #ffffff; padding: 60px 20px; text-align: center;">
    <div class="container">
        <h1 style="font-family: var(--font-heading); font-size: 2.8rem; font-weight: 800;">Contact & Admission Helpline</h1>
        <p style="color: var(--accent-gold); font-size: 1.1rem; font-weight: 600; margin-top: 10px;">We are here to answer your academic queries 24/7</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 40px;">
            <div>
                <h2 style="font-family: var(--font-heading); color: var(--primary-maroon); font-size: 1.8rem; margin-bottom: 25px;">Get In Touch</h2>
                
                <div style="margin-bottom: 25px; display: flex; gap: 15px; align-items: flex-start;">
                    <div style="width: 48px; height: 48px; background: rgba(128,0,0,0.1); color: var(--primary-maroon); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 style="color: var(--dark-navy); font-weight: 700;">Campus Address</h4>
                        <p style="color: var(--text-muted); font-size: 0.95rem;"><?php echo getSetting('address'); ?></p>
                    </div>
                </div>

                <div style="margin-bottom: 25px; display: flex; gap: 15px; align-items: flex-start;">
                    <div style="width: 48px; height: 48px; background: rgba(128,0,0,0.1); color: var(--primary-maroon); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <h4 style="color: var(--dark-navy); font-weight: 700;">Helpline Numbers</h4>
                        <p style="color: var(--text-muted); font-size: 0.95rem;"><?php echo getSetting('helpline'); ?></p>
                    </div>
                </div>

                <div style="margin-bottom: 25px; display: flex; gap: 15px; align-items: flex-start;">
                    <div style="width: 48px; height: 48px; background: rgba(128,0,0,0.1); color: var(--primary-maroon); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 style="color: var(--dark-navy); font-weight: 700;">Email Communications</h4>
                        <p style="color: var(--text-muted); font-size: 0.95rem;"><?php echo getSetting('email'); ?></p>
                    </div>
                </div>

                <div style="background: var(--light-bg); padding: 25px; border-radius: var(--radius-md); border: 1px solid var(--border-color); margin-top: 30px;">
                    <h4 style="color: var(--dark-navy); font-weight: 700; margin-bottom: 8px;">Admission Office Hours</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Monday - Saturday: 9:00 AM to 5:30 PM</p>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Sunday: Closed (Online Enquiries Open)</p>
                </div>
            </div>

            <div style="background: #ffffff; padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); border: 1px solid var(--border-color);" id="apply">
                <h3 style="font-family: var(--font-heading); color: var(--dark-navy); font-size: 1.6rem; margin-bottom: 20px;">Send Admission Query</h3>

                <?php if ($enquirySuccess): ?>
                    <div class="alert alert-success"><i class="fas fa-check-circle"></i> Enquiry submitted successfully! Our team will contact you shortly.</div>
                <?php elseif ($enquiryErr): ?>
                    <div class="alert alert-danger"><?php echo sanitize($enquiryErr); ?></div>
                <?php endif; ?>

                <form action="contact.php#apply" method="POST">
                    <div class="form-group">
                        <label>Your Full Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="10-digit Mobile Number" required>
                    </div>
                    <div class="form-group">
                        <label>Course Interested In</label>
                        <input type="text" name="course" class="form-control" value="<?php echo sanitize($selectedCourse); ?>" placeholder="e.g. B.Tech CSE / B.Pharm">
                    </div>
                    <div class="form-group">
                        <label>Your Message / Question</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Enter your detailed query..."></textarea>
                    </div>
                    <button type="submit" name="submit_contact" class="btn-primary" style="width: 100%; border: none; cursor: pointer;">
                        <i class="fas fa-paper-plane"></i> Send Enquiry Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
