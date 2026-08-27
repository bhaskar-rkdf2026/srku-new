<?php
require_once __DIR__ . '/includes/functions.php';

$chancellorName = getSetting('chancellor_name', 'Mrs. Janak Kapoor');
$chancellorTitle = getSetting('chancellor_title', 'Chancellor');
$chancellorPhoto = getSetting('chancellor_photo', 'assets/uploads/2026/08/chancellor.jpeg');
$chancellorPhotoSrc = (strpos($chancellorPhoto, 'http') === 0) ? $chancellorPhoto : BASE_URL . $chancellorPhoto;
$chancellorFullPage = getSetting('chancellor_full_page_msg', '');

$pageTitle = "Chancellor's Message | " . $chancellorName . " | SRKU Bhopal";
$pageDesc = "Read the official welcome message and visionary address from " . $chancellorName . ", " . $chancellorTitle . " of Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = "Chancellor Message SRKU, " . $chancellorName . " Chancellor, SRK University Leadership, RKDF Group Chancellor Bhopal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';
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
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>about.php" class="text-decoration-none text-white-50">About</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgba(255,255,255,0.85);">Chancellor's Message</li>
                    </ol>
                </nav>
                <span class="about-hero-v2__eyebrow"><i class="fas fa-crown"></i> University Leadership &amp; Governance</span>
                <h1 class="about-hero-v2__title">Message from the <span>Chancellor</span></h1>
                <p class="about-hero-v2__desc">
                    "Education is the most powerful instrument for human empowerment, ethical leadership, and societal transformation."
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn-hero-yellow">
                        <i class="fas fa-paper-plane me-1"></i> Apply for Admission 2026-27
                    </a>
                    <a href="<?php echo BASE_URL; ?>vice-chancellor-message.php" class="btn-hero-outline">
                        <i class="fas fa-user-tie me-1"></i> Vice Chancellor's Message
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-hero-v2__cards">
                    <div class="about-hero-v2__card about-hero-v2__card--float1">
                        <i class="fas fa-university"></i>
                        <span class="num">1995</span>
                        <span class="lbl">Heritage Founded</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float2">
                        <i class="fas fa-user-graduate"></i>
                        <span class="num">35,000+</span>
                        <span class="lbl">Alumni Worldwide</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float3">
                        <i class="fas fa-bookmark"></i>
                        <span class="num">95%</span>
                        <span class="lbl">Passing from Universities</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float4">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span class="num">1,000+</span>
                        <span class="lbl">Eminent Faculty</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Chancellor Message Content -->
