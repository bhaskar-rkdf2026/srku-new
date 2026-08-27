<?php
$pageTitle = "Sarvepalli Radhakrishnan University (SRKU) Bhopal | Admissions 2026-27 | UGC Approved Private University in MP";
$pageDesc = "Sarvepalli Radhakrishnan University (SRKU), Bhopal is a premier UGC-recognized multidisciplinary private university in Madhya Pradesh offering 120+ UG, PG, and Ph.D. programmes in Medical, Engineering, Pharmacy, Nursing, Law, Agriculture & Management.";
$pageKeywords = "Sarvepalli Radhakrishnan University, SRKU Bhopal, SRK University, Admissions 2026-27, Best Private University in MP, UGC Approved University Bhopal, MBBS Admission Bhopal, BTech College Bhopal, Pharmacy College MP, RKDF Group";
$activeNav = "home";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$tickerText = getSetting('ticker_text', 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for Engineering, Pharmacy, Nursing, Management & Medicine | 94% Placement Record');
$totalLabs = getSetting('total_labs', '42+');
$placementRecord = getSetting('placement_record', '94%');
$highestPackage = getSetting('highest_package', '12 LPA');
$recruitingPartners = getSetting('recruiting_partners', '120+');
$totalAlumni = getSetting('total_alumni', '15,000+');
$heroTitle = getSetting('hero_title', 'SRK University, Bhopal');
$heroSubtitle = getSetting('hero_subtitle', 'UGC-Recognized University in MP');
$heroDesc = getSetting('hero_desc', 'Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership. If you are looking for the best placement university in MP, our rigorous research, multi-disciplinary collaboration, and industry-aligned pedagogy deliver unmatched career growth.');
$heroVideo = getSetting('hero_video_url', 'assets/images/concept2-hero.mp4');
$heroFallbackImg = getSetting('hero_fallback_image', 'assets/uploads/2026/08/srku-rkdf-building.jpeg');
$heroVideoSrc = resolveMediaUrl($heroVideo, 'assets/images/concept2-hero.mp4');
$heroFallbackPoster = resolveMediaUrl($heroFallbackImg, 'assets/uploads/2026/08/srku-rkdf-building.jpeg');

$welcomeSubtitle = getSetting('welcome_subtitle', 'WELCOME TO SRK UNIVERSITY');
$welcomeTitle = getSetting('welcome_title', 'Committed Towards Your Better Future Through Academic Excellence');
$welcomeBody1 = getSetting('welcome_body_1', 'The SRK University is a multidisciplinary university known for its high standards in teaching and research, and attracts eminent scholars to its faculty across the academic spectrum.');
$welcomeBody2 = getSetting('welcome_body_2', 'The group was established in 1995 under the flagship of the RKDF Group. Ever since its inception, a strong commitment to excellence in teaching and research has made the group a role-model and path-setter for other institutions. Its rich academic tradition has always attracted the most talented students, who later go on to make important contributions to society.');
$welcomePhoto = getSetting('welcome_photo', 'assets/uploads/2026/08/welcome-srku-campus.jpeg');
$welcomePhotoSrc = resolveMediaUrl($welcomePhoto, 'assets/uploads/2026/08/welcome-srku-campus.jpeg');

$chancellorName = getSetting('chancellor_name', 'Mrs. Janak Kapoor');
$chancellorTitle = getSetting('chancellor_title', 'Chancellor');
$chancellorPhoto = getSetting('chancellor_photo', 'assets/uploads/2026/08/chancellor.jpeg');
$chancellorPhotoSrc = resolveMediaUrl($chancellorPhoto, 'assets/uploads/2026/08/chancellor.jpeg');
$chancellorHeading = getSetting('chancellor_heading', 'A Legacy of Excellence, A Vision for Tomorrow');
$chancellorMsg = getSetting('chancellor_msg', 'It is a matter of great joy that the notification for the establishment of Sarvepalli Radhakrishnan University, Bhopal, has been issued by the State Government.');
$chancellorMsg2 = getSetting('chancellor_msg2', "In order to maintain quality in the field of higher education in the state, it is an important responsibility of private universities, alongside government universities, to bring about change in research and exploration. It is hoped that Sarvepalli Radhakrishnan University will, in the future, deliver unprecedented performance on quality standards and establish itself as the state's foremost institution of education.");

$vcName = getSetting('vc_name', 'Ms. Priyanka Jaiswal');
$vcTitle = getSetting('vc_title', 'Vice Chancellor');
$vcPhoto = getSetting('vc_photo', 'assets/uploads/2026/07/ruchichaubey.webp');
$vcPhotoSrc = resolveMediaUrl($vcPhoto, 'assets/uploads/2026/07/ruchichaubey.webp');
$vcHeading = getSetting('vc_heading', 'Pioneering Excellence, Empowering Future Leaders');
$vcMsg = getSetting('vc_msg', 'At SRK University, our mission is to transform ambitious learners into visionary global leaders through outcome-based education and cutting-edge research.');
$vcMsg2 = getSetting('vc_msg2', 'We foster innovation, high-impact research, and multi-disciplinary excellence. Our state-of-the-art infrastructure and faculty mentorship ensure every graduate is prepared for global careers.');

// Handle Form Submission for Enquiry
$enquirySuccess = false;
$enquiryErr = '';
$enquiryMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_enquiry'])) {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['course'] ?? '',
        $_POST['message'] ?? '',
        'Homepage Admission Section',
        $_POST['father_name'] ?? '',
        $_POST['city'] ?? '',
        $_POST['state'] ?? ''
    );
    if ($res['success']) {
        $enquirySuccess = true;
        $enquiryMsg = $res['message'];
    } else {
        $enquiryErr = $res['error'];
    }
}
?>

<!-- ═══════════════════════════════════════════════════════
     HERO SECTION — 100% FULLSCREEN HTML5 VIDEO & FALLBACK POSTER
