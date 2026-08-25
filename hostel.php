<?php
$pageTitle = "Hostel Accommodation & Campus Living | Boys & Girls Hostels | SRKU Bhopal";
$pageDesc = "Explore on-campus residential hostel facilities at Sarvepalli Radhakrishnan University (SRKU), Bhopal. 24/7 security, Wi-Fi, hygienic mess, modern AC/Non-AC rooms, gym and warden supervision.";
$pageKeywords = "SRKU Hostel Bhopal, University Hostel Fees, Boys Hostel Bhopal, Girls Hostel MP, Campus Accommodation SRKU";
$activeNav = "facilities";
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
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>facilities.php" class="text-decoration-none text-white-50">Campus Facilities</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgba(255,255,255,0.85);">Hostel Accommodation</li>
                    </ol>
                </nav>
                <span class="about-hero-v2__eyebrow"><i class="fas fa-bed"></i> Safe &amp; Vibrant Campus Living</span>
                <h1 class="about-hero-v2__title">On-Campus <span>Hostels &amp; Living</span></h1>
                <p class="about-hero-v2__desc">
                    A home away from home: separate modern residential hostel blocks for boys and girls with 24/7 biometric security, nutritious dining mess, high-speed Wi-Fi, sports, and hospital healthcare.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn-hero-yellow">
                        <i class="fas fa-key me-1"></i> Apply for Hostel Room
                    </a>
                    <a href="<?php echo BASE_URL; ?>facilities.php" class="btn-hero-outline">
                        <i class="fas fa-building me-1"></i> All Campus Facilities
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-hero-v2__cards">
                    <div class="about-hero-v2__card about-hero-v2__card--float1">
                        <i class="fas fa-shield-alt"></i>
                        <span class="num">24/7</span>
                        <span class="lbl">CCTV &amp; Security</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float2">
                        <i class="fas fa-utensils"></i>
                        <span class="num">4 Meals</span>
                        <span class="lbl">Hygienic Mess / Day</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float3">
                        <i class="fas fa-wifi"></i>
                        <span class="num">High-Speed</span>
                        <span class="lbl">Wi-Fi Campus</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float4">
                        <i class="fas fa-hospital"></i>
                        <span class="num">24-Hr</span>
                        <span class="lbl">Medical Hospital</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hostel Features & Room Categories -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        
        <!-- Overview Banner -->
        <div class="row g-4 align-items-center mb-5">
            <div class="col-12 col-lg-6">
                <span class="section-subtitle text-danger fw-bold">RESIDENTIAL EXCELLENCE</span>
                <h2 class="fw-bold text-navy mb-3">Safe, Secure &amp; Disciplined Living Environment</h2>
                <p class="text-secondary" style="line-height: 1.8;">
                    Sarvepalli Radhakrishnan University provides comprehensive on-campus boarding facilities designed to foster holistic development, academic camaraderie, and self-reliance among residential scholars.
                </p>
                <p class="text-secondary" style="line-height: 1.8;">
                    With round-the-clock professional security guards, biometric access control, CCTV monitoring, resident wardens, and dedicated healthcare assistance from the adjacent RKDF Medical College Hospital, parents are assured of their ward's absolute safety and well-being.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill small fw-semibold">
                        <i class="fas fa-check me-1"></i> Ragging Free Campus
                    </span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill small fw-semibold">
                        <i class="fas fa-check me-1"></i> RO Purified Drinking Water
                    </span>
                    <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-3 py-2 rounded-pill small fw-semibold">
                        <i class="fas fa-check me-1"></i> 100% Power Backup
                    </span>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/hostel.webp" alt="SRKU University Hostels" class="img-fluid w-100 object-fit-cover" style="max-height: 380px;">
                    <div class="card-body p-3 bg-dark text-white text-center">
                        <small class="text-white-50"><i class="fas fa-building me-1"></i> Modern Boys &amp; Girls Hostel Complexes on NH-12 Campus</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Types & Amenities Cards -->
        <h4 class="fw-bold text-navy mb-4 text-center">Hostel Amenities &amp; Services</h4>
        <div class="row g-4 mb-5">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                    <div class="p-3 rounded-circle bg-danger-subtle text-danger mb-3 d-inline-block" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">Hygienic Dining &amp; Mess</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.7;">
                        Spacious dining halls serving nutritious, multi-cuisine vegetarian and balanced meals (Breakfast, Lunch, Evening Snacks, and Dinner) overseen by student food committees.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                    <div class="p-3 rounded-circle bg-primary-subtle text-primary mb-3 d-inline-block" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">Study Lounges &amp; Wi-Fi</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.7;">
                        Airy quiet study rooms, uninterrupted 100 Mbps optical fiber Wi-Fi access, and digital study resources for evening and late-night revisions.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                    <div class="p-3 rounded-circle bg-success-subtle text-success mb-3 d-inline-block" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">24/7 Medical Care &amp; Gym</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.7;">
                        Direct emergency access to doctors and ambulances at the RKDF Medical College Hospital, fully equipped multi-gymnasium, badminton, and volleyball courts.
                    </p>
                </div>
            </div>
        </div>

        <!-- Hostel Guidelines & Contact -->
        <div class="card border-0 shadow rounded-4 text-white p-4 p-md-5 overflow-hidden position-relative" style="background: linear-gradient(135deg, #7A0B0D 0%, #16233f 100%);">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                    <h3 class="fw-bold text-white mb-2">Hostel Admission &amp; Enquiries</h3>
                    <p class="text-white-50 mb-0" style="line-height: 1.7;">
                        Hostel rooms are allotted on a first-come, first-served basis at the time of academic registration. Room choices include Single, Double, and Triple Sharing (AC and Non-AC variants).
                    </p>
                </div>
                <div class="col-12 col-lg-4 text-lg-end">
                    <a href="<?php echo BASE_URL; ?>contact.php" class="btn btn-warning text-dark px-4 py-2 rounded-pill fw-bold shadow">
                        <i class="fas fa-phone-alt me-1"></i> Contact Hostel Warden
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
