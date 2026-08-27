<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Distinguished Faculty Directory | 1,000+ Professors & Mentors | SRKU";
$pageDesc = "Meet 1,000+ esteemed professors, medical doctors, researchers, and academic leaders at Sarvepalli Radhakrishnan University (SRKU) Bhopal across 15 constituent colleges.";
$pageKeywords = "SRKU Faculty, Professors Bhopal, Medical Faculty RKDF, Engineering Professors Bhopal, Academic Mentors";
$activeNav = "faculties";

$stats = getFacultyStats();
$facultyDepts = getFacultyDepartments();
$allFaculty = getFacultyList();

$selectedDept = sanitize($_GET['dept'] ?? '');
$searchQuery = sanitize($_GET['q'] ?? '');

require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════
     HERO — AURORA MESH (Same as About Us)
═══════════════════════════════════════════════════════ -->
<section class="about-hero-v2">
    <div class="about-hero-v2__blob about-hero-v2__blob--1"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--2"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--3"></div>
    <div class="about-hero-v2__grid"></div>

    <div class="container-xl about-hero-v2__inner">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-warning"><i class="fas fa-home me-1"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>departments.php" class="text-decoration-none text-white-50">Academic Units</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgba(255,255,255,0.85);">Faculty Directory</li>
                    </ol>
                </nav>
                <span class="about-hero-v2__eyebrow"><i class="fas fa-chalkboard-teacher"></i> Academic Leadership &amp; Mentorship</span>
                <h1 class="about-hero-v2__title">Distinguished <span>Faculty Directory</span> &ndash; Mentoring Future Leaders</h1>
                <p class="about-hero-v2__desc">
                    Meet our team of over <strong>1,000+</strong> esteemed professors, eminent doctors, researchers, and industry veterans delivering experiential pedagogy and pioneering research across constituent colleges and institutes.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/department-wise-faculty-details.pdf" target="_blank" class="btn-hero-yellow">
                        <i class="fas fa-file-pdf me-1"></i> Download Faculty List (PDF)
                    </a>
                    <a href="<?php echo BASE_URL; ?>departments.php" class="btn-hero-outline">
                        <i class="fas fa-building me-1"></i> View Academic Units
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-hero-v2__cards">
                    <div class="about-hero-v2__card about-hero-v2__card--float1">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span class="num"><?php echo number_format($stats['total'] ?: 1000); ?>+</span>
                        <span class="lbl">Faculty Members</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float2">
                        <i class="fas fa-layer-group"></i>
                        <span class="num"><?php echo $stats['departments'] ?: 15; ?></span>
                        <span class="lbl">Constituent Units</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float3">
                        <i class="fas fa-user-tie"></i>
                        <span class="num"><?php echo number_format($stats['professors'] ?: 180); ?>+</span>
                        <span class="lbl">Professors &amp; Deans</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float4">
                        <i class="fas fa-award"></i>
                        <span class="num"><?php echo number_format($stats['phd_md_count'] ?: 600); ?>+</span>
                        <span class="lbl">PhD / MD Mentors</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Calculate dynamic role counts
function getRoleCategory($desig) {
    $d = strtolower($desig);
    if (strpos($d, 'dean') !== false || strpos($d, 'principal') !== false || strpos($d, 'director') !== false) {
        return 'dean_principal';
    }
    if (strpos($d, 'associate') !== false || strpos($d, 'reader') !== false) {
        return 'associate_professor';
    }
    if (strpos($d, 'assistant') !== false || strpos($d, 'lecturer') !== false) {
        return 'assistant_professor';
    }
    if (strpos($d, 'professor') !== false) {
        return 'professor';
    }
    if (strpos($d, 'resident') !== false) {
        return 'resident';
    }
    if (strpos($d, 'tutor') !== false || strpos($d, 'cmo') !== false) {
        return 'tutor';
    }
    return 'other';
}

$roleCounts = [
    'dean_principal' => 0,
    'professor' => 0,
    'associate_professor' => 0,
    'assistant_professor' => 0,
    'resident' => 0,
    'tutor' => 0
];
foreach ($allFaculty as $f) {
    $rc = getRoleCategory($f['designation']);
    if (isset($roleCounts[$rc])) {
        $roleCounts[$rc]++;
    }
}
?>

