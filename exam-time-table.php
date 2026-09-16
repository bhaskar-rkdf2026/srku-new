<?php
$pageTitle = "SRK University Exam Time Table 2024-25 & 2026 | Semester Examination Schedules | SRKU Bhopal";
$pageDesc = "Official Examination Time Table and Date Sheets for Sarvepalli Radhakrishnan University (SRKU), Bhopal. Download semester exam time tables for Engineering, Pharmacy, Medical, Nursing, Law, Management and Agriculture.";
$pageKeywords = "SRKU Exam Time Table, SRK University Date Sheet 2024, Bhopal University Exam Schedule, B.Tech Exam Time Table, Pharmacy Time Table SRKU, MBBS Examination Schedule";
$activeNav = "academics";
require_once __DIR__ . '/includes/header.php';

// Fetch dynamic examination timetables from database
$dbTimetables = getExamTimetables('', '', 'active');
$rawCategories = [];
foreach ($dbTimetables as $t) {
    $cat = !empty($t['category']) ? $t['category'] : 'General';
    if (!isset($rawCategories[$cat])) {
        $rawCategories[$cat] = [];
    }
    $pdfUrl = $t['file_url'] ?? '';
    if (!empty($pdfUrl) && strpos($pdfUrl, 'http') !== 0) {
        $pdfUrl = BASE_URL . ltrim($pdfUrl, '/');
    }
    $rawCategories[$cat][] = [
        'id' => $t['id'],
        'course' => $t['course_title'],
        'details' => $t['details'] ?? 'Official Semester Examination Schedule',
        'url' => $pdfUrl,
        'filename' => $t['filename'] ?: basename($pdfUrl ?: 'exam-time-table.pdf'),
        'publish_date' => $t['created_at'] ?? ''
    ];
}

// Calculate total count
$totalTimetables = count($dbTimetables);
?>

<!-- ═══════════════════════════════════════════════════════
     HERO — AURORA MESH
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
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>courses.php" class="text-decoration-none text-white-50">Academics</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgba(255,255,255,0.85);">Exam Time Table</li>
                    </ol>
                </nav>
                <span class="about-hero-v2__eyebrow"><i class="fas fa-calendar-alt"></i> Controller of Examinations &middot; Official Date Sheets</span>
                <h1 class="about-hero-v2__title">Examination <span>Time Table</span> &amp; Schedules</h1>
                <p class="about-hero-v2__desc">
                    Access official semester examination date sheets, practical and theory schedules, notifications, and downloadable PDFs across all undergraduate, postgraduate, and diploma faculties of Sarvepalli Radhakrishnan University.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#exam-list" class="btn-hero-yellow">
                        <i class="fas fa-th-list me-1"></i> Browse All Time Tables
                    </a>
                    <a href="<?php echo BASE_URL; ?>exam-rules.php" class="btn-hero-outline">
                        <i class="fas fa-clipboard-check me-1"></i> Exam Rules &amp; Ordinances
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-hero-v2__cards">
                    <div class="about-hero-v2__card about-hero-v2__card--float1">
                        <i class="fas fa-file-alt"></i>
                        <span class="num"><?php echo $totalTimetables; ?>+</span>
                        <span class="lbl">Active Time Tables</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float2">
                        <i class="fas fa-university"></i>
                        <span class="num">7</span>
                        <span class="lbl">Academic Faculties</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float3">
                        <i class="fas fa-clock"></i>
                        <span class="num">2024-26</span>
                        <span class="lbl">Current Session</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float4">
                        <i class="fas fa-check-circle"></i>
                        <span class="num">100%</span>
                        <span class="lbl">Official &amp; Verified</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     EXAMINATION CONTROLLER ADVISORY & SEARCH STRIP
