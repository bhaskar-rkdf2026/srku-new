<?php
$pageTitle = "Board of Management Members & Governance | SRK University Bhopal";
$pageDesc = "Meet the distinguished members of the Board of Management and Governing Body of Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = "SRKU Board of Management, Board Members SRK University, University Governance, RKDF Education Society Bhopal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';

// Statutory and apex leadership list
$canonicalBoardMembers = [
    [
        'name' => 'Dr. Sunil Kapoor',
        'designation' => 'Chairman & Chief Patron',
        'category' => 'leadership',
        'representation' => 'Founder & Visionary, RKDF Education Society',
        'bio' => 'Guiding the RKDF group and SRK University since 1995 with an inspiring mission of affordable, benchmarked multidisciplinary higher education.',
        'icon' => 'fa-crown',
        'photo' => 'assets/uploads/2026/08/dr-sunil-kapoor.jpeg'
    ],
    [
        'name' => 'Mrs. Janak Kapoor',
        'designation' => 'Chancellor',
        'category' => 'leadership',
        'representation' => 'Statutory Head of the University',
        'bio' => 'Presiding officer of university convocations and apex custodian of university ethos and statutory adherence.',
        'icon' => 'fa-user-tie',
        'photo' => 'assets/uploads/2026/08/chancellor.jpeg'
    ],
    [
        'name' => 'Ms. Priyanka Jaiswal',
        'designation' => 'Vice Chancellor',
        'category' => 'leadership',
        'representation' => 'Principal Academic & Executive Officer',
        'bio' => 'Leading the university\'s NEP 2020 pedagogical transformation, multidisciplinary research, and international accreditations.',
        'icon' => 'fa-graduation-cap',
        'photo' => ''
    ],
    [
        'name' => 'Shri. Ratnesh Jain',
        'designation' => 'Member',
        'category' => 'sponsoring',
        'representation' => 'Sponsoring Body Representative',
        'bio' => 'Distinguished member nominated by RKDF Education Society contributing to institutional resource planning and development.',
        'icon' => 'fa-briefcase',
        'photo' => ''
    ],
    [
        'name' => 'Dr. Amarjeet Singh',
        'designation' => 'Member',
        'category' => 'sponsoring',
        'representation' => 'Sponsoring Body Representative',
        'bio' => 'Senior educationist and policy strategist supporting institutional expansion and regulatory compliance.',
        'icon' => 'fa-user-check',
        'photo' => ''
    ],
    [
        'name' => 'Dr. Aparna Paliwal',
        'designation' => 'Member',
        'category' => 'academic',
        'representation' => 'Eminent Academician',
        'bio' => 'Senior professor advising the university on outcome-based education, curriculum restructuring, and pedagogical innovations.',
        'icon' => 'fa-book-reader',
        'photo' => ''
    ],
    [
        'name' => 'Dr. Vikram Singh',
        'designation' => 'Member',
        'category' => 'academic',
        'representation' => 'Academic & Research Expert',
        'bio' => 'Guiding scientific research publications, doctoral review committees, and inter-institutional research collaborations.',
        'icon' => 'fa-microscope',
        'photo' => ''
    ],
    [
        'name' => 'Mr. Santosh Negi',
        'designation' => 'Member',
        'category' => 'administration',
        'representation' => 'Industry & Administrative Expert',
        'bio' => 'Providing strategic direction for corporate relations, campus placements, and industrial internships.',
        'icon' => 'fa-chart-line',
        'photo' => ''
    ],
    [
        'name' => 'Dr. Neha Dubey',
        'designation' => 'Member',
        'category' => 'academic',
        'representation' => 'Faculty Representative',
        'bio' => 'Representing faculty governance, faculty development programs, and interdisciplinary student initiatives.',
        'icon' => 'fa-chalkboard-teacher',
        'photo' => ''
    ],
    [
        'name' => 'Dr. S.S. Pawar',
        'designation' => 'Member Secretary & Registrar',
        'category' => 'administration',
        'representation' => 'Executive Head of Administration',
        'bio' => 'Custodian of university records, legal affairs, statutory councils, and university secretariat.',
        'icon' => 'fa-id-card',
        'photo' => ''
    ],
];

// Fetch dynamic board members from database if available
$dbMembers = getBoardMembers('active');
if (!empty($dbMembers)) {
    // If DB already has custom full list, ensure category and icon mappings exist
    $hasSunil = false;
    foreach ($dbMembers as $dm) {
        if (stripos($dm['name'] ?? '', 'Sunil') !== false) {
            $hasSunil = true;
            break;
        }
    }
    if (!$hasSunil) {
        // Use canonical list so all leadership + statutory members are seamlessly presented
        $boardMembers = $canonicalBoardMembers;
    } else {
        $boardMembers = $dbMembers;
    }
} else {
    $boardMembers = $canonicalBoardMembers;
}
$stats = getUniversityStats();
?>

