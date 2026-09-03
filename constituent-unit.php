<?php
$pageTitle = "Constituent Colleges & Specialized Institutes | SRK University Bhopal";
$pageDesc = "Explore the 20+ statutory constituent colleges and specialized institutes of Sarvepalli Radhakrishnan University (SRKU) Bhopal spanning Medicine, Dentistry, Ayurveda, Homoeopathy, Pharmacy, Nursing, Law, Engineering & Agriculture.";
$pageKeywords = "SRKU Constituent Units, RKDF Medical College, RKDF Institute of Science and Technology, Sri Sai Pharmacy, SRKU Colleges, Medical College Bhopal, Pharmacy Colleges MP";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';

$dbDepartments = getDepartments(true);
$units = [];

// Exact Constituent Institutes that possess their own official circular seals
$exactSeals = [
    'rkdf-medical-college' => 'logo-rkdf-medical.png',
    'sarvepalli-radhakrishnan-college-of-ayurveda' => 'logo-srk-ayurveda.png',
    'rkdf-homoeopathic-medical-college' => 'logo-rkdf-homoeopathy.png',
    'rkdf-dental-college' => 'logo-rkdf-dental.png',
    'rkdf-college-of-pharmacy' => 'logo-rkdf-pharmacy.png',
    'sarvepalli-radhakrishnan-college-of-pharmacy' => 'logo-rkdf-pharmacy.png',
    'dr-apj-abdul-kalam-college-of-pharmacy-srk-bhopal' => 'logo-rkdf-pharmacy.png',
    'sri-sai-college-of-pharmacy-srk-bhopal' => 'logo-rkdf-pharmacy.png',
    'sarvepalli-radhakrishnan-institute-of-pharmaceutical-science' => 'logo-rkdf-pharmacy.png',
    'r-n-kapoor-memorial-institute-of-pharmaceutical-sciences-srk-university' => 'logo-rkdf-pharmacy.png',
    'rkdf-college-of-nursing' => 'logo-rkdf-nursing.png',
    'department-of-paramedical-sciences' => 'logo-allied-healthcare.png',
    'rkdf-institute-of-science-and-technology' => 'logo-rkdf-science-tech.png',
    'sarvepalli-radhakrishnan-college-of-law' => 'logo-srk-law.png',
    'rkdf-institute-of-business-management' => 'logo-rkdf-management.png',
    'rkdf-institute-of-management' => 'logo-rkdf-management.png',
    'department-of-management' => 'logo-rkdf-management.png',
    'faculty-of-agriculture' => 'logo-srk-agriculture.png'
];

// Standalone Official External Hospital / Institute Portals
$externalWebsites = [
    'rkdf-medical-college' => 'https://rkdfmedicalcollege.org/',
    'rkdf-dental-college' => 'http://rkdfdentalcollege.in/',
    'rkdf-homoeopathic-medical-college' => 'http://www.rkdfhmc.in/',
    'sarvepalli-radhakrishnan-college-of-ayurveda' => 'https://www.srkcahrc.in/',
    'rkdf-institute-of-science-and-technology' => 'https://srku.edu.in/rkdf-ist/index.php',
    'faculty-of-agriculture' => 'https://srku.edu.in/agriculture/index.php'
];

function resolveUnitCategoryGroup($cat, $slug) {
    $str = strtolower($cat . ' ' . $slug);
    if (strpos($str, 'ayurveda') !== false || strpos($str, 'homoeopath') !== false || strpos($str, 'ayush') !== false) {
        return 'ayush';
    }
    if (strpos($str, 'medical') !== false || strpos($str, 'dental') !== false) {
        return 'medical';
    }
    if (strpos($str, 'pharmacy') !== false || strpos($str, 'pharmaceutical') !== false) {
        return 'pharmacy';
    }
    if (strpos($str, 'nursing') !== false || strpos($str, 'paramedical') !== false) {
        return 'nursing';
    }
    if (strpos($str, 'engineering') !== false || strpos($str, 'science-and-technology') !== false) {
        return 'engineering';
    }
    if (strpos($str, 'law') !== false) {
        return 'law';
    }
    if (strpos($str, 'agriculture') !== false) {
        return 'agriculture';
    }
    if (strpos($str, 'management') !== false || strpos($str, 'computer application') !== false || strpos($str, 'mca') !== false) {
        return 'management';
    }
    return 'allied';
}

