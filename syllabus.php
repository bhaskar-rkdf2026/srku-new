<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Scheme & Syllabus | Semester Curriculum & PDF Downloads | SRKU";
$pageDesc = "Download official course schemes, semester-wise syllabus, examination guidelines, and grading patterns for all degree programs at Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = "SRKU Syllabus, Scheme of Examination, BTech Syllabus, Pharmacy Syllabus Bhopal, University Curriculum PDF";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';

$departments = getDepartments(true);
$allCourses = getCourses();
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('syllabus', 'Academic Curriculum & Syllabus', 'Official Semester-Wise Scheme of Examination, Course Structures & Learning Outcomes for 2026-27'); ?>

<section class="py-5 bg-light-subtle">
    <div class="container-xl py-3">
        
        <!-- Section Header Intro -->
        <div class="text-center mb-5" style="max-width:850px; margin:auto;">
            <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold text-uppercase mb-2" style="letter-spacing:1px;">
                <i class="fas fa-file-pdf me-1"></i> UGC, AICTE, PCI &amp; NEP-2020 Aligned
            </span>
            <h2 class="fw-bold text-navy display-6 mb-3">Download Course Scheme &amp; Syllabus</h2>
            <p class="text-secondary lead fs-6">
                Access official curriculum outlines, detailed semester-wise subject schemes, credit distribution, internal assessment criteria, and prescribed textbooks directly from SRK University academic repository.
            </p>
        </div>

        <!-- Filter & Search Controls Bar -->
        <div class="card p-4 p-lg-4 border-0 shadow-sm rounded-4 mb-5 bg-white">
            <div class="row g-3 align-items-end">
                
                <!-- Search Input -->
                <div class="col-12 col-md-6 col-lg-4">
                    <label for="syllabusSearch" class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-search text-danger me-1"></i> Search Curriculum
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="syllabusSearch" class="form-control border-start-0 ps-0" placeholder="Search course, branch, specialization..." oninput="applySyllabusFilters()">
                    </div>
                </div>

                <!-- Discipline / Faculty Dropdown -->
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <label for="disciplineFilter" class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-university text-primary me-1"></i> Faculty / Discipline
                    </label>
                    <select id="disciplineFilter" class="form-select" onchange="applySyllabusFilters()">
                        <option value="all">All Faculties &amp; Disciplines</option>
                        <option value="engineering">Engineering &amp; Technology</option>
                        <option value="pharmacy">Pharmacy &amp; Pharmaceutical</option>
                        <option value="medical">Medical, Dental &amp; Ayush</option>
                        <option value="nursing">Nursing &amp; Paramedical</option>
                        <option value="law">Law &amp; Legal Studies</option>
                        <option value="agriculture">Agriculture &amp; Allied</option>
                        <option value="management">Management &amp; Commerce</option>
                        <option value="computer">Computer Applications (BCA/MCA)</option>
                        <option value="science">Sciences, Arts &amp; Yoga</option>
                    </select>
                </div>

                <!-- Academic Level Dropdown -->
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <label for="levelFilter" class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-layer-group text-warning me-1"></i> Academic Level
                    </label>
                    <select id="levelFilter" class="form-select" onchange="applySyllabusFilters()">
                        <option value="all">All Academic Levels</option>
                        <option value="undergraduate">Undergraduate (UG)</option>
                        <option value="postgraduate">Postgraduate (PG)</option>
                        <option value="diploma">Diploma / Polytechnic</option>
                        <option value="doctorate">Doctorate (Ph.D.)</option>
                    </select>
                </div>

                <!-- Reset Filters Button -->
                <div class="col-12 col-md-6 col-lg-2">
                    <button type="button" class="btn btn-outline-danger w-100 rounded-3 py-2 fw-semibold" onclick="resetAllSyllabusFilters()">
                        <i class="fas fa-redo-alt me-1"></i> Reset Filters
                    </button>
                </div>

            </div>
            
            <!-- Active Filter Status Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-3 mt-3 border-top small text-muted">
                <div>
                    <span id="activeFiltersSummary" class="fw-semibold text-navy">
                        <i class="fas fa-sliders-h text-danger me-1"></i> Showing all curriculum schemes
                    </span>
                </div>
            </div>
        </div>

        <!-- Syllabus Department Blocks -->
        <div class="row g-4" id="syllabusContainer">
            <?php foreach ($departments as $dept): 
                $deptCourses = getCourses($dept['slug']);
                if (empty($deptCourses)) {
                    $deptCourses = getCourses($dept['name']);
                }
                if (empty($deptCourses)) continue;
                $deptCategory = strtolower($dept['category'] . ' ' . $dept['name']);
            ?>
                <div class="col-12 dept-block" data-category="<?php echo sanitize($deptCategory); ?>" data-deptname="<?php echo sanitize(strtolower($dept['name'])); ?>">
                    <div class="card p-4 p-md-4 border-0 shadow-sm rounded-4 bg-white">
                        
                        <!-- Department Title Bar -->
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center p-3 shadow-xs" style="width:52px; height:52px; font-size:1.3rem;">
                                    <i class="<?php echo sanitize($dept['icon'] ?: 'fas fa-graduation-cap'); ?>"></i>
                                </div>
                                <div>
                                    <h3 class="h5 fw-bold text-navy mb-1"><?php echo sanitize($dept['name']); ?></h3>
                                    <div class="d-flex align-items-center gap-2 flex-wrap small">
                                        <span class="badge bg-light text-secondary border"><?php echo sanitize($dept['category'] ?: 'Constituent Unit'); ?></span>
                                        <span class="text-muted"><i class="fas fa-check-circle text-success me-1"></i>Approved Programmes</span>
                                        <?php if ($dept['contact_no']): ?>
                                            <span class="text-muted d-none d-md-inline">&bull; <i class="fas fa-phone-alt text-warning me-1"></i><?php echo sanitize($dept['contact_no']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <a href="<?php echo BASE_URL; ?>department/<?php echo urlencode($dept['slug']); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="fas fa-university me-1"></i> Department Profile
                                </a>
                            </div>
                        </div>

                        <!-- Courses Scheme & Syllabus Table -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:38%;">Course / Academic Programme</th>
                                        <th style="width:12%;">Level</th>
                                        <th style="width:12%;">Duration</th>
                                        <th style="width:38%;" class="text-end text-nowrap">Curriculum Documents (PDF)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php foreach ($deptCourses as $c): 
                                        $hasScheme = !empty($c['scheme_url']) && $c['scheme_url'] !== '#';
                                        $hasSyllabus = !empty($c['syllabus_url']) && $c['syllabus_url'] !== '#';
                                        
                                        $schemeHref = $hasScheme ? (strpos($c['scheme_url'], 'http') === 0 ? $c['scheme_url'] : BASE_URL . ltrim($c['scheme_url'], '/')) : '#';
                                        $syllabusHref = $hasSyllabus ? (strpos($c['syllabus_url'], 'http') === 0 ? $c['syllabus_url'] : BASE_URL . ltrim($c['syllabus_url'], '/')) : '#';
                                        $courseLevel = strtolower($c['level'] ?? '');
                                    ?>
                                        <tr class="course-row" 
                                            data-coursename="<?php echo sanitize(strtolower($c['course_name'] . ' ' . ($c['specializations'] ?? '') . ' ' . $dept['name'])); ?>"
                                            data-level="<?php echo sanitize($courseLevel); ?>">
                                            <td>
                                                <div class="fw-bold text-navy fs-6 mb-1">
                                                    <a href="<?php echo BASE_URL; ?>course/<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="text-navy text-decoration-none hover-maroon">
                                                        <?php echo sanitize($c['course_name']); ?>
                                                    </a>
                                                </div>
                                                <?php if (!empty($c['specializations'])): ?>
                                                    <small class="text-muted d-block text-truncate" style="max-width: 420px;" title="<?php echo sanitize($c['specializations']); ?>">
                                                        <i class="fas fa-layer-group text-danger me-1"></i><?php echo sanitize($c['specializations']); ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-level-navy text-white px-2 py-1"><?php echo sanitize($c['level']); ?></span>
                                            </td>
                                            <td>
                                                <span class="text-secondary small fw-semibold"><i class="far fa-clock me-1"></i><?php echo sanitize($c['duration']); ?></span>
                                            </td>
                                            <td class="text-end text-nowrap">
                                                <div class="d-inline-flex gap-2">
                                                    <?php if ($hasScheme): ?>
                                                        <a href="<?php echo sanitize($schemeHref); ?>" target="_blank" class="btn btn-sm btn-outline-danger shadow-xs fw-semibold" title="Download Scheme PDF">
                                                            <i class="fas fa-file-pdf text-danger me-1"></i> Scheme
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="#" class="btn btn-sm btn-outline-secondary opacity-60 shadow-xs fw-semibold" title="Scheme available upon request" onclick="return false;">
                                                            <i class="fas fa-file-alt me-1"></i> Scheme
                                                        </a>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($hasSyllabus): ?>
                                                        <a href="<?php echo sanitize($syllabusHref); ?>" target="_blank" class="btn btn-sm btn-danger shadow-xs fw-semibold" title="Download Syllabus PDF">
                                                            <i class="fas fa-download me-1"></i> Syllabus
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="#" class="btn btn-sm btn-secondary opacity-60 shadow-xs fw-semibold" title="Syllabus available upon request" onclick="return false;">
                                                            <i class="fas fa-clock me-1"></i> On Request
                                                        </a>
                                                    <?php endif; ?>

                                                    <a href="<?php echo BASE_URL; ?>course/<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="btn btn-sm btn-light border" title="Course Details">
                                                        <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Empty Results Alert -->
        <div id="noResultsMsg" class="card p-5 text-center border-0 shadow-sm rounded-4 mt-4 d-none">
            <i class="fas fa-search fa-3x text-muted opacity-50 mb-3"></i>
            <h4 class="fw-bold text-navy mb-2">No matching curriculum documents found</h4>
            <p class="text-muted mb-3">Please try changing your search keywords or adjusting the Faculty &amp; Academic Level filters.</p>
            <div>
                <button type="button" class="btn btn-danger btn-sm px-4 rounded-pill" onclick="resetAllSyllabusFilters()">
                    <i class="fas fa-redo-alt me-1"></i> Reset All Filters
                </button>
            </div>
        </div>

    </div>
</section>

<!-- Curriculum Guidelines FAQ / Notice Box -->
<section class="py-5 bg-white border-top">
    <div class="container-xl">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-navy mb-2">Need Syllabus Assistance or Subject Credits Help?</h3>
                <p class="text-secondary mb-0">
                    If you are an enrolled student or faculty requiring previous years' archive question schemes, elective course guidelines, or credit conversion certificates, please reach out to the University Examination Cell.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?php echo BASE_URL; ?>contact.php" class="btn btn-maroon px-4 py-2 fw-bold">
                    <i class="fas fa-headset me-1"></i> Contact Examination Desk
                </a>
            </div>
        </div>
    </div>
</section>

<script>
function applySyllabusFilters() {
    const query = (document.getElementById('syllabusSearch').value || '').toLowerCase().trim();
    const discipline = document.getElementById('disciplineFilter').value;
    const level = document.getElementById('levelFilter').value;

    const deptBlocks = document.querySelectorAll('.dept-block');
    let totalMatchingCourses = 0;
    let totalVisibleDepts = 0;

    deptBlocks.forEach(block => {
        const catData = (block.getAttribute('data-category') || '').toLowerCase();
        const deptName = (block.getAttribute('data-deptname') || '').toLowerCase();
        const deptCombo = catData + ' ' + deptName;

        // Check if department matches selected discipline
        let deptMatchesDiscipline = false;
        if (discipline === 'all') {
            deptMatchesDiscipline = true;
        } else if (discipline === 'engineering' && (deptCombo.includes('engineering') || deptCombo.includes('science & technology') || deptCombo.includes('polytechnic'))) {
            deptMatchesDiscipline = true;
        } else if (discipline === 'pharmacy' && deptCombo.includes('pharmacy')) {
            deptMatchesDiscipline = true;
        } else if (discipline === 'medical' && (deptCombo.includes('medical') || deptCombo.includes('dental') || deptCombo.includes('ayurveda') || deptCombo.includes('homoeopathic') || deptCombo.includes('hospital'))) {
            deptMatchesDiscipline = true;
        } else if (discipline === 'nursing' && (deptCombo.includes('nursing') || deptCombo.includes('paramedical') || deptCombo.includes('allied'))) {
            deptMatchesDiscipline = true;
        } else if (discipline === 'law' && deptCombo.includes('law')) {
            deptMatchesDiscipline = true;
        } else if (discipline === 'agriculture' && deptCombo.includes('agri')) {
            deptMatchesDiscipline = true;
        } else if (discipline === 'management' && (deptCombo.includes('management') || deptCombo.includes('business') || deptCombo.includes('commerce'))) {
            deptMatchesDiscipline = true;
        } else if (discipline === 'computer' && (deptCombo.includes('computer') || deptCombo.includes('mca') || deptCombo.includes('bca'))) {
            deptMatchesDiscipline = true;
        } else if (discipline === 'science' && (deptCombo.includes('science') || deptCombo.includes('arts') || deptCombo.includes('yoga') || deptCombo.includes('library') || deptCombo.includes('fashion'))) {
            deptMatchesDiscipline = true;
        }

        if (!deptMatchesDiscipline) {
            block.style.display = 'none';
            return;
        }

        const rows = block.querySelectorAll('.course-row');
        let deptHasMatchingRows = 0;

        rows.forEach(row => {
            const courseText = (row.getAttribute('data-coursename') || '').toLowerCase();
            const courseLevel = (row.getAttribute('data-level') || '').toLowerCase();

            // Search query match
            const matchesQuery = !query || courseText.includes(query) || deptName.includes(query);

            // Level match
            let matchesLevel = false;
            if (level === 'all') {
                matchesLevel = true;
            } else if (level === 'undergraduate' && (courseLevel.includes('under') || courseLevel.includes('ug') || courseLevel.includes('bachelor') || courseLevel.includes('b.'))) {
                matchesLevel = true;
            } else if (level === 'postgraduate' && (courseLevel.includes('post') || courseLevel.includes('pg') || courseLevel.includes('master') || courseLevel.includes('m.'))) {
                matchesLevel = true;
            } else if (level === 'diploma' && (courseLevel.includes('diploma') || courseLevel.includes('polytechnic'))) {
                matchesLevel = true;
            } else if (level === 'doctorate' && (courseLevel.includes('doctor') || courseLevel.includes('ph.d') || courseLevel.includes('phd') || courseLevel.includes('research'))) {
                matchesLevel = true;
            }

            if (matchesQuery && matchesLevel) {
                row.style.display = '';
                deptHasMatchingRows++;
                totalMatchingCourses++;
            } else {
                row.style.display = 'none';
            }
        });

        if (deptHasMatchingRows > 0) {
            block.style.display = '';
            totalVisibleDepts++;
        } else {
            block.style.display = 'none';
        }
    });

    // Update Summary
    const summary = document.getElementById('activeFiltersSummary');
    const noMsg = document.getElementById('noResultsMsg');

    if (totalVisibleDepts === 0 || totalMatchingCourses === 0) {
        noMsg.classList.remove('d-none');
        summary.innerHTML = '<i class="fas fa-exclamation-circle text-danger me-1"></i> No matching curriculum found';
    } else {
        noMsg.classList.add('d-none');
        
        let filterParts = [];
        if (query) filterParts.push('"' + query + '"');
        if (discipline !== 'all') filterParts.push(document.getElementById('disciplineFilter').selectedOptions[0].text);
        if (level !== 'all') filterParts.push(document.getElementById('levelFilter').selectedOptions[0].text);
        
        if (filterParts.length > 0) {
            summary.innerHTML = '<i class="fas fa-filter text-danger me-1"></i> Filtered by: <strong>' + filterParts.join(' &bull; ') + '</strong>';
        } else {
            summary.innerHTML = '<i class="fas fa-sliders-h text-danger me-1"></i> Showing all curriculum schemes';
        }
    }
}

function resetAllSyllabusFilters() {
    document.getElementById('syllabusSearch').value = '';
    document.getElementById('disciplineFilter').value = 'all';
    document.getElementById('levelFilter').value = 'all';
    applySyllabusFilters();
}

// Initial execution to ensure sync
document.addEventListener('DOMContentLoaded', applySyllabusFilters);
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
