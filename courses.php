<?php
$pageTitle = "Academic Programmes & Degrees | 120+ UG, PG, PhD Courses | SRKU";
$pageDesc = "Explore 120+ UGC and regulatory approved courses at Sarvepalli Radhakrishnan University (SRKU), Bhopal spanning B.Tech, MBBS, B.Pharm, MBA, MCA, B.Sc. Nursing, Law, Agriculture and Ph.D.";
$pageKeywords = "SRKU Courses, Degrees Catalog, BTech Bhopal, MBBS MP, BPharm Bhopal, MBA Admission, PhD Admissions SRKU";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';

$selectedDept = sanitize($_GET['dept'] ?? '');
$selectedLevel = sanitize($_GET['level'] ?? '');
$searchKeyword = sanitize($_GET['search'] ?? ($_GET['q'] ?? ''));

// Fetch all active courses for client-side instant filtering and deep search
$courses = getCourses();
$departments = getDepartments(true);
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('courses', 'Academic Programmes & Degrees Catalog', 'Undergraduate (UG), Postgraduate (PG), Diploma & Doctoral Research Programs Across 26 Constituent Units'); ?>

<style>
.course-filter-card {
    background: #ffffff;
    border: 1px solid rgba(226, 232, 240, 0.8) !important;
    border-top: 4px solid #7A0B0D !important;
    border-radius: 20px !important;
    box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.07), 0 4px 12px -2px rgba(15, 23, 42, 0.03) !important;
}

.course-filter-card .form-control,
.course-filter-card .form-select {
    height: 48px;
    border-radius: 12px;
    border: 1px solid #cbd5e1;
    font-size: 0.92rem;
    color: #1e293b;
    background-color: #f8fafc;
    transition: all 0.2s ease;
}

.course-filter-card .form-control:focus,
.course-filter-card .form-select:focus {
    background-color: #ffffff;
    border-color: #7A0B0D;
    box-shadow: 0 0 0 3.5px rgba(122, 11, 13, 0.12);
}

.course-filter-card .input-group-text {
    border-radius: 12px 0 0 12px;
    border: 1px solid #cbd5e1;
    border-end: 0;
    background-color: #f8fafc;
}

.btn-filter-reset {
    height: 48px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    color: #7A0B0D;
    background: #fff5f5;
    border: 1px solid #fecdd3;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.btn-filter-reset:hover {
    background: #7A0B0D;
    color: #ffffff;
    border-color: #7A0B0D;
    box-shadow: 0 4px 12px rgba(122, 11, 13, 0.2);
    transform: translateY(-1px);
}

/* Segmented Pill Selector Bar */
.level-pill-wrapper {
    background: #f1f5f9;
    padding: 6px;
    border-radius: 60px;
    display: inline-flex;
    flex-wrap: wrap;
    gap: 6px;
    justify-content: center;
    border: 1px solid #e2e8f0;
}

.level-pill-btn {
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 0.88rem;
    padding: 8px 18px !important;
    border-radius: 50px !important;
    font-weight: 600;
    border: 1px solid transparent !important;
    background: transparent !important;
    color: #475569 !important;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
    text-decoration: none;
    line-height: 1.2;
}

.level-pill-btn:hover {
    background-color: #ffffff !important;
    color: #0f172a !important;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
    transform: translateY(-1px);
}