<!-- ═══════════════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════════════ -->
<section class="about-hero-v2">
    <div class="about-hero-v2__blob about-hero-v2__blob--1"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--2"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--3"></div>
    <div class="about-hero-v2__grid"></div>
    <div class="container-xl about-hero-v2__inner">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-warning"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>about.php" class="text-decoration-none text-white-50">About</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Board of Management Members</li>
            </ol>
        </nav>
        <span class="about-hero-v2__eyebrow"><i class="fas fa-balance-scale"></i> Statutory Governance &middot; MP Act No. 17 of 2007</span>
        <h1 class="about-hero-v2__title">Board of <span>Management Members</span></h1>
        <p class="about-hero-v2__desc">
            The Board of Management is the principal executive authority of Sarvepalli Radhakrishnan University, responsible for the general management and administration of the university, its academic ecosystem, and statutory governance.
        </p>
        <div class="d-flex flex-wrap gap-3">
            <a href="#members-directory" class="btn-hero-yellow"><i class="fas fa-users me-1"></i> View Directory</a>
            <a href="<?php echo BASE_URL; ?>document/board-of-management" class="btn-hero-outline"><i class="fas fa-file-pdf me-1"></i> Official Notification</a>
            <a href="<?php echo BASE_URL; ?>about.php" class="btn-hero-outline"><i class="fas fa-university me-1"></i> About University</a>
        </div>
    </div>
</section>

<!-- STATS STRIP -->
<div class="stats-strip py-3">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-5 g-0 text-center">
            <div class="col stat-box">
                <div class="stat-val"><?php echo $stats['years']; ?></div>
                <div class="stat-txt">Legacy of Excellence</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo $stats['units']; ?></div>
                <div class="stat-txt">Constituent Units</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo $stats['programs']; ?></div>
                <div class="stat-txt">Approved Programmes</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo $stats['faculty']; ?></div>
                <div class="stat-txt">Distinguished Faculty</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo $stats['students']; ?></div>
                <div class="stat-txt">Enrolled Students</div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     MEMBERS DIRECTORY & FILTER TABS
