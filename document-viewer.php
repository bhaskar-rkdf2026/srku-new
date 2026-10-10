<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? $_GET['doc'] ?? '');
$fileParam = sanitize($_GET['file'] ?? '');

$aliases = array (
  'act-and-statutes' => 'act-statutes',
  'act_statutes' => 'act-statutes',
  'idp' => 'institutional-development-plan',
  'institutional_development_plan' => 'institutional-development-plan',
  'constituent-unit' => 'constituent-units',
  'constituent_units' => 'constituent-units',
  'accreditation' => 'accreditation-ranking',
  'accreditation_ranking' => 'accreditation-ranking',
  'recognition' => 'recognition-approval',
  'recognition_approval' => 'recognition-approval',
  'annual-report-2024-25' => 'annual-report',
  'annual_report' => 'annual-report',
  'details_of_sponsoring_body' => 'details-of-sponsoring-body',
  'sponsoring-body' => 'details-of-sponsoring-body',
  'eoa-report' => 'council-of-technical-education',
  'eoa-report-2020-21-1' => 'council-of-technical-education',
  'eoa_report_2020-21-1' => 'council-of-technical-education',
  'ordinance-1-to-92' => 'university-ordinance',
  'ordinance' => 'university-ordinance',
  'subsequent-ordinance-93-100' => 'ordinance-93-100',
  'subsequent-ordinance' => 'ordinance-93-100',
  'annexure-i-ugcinfo' => 'ugc-information',
  'ugc-info' => 'ugc-information',
  'officersofuniversity' => 'officers-of-university',
  'officers' => 'officers-of-university',
  'governing_body' => 'governing-body',
  'board_of_management' => 'board-of-management',
  'bom' => 'board-of-management',
  'finance_committee' => 'finance-committee',
  'academic-council' => 'academic-councils',
  'academic_council' => 'academic-councils',
  'boardofstudies' => 'board-of-studies',
  'board_of_studies' => 'board-of-studies',
  'bos' => 'board-of-studies',
  'icc' => 'internal-complaint-committee',
  'internalcomplaint-committee' => 'internal-complaint-committee',
  'internalcomplaintcommittee' => 'internal-complaint-committee',
  'bjmc' => 'bjmc-syllabus-scheme',
  'bjmc-syllabus' => 'bjmc-syllabus-scheme',
  'details-of-academic-programs' => 'details-of-academic-programmes',
  'academic-calendar-2024-25' => 'academic-calendar',
  'academic-calendar-2026-27' => 'academic-calendar',
  'statutes-ordinances' => 'statutes-ordinances-academics-examination',
  'statutes-ordinances-pertaining-to-academics-examination' => 'statutes-ordinances-academics-examination',
  'constituent-units-departments' => 'school-department-centres',
  'constituent-units-department' => 'school-department-centres',
  'constituent-units&department' => 'school-department-centres',
  'department-wise-faculty-details' => 'faculty-staff-details',
  'internal-quality-assurance-cell' => 'iqac',
  'library' => 'university-library',
  'admission-process' => 'admission-process-guidelines',
  'admission-process&guidelines' => 'admission-process-guidelines',
  'fee-refund' => 'fee-refund-policy',
  'fee-refund-policy-2024-25' => 'fee-refund-policy',
  'research-and-development-cell' => 'research-development-cell',
  'research&developmentcell' => 'research-development-cell',
  'rdc' => 'research-development-cell',
  'incubation-center' => 'incubation-centre',
  'incubation' => 'incubation-centre',
  'central-facilities-for-research-and-development' => 'central-facilities-research',
  'constitution-of-ethics-board' => 'ethics-board',
  'admission-policy-for-ph-d-programme' => 'phd-admission-policy',
  'admission-policy-for-phd-programme' => 'phd-admission-policy',
  'research-advisory-committee' => 'constitution-of-research-advisory-committee',
  'rac' => 'constitution-of-research-advisory-committee',
  'details-about-ph-d-scholars-currently-enrolled' => 'phd-scholars-currently-enrolled',
  'details-about-phd-scholars-currently-enrolled' => 'phd-scholars-currently-enrolled',
  'phd-scholars-pursuing' => 'phd-scholars-currently-enrolled',
  'sports' => 'sports-facilities',
  'ncc-nss-details' => 'ncc-nss',
  'hostel' => 'hostel-details',
  'placement' => 'placement-cell',
  'student-grievance' => 'student-grievance-committee',
  'health' => 'health-facility',
  'anti-ragging-committee' => 'anti-ragging',
  'anti-ragging-committe' => 'anti-ragging',
  'equal-opportunity' => 'equal-opportunity-cell',
  'sedg' => 'sedg-cell',
  'sedg-cell' => 'sedg-cell',
  'socio-economically-disadvantaged-groups-cell-sedg' => 'sedg-cell',
  'socio-economically-disadvantaged-groups-cell' => 'sedg-cell',
  'socio-economically-disadvantaged-groups-cell-(sedg)' => 'sedg-cell',
  'facilities-for-differently-abled-students' => 'differently-abled-facilities',
  'facilities-for-differently-abled--students' => 'differently-abled-facilities',
  'alumni-registration-certificate' => 'alumni-registration-certificate',
  'aluminai-registration-certificate' => 'alumni-registration-certificate',
  'alumni-registration-certificat' => 'alumni-registration-certificate',
  'alumni-bylaws' => 'alumni-bylaws',
  'right-to-information' => 'rti',
  'ph-d-pursuing' => 'phd-pursuing',
  'ph-d-completed' => 'phd-completed',
  'phd-scholars-completed' => 'phd-completed',
  'nirf' => 'nirf-2026',
  'careers' => 'vacancy',
  'requirement-paper' => 'vacancy',
  'fees' => 'fees-2026-27',
  'fee-structure' => 'fees-2026-27',
  'fee-structure-2026-27' => 'fees-2026-27',
  'fees-structure' => 'fees-2026-27',
  'fees-2026' => 'fees-2026-27',
  'clean-green-campus' => 'clean-green-campus-policy',
  'clean-green-policy' => 'clean-green-campus-policy',
  'green-campus-policy' => 'clean-green-campus-policy',
  'hr-policy-pdf' => 'hr-policy',
  'it-policy-pdf' => 'it-policy',
  'inhouse-scheme' => 'inhouse-scheme-policy',
  'inhouse-policy' => 'inhouse-scheme-policy',
  'maintenance' => 'maintenance-policy',
  'appraisal-policy' => 'performance-appraisal-policy',
  'performance-appraisal' => 'performance-appraisal-policy',
  'plastic-ban' => 'plastic-ban-policy',
  'plastic-policy' => 'plastic-ban-policy',
  'disabled-friendly-policy' => 'differently-abled-facilities',
  'barrier-free-environment' => 'differently-abled-facilities',
  'grievance-redressal-policy' => 'policy-for-grievance-redressal',
  'policy-for-grievance-redressal' => 'policy-for-grievance-redressal',
  'policy-grievance-redressal' => 'policy-for-grievance-redressal',
  'grievance-policy' => 'policy-for-grievance-redressal',
  'student-grievance-committee' => 'student-grievance-committee',
  'student-grievance' => 'student-grievance-committee',
  'consultancy-policy' => 'consultancy-projects',
  'welfare' => 'welfare-policy',
  'welfare-policy-pdf' => 'welfare-policy',
  'meritorious-scheme' => 'meritorious-scheme-policy',
  'merit-scholarship-policy' => 'meritorious-scheme-policy',
  'scholarship-policy' => 'meritorious-scheme-policy',
  'university-research-policy' => 'research-policy',
  'antiragging' => 'anti-ragging',
  'antiragging-policy' => 'anti-ragging',
  'sc-and-st-grievance' => 'sc-st-grievance-committee',
  'sc-st-grievance' => 'sc-st-grievance-committee',
  'seed-money-policy' => 'seed-money-research-policy',
  'seed-money' => 'seed-money-research-policy',
  'university-prospectus' => 'prospectus',
  'admission-prospectus' => 'prospectus',
  'aicte-approval-2026-27' => 'council-of-technical-education',
  'aicte-rkdfist' => 'aicte-approval-rkdfist',
  'aicte-rkdfist-mca' => 'aicte-approval-rkdfist-mca',
  'aicte-rkdfim' => 'aicte-approval-rkdfim',
  'aicte-rkdfibm' => 'aicte-approval-rkdfibm',
  'rkdfibm' => 'aicte-approval-rkdfibm',
  'rkdfim' => 'aicte-approval-rkdfim',
  'rkdfist' => 'aicte-approval-rkdfist',
  'rkdfist-mca' => 'aicte-approval-rkdfist-mca',
);

