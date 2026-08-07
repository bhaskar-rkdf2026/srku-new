<?php
$pageTitle = "Home - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "home";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

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

<!-- HERO BANNER SECTION WITH BACKGROUND VIDEO & FLOATING STAT CARDS -->
<section class="hero-section" style="background-image: url('assets/upload/2026/07/campus-1.webp');">
    <!-- Vimeo Background Video iFrame -->
    <div class="elementor-background-video-container" style="position: absolute; top:0; left:0; width:100%; height:100%; overflow:hidden; z-index:1; pointer-events:none;">
        <iframe src="https://player.vimeo.com/video/1213199411?muted=1&amp;autoplay=1&amp;loop=1&amp;background=1&amp;app_id=122963" 
                style="width: 100vw; height: 56.25vw; min-height: 100%; min-width: 177.77vh; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.8;" 
                frameborder="0" allow="autoplay; fullscreen; picture-in-picture" title="SRKU Hero Video"></iframe>
    </div>

    <div class="hero-overlay"></div>
    
    <div class="hero-container" style="position: relative; z-index: 3;">
        <div>
            <h1 class="hero-title">
                SRK University, Bhopal<br>
                <font color="#c9a24c"><i class="gold-italic">UGC-Recognized<br></i></font>
                University in MP
            </h1>

            <div class="hero-desc">
                <p>Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership. If you are looking for the <strong>best placement university in MP</strong>, our rigorous research, multi-disciplinary collaboration, and industry-aligned pedagogy deliver unmatched career growth.</p>
            </div>

            <div class="hero-btns">
                <a href="#apply" class="btn btn-hero-yellow">Apply Now</a>
                <a href="courses.php" class="btn btn-hero-outline">Explore Programme</a>
            </div>
        </div>

        <!-- FLOATING ABSOLUTE STAT CARDS ON RIGHT (EXACT MATCH TO SCREENSHOT) -->
        <div class="hero-stat-cards">
            <div class="stat-card-light">
                <div class="icon-blue-box">
                    <i class="far fa-keyboard"></i>
                </div>
                <div>
                    <h3 class="stat-num">42+</h3>
                    <p class="stat-lbl">HIGH-TECH LABS</p>
                </div>
            </div>

            <div class="stat-card-dark">
                <div class="icon-maroon-box">
                    <i class="fas fa-bell"></i>
                </div>
                <div>
                    <h3 class="stat-num">94%</h3>
                    <p class="stat-lbl">PLACEMENT RECORD</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS STRIP -->
<div class="stats-strip">
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-val">42+</div>
            <div class="stat-txt">HIGH-TECH LABS</div>
        </div>
        <div class="stat-box">
            <div class="stat-val">94%</div>
            <div class="stat-txt">Placement Record</div>
        </div>
        <div class="stat-box">
            <div class="stat-val">120+</div>
            <div class="stat-txt">Corporate Recruiters</div>
        </div>
        <div class="stat-box">
            <div class="stat-val">15,000+</div>
            <div class="stat-txt">Global Alumni</div>
        </div>
    </div>
</div>

<!-- WELCOME TO SRK UNIVERSITY SECTION -->
<section class="section">
    <div class="container">
        <div class="grid-2" style="align-items: center;">
            <div>
                <span class="section-subtitle">WELCOME TO SRK UNIVERSITY</span>
                <div class="section-header" style="text-align: left; margin-bottom: 20px;">
                    <h2 class="section-title">Empowering Minds, Shaping Futures through <span class="highlight">Academic Excellence</span></h2>
                </div>
                <p style="color: var(--text-dark); margin-bottom: 15px; line-height: 1.8;">
                    Sarvepalli Radhakrishnan University (SRKU), Bhopal is a premier educational institution committed to delivering cutting-edge technical, pharmaceutical, management, and scientific education.
                </p>
                <p style="color: var(--text-muted); margin-bottom: 25px; line-height: 1.8;">
                    Recognized by the University Grants Commission (UGC) under Section 2(f), AICTE, PCI, and statutory councils, SRKU provides an innovative ecosystem blending rigorous research, multidisciplinary collaboration, and industry-aligned pedagogy.
                </p>

                <a href="about.php" class="btn btn-primary">
                    Read More <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div>
                <img src="assets/upload/2026/07/2ZG_1043-scaled.jpg" alt="SRKU Main Campus Building" style="border-radius: var(--radius-md); box-shadow: var(--shadow-lg); border: 4px solid var(--accent-yellow); margin-bottom: 20px;">
                <div class="grid-3" style="text-align: center; gap: 10px;">
                    <div style="background: var(--dark-navy); color: #fff; padding: 12px; border-radius: 6px;">
                        <strong style="color: var(--accent-yellow); font-size: 1.2rem; display: block;">42+</strong>
                        <small style="font-size: 0.75rem;">HIGH-TECH LABS</small>
                    </div>
                    <div style="background: var(--dark-navy); color: #fff; padding: 12px; border-radius: 6px;">
                        <strong style="color: var(--accent-yellow); font-size: 1.2rem; display: block;">94%</strong>
                        <small style="font-size: 0.75rem;">Placement Rate</small>
                    </div>
                    <div style="background: var(--dark-navy); color: #fff; padding: 12px; border-radius: 6px;">
                        <strong style="color: var(--accent-yellow); font-size: 1.2rem; display: block;">2026-27</strong>
                        <small style="font-size: 0.75rem;">LIVE UPDATES</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- EXPLORE PROGRAMMES SECTION -->
