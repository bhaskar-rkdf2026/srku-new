<?php
$pageTitle = "Academic Programmes & Degrees | 120+ UG, PG, PhD Courses | SRKU";
$pageDesc = "Explore 120+ UGC and regulatory approved courses at Sarvepalli Radhakrishnan University (SRKU), Bhopal spanning B.Tech, MBBS, B.Pharm, MBA, MCA, B.Sc. Nursing, Law, Agriculture and Ph.D.";
$pageKeywords = "SRKU Courses, Degrees Catalog, BTech Bhopal, MBBS MP, BPharm Bhopal, MBA Admission, PhD Admissions SRKU";
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
                    All Degrees
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
                        <div class="srku-course-card h-100 rounded-4 shadow-sm d-flex flex-column position-relative overflow-hidden">
                            
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
                                    <a href="<?php echo BASE_URL; ?>course/<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="text-decoration-none">
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