// ═══════════════════════════════════════════════════════
// MULTI-TIER DOCUMENT RESOLUTION ENGINE
// ═══════════════════════════════════════════════════════
$doc = null;
$cleanSlug = strtolower(trim($slug));
// Normalize dashes, spaces, underscores
$normKey = preg_replace('/[^a-z0-9]+/', '-', $cleanSlug);
$normKey = trim($normKey, '-');
$pdo = getDBConnection();

// 0. Primary DB Lookup from `documents` table (Dynamic Admin Managed)
if (!empty($slug) || !empty($normKey)) {
    try {
        $pdo = getDBConnection();
        $aliasTarget = $aliases[$normKey] ?? ($aliases[$slug] ?? null);
        if ($aliasTarget) {
            $docStmt = $pdo->prepare("SELECT * FROM documents WHERE (slug = :s OR slug = :alias OR slug = :norm) LIMIT 1");
            $docStmt->execute([':s' => $slug, ':alias' => $aliasTarget, ':norm' => $normKey]);
        } else {
            $docStmt = $pdo->prepare("SELECT * FROM documents WHERE (slug = :s OR slug = :norm) LIMIT 1");
            $docStmt->execute([':s' => $slug, ':norm' => $normKey]);
        }
        $row = $docStmt->fetch();
        if ($row && ($row['status'] === 'published' || isset($_SESSION['admin_user']))) {
            $hl = [];
            if (!empty($row['highlights'])) {
                $decoded = json_decode($row['highlights'], true);
                if (is_array($decoded)) {
                    $hl = $decoded;
                } else {
                    $lines = explode("\n", str_replace("\r", "", $row['highlights']));
                    $hl = array_values(array_filter(array_map('trim', $lines)));
                }
            }
            $doc = [
                'id' => $row['id'],
                'title' => $row['title'],
                'category' => $row['category'],
                'subtitle' => $row['subtitle'] ?? '',
                'pdf_path' => $row['pdf_path'],
                'description' => $row['description'] ?? '',
                'highlights' => $hl,
                'status' => $row['status'] ?? 'published'
            ];
            $slug = $row['slug'];
        }
    } catch (Exception $e) {}
}