<section class="section bg-cream">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
            <div>
                <span class="section-subtitle">ACADEMIC EXCELLENCE</span>
                <div class="section-header" style="text-align: left; margin-bottom: 0;">
                    <h2 class="section-title">Explore Programmes <span>Offered</span></h2>
                </div>
            </div>
            <a href="courses.php" class="btn-card-apply" style="font-size: 0.95rem;">
                View All Programmes <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid-4">
            <div class="prog-card">
                <img src="assets/upload/2026/06/DSC_2491-scaled.jpg" class="prog-img" alt="Engineering">
                <div class="prog-body">
                    <h3 class="prog-title">Department of Engineering</h3>
                    <p class="prog-desc">B.Tech & M.Tech programs in CSE, Mechanical, Civil & Electrical Engineering with AI & IoT specializations.</p>
                    <a href="courses.php?dept=Engineering" class="btn-card-apply">Explore Department &rarr;</a>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0670-scaled.jpg" class="prog-img" alt="Pharmacy">
                <div class="prog-body">
                    <h3 class="prog-title">Sri Sai College of Pharmacy</h3>
                    <p class="prog-desc">PCI & AICTE approved B.Pharm, D.Pharm and M.Pharm programs with modern drug testing labs.</p>
                    <a href="courses.php?dept=Pharmacy" class="btn-card-apply">Explore Department &rarr;</a>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0772-scaled.jpg" class="prog-img" alt="Computer Applications">
                <div class="prog-body">
                    <h3 class="prog-title">Department of Computer Application</h3>
                    <p class="prog-desc">BCA, MCA, and B.Sc Computer Science courses designed for modern software development & cloud computing.</p>
                    <a href="courses.php?dept=Computer" class="btn-card-apply">Explore Department &rarr;</a>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0736-scaled.jpg" class="prog-img" alt="Nursing">
                <div class="prog-body">
                    <h3 class="prog-title">RKDF College of Nursing</h3>
                    <p class="prog-desc">INC & MPNRC recognized B.Sc Nursing, Post Basic Nursing, and GNM programs with hospital clinical training.</p>
                    <a href="courses.php?dept=Nursing" class="btn-card-apply">Explore Department &rarr;</a>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0762-scaled.jpg" class="prog-img" alt="Management">
                <div class="prog-body">
                    <h3 class="prog-title">Department of Management</h3>
                    <p class="prog-desc">MBA, BBA, and Commerce degrees with Dual Specializations in Marketing, HR, Finance & Business Analytics.</p>
                    <a href="courses.php?dept=Management" class="btn-card-apply">Explore Department &rarr;</a>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0696-scaled.jpg" class="prog-img" alt="APJ Kalam Pharmacy">
                <div class="prog-body">
                    <h3 class="prog-title">Dr. APJ Abdul Kalam College of Pharmacy</h3>
                    <p class="prog-desc">Premier pharmaceutical research institute offering state-of-the-art pharmacology & chemistry labs.</p>
                    <a href="courses.php?dept=Pharmacy" class="btn-card-apply">Explore Department &rarr;</a>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0603-scaled.jpg" class="prog-img" alt="Allied Sciences">
                <div class="prog-body">
                    <h3 class="prog-title">Department of Allied Sciences</h3>
                    <p class="prog-desc">B.Sc, M.Sc courses in Biotechnology, Microbiology, Medical Lab Technology (BMLT) & Physics.</p>
                    <a href="courses.php?dept=Allied" class="btn-card-apply">Explore Department &rarr;</a>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0590-scaled.jpg" class="prog-img" alt="SRK College of Pharmacy">
                <div class="prog-body">
                    <h3 class="prog-title">Sarvepalli Radhakrishnan College of Pharmacy</h3>
                    <p class="prog-desc">Center of excellence in pharmaceutical research, drug formulation, and clinical trials training.</p>
                    <a href="courses.php?dept=Pharmacy" class="btn-card-apply">Explore Department &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROMINENT INSTITUTES / FACULTIES -->
