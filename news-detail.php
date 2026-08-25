<?php
require_once __DIR__ . '/includes/functions.php';

$id = (int)($_GET['id'] ?? 0);
$slug = sanitize($_GET['slug'] ?? '');

$notice = null;
if (!empty($slug)) {
    $notice = getNewsBySlug($slug);
}
if (!$notice && $id > 0) {
    $notice = getNewsBySlug($id);
}
if (!$notice) {
    // If still not found, fetch latest news notice
    $recentNotices = getNews(null, 1);
    if (!empty($recentNotices)) {
        $notice = $recentNotices[0];
    } else {
        header("Location: " . BASE_URL . "blogs.php");
        exit;
    }
}

$pageTitle = sanitize($notice['title']) . " | Official Circular | SRKU Bhopal";
$pageDesc = substr(strip_tags($notice['content'] ?? ''), 0, 160) ?: "Official announcement and circular published by Sarvepalli Radhakrishnan University, Bhopal.";
$pageKeywords = sanitize($notice['title']) . ", SRKU Notice, University Circular, " . sanitize($notice['category'] ?? 'Announcement');
$activeNav = "news";
require_once __DIR__ . '/includes/header.php';

$recentNews = getNews(null, 5);
$tickerNotices = getNews('Announcement', 4);
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('notice', 'Official Notice & Circular', 'Sarvepalli Radhakrishnan University Official Communication'); ?>

<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm border mb-0">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-navy text-decoration-none"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>news.php" class="text-navy text-decoration-none">Notice Board</a></li>
                <li class="breadcrumb-item active text-danger fw-bold text-truncate" style="max-width: 400px;" aria-current="page"><?php echo sanitize($notice['title']); ?></li>
            </ol>
        </nav>

        <div class="row g-4 g-lg-5">
            
            <!-- Left: Official Notice Document Card -->
            <div class="col-12 col-lg-8">
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white border-top border-4 border-danger">
                    
                    <!-- Notice Header Badge & Date -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-bold">
                                <i class="fas fa-bullhorn me-1"></i> <?php echo sanitize($notice['category'] ?? 'Official Notice'); ?>
                            </span>
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                Notice ID: #SRKU-<?php echo str_pad($notice['id'], 4, '0', STR_PAD_LEFT); ?>
                            </span>
                        </div>
                        <div class="text-muted small fw-semibold">
                            <i class="far fa-calendar-alt text-danger me-1"></i> Published: <?php echo date('F j, Y', strtotime($notice['publish_date'] ?: $notice['created_at'])); ?>
                        </div>
                    </div>

                    <!-- Notice Title -->
                    <h1 class="h3 fw-bold text-navy mb-4" style="line-height: 1.35;">
                        <?php echo sanitize($notice['title']); ?>
                    </h1>

                    <?php if (!empty($notice['image_url'])): ?>
                        <div class="mb-4 text-center">
                            <img src="<?php echo BASE_URL . sanitize($notice['image_url']); ?>" 
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';" 
                                 class="img-fluid rounded-4 shadow-sm border" style="max-height: 420px; object-fit: cover; width: 100%;" 
                                 alt="<?php echo sanitize($notice['title']); ?>">
                        </div>
                    <?php endif; ?>

                    <!-- Notice Content -->
                    <div class="notice-content text-dark mb-4" style="line-height: 1.85; font-size: 1.02rem;">
                        <?php echo nl2br(sanitize($notice['content'])); ?>
                    </div>

                    <!-- Official Disclaimer Box -->
                    <div class="p-3 bg-light rounded-3 border-start border-4 border-navy mt-4 mb-4 small text-muted">
                        <strong class="text-navy d-block mb-1"><i class="fas fa-shield-alt text-danger me-1"></i> Issued by: Office of the Registrar / Academic Council</strong>
                        This is an official university communication. For further assistance or clarifications regarding this notice, please contact the examination desk at <a href="mailto:exam@srku.edu.in" class="text-danger fw-semibold">exam@srku.edu.in</a>.
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pt-3 border-top">
                        <a href="javascript:window.print()" class="btn btn-outline-secondary btn-sm px-3 rounded-pill fw-semibold">
                            <i class="fas fa-print me-1"></i> Print Circular
                        </a>
                        <a href="<?php echo BASE_URL; ?>news.php" class="btn btn-srku btn-sm px-4 rounded-pill fw-bold">
                            <i class="fas fa-arrow-left me-1"></i> Back to Notice Board
                        </a>
                    </div>

                </div>
            </div>

            <!-- Right Sidebar: Recent Notices & Quick Downloads -->
            <div class="col-12 col-lg-4">
                
                <!-- Recent Notices Widget -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3 pb-2 border-bottom">
                        <i class="fas fa-bell text-danger me-2"></i> Recent Circulars
                    </h5>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($recentNews as $rn): ?>
                            <div class="d-flex gap-3 align-items-start pb-2 border-bottom">
                                <div class="bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; font-size: 1.1rem;">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1" style="font-size: 0.9rem; line-height: 1.35;">
                                        <a href="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo $rn['id']; ?>" class="text-navy text-decoration-none hover-text-danger fw-semibold">
                                            <?php echo sanitize($rn['title']); ?>
                                        </a>
                                    </h6>
                                    <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> <?php echo date('M d, Y', strtotime($rn['publish_date'] ?: $rn['created_at'])); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Admission Enquiry CTA Card -->
                <div class="card p-4 border-0 shadow-sm rounded-4 text-white text-center" style="background: linear-gradient(135deg, #7A0B0D 0%, #a31216 100%);">
                    <div class="bg-warning text-dark rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; font-size: 1.3rem;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Admissions Open 2026-27</h5>
                    <p class="small text-white-50 mb-3">Apply now for Engineering, Medical, Pharmacy, Nursing, Law &amp; Management programs.</p>
                    <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn btn-warning text-dark fw-bold rounded-pill w-100 py-2">
                        Apply Online Now <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
