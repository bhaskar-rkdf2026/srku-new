<?php
$pageTitle = "About SRK University Bhopal | Legacy, Academic Ecosystem & Leadership | SRKU";
$pageDesc = "Discover Sarvepalli Radhakrishnan University (SRKU), Bhopal — a premier institution established in 1995 under the RKDF Education Society, offering benchmarked education across 14 constituent units.";
$pageKeywords = "About SRKU, Sarvepalli Radhakrishnan University History, RKDF Group, Private University Bhopal, SRKU Campus Ecosystem";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════
     HERO — AURORA MESH (no photo, pure animated gradient)
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
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-warning">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgba(255,255,255,0.85);">About</li>
                    </ol>
                </nav>
                <span class="about-hero-v2__eyebrow"><i class="fas fa-star"></i> Est. 1995 &middot; RKDF Education Society</span>
                <h1 class="about-hero-v2__title">Discover <span>SRK University</span> &ndash; Bhopal's Premier Multidisciplinary Private University</h1>
                <p class="about-hero-v2__desc">
                    Welcome to Sarvepalli Radhakrishnan University, commonly known as SRK University, one of Madhya Pradesh's leading private universities. Named after Dr. Sarvepalli Radhakrishnan, India's First Vice President, our institution embodies excellence, innovation, and commitment to holistic education.
                </p>
                <div class="d-flex flex-wrap gap-2 pt-2">
                    <a href="#leadership" class="btn-hero-yellow"><i class="fas fa-users-cog me-1"></i> Meet the Leadership</a>
                    <a href="#chairman-story" class="btn-hero-outline"><i class="fas fa-user-tie me-1"></i> Chairman's Story</a>
                    <a href="#all-committees" class="btn-hero-outline"><i class="fas fa-users-cog me-1"></i> All Committees &amp; Boards</a>
                    <a href="<?php echo BASE_URL; ?>board-members.php" class="btn-hero-outline"><i class="fas fa-id-badge me-1"></i> View Board Members</a>
                    <a href="<?php echo BASE_URL; ?>board-of-management.php" class="btn-hero-outline"><i class="fas fa-landmark me-1"></i> Board of Management</a>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-hero-v2__cards">
                    <div class="about-hero-v2__card about-hero-v2__card--float1">
                        <i class="fas fa-calendar-check"></i>
                        <span class="num"><?php echo getSetting('stat_years', '31st'); ?></span>
                        <span class="lbl">Year of Excellence</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float2">
                        <i class="fas fa-user-graduate"></i>
                        <span class="num"><?php echo getSetting('stat_students', '20,000+'); ?></span>
                        <span class="lbl">Students</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float3">
                        <i class="fas fa-layer-group"></i>
                        <span class="num"><?php echo getSetting('stat_units', '14'); ?></span>
                        <span class="lbl">Constituent Units</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float4">
                        <i class="fas fa-briefcase"></i>
                        <span class="num"><?php echo getSetting('stat_placements', '35,000+'); ?></span>
                        <span class="lbl">Placements</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- WHO WE ARE / UNIVERSITY OVERVIEW -->
