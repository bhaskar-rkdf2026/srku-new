<?php
$pageTitle = "Board of Management & Governance | SRK University Bhopal";
$pageDesc = "Meet the distinguished Board of Management, Governing Body, and academic leadership guiding Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = "SRKU Board of Management, University Leadership, SRKU Governance, Chancellor, Vice Chancellor Bhopal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';

$boardMembers = [
    ['name' => 'Shri. Ratnesh Jain', 'title' => 'Member (Sponsoring Body)'],
    ['name' => 'Dr. Amarjeet Singh', 'title' => 'Member (Sponsoring Body)'],
    ['name' => 'Dr. Aparna Paliwal', 'title' => 'Member'],
    ['name' => 'Dr. Vikram Singh', 'title' => 'Member'],
    ['name' => 'Mr. Santosh Negi', 'title' => 'Member'],
    ['name' => 'Dr. Neha Dubey', 'title' => 'Member'],
    ['name' => 'Dr. S.S. Pawar', 'title' => 'Member Secretary'],
];
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
                <li class="breadcrumb-item active text-white-50" aria-current="page">Board of Management</li>
            </ol>
        </nav>
        <span class="about-hero-v2__eyebrow"><i class="fas fa-star"></i> Est. 1995 &middot; RKDF Education Society</span>
        <h1 class="about-hero-v2__title" style="max-width:800px;">Fourteen schools, <span>one ecosystem.</span></h1>
        <p class="about-hero-v2__desc" style="max-width:760px;">
            From B.Tech and MBBS to MBA, LLM, and doctoral research &mdash; every program blends theory, industry immersion, and global exposure. Essays, field notes, and long-form research from students, faculty, and alumni &mdash; published weekly.
        </p>
        <div class="d-flex flex-wrap gap-3">
            <a href="#board-members" class="btn-hero-yellow">View Board Members</a>
            <a href="<?php echo BASE_URL; ?>about.php" class="btn-hero-outline">University Profile</a>
        </div>
    </div>
</section>

<!-- STATS STRIP -->
<div class="stats-strip py-2">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-5 g-0 text-center">
            <div class="col stat-box">
                <div class="stat-val">18,000+</div>
                <div class="stat-txt">Students</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">600+</div>
                <div class="stat-txt">Faculty</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">120+</div>
                <div class="stat-txt">Programs</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">1,400+</div>
                <div class="stat-txt">Research Papers</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">42+</div>
                <div class="stat-txt">Global Partners</div>
            </div>
        </div>
    </div>
</div>

<!-- CHAIRMAN STORY -->
<section class="py-5 bg-cream">
    <div class="container-xl py-3">
        <span class="section-subtitle">CHAIRMAN STORY</span>
        <h2 class="section-title mb-4">Shaping Future <span>Leaders Through</span> Education</h2>
        <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 reveal" style="border-left: 5px solid var(--srku-maroon) !important;">
            <div class="row align-items-center g-4">
                <div class="col-12 col-md-3 text-center">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:130px; height:130px; font-size:3.5rem; color:#adb5bd;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <i class="fas fa-quote-left text-warning fs-2 mb-2 d-block"></i>
                    <p class="text-muted mb-3" style="line-height:1.85; font-size:0.95rem;">
                        &ldquo;Education is the foundation of progress, empowering individuals with knowledge, values, and the confidence to shape a better future.&rdquo; At SRK University, our vision is to provide quality education that combines academic excellence with practical learning, innovation, and strong ethical values. We are committed to creating an environment where students can explore their potential, develop professional skills, and prepare themselves to meet the challenges of a rapidly changing world.
                        <br><br>
                        I welcome every student to SRK University and wish them a rewarding journey of learning, growth, and success.
                    </p>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <strong class="text-maroon fst-italic">Dr. A. K. Shrivastav</strong>
                        <span class="text-muted small">Chairman</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BOARD OF MANAGEMENT -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">OUR LEADERS</span>
            <h2 class="section-title">Board of <span>Management</span></h2>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            <?php foreach ($boardMembers as $m): ?>
                <div class="col">
                    <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4 reveal" style="background: var(--srku-cream);">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:90px; height:90px; font-size:2.2rem; color:#adb5bd;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4 class="h6 fw-bold text-navy mb-1"><?php echo sanitize($m['name']); ?></h4>
                        <p class="text-muted small mb-3"><?php echo sanitize($m['title']); ?></p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="board-social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="board-social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="board-social-icon" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CAMPUS GALLERY -->
<?php
$bomGalleryImages = [
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
    <div class="auto-gallery__viewport" id="bomGalleryViewport">
        <div class="auto-gallery__track" id="bomGalleryTrack">
            <?php foreach ($bomGalleryImages as $image): ?>
                <div class="auto-gallery__item">
                    <img src="<?php echo BASE_URL . sanitize($image['path']); ?>"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         alt="<?php echo sanitize($image['alt']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="auto-gallery__dots" id="bomGalleryDots"></div>
    <div class="text-center mt-4">
        <a href="<?php echo BASE_URL; ?>gallery.php?category=Campus" class="btn btn-srku-gold">
            <i class="fas fa-images me-2"></i>View More Photos
        </a>
    </div>
</section>
<script>
(function () {
    var track = document.getElementById('bomGalleryTrack');
    var viewport = document.getElementById('bomGalleryViewport');
    var dotsWrap = document.getElementById('bomGalleryDots');
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
        <div class="accordion mx-auto reveal" id="bomFaq" style="max-width:760px;">
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#bomFaq1" aria-expanded="true" aria-controls="bomFaq1">
                        What does SRK University stand for?
                    </button>
                </h3>
                <div id="bomFaq1" class="accordion-collapse collapse show" data-bs-parent="#bomFaq">
                    <div class="accordion-body text-start">
                        SRK University is named after Dr. Sarvepalli Radhakrishnan, India's First Vice President, a renowned philosopher and educator. We embody his ideals of intellectual excellence and humanistic education.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bomFaq2" aria-expanded="false" aria-controls="bomFaq2">
                        How does SRK University support diversity and inclusion?
                    </button>
                </h3>
                <div id="bomFaq2" class="accordion-collapse collapse" data-bs-parent="#bomFaq">
                    <div class="accordion-body text-start">
                        Our core value of tolerance and inclusivity means we actively recruit and support students from diverse backgrounds. We offer scholarships, mentorship, and campus organisations that celebrate cultural diversity.
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
