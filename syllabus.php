<?php
require_once __DIR__ . '/includes/functions.php';

// Dynamic Database Fetch (Strictly from MySQL `syllabi` table)
$syllabusCategories = getDynamicSyllabusData(true);

$pageTitle = "Scheme & Syllabus | Semester Curriculum & PDF Downloads | SRKU";
$pageDesc = "Download official course schemes, semester-wise syllabus, examination guidelines, and grading patterns for all degree and diploma programs at Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = "SRKU Syllabus, Scheme of Examination, BTech Syllabus, Pharmacy Syllabus Bhopal, University Curriculum PDF, NEP 2020 Syllabus";
$activeNav = "syllabus";

// Count total PDFs across all categories
$grandTotalPdfs = 0;
foreach ($syllabusCategories as $cat) {
    $grandTotalPdfs += $cat['total_pdfs'];
}

// Check if a specific course or branch is requested via query param
$selectedCourse = isset($_GET['course']) ? trim($_GET['course']) : 'all';
if (!empty($selectedCourse) && !isset($syllabusCategories[$selectedCourse])) {
    $selectedCourse = 'all';
}
$selectedBranch = isset($_GET['branch']) ? trim($_GET['branch']) : 'all';

require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('syllabus', 'Academic Curriculum & Syllabus', 'Official Semester-Wise Scheme of Examination, Course Structures & Learning Outcomes for 2026-27'); ?>

