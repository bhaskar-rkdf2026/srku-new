<?php
require_once __DIR__ . '/../includes/functions.php';
checkAdminLogin();

$pdo = getDBConnection();

// Ensure inventory is initialized
$stats = getSeoSummaryStats($pdo);

// ---------------------------------------------------------
// AJAX API ENDPOINTS
// ---------------------------------------------------------
if (isset($_REQUEST['ajax_action'])) {
    if (ob_get_length()) ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    $action = $_REQUEST['ajax_action'];

    // 1. Get Single Page SEO Record
    if ($action === 'get_seo') {
        $id = (int)($_REQUEST['id'] ?? 0);
        $stmt = $pdo->prepare("SELECT * FROM seo_metadata WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Page record not found.']);
        }
        exit;
    }

    // 2. Save Page SEO Changes
    if ($action === 'save_seo') {
        $res = savePageSeoMetadata($_POST, $pdo);
        if ($res['success']) {
            $stmt = $pdo->prepare("SELECT * FROM seo_metadata WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $res['id']]);
            $updatedRow = $stmt->fetch(PDO::FETCH_ASSOC);
            $newStats = getSeoSummaryStats($pdo);
            echo json_encode([
                'success' => true,
                'message' => 'SEO metadata saved successfully!',
                'data' => $updatedRow,
                'stats' => $newStats
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => $res['error'] ?? 'Failed to save SEO metadata.']);
        }
        exit;
    }

    // 3. Toggle Global Indexing (Development vs Live Mode)
    if ($action === 'toggle_global_indexing') {
        $curr = getSetting('global_robots_indexing', 'noindex, nofollow');
        $isLiveNow = (strpos($curr, 'index, follow') !== false || strpos($curr, 'index') !== false) && strpos($curr, 'noindex') === false;

        if ($isLiveNow) {
            $newSetting = 'noindex, nofollow';
            $newMode = 'development';
            $msg = 'Switched to Development Mode (noindex, nofollow). Search bots are blocked.';
        } else {
            $newSetting = 'index, follow';
            $newMode = 'live';
            $msg = 'Switched to Live Production Mode (index, follow). Website is discoverable by search engines.';
        }

        // Update settings in database
        $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES ('global_robots_indexing', :v1) ON DUPLICATE KEY UPDATE setting_value = :v2")
            ->execute([':v1' => $newSetting, ':v2' => $newSetting]);
        $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES ('global_seo_mode', :m1) ON DUPLICATE KEY UPDATE setting_value = :m2")
            ->execute([':m1' => $newMode, ':m2' => $newMode]);

        $newStats = getSeoSummaryStats($pdo);
        echo json_encode([
            'success' => true,
            'message' => $msg,
            'global_robots' => $newSetting,
            'is_live' => !$isLiveNow,
            'stats' => $newStats
        ]);
        exit;
    }

    // 4. Re-scan and Sync Pages Inventory
    if ($action === 'resync_inventory') {
        $syncRes = syncSeoPagesInventory($pdo, true);
        $newStats = getSeoSummaryStats($pdo);
        echo json_encode([
            'success' => true,
            'message' => "SEO Pages Inventory synchronized! Total {$syncRes['total']} routes verified ({$syncRes['added']} newly indexed).",
            'stats' => $newStats
        ]);
        exit;
    }

    // 5. Add Custom Route
    if ($action === 'add_custom_route') {
        $res = savePageSeoMetadata($_POST, $pdo);
        $newStats = getSeoSummaryStats($pdo);
        echo json_encode([
            'success' => $res['success'],
            'message' => $res['success'] ? 'New route added to SEO inventory!' : ($res['error'] ?? 'Failed to add route.'),
            'stats' => $newStats
        ]);
        exit;
    }

    // 6. Delete Route
    if ($action === 'delete_route') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM seo_metadata WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $newStats = getSeoSummaryStats($pdo);
        echo json_encode([
            'success' => true,
            'message' => 'Route removed from SEO inventory.',
            'stats' => $newStats
        ]);
        exit;
    }

    echo json_encode(['success' => false, 'error' => 'Invalid action.']);
    exit;
}