.level-pill-btn.active {
    background: linear-gradient(135deg, #7A0B0D 0%, #991b1b 100%) !important;
    color: #ffffff !important;
    border-color: #7A0B0D !important;
    box-shadow: 0 4px 14px rgba(122, 11, 13, 0.3) !important;
}

.level-pill-btn.active i {
    color: #ffffff !important;
}

/* Interactive Filter Chips */
.filter-active-chip {
    display: inline-flex;
    align-items: center;
    background: #ffffff;
    color: #7A0B0D;
    border: 1px solid #fecaca;
    padding: 4px 10px 4px 12px;
    border-radius: 30px;
    font-size: 0.82rem;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(122, 11, 13, 0.05);
    gap: 6px;
}

.filter-active-chip .chip-remove-btn {
    background: #fee2e2;
    border: none;
    color: #991b1b;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 0.65rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s ease;
    padding: 0;
}

.filter-active-chip .chip-remove-btn:hover {
    background: #7A0B0D;
    color: #ffffff;
}
</style>

<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- SEARCH & FILTER BAR -->
        <div class="card p-4 p-lg-4 mb-4 course-filter-card">
            
            <div class="row g-3 align-items-end">
                
                <!-- Search Input -->
                <div class="col-12 col-md-5 col-lg-4">
                    <label for="courseSearch" class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-search text-danger me-1"></i> Search Course or Subject
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="courseSearch" class="form-control border-start-0 ps-0" 
                               placeholder="e.g. MBBS, B.Tech, MBA, D.Pharm, MCA, LL.M..." 
                               value="<?php echo sanitize($searchKeyword); ?>" 
                               oninput="applyCourseFilters()">
                    </div>
                </div>

                <!-- Constituent Unit / Faculty Dropdown -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <label for="courseDeptFilter" class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-university text-primary me-1"></i> Constituent Unit / Faculty
                    </label>
                    <select id="courseDeptFilter" class="form-select" onchange="applyCourseFilters()">
                        <option value="">All Constituent Units &amp; Faculties</option>
                        <?php foreach ($departments as $d): ?>
                            <option value="<?php echo sanitize($d['slug']); ?>" 
                                    data-name="<?php echo sanitize(strtolower($d['name'])); ?>"
                                    <?php echo (strcasecmp($selectedDept, $d['slug']) === 0 || strcasecmp($selectedDept, $d['name']) === 0) ? 'selected' : ''; ?>>
                                <?php echo sanitize($d['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Academic Level Dropdown -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                    <label for="courseLevelFilter" class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-layer-group text-warning me-1"></i> Academic Level
                    </label>
                    <select id="courseLevelFilter" class="form-select" onchange="applyCourseFilters()">
                        <option value="">All Academic Levels</option>
                        <option value="UG" <?php echo strcasecmp($selectedLevel, 'UG') === 0 ? 'selected' : ''; ?>>Undergraduate (UG)</option>
                        <option value="PG" <?php echo strcasecmp($selectedLevel, 'PG') === 0 ? 'selected' : ''; ?>>Postgraduate (PG)</option>
                        <option value="Diploma" <?php echo strcasecmp($selectedLevel, 'Diploma') === 0 ? 'selected' : ''; ?>>Diploma &amp; Polytechnic</option>
                        <option value="Doctorate" <?php echo strcasecmp($selectedLevel, 'Doctorate') === 0 ? 'selected' : ''; ?>>Doctorate (Ph.D.)</option>
                    </select>
                </div>

                <!-- Reset Filters Button -->
                <div class="col-12 col-md-12 col-lg-2">
                    <label class="form-label small fw-bold text-muted mb-1 d-none d-lg-block invisible">&nbsp;</label>
                    <button type="button" class="btn btn-filter-reset w-100" onclick="resetAllCourseFilters()">
                        <i class="fas fa-redo-alt"></i> Reset Filters
                    </button>
                </div>

            </div>

            <?php
            $isAll = empty($selectedLevel);
            $isUG = strcasecmp($selectedLevel, 'UG') === 0;
            $isPG = strcasecmp($selectedLevel, 'PG') === 0;
            $isDip = strcasecmp($selectedLevel, 'Diploma') === 0;
            $isDoc = strcasecmp($selectedLevel, 'Doctorate') === 0;
            ?>
            <!-- Degree Level Quick Filter Pills (Segmented Bar) -->
            <div class="d-flex justify-content-center mt-4 pt-3 border-top">
                <div class="level-pill-wrapper" id="levelQuickPills">
                    <button type="button" class="btn level-pill-btn <?php echo $isAll ? 'active' : ''; ?>" data-level="" onclick="setLevelFilter('')">
                        <i class="fas fa-th-large me-1"></i> All Degrees
                    </button>
                    <button type="button" class="btn level-pill-btn <?php echo $isUG ? 'active' : ''; ?>" data-level="UG" onclick="setLevelFilter('UG')">
                        <i class="fas fa-user-graduate me-1 text-danger"></i> Undergraduate (UG)
                    </button>
                    <button type="button" class="btn level-pill-btn <?php echo $isPG ? 'active' : ''; ?>" data-level="PG" onclick="setLevelFilter('PG')">
                        <i class="fas fa-graduation-cap me-1 text-primary"></i> Postgraduate (PG)
                    </button>
                    <button type="button" class="btn level-pill-btn <?php echo $isDip ? 'active' : ''; ?>" data-level="Diploma" onclick="setLevelFilter('Diploma')">
                        <i class="fas fa-certificate me-1 text-warning"></i> Diploma &amp; Polytechnic
                    </button>
                    <button type="button" class="btn level-pill-btn <?php echo $isDoc ? 'active' : ''; ?>" data-level="Doctorate" onclick="setLevelFilter('Doctorate')">
                        <i class="fas fa-award me-1 text-success"></i> Doctorate (Ph.D.)
                    </button>
                </div>
            </div>

            <!-- Active Status Summary Bar -->
            <div class="pt-3 mt-3 border-top" id="activeCourseFiltersSummary">
                <div class="d-flex align-items-center justify-content-between w-100 flex-wrap gap-2">
                    <span class="text-secondary small"><i class="fas fa-sliders-h text-danger me-1"></i> Showing all academic programmes</span>
                </div>
            </div>

        </div>

        <!-- Syllabus Repository Callout Banner -->
        <div class="alert alert-light border shadow-sm rounded-4 p-3 mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: linear-gradient(90deg, #fff5f5 0%, #ffffff 100%); border-left: 5px solid #7A0B0D !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger-subtle text-danger flex-shrink-0" style="width: 44px; height: 44px; font-size: 1.2rem;">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-navy">Looking for Semester Schemes &amp; Syllabus PDFs?</h6>
                    <span class="text-secondary small">Download official curriculum outlines, subject schemes, and grading patterns across all 19 academic disciplines (266+ local PDFs).</span>
                </div>
            </div>
            <a href="<?php echo BASE_URL; ?>syllabus" class="btn btn-danger btn-sm rounded-pill px-4 py-2 fw-bold text-nowrap">
                <i class="fas fa-download me-1"></i> View Syllabus Repository &rarr;
            </a>
        </div>

        <!-- Course Cards Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="coursesGrid">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $c): 
                    $specs = !empty($c['specializations']) ? array_map('trim', explode(',', $c['specializations'])) : [];
                    $deptSlug = sanitize(strtolower($c['dept_slug'] ?? ''));
                    $deptName = sanitize(strtolower($c['department'] ?? ''));
                    $courseName = sanitize(strtolower($c['course_name'] ?? ''));
                    $levelVal = sanitize($c['level'] ?? '');
                    $searchData = strtolower($courseName . ' ' . $deptName . ' ' . $deptSlug . ' ' . ($c['specializations'] ?? '') . ' ' . ($c['eligibility'] ?? '') . ' ' . ($c['duration'] ?? ''));
                ?>
                    <div class="col course-card-item" 
                         data-name="<?php echo $courseName; ?>"
                         data-dept="<?php echo $deptName; ?>"
                         data-dept-slug="<?php echo $deptSlug; ?>"
                         data-level="<?php echo sanitize($levelVal); ?>"
                         data-search="<?php echo htmlspecialchars($searchData); ?>">
                        
                        <div class="srku-course-card h-100 rounded-4 shadow-sm d-flex flex-column position-relative overflow-hidden bg-white">
                            
                            <!-- Top Theme Gradient Accent -->
                            <div class="course-card-accent"></div>

                            <div class="p-4 d-flex flex-column flex-grow-1">
                                
                                <!-- Top Badges Row -->
                                <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                    <span class="course-dept-badge text-truncate" title="<?php echo sanitize($c['department']); ?>">
                                        <i class="fas fa-university me-1 text-danger"></i> <?php echo sanitize($c['department']); ?>
                                    </span>
                                    <span class="badge badge-level-navy rounded-pill">
                                        <?php echo sanitize($c['level']); ?>
                                    </span>
                                </div>

                                <!-- Course Title -->
                                <h3 class="course-card-title mb-2">
                                    <a href="<?php echo BASE_URL; ?>course/<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="text-decoration-none text-navy">
                                        <?php echo sanitize($c['course_name']); ?>
                                    </a>
                                </h3>

                                <!-- Specializations Pill -->
                                <?php if (!empty($specs)): ?>
                                    <div class="mb-3">
                                        <span class="course-spec-badge">
                                            <i class="fas fa-layer-group text-warning me-1"></i> Specializations &amp; Tracks Available
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <div class="mb-3">
                                        <span class="course-spec-badge course-spec-badge-general">
                                            <i class="fas fa-award text-secondary me-1"></i> Degree Programme
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <!-- Key Meta Box (Duration & Eligibility) -->
                                <div class="course-meta-box p-3 rounded-3 mb-3">
                                    <div class="course-meta-row mb-2">
                                        <span class="course-meta-label"><i class="far fa-clock text-danger me-1"></i> Duration:</span>
                                        <span class="course-meta-val fw-semibold"><?php echo sanitize($c['duration']); ?></span>
                                    </div>
                                    <div class="course-meta-row">
                                        <span class="course-meta-label"><i class="fas fa-check-circle text-success me-1"></i> Eligibility:</span>
                                        <span class="course-meta-val text-muted small" title="<?php echo sanitize($c['eligibility']); ?>">
                                            <?php echo sanitize($c['eligibility']); ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Buttons Footer -->
                                <div class="d-flex gap-2 pt-3 border-top mt-auto">
                                    <a href="<?php echo BASE_URL; ?>course/<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="btn btn-course-details flex-grow-1">
                                        <i class="fas fa-info-circle me-1"></i> Details
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>admission-enquiry.php?course=<?php echo urlencode($c['course_name']); ?>" class="btn btn-course-apply flex-grow-1">
                                        <i class="fas fa-paper-plane me-1"></i> Apply Now
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Empty State Container (Shows dynamically when no match) -->
        <div id="courseNoResults" class="card p-5 text-center border-0 shadow-sm rounded-4 bg-white mt-3" style="display: none;">
            <div class="mb-3">
                <i class="fas fa-search-minus fa-3x text-danger opacity-50"></i>
            </div>
            <h4 class="fw-bold text-navy mb-2">No Academic Programmes Found</h4>
            <p class="text-muted small mx-auto mb-4" style="max-width: 480px;">
                No courses match your current filter selections. Try searching with different keywords or reset your filters.
            </p>
            <div>
                <button type="button" class="btn btn-srku px-4 py-2" onclick="resetAllCourseFilters()">
                    <i class="fas fa-redo-alt me-1"></i> Clear &amp; Reset Filters
                </button>
            </div>
        </div>

    </div>
</section>

<script>
function applyCourseFilters() {
    var searchInput = document.getElementById('courseSearch');
    var deptSelect = document.getElementById('courseDeptFilter');
    var levelSelect = document.getElementById('courseLevelFilter');
    var statusSummary = document.getElementById('activeCourseFiltersSummary');
    var noResultsBox = document.getElementById('courseNoResults');
    var cards = document.querySelectorAll('.course-card-item');

    var query = searchInput ? searchInput.value.trim().toLowerCase() : '';
    var selectedDept = deptSelect ? deptSelect.value.trim().toLowerCase() : '';
    var selectedLevel = levelSelect ? levelSelect.value.trim() : '';

    // Update Quick Pills state
    var pills = document.querySelectorAll('#levelQuickPills .level-pill-btn');
    pills.forEach(function (pill) {
        var pillLevel = (pill.getAttribute('data-level') || '').toLowerCase();
        var selLevelLower = selectedLevel.toLowerCase();
        if (pillLevel === selLevelLower) {
            pill.classList.add('active');
        } else {
            pill.classList.remove('active');
        }
    });

    var visibleCount = 0;

    cards.forEach(function (card) {
        var cardSearchData = (card.getAttribute('data-search') || '').toLowerCase();
        var cardDeptSlug = (card.getAttribute('data-dept-slug') || '').toLowerCase();
        var cardDeptName = (card.getAttribute('data-dept') || '').toLowerCase();
        var cardLevel = card.getAttribute('data-level') || '';

        var matchesSearch = true;
        if (query) {
            matchesSearch = cardSearchData.indexOf(query) !== -1;
        }

        var matchesDept = true;
        if (selectedDept) {
            matchesDept = (cardDeptSlug === selectedDept || cardDeptName.indexOf(selectedDept) !== -1);
        }

        var matchesLevel = true;
        if (selectedLevel) {
            matchesLevel = (cardLevel.toUpperCase() === selectedLevel.toUpperCase());
        }

        if (matchesSearch && matchesDept && matchesLevel) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    if (noResultsBox) {
        noResultsBox.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    // Update Status Label with interactive chips & live count
    if (statusSummary) {
        var activeLabels = [];
        if (query) {
            activeLabels.push('<span class="filter-active-chip"><i class="fas fa-search text-danger"></i> "' + query + '" <button type="button" class="chip-remove-btn" onclick="clearSearchFilter()" title="Remove search filter"><i class="fas fa-times"></i></button></span>');
        }
        if (selectedDept) {
            var selectedDeptText = deptSelect.options[deptSelect.selectedIndex].text;
            activeLabels.push('<span class="filter-active-chip"><i class="fas fa-university text-primary"></i> ' + selectedDeptText + ' <button type="button" class="chip-remove-btn" onclick="clearDeptFilter()" title="Remove faculty filter"><i class="fas fa-times"></i></button></span>');
        }
        if (selectedLevel) {
            var levelMap = {
                'UG': 'Undergraduate (UG)',
                'PG': 'Postgraduate (PG)',
                'Diploma': 'Diploma & Polytechnic',
                'Doctorate': 'Doctorate (Ph.D.)'
            };
            var displayLevel = levelMap[selectedLevel] || selectedLevel;
            activeLabels.push('<span class="filter-active-chip"><i class="fas fa-graduation-cap text-danger"></i> Level: ' + displayLevel + ' <button type="button" class="chip-remove-btn" onclick="setLevelFilter(\'\')" title="Remove level filter"><i class="fas fa-times"></i></button></span>');
        }

        if (activeLabels.length > 0) {
            statusSummary.innerHTML = '<div class="d-flex align-items-center gap-2 flex-wrap"><span class="text-navy small fw-bold"><i class="fas fa-filter text-danger me-1"></i> Active Filters:</span> ' + activeLabels.join(' ') + '</div>';
        } else {
            statusSummary.innerHTML = '<div class="d-flex align-items-center flex-wrap gap-2"><span class="text-secondary small"><i class="fas fa-sliders-h text-danger me-1"></i> Showing all academic programmes</span></div>';
        }
    }

    // Update URL query parameters cleanly
    try {
        var url = new URL(window.location);
        if (query) url.searchParams.set('search', query); else url.searchParams.delete('search');
        if (selectedDept) url.searchParams.set('dept', selectedDept); else url.searchParams.delete('dept');
        if (selectedLevel) url.searchParams.set('level', selectedLevel); else url.searchParams.delete('level');
        window.history.replaceState({}, '', url);
    } catch (e) {}
}

function setLevelFilter(level) {
    var levelSelect = document.getElementById('courseLevelFilter');
    if (levelSelect) {
        levelSelect.value = level;
    }
    applyCourseFilters();
}

function clearSearchFilter() {
    var searchInput = document.getElementById('courseSearch');
    if (searchInput) searchInput.value = '';
    applyCourseFilters();
}

function clearDeptFilter() {
    var deptSelect = document.getElementById('courseDeptFilter');
    if (deptSelect) deptSelect.value = '';
    applyCourseFilters();
}

function resetAllCourseFilters() {
    var searchInput = document.getElementById('courseSearch');
    var deptSelect = document.getElementById('courseDeptFilter');
    var levelSelect = document.getElementById('courseLevelFilter');

    if (searchInput) searchInput.value = '';
    if (deptSelect) deptSelect.value = '';
    if (levelSelect) levelSelect.value = '';

    applyCourseFilters();
}

document.addEventListener('DOMContentLoaded', function () {
    applyCourseFilters();
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
