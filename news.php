<?php
$pageTitle = "Official Notice Board & Academic Circulars | SRKU Bhopal";
$pageDesc = "Stay updated with official academic circulars, exam notifications, admission announcements, and placement drives at Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = "SRKU Notice Board, University Circulars Bhopal, Exam Time Table SRKU, Admission Notices MP";
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

            <!-- Category Pills (Single Row, Never Cuts) -->
            <div class="pt-3 border-top">
                <div class="srku-filter-row">
                    <a href="<?php echo BASE_URL; ?>news.php" class="srku-filter-btn <?php echo empty($selectedCategory) ? 'active' : ''; ?>">
                        <i class="fas fa-bullhorn"></i> All Notices
                    </a>
                    <?php 
                    $dbCats = [];
try {
    $pdoConn = getDBConnection();
    if ($pdoConn) {
        $dbCats = $pdoConn->query("SELECT DISTINCT category FROM news WHERE category IS NOT NULL AND category != '' ORDER BY category ASC")->fetchAll(PDO::FETCH_COLUMN);
    }
} catch (Exception $e) {}
$cats = !empty($dbCats) ? $dbCats : ['Sports', 'Press Coverage', 'Examination', 'Admission'];
                    foreach ($cats as $cat):
                    ?>
                        <a href="<?php echo BASE_URL; ?>news.php?category=<?php echo urlencode($cat); ?>" class="srku-filter-btn <?php echo $selectedCategory === $cat ? 'active' : ''; ?>">
                            <?php echo $cat; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Notices List -->
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <?php if (!empty($filteredNews)): ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($filteredNews as $n): ?>
                            <div class="card p-3 p-md-4 border-0 shadow-sm rounded-4 bg-white hover-shadow" style="transition: all 0.25s ease;">
                                <div class="row g-3 align-items-center">
                                    <?php if (!empty($n['image_url'])): ?>
                                        <div class="col-12 col-md-4">
                                            <a href="javascript:void(0)" 
                                               class="d-block overflow-hidden rounded-3 border bg-light text-center p-1 position-relative open-news-modal group-zoom-trigger"
                                               data-bs-toggle="modal" 
                                               data-bs-target="#newsListModal"
                                               data-img="<?php echo BASE_URL . sanitize($n['image_url']); ?>"
                                               data-title="<?php echo htmlspecialchars($n['title'], ENT_QUOTES); ?>"
                                               data-date="<?php echo date('M d, Y', strtotime($n['publish_date'] ?: $n['created_at'])); ?>"
                                               data-detail="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo $n['id']; ?>"
                                               title="Click to view newspaper clipping in popup"
                                               style="max-height: 200px; cursor: pointer;">
                                                <img src="<?php echo BASE_URL . sanitize($n['image_url']); ?>" alt="<?php echo sanitize($n['title']); ?>" 
                                                     class="img-fluid w-100 object-fit-contain" style="max-height: 190px; transition: transform 0.25s ease;"
                                                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                                                <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark bg-opacity-75 text-white small px-2 py-1 rounded-pill">
                                                    <i class="fas fa-search-plus"></i> View Scan
                                                </span>
                                            </a>
                                        </div>
                                        <div class="col-12 col-md-8">
                                    <?php else: ?>
                                        <div class="col-12">
                                    <?php endif; ?>
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
                                            <?php echo mb_substr(strip_tags($n['content']), 0, 175) . '...'; ?>
                                        </p>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo $n['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">
                                                Read Full Coverage &rarr;
                                            </a>
                                            <?php if (!empty($n['image_url'])): ?>
                                                <button type="button" 
                                                        class="btn btn-sm btn-light border text-navy rounded-pill px-3 fw-semibold open-news-modal"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#newsListModal"
                                                        data-img="<?php echo BASE_URL . sanitize($n['image_url']); ?>"
                                                        data-title="<?php echo htmlspecialchars($n['title'], ENT_QUOTES); ?>"
                                                        data-date="<?php echo date('M d, Y', strtotime($n['publish_date'] ?: $n['created_at'])); ?>"
                                                        data-detail="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo $n['id']; ?>">
                                                    <i class="fas fa-search-plus text-danger me-1"></i> View Scan
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
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

<!-- Reusable News Clipping Lightbox Modal for News Listing -->
<div class="modal fade" id="newsListModal" tabindex="-1" aria-labelledby="newsListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg text-white" style="background: rgba(18, 22, 28, 0.96); backdrop-filter: blur(12px); border-radius: 16px;">
            <div class="modal-header border-bottom border-secondary border-opacity-25 py-2 px-3">
                <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                    <span class="badge bg-danger px-2 py-1 rounded-pill small flex-shrink-0">
                        <i class="fas fa-newspaper me-1"></i> Press Scan
                    </span>
                    <h6 class="modal-title text-truncate fw-semibold mb-0 text-white" id="newsListModalLabel" style="font-size: 0.95rem;">
                        Newspaper Clipping
                    </h6>
                </div>
                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1" id="newsListZoomBtn" title="Toggle 100% zoom">
                        <i class="fas fa-search-plus me-1" id="newsListZoomIcon"></i> <span id="newsListZoomText" class="d-none d-sm-inline">Zoom In</span>
                    </button>
                    <a href="#" download id="newsListDownloadBtn" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1" title="Download High-Res Scan">
                        <i class="fas fa-download me-1"></i> <span class="d-none d-sm-inline">Download</span>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body p-2 p-md-4 text-center position-relative d-flex align-items-center justify-content-center" style="min-height: 320px; max-height: 82vh; overflow-y: auto;">
                <img src="" 
                     alt="Newspaper Clipping" 
                     class="img-fluid rounded shadow" 
                     id="newsListModalImg"
                     style="max-height: 75vh; width: auto; max-width: 100%; object-fit: contain; cursor: zoom-in; transition: max-height 0.2s ease, width 0.2s ease;">
            </div>
            <div class="modal-footer border-top border-secondary border-opacity-25 py-2 px-3 justify-content-between text-white-50 small">
                <div id="newsListModalMeta">
                    <i class="far fa-calendar-alt me-1"></i> Press Release Scan
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="#" id="newsListDetailBtn" class="btn btn-outline-light btn-sm rounded-pill px-3">
                        Read Full Article &rarr;
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalImg = document.getElementById('newsListModalImg');
    var modalTitle = document.getElementById('newsListModalLabel');
    var modalMeta = document.getElementById('newsListModalMeta');
    var downloadBtn = document.getElementById('newsListDownloadBtn');
    var detailBtn = document.getElementById('newsListDetailBtn');
    var zoomBtn = document.getElementById('newsListZoomBtn');
    var zoomIcon = document.getElementById('newsListZoomIcon');
    var zoomText = document.getElementById('newsListZoomText');
    var isZoomed = false;

    function resetZoom() {
        isZoomed = false;
        if (modalImg) {
            modalImg.style.maxHeight = '75vh';
            modalImg.style.width = 'auto';
            modalImg.style.maxWidth = '100%';
            modalImg.style.cursor = 'zoom-in';
        }
        if (zoomIcon) zoomIcon.className = 'fas fa-search-plus me-1';
        if (zoomText) zoomText.textContent = 'Zoom In';
    }

    function toggleZoom() {
        if (!modalImg) return;
        isZoomed = !isZoomed;
        if (isZoomed) {
            modalImg.style.maxHeight = 'none';
            modalImg.style.width = '100%';
            modalImg.style.maxWidth = '1150px';
            modalImg.style.cursor = 'zoom-out';
            if (zoomIcon) zoomIcon.className = 'fas fa-search-minus me-1';
            if (zoomText) zoomText.textContent = 'Zoom Out';
        } else {
            resetZoom();
        }
    }

    if (zoomBtn) zoomBtn.addEventListener('click', toggleZoom);
    if (modalImg) modalImg.addEventListener('click', toggleZoom);

    document.querySelectorAll('.open-news-modal').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            var imgSrc = this.getAttribute('data-img');
            var title = this.getAttribute('data-title');
            var date = this.getAttribute('data-date');
            var detail = this.getAttribute('data-detail');

            if (modalImg) modalImg.src = imgSrc;
            if (modalTitle) modalTitle.textContent = title;
            if (modalMeta) modalMeta.innerHTML = '<i class="far fa-calendar-alt me-1"></i> ' + (date || '') + ' &bull; Click image or Zoom button to toggle 100% view';
            if (downloadBtn) {
                downloadBtn.href = imgSrc;
                downloadBtn.setAttribute('download', title ? title.replace(/[^a-zA-Z0-9_-]/g, '_') : 'newspaper-scan');
            }
            if (detailBtn) {
                detailBtn.href = detail;
            }
            resetZoom();
        });
    });

    var modalEl = document.getElementById('newsListModal');
    if (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', resetZoom);
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