// 2. Check Database `pages` table
if (!$doc && !empty($slug)) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = :s OR slug = :norm LIMIT 1");
        $stmt->execute([':s' => $slug, ':norm' => $normKey]);
        $pRow = $stmt->fetch();
        if ($pRow && !empty($pRow['banner_img']) && preg_match('/\.pdf$/i', $pRow['banner_img'])) {
            $doc = [
                'title' => $pRow['title'],
                'category' => 'Official Document',
                'subtitle' => !empty($pRow['banner_subtitle']) ? $pRow['banner_subtitle'] : (!empty($pRow['banner_title']) ? $pRow['banner_title'] : $pRow['title']),
                'pdf_path' => $pRow['banner_img'],
                'description' => !empty($pRow['meta_description']) ? $pRow['meta_description'] : strip_tags($pRow['content']),
                'highlights' => []
            ];
        }
    } catch (Exception $e) {}
}

// 5. Match by fileParam
if (!$doc && !empty($fileParam)) {
    $searchBase = basename($fileParam);
    foreach ($documentsRegistry as $k => $item) {
        if (basename($item['pdf_path']) === $searchBase || $item['pdf_path'] === $fileParam) {
            $doc = $item;
            $slug = $k;
            break;
        }
    }
    if (!$doc) {
        $cleanTitle = ucwords(str_replace(['-', '_', '.pdf', '%20'], ' ', $searchBase));
        $doc = [
            'title' => $cleanTitle,
            'category' => 'University Document',
            'subtitle' => 'Official University Publication & Information Document',
            'pdf_path' => $fileParam,
            'description' => 'Official published document of Sarvepalli Radhakrishnan University (SRKU), Bhopal for student and faculty reference.',
            'highlights' => [
                'Official publication approved by university authorities.',
                'Prescribed format, guidelines, and compliance records.',
                'Available for public reference and direct download.'
            ]
        ];
    }
}

