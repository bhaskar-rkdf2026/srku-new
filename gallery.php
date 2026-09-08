<?php
$pageTitle = "Campus Life & Facilities Gallery | Photos & Infrastructure | SRKU Bhopal";
$pageDesc = "Take a visual tour of Sarvepalli Radhakrishnan University (SRKU) Bhopal: Modern campus architecture, air-conditioned auditorium, advanced medical hospital, student gymnasium, and championship sports arena.";
$pageKeywords = "SRKU Gallery, Campus Photos, University Gym, Sports Arena, Medical Hospital Gallery Bhopal, RKDF Campus Photos";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';

$activeCategory = sanitize($_GET['category'] ?? '');
$allImages = getGalleryImages();

// Category Definitions & Count Map
$categoryLabels = [
    'Campus'  => 'Campus & Architecture',
    'Gym'     => 'Gymnasium & Fitness',
    'Sports'  => 'Sports Arena & Courts',
    'Medical' => 'Medical & Hospitals'
];

$counts = [
    'all'     => count($allImages),
    'Campus'  => 0,
    'Gym'     => 0,
    'Sports'  => 0,
    'Medical' => 0
];

foreach ($allImages as $img) {
    $c = trim($img['category'] ?? 'Campus');
    if (empty($c)) $c = 'Campus';
    if (!isset($categoryLabels[$c])) {
        $categoryLabels[$c] = ucfirst($c);
    }
    if (!isset($counts[$c])) {
        $counts[$c] = 0;
    }
    $counts[$c]++;
}
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('gallery', 'Campus Photo & Facilities Gallery', 'Glimpses of Academic Infrastructure, Sports Complex, Student Gymnasium & Teaching Hospital'); ?>

<section class="py-5 bg-light-subtle">
    <div class="container-xl py-2">
        
        <!-- Top Stats / Header Summary Strip -->
        <div class="row align-items-center justify-content-between mb-4 g-3">
            <div class="col-12 col-md-auto">
                <h2 class="h3 fw-bold text-navy mb-1">
                    <i class="fas fa-camera-retro text-danger me-2"></i> Campus Tour in Pictures
                </h2>
                <p class="text-muted small mb-0">High-resolution glimpses of campus architecture, sports facilities, modern gym &amp; hospital wards.</p>
            </div>
            <div class="col-12 col-md-auto">
                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold" style="font-size: 0.88rem;">
                    <i class="fas fa-images me-1"></i> High-Definition Photos
                </span>
            </div>
        </div>

        <!-- Filter Tabs (Dynamic Categories from DB) -->
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-5" id="galleryFilterTabs">
            <button type="button" class="srku-filter-pill <?php echo empty($activeCategory) ? 'active' : ''; ?>" data-filter="all">
                <i class="fas fa-th-large"></i> All Photos <span class="srku-filter-badge"><?php echo $counts['all']; ?></span>
            </button>
            <?php foreach ($categoryLabels as $catKey => $catLabel): 
                if (($counts[$catKey] ?? 0) === 0) continue;
                $catIcon = 'fa-images';
                if (stripos($catKey, 'Campus') !== false) $catIcon = 'fa-university';
                elseif (stripos($catKey, 'Gym') !== false) $catIcon = 'fa-dumbbell';
                elseif (stripos($catKey, 'Sport') !== false) $catIcon = 'fa-running';
                elseif (stripos($catKey, 'Med') !== false || stripos($catKey, 'Hosp') !== false) $catIcon = 'fa-hospital-alt';
                elseif (stripos($catKey, 'Lab') !== false) $catIcon = 'fa-flask';
                elseif (stripos($catKey, 'Lib') !== false) $catIcon = 'fa-book-reader';
                elseif (stripos($catKey, 'Event') !== false) $catIcon = 'fa-calendar-alt';
            ?>
                <button type="button" class="srku-filter-pill <?php echo (strcasecmp($activeCategory, $catKey) === 0) ? 'active' : ''; ?>" data-filter="<?php echo sanitize($catKey); ?>">
                    <i class="fas <?php echo $catIcon; ?>"></i> <?php echo sanitize($catLabel); ?>
                    <span class="srku-filter-badge"><?php echo $counts[$catKey]; ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Gallery Grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="galleryGrid">
            <?php 
            $index = 0;
            foreach ($allImages as $item): 
                $itemCat = trim($item['category'] ?? 'Campus') ?: 'Campus';
                $itemImg = $item['image_url'] ?? ($item['image'] ?? ($item['file_path'] ?? ($item['img'] ?? ($item['photo'] ?? ''))));
                $fullImgUrl = resolveMediaUrl($itemImg, 'assets/uploads/2026/07/001.webp');
                $itemTitle = $item['title'] ?? 'SRKU Campus Photo';
                $catLabel = $categoryLabels[$itemCat] ?? $itemCat;
            ?>
                <div class="col gallery-item <?php echo (!empty($activeCategory) && strcasecmp($itemCat, $activeCategory) !== 0) ? 'd-none' : ''; ?>" data-category="<?php echo sanitize($itemCat); ?>">
                    <div class="srku-gallery-card h-100" onclick="openLightbox(<?php echo $index; ?>)">
                        <div class="srku-gallery-thumb-wrap">
                            <img src="<?php echo $fullImgUrl; ?>"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/campus-1.webp';"
                                 class="srku-gallery-thumb" 
                                 alt="<?php echo sanitize($itemTitle); ?>">
                            <div class="srku-gallery-overlay"></div>
                            <div class="srku-gallery-zoom-btn" title="View Fullscreen">
                                <i class="fas fa-expand-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                $index++;
            endforeach; 
            ?>
        </div>

        <!-- No Results Message (Hidden by default) -->
        <div id="noResultsMsg" class="text-center py-5 d-none">
            <i class="fas fa-images text-muted fa-3x mb-3"></i>
            <h5 class="text-navy fw-bold">No photos found in this category.</h5>
            <p class="text-muted small">Please select another category above to view photos.</p>
        </div>

    </div>