if (!empty($dbDepartments)) {
    foreach ($dbDepartments as $d) {
        $img = !empty($d['image']) ? $d['image'] : (!empty($d['banner_img']) ? $d['banner_img'] : '');
        if (empty($img) || !file_exists(__DIR__ . '/' . ltrim(str_replace('\\', '/', $img), '/'))) {
            $cand = 'assets/uploads/constituent-units/' . ($d['slug'] ?? '') . '.webp';
            if (file_exists(__DIR__ . '/' . $cand)) {
                $img = $cand;
            } else {
                $img = 'assets/uploads/2026/07/001.webp';
            }
        }
        $groupKey = resolveUnitCategoryGroup($d['category'] ?? '', $d['slug'] ?? '');
        $sealImg = $exactSeals[$d['slug']] ?? null;
        $extUrl = $externalWebsites[$d['slug']] ?? null;

        $units[] = [
            'id' => $d['id'],
            'title' => $d['name'],
            'subtitle' => !empty($d['category']) ? $d['category'] : 'Constituent Institute',
            'slug' => $d['slug'],
            'group' => $groupKey,
            'img_src' => resolveMediaUrl($img, 'assets/uploads/2026/07/001.webp'),
            'href' => BASE_URL . 'department-detail.php?slug=' . urlencode($d['slug']),
            'seal' => $sealImg,
            'external_url' => $extUrl,
            'dean_name' => trim((string)($d['dean_name'] ?? '')),
            'dean_desig' => trim((string)($d['dean_designation'] ?? '')),
            'approvals' => trim((string)($d['approvals'] ?? '')),
            'est_year' => trim((string)($d['established_year'] ?? '')),
            'external' => false
        ];
    }
}

// Category filter configurations with counts
$filterCounts = ['all' => count($units)];
foreach ($units as $u) {
    $grp = $u['group'];
    $filterCounts[$grp] = ($filterCounts[$grp] ?? 0) + 1;
}
?>

<!-- ═══════════════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════════════ -->
<section class="about-hero-v2 position-relative overflow-hidden">
    <div class="about-hero-v2__blob about-hero-v2__blob--1"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--2"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--3"></div>
    <div class="about-hero-v2__grid"></div>
    <div class="container-xl about-hero-v2__inner position-relative" style="z-index: 3;">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-warning"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">Constituent Units</li>
            </ol>
        </nav>
        
        <span class="about-hero-v2__eyebrow d-inline-flex align-items-center gap-2 mb-3">
            <i class="fas fa-university text-warning"></i> Recognized Statutory Constituent Colleges &middot; Est. 1995
        </span>
        
        <h1 class="about-hero-v2__title" style="max-width:850px;">
            Constituent Colleges &amp; <span>Specialized Institutes</span>
        </h1>
        
        <p class="about-hero-v2__desc" style="max-width:780px; line-height: 1.75;">
            Explore the 20+ statutory constituent colleges and specialized research centres of Sarvepalli Radhakrishnan University (SRKU), Bhopal &mdash; accredited and recognized by India's apex statutory regulatory bodies to deliver premier education across Medical, AYUSH, Technical, Legal, and Allied disciplines.
        </p>

        <!-- Regulatory Approvals Pill Strip -->
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
            <span class="text-white-50 small fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Statutory Approvals:</span>
            <span class="badge bg-white bg-opacity-10 text-white border border-white-25 px-2 py-1 rounded-pill small"><i class="fas fa-check-circle text-warning me-1"></i> NMC (MBBS)</span>
            <span class="badge bg-white bg-opacity-10 text-white border border-white-25 px-2 py-1 rounded-pill small"><i class="fas fa-check-circle text-warning me-1"></i> DCI (Dental)</span>
            <span class="badge bg-white bg-opacity-10 text-white border border-white-25 px-2 py-1 rounded-pill small"><i class="fas fa-check-circle text-warning me-1"></i> NCISM (Ayurveda)</span>
            <span class="badge bg-white bg-opacity-10 text-white border border-white-25 px-2 py-1 rounded-pill small"><i class="fas fa-check-circle text-warning me-1"></i> NCH (Homoeopathy)</span>
            <span class="badge bg-white bg-opacity-10 text-white border border-white-25 px-2 py-1 rounded-pill small"><i class="fas fa-check-circle text-warning me-1"></i> PCI (Pharmacy)</span>
            <span class="badge bg-white bg-opacity-10 text-white border border-white-25 px-2 py-1 rounded-pill small"><i class="fas fa-check-circle text-warning me-1"></i> INC (Nursing)</span>
            <span class="badge bg-white bg-opacity-10 text-white border border-white-25 px-2 py-1 rounded-pill small"><i class="fas fa-check-circle text-warning me-1"></i> BCI (Law)</span>
            <span class="badge bg-white bg-opacity-10 text-white border border-white-25 px-2 py-1 rounded-pill small"><i class="fas fa-check-circle text-warning me-1"></i> AICTE (Engg &amp; Mgmt)</span>
            <span class="badge bg-white bg-opacity-10 text-white border border-white-25 px-2 py-1 rounded-pill small"><i class="fas fa-check-circle text-warning me-1"></i> UGC Recognized</span>
        </div>

        <div class="d-flex flex-wrap gap-3">
            <a href="#unitsCatalog" class="btn-hero-yellow shadow-sm">
                <i class="fas fa-th-large me-2"></i> Explore All Colleges
            </a>
            <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Constituent-units.pdf" target="_blank" rel="noopener noreferrer" class="btn-hero-outline shadow-sm">
                <i class="fas fa-file-pdf me-2 text-danger"></i> Download Official Brochure (PDF)
            </a>
            <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="fas fa-user-graduate text-warning"></i> Admission Enquiry
            </a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     KEY INFRASTRUCTURE STATS STRIP