// 6. Dynamic Disk Search across assets/uploads/
if (!$doc && !empty($normKey)) {
    $searchDirs = [
        __DIR__ . '/assets/uploads/2026/updated-docs/',
        __DIR__ . '/updated-docs-Website/',
        __DIR__ . '/assets/uploads/2025/10/new-update/',
        __DIR__ . '/assets/uploads/2025/allCommittee/',
        __DIR__ . '/assets/uploads/2026/07/',
        __DIR__ . '/assets/uploads/phd/',
        __DIR__ . '/assets/uploads/2025/nirf/',
        __DIR__ . '/assets/uploads/2023/09/',
        __DIR__ . '/assets/uploads/2023/05/',
        __DIR__ . '/assets/uploads/2024/07/',
        __DIR__ . '/assets/uploads/pdf/',
        __DIR__ . '/assets/uploads/'
    ];

    $normSlugWord = preg_replace('/[^a-z0-9]/', '', $normKey);
    foreach ($searchDirs as $dir) {
        if (!is_dir($dir)) continue;
        $files = scandir($dir);
        foreach ($files as $file) {
            if (!preg_match('/\.pdf$/i', $file)) continue;
            $normFileWord = preg_replace('/[^a-z0-9]/', '', strtolower($file));
            if ($normFileWord === $normSlugWord || strpos($normFileWord, $normSlugWord) !== false || strpos($normSlugWord, $normFileWord) !== false) {
                $cleanTitle = ucwords(str_replace(['-', '_', '.pdf', '%20'], ' ', $file));
                $relPath = str_replace(__DIR__ . '/', '', $dir . $file);
                $doc = [
                    'title' => $cleanTitle,
                    'category' => 'Official Document',
                    'subtitle' => 'Official University Document & Public Disclosure',
                    'pdf_path' => $relPath,
                    'description' => 'Official document and notification published by Sarvepalli Radhakrishnan University (SRKU), Bhopal.',
                    'highlights' => []
                ];
                break 2;
            }
        }
    }
}

if (!$doc) {
    if (empty($slug) && empty($fileParam)) {
        try {
            $defStmt = $pdo->query("SELECT * FROM documents WHERE status = 'published' ORDER BY display_order ASC, id ASC LIMIT 1");
            $r = $defStmt->fetch();
            if ($r) {
                $hl = !empty($r['highlights']) ? json_decode($r['highlights'], true) : [];
                $doc = [
                    'id' => $r['id'],
                    'title' => $r['title'],
                    'category' => $r['category'],
                    'subtitle' => $r['subtitle'] ?? '',
                    'pdf_path' => $r['pdf_path'],
                    'description' => $r['description'] ?? '',
                    'highlights' => is_array($hl) ? $hl : [],
                    'status' => $r['status']
                ];
                $slug = $r['slug'];
            }
        } catch (Exception $e) {}
    }
}

