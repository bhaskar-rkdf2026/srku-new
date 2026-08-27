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

$pageTitle = sanitize($dept['name']) . " | Programmes & Admissions | SRKU";
$pageDesc = "Explore academic programs, laboratory infrastructure, distinguished faculty, and admissions at " . sanitize($dept['name']) . ", Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = sanitize($dept['name']) . ", SRKU Department, Courses, Admissions Bhopal, Faculty";
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

// Exact 11 Constituent Institutes that possess their own official circular seals
$exactSeals = [
    'rkdf-medical-college' => 'logo-rkdf-medical.png',
    'sarvepalli-radhakrishnan-college-of-ayurveda' => 'logo-srk-ayurveda.png',
    'rkdf-homoeopathic-medical-college' => 'logo-rkdf-homoeopathy.png',
    'rkdf-dental-college' => 'logo-rkdf-dental.png',
    'rkdf-college-of-pharmacy' => 'logo-rkdf-pharmacy.png',
    'rkdf-college-of-nursing' => 'logo-rkdf-nursing.png',
    'department-of-paramedical-sciences' => 'logo-allied-healthcare.png',
    'rkdf-institute-of-science-and-technology' => 'logo-rkdf-science-tech.png',
    'sarvepalli-radhakrishnan-college-of-law' => 'logo-srk-law.png',
    'rkdf-institute-of-business-management' => 'logo-rkdf-management.png',
    'faculty-of-agriculture' => 'logo-srk-agriculture.png'
];

// Dedicated External Websites Map for standalone portals
$externalWebsites = [
    'rkdf-medical-college' => 'https://rkdfmedicalcollege.org/',
    'rkdf-dental-college' => 'http://rkdfdentalcollege.in/',
    'rkdf-homoeopathic-medical-college' => 'http://www.rkdfhmc.in/',
    'sarvepalli-radhakrishnan-college-of-ayurveda' => 'https://www.srkcahrc.in/',
    'rkdf-institute-of-science-and-technology' => 'https://srku.edu.in/rkdf-ist/index.php',
    'faculty-of-agriculture' => 'https://srku.edu.in/agriculture/index.php'
];

$sealFile = $exactSeals[$dept['slug']] ?? null;
$officialWebsite = $externalWebsites[$dept['slug']] ?? null;
$deptImg = !empty($dept['image']) ? $dept['image'] : 'assets/uploads/2026/07/001.webp';
$deptImgSrc = resolveMediaUrl($deptImg, 'assets/uploads/2026/07/001.webp');

