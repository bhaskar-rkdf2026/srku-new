<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? '');
if (empty($slug)) {
    header("Location: " . BASE_URL . "blogs.php");
    exit;
}

$article = getBlogBySlug($slug);

// Fallback to news table if slug was from news
if (!$article) {
    $newsArticle = getNewsBySlug($slug);
    if ($newsArticle) {
        $article = [
            'id' => $newsArticle['id'],
            'title' => $newsArticle['title'],
            'slug' => $newsArticle['slug'] ?: $newsArticle['id'],
            'author' => 'SRKU University Desk',
            'category' => $newsArticle['category'] ?: 'News & Notice',
            'short_description' => substr(strip_tags($newsArticle['content'] ?? ''), 0, 200),
            'content' => $newsArticle['content'] ?? '',
            'image_url' => $newsArticle['image_url'] ?? '',
            'publish_date' => $newsArticle['publish_date'] ?: $newsArticle['created_at'],
            'views' => 120
        ];
    }
}

if (!$article) {
    header("Location: " . BASE_URL . "blogs.php");
    exit;
}

$pageTitle = sanitize($article['title']) . " | SRKU Blog & Articles";
$pageDesc = sanitize($article['short_description'] ?? substr(strip_tags($article['content']), 0, 160));
$pageKeywords = sanitize($article['title']) . ", SRKU Article, University Blog, " . sanitize($article['category'] ?? 'Campus Life');
$pageImage = !empty($article['image_url']) ? (strpos($article['image_url'], 'http') === 0 ? $article['image_url'] : BASE_URL . $article['image_url']) : null;
$activeNav = "blogs";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Schema.org BlogPosting Structured Data for Google News, Search & AI Engine Citations -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": <?php echo json_encode($article['title']); ?>,
  "description": <?php echo json_encode($pageDesc); ?>,
  "image": <?php echo json_encode($pageImage ?: BASE_URL . 'assets/uploads/2026/07/campus-1.webp'); ?>,
  "datePublished": <?php echo json_encode(date('c', strtotime($article['publish_date'] ?? 'now'))); ?>,
  "author": {
    "@type": "Organization",
    "name": <?php echo json_encode($article['author'] ?? 'SRKU Editorial Desk') ?>
  },
  "publisher": {
    "@type": "CollegeOrUniversity",
    "name": "Sarvepalli Radhakrishnan University",
    "logo": {
      "@type": "ImageObject",
      "url": "https://srku.edu.in/assets/uploads/2026/07/SRK-logo.webp"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": <?php echo json_encode($currentUrl); ?>
  }
}
</script>
<?php
// Fetch recent & related blogs
$recentBlogs = getBlogs(null, 5);
$relatedBlogs = getBlogs($article['category'], 4);
?>

<!-- Dynamic Banner Header -->
<div class="py-5 text-white position-relative" style="background: linear-gradient(135deg, #0e1f45 0%, #18183d 50%, #7a0b0d 100%);">
    <div class="container-xl py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-white-50 text-decoration-none"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>blogs.php" class="text-white-50 text-decoration-none">Blogs &amp; Insights</a></li>
                <li class="breadcrumb-item active text-warning" aria-current="page"><?php echo sanitize($article['category'] ?: 'Article'); ?></li>
            </ol>
        </nav>
        <span class="badge bg-warning text-dark px-3 py-2 mb-3 fw-bold text-uppercase rounded-pill" style="font-size:0.78rem;">
            <i class="fas fa-tag me-1"></i> <?php echo sanitize($article['category'] ?: 'General'); ?>
        </span>
        <h1 class="fw-bold display-6 mb-3 text-white" style="line-height: 1.3; max-width: 950px;"><?php echo sanitize($article['title']); ?></h1>
        <div class="d-flex flex-wrap align-items-center gap-4 text-white-50 small">
            <span><i class="far fa-user text-warning me-1"></i> By <strong><?php echo sanitize($article['author'] ?: 'SRKU Editorial Board'); ?></strong></span>
            <span><i class="far fa-calendar-alt text-warning me-1"></i> Published: <?php echo date('d F Y', strtotime($article['publish_date'] ?: $article['created_at'])); ?></span>
            <span><i class="far fa-eye text-warning me-1"></i> <?php echo (int)($article['views'] ?? 0); ?> Reads</span>
            <span><i class="far fa-clock text-warning me-1"></i> ~4 Min Read</span>
        </div>
    </div>
</div>