<section class="py-5 bg-light-subtle" id="syllabusApp">
    <div class="container-xl py-2">
        
        <!-- Section Header Intro & Key Badges -->
        <div class="text-center mb-4" style="max-width:860px; margin:auto;">
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-2">
                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold text-uppercase" style="letter-spacing:.5px;">
                    <i class="fas fa-file-pdf me-1"></i> UGC, AICTE, PCI, BCI, INC &amp; NEP-2020 Aligned
                </span>
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold text-uppercase" style="letter-spacing:.5px;">
                    <i class="fas fa-university me-1"></i> 19 Academic Disciplines
                </span>
                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold text-uppercase" style="letter-spacing:.5px;">
                    <i class="fas fa-download me-1"></i> <?php echo $grandTotalPdfs; ?>+ Offline Local PDFs
                </span>
            </div>
            <h2 class="fw-bold text-navy display-6 mb-2">Download Course Scheme &amp; Syllabus</h2>
            <p class="text-secondary lead fs-6">
                Access official university curriculum outlines, detailed semester-wise subject schemes, credit distribution, internal assessment criteria, and prescribed syllabus directly with fast local downloads.
            </p>
        </div>

        <!-- Filter & Search Controls Bar -->
        <div class="card p-3 p-lg-4 border-0 shadow-sm rounded-4 mb-4 bg-white sticky-top" style="top: 80px; z-index: 1010;">
            <div class="row g-3 align-items-end">
                
                <!-- Search Input -->
                <div class="col-12 col-md-4 col-lg-4">
                    <label for="syllabusSearch" class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-search text-danger me-1"></i> Search Curriculum Documents
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="syllabusSearch" class="form-control border-start-0 ps-0" placeholder="Search by course, branch, semester..." oninput="filterSyllabus()">
                        <button class="btn btn-light border border-start-0 text-muted" type="button" id="clearSearchBtn" onclick="clearSearch()" style="display:none;" title="Clear search">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Discipline / Course Filter -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                    <label for="courseFilterSelect" class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-filter text-primary me-1"></i> Academic Discipline
                    </label>
                    <select id="courseFilterSelect" class="form-select" onchange="switchCategory(this.value)">
                        <option value="all" <?php echo ($selectedCourse === 'all') ? 'selected' : ''; ?>>All Disciplines (<?php echo $grandTotalPdfs; ?> PDFs)</option>
                        <?php foreach ($syllabusCategories as $slug => $cat): ?>
                            <option value="<?php echo $slug; ?>" <?php echo ($selectedCourse === $slug) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['title']); ?> (<?php echo $cat['total_pdfs']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Branch / Specialization Filter -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                    <label for="branchFilterSelect" class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-code-branch text-danger me-1"></i> Branch / Specialization
                    </label>
                    <select id="branchFilterSelect" class="form-select" onchange="onBranchSelectChange(this.value)">
                        <option value="all">All Branches / Specializations</option>
                    </select>
                </div>

                <!-- Document Type Filter -->
                <div class="col-6 col-sm-3 col-md-1 col-lg-1">
                    <label for="docTypeFilter" class="form-label small fw-bold text-navy mb-1 text-nowrap">
                        <i class="fas fa-file-alt text-warning me-1"></i> Type
                    </label>
                    <select id="docTypeFilter" class="form-select px-2" onchange="filterSyllabus()">
                        <option value="all">All</option>
                        <option value="scheme">Scheme</option>
                        <option value="syllabus">Syllabus</option>
                    </select>
                </div>

                <!-- Reset Button -->
                <div class="col-6 col-sm-3 col-md-1 col-lg-1">
                    <button type="button" class="btn btn-outline-danger w-100 rounded-3 py-2 fw-semibold" onclick="resetSyllabusFilters()" title="Reset all filters">
                        <i class="fas fa-redo-alt"></i> <span class="d-none d-sm-inline d-md-none">Reset</span>
                    </button>
                </div>

            </div>
            
            <!-- Active Status Summary -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-3 mt-3 border-top small text-muted">
                <div>
                    <span id="activeFiltersSummary" class="fw-semibold text-navy">
                        <i class="fas fa-check-circle text-success me-1"></i> Showing <span id="visibleDocCount"><?php echo $grandTotalPdfs; ?></span> curriculum documents
                    </span>
                    <span id="activeBranchBadge" class="badge bg-danger text-white rounded-pill ms-2 d-none"></span>
                </div>
                <div class="d-none d-md-flex align-items-center gap-2">
                    <span class="text-muted small">Quick Jump:</span>
                    <a href="javascript:void(0)" onclick="switchCategory('be-btech')" class="badge bg-light text-navy border text-decoration-none">B.E. / B.Tech</a>
                    <a href="javascript:void(0)" onclick="switchCategory('allied-courses')" class="badge bg-light text-navy border text-decoration-none">Allied Courses</a>
                    <a href="javascript:void(0)" onclick="switchCategory('mba')" class="badge bg-light text-navy border text-decoration-none">MBA</a>
                    <a href="javascript:void(0)" onclick="switchCategory('paramedical')" class="badge bg-light text-navy border text-decoration-none">Paramedical</a>
                </div>
            </div>
        </div>

        <!-- Discipline Category Tabs (Horizontal Scrollable Pills) -->
        <div class="category-pills-wrap mb-4 position-relative">
            <div class="d-flex gap-2 flex-nowrap overflow-x-auto pb-2 px-1" id="categoryTabsContainer">
                <button type="button" class="btn cat-pill <?php echo ($selectedCourse === 'all') ? 'active' : ''; ?>" data-cat="all" onclick="switchCategory('all')">
                    <span class="cat-pill-icon"><i class="fas fa-th-large"></i></span>
                    <span class="cat-pill-label">All Courses</span>
                    <span class="cat-pill-count"><?php echo $grandTotalPdfs; ?></span>
                </button>
                <?php foreach ($syllabusCategories as $slug => $cat): ?>
                    <button type="button" class="btn cat-pill <?php echo ($selectedCourse === $slug) ? 'active' : ''; ?>" data-cat="<?php echo $slug; ?>" onclick="switchCategory('<?php echo $slug; ?>')">
                        <span class="cat-pill-icon"><i class="<?php echo $cat['icon']; ?>"></i></span>
                        <span class="cat-pill-label"><?php echo htmlspecialchars($cat['title']); ?></span>
                        <span class="cat-pill-count"><?php echo $cat['total_pdfs']; ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Main Syllabus Container (19 Categories) -->
        <div id="syllabusMainList">
            <?php foreach ($syllabusCategories as $slug => $cat): 
                $items = $cat['items'];
                if (empty($items)) continue;
                $isCategorySelected = ($selectedCourse === 'all' || $selectedCourse === $slug);
                $branches = $cat['branches'] ?? [];
            ?>
                <div class="category-block mb-5 <?php echo $isCategorySelected ? '' : 'd-none'; ?>" id="cat-block-<?php echo $slug; ?>" data-cat-slug="<?php echo $slug; ?>">
                    
                    <!-- Category Header Bar (Modern Elevated Ribbon Design) -->
                    <div class="category-header-banner p-3 px-md-4 mb-3 rounded-4 shadow-sm position-relative overflow-hidden">
                        <div class="category-header-accent" style="background: <?php echo $cat['color']; ?>;"></div>
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 position-relative" style="z-index: 2;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="cat-icon-badge shadow-xs rounded-3 d-flex align-items-center justify-content-center" 
                                     style="background: linear-gradient(135deg, <?php echo $cat['color']; ?>15 0%, <?php echo $cat['color']; ?>28 100%); color: <?php echo $cat['color']; ?>; width: 48px; height: 48px; font-size: 1.35rem; border: 1.5px solid <?php echo $cat['color']; ?>30;">
                                    <i class="<?php echo $cat['icon']; ?>"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                        <h3 class="h5 fw-bold text-navy mb-0" style="letter-spacing: -0.2px; font-size: 1.15rem;">
                                            <?php echo htmlspecialchars($cat['title']); ?>
                                        </h3>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-1 small fw-bold">
                                            <i class="fas fa-file-pdf me-1"></i> <?php echo count($items); ?> PDF Documents
                                        </span>
                                        <?php if (!empty($branches) && count($branches) > 1): ?>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2.5 py-1 small fw-bold">
                                                <i class="fas fa-code-branch me-1"></i> <?php echo count($branches); ?> Branches / Specializations
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 small text-muted">
                                        <span class="dept-badge text-secondary fw-medium">
                                            <i class="fas fa-university me-1 text-muted"></i> <?php echo htmlspecialchars($cat['dept']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-focus-discipline shadow-xs rounded-pill px-3 py-1.5 fw-semibold" onclick="switchCategory('<?php echo $slug; ?>')">
                                    <i class="fas fa-filter text-danger me-1"></i> Focus Discipline
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive Branch / Specialization Quick-Filter Pills Ribbon -->
                    <?php if (!empty($branches) && count($branches) > 1): ?>
                        <div class="branch-filter-strip mb-4 p-2.5 bg-white rounded-4 border shadow-xs d-flex flex-wrap align-items-center gap-2">
                            <span class="small fw-bold text-navy px-2 text-nowrap">
                                <i class="fas fa-code-branch text-danger me-1"></i> Filter by Branch:
                            </span>
                            <div class="d-flex flex-wrap gap-1.5 align-items-center" id="branchPillsWrap-<?php echo $slug; ?>">
                                <button type="button" class="btn btn-sm btn-dark rounded-pill branch-pill-btn active" data-cat="<?php echo $slug; ?>" data-branch="all" onclick="selectBranchPill('<?php echo $slug; ?>', 'all')">
                                    All Branches (<?php echo $cat['total_pdfs']; ?>)
                                </button>
                                <?php foreach ($branches as $bSlug => $bInfo): ?>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill branch-pill-btn" data-cat="<?php echo $slug; ?>" data-branch="<?php echo $bSlug; ?>" onclick="selectBranchPill('<?php echo $slug; ?>', '<?php echo $bSlug; ?>')">
                                        <?php echo htmlspecialchars($bInfo['short'] ?? $bInfo['name']); ?>
                                        <span class="badge bg-secondary-subtle text-dark rounded-pill ms-1"><?php echo $bInfo['count']; ?></span>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Cards Grid (Matching Old Web PDF Cards + Modern Polish) -->
                    <div class="row g-3 g-md-4">
                        <?php foreach ($items as $item): 
                            $localHref = BASE_URL . $item['local_url'];
                            $typeBadgeClass = 'bg-danger-subtle text-danger';
                            if (strtolower($item['type']) === 'scheme') {
                                $typeBadgeClass = 'bg-primary-subtle text-primary';
                            } elseif (stripos($item['type'], '&') !== false) {
                                $typeBadgeClass = 'bg-success-subtle text-success';
                            }
                            $branchSlug = $item['branch_slug'] ?? 'general';
                            $branchName = $item['branch_name'] ?? '';
                            $branchShort = $item['branch_short'] ?? '';
                        ?>
                            <div class="col-12 col-md-6 col-lg-4 syllabus-item-col" 
                                 data-category="<?php echo $slug; ?>"
                                 data-branch="<?php echo $branchSlug; ?>"
                                 data-doctype="<?php echo strtolower($item['type']); ?>"
                                 data-title="<?php echo htmlspecialchars(strtolower($item['title'] . ' ' . $cat['title'] . ' ' . $item['type'] . ' ' . $branchName . ' ' . $branchShort)); ?>">
                                
                                <div class="card h-100 border-0 rounded-4 syllabus-card-pro bg-white">
                                    <div class="card-body p-3 p-md-4 d-flex flex-column">
                                        <!-- Top Header Bar: Document Type Badge & Branch Tag -->
                                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-1">
                                            <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                                <span class="badge <?php echo $typeBadgeClass; ?> rounded-pill px-3 py-1-5 fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: .4px;">
                                                    <i class="<?php echo (strtolower($item['type']) === 'scheme' ? 'fas fa-clipboard-list' : 'fas fa-book'); ?> me-1"></i>
                                                    <?php echo htmlspecialchars($item['type']); ?>
                                                </span>
                                                <?php if (!empty($branchShort) && $branchSlug !== 'general'): ?>
                                                    <span class="badge bg-dark-subtle text-dark border rounded-pill px-2.5 py-1 small fw-semibold" title="<?php echo htmlspecialchars($branchName); ?>">
                                                        <i class="fas fa-code-branch text-danger me-1"></i><?php echo htmlspecialchars($branchShort); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="pdf-icon-indicator" title="Official PDF Document">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                        </div>

                                        <!-- Document Title -->
                                        <h4 class="syllabus-card-title mb-2" title="<?php echo htmlspecialchars($item['title']); ?>">
                                            <?php echo htmlspecialchars($item['title']); ?>
                                        </h4>

                                        <!-- Course Discipline Subtitle -->
                                        <div class="syllabus-card-sub text-muted small mb-3 mt-auto d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-graduation-cap text-danger me-1"></i> 
                                                <span><?php echo htmlspecialchars($cat['title']); ?></span>
                                            </div>
                                            <?php if (!empty($branchName) && $branchSlug !== 'general'): ?>
                                                <span class="text-muted small" style="font-size: 0.76rem;">
                                                    <?php echo htmlspecialchars($branchName); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Action Buttons: View PDF & Download -->
                                        <div class="card-actions-wrapper pt-3 border-top d-flex gap-2">
                                            <a href="<?php echo $localHref; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-view-pdf flex-grow-1">
                                                <i class="fas fa-eye me-1"></i> View PDF
                                            </a>
                                            <a href="<?php echo $localHref; ?>" download="<?php echo htmlspecialchars($item['filename']); ?>" class="btn btn-download-pdf" title="Download to Device">
                                                <i class="fas fa-download me-1"></i> <span class="d-none d-sm-inline">Download</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <!-- Empty Results Alert -->
        <div id="noResultsMsg" class="card p-5 text-center border-0 shadow-sm rounded-4 mt-4 d-none bg-white">
            <div class="py-4">
                <i class="fas fa-search fa-3x text-muted opacity-50 mb-3"></i>
                <h4 class="fw-bold text-navy mb-2">No matching curriculum documents found</h4>
                <p class="text-muted mb-3" style="max-width:550px; margin:auto;">
                    We couldn't find any scheme or syllabus matching your branch or search query. Please choose "All Branches" or reset the filters.
                </p>
                <div>
                    <button type="button" class="btn btn-danger px-4 py-2 rounded-pill fw-semibold" onclick="resetSyllabusFilters()">
                        <i class="fas fa-redo-alt me-1"></i> Reset All Filters
                    </button>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Additional Examination & Curriculum Notice -->
<section class="py-5 bg-white border-top">
    <div class="container-xl">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-start gap-3">
                    <div class="p-3 bg-danger-subtle text-danger rounded-circle d-none d-md-flex">
                        <i class="fas fa-question-circle fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold text-navy mb-2">Need Past Question Papers or Previous Schemes?</h3>
                        <p class="text-secondary mb-0">
                            If you require archival syllabus prior to 2015, special back-log examination schemes, or subject equivalence certificates for migration, please submit a request to the Controller of Examinations.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="<?php echo BASE_URL; ?>contact.php" class="btn btn-maroon px-4 py-2 fw-bold rounded-pill">
                        <i class="fas fa-headset me-1"></i> Examination Cell
                    </a>
                    <a href="<?php echo BASE_URL; ?>exam-rules.php" class="btn btn-outline-navy px-3 py-2 fw-semibold rounded-pill">
                        <i class="fas fa-book me-1"></i> Exam Rules
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Live Interactive Filtering & Deep-Linking Script with Branch Filter -->
<script>
const categoryBranchesMap = <?php 
    $catBranchData = [];
    foreach ($syllabusCategories as $slug => $cat) {
        $catBranchData[$slug] = $cat['branches'] ?? [];
    }
    echo json_encode($catBranchData);
?>;

let currentCategory = '<?php echo $selectedCourse; ?>';
let currentBranch = '<?php echo $selectedBranch; ?>';

function updateBranchDropdown(catSlug, preserveBranch = false) {
    const branchSelect = document.getElementById('branchFilterSelect');
    if (!branchSelect) return;

    const prevVal = preserveBranch ? currentBranch : 'all';
    branchSelect.innerHTML = '<option value="all">All Branches / Specializations</option>';

    if (catSlug === 'all') {
        // Show all unique branches across all categories
        const allBranches = {};
        for (const c in categoryBranchesMap) {
            for (const b in categoryBranchesMap[c]) {
                if (!allBranches[b]) {
                    allBranches[b] = { name: categoryBranchesMap[c][b].name, count: 0 };
                }
                allBranches[b].count += categoryBranchesMap[c][b].count;
            }
        }
        for (const b in allBranches) {
            const opt = document.createElement('option');
            opt.value = b;
            opt.textContent = allBranches[b].name + ' (' + allBranches[b].count + ')';
            branchSelect.appendChild(opt);
        }
    } else if (categoryBranchesMap[catSlug]) {
        const branches = categoryBranchesMap[catSlug];
        for (const b in branches) {
            const opt = document.createElement('option');
            opt.value = b;
            opt.textContent = (branches[b].name || b) + ' (' + branches[b].count + ')';
            branchSelect.appendChild(opt);
        }
    }

    if (preserveBranch && prevVal && prevVal !== 'all') {
        branchSelect.value = prevVal;
    } else {
        branchSelect.value = 'all';
        currentBranch = 'all';
    }
}

function onBranchSelectChange(branchSlug) {
    currentBranch = branchSlug;
    updateBranchPillsUI(currentCategory, branchSlug);
    updateUrlParams();
    filterSyllabus();
}

function selectBranchPill(catSlug, branchSlug) {
    currentBranch = branchSlug;
    const branchSelect = document.getElementById('branchFilterSelect');
    if (branchSelect) branchSelect.value = branchSlug;

    updateBranchPillsUI(catSlug, branchSlug);
    updateUrlParams();
    filterSyllabus();
}

function updateBranchPillsUI(catSlug, branchSlug) {
    const pills = document.querySelectorAll('.branch-pill-btn');
    pills.forEach(pill => {
        const pillCat = pill.dataset.cat;
        const pillBranch = pill.dataset.branch;
        if ((catSlug === 'all' || pillCat === catSlug) && pillBranch === branchSlug) {
            pill.classList.remove('btn-outline-secondary');
            pill.classList.add('btn-dark', 'active');
        } else if (pillCat === catSlug || catSlug === 'all') {
            pill.classList.remove('btn-dark', 'active');
            pill.classList.add('btn-outline-secondary');
        }
    });

    const activeBadge = document.getElementById('activeBranchBadge');
    if (activeBadge) {
        if (branchSlug && branchSlug !== 'all') {
            activeBadge.textContent = 'Branch: ' + branchSlug.toUpperCase();
            activeBadge.classList.remove('d-none');
        } else {
            activeBadge.classList.add('d-none');
        }
    }
}

function switchCategory(catSlug, branchToSet = 'all') {
    currentCategory = catSlug;
    
    // Update select dropdown
    const select = document.getElementById('courseFilterSelect');
    if (select) select.value = catSlug;

    // Update pill buttons
    const pills = document.querySelectorAll('.cat-pill');
    pills.forEach(pill => {
        if (pill.dataset.cat === catSlug) {
            pill.classList.add('active');
            pill.scrollIntoView({ behavior: 'smooth', inline: 'nearest', block: 'nearest' });
        } else {
            pill.classList.remove('active');
        }
    });

    // Populate branch select
    updateBranchDropdown(catSlug, branchToSet !== 'all');
    if (branchToSet !== 'all') {
        currentBranch = branchToSet;
    }
    updateBranchPillsUI(catSlug, currentBranch);
    updateUrlParams();
    filterSyllabus();

    // Scroll if focused
    if (catSlug !== 'all') {
        const section = document.getElementById('cat-block-' + catSlug);
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}

function updateUrlParams() {
    const url = new URL(window.location);
    if (currentCategory === 'all') {
        url.searchParams.delete('course');
    } else {
        url.searchParams.set('course', currentCategory);
    }

    if (currentBranch === 'all') {
        url.searchParams.delete('branch');
    } else {
        url.searchParams.set('branch', currentBranch);
    }
    window.history.replaceState({}, '', url);
}

function filterSyllabus() {
    const searchInput = document.getElementById('syllabusSearch');
    const query = (searchInput.value || '').toLowerCase().trim();
    const docType = (document.getElementById('docTypeFilter').value || 'all').toLowerCase();
    const branchSelect = document.getElementById('branchFilterSelect');
    const selectedBranchVal = branchSelect ? branchSelect.value : currentBranch;
    const clearBtn = document.getElementById('clearSearchBtn');

    if (clearBtn) {
        clearBtn.style.display = query.length > 0 ? 'inline-block' : 'none';
    }

    const categoryBlocks = document.querySelectorAll('.category-block');
    let totalVisible = 0;

    categoryBlocks.forEach(block => {
        const catSlug = block.dataset.catSlug;
        const isCatMatch = (currentCategory === 'all' || currentCategory === catSlug);
        
        if (!isCatMatch) {
            block.classList.add('d-none');
            return;
        }

        const items = block.querySelectorAll('.syllabus-item-col');
        let visibleInCat = 0;

        items.forEach(col => {
            const titleData = col.dataset.title || '';
            const typeData = col.dataset.doctype || '';
            const itemBranch = col.dataset.branch || 'general';

            // Check doc type match
            let matchesDocType = true;
            if (docType === 'scheme') {
                matchesDocType = (typeData.indexOf('scheme') !== -1);
            } else if (docType === 'syllabus') {
                matchesDocType = (typeData.indexOf('syllabus') !== -1);
            }

            // Check branch match
            let matchesBranch = true;
            if (selectedBranchVal && selectedBranchVal !== 'all') {
                matchesBranch = (itemBranch === selectedBranchVal);
            }

            // Check text query match
            const matchesQuery = (query === '' || titleData.indexOf(query) !== -1);

            if (matchesDocType && matchesBranch && matchesQuery) {
                col.classList.remove('d-none');
                visibleInCat++;
                totalVisible++;
            } else {
                col.classList.add('d-none');
            }
        });

        // Hide category block if 0 items match search
        if (visibleInCat > 0) {
            block.classList.remove('d-none');
        } else {
            block.classList.add('d-none');
        }
    });

    // Update count display
    const countSpan = document.getElementById('visibleDocCount');
    if (countSpan) countSpan.textContent = totalVisible;

    // Show empty state if 0 visible
    const noResultsMsg = document.getElementById('noResultsMsg');
    if (noResultsMsg) {
        if (totalVisible === 0) {
            noResultsMsg.classList.remove('d-none');
        } else {
            noResultsMsg.classList.add('d-none');
        }
    }
}

function clearSearch() {
    const input = document.getElementById('syllabusSearch');
    if (input) {
        input.value = '';
        filterSyllabus();
        input.focus();
    }
}

function resetSyllabusFilters() {
    const input = document.getElementById('syllabusSearch');
    if (input) input.value = '';
    
    const docType = document.getElementById('docTypeFilter');
    if (docType) docType.value = 'all';

    currentBranch = 'all';
    switchCategory('all');
}

// On page load, handle any query params (?course=be-btech&branch=cse)
window.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const courseParam = urlParams.get('course');
    const branchParam = urlParams.get('branch') || 'all';
    const hash = window.location.hash.replace('#', '').trim();
    const targetCat = (courseParam && courseParam !== 'all') ? courseParam : (hash || 'all');

    updateBranchDropdown(targetCat, branchParam !== 'all');
    if (targetCat !== 'all' && document.getElementById('cat-block-' + targetCat)) {
        switchCategory(targetCat, branchParam);
    } else {
        if (branchParam !== 'all') {
            currentBranch = branchParam;
            const bSelect = document.getElementById('branchFilterSelect');
            if (bSelect) bSelect.value = branchParam;
        }
        filterSyllabus();
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