═══════════════════════════════════════════════════════ -->
<div class="stats-strip py-3" style="background: #0f172a; border-bottom: 1px solid rgba(255,255,255,0.08);">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-5 g-3 text-center">
            <div class="col stat-box">
                <div class="stat-val text-warning">20+</div>
                <div class="stat-txt text-white-50">Constituent Colleges</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val text-white">750+</div>
                <div class="stat-txt text-white-50">Hospital Beds (Teaching)</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val text-warning">250+</div>
                <div class="stat-txt text-white-50">Dental Treatment Chairs</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val text-white">18,000+</div>
                <div class="stat-txt text-white-50">Students Enrolled</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val text-warning">90+</div>
                <div class="stat-txt text-white-50">Degree Programmes</div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     CONSTITUENT UNITS CATALOG WITH INTERACTIVE FILTERS
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light" id="unitsCatalog">
    <div class="container-xl py-2">
        
        <!-- Header -->
        <div class="text-center mb-4">
            <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-1 rounded-pill small text-uppercase" style="letter-spacing: 0.5px;">
                Directory of Academic Institutions
            </span>
            <h2 class="section-title mt-2 mb-2">A Guide to the <span>University's Constituent</span> Units</h2>
            <p class="text-muted mx-auto" style="max-width: 680px; font-size: 0.95rem;">
                Browse our recognized colleges, healthcare institutes, and academic departments by discipline, or search directly by name.
            </p>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
            <div class="row g-3 align-items-center">
                <!-- Search Box -->
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted ps-3"><i class="fas fa-search"></i></span>
                        <input type="text" id="unitSearchInput" class="form-control bg-light border-0 py-2 small" placeholder="Search by college name, degree (e.g. MBBS, Pharmacy, Law)...">
                        <button class="btn btn-light border-0 text-muted" type="button" id="clearUnitSearch" style="display:none;" title="Clear Search">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- Active Counter -->
                <div class="col-12 col-md-7 text-md-end">
                    <span class="text-muted small">
                        Showing <strong id="visibleUnitsCount" class="text-danger"><?php echo count($units); ?></strong> of <?php echo count($units); ?> Constituent Units
                    </span>
                </div>
            </div>

            <!-- Category Filter Tabs -->
            <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top" id="unitFilterTabs" role="tablist">
                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 py-2 fw-semibold filter-tab-btn active" data-filter="all">
                    <i class="fas fa-th-large me-1"></i> All Units (<?php echo $filterCounts['all']; ?>)
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold filter-tab-btn" data-filter="medical">
                    <i class="fas fa-hospital-user text-danger me-1"></i> Medical &amp; Dental (<?php echo $filterCounts['medical'] ?? 0; ?>)
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold filter-tab-btn" data-filter="ayush">
                    <i class="fas fa-leaf text-success me-1"></i> AYUSH (<?php echo $filterCounts['ayush'] ?? 0; ?>)
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold filter-tab-btn" data-filter="pharmacy">
                    <i class="fas fa-capsules text-warning me-1"></i> Pharmacy (<?php echo $filterCounts['pharmacy'] ?? 0; ?>)
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold filter-tab-btn" data-filter="engineering">
                    <i class="fas fa-cogs text-primary me-1"></i> Engineering &amp; Tech (<?php echo $filterCounts['engineering'] ?? 0; ?>)
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold filter-tab-btn" data-filter="nursing">
                    <i class="fas fa-user-nurse text-info me-1"></i> Nursing &amp; Paramedical (<?php echo $filterCounts['nursing'] ?? 0; ?>)
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold filter-tab-btn" data-filter="law">
                    <i class="fas fa-balance-scale text-secondary me-1"></i> Law (<?php echo $filterCounts['law'] ?? 0; ?>)
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold filter-tab-btn" data-filter="agriculture">
                    <i class="fas fa-seedling text-success me-1"></i> Agriculture (<?php echo $filterCounts['agriculture'] ?? 0; ?>)
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold filter-tab-btn" data-filter="management">
                    <i class="fas fa-briefcase text-dark me-1"></i> Management &amp; IT (<?php echo $filterCounts['management'] ?? 0; ?>)
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold filter-tab-btn" data-filter="allied">
                    <i class="fas fa-atom text-purple me-1"></i> Allied Arts &amp; Sciences (<?php echo $filterCounts['allied'] ?? 0; ?>)
                </button>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4" id="unitCardsContainer">
            <?php foreach ($units as $u): ?>
                <div class="col unit-card-col" 
                     data-category="<?php echo sanitize($u['group']); ?>" 
                     data-title="<?php echo htmlspecialchars(strtolower($u['title'] . ' ' . $u['subtitle'] . ' ' . $u['approvals'])); ?>">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white unit-box-hover position-relative" style="transition: all 0.3s ease; border: 1px solid #e2e8f0 !important;">
                        
                        <!-- Top Image Wrap -->
                        <div class="position-relative overflow-hidden" style="height: 220px; background: #0f172a;">
                            <img src="<?php echo $u['img_src']; ?>"
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                 class="w-100 h-100 object-fit-cover transition-zoom" 
                                 alt="<?php echo sanitize($u['title']); ?>">
                            
                            <!-- Gradient Overlay -->
                            <div class="position-absolute top-0 start-0 end-0 bottom-0" style="background: linear-gradient(to top, rgba(15,23,42,0.85) 0%, rgba(15,23,42,0.2) 60%, transparent 100%);"></div>

                            <!-- Top-Right Official Seal / Crest -->
                            <?php if (!empty($u['seal']) && file_exists(__DIR__ . '/assets/images/constituent-logos/' . $u['seal'])): ?>
                                <div class="position-absolute top-0 end-0 m-3 bg-white rounded-circle p-1 shadow-sm d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; z-index: 2;">
                                    <img src="<?php echo BASE_URL; ?>assets/images/constituent-logos/<?php echo $u['seal']; ?>" alt="Seal" class="img-fluid" style="max-height: 44px; object-fit: contain;">
                                </div>
                            <?php else: ?>
                                <div class="position-absolute top-0 end-0 m-3 bg-white bg-opacity-25 rounded-circle p-2 shadow-sm d-flex align-items-center justify-content-center text-white" style="width: 44px; height: 44px; backdrop-filter: blur(4px);">
                                    <i class="fas fa-university"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Bottom Badges on Image -->
                            <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white d-flex align-items-center justify-content-between flex-wrap gap-1" style="z-index: 2;">
                                <?php if (!empty($u['est_year'])): ?>
                                    <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill small">
                                        Est. <?php echo sanitize($u['est_year']); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($u['approvals'])): ?>
                                    <span class="badge bg-white bg-opacity-25 text-white border border-white-50 px-2 py-1 rounded-pill small">
                                        <?php echo sanitize($u['approvals']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-danger-subtle text-danger fw-semibold px-2 py-1 rounded-pill small mb-2 d-inline-block">
                                    <?php echo sanitize($u['subtitle']); ?>
                                </span>
                                
                                <h3 class="h5 fw-bold text-navy mb-2" style="font-size: 1.1rem; line-height: 1.4;">
                                    <a href="<?php echo sanitize($u['href']); ?>" class="text-navy text-decoration-none hover-danger">
                                        <?php echo sanitize($u['title']); ?>
                                    </a>
                                </h3>

                            </div>

                            <!-- Footer Actions -->
                            <div class="pt-3 mt-3 border-top d-flex align-items-center justify-content-between gap-2">
                                <a href="<?php echo sanitize($u['href']); ?>" class="btn btn-sm btn-danger fw-bold rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 shadow-xs">
                                    Explore College <i class="fas fa-arrow-right fa-xs ms-1"></i>
                                </a>

                                <?php if (!empty($u['external_url'])): ?>
                                    <a href="<?php echo $u['external_url']; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1 small" title="Visit Dedicated Hospital / Institute Portal">
                                        <i class="fas fa-globe text-primary me-1"></i> Official Web <i class="fas fa-external-link-alt fa-xs"></i>
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- No Results Found Box -->
        <div id="noUnitsMatch" class="card border-0 shadow-sm rounded-4 p-5 text-center my-4 bg-white" style="display:none;">
            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                <i class="fas fa-search text-muted fa-2x"></i>
            </div>
            <h4 class="h5 fw-bold text-navy mb-2">No Constituent Units Found</h4>
            <p class="text-muted small mb-3">No constituent college matches your selected filter or search criteria.</p>
            <div>
                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 py-2 fw-semibold" id="resetUnitsFilter">
                    <i class="fas fa-redo me-1"></i> Reset Filters
                </button>
            </div>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     FAQ SECTION
═══════════════════════════════════════════════════════ -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, var(--srku-maroon), var(--srku-navy));">
    <div class="container-xl py-2">
        <div class="text-center mb-4">
            <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill small text-uppercase">Constituent Units FAQ</span>
            <h2 class="fw-bold mt-2 text-white">Frequently Asked Questions</h2>
        </div>
        
        <div class="accordion mx-auto" id="cuFaq" style="max-width:820px;">
            <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                <h3 class="accordion-header">
                    <button class="accordion-button fw-bold text-navy" type="button" data-bs-toggle="collapse" data-bs-target="#cuFaq1" aria-expanded="true" aria-controls="cuFaq1">
                        What is the difference between a Constituent Unit and an Affiliated College?
                    </button>
                </h3>
                <div id="cuFaq1" class="accordion-collapse collapse show" data-bs-parent="#cuFaq">
                    <div class="accordion-body text-dark" style="line-height: 1.75; font-size: 0.95rem;">
                        Constituent units of SRK University are integral, statutory colleges established, owned, and directly governed under the charter of Sarvepalli Radhakrishnan University. Degrees are conferred directly by SRKU, and all clinical training, hospital rotations, and laboratory infrastructure are maintained to university and apex council standards.
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold text-navy" type="button" data-bs-toggle="collapse" data-bs-target="#cuFaq2" aria-expanded="false" aria-controls="cuFaq2">
                        Are medical, dental, and pharmacy degrees awarded by SRKU recognized nationwide?
                    </button>
                </h3>
                <div id="cuFaq2" class="accordion-collapse collapse" data-bs-parent="#cuFaq">
                    <div class="accordion-body text-dark" style="line-height: 1.75; font-size: 0.95rem;">
                        Yes. Every constituent professional college of SRKU is recognized and approved by its respective national statutory apex council: <strong>NMC</strong> (National Medical Commission for MBBS/MD/MS), <strong>DCI</strong> (Dental Council of India for BDS/MDS), <strong>NCISM</strong> (National Commission for Indian System of Medicine for BAMS), <strong>NCH</strong> (Homoeopathy for BHMS), <strong>PCI</strong> (Pharmacy Council of India), <strong>INC</strong> (Indian Nursing Council), <strong>BCI</strong> (Bar Council of India), and <strong>AICTE</strong> (Engineering &amp; Management).
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold text-navy" type="button" data-bs-toggle="collapse" data-bs-target="#cuFaq3" aria-expanded="false" aria-controls="cuFaq3">
                        Does SRKU operate teaching hospitals for clinical medical training?
                    </button>
                </h3>
                <div id="cuFaq3" class="accordion-collapse collapse" data-bs-parent="#cuFaq">
                    <div class="accordion-body text-dark" style="line-height: 1.75; font-size: 0.95rem;">
                        Yes. SRKU boasts a <strong>750+ bed multispecialty teaching hospital</strong>, 24x7 emergency trauma centre, advanced ICU/NICU/PICU units, an NABH-aligned blood bank, and dedicated outpatient departments (OPDs). Additionally, our campus houses a 250-chair dental hospital, a 60-bed Ayurvedic hospital with Panchakarma facilities, and a Homoeopathic clinical hospital.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CALL TO ACTION
