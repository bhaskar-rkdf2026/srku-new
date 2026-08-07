<?php
$pageTitle = "Home";
$activeNav = "home";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

// Fetch Banners
$banners = [];
try {
    $stmt = $pdo->query("SELECT * FROM banners ORDER BY sort_order ASC, id DESC");
    $banners = $stmt->fetchAll();
} catch (Exception $e) {}

// Fetch News
$newsList = [];
try {
    $stmt = $pdo->query("SELECT * FROM news ORDER BY id DESC LIMIT 4");
    $newsList = $stmt->fetchAll();
} catch (Exception $e) {}

// Fetch Courses summary
$coursesList = [];
try {
    $stmt = $pdo->query("SELECT * FROM courses WHERE status = 'active' LIMIT 6");
    $coursesList = $stmt->fetchAll();
} catch (Exception $e) {}

// Handle Form Submission for Enquiry
$enquirySuccess = false;
$enquiryErr = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_enquiry'])) {
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
            $enquiryErr = "Submission failed. Please try again.";
        }
    } else {
        $enquiryErr = "Please fill in all required fields.";
    }
}
?>

<!-- HERO BANNER SECTION -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-container">
        <div class="hero-text">
            <span style="background: rgba(212, 175, 55, 0.2); color: var(--accent-gold); padding: 6px 16px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; display: inline-block; margin-bottom: 15px; border: 1px solid var(--accent-gold);">
                <i class="fas fa-university"></i> UGC RECOGNIZED UNIVERSITY IN MP
            </span>
            <h2>Empowering Minds, <span>Transforming Futures</span></h2>
            <p>Welcome to Sarvepalli Radhakrishnan University (SRKU), a premier technical and academic ecosystem designed for global industry leadership and research excellence.</p>
            <div class="hero-btns">
                <a href="#apply" class="btn-primary"><i class="fas fa-graduation-cap"></i> Apply Now 2026-27</a>
                <a href="courses.php" class="btn-secondary"><i class="fas fa-book-open"></i> Explore Programmes</a>
            </div>
        </div>

        <div class="hero-stats-card">
            <div class="stat-item">
                <div class="stat-number" data-target="42" data-suffix="+">0</div>
                <div class="stat-label">High-Tech Labs</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="94" data-suffix="%">0</div>
                <div class="stat-label">Placement Record</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="120" data-suffix="+">0</div>
                <div class="stat-label">Recruiting Partners</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="15" data-suffix="K+">0</div>
                <div class="stat-label">Global Alumni</div>
            </div>
        </div>
    </div>
</section>

<!-- WHY CHOOSE SRKU SECTION -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Why SRK University?</h2>
            <p>A benchmark of quality higher education and multidisciplinary research</p>
        </div>

        <div class="grid-3">
            <div class="card">
                <div class="card-icon"><i class="fas fa-microscope"></i></div>
                <h3 class="card-title">Advanced Research & Innovation</h3>
                <p class="card-text">State-of-the-art incubation centers, high-performance computing labs, and industry-sponsored research projects driving practical learning.</p>
                <a href="page.php?slug=why-srk" style="color: var(--primary-maroon); font-weight: 700;">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="card">
                <div class="card-icon"><i class="fas fa-briefcase"></i></div>
                <h3 class="card-title">Unmatched Placement Track Record</h3>
                <p class="card-text">Dedicated Corporate Relations Cell organizing continuous recruitment drives with Fortune 500 companies and leading Indian conglomerates.</p>
                <a href="courses.php" style="color: var(--primary-maroon); font-weight: 700;">View Recruiters <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="card">
                <div class="card-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h3 class="card-title">World-Class Faculty</h3>
                <p class="card-text">Learn from distinguished professors, PhD scholars, and industry mentors committed to academic excellence and personal growth.</p>
                <a href="about.php" style="color: var(--primary-maroon); font-weight: 700;">Faculty Directory <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- CHANCELLOR & LEADERSHIP SECTION -->
