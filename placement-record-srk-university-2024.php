<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Placement Record | Sarvepalli Radhakrishnan University (SRKU) Bhopal";
$pageDesc = "Official Placement Records of Sarvepalli Radhakrishnan University (SRKU), Bhopal. Explore student placement selections at Accenture, TCS, John Deere, Hexaware, Procter & Gamble, Zensar, Adama, Mastek, GAIL and 120+ top MNCs.";
$pageKeywords = "SRKU Placement Record, Sarvepalli Radhakrishnan University Placements, Student Selections Bhopal, TCS, Accenture, Highest Package 12 LPA, Top Placement University MP";
$activeNav = "placements";
require_once __DIR__ . '/includes/header.php';

// Verified Real Student Placement Records from SRKU Official Records
$studentPlacements = [
    [
        'students' => ['Ms. Prakriti Srivastava'],
        'company'  => 'Accenture',
        'badge'    => 'Global IT Leader',
        'icon'     => 'fas fa-laptop-code text-primary',
        'color'    => '#4f46e5'
    ],
    [
        'students' => ['Mr. Amul Bisen'],
        'company'  => 'Adama',
        'badge'    => 'Agri-Business MNC',
        'icon'     => 'fas fa-seedling text-success',
        'color'    => '#16a34a'
    ],
    [
        'students' => ['Ms. Rashmi Priya'],
        'company'  => 'Zensar',
        'badge'    => 'Digital Solutions & Technology',
        'icon'     => 'fas fa-network-wired text-info',
        'color'    => '#0284c7'
    ],
    [
        'students' => ['Mr. Mrityunjay Kumar'],
        'company'  => 'Tata',
        'badge'    => 'Tata Conglomerate',
        'icon'     => 'fas fa-industry text-primary',
        'color'    => '#1d4ed8'
    ],
    [
        'students' => ['Ms. Aprajita Gokhale'],
        'company'  => 'Mastek',
        'badge'    => 'Enterprise Tech Solutions',
        'icon'     => 'fas fa-microchip text-danger',
        'color'    => '#dc2626'
    ],
    [
        'students' => ['Akash Kumar'],
        'company'  => 'Heleon',
        'badge'    => 'Specialty Engineering',
        'icon'     => 'fas fa-cogs text-warning',
        'color'    => '#d97706'
    ],
    [
        'students' => [
            'Ratindar Singh', 'Deepak Shewani', 'Shriya Mishra', 'Dolly Meena',
            'Pankaj Dongre', 'Ajay Yagik', 'Rahul Patle', 'Abhishek Maheshwari',
            'Raj Ranjan', 'Rupesh Ranjan'
        ],
        'company'  => 'Hexaware',
        'badge'    => '10 Students Selected • Hexaware Technologies',
        'icon'     => 'fas fa-server text-purple',
        'color'    => '#7c3aed'
    ],
    [
        'students' => ['Udit', 'Vijay Yagik', 'Amit Rajak'],
        'company'  => 'Sutherland',
        'badge'    => '3 Students Selected • Sutherland Global',
        'icon'     => 'fas fa-headset text-teal',
        'color'    => '#0d9488'
    ],
    [
        'students' => [
            'Abhishek Kumar', 'Amar Panday', 'Ritesh Kumar Upadhyay',
            'Mohd. Zayullah', 'Abhina Singh', 'Raja Ughode', 'Nirajan'
        ],
        'company'  => 'John Deere India Limited',
        'badge'    => '7 Students Selected • Heavy Machinery MNC',
        'icon'     => 'fas fa-tractor text-success',
        'color'    => '#15803d'
    ],
    [
        'students' => ['Aditya Bisaria'],
        'company'  => 'Procter & Gamble Health Ltd.',
        'badge'    => 'Healthcare & FMCG Giant',
        'icon'     => 'fas fa-heartbeat text-danger',
        'color'    => '#be123c'
    ],
    [
        'students' => ['Md. Arif'],
        'company'  => 'Tata Group of Company',
        'badge'    => 'Core Engineering & Operations',
        'icon'     => 'fas fa-cog text-primary',
        'color'    => '#2563eb'
    ],
    [
        'students' => ['Arun Kumar Yadav', 'Atul Tawar'],
        'company'  => 'IndiaMART InterMESH Ltd.',
        'badge'    => '2 Students Selected • B2B Marketplace',
        'icon'     => 'fas fa-store text-danger',
        'color'    => '#b91c1c'
    ],
    [
        'students' => ['Sourab Dhote'],
        'company'  => "Byju's",
        'badge'    => 'EdTech Leader',
        'icon'     => 'fas fa-graduation-cap text-purple',
        'color'    => '#6d28d9'
    ],
    [
        'students' => ['Nainy Baisakhiya'],
        'company'  => 'GAIL India Limited',
        'badge'    => 'Maharatna PSU of India',
        'icon'     => 'fas fa-burn text-warning',
        'color'    => '#b45309'
    ],
    [
        'students' => ['Amit Kumar'],
        'company'  => 'TATA Consultancy Services (TCS)',
        'badge'    => 'Global IT Consultancy',
        'icon'     => 'fas fa-code text-primary',
        'color'    => '#1e40af'
    ],
    [
        'students' => ['Abhishek Kumar Kushwah'],
        'company'  => 'TATA Consultancy Services (TCS)',
        'badge'    => 'Global IT Consultancy',
        'icon'     => 'fas fa-laptop text-primary',
        'color'    => '#1e40af'
    ]
];
?>

