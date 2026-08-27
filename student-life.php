<?php
$pageTitle = "Student Life & Campus Culture | Clubs, Sports & Festivals | SRKU Bhopal";
$pageDesc = "Experience student life at Sarvepalli Radhakrishnan University (SRKU), Bhopal: cultural festivals (Tarang), tech symposiums, sports leagues, student clubs and community activities.";
$pageKeywords = "SRKU Student Life, Campus Events Bhopal, University Clubs, Tarang Fest, Sports Facilities Bhopal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('student-life', 'Student Life & Campus Culture', 'Vibrant, Diverse, Inclusive & Energetic Campus Community'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5 mb-5">
            <div class="col-12 col-lg-6 reveal">
                <span class="section-subtitle">CAMPUS VIBRANCY</span>
                <h2 class="section-title mb-3">Beyond Academics: <span>A World of Opportunities</span></h2>
                <p class="text-dark mb-3" style="line-height:1.8; font-size:0.95rem;">
                    Life at Sarvepalli Radhakrishnan University is an exhilarating journey of personal growth, cultural celebration, athletic achievement, and lasting friendships. With students from all states across India and international backgrounds, the campus pulsates with diverse traditions and energetic youth power.
                </p>
                <p class="text-muted mb-4" style="line-height:1.8; font-size:0.93rem;">
                    From competitive hackathons and robotics competitions to musical concerts, drama fests, and inter-university sports tournaments, every day at SRKU brings exciting avenues to explore your passions.
                </p>
                <a href="<?php echo BASE_URL; ?>gallery.php" class="btn btn-srku"><i class="fas fa-images me-1"></i> View Campus Life Gallery</a>
            </div>
            <div class="col-12 col-lg-6 reveal">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-01.webp"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     alt="Student Life at SRKU" class="img-fluid rounded-4 border border-4 border-danger shadow">
            </div>
        </div>

        <!-- Student Life Highlights -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card reveal p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.6rem;">
                        <i class="fas fa-guitar"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">Tarang — Annual Cultural Fest</h3>
                    <p class="text-muted small mb-0" style="line-height:1.7;">
                        Three days of star-studded musical concerts, fashion shows, dance competitions, and theatrical performances with 10,000+ attendees.
                    </p>
                </div>
            </div>

            <div class="col">
                <div class="card reveal p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.6rem;">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">Inter-University Sports Meet</h3>
                    <p class="text-muted small mb-0" style="line-height:1.7;">
                        Annual tournaments across Cricket, Football, Basketball, Volleyball, Badminton, Table Tennis, and Track &amp; Field athletics.
                    </p>
                </div>
            </div>

            <div class="col">
                <div class="card reveal p-4 border-0 shadow-sm rounded-4 h-100">
                    <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.6rem;">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">NSS &amp; Community Service</h3>
                    <p class="text-muted small mb-0" style="line-height:1.7;">
                        Active National Service Scheme units organizing blood donation camps, free health checkups, tree plantation, and rural literacy drives.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<script src="<?php echo BASE_URL; ?>assets/js/reveal.js" defer></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
