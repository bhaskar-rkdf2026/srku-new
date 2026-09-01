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

$alliedFacultiesConfig = [
    'faculty-of-science' => [
        'name' => 'Faculty of Science',
        'icon' => 'fa-atom',
        'color' => '#0284c7'
    ],
    'faculty-of-arts' => [
        'name' => 'Faculty of Arts',
        'icon' => 'fa-palette',
        'color' => '#d97706'
    ],
    'faculty-of-commerce' => [
        'name' => 'Faculty of Commerce',
        'icon' => 'fa-chart-line',
        'color' => '#059669'
    ],
    'faculty-of-management' => [
        'name' => 'Faculty of Management',
        'icon' => 'fa-briefcase',
        'color' => '#7c3aed'
    ],
    'faculty-of-computer-application' => [
        'name' => 'Faculty of Computer Application',
        'icon' => 'fa-laptop-code',
        'color' => '#2563eb'
    ],
    'faculty-of-library-science' => [
        'name' => 'Faculty of Library & Information Science',
        'icon' => 'fa-book-reader',
        'color' => '#e11d48'
    ],
    'faculty-of-yoga' => [
        'name' => 'Faculty of Yoga',
        'icon' => 'fa-spa',
        'color' => '#16a34a'
    ],
    'faculty-of-fashion-technology-design' => [
        'name' => 'Faculty of Fashion Technology & Design',
        'icon' => 'fa-tshirt',
        'color' => '#db2777'
    ]
];

// Redirect sub-faculty URLs directly to their section in the unified Allied Sciences department page
if (isset($alliedFacultiesConfig[$dept['slug']])) {
    header("Location: " . BASE_URL . "allied-sciences#" . $dept['slug']);
    exit;
}

$isAlliedSciences = ($dept['slug'] === 'allied-sciences');
$alliedGroupedCourses = [];

$pageTitle = sanitize($dept['name']) . " | Programmes & Admissions | SRKU";
$pageDesc = "Explore academic programs, laboratory infrastructure, distinguished faculty, and admissions at " . sanitize($dept['name']) . ", Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = sanitize($dept['name']) . ", SRKU Department, Courses, Admissions Bhopal, Faculty";
$activeNav = "departments";
require_once __DIR__ . '/includes/header.php';

if ($isAlliedSciences) {
    $pdoConn = getDBConnection();
    $fSlugs = array_keys($alliedFacultiesConfig);
    $inPlaceholders = implode(',', array_fill(0, count($fSlugs), '?'));
    $stmtAllied = $pdoConn->prepare("SELECT * FROM courses WHERE dept_slug IN ($inPlaceholders) AND status = 'active' ORDER BY id ASC");
    $stmtAllied->execute($fSlugs);
    $allCoursesAllied = $stmtAllied->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fSlugs as $fSlug) {
        $alliedGroupedCourses[$fSlug] = [];
    }
    foreach ($allCoursesAllied as $c) {
        $lvl = strtolower(trim($c['level'] ?? ''));
        $degLvl = strtolower(trim($c['degree_level'] ?? ''));
        if (in_array($lvl, ['doctorate', 'phd', 'ph.d', 'doctoral']) || in_array($degLvl, ['doctorate', 'phd', 'ph.d', 'doctoral'])) {
            continue;
        }
        $fSlug = $c['dept_slug'];
        if (isset($alliedGroupedCourses[$fSlug])) {
            $alliedGroupedCourses[$fSlug][] = $c;
        }
    }
    // Sort each faculty's courses level-wise (Diploma -> UG -> PG)
    foreach ($alliedGroupedCourses as $fSlug => &$cList) {
        usort($cList, function($a, $b) {
            $getLevelRank = function($item) {
                $lvl = strtolower(trim($item['level'] ?? ''));
                $degLvl = strtolower(trim($item['degree_level'] ?? ''));
                $name = strtolower(trim($item['course_name'] ?? ''));
                if ($lvl === 'diploma' || strpos($name, 'diploma') !== false || strpos($name, 'dca') !== false || strpos($name, 'pgdca') !== false || strpos($name, 'pgdyt') !== false) {
                    return 10;
                }
                if ($lvl === 'ug' || $degLvl === 'ug' || strpos($name, 'b.') !== false || strpos($name, 'bachelor') !== false) {
                    return 20;
                }
                if ($lvl === 'pg' || $degLvl === 'pg' || strpos($name, 'm.') !== false || strpos($name, 'master') !== false || strpos($name, 'msw') !== false) {
                    return 30;
                }
                return 40;
            };
            return $getLevelRank($a) <=> $getLevelRank($b);
        });
    }
    unset($cList);
    $courses = $allCoursesAllied;
} else {
    $courses = getCourses($dept['slug']);
    if (empty($courses)) {
        $courses = getCourses($dept['name']);
    }

    // Filter out Doctorate / PhD programs from department pages
    $courses = array_values(array_filter($courses, function($c) {
        $lvl = strtolower(trim($c['level'] ?? ''));
        $degLvl = strtolower(trim($c['degree_level'] ?? ''));
        return !in_array($lvl, ['doctorate', 'phd', 'ph.d', 'doctoral']) && !in_array($degLvl, ['doctorate', 'phd', 'ph.d', 'doctoral']);
    }));
}