═══════════════════════════════════════════════════════ -->
<section class="hero-section position-relative" style="background: #0b1120 url('<?php echo $heroFallbackPoster; ?>') center/cover no-repeat;">

    <video class="hero-bg-video" id="heroBgVideo" autoplay muted loop playsinline preload="auto" poster="<?php echo $heroFallbackPoster; ?>">
        <source src="<?php echo $heroVideoSrc; ?>" type="video/mp4">
        <!-- Direct Fallback Image if Video Cannot Play -->
        <img src="<?php echo $heroFallbackPoster; ?>" alt="<?php echo sanitize($heroTitle); ?>" class="hero-bg-video object-fit-cover">
    </video>

    <div class="hero-overlay"></div>

    <script>
    (function() {
        function initHeroVideo() {
            var v = document.getElementById('heroBgVideo');
            if (!v) return;
            v.muted = true;
            v.defaultMuted = true;
            v.playsInline = true;
            var playPromise = v.play();
            if (playPromise !== undefined) {
                playPromise.catch(function(err) {
                    var startPlayback = function() {
                        v.play().catch(function(){});
                        ['click', 'touchstart', 'scroll', 'keydown', 'mousemove'].forEach(function(e) {
                            window.removeEventListener(e, startPlayback);
                        });
                    };
                    ['click', 'touchstart', 'scroll', 'keydown', 'mousemove'].forEach(function(e) {
                        window.addEventListener(e, startPlayback, { passive: true, once: true });
                    });
                });
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initHeroVideo);
        } else {
            initHeroVideo();
        }
    })();
    </script>

    <div class="container-fluid px-4 px-lg-5 position-relative z-3">
        <div class="hero-content px-0">
            <h1 class="hero-h1">
                <?php echo sanitize($heroTitle); ?><br>
                <span class="gold-line"><?php echo sanitize($heroSubtitle); ?></span>
            </h1>
            <p class="hero-desc my-3">
                <?php echo sanitize($heroDesc); ?>
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="#apply" class="btn-hero-yellow">Apply Now</a>
                <a href="<?php echo BASE_URL; ?>courses.php" class="btn-hero-outline">Explore Programmes</a>
            </div>
        </div>
    </div>

    <!-- Hero Floating Stats Stack (Uniform Flex Container) -->
    <div class="hero-stats-floating d-none d-xl-flex">
        <!-- Stat Card 1 — White Glass -->
        <div class="hero-stat-card hero-stat-card-white">
            <div class="icon-box">
                <i class="fas fa-microscope"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-num mb-0"><?php echo sanitize($totalLabs); ?></h3>
                <p class="stat-lbl mb-0">HIGH-TECH LABS</p>
            </div>
        </div>

        <!-- Stat Card 2 — Brand Red -->
        <div class="hero-stat-card hero-stat-card-red">
            <div class="icon-box">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-num mb-0"><?php echo sanitize($placementRecord); ?></h3>
                <p class="stat-lbl mb-0">PLACEMENT RECORD</p>
            </div>
        </div>
    </div>

    <!-- Live ticker pinned to bottom of hero -->
    <?php $tickerNews = getNews(null, 10); ?>
    <div class="hero-ticker">
        <div class="hero-ticker-label"><i class="fas fa-bolt me-1"></i> LIVE UPDATES</div>
        <div class="hero-ticker-track">
            <span class="hero-ticker-content">
                <?php if (!empty($tickerNews)): ?>
                    <?php foreach ($tickerNews as $tn): ?>
                        <a href="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo (int)$tn['id']; ?>" class="ticker-news-link">
                            <span class="badge bg-danger me-1 small px-2 py-0.5"><?php echo sanitize($tn['category'] ?? 'Notice'); ?></span>
                            <?php echo sanitize($tn['title']); ?>
                        </a>
                        <span class="ticker-separator">&nbsp;&nbsp;&bull;&nbsp;&nbsp;</span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo sanitize($tickerText); ?> &nbsp;&bull;&nbsp;
                    Highest Package: <?php echo sanitize($highestPackage); ?> &nbsp;&bull;&nbsp;
                    <?php echo sanitize($recruitingPartners); ?> Corporate Recruitment Partners &nbsp;&bull;&nbsp;
                    UGC Recognized &amp; AICTE Approved Premier University in Madhya Pradesh &nbsp;&bull;&nbsp;
                <?php endif; ?>
            </span>
        </div>
    </div>

</section>

<!-- ═══════════════════════════════════════════════════════
     STATS STRIP (Bootstrap Row)
