<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? 'b-tech-engineering');
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

// Handle Direct Course Admission Form Submit
$enquirySuccess = false;
$enquiryErr = '';
$enquiryMsg = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['submit_course_enquiry'])) {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $course['course_name'],
        $_POST['message'] ?? '',
        'Course Detail Page - ' . $course['course_name']
    );
    if ($res['success']) {
        $enquirySuccess = true;
        $enquiryMsg = $res['message'];
    } else {
        $enquiryErr = $res['error'];
    }
}

$pageTitle = sanitize($course['course_name']) . " | Admissions, Eligibility & Details | SRKU Bhopal";
$pageDesc = "Apply for " . sanitize($course['course_name']) . " at Sarvepalli Radhakrishnan University (SRKU), Bhopal. Check eligibility criteria (" . sanitize($course['eligibility'] ?? '10+2 / Graduation') . "), duration (" . sanitize($course['duration'] ?? '') . "), and career scope.";
$pageKeywords = sanitize($course['course_name']) . ", " . sanitize($course['course_name']) . " in Bhopal, SRKU Admissions 2026, Course Syllabus, Fees and Eligibility";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Schema.org Course Structured Data for Google Course Rich Snippets & AI Search -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": <?php echo json_encode($course['course_name']); ?>,
  "description": <?php echo json_encode(substr(strip_tags($course['description'] ?? $pageDesc), 0, 300)); ?>,
  "provider": {
    "@type": "CollegeOrUniversity",
    "name": "Sarvepalli Radhakrishnan University",
    "sameAs": "https://srku.edu.in/"
  },
  "educationalCredentialAwarded": <?php echo json_encode($course['course_name']); ?>,
  "timeRequired": <?php echo json_encode($course['duration'] ?? 'P3Y'); ?>,
  "coursePrerequisites": <?php echo json_encode($course['eligibility'] ?? '10+2 with minimum aggregate'); ?>,
  "offers": {
    "@type": "Offer",
    "category": <?php echo json_encode($course['level'] ?? 'Degree'); ?>
  }
}
</script>
<?php
$relatedCourses = getCourses($course['dept_slug'] ?: $course['department'], null, null, 4);
$specList = !empty($course['specializations']) ? array_map('trim', explode(',', $course['specializations'])) : [];

// Fetch department info if available
$deptInfo = getDepartmentBySlug($course['dept_slug'] ?: $course['department']);
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white position-relative" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <div class="d-inline-flex align-items-center gap-2 mb-2 flex-wrap justify-content-center">
            <span class="badge bg-warning text-dark px-3 py-1 fw-bold"><?php echo sanitize($course['level']); ?> Programme</span>
            <span class="badge bg-white bg-opacity-25 text-white px-3 py-1 border border-white-50">
                <i class="fas fa-university me-1"></i> <?php echo sanitize($course['department']); ?>
            </span>
            <?php if (!empty($specList)): ?>
                <span class="badge bg-danger px-3 py-1">Specializations &amp; Tracks Available</span>
            <?php endif; ?>
        </div>
        <h1 class="fw-bold display-6 mb-2"><?php echo sanitize($course['course_name']); ?></h1>
        <p class="text-warning fw-semibold lead mb-0">Sarvepalli Radhakrishnan University &bull; Industry-Aligned &bull; Dedicated Placement Support</p>
    </div>
</div>