<section class="py-5" id="overview">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-5 reveal">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/08/srku-rkdf-building.jpeg"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     class="welcome-img" alt="RKDF Group Campus Building">
            </div>
            <div class="col-12 col-lg-7 reveal">
                <span class="section-subtitle">UNIVERSITY OVERVIEW</span>
                <h2 class="section-title mb-3">Who <span>We Are</span></h2>
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.96rem;">
                    Established under the Madhya Pradesh Niji Vishwavidyalaya (Sthapana Avam Sanchalan) Adhiniyam 2007, as amended by the Dwitiya Sanshodhan Adhiniyam 2014, and sponsored by RKDF Education Society, Bhopal, SRK University stands as a beacon of academic excellence in central India.
                </p>
                <ul class="list-unstyled row row-cols-1 row-cols-sm-2 g-2 mb-0">
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> UGC (University Grants Commission) &ndash; Section 2(f)</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> AICTE (All India Council for Technical Education)</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> NMC (National Medical Commission) &ndash; MBBS &amp; MD programmes</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> DCI (Dental Council of India) &ndash; BDS &amp; MDS programmes</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> PCI (Pharmacy Council of India) &ndash; Pharmacy programmes</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> INC (Indian Nursing Council) &ndash; Nursing programmes</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> CCH &amp; NCISM (Central Council for Homeopathy)</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- STATS MILESTONE TIMELINE -->
<?php
$aboutMilestoneStats = [
    ['icon' => 'fa-award', 'num' => getSetting('stat_years', '31<sup>st</sup>'), 'lbl' => 'Year of Excellence'],
    ['icon' => 'fa-user-graduate', 'num' => getSetting('stat_students', '20,000+'), 'lbl' => 'Students'],
    ['icon' => 'fa-briefcase', 'num' => getSetting('stat_placements', '35,000+'), 'lbl' => 'Placements'],
    ['icon' => 'fa-handshake', 'num' => getSetting('stat_partners', '42+') . ' (300+ Linkages)', 'lbl' => 'Industry Linkages'],
    ['icon' => 'fa-users', 'num' => getSetting('stat_alumni', '1,10,000+'), 'lbl' => 'Alumni'],
    ['icon' => 'fa-chalkboard-teacher', 'num' => getSetting('stat_faculty', '600+'), 'lbl' => 'Faculty'],
    ['icon' => 'fa-lightbulb', 'num' => getSetting('stat_patents', '160+'), 'lbl' => 'Patents'],
    ['icon' => 'fa-gift', 'num' => '&#10003;', 'lbl' => 'Scholarship Available'],
];
?>
<section class="stat-milestones">
    <div class="stat-milestones__track">

        <div class="stat-milestones__row stat-milestones__row--top">
            <?php foreach ($aboutMilestoneStats as $mi => $ms): ?>
                <div class="stat-milestones__col">
                    <?php if ($mi % 2 === 0): ?>
                        <div class="stat-milestones__card">
                            <span class="stat-milestones__icon"><i class="fas <?php echo $ms['icon']; ?>"></i></span>
                            <span class="stat-milestones__num"><?php echo $ms['num']; ?></span>
                            <span class="stat-milestones__lbl"><?php echo $ms['lbl']; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="stat-milestones__row stat-milestones__row--dots">
            <?php foreach ($aboutMilestoneStats as $mi => $ms): ?>
                <div class="stat-milestones__col<?php echo $mi % 2 === 1 ? ' stat-milestones__col--bottom-accent' : ''; ?>">
                    <span class="stat-milestones__dot"></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="stat-milestones__row stat-milestones__row--bottom">
            <?php foreach ($aboutMilestoneStats as $mi => $ms): ?>
                <div class="stat-milestones__col">
                    <?php if ($mi % 2 === 1): ?>
                        <div class="stat-milestones__card stat-milestones__card--accent">
                            <span class="stat-milestones__icon"><i class="fas <?php echo $ms['icon']; ?>"></i></span>
                            <span class="stat-milestones__num"><?php echo $ms['num']; ?></span>
                            <span class="stat-milestones__lbl"><?php echo $ms['lbl']; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php foreach ($aboutMilestoneStats as $mi => $ms): ?>
            <div class="stat-milestones__grid-item">
                <div class="stat-milestones__card<?php echo $mi % 2 === 1 ? ' stat-milestones__card--accent' : ''; ?>">
                    <span class="stat-milestones__icon"><i class="fas <?php echo $ms['icon']; ?>"></i></span>
                    <span class="stat-milestones__num"><?php echo $ms['num']; ?></span>
                    <span class="stat-milestones__lbl"><?php echo $ms['lbl']; ?></span>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CHAIRMAN'S STORY & VISION