═══════════════════════════════════════════════════════ -->
<section class="py-5" id="members-directory">
    <div class="container-xl py-3">
        <div class="text-center mb-4">
            <span class="section-subtitle">EXECUTIVE DIRECTORY</span>
            <h2 class="section-title">Members of the <span>Board of Management</span></h2>
            <p class="text-muted mx-auto" style="max-width:720px; font-size:0.95rem;">
                Constituted under Section 22 of the Madhya Pradesh Niji Vishwavidyalaya (Sthapana Avam Sanchalan) Adhiniyam, 2007, comprising visionary leaders, academic scholars, and administrative experts.
            </p>
        </div>

        <!-- Filter Tabs -->
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-5" id="boardFilterTabs">
            <button type="button" class="btn btn-sm btn-outline-danger active px-3 py-2 rounded-pill fw-semibold board-filter-btn" data-filter="all">
                <i class="fas fa-th-large me-1"></i> All Members (<?php echo count($boardMembers); ?>)
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger px-3 py-2 rounded-pill fw-semibold board-filter-btn" data-filter="leadership">
                <i class="fas fa-crown me-1"></i> University Leadership
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger px-3 py-2 rounded-pill fw-semibold board-filter-btn" data-filter="sponsoring">
                <i class="fas fa-landmark me-1"></i> Sponsoring Body
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger px-3 py-2 rounded-pill fw-semibold board-filter-btn" data-filter="academic">
                <i class="fas fa-graduation-cap me-1"></i> Academic Leaders
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger px-3 py-2 rounded-pill fw-semibold board-filter-btn" data-filter="administration">
                <i class="fas fa-user-shield me-1"></i> Administration
            </button>
        </div>

        <!-- Members Grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4" id="boardMembersGrid">
            <?php foreach ($boardMembers as $m): 
                $cat = $m['category'] ?? 'academic';
                $icon = $m['icon'] ?? 'fa-user-tie';
            ?>
                <div class="col board-member-card-wrapper" data-category="<?php echo sanitize($cat); ?>">
                    <div class="card h-100 p-4 border-0 shadow-sm rounded-4 text-center d-flex flex-column transition-all" style="background:#ffffff; border-top: 4px solid var(--srku-maroon) !important;">
                        
                        <!-- Avatar / Photo -->
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm" style="width:90px; height:90px; background: #fdf2f2; color: var(--srku-maroon); font-size:2.2rem; overflow:hidden;">
                            <?php if (!empty($m['photo'])): ?>
                                <img src="<?php echo BASE_URL . sanitize($m['photo']); ?>" alt="<?php echo sanitize($m['name']); ?>" style="width:100%; height:100%; object-fit:cover;">
                            <?php else: ?>
                                <i class="fas <?php echo sanitize($icon); ?>"></i>
                            <?php endif; ?>
                        </div>

                        <!-- Name & Designation -->
                        <h3 class="h6 fw-bold text-navy mb-1" style="font-size:1.05rem;"><?php echo sanitize($m['name']); ?></h3>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 mb-2 align-self-center small fw-semibold">
                            <?php echo sanitize($m['designation'] ?? 'Member'); ?>
                        </span>

                        <?php if (!empty($m['representation'])): ?>
                            <p class="text-muted small fw-semibold mb-2" style="font-size:0.82rem;">
                                <i class="fas fa-tag text-warning me-1"></i> <?php echo sanitize($m['representation']); ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($m['bio'])): ?>
                            <p class="text-muted small mb-3 flex-grow-1" style="font-size:0.82rem; line-height:1.6;">
                                <?php echo sanitize($m['bio']); ?>
                            </p>
                        <?php endif; ?>

                        <div class="mt-auto pt-2 border-top">
                            <span class="text-muted small" style="font-size:0.75rem;">Sarvepalli Radhakrishnan University</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     STATUTORY MANDATE & POWERS SECTION
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-6">
                <span class="section-subtitle">STATUTORY POWERS &amp; FUNCTIONS</span>
                <h2 class="section-title mb-3">Role of the <span>Board of Management</span></h2>
                <p class="text-muted mb-4" style="line-height:1.8;">
                    In accordance with the regulatory statutes of the University and the guidelines of the Madhya Pradesh Private University Regulatory Commission (MPPURC), the Board of Management performs key executive governance functions:
                </p>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px; height:36px;">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-navy">Academic &amp; Infrastructure Administration:</strong>
                            <p class="text-muted small mb-0">Approval of new institutes, degree programmes, curriculum restructuring, and campus facility expansions.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px; height:36px;">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-navy">Financial Oversight &amp; Budgeting:</strong>
                            <p class="text-muted small mb-0">Examination of annual accounts, budget allocation for scientific research, and scholarships for meritorious students.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px; height:36px;">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-navy">Faculty &amp; Staff Appointments:</strong>
                            <p class="text-muted small mb-0">Ratification of selection committees for senior professors, directors, medical consultants, and statutory deans.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 text-white" style="background: linear-gradient(135deg, var(--srku-maroon), var(--srku-navy));">
                    <span class="badge bg-warning text-dark align-self-start mb-3 px-3 py-1 fw-bold">Statutory Compliance</span>
                    <h3 class="h4 fw-bold mb-3">Official Board Documents &amp; Regulatory Notifications</h3>
                    <p class="text-white-50 small mb-4" style="line-height:1.75;">
                        Review the official Gazetted notifications, ordinances, and governing body resolutions approved by the State Higher Education Department and Regulatory Commission.
                    </p>
                    <div class="d-flex flex-column gap-2">
                        <a href="<?php echo BASE_URL; ?>document/board-of-management" class="btn btn-light text-danger fw-bold d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                            <span><i class="fas fa-file-pdf text-danger me-2"></i> Board of Management Official List (PDF)</span>
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>document/governing-body" class="btn btn-outline-light d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                            <span><i class="fas fa-landmark me-2"></i> Governing Body Constitution</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>document/university-ordinance" class="btn btn-outline-light d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                            <span><i class="fas fa-book me-2"></i> University Statutes &amp; Ordinances</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter Script -->
<script>
(function() {
    var buttons = document.querySelectorAll('#boardFilterTabs .board-filter-btn');
    var cards = document.querySelectorAll('#boardMembersGrid .board-member-card-wrapper');
    if (!buttons.length || !cards.length) return;

    buttons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            buttons.forEach(function(b) {
                b.classList.remove('active');
                b.classList.remove('btn-danger');
                b.classList.add('btn-outline-danger');
            });
            btn.classList.add('active');
            btn.classList.remove('btn-outline-danger');
            btn.classList.add('btn-danger');

            var filter = btn.getAttribute('data-filter');
            cards.forEach(function(card) {
                var cat = card.getAttribute('data-category');
                if (filter === 'all' || cat === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
})();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