<style>
/* Placement Carousel & Marquee Styling */
.placement-banner-container {
    background: #0b1f44;
    border-radius: 20px;
    padding: 16px;
    box-shadow: 0 12px 36px rgba(11, 31, 68, 0.2);
    position: relative;
    overflow: hidden;
}

.placement-banner-img {
    width: 100%;
    height: 480px;
    object-fit: contain;
    background: #000;
    border-radius: 14px;
    transition: opacity 0.5s ease-in-out;
}

.placement-ticker-panel {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(11, 31, 68, 0.06);
    height: 512px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.ticker-header {
    background: linear-gradient(135deg, #991b1b, #dc2626);
    color: #fff;
    padding: 18px 24px;
}

.ticker-scroll-box {
    flex: 1;
    overflow-y: auto;
    padding: 18px;
    scroll-behavior: smooth;
}

.ticker-scroll-box::-webkit-scrollbar {
    width: 6px;
}
.ticker-scroll-box::-webkit-scrollbar-track {
    background: #f1f5f9;
}
.ticker-scroll-box::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.student-placement-item {
    background: #f8fafc;
    border-radius: 12px;
    border-left: 4px solid #dc2626;
    padding: 14px 16px;
    margin-bottom: 12px;
    transition: all 0.25s ease;
}
.student-placement-item:hover {
    background: #ffffff;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    transform: translateX(4px);
}

.stat-pill {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.25);
    padding: 8px 18px;
    border-radius: 50px;
    color: #fff;
    font-size: 0.9rem;
    font-weight: 600;
}
</style>

<!-- ═══════════════════════════════════════════════════════
     HERO BANNER
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
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>placements" class="text-decoration-none text-white-50">Placements</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Placement Record</li>
                    </ol>
                </nav>
                <span class="about-hero-v2__eyebrow"><i class="fas fa-award"></i> Industry Placements &amp; Corporate Success</span>
                <h1 class="about-hero-v2__title">SRK University <span>Placement Record</span></h1>
                <p class="about-hero-v2__desc">
                    Celebrating outstanding campus selections across Fortune 500 multinationals, technology conglomerates, pharmaceutical giants, and Indian Maharatna enterprises.
                </p>
                <div class="d-flex flex-wrap gap-2 pt-2">
                    <span class="stat-pill"><i class="fas fa-percent text-warning me-1"></i> 94.2% Placement Rate</span>
                    <span class="stat-pill"><i class="fas fa-money-bill-wave text-success me-1"></i> ₹12 LPA Highest Package</span>
                    <span class="stat-pill"><i class="fas fa-building text-info me-1"></i> 120+ Recruiting Partners</span>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-hero-v2__cards">
                    <div class="about-hero-v2__card about-hero-v2__card--float1">
                        <i class="fas fa-user-tie text-danger"></i>
                        <span class="num">1,500+</span>
                        <span class="lbl">Total Job Offers</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float2">
                        <i class="fas fa-briefcase text-warning"></i>
                        <span class="num">85+</span>
                        <span class="lbl">Drives Annually</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     FLAGSHIP DUAL SECTION: INTERACTIVE BANNER SLIDER + LIVE SELECTIONS TICKER
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-white position-relative">
    <div class="container-xl">
        <div class="row g-4 align-items-stretch">
            
            <!-- Left: Placement Drive Visual Banner Showcase -->
            <div class="col-12 col-lg-7">
                <div class="placement-banner-container h-100 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center justify-content-between px-2 pt-1 pb-3 text-white border-bottom border-secondary border-opacity-25">
                        <div class="d-flex align-items-center gap-2">
                            <span class="spinner-grow spinner-grow-sm text-danger" role="status"></span>
                            <span class="fw-bold tracking-wide small text-uppercase">On-Campus Placement Drives &amp; Offer Handover</span>
                        </div>
                        <div class="badge bg-danger rounded-pill px-3 py-1 font-monospace" id="sliderCounter">Photo 1 of 19</div>
                    </div>

                    <div class="position-relative my-auto py-2 text-center">
                        <img id="activePlacementImg" 
                             src="<?php echo BASE_URL; ?>assets/images/placements/placement1.jpg" 
                             alt="SRK University Campus Placement Drive" 
                             class="placement-banner-img shadow">

                        <!-- Nav Buttons -->
                        <button type="button" class="btn btn-dark bg-opacity-75 position-absolute start-0 top-50 translate-middle-y ms-2 rounded-circle shadow" style="width: 44px; height: 44px;" onclick="changeSlide(-1)">
                            <i class="fas fa-chevron-left text-white"></i>
                        </button>
                        <button type="button" class="btn btn-dark bg-opacity-75 position-absolute end-0 top-50 translate-middle-y me-2 rounded-circle shadow" style="width: 44px; height: 44px;" onclick="changeSlide(1)">
                            <i class="fas fa-chevron-right text-white"></i>
                        </button>
                    </div>

                    <!-- Slide controls & indicators -->
                    <div class="d-flex align-items-center justify-content-between pt-2 px-2 text-white-50 small">
                        <div>
                            <i class="fas fa-info-circle text-warning me-1"></i> Interactive Drive Gallery &bull; Autoplays every 4s
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-light rounded-pill px-3" id="playPauseBtn" onclick="togglePlayPause()">
                                <i class="fas fa-pause me-1"></i> Pause
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Real Student Selections Ticker & Directory -->
            <div class="col-12 col-lg-5">
                <div class="placement-ticker-panel">
                    <div class="ticker-header d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold mb-1"><i class="fas fa-user-check me-2"></i> Verified Placements</h5>
                            <span class="small text-white-50">Direct corporate recruitments across disciplines</span>
                        </div>
                        <span class="badge bg-white text-danger fw-bold px-3 py-2 rounded-pill shadow-sm">
                            <?php echo count($studentPlacements); ?> Drives
                        </span>
                    </div>

                    <div class="ticker-scroll-box" id="autoScrollBox">
                        <?php foreach ($studentPlacements as $item): ?>
                        <div class="student-placement-item border-start-0" style="border-left: 5px solid <?php echo $item['color']; ?> !important;">
                            <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
                                <h6 class="fw-bold text-navy mb-0">
                                    <i class="<?php echo $item['icon']; ?> me-1"></i>
                                    <?php echo $item['company']; ?>
                                </h6>
                                <span class="badge bg-light text-secondary rounded-pill border small">
                                    <?php echo count($item['students']); ?> Candidate<?php echo count($item['students']) > 1 ? 's' : ''; ?>
                                </span>
                            </div>
                            <div class="text-dark small fw-semibold mb-1">
                                <?php echo implode(', ', $item['students']); ?>
                            </div>
                            <div class="text-muted" style="font-size: 0.8rem;">
                                <i class="fas fa-shield-alt text-success me-1"></i> <?php echo $item['badge']; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="p-3 bg-light border-top text-center">
                        <a href="<?php echo BASE_URL; ?>tpo-director-message" class="btn btn-sm btn-danger fw-semibold rounded-pill px-4">
                            <i class="fas fa-envelope-open-text me-1"></i> Read Director T&amp;P Message
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     FULL STUDENT PLACEMENT DIRECTORY (FILTERABLE & SEARCHABLE)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold mb-2">
                <i class="fas fa-graduation-cap me-1"></i> Corporate Placement Roll of Honour
            </span>
            <h2 class="display-6 fw-bold text-navy">Distinguished Student Achievers</h2>
            <p class="text-muted lead fs-6">
                Complete directory of students placed in prestigious national and multinational corporations.
            </p>
        </div>

        <!-- Search Bar -->
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border">
                    <span class="input-group-text bg-white border-0 ps-4 text-muted"><i class="fas fa-search"></i></span>
                    <input type="text" id="placementSearch" class="form-control border-0 py-3 ps-2 shadow-none" placeholder="Search student name or recruiting company (e.g. TCS, Accenture, Prakriti, Hexaware)..." onkeyup="filterPlacements()">
                    <button class="btn btn-danger px-4 fw-semibold rounded-pill m-1" type="button" onclick="document.getElementById('placementSearch').value=''; filterPlacements();">Clear</button>
                </div>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="row g-4" id="placementCardsRow">
            <?php foreach ($studentPlacements as $idx => $item): ?>
            <div class="col-12 col-md-6 col-lg-4 placement-card-wrapper" data-text="<?php echo strtolower(implode(' ', $item['students']) . ' ' . $item['company']); ?>">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white hover-lift transition-all">
                    <div class="card-header bg-white border-bottom p-4 pb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge rounded-pill px-3 py-1 text-white fw-bold" style="background-color: <?php echo $item['color']; ?>;">
                                <i class="<?php echo $item['icon']; ?> me-1"></i> <?php echo $item['company']; ?>
                            </span>
                            <span class="text-muted small fw-semibold">Drive #<?php echo $idx + 1; ?></span>
                        </div>
                        <h5 class="fw-bold text-navy mb-0"><?php echo $item['company']; ?></h5>
                        <div class="text-muted small"><?php echo $item['badge']; ?></div>
                    </div>
                    <div class="card-body p-4 pt-3">
                        <div class="text-secondary small fw-semibold text-uppercase tracking-wider mb-2">Selected Candidates:</div>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($item['students'] as $sName): ?>
                            <li class="py-1 d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2 fs-6"></i>
                                <span class="fw-bold text-dark"><?php echo $sName; ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="card-footer bg-light border-0 p-3 px-4 d-flex justify-content-between align-items-center">
                        <span class="text-muted small"><i class="fas fa-map-marker-alt text-danger me-1"></i> On-Campus Selection</span>
                        <span class="badge bg-success-subtle text-success rounded-pill fw-semibold">Verified</span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     PROMINENT RECRUITERS STRIP
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-white border-top">
    <div class="container-xl">
        <div class="row align-items-center g-4 mb-4">
            <div class="col-lg-6">
                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold mb-2">
                    <i class="fas fa-handshake me-1"></i> Corporate Ecosystem
                </span>
                <h3 class="fw-bold text-navy">120+ Premier Recruiting Brands</h3>
                <p class="text-muted mb-0">
                    Industry titans collaborate with SRKU every academic session for campus hiring drives, tech bootcamps, and executive internships.
                </p>
            </div>
            <div class="col-lg-6 text-lg-end">
                <a href="<?php echo BASE_URL; ?>placements" class="btn btn-outline-danger rounded-pill px-4 fw-semibold me-2">
                    <i class="fas fa-building me-1"></i> Corporate Placements Overview
                </a>
                <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/placement-cell.pdf" target="_blank" class="btn btn-danger rounded-pill px-4 fw-semibold">
                    <i class="fas fa-download me-1"></i> Placement Brochure (PDF)
                </a>
            </div>
        </div>

        <!-- Marquee of Top Company Names -->
        <div class="p-4 bg-light rounded-4 shadow-sm border">
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3 text-center">
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">Accenture</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">TATA (TCS)</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">Infosys</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">Wipro</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">Hexaware</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">John Deere</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">P&amp;G Health</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">GAIL India</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">Zensar</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">Mastek</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">Sutherland</div></div>
                <div class="col"><div class="p-3 bg-white rounded-3 shadow-xs fw-bold text-navy border">IndiaMART</div></div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     QUICK LINKS FOOTER ROW
═══════════════════════════════════════════════════════ -->
<section class="py-4 bg-light border-top">
    <div class="container-xl">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-folder-open text-danger fs-4"></i>
                <div>
                    <strong class="text-navy">Related Placement &amp; Research Portals</strong>
                    <div class="text-muted small">Direct resources from the Central Training &amp; Research Cell</div>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="<?php echo BASE_URL; ?>tpo-director-message" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    <i class="fas fa-user-tie me-1"></i> Director Message
                </a>
                <a href="<?php echo BASE_URL; ?>assets/uploads/phd/Phd-Pursuing.pdf" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    <i class="fas fa-file-pdf text-danger me-1"></i> Ph. D. Pursuing (PDF)
                </a>
                <a href="<?php echo BASE_URL; ?>assets/uploads/phd/Phd-Completed.pdf" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    <i class="fas fa-file-pdf text-danger me-1"></i> Ph. D. Completed (PDF)
                </a>
                <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn btn-sm btn-danger rounded-pill px-3">
                    <i class="fas fa-paper-plane me-1"></i> Apply for 2026 Admissions
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Script for Interactive Placement Slider & Live Search -->
<script>
(function() {
    var totalSlides = 19;
    var currentSlide = 1;
    var isPlaying = true;
    var timer = null;
    var baseUrl = '<?php echo BASE_URL; ?>';

    var imgEl = document.getElementById('activePlacementImg');
    var counterEl = document.getElementById('sliderCounter');
    var playPauseBtn = document.getElementById('playPauseBtn');

    function updateSlide() {
        if (!imgEl) return;
        imgEl.style.opacity = '0.3';
        setTimeout(function() {
            imgEl.src = baseUrl + 'assets/images/placements/placement' + currentSlide + '.jpg';
            if (counterEl) counterEl.textContent = 'Photo ' + currentSlide + ' of ' + totalSlides;
            imgEl.style.opacity = '1';
        }, 200);
    }

    window.changeSlide = function(delta) {
        currentSlide += delta;
        if (currentSlide > totalSlides) currentSlide = 1;
        if (currentSlide < 1) currentSlide = totalSlides;
        updateSlide();
    };

    function startAutoPlay() {
        if (timer) clearInterval(timer);
        timer = setInterval(function() {
            changeSlide(1);
        }, 4000);
    }

    window.togglePlayPause = function() {
        if (isPlaying) {
            clearInterval(timer);
            isPlaying = false;
            if (playPauseBtn) playPauseBtn.innerHTML = '<i class="fas fa-play me-1"></i> Resume';
        } else {
            startAutoPlay();
            isPlaying = true;
            if (playPauseBtn) playPauseBtn.innerHTML = '<i class="fas fa-pause me-1"></i> Pause';
        }
    };

    startAutoPlay();

    // Auto-scroll ticker on hover pause
    var scrollBox = document.getElementById('autoScrollBox');
    var scrollInterval = null;
    if (scrollBox) {
        function runAutoScroll() {
            scrollInterval = setInterval(function() {
                if (scrollBox.scrollTop + scrollBox.clientHeight >= scrollBox.scrollHeight - 5) {
                    scrollBox.scrollTop = 0;
                } else {
                    scrollBox.scrollTop += 1;
                }
            }, 60);
        }
        runAutoScroll();
        scrollBox.addEventListener('mouseenter', function() { clearInterval(scrollInterval); });
        scrollBox.addEventListener('mouseleave', function() { runAutoScroll(); });
    }

    // Filter functionality
    window.filterPlacements = function() {
        var query = (document.getElementById('placementSearch').value || '').trim().toLowerCase();
        var cards = document.querySelectorAll('.placement-card-wrapper');
        cards.forEach(function(card) {
            var text = card.getAttribute('data-text') || '';
            if (!query || text.indexOf(query) !== -1) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    };
})();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