// Order courses strictly by level hierarchy: Diploma -> UG -> PG (M.Tech/M.E. -> MCA -> MBA -> M.Pharm -> M.Sc -> NPCC -> MDS -> MD)
usort($courses, function($a, $b) {
    $getLevelRank = function($item) {
        $lvl = strtolower(trim($item['level'] ?? ''));
        $degLvl = strtolower(trim($item['degree_level'] ?? ''));
        $name = strtolower(trim($item['course_name'] ?? ''));

        // 1. Diploma / Polytechnic / GNM
        if ($lvl === 'diploma' || strpos($name, 'diploma') !== false || strpos($name, 'polytechnic') !== false || strpos($name, 'gnm') !== false) {
            return 10;
        }
        // 2. UG / Undergraduate / B.Tech / B.Pharm / BHMS / BDS / B.Sc.
        if ($lvl === 'ug' || $degLvl === 'ug' || strpos($name, 'b.') !== false || strpos($name, 'bachelor') !== false || strpos($name, 'b.tech') !== false || strpos($name, 'bhms') !== false || strpos($name, 'bds') !== false) {
            if (strpos($name, 'post basic') !== false) return 22;
            return 20;
        }
        // 3. PG / Postgraduate / M.Tech / MCA / MBA / Master / MDS / MD / NPCC
        if ($lvl === 'pg' || $degLvl === 'pg' || strpos($name, 'm.') !== false || strpos($name, 'master') !== false || strpos($name, 'mba') !== false || strpos($name, 'mca') !== false || strpos($name, 'm.tech') !== false || strpos($name, 'mds') !== false || strpos($name, 'md') !== false || strpos($name, 'npcc') !== false) {
            if (strpos($name, 'm.tech') !== false || strpos($name, 'm.e') !== false) return 31;
            if (strpos($name, 'mca') !== false) return 32;
            if (strpos($name, 'mba') !== false) return 33;
            if (strpos($name, 'm.pharm') !== false) return 34;
            if (strpos($name, 'm.sc') !== false) return 35;
            if (strpos($name, 'npcc') !== false) return 36;
            if (strpos($name, 'mds') !== false) return 37;
            if (strpos($name, 'md') !== false) return 38;
            return 39;
        }
        return 50;
    };

    $rankA = $getLevelRank($a);
    $rankB = $getLevelRank($b);
    if ($rankA !== $rankB) {
        return $rankA <=> $rankB;
    }
    return ($a['id'] ?? 0) <=> ($b['id'] ?? 0);
});

// Group courses by level
$ugCourses = array_filter($courses, fn($c) => $c['level'] === 'UG');
$pgCourses = array_filter($courses, fn($c) => $c['level'] === 'PG');
$dipCourses = array_filter($courses, fn($c) => in_array($c['level'], ['Diploma', 'Certificate']));

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

