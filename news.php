<?php
$pageTitle = "Official Notice Board & Circulars - SRK University Bhopal";
$activeNav = "news";
require_once __DIR__ . '/includes/header.php';

$selectedCategory = sanitize($_GET['category'] ?? '');
$searchQuery = sanitize($_GET['q'] ?? '');

$allNews = getNews();

$filteredNews = array_filter($allNews, function($n) use ($selectedCategory, $searchQuery) {
    if (!empty($selectedCategory) && $selectedCategory !== 'all') {
        if (strcasecmp($n['category'] ?? '', $selectedCategory) !== 0) {
            return false;
        }
    }
    if (!empty($searchQuery)) {
        $term = strtolower($searchQuery);
        $titleMatch = strpos(strtolower($n['title']), $term) !== false;
        $contentMatch = strpos(strtolower($n['content']), $term) !== false;
        if (!$titleMatch && !$contentMatch) {
            return false;
        }
    }
    return true;
});
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('notice', 'Notice Board & Official Circulars', 'Stay Updated with University Examinations, Academic Calendars, Circulars & Placement Drives'); ?>

<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- Filter & Search Bar -->
        <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="row g-3 align-items-center mb-3">
                <div class="col-12 col-md-6">
                    <h2 class="h4 fw-bold text-navy mb-1"><i class="fas fa-bullhorn text-danger me-2"></i> University Notices &amp; Circulars</h2>
                    <p class="text-muted small mb-0">Official academic announcements, exam schedules, and circulars.</p>
                </div>
                <div class="col-12 col-md-6">
                    <form action="<?php echo BASE_URL; ?>news.php" method="GET" class="d-flex gap-2">
                        <?php if ($selectedCategory): ?>
                            <input type="hidden" name="category" value="<?php echo sanitize($selectedCategory); ?>">
                        <?php endif; ?>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control border-start-0" placeholder="Search notices, exams, circulars..." value="<?php echo sanitize($searchQuery); ?>">
                        </div>
                        <button type="submit" class="btn btn-srku px-4"><i class="fas fa-filter me-1"></i> Filter</button>
                    </form>
                </div>
            </div>

            <!-- Category Pills -->
            <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                <a href="<?php echo BASE_URL; ?>news.php" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo empty($selectedCategory) ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    All Notices (<?php echo count($allNews); ?>)
                </a>
                <?php 
                $cats = ['Admission', 'Placement', 'Examination', 'Announcement'];
                foreach ($cats as $cat):
                ?>
                    <a href="<?php echo BASE_URL; ?>news.php?category=<?php echo urlencode($cat); ?>" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory === $cat ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                        <?php echo $cat; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Notices List -->
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <?php if (!empty($filteredNews)): ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($filteredNews as $n): ?>
                            <div class="card p-4 border-0 shadow-sm rounded-4 bg-white hover-shadow" style="transition: all 0.25s ease;">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill fw-bold">
                                            <i class="fas fa-tag me-1"></i> <?php echo sanitize($n['category'] ?? 'Announcement'); ?>
                                        </span>
                                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> <?php echo date('M d, Y', strtotime($n['publish_date'] ?: $n['created_at'])); ?></small>
                                    </div>
                                    <span class="badge bg-light text-dark border">Notice #<?php echo $n['id']; ?></span>
                                </div>
                                <h3 class="h5 fw-bold text-navy mb-2">
                                    <a href="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo $n['id']; ?>" class="text-navy text-decoration-none hover-text-danger">
                                        <?php echo sanitize($n['title']); ?>
                                    </a>
                                </h3>
                                <p class="text-muted small mb-3">
                                    <?php echo substr(strip_tags($n['content']), 0, 160) . '...'; ?>
                                </p>
                                <div>
                                    <a href="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo $n['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">
                                        Read Official Circular &rarr;
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="card p-5 text-center bg-white rounded-4 border-0 shadow-sm">
                        <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                        <h4 class="text-navy fw-bold">No Notices Found</h4>
                        <p class="text-muted mb-0">No circulars match your search criteria. Please reset filters.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-12 col-lg-4">
                <!-- Blogs Widget -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold text-navy mb-0"><i class="fas fa-newspaper text-danger me-2"></i> University Blogs</h5>
                        <a href="<?php echo BASE_URL; ?>blogs.php" class="small text-danger fw-bold text-decoration-none">View All</a>
                    </div>
                    <?php 
                    $sideBlogs = getBlogs(null, 4);
                    foreach ($sideBlogs as $sb):
                    ?>
                        <div class="d-flex gap-3 align-items-center pb-2 mb-2 border-bottom">
                            <img src="<?php echo BASE_URL . sanitize($sb['image_url'] ?: 'assets/uploads/2026/07/001.webp'); ?>" 
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';" 
                                 class="rounded-3 object-fit-cover flex-shrink-0" style="width: 52px; height: 42px;" alt="">
                            <div>
                                <h6 class="mb-0" style="font-size: 0.88rem; line-height: 1.3;">
                                    <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($sb['slug'] ?: $sb['id']); ?>" class="text-navy text-decoration-none hover-text-danger fw-semibold">
                                        <?php echo sanitize($sb['title']); ?>
                                    </a>
                                </h6>
                                <small class="text-muted" style="font-size: 0.76rem;"><?php echo date('M d, Y', strtotime($sb['publish_date'] ?: $sb['created_at'])); ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Admission CTA -->
                <div class="card p-4 border-0 shadow-sm rounded-4 text-white text-center" style="background: linear-gradient(135deg, #7A0B0D 0%, #a31216 100%);">
                    <h5 class="fw-bold mb-2">Admissions Open 2026-27</h5>
                    <p class="small text-white-50 mb-3">Enquire now for direct counseling and scholarship eligibility.</p>
                    <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn btn-warning text-dark fw-bold rounded-pill w-100 py-2">
                        Online Admission Form &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
