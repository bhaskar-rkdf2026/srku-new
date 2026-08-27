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

<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- SEARCH & FILTER BAR -->
        <div class="card p-4 p-lg-4 border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="row g-3 align-items-end">
                
                <!-- Search Input -->
                <div class="col-12 col-md-5 col-lg-4">
                    <label for="courseSearch" class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-search text-danger me-1"></i> Search Course or Subject
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
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
                    <select id="courseDeptFilter" class="form-select bg-light" onchange="applyCourseFilters()">
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
                    <select id="courseLevelFilter" class="form-select bg-light" onchange="applyCourseFilters()">
                        <option value="">All Academic Levels</option>
                        <option value="UG" <?php echo strcasecmp($selectedLevel, 'UG') === 0 ? 'selected' : ''; ?>>Undergraduate (UG)</option>
                        <option value="PG" <?php echo strcasecmp($selectedLevel, 'PG') === 0 ? 'selected' : ''; ?>>Postgraduate (PG)</option>
                        <option value="Diploma" <?php echo strcasecmp($selectedLevel, 'Diploma') === 0 ? 'selected' : ''; ?>>Diploma &amp; Polytechnic</option>
                        <option value="Doctorate" <?php echo strcasecmp($selectedLevel, 'Doctorate') === 0 ? 'selected' : ''; ?>>Doctorate (Ph.D.)</option>
                    </select>
                </div>

                <!-- Reset Filters Button -->
                <div class="col-12 col-md-12 col-lg-2">
                    <button type="button" class="btn btn-outline-danger w-100 rounded-3 py-2 fw-semibold" onclick="resetAllCourseFilters()">
                        <i class="fas fa-redo-alt me-1"></i> Reset Filters
                    </button>
                </div>

            </div>

            <!-- Degree Level Quick Filter Pills -->
            <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top justify-content-center" id="levelQuickPills">
                <button type="button" class="btn btn-sm rounded-pill px-3 py-1 fw-semibold level-pill-btn active" data-level="" onclick="setLevelFilter('')">
                    All Degrees
                </button>
                <button type="button" class="btn btn-sm rounded-pill px-3 py-1 fw-semibold level-pill-btn btn-light border" data-level="UG" onclick="setLevelFilter('UG')">
                    <i class="fas fa-user-graduate me-1 text-danger"></i> Undergraduate (UG)
                </button>
                <button type="button" class="btn btn-sm rounded-pill px-3 py-1 fw-semibold level-pill-btn btn-light border" data-level="PG" onclick="setLevelFilter('PG')">
                    <i class="fas fa-graduation-cap me-1 text-primary"></i> Postgraduate (PG)
                </button>
                <button type="button" class="btn btn-sm rounded-pill px-3 py-1 fw-semibold level-pill-btn btn-light border" data-level="Diploma" onclick="setLevelFilter('Diploma')">
                    <i class="fas fa-certificate me-1 text-warning"></i> Diploma &amp; Polytechnic
                </button>
                <button type="button" class="btn btn-sm rounded-pill px-3 py-1 fw-semibold level-pill-btn btn-light border" data-level="Doctorate" onclick="setLevelFilter('Doctorate')">
                    <i class="fas fa-award me-1 text-success"></i> Doctorate (Ph.D.)
                </button>
            </div>

            <!-- Active Status Summary -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-2 mt-2 border-top small text-muted">
                <span id="activeCourseFiltersSummary" class="fw-semibold text-navy">
                    <i class="fas fa-sliders-h text-danger me-1"></i> Showing all academic programmes
                </span>
            </div>

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
        var pillLevel = pill.getAttribute('data-level') || '';
        if (pillLevel === selectedLevel) {
            pill.classList.remove('btn-light', 'border');
            pill.classList.add('btn-danger', 'text-white', 'active');
        } else {
            pill.classList.remove('btn-danger', 'text-white', 'active');
            pill.classList.add('btn-light', 'border');
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

    // Update Status Label (without numeric badges)
    if (statusSummary) {
        var activeLabels = [];
        if (query) activeLabels.push('Search: "' + query + '"');
        if (selectedDept) {
            var selectedDeptText = deptSelect.options[deptSelect.selectedIndex].text;
            activeLabels.push('Faculty: ' + selectedDeptText);
        }
        if (selectedLevel) activeLabels.push('Level: ' + selectedLevel);

        if (activeLabels.length > 0) {
            statusSummary.innerHTML = '<i class="fas fa-filter text-danger me-1"></i> Filtered by: ' + activeLabels.join(' &bull; ');
        } else {
            statusSummary.innerHTML = '<i class="fas fa-sliders-h text-danger me-1"></i> Showing all academic programmes';
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