<section class="section bg-light">
    <div class="container">
        <div class="leadership-grid">
            <div class="leader-image">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="leader-info">
                <h3>Message From Leadership</h3>
                <div class="designation">Chancellor's Desk & Governance</div>
                <p>
                    "At Sarvepalli Radhakrishnan University, our mission is to foster an academic environment that cultivates critical thinking, innovation, and professional integrity. We empower our students to become technology leaders, entrepreneurs, and responsible global citizens."
                </p>
                <div style="margin-top: 25px; display: flex; gap: 15px;">
                    <a href="about.php#board" class="btn-primary" style="padding: 10px 20px; font-size: 0.9rem;">Read Full Message</a>
                    <a href="page.php?slug=vision-mission" class="btn-secondary" style="padding: 10px 20px; font-size: 0.9rem; color: var(--dark-navy); border-color: var(--border-color);">Vision & Mission</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- POPULAR DEPARTMENTS & COURSES -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Academic Departments & Programmes</h2>
            <p>Explore industry-aligned undergraduate, postgraduate & doctorate degrees</p>
        </div>

        <div class="grid-3">
            <?php if (!empty($coursesList)): ?>
                <?php foreach ($coursesList as $c): ?>
                    <div class="card">
                        <span style="font-size: 0.75rem; background: rgba(128,0,0,0.1); color: var(--primary-maroon); padding: 4px 10px; border-radius: 12px; font-weight: 700; width: fit-content; margin-bottom: 12px;">
                            <?php echo sanitize($c['department']); ?>
                        </span>
                        <h3 class="card-title"><?php echo sanitize($c['course_name']); ?></h3>
                        <p class="card-text">
                            <strong>Duration:</strong> <?php echo sanitize($c['duration']); ?><br>
                            <strong>Eligibility:</strong> <?php echo sanitize($c['eligibility']); ?><br>
                            <strong>Annual Fee:</strong> <?php echo sanitize($c['fees']); ?>
                        </p>
                        <a href="contact.php?course=<?php echo urlencode($c['course_name']); ?>" class="btn-primary" style="text-align: center; font-size: 0.85rem; padding: 10px;">Enquire / Apply Now</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card">
                    <h3 class="card-title">Department of Engineering</h3>
                    <p class="card-text">B.Tech, M.Tech & Diploma in CSE, Mechanical, Civil, Electrical Engineering.</p>
                    <a href="courses.php" class="btn-primary" style="text-align: center;">View Courses</a>
                </div>
                <div class="card">
                    <h3 class="card-title">Faculty of Pharmacy</h3>
                    <p class="card-text">PCI & AICTE approved B.Pharm, D.Pharm & M.Pharm programs.</p>
                    <a href="courses.php" class="btn-primary" style="text-align: center;">View Courses</a>
                </div>
                <div class="card">
                    <h3 class="card-title">Computer Applications</h3>
                    <p class="card-text">BCA, MCA, B.Sc Computer Science with cloud computing & AI Specializations.</p>
                    <a href="courses.php" class="btn-primary" style="text-align: center;">View Courses</a>
                </div>
            <?php endif; ?>
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="courses.php" class="btn-secondary" style="color: var(--dark-navy); border-color: var(--border-color); font-weight: 700;">
                <i class="fas fa-th-list"></i> View All Offered Programmes
            </a>
        </div>
    </div>
</section>

<!-- NEWS & ANNOUNCEMENTS -->
<section class="section bg-light">
    <div class="container">
        <div class="section-title">
            <h2>Campus News & Circulars</h2>
            <p>Latest announcements, upcoming seminars, and examination notices</p>
        </div>

        <div class="grid-4">
            <?php if (!empty($newsList)): ?>
                <?php foreach ($newsList as $n): ?>
                    <div class="card">
                        <span style="font-size: 0.75rem; color: var(--accent-gold); background: var(--dark-navy); padding: 3px 8px; border-radius: 4px; font-weight: 700; width: fit-content; margin-bottom: 10px;">
                            <?php echo sanitize($n['category']); ?>
                        </span>
                        <h4 style="font-family: var(--font-heading); font-size: 1.1rem; margin-bottom: 10px; color: var(--dark-navy);"><?php echo sanitize($n['title']); ?></h4>
                        <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 15px;">
                            <?php echo sanitize(substr($n['content'], 0, 100)) . '...'; ?>
                        </p>
                        <small style="color: #94a3b8; font-weight: 600;"><i class="far fa-calendar-alt"></i> <?php echo sanitize($n['publish_date'] ?? date('Y-m-d')); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card">
                    <span style="font-size: 0.75rem; color: var(--accent-gold); background: var(--dark-navy); padding: 3px 8px; border-radius: 4px; font-weight: 700; width: fit-content; margin-bottom: 10px;">Admission</span>
                    <h4 style="font-family: var(--font-heading); font-size: 1.1rem; margin-bottom: 10px;">Admissions Open 2026-27</h4>
                    <p style="font-size: 0.88rem; color: var(--text-muted);">Applications invited for all engineering, medical, management & nursing programs.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ADMISSION QUERY FORM SECTION -->
<section class="section" id="apply">
    <div class="container">
        <div style="max-width: 700px; margin: 0 auto; background: #ffffff; padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); border: 1px solid var(--border-color);">
            <h3 style="font-family: var(--font-heading); text-align: center; color: var(--primary-maroon); font-size: 1.8rem; margin-bottom: 10px;">Admission Enquiry Form 2026</h3>
            <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">Fill out your details and our admission counselor will get in touch with you shortly.</p>

            <?php if ($enquirySuccess): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Thank you for your enquiry! Our admissions team will call you back within 24 hours.
                </div>
            <?php elseif ($enquiryErr): ?>
                <div class="alert alert-danger"><?php echo sanitize($enquiryErr); ?></div>
            <?php endif; ?>

            <form action="#apply" method="POST">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" class="form-control" placeholder="yourname@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile number" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Interested Course / Discipline</label>
                    <select name="course" class="form-control">
                        <option value="">-- Select Course --</option>
                        <option value="B.Tech Computer Science">B.Tech Computer Science</option>
                        <option value="Bachelor of Pharmacy (B.Pharm)">Bachelor of Pharmacy (B.Pharm)</option>
                        <option value="Master of Business Administration (MBA)">Master of Business Administration (MBA)</option>
                        <option value="Master of Computer Applications (MCA)">Master of Computer Applications (MCA)</option>
                        <option value="B.Sc Nursing">B.Sc Nursing</option>
                        <option value="Other">Other Programme</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Your Message / Query</label>
                    <textarea name="message" class="form-control" rows="3" placeholder="Specify your qualification or query"></textarea>
                </div>
                <button type="submit" name="submit_enquiry" class="btn-primary" style="width: 100%; border: none; cursor: pointer; font-size: 1rem;">
                    <i class="fas fa-paper-plane"></i> Submit Enquiry
                </button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
