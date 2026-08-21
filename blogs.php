<?php
$pageTitle = "University News & Blogs - Sarvepalli Radhakrishnan University";
$activeNav = "blogs";
require_once __DIR__ . '/includes/header.php';

$category = sanitize($_GET['cat'] ?? '');
$newsList = getNews($category, 12);
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('blogs', 'Campus News, Articles & Updates', 'Latest Announcements, Research Highlights & Student Achievements'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        
        <!-- Category Filter -->
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-5">
            <a href="<?php echo BASE_URL; ?>blogs.php" class="btn btn-sm <?php echo empty($category) ? 'btn-danger' : 'btn-light border'; ?> px-3 py-2 rounded-pill fw-bold">All News</a>
            <a href="<?php echo BASE_URL; ?>blogs.php?cat=Admission" class="btn btn-sm <?php echo $category == 'Admission' ? 'btn-danger' : 'btn-light border'; ?> px-3 py-2 rounded-pill fw-bold">Admissions</a>
            <a href="<?php echo BASE_URL; ?>blogs.php?cat=Placement" class="btn btn-sm <?php echo $category == 'Placement' ? 'btn-danger' : 'btn-light border'; ?> px-3 py-2 rounded-pill fw-bold">Placements</a>
            <a href="<?php echo BASE_URL; ?>blogs.php?cat=Event" class="btn btn-sm <?php echo $category == 'Event' ? 'btn-danger' : 'btn-light border'; ?> px-3 py-2 rounded-pill fw-bold">Conferences &amp; Events</a>
            <a href="<?php echo BASE_URL; ?>blogs.php?cat=Campus%20Life" class="btn btn-sm <?php echo $category == 'Campus Life' ? 'btn-danger' : 'btn-light border'; ?> px-3 py-2 rounded-pill fw-bold">Campus Life</a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (!empty($newsList)): ?>
                <?php foreach ($newsList as $n): ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column hover-shadow">
                            <?php if (!empty($n['image_url'])): ?>
                                <img src="<?php echo BASE_URL . sanitize($n['image_url']); ?>" 
                                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                     class="card-img-top" style="height:200px; object-fit:cover;" alt="<?php echo sanitize($n['title']); ?>">
                            <?php else: ?>
                                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp" class="card-img-top" style="height:200px; object-fit:cover;" alt="<?php echo sanitize($n['title']); ?>">
                            <?php endif; ?>

                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                                    <span class="badge bg-danger-subtle text-danger border"><?php echo sanitize($n['category']); ?></span>
                                    <span><i class="far fa-calendar-alt me-1"></i> <?php echo date('d M Y', strtotime($n['publish_date'] ?: $n['created_at'])); ?></span>
                                </div>
                                <h3 class="h5 fw-bold text-navy mb-2"><?php echo sanitize($n['title']); ?></h3>
                                <p class="text-muted small mb-4 flex-grow-1" style="line-height:1.7;">
                                    <?php echo substr(strip_tags($n['content']), 0, 140) . '...'; ?>
                                </p>
                                <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($n['slug'] ?: $n['id']); ?>" class="btn btn-sm btn-outline-danger mt-auto align-self-start">
                                    Read Article <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h4 class="text-navy fw-bold">No articles found in this category</h4>
                    <a href="<?php echo BASE_URL; ?>blogs.php" class="btn btn-srku mt-2">View All News</a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
