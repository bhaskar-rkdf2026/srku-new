<?php
/**
 * Modern Responsive Popup Modal for Latest Notifications & Single Creative Event Showcase
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

// Determine Active Event Details
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

// 5. Admission Notices & Important Links with themes
// Resolver function to guarantee all notices and document links resolve to valid, existing URLs
if (!function_exists("resolvePopupDocLink")) {
    function resolvePopupDocLink($url, $filePath = "") {
        $raw = !empty($url) ? $url : $filePath;
        if (empty($raw)) return "#";
        if (preg_match("/^https?:\/\//i", $raw)) return $raw;

        $clean = ltrim($raw, "/");
        // Check exact path relative to root
        if (file_exists(__DIR__ . "/../" . $clean)) {
            return BASE_URL . $clean;
        }
        // If missing "assets/", check with "assets/"
        if (strpos($clean, "assets/") !== 0 && file_exists(__DIR__ . "/../assets/" . $clean)) {
            return BASE_URL . "assets/" . $clean;
        }
        $base = basename($clean);
        // Check in assets/uploads/2026/07/
        if (file_exists(__DIR__ . "/../assets/uploads/2026/07/" . $base)) {
            return BASE_URL . "assets/uploads/2026/07/" . $base;
        }
        // Check in assets/uploads/pdf/
        if (file_exists(__DIR__ . "/../assets/uploads/pdf/" . $base)) {
            return BASE_URL . "assets/uploads/pdf/" . $base;
        }
        // Check in assets/uploads/2026/updated-docs/
        if (file_exists(__DIR__ . "/../assets/uploads/2026/updated-docs/" . $base)) {
            return BASE_URL . "assets/uploads/2026/updated-docs/" . $base;
        }
        return BASE_URL . (strpos($clean, "assets/") === 0 ? $clean : "assets/" . $clean);
    }
}

// 5. Admission Notices & Important Links with themes
$admissionNoticeItems = [
    [
        'title' => 'Admissions Open 2026-27: UG, PG, Diploma & Ph.D. Programs',
        'badge' => 'ADMISSIONS 2026',
        'theme' => 'crimson',
        'desc' => 'UGC-recognized degrees in Engineering, Pharmacy, Nursing, Law, Medicine & Management.',
        'btn_text' => 'Apply Online',
        'btn_type' => 'modal',
        'btn_target' => '#quickAdmissionModal',
        'icon' => 'fas fa-graduation-cap'
    ],
    [
        'title' => 'Ph.D. Entrance Examination 2026 Guidelines & Online Application',
        'badge' => 'RESEARCH',
        'theme' => 'blue',
        'desc' => 'Doctoral entrance test and fellowship admissions for session 2026-27.',
        'btn_text' => 'View Details',
        'btn_type' => 'link',
        'btn_target' => BASE_URL . 'phd-admission.php',
        'target' => '_blank',
        'icon' => 'fas fa-microscope'
    ],
    [
        'title' => 'Official Fee Structure & Refund Policy for Academic Session 2026-27',
        'badge' => 'FEES & AID',
        'theme' => 'emerald',
        'desc' => 'Approved schedule of course-wise tuition fees and hostel accommodations.',
        'btn_text' => 'View PDF',
        'btn_type' => 'link',
        'btn_target' => BASE_URL . 'assets/uploads/2026/updated-docs/fees-2026-27.pdf',
        'target' => '_blank',
        'icon' => 'fas fa-file-invoice-dollar'
    ],
    [
        'title' => 'University Information Prospectus 2026-27 (Complete Brochure)',
        'badge' => 'PROSPECTUS',
        'theme' => 'amber',
        'desc' => 'Detailed curriculum guide, lab facilities, placement records and faculty directory.',
        'btn_text' => 'Download',
        'btn_type' => 'link',
        'btn_target' => BASE_URL . 'assets/uploads/2026/updated-docs/prospectus.pdf',
        'target' => '_blank',
        'download' => 'SRKU-Prospectus-2026-27.pdf',
        'icon' => 'fas fa-book-open'
    ],
    [
        'title' => 'AICTE Pragati & Saksham Scholarship Scheme for Girls & Divyangjan',
        'badge' => 'SCHOLARSHIP',
        'theme' => 'purple',
        'desc' => 'National scholarship portal guidelines and university student support desk.',
        'btn_text' => 'View Circular',
        'btn_type' => 'link',
        'btn_target' => BASE_URL . 'assets/uploads/2026/updated-docs/meritorious-scheme-policy.pdf',
        'target' => '_blank',
        'icon' => 'fas fa-award'
    ]
];
?>

<!-- ═══════════════════════════════════════════════════════════════════
     RESPONSIVE CAMPUS BULLETIN MODAL (Mobile-Optimized & Desktop-Spacious)
═══════════════════════════════════════════════════════════════════ -->
<div class="modal fade srku-compact-popup" id="campusEventsNotificationsModal" tabindex="-1" aria-labelledby="campusEventsModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable srku-modal-spacious-dialog">
        <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden bg-white">
            
            <!-- Sleek Header (Maroon-to-Navy Gradient) -->
            <div class="modal-header text-white px-3 px-sm-4 py-2.5 py-sm-3 border-0 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #7A0B0D 0%, #0F1E3B 100%);">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="popup-mini-badge rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 32px; height: 32px;">
                        <i class="fas fa-bullhorn" style="font-size: 0.9rem;"></i>
                    </div>
                    <div class="min-w-0">
                        <h5 class="modal-title fw-bold text-white mb-0 text-truncate" id="campusEventsModalLabel" style="font-size: 1.05rem; letter-spacing: -0.2px;">
                            <?php echo sanitize($popupHeaderTitle); ?>
                        </h5>
                        <small class="text-white-50 d-block text-truncate" style="font-size: 0.74rem;"><?php echo sanitize($popupHeaderSubtitle); ?></small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white shadow-none flex-shrink-0 ms-2" data-bs-dismiss="modal" aria-label="Close" style="font-size: 0.75rem;"></button>
            </div>

            <!-- Single-Row Non-Wrapping Segmented Tabs Bar -->
            <div class="popup-tabs-bar bg-light border-bottom px-2.5 px-sm-3 py-2">
                <ul class="nav nav-pills compact-nav-tabs nav-fill flex-nowrap" id="bulletinCompactTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $popupDefaultTab === 'events' ? 'active' : ''; ?> rounded-pill" id="pills-event-btn" data-bs-toggle="pill" data-bs-target="#pills-event-pane" type="button" role="tab" aria-controls="pills-event-pane" aria-selected="<?php echo $popupDefaultTab === 'events' ? 'true' : 'false'; ?>">
                            <i class="fas fa-calendar-star me-1 text-warning"></i><span>Events</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $popupDefaultTab === 'notices' ? 'active' : ''; ?> rounded-pill" id="pills-notices-btn" data-bs-toggle="pill" data-bs-target="#pills-notices-pane" type="button" role="tab" aria-controls="pills-notices-pane" aria-selected="<?php echo $popupDefaultTab === 'notices' ? 'true' : 'false'; ?>">
                            <i class="fas fa-bell me-1 text-primary"></i><span>Notices</span> <span class="badge bg-danger rounded-pill px-1.5 py-0.5 ms-0.5"><?php echo count($popupNotices); ?></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $popupDefaultTab === 'admissions' ? 'active' : ''; ?> rounded-pill" id="pills-admission-btn" data-bs-toggle="pill" data-bs-target="#pills-admission-pane" type="button" role="tab" aria-controls="pills-admission-pane" aria-selected="<?php echo $popupDefaultTab === 'admissions' ? 'true' : 'false'; ?>">
                            <i class="fas fa-graduation-cap me-1 text-success"></i><span>Admissions<span class="d-none d-md-inline"> 2026</span></span>
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Modal Body with Scrollable List -->
            <div class="modal-body p-2.5 p-sm-3.5" style="max-height: calc(85vh - 130px); overflow-y: auto; background-color: #f8fafc;">
                <div class="tab-content" id="bulletinCompactTabContent">
                    
                    <!-- ═════════ TAB 1: SINGLE CREATIVE EVENT SHOWCASE ═════════ -->
                    <div class="tab-pane fade <?php echo $popupDefaultTab === 'events' ? 'show active' : ''; ?>" id="pills-event-pane" role="tabpanel" aria-labelledby="pills-event-btn">
                        <div class="single-event-container bg-white p-2.5 p-sm-3 rounded-3 border border-slate-200 shadow-2xs">
                            
                            <!-- Single Creative Image Box -->
                            <a href="<?php echo $fLink; ?>" target="_blank" class="d-block text-decoration-none position-relative rounded-3 overflow-hidden shadow-sm mb-2.5 featured-poster-frame" style="background:#0F1E3B;">
                                <img id="activeEventImage" 
                                     src="<?php echo $fImg; ?>" 
                                     alt="<?php echo sanitize($fTitle); ?>" 
                                     class="w-100 object-fit-cover transition-all" 
                                     style="height: 220px; display:block;"
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

                            <!-- Event Details -->
                            <div class="px-1">
                                <h6 id="activeEventTitle" class="fw-bold text-navy mb-2" style="font-size: 0.96rem; line-height: 1.4;">
                                    <a href="<?php echo $fLink; ?>" target="_blank" class="text-navy text-decoration-none hover-maroon">
                                        <?php echo sanitize($fTitle); ?>
                                    </a>
                                </h6>
                                
                                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                    <span id="activeEventDateStr" class="text-muted fw-semibold small" style="font-size: 0.76rem;">
                                        <i class="far fa-calendar-alt text-danger me-1"></i> Date: <?php echo date('d M, Y', $firstDate); ?>
                                    </span>
                                    <a id="activeEventLink" href="<?php echo $fLink; ?>" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3 py-1 fw-bold shadow-xs d-inline-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                                        <span>View Details</span> <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ═════════ TAB 2: MOBILE-OPTIMIZED FULL-WIDTH TITLE NOTICES LIST ═════════ -->
                    <div class="tab-pane fade <?php echo $popupDefaultTab === 'notices' ? 'show active' : ''; ?>" id="pills-notices-pane" role="tabpanel" aria-labelledby="pills-notices-btn">
                        <div class="d-flex flex-column gap-2.5">
                            <?php if (!empty($popupNotices)): ?>
                                <?php foreach ($popupNotices as $idx => $not): 
                                    $timestamp = !empty($not['publish_date']) ? strtotime($not['publish_date']) : time();
                                    $notDate = date('d M, Y', $timestamp);
                                    $docLink = resolvePopupDocLink($not['external_url'] ?? '', $not['file_path'] ?? '');
                                    $isPdf = preg_match('/\.pdf$/i', $docLink);
                                    $cat = sanitize($not['category'] ?? 'Notice');
                                    $catClass = 'cat-default';
                                    if (stripos($cat, 'accred') !== false) $catClass = 'cat-blue';
                                    elseif (stripos($cat, 'gov') !== false) $catClass = 'cat-green';
                                    elseif (stripos($cat, 'app') !== false) $catClass = 'cat-amber';
                                    elseif (stripos($cat, 'comm') !== false) $catClass = 'cat-purple';
                                ?>
                                <div class="popup-notice-card">
                                    <!-- Top Row: Date Pill, Category Badge & Action Button -->
                                    <div class="notice-card-header d-flex align-items-center justify-content-between gap-2 mb-1.5">
                                        <div class="d-flex align-items-center gap-1.5 flex-wrap min-w-0">
                                            <span class="notice-date-pill">
                                                <i class="far fa-calendar-alt text-danger me-1"></i><?php echo $notDate; ?>
                                            </span>
                                            <span class="notice-cat-pill <?php echo $catClass; ?>">
                                                <?php echo $cat; ?>
                                            </span>
                                            <?php if ($idx < 2): ?>
                                                <span class="badge bg-danger text-white rounded-pill px-1.5 py-0.5 fw-bold" style="font-size: 0.6rem; letter-spacing: 0.4px;">NEW</span>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?php echo sanitize($docLink); ?>" target="_blank" class="notice-action-btn flex-shrink-0" title="View Document">
                                            <span>View</span>
                                            <i class="fas fa-arrow-up-right-from-square"></i>
                                        </a>
                                    </div>

                                    <!-- Bottom Row: Title spans the FULL width of the card! -->
                                    <a href="<?php echo sanitize($docLink); ?>" target="_blank" class="notice-card-title d-block">
                                        <i class="fas <?php echo $isPdf ? 'fa-file-pdf text-danger' : 'fa-file-alt text-primary'; ?> me-1.5 opacity-75"></i>
                                        <?php echo sanitize($not['title']); ?>
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-5 text-muted small bg-white rounded-3 border">
                                    <i class="fas fa-bell-slash fa-2x text-muted mb-2 d-block opacity-50"></i>
                                    No active notices available right now.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- ═════════ TAB 3: MOBILE-OPTIMIZED STRUCTURED ADMISSIONS LIST ═════════ -->
                    <div class="tab-pane fade <?php echo $popupDefaultTab === 'admissions' ? 'show active' : ''; ?>" id="pills-admission-pane" role="tabpanel" aria-labelledby="pills-admission-btn">
                        <div class="d-flex flex-column gap-2.5">
                            <?php foreach ($admissionNoticeItems as $adm): ?>
                            <div class="popup-adm-card">
                                <!-- Top Row: Icon + Badge on left, Action on right -->
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-1.5">
                                    <div class="d-flex align-items-center gap-2 min-w-0">
                                        <span class="adm-pill-icon theme-<?php echo $adm['theme']; ?> flex-shrink-0">
                                            <i class="<?php echo $adm['icon']; ?>"></i>
                                        </span>
                                        <span class="adm-cat-pill badge-<?php echo $adm['theme']; ?> text-truncate">
                                            <?php echo $adm['badge']; ?>
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <?php if ($adm['btn_type'] === 'modal'): ?>
                                            <button type="button" class="adm-action-btn btn-<?php echo $adm['theme']; ?>" data-bs-toggle="modal" data-bs-target="<?php echo $adm['btn_target']; ?>" data-bs-dismiss="modal">
                                                <span><?php echo $adm['btn_text']; ?></span>
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                        <?php else: ?>
                                            <a href="<?php echo $adm['btn_target']; ?>" <?php echo !empty($adm['target']) ? 'target="' . $adm['target'] . '"' : ''; ?> <?php echo !empty($adm['download']) ? 'download="' . $adm['download'] . '"' : ''; ?> class="adm-action-btn btn-<?php echo $adm['theme']; ?>" title="<?php echo sanitize($adm['title']); ?>">
                                                <span><?php echo $adm['btn_text']; ?></span>
                                                <i class="fas <?php echo !empty($adm['download']) ? 'fa-download' : 'fa-arrow-up-right-from-square'; ?>"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Full-Width Title & Description -->
                                <h6 class="adm-card-title mb-1">
                                    <?php if ($adm['btn_type'] === 'modal'): ?>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="<?php echo $adm['btn_target']; ?>" data-bs-dismiss="modal" class="text-navy text-decoration-none hover-maroon">
                                            <?php echo sanitize($adm['title']); ?>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo $adm['btn_target']; ?>" <?php echo !empty($adm['target']) ? 'target="' . $adm['target'] . '"' : ''; ?> <?php echo !empty($adm['download']) ? 'download="' . $adm['download'] . '"' : ''; ?> class="text-navy text-decoration-none hover-maroon">
                                            <?php echo sanitize($adm['title']); ?>
                                        </a>
                                    <?php endif; ?>
                                </h6>
                                <p class="adm-card-desc mb-0">
                                    <?php echo sanitize($adm['desc']); ?>
                                </p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Responsive Modal Footer -->
            <div class="modal-footer bg-white px-3 px-sm-4 py-2 border-top d-flex align-items-center justify-content-between">
                <?php if ($popupShowOnceDay === '1'): ?>
                <div class="form-check m-0">
                    <input class="form-check-input shadow-none" type="checkbox" id="srkuDismissBulletinToday" style="cursor: pointer; width: 14px; height: 14px;">
                    <label class="form-check-label text-muted small" for="srkuDismissBulletinToday" style="cursor: pointer; font-size: 0.74rem; user-select: none;">
                        Don't show again today
                    </label>
                </div>
                <?php else: ?>
                <div></div>
                <?php endif; ?>
                
                <div class="d-flex align-items-center gap-2">
                    <a href="<?php echo BASE_URL; ?>accreditation.php" class="text-maroon fw-semibold small text-decoration-none d-none d-sm-inline-flex align-items-center gap-1" style="font-size: 0.76rem;">
                        <span>All Circulars</span> <i class="fas fa-arrow-right" style="font-size: 0.68rem;"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-dark rounded-pill px-3.5 py-1 fw-semibold" data-bs-dismiss="modal" style="font-size: 0.78rem;">
                        Close
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════
     HIGH-END RESPONSIVE STYLING (Mobile-Perfect & Desktop-Spacious)
═══════════════════════════════════════════════════════════════════ -->
<style>
/* Proportional Dialog Sizing */
.srku-modal-spacious-dialog {
    max-width: 620px !important;
    width: 94% !important;
    margin: 1.5rem auto;
}
@media (max-width: 576px) {
    .srku-modal-spacious-dialog {
        width: 95% !important;
        margin: 0.6rem auto;
    }
}