</section>

<!-- Modern Lightbox Modal -->
<div class="modal fade" id="galleryLightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 justify-content-between text-white px-3 pt-2">
                <div>
                    <span id="lightboxCategory" class="badge bg-danger px-3 py-1 rounded-pill small me-2"></span>
                    <span id="lightboxIndex" class="small text-white-50"></span>
                </div>
                <button type="button" class="btn btn-sm btn-dark rounded-circle shadow" data-bs-dismiss="modal" aria-label="Close" style="width:36px; height:36px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-2 position-relative text-center">
                <button type="button" class="lightbox-nav-btn lightbox-prev" onclick="prevLightbox(event)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <img id="lightboxImg" src="" alt="SRKU Gallery Fullsize">
                <button type="button" class="lightbox-nav-btn lightbox-next" onclick="nextLightbox(event)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            </div>
        </div>
    </div>
</div>

<script>
// Gallery Data for Lightbox
var galleryData = <?php echo json_encode(array_values(array_map(function($item) use ($categoryLabels) {
    $itemCat = trim($item['category'] ?? 'Campus') ?: 'Campus';
    $itemImg = $item['image_url'] ?? ($item['image'] ?? ($item['file_path'] ?? ($item['img'] ?? ($item['photo'] ?? ''))));
    return [
        'category' => $categoryLabels[$itemCat] ?? ucfirst($itemCat),
        'cat_key' => $itemCat,
        'url' => resolveMediaUrl($itemImg, 'assets/uploads/2026/07/001.webp')
    ];
}, $allImages))); ?>;

var currentLightboxIdx = 0;
var visibleIndices = [];

function updateVisibleIndices(filterCat) {
    visibleIndices = [];
    galleryData.forEach(function(item, idx) {
        if (filterCat === 'all' || item.cat_key.toLowerCase() === filterCat.toLowerCase()) {
            visibleIndices.push(idx);
        }
    });
}
updateVisibleIndices('<?php echo $activeCategory ?: "all"; ?>');

function openLightbox(index) {
    currentLightboxIdx = index;
    renderLightboxItem();
    var modalEl = document.getElementById('galleryLightboxModal');
    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}

function renderLightboxItem() {
    var item = galleryData[currentLightboxIdx];
    if (!item) return;
    document.getElementById('lightboxImg').src = item.url;
    document.getElementById('lightboxCategory').textContent = item.category;
    document.getElementById('lightboxIndex').textContent = (currentLightboxIdx + 1) + ' / ' + galleryData.length;
}

function nextLightbox(e) {
    if (e) e.stopPropagation();
    var currPos = visibleIndices.indexOf(currentLightboxIdx);
    if (currPos !== -1 && currPos < visibleIndices.length - 1) {
        currentLightboxIdx = visibleIndices[currPos + 1];
    } else {
        currentLightboxIdx = visibleIndices[0];
    }
    renderLightboxItem();
}

function prevLightbox(e) {
    if (e) e.stopPropagation();
    var currPos = visibleIndices.indexOf(currentLightboxIdx);
    if (currPos > 0) {
        currentLightboxIdx = visibleIndices[currPos - 1];
    } else {
        currentLightboxIdx = visibleIndices[visibleIndices.length - 1];
    }
    renderLightboxItem();
}

// Keyboard Navigation for Lightbox
document.addEventListener('keydown', function(e) {
    var modalEl = document.getElementById('galleryLightboxModal');
    if (modalEl && modalEl.classList.contains('show')) {
        if (e.key === 'ArrowRight') nextLightbox();
        if (e.key === 'ArrowLeft') prevLightbox();
    }
});

// Instant Client-Side Category Filtering
document.querySelectorAll('#galleryFilterTabs .srku-filter-pill').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('#galleryFilterTabs .srku-filter-pill').forEach(function(b) {
            b.classList.remove('active');
        });
        this.classList.add('active');

        var filter = this.getAttribute('data-filter');
        updateVisibleIndices(filter);

        var items = document.querySelectorAll('#galleryGrid .gallery-item');
        var visibleCount = 0;

        items.forEach(function(item) {
            var itemCat = item.getAttribute('data-category');
            if (filter === 'all' || itemCat.toLowerCase() === filter.toLowerCase()) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        var noRes = document.getElementById('noResultsMsg');
        if (visibleCount === 0) {
            noRes.classList.remove('d-none');
        } else {
            noRes.classList.add('d-none');
        }
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
