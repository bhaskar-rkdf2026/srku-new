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
$facilitiesFromDb = getCampusFacilities('active');
$facilitiesList = [];
foreach ($facilitiesFromDb as $fac) {
    $img = $fac['image'] ?? $fac['image_url'] ?? '';
    if (!empty($img) && strpos($img, 'http') !== 0) {
        $img = BASE_URL . ltrim($img, '/');
    }
    $facilitiesList[] = [
        'id'    => $fac['id'],
        'title' => $fac['title'] ?? '',
        'icon'  => !empty($fac['icon']) ? $fac['icon'] : 'fa-building',
        'image' => $img,
        'desc'  => $fac['description'] ?? ''
    ];
}
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
                        <img src="<?php echo htmlspecialchars($fac['image']); ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/08/welcome-srku-campus.jpeg';"
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
<!-- Campus Policies & Environmental Standards -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5" style="max-width:750px; margin:auto;">
            <span class="section-subtitle">COMPLIANCE &amp; STANDARDS</span>
            <h2 class="fw-bold text-navy">Campus Infrastructure &amp; Environmental Policies</h2>
            <p class="text-muted">Official institutional policies ensuring sustainable, inclusive, barrier-free, and high-standard campus operations.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <a href="<?php echo BASE_URL; ?>document/clean-green-campus-policy" class="text-decoration-none text-dark d-block h-100">
                    <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow" style="transition:all 0.2s ease;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-success-subtle text-success rounded-3 p-3"><i class="fas fa-leaf fa-lg"></i></div>
                            <h4 class="h5 fw-bold text-navy mb-0">Clean &amp; Green Campus Policy</h4>
                        </div>
                        <p class="text-muted small mb-3">Ecological stewardship, 100% green coverage, biodiversity protection, and solar energy norms.</p>
                        <span class="small fw-bold text-success d-flex align-items-center gap-1">View Policy Document &rarr;</span>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="<?php echo BASE_URL; ?>document/plastic-ban-policy" class="text-decoration-none text-dark d-block h-100">
                    <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow" style="transition:all 0.2s ease;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-danger-subtle text-danger rounded-3 p-3"><i class="fas fa-ban fa-lg"></i></div>
                            <h4 class="h5 fw-bold text-navy mb-0">Plastic Ban Policy</h4>
                        </div>
                        <p class="text-muted small mb-3">Single-use plastic prohibition, zero plastic zones, waste segregation, and green ambassadors.</p>
                        <span class="small fw-bold text-danger d-flex align-items-center gap-1">View Policy Document &rarr;</span>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="<?php echo BASE_URL; ?>document/differently-abled-facilities" class="text-decoration-none text-dark d-block h-100">
                    <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow" style="transition:all 0.2s ease;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-primary-subtle text-primary rounded-3 p-3"><i class="fas fa-wheelchair fa-lg"></i></div>
                            <h4 class="h5 fw-bold text-navy mb-0">Disabled-Friendly &amp; Barrier Free</h4>
                        </div>
                        <p class="text-muted small mb-3">Wheelchair accessibility ramps, tactile flooring, accessible elevators, and Braille support.</p>
                        <span class="small fw-bold text-primary d-flex align-items-center gap-1">View Policy Document &rarr;</span>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="<?php echo BASE_URL; ?>document/it-policy" class="text-decoration-none text-dark d-block h-100">
                    <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow" style="transition:all 0.2s ease;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-info-subtle text-info rounded-3 p-3"><i class="fas fa-laptop-code fa-lg"></i></div>
                            <h4 class="h5 fw-bold text-navy mb-0">IT &amp; Network Policy</h4>
                        </div>
                        <p class="text-muted small mb-3">Campus optical fiber network, cybersecurity, enterprise ERP portal access, and IT assets.</p>
                        <span class="small fw-bold text-info d-flex align-items-center gap-1">View Policy Document &rarr;</span>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="<?php echo BASE_URL; ?>document/maintenance-policy" class="text-decoration-none text-dark d-block h-100">
                    <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow" style="transition:all 0.2s ease;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-warning-subtle text-warning rounded-3 p-3"><i class="fas fa-tools fa-lg"></i></div>
                            <h4 class="h5 fw-bold text-navy mb-0">Campus Maintenance Policy</h4>
                        </div>
                        <p class="text-muted small mb-3">Laboratory equipment calibration, annual maintenance contracts (AMC), and building safety SOPs.</p>
                        <span class="small fw-bold text-warning d-flex align-items-center gap-1">View Policy Document &rarr;</span>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="<?php echo BASE_URL; ?>document/sports-facilities" class="text-decoration-none text-dark d-block h-100">
                    <div class="card p-4 border rounded-4 shadow-sm h-100 hover-shadow" style="transition:all 0.2s ease;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-danger-subtle text-danger rounded-3 p-3"><i class="fas fa-running fa-lg"></i></div>
                            <h4 class="h5 fw-bold text-navy mb-0">Sports &amp; Cultural Policy</h4>
                        </div>
                        <p class="text-muted small mb-3">Sports quota, athletic complex facilities, gymnasium norms, and inter-university competitions.</p>
                        <span class="small fw-bold text-danger d-flex align-items-center gap-1">View Policy Document &rarr;</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo BASE_URL; ?>assets/js/reveal.js" defer></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