<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="row g-4 g-lg-5">
            
            <!-- Main Article Column -->
            <div class="col-12 col-lg-8">
                <article class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white">
                    
                    <?php if (!empty($article['image_url'])): ?>
                        <div class="rounded-4 overflow-hidden mb-4 shadow-sm" style="max-height: 480px;">
                            <img src="<?php echo BASE_URL . sanitize($article['image_url']); ?>" 
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                 class="w-100 h-100 object-fit-cover" alt="<?php echo sanitize($article['title']); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($article['short_description'])): ?>
                        <div class="lead fw-normal text-muted mb-4 p-3 bg-light rounded-3 border-start border-4 border-danger" style="font-size: 1.1rem; line-height: 1.8;">
                            <?php echo nl2br(sanitize($article['short_description'])); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Article Body Content -->
                    <div class="article-content text-dark" style="line-height: 1.95; font-size: 1.05rem;">
                        <?php echo $article['content']; ?>
                    </div>

                    <!-- Social Sharing & Tags -->
                    <div class="mt-5 pt-4 border-top">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold text-navy small"><i class="fas fa-share-alt me-1 text-danger"></i> Share Article:</span>
                                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($article['title'] . ' ' . $currentUrl); ?>" target="_blank" class="btn btn-sm btn-outline-success rounded-circle" style="width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center;" title="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($currentUrl); ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" style="width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center;" title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($currentUrl); ?>&title=<?php echo urlencode($article['title']); ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-circle" style="width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center;" title="Share on LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="<?php echo BASE_URL; ?>blogs.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Blogs
                                </a>
                            </div>
                        </div>
                    </div>

                </article>

                <!-- Related Articles Grid -->
                <?php 
                $otherRelated = array_filter($relatedBlogs, fn($r) => $r['id'] != $article['id']);
                if (!empty($otherRelated)): 
                ?>
                    <div class="mt-5">
                        <h4 class="h5 fw-bold text-navy mb-4"><i class="fas fa-newspaper text-danger me-2"></i> Related Articles in <?php echo sanitize($article['category']); ?></h4>
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            <?php foreach (array_slice($otherRelated, 0, 2) as $rel): ?>
                                <div class="col">
                                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                                        <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($rel['slug'] ?: $rel['id']); ?>">
                                            <img src="<?php echo BASE_URL . sanitize($rel['image_url'] ?: 'assets/uploads/2026/07/001.webp'); ?>" 
                                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                                 class="w-100 object-fit-cover" style="height: 160px;" alt="<?php echo sanitize($rel['title']); ?>">
                                        </a>
                                        <div class="p-3 d-flex flex-column flex-grow-1">
                                            <small class="text-muted mb-1"><i class="far fa-calendar-alt text-warning me-1"></i> <?php echo date('d M Y', strtotime($rel['publish_date'] ?: $rel['created_at'])); ?></small>
                                            <h6 class="fw-bold mb-2">
                                                <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($rel['slug'] ?: $rel['id']); ?>" class="text-navy text-decoration-none hover-text-danger">
                                                    <?php echo sanitize($rel['title']); ?>
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Right Sidebar Column -->
            <div class="col-12 col-lg-4">
                
                <!-- Author / University Desk Box -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-navy text-white d-flex align-items-center justify-content-center p-3" style="width:52px; height:52px;">
                            <i class="fas fa-university fa-lg text-warning"></i>
                        </div>
                        <div>
                            <h5 class="h6 fw-bold text-navy mb-0">SRKU Media &amp; Research Desk</h5>
                            <small class="text-muted">Bhopal, Madhya Pradesh</small>
                        </div>
                    </div>
                    <p class="text-muted small mb-0" style="line-height: 1.6;">
                        Delivering verified academic news, breakthroughs in healthcare, engineering research highlights, and campus culture stories directly from Sarvepalli Radhakrishnan University.
                    </p>
                </div>

                <!-- Recent Articles List -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-white">
                    <h5 class="h6 fw-bold text-navy mb-3 pb-2 border-bottom"><i class="fas fa-fire text-danger me-2"></i> Recent Articles</h5>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($recentBlogs as $rn): ?>
                            <div class="d-flex gap-3 align-items-start pb-3 border-bottom border-light">
                                <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($rn['slug'] ?: $rn['id']); ?>" class="flex-shrink-0">
                                    <img src="<?php echo BASE_URL . sanitize($rn['image_url'] ?: 'assets/uploads/2026/07/001.webp'); ?>" 
                                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                         class="rounded-3 object-fit-cover" style="width: 70px; height: 60px;" alt="<?php echo sanitize($rn['title']); ?>">
                                </a>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="font-size: 0.88rem; line-height: 1.4;">
                                        <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($rn['slug'] ?: $rn['id']); ?>" class="text-decoration-none text-dark hover-text-danger">
                                            <?php echo sanitize($rn['title']); ?>
                                        </a>
                                    </h6>
                                    <small class="text-muted"><i class="far fa-calendar-alt me-1 text-warning"></i> <?php echo date('M d, Y', strtotime($rn['publish_date'] ?: $rn['created_at'])); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Admission CTA Widget -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 text-white text-center" style="background: linear-gradient(135deg, #7a0b0d, #d62529);">
                    <div class="mb-3">
                        <i class="fas fa-graduation-cap fa-3x text-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Admissions Open 2026-27</h5>
                    <p class="text-white-50 small mb-3">Join 95+ undergraduate, postgraduate, and doctoral degree programs at SRKU.</p>
                    <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn btn-warning fw-bold text-dark w-100 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-file-signature me-1"></i> Apply Online Now
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