═══════════════════════════════════════════════════════ -->
<div class="stats-strip py-2">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-5 g-0 text-center">
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($totalLabs); ?></div>
                <div class="stat-txt">High-Tech Labs</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($placementRecord); ?></div>
                <div class="stat-txt">Placement Record</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($recruitingPartners); ?></div>
                <div class="stat-txt">Corporate Recruiters</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">15,000+</div>
                <div class="stat-txt">Global Alumni</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">25+</div>
                <div class="stat-txt">Years of Excellence</div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     WELCOME SECTION (Bootstrap 2-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            
            <div class="col-12 col-lg-6">
                <span class="section-subtitle"><?php echo sanitize($welcomeSubtitle); ?></span>
                <h2 class="section-title mb-3"><?php echo $welcomeTitle; ?></h2>
                <p class="text-dark mb-3" style="line-height:1.8; font-size:0.95rem;">
                    <?php echo $welcomeBody1; ?>
                </p>
                <p class="text-muted mb-4" style="line-height:1.8; font-size:0.93rem;">
                    <?php echo $welcomeBody2; ?>
                </p>
                <div class="d-flex gap-3">
                    <a href="<?php echo BASE_URL; ?>about.php" class="btn btn-srku"><i class="fas fa-arrow-right me-1"></i> Read More</a>
                    <a href="<?php echo BASE_URL; ?>why-srk.php" class="btn btn-srku-outline-maroon"><span class="btn-icon-badge"><i class="fas fa-star"></i></span> Why Choose SRKU</a>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="position-relative">
                    <img src="<?php echo $welcomePhotoSrc; ?>"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/08/welcome-srku-campus.jpeg';"
                         alt="SRKU Main Campus" class="welcome-img">
                    <div class="row g-2 mt-3 text-center">
                        <div class="col-4">
                            <div class="welcome-badge"><strong><?php echo sanitize($totalLabs); ?></strong><small>HIGH-TECH LABS</small></div>
                        </div>
                        <div class="col-4">
                            <div class="welcome-badge"><strong><?php echo sanitize($placementRecord); ?></strong><small>Placement Rate</small></div>
                        </div>
                        <div class="col-4">
                            <div class="welcome-badge"><strong>2026-27</strong><small>Admissions Open</small></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     STATUTORY APPROVALS & CONSTITUENT LOGOS CAROUSEL (After Welcome)
═══════════════════════════════════════════════════════ -->
<section class="py-4 border-top border-bottom bg-light overflow-hidden">
    <div class="container-fluid px-3 px-lg-5 mb-3" style="max-width: 1560px;">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-xl-nowrap overflow-x-auto pb-1" style="scrollbar-width: none; -ms-overflow-style: none;">
            <!-- Stacked Heading -->
            <div class="d-flex flex-column text-nowrap flex-shrink-0">
                <div>
                    <span class="badge bg-danger text-white px-2 py-1 rounded-pill fw-bold" style="font-size: 0.68rem; letter-spacing: 0.5px;"><i class="fas fa-shield-alt me-1"></i> RECOGNITIONS</span>
                </div>
                <span class="fw-bold text-navy small mt-1">Approved &amp; Recognized by:</span>
            </div>

            <!-- All 11 Apex Councils in ONE Single Row -->
            <div class="d-flex align-items-center gap-2 flex-nowrap overflow-x-auto flex-grow-1 justify-content-start justify-content-xl-center" style="scrollbar-width: none; -ms-overflow-style: none;">
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> UGC</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> NMC</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> NCISM</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> NCH</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> NDC</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> PCI</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> INC</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> MPPMC</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> AICTE</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> BCI</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> MPPURC</span>
            </div>

            <!-- Link to details -->
            <a href="<?php echo BASE_URL; ?>accreditation.php" class="small fw-bold text-danger text-nowrap text-decoration-none flex-shrink-0 hover-underline ms-auto">
                View All Accreditations <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Infinite Smooth Scrolling Constituent Institutes Seals Carousel -->
    <div class="constituent-carousel-container pt-3 border-top position-relative">
        <div class="constituent-marquee-track">
            <?php
            $sealsList = [
                ['name' => 'RKDF Medical College & Research Centre', 'img' => 'logo-rkdf-medical.png', 'slug' => 'rkdf-medical-college-hospital-research-center-2014'],
                ['name' => 'SRK College of Ayurveda Hospital', 'img' => 'logo-srk-ayurveda.png', 'slug' => 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-center-2021'],
                ['name' => 'RKDF Homoeopathic Medical College', 'img' => 'logo-rkdf-homoeopathy.png', 'slug' => 'rkdf-homoeopathic-medical-college-hospital-research-center-2000'],
                ['name' => 'RKDF Dental College & Research Centre', 'img' => 'logo-rkdf-dental.png', 'slug' => 'rkdf-dental-college-research-center-2003'],
                ['name' => 'RKDF College of Pharmacy (1995)', 'img' => 'logo-rkdf-pharmacy.png', 'slug' => 'rkdf-college-of-pharmacy-1995'],
                ['name' => 'RKDF College of Nursing (2003)', 'img' => 'logo-rkdf-nursing.png', 'slug' => 'rkdf-college-of-nursing-2003'],
                ['name' => 'SRK College of Allied & Healthcare', 'img' => 'logo-allied-healthcare.png', 'slug' => 'department-of-allied-health-care-sciences'],
                ['name' => 'RKDF Institute of Science & Technology', 'img' => 'logo-rkdf-science-tech.png', 'slug' => 'rkdf-institute-of-science-technology'],
                ['name' => 'Sarvepalli Radhakrishnan College of Law', 'img' => 'logo-srk-law.png', 'slug' => 'sarvepalli-radhakrishnan-college-of-law'],
                ['name' => 'RKDF Institute of Business Management', 'img' => 'logo-rkdf-management.png', 'slug' => 'rkdf-institute-of-business-management'],
                ['name' => 'Faculty of Agriculture, SRKU', 'img' => 'logo-srk-agriculture.png', 'slug' => 'faculty-of-agriculture']
            ];
            // Render 2 sets for seamless infinite loop
            $loopSeals = array_merge($sealsList, $sealsList);
            foreach ($loopSeals as $s):
            ?>
                <a href="<?php echo BASE_URL; ?>departments.php" class="seal-item text-decoration-none" title="<?php echo $s['name']; ?>">
                    <div class="seal-card bg-white p-2 rounded-4 shadow-xs border d-flex align-items-center gap-2">
                        <img src="<?php echo BASE_URL; ?>assets/images/constituent-logos/<?php echo $s['img']; ?>" alt="<?php echo $s['name']; ?>" class="seal-img flex-shrink-0" style="width: 58px; height: 58px; object-fit: contain;">
                        <div class="seal-info pe-2">
                            <span class="d-block fw-bold text-navy text-nowrap" style="font-size: 0.82rem;"><?php echo $s['name']; ?></span>
                            <span class="small text-muted" style="font-size: 0.72rem;">Constituent Institute</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.constituent-carousel-container {
    overflow: hidden;
    white-space: nowrap;
    width: 100%;
    position: relative;
}
.constituent-marquee-track {
    display: flex;
    gap: 16px;
    width: max-content;
    animation: constituentScroll 32s linear infinite;
}
.constituent-marquee-track:hover {
    animation-play-state: paused;
}
.seal-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}
.seal-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 18px rgba(15, 30, 59, 0.12) !important;
    border-color: #DC2626 !important;
}
@keyframes constituentScroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}
</style>

