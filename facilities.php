<?php
$pageTitle = "Campus Facilities & Infrastructure - SRK University Bhopal";
$activeNav = "facilities";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('facilities', 'World-Class Campus Facilities', 'Lush Green Sprawling Campus Spread Over Expansive Acres in Bhopal'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5" style="max-width:750px; margin:auto;">
            <span class="section-subtitle">INFRASTRUCTURE EXCELLENCE</span>
            <h2 class="fw-bold text-navy">State-of-the-Art Learning &amp; Living Environment</h2>
            <p class="text-muted">Designed to provide students with a holistic ecosystem for rigorous academic pursuit, breakthrough research, athletic vigor, and community living.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            
            <!-- Facility 1: Labs -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         class="card-img-top" style="height:220px; object-fit:cover;" alt="Research Labs">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-microscope text-danger"></i>
                            <h3 class="h5 fw-bold text-navy mb-0">42+ Research Laboratories</h3>
                        </div>
                        <p class="text-muted small mb-0" style="line-height:1.7;">
                            Equipped with high-performance computing clusters, robotics simulation kits, automated HPLC drug testing systems, and agronomy research suites.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Facility 2: Library -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/library.webp"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         class="card-img-top" style="height:220px; object-fit:cover;" alt="Central Library">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-book-reader text-danger"></i>
                            <h3 class="h5 fw-bold text-navy mb-0">Central Digital Library</h3>
                        </div>
                        <p class="text-muted small mb-0" style="line-height:1.7;">
                            Over 50,000+ volumes, IEEE, Scopus, Springer e-journal subscriptions, DELNET network access, and quiet digital reading rooms.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Facility 3: Auditoriums -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Operation-Theatre.webp"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         class="card-img-top" style="height:220px; object-fit:cover;" alt="Auditorium">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-chalkboard-teacher text-danger"></i>
                            <h3 class="h5 fw-bold text-navy mb-0">Smart AC Auditoriums</h3>
                        </div>
                        <p class="text-muted small mb-0" style="line-height:1.7;">
                            Fully air-conditioned multi-tiered amphitheaters with Dolby surround sound, interactive smartboards, and live video conferencing.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Facility 4: Sports -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/sports.webp"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         class="card-img-top" style="height:220px; object-fit:cover;" alt="Sports Complex">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-running text-danger"></i>
                            <h3 class="h5 fw-bold text-navy mb-0">Sports Complex &amp; Gym</h3>
                        </div>
                        <p class="text-muted small mb-0" style="line-height:1.7;">
                            Full-size cricket turf ground, floodlit basketball courts, volleyball, indoor badminton arena, and modern fitness gymnasium.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Facility 5: Hostels -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/hostel.webp"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         class="card-img-top" style="height:220px; object-fit:cover;" alt="Hostels">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-bed text-danger"></i>
                            <h3 class="h5 fw-bold text-navy mb-0">On-Campus Hostels</h3>
                        </div>
                        <p class="text-muted small mb-0" style="line-height:1.7;">
                            Separate boys and girls residential blocks with Wi-Fi, 24x7 security surveillance, water purifiers, and hygienic multi-cuisine mess.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Facility 6: Hospital -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/INFRA-STRUCTURE-SRKU-05.webp"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         class="card-img-top" style="height:220px; object-fit:cover;" alt="Hospital">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-hospital-alt text-danger"></i>
                            <h3 class="h5 fw-bold text-navy mb-0">750+ Bed Teaching Hospital</h3>
                        </div>
                        <p class="text-muted small mb-0" style="line-height:1.7;">
                            Full-fledged super-specialty hospital with 24x7 ICU, emergency casualty, operation theaters, and clinical diagnostic pathology.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Transport & Campus Safety -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-4 p-md-5 bg-white rounded-4 border shadow-sm h-100">
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
                <div class="p-4 p-md-5 bg-white rounded-4 border shadow-sm h-100">
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

<?php require_once __DIR__ . '/includes/footer.php'; ?>
