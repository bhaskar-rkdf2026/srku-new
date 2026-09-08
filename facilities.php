<?php
$pageTitle = "Campus Facilities & Infrastructure | 42+ Labs, Hostels & Hospitals | SRKU";
$pageDesc = "Explore the infrastructure of Sarvepalli Radhakrishnan University (SRKU) Bhopal: 42+ high-tech laboratories, Central Library, RKDF Medical Hospital, smart classrooms, hostels and sports complex.";
$pageKeywords = "SRKU Facilities, University Infrastructure Bhopal, Laboratories, Hostel Facilities, Campus Hospital Bhopal";
$activeNav = "facilities";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('facilities', 'Campus Facilities', 'Infrastructure and amenities available across the SRK University campus in Bhopal'); ?>

<?php
$defaultFacilities = [
    [
        'title' => getSetting('total_labs', '42+') . ' Research Laboratories',
        'icon' => 'fa-microscope',
        'image' => 'assets/uploads/2026/07/lab-and-research.webp',
        'desc' => 'Equipped with high-performance computing clusters, robotics simulation kits, automated HPLC drug testing systems, and agronomy research suites.'
    ],
    [
        'title' => 'Central Digital Library',
        'icon' => 'fa-book-reader',
        'image' => 'assets/uploads/2026/07/library.webp',
        'desc' => 'Over 50,000+ volumes, IEEE, Scopus, Springer e-journal subscriptions, DELNET network access, and quiet digital reading rooms.'
    ],
    [
        'title' => 'Smart AC Auditoriums',
        'icon' => 'fa-chalkboard-teacher',
        'image' => 'assets/uploads/2026/07/Operation-Theatre.webp',
        'desc' => 'Fully air-conditioned multi-tiered amphitheaters with Dolby surround sound, interactive smartboards, and live video conferencing.'
    ],
    [
        'title' => 'Sports Complex & Gym',
        'icon' => 'fa-running',
        'image' => 'assets/uploads/2026/07/sports.webp',
        'desc' => 'Full-size cricket turf ground, floodlit basketball courts, volleyball, indoor badminton arena, and modern fitness gymnasium.'
    ],
    [
        'title' => 'On-Campus Hostels',
        'icon' => 'fa-bed',
        'image' => 'assets/uploads/2026/07/hostel.webp',
        'desc' => 'Separate boys and girls residential blocks with Wi-Fi, 24x7 security surveillance, water purifiers, and hygienic multi-cuisine mess.'
    ],
    [
        'title' => getSetting('stat_hospital_beds', '750+') . ' Bed Teaching Hospital',
        'icon' => 'fa-hospital-alt',
        'image' => 'assets/uploads/2026/07/INFRA-STRUCTURE-SRKU-05.webp',
        'desc' => 'Full-fledged super-specialty hospital with 24x7 ICU, emergency casualty, operation theaters, and clinical diagnostic pathology.'
    ]
];
$facilitiesList = getJsonSetting('facilities_list', $defaultFacilities);
?>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5" style="max-width:750px; margin:auto;">
            <span class="section-subtitle">INFRASTRUCTURE EXCELLENCE</span>
            <h2 class="fw-bold text-navy">State-of-the-Art Learning &amp; Living Environment</h2>
            <p class="text-muted"><?php echo sanitize(getSetting('facilities_desc', 'Designed to provide students with a holistic ecosystem for rigorous academic pursuit, breakthrough research, athletic vigor, and community living.')); ?></p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($facilitiesList as $fac): ?>
                <div class="col">
                    <div class="card reveal h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="<?php echo BASE_URL . sanitize($fac['image']); ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                             class="card-img-top" style="height:220px; object-fit:cover;" alt="<?php echo sanitize($fac['title']); ?>">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="fas <?php echo sanitize($fac['icon'] ?? 'fa-building'); ?> text-danger"></i>
                                <h3 class="h5 fw-bold text-navy mb-0"><?php echo sanitize($fac['title']); ?></h3>
                            </div>
                            <p class="text-muted small mb-0" style="line-height:1.7;">
                                <?php echo sanitize($fac['desc']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Transport & Campus Safety -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="facility-info-box reveal p-4 p-md-5 bg-white rounded-4 border shadow-sm h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-danger-subtle text-danger rounded-circle p-3"><i class="fas fa-bus fa-2x"></i></div>
                        <h3 class="h4 fw-bold text-navy mb-0">Fleet of 30+ University Buses</h3>
                    </div>
                    <p class="text-muted small mb-0" style="line-height:1.8;">
                        Comprehensive bus transportation network covering all major boarding points across Bhopal, Mandideep, Hoshangabad, Sehore, and Raisen for safe and convenient daily transit.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="facility-info-box reveal p-4 p-md-5 bg-white rounded-4 border shadow-sm h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-success-subtle text-success rounded-circle p-3"><i class="fas fa-shield-alt fa-2x"></i></div>
                        <h3 class="h4 fw-bold text-navy mb-0">24/7 Security &amp; Wi-Fi Campus</h3>
                    </div>
                    <p class="text-muted small mb-0" style="line-height:1.8;">
                        Complete CCTV surveillance across academic blocks, biometric attendance systems, ragging-free campus monitoring, and high-speed optical fiber internet connectivity.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo BASE_URL; ?>assets/js/reveal.js" defer></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