<!-- ═══════════════════════════════════════════════════════
     EXPLORE PROGRAMMES SECTION (Bootstrap 4-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream">
    <div class="container-xl py-3">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-2">
            <div>
                <span class="section-subtitle">CONSTITUENT UNITS</span>
                <h2 class="section-title mb-0">A Guide to the University's <span>Constituent Units</span></h2>
            </div>
            <a href="<?php echo BASE_URL; ?>departments.php" class="btn-card-apply fs-6">View all Constituent Units <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php
            $topUnits = $pdo->query("SELECT * FROM departments WHERE status = 'active' ORDER BY established_year ASC, id ASC LIMIT 8")->fetchAll();
            if (empty($topUnits)) {
                $topUnits = $pdo->query("SELECT * FROM departments ORDER BY id ASC LIMIT 8")->fetchAll();
            }
            foreach ($topUnits as $u):
                $uImg = $u['image'] ?: 'assets/uploads/2026/07/001.webp';
                $uImgSrc = (strpos($uImg, 'http') === 0) ? $uImg : BASE_URL . $uImg;
                $uDesc = !empty($u['description']) ? strip_tags($u['description']) : 'Premier academic and research constituent unit at SRK University.';
                if (mb_strlen($uDesc) > 95) {
                    $uDesc = mb_substr($uDesc, 0, 92) . '...';
                }
            ?>
                <div class="col">
                    <div class="prog-card d-flex flex-column h-100">
                        <img src="<?php echo $uImgSrc; ?>" class="prog-img" alt="<?php echo sanitize($u['name']); ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                        <div class="prog-body d-flex flex-column flex-grow-1">
                            <h3 class="prog-title mb-2">
                                <?php echo sanitize($u['name']); ?>
                                <?php if (!empty($u['established_year'])): ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-bold ms-1" style="font-size:0.75rem;"><?php echo sanitize($u['established_year']); ?></span>
                                <?php endif; ?>
                            </h3>
                            <p class="prog-desc text-muted small mb-3"><?php echo sanitize($uDesc); ?></p>
                            <a href="<?php echo BASE_URL; ?>department-detail.php?slug=<?php echo urlencode($u['slug']); ?>" class="btn-card-apply mt-auto">Explore &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     PROMINENT INSTITUTES / FACULTIES (Bootstrap Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-4">
            <span class="section-subtitle">WHY CHOOSE SRKU</span>
            <h2 class="section-title">Foundations of Academic <span>Excellence</span> in Central India</h2>
            <p class="text-muted small mb-0">Discover why we are consistently ranked among the top engineering colleges in MP and premier management hubs.</p>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-science-and-technology" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-cogs"></i></div><div class="faculty-info"><h4>Faculty of Engineering</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-medical-college" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-stethoscope"></i></div><div class="faculty-info"><h4>Faculty of Medicine</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-management" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-chart-bar"></i></div><div class="faculty-info"><h4>Business &amp; Management</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=department-of-paramedical-sciences" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-user-md"></i></div><div class="faculty-info"><h4>Paramedical Sciences</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=sarvepalli-radhakrishnan-college-of-law" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-balance-scale"></i></div><div class="faculty-info"><h4>Law &amp; Governance</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-science" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-atom"></i></div><div class="faculty-info"><h4>Allied Science &amp; Humanities</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-agriculture" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-seedling"></i></div><div class="faculty-info"><h4>Faculty of Agriculture</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-computer-application" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-laptop-code"></i></div><div class="faculty-info"><h4>Computer Application</h4></div></div></a></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ADMISSION PATHWAYS (UG / PG / PhD / Diploma)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-2">
            <div>
                <span class="section-subtitle">COURSES &amp; PROGRAMMES</span>
                <h2 class="section-title mb-0">How to Get Admission in <span>SRK University</span>, Bhopal?</h2>
                <p class="text-muted small mb-0">Choose your trajectory from over 140+ meticulously designed programmes and find the pathway that fits your goals.</p>
            </div>
            <a href="<?php echo BASE_URL; ?>courses.php" class="btn-card-apply fs-6">View all 140+ programmes <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-user-graduate"></i></div>
                    <h3>UG</h3>
                    <p>B.Tech, BCA, BBA, B.Pharm, BA LL.B, MBBS &amp; more foundation degree programmes.</p>
                </div>
            </div>
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-user-tie"></i></div>
                    <h3>PG</h3>
                    <p>M.Tech, MBA, MCA, M.Pharm, LL.M &amp; specialized postgraduate degrees.</p>
                </div>
            </div>
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-microscope"></i></div>
                    <h3>PHD</h3>
                    <p>Doctoral Research across Engineering, Pharmacy, Management &amp; Sciences.</p>
                </div>
            </div>
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-certificate"></i></div>
                    <h3>Diploma &amp; Certificate</h3>
                    <p>Professional Development and short-term certification programmes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CHANCELLOR'S MESSAGE SECTION (Luxury Theme Design)
═══════════════════════════════════════════════════════ -->
<section class="chancellor-desk-section py-5 position-relative overflow-hidden">
    <div class="container-xl py-lg-4">
        <div class="row align-items-center g-4 g-lg-5">
            
            <!-- Left: Framed Portrait & Name Plate -->
            <div class="col-12 col-lg-5">
                <div class="chancellor-portrait-wrap position-relative">
                    <div class="chancellor-photo-frame shadow-lg">
                        <img src="<?php echo $chancellorPhotoSrc; ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/08/chancellor.jpeg';"
                             alt="<?php echo sanitize($chancellorName); ?>, Chancellor of SRK University, Bhopal"
                             class="chancellor-photo img-fluid">
                    </div>
                    
                    <!-- Floating Official Designation Badge -->
                    <div class="chancellor-badge-card shadow-lg">
                        <div class="d-flex align-items-center gap-3">
                            <div class="chancellor-badge-icon">
                                <i class="fas fa-university"></i>
                            </div>
                            <div>
                                <h4 class="chancellor-badge-name mb-0"><?php echo sanitize($chancellorName); ?></h4>
                                <span class="chancellor-badge-role"><?php echo sanitize($chancellorTitle); ?>, SRK University</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Visionary Statement & Accreditations -->
            <div class="col-12 col-lg-7">
                <div class="chancellor-content ps-lg-3">
                    <span class="section-subtitle">
                        <i class="fas fa-quote-left text-danger me-1"></i> CHANCELLOR&rsquo;S DESK
                    </span>
                    <h2 class="section-title mb-3">
                        <?php echo $chancellorHeading; ?>
                    </h2>
                    
                    <div class="chancellor-quote-lead mb-3">
                        <p class="mb-0"><?php echo sanitize($chancellorMsg); ?></p>
                    </div>
                    
                    <p class="text-muted mb-4" style="line-height: 1.85; font-size: 0.96rem;">
                        <?php echo $chancellorMsg2; ?>
                    </p>

                    <!-- Call to Action Buttons -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        <a href="<?php echo BASE_URL; ?>chancellor-message.php" class="btn btn-danger rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center gap-2 shadow-sm">
                            <i class="fas fa-crown text-warning"></i> Read Full Chancellor's Message &rarr;
                        </a>
                        <a href="<?php echo BASE_URL; ?>vice-chancellor-message.php" class="btn btn-outline-dark rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                            <i class="fas fa-user-tie text-danger"></i> VC's Message
                        </a>
                    </div>

                    <!-- Trust & Accreditations Pill Row -->
                    <div class="d-flex flex-wrap gap-3 pt-3 border-top">
                        <div class="chancellor-accred-box">
                            <div class="accred-logo"><i class="fas fa-check-circle text-danger"></i> UGC</div>
                            <span class="accred-sub">Recognized</span>
                        </div>
                        <div class="chancellor-accred-box">
                            <div class="accred-logo"><i class="fas fa-award text-warning"></i> NAAC</div>
                            <span class="accred-sub">A+ Grade</span>
                        </div>
                        <div class="chancellor-accred-box">
                            <div class="accred-logo"><i class="fas fa-shield-alt text-success"></i> AICTE</div>
                            <span class="accred-sub">Approved</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CAMPUS FACILITIES (Bootstrap 3-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="text-center mb-4">
            <span class="section-subtitle">CAMPUS LIFE &amp; INFRASTRUCTURE</span>
            <h2 class="section-title">World-Class Campus <span>Facilities</span></h2>
            <p class="text-muted small">Equipped with state-of-the-art infrastructure for learning, living, and innovating.</p>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/library.webp" class="prog-img" alt="Library"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Central Digital Library</h3><p class="prog-desc mb-0">50,000+ books, international journals, e-books, and 24/7 digital resource access.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp" class="prog-img" alt="Labs"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">42+ Advanced Research Labs</h3><p class="prog-desc mb-0">High-performance computing, Robotics, Pharmaceutics testing, and AI innovation units.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Operation-Theatre.webp" class="prog-img" alt="Lecture Halls"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Air-Conditioned Auditoriums</h3><p class="prog-desc mb-0">Smart audio-visual lecture halls hosting national seminars, workshops, and guest lectures.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/sports.webp" class="prog-img" alt="Sports"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Sports Complex &amp; Gymnasium</h3><p class="prog-desc mb-0">Cricket ground, basketball courts, indoor badminton arenas, and modern fitness gym.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/hostel.webp" class="prog-img" alt="Hostel"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Hostels &amp; Hygienic Dining</h3><p class="prog-desc mb-0">Secured hostels for boys &amp; girls with Wi-Fi, 24/7 security, and nutritious dining.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/INFRA-STRUCTURE-SRKU-05.webp" class="prog-img" alt="Healthcare"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Medical &amp; Healthcare Center</h3><p class="prog-desc mb-0">On-campus 750+ bed hospital providing round-the-clock emergency care, pharmacy, and check-ups.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     LABS DRIVING INDUSTRY INNOVATION
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-6 order-lg-2">
                <span class="section-subtitle">INNOVATION &amp; RESEARCH</span>
                <h2 class="section-title mb-3">Labs <span style="font-style:italic;">Driving</span> Industry Innovation.</h2>
                <div class="row row-cols-3 g-3 mb-4">
                    <div class="col"><div class="labs-stat-box"><span class="num">42+</span><span class="lbl">Active Clubs</span></div></div>
                    <div class="col"><div class="labs-stat-box"><span class="num">120+</span><span class="lbl">Patents Filed</span></div></div>
                    <div class="col"><div class="labs-stat-box"><span class="num">&#8377;12Cr</span><span class="lbl">Annual Grants</span></div></div>
                </div>
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.94rem;">
                    From AI/ML and IoT to biomedical instrumentation, our research labs are supported by industry partnerships and produce industry-ready innovations&mdash;not just research papers.
                </p>
                <a href="<?php echo BASE_URL; ?>research-innovation.php" class="btn btn-srku"><i class="fas fa-flask me-1"></i> Research &amp; Innovation</a>
            </div>
            <div class="col-12 col-lg-6 order-lg-1">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     alt="Labs Driving Industry Innovation" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     PLACEMENT & TOP RECRUITERS
═══════════════════════════════════════════════════════ -->
<section class="placement-v2">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">DISCOVER SUCCESS</span>
            <h2 class="section-title mb-0">A direct pipeline to <span>industry leadership</span></h2>
        </div>
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-6">
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.94rem;">
                    Our dedicated Corporate Relations Cell conducts year-round campus recruitment drives, soft skills training, mock interviews, and industry internships, connecting students to 500+ top national and global MNCs.
                </p>
                <div class="row row-cols-3 g-2 mb-4">
                    <div class="col"><div class="labs-stat-box labs-stat-box--sm"><span class="num">&#8377;42 LPA</span><span class="lbl">Highest Package</span></div></div>
                    <div class="col"><div class="labs-stat-box labs-stat-box--sm"><span class="num">500+</span><span class="lbl">Corporate Partners</span></div></div>
                    <div class="col"><div class="labs-stat-box labs-stat-box--sm"><span class="num">15,000+</span><span class="lbl">Alumni Leaders</span></div></div>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>placements.php" class="btn btn-srku"><i class="fas fa-chart-line me-1"></i> View Full Placement Report</a>
                    <a href="<?php echo BASE_URL; ?>placements.php" class="btn btn-srku-outline-maroon"><span class="btn-icon-badge"><i class="fas fa-users"></i></span> Explore Recruiters</a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="placement-v2__media placement-v2__media--compact">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/placement-hero-DCAhDTqD.jpg"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/graduates.webp';"
                         alt="Campus Placement">
                    <div class="placement-v2__badge">
                        <span class="placement-v2__badge-num">94%</span>
                        <span class="placement-v2__badge-lbl">Placement Record</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Recruiting Partners — infinite auto-scrolling logo marquee -->
    <?php
    $recruiterLogos = [
        ['file' => '1.webp', 'alt' => 'TATA'],
        ['file' => '2.webp', 'alt' => 'Infosys'],
        ['file' => '6.webp', 'alt' => 'Amazon'],
        ['file' => '4.webp', 'alt' => 'Wipro'],
        ['file' => '3.webp', 'alt' => 'Cognizant'],
        ['file' => '2.webp', 'alt' => 'Infosys'],
    ];
    ?>
    <div class="recruiter-marquee">
        <p class="recruiter-marquee__label">Our Recruiting Partners</p>
        <div class="recruiter-marquee__viewport">
            <div class="recruiter-marquee__track">
                <?php for ($r = 0; $r < 4; $r++): ?>
                    <?php foreach ($recruiterLogos as $logo): ?>
                        <div class="recruiter-marquee__item">
                            <img src="<?php echo BASE_URL . 'assets/uploads/2026/07/' . rawurlencode($logo['file']); ?>"
                                 alt="<?php echo sanitize($logo['alt']); ?>" loading="eager" decoding="async">
                        </div>
                    <?php endforeach; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     STUDENT LIFE AT SRK (matches live srku.edu.in design)
═══════════════════════════════════════════════════════ -->
<section class="student-life-v2">
    <div class="student-life-v2__inner">
        <p class="student-life-v2__eyebrow">Student Life at SRK</p>
        <h2 class="student-life-v2__title">Experience <em>an Unmatched University</em><br>Campus Life in Bhopal</h2>
        <p class="student-life-v2__desc">A campus that thinks, builds, and celebrates together.<br>200 lush acres, 120+ active student clubs, and 18 annual fests create an unforgettable student journey.</p>

        <div class="student-life-v2__row">
            <div class="student-life-v2__media">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/alumni-hero-TzGn9_DY-3.jpg"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     alt="Annual Cultural Fest at SRK University">
                <div class="student-life-v2__badge">
                    <span class="student-life-v2__badge-tag">Featured</span>
                    <span class="student-life-v2__badge-title">Annual Cultural Fest</span>
                </div>
            </div>
            <div class="student-life-v2__grid">
                <div class="student-life-v2__box student-life-v2__box--maroon">
                    <i class="fas fa-star"></i>
                    <h3>42+</h3>
                    <p>Active Clubs</p>
                </div>
                <div class="student-life-v2__box student-life-v2__box--gray">
                    <i class="fas fa-trophy"></i>
                    <h3>120+</h3>
                    <p>Sports</p>
                </div>
                <div class="student-life-v2__box student-life-v2__box--cream">
                    <i class="fas fa-bed"></i>
                    <h3>4,500+</h3>
                    <p>Hostel Beds</p>
                </div>
                <div class="student-life-v2__box student-life-v2__box--maroon">
                    <i class="fas fa-music"></i>
                    <h3>18</h3>
                    <p>Annual Fests</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     GALLERY SECTION (Bootstrap 5-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream">
    <div class="container-xl py-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="section-subtitle">CAMPUS LIFE</span>
                <h2 class="section-title mb-0">Life at <span>SRK University</span></h2>
            </div>
            <a href="<?php echo BASE_URL; ?>gallery.php" class="btn-card-apply">View Full Gallery &rarr;</a>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-2">
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-01.webp" class="gallery-img" alt="Gallery 1" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-03.webp" class="gallery-img" alt="Gallery 2" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-06.webp" class="gallery-img" alt="Gallery 3" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-07.webp" class="gallery-img" alt="Gallery 4" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-10.webp" class="gallery-img" alt="Gallery 5" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     INCUBATION & STARTUPS + LATEST NEWS
═══════════════════════════════════════════════════════ -->
<?php $incubationNews = getNews(null, 3); ?>
<section class="py-5 bg-cream">
    <div class="container-xl py-3">
        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-6">
                <div class="incubation-panel h-100">
                    <span class="incubation-panel__eyebrow">Incubation &amp; Startups</span>
                    <h2 class="incubation-panel__title">Build Your Venture On Campus.</h2>
                    <p class="incubation-panel__desc">The university has established an incubation center for promoting new ideas and startups in the region. The center will incubate business ideas with relevance and fitment to local expertise, uniqueness, and market demands. Initially, the center will provide training and support for startups related to handmade soaps &amp; sanitizers and mobile apps.</p>
                    <a href="<?php echo BASE_URL; ?>incubation-center.php" class="incubation-panel__btn">View More &rarr;</a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="latest-news-panel h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="latest-news-panel__eyebrow mb-0">Latest News &amp; Circulars</span>
                        <a href="<?php echo BASE_URL; ?>news.php" class="small text-danger fw-bold text-decoration-none">View All Notices &rarr;</a>
                    </div>
                    <?php if (!empty($incubationNews)): ?>
                        <?php foreach ($incubationNews as $n): ?>
                            <div class="latest-news-item">
                                <img src="<?php echo !empty($n['image_url']) ? BASE_URL . sanitize($n['image_url']) : BASE_URL . 'assets/uploads/2026/07/001.webp'; ?>"
                                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                     alt="<?php echo sanitize($n['title']); ?>">
                                <div class="latest-news-item__body">
                                    <h4><?php echo sanitize($n['title']); ?></h4>
                                    <span class="latest-news-item__date"><?php echo date('F j, Y', strtotime($n['publish_date'] ?: $n['created_at'])); ?></span>
                                    <a href="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo $n['id']; ?>">Read Circular &raquo;</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted small mb-0">No circulars published yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ADMISSION FORM SECTION (Bootstrap Maroon 2-col Form)
═══════════════════════════════════════════════════════ -->
<section class="enquiry-section py-5" id="apply">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            
            <div class="col-12 col-lg-5 text-white">
                <span class="section-subtitle text-warning">ADMISSION SESSION 2026-27</span>
                <h2 class="text-white fw-bold mb-3">Apply For <span class="text-warning">Admissions 2026</span></h2>
                <p class="text-white-50 mb-4" style="line-height:1.7;">
                    Fill out your details and our admission counselor will call you within 24 hours. Seats are limited — apply early!
                </p>
                <ul class="list-unstyled text-white-50 d-flex flex-column gap-2">
                    <li><i class="fas fa-check-circle text-warning me-2"></i> UGC Recognized &amp; AICTE/PCI Approved</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> 94% Campus Placement Record</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> Scholarship &amp; Fee Concessions Available</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> Modern On-Campus Hostels &amp; Transport</li>
                </ul>
            </div>

            <div class="col-12 col-lg-7">
                <div class="enquiry-form-box">
                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> Thank you! Your admission enquiry has been submitted successfully. Our team will contact you shortly.</div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger"><?php echo sanitize($enquiryErr); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>#apply" method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Your Name *</label>
                                <input type="text" name="name" class="form-control py-2" placeholder="Enter your full name" minlength="2" maxlength="80" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Father's Name</label>
                                <input type="text" name="father_name" class="form-control py-2" placeholder="Enter father's name" maxlength="80">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small mb-1">Courses</label>
                            <select name="course" class="form-select py-2">
                                <option value="">-- Please choose an option --</option>
                                <option>B.Tech Computer Science &amp; Engineering</option>
                                <option>B.Tech Artificial Intelligence &amp; Data Science</option>
                                <option>Bachelor of Pharmacy (B.Pharm)</option>
                                <option>Diploma in Pharmacy (D.Pharm)</option>
                                <option>MBA — Master of Business Administration</option>
                                <option>MCA — Master of Computer Applications</option>
                                <option>B.Sc. Nursing</option>
                                <option>LL.B — Bachelor of Laws</option>
                                <option>B.Sc. (Hons) Agriculture</option>
                                <option>BPT — Bachelor of Physiotherapy</option>
                                <option>Other University Programme</option>
                            </select>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Mail ID *</label>
                                <input type="email" name="email" class="form-control py-2" placeholder="yourname@gmail.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control py-2" placeholder="10-digit mobile number" pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">City</label>
                                <input type="text" name="city" class="form-control py-2" placeholder="Enter your city" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">State</label>
                                <input type="text" name="state" class="form-control py-2" placeholder="Enter your state" maxlength="100">
                            </div>
                        </div>
                        <button type="submit" name="submit_enquiry" class="btn btn-warning w-100 py-2 fw-bold text-dark">
                            <i class="fas fa-paper-plane me-1"></i> Submit
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     RECENT NEWS & BLOGS
═══════════════════════════════════════════════════════ -->
<?php $homeBlogs = getBlogs(null, 3); ?>
<?php if (!empty($homeBlogs)): ?>
<section class="py-5 bg-cream">
    <div class="container-xl py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-2">
            <div>
                <span class="section-subtitle">RECENT BLOGS &amp; ARTICLES</span>
                <h2 class="section-title mb-0">Insights &amp; Stories from <span>SRK University</span></h2>
            </div>
            <a href="<?php echo BASE_URL; ?>blogs.php" class="btn-card-apply fs-6">View All Articles <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($homeBlogs as $b): ?>
                <div class="col">
                    <div class="prog-card h-100 d-flex flex-column">
                        <img src="<?php echo !empty($b['image_url']) ? BASE_URL . sanitize($b['image_url']) : BASE_URL . 'assets/uploads/2026/07/001.webp'; ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                             class="prog-img" alt="<?php echo sanitize($b['title']); ?>">
                        <div class="prog-body d-flex flex-column flex-grow-1">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span class="badge bg-danger-subtle text-danger"><?php echo sanitize($b['category']); ?></span>
                                <span><i class="far fa-calendar-alt me-1"></i> <?php echo date('d M Y', strtotime($b['publish_date'] ?: $b['created_at'])); ?></span>
                            </div>
                            <h3 class="prog-title mt-2"><?php echo sanitize($b['title']); ?></h3>
                            <p class="prog-desc flex-grow-1"><?php 
                                $bdesc = !empty($b['short_description']) ? $b['short_description'] : strip_tags($b['content']);
                                echo substr($bdesc, 0, 110) . '...'; 
                            ?></p>
                            <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($b['slug'] ?: $b['id']); ?>" class="btn-card-apply mt-auto align-self-start">Read Article &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════
     TESTIMONIALS (matches live srku.edu.in design)
═══════════════════════════════════════════════════════ -->
<?php
$homeTestimonials = [
    [
        'name' => 'Ravi Gupta',
        'city' => 'Bhopal',
        'text' => 'Graduated from this university with valuable skills and experiences that have helped me succeed in my career. The alumni network is strong and supportive, and the career services office provided excellent guidance and resources to help me secure a job after graduation. I also appreciated the emphasis on real-world learning through internships and co-op programmes.',
    ],
    [
        'name' => 'Nitish Rai',
        'city' => 'Bhopal',
        'text' => "The professors at this university are some of the best in their fields, and they are genuinely passionate about teaching. I appreciated the diverse range of courses offered, and the opportunities to conduct research alongside faculty members. The university's commitment to community service and social responsibility also inspired me to get involved in volunteer work and make a positive impact on society.",
    ],
    [
        'name' => 'Manish Nigam',
        'city' => 'Bhopal',
        'text' => 'Attending this university was one of the best decisions I have made. The faculty and staff were incredibly supportive, and the campus provided a great environment for learning. I was able to participate in various extracurricular activities that helped me develop leadership skills and make new friends. I highly recommend this university to anyone who wants to receive a top-quality education in a welcoming community.',
    ],
];
?>
<section class="testimonial-v2">
    <div class="testimonial-v2__inner">
        <p class="testimonial-v2__eyebrow">Real Stories</p>
        <h2 class="testimonial-v2__title">What our <em>Students say</em> about the university</h2>

        <div class="testimonial-v2__carousel" id="testimonialCarousel">
            <?php foreach ($homeTestimonials as $i => $t): ?>
                <div class="testimonial-v2__slide<?php echo $i === 0 ? ' active' : ''; ?>">
                    <span class="testimonial-v2__avatar" aria-hidden="true"><i class="fas fa-user"></i></span>
                    <p class="testimonial-v2__text"><?php echo sanitize($t['text']); ?></p>
                    <p class="testimonial-v2__name"><?php echo sanitize($t['name']); ?></p>
                    <p class="testimonial-v2__city"><?php echo sanitize($t['city']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="testimonial-v2__dots" id="testimonialDots">
            <?php foreach ($homeTestimonials as $i => $t): ?>
                <span class="testimonial-v2__dot<?php echo $i === 0 ? ' active' : ''; ?>" data-index="<?php echo $i; ?>"></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<script>
(function () {
    var slides = document.querySelectorAll('#testimonialCarousel .testimonial-v2__slide');
    var dots = document.querySelectorAll('#testimonialDots .testimonial-v2__dot');
    if (!slides.length) return;
    var current = 0;

    function show(i) {
        slides.forEach(function (s, idx) { s.classList.toggle('active', idx === i); });
        dots.forEach(function (d, idx) { d.classList.toggle('active', idx === i); });
        current = i;
    }

    dots.forEach(function (d) {
        d.addEventListener('click', function () { show(parseInt(d.dataset.index, 10)); });
    });

    setInterval(function () {
        show((current + 1) % slides.length);
    }, 5000);
})();
</script>

<!-- ═══════════════════════════════════════════════════════
     EVENTS GALLERY (auto-scrolling, matches live srku.edu.in design)
═══════════════════════════════════════════════════════ -->
<?php
$eventsGalleryImages = [
    ['file' => 'Gallary-slider-10.webp', 'alt' => 'Faculty Group Event'],
    ['file' => 'Gallary-slider-07.webp', 'alt' => 'Library Session'],
    ['file' => 'Gallary-slider-06.webp', 'alt' => 'Clinical Training Event'],
    ['file' => 'Gallary-slider-03.webp', 'alt' => 'MRI Lab Tour'],
    ['file' => '2.png', 'alt' => 'Cultural Dance Event'],
    ['file' => 'Gallary-slider-01.webp', 'alt' => 'Hospital Ward Visit'],
    ['file' => '7.png', 'alt' => 'Award Ceremony'],
    ['file' => '6.png', 'alt' => 'University Event'],
    ['file' => '5.png', 'alt' => 'University Event'],
    ['file' => '4.png', 'alt' => 'University Event'],
    ['file' => 'welcome-srku-campus.jpeg', 'alt' => 'SRK University Main Building', 'month' => '08'],
    ['file' => 'srku-main-gate.jpeg', 'alt' => 'SRK University Main Gate', 'month' => '08'],
    ['file' => 'srku-academic-block.jpeg', 'alt' => 'SRK University Academic Block', 'month' => '08'],
    ['file' => 'srku-rkdf-building.jpeg', 'alt' => 'RKDF Group Campus Building', 'month' => '08'],
    ['file' => 'srku-campus-block.jpeg', 'alt' => 'SRK University Campus Block', 'month' => '08'],
];
?>
<section class="py-5">
    <div class="container-xl py-2 text-center">
        <span class="section-subtitle">OUR EVENTS GALLERY</span>
        <h2 class="section-title mb-4">Events <span>at SRK</span> University</h2>
    </div>
    <div class="auto-gallery__viewport" id="eventsGalleryViewport">
        <div class="auto-gallery__track auto-gallery__track--3up" id="eventsGalleryTrack">
            <?php foreach ($eventsGalleryImages as $img): ?>
                <div class="auto-gallery__item auto-gallery__item--3up">
                    <img src="<?php echo BASE_URL . 'assets/uploads/2026/' . ($img['month'] ?? '07') . '/' . rawurlencode($img['file']); ?>"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         alt="<?php echo sanitize($img['alt']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="auto-gallery__dots" id="eventsGalleryDots"></div>
</section>
<script>
(function () {
    var track = document.getElementById('eventsGalleryTrack');
    var viewport = document.getElementById('eventsGalleryViewport');
    var dotsWrap = document.getElementById('eventsGalleryDots');
    if (!track || !viewport || !dotsWrap) return;

    var originalItems = Array.prototype.slice.call(track.children);
    var total = originalItems.length;

    function perView() {
        var w = window.innerWidth;
        if (w < 576) return 1;
        if (w < 900) return 2;
        return 3;
    }

    var visible = perView();
    originalItems.slice(0, visible).forEach(function (node) {
        track.appendChild(node.cloneNode(true));
    });

    var index = 0;
    var dots = [];
    dotsWrap.innerHTML = '';
    for (var i = 0; i < total; i++) {
        var dot = document.createElement('span');
        dot.className = 'auto-gallery__dot' + (i === 0 ? ' active' : '');
        (function (idx) {
            dot.addEventListener('click', function () { goTo(idx); });
        })(i);
        dotsWrap.appendChild(dot);
        dots.push(dot);
    }

    function setPosition(withTransition) {
        var itemWidth = track.children[0].getBoundingClientRect().width;
        var gap = parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap || 0);
        track.style.transition = withTransition === false ? 'none' : '';
        track.style.transform = 'translateX(-' + (index * (itemWidth + gap)) + 'px)';
    }

    function updateDots() {
        dots.forEach(function (d, i) { d.classList.toggle('active', i === (index % total)); });
    }

    function goTo(i) {
        index = i;
        setPosition(true);
        updateDots();
    }

    function next() {
        index++;
        setPosition(true);
        updateDots();
        if (index >= total) {
            setTimeout(function () {
                index = 0;
                setPosition(false);
            }, 500);
        }
    }

    window.addEventListener('resize', function () {
        visible = perView();
        setPosition(false);
    });

    setPosition(false);
    setInterval(next, 2500);
})();
</script>

<!-- ═══════════════════════════════════════════════════════
     CTA BANNER
═══════════════════════════════════════════════════════ -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-dark));">
    <div class="container-xl py-2">
        <h2 class="fw-bold mb-2">Admissions Open for Academic Session 2026-27</h2>
        <p class="text-white-50 mb-4" style="font-size:1.05rem;">Take the first step towards a rewarding global career with SRK University Bhopal.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="#apply" class="btn btn-srku-gold px-4 py-2"><i class="fas fa-edit me-1"></i> Apply Now</a>
            <a href="tel:<?php echo preg_replace('/[^0-9]/', '', getSetting('helpline')); ?>" class="btn btn-srku-outline px-4 py-2"><i class="fas fa-phone-alt me-1"></i> Call Helpline</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