═══════════════════════════════════════════════════════ -->
<section class="chairman-story-section py-5 position-relative" id="chairman-story">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-5 reveal">
                <div class="chairman-card-wrap">
                    <div class="chairman-card-frame shadow-lg">
                        <div class="chairman-card-banner">
                            <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill"><i class="fas fa-star me-1"></i> EST. 1995</span>
                            <span class="text-white-50 small fw-semibold">RKDF Education Society</span>
                        </div>
                        <div class="chairman-avatar-box">
                            <div class="chairman-avatar-circle">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="chairman-card-body text-center">
                            <h3 class="chairman-name mb-1"><?php echo sanitize(getSetting('chairman_name', 'Dr. Sunil Kapoor')); ?></h3>
                            <p class="chairman-title text-danger fw-bold mb-3"><?php echo sanitize(getSetting('chairman_title', 'Chairman &amp; Founder Patron')); ?></p>
                            
                            <p class="text-muted small mb-3" style="line-height:1.6;">
                                Pioneering multidisciplinary higher education across Central India, nurturing excellence in medical, dental, pharmacy, engineering, and doctoral research.
                            </p>

                            <div class="chairman-pillars d-flex justify-content-center gap-2 flex-wrap mb-4">
                                <span class="badge-pill-soft"><i class="fas fa-certificate text-warning me-1"></i> 31+ Years Legacy</span>
                                <span class="badge-pill-soft"><i class="fas fa-university text-primary me-1"></i> 14 Units</span>
                                <span class="badge-pill-soft"><i class="fas fa-user-graduate text-success me-1"></i> 1,10,000+ Alumni</span>
                            </div>

                            <div class="chairman-actions d-flex justify-content-center gap-2 flex-wrap">
                                <a href="<?php echo BASE_URL; ?>board-members.php" class="btn btn-sm btn-maroon rounded-pill px-3 py-2">
                                    <i class="fas fa-users me-1"></i> View Board Members
                                </a>
                                <a href="<?php echo BASE_URL; ?>board-of-management.php" class="btn btn-sm btn-outline-navy rounded-pill px-3 py-2">
                                    <i class="fas fa-landmark me-1"></i> Board of Management
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7 reveal">
                <span class="section-subtitle">FOUNDER &amp; CHAIRMAN'S DESK</span>
                <h2 class="section-title mb-3">Shaping Future <span>Leaders Through</span> Value-Based Education</h2>
                
                <div class="chairman-quote-card mb-4 shadow-sm">
                    <i class="fas fa-quote-left text-warning fs-3 mb-2 d-block"></i>
                    <p class="lead-quote mb-0">
                        &ldquo;<?php echo sanitize(getSetting('chairman_story_quote', 'Education is the foundation of progress, empowering individuals with knowledge, values, and the confidence to shape a better future. At SRK University, our vision is to provide quality education that combines academic excellence with practical learning, innovation, and strong ethical values. We are committed to creating an environment where students can explore their potential, develop professional skills, and prepare themselves to meet the challenges of a rapidly changing world.')); ?>&rdquo;
                    </p>
                </div>

                <p class="text-dark mb-3" style="line-height:1.85; font-size:0.96rem;">
                    When RKDF Education Society laid its foundations in 1995, it set forth on a visionary mission: to build a benchmarked educational powerhouse in Central India that brings world-class technical, healthcare, and humanistic learning within reach of every aspirational learner.
                </p>

                <p class="text-muted mb-4" style="line-height:1.85; font-size:0.96rem;">
                    From starting pioneer technical institutes to founding Sarvepalli Radhakrishnan University with 14 constituent units, 750+ hospital beds, and 160+ patents, the journey represents three decades of relentless dedication to societal upliftment and national development.
                </p>

                <div class="row g-3 pt-1">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border">
                            <div class="icon-circle bg-navy text-white"><i class="fas fa-graduation-cap"></i></div>
                            <div>
                                <h6 class="fw-bold text-navy mb-1">Inclusive Access</h6>
                                <p class="text-muted small mb-0">Democratizing professional, legal, and medical sciences with extensive scholarships and state-of-the-art campus amenities.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border">
                            <div class="icon-circle" style="background:#7A0B0D; color:#fff;"><i class="fas fa-flask"></i></div>
                            <div>
                                <h6 class="fw-bold text-navy mb-1">Innovation Ecosystem</h6>
                                <p class="text-muted small mb-0">Over 160 filed patents, cutting-edge Incubation Centre, and 300+ active industry-research MoUs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- VISION & MISSION -->
<section class="py-5 bg-cream" id="vision">
    <div class="container-xl py-3">
        <div class="text-center mb-4">
            <span class="section-subtitle">OUR COMMITMENT</span>
            <h2 class="section-title">Our <span>Vision</span> &amp; <span>Mission</span></h2>
        </div>

        <div class="vm-tabs reveal" id="vmTabs" role="tablist">
            <button type="button" class="vm-tab active" data-target="vm-panel-vision" role="tab" aria-selected="true">
                <i class="fas fa-eye me-2"></i> Our Vision
            </button>
            <button type="button" class="vm-tab" data-target="vm-panel-mission" role="tab" aria-selected="false">
                <i class="fas fa-bullseye me-2"></i> Our Mission
            </button>
        </div>

        <div class="vm-panel-wrap reveal">
            <div class="vm-panel active" id="vm-panel-vision" role="tabpanel">
                <p class="vm-panel__quote">&ldquo;<?php echo sanitize(getSetting('vision_quote', 'Learn about Education that helps Society')); ?>&rdquo;</p>
                <p class="vm-panel__text">
                    <?php echo sanitize(getSetting('vision_text', 'Sarvepalli Radhakrishnan University is an academic fraternity of individuals dedicated to the motto of "Learn about Education that helps Society". To emerge as a World-Class University in creating and disseminating knowledge, and providing students a unique learning experience in Science, Technology, Medicine, Management and other areas of life that will best serve the world and betterment of society. To create a knowledge-based society with scientific temper, team spirit, and dignity of labour to face global competitive challenges.')); ?>
                </p>
            </div>
            <div class="vm-panel" id="vm-panel-mission" role="tabpanel">
                <ul class="vm-panel__list">
                    <li>Sarvepalli Radhakrishnan University is a nurturing ground for an individual's holistic growth to make effective contribution to the society in a dynamic environment. To evolve and develop skill-based systems for effective delivery of knowledge so as to equip young professionals with dedication and commitment to excellence in all spheres of life &amp; society.</li>
                    <li>Facilitate intellectual stimulation to generate, maintain, and disseminate knowledge.</li>
                    <li>Empower participants to meet the challenges of a collaborative and competitive globalized environment.</li>
                    <li>Synergize excellence amongst aspirants through world-class ambience.</li>
                    <li>Institute a culture of inclusiveness and provide wide access to higher education opportunities.</li>
                    <li>Foster sustainable environmental attitude.</li>
                    <li>Initiate trends which impact global higher education policies and practices.</li>
                    <li>We treasure our ethos and our character.</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<script>
