<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "University Blogs, Articles & Academic Insights | SRKU Bhopal";
$pageDesc = "Read latest university articles, educational insights, student experiences, campus updates, and academic trends from Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = "SRKU Blogs, Higher Education Articles, Student Stories, Academic Insights Bhopal";
$activeNav = "blogs";

$category = sanitize($_GET['cat'] ?? '');
$search = sanitize($_GET['q'] ?? '');
$blogsList = getBlogs($category, 18, $search);

// Get distinct categories
$pdo = getDBConnection();
$categories = $pdo->query("SELECT DISTINCT category FROM blogs WHERE status = 'published' AND category IS NOT NULL AND category != ''")->fetchAll(PDO::FETCH_COLUMN);

require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('blogs', 'SRKU Campus Blogs & Insights', 'Academic Research, Campus Life, Innovation & Student Achievement Stories'); ?>

<section class="py-5 bg-light">
    <div class="container-xl py-3">
        
        <!-- Search & Filter Bar -->
        <div class="card p-3 p-md-4 border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="row g-3 align-items-center mb-3">
                <div class="col-12 col-lg-7">
                    <h2 class="h5 fw-bold text-navy mb-1"><i class="fas fa-newspaper text-danger me-2"></i> Articles &amp; Insights</h2>
                    <p class="text-muted small mb-0">Browse university blogs, research highlights, and campus stories.</p>
                </div>
                <div class="col-12 col-lg-5">
                    <form method="GET" action="<?php echo BASE_URL; ?>blogs.php" class="d-flex gap-2">
                        <?php if ($category): ?>
                            <input type="hidden" name="cat" value="<?php echo sanitize($category); ?>">
                        <?php endif; ?>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="q" value="<?php echo sanitize($search); ?>" class="form-control border-start-0" placeholder="Search blog articles...">
                            <button type="submit" class="btn btn-srku px-4">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Single Row Category Tabs (Never Cuts, Smooth Scroll) -->
            <div class="pt-3 border-top">
                <div class="srku-filter-row">
                    <a href="<?php echo BASE_URL; ?>blogs.php<?php echo $search ? '?q='.urlencode($search) : ''; ?>" 
                       class="srku-filter-btn <?php echo empty($category) ? 'active' : ''; ?>">
                        <i class="fas fa-th-large"></i> All Categories
                    </a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="<?php echo BASE_URL; ?>blogs.php?cat=<?php echo urlencode($cat); ?><?php echo $search ? '&q='.urlencode($search) : ''; ?>" 
                           class="srku-filter-btn <?php echo $category === $cat ? 'active' : ''; ?>">
                            <?php echo sanitize($cat); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php if ($search || $category): ?>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="text-muted mb-0 small">
                    Showing results for <strong><?php echo $category ? 'Category: ' . sanitize($category) : ''; ?><?php echo ($category && $search) ? ' & ' : ''; ?><?php echo $search ? 'Keyword: "' . sanitize($search) . '"' : ''; ?></strong>
                </p>
                <a href="<?php echo BASE_URL; ?>blogs.php" class="btn btn-sm btn-outline-secondary rounded-pill"><i class="fas fa-redo me-1"></i> Clear Filters</a>
            </div>
        <?php endif; ?>

        <!-- Blogs Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (!empty($blogsList)): ?>
                <?php foreach ($blogsList as $b): ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column hover-shadow transition-all bg-white">
                            <div class="position-relative overflow-hidden" style="height: 220px;">
                                <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($b['slug'] ?: $b['id']); ?>">
                                    <?php if (!empty($b['image_url'])): ?>
                                        <img src="<?php echo BASE_URL . sanitize($b['image_url']); ?>" 
                                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                             class="w-100 h-100 object-fit-cover transition-transform" alt="<?php echo sanitize($b['title']); ?>">
                                    <?php else: ?>
                                        <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp" 
                                             class="w-100 h-100 object-fit-cover transition-transform" alt="<?php echo sanitize($b['title']); ?>">
                                    <?php endif; ?>
                                </a>
                                <span class="position-absolute top-0 end-0 m-3 badge bg-danger shadow-sm px-3 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    <?php echo sanitize($b['category']); ?>
                                </span>
                            </div>

                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                                    <span><i class="far fa-calendar-alt text-warning me-1"></i> <?php echo date('d M Y', strtotime($b['publish_date'] ?: $b['created_at'])); ?></span>
                                    <span><i class="far fa-user text-danger me-1"></i> <?php echo sanitize($b['author'] ?: 'SRKU Desk'); ?></span>
                                </div>
                                <h3 class="h5 fw-bold text-navy mb-2 line-clamp-2" style="min-height: 48px;">
                                    <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($b['slug'] ?: $b['id']); ?>" class="text-decoration-none text-navy hover-text-danger">
                                        <?php echo sanitize($b['title']); ?>
                                    </a>
                                </h3>
                                <p class="text-muted small mb-4 flex-grow-1" style="line-height:1.7;">
                                    <?php 
                                    $desc = !empty($b['short_description']) ? $b['short_description'] : strip_tags($b['content']);
                                    echo substr($desc, 0, 130) . '...'; 
                                    ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($b['slug'] ?: $b['id']); ?>" class="btn btn-sm btn-outline-danger fw-bold rounded-pill px-3">
                                        Read Article <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                    <small class="text-muted"><i class="far fa-eye me-1"></i> <?php echo (int)($b['views'] ?? 0); ?> views</small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="card p-5 border-0 shadow-sm rounded-4 bg-white">
                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                        <h4 class="text-navy fw-bold">No articles found</h4>
                        <p class="text-muted">No blog posts matched your search criteria. Try choosing another category or keyword.</p>
                        <div>
                            <a href="<?php echo BASE_URL; ?>blogs.php" class="btn btn-srku rounded-pill px-4">Browse All Articles</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
