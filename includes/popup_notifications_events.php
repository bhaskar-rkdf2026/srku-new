<?php
/**
 * Modern Compact Popup Modal for Latest Notifications & Single Creative Event Showcase
 * Sarvepalli Radhakrishnan University (SRKU), Bhopal
 * Fully connected to Database & Admin CMS (Active/Disable, Custom/Dynamic Events, Delay, etc.)
 */

require_once __DIR__ . '/functions.php';

// 1. Check if Popup is enabled in Database Settings
$popupEnabled = getSetting('popup_enabled', '1');
if ($popupEnabled !== '1') {
    return; // Popup is disabled by Administrator from CMS
}

// 2. Fetch Popup Settings from DB
$popupHeaderTitle = getSetting('popup_header_title', 'Campus Bulletin & Alerts');
$popupHeaderSubtitle = getSetting('popup_header_subtitle', 'Sarvepalli Radhakrishnan University (SRKU)');
$popupEventTitle = getSetting('popup_event_title', '');
$popupEventImage = getSetting('popup_event_image', '');
$popupEventLink = getSetting('popup_event_link', '');
$popupEventDate = getSetting('popup_event_date', '');
$popupEventCategory = getSetting('popup_event_category', '');
$popupDelaySec = (float) getSetting('popup_delay_sec', '1.2');
$popupDefaultTab = getSetting('popup_default_tab', 'events');
$popupShowOnceDay = getSetting('popup_show_once_day', '1');

// 3. Fetch Latest News & Events from Database for fallback
$popupEvents = [];
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT id, title, slug, category, publish_date, image_url, content FROM news ORDER BY publish_date DESC, id DESC LIMIT 5");
    $popupEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// Fallback featured event if none configured
$featuredEvent = !empty($popupEvents) ? $popupEvents[0] : [
    'id' => 1,
    'title' => 'Tarang 2026 - Annual Sports & Cultural Extravaganza',
    'slug' => 'tarang-annual-fest-2026',
    'category' => 'Campus Life',
    'publish_date' => '2026-08-15',
    'image_url' => 'assets/images/news4.jpg',
    'content' => ''
];

// Determine Active Event Details (Custom DB Override or Latest from DB)
if (!empty($popupEventTitle)) {
    $fTitle = $popupEventTitle;
    $firstDate = !empty($popupEventDate) ? strtotime($popupEventDate) : time();
    $fDay = date('d', $firstDate);
    $fMonth = strtoupper(date('M', $firstDate));
    $fImg = !empty($popupEventImage) ? (preg_match('/^https?:\/\//i', $popupEventImage) ? $popupEventImage : BASE_URL . ltrim($popupEventImage, '/')) : BASE_URL . 'assets/images/news4.jpg';
    $fLink = !empty($popupEventLink) ? (preg_match('/^https?:\/\//i', $popupEventLink) ? $popupEventLink : BASE_URL . ltrim($popupEventLink, '/')) : BASE_URL . 'news.php';
    $fCat = !empty($popupEventCategory) ? $popupEventCategory : 'Featured Event';
} else {
    $fTitle = $featuredEvent['title'];
    $firstDate = !empty($featuredEvent['publish_date']) ? strtotime($featuredEvent['publish_date']) : time();
    $fDay = date('d', $firstDate);
    $fMonth = strtoupper(date('M', $firstDate));
    $fImg = !empty($featuredEvent['image_url']) ? BASE_URL . ltrim($featuredEvent['image_url'], '/') : BASE_URL . 'assets/images/news4.jpg';
    $fSlug = !empty($featuredEvent['slug']) ? $featuredEvent['slug'] : $featuredEvent['id'];
    $fCat = !empty($featuredEvent['category']) ? $featuredEvent['category'] : 'Featured Event';
    $fLink = BASE_URL . 'news-detail.php?slug=' . urlencode($fSlug);
}

// 4. Fetch Latest Official Notices & Circulars from Database
$popupNotices = [];
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT id, title, category, external_url, file_path, publish_date FROM notices WHERE status = 1 ORDER BY publish_date DESC, id DESC LIMIT 6");
    $popupNotices = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// 5. Admission Notices & Important Links (Single-Column List Data)