(function () {
    var tabs = document.querySelectorAll('#vmTabs .vm-tab');
    var panels = document.querySelectorAll('.vm-panel-wrap .vm-panel');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('active'); t.setAttribute('aria-selected', 'false'); });
            panels.forEach(function (p) { p.classList.remove('active'); });
            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');
            document.getElementById(tab.dataset.target).classList.add('active');
        });
    });
})();
</script>

<!-- ═══════════════════════════════════════════════════════
     MEET THE LEADERSHIP
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-white position-relative" id="leadership">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">UNIVERSITY GOVERNANCE</span>
            <h2 class="section-title">Meet the <span>Leadership</span></h2>
            <p class="text-muted mx-auto" style="max-width:720px; font-size:0.95rem;">
                Guided by distinguished academicians, visionary administrators, and eminent mentors steering SRK University's academic excellence and institutional integrity.
            </p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <!-- 1. Chancellor -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 leadership-card-v2 reveal">
                    <div class="leadership-card-v2__badge">Statutory Head</div>
                    <div class="leadership-card-v2__photo-wrap">
                        <img src="<?php echo BASE_URL; ?>assets/uploads/2026/08/chancellor.jpeg"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                             alt="<?php echo sanitize(getSetting('chancellor_name', 'Mrs. Janak Kapoor')); ?>"
                             class="leadership-card-v2__img">
                    </div>
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <h4 class="h5 fw-bold text-navy mb-1"><?php echo sanitize(getSetting('chancellor_name', 'Mrs. Janak Kapoor')); ?></h4>
                        <span class="text-danger small fw-bold mb-2 d-block"><?php echo sanitize(getSetting('chancellor_title', 'Hon\'ble Chancellor')); ?></span>
                        <p class="text-muted small mb-3 flex-grow-1" style="line-height:1.65;">
                            Apex presiding authority, guiding university convocations, and upholding the noble legacy of Dr. Sarvepalli Radhakrishnan.
                        </p>
                        <div class="mt-auto pt-2 border-top">
                            <a href="<?php echo BASE_URL; ?>chancellor-message.php" class="btn btn-sm btn-outline-danger w-100 rounded-pill">
                                <i class="fas fa-crown me-1"></i> Chancellor's Desk
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Vice Chancellor -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 leadership-card-v2 reveal">
                    <div class="leadership-card-v2__badge bg-maroon">Academic Executive</div>
                    <div class="leadership-card-v2__photo-wrap leadership-card-v2__photo-wrap--icon">
                        <div class="leadership-icon-avatar">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <h4 class="h5 fw-bold text-navy mb-1"><?php echo sanitize(getSetting('vc_name', 'Ms. Priyanka Jaiswal')); ?></h4>
                        <span class="text-danger small fw-bold mb-2 d-block"><?php echo sanitize(getSetting('vc_title', 'Vice Chancellor')); ?></span>
                        <p class="text-muted small mb-3 flex-grow-1" style="line-height:1.65;">
                            Leading academic affairs, curriculum innovation under NEP 2020, national accreditations, and interdisciplinary research excellence.
                        </p>
                        <div class="mt-auto pt-2 border-top">
                            <a href="<?php echo BASE_URL; ?>vice-chancellor-message.php" class="btn btn-sm btn-outline-danger w-100 rounded-pill">
                                <i class="fas fa-comment-dots me-1"></i> VC's Message
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Chairman & Founder -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 leadership-card-v2 reveal">
                    <div class="leadership-card-v2__badge bg-gold text-navy">Founder &amp; Patron</div>
                    <div class="leadership-card-v2__photo-wrap leadership-card-v2__photo-wrap--icon">
                        <div class="leadership-icon-avatar bg-gold-soft text-navy">
                            <i class="fas fa-crown"></i>
                        </div>
                    </div>
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <h4 class="h5 fw-bold text-navy mb-1"><?php echo sanitize(getSetting('chairman_name', 'Dr. Sunil Kapoor')); ?></h4>
                        <span class="text-danger small fw-bold mb-2 d-block"><?php echo sanitize(getSetting('chairman_title', 'Chairman &amp; Chief Patron')); ?></span>
                        <p class="text-muted small mb-3 flex-grow-1" style="line-height:1.65;">
                            Visionary founder of RKDF Group since 1995, building accessible healthcare and multidisciplinary education across Central India.
                        </p>
                        <div class="mt-auto pt-2 border-top">
                            <a href="#chairman-story" class="btn btn-sm btn-outline-navy w-100 rounded-pill">
                                <i class="fas fa-book-reader me-1"></i> Chairman's Story
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Registrar -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 leadership-card-v2 reveal">
                    <div class="leadership-card-v2__badge bg-navy">Administration</div>
                    <div class="leadership-card-v2__photo-wrap leadership-card-v2__photo-wrap--icon">
                        <div class="leadership-icon-avatar bg-navy-soft text-navy">
                            <i class="fas fa-id-card"></i>
                        </div>
                    </div>
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <h4 class="h5 fw-bold text-navy mb-1"><?php echo sanitize(getSetting('registrar_name', 'Dr. S.S. Pawar')); ?></h4>
                        <span class="text-danger small fw-bold mb-2 d-block"><?php echo sanitize(getSetting('registrar_title', 'Registrar &amp; Member Secretary')); ?></span>
                        <p class="text-muted small mb-3 flex-grow-1" style="line-height:1.65;">
                            Custodian of university seal and records, overseeing administrative operations, statutory councils, and regulatory compliances.
                        </p>
                        <div class="mt-auto pt-2 border-top">
                            <a href="<?php echo BASE_URL; ?>board-members.php" class="btn btn-sm btn-outline-secondary w-100 rounded-pill">
                                <i class="fas fa-users-cog me-1"></i> View Secretariat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     APEX BOARDS & ALL COMMITTEES SHOWCASE
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream position-relative" id="all-committees">
    <span id="board-management-showcase" style="position:absolute; top:-70px;"></span>
    <div class="container-xl py-3">
        <div class="row align-items-center mb-4 g-3">
            <div class="col-12 col-md-8">
                <span class="section-subtitle">STATUTORY APEX GOVERNANCE &amp; COMMITTEES</span>
                <h2 class="section-title mb-2">Apex Boards &amp; <span>All Committees</span></h2>
                <p class="text-muted mb-0" style="max-width:760px; font-size:0.95rem;">
                    Constituted under the statutory mandate of MP Niji Vishwavidyalaya Adhiniyam 2007, UGC regulations, and statutory bodies. Explore the apex executive organs, Board of Management, Board Members, and all statutory student welfare and redressal committees.
                </p>
            </div>
            <div class="col-12 col-md-4 text-md-end">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                    <a href="<?php echo BASE_URL; ?>board-members.php" class="btn btn-maroon rounded-pill px-3 py-2 shadow-sm">
                        <i class="fas fa-users-cog me-1"></i> Board Members
                    </a>
                    <a href="<?php echo BASE_URL; ?>board-of-management.php" class="btn btn-navy text-white rounded-pill px-3 py-2 shadow-sm">
                        <i class="fas fa-landmark me-1"></i> Board of Management
                    </a>
                </div>
            </div>
        </div>

        <!-- Representation Highlights Grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-4">
            <div class="col">
                <div class="card h-100 p-3 border-0 shadow-sm rounded-3 bg-white">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-navy text-white d-flex align-items-center justify-content-center" style="width:48px; height:48px; font-size:1.2rem; flex-shrink:0;">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-navy mb-0">Sponsoring Body</h6>
                            <span class="text-muted small">RKDF Education Society</span>
                        </div>
                    </div>
                    <p class="text-muted small mt-2 mb-0" style="line-height:1.5;">Nominees providing institutional resource planning, endowment governance, and development oversight.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-3 border-0 shadow-sm rounded-3 bg-white">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-maroon text-white d-flex align-items-center justify-content-center" style="width:48px; height:48px; font-size:1.2rem; flex-shrink:0;">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-navy mb-0">Eminent Academics</h6>
                            <span class="text-muted small">Senior Faculty &amp; Deans</span>
                        </div>
                    </div>
                    <p class="text-muted small mt-2 mb-0" style="line-height:1.5;">Distinguished professors shaping curriculum design, NEP 2020 alignments, and doctoral research review.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-3 border-0 shadow-sm rounded-3 bg-white">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center" style="width:48px; height:48px; font-size:1.2rem; flex-shrink:0;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-navy mb-0">Industry &amp; Admin</h6>
                            <span class="text-muted small">Corporate Experts</span>
                        </div>
                    </div>
                    <p class="text-muted small mt-2 mb-0" style="line-height:1.5;">External industry stalwarts steering collaborative MoUs, corporate recruitment, and incubation.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-3 border-0 shadow-sm rounded-3 bg-white">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:48px; height:48px; font-size:1.2rem; flex-shrink:0;">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-navy mb-0">Statutory Secretariat</h6>
                            <span class="text-muted small">Registrar's Office</span>
                        </div>
                    </div>
                    <p class="text-muted small mt-2 mb-0" style="line-height:1.5;">Ensuring total compliance with UGC, MPPURC, regulatory councils, and statutory record audit.</p>
                </div>
            </div>
        </div>

        <!-- Featured Members Strip -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white reveal mb-4">
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg-8">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <span class="badge bg-danger text-white px-3 py-1 rounded-pill small fw-bold">Apex Statutory Governance</span>
                        <span class="text-muted small"><i class="fas fa-calendar-check me-1 text-primary"></i> Academic Year 2026-27</span>
                    </div>
                    <h5 class="fw-bold text-navy mb-1">Board of Management &amp; Governing Body Directory</h5>
                    <p class="text-muted small mb-0">
                        Explore complete details of university board members, statutory executive functions, regulatory mandates, and gazette notifications.
                    </p>
                </div>
                <div class="col-12 col-lg-4 text-lg-end">
                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                        <a href="<?php echo BASE_URL; ?>board-members.php" class="btn btn-maroon px-3 py-2 rounded-pill">
                            <i class="fas fa-id-badge me-1"></i> View Board Members
                        </a>
                        <a href="<?php echo BASE_URL; ?>board-of-management.php" class="btn btn-outline-navy px-3 py-2 rounded-pill">
                            <i class="fas fa-landmark me-1"></i> Board of Management
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Statutory Committees Grid -->
        <div class="mt-4 pt-2">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                <div>
                    <span class="badge bg-warning text-dark px-3 py-1 rounded-pill small fw-bold mb-1">Mandatory Statutory Bodies</span>
                    <h4 class="fw-bold text-navy mb-0">University Statutory Committees &amp; Cells</h4>
                </div>
                <a href="<?php echo BASE_URL; ?>grievance.php" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1 mt-2 mt-sm-0">
                    <i class="fas fa-balance-scale me-1"></i> Online Grievance Portal
                </a>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                <!-- 1. Student Grievance -->
                <div class="col">
                    <div class="card h-100 p-3 border-0 shadow-sm rounded-3 bg-white">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width:42px; height:42px; font-size:1.1rem; flex-shrink:0;">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-navy mb-1">Student Grievance Committee</h6>
                                <p class="text-muted small mb-2" style="font-size:0.84rem; line-height:1.4;">Dedicated redressal mechanism for academic, administrative, and student life queries.</p>
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <a href="<?php echo BASE_URL; ?>document/student-grievance-committee" class="text-danger small fw-semibold text-decoration-none">
                                        <i class="fas fa-file-pdf me-1"></i> View Committee
                                    </a>
                                    <span class="text-muted small">&middot;</span>
                                    <a href="<?php echo BASE_URL; ?>grievance.php" class="text-navy small fw-semibold text-decoration-none">
                                        <i class="fas fa-paper-plane me-1"></i> Lodge Grievance
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Anti Ragging -->
                <div class="col">
                    <div class="card h-100 p-3 border-0 shadow-sm rounded-3 bg-white">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center" style="width:42px; height:42px; font-size:1.1rem; flex-shrink:0;">
                                <i class="fas fa-hand-paper"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-navy mb-1">Anti-Ragging Committee</h6>
                                <p class="text-muted small mb-2" style="font-size:0.84rem; line-height:1.4;">Strict zero-tolerance policy against ragging with 24x7 squad monitoring and helpline.</p>
                                <a href="<?php echo BASE_URL; ?>document/anti-ragging" class="text-danger small fw-semibold text-decoration-none">
                                    <i class="fas fa-file-pdf me-1"></i> Constitution &amp; Guidelines
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Internal Complaints Committee (Women Grievance) -->
                <div class="col">
                    <div class="card h-100 p-3 border-0 shadow-sm rounded-3 bg-white">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-maroon text-white d-flex align-items-center justify-content-center" style="width:42px; height:42px; font-size:1.1rem; flex-shrink:0;">
                                <i class="fas fa-female"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-navy mb-1">Women Grievance / ICC</h6>
                                <p class="text-muted small mb-2" style="font-size:0.84rem; line-height:1.4;">Constituted as per POSH Act 2013 ensuring safety and gender dignity of women on campus.</p>
                                <a href="<?php echo BASE_URL; ?>document/women-grievance-committee" class="text-danger small fw-semibold text-decoration-none">
                                    <i class="fas fa-file-pdf me-1"></i> Members &amp; SOP
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. OBC & Minority Committee -->
                <div class="col">
                    <div class="card h-100 p-3 border-0 shadow-sm rounded-3 bg-white">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-navy text-white d-flex align-items-center justify-content-center" style="width:42px; height:42px; font-size:1.1rem; flex-shrink:0;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-navy mb-1">OBC &amp; Minority Committee</h6>
                                <p class="text-muted small mb-2" style="font-size:0.84rem; line-height:1.4;">Empowerment, scholarship awareness, and academic handholding for minority &amp; OBC students.</p>
                                <a href="<?php echo BASE_URL; ?>document/obc-minority" class="text-danger small fw-semibold text-decoration-none">
                                    <i class="fas fa-file-pdf me-1"></i> Notification &amp; Members
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. SC & ST Grievance Committee -->
                <div class="col">
                    <div class="card h-100 p-3 border-0 shadow-sm rounded-3 bg-white">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:42px; height:42px; font-size:1.1rem; flex-shrink:0;">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-navy mb-1">SC &amp; ST Grievance Committee</h6>
                                <p class="text-muted small mb-2" style="font-size:0.84rem; line-height:1.4;">Safeguarding constitutional rights, welfare schemes, and non-discrimination on premises.</p>
                                <a href="<?php echo BASE_URL; ?>document/sc-st-grievance-committee" class="text-danger small fw-semibold text-decoration-none">
                                    <i class="fas fa-file-pdf me-1"></i> Committee Notification
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Equal Opportunity Cell -->
                <div class="col">
                    <div class="card h-100 p-3 border-0 shadow-sm rounded-3 bg-white">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center" style="width:42px; height:42px; font-size:1.1rem; flex-shrink:0;">
                                <i class="fas fa-universal-access"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-navy mb-1">Equal Opportunity Cell</h6>
                                <p class="text-muted small mb-2" style="font-size:0.84rem; line-height:1.4;">Ensuring barrier-free campus access, assistive tools, and equal growth opportunities for all.</p>
                                <a href="<?php echo BASE_URL; ?>document/equal-opportunity-cell" class="text-danger small fw-semibold text-decoration-none">
                                    <i class="fas fa-file-pdf me-1"></i> Cell Details &amp; Mandate
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- WHY CHOOSE SRK UNIVERSITY -->
<section class="py-5" id="why">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">WHY SRKU</span>
            <h2 class="section-title">Why Choose <span>SRK University?</span></h2>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">01</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Multidisciplinary Education</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">We offer over 50 diverse programmes spanning Medical, Dental, Nursing, Engineering, Management, Law, Commerce, Agriculture, Science, and Humanities. Students choose courses aligned with their aspirations and the National Education Policy 2020.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">02</div>
                    <h4 class="h5 fw-bold text-navy mb-2">State-of-the-Art Infrastructure</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">Our lush green campus spans a cosmopolitan setting with modern laboratories, interactive learning spaces, high-tech medical facilities, and libraries equipped with the latest technology and resources.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">03</div>
                    <h4 class="h5 fw-bold text-navy mb-2">NAAC-Graded Excellence</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">SRK University is NAAC-accredited, ensuring quality education meets international standards. Our commitment to continuous improvement and academic rigor sets us apart from other private universities in Bhopal.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">04</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Industry &amp; Research Partnerships</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">We foster strong collaborations with leading industries for internships, placements, and research initiatives, ensuring students gain hands-on experience and are job-ready upon graduation.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">05</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Diverse Student Community</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">Our campus welcomes students from all corners of India, creating a multicultural environment that enriches learning and promotes cross-cultural understanding.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">06</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Holistic Student Development</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">At SRK University, students grow beyond academics through sports, cultural activities, leadership programmes, innovation, and community engagement, building confidence, teamwork, and essential life skills for future success.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RECOGNITIONS / ACCREDITATION -->