═══════════════════════════════════════════════════════ -->
<section class="py-4 bg-white border-bottom shadow-sm" id="exam-list">
    <div class="container-xl">
        <div class="row align-items-center g-3">
            <div class="col-12 col-md-6">
                <div class="input-group search-input-group shadow-sm rounded-pill overflow-hidden border">
                    <span class="input-group-text bg-white border-0 ps-3 text-muted">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="timetableSearch" class="form-control border-0 py-2 ps-2" placeholder="Search course, branch, semester or batch (e.g., B.Tech, Nursing, LLB)...">
                    <button class="btn btn-maroon px-4" type="button" id="clearSearchBtn">Clear</button>
                </div>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <div class="d-inline-flex align-items-center gap-2 text-muted small bg-light p-2 px-3 rounded-pill border">
                    <i class="fas fa-info-circle text-primary"></i>
                    <span>For Verification: <a href="mailto:exam@srku.edu.in" class="text-navy fw-bold text-decoration-none">exam@srku.edu.in</a> | Helpline: <span class="text-danger fw-bold">0755 - 4911204</span></span>
                </div>
            </div>
        </div>

        <!-- Faculty Category Filter Buttons -->
        <div class="d-flex flex-wrap gap-2 mt-4 pt-2" id="categoryFilterTabs">
            <button type="button" class="btn btn-sm btn-navy rounded-pill px-3 py-2 active-cat" data-category="all">
                <i class="fas fa-globe me-1"></i> All Courses <span class="badge bg-white text-navy ms-1 rounded-pill"><?php echo $totalTimetables; ?></span>
            </button>
            <?php 
            $catIcons = [
                'Engineering & Polytechnic' => 'fa-cogs',
                'Pharmacy' => 'fa-pills',
                'Medical, Dental & Ayush' => 'fa-stethoscope',
                'Nursing & Paramedical' => 'fa-user-nurse',
                'Management & Computer Application' => 'fa-laptop-code',
                'Law' => 'fa-balance-scale',
                'Agriculture & Allied Sciences' => 'fa-seedling'
            ];
            foreach ($rawCategories as $catName => $items): 
                $icon = $catIcons[$catName] ?? 'fa-folder';
            ?>
                <button type="button" class="btn btn-sm btn-outline-navy rounded-pill px-3 py-2" data-category="<?php echo htmlspecialchars($catName); ?>">
                    <i class="fas <?php echo $icon; ?> me-1"></i> <?php echo htmlspecialchars($catName); ?> <span class="badge bg-secondary ms-1 rounded-pill"><?php echo count($items); ?></span>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     TIMETABLES GRID SECTION
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream">
    <div class="container-xl py-2">
        <div id="noResultsAlert" class="alert alert-warning text-center rounded-4 shadow-sm p-4 d-none">
            <i class="fas fa-exclamation-triangle fs-3 text-warning mb-2 d-block"></i>
            <h5 class="fw-bold mb-1">No Time Tables Found</h5>
            <p class="text-muted small mb-0">No examination schedule matched your search criteria. Please try another course name or clear the filter.</p>
        </div>

        <?php foreach ($rawCategories as $catName => $items): ?>
            <div class="category-block mb-5" data-catname="<?php echo htmlspecialchars($catName); ?>">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                    <h3 class="h5 fw-bold text-navy mb-0 d-flex align-items-center gap-2">
                        <span class="rounded-circle bg-maroon text-white d-inline-flex align-items-center justify-content-center" style="width:32px; height:32px; font-size:0.9rem;">
                            <i class="fas <?php echo $catIcons[$catName] ?? 'fa-folder'; ?>"></i>
                        </span>
                        <?php echo htmlspecialchars($catName); ?>
                    </h3>
                    <span class="badge bg-maroon text-white rounded-pill px-3 py-1 small fw-bold">
                        <?php echo count($items); ?> Schedules
                    </span>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                    <?php foreach ($items as $item): ?>
                        <div class="col timetable-item-col" data-text="<?php echo strtolower(htmlspecialchars($item['course'] . ' ' . $item['details'] . ' ' . $catName)); ?>">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 bg-white timetable-card transition-all">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill small fw-semibold px-2 py-1">
                                        <i class="fas fa-calendar-check me-1"></i> Official Schedule
                                    </span>
                                    <span class="badge bg-light text-muted border rounded-pill small">
                                        PDF
                                    </span>
                                </div>
                                <h4 class="h6 fw-bold text-navy mb-1" style="line-height:1.45;">
                                    <?php echo htmlspecialchars($item['course']); ?>
                                </h4>
                                <p class="text-muted small mb-3 flex-grow-1" style="line-height:1.55; font-size:0.84rem;">
                                    <?php echo !empty($item['details']) ? htmlspecialchars($item['details']) : 'Official University Semester Examination Schedule'; ?>
                                </p>
                                <div class="mt-auto pt-2 border-top d-flex gap-2">
                                    <a href="<?php echo htmlspecialchars($item['url']); ?>" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill flex-grow-1">
                                        <i class="fas fa-eye me-1"></i> View Time Table
                                    </a>
                                    <a href="<?php echo htmlspecialchars($item['url']); ?>" download="<?php echo htmlspecialchars($item['filename']); ?>" class="btn btn-sm btn-maroon rounded-pill px-3" title="Direct Download PDF">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Examination General Guidelines Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mt-4" style="border-left: 5px solid #0F1E3B !important;">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                    <span class="badge bg-navy text-white px-3 py-1 rounded-pill small fw-bold mb-2">
                        <i class="fas fa-shield-alt me-1"></i> Mandatory Candidate Instructions
                    </span>
                    <h4 class="h5 fw-bold text-navy mb-2">Important Instructions for University Examinations</h4>
                    <ul class="text-muted small mb-0 ps-3" style="line-height:1.7;">
                        <li>Students must carry their <strong>Original Admit Card / Hall Ticket</strong> and <strong>University ID Card</strong> to the examination centre.</li>
                        <li>Candidates should report to the examination hall at least <strong>30 minutes before</strong> the scheduled commencement of the test.</li>
                        <li>Electronic gadgets, smartwatches, programmable calculators, and mobile phones are <strong>strictly prohibited</strong> inside the examination premises.</li>
                        <li>For any conflict in paper codes or back-paper schedule clashing, contact the Examination Control Room immediately.</li>
                    </ul>
                </div>
                <div class="col-12 col-lg-4 text-lg-end">
                    <div class="bg-light p-3 rounded-4 border text-center">
                        <i class="fas fa-headset text-danger fs-2 mb-2 d-block"></i>
                        <h6 class="fw-bold text-navy mb-1">Examination Control Room</h6>
                        <p class="text-muted small mb-2">Helpdesk available Mon &ndash; Sat, 9:30 AM to 5:30 PM</p>
                        <a href="tel:07554911204" class="btn btn-sm btn-maroon rounded-pill px-3 py-2 w-100 mb-2">
                            <i class="fas fa-phone-alt me-1"></i> 0755 - 4911204
                        </a>
                        <a href="mailto:exam@srku.edu.in" class="btn btn-sm btn-outline-navy rounded-pill px-3 py-2 w-100">
                            <i class="fas fa-envelope me-1"></i> exam@srku.edu.in
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Interactive Live Filter Script -->
<script>
document.addEventListener('DOMContentLoaded', function(){
    const searchInput = document.getElementById('timetableSearch');
    const clearBtn = document.getElementById('clearSearchBtn');
    const filterTabs = document.querySelectorAll('#categoryFilterTabs button');
    const categoryBlocks = document.querySelectorAll('.category-block');
    const noResultsAlert = document.getElementById('noResultsAlert');

    let activeCategory = 'all';

    function filterTimetables() {
        const query = searchInput.value.toLowerCase().trim();
        let totalVisible = 0;

        categoryBlocks.forEach(function(block) {
            const catName = block.getAttribute('data-catname');
            const items = block.querySelectorAll('.timetable-item-col');
            let blockVisibleCount = 0;

            const matchesCategory = (activeCategory === 'all' || activeCategory === catName);

            if (!matchesCategory) {
                block.classList.add('d-none');
            } else {
                items.forEach(function(item) {
                    const text = item.getAttribute('data-text');
                    const matchesSearch = (!query || text.indexOf(query) !== -1);

                    if (matchesSearch) {
                        item.classList.remove('d-none');
                        blockVisibleCount++;
                    } else {
                        item.classList.add('d-none');
                    }
                });

                if (blockVisibleCount > 0) {
                    block.classList.remove('d-none');
                    totalVisible += blockVisibleCount;
                } else {
                    block.classList.add('d-none');
                }
            }
        });

        if (totalVisible === 0) {
            noResultsAlert.classList.remove('d-none');
        } else {
            noResultsAlert.classList.add('d-none');
        }
    }

    // Category button clicks
    filterTabs.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filterTabs.forEach(function(b) {
                b.classList.remove('btn-navy', 'active-cat');
                b.classList.add('btn-outline-navy');
                const badge = b.querySelector('.badge');
                if (badge) {
                    badge.classList.remove('bg-white', 'text-navy');
                    badge.classList.add('bg-secondary');
                }
            });

            btn.classList.remove('btn-outline-navy');
            btn.classList.add('btn-navy', 'active-cat');
            const activeBadge = btn.querySelector('.badge');
            if (activeBadge) {
                activeBadge.classList.remove('bg-secondary');
                activeBadge.classList.add('bg-white', 'text-navy');
            }

            activeCategory = btn.getAttribute('data-category');
            filterTimetables();
        });
    });

    // Search input typing
    searchInput.addEventListener('input', filterTimetables);

    // Clear search
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        filterTimetables();
        searchInput.focus();
    });
});
</script>

<style>
.timetable-card {
    transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
    border: 1px solid rgba(0,0,0,0.06) !important;
}
.timetable-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(15, 30, 59, 0.1) !important;
    border-color: rgba(122, 11, 13, 0.25) !important;
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