$admissionNoticeItems = [
    [
        'title' => 'Admissions Open 2026-27: UG, PG, Diploma & Ph.D. Programs',
        'badge' => 'ADMISSIONS 2026',
        'badge_bg' => 'bg-danger text-white',
        'desc' => 'UGC-recognized degrees in Engineering, Pharmacy, Nursing, Law, Medicine & Management.',
        'btn_text' => 'Apply Online',
        'btn_type' => 'modal',
        'btn_target' => '#quickAdmissionModal',
        'btn_class' => 'btn-danger',
        'icon' => 'fas fa-edit'
    ],
    [
        'title' => 'Ph.D. Entrance Examination 2026 Guidelines & Online Application',
        'badge' => 'RESEARCH',
        'badge_bg' => 'bg-primary text-white',
        'desc' => 'Doctoral entrance test and fellowship admissions for session 2026-27.',
        'btn_text' => 'View Details',
        'btn_type' => 'link',
        'btn_target' => BASE_URL . 'phd-admission.php',
        'btn_class' => 'btn-outline-navy',
        'icon' => 'fas fa-user-graduate'
    ],
    [
        'title' => 'Official Fee Structure & Refund Policy for Academic Session 2026-27',
        'badge' => 'FEES & AID',
        'badge_bg' => 'bg-success text-white',
        'desc' => 'Approved schedule of course-wise tuition fees and hostel accommodations.',
        'btn_text' => 'View PDF',
        'btn_type' => 'link',
        'btn_target' => BASE_URL . 'document/fees-2026-27',
        'btn_class' => 'btn-outline-success',
        'icon' => 'fas fa-file-invoice-dollar'
    ],
    [
        'title' => 'University Information Prospectus 2026-27 (Complete Brochure)',
        'badge' => 'PROSPECTUS',
        'badge_bg' => 'bg-warning text-dark',
        'desc' => 'Detailed curriculum guide, lab facilities, placement records and faculty directory.',
        'btn_text' => 'Download',
        'btn_type' => 'link',
        'btn_target' => BASE_URL . 'document/prospectus',
        'btn_class' => 'btn-outline-dark',
        'icon' => 'fas fa-book-open'
    ],
    [
        'title' => 'AICTE Pragati & Saksham Scholarship Scheme for Girls & Divyangjan',
        'badge' => 'SCHOLARSHIP',
        'badge_bg' => 'bg-info text-dark',
        'desc' => 'National scholarship portal guidelines and university student support desk.',
        'btn_text' => 'View Circular',
        'btn_type' => 'link',
        'btn_target' => BASE_URL . 'document/meritorious-scheme-policy',
        'btn_class' => 'btn-outline-info',
        'icon' => 'fas fa-award'
    ]
];
?>

<!-- ═══════════════════════════════════════════════════════════════════
     COMPACT, MODERN CAMPUS NOTIFICATIONS & EVENT SHOWCASE POPUP