═══════════════════════════════════════════════════════ -->
<section class="py-5 text-center text-white position-relative" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3 position-relative" style="z-index: 2;">
        <h2 class="fw-bold mb-3 display-6">Ready to Begin Your Academic Journey<br>at SRK University?</h2>
        <p class="text-white-50 mb-4 mx-auto lead fs-6" style="max-width: 650px;">
            Join over 18,000 students thriving across our 20+ constituent colleges. Admissions for the 2026-27 academic session are now open.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn btn-warning fw-bold text-dark px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-pencil-alt me-1"></i> Apply Online Now
            </a>
            <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Constituent-units.pdf" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light px-4 py-2 rounded-pill">
                <i class="fas fa-file-pdf me-1 text-warning"></i> Download Brochure
            </a>
            <a href="tel:07554700983" class="btn btn-outline-light px-4 py-2 rounded-pill">
                <i class="fas fa-phone-alt me-1 text-warning"></i> Call Admission Cell (0755-4700983)
            </a>
        </div>
    </div>
</section>

<!-- Interactive Filter & Search JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-tab-btn');
    const searchInput = document.getElementById('unitSearchInput');
    const clearSearchBtn = document.getElementById('clearUnitSearch');
    const unitCols = document.querySelectorAll('.unit-card-col');
    const counter = document.getElementById('visibleUnitsCount');
    const noMatchBox = document.getElementById('noUnitsMatch');
    const resetBtn = document.getElementById('resetUnitsFilter');

    let activeFilter = 'all';
    let currentSearchTerm = '';

    function applyFilter() {
        let visibleCount = 0;

        unitCols.forEach(function(col) {
            const category = col.getAttribute('data-category');
            const titleData = col.getAttribute('data-title') || '';

            const matchesCategory = (activeFilter === 'all' || category === activeFilter);
            const matchesSearch = (!currentSearchTerm || titleData.includes(currentSearchTerm));

            if (matchesCategory && matchesSearch) {
                col.style.display = '';
                visibleCount++;
            } else {
                col.style.display = 'none';
            }
        });

        if (counter) counter.textContent = visibleCount;
        if (noMatchBox) noMatchBox.style.display = (visibleCount === 0) ? 'block' : 'none';
    }

    // Filter tab click
    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => {
                b.classList.remove('btn-danger', 'active');
                b.classList.add('btn-outline-secondary');
            });
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-danger', 'active');

            activeFilter = this.getAttribute('data-filter') || 'all';
            applyFilter();
        });
    });

    // Real-time search
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentSearchTerm = this.value.trim().toLowerCase();
            if (clearSearchBtn) {
                clearSearchBtn.style.display = currentSearchTerm ? 'block' : 'none';
            }
            applyFilter();
        });
    }

    // Clear search
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            currentSearchTerm = '';
            this.style.display = 'none';
            applyFilter();
        });
    }

    // Reset button
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            currentSearchTerm = '';
            if (clearSearchBtn) clearSearchBtn.style.display = 'none';
            const allBtn = document.querySelector('.filter-tab-btn[data-filter="all"]');
            if (allBtn) allBtn.click();
        });
    }
});
</script>

<style>
.unit-box-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 32px rgba(15, 23, 42, 0.12) !important;
}
.unit-box-hover:hover .transition-zoom {
    transform: scale(1.05);
}
.transition-zoom {
    transition: transform 0.4s ease;
}
.hover-danger:hover {
    color: #b91c1c !important;
}
.text-purple {
    color: #7c3aed !important;
}
</style>

<script src="<?php echo BASE_URL; ?>assets/js/reveal.js" defer></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