<section class="py-5 bg-cream" id="accred">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">RECOGNITIONS</span>
            <h2 class="section-title">Accredited. <span>Recognized.</span> Trusted.</h2>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4 reveal">
                    <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.5rem;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">UGC</h3>
                    <p class="text-muted small mb-0">Recognized under Section 2(f) of the UGC Act, 1956.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4 reveal">
                    <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.5rem;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">NAAC A+</h3>
                    <p class="text-muted small mb-0">Accredited by the National Assessment and Accreditation Council.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4 reveal">
                    <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.5rem;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">AICTE</h3>
                    <p class="text-muted small mb-0">All technical programmes approved by the All India Council for Technical Education.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4 reveal">
                    <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.5rem;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">PCI &amp; INC</h3>
                    <p class="text-muted small mb-0">Pharmacy and Nursing programmes approved by the respective national councils.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CAMPUS GALLERY -->
<?php
$aboutGalleryImages = [
    ['path' => 'assets/uploads/2026/08/welcome-srku-campus.jpeg', 'alt' => 'SRK University Main Building'],
    ['path' => 'assets/uploads/2026/08/srku-main-gate.jpeg', 'alt' => 'SRK University Main Gate'],
    ['path' => 'assets/uploads/2026/08/srku-academic-block.jpeg', 'alt' => 'SRK University Academic Block'],
    ['path' => 'assets/uploads/2026/08/srku-rkdf-building.jpeg', 'alt' => 'RKDF Group Campus Building'],
    ['path' => 'assets/uploads/2026/08/srku-campus-block.jpeg', 'alt' => 'SRK University Campus Block'],
    ['path' => 'assets/uploads/2026/07/Gallary-slider-07.webp', 'alt' => 'Students in the University Library'],
    ['path' => 'assets/uploads/2026/07/Gallary-slider-06.webp', 'alt' => 'Clinical Training at SRK University'],
    ['path' => 'assets/uploads/2026/07/Gallary-slider-10.webp', 'alt' => 'SRK University Faculty Group'],
    ['path' => 'assets/uploads/2026/07/5.png', 'alt' => 'Student Life at SRK University']
];
?>
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-maroon), var(--srku-navy));">
    <div class="container-xl py-2 reveal">
        <span class="section-subtitle text-warning">CAMPUS GALLERY</span>
        <h2 class="fw-bold mb-0">A Glimpse Into Life at SRK University</h2>
    </div>
