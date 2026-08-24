<?php
$pageTitle = "Academic Programmes & Degrees Catalog - SRK University Bhopal";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';

$selectedDept = sanitize($_GET['dept'] ?? '');
$selectedLevel = sanitize($_GET['level'] ?? '');
$searchKeyword = sanitize($_GET['search'] ?? '');

$courses = getCourses($selectedDept, $selectedLevel, $searchKeyword);
$departments = getDepartments(true);
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('courses', 'Academic Programmes & Degrees Catalog', 'Undergraduate (UG), Postgraduate (PG), Diploma & Doctoral Research Programs Across 26 Constituent Units'); ?>

<section class="py-5">
    <div class="container-xl py-2">
        
        <!-- SEARCH & FILTER BAR -->
        <div class="card p-4 border-0 shadow-sm rounded-4 mb-5 bg-white border">
            <form action="<?php echo BASE_URL; ?>courses.php" method="GET" class="row g-3 align-items-center">
                
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search by course (e.g. MBBS, B.Tech, MPT, MBA, D.Pharm, LL.M.)..." value="<?php echo sanitize($searchKeyword); ?>">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <select name="dept" class="form-select bg-light">
                        <option value="">-- All Constituent Units &amp; Faculties --</option>
                        <?php foreach ($departments as $d): ?>
                            <option value="<?php echo sanitize($d['slug']); ?>" <?php echo ($selectedDept == $d['slug'] || $selectedDept == $d['name']) ? 'selected' : ''; ?>>
                                <?php echo sanitize($d['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-srku flex-grow-1"><i class="fas fa-filter me-1"></i> Filter Courses</button>
                    <?php if ($selectedDept || $selectedLevel || $searchKeyword): ?>
                        <a href="<?php echo BASE_URL; ?>courses.php" class="btn btn-outline-secondary" title="Reset All Filters"><i class="fas fa-times"></i></a>
                    <?php endif; ?>
                </div>

            </form>

            <!-- Degree Level Pills -->
            <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top justify-content-center">
                <a href="<?php echo BASE_URL; ?>courses.php<?php echo $selectedDept ? '?dept=' . urlencode($selectedDept) : ''; ?>" 
                   class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo empty($selectedLevel) ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    All Degrees (<?php echo count(getCourses($selectedDept, null, $searchKeyword)); ?>)
                </a>
                <a href="<?php echo BASE_URL; ?>courses.php?level=UG<?php echo $selectedDept ? '&dept=' . urlencode($selectedDept) : ''; ?>" 
                   class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedLevel == 'UG' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-user-graduate me-1"></i> Undergraduate (UG)
                </a>
                <a href="<?php echo BASE_URL; ?>courses.php?level=PG<?php echo $selectedDept ? '&dept=' . urlencode($selectedDept) : ''; ?>" 
                   class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedLevel == 'PG' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-graduation-cap me-1"></i> Postgraduate (PG)
                </a>
                <a href="<?php echo BASE_URL; ?>courses.php?level=Diploma<?php echo $selectedDept ? '&dept=' . urlencode($selectedDept) : ''; ?>" 
                   class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedLevel == 'Diploma' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-certificate me-1"></i> Diploma &amp; Polytechnic
                </a>
                <a href="<?php echo BASE_URL; ?>courses.php?level=Doctorate<?php echo $selectedDept ? '&dept=' . urlencode($selectedDept) : ''; ?>" 
                   class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedLevel == 'Doctorate' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-award me-1"></i> Doctorate (Ph.D.)
                </a>
            </div>

        </div>

        <!-- Course Cards Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $c): 
                    $specs = !empty($c['specializations']) ? array_map('trim', explode(',', $c['specializations'])) : [];
                ?>
                    <div class="col">
                        <div class="card h-100 p-4 border-0 shadow-sm rounded-4 d-flex flex-column hover-shadow bg-white border" style="transition: all 0.25s ease;">
                            
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill small fw-bold text-truncate" style="max-width: 70%;" title="<?php echo sanitize($c['department']); ?>">
                                    <i class="fas fa-university me-1"></i> <?php echo sanitize($c['department']); ?>
                                </span>
                                <span class="badge bg-primary text-white small px-2 py-1">
                                    <?php echo sanitize($c['level']); ?>
                                </span>
                            </div>

                            <h3 class="h5 fw-bold text-navy mb-2" style="min-height: 2.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="text-navy text-decoration-none hover-danger">
                                    <?php echo sanitize($c['course_name']); ?>
                                </a>
                            </h3>

                            <!-- Specializations badge if available -->
                            <?php if (!empty($specs)): ?>
                                <div class="mb-2">
                                    <span class="badge bg-warning-subtle text-dark border border-warning-subtle small fw-semibold">
                                        <i class="fas fa-sitemap text-danger me-1"></i> <?php echo count($specs); ?> Disciplines / Specializations
                                    </span>
                                </div>
                            <?php endif; ?>

                            <div class="text-muted small mb-3 flex-grow-1" style="line-height:1.65;">
                                <div class="mb-1"><strong class="text-dark"><i class="far fa-clock text-danger me-1"></i> Duration:</strong> <?php echo sanitize($c['duration']); ?></div>
                                <div class="text-truncate" title="<?php echo sanitize($c['eligibility']); ?>"><strong class="text-dark"><i class="fas fa-check-circle text-success me-1"></i> Eligibility:</strong> <?php echo sanitize($c['eligibility']); ?></div>
                            </div>

                            <div class="d-flex gap-2 mt-auto pt-3 border-top">
                                <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="btn btn-sm btn-outline-danger flex-grow-1 text-center justify-content-center">
                                    <i class="fas fa-info-circle me-1"></i> Details &amp; Specs
                                </a>
                                <a href="<?php echo BASE_URL; ?>contact.php?course=<?php echo urlencode($c['course_name']); ?>" class="btn btn-sm btn-srku flex-grow-1 text-center justify-content-center">
                                    <i class="fas fa-paper-plane me-1"></i> Apply
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-navy fw-bold">No programmes found</h4>
                    <p class="text-muted">No courses match your filter criteria. Try resetting filters or search terms.</p>
                    <a href="<?php echo BASE_URL; ?>courses.php" class="btn btn-srku px-4 py-2">Reset All Filters</a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
