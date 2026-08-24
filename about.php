<?php
$pageTitle = "About Us - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════════════ -->
<section class="about-hero-clean text-white py-5 position-relative" style="background: linear-gradient(135deg, #0b152d 0%, #16233f 45%, #630809 100%) !important; color: #ffffff !important;">
    <div class="container-xl position-relative z-2">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-warning"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">About SRKU</li>
            </ol>
        </nav>
        <span class="about-hero-tag" style="display: inline-flex; align-items: center; gap: 6px; background: rgba(229, 169, 59, 0.16) !important; color: #ffcc00 !important; border: 1px solid rgba(229, 169, 59, 0.38) !important; font-size: 0.76rem; font-weight: 700; padding: 5px 14px; border-radius: 30px; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 1rem;"><i class="fas fa-university me-1"></i> INSTITUTIONAL OVERVIEW</span>
        <h1 class="fw-bold display-6 mb-3 text-white" style="max-width:860px; line-height: 1.3;">Discover SRK University &ndash; Bhopal's Premier Multidisciplinary Private University</h1>
        <p class="mb-4 text-white-50" style="max-width:780px; line-height:1.8; font-size: 1.02rem;">
            Welcome to Sarvepalli Radhakrishnan University (SRKU), one of Madhya Pradesh's apex private universities. Named after Dr. Sarvepalli Radhakrishnan, India's First Vice President, our institution embodies excellence, innovation, and holistic education across 26 constituent units.
        </p>
        <div class="d-flex flex-wrap gap-3">
            <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn-hero-yellow">Apply Now</a>
            <a href="<?php echo BASE_URL; ?>board-of-management.php" class="btn-hero-outline">Meet the Leadership</a>
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
    ['icon' => 'fa-award', 'num' => '31<sup>st</sup>', 'lbl' => 'Year of Excellence'],
    ['icon' => 'fa-user-graduate', 'num' => '20,000+', 'lbl' => 'Students'],
    ['icon' => 'fa-briefcase', 'num' => '35,000+', 'lbl' => 'Placements'],
    ['icon' => 'fa-handshake', 'num' => '300+', 'lbl' => 'Industry Linkages'],
    ['icon' => 'fa-users', 'num' => '1,10,000+', 'lbl' => 'Alumni'],
    ['icon' => 'fa-chalkboard-teacher', 'num' => '1,000+', 'lbl' => 'Faculty'],
    ['icon' => 'fa-lightbulb', 'num' => '160+', 'lbl' => 'Patents'],
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
                <p class="vm-panel__quote">&ldquo;Learn about Education that helps Society&rdquo;</p>
                <p class="vm-panel__text">
                    Sarvepalli Radhakrishnan University is an academic fraternity of individuals dedicated to the motto of &ldquo;Learn about Education that helps Society&rdquo;. To emerge as a World-Class University in creating and disseminating knowledge, and providing students a unique learning experience in Science, Technology, Medicine, Management and other areas of life that will best serve the world and betterment of society. To create a knowledge-based society with scientific temper, team spirit, and dignity of labour to face global competitive challenges.
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