// Dedicated External Websites Map for standalone portals with rich metadata
$externalWebsiteMeta = [
    'rkdf-medical-college' => [
        'url' => 'https://rkdfmedicalcollege.org/',
        'btn' => 'Visit Official Hospital & Medical College Website',
        'badge' => '750+ Bed Teaching Hospital & Super-Specialty Healthcare',
        'desc' => 'Visit the dedicated hospital portal for 24x7 Emergency, Trauma Care, OPD Timings, Bed Availability, Blood Bank, and Clinical Departments.',
        'icon' => 'fa-hospital-user'
    ],
    'rkdf-dental-college' => [
        'url' => 'http://rkdfdentalcollege.in/',
        'btn' => 'Visit Official Dental College & Hospital Website',
        'badge' => '250+ Dental Treatment Chairs & Specialized OPD Clinics',
        'desc' => 'Access the official dental portal for patient consultations, maxillofacial surgery, orthodontic clinic, and dental hospital services.',
        'icon' => 'fa-tooth'
    ],
    'rkdf-homoeopathic-medical-college' => [
        'url' => 'http://www.rkdfhmc.in/',
        'btn' => 'Visit Official Homoeopathic Hospital Website',
        'badge' => 'Homoeopathic Clinical Hospital & OPD Services',
        'desc' => 'Explore the dedicated portal for hospital clinical services, patient consultations, and academic BHMS details.',
        'icon' => 'fa-clinic-medical'
    ],
    'sarvepalli-radhakrishnan-college-of-ayurveda' => [
        'url' => 'https://www.srkcahrc.in/',
        'btn' => 'Visit Official Ayurveda Hospital & College Website',
        'badge' => '60-Bed Ayurvedic Hospital with Panchakarma & Herbal Pharmacy',
        'desc' => 'Visit the official portal for Ayurvedic OPD consultations, Panchakarma therapies, in-house herbal pharmacy, and BAMS admissions.',
        'icon' => 'fa-leaf'
    ],
    'rkdf-institute-of-science-and-technology' => [
        'url' => 'https://srku.edu.in/rkdf-ist/index.php',
        'btn' => 'Visit Official RKDF IST Engineering Portal',
        'badge' => 'Pioneer Engineering Institution Est. 1995',
        'desc' => 'Access technical laboratories, departmental workshops, campus placements, AICTE compliance, and incubation centres.',
        'icon' => 'fa-cogs'
    ],
    'faculty-of-agriculture' => [
        'url' => 'https://srku.edu.in/agriculture/index.php',
        'btn' => 'Visit Official Faculty of Agriculture Portal',
        'badge' => 'Experimental Research Farms & Crop Polyhouses',
        'desc' => 'Explore agricultural research labs, crop fields, soil testing facilities, and ICAR 6th Dean committee curriculum details.',
        'icon' => 'fa-seedling'
    ]
];

$sealFile = $exactSeals[$dept['slug']] ?? null;
$extMeta = $externalWebsiteMeta[$dept['slug']] ?? null;
$officialWebsite = $extMeta['url'] ?? null;
$deptImg = !empty($dept['image']) ? $dept['image'] : (!empty($dept['banner_img']) ? $dept['banner_img'] : '');
if (empty($deptImg) || !file_exists(__DIR__ . '/' . ltrim(str_replace('\\', '/', $deptImg), '/'))) {
    $cand = 'assets/uploads/constituent-units/' . ($dept['slug'] ?? '') . '.webp';
    if (file_exists(__DIR__ . '/' . $cand)) {
        $deptImg = $cand;
    } else {
        $deptImg = 'assets/uploads/2026/07/001.webp';
    }
}
$deptImgSrc = resolveMediaUrl($deptImg, 'assets/uploads/2026/07/001.webp');

// Other departments for sidebar
$allDepts = getDepartments(true);
$otherDepts = array_filter($allDepts, fn($d) => $d['id'] != $dept['id']);