</section>
<section class="auto-gallery" id="gallery">
    <div class="auto-gallery__viewport" id="aboutGalleryViewport">
        <div class="auto-gallery__track" id="aboutGalleryTrack">
            <?php foreach ($aboutGalleryImages as $image): ?>
                <div class="auto-gallery__item">
                    <img src="<?php echo BASE_URL . sanitize($image['path']); ?>"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         alt="<?php echo sanitize($image['alt']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="auto-gallery__dots" id="aboutGalleryDots"></div>
    <div class="text-center mt-4">
        <a href="<?php echo BASE_URL; ?>gallery.php?category=Campus" class="btn btn-srku-gold">
            <i class="fas fa-images me-2"></i>View More Photos
        </a>
    </div>
</section>
<script>
(function () {
    var track = document.getElementById('aboutGalleryTrack');
    var viewport = document.getElementById('aboutGalleryViewport');
    var dotsWrap = document.getElementById('aboutGalleryDots');
    if (!track || !viewport || !dotsWrap) return;

    var originalItems = Array.prototype.slice.call(track.children);
    var total = originalItems.length;
    var index = 0;
    var dots = [];
    var timer;

    originalItems.slice(0, Math.min(4, total)).forEach(function (item) {
        track.appendChild(item.cloneNode(true));
    });

    function setPosition(withTransition) {
        var itemWidth = track.children[0].getBoundingClientRect().width;
        var styles = getComputedStyle(track);
        var gap = parseFloat(styles.columnGap || styles.gap || 0);
        track.style.transition = withTransition === false ? 'none' : '';
        track.style.transform = 'translateX(-' + (index * (itemWidth + gap)) + 'px)';
    }

    function updateDots() {
        dots.forEach(function (dot, dotIndex) {
            var active = dotIndex === (index % total);
            dot.classList.toggle('active', active);
            dot.setAttribute('aria-current', active ? 'true' : 'false');
        });
    }

    function goTo(nextIndex) {
        index = nextIndex;
        setPosition(true);
        updateDots();
    }

    function next() {
        index++;
        setPosition(true);
        updateDots();
        if (index >= total) {
            window.setTimeout(function () {
                index = 0;
                setPosition(false);
                updateDots();
            }, 600);
        }
    }

    function startAutoScroll() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        window.clearInterval(timer);
        timer = window.setInterval(next, 3000);
    }

    originalItems.forEach(function (_, dotIndex) {
        var dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'auto-gallery__dot' + (dotIndex === 0 ? ' active' : '');
        dot.setAttribute('aria-label', 'Show gallery photo ' + (dotIndex + 1));
        dot.setAttribute('aria-current', dotIndex === 0 ? 'true' : 'false');
        dot.addEventListener('click', function () {
            goTo(dotIndex);
            startAutoScroll();
        });
        dotsWrap.appendChild(dot);
        dots.push(dot);
    });

    viewport.addEventListener('mouseenter', function () { window.clearInterval(timer); });
    viewport.addEventListener('mouseleave', startAutoScroll);
    window.addEventListener('resize', function () { setPosition(false); });

    setPosition(false);
    startAutoScroll();
})();
</script>

