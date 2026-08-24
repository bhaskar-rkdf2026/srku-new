<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Scheme & Syllabus - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';

$departments = getDepartments(true);
$allCourses = getCourses();

// Categories for filters
$categories = [
    'All' => 'All Disciplines',
    'Engineering & Technology' => 'Engineering & IT',
    'Pharmacy' => 'Pharmacy',
    'Medical & Health' => 'Medical, Dental & Ayush',
    'Nursing' => 'Nursing',
    'Paramedical' => 'Paramedical',
    'Law' => 'Law',
    'Agriculture' => 'Agriculture',
    'Management' => 'Management & Commerce',
    'Computer Applications' => 'Computer Applications'
];
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

        <!-- Filter & Search Bar -->
        <div class="card p-3 p-md-4 border-0 shadow-sm rounded-4 mb-5 bg-white">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="syllabusSearch" class="form-control border-start-0 ps-0" placeholder="Search by course name, branch, or department..." onkeyup="filterSyllabus()">
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end" id="categoryPills">
                        <button type="button" class="btn btn-sm btn-danger active-filter rounded-pill px-3 fw-semibold cat-btn" onclick="filterCategory('all', this)">
                            All Programs
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold cat-btn" onclick="filterCategory('engineering', this)">
                            Engineering
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold cat-btn" onclick="filterCategory('pharmacy', this)">
                            Pharmacy
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold cat-btn" onclick="filterCategory('nursing', this)">
                            Nursing &amp; Paramedical
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold cat-btn" onclick="filterCategory('law', this)">
                            Law
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold cat-btn" onclick="filterCategory('agriculture', this)">
                            Agriculture
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold cat-btn" onclick="filterCategory('management', this)">
                            Management &amp; IT
                        </button>
                    </div>
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
                                        <span class="text-muted"><i class="fas fa-check-circle text-success me-1"></i><?php echo count($deptCourses); ?> Approved Programmes</span>
                                        <?php if ($dept['contact_no']): ?>
                                            <span class="text-muted d-none d-md-inline">&bull; <i class="fas fa-phone-alt text-warning me-1"></i><?php echo sanitize($dept['contact_no']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <a href="<?php echo BASE_URL; ?>department-detail.php?slug=<?php echo urlencode($dept['slug']); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="fas fa-university me-1"></i> Department Page
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
                                    ?>
                                        <tr class="course-row" data-coursename="<?php echo sanitize(strtolower($c['course_name'] . ' ' . $c['specializations'])); ?>">
                                            <td>
                                                <div class="fw-bold text-navy fs-6 mb-1">
                                                    <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="text-navy text-decoration-none hover-maroon">
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
                                                <span class="badge bg-primary-subtle text-primary border px-2 py-1"><?php echo sanitize($c['level']); ?></span>
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

                                                    <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="btn btn-sm btn-light border" title="Course Details">
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
            <p class="text-muted mb-3">Please try searching with different keywords like 'Pharmacy', 'CSE', 'Agriculture', or 'MBA'.</p>
            <div>
                <button type="button" class="btn btn-danger btn-sm px-4 rounded-pill" onclick="resetFilters()">Reset All Filters</button>
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
function filterSyllabus() {
    const query = document.getElementById('syllabusSearch').value.toLowerCase().trim();
    const deptBlocks = document.querySelectorAll('.dept-block');
    let totalVisible = 0;

    deptBlocks.forEach(block => {
        const rows = block.querySelectorAll('.course-row');
        let blockHasMatch = false;

        rows.forEach(row => {
            const courseText = row.getAttribute('data-coursename');
            const deptText = block.getAttribute('data-deptname');
            if (!query || courseText.includes(query) || deptText.includes(query)) {
                row.style.display = '';
                blockHasMatch = true;
            } else {
                row.style.display = 'none';
            }
        });

        if (blockHasMatch) {
            block.style.display = '';
            totalVisible++;
        } else {
            block.style.display = 'none';
        }
    });

    const noMsg = document.getElementById('noResultsMsg');
    if (totalVisible === 0) {
        noMsg.classList.remove('d-none');
    } else {
        noMsg.classList.add('d-none');
    }
}

function filterCategory(cat, btn) {
    // Update active button state
    document.querySelectorAll('.cat-btn').forEach(b => {
        b.classList.remove('btn-danger', 'active-filter');
        b.classList.add('btn-outline-secondary');
    });
    btn.classList.remove('btn-outline-secondary');
    btn.classList.add('btn-danger', 'active-filter');

    const deptBlocks = document.querySelectorAll('.dept-block');
    let totalVisible = 0;

    deptBlocks.forEach(block => {
        const catData = block.getAttribute('data-category') || '';
        const deptName = block.getAttribute('data-deptname') || '';
        const combo = (catData + ' ' + deptName).toLowerCase();

        let show = false;
        if (cat === 'all') {
            show = true;
        } else if (cat === 'engineering' && (combo.includes('engineering') || combo.includes('science & technology') || combo.includes('polytechnic'))) {
            show = true;
        } else if (cat === 'pharmacy' && combo.includes('pharmacy')) {
            show = true;
        } else if (cat === 'nursing' && (combo.includes('nursing') || combo.includes('paramedical') || combo.includes('allied'))) {
            show = true;
        } else if (cat === 'law' && combo.includes('law')) {
            show = true;
        } else if (cat === 'agriculture' && combo.includes('agri')) {
            show = true;
        } else if (cat === 'management' && (combo.includes('management') || combo.includes('computer') || combo.includes('commerce') || combo.includes('mca') || combo.includes('bca'))) {
            show = true;
        }

        if (show) {
            block.style.display = '';
            // Make sure all rows inside are reset to visible
            block.querySelectorAll('.course-row').forEach(r => r.style.display = '');
            totalVisible++;
        } else {
            block.style.display = 'none';
        }
    });

    const noMsg = document.getElementById('noResultsMsg');
    if (totalVisible === 0) {
        noMsg.classList.remove('d-none');
    } else {
        noMsg.classList.add('d-none');
    }
}

function resetFilters() {
    document.getElementById('syllabusSearch').value = '';
    const allBtn = document.querySelector('.cat-btn');
    if (allBtn) filterCategory('all', allBtn);
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
