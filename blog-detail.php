<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? '1');
$pdo = getDBConnection();
$stmt = $pdo->prepare("SELECT * FROM news WHERE slug = :s OR id = :s LIMIT 1");
$stmt->execute([':s' => $slug]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: " . BASE_URL . "blogs.php");
    exit;
}

$pageTitle = $article['title'] . " - SRK University";
$activeNav = "blogs";
require_once __DIR__ . '/includes/header.php';

$recentNews = getNews(null, 5);
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <span class="badge bg-warning text-dark px-3 py-1 mb-2 fw-bold"><?php echo sanitize($article['category']); ?></span>
        <h1 class="fw-bold display-6 mb-2"><?php echo sanitize($article['title']); ?></h1>
        <p class="text-white-50 small mb-0"><i class="far fa-calendar-alt me-1 text-warning"></i> Published on <?php echo date('d F Y', strtotime($article['publish_date'] ?: $article['created_at'])); ?></p>
    </div>
</div>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row g-4 g-lg-5">
            
            <!-- Main Article Column -->
            <div class="col-12 col-lg-8">
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4">
                    <?php if (!empty($article['image_url'])): ?>
                        <img src="<?php echo BASE_URL . sanitize($article['image_url']); ?>" 
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                             class="img-fluid rounded-4 mb-4" alt="<?php echo sanitize($article['title']); ?>">
                    <?php endif; ?>

                    <div class="article-content text-dark" style="line-height:1.9; font-size:1.02rem;">
                        <?php echo nl2br($article['content']); ?>
                    </div>

                    <div class="mt-5 pt-4 border-top d-flex justify-content-between align-items-center">
                        <a href="<?php echo BASE_URL; ?>blogs.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to News</a>
                        <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku btn-sm"><i class="fas fa-paper-plane me-1"></i> Admission Enquiry</a>
                    </div>
                </div>
            </div>

            <!-- Recent News Sidebar -->
            <div class="col-12 col-lg-4">
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4">
                    <h4 class="h5 fw-bold text-navy mb-3"><i class="fas fa-newspaper text-danger me-2"></i> Recent Announcements</h4>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($recentNews as $rn): 
                            if ($rn['id'] == $article['id']) continue;
                        ?>
                            <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($rn['slug'] ?: $rn['id']); ?>" class="text-decoration-none border-bottom pb-2">
                                <div class="text-danger small fw-semibold"><?php echo sanitize($rn['category']); ?> &bull; <?php echo date('M d', strtotime($rn['publish_date'] ?: $rn['created_at'])); ?></div>
                                <div class="text-navy fw-bold small" style="line-height:1.4;"><?php echo sanitize($rn['title']); ?></div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="card p-4 border-0 shadow-sm rounded-4 bg-maroon text-white text-center">
                    <h5 class="fw-bold text-warning mb-2">Admissions 2026-27</h5>
                    <p class="text-white-50 small mb-3">Enquire now for merit seats in Engineering, Pharmacy, Nursing, Law &amp; Management.</p>
                    <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-warning btn-sm fw-bold text-dark">Apply Online</a>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