<!-- Main Faculty Directory Section -->
<section class="py-5 bg-light">
    <div class="container-fluid px-3 px-lg-5" style="max-width: 1560px;">

        <!-- Interactive Search and Filter Header Card -->
        <div class="card p-3 p-lg-4 border-0 shadow-sm rounded-4 mb-4 bg-white border">
            <div class="row g-3 align-items-center">
                <!-- Search Input -->
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted ps-3"><i class="fas fa-search"></i></span>
                        <input type="text" id="facultySearchInput" class="form-control bg-light border-start-0 py-2" placeholder="Search by name, doctor, qualification..." value="<?php echo sanitize($searchQuery); ?>" autocomplete="off">
                        <button class="btn btn-outline-secondary d-none" id="clearSearchBtn" type="button"><i class="fas fa-times"></i></button>
                    </div>
                </div>

                <!-- Department / Institute Filter -->
                <div class="col-12 col-md-4 col-lg-4">
                    <select id="departmentFilterSelect" class="form-select bg-light py-2">
                        <option value="">All Constituent Colleges &amp; Institutes (<?php echo count($allFaculty); ?>)</option>
                        <?php foreach ($facultyDepts as $fd): ?>
                            <option value="<?php echo sanitize($fd['dept_slug']); ?>" <?php echo $selectedDept === $fd['dept_slug'] ? 'selected' : ''; ?>>
                                <?php echo sanitize($fd['department_name']); ?> (<?php echo $fd['count']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Designation Category Filter (Exact Category Match) -->
                <div class="col-12 col-md-3 col-lg-4 d-flex justify-content-md-end align-items-center gap-2">
                    <select id="designationFilterSelect" class="form-select bg-light py-2" style="max-width: 260px;">
                        <option value="">All Academic Roles (<?php echo count($allFaculty); ?>)</option>
                        <option value="dean_principal">Deans &amp; Principals (<?php echo $roleCounts['dean_principal']; ?>)</option>
                        <option value="professor">Professors &amp; HODs (<?php echo $roleCounts['professor']; ?>)</option>
                        <option value="associate_professor">Associate Professors &amp; Readers (<?php echo $roleCounts['associate_professor']; ?>)</option>
                        <option value="assistant_professor">Assistant Professors &amp; Lecturers (<?php echo $roleCounts['assistant_professor']; ?>)</option>
                        <option value="resident">Senior &amp; Junior Residents (<?php echo $roleCounts['resident']; ?>)</option>
                        <option value="tutor">Clinical Tutors &amp; Instructors (<?php echo $roleCounts['tutor']; ?>)</option>
                    </select>

                    <div class="btn-group border rounded" role="group" aria-label="View toggle">
                        <button type="button" id="cardViewBtn" class="btn btn-sm btn-danger active" title="Grid Card View"><i class="fas fa-th-large"></i></button>
                        <button type="button" id="tableViewBtn" class="btn btn-sm btn-light" title="Compact Table View"><i class="fas fa-list"></i></button>
                    </div>
                </div>
            </div>

            <!-- Quick Filter Chips & Results Count Bar -->
            <div class="pt-3 mt-3 border-top">
                <div class="d-flex align-items-center gap-1 flex-wrap" id="quickPillsContainer">
                    <span class="small text-muted fw-bold me-1 text-nowrap"><i class="fas fa-filter text-danger me-1"></i> Quick Filters:</span>
                    <button type="button" class="btn btn-xs rounded-pill px-2 py-1 fw-semibold active-pill text-nowrap" data-category="">All (<?php echo count($allFaculty); ?>)</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill px-2 py-1 fw-semibold text-nowrap" data-category="medical">Medical (350)</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill px-2 py-1 fw-semibold text-nowrap" data-category="engineering">Engineering (272)</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill px-2 py-1 fw-semibold text-nowrap" data-category="pharmacy">Pharmacy (154)</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill px-2 py-1 fw-semibold text-nowrap" data-category="dental">Dental (102)</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill px-2 py-1 fw-semibold text-nowrap" data-category="nursing">Nursing (80)</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill px-2 py-1 fw-semibold text-nowrap" data-category="homoeopathic">Homoeopathy (47)</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill px-2 py-1 fw-semibold text-nowrap" data-category="ayurveda">Ayurveda (31)</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill px-2 py-1 fw-semibold text-nowrap" data-category="management">Management (25)</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary rounded-pill px-2 py-1 fw-semibold text-nowrap" data-category="law">Law (18)</button>

                    <div class="ms-auto text-secondary small fw-bold text-nowrap ps-2">
                        Showing <span id="visibleCount" class="text-danger fw-bold"><?php echo count($allFaculty); ?></span> of <?php echo count($allFaculty); ?> Faculties
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. GRID CARD VIEW (Default) -->
        <div id="facultyGridView" class="row g-4">
            <?php 
            $cardIdx = 0;
            foreach ($allFaculty as $fac): 
                $cardIdx++;
                $name = $fac['name'];
                $dept = $fac['department_name'];
                $deptSlug = $fac['dept_slug'];
                $desig = $fac['designation'];
                $qual = $fac['qualification'] ?: 'Doctorate / Postgraduate';
                $exp = $fac['experience'] ?: 'Experienced';

                // Determine styling & discipline category
                $isDean = stripos($desig, 'Dean') !== false || stripos($desig, 'Principal') !== false || stripos($desig, 'Director') !== false;
                $isHod = stripos($desig, 'HOD') !== false || stripos($desig, 'Head') !== false;
                $isProfessor = stripos($desig, 'Professor') !== false;
                $isMedical = stripos($dept, 'Medical') !== false;
                $isDental = stripos($dept, 'Dental') !== false;
                $isAyurveda = stripos($dept, 'Ayurveda') !== false;
                $isHomoeo = stripos($dept, 'Homoeopathic') !== false;
                $isPharmacy = stripos($dept, 'Pharmacy') !== false;
                $isNursing = stripos($dept, 'Nursing') !== false;
                $isLaw = stripos($dept, 'Law') !== false;
                $isMgmt = stripos($dept, 'Management') !== false || stripos($dept, 'Business') !== false;
                $isEngg = stripos($dept, 'Science and Technology') !== false || stripos($dept, 'MCA') !== false || stripos($dept, 'Engineering') !== false;

                $catKey = 'other';
                if ($isMedical) $catKey = 'medical';
                elseif ($isDental) $catKey = 'dental';
                elseif ($isAyurveda) $catKey = 'ayurveda';
                elseif ($isHomoeo) $catKey = 'homoeopathic';
                elseif ($isPharmacy) $catKey = 'pharmacy';
                elseif ($isNursing) $catKey = 'nursing';
                elseif ($isEngg) $catKey = 'engineering';
                elseif ($isLaw) $catKey = 'law';
                elseif ($isMgmt) $catKey = 'management';

                $roleCat = getRoleCategory($desig);

                // Initials for avatar
                $cleanName = preg_replace('/^(Dr\.|Prof\.|Mr\.|Ms\.|Mrs\.|Ma\.)\s*/i', '', $name);
                $parts = explode(' ', trim($cleanName));
                $initials = strtoupper(substr($parts[0] ?? 'S', 0, 1) . substr($parts[1] ?? ($parts[0] ?? 'R'), 0, 1));
            ?>
                <div class="col-12 col-md-6 col-lg-4 faculty-item" 
                     data-name="<?php echo sanitize(strtolower($name)); ?>"
                     data-dept="<?php echo sanitize(strtolower($deptSlug . ' ' . $dept)); ?>"
                     data-desig="<?php echo sanitize(strtolower($desig)); ?>"
                     data-category="<?php echo sanitize($catKey); ?>"
                     data-role="<?php echo sanitize($roleCat); ?>"
                     data-qual="<?php echo sanitize(strtolower($qual)); ?>"
                     data-exp="<?php echo sanitize(strtolower($exp)); ?>">
                    
                    <div class="card h-100 border shadow-sm rounded-4 bg-white faculty-card transition-hover position-relative <?php echo $isDean ? 'card-dean' : ''; ?>">
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <!-- Top Department Tag & Leader Badge (Clean & High-Contrast) -->
                                <div class="d-flex align-items-start justify-content-between gap-2 mb-3 pb-2 border-bottom">
                                    <span class="small fw-semibold text-secondary text-wrap" style="font-size: 0.8rem; line-height: 1.35;">
                                        <i class="fas fa-university text-danger me-1"></i> <?php echo sanitize($dept); ?>
                                    </span>
                                    <?php if ($isDean): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1 flex-shrink-0 fw-bold" style="font-size: 0.68rem; letter-spacing: 0.3px;">
                                            KEY LEADER
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Faculty Header (Avatar + Name + Role) -->
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <div class="faculty-avatar rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5 shadow-xs flex-shrink-0 <?php echo $isDean ? 'avatar-gold' : ($isProfessor ? 'avatar-navy' : 'avatar-standard'); ?>" style="width: 52px; height: 52px;">
                                        <?php echo $initials; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fw-bold text-navy mb-1 text-wrap" style="font-size: 1.05rem; line-height: 1.3;" title="<?php echo sanitize($name); ?>">
                                            <?php echo sanitize($name); ?>
                                        </h5>
                                        <div class="d-flex flex-wrap gap-1 align-items-center mt-1">
                                            <span class="badge <?php echo $isDean || $isHod ? 'bg-danger text-white' : ($isProfessor ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-light text-dark border'); ?> px-2 py-1 rounded fw-semibold text-wrap text-start" style="font-size: 0.75rem; line-height: 1.3;">
                                                <?php echo sanitize($desig); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Qualifications & Experience (Clean, Decluttered) -->
                                <div class="my-3 py-2 px-3 bg-light rounded-3 border">
                                    <div class="d-flex align-items-start gap-2 mb-2">
                                        <i class="fas fa-graduation-cap text-danger mt-1 flex-shrink-0" style="width: 16px;"></i>
                                        <div class="small fw-semibold text-dark text-wrap" style="line-height: 1.35;" title="<?php echo sanitize($qual); ?>">
                                            <?php echo sanitize($qual); ?>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="far fa-clock text-success flex-shrink-0" style="width: 16px;"></i>
                                        <div class="small text-muted">
                                            Teaching Exp: <strong class="text-dark"><?php echo sanitize($exp); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Info -->
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top text-muted" style="font-size: 0.78rem;">
                                <span><i class="fas fa-map-marker-alt text-danger me-1"></i> SRKU Main Campus</span>
                                <span class="text-success fw-semibold">
                                    <i class="fas fa-check-circle me-1"></i> Full Time Faculty
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- 2. TABLE VIEW (Toggleable for Fast Academic Audit) -->
        <div id="facultyTableView" class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white d-none">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="facultyMainTable">
                    <thead class="table-dark text-white">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 25%;">Faculty Name</th>
                            <th style="width: 20%;">Designation / Role</th>
                            <th style="width: 25%;">Department &amp; College</th>
                            <th style="width: 15%;">Qualification</th>
                            <th style="width: 10%;" class="text-end">Experience</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $tIdx = 0;
                        foreach ($allFaculty as $fac): 
                            $tIdx++;
                            $tRoleCat = getRoleCategory($fac['designation']);
                            $tDept = $fac['department_name'];
                            $tCatKey = 'other';
                            if (stripos($tDept, 'Medical') !== false) $tCatKey = 'medical';
                            elseif (stripos($tDept, 'Dental') !== false) $tCatKey = 'dental';
                            elseif (stripos($tDept, 'Ayurveda') !== false) $tCatKey = 'ayurveda';
                            elseif (stripos($tDept, 'Homoeopathic') !== false) $tCatKey = 'homoeopathic';
                            elseif (stripos($tDept, 'Pharmacy') !== false) $tCatKey = 'pharmacy';
                            elseif (stripos($tDept, 'Nursing') !== false) $tCatKey = 'nursing';
                            elseif (stripos($tDept, 'Science and Technology') !== false || stripos($tDept, 'MCA') !== false || stripos($tDept, 'Engineering') !== false) $tCatKey = 'engineering';
                            elseif (stripos($tDept, 'Law') !== false) $tCatKey = 'law';
                            elseif (stripos($tDept, 'Management') !== false || stripos($tDept, 'Business') !== false) $tCatKey = 'management';
                        ?>
                            <tr class="faculty-table-row"
                                data-name="<?php echo sanitize(strtolower($fac['name'])); ?>"
                                data-dept="<?php echo sanitize(strtolower($fac['dept_slug'] . ' ' . $fac['department_name'])); ?>"
                                data-desig="<?php echo sanitize(strtolower($fac['designation'])); ?>"
                                data-category="<?php echo sanitize($tCatKey); ?>"
                                data-role="<?php echo sanitize($tRoleCat); ?>"
                                data-qual="<?php echo sanitize(strtolower($fac['qualification'])); ?>"
                                data-exp="<?php echo sanitize(strtolower($fac['experience'])); ?>">
                                <td class="text-muted small"><?php echo $tIdx; ?></td>
                                <td>
                                    <div class="fw-bold text-navy"><?php echo sanitize($fac['name']); ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border px-2 py-1 small"><?php echo sanitize($fac['designation']); ?></span>
                                </td>
                                <td>
                                    <div class="small fw-semibold text-secondary"><?php echo sanitize($fac['department_name']); ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 small"><?php echo sanitize($fac['qualification']); ?></span>
                                </td>
                                <td class="text-end fw-bold text-success small">
                                    <?php echo sanitize($fac['experience']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Empty State Message -->
        <div id="noFacultyFound" class="card p-5 text-center border-0 shadow-sm rounded-4 mt-4 d-none bg-white">
            <i class="fas fa-user-slash fa-3x text-muted opacity-50 mb-3"></i>
            <h4 class="fw-bold text-navy mb-2">No Matching Faculty Found</h4>
            <p class="text-muted mb-3" style="max-width: 500px; margin: 0 auto;">No faculty members match your selected combination of department, role, and search keywords.</p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <button type="button" class="btn btn-outline-danger btn-sm px-3 rounded-pill fw-semibold" onclick="resetRoleFilter()">
                    <i class="fas fa-times me-1"></i> Clear Role Filter
                </button>
                <button type="button" class="btn btn-danger btn-sm px-4 rounded-pill fw-bold" onclick="resetAllFacultyFilters()">
                    <i class="fas fa-sync-alt me-1"></i> Reset All Filters
                </button>
            </div>
        </div>

    </div>
</section>

<!-- Custom Styles for Faculty Directory -->
<style>
.backdrop-blur {
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}
.bg-navy {
    background-color: #0F1E3B !important;
}
.bg-dark-maroon {
    background-color: #5B1614 !important;
}
.faculty-card {
    border: 1px solid #E2E8F0 !important;
    border-top: 3.5px solid #0F1E3B !important;
    border-radius: 14px !important;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.faculty-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 28px -6px rgba(15, 30, 59, 0.12) !important;
    border-color: #CBD5E1 !important;
    border-top-color: #B91C1C !important;
}
.faculty-card.card-dean {
    border-top: 3.5px solid #DC2626 !important;
}
.avatar-gold {
    background: linear-gradient(135deg, #5B1614 0%, #991B1B 100%);
    color: #FDE68A;
    border: 2px solid #FCD34D;
}
.avatar-navy {
    background: linear-gradient(135deg, #0F1E3B 0%, #1E3A8A 100%);
    color: #DBEAFE;
    border: 2px solid #93C5FD;
}
.avatar-standard {
    background: linear-gradient(135deg, #334155 0%, #475569 100%);
    color: #F8FAFC;
    border: 2px solid #CBD5E1;
}
.btn-xs {
    padding: 0.25rem 0.65rem;
    font-size: 0.78rem;
}
.active-pill {
    background-color: #5B1614 !important;
    color: #ffffff !important;
    border-color: #5B1614 !important;
}
</style>

<!-- Dynamic Search & Filter Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('facultySearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    const deptFilter = document.getElementById('departmentFilterSelect');
    const desigFilter = document.getElementById('designationFilterSelect');
    const gridView = document.getElementById('facultyGridView');
    const tableView = document.getElementById('facultyTableView');
    const cardBtn = document.getElementById('cardViewBtn');
    const tableBtn = document.getElementById('tableViewBtn');
    const noResults = document.getElementById('noFacultyFound');
    const visibleCountEl = document.getElementById('visibleCount');
    const quickPills = document.querySelectorAll('#quickPillsContainer button');

    const gridItems = document.querySelectorAll('.faculty-item');
    const tableItems = document.querySelectorAll('.faculty-table-row');

    let currentQuickCategory = '';

    function filterFaculty() {
        const query = searchInput.value.trim().toLowerCase();
        const deptVal = deptFilter.value.trim().toLowerCase();
        const desigVal = desigFilter.value.trim().toLowerCase();

        if (query.length > 0) {
            clearBtn.classList.remove('d-none');
        } else {
            clearBtn.classList.add('d-none');
        }

        let matchCount = 0;

        // Filter Grid Items
        gridItems.forEach(item => {
            const name = item.getAttribute('data-name') || '';
            const dept = item.getAttribute('data-dept') || '';
            const desig = item.getAttribute('data-desig') || '';
            const category = item.getAttribute('data-category') || '';
            const role = item.getAttribute('data-role') || '';
            const qual = item.getAttribute('data-qual') || '';

            const matchQuery = !query || name.includes(query) || dept.includes(query) || desig.includes(query) || qual.includes(query);
            
            // Check category from quick pills or dropdown
            const matchCategory = !currentQuickCategory || category === currentQuickCategory || dept.includes(currentQuickCategory);
            const matchDept = !deptVal || dept.includes(deptVal);
            const matchDesig = !desigVal || role === desigVal;

            if (matchQuery && matchCategory && matchDept && matchDesig) {
                item.style.display = '';
                matchCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Filter Table Items
        tableItems.forEach(item => {
            const name = item.getAttribute('data-name') || '';
            const dept = item.getAttribute('data-dept') || '';
            const desig = item.getAttribute('data-desig') || '';
            const category = item.getAttribute('data-category') || '';
            const role = item.getAttribute('data-role') || '';
            const qual = item.getAttribute('data-qual') || '';

            const matchQuery = !query || name.includes(query) || dept.includes(query) || desig.includes(query) || qual.includes(query);
            const matchCategory = !currentQuickCategory || category === currentQuickCategory || dept.includes(currentQuickCategory);
            const matchDept = !deptVal || dept.includes(deptVal);
            const matchDesig = !desigVal || role === desigVal;

            if (matchQuery && matchCategory && matchDept && matchDesig) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });

        visibleCountEl.innerText = matchCount;

        if (matchCount === 0) {
            noResults.classList.remove('d-none');
            gridView.classList.add('d-none');
            tableView.classList.add('d-none');
        } else {
            noResults.classList.add('d-none');
            if (cardBtn.classList.contains('active')) {
                gridView.classList.remove('d-none');
                tableView.classList.add('d-none');
            } else {
                gridView.classList.add('d-none');
                tableView.classList.remove('d-none');
            }
        }
    }

    searchInput.addEventListener('input', filterFaculty);
    
    deptFilter.addEventListener('change', function() {
        // Clear quick pills active state when selecting from dropdown
        const selectedVal = deptFilter.value.toLowerCase();
        currentQuickCategory = '';
        
        quickPills.forEach(p => {
            const cat = p.getAttribute('data-category');
            if (cat && selectedVal.includes(cat)) {
                p.classList.add('active-pill');
                p.classList.remove('btn-outline-secondary');
            } else if (!cat && !selectedVal) {
                p.classList.add('active-pill');
                p.classList.remove('btn-outline-secondary');
            } else {
                p.classList.remove('active-pill');
                p.classList.add('btn-outline-secondary');
            }
        });

        filterFaculty();
    });

    desigFilter.addEventListener('change', filterFaculty);

    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        filterFaculty();
        searchInput.focus();
    });

    // Quick filter pills click handler
    quickPills.forEach(pill => {
        pill.addEventListener('click', function() {
            quickPills.forEach(p => {
                p.classList.remove('active-pill');
                p.classList.add('btn-outline-secondary');
            });
            this.classList.add('active-pill');
            this.classList.remove('btn-outline-secondary');

            currentQuickCategory = this.getAttribute('data-category') || '';
            deptFilter.value = ''; // Reset department dropdown to show all in this category
            desigFilter.value = ''; // Reset role filter so it immediately shows all faculties of this discipline

            filterFaculty();
        });
    });

    // View Switcher (Card vs Table)
    cardBtn.addEventListener('click', function() {
        cardBtn.classList.add('btn-danger', 'active');
        cardBtn.classList.remove('btn-light');
        tableBtn.classList.remove('btn-danger', 'active');
        tableBtn.classList.add('btn-light');

        if (parseInt(visibleCountEl.innerText) > 0) {
            gridView.classList.remove('d-none');
            tableView.classList.add('d-none');
        }
    });

    tableBtn.addEventListener('click', function() {
        tableBtn.classList.add('btn-danger', 'active');
        tableBtn.classList.remove('btn-light');
        cardBtn.classList.remove('btn-danger', 'active');
        cardBtn.classList.add('btn-light');

        if (parseInt(visibleCountEl.innerText) > 0) {
            tableView.classList.remove('d-none');
            gridView.classList.add('d-none');
        }
    });

    window.resetRoleFilter = function() {
        desigFilter.value = '';
        filterFaculty();
    };

    window.resetAllFacultyFilters = function() {
        searchInput.value = '';
        deptFilter.value = '';
        desigFilter.value = '';
        currentQuickCategory = '';
        quickPills.forEach((p, idx) => {
            if (idx === 0) {
                p.classList.add('active-pill');
                p.classList.remove('btn-outline-secondary');
            } else {
                p.classList.remove('active-pill');
                p.classList.add('btn-outline-secondary');
            }
        });
        filterFaculty();
    };

    // Run initial filter if URL parameters exist
    if (searchInput.value || deptFilter.value) {
        filterFaculty();
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