<section class="section">
    <div class="container">
        <div class="section-header" style="margin-bottom: 40px;">
            <span class="section-subtitle">CONSTITUENT UNITS</span>
            <h2 class="section-title">Prominent Institutes under <span class="highlight">SRK University</span></h2>
        </div>

        <div class="grid-4">
            <div class="faculty-card">
                <div class="faculty-icon"><i class="fas fa-cogs"></i></div>
                <div class="faculty-info">
                    <h4>Faculty of Engineering</h4>
                </div>
            </div>

            <div class="faculty-card">
                <div class="faculty-icon"><i class="fas fa-pills"></i></div>
                <div class="faculty-info">
                    <h4>Faculty of Pharmacy</h4>
                </div>
            </div>

            <div class="faculty-card">
                <div class="faculty-icon"><i class="fas fa-laptop-code"></i></div>
                <div class="faculty-info">
                    <h4>Computer Applications</h4>
                </div>
            </div>

            <div class="faculty-card">
                <div class="faculty-icon"><i class="fas fa-user-md"></i></div>
                <div class="faculty-info">
                    <h4>Faculty of Nursing</h4>
                </div>
            </div>

            <div class="faculty-card">
                <div class="faculty-icon"><i class="fas fa-chart-bar"></i></div>
                <div class="faculty-info">
                    <h4>Business Management</h4>
                </div>
            </div>

            <div class="faculty-card">
                <div class="faculty-icon"><i class="fas fa-atom"></i></div>
                <div class="faculty-info">
                    <h4>Allied Sciences</h4>
                </div>
            </div>

            <div class="faculty-card">
                <div class="faculty-icon"><i class="fas fa-flask"></i></div>
                <div class="faculty-info">
                    <h4>R.N. Kapoor Institute</h4>
                </div>
            </div>

            <div class="faculty-card">
                <div class="faculty-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="faculty-info">
                    <h4>Dr. APJ Kalam College</h4>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CHANCELLOR & LEADERSHIP SECTION -->
<section class="chancellor-banner">
    <div class="chancellor-grid">
        <div>
            <img src="assets/upload/2026/06/DSC_3756-scaled.jpg" class="chancellor-photo" alt="Chancellor SRK University">
        </div>
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 2.2rem; font-weight: 800; margin-bottom: 8px;">Message From Chancellor Desk</h3>
            <div style="color: var(--accent-yellow); font-weight: 700; font-size: 1rem; margin-bottom: 20px; text-transform: uppercase;">Leadership & Governance</div>
            <p style="font-size: 1.05rem; line-height: 1.8; color: #f1f5f9; font-style: italic; margin-bottom: 25px; border-left: 4px solid var(--accent-yellow); padding-left: 20px;">
                "At Sarvepalli Radhakrishnan University, our mission is to foster an academic environment that cultivates critical thinking, research innovation, and professional integrity. We empower our students to become technology leaders, entrepreneurs, and responsible global citizens."
            </p>
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="about.php#board" class="btn btn-hero-yellow"><i class="fas fa-user-tie"></i> Read Full Message</a>
                <a href="page.php?slug=vision-mission" class="btn btn-hero-outline"><i class="fas fa-bullseye"></i> Vision & Mission</a>
            </div>
        </div>
    </div>
</section>

<!-- WORLD-CLASS FACILITIES SECTION -->
<section class="section bg-light">
    <div class="container">
        <div class="section-header" style="margin-bottom: 40px;">
            <span class="section-subtitle">CAMPUS LIFE & INFRASTRUCTURE</span>
            <h2 class="section-title">World-Class Campus <span class="highlight">Facilities</span></h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 8px;">Equipped with state-of-the-art infrastructure for learning, living, and innovating.</p>
        </div>

        <div class="grid-3">
            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0778-scaled.jpg" class="prog-img" alt="Central Library">
                <div class="prog-body">
                    <h3 class="prog-title">Central Digital Library</h3>
                    <p class="prog-desc">Vast collection of over 50,000 books, international research journals, e-books, and 24/7 digital resource access.</p>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0670-scaled.jpg" class="prog-img" alt="Advanced Research Labs">
                <div class="prog-body">
                    <h3 class="prog-title">42+ Advanced Research Labs</h3>
                    <p class="prog-desc">High-performance computing centers, Robotics labs, Pharmaceutics testing equipment, and AI innovation units.</p>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0736-scaled.jpg" class="prog-img" alt="Lecture Theatres">
                <div class="prog-body">
                    <h3 class="prog-title">Air-Conditioned Auditoriums</h3>
                    <p class="prog-desc">Smart audio-visual lecture halls and auditoriums hosting national seminars, workshops, and guest lectures.</p>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0696-scaled.jpg" class="prog-img" alt="Sports Complex">
                <div class="prog-body">
                    <h3 class="prog-title">Sports Complex & Gymnasium</h3>
                    <p class="prog-desc">Cricket stadium, basketball courts, indoor badminton arenas, and modern fitness gym for student athletics.</p>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/DSC06304-scaled.jpg" class="prog-img" alt="Hostel & Dining">
                <div class="prog-body">
                    <h3 class="prog-title">Hostels & Hygienic Dining</h3>
                    <p class="prog-desc">Separate secured hostels for boys & girls with Wi-Fi, 24/7 security, medical support, and nutritious mess food.</p>
                </div>
            </div>

            <div class="prog-card">
                <img src="assets/upload/2026/06/TZ3_0603-scaled.jpg" class="prog-img" alt="Medical Facilities">
                <div class="prog-body">
                    <h3 class="prog-title">Medical & Healthcare Center</h3>
                    <p class="prog-desc">On-campus 100-bed hospital providing round-the-clock emergency care, pharmacy, and health check-ups.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PLACEMENT & RECRUITER HIGHLIGHTS -->