═══════════════════════════════════════════════════════════════════ -->
<div class="modal fade srku-compact-popup" id="campusEventsNotificationsModal" tabindex="-1" aria-labelledby="campusEventsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable srku-modal-compact-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden bg-white">
            
            <!-- Sleek Compact Header (Maroon-to-Navy Gradient) -->
            <div class="modal-header text-white px-3 py-2.5 border-0 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #7A0B0D 0%, #0F1E3B 100%);">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="popup-mini-badge rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center shadow-xs" style="width: 32px; height: 32px; min-width: 32px;">
                        <i class="fas fa-bullhorn" style="font-size: 0.9rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="campusEventsModalLabel" style="font-size: 1.05rem; letter-spacing: -0.2px;">
                            <?php echo sanitize($popupHeaderTitle); ?>
                        </h5>
                        <small class="text-white-50" style="font-size: 0.72rem;"><?php echo sanitize($popupHeaderSubtitle); ?></small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="font-size: 0.75rem;"></button>
            </div>

            <!-- Clean Segmented Tabs Bar -->
            <div class="bg-light border-bottom px-3 py-2">
                <ul class="nav nav-pills compact-nav-tabs nav-fill gap-1" id="bulletinCompactTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $popupDefaultTab === 'events' ? 'active' : ''; ?> rounded-pill fw-semibold py-1.5 px-2.5 text-truncate" id="pills-event-btn" data-bs-toggle="pill" data-bs-target="#pills-event-pane" type="button" role="tab" aria-controls="pills-event-pane" aria-selected="<?php echo $popupDefaultTab === 'events' ? 'true' : 'false'; ?>" style="font-size: 0.8rem;">
                            <i class="fas fa-calendar-star me-1 text-warning"></i> Events
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $popupDefaultTab === 'notices' ? 'active' : ''; ?> rounded-pill fw-semibold py-1.5 px-2.5 text-truncate" id="pills-notices-btn" data-bs-toggle="pill" data-bs-target="#pills-notices-pane" type="button" role="tab" aria-controls="pills-notices-pane" aria-selected="<?php echo $popupDefaultTab === 'notices' ? 'true' : 'false'; ?>" style="font-size: 0.8rem;">
                            <i class="fas fa-bell me-1 text-primary"></i> Notices <span class="badge bg-danger rounded-pill px-1.5 py-0.5 ms-1" style="font-size: 0.65rem;"><?php echo count($popupNotices); ?></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $popupDefaultTab === 'admissions' ? 'active' : ''; ?> rounded-pill fw-semibold py-1.5 px-2.5 text-truncate" id="pills-admission-btn" data-bs-toggle="pill" data-bs-target="#pills-admission-pane" type="button" role="tab" aria-controls="pills-admission-pane" aria-selected="<?php echo $popupDefaultTab === 'admissions' ? 'true' : 'false'; ?>" style="font-size: 0.8rem;">
                            <i class="fas fa-graduation-cap me-1 text-success"></i> Admissions 2026
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Modal Body with 3 Focused Views -->
            <div class="modal-body p-3 bg-white" style="max-height: 500px; overflow-y: auto;">
                <div class="tab-content" id="bulletinCompactTabContent">
                    
                    <!-- ═════════ TAB 1: SINGLE CREATIVE EVENT SHOWCASE ═════════ -->
                    <div class="tab-pane fade <?php echo $popupDefaultTab === 'events' ? 'show active' : ''; ?>" id="pills-event-pane" role="tabpanel" aria-labelledby="pills-event-btn">
                        <div class="single-event-container">
                            
                            <!-- Single Creative Image Box (Clickable Direct Link to Event) -->
                            <a href="<?php echo $fLink; ?>" class="d-block text-decoration-none position-relative rounded-3 overflow-hidden shadow-sm mb-2.5 featured-poster-frame" style="background:#0F1E3B;">
                                <img id="activeEventImage" 
                                     src="<?php echo $fImg; ?>" 
                                     alt="<?php echo sanitize($fTitle); ?>" 
                                     class="w-100 object-fit-cover transition-all" 
                                     style="height: 240px; display:block;"
                                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/images/news4.jpg';">

                                <!-- Floating Calendar Date Tag -->
                                <div class="position-absolute top-0 start-0 m-2.5 text-center rounded-2 overflow-hidden shadow date-float-tag">
                                    <div id="activeEventMonth" class="bg-danger text-white px-2 py-0.5 fw-bold text-uppercase" style="font-size: 0.62rem; letter-spacing: 0.5px;">
                                        <?php echo $fMonth; ?>
                                    </div>
                                    <div id="activeEventDay" class="bg-white text-navy px-2 py-0.5 fw-bold fs-6 lh-1">
                                        <?php echo $fDay; ?>
                                    </div>
                                </div>

                                <!-- Category Badge -->
                                <div class="position-absolute top-0 end-0 m-2.5">
                                    <span id="activeEventCategory" class="badge bg-dark bg-opacity-75 text-white backdrop-blur rounded-pill px-2.5 py-1" style="font-size: 0.7rem;">
                                        <i class="fas fa-star text-warning me-1"></i><?php echo sanitize($fCat); ?>
                                    </span>
                                </div>
                            </a>

                            <!-- Event Details: Title & Direct Redirect Action Only -->
                            <div class="px-1">
                                <h6 id="activeEventTitle" class="fw-bold text-navy mb-2" style="font-size: 1rem; line-height: 1.35;">
                                    <a href="<?php echo $fLink; ?>" class="text-navy text-decoration-none hover-maroon">
                                        <?php echo sanitize($fTitle); ?>
                                    </a>
                                </h6>
                                
                                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                    <span id="activeEventDateStr" class="small text-muted" style="font-size: 0.75rem;">
                                        <i class="far fa-calendar-alt text-danger me-1"></i> Date: <?php echo date('d M, Y', $firstDate); ?>
                                    </span>
                                    <a id="activeEventLink" href="<?php echo $fLink; ?>" class="btn btn-sm btn-danger rounded-pill px-3 py-1.5 fw-bold shadow-xs d-inline-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                                        <span>View Event Details</span> <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ═════════ TAB 2: SIMPLE 1-COLUMN LIST VIEW FOR NOTICES ═════════ -->
                    <div class="tab-pane fade <?php echo $popupDefaultTab === 'notices' ? 'show active' : ''; ?>" id="pills-notices-pane" role="tabpanel" aria-labelledby="pills-notices-btn">
                        <div class="d-flex flex-column gap-2">
                            <?php if (!empty($popupNotices)): ?>
                                <?php foreach ($popupNotices as $idx => $not): 
                                    $notDate = !empty($not['publish_date']) ? date('d M, Y', strtotime($not['publish_date'])) : date('d M, Y');
                                    $docLink = '#';
                                    if (!empty($not['external_url'])) {
                                        $docLink = (strpos($not['external_url'], 'http') === 0) ? $not['external_url'] : BASE_URL . ltrim($not['external_url'], '/');
                                    } elseif (!empty($not['file_path'])) {
                                        $docLink = BASE_URL . ltrim($not['file_path'], '/');
                                    }
                                    $isPdf = preg_match('/\.pdf$/i', $docLink);
                                ?>
                                <div class="notice-row-item p-2.5 rounded-3 bg-light border border-light-subtle d-flex align-items-center justify-content-between gap-2.5 transition-all">
                                    <div class="d-flex align-items-center gap-2.5 flex-grow-1 overflow-hidden">
                                        <div class="notice-bullet-icon rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center shadow-2xs" style="width: 32px; height: 32px; min-width: 32px;">
                                            <i class="fas <?php echo $isPdf ? 'fa-file-pdf' : 'fa-file-alt'; ?>" style="font-size: 0.85rem;"></i>
                                        </div>
                                        <div class="overflow-hidden">
                                            <div class="d-flex align-items-center gap-1.5 mb-0.5">
                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">
                                                    <?php echo sanitize($not['category'] ?? 'Notice'); ?>
                                                </span>
                                                <?php if ($idx < 2): ?>
                                                    <span class="badge bg-danger text-white rounded-pill px-1.5 py-0.5 fw-bold" style="font-size: 0.6rem;">NEW</span>
                                                <?php endif; ?>
                                                <span class="text-muted small" style="font-size: 0.72rem;">
                                                    <?php echo $notDate; ?>
                                                </span>
                                            </div>
                                            <a href="<?php echo sanitize($docLink); ?>" target="_blank" class="text-navy text-decoration-none fw-semibold d-block text-truncate hover-maroon" style="font-size: 0.84rem;">
                                                <?php echo sanitize($not['title']); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text-end text-nowrap">
                                        <a href="<?php echo sanitize($docLink); ?>" target="_blank" class="btn btn-xs btn-outline-danger rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.72rem;">
                                            <i class="fas <?php echo $isPdf ? 'fa-download' : 'fa-external-link-alt'; ?> me-0.5"></i> View
                                        </a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-4 text-muted small">
                                    No active notices available right now.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- ═════════ TAB 3: SIMPLE 1-COLUMN LIST VIEW FOR ADMISSIONS ═════════ -->
                    <div class="tab-pane fade <?php echo $popupDefaultTab === 'admissions' ? 'show active' : ''; ?>" id="pills-admission-pane" role="tabpanel" aria-labelledby="pills-admission-btn">
                        <div class="d-flex flex-column gap-2">
                            <?php foreach ($admissionNoticeItems as $adm): ?>
                            <div class="admission-row-item p-2.5 rounded-3 bg-light border border-light-subtle d-flex align-items-center justify-content-between gap-2.5 transition-all">
                                <div class="d-flex align-items-center gap-2.5 flex-grow-1 overflow-hidden">
                                    <div class="adm-icon-box rounded-circle bg-white border text-navy d-flex align-items-center justify-content-center shadow-2xs" style="width: 34px; height: 34px; min-width: 34px;">
                                        <i class="<?php echo $adm['icon']; ?>" style="font-size: 0.9rem;"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="d-flex align-items-center gap-1.5 mb-0.5">
                                            <span class="badge <?php echo $adm['badge_bg']; ?> rounded-pill px-2 py-0.5" style="font-size: 0.62rem; letter-spacing: 0.3px;">
                                                <?php echo $adm['badge']; ?>
                                            </span>
                                        </div>
                                        <h6 class="mb-0 fw-bold text-navy text-truncate" style="font-size: 0.84rem;">
                                            <?php echo sanitize($adm['title']); ?>
                                        </h6>
                                        <p class="text-secondary small mb-0 text-truncate" style="font-size: 0.74rem;">
                                            <?php echo sanitize($adm['desc']); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-end text-nowrap">
                                    <?php if ($adm['btn_type'] === 'modal'): ?>
                                        <button type="button" class="btn btn-xs <?php echo $adm['btn_class']; ?> rounded-pill px-2.5 py-1 fw-bold shadow-2xs" data-bs-toggle="modal" data-bs-target="<?php echo $adm['btn_target']; ?>" data-bs-dismiss="modal" style="font-size: 0.72rem;">
                                            <?php echo $adm['btn_text']; ?> &rarr;
                                        </button>
                                    <?php else: ?>
                                        <a href="<?php echo $adm['btn_target']; ?>" class="btn btn-xs <?php echo $adm['btn_class']; ?> rounded-pill px-2.5 py-1 fw-bold shadow-2xs" style="font-size: 0.72rem;">
                                            <?php echo $adm['btn_text']; ?> &rarr;
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Compact Modal Footer -->
            <div class="modal-footer bg-light px-3 py-2 border-top d-flex align-items-center justify-content-between">
                <?php if ($popupShowOnceDay === '1'): ?>
                <div class="form-check m-0">
                    <input class="form-check-input shadow-none" type="checkbox" id="srkuDismissBulletinToday" style="cursor: pointer; width: 14px; height: 14px;">
                    <label class="form-check-label text-muted" for="srkuDismissBulletinToday" style="cursor: pointer; font-size: 0.75rem; user-select: none;">
                        Don't show again today
                    </label>
                </div>
                <?php else: ?>
                <div></div>
                <?php endif; ?>
                
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 py-1 fw-semibold" data-bs-dismiss="modal" style="font-size: 0.78rem;">
                        Close
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════
     COMPACT POPUP STYLING (Scoped & Clean)