if (!$doc) {
    http_response_code(404);
    $pageTitle = "Document Not Found | SRKU Bhopal";
    $pageDesc = "The requested university document or regulatory disclosure could not be found.";
    require_once __DIR__ . '/includes/header.php';
    ?>
    <section class="py-5 bg-light text-center" style="min-height: 55vh; display: flex; align-items: center;">
        <div class="container py-5">
            <i class="fas fa-file-excel text-danger fa-4x mb-3"></i>
            <h1 class="display-6 fw-bold text-navy">Document Not Found</h1>
            <p class="lead text-muted mb-4">The document you requested is currently unavailable or has been archived.</p>
            <a href="<?php echo BASE_URL; ?>" class="btn btn-navy rounded-pill px-4 me-2"><i class="fas fa-home me-1"></i> Home</a>
            <a href="<?php echo BASE_URL; ?>about.php" class="btn btn-outline-danger rounded-pill px-4">About University</a>
        </div>
    </section>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = sanitize($doc['title']) . " | Official University Document & PDF | SRKU Bhopal";
$pageDesc = sanitize($doc['description']);
$pageKeywords = sanitize($doc['title']) . ", SRKU PDF, Official Document SRKU Bhopal, " . sanitize($doc['category']);
$activeNav = strtolower($doc['category']);
require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner Header -->
<?php renderPageBanner('document-view', $doc['title'], $doc['subtitle']); ?>

<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm border mb-0">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-navy text-decoration-none"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><span class="text-muted"><?php echo sanitize($doc['category']); ?></span></li>
                <li class="breadcrumb-item active text-danger fw-bold" aria-current="page"><?php echo sanitize($doc['title']); ?></li>
            </ol>
        </nav>

        <!-- Top Action Callout Banner -->
        <div class="card p-4 p-lg-5 border-0 shadow rounded-4 text-white mb-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #7A0B0D 0%, #16233f 100%);">
            <div class="row align-items-center g-4 position-relative z-2">
                <div class="col-12 col-lg-8">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="fas fa-file-pdf me-1"></i> <?php echo sanitize($doc['category']); ?> Official Document
                    </span>
                    <h2 class="h2 fw-bold text-white mb-3"><?php echo sanitize($doc['title']); ?></h2>
                    <p class="text-white-50 mb-4" style="line-height: 1.7; font-size: 0.98rem;">
                        <?php echo sanitize($doc['description']); ?>
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" download class="btn btn-warning text-dark fw-bold px-4 py-3 rounded-pill shadow">
                            <i class="fas fa-download me-2"></i> Download Official PDF
                        </a>
                        <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" target="_blank" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill">
                            <i class="fas fa-external-link-alt me-2"></i> View PDF Fullscreen
                        </a>
                        <a href="#pdf-viewer" class="btn btn-light text-navy fw-bold px-4 py-3 rounded-pill">
                            <i class="fas fa-eye me-2"></i> In-Page Preview
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-4 rounded-4 bg-white text-navy shadow-sm">
                        <h6 class="fw-bold text-navy mb-3"><i class="fas fa-info-circle text-danger me-2"></i> Document Information</h6>
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Type:</span>
                                <strong class="text-navy">Official PDF File</strong>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Category:</span>
                                <strong class="text-navy"><?php echo sanitize($doc['category']); ?></strong>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Compliance:</span>
                                <strong class="text-success">UGC / Regulatory Norms</strong>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Status:</span>
                                <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold">Active &amp; Verified</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 g-lg-5 mb-5">
            
            <!-- Left Column: Interactive PDF Viewer -->
            <div class="col-12 col-lg-8">
                
                <!-- PDF Preview Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-4" id="pdf-viewer">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <div>
                            <span class="section-subtitle"><i class="fas fa-file-pdf text-danger me-1"></i> DOCUMENT VIEWER</span>
                            <h3 class="h4 fw-bold text-navy mb-0"><?php echo sanitize($doc['title']); ?></h3>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" download class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
                                <i class="fas fa-download me-1"></i> Download PDF
                            </a>
                            <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" target="_blank" class="btn btn-sm btn-outline-navy rounded-pill px-3 fw-bold">
                                <i class="fas fa-external-link-alt me-1"></i> Fullscreen
                            </a>
                        </div>
                    </div>

                    <div class="ratio ratio-4x3 border rounded-4 overflow-hidden shadow-sm bg-light" style="min-height: 600px;">
                        <iframe src="<?php echo BASE_URL . $doc['pdf_path']; ?>#toolbar=1" class="w-100 h-100" style="border:none;" title="<?php echo sanitize($doc['title']); ?>">
                            <p class="p-4 text-center text-muted">
                                Your browser does not support embedded PDF viewing. 
                                <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" target="_blank" class="btn btn-danger btn-sm ms-2">Click here to download and view the PDF.</a>
                            </p>
                        </iframe>
                    </div>
                </div>

                <?php if (!empty($doc['highlights'])): ?>
                <!-- Key Highlights Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h4 class="fw-bold text-navy mb-3"><i class="fas fa-check-circle text-success me-2"></i> Key Document Highlights</h4>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                        <?php foreach ($doc['highlights'] as $highlight): ?>
                            <li class="d-flex align-items-start gap-3">
                                <i class="fas fa-arrow-circle-right text-danger mt-1"></i>
                                <span class="text-secondary"><?php echo sanitize($highlight); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

            </div>

            <!-- Right Sidebar: Contact Desk & Related Documents -->
            <div class="col-12 col-lg-4">
                
                <!-- University Office Card -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-university text-danger me-2"></i> University Desk</h5>
                    <p class="text-muted small mb-3">
                        For questions, authentication, or queries regarding university regulations, circulars, or admissions:
                    </p>
                    <div class="p-3 rounded-3 bg-light border small text-muted mb-3">
                        <strong class="text-navy d-block mb-1">Sarvepalli Radhakrishnan University</strong>
                        NH-12, Hoshangabad Road, Misrod,<br>
                        Bhopal, Madhya Pradesh - 462026
                    </div>
                    <div class="d-flex flex-column gap-2 small">
                        <a href="tel:7024144981" class="text-decoration-none text-navy fw-semibold p-2 rounded-3 bg-light border d-flex align-items-center">
                            <i class="fas fa-phone-alt text-danger me-2"></i> University Helpline: 7024144981
                        </a>
                        <a href="mailto:info@srku.edu.in" class="text-decoration-none text-navy fw-semibold p-2 rounded-3 bg-light border d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-2"></i> info@srku.edu.in
                        </a>
                    </div>
                </div>

                <!-- Related Documents in this category -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-folder-open text-warning me-2"></i> Related Documents</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                        <?php 
                        $allDocsList = []; $pdo = getDBConnection();
                        try {
                            $allStmt = $pdo->query("SELECT slug, title, category, pdf_path FROM documents WHERE status = 'published' ORDER BY display_order ASC, id ASC");
                            $dbDocs = $allStmt->fetchAll();
                            if (!empty($dbDocs)) {
                                $allDocsList = [];
                                foreach ($dbDocs as $dRow) {
                                    $allDocsList[$dRow['slug']] = [
                                        'title' => $dRow['title'],
                                        'category' => $dRow['category'],
                                        'pdf_path' => $dRow['pdf_path']
                                    ];
                                }
                            }
                        } catch (Exception $e) {}

                        $count = 0;
                        foreach ($allDocsList as $k => $item): 
                            if ($k === $slug) continue;
                            if ($item['category'] === $doc['category'] || $count < 4):
                                $count++;
                        ?>
                            <li>
                                <a href="<?php echo BASE_URL; ?>document/<?php echo $k; ?>" class="text-decoration-none text-navy d-flex align-items-center justify-content-between p-2 rounded-2 hover-bg-light">
                                    <span class="text-truncate me-2"><i class="fas fa-file-pdf text-danger me-2"></i><?php echo sanitize($item['title']); ?></span>
                                    <i class="fas fa-chevron-right text-muted small"></i>
                                </a>
                            </li>
                        <?php 
                            endif;
                            if ($count >= 6) break;
                        endforeach; 
                        ?>
                    </ul>
                </div>

            </div>

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>