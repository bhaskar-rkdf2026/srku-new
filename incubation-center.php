<?php
$pageTitle = "SRKU Incubation Centre & Startups - Sarvepalli Radhakrishnan University";
$activeNav = "research";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('incubation-center', 'SRKU Incubation & Startup Centre', 'Nurturing Student Entrepreneurs, Ideation & Commercial Venture Creation'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5 mb-5">
            <div class="col-12 col-lg-6">
                <span class="section-subtitle">ENTREPRENEURSHIP CELL</span>
                <h2 class="section-title mb-3">From Classroom Ideation to <span>Thriving Enterprises</span></h2>
                <p class="text-dark mb-3" style="line-height:1.8; font-size:0.95rem;">
                    The SRKU Incubation Centre provides early-stage student startups, faculty researchers, and young entrepreneurs with state-of-the-art co-working spaces, seed funding support, intellectual property filing assistance, and one-on-one mentorship from venture capitalists.
                </p>
                <p class="text-muted mb-4" style="line-height:1.8; font-size:0.93rem;">
                    Focus sectors include Agri-Tech, Health-Tech, AI &amp; Software Solutions, Renewable Energy, and Smart Manufacturing.
                </p>
                <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku"><i class="fas fa-paper-plane me-1"></i> Apply with Startup Pitch</a>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-light">
                    <h4 class="text-navy fw-bold mb-3"><i class="fas fa-rocket text-danger me-2"></i> Incubation Support Pillars</h4>
                    <ul class="list-unstyled d-flex flex-column gap-3 mb-0" style="line-height:1.7;">
                        <li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Seed Grant Funding:</strong> Financial support for prototype validation and initial market launch.</li>
                        <li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Modern Prototyping Labs:</strong> 3D printers, IoT workstations, and testing software suites.</li>
                        <li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Legal &amp; Compliance Help:</strong> Company incorporation, GST, trademark, and patent filing.</li>
                        <li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Investor Demo Days:</strong> Pitch opportunities in front of Angel Networks and VC funds.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
