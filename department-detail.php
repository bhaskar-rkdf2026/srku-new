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

// RKDF IST: Dynamic PDF resolver — uses local file if downloaded, else falls back to live URL
$_istPdfBase = BASE_URL . 'assets/pdf/rkdf-ist/';
$_istPdfDir  = __DIR__ . '/assets/pdf/rkdf-ist/';
function istPdf(string $localRelPath, string $fallbackUrl): string {
    global $_istPdfDir, $_istPdfBase;
    return file_exists($_istPdfDir . $localRelPath)
        ? $_istPdfBase . $localRelPath
        : $fallbackUrl;
}
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
                            <div class="fw-bold text-navy fs-6">Degrees / Diplomas</div>
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
                // RKDF IST: Hardcode Director details as fallback when DB row is empty
                if ($dept['slug'] === 'rkdf-institute-of-science-and-technology') {
                    if (empty(trim($dept['dean_name'] ?? ''))) {
                        $dept['dean_name']        = 'Dr. Nilesh Diwakar';
                        $dept['dean_designation'] = 'Director';
                        $dept['dean_photo']       = 'assets/images/rkdf-ist/diwarkar-sir.jpg';
                        $dept['dean_message']     = "SRK University RKDF Institute of Science & Technology is a premier institute for professional studies. This institute has achieved ladder of engineering excellence since it's inception in 1995 & is recognized as one of the leading professional institutes in Madhya Pradesh, where students acquire technical & professional skills with cutting edge technology, knowledge & high moral standards. The growth achieved by this institution is significant. The institute is committed to offer quality technical education by adopting principle of mutual trust, fairness & positive orientation. The management, faculty members & supporting staff is committed to fulfill the expectations of all the stake holders i.e. students, parent, corporate community & society. The students are benefited with excellent infrastructure, dedicated faculty members & excellent track record of placement in corporate world. The vision of our faculties and their dedication to the cause of technical education combined with their dynamic approach to leadership has made a telling difference to the growth of the college. Our graduate students are selected in top notch organization, working in the field of software, energy, infrastructure, robotics & automation in fortune 500 companies of western world as well as MNCs of India. In the years to come RKDF Institute of Science & Technology shall play a significant role in the technology sector for developing trained & skilled human resources to serve the nation for better economic performance & growth.";
                    }
                }
                $dName = trim((string)($dept['dean_name'] ?? ''));
                $dMsg = trim((string)($dept['dean_message'] ?? ''));
                if (!empty($dName) && !empty($dMsg)): 
                    $dDesig = trim((string)($dept['dean_designation'] ?? 'Dean & Principal')) ?: 'Dean & Principal';
                    $dPhoto = trim((string)($dept['dean_photo'] ?? ''));
                ?>
                    <!-- Dean / Principal's Desk Message Section (Centered Top Profile Design) -->
                    <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 position-relative overflow-hidden bg-white" style="border: 1px solid #e2e8f0 !important; border-top: 5px solid #7a0b0d !important;">
                        
                        <!-- Top Header Badge -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-navy bg-opacity-10 text-navy rounded-pill small fw-bold mb-2">
                                <i class="fas fa-quote-left text-warning"></i> Leadership Desk &bull; Message from the <?php echo sanitize($dDesig); ?>
                            </div>
                        </div>

                        <!-- Top Centered Profile & Photo -->
                        <div class="text-center mb-4">
                            <div class="rounded-circle overflow-hidden shadow-sm border border-4 border-light mx-auto mb-3 bg-light" style="width: 135px; height: 135px;">
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
                            <h4 class="h5 fw-bold text-navy mb-1"><?php echo sanitize($dName); ?></h4>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 fw-semibold" style="font-size: 0.82rem;"><?php echo sanitize($dDesig); ?> &bull; <?php echo sanitize($dept['name']); ?></span>
                        </div>

                        <hr class="my-3 opacity-10">

                        <!-- Message Text Below the Photo & Profile -->
                        <div class="mt-3">
                            <h5 class="h6 fw-bold text-navy mb-3 text-center">
                                <i class="fas fa-award text-danger me-2"></i> Guiding Academic Excellence &amp; Innovation
                            </h5>
                            <div class="text-secondary lead fs-6 fst-italic position-relative p-3 p-md-4 rounded-4" style="line-height: 1.85; font-size: 0.96rem !important; background: #fafbfc; border-left: 4px solid var(--srku-maroon, #7a0b0d);">
                                <i class="fas fa-quote-left text-danger opacity-25 fa-2x position-absolute top-0 start-0 translate-middle ms-4 mt-3"></i>
                                &ldquo;<?php echo nl2br(sanitize($dMsg)); ?>&rdquo;
                            </div>
                        </div>

                    </div>
                <?php endif; ?>

                <?php if ($dept['slug'] === 'rkdf-institute-of-science-and-technology'): ?>
                <!-- ======================================================= -->
                <!-- RKDF IST: VISION & MISSION (above courses)               -->
                <!-- ======================================================= -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4" id="ist-vision-mission">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <i class="fas fa-compass fa-lg text-danger"></i>
                        <h3 class="fw-bold text-navy mb-0">Vision &amp; Mission</h3>
                    </div>
                    <div class="row g-4">
                        <!-- Vision -->
                        <div class="col-12 col-md-6">
                            <div class="h-100 p-4 rounded-4" style="background: linear-gradient(135deg, #0b1526 0%, #1e3a5f 100%);">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:38px;height:38px;">
                                        <i class="fas fa-eye text-dark small"></i>
                                    </div>
                                    <h4 class="h6 fw-bold text-white mb-0">Vision</h4>
                                </div>
                                <p class="fw-semibold mb-2" style="color:#fbbf24; font-size:0.85rem;">&ldquo;LEARN ABOUT EDUCATION THAT HELPS SOCIETY&rdquo;</p>
                                <p class="mb-0" style="color:rgba(255,255,255,0.85); font-size:0.88rem; line-height:1.8;">
                                    Sarvepalli Radhakrishnan University is an academic fraternity of individuals dedicated to the motto of ease learn about education that helps society. To emerge as a World &ndash; Class University in creating and disseminating knowledge, and providing students a unique learning experience in Science, Technology, Medicine, Management and other areas of life that will best serve the world and betterment of society. To create knowledge based society with scientific temper, team spirit and dignity of labor to face global competitive challenges.
                                </p>
                            </div>
                        </div>
                        <!-- Mission -->
                        <div class="col-12 col-md-6">
                            <div class="h-100 p-4 rounded-4" style="background: linear-gradient(135deg, #7a0b0d 0%, #b91c1c 100%);">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:38px;height:38px;">
                                        <i class="fas fa-bullseye text-danger small"></i>
                                    </div>
                                    <h4 class="h6 fw-bold text-white mb-0">Mission</h4>
                                </div>
                                <ul class="list-unstyled mb-0" style="color:rgba(255,255,255,0.9); font-size:0.85rem; line-height:1.75;">
                                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-1"></i> Nurturing ground for individual&rsquo;s holistic growth &amp; effective contribution to society.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-1"></i> Equip young professionals with dedication &amp; commitment to excellence in all spheres of life.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-1"></i> Facilitate intellectual stimulation to generate, maintain &amp; disseminate knowledge.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-1"></i> Empower participants to meet challenges of a collaborative &amp; competitive globalized environment.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-1"></i> Synergize excellence through world-class ambience &amp; inclusive culture.</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-1"></i> Foster sustainable environmental attitude.</li>
                                    <li><i class="fas fa-check-circle text-warning me-1"></i> Initiate trends which impact global higher education policies and practices.</li>
                                </ul>
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
                        <span class="badge bg-danger px-3 py-2 rounded-pill">Programs Available</span>
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
                                                    <span>Available Disciplines &amp; Specializations:</span>
                                                </div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <?php foreach ($specList as $sp): ?>
                                                        <span class="badge rounded-2 fw-medium py-2 px-3 text-start" style="background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; font-size: 0.83rem; white-space: normal; line-height: 1.4;">
                                                            &bull; <?php echo sanitize($sp); ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                    <span class="badge rounded-2 fw-medium py-2 px-3 text-start" style="background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; font-size: 0.83rem; white-space: normal; line-height: 1.4;">
                                                        &bull; &amp; many more...
                                                    </span>
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
                                                        <div class="small text-muted" style="line-height: 1.6;"><?php echo sanitize($c['career_scope']); ?><span class="text-secondary fw-semibold">, &amp; many more...</span></div>
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

                <?php if ($dept['slug'] === 'rkdf-institute-of-science-and-technology'): ?>

                <!-- ======================================================= -->
                <!-- RKDF IST: CAMPUS TOUR VIDEO                              -->
                <!-- ======================================================= -->
                <div class="rounded-4 overflow-hidden shadow-sm mt-4" id="ist-campus-tour" style="border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center gap-2 px-4 py-3 bg-dark">
                        <i class="fas fa-video text-warning"></i>
                        <h4 class="h6 fw-bold text-white mb-0">RKDF IST &mdash; Campus Tour</h4>
                        <span class="badge bg-danger ms-auto small">Official Video</span>
                    </div>
                    <video class="w-100 d-block" style="max-height:460px; object-fit:cover; background:#000;" autoplay muted loop playsinline controls>
                        <source src="<?php echo file_exists(__DIR__ . '/assets/videos/rkdf-ist/RKDF-IST-College-Tour.mp4') ? BASE_URL . 'assets/videos/rkdf-ist/RKDF-IST-College-Tour.mp4' : 'https://www.srku.edu.in/rkdf-ist/images/RKDF-IST-College-Tour.mp4'; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <!-- ======================================================= -->
                <!-- RKDF IST: ENGINEERING BRANCHES                           -->
                <!-- ======================================================= -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mt-4" id="ist-branches">
                    <h3 class="text-navy fw-bold mb-1"><i class="fas fa-sitemap text-danger me-2"></i> Engineering Branches</h3>
                    <p class="text-muted small mb-4">Specialized engineering branches offered under RKDF IST covering core, applied and emerging technology domains.</p>
                    <div class="row g-3">
                        <?php
                        $istBranches = [
                            ['icon' => 'fas fa-hard-hat',        'name' => 'Civil Engineering',                   'short' => 'CE'],
                            ['icon' => 'fas fa-cogs',            'name' => 'Mechanical Engineering',               'short' => 'ME'],
                            ['icon' => 'fas fa-laptop-code',     'name' => 'Computer Science Engineering',         'short' => 'CSE'],
                            ['icon' => 'fas fa-broadcast-tower', 'name' => 'Electronics &amp; Communication',      'short' => 'EC'],
                            ['icon' => 'fas fa-bolt',            'name' => 'Electrical &amp; Electronics Engg.',   'short' => 'EEE'],
                            ['icon' => 'fas fa-microchip',       'name' => 'Electronic Engineering',               'short' => 'EE'],
                            ['icon' => 'fas fa-tachometer-alt',  'name' => 'Electronics Instrumentation',          'short' => 'EI'],
                            ['icon' => 'fas fa-network-wired',   'name' => 'Information Technology',               'short' => 'IT'],
                        ];
                        foreach ($istBranches as $br): ?>
                            <div class="col-6 col-md-3">
                                <div class="p-3 bg-light rounded-3 text-center border h-100" style="transition:all 0.2s;">
                                    <div class="mb-2"><i class="<?php echo $br['icon']; ?> text-danger fa-lg"></i></div>
                                    <div class="fw-bold text-navy" style="font-size:0.85rem;"><?php echo $br['short']; ?></div>
                                    <div class="text-muted" style="font-size:0.73rem; line-height:1.3;"><?php echo $br['name']; ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- RKDF IST: SYLLABUS DOWNLOADS                             -->
                <!-- ======================================================= -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mt-4" id="ist-syllabus">
                    <h3 class="text-navy fw-bold mb-1"><i class="fas fa-book-open text-danger me-2"></i> Syllabus Downloads</h3>
                    <p class="text-muted small mb-4">Download official AICTE/UGC approved scheme &amp; syllabus for all programs offered at RKDF IST.</p>
                    <div class="accordion" id="syllabusAccordion">

                        <!-- B.E. / B.Tech -->
                        <div class="accordion-item border rounded-3 mb-2">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed rounded-3 fw-bold text-navy bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#syBtech" style="font-size:0.9rem;">
                                    <i class="fas fa-graduation-cap text-danger me-2"></i> B.E. / B.Tech Programs
                                </button>
                            </h2>
                            <div id="syBtech" class="accordion-collapse collapse" data-bs-parent="#syllabusAccordion">
                                <div class="accordion-body pt-2">
                                    <div class="row g-2">
                                        <?php
                                        $btechSyllabus = [
                                            ['branch' => 'All Branch – I &amp; II Sem (Reg. 2020)', 'url' => istPdf('syllabus/be-all-branch-i-ii-sem-2020.pdf',   'https://www.srku.edu.in/wp-content/uploads/2023/05/BE-ALL-BRANCH-I-II-SEM-SYLLABUS-REG-2020-BATCH-ONWARDS-1.pdf')],
                                            ['branch' => 'All Branch – I &amp; II Sem (Reg. 2021)', 'url' => istPdf('syllabus/be-all-branch-scheme-2021.pdf',     'http://srku.edu.in/rkdf-ist/images/pdf/b-tech-all-branches-scheme.pdf')],
                                            ['branch' => 'B.E. Mechanical – III to VIII Sem',       'url' => istPdf('syllabus/be-mechanical-iii-viii-2021.pdf',  'https://www.srku.edu.in/wp-content/uploads/2023/05/BE-MECHANICAL-III-VIII-SEM-SYLLABUS-2021-BATCH.pdf')],
                                            ['branch' => 'B.E. Civil – III to VIII Sem',             'url' => istPdf('syllabus/be-civil-iii-viii-2021.pdf',       'https://www.srku.edu.in/wp-content/uploads/2023/05/B.TECHCIVILIII-VIII-SEMESTER-SYLLABUSREG-2021-BATCH-ONWARDS.pdf')],
                                            ['branch' => 'B.E. CSE – III to VIII Sem',               'url' => istPdf('syllabus/be-cse-iii-viii-2021.pdf',         'https://www.srku.edu.in/wp-content/uploads/2023/05/B.TECHCSEIII-VIII-SEMESTER-SYLLABUSREG-2021-BATCH-ONWARDS.pdf')],
                                            ['branch' => 'B.E. EC – III to VIII Sem',                'url' => istPdf('syllabus/be-ec-iii-viii-2021.pdf',          'https://www.srku.edu.in/wp-content/uploads/2023/05/B.TECHECIII-VIII-SEMESTER-SYLLABUSREG-2021-BATCH-ONWARDS.pdf')],
                                            ['branch' => 'B.E. EE – III to VIII Sem',                'url' => istPdf('syllabus/be-ee-iii-viii-2021.pdf',          'https://www.srku.edu.in/wp-content/uploads/2023/05/B.TECHEEIII-VIII-SEMESTER-SCHEMEREG-2021-BATCH-ONWARDS.pdf')],
                                            ['branch' => 'B.E. EEE – III to VIII Sem',               'url' => istPdf('syllabus/be-eee-iii-viii-2021.pdf',         'https://www.srku.edu.in/wp-content/uploads/2023/05/B.TECHEEEIII-VIII-SEMESTER-SYLLABUSREG-2021-BATCH-ONWARDS.pdf')],
                                            ['branch' => 'B.E. EI – III to VIII Sem',                'url' => istPdf('syllabus/be-ei-iii-viii-2021.pdf',          'https://www.srku.edu.in/wp-content/uploads/2023/05/B.TECHEIIII-VIIII-SEMESTER-SYLLABUSREG-2021-ONWARDS-22.pdf')],
                                            ['branch' => 'B.E. IT – III to VIII Sem',                'url' => istPdf('syllabus/be-it-iii-viii-2021.pdf',          'https://www.srku.edu.in/wp-content/uploads/2023/05/B.TECHITIII-VIII-SEMESTER-SYLLABUSREG-2021-BATCH-ONWARDS.pdf')],
                                            ['branch' => 'B.E. Electronics – III to VIII Sem',       'url' => istPdf('syllabus/be-electronics-iii-viii-2019.pdf', 'https://www.srku.edu.in/wp-content/uploads/2023/05/BE-ELECTRONICS-III-VIII-sem-SCHEME-reg-2019-batch-onwards-1.pdf')],
                                        ];
                                        foreach ($btechSyllabus as $s): ?>
                                            <div class="col-12 col-md-6">
                                                <a href="<?php echo $s['url']; ?>" target="_blank" rel="noopener" class="d-flex align-items-center gap-2 p-2 px-3 rounded-3 text-decoration-none bg-light border text-dark small" style="transition:all 0.2s;">
                                                    <i class="fas fa-file-pdf text-danger flex-shrink-0"></i>
                                                    <span><?php echo $s['branch']; ?></span>
                                                    <i class="fas fa-download text-muted ms-auto" style="font-size:0.7rem;"></i>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- M.Tech -->
                        <div class="accordion-item border rounded-3 mb-2">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed rounded-3 fw-bold text-navy bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#syMtech" style="font-size:0.9rem;">
                                    <i class="fas fa-flask text-danger me-2"></i> M.Tech Programs
                                </button>
                            </h2>
                            <div id="syMtech" class="accordion-collapse collapse" data-bs-parent="#syllabusAccordion">
                                <div class="accordion-body pt-2">
                                    <div class="row g-2">
                                        <?php
                                        $mtechSyllabus = [
                                            ['branch' => 'M.Tech. VLSI – I to IV Sem',      'url' => istPdf('syllabus/mtech-vlsi-2020.pdf',      'https://www.srku.edu.in/wp-content/uploads/2023/05/M-TECH-VLSI-i-iv-sem-Scheme-reg-2020-batch-onwards.pdf')],
                                            ['branch' => 'M.Tech. Thermal – I to IV Sem',   'url' => istPdf('syllabus/mtech-thermal-2020.pdf',   'https://www.srku.edu.in/wp-content/uploads/2023/05/M.TECH-THERMAL-I-IV-SEM-SCHEME-REG-2020-BATCH-ONWARDS.pdf')],
                                            ['branch' => 'M.Tech. Structure – I to IV Sem', 'url' => istPdf('syllabus/mtech-structure.pdf',      'https://srku.edu.in/wp-content/uploads/2023/05/MTECH-SYLLABUS.pdf')],
                                            ['branch' => 'M.Tech. CSE – I to IV Sem',       'url' => istPdf('syllabus/mtech-cse-se.pdf',         'https://www.srku.edu.in/wp-content/uploads/2023/05/MTECH-SE-SCHEME.pdf')],
                                            ['branch' => 'M.Tech. IT – I to IV Sem',        'url' => istPdf('syllabus/mtech-it-2016.pdf',        'https://www.srku.edu.in/wp-content/uploads/2023/05/M.TECHIT-I-IV-SEMREG-2016-BATCH-ON-WORD.pdf')],
                                            ['branch' => 'M.Tech. SE – I to IV Sem',        'url' => istPdf('syllabus/mtech-cse-se.pdf',         'https://www.srku.edu.in/wp-content/uploads/2023/05/MTECH-SE-SCHEME.pdf')],
                                            ['branch' => 'M.Tech. MWM – I to IV Sem',       'url' => istPdf('syllabus/mtech-mwm-2020.pdf',       'https://www.srku.edu.in/wp-content/uploads/2023/05/04-DEC-2020-MTECH-MWM-SYLLABUS-AICTE.pdf')],
                                            ['branch' => 'M.Tech. DC – I to IV Sem',        'url' => istPdf('syllabus/mtech-dc-2020.pdf',        'https://www.srku.edu.in/wp-content/uploads/2023/05/04-DEC-2020-MTECH-DC-SYLLABUS-AICTE.pdf')],
                                            ['branch' => 'M.Tech. PE – I to IV Sem',        'url' => istPdf('syllabus/mtech-pe.pdf',             'https://www.srku.edu.in/wp-content/uploads/2023/05/22-DEC-MTECH-SCHEME_PE.pdf')],
                                        ];
                                        foreach ($mtechSyllabus as $s): ?>
                                            <div class="col-12 col-md-6">
                                                <a href="<?php echo $s['url']; ?>" target="_blank" rel="noopener" class="d-flex align-items-center gap-2 p-2 px-3 rounded-3 text-decoration-none bg-light border text-dark small" style="transition:all 0.2s;">
                                                    <i class="fas fa-file-pdf text-danger flex-shrink-0"></i>
                                                    <span><?php echo $s['branch']; ?></span>
                                                    <i class="fas fa-download text-muted ms-auto" style="font-size:0.7rem;"></i>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- M.C.A. -->
                        <div class="accordion-item border rounded-3 mb-2">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed rounded-3 fw-bold text-navy bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#syMca" style="font-size:0.9rem;">
                                    <i class="fas fa-code text-danger me-2"></i> M.C.A. Program
                                </button>
                            </h2>
                            <div id="syMca" class="accordion-collapse collapse" data-bs-parent="#syllabusAccordion">
                                <div class="accordion-body pt-2">
                                    <div class="row g-2">
                                        <?php
                                        $mcaSyllabus = [
                                            ['branch' => 'MCA – First Semester',   'url' => istPdf('syllabus/mca-sem1.pdf', 'https://www.srku.edu.in/wp-content/uploads/2023/05/MCA-I-Sem-Scheme-Syllabus.pdf')],
                                            ['branch' => 'MCA – Second Semester',  'url' => istPdf('syllabus/mca-sem2.pdf', 'https://www.srku.edu.in/wp-content/uploads/2023/05/MCA-II-Sem-Scheme-Syllabus.pdf')],
                                            ['branch' => 'MCA – Third Semester',   'url' => istPdf('syllabus/mca-sem3.pdf', 'https://www.srku.edu.in/wp-content/uploads/2023/05/MCA-III-Sem-Scheme-Syllabus.pdf')],
                                            ['branch' => 'MCA – Fourth Semester',  'url' => istPdf('syllabus/mca-sem4.pdf', 'https://www.srku.edu.in/wp-content/uploads/2023/05/MCA-IV-Sem-Scheme-Syllabus.pdf')],
                                            ['branch' => 'MCA – Fifth Semester',   'url' => istPdf('syllabus/mca-sem5.pdf', 'https://www.srku.edu.in/wp-content/uploads/2023/05/MCA-V-Sem-Scheme-Syllabus.pdf')],
                                            ['branch' => 'MCA – Sixth Semester',   'url' => istPdf('syllabus/mca-sem6.pdf', 'https://www.srku.edu.in/wp-content/uploads/2023/05/MCA-VI-Sem-Scheme-Syllabus.pdf')],
                                        ];
                                        foreach ($mcaSyllabus as $s): ?>
                                            <div class="col-12 col-md-6">
                                                <a href="<?php echo $s['url']; ?>" target="_blank" rel="noopener" class="d-flex align-items-center gap-2 p-2 px-3 rounded-3 text-decoration-none bg-light border text-dark small" style="transition:all 0.2s;">
                                                    <i class="fas fa-file-pdf text-danger flex-shrink-0"></i>
                                                    <span><?php echo $s['branch']; ?></span>
                                                    <i class="fas fa-download text-muted ms-auto" style="font-size:0.7rem;"></i>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- M.B.A. -->
                        <div class="accordion-item border rounded-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed rounded-3 fw-bold text-navy bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#syMba" style="font-size:0.9rem;">
                                    <i class="fas fa-briefcase text-danger me-2"></i> M.B.A. Program
                                </button>
                            </h2>
                            <div id="syMba" class="accordion-collapse collapse" data-bs-parent="#syllabusAccordion">
                                <div class="accordion-body pt-2">
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">
                                            <a href="<?php echo istPdf('syllabus/mba-ft-year1.pdf', 'https://www.srku.edu.in/wp-content/uploads/2023/05/MBAFT-1st-year-syllabus.pdf'); ?>" target="_blank" rel="noopener" class="d-flex align-items-center gap-2 p-2 px-3 rounded-3 text-decoration-none bg-light border text-dark small">
                                                <i class="fas fa-file-pdf text-danger flex-shrink-0"></i>
                                                <span>M.B.A. Full Time &ndash; 1st Year Syllabus</span>
                                                <i class="fas fa-download text-muted ms-auto" style="font-size:0.7rem;"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- RKDF IST: AICTE EOA APPROVAL REPORTS                     -->
                <!-- ======================================================= -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mt-4" id="ist-eoa-reports">
                    <h3 class="text-navy fw-bold mb-1"><i class="fas fa-stamp text-danger me-2"></i> AICTE Approval &mdash; EOA Reports</h3>
                    <p class="text-muted small mb-4">Official Extension of Approval (EOA) reports issued by AICTE for RKDF IST, year-wise from 2013 onwards.</p>
                    <div class="row g-2">
                        <?php
                        $eoaReports = [
                            ['year' => '2026&ndash;27', 'url' => istPdf('eoa/eoa-2026-27.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/EOA-Report_2026-2027.pdf')],
                            ['year' => '2025&ndash;26', 'url' => istPdf('eoa/eoa-2025-26.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/RKDFIST-EOA2025-26.pdf')],
                            ['year' => '2024&ndash;25', 'url' => istPdf('eoa/eoa-2024-25.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/RKDFIST-EOA-2024-25.pdf')],
                            ['year' => '2023&ndash;24', 'url' => istPdf('eoa/eoa-2023-24.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/EOA-Report-2023-24.PDF')],
                            ['year' => '2022&ndash;23', 'url' => istPdf('eoa/eoa-2022-23.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/EOA-Report-2022-23.PDF')],
                            ['year' => '2021&ndash;22', 'url' => istPdf('eoa/eoa-2021-22.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/EOA-Report_21-22.PDF')],
                            ['year' => '2020&ndash;21', 'url' => istPdf('eoa/eoa-2020-21.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/RKDF-IST-2020-21.pdf')],
                            ['year' => '2019&ndash;20', 'url' => istPdf('eoa/eoa-2019-20.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/EOA-Report_2019-20.PDF')],
                            ['year' => '2018&ndash;19', 'url' => istPdf('eoa/eoa-2018-19.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/EOA-Report_2018-19.PDF')],
                            ['year' => '2016&ndash;17', 'url' => istPdf('eoa/eoa-2016-17.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/RKDFIST_2016-17.pdf')],
                            ['year' => '2015&ndash;16', 'url' => istPdf('eoa/eoa-2015-16.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/EOA-Report%202015-16.PDF')],
                            ['year' => '2014&ndash;15', 'url' => istPdf('eoa/eoa-2014-15.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/EOA-Report%202014-15.PDF')],
                            ['year' => '2013&ndash;14', 'url' => istPdf('eoa/eoa-2013-14.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/approvals/EOA-Report-2013-14.PDF')],
                        ];
                        foreach ($eoaReports as $eoa): ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="<?php echo $eoa['url']; ?>" target="_blank" rel="noopener"
                                   class="d-flex align-items-center gap-2 p-2 px-3 rounded-3 text-decoration-none text-dark bg-light border small" style="transition:all 0.2s;">
                                    <i class="fas fa-file-alt text-danger flex-shrink-0"></i>
                                    <span class="fw-semibold">EOA <?php echo $eoa['year']; ?></span>
                                    <i class="fas fa-download text-muted ms-auto" style="font-size:0.65rem;"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- RKDF IST: STATUTORY COMMITTEES                           -->
                <!-- ======================================================= -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mt-4" id="ist-committees">
                    <h3 class="text-navy fw-bold mb-1"><i class="fas fa-users-cog text-danger me-2"></i> Statutory Committees</h3>
                    <p class="text-muted small mb-4">AICTE/UGC mandated committees constituted at RKDF IST for student welfare &amp; institutional governance.</p>
                    <div class="row g-3">
                        <?php
                        $committees = [
                            ['name' => 'Anti Ragging Committee',          'icon' => 'fas fa-shield-alt',       'url' => istPdf('committees/anti-ragging.pdf',             'https://www.srku.edu.in/wp-content/uploads/2024/07/anti-ragging-committee.pdf')],
                            ['name' => 'Student Grievance Committee',     'icon' => 'fas fa-comment-alt',      'url' => istPdf('committees/student-grievance.pdf',        'https://www.srku.edu.in/wp-content/uploads/2024/07/student-grievance-committee.pdf')],
                            ['name' => 'Women Grievance Committee',       'icon' => 'fas fa-female',           'url' => istPdf('committees/women-grievance.pdf',          'https://www.srku.edu.in/wp-content/uploads/2024/07/women-grievance-committee.pdf')],
                            ['name' => 'OBC &amp; Minority Committee',    'icon' => 'fas fa-balance-scale',    'url' => istPdf('committees/obc-minority.pdf',             'https://www.srku.edu.in/wp-content/uploads/2024/07/obc-minority-grievance-committee.pdf')],
                            ['name' => 'SC &amp; ST Committee',           'icon' => 'fas fa-hands-helping',    'url' => istPdf('committees/sc-st.pdf',                    'https://www.srku.edu.in/wp-content/uploads/2024/07/Sc-ST-committee.pdf')],
                            ['name' => 'Internal Complaint Committee',    'icon' => 'fas fa-gavel',            'url' => istPdf('committees/internal-complaint.pdf',       'https://www.srku.edu.in/wp-content/uploads/2024/07/Internal-complaint.pdf')],
                            ['name' => 'IQAC Committee',                  'icon' => 'fas fa-award',            'url' => istPdf('committees/iqac.pdf',                     'https://www.srku.edu.in/rkdf-ist/committee/IQAC.pdf')],
                            ['name' => 'Employee &amp; Student Redressal','icon' => 'fas fa-user-shield',      'url' => istPdf('committees/employee-student-redressal.pdf','https://www.srku.edu.in/rkdf-ist/committee/EmployeesAndStudentRedressal.pdf')],
                        ];
                        foreach ($committees as $com): ?>
                            <div class="col-12 col-md-6">
                                <a href="<?php echo $com['url']; ?>" target="_blank" rel="noopener"
                                   class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border text-decoration-none text-dark h-100" style="transition:all 0.2s;">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm border flex-shrink-0" style="width:40px;height:40px;">
                                        <i class="<?php echo $com['icon']; ?> text-danger small"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold text-navy" style="font-size:0.85rem;"><?php echo $com['name']; ?></div>
                                        <div class="text-muted" style="font-size:0.72rem;">Click to view PDF</div>
                                    </div>
                                    <i class="fas fa-file-pdf text-danger small"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- RKDF IST: FEEDBACK FORMS                                 -->
                <!-- ======================================================= -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mt-4" id="ist-feedback">
                    <h3 class="text-navy fw-bold mb-1"><i class="fas fa-poll text-danger me-2"></i> Feedback Forms</h3>
                    <p class="text-muted small mb-4">Official feedback forms for students, parents, and faculty for continuous improvement and quality assurance at RKDF IST.</p>
                    <div class="row g-3">
                        <?php
                        $feedbackForms = [
                            ['name' => 'Student Feedback Form',                    'type' => 'PDF',    'icon' => 'fas fa-user-graduate',       'url' => istPdf('feedback/student-feedback.pdf',             'https://www.srku.edu.in/rkdf-ist/images/pdf/ist/STUDENT-FEEDBACK-FORM_page-0001.pdf')],
                            ['name' => 'Teacher Curriculum Feedback',              'type' => 'PDF',    'icon' => 'fas fa-chalkboard-teacher',  'url' => istPdf('feedback/teacher-curriculum-feedback.pdf',  'https://www.srku.edu.in/rkdf-ist/images/pdf/ist/feedback-on-curriculum-for-teachers_page-0001.pdf')],
                            ['name' => 'Parent Feedback Form',                     'type' => 'PDF',    'icon' => 'fas fa-users',               'url' => istPdf('feedback/parent-feedback.pdf',              'https://www.srku.edu.in/rkdf-ist/images/pdf/ist/Parent-Feed-Back-converted_page-0001%20(1).pdf')],
                            ['name' => 'Online Student Feedback',                  'type' => 'Online', 'icon' => 'fas fa-laptop',              'url' => BASE_URL . 'rkdf-ist-student-feedback.php'],
                            ['name' => 'Online Curriculum Feedback (Teachers)',    'type' => 'Online', 'icon' => 'fas fa-clipboard-list',      'url' => BASE_URL . 'rkdf-ist-teacher-feedback.php'],
                            ['name' => 'Online Parent Feedback Form',              'type' => 'Online', 'icon' => 'fas fa-home',                'url' => BASE_URL . 'rkdf-ist-parent-feedback.php'],
                        ];
                        foreach ($feedbackForms as $fb): ?>
                            <div class="col-12 col-md-6">
                                <a href="<?php echo $fb['url']; ?>" <?php echo $fb['type'] === 'PDF' ? 'target="_blank"' : ''; ?> rel="noopener"
                                   class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border text-decoration-none text-dark h-100" style="transition:all 0.2s;">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm border flex-shrink-0" style="width:40px;height:40px;">
                                        <i class="<?php echo $fb['icon']; ?> text-danger small"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold text-navy" style="font-size:0.85rem;"><?php echo $fb['name']; ?></div>
                                        <span class="badge <?php echo $fb['type'] === 'Online' ? 'bg-success' : 'bg-secondary'; ?> mt-1" style="font-size:0.65rem;"><?php echo $fb['type']; ?></span>
                                    </div>
                                    <i class="fas fa-<?php echo $fb['type'] === 'Online' ? 'arrow-right' : 'file-pdf'; ?> text-muted small"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php endif; // end RKDF IST left-column sections ?>

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
                        <a href="<?php echo BASE_URL; ?>departments.php" class="btn btn-sm btn-outline-secondary w-100">View All Constituent Units</a>
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

                <?php if ($dept['slug'] === 'rkdf-institute-of-science-and-technology'): ?>

                <!-- ======================================================= -->
                <!-- RKDF IST SIDEBAR: IMPORTANT DOWNLOADS                    -->
                <!-- ======================================================= -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mt-4 bg-white" id="ist-downloads">
                    <h5 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="fas fa-download text-danger me-2"></i> Important Downloads</h5>
                    <div class="d-flex flex-column gap-2">
                        <?php
                        $impDownloads = [
                            ['name' => 'Faculty List',                'icon' => 'fas fa-users',        'url' => istPdf('downloads/faculty-list.pdf',          'https://www.srku.edu.in/rkdf-ist/images/RKDF-IST-FACULTY-LIST.pdf')],
                            ['name' => 'Mandatory Disclosures',       'icon' => 'fas fa-file-alt',     'url' => istPdf('downloads/mandatory-disclosures.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/RKDF%20IST%20Mandatory%20Disclosures.pdf')],
                            ['name' => 'Accreditation Status',        'icon' => 'fas fa-certificate',  'url' => istPdf('downloads/accreditation-status.pdf', 'https://www.srku.edu.in/rkdf-ist/images/pdf/AccreditationStatusRKDFIST.pdf')],
                            ['name' => 'Board of Governors (BOG)',    'icon' => 'fas fa-landmark',     'url' => istPdf('downloads/governing-body.pdf',       'https://www.srku.edu.in/rkdf-ist/images/pdf/Governing-Body.pdf')],
                            ['name' => 'Board of Management (BOM)',   'icon' => 'fas fa-sitemap',      'url' => istPdf('downloads/board-of-management.pdf',  'https://www.srku.edu.in/rkdf-ist/images/pdf/Board-of-Management.pdf')],
                            ['name' => 'Vacancy / Recruitment',       'icon' => 'fas fa-briefcase',    'url' => istPdf('downloads/vacancy-recruitment.pdf',  'https://www.srku.edu.in/rkdf-ist/rkdf-ist-mca/images/SRKU-Requirement-Paper.pdf')],
                            ['name' => 'Fee Payment Link',            'icon' => 'fas fa-credit-card',  'url' => istPdf('downloads/payment-link.pdf',          'https://www.srku.edu.in/rkdf-ist/rkdf-ist-mca/images/payment-link.pdf')],
                        ];
                        foreach ($impDownloads as $dl): ?>
                            <a href="<?php echo $dl['url']; ?>" target="_blank" rel="noopener"
                               class="d-flex align-items-center gap-2 p-2 px-3 rounded-3 bg-light border text-decoration-none text-dark small" style="transition:all 0.2s;">
                                <i class="<?php echo $dl['icon']; ?> text-danger flex-shrink-0"></i>
                                <span class="fw-semibold text-truncate"><?php echo $dl['name']; ?></span>
                                <i class="fas fa-file-pdf text-muted ms-auto" style="font-size:0.7rem;"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- RKDF IST SIDEBAR: GRIEVANCE & CONTACT                    -->
                <!-- ======================================================= -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mt-4 bg-white">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-headset text-danger me-2"></i> Dept. Contact &amp; Grievance</h5>
                    <div class="d-flex flex-column gap-2 small mb-3">
                        <div class="d-flex align-items-center gap-2 p-2 px-3 bg-light rounded-3 border">
                            <i class="fas fa-envelope text-danger flex-shrink-0"></i>
                            <a href="mailto:deanengg@srku.edu.in" class="text-decoration-none text-dark fw-semibold text-truncate">deanengg@srku.edu.in</a>
                        </div>
                        <div class="d-flex align-items-center gap-2 p-2 px-3 bg-light rounded-3 border">
                            <i class="fas fa-phone text-danger flex-shrink-0"></i>
                            <span class="fw-semibold">0755 &ndash; 4911204</span>
                            <span class="badge bg-danger-subtle text-danger ms-auto" style="font-size:0.62rem;">Women Helpline</span>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>rkdf-ist-grievance.php" class="btn btn-outline-danger btn-sm w-100 fw-semibold">
                        <i class="fas fa-file-signature me-1"></i> Submit Grievance Online
                    </a>
                </div>

                <!-- ======================================================= -->
                <!-- RKDF IST SIDEBAR: GOOGLE MAPS                            -->
                <!-- ======================================================= -->
                <div class="card border-0 shadow-sm rounded-4 mt-4 overflow-hidden">
                    <div class="d-flex align-items-center gap-2 px-3 py-3 bg-light border-bottom">
                        <i class="fas fa-map-marker-alt text-danger"></i>
                        <h5 class="fw-bold text-navy mb-0 small">Campus Location</h5>
                    </div>
                    <div class="px-3 py-2 bg-light border-bottom">
                        <span class="text-muted" style="font-size:0.78rem;">
                            <i class="fas fa-location-dot text-danger me-1"></i>
                            Jatkhedi, Hoshangabad Road, Misrod, Bhopal &ndash; M.P.
                        </span>
                    </div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7335.482809167967!2d77.47361302726313!3d23.179636406945196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397c3673db484b05%3A0x3118458cd27bc403!2sSarvepalli%20Radhakrishnan%20University%2C%20Bhopal!5e0!3m2!1sen!2sin!4v1727853814441!5m2!1sen!2sin"
                            width="100%" height="250" style="border:0; display:block;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" title="SRKU Campus Map">
                    </iframe>
                </div>

                <?php endif; // end RKDF IST sidebar sections ?>

            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
