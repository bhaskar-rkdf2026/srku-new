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
    $c = $img['category'] ?? 'Campus';
    if (isset($counts[$c])) {
        $counts[$c]++;
    } else {
        $counts['Campus']++;
    }
}
?>

<style>
/* Gallery Custom Styling */
.srku-gallery-card {
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
    position: relative;
    cursor: pointer;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.srku-gallery-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 32px rgba(169, 29, 39, 0.14);
}

.srku-gallery-thumb-wrap {
    position: relative;
    width: 100%;
    height: 270px;
    overflow: hidden;
    background: #111827;
}

.srku-gallery-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
}

.srku-gallery-card:hover .srku-gallery-thumb {
    transform: scale(1.08);
}

.srku-gallery-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(11,17,32,0.85) 100%);
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.srku-gallery-card:hover .srku-gallery-overlay {
    opacity: 0.95;
    background: linear-gradient(180deg, rgba(169, 29, 39, 0.2) 0%, rgba(11,17,32,0.92) 100%);
}

.srku-gallery-zoom-btn {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    color: #a91d27;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    opacity: 0;
    transform: scale(0.7);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.srku-gallery-card:hover .srku-gallery-zoom-btn {
    opacity: 1;
    transform: scale(1);
}

.srku-gallery-info {
    padding: 14px 16px 16px;
    background: #fff;
}

.srku-filter-pill {
    font-size: 0.85rem;
    padding: 8px 18px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.25s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #475569;
}

.srku-filter-pill:hover {
    background: #f8fafc;
    color: #a91d27;
    border-color: #cbd5e1;
}

.srku-filter-pill.active {
    background: #a91d27;
    color: #fff;
    border-color: #a91d27;
    box-shadow: 0 4px 12px rgba(169, 29, 39, 0.25);
}

.srku-filter-badge {
    font-size: 0.72rem;
    padding: 2px 7px;
    border-radius: 20px;
    background: rgba(0,0,0,0.08);
}

.srku-filter-pill.active .srku-filter-badge {
    background: rgba(255,255,255,0.25);
    color: #fff;
}

/* Lightbox Modal */
#galleryLightboxModal .modal-content {
    background: transparent;
    border: none;
}
#galleryLightboxModal .modal-body {
    padding: 0;
    position: relative;
}
#lightboxImg {
    max-height: 82vh;
    width: auto;
    max-width: 100%;
    margin: 0 auto;
    display: block;
    border-radius: 12px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.6);
}
.lightbox-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.2);
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 10;
}
.lightbox-nav-btn:hover {
    background: #a91d27;
    color: #fff;
}
.lightbox-prev { left: 10px; }
.lightbox-next { right: 10px; }
</style>

<!-- ═══════════════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════════════ -->
<section class="about-hero-v2">
    <div class="about-hero-v2__blob about-hero-v2__blob--1"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--2"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--3"></div>
    <div class="about-hero-v2__grid"></div>
    <div class="container-xl about-hero-v2__inner">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-warning"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">Gallery</li>
            </ol>
        </nav>
        <span class="about-hero-v2__eyebrow"><i class="fas fa-star"></i> Est. 1995 &middot; RKDF Education Society</span>
        <h1 class="about-hero-v2__title" style="max-width:800px;">Campus Photo &amp; <span>Facilities Gallery.</span></h1>
        <p class="about-hero-v2__desc" style="max-width:760px;">
            Glimpses of Academic Infrastructure, Sports Complex, Student Gymnasium &amp; Teaching Hospital.
        </p>
        <div class="d-flex flex-wrap gap-3">
            <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn-hero-yellow">Apply For Admission</a>
            <a href="<?php echo BASE_URL; ?>about.php" class="btn-hero-outline">About SRKU</a>
        </div>
    </div>
</section>

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

        <!-- Filter Tabs (Events removed, Gym added) -->
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-5" id="galleryFilterTabs">
            <button type="button" class="srku-filter-pill <?php echo empty($activeCategory) ? 'active' : ''; ?>" data-filter="all">
                <i class="fas fa-th-large"></i> All Photos
            </button>
            <button type="button" class="srku-filter-pill <?php echo $activeCategory == 'Campus' ? 'active' : ''; ?>" data-filter="Campus">
                <i class="fas fa-university"></i> Campus &amp; Architecture
            </button>
            <button type="button" class="srku-filter-pill <?php echo $activeCategory == 'Gym' ? 'active' : ''; ?>" data-filter="Gym">
                <i class="fas fa-dumbbell"></i> Gymnasium &amp; Fitness
            </button>
            <button type="button" class="srku-filter-pill <?php echo $activeCategory == 'Sports' ? 'active' : ''; ?>" data-filter="Sports">
                <i class="fas fa-running"></i> Sports Arena &amp; Courts
            </button>
            <button type="button" class="srku-filter-pill <?php echo $activeCategory == 'Medical' ? 'active' : ''; ?>" data-filter="Medical">
                <i class="fas fa-hospital-alt"></i> Medical &amp; Hospitals
            </button>
        </div>

        <!-- Gallery Grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="galleryGrid">
            <?php 
            $index = 0;
            foreach ($allImages as $item): 
                $itemCat = $item['category'] ?? 'Campus';
                $itemImg = $item['image_url'] ?? '';
                $fullImgUrl = resolveMediaUrl($itemImg, 'assets/uploads/2026/07/001.webp');
                $itemTitle = $item['title'] ?? 'SRKU Campus Photo';
                $catLabel = $categoryLabels[$itemCat] ?? $itemCat;
            ?>
                <div class="col gallery-item <?php echo (!empty($activeCategory) && $itemCat !== $activeCategory) ? 'd-none' : ''; ?>" data-category="<?php echo sanitize($itemCat); ?>">
                    <div class="srku-gallery-card h-100" onclick="openLightbox(<?php echo $index; ?>)">
                        <div class="srku-gallery-thumb-wrap">
                            <img src="<?php echo $fullImgUrl; ?>"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/campus-1.webp';"
                                 class="srku-gallery-thumb" 
                                 alt="SRKU Campus Photo">
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
    $itemCat = $item['category'] ?? 'Campus';
    return [
        'category' => $categoryLabels[$itemCat] ?? $itemCat,
        'cat_key' => $itemCat,
        'url' => resolveMediaUrl($item['image_url'] ?? '', 'assets/uploads/2026/07/001.webp')
    ];
}, $allImages))); ?>;

var currentLightboxIdx = 0;
var visibleIndices = [];

function updateVisibleIndices(filterCat) {
    visibleIndices = [];
    galleryData.forEach(function(item, idx) {
        if (filterCat === 'all' || item.cat_key === filterCat) {
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
            if (filter === 'all' || itemCat === filter) {
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