<section class="section">
    <div class="container">
        <div class="grid-2" style="align-items: center; margin-bottom: 40px;">
            <div>
                <span class="section-subtitle">CAREER & PLACEMENT CELL</span>
                <div class="section-header" style="text-align: left; margin-bottom: 20px;">
                    <h2 class="section-title">Unmatched Placement <span class="highlight">Track Record</span></h2>
                </div>
                <p style="color: var(--text-dark); margin-bottom: 15px; line-height: 1.8;">
                    Our dedicated Corporate Relations Cell conducts year-round campus recruitment drives, soft skills training, mock interviews, and industry internships.
                </p>
                <div class="recruiter-marquee">
                    <div class="recruiter-item">TCS</div>
                    <div class="recruiter-item">Infosys</div>
                    <div class="recruiter-item">Amazon</div>
                    <div class="recruiter-item">Wipro</div>
                    <div class="recruiter-item">Cognizant</div>
                </div>
            </div>

            <div>
                <img src="assets/upload/2026/06/TZ3_0590-scaled.jpg" alt="Campus Placement Ceremony" style="border-radius: var(--radius-md); border: 4px solid var(--primary-maroon); box-shadow: var(--shadow-lg);">
            </div>
        </div>
    </div>
</section>

<!-- ADMISSION QUERY FORM SECTION -->
<section class="section bg-cream" id="apply">
    <div class="container">
        <div style="max-width: 750px; margin: 0 auto; background: #ffffff; padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); border: 1px solid var(--border-color);">
            <div class="section-header" style="margin-bottom: 25px;">
                <span class="section-subtitle">ADMISSION SESSION 2026-27</span>
                <h2 class="section-title">Apply For <span class="highlight">Admissions 2026</span></h2>
                <p style="color: var(--text-muted); font-size: 0.92rem; margin-top: 6px;">Fill out your details below and our counselor will call you within 24 hours.</p>
            </div>

            <?php if ($enquirySuccess): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Thank you! Your enquiry has been submitted successfully. Our admission team will contact you shortly.
                </div>
            <?php elseif ($enquiryErr): ?>
                <div class="alert alert-danger"><?php echo sanitize($enquiryErr); ?></div>
            <?php endif; ?>

            <form action="#apply" method="POST">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                </div>
                <div class="grid-2" style="gap: 20px;">
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
                <button type="submit" name="submit_enquiry" class="btn btn-hero-yellow" style="width: 100%; justify-content: center; font-size: 1rem;">
                    <i class="fas fa-paper-plane"></i> Submit Admission Enquiry
                </button>
            </form>
        </div>
    </div>
</section>

<!-- CTA BANNER -->
<section class="cta-banner" style="background: linear-gradient(135deg, var(--dark-navy), var(--dark-blue)); color: #ffffff; padding: 60px 20px; text-align: center;">
    <div class="container">
        <h2 style="font-family: var(--font-heading); font-size: 2.4rem; font-weight: 800; margin-bottom: 12px;">Admissions Open for Session 2026-27</h2>
        <p style="font-size: 1.1rem; color: #cbd5e1; margin-bottom: 25px;">Take the first step towards a rewarding global career with SRK University Bhopal.</p>
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="#apply" class="btn btn-hero-yellow"><i class="fas fa-edit"></i> Apply Now</a>
            <a href="tel:07554911204" class="btn btn-hero-outline"><i class="fas fa-phone-alt"></i> Call Helpline</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