/* Single-Row Tabs Bar (Never Wraps on Mobile!) */
.popup-tabs-bar .compact-nav-tabs {
    display: flex;
    flex-wrap: nowrap !important;
    gap: 6px;
    width: 100%;
}
.popup-tabs-bar .compact-nav-tabs .nav-item {
    flex: 1 1 0;
    min-width: 0;
}
.popup-tabs-bar .compact-nav-tabs .nav-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 7px 6px;
    font-size: 0.78rem;
    font-weight: 700;
    border-radius: 50px;
    white-space: nowrap;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    transition: all 0.2s ease;
}
.popup-tabs-bar .compact-nav-tabs .nav-link:hover {
    background: #f1f5f9;
    color: #0f172a;
}
.popup-tabs-bar .compact-nav-tabs .nav-link.active {
    background: linear-gradient(135deg, #8B0000 0%, #7A0B0D 100%) !important;
    color: #ffffff !important;
    border-color: #7A0B0D !important;
    box-shadow: 0 3px 10px rgba(122, 11, 13, 0.3);
}

@media (min-width: 576px) {
    .popup-tabs-bar .compact-nav-tabs {
        gap: 8px;
    }
    .popup-tabs-bar .compact-nav-tabs .nav-link {
        padding: 8px 14px;
        font-size: 0.84rem;
    }
}

/* Event Poster Frame */
.featured-poster-frame {
    border: 1px solid #e2e8f0;
}
.date-float-tag {
    border: 1px solid rgba(255, 255, 255, 0.9);
    min-width: 40px;
}

/* ==============================================================
   FULL-WIDTH NOTICES CARDS (Zero Horizontal Chocking!)
   ============================================================== */
.popup-notice-card {
    background: #ffffff;
    border: 1px solid #edf2f7;
    border-radius: 12px;
    padding: 10px 12px;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
}
.popup-notice-card:hover {
    border-color: #fca5a5;
    box-shadow: 0 5px 14px rgba(122, 11, 13, 0.08);
    transform: translateY(-1.5px);
}

/* Top Meta Elements */
.notice-date-pill {
    font-size: 0.68rem;
    font-weight: 700;
    color: #475569;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    padding: 2px 7px;
    border-radius: 9999px;
    display: inline-flex;
    align-items: center;
}
.notice-cat-pill {
    font-size: 0.62rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    padding: 2px 7px;
    border-radius: 9999px;
}
.cat-blue { background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }
.cat-green { background: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
.cat-amber { background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; }
.cat-purple { background: #faf5ff; color: #7e22ce; border: 1px solid #f3e8ff; }
.cat-default { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

/* Notice Card Title (100% Width Freedom) */
.notice-card-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: #0f1e3b;
    text-decoration: none;
    line-height: 1.4;
    transition: color 0.15s ease;
}
.notice-card-title:hover {
    color: #7A0B0D;
}
@media (min-width: 576px) {
    .popup-notice-card {
        padding: 12px 14px;
    }
    .notice-card-title {
        font-size: 0.92rem;
    }
    .notice-date-pill {
        font-size: 0.72rem;
    }
}

/* Action Button */
.notice-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    background: #f8fafc;
    color: #0F1E3B;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    font-size: 0.72rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.popup-notice-card:hover .notice-action-btn,
.notice-action-btn:hover {
    background: #7A0B0D;
    color: #ffffff !important;
    border-color: #7A0B0D;
    box-shadow: 0 3px 8px rgba(122, 11, 13, 0.25);
}

/* ==============================================================
   ADMISSIONS TAB CARDS (Mobile-Optimized)
   ============================================================== */
.popup-adm-card {
    background: #ffffff;
    border: 1px solid #edf2f6;
    border-radius: 12px;
    padding: 11px 13px;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
}
.popup-adm-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 5px 14px rgba(15, 30, 59, 0.07);
    transform: translateY(-1.5px);
}

.adm-pill-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
}
.adm-pill-icon.theme-crimson { background: #fee2e2; color: #dc2626; }
.adm-pill-icon.theme-blue { background: #eff6ff; color: #2563eb; }
.adm-pill-icon.theme-emerald { background: #ecfdf5; color: #059669; }
.adm-pill-icon.theme-amber { background: #fffbeb; color: #d97706; }
.adm-pill-icon.theme-purple { background: #f5f3ff; color: #7c3aed; }

.adm-cat-pill {
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    padding: 2px 7px;
    border-radius: 9999px;
    text-transform: uppercase;
}
.badge-crimson { background: #fee2e2; color: #991b1b; }
.badge-blue { background: #dbeafe; color: #1e40af; }
.badge-emerald { background: #d1fae5; color: #065f46; }
.badge-amber { background: #fef3c7; color: #92400e; }
.badge-purple { background: #ede9fe; color: #5b21b6; }

.adm-card-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: #0f1e3b;
    line-height: 1.35;
}
.adm-card-desc {
    font-size: 0.76rem;
    color: #64748b;
    line-height: 1.4;
}

.adm-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 9999px;
    font-size: 0.72rem;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    border: 1px solid transparent;
    transition: all 0.2s ease;
    cursor: pointer;
}
.btn-crimson { background: #7A0B0D; color: #ffffff; }
.btn-crimson:hover { background: #5c080a; color: #ffffff; box-shadow: 0 3px 8px rgba(122, 11, 13, 0.3); }

.btn-blue { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
.btn-blue:hover { background: #1d4ed8; color: #ffffff; }

.btn-emerald { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
.btn-emerald:hover { background: #047857; color: #ffffff; }

.btn-amber { background: #fffbeb; color: #b45309; border-color: #fde68a; }
.btn-amber:hover { background: #b45309; color: #ffffff; }

.btn-purple { background: #f5f3ff; color: #6d28d9; border-color: #ddd6fe; }
.btn-purple:hover { background: #6d28d9; color: #ffffff; }

@media (min-width: 576px) {
    .popup-adm-card {
        padding: 12px 14px;
    }
    .adm-card-title {
        font-size: 0.92rem;
    }
    .adm-card-desc {
        font-size: 0.78rem;
    }
    .adm-pill-icon {
        width: 32px;
        height: 32px;
        font-size: 0.95rem;
    }
    .adm-action-btn {
        padding: 5px 12px;
        font-size: 0.74rem;
    }
}

.hover-maroon:hover {
    color: #7A0B0D !important;
}
.text-maroon {
    color: #7A0B0D !important;
}
.shadow-2xs {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
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

    // Ensure the default tab configured in Admin is activated every time the modal is opened
    modalEl.addEventListener('show.bs.modal', function() {
        const defTab = '<?php echo $popupDefaultTab; ?>';
        const targetBtnId = (defTab === 'notices') ? 'pills-notices-btn' : ((defTab === 'admissions') ? 'pills-admission-btn' : 'pills-event-btn');
        const targetBtn = document.getElementById(targetBtnId);
        if (targetBtn && typeof bootstrap !== 'undefined' && bootstrap.Tab) {
            const tabInstance = bootstrap.Tab.getOrCreateInstance(targetBtn);
            tabInstance.show();
        }
    });

    // Dismissal listener (Don't show again today)
    if (dismissCheckbox) {
        dismissCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Set expiry for 24 hours from now
                const expireAt = Date.now() + (24 * 60 * 60 * 1000);
                try {
                    localStorage.setItem(STORAGE_KEY, expireAt.toString());
                } catch (e) {}
            } else {
                try {
                    localStorage.removeItem(STORAGE_KEY);
                } catch (e) {}
            }
        });
    }

    // Automatically trigger popup with configured delay if not dismissed
    setTimeout(function() {
        if (!isPopupDismissed()) {
            const bsModal = new bootstrap.Modal(modalEl);
            bsModal.show();
        }
    }, delayMs);
});
</script>