<section class="py-5 bg-light position-relative">
    <div class="container-xl py-4">
        <div class="row g-5">
            
            <!-- Left: Chancellor Profile Card (Sticky) -->
            <div class="col-12 col-lg-4 position-relative">
                <div class="card border-0 shadow rounded-4 overflow-hidden sticky-profile-sidebar">
                    <div class="bg-gradient-maroon text-white p-4 text-center" style="background: linear-gradient(135deg, #7A0B0D 0%, #a8171b 100%);">
                        <div class="mx-auto mb-3 bg-white p-1 rounded-4 shadow" style="width: 100%; max-width: 220px; height: 250px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            <img src="<?php echo $chancellorPhotoSrc; ?>"
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/08/chancellor.jpeg';"
                                 alt="<?php echo sanitize($chancellorName); ?>, Chancellor"
                                 class="w-100 h-100 rounded-3 shadow-sm"
                                 style="object-fit: cover; object-position: top center;">
                        </div>
                        <h4 class="fw-bold mb-1 text-white"><?php echo sanitize($chancellorName); ?></h4>
                        <p class="text-warning small mb-0 fw-semibold"><?php echo sanitize($chancellorTitle); ?></p>
                        <small class="text-white-50">Sarvepalli Radhakrishnan University, Bhopal</small>
                    </div>

                    <div class="card-body p-4 bg-white">
                        <h6 class="fw-bold text-navy mb-3 text-uppercase small" style="letter-spacing: 0.5px;">Institutional Pillars</h6>
                        <ul class="list-unstyled mb-4 small text-secondary d-flex flex-column gap-2">
                            <li class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-success"></i> Multidisciplinary Academic Excellence
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-success"></i> Research &amp; Technological Innovation
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-success"></i> Character Building &amp; Ethical Values
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-success"></i> Inclusive Social Empowerment
                            </li>
                        </ul>

                        <div class="border-top pt-3 text-center">
                            <a href="<?php echo BASE_URL; ?>contact.php" class="btn btn-outline-danger btn-sm w-100 rounded-pill fw-semibold py-2">
                                <i class="fas fa-envelope me-1"></i> Contact Chancellor's Secretariat
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Chancellor's Message Letter -->
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                        <div class="p-3 rounded-circle bg-danger-subtle text-danger" style="font-size: 1.5rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div>
                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill small fw-bold">Chancellor's Address</span>
                            <h3 class="fw-bold text-navy mb-0 mt-1">Warm Greetings &amp; Welcome to SRKU</h3>
                        </div>
                    </div>

                    <?php if (!empty($chancellorFullPage)): ?>
                        <div class="chancellor-custom-content text-secondary" style="line-height: 1.85;">
                            <?php echo $chancellorFullPage; ?>
                        </div>
                    <?php else: ?>
                        <div class="lead text-secondary mb-4" style="line-height: 1.8; font-size: 1.05rem;">
                            Dear Students, Parents, Educators, and Esteemed Partners,
                        </div>

                        <p class="text-secondary" style="line-height: 1.8;">
                            It gives me immense pleasure and pride to welcome you to <strong>Sarvepalli Radhakrishnan University (SRKU)</strong>, Bhopal — an institution established on the enduring philosophical foundations of Dr. Sarvepalli Radhakrishnan, who believed that <em>"The true teachers are those who help us think for ourselves."</em>
                        </p>

                        <p class="text-secondary" style="line-height: 1.8;">
                            Since our inception under the aegis of the RKDF Education Society in 1995, our journey has been defined by an unwavering dedication to democratizing quality higher education. We envisioned creating a world-class academic hub in central India that brings together cutting-edge engineering, life-saving medical sciences, advanced pharmacy, holistic AYUSH healthcare, agricultural breakthroughs, legal acumen, and entrepreneurial leadership under one vibrant umbrella.
                        </p>

                        <div class="p-4 rounded-4 my-4" style="background: linear-gradient(135deg, #fdfbf7 0%, #f7f1e5 100%); border-left: 4px solid var(--srku-maroon);">
                            <h5 class="fw-bold text-navy mb-2"><i class="fas fa-lightbulb text-warning me-2"></i> Our Educational Philosophy</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.7;">
                                "In an era of rapid technological disruption, our mission is not merely to impart textbook knowledge, but to ignite curiosity, foster critical thinking, instill ethical integrity, and nurture resilient global citizens capable of solving 21st-century challenges."
                            </p>
                        </div>

                        <p class="text-secondary" style="line-height: 1.8;">
                            At SRKU, we take immense pride in our state-of-the-art infrastructure comprising 42+ advanced research laboratories, digital libraries, an operational multi-specialty teaching hospital, simulation suites, and an active startup incubation centre. Our world-class faculty mentors work tirelessly to ensure that our students receive experiential, outcome-based pedagogy that bridges the gap between academic theory and real-world industrial practice.
                        </p>

                        <p class="text-secondary" style="line-height: 1.8;">
                            To every aspiring student joining our campus: I assure you that your years at SRKU will be transformative. You will be encouraged to explore, question, experiment, and excel. We are committed to standing by you as you craft your dreams and build a glorious future for yourself and the nation.
                        </p>
                    <?php endif; ?>

                    <div class="mt-5 pt-4 border-top d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                        <div>
                            <h5 class="fw-bold text-navy mb-0"><?php echo sanitize($chancellorName); ?></h5>
                            <p class="text-danger small mb-0 fw-semibold"><?php echo sanitize($chancellorTitle); ?></p>
                            <small class="text-muted">Sarvepalli Radhakrishnan University, Bhopal</small>
                        </div>
                        <div class="text-sm-end">
                            <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i> Bhopal, Madhya Pradesh
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