// RKDF IST: Dynamic PDF resolver — uses local file if downloaded, else falls back to live URL
$_istPdfBase = BASE_URL . 'assets/pdf/rkdf-ist/';
$_istPdfDir  = __DIR__ . '/assets/pdf/rkdf-ist/';
if (!function_exists('istPdf')) {
    function istPdf(string $localRelPath, string $fallbackUrl): string {
        global $_istPdfDir, $_istPdfBase;
        return file_exists($_istPdfDir . $localRelPath)
            ? $_istPdfBase . $localRelPath
            : $fallbackUrl;
    }
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
                    <i class="fas <?php echo $extMeta['icon'] ?? 'fa-globe'; ?>"></i> <?php echo sanitize($extMeta['btn'] ?? 'Visit Official Website'); ?> <i class="fas fa-external-link-alt ms-1" style="font-size:0.75rem;"></i>
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

<section class="py-4 py-lg-5">
    <div class="container-fluid px-3 px-md-4 px-xl-5 py-2" style="max-width: 1520px;">
        <div class="row g-3 g-lg-4">
            
            <!-- Left Main Column (Wider Content Area) -->
            <div class="col-12 col-lg-8 col-xl-9">
                
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
                            <div class="fw-bold text-danger fs-6">Active Assistance</div>
                        </div>
                    </div>
                </div>

                <?php if ($officialWebsite && $extMeta): ?>
                    <!-- Official Website Callout Box -->
                    <div class="card p-3 p-md-4 border-0 rounded-4 mb-4 shadow-sm" style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border-left: 5px solid #ea580c !important;">
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white rounded-circle p-2 shadow-xs border d-flex align-items-center justify-content-center" style="width:56px; height:56px; flex-shrink:0;">
                                    <i class="fas <?php echo $extMeta['icon']; ?> text-danger fs-3"></i>
                                </div>
                                <div>
                                    <div class="badge bg-danger text-white rounded-pill px-2 py-1 small fw-semibold mb-1">
                                        <?php echo sanitize($extMeta['badge']); ?>
                                    </div>
                                    <h4 class="h6 fw-bold text-dark mb-1"><?php echo sanitize($extMeta['btn']); ?></h4>
                                    <p class="text-muted small mb-0"><?php echo sanitize($extMeta['desc']); ?></p>
                                </div>
                            </div>
                            <a href="<?php echo $officialWebsite; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-danger btn-sm px-4 py-2 fw-semibold text-nowrap rounded-pill d-inline-flex align-items-center gap-2 shadow-sm">
                                <span>Explore Portal</span> <i class="fas fa-external-link-alt" style="font-size:0.75rem;"></i>
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
                    $firstDesig = trim(explode('|', $dDesig)[0]);
                    $cleanRole = trim(preg_replace('/\s*\([^)]*(?:PhD|Ph\.D|MD|MBBS|MSc|MA|M\.Pharm|PGDCA|Total Exp)[^)]*\)/i', '', $firstDesig)) ?: 'Dean & Principal';
                ?>
                    <!-- Dean / Principal's Desk Message Section (Centered Top Profile Design) -->
                    <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 position-relative overflow-hidden bg-white" style="border: 1px solid #e2e8f0 !important; border-top: 5px solid #7a0b0d !important;">
                        
                        <!-- Top Header Badge -->
                        <div class="text-center mb-3">
                            <span class="badge px-3 py-2 rounded-pill text-white fw-semibold shadow-xs d-inline-flex align-items-center gap-2" style="background: #0b1526; font-size: 0.82rem;">
                                <i class="fas fa-quote-left text-warning"></i> Leadership Desk &bull; Message from the <?php echo sanitize($cleanRole); ?>
                            </span>
                        </div>

                        <!-- Top Centered Profile & Photo -->
                        <div class="text-center mb-4">
                            <div class="rounded-circle overflow-hidden shadow border border-4 border-white mx-auto mb-3 bg-light" style="width: 130px; height: 130px; outline: 2px solid #e2e8f0;">
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
                            <div class="d-flex justify-content-center flex-wrap gap-2 mt-2">
                                <?php 
                                $desigParts = array_filter(array_map('trim', explode('|', $dDesig)));
                                foreach ($desigParts as $partIdx => $part):
                                    $isPub = (stripos($part, 'Publication') !== false);
                                    $isExp = (stripos($part, 'Exp') !== false);
                                    $isQual = (stripos($part, 'Qualification') !== false);
                                ?>
                                    <?php if ($isPub): ?>
                                        <span class="badge px-3 py-1 rounded-pill fw-bold text-dark shadow-xs" style="background: linear-gradient(135deg, #fef08a, #facc15); border: 1px solid #eab308; font-size: 0.82rem;">
                                            <i class="fas fa-book-open text-danger me-1"></i> <?php echo sanitize($part); ?>
                                        </span>
                                    <?php elseif ($isExp): ?>
                                        <span class="badge px-3 py-1 rounded-pill fw-semibold" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-size: 0.8rem;">
                                            <i class="fas fa-briefcase text-primary me-1"></i> <?php echo sanitize($part); ?>
                                        </span>
                                    <?php elseif ($isQual): ?>
                                        <span class="badge px-3 py-1 rounded-pill fw-semibold" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 0.8rem;">
                                            <i class="fas fa-graduation-cap text-success me-1"></i> <?php echo sanitize($part); ?>
                                        </span>
                                    <?php elseif ($partIdx === 0): ?>
                                        <span class="badge px-3 py-1 rounded-pill fw-semibold" style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; font-size: 0.8rem;">
                                            <i class="fas fa-user-tie text-danger me-1"></i> <?php echo sanitize($part); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge px-3 py-1 rounded-pill fw-semibold" style="background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 0.8rem;">
                                            <?php echo sanitize($part); ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <span class="badge px-3 py-1 rounded-pill fw-semibold" style="background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 0.8rem;">
                                    <i class="fas fa-university me-1 text-muted"></i> <?php echo sanitize($dept['name']); ?>
                                </span>
                            </div>
                        </div>

                        <hr class="my-3 opacity-10">

                        <!-- Message Text Below Profile -->
                        <div class="mt-2">
                            <h5 class="h6 fw-bold text-navy mb-3 text-center d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-award text-danger"></i> Guiding Academic Excellence &amp; Innovation
                            </h5>
                            <div class="position-relative p-4 rounded-4" style="line-height: 1.85; font-size: 0.95rem; background: #f8fafc; border-left: 4px solid #7a0b0d; color: #334155;">
                                <i class="fas fa-quote-left text-danger position-absolute top-0 start-0 translate-middle ms-4 mt-3" style="opacity: 0.18; font-size: 1.6rem;"></i>
                                <div class="fst-italic">
                                    <?php echo nl2br(sanitize($dMsg)); ?>
                                </div>
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

                    <?php
                    $renderCourseCard = function($c) {
                        $specList = !empty($c['specializations']) ? array_map('trim', explode(',', $c['specializations'])) : [];
                        $cLvlLower = strtolower(trim($c['level'] ?? ''));
                        $cNameLower = strtolower(trim($c['course_name'] ?? ''));
                        if ($cLvlLower === 'diploma' || strpos($cNameLower, 'diploma') !== false || strpos($cNameLower, 'polytechnic') !== false || strpos($cNameLower, 'gnm') !== false || strpos($cNameLower, 'dca') !== false || strpos($cNameLower, 'pgdca') !== false || strpos($cNameLower, 'pgdyt') !== false || strpos($cNameLower, 'certificate') !== false) {
                            if (strpos($cNameLower, 'gnm') !== false || strpos($cNameLower, 'midwifery') !== false) {
                                $levelBadge = 'Diploma : GNM';
                            } elseif (strpos($cNameLower, 'agriculture') !== false) {
                                $levelBadge = 'Diploma : Agriculture';
                            } elseif (strpos($cNameLower, 'pgdca') !== false) {
                                $levelBadge = 'PG Diploma : PGDCA';
                            } elseif (strpos($cNameLower, 'dca') !== false) {
                                $levelBadge = 'Diploma : DCA';
                            } elseif (strpos($cNameLower, 'pgdyt') !== false) {
                                $levelBadge = 'PG Diploma : PGDYT';
                            } elseif (strpos($cNameLower, 'certificate') !== false) {
                                $levelBadge = 'Certificate Course';
                            } elseif (strpos($cNameLower, 'pharm') !== false || strpos($cNameLower, 'd.') !== false) {
                                $levelBadge = 'Diploma : D.Pharmacy';
                            } elseif (strpos($cNameLower, 'dmlt') !== false) {
                                $levelBadge = 'Diploma : DMLT';
                            } elseif (strpos($cNameLower, 'polytechnic') !== false) {
                                $levelBadge = 'Diploma : Polytechnic';
                            } else {
                                $levelBadge = 'Diploma Course';
                            }
                        } elseif ($cLvlLower === 'ug' || strpos($cNameLower, 'b.tech') !== false || strpos($cNameLower, 'bachelor') !== false || strpos($cNameLower, 'b.pharm') !== false || strpos($cNameLower, 'bhms') !== false || strpos($cNameLower, 'bds') !== false || strpos($cNameLower, 'b.sc') !== false || strpos($cNameLower, 'mbbs') !== false || strpos($cNameLower, 'bams') !== false || strpos($cNameLower, 'll.b') !== false || strpos($cNameLower, 'bba') !== false || strpos($cNameLower, 'bca') !== false || strpos($cNameLower, 'bmlt') !== false || strpos($cNameLower, 'bpt') !== false || strpos($cNameLower, 'b.com') !== false || strpos($cNameLower, 'b.a') !== false || strpos($cNameLower, 'b.lib') !== false) {
                            if (strpos($cNameLower, 'mbbs') !== false) {
                                $levelBadge = 'UG Degree : MBBS';
                            } elseif (strpos($cNameLower, 'bams') !== false) {
                                $levelBadge = 'UG Degree : BAMS';
                            } elseif (strpos($cNameLower, 'bds') !== false) {
                                $levelBadge = 'UG Degree : BDS';
                            } elseif (strpos($cNameLower, 'bhms') !== false) {
                                $levelBadge = 'UG Degree : BHMS';
                            } elseif (strpos($cNameLower, 'bba') !== false) {
                                $levelBadge = 'UG Degree : BBA';
                            } elseif (strpos($cNameLower, 'bca') !== false) {
                                $levelBadge = 'UG Degree : BCA';
                            } elseif (strpos($cNameLower, 'bmlt') !== false) {
                                $levelBadge = 'UG Degree : BMLT';
                            } elseif (strpos($cNameLower, 'bpt') !== false) {
                                $levelBadge = 'UG Degree : BPT';
                            } elseif (strpos($cNameLower, 'b.lib') !== false) {
                                $levelBadge = 'UG Degree : B.Lib.';
                            } elseif (strpos($cNameLower, 'b.com') !== false) {
                                $levelBadge = 'UG Degree : B.Com.';
                            } elseif (strpos($cNameLower, 'ba. ll.b') !== false || strpos($cNameLower, 'ba ll.b') !== false) {
                                $levelBadge = 'UG Degree : BA. LL.B. (Hons.)';
                            } elseif (strpos($cNameLower, 'll.b') !== false && strpos($cNameLower, 'll.m') === false) {
                                $levelBadge = 'UG Degree : LL.B.';
                            } elseif (strpos($cNameLower, 'post basic') !== false) {
                                $levelBadge = 'UG Degree : Post Basic B.Sc. (Nursing)';
                            } elseif (strpos($cNameLower, 'agriculture') !== false && strpos($cNameLower, 'b.sc') !== false) {
                                $levelBadge = 'UG Degree : B.Sc. (Hons.) Agriculture';
                            } elseif (strpos($cNameLower, 'b.sc') !== false) {
                                $levelBadge = 'UG Degree : B.Sc.';
                            } elseif (strpos($cNameLower, 'b.a') !== false || strpos($cNameLower, 'arts') !== false) {
                                $levelBadge = 'UG Degree : B.A.';
                            } elseif (strpos($cNameLower, 'journalism') !== false) {
                                $levelBadge = 'UG Degree : B. Journalism';
                            } elseif (strpos($cNameLower, 'pharm') !== false) {
                                $levelBadge = 'Degree : B.Pharmacy';
                            } else {
                                $levelBadge = 'UG Degree';
                            }
                        } elseif ($cLvlLower === 'pg' || strpos($cNameLower, 'master') !== false || strpos($cNameLower, 'm.tech') !== false || strpos($cNameLower, 'mba') !== false || strpos($cNameLower, 'mca') !== false || strpos($cNameLower, 'm.pharm') !== false || strpos($cNameLower, 'mds') !== false || strpos($cNameLower, 'md') !== false || strpos($cNameLower, 'ms') !== false || strpos($cNameLower, 'm.sc') !== false || strpos($cNameLower, 'npcc') !== false || strpos($cNameLower, 'll.m') !== false || strpos($cNameLower, 'mpt') !== false || strpos($cNameLower, 'mmlt') !== false || strpos($cNameLower, 'm.com') !== false || strpos($cNameLower, 'm.lib') !== false || strpos($cNameLower, 'msw') !== false || strpos($cNameLower, 'm.a') !== false || strpos($cNameLower, 'journalism') !== false) {
                            if (strpos($cNameLower, 'md / ms') !== false || strpos($cNameLower, 'md/ms') !== false || (strpos($cNameLower, 'surgery') !== false && strpos($cNameLower, 'dental') === false && strpos($cNameLower, 'mds') === false)) {
                                $levelBadge = 'PG Degree : MD / MS';
                            } elseif (strpos($cNameLower, 'll.m') !== false) {
                                $levelBadge = 'PG Degree : LL.M.';
                            } elseif (strpos($cNameLower, 'mpt') !== false) {
                                $levelBadge = 'PG Degree : MPT';
                            } elseif (strpos($cNameLower, 'mmlt') !== false) {
                                $levelBadge = 'PG Degree : MMLT';
                            } elseif (strpos($cNameLower, 'm.com') !== false) {
                                $levelBadge = 'PG Degree : M.Com.';
                            } elseif (strpos($cNameLower, 'm.lib') !== false) {
                                $levelBadge = 'PG Degree : M.Lib.';
                            } elseif (strpos($cNameLower, 'msw') !== false) {
                                $levelBadge = 'PG Degree : MSW';
                            } elseif (strpos($cNameLower, 'journalism') !== false) {
                                $levelBadge = 'PG Degree : M. Journalism';
                            } elseif (strpos($cNameLower, 'm.a') !== false || strpos($cNameLower, 'master of arts') !== false) {
                                $levelBadge = 'PG Degree : M.A.';
                            } elseif (strpos($cNameLower, 'agriculture') !== false && strpos($cNameLower, 'm.sc') !== false) {
                                $levelBadge = 'PG Degree : M.Sc. Agriculture';
                            } elseif (strpos($cNameLower, 'mds') !== false) {
                                $levelBadge = 'PG Degree : MDS';
                            } elseif (strpos($cNameLower, 'md') !== false && strpos($cNameLower, 'mds') === false) {
                                $levelBadge = 'PG Degree : MD';
                            } elseif (strpos($cNameLower, 'npcc') !== false) {
                                $levelBadge = 'PG Degree : NPCC';
                            } elseif (strpos($cNameLower, 'm.sc') !== false) {
                                $levelBadge = 'PG Degree : M.Sc.';
                            } else {
                                $levelBadge = 'PG Degree';
                            }
                        } else {
                            $levelBadge = sanitize($c['level']) . ' Programme';
                        }
                        ?>
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white" style="border: 1px solid #e2e8f0 !important; transition: all 0.25s ease;">
                            <div class="p-4 pb-3 border-bottom bg-light bg-opacity-50 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                        <span class="badge bg-navy text-white rounded-pill px-3 py-1 fw-semibold small"><?php echo $levelBadge; ?></span>
                                        <?php if (!empty($c['duration'])): ?>
                                            <span class="badge bg-white text-secondary border rounded-pill px-3 py-1 fw-semibold small">
                                                <i class="fas fa-clock text-danger me-1"></i> Duration: <?php echo sanitize($c['duration']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <h4 class="h5 fw-bold text-navy mb-0">
                                        <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="text-navy text-decoration-none hover-danger">
                                            <?php echo sanitize($c['course_name']); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div class="d-flex gap-2 flex-shrink-0">
                                    <a href="<?php echo BASE_URL; ?>course/<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="btn btn-sm btn-outline-secondary px-3 py-2 fw-semibold">
                                        <i class="fas fa-info-circle me-1"></i> Details
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>contact.php?course=<?php echo urlencode($c['course_name']); ?>" class="btn btn-sm btn-srku px-3 py-2 fw-semibold">
                                        <i class="fas fa-paper-plane me-1"></i> Apply Now
                                    </a>
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-muted small mb-3" style="line-height: 1.75; font-size: 0.93rem;">
                                    <?php echo sanitize($c['description']); ?>
                                </p>
                                <?php if (!empty($specList)): ?>
                                    <div class="mb-3 pt-1">
                                        <div class="small fw-bold text-navy mb-2 d-flex align-items-center gap-2">
                                            <i class="fas fa-layer-group text-danger"></i> 
                                            <span>Discipline / Specializations:</span>
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
                                <div class="mt-3">
                                    <div class="p-3 rounded-3" style="background: #f8fafc; border-left: 3px solid #10b981; border-top: 1px solid #edf2f7; border-right: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7;">
                                        <div class="small fw-bold text-navy mb-1"><i class="fas fa-check-circle text-success me-1"></i> Eligibility Criteria</div>
                                        <div class="small text-muted" style="line-height: 1.6;"><?php echo sanitize($c['eligibility']); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    };
                    ?>

                    <?php if ($isAlliedSciences): ?>
                        <!-- Quick Jump Bar for Allied Faculties -->
                        <div class="card p-3 p-md-4 border-0 shadow-sm rounded-4 mb-4 bg-light border">
                            <div class="small fw-bold text-navy text-uppercase letter-spacing-1 mb-2 d-flex align-items-center gap-2">
                                <i class="fas fa-compass text-danger"></i> Constituent Faculties Under Allied Sciences:
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($alliedFacultiesConfig as $fSlug => $fInfo): 
                                    $fCount = count($alliedGroupedCourses[$fSlug] ?? []);
                                ?>
                                    <a href="#<?php echo $fSlug; ?>" class="btn btn-sm btn-white border shadow-sm rounded-pill px-3 py-1 fw-semibold text-navy d-flex align-items-center gap-2 hover-shadow" style="font-size: 0.82rem; background: #fff;">
                                        <i class="fas <?php echo $fInfo['icon']; ?>" style="color: <?php echo $fInfo['color']; ?>;"></i>
                                        <span><?php echo $fInfo['name']; ?></span>
                                        <span class="badge rounded-pill bg-light text-muted border px-2 py-0" style="font-size: 0.72rem;"><?php echo $fCount; ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Render each Faculty as its own Heading Block with courses -->
                        <?php foreach ($alliedFacultiesConfig as $fSlug => $fInfo): 
                            $facultyCourses = $alliedGroupedCourses[$fSlug] ?? [];
                            if (empty($facultyCourses)) continue;
                        ?>
                            <div class="allied-faculty-group mb-5" id="<?php echo $fSlug; ?>" style="scroll-margin-top: 90px;">
                                <div class="d-flex align-items-center justify-content-between p-3 px-4 rounded-4 mb-3 shadow-sm flex-wrap gap-2" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-left: 6px solid <?php echo $fInfo['color']; ?>;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 shadow-sm" style="width: 44px; height: 44px; background: rgba(255,255,255,0.12); color: #fff; font-size: 1.25rem;">
                                            <i class="fas <?php echo $fInfo['icon']; ?>" style="color: #fbbf24;"></i>
                                        </div>
                                        <div>
                                            <h4 class="h5 fw-bold text-white mb-0"><?php echo $fInfo['name']; ?></h4>
                                            <span class="text-white-50 small">Allied Sciences Constituent Academic Faculty</span>
                                        </div>
                                    </div>
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background: rgba(255,255,255,0.18); color: #fff; font-size: 0.82rem;">
                                        <?php echo count($facultyCourses); ?> Programmes Offered
                                    </span>
                                </div>
                                
                                <div class="d-flex flex-column gap-3">
                                    <?php foreach ($facultyCourses as $c): ?>
                                        <?php $renderCourseCard($c); ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <!-- Standard Department Courses List -->
                        <?php if (!empty($courses)): ?>
                            <div class="d-flex flex-column gap-4">
                                <?php foreach ($courses as $c): ?>
                                    <?php $renderCourseCard($c); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="card p-4 border-0 shadow-sm rounded-4 text-center py-4 text-muted">
                                <i class="fas fa-book-open fa-2x mb-2"></i>
                                <p class="mb-0">Programmes catalog being updated. Please contact the admission desk for details.</p>
                            </div>
                        <?php endif; ?>
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
                            ['name' => 'Student Feedback Form',                    'type' => 'PDF File',   'icon' => 'fas fa-user-graduate',       'url' => istPdf('feedback/student-feedback.pdf',             'https://www.srku.edu.in/rkdf-ist/images/pdf/ist/STUDENT-FEEDBACK-FORM_page-0001.pdf')],
                            ['name' => 'Online Student Feedback (View & Download)','type' => 'PDF Portal', 'icon' => 'fas fa-eye',                'url' => BASE_URL . 'rkdf-ist-student-feedback.php'],
                            ['name' => 'Teacher Curriculum Feedback',              'type' => 'PDF File',   'icon' => 'fas fa-chalkboard-teacher',  'url' => istPdf('feedback/teacher-curriculum-feedback.pdf',  'https://www.srku.edu.in/rkdf-ist/images/pdf/ist/feedback-on-curriculum-for-teachers_page-0001.pdf')],
                            ['name' => 'Online Teacher Feedback (View & Download)','type' => 'PDF Portal', 'icon' => 'fas fa-eye',                'url' => BASE_URL . 'rkdf-ist-teacher-feedback.php'],
                            ['name' => 'Parent Feedback Form',                     'type' => 'PDF File',   'icon' => 'fas fa-users',               'url' => istPdf('feedback/parent-feedback.pdf',              'https://www.srku.edu.in/rkdf-ist/images/pdf/ist/Parent-Feed-Back-converted_page-0001%20(1).pdf')],
                            ['name' => 'Online Parent Feedback (View & Download)', 'type' => 'PDF Portal', 'icon' => 'fas fa-eye',                'url' => BASE_URL . 'rkdf-ist-parent-feedback.php'],
                        ];
                        foreach ($feedbackForms as $fb): ?>
                            <div class="col-12 col-md-6">
                                <a href="<?php echo $fb['url']; ?>" <?php echo $fb['type'] === 'PDF File' ? 'target="_blank"' : ''; ?> rel="noopener"
                                   class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border text-decoration-none text-dark h-100" style="transition:all 0.2s;">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm border flex-shrink-0" style="width:40px;height:40px;">
                                        <i class="<?php echo $fb['icon']; ?> text-danger small"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold text-navy" style="font-size:0.85rem;"><?php echo $fb['name']; ?></div>
                                        <span class="badge <?php echo $fb['type'] === 'PDF Portal' ? 'bg-danger text-white' : 'bg-secondary'; ?> mt-1" style="font-size:0.65rem;"><?php echo $fb['type']; ?></span>
                                    </div>
                                    <i class="fas fa-<?php echo $fb['type'] === 'PDF Portal' ? 'arrow-right' : 'file-pdf'; ?> text-muted small"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php endif; // end RKDF IST left-column sections ?>

            </div>

            <!-- Right Sidebar Column -->
            <div class="col-12 col-lg-4 col-xl-3">
                
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
