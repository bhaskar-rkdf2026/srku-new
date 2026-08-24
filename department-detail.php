<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? 'rkdf-institute-of-science-and-technology');
$dept = getDepartmentBySlug($slug);

if (!$dept) {
    // If not found by exact slug, try matching first department
    $departments = getDepartments(true);
    if (!empty($departments)) {
        $dept = $departments[0];
    } else {
        header("Location: " . BASE_URL . "departments.php");
        exit;
    }
}

// Handle Direct Department Admission Form Submit
$enquirySuccess = false;
$enquiryErr = '';
$enquiryMsg = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['submit_dept_enquiry'])) {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['course'] ?? $dept['name'],
        $_POST['message'] ?? '',
        'Department Page - ' . $dept['name']
    );
    if ($res['success']) {
        $enquirySuccess = true;
        $enquiryMsg = $res['message'];
    } else {
        $enquiryErr = $res['error'];
    }
}

$pageTitle = $dept['name'] . " - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "departments";
require_once __DIR__ . '/includes/header.php';

$courses = getCourses($dept['slug']);
if (empty($courses)) {
    $courses = getCourses($dept['name']);
}

// Group courses by level
$ugCourses = array_filter($courses, fn($c) => $c['level'] === 'UG');
$pgCourses = array_filter($courses, fn($c) => $c['level'] === 'PG');
$dipCourses = array_filter($courses, fn($c) => in_array($c['level'], ['Diploma', 'Certificate']));
$docCourses = array_filter($courses, fn($c) => in_array($c['level'], ['Doctorate', 'PhD']));

// Other departments for sidebar
$allDepts = getDepartments(true);
$otherDepts = array_filter($allDepts, fn($d) => $d['id'] != $dept['id']);
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white position-relative" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-10 rounded-circle p-3 mb-3 shadow" style="width:70px; height:70px; font-size:2rem;">
            <i class="<?php echo sanitize($dept['icon'] ?: 'fas fa-graduation-cap'); ?> text-warning"></i>
        </div>
        
        <div class="d-flex justify-content-center gap-2 mb-2 flex-wrap">
            <?php if (!empty($dept['established_year'])): ?>
                <span class="badge bg-warning text-dark fw-bold px-3 py-1">Est. <?php echo sanitize($dept['established_year']); ?></span>
            <?php endif; ?>
            <?php if (!empty($dept['approvals'])): ?>
                <span class="badge bg-white bg-opacity-25 text-white px-3 py-1 border border-white-50"><?php echo sanitize($dept['approvals']); ?> Approved</span>
            <?php endif; ?>
            <span class="badge bg-danger px-3 py-1"><?php echo sanitize($dept['category'] ?? 'Faculty'); ?></span>
        </div>

        <h1 class="fw-bold display-6 mb-2"><?php echo sanitize($dept['name']); ?></h1>
        <p class="text-warning fw-semibold lead mb-0">Sarvepalli Radhakrishnan University, Bhopal</p>
    </div>
</div>

<!-- Breadcrumb Bar -->
<div class="bg-light py-2 border-bottom">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>departments.php" class="text-decoration-none text-muted">Constituent Units &amp; Departments</a></li>
                <li class="breadcrumb-item active text-danger fw-semibold" aria-current="page"><?php echo sanitize($dept['name']); ?></li>
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
                            <div class="small text-muted mb-1"><i class="fas fa-calendar-alt text-danger me-1"></i> Established</div>
                            <div class="fw-bold text-navy fs-6"><?php echo sanitize($dept['established_year'] ?: '1995'); ?></div>
                        </div>
                        <div class="col">
                            <div class="small text-muted mb-1"><i class="fas fa-graduation-cap text-danger me-1"></i> Programs</div>
                            <div class="fw-bold text-navy fs-6"><?php echo count($courses); ?> Degrees / Diplomas</div>
                        </div>
                        <div class="col">
                            <div class="small text-muted mb-1"><i class="fas fa-stamp text-danger me-1"></i> Regulatory Status</div>
                            <div class="fw-bold text-navy fs-6"><?php echo sanitize($dept['approvals'] ?: 'UGC Approved'); ?></div>
                        </div>
                        <div class="col">
                            <div class="small text-muted mb-1"><i class="fas fa-chart-line text-danger me-1"></i> Placement Record</div>
                            <div class="fw-bold text-danger fs-6">94% Supported</div>
                        </div>
                    </div>
                </div>

                <!-- About the Faculty Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4">
                    <h2 class="text-maroon fw-bold mb-3"><i class="fas fa-university text-danger me-2"></i> About the Constituent Unit &amp; Academic Vision</h2>
                    <p class="text-dark lead fs-6" style="line-height:1.85;">
                        <?php echo nl2br(sanitize($dept['description'])); ?>
                    </p>
                    <p class="text-muted" style="line-height:1.85; font-size:0.95rem;">
                        Equipped with industry-standard curriculum, advanced specialized laboratories, experienced doctoral faculty members, and regular internships, the faculty prepares scholars to excel in competitive careers, clinical healthcare, scientific research, and entrepreneurship.
                    </p>
                </div>

                <!-- Academic Programmes Catalog -->
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 pb-2 border-bottom">
                        <div>
                            <h3 class="text-navy fw-bold mb-1"><i class="fas fa-graduation-cap text-danger me-2"></i> Degrees, Diplomas &amp; Specializations</h3>
                            <p class="text-muted small mb-0">Official academic programs offered by <?php echo sanitize($dept['name']); ?></p>
                        </div>
                        <span class="badge bg-danger px-3 py-2 rounded-pill"><?php echo count($courses); ?> Programs Available</span>
                    </div>

                    <?php if (!empty($courses)): ?>
                        <div class="d-flex flex-column gap-4">
                            <?php foreach ($courses as $c): 
                                $specList = !empty($c['specializations']) ? array_map('trim', explode(',', $c['specializations'])) : [];
                            ?>
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white" style="border: 1px solid #e2e8f0 !important; transition: all 0.25s ease;">
                                    
                                    <!-- Course Item Header -->
                                    <div class="p-4 pb-3 border-bottom bg-light bg-opacity-50 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                <span class="badge bg-navy text-white rounded-pill px-3 py-1 fw-semibold small"><?php echo sanitize($c['level']); ?> Programme</span>
                                                <span class="badge bg-white text-muted border rounded-pill px-3 py-1 small"><i class="far fa-clock me-1 text-danger"></i> <?php echo sanitize($c['duration']); ?></span>
                                            </div>
                                            <h4 class="h5 fw-bold text-navy mb-0">
                                                <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="text-navy text-decoration-none hover-danger">
                                                    <?php echo sanitize($c['course_name']); ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="d-flex gap-2 flex-shrink-0">
                                            <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="btn btn-sm btn-outline-secondary px-3 py-2 fw-semibold">
                                                <i class="fas fa-info-circle me-1"></i> Details
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>contact.php?course=<?php echo urlencode($c['course_name']); ?>" class="btn btn-sm btn-srku px-3 py-2 fw-semibold">
                                                <i class="fas fa-paper-plane me-1"></i> Apply Now
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Course Item Body -->
                                    <div class="p-4">
                                        <p class="text-muted small mb-3" style="line-height: 1.75; font-size: 0.93rem;">
                                            <?php echo sanitize($c['description']); ?>
                                        </p>

                                        <!-- Specializations / Disciplines Tag Cloud -->
                                        <?php if (!empty($specList)): ?>
                                            <div class="mb-3 pt-1">
                                                <div class="small fw-bold text-navy mb-2 d-flex align-items-center gap-2">
                                                    <i class="fas fa-layer-group text-danger"></i> 
                                                    <span>Available Disciplines &amp; Specializations (<?php echo count($specList); ?>):</span>
                                                </div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <?php foreach ($specList as $sp): ?>
                                                        <span class="badge rounded-2 fw-medium py-2 px-3 text-start" style="background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; font-size: 0.83rem; white-space: normal; line-height: 1.4;">
                                                            &bull; <?php echo sanitize($sp); ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- 2-Column Info Grid for Eligibility & Career -->
                                        <div class="row g-3 mt-1">
                                            <div class="col-12 <?php echo !empty($c['career_scope']) ? 'col-md-6' : ''; ?>">
                                                <div class="p-3 rounded-3 h-100" style="background: #f8fafc; border-left: 3px solid #10b981; border-top: 1px solid #edf2f7; border-right: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7;">
                                                    <div class="small fw-bold text-navy mb-1"><i class="fas fa-check-circle text-success me-1"></i> Eligibility Criteria</div>
                                                    <div class="small text-muted" style="line-height: 1.6;"><?php echo sanitize($c['eligibility']); ?></div>
                                                </div>
                                            </div>
                                            <?php if (!empty($c['career_scope'])): ?>
                                                <div class="col-12 col-md-6">
                                                    <div class="p-3 rounded-3 h-100" style="background: #f8fafc; border-left: 3px solid #3b82f6; border-top: 1px solid #edf2f7; border-right: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7;">
                                                        <div class="small fw-bold text-navy mb-1"><i class="fas fa-briefcase text-primary me-1"></i> Career Scope &amp; Roles</div>
                                                        <div class="small text-muted" style="line-height: 1.6;"><?php echo sanitize($c['career_scope']); ?></div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="card p-4 border-0 shadow-sm rounded-4 text-center py-4 text-muted">
                            <i class="fas fa-book-open fa-2x mb-2"></i>
                            <p class="mb-0">Programmes catalog being updated. Please contact the admission desk for details.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Laboratory & Infrastructure Section -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4">
                    <h3 class="text-navy fw-bold mb-3"><i class="fas fa-flask text-danger me-2"></i> Infrastructure &amp; Practical Training Suites</h3>
                    <p class="text-muted mb-4">Hands-on practical exposure in world-class facilities equipped with modern machinery, testing instruments, and computational tools.</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-3 border h-100">
                                <i class="fas fa-microscope text-danger fa-2x"></i>
                                <div>
                                    <h5 class="h6 fw-bold text-dark mb-1">Advanced Research Labs</h5>
                                    <small class="text-muted">High-precision testing instruments &amp; equipment</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-3 border h-100">
                                <i class="fas fa-laptop-code text-danger fa-2x"></i>
                                <div>
                                    <h5 class="h6 fw-bold text-dark mb-1">Modern Computational Center</h5>
                                    <small class="text-muted">High-speed gigabit Wi-Fi &amp; licensed software</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-3 border h-100">
                                <i class="fas fa-hospital-user text-danger fa-2x"></i>
                                <div>
                                    <h5 class="h6 fw-bold text-dark mb-1">Teaching Hospital / Live Beds</h5>
                                    <small class="text-muted">750+ Bed multi-specialty clinical training</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-3 border h-100">
                                <i class="fas fa-book text-danger fa-2x"></i>
                                <div>
                                    <h5 class="h6 fw-bold text-dark mb-1">Departmental Digital Library</h5>
                                    <small class="text-muted">IEEE, Springer, ScienceDirect &amp; Delnet e-journals</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar Column -->
            <div class="col-12 col-lg-4">
                
                <!-- Brochure Contact & Direct Apply Box -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-maroon text-white" id="apply">
                    <h4 class="fw-bold text-warning mb-2"><i class="fas fa-paper-plane me-2"></i> Apply for Admission</h4>
                    <p class="text-white-50 small mb-3">Admissions Open 2026-27 for <strong><?php echo sanitize($dept['name']); ?></strong>. Apply now for counseling and seat confirmation.</p>
                    
                    <div class="p-3 bg-white bg-opacity-10 rounded-3 mb-3 small">
                        <div class="mb-1"><i class="fas fa-phone-alt text-warning me-2"></i> <strong>Admission Desk:</strong> <?php echo sanitize($dept['contact_no'] ?: '0755-4700983, 7024144981'); ?></div>
                        <div><i class="fas fa-envelope text-warning me-2"></i> <strong>Official Email:</strong> info@srku.edu.in</div>
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
                        <input type="hidden" name="department" value="<?php echo sanitize($dept['name']); ?>">
                        <div class="mb-2">
                            <label class="form-label text-white small fw-semibold">Full Name *</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Enter Full Name" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['name'] ?? ''); ?>" required>
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
                            <label class="form-label text-white small fw-semibold">Select Course of Interest</label>
                            <select name="course" class="form-select form-select-sm">
                                <?php foreach ($courses as $c): ?>
                                    <option value="<?php echo sanitize($c['course_name']); ?>"><?php echo sanitize($c['course_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="submit_dept_enquiry" class="btn btn-warning w-100 fw-bold text-dark btn-sm py-2">
                            <i class="fas fa-check-circle me-1"></i> Submit Admission Enquiry
                        </button>
                    </form>
                </div>

                <!-- Other Constituent Units Sidebar -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                    <h5 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="fas fa-university text-danger me-2"></i> Other Constituent Units</h5>
                    <div class="d-flex flex-column gap-2" style="max-height: 400px; overflow-y: auto;">
                        <?php foreach (array_slice($otherDepts, 0, 10) as $od): ?>
                            <a href="<?php echo BASE_URL; ?>department-detail.php?slug=<?php echo urlencode($od['slug']); ?>" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                                <span class="fw-semibold text-truncate" style="max-width: 85%;"><?php echo sanitize($od['name']); ?></span>
                                <i class="fas fa-chevron-right text-muted small"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-3 pt-2 border-top text-center">
                        <a href="<?php echo BASE_URL; ?>departments.php" class="btn btn-sm btn-outline-secondary w-100">View All 26 Units</a>
                    </div>
                </div>

                <!-- Career & Placement Widget -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-light border">
                    <h5 class="fw-bold text-navy mb-2"><i class="fas fa-award text-danger me-2"></i> Training &amp; Placements</h5>
                    <p class="text-muted small mb-3">Dedicated training in soft skills, technical coding, aptitude, and multi-round interviews with 120+ top MNCs.</p>
                    <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded-3 border mb-2">
                        <span class="small fw-semibold text-muted">Highest Package:</span>
                        <span class="text-danger fw-bold">12 LPA</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded-3 border">
                        <span class="small fw-semibold text-muted">Placement Record:</span>
                        <span class="text-navy fw-bold">94% Verified</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
