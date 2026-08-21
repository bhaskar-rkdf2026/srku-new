<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? 'b-tech-computer-science');
$course = getCourseBySlug($slug);

if (!$course) {
    // If not found by slug, fallback to first course
    $courses = getCourses(null, null, null, 1);
    if (!empty($courses)) {
        $course = $courses[0];
    } else {
        header("Location: " . BASE_URL . "courses.php");
        exit;
    }
}

$pageTitle = $course['course_name'] . " - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';

$relatedCourses = getCourses($course['dept_slug'] ?: $course['department'], null, null, 4);
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <div class="d-inline-flex align-items-center gap-2 mb-2">
            <span class="badge bg-warning text-dark px-3 py-1 fw-bold"><?php echo sanitize($course['level']); ?> Programme</span>
            <span class="badge bg-white bg-opacity-25 text-white px-3 py-1"><?php echo sanitize($course['department']); ?></span>
        </div>
        <h1 class="fw-bold display-5 mb-2"><?php echo sanitize($course['course_name']); ?></h1>
        <p class="text-warning fw-semibold lead mb-0">Industry-Aligned Curriculum &bull; 94% Placement Record</p>
    </div>
</div>

<!-- Breadcrumb Bar -->
<div class="bg-light py-2 border-bottom">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>courses.php" class="text-decoration-none text-muted">Courses</a></li>
                <li class="breadcrumb-item active text-danger fw-semibold" aria-current="page"><?php echo sanitize($course['course_name']); ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row g-4 g-lg-5">
            
            <!-- Left Main Column -->
            <div class="col-12 col-lg-8">
                
                <!-- Quick KPI Bar -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-light">
                    <div class="row row-cols-2 row-cols-md-4 g-3 text-center">
                        <div class="col">
                            <div class="small text-muted mb-1"><i class="far fa-clock text-danger me-1"></i> Duration</div>
                            <div class="fw-bold text-navy fs-6"><?php echo sanitize($course['duration']); ?></div>
                        </div>
                        <div class="col">
                            <div class="small text-muted mb-1"><i class="fas fa-graduation-cap text-danger me-1"></i> Degree Level</div>
                            <div class="fw-bold text-navy fs-6"><?php echo sanitize($course['level']); ?></div>
                        </div>
                        <div class="col">
                            <div class="small text-muted mb-1"><i class="fas fa-rupee-sign text-danger me-1"></i> Academic Fee</div>
                            <div class="fw-bold text-danger fs-6"><?php echo sanitize($course['fees'] ?: 'As per Norms'); ?></div>
                        </div>
                        <div class="col">
                            <div class="small text-muted mb-1"><i class="fas fa-shield-alt text-danger me-1"></i> Approvals</div>
                            <div class="fw-bold text-navy fs-6">UGC / AICTE / PCI</div>
                        </div>
                    </div>
                </div>

                <!-- Programme Overview -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4">
                    <h2 class="text-maroon fw-bold mb-3">Degree Overview &amp; Objective</h2>
                    <p class="text-dark" style="line-height:1.85; font-size:0.98rem;">
                        <?php echo nl2br(sanitize($course['description'] ?: 'The ' . $course['course_name'] . ' at Sarvepalli Radhakrishnan University is designed in close consultation with industry stalwarts, focusing on theoretical foundations, cutting-edge practical training, and multi-disciplinary research.')); ?>
                    </p>
                    <p class="text-muted" style="line-height:1.85; font-size:0.95rem;">
                        Students benefit from continuous hands-on laboratory sessions, industrial internships, live capstone projects, and mentorship from highly qualified faculty members.
                    </p>
                </div>

                <!-- Eligibility Criteria -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4">
                    <h3 class="text-navy fw-bold mb-3"><i class="fas fa-check-circle text-danger me-2"></i> Eligibility &amp; Admission Criteria</h3>
                    <div class="p-3 bg-light rounded-3 border-start border-4 border-danger mb-3">
                        <p class="mb-0 text-dark fw-semibold" style="line-height:1.7;">
                            <?php echo sanitize($course['eligibility']); ?>
                        </p>
                    </div>
                    <ul class="text-muted small d-flex flex-column gap-2 mb-0" style="line-height:1.7;">
                        <li>Reservation and relaxation for SC/ST/OBC and PwD candidates as per Madhya Pradesh State Government &amp; UGC guidelines.</li>
                        <li>Direct admission available through university merit assessment and counseling rounds.</li>
                        <li>Scholarship support applicable under AICTE Pragati, Post-Matric, and university merit schemes.</li>
                    </ul>
                </div>

                <!-- Career Opportunities & Scope -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4">
                    <h3 class="text-navy fw-bold mb-3"><i class="fas fa-briefcase text-danger me-2"></i> Career Scope &amp; Job Roles</h3>
                    <p class="text-dark" style="line-height:1.8;">
                        Graduates of <strong><?php echo sanitize($course['course_name']); ?></strong> possess high demand across national and multinational corporations:
                    </p>
                    <div class="p-3 bg-danger-subtle rounded-3 text-danger fw-semibold mb-3">
                        <?php echo sanitize($course['career_scope'] ?: 'Software Specialist, R&D Associate, Project Lead, Industry Consultant'); ?>
                    </div>
                    <p class="text-muted small mb-0">
                        Our Training &amp; Placement Cell conducts dedicated campus recruitment drives with companies offering packages up to <strong>12 LPA</strong>.
                    </p>
                </div>

                <!-- Syllabus CTA -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-light d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h4 class="h5 fw-bold text-navy mb-1">Curriculum &amp; Scheme of Examination</h4>
                        <p class="text-muted small mb-0">Download semester-wise syllabus, examination scheme, and course structure.</p>
                    </div>
                    <a href="<?php echo BASE_URL; ?>syllabus.php" class="btn btn-outline-danger btn-sm text-nowrap">
                        <i class="fas fa-file-pdf me-1"></i> View Syllabus
                    </a>
                </div>

            </div>

            <!-- Right Sidebar Column -->
            <div class="col-12 col-lg-4">
                
                <!-- Direct Apply Box -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-maroon text-white" id="apply">
                    <h4 class="fw-bold text-warning mb-2"><i class="fas fa-paper-plane me-2"></i> Apply for Admission</h4>
                    <p class="text-white-50 small mb-4">Admissions open for 2026-27. Submit your details for instant counseling and seat confirmation.</p>
                    
                    <form action="<?php echo BASE_URL; ?>contact.php#apply" method="POST">
                        <input type="hidden" name="course" value="<?php echo sanitize($course['course_name']); ?>">
                        <div class="mb-3">
                            <label class="form-label text-white small fw-semibold">Full Name *</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Your Full Name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white small fw-semibold">Email Address *</label>
                            <input type="email" name="email" class="form-control form-control-sm" placeholder="yourname@gmail.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white small fw-semibold">Mobile Number *</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" placeholder="10-Digit Mobile" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white small fw-semibold">Your Message</label>
                            <textarea name="message" class="form-control form-control-sm" rows="2" placeholder="Mention your 10+2 / Graduation %"></textarea>
                        </div>
                        <button type="submit" name="submit_contact" class="btn btn-warning w-100 fw-bold text-dark btn-sm py-2">
                            <i class="fas fa-check-circle me-1"></i> Apply for <?php echo sanitize($course['course_name']); ?>
                        </button>
                    </form>
                </div>

                <!-- Helpline Box -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-light">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-headset text-danger me-2"></i> Admission Helpline</h5>
                    <p class="text-muted small mb-2">Speak directly to an admission counselor for this course:</p>
                    <p class="mb-1 fw-bold text-dark"><i class="fas fa-phone-alt text-danger me-2"></i> <?php echo getSetting('helpline'); ?></p>
                    <p class="mb-0 fw-bold text-dark"><i class="fas fa-envelope text-danger me-2"></i> <?php echo getSetting('email'); ?></p>
                </div>

                <!-- Related Courses -->
                <?php if (!empty($relatedCourses)): ?>
                    <div class="card p-4 border-0 shadow-sm rounded-4">
                        <h5 class="fw-bold text-navy mb-3">Other Courses in this Faculty</h5>
                        <div class="list-group list-group-flush">
                            <?php foreach ($relatedCourses as $rc): 
                                if ($rc['id'] == $course['id']) continue;
                            ?>
                                <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($rc['slug'] ?: $rc['id']); ?>" 
                                   class="list-group-item list-group-item-action px-0 d-flex justify-content-between align-items-center small text-muted">
                                    <span><i class="fas fa-graduation-cap me-2 text-danger"></i> <?php echo sanitize($rc['course_name']); ?></span>
                                    <i class="fas fa-chevron-right fa-xs"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