<!-- FAQ -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-maroon), var(--srku-navy));">
    <div class="container-xl py-2">
        <span class="section-subtitle text-warning">FAQS</span>
        <h2 class="fw-bold mb-4">Answers before you ask.</h2>
        <div class="accordion mx-auto reveal" id="aboutFaq" style="max-width:760px;">
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#aboutFaq1" aria-expanded="true" aria-controls="aboutFaq1">
                        When was SRK University established?
                    </button>
                </h3>
                <div id="aboutFaq1" class="accordion-collapse collapse show" data-bs-parent="#aboutFaq">
                    <div class="accordion-body text-start">
                        SRK University, Bhopal, was established under the Madhya Pradesh Niji Vishwavidyalaya (Sthapana Avam Sanchalan) Adhiniyam 2007, as amended by the Dwitiya Sanshodhan Adhiniyam 2014, and is sponsored by RKDF Education Society, Bhopal.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#aboutFaq2" aria-expanded="false" aria-controls="aboutFaq2">
                        Which regulatory bodies recognise SRK University?
                    </button>
                </h3>
                <div id="aboutFaq2" class="accordion-collapse collapse" data-bs-parent="#aboutFaq">
                    <div class="accordion-body text-start">
                        We are recognised by the UGC (Section 2(f)), AICTE, NMC, DCI, PCI, INC, and CCH &amp; NCISM, ensuring our programmes meet national academic and professional standards.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#aboutFaq3" aria-expanded="false" aria-controls="aboutFaq3">
                        What makes SRK University different from other private universities?
                    </button>
                </h3>
                <div id="aboutFaq3" class="accordion-collapse collapse" data-bs-parent="#aboutFaq">
                    <div class="accordion-body text-start">
                        Our multidisciplinary campus, NAAC-graded excellence, modern infrastructure, and strong industry and research partnerships set us apart, offering students a well-rounded and future-ready education.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-2 reveal">
        <h2 class="fw-bold mb-4">Ready to write your chapter<br>at SRK University?</h2>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku-gold px-4 py-2">Apply Now</a>
            <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku-outline px-4 py-2">Schedule a Visit</a>
            <a href="tel:07554700983" class="btn btn-srku-outline px-4 py-2">Talk to Counsellor</a>
        </div>
    </div>
</section>

<script src="<?php echo BASE_URL; ?>assets/js/reveal.js" defer></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
