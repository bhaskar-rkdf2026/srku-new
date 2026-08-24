<?php
$pageTitle = "Campus Photo & Event Gallery - SRK University Bhopal";
$activeNav = "admission";
require_once __DIR__ . '/includes/header.php';

$category = sanitize($_GET['category'] ?? '');
$images = getGalleryImages($category);

// Fallback images from assets if database gallery is empty
$defaultGallery = [
    ['title' => 'Main Academic Campus Block', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/07/campus-1.webp'],
    ['title' => 'Central Digital Library', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/07/library.webp'],
    ['title' => 'High-Performance Computing Lab', 'cat' => 'Labs', 'img' => 'assets/uploads/2026/07/lab-and-research.webp'],
    ['title' => 'Smart AC Auditorium & Seminar Hall', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/07/Operation-Theatre.webp'],
    ['title' => 'Campus Sports Tournament', 'cat' => 'Sports', 'img' => 'assets/uploads/2026/07/sports.webp'],
    ['title' => 'Student Residential Hostels', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/07/hostel.webp'],
    ['title' => 'Super-Specialty Teaching Hospital', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/07/INFRA-STRUCTURE-SRKU-05.webp'],
    ['title' => 'Graduation Day & Convocation', 'cat' => 'Events', 'img' => 'assets/uploads/2026/07/graduates.webp'],
    ['title' => 'Cultural Fest Celebrations', 'cat' => 'Events', 'img' => 'assets/uploads/2026/07/Gallary-slider-01.webp'],
    ['title' => 'Campus Life & Student Activities', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/07/Gallary-slider-03.webp'],
    ['title' => 'Robotics & AI Innovation Workshop', 'cat' => 'Labs', 'img' => 'assets/uploads/2026/07/Gallary-slider-06.webp'],
    ['title' => 'Annual Cultural Evening', 'cat' => 'Events', 'img' => 'assets/uploads/2026/07/Gallary-slider-07.webp']
];

$infrastructureGallery = [
    ['title' => 'SRK University Main Building', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/08/welcome-srku-campus.jpeg'],
    ['title' => 'SRK University Main Gate', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/08/srku-main-gate.jpeg'],
    ['title' => 'SRK University Academic Block', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/08/srku-academic-block.jpeg'],
    ['title' => 'RKDF Group Campus Building', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/08/srku-rkdf-building.jpeg'],
    ['title' => 'SRK University Campus Block', 'cat' => 'Campus', 'img' => 'assets/uploads/2026/08/srku-campus-block.jpeg']
];

$displayItems = !empty($images) ? $images : $defaultGallery;
if (empty($category) || $category === 'Campus') {
    $displayItems = array_merge($infrastructureGallery, $displayItems);
}
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('gallery', 'Campus Photo & Event Gallery', 'Glimpses of Academic Life, Cultural Fests, Sports & World-Class Infrastructure'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        
        <!-- Filter Tabs -->
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-5">
            <a href="<?php echo BASE_URL; ?>gallery.php" class="btn btn-sm <?php echo empty($category) ? 'btn-danger' : 'btn-light border'; ?> px-3 py-2 rounded-pill fw-bold">All Photos</a>
            <a href="<?php echo BASE_URL; ?>gallery.php?category=Campus" class="btn btn-sm <?php echo $category == 'Campus' ? 'btn-danger' : 'btn-light border'; ?> px-3 py-2 rounded-pill fw-bold">Campus Infrastructure</a>
            <a href="<?php echo BASE_URL; ?>gallery.php?category=Labs" class="btn btn-sm <?php echo $category == 'Labs' ? 'btn-danger' : 'btn-light border'; ?> px-3 py-2 rounded-pill fw-bold">Laboratories &amp; Research</a>
            <a href="<?php echo BASE_URL; ?>gallery.php?category=Events" class="btn btn-sm <?php echo $category == 'Events' ? 'btn-danger' : 'btn-light border'; ?> px-3 py-2 rounded-pill fw-bold">Events &amp; Convocations</a>
            <a href="<?php echo BASE_URL; ?>gallery.php?category=Sports" class="btn btn-sm <?php echo $category == 'Sports' ? 'btn-danger' : 'btn-light border'; ?> px-3 py-2 rounded-pill fw-bold">Sports &amp; Athletics</a>
        </div>

        <!-- Gallery Grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            <?php 
            foreach ($displayItems as $item): 
                $itemCat = $item['category'] ?? $item['cat'];
                if ($category && $itemCat !== $category) continue;
                $itemImg = $item['image_url'] ?? $item['img'];
                $itemTitle = $item['title'];
            ?>
                <div class="col">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 group-hover">
                        <img src="<?php echo BASE_URL . sanitize($itemImg); ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                             class="card-img-top" style="height:220px; object-fit:cover; transition:transform 0.4s ease;" alt="<?php echo sanitize($itemTitle); ?>">
                        <div class="p-3 bg-white border-top">
                            <span class="badge bg-danger-subtle text-danger small mb-1"><?php echo sanitize($itemCat); ?></span>
                            <h4 class="h6 fw-bold text-navy mb-0"><?php echo sanitize($itemTitle); ?></h4>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