<!-- Breadcrumb Bar -->
<div class="bg-light py-2 border-bottom">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>courses.php" class="text-decoration-none text-muted">Courses Catalog</a></li>
                <?php if ($deptInfo): ?>
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>department/<?php echo urlencode($deptInfo['slug']); ?>" class="text-decoration-none text-muted"><?php echo sanitize($deptInfo['name']); ?></a></li>
                <?php endif; ?>
                <li class="breadcrumb-item active text-danger fw-semibold" aria-current="page"><?php echo sanitize($course['course_name']); ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container-xl py-2">
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
                            <div class="small text-muted mb-1"><i class="fas fa-user-check text-danger me-1"></i> Admission Session</div>
                            <div class="fw-bold text-danger fs-6">2026 - 2027</div>
                        </div>
                        <div class="col">
                            <div class="small text-muted mb-1"><i class="fas fa-shield-alt text-danger me-1"></i> Approvals</div>
                            <div class="fw-bold text-navy fs-6"><?php echo sanitize($deptInfo['approvals'] ?? 'UGC / AICTE / Regulatory'); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Programme Overview -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                    <h2 class="text-maroon fw-bold mb-3"><i class="fas fa-info-circle text-danger me-2"></i> Degree Overview &amp; Academic Objectives</h2>
                    <p class="text-dark lead fs-6" style="line-height:1.85;">
                        <?php echo nl2br(sanitize($course['description'] ?: 'The ' . $course['course_name'] . ' at Sarvepalli Radhakrishnan University is designed in close consultation with industry stalwarts and apex academic councils, focusing on theoretical foundations, cutting-edge practical training, and multi-disciplinary research.')); ?>
                    </p>
                    <p class="text-muted" style="line-height:1.85; font-size:0.95rem;">
                        Students benefit from continuous hands-on laboratory sessions, industrial apprenticeships, hospital clinical rotations, live capstone projects, and mentorship from highly qualified doctorate faculty members.
                    </p>
                </div>

                <!-- Dynamic Specializations & Disciplines (if available) -->
                <?php if (!empty($specList)): ?>
                    <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <h3 class="text-navy fw-bold mb-0">
                                <i class="fas fa-sitemap text-danger me-2"></i> Available Disciplines &amp; Specializations
                            </h3>
                            <span class="badge bg-danger px-3 py-2">Specializations Offered</span>
                        </div>
                        <p class="text-muted small mb-4">
                            Students pursuing <strong><?php echo sanitize($course['course_name']); ?></strong> can specialize in the following focused tracks during their academic curriculum:
                        </p>
                        <div class="row row-cols-1 row-cols-sm-2 g-3">
                            <?php foreach ($specList as $spec): ?>
                                <div class="col">
                                    <div class="p-3 bg-light rounded-3 border d-flex align-items-center gap-3 h-100">
                                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:34px; height:34px; font-size:0.85rem;">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="fw-semibold text-navy small">
                                            <?php echo sanitize($spec); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="col">
                                <div class="p-3 bg-light rounded-3 border d-flex align-items-center gap-3 h-100">
                                    <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:34px; height:34px; font-size:0.85rem;">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="fw-semibold text-navy small">
                                        &amp; Many More Specializations...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Eligibility Criteria -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                    <h3 class="text-navy fw-bold mb-3"><i class="fas fa-check-circle text-danger me-2"></i> Eligibility &amp; Admission Criteria</h3>
                    <div class="p-3 bg-light rounded-3 border-start border-4 border-danger mb-3">
                        <p class="mb-0 text-dark fw-semibold" style="line-height:1.7;">
                            <?php echo sanitize($course['eligibility']); ?>
                        </p>
                    </div>
                    <ul class="text-muted small d-flex flex-column gap-2 mb-0" style="line-height:1.7;">
                        <li>Direct admission available through university merit assessment, entrance test scores, and counseling rounds.</li>
                        <li>Reservation and relaxation for SC / ST / OBC and PwD candidates as per Madhya Pradesh State Government &amp; UGC guidelines.</li>
                        <li>Scholarship support applicable under AICTE Pragati, Post-Matric State Schemes, and University Merit Scholarships.</li>
                    </ul>
                </div>

                <!-- Career Opportunities & Scope -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                    <h3 class="text-navy fw-bold mb-3"><i class="fas fa-briefcase text-danger me-2"></i> Career Scope &amp; Job Opportunities</h3>
                    <p class="text-dark" style="line-height:1.8;">
                        Graduates of <strong><?php echo sanitize($course['course_name']); ?></strong> possess exceptional career prospects across leading corporations, healthcare institutions, and research sectors:
                    </p>
                    <div class="p-3 bg-danger-subtle rounded-3 text-danger fw-semibold mb-3 border border-danger-subtle">
                        <i class="fas fa-star me-2"></i> <?php echo sanitize($course['career_scope'] ?: 'Industry Specialist, R&D Associate, Technical Consultant, Public Sector Officer'); ?><span class="fw-normal">, &amp; many more...</span>
                    </div>
                    <p class="text-muted small mb-0">
                        Our centralized Training &amp; Placement Cell conducts regular corporate interviews, mock assessments, and campus recruitment drives with recruiters offering salary packages up to <strong>12 LPA</strong>.
                    </p>
                </div>

                <!-- Syllabus & Examination Scheme Downloads -->
                <?php 
                    $hasScheme = !empty($course['scheme_url']) && $course['scheme_url'] !== '#';
                    $hasSyllabus = !empty($course['syllabus_url']) && $course['syllabus_url'] !== '#';

                    $schemeHref = $hasScheme ? (strpos($course['scheme_url'], 'http') === 0 ? $course['scheme_url'] : BASE_URL . ltrim($course['scheme_url'], '/')) : '#';
                    $syllabusHref = $hasSyllabus ? (strpos($course['syllabus_url'], 'http') === 0 ? $course['syllabus_url'] : BASE_URL . ltrim($course['syllabus_url'], '/')) : '#';
                ?>
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <div>
                            <h3 class="text-navy fw-bold mb-1"><i class="fas fa-file-pdf text-danger me-2"></i> Official Curriculum Scheme &amp; Syllabus</h3>
                            <p class="text-muted small mb-0">Approved semester-wise structure, scheme of marks, and complete syllabus.</p>
                        </div>
                        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold small">
                            <i class="fas fa-check me-1"></i> Academic Session 2026-27
                        </span>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="badge bg-secondary-subtle text-dark border mb-2 small">Examination Blueprint</span>
                                    <h5 class="h6 fw-bold text-navy mb-1">Scheme of Examination</h5>
                                    <p class="text-muted small mb-3">Credit hours, theory/practical marks distribution &amp; passing standards.</p>
                                </div>
                                <?php if ($hasScheme): ?>
                                    <a href="<?php echo sanitize($schemeHref); ?>" target="_blank" class="btn btn-outline-danger btn-sm fw-bold w-100 py-2">
                                        <i class="fas fa-file-pdf me-1"></i> Download Scheme (PDF)
                                    </a>
                                <?php else: ?>
                                    <a href="#" class="btn btn-outline-secondary btn-sm fw-bold w-100 py-2 opacity-75" title="Available upon request" onclick="return false;">
                                        <i class="fas fa-info-circle me-1"></i> Scheme on Request
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-2 small">Full Academic Syllabus</span>
                                    <h5 class="h6 fw-bold text-navy mb-1">Course Syllabus &amp; Topics</h5>
                                    <p class="text-muted small mb-3">Detailed unit-wise topics, lab practicals, reference books &amp; journals.</p>
                                </div>
                                <?php if ($hasSyllabus): ?>
                                    <a href="<?php echo sanitize($syllabusHref); ?>" target="_blank" class="btn btn-danger btn-sm fw-bold w-100 py-2 shadow-xs">
                                        <i class="fas fa-download me-1"></i> Download Syllabus (PDF)
                                    </a>
                                <?php else: ?>
                                    <a href="#" class="btn btn-secondary btn-sm fw-bold w-100 py-2 opacity-75" title="Available upon request" onclick="return false;">
                                        <i class="fas fa-clock me-1"></i> Syllabus on Request
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 mt-3 border-top text-center text-md-start d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <small class="text-muted"><i class="fas fa-info-circle text-primary me-1"></i> Need archival question papers or electives syllabus?</small>
                        <a href="<?php echo BASE_URL; ?>syllabus.php" class="small fw-bold text-danger text-decoration-none">
                            View All University Course Syllabuses &rarr;
                        </a>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar Column -->
            <div class="col-12 col-lg-4">
                
                <!-- Direct Apply Box -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-maroon text-white" id="apply">
                    <h4 class="fw-bold text-warning mb-2"><i class="fas fa-paper-plane me-2"></i> Apply for Admission</h4>
                    <p class="text-white-50 small mb-3">Admissions Open 2026-27 for <strong><?php echo sanitize($course['course_name']); ?></strong>. Submit your details for instant seat counseling.</p>
                    
                    <!-- Brochure Official Helplines -->
                    <div class="p-3 bg-white bg-opacity-10 rounded-3 mb-3 small">
                        <div class="mb-1"><i class="fas fa-phone-alt text-warning me-2"></i> <strong>Helplines:</strong> 0755-4700983, 7024144981</div>
                        <div><i class="fas fa-envelope text-warning me-2"></i> <strong>Email:</strong> info@srku.edu.in</div>
                    </div>

                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success text-dark py-3 px-3 rounded-3 mb-3 small fw-semibold shadow-sm border-0 bg-white">
                            <div class="d-flex align-items-center gap-2 mb-1 text-success fw-bold">
                                <i class="fas fa-check-circle fa-lg"></i> Application Received!
                            </div>
                            <?php echo sanitize($enquiryMsg); ?>
                        </div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger py-2 px-3 rounded-3 mb-3 small fw-semibold">
                            <i class="fas fa-exclamation-triangle me-1"></i> <?php echo sanitize($enquiryErr); ?>
                        </div>
                    <?php endif; ?>

                    <form action="#apply" method="POST">
                        <input type="hidden" name="course" value="<?php echo sanitize($course['course_name']); ?>">
                        <input type="hidden" name="department" value="<?php echo sanitize($course['department']); ?>">
                        <div class="mb-2">
                            <label class="form-label text-white small fw-semibold">Full Name *</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Your Full Name" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['name'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-white small fw-semibold">Email Address *</label>
                            <input type="email" name="email" class="form-control form-control-sm" placeholder="yourname@gmail.com" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['email'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-white small fw-semibold">Mobile Number *</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" placeholder="10-Digit Mobile Number" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['phone'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white small fw-semibold">Your Message / Percentage</label>
                            <textarea name="message" class="form-control form-control-sm" rows="2" placeholder="Mention 10+2 / Graduation % or queries"><?php echo $enquirySuccess ? '' : sanitize($_POST['message'] ?? ''); ?></textarea>
                        </div>
                        <button type="submit" name="submit_course_enquiry" class="btn btn-warning w-100 fw-bold text-dark btn-sm py-2 shadow-sm">
                            <i class="fas fa-check-circle me-1"></i> Apply for <?php echo sanitize(explode('(', $course['course_name'])[0]); ?>
                        </button>
                    </form>
                </div>

                <!-- Department / Constituent Unit Widget -->
                <?php if ($deptInfo): ?>
                    <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                        <h5 class="fw-bold text-navy mb-2"><i class="fas fa-university text-danger me-2"></i> Offered by</h5>
                        <h6 class="fw-bold text-maroon mb-2"><?php echo sanitize($deptInfo['name']); ?></h6>
                        <p class="text-muted small mb-3" style="line-height:1.65;">
                            <?php echo sanitize($deptInfo['description']); ?>
                        </p>
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=<?php echo urlencode($deptInfo['slug']); ?>" class="btn btn-sm btn-outline-danger w-100">
                            <i class="fas fa-external-link-alt me-1"></i> View Constituent Unit Details
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Related Courses Widget -->
                <?php if (!empty($relatedCourses)): ?>
                    <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                        <h5 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="fas fa-layer-group text-danger me-2"></i> Related Degree Offerings</h5>
                        <div class="d-flex flex-column gap-2">
                            <?php foreach ($relatedCourses as $rc): 
                                if ($rc['id'] == $course['id']) continue;
                            ?>
                                <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($rc['slug'] ?: $rc['id']); ?>" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold text-truncate" style="max-width: 210px;"><?php echo sanitize($rc['course_name']); ?></div>
                                        <span class="badge badge-level-navy text-white small" style="font-size:0.7rem;"><?php echo sanitize($rc['level']); ?> &bull; <?php echo sanitize($rc['duration']); ?></span>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted small"></i>
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