═══════════════════════════════════════════════════════════════════ -->
<style>
/* Dialog Width Constraint: Compact & Focused */
.srku-modal-compact-dialog {
    max-width: 600px !important;
    width: 92% !important;
    margin: 1.75rem auto;
}
@media (max-width: 576px) {
    .srku-modal-compact-dialog {
        max-width: 95% !important;
        margin: 0.75rem auto;
    }
}

/* Nav Tabs */
.compact-nav-tabs .nav-link {
    color: #475569;
    background: #e2e8f0;
    transition: all 0.2s ease;
}
.compact-nav-tabs .nav-link:hover {
    background: #cbd5e1;
    color: #0f172a;
}
.compact-nav-tabs .nav-link.active {
    background: #7A0B0D !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(122, 11, 13, 0.35);
}

/* Event poster container */
.featured-poster-frame {
    border: 1px solid #e2e8f0;
}
.date-float-tag {
    border: 1px solid rgba(255, 255, 255, 0.9);
    min-width: 40px;
}

/* Single-Column List Rows Hover */
.notice-row-item:hover, .admission-row-item:hover {
    background: #ffffff !important;
    border-color: #cbd5e1 !important;
    box-shadow: 0 3px 8px rgba(15, 30, 59, 0.06);
    transform: translateY(-1px);
}