// Other departments for sidebar
$allDepts = getDepartments(true);
$otherDepts = array_filter($allDepts, fn($d) => $d['id'] != $dept['id']);
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white position-relative" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <?php if ($sealFile && file_exists(__DIR__ . '/assets/images/constituent-logos/' . $sealFile)): ?>
            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle shadow mx-auto mb-3" style="width:88px; height:88px;">
                <img src="<?php echo BASE_URL; ?>assets/images/constituent-logos/<?php echo $sealFile; ?>?v=3" alt="<?php echo sanitize($dept['name']); ?>" class="img-fluid d-block m-auto" style="max-width:88%; max-height:88%; object-fit:contain;">
            </div>
        <?php else: ?>
            <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-10 rounded-circle p-3 mb-3 shadow" style="width:70px; height:70px; font-size:2rem;">
                <i class="<?php echo sanitize($dept['icon'] ?: 'fas fa-graduation-cap'); ?> text-warning"></i>
            </div>
        <?php endif; ?>
        
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

        <?php if ($officialWebsite): ?>
            <div class="mt-3">
                <a href="<?php echo $officialWebsite; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-warning btn-lg fw-bold text-dark px-4 py-2 shadow rounded-pill d-inline-flex align-items-center gap-2" style="font-size:0.95rem;">
                    <i class="fas fa-globe"></i> Visit Official College Website <i class="fas fa-external-link-alt ms-1" style="font-size:0.75rem;"></i>
                </a>
            </div>
        <?php endif; ?>
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
                
                <!-- Campus / Building Image Feature -->
                <div class="rounded-4 overflow-hidden mb-4 shadow-sm position-relative border" style="max-height: 380px; background: #0b1526;">
                    <img src="<?php echo $deptImgSrc; ?>" 
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';" 
                         alt="<?php echo sanitize($dept['name']); ?> Campus" 
                         class="w-100 h-100 object-fit-cover" style="min-height: 260px; max-height: 380px;">
                    <div class="position-absolute bottom-0 start-0 end-0 p-3 p-md-4 text-white d-flex align-items-end justify-content-between flex-wrap gap-2" style="background: linear-gradient(to top, rgba(11,21,38,0.92) 0%, rgba(11,21,38,0.4) 60%, transparent 100%);">
                        <div>
                            <span class="badge bg-danger text-white px-3 py-1 rounded-pill small fw-bold mb-1 shadow-xs"><i class="fas fa-building me-1"></i> Campus &amp; Infrastructure</span>
                            <h4 class="h5 fw-bold text-white mb-0 text-shadow"><?php echo sanitize($dept['name']); ?></h4>
                        </div>
                        <?php if (!empty($dept['established_year'])): ?>
                            <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill shadow-xs">Established <?php echo sanitize($dept['established_year']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

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

                <?php if ($officialWebsite): ?>
                    <!-- Official Website Callout Box -->
                    <div class="card p-3 p-md-4 border-0 rounded-4 mb-4 shadow-sm" style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border-left: 5px solid #ea580c !important;">
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white rounded-circle p-2 shadow-xs border d-flex align-items-center justify-content-center" style="width:52px; height:52px; flex-shrink:0;">
                                    <i class="fas fa-globe text-danger fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="h6 fw-bold text-dark mb-1">Dedicated Official Website Available</h4>
                                    <p class="text-muted small mb-0">Visit the standalone institutional portal for specialized hospital OPD timings, clinical facilities &amp; department details.</p>
                                </div>
                            </div>
                            <a href="<?php echo $officialWebsite; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-danger btn-sm px-3 py-2 fw-semibold text-nowrap rounded-pill d-inline-flex align-items-center gap-1 shadow-sm">
                                <span>Check Official Web</span> <i class="fas fa-external-link-alt" style="font-size:0.75rem;"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- About the Faculty Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4">
                    <h2 class="text-maroon fw-bold mb-3"><i class="fas fa-university text-danger me-2"></i> About the Constituent Unit &amp; Academic Vision</h2>
                    <p class="text-dark lead fs-6" style="line-height:1.85;">
                        <?php echo nl2br(sanitize($dept['description'])); ?>
                    </p>
                    <p class="text-muted mb-0" style="line-height:1.85; font-size:0.95rem;">
                        Equipped with industry-standard curriculum, advanced specialized laboratories, experienced doctoral faculty members, and regular internships, the faculty prepares scholars to excel in competitive careers, clinical healthcare, scientific research, and entrepreneurship.
                    </p>
                </div>

                <?php 
                $dName = trim((string)($dept['dean_name'] ?? ''));
                $dMsg = trim((string)($dept['dean_message'] ?? ''));
                if (!empty($dName) && !empty($dMsg)): 
                    $dDesig = trim((string)($dept['dean_designation'] ?? 'Dean & Principal')) ?: 'Dean & Principal';
                    $dPhoto = trim((string)($dept['dean_photo'] ?? ''));
                ?>
                    <!-- Dean / Principal's Desk Message Section (Only shown when populated) -->
                    <div class="card p-4 p-md-4 border-0 shadow-sm rounded-4 mb-4 position-relative overflow-hidden bg-white" style="border: 1px solid #e2e8f0 !important; border-left: 5px solid #7a0b0d !important;">
                        <div class="d-flex flex-column flex-md-row gap-4 align-items-md-center">
                            
                            <!-- Dean Photo Column -->
                            <div class="text-center flex-shrink-0 mx-auto mx-md-0" style="width: 140px;">
                                <div class="rounded-circle overflow-hidden shadow-xs border border-3 border-light mx-auto mb-2 bg-light" style="width: 110px; height: 110px;">
                                    <?php if (!empty($dPhoto)): ?>
                                        <img src="<?php echo (strpos($dPhoto, 'http') === 0) ? $dPhoto : BASE_URL . $dPhoto; ?>" 
                                             alt="<?php echo sanitize($dName); ?>" 
                                             class="w-100 h-100 object-fit-cover">
                                    <?php else: ?>
                                        <div class="w-100 h-100 bg-light d-flex flex-column align-items-center justify-content-center text-danger">
                                            <i class="fas fa-user-graduate fs-1"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h6 class="fw-bold text-navy mb-0" style="font-size: 0.92rem;"><?php echo sanitize($dName); ?></h6>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 mt-1 small" style="font-size: 0.72rem;"><?php echo sanitize($dDesig); ?></span>
                            </div>

                            <!-- Dean Message Content Column -->
                            <div class="flex-grow-1 border-start ps-md-4" style="border-color: #f1f5f9 !important;">
                                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                    <span class="badge bg-navy text-white px-3 py-1 rounded-pill small fw-bold"><i class="fas fa-quote-left me-1 text-warning"></i> Leadership Desk</span>
                                    <span class="text-muted small">Message from the <?php echo sanitize($dDesig); ?></span>
                                </div>
                                <h3 class="h6 fw-bold text-navy mb-2">Guiding Academic Excellence &amp; Innovation</h3>
                                <div class="text-secondary lead fs-6 fst-italic position-relative" style="line-height: 1.75; font-size: 0.95rem !important;">
                                    "<?php echo nl2br(sanitize($dMsg)); ?>"
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

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