// Fetch all SEO records
$allPages = $pdo->query("SELECT * FROM seo_metadata ORDER BY 
    CASE 
        WHEN page_category = 'Portal Pages' THEN 1
        WHEN page_category = 'Core & Database' THEN 2
        WHEN page_category = 'CMS Generic' THEN 3
        WHEN page_category = 'Academic & Exam' THEN 4
        WHEN page_category = 'Static Showcase' THEN 5
        ELSE 6
    END ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/header.php';
?>

<!-- Custom Styling for SEO Manager Dashboard -->
<style>
.seo-header-card {
    background: linear-gradient(135deg, #0b1f44 0%, #1e3a8a 100%);
    border-radius: 16px;
    color: #ffffff;
    box-shadow: 0 10px 25px -5px rgba(11, 31, 68, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.crawling-status-card {
    border-radius: 14px;
    transition: all 0.3s ease;
}
.crawling-status-card.dev-mode {
    background: #fffbeb;
    border: 2px solid #f59e0b;
}
.crawling-status-card.live-mode {
    background: #f0fdf4;
    border: 2px solid #10b981;
}

.stat-card-seo {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px 18px;
    transition: all 0.25s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
}
.stat-card-seo:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.06);
    border-color: #cbd5e1;
}
.stat-icon-wrapper {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.seo-filter-tab {
    padding: 8px 18px;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 600;
    color: #475569;
    background: #f1f5f9;
    border: 1px solid transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.seo-filter-tab:hover {
    background: #e2e8f0;
    color: #0f172a;
}
.seo-filter-tab.active {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
}
.seo-filter-tab.active .badge {
    background: rgba(255,255,255,0.2) !important;
    color: #ffffff !important;
}

.seo-table-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.char-badge {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
}
.char-badge-good {
    background-color: #dcfce7;
    color: #15803d;
}
.char-badge-warn {
    background-color: #fef3c7;
    color: #b45309;
}
.char-badge-muted {
    background-color: #f1f5f9;
    color: #64748b;
}

.cat-badge {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.cat-portal { background: #e0e7ff; color: #3730a3; }
.cat-core { background: #e0f2fe; color: #0369a1; }
.cat-cms { background: #ffedd5; color: #c2410c; }
.cat-exam { background: #f3e8ff; color: #6b21a8; }
.cat-static { background: #f1f5f9; color: #334155; }

.action-btn-seo {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 8px;
}

/* Toast Notification */
.seo-toast {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 9999;
    min-width: 320px;
}

/* Modal Body Scroll Fix */
#editSeoModal .modal-dialog-scrollable .modal-body,
#addRouteModal .modal-dialog-scrollable .modal-body {
    max-height: calc(85vh - 140px);
    overflow-y: auto !important;
    -webkit-overflow-scrolling: touch;
}
#editSeoModal .modal-body::-webkit-scrollbar,
#addRouteModal .modal-body::-webkit-scrollbar {
    width: 6px;
}
#editSeoModal .modal-body::-webkit-scrollbar-track,
#addRouteModal .modal-body::-webkit-scrollbar-track {
    background: #f1f5f9;
}
#editSeoModal .modal-body::-webkit-scrollbar-thumb,
#addRouteModal .modal-body::-webkit-scrollbar-thumb {
    background: #94a3b8;
    border-radius: 4px;
}
</style>

<!-- TOAST CONTAINER -->
<div class="toast-container seo-toast" id="seoToastContainer"></div>

<!-- SECTION 1: HEADER BANNER -->
<div class="seo-header-card p-4 mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-warning text-dark rounded-3 p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-chart-line fs-5"></i>
                </div>
                <h3 class="fw-bold mb-0 text-white">Dynamic SEO &amp; Meta Manager</h3>
            </div>
            <p class="text-white-50 mb-0 small">
                Manage Search Engine Titles, Descriptions, OpenGraph Social Previews, and Robots Indexing for all <span class="text-white fw-bold" id="statHeaderTotal"><?php echo $stats['total']; ?></span> pages.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge <?php echo $stats['is_live'] ? 'bg-success' : 'bg-warning text-dark'; ?> px-3 py-2 rounded-pill fw-bold shadow-sm" id="globalModeBadge" style="font-size: 0.85rem;">
                <i class="fas <?php echo $stats['is_live'] ? 'fa-check-circle' : 'fa-shield-alt'; ?> me-1"></i>
                <span id="globalModeText"><?php echo $stats['is_live'] ? 'Live Mode Active' : 'Development Mode Active'; ?></span>
            </span>
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3 shadow-sm" id="btnResyncInventory" title="Auto-scan all database courses, constituent units, and CMS pages">
                <i class="fas fa-sync-alt me-1"></i> Sync Inventory
            </button>
        </div>
    </div>
</div>

<!-- SECTION 2: GLOBAL SEARCH ENGINE CRAWLING STATUS STRIP -->
<div class="crawling-status-card <?php echo $stats['is_live'] ? 'live-mode' : 'dev-mode'; ?> p-3 p-md-4 mb-4 shadow-sm" id="crawlingStatusBar">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: <?php echo $stats['is_live'] ? '#dcfce7' : '#fef3c7'; ?>; color: <?php echo $stats['is_live'] ? '#15803d' : '#d97706'; ?>;">
                <i class="fas <?php echo $stats['is_live'] ? 'fa-globe' : 'fa-shield-alt'; ?> fs-4" id="crawlingStatusIcon"></i>
            </div>
            <div>
                <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                    <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.05rem;">Global Search Engine Crawling Status:</h5>
                    <span class="badge <?php echo $stats['is_live'] ? 'bg-success' : 'bg-warning text-dark'; ?> px-2 py-1 rounded" id="crawlingTagPill">
                        <?php echo $stats['global_robots']; ?>
                    </span>
                </div>
                <p class="mb-0 text-muted small" id="crawlingDescText">
                    <?php if ($stats['is_live']): ?>
                        <i class="fas fa-check-circle text-success me-1"></i> <strong>Live &amp; Indexed:</strong> Google, Bing, and major search engine bots can discover and rank website pages.
                    <?php else: ?>
                        <i class="fas fa-lock text-warning me-1"></i> <strong>Protected:</strong> Google and search bots are currently blocked from indexing any page on the website.
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="flex-shrink-0">
            <button type="button" class="btn <?php echo $stats['is_live'] ? 'btn-outline-dark' : 'btn-success'; ?> fw-bold px-4 py-2 shadow-sm rounded-pill d-inline-flex align-items-center gap-2" id="btnToggleGlobalStatus">
                <i class="fas <?php echo $stats['is_live'] ? 'fa-toggle-off' : 'fa-toggle-on'; ?>" id="toggleBtnIcon"></i>
                <span id="toggleBtnText"><?php echo $stats['is_live'] ? 'Switch to Development Mode (noindex, nofollow)' : 'Switch to Live Mode (Index, follow)'; ?></span>
            </button>
        </div>
    </div>
</div>

<!-- SECTION 3: QUICK METRICS CARDS -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Pages -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-seo">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <small class="text-muted fw-bold">Total Pages</small>
                <div class="stat-icon-wrapper bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
            <h3 class="fw-bold text-dark mb-0" id="statCardTotal"><?php echo $stats['total']; ?></h3>
        </div>
    </div>

    <!-- Card 2: Portal Pages -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-seo">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <small class="text-muted fw-bold">Portal Pages</small>
                <div class="stat-icon-wrapper bg-indigo bg-opacity-10 text-primary">
                    <i class="fas fa-th-large"></i>
                </div>
            </div>
            <h3 class="fw-bold text-success mb-0" id="statCardPortal"><?php echo $stats['portal']; ?></h3>
        </div>
    </div>

    <!-- Card 3: Core Modules -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-seo">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <small class="text-muted fw-bold">Core Modules</small>
                <div class="stat-icon-wrapper bg-info bg-opacity-10 text-info">
                    <i class="fas fa-database"></i>
                </div>
            </div>
            <h3 class="fw-bold text-info mb-0" id="statCardCore"><?php echo $stats['core']; ?></h3>
        </div>
    </div>

    <!-- Card 4: CMS Pages -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-seo">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <small class="text-muted fw-bold">CMS Pages</small>
                <div class="stat-icon-wrapper bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-sitemap"></i>
                </div>
            </div>
            <h3 class="fw-bold text-warning mb-0" id="statCardCms"><?php echo $stats['cms']; ?></h3>
        </div>
    </div>

    <!-- Card 5: Exam Papers / Academic -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-seo">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <small class="text-muted fw-bold">Exam &amp; Syllabi</small>
                <div class="stat-icon-wrapper bg-purple bg-opacity-10 text-purple" style="background: #f3e8ff; color: #7c3aed;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <h3 class="fw-bold text-purple mb-0" style="color: #7c3aed;" id="statCardExam"><?php echo $stats['exam']; ?></h3>
        </div>
    </div>

    <!-- Card 6: Static Showcase -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-seo">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <small class="text-muted fw-bold">Static Pages</small>
                <div class="stat-icon-wrapper bg-secondary bg-opacity-10 text-secondary">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
            <h3 class="fw-bold text-secondary mb-0" id="statCardStatic"><?php echo $stats['static']; ?></h3>
        </div>
    </div>
</div>

<!-- SECTION 4: FILTER TABS & SEARCH CONTROLS -->
<div class="seo-table-card p-4">
    
    <!-- Filter Category Tabs -->
    <div class="d-flex flex-wrap gap-2 mb-3 pb-3 border-bottom" id="seoTabsContainer">
        <button type="button" class="seo-filter-tab active" data-category="all">
            <i class="fas fa-list"></i> All Pages <span class="badge bg-secondary rounded-pill ms-1" id="tabBadgeAll"><?php echo $stats['total']; ?></span>
        </button>
        <button type="button" class="seo-filter-tab" data-category="Portal Pages">
            <i class="fas fa-th-large"></i> Portal Pages <span class="badge bg-secondary rounded-pill ms-1" id="tabBadgePortal"><?php echo $stats['portal']; ?></span>
        </button>
        <button type="button" class="seo-filter-tab" data-category="Core & Database">
            <i class="fas fa-database"></i> Core &amp; Database <span class="badge bg-secondary rounded-pill ms-1" id="tabBadgeCore"><?php echo $stats['core']; ?></span>
        </button>
        <button type="button" class="seo-filter-tab" data-category="CMS Generic">
            <i class="fas fa-sitemap"></i> CMS Generic <span class="badge bg-secondary rounded-pill ms-1" id="tabBadgeCms"><?php echo $stats['cms']; ?></span>
        </button>
        <button type="button" class="seo-filter-tab" data-category="Academic & Exam">
            <i class="fas fa-graduation-cap"></i> Academic &amp; Exams <span class="badge bg-secondary rounded-pill ms-1" id="tabBadgeExam"><?php echo $stats['exam']; ?></span>
        </button>
        <button type="button" class="seo-filter-tab" data-category="Static Showcase">
            <i class="fas fa-layer-group"></i> Static Showcase <span class="badge bg-secondary rounded-pill ms-1" id="tabBadgeStatic"><?php echo $stats['static']; ?></span>
        </button>

        <div class="ms-auto d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addRouteModal">
                <i class="fas fa-plus me-1"></i> Add Custom Route
            </button>
        </div>
    </div>

    <!-- Search & Pagination Controls -->
    <div class="row g-2 align-items-center justify-content-between mb-3">
        <div class="col-12 col-md-4 col-lg-3 d-flex align-items-center gap-2">
            <span class="text-muted small">Show</span>
            <select class="form-select form-select-sm" id="entriesPerPageSelect" style="width: 80px;">
                <option value="10">10</option>
                <option value="25" selected>25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="-1">All</option>
            </select>
            <span class="text-muted small">entries</span>
        </div>

        <div class="col-12 col-md-5 col-lg-4 ms-auto">
            <div class="input-group input-group-sm shadow-2xs">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" id="pageSearchInput" class="form-control border-start-0 ps-0" placeholder="Search by page name, route, or keyword...">
                <button class="btn btn-outline-secondary" type="button" id="pageSearchClear" style="display: none;" title="Clear Search">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- SEO INVENTORY TABLE -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="seoPagesTable">
            <thead class="table-light">
                <tr class="text-uppercase text-muted" style="font-size: 0.78rem; letter-spacing: 0.6px;">
                    <th style="width: 50px;">#</th>
                    <th>Page Details</th>
                    <th style="width: 180px;">Category</th>
                    <th style="width: 200px;">Robots Indexing</th>
                    <th class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody id="seoTableBody">
                <?php 
                $rowIdx = 1;
                foreach ($allPages as $page): 
                    $cat = $page['page_category'] ?? 'Portal Pages';
                    $catClass = 'cat-portal';
                    if ($cat === 'Core & Database') $catClass = 'cat-core';
                    elseif ($cat === 'CMS Generic') $catClass = 'cat-cms';
                    elseif ($cat === 'Academic & Exam') $catClass = 'cat-exam';
                    elseif ($cat === 'Static Showcase') $catClass = 'cat-static';

                    $robotsTag = $page['robots_tag'] ?? 'inherit';
                ?>
                <tr class="seo-row" 
                    data-id="<?php echo $page['id']; ?>" 
                    data-category="<?php echo htmlspecialchars($cat); ?>"
                    data-identifier="<?php echo htmlspecialchars($page['page_identifier']); ?>"
                    data-name="<?php echo htmlspecialchars(strtolower($page['page_name'])); ?>"
                    data-title="<?php echo htmlspecialchars(strtolower($page['meta_title'] ?? '')); ?>">
                    
                    <td class="text-muted small fw-bold row-index"><?php echo $rowIdx++; ?></td>
                    
                    <td>
                        <div class="fw-bold text-dark mb-1 row-page-name" style="font-size: 0.95rem;"><?php echo htmlspecialchars($page['page_name']); ?></div>
                        <div class="d-flex align-items-center gap-2">
                            <code class="text-muted small px-2 py-0 bg-light border rounded row-identifier"><?php echo htmlspecialchars($page['page_identifier']); ?></code>
                            <a href="<?php echo BASE_URL . $page['page_identifier']; ?>" target="_blank" class="text-primary text-decoration-none small d-inline-flex align-items-center gap-1" title="Open live page in new tab">
                                <i class="fas fa-external-link-alt" style="font-size: 0.75rem;"></i>
                                <span style="font-size: 0.75rem;">View</span>
                            </a>
                        </div>
                    </td>

                    <td>
                        <span class="cat-badge <?php echo $catClass; ?> row-category"><?php echo htmlspecialchars($cat); ?></span>
                    </td>

                    <td>
                        <?php if ($robotsTag === 'inherit' || empty($robotsTag)): ?>
                            <span class="badge bg-light text-muted border row-robots"><i class="fas fa-link me-1"></i> Inherit Global</span>
                        <?php elseif ($robotsTag === 'index, follow'): ?>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 row-robots"><i class="fas fa-check me-1"></i> index, follow</span>
                        <?php else: ?>
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 row-robots"><i class="fas fa-ban me-1"></i> <?php echo htmlspecialchars($robotsTag); ?></span>
                        <?php endif; ?>
                    </td>

                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-navy text-white action-btn-seo btn-edit-seo" data-id="<?php echo $page['id']; ?>" style="background: #0f172a;">
                            <i class="fas fa-edit me-1"></i> Edit SEO
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Empty State -->
    <div id="seoEmptyState" class="text-center py-5 d-none">
        <div class="text-muted mb-2"><i class="fas fa-search fs-1 opacity-25"></i></div>
        <h6 class="fw-bold text-secondary">No matching pages found</h6>
        <p class="text-muted small">Try refining your search keyword or selecting a different category filter.</p>
    </div>

    <!-- Table Pagination Footer -->
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 mt-3 pt-3 border-top">
        <div class="text-muted small" id="tableInfoText">
            Showing 1 to <?php echo min(25, count($allPages)); ?> of <?php echo count($allPages); ?> entries
        </div>
        <nav aria-label="SEO Table Pagination">
            <ul class="pagination pagination-sm mb-0" id="seoPagination">
                <!-- Dynamically Rendered -->
            </ul>
        </nav>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     EDIT SEO METADATA MODAL (Dynamic AJAX)
     ══════════════════════════════════════════════════════════ -->
<div class="modal fade" id="editSeoModal" tabindex="-1" aria-labelledby="editSeoModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form id="editSeoForm" class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" autocomplete="off">
            
            <!-- MODAL HEADER -->
            <div class="modal-header text-white px-4 py-3 align-items-center" style="background: #0f172a;">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-warning text-dark rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fas fa-chart-line fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="editSeoModalLabel">
                            Edit SEO Metadata: <span class="text-warning" id="modalPageNameTitle">Page Title</span>
                        </h5>
                        <small class="text-white-50" style="font-size: 0.78rem;" id="modalRouteSubtitle">
                            Route: page.php?id=0
                        </small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <input type="hidden" name="ajax_action" value="save_seo">
            <input type="hidden" name="id" id="formSeoId" value="0">
            <input type="hidden" name="page_identifier" id="formPageIdentifier" value="">

            <!-- MODAL BODY -->
            <div class="modal-body p-4 bg-light">
                
                <!-- Top Page Name & Category Strip -->
                <div class="row g-3 mb-3">
                    <div class="col-md-7">
                        <label class="form-label fw-bold text-dark small mb-1">Page Display Name *</label>
                        <input type="text" name="page_name" id="formPageName" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold text-dark small mb-1">Category Classification</label>
                        <select name="page_category" id="formPageCategory" class="form-select form-select-sm">
                            <option value="Portal Pages">Portal Pages</option>
                            <option value="Core & Database">Core & Database</option>
                            <option value="CMS Generic">CMS Generic</option>
                            <option value="Academic & Exam">Academic & Exam</option>
                            <option value="Static Showcase">Static Showcase</option>
                        </select>
                    </div>
                </div>

                <!-- Meta Title Section -->
                <div class="bg-white p-3 rounded-3 border mb-3 shadow-2xs">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label class="form-label fw-bold text-dark small mb-0">
                            Meta Title <span class="text-muted fw-normal">(Recommended 50–60 characters)</span>
                        </label>
                        <span class="badge char-badge-muted" id="modalTitleCount">0 / 60</span>
                    </div>
                    <input type="text" name="meta_title" id="formMetaTitle" class="form-control" placeholder="e.g. Admission Helplines & Contact | SRKU Bhopal" maxlength="150">
                    <div class="form-text small text-muted">
                        Shown in search engine headlines and browser tab titles.
                    </div>
                </div>

                <!-- Meta Description Section -->
                <div class="bg-white p-3 rounded-3 border mb-3 shadow-2xs">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label class="form-label fw-bold text-dark small mb-0">
                            Meta Description <span class="text-muted fw-normal">(Recommended 120–160 characters)</span>
                        </label>
                        <span class="badge char-badge-muted" id="modalDescCount">0 / 160</span>
                    </div>
                    <textarea name="meta_description" id="formMetaDescription" rows="3" class="form-control" placeholder="Shown beneath the title in search engine snippets to encourage user clicks."></textarea>
                    <div class="form-text small text-muted">
                        Compelling summary shown in Google snippet beneath the title.
                    </div>
                </div>

                <!-- Focus Keywords Section -->
                <div class="bg-white p-3 rounded-3 border mb-3 shadow-2xs">
                    <label class="form-label fw-bold text-dark small mb-1">Focus Keywords</label>
                    <input type="text" name="focus_keywords" id="formFocusKeywords" class="form-control" placeholder="e.g. SRKU Bhopal, top university in MP, engineering admissions 2026, pharmacy, medical">
                    <div class="form-text small text-muted">
                        Target keywords for reference, search engines, and thematic relevance.
                    </div>
                </div>

                <!-- Canonical URL & Robots Indexing -->
                <div class="row g-3 mb-3">
                    <div class="col-md-7">
                        <div class="bg-white p-3 rounded-3 border h-100 shadow-2xs">
                            <label class="form-label fw-bold text-dark small mb-1">Canonical URL</label>
                            <input type="url" name="canonical_url" id="formCanonicalUrl" class="form-control form-control-sm" placeholder="https://srku.edu.in/page.php?id=24">
                            <div class="form-text small text-muted">
                                Self-referencing canonical URL prevents duplicate content issues.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="bg-white p-3 rounded-3 border h-100 shadow-2xs">
                            <label class="form-label fw-bold text-dark small mb-1">Robots Indexing Tag</label>
                            <select name="robots_tag" id="formRobotsTag" class="form-select form-select-sm">
                                <option value="inherit">Inherit Global Setting (<?php echo $stats['global_robots']; ?>)</option>
                                <option value="index, follow">index, follow (Allow Indexing)</option>
                                <option value="noindex, nofollow">noindex, nofollow (Block Indexing)</option>
                                <option value="noindex, follow">noindex, follow</option>
                                <option value="index, nofollow">index, nofollow</option>
                            </select>
                            <div class="form-text small text-muted">
                                Override global setting for this specific page if needed.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COLLAPSIBLE ACCORDION: SOCIAL SHARE (OpenGraph & Twitter) -->
                <div class="accordion mb-3" id="socialShareAccordion">
                    <div class="accordion-item border rounded-3 overflow-hidden shadow-2xs">
                        <h2 class="accordion-header" id="headingSocial">
                            <button class="accordion-button collapsed fw-bold py-2 bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSocial" aria-expanded="false" aria-controls="collapseSocial">
                                <i class="fas fa-share-alt text-danger me-2"></i> Social Share (OpenGraph / WhatsApp / Twitter) Settings
                            </button>
                        </h2>
                        <div id="collapseSocial" class="accordion-collapse collapse" aria-labelledby="headingSocial" data-bs-parent="#socialShareAccordion">
                            <div class="accordion-body bg-white p-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark small mb-1">OpenGraph / Social Title</label>
                                    <input type="text" name="og_title" id="formOgTitle" class="form-control form-control-sm" placeholder="Leave blank to automatically use Meta Title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark small mb-1">OpenGraph / Social Description</label>
                                    <textarea name="og_description" id="formOgDescription" rows="2" class="form-control form-control-sm" placeholder="Leave blank to automatically use Meta Description"></textarea>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold text-dark small mb-1">Social Preview Image (OG Image)</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="og_image" id="formOgImage" class="form-control" placeholder="assets/uploads/2026/07/SRK-logo.webp">
                                            <button type="button" class="btn btn-outline-secondary" id="btnBrowseOgMedia">
                                                <i class="fas fa-photo-video me-1"></i> Browse Media
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark small mb-1">Twitter Card Type</label>
                                        <select name="twitter_card" id="formTwitterCard" class="form-select form-select-sm">
                                            <option value="summary_large_image">summary_large_image (Large Banner)</option>
                                            <option value="summary">summary (Small Square)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Schema (JSON-LD Structured Data) -->
                <div class="bg-white p-3 rounded-3 border shadow-2xs">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label class="form-label fw-bold text-dark small mb-0">
                            <i class="fas fa-code text-primary me-1"></i> Custom Schema (JSON-LD Structured Data)
                        </label>
                        <span class="text-muted small" style="font-size: 0.72rem;">Optional Rich Snippet</span>
                    </div>
                    <textarea name="schema_json" id="formSchemaJson" rows="4" class="form-control font-monospace text-dark" style="font-size: 0.82rem;" placeholder='{ "@context": "https://schema.org", "@type": "WebPage", ... }'></textarea>
                    <div class="form-text small text-muted">
                        Optional: Paste valid JSON-LD schema snippet for this specific page. Do not include <code>&lt;script&gt;</code> tags.
                    </div>
                </div>

            </div>

            <!-- MODAL FOOTER -->
            <div class="modal-footer bg-white px-4 py-3 justify-content-between">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-navy text-white rounded-pill px-4 fw-bold" id="btnSaveSeoSubmit" style="background: #0f172a;">
                    <i class="fas fa-save me-1"></i> Save SEO Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     ADD CUSTOM ROUTE MODAL
     ══════════════════════════════════════════════════════════ -->
<div class="modal fade" id="addRouteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
        <form id="addRouteForm" class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-navy text-white px-4 py-3" style="background: #0f172a;">
                <h5 class="modal-title fw-bold text-white mb-0"><i class="fas fa-plus-circle me-1 text-warning"></i> Add Custom Route to SEO Manager</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <input type="hidden" name="ajax_action" value="add_custom_route">
            
            <div class="modal-body p-4 bg-light">
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Page URL Identifier / Route *</label>
                    <input type="text" name="page_identifier" class="form-control" placeholder="e.g. custom-admission-guide.php or portal/apply" required>
                    <div class="form-text small text-muted">Relative route path or filename.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Page Display Name *</label>
                    <input type="text" name="page_name" class="form-control" placeholder="e.g. Special Admission Guide 2026" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Category</label>
                    <select name="page_category" class="form-select">
                        <option value="Portal Pages">Portal Pages</option>
                        <option value="Core & Database">Core & Database</option>
                        <option value="CMS Generic">CMS Generic</option>
                        <option value="Academic & Exam">Academic & Exam</option>
                        <option value="Static Showcase">Static Showcase</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" placeholder="SEO title for search engines">
                </div>
                <div>
                    <label class="form-label fw-bold text-dark small">Meta Description</label>
                    <textarea name="meta_description" rows="2" class="form-control" placeholder="SEO description summary"></textarea>
                </div>
            </div>
            <div class="modal-footer bg-white px-4 py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Add Route</button>
            </div>
        </form>
    </div>
</div>

<!-- JAVASCRIPT ENGINE FOR DYNAMIC SEO MANAGER -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('seoTableBody');
    const searchInput = document.getElementById('pageSearchInput');
    const searchClearBtn = document.getElementById('pageSearchClear');
    const entriesSelect = document.getElementById('entriesPerPageSelect');
    const emptyState = document.getElementById('seoEmptyState');
    const paginationUl = document.getElementById('seoPagination');
    const tableInfoText = document.getElementById('tableInfoText');
    const tabsContainer = document.getElementById('seoTabsContainer');

    // Modals & Forms
    const editModalEl = document.getElementById('editSeoModal');
    const editModal = new bootstrap.Modal(editModalEl);
    const editForm = document.getElementById('editSeoForm');
    const formMetaTitle = document.getElementById('formMetaTitle');
    const formMetaDesc = document.getElementById('formMetaDescription');
    const modalTitleCount = document.getElementById('modalTitleCount');
    const modalDescCount = document.getElementById('modalDescCount');

    // Global Crawling Toggle
    const btnToggleGlobal = document.getElementById('btnToggleGlobalStatus');
    const btnResync = document.getElementById('btnResyncInventory');

    let currentCategoryFilter = 'all';
    let currentSearchQuery = '';
    let currentPage = 1;
    let entriesPerPage = 25;

    // Toast Notification Helper
    function showToast(message, type = 'success') {
        const toastContainer = document.getElementById('seoToastContainer');
        const toastId = 'toast_' + Date.now();
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const bgClass = type === 'success' ? 'bg-success text-white' : 'bg-danger text-white';

        const toastHtml = `
            <div id="${toastId}" class="toast align-items-center ${bgClass} border-0 shadow-lg rounded-3 mb-2 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="fas ${icon} fs-5"></i>
                        <div>${message}</div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        setTimeout(() => {
            const el = document.getElementById(toastId);
            if (el) el.remove();
        }, 4500);
    }

    // Update Character Counters in Modal
    function updateCharCounters() {
        const tLen = formMetaTitle.value.length;
        const dLen = formMetaDesc.value.length;

        modalTitleCount.innerText = `${tLen} / 60`;
        if (tLen >= 30 && tLen <= 65) {
            modalTitleCount.className = 'badge char-badge-good';
        } else if (tLen > 0) {
            modalTitleCount.className = 'badge char-badge-warn';
        } else {
            modalTitleCount.className = 'badge char-badge-muted';
        }

        modalDescCount.innerText = `${dLen} / 160`;
        if (dLen >= 100 && dLen <= 165) {
            modalDescCount.className = 'badge char-badge-good';
        } else if (dLen > 0) {
            modalDescCount.className = 'badge char-badge-warn';
        } else {
            modalDescCount.className = 'badge char-badge-muted';
        }
    }

    formMetaTitle.addEventListener('input', updateCharCounters);
    formMetaDesc.addEventListener('input', updateCharCounters);

    // Media Picker Integration for OG Image
    const btnBrowseOg = document.getElementById('btnBrowseOgMedia');
    const formOgImage = document.getElementById('formOgImage');
    if (btnBrowseOg && typeof window.openMediaPicker === 'function') {
        btnBrowseOg.addEventListener('click', () => {
            window.openMediaPicker({
                currentValue: formOgImage.value,
                onSelect: function(img) {
                    formOgImage.value = img.path;
                }
            });
        });
    }

    // Filter and Paginate Table
    function renderTable() {
        const rows = Array.from(tableBody.querySelectorAll('tr.seo-row'));
        let visibleRows = [];

        rows.forEach(row => {
            const rowCat = row.getAttribute('data-category');
            const rowName = row.getAttribute('data-name');
            const rowIdent = row.getAttribute('data-identifier').toLowerCase();
            const rowTitle = row.getAttribute('data-title');

            const matchesCategory = (currentCategoryFilter === 'all' || rowCat === currentCategoryFilter);
            const matchesSearch = (!currentSearchQuery || 
                rowName.includes(currentSearchQuery) || 
                rowIdent.includes(currentSearchQuery) || 
                rowTitle.includes(currentSearchQuery));

            if (matchesCategory && matchesSearch) {
                visibleRows.push(row);
            } else {
                row.style.display = 'none';
            }
        });

        const totalVisible = visibleRows.length;
        if (totalVisible === 0) {
            emptyState.classList.remove('d-none');
        } else {
            emptyState.classList.add('d-none');
        }

        // Pagination calculations
        const perPage = entriesPerPage === -1 ? totalVisible : entriesPerPage;
        const totalPages = Math.ceil(totalVisible / perPage) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const startIndex = (currentPage - 1) * perPage;
        const endIndex = entriesPerPage === -1 ? totalVisible : Math.min(startIndex + perPage, totalVisible);

        visibleRows.forEach((row, idx) => {
            if (idx >= startIndex && idx < endIndex) {
                row.style.display = '';
                row.querySelector('.row-index').innerText = idx + 1;
            } else {
                row.style.display = 'none';
            }
        });

        // Update Info Text
        if (totalVisible > 0) {
            tableInfoText.innerText = `Showing ${startIndex + 1} to ${endIndex} of ${totalVisible} entries ${currentSearchQuery ? '(filtered)' : ''}`;
        } else {
            tableInfoText.innerText = 'Showing 0 entries';
        }

        // Render Pagination Numbers
        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        paginationUl.innerHTML = '';
        if (totalPages <= 1) return;

        // Previous button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>`;
        prevLi.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });
        paginationUl.appendChild(prevLi);

        // Page Numbers (up to 7 items with ellipsis)
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                const li = document.createElement('li');
                li.className = `page-item ${currentPage === i ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentPage = i;
                    renderTable();
                });
                paginationUl.appendChild(li);
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                const li = document.createElement('li');
                li.className = 'page-item disabled';
                li.innerHTML = `<span class="page-link">...</span>`;
                paginationUl.appendChild(li);
            }
        }

        // Next button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>`;
        nextLi.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });
        paginationUl.appendChild(nextLi);
    }

    // Category Tabs click
    tabsContainer.querySelectorAll('.seo-filter-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            tabsContainer.querySelectorAll('.seo-filter-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            currentCategoryFilter = tab.getAttribute('data-category');
            currentPage = 1;
            renderTable();
        });
    });

    // Search Input
    searchInput.addEventListener('input', () => {
        currentSearchQuery = searchInput.value.trim().toLowerCase();
        searchClearBtn.style.display = currentSearchQuery ? 'block' : 'none';
        currentPage = 1;
        renderTable();
    });

    searchClearBtn.addEventListener('click', () => {
        searchInput.value = '';
        currentSearchQuery = '';
        searchClearBtn.style.display = 'none';
        currentPage = 1;
        renderTable();
    });

    // Entries per page
    entriesSelect.addEventListener('change', () => {
        entriesPerPage = parseInt(entriesSelect.value, 10);
        currentPage = 1;
        renderTable();
    });

    // OPEN EDIT MODAL (AJAX)
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-edit-seo');
        if (!btn) return;

        const id = btn.getAttribute('data-id');
        btn.disabled = true;
        btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;

        fetch(`manage_seo.php?ajax_action=get_seo&id=${id}`)
            .then(res => res.json())
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-edit me-1"></i> Edit SEO`;

                if (res.success && res.data) {
                    const d = res.data;
                    document.getElementById('formSeoId').value = d.id;
                    document.getElementById('formPageIdentifier').value = d.page_identifier;
                    document.getElementById('modalPageNameTitle').innerText = d.page_name;
                    document.getElementById('modalRouteSubtitle').innerText = `Route: ${d.page_identifier}`;
                    document.getElementById('formPageName').value = d.page_name;
                    document.getElementById('formPageCategory').value = d.page_category || 'Portal Pages';
                    document.getElementById('formMetaTitle').value = d.meta_title || '';
                    document.getElementById('formMetaDescription').value = d.meta_description || '';
                    document.getElementById('formFocusKeywords').value = d.focus_keywords || '';
                    document.getElementById('formCanonicalUrl').value = d.canonical_url || '';
                    document.getElementById('formRobotsTag').value = d.robots_tag || 'inherit';
                    document.getElementById('formOgTitle').value = d.og_title || '';
                    document.getElementById('formOgDescription').value = d.og_description || '';
                    document.getElementById('formOgImage').value = d.og_image || '';
                    document.getElementById('formTwitterCard').value = d.twitter_card || 'summary_large_image';
                    document.getElementById('formSchemaJson').value = d.schema_json || '';

                    updateCharCounters();
                    editModal.show();
                } else {
                    showToast(res.error || 'Could not load SEO record.', 'error');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = `<i class="fas fa-edit me-1"></i> Edit SEO`;
                showToast('Server connection error.', 'error');
            });
    });

    // SUBMIT EDIT FORM (AJAX)
    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const submitBtn = document.getElementById('btnSaveSeoSubmit');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin me-1"></i> Saving...`;

        const formData = new FormData(editForm);

        fetch('manage_seo.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<i class="fas fa-save me-1"></i> Save SEO Changes`;

            if (res.success && res.data) {
                const d = res.data;
                editModal.hide();
                showToast(res.message || 'SEO metadata saved successfully!');

                // Update row in DOM
                const row = document.querySelector(`tr.seo-row[data-id="${d.id}"]`);
                if (row) {
                    row.setAttribute('data-category', d.page_category);
                    row.setAttribute('data-name', (d.page_name || '').toLowerCase());
                    row.setAttribute('data-title', (d.meta_title || '').toLowerCase());

                    row.querySelector('.row-page-name').innerText = d.page_name;
                    
                    const catEl = row.querySelector('.row-category');
                    catEl.innerText = d.page_category;
                    let catClass = 'cat-portal';
                    if (d.page_category === 'Core & Database') catClass = 'cat-core';
                    else if (d.page_category === 'CMS Generic') catClass = 'cat-cms';
                    else if (d.page_category === 'Academic & Exam') catClass = 'cat-exam';
                    else if (d.page_category === 'Static Showcase') catClass = 'cat-static';
                    catEl.className = `cat-badge ${catClass} row-category`;

                    const robotsEl = row.querySelector('.row-robots');
                    const rTag = d.robots_tag || 'inherit';
                    if (rTag === 'inherit') {
                        robotsEl.className = 'badge bg-light text-muted border row-robots';
                        robotsEl.innerHTML = `<i class="fas fa-link me-1"></i> Inherit Global`;
                    } else if (rTag === 'index, follow') {
                        robotsEl.className = 'badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 row-robots';
                        robotsEl.innerHTML = `<i class="fas fa-check me-1"></i> index, follow`;
                    } else {
                        robotsEl.className = 'badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 row-robots';
                        robotsEl.innerHTML = `<i class="fas fa-ban me-1"></i> ${rTag}`;
                    }
                }
            } else {
                showToast(res.error || 'Failed to save changes.', 'error');
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<i class="fas fa-save me-1"></i> Save SEO Changes`;
            showToast('Server communication error.', 'error');
        });
    });

    // TOGGLE GLOBAL INDEXING STATUS (Live vs Dev)
    btnToggleGlobal.addEventListener('click', () => {
        btnToggleGlobal.disabled = true;
        btnToggleGlobal.innerHTML = `<i class="fas fa-spinner fa-spin me-1"></i> Updating Mode...`;

        fetch('manage_seo.php?ajax_action=toggle_global_indexing')
            .then(res => res.json())
            .then(res => {
                btnToggleGlobal.disabled = false;
                if (res.success) {
                    showToast(res.message);
                    const isLive = res.is_live;
                    const card = document.getElementById('crawlingStatusBar');
                    const badge = document.getElementById('globalModeBadge');
                    const modeText = document.getElementById('globalModeText');
                    const pill = document.getElementById('crawlingTagPill');
                    const desc = document.getElementById('crawlingDescText');
                    const icon = document.getElementById('crawlingStatusIcon');

                    if (isLive) {
                        card.className = 'crawling-status-card live-mode p-3 p-md-4 mb-4 shadow-sm';
                        badge.className = 'badge bg-success px-3 py-2 rounded-pill fw-bold shadow-sm';
                        modeText.innerText = 'Live Mode Active';
                        pill.className = 'badge bg-success px-2 py-1 rounded';
                        pill.innerText = 'index, follow';
                        desc.innerHTML = `<i class="fas fa-check-circle text-success me-1"></i> <strong>Live &amp; Indexed:</strong> Google, Bing, and major search engine bots can discover and rank website pages.`;
                        icon.className = 'fas fa-globe fs-4';
                        icon.parentElement.style.background = '#dcfce7';
                        icon.parentElement.style.color = '#15803d';
                        btnToggleGlobal.className = 'btn btn-outline-dark fw-bold px-4 py-2 shadow-sm rounded-pill d-inline-flex align-items-center gap-2';
                        btnToggleGlobal.innerHTML = `<i class="fas fa-toggle-off"></i> <span>Switch to Development Mode (noindex, nofollow)</span>`;
                    } else {
                        card.className = 'crawling-status-card dev-mode p-3 p-md-4 mb-4 shadow-sm';
                        badge.className = 'badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold shadow-sm';
                        modeText.innerText = 'Development Mode Active';
                        pill.className = 'badge bg-warning text-dark px-2 py-1 rounded';
                        pill.innerText = 'noindex, nofollow';
                        desc.innerHTML = `<i class="fas fa-lock text-warning me-1"></i> <strong>Protected:</strong> Google and search bots are currently blocked from indexing any page on the website.`;
                        icon.className = 'fas fa-shield-alt fs-4';
                        icon.parentElement.style.background = '#fef3c7';
                        icon.parentElement.style.color = '#d97706';
                        btnToggleGlobal.className = 'btn btn-success fw-bold px-4 py-2 shadow-sm rounded-pill d-inline-flex align-items-center gap-2';
                        btnToggleGlobal.innerHTML = `<i class="fas fa-toggle-on"></i> <span>Switch to Live Mode (Index, follow)</span>`;
                    }
                } else {
                    showToast(res.error || 'Failed to update crawling mode.', 'error');
                }
            })
            .catch(err => {
                btnToggleGlobal.disabled = false;
                showToast('Server connection error.', 'error');
            });
    });

    // 1-CLICK RESYNC INVENTORY
    btnResync.addEventListener('click', () => {
        btnResync.disabled = true;
        btnResync.innerHTML = `<i class="fas fa-spinner fa-spin me-1"></i> Scanning...`;

        fetch('manage_seo.php?ajax_action=resync_inventory')
            .then(res => res.json())
            .then(res => {
                btnResync.disabled = false;
                btnResync.innerHTML = `<i class="fas fa-sync-alt me-1"></i> Sync Inventory`;
                if (res.success) {
                    showToast(res.message);
                    setTimeout(() => location.reload(), 1200);
                } else {
                    showToast(res.error || 'Failed to sync inventory.', 'error');
                }
            })
            .catch(err => {
                btnResync.disabled = false;
                btnResync.innerHTML = `<i class="fas fa-sync-alt me-1"></i> Sync Inventory`;
                showToast('Server connection error.', 'error');
            });
    });

    // Initial table render
    renderTable();
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