.hover-maroon:hover {
    color: #7A0B0D !important;
}

/* Mini Buttons */
.btn-xs {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    line-height: 1.3;
}
.shadow-2xs {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
</style>

<!-- ═══════════════════════════════════════════════════════════════════
     EVENT AUTO-POPUP SCRIPT (Configured via CMS Settings)
═══════════════════════════════════════════════════════════════════ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('campusEventsNotificationsModal');
    if (!modalEl || typeof bootstrap === 'undefined') return;

    const delayMs = <?php echo max(300, (int)($popupDelaySec * 1000)); ?>;
    const showOnceDay = <?php echo $popupShowOnceDay === '1' ? 'true' : 'false'; ?>;
    const dismissCheckbox = document.getElementById('srkuDismissBulletinToday');
    const STORAGE_KEY = 'srku_events_popup_dismissed_until';

    function isPopupDismissed() {
        if (!showOnceDay) return false;
        try {
            const dismissedUntil = localStorage.getItem(STORAGE_KEY);
            if (dismissedUntil) {
                const expiry = parseInt(dismissedUntil, 10);
                if (Date.now() < expiry) {
                    return true;
                } else {
                    localStorage.removeItem(STORAGE_KEY);
                }
            }
        } catch (e) {}
        return false;
    }

    // Auto-launch popup after configured delay if not dismissed
    if (!isPopupDismissed()) {
        setTimeout(function() {
            if (!document.querySelector('.modal.show')) {
                const popupModal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: true
                });
                popupModal.show();
            }
        }, delayMs);
    }

    modalEl.addEventListener('hidden.bs.modal', function() {
        if (showOnceDay && dismissCheckbox && dismissCheckbox.checked) {
            try {
                // 24 hours dismissal
                const expiryTime = Date.now() + (24 * 60 * 60 * 1000);
                localStorage.setItem(STORAGE_KEY, expiryTime.toString());
            } catch (e) {}
        }
    });
});
</script>