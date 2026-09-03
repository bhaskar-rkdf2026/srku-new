<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Handle AJAX Sync Request
if (isset($_REQUEST['ajax_sync'])) {
    header('Content-Type: application/json');
    $target = sanitize($_REQUEST['target'] ?? 'all');
    $force = isset($_REQUEST['force']) && $_REQUEST['force'] == '1';
    
    $res = syncDatabaseMasterData($target, $force);
    $statusInfo = getDatabaseStatusInfo();
    $res['status_info'] = $statusInfo;
    echo json_encode($res);
    exit;
}

// Handle Form POST Sync Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $target = sanitize($_POST['target'] ?? 'all');
    $force = isset($_POST['force']) && $_POST['force'] == '1';

    if ($action === 'sync') {
        $res = syncDatabaseMasterData($target, $force);
        if ($res['success']) {
            $msg = "<strong>1-Click DB Sync Completed Successfully!</strong><br>";
            if (!empty($res['messages'])) {
                $msg .= implode("<br>", $res['messages']);
            } else {
                $msg .= "All database tables, schemas, and master records are synchronized.";
            }
            setFlashMsg('success', $msg);
        } else {
            setFlashMsg('danger', 'Sync Failed: ' . ($res['error'] ?? 'Unknown database error occurred.'));
        }
        header("Location: manage_dbsync.php");
        exit;
    }
}

$dbStatus = getDatabaseStatusInfo();
$tables = $dbStatus['tables'] ?? [];

// Module metadata mapping for sync table
$syncModules = [
    'faculty' => [
        'name' => 'Faculty Directory',
        'table' => 'faculty',
        'icon' => 'fas fa-chalkboard-teacher text-primary',
        'desc' => '1,000+ Professors, Deans, Doctors, Researchers and Mentors',
        'expected' => 1074,
        'manage_url' => 'manage_faculty.php'
    ],
    'syllabi' => [
        'name' => 'Syllabus & Schemes',
        'table' => 'syllabi',
        'icon' => 'fas fa-file-pdf text-danger',
        'desc' => '267 University Curriculum, Scheme and Syllabus PDF records',
        'expected' => 267,
        'manage_url' => 'manage_syllabus.php'
    ],
    'departments' => [
        'name' => 'Constituent Units & Colleges',
        'table' => 'departments',
        'icon' => 'fas fa-sitemap text-maroon',
        'desc' => 'All 26 Constituent Institutes, Colleges, and Academic Departments',
        'expected' => 26,
        'manage_url' => 'manage_departments.php'
    ],
    'courses' => [
        'name' => 'Academic Courses & Programs',
        'table' => 'courses',
        'icon' => 'fas fa-graduation-cap text-warning',
        'desc' => '95 Degree, Diploma, and Doctorate Programs with Specializations',
        'expected' => 95,
        'manage_url' => 'manage_courses.php'
    ],
    'gallery' => [
        'name' => 'Photo Gallery & Assets',
        'table' => 'gallery',
        'icon' => 'fas fa-images text-success',
        'desc' => '71 High Definition Campus, Gym, Sports & Medical photos',
        'expected' => 71,
        'manage_url' => 'manage_gallery.php'
    ],
    'blogs' => [
        'name' => 'Blogs & Articles',
        'table' => 'blogs',
        'icon' => 'fas fa-newspaper text-info',
        'desc' => 'Published Campus, Fest, Placement, and Research Articles',
        'expected' => 6,
        'manage_url' => 'manage_blogs.php'
    ],
    'news' => [
        'name' => 'News & Notices',
        'table' => 'news',
        'icon' => 'fas fa-bullhorn text-secondary',
        'desc' => 'University Circulars, Admission Announcements & Ticker items',
        'expected' => 4,
        'manage_url' => 'manage_news.php'
    ],
    'banners' => [
        'name' => 'Banners & Hero Sliders',
        'table' => 'banners',
        'icon' => 'fas fa-sliders-h text-primary',
        'desc' => 'Homepage and Dynamic Page Header Banners with CTA buttons',
        'expected' => 3,
        'manage_url' => 'manage_banners.php'
    ],
    'pages' => [
        'name' => 'Dynamic CMS Pages',
        'table' => 'pages',
        'icon' => 'fas fa-file-alt text-dark',
        'desc' => 'Why SRK, Vision & Mission, Accreditation, Governance pages',
        'expected' => 6,
        'manage_url' => 'manage_pages.php'
    ],
    'settings' => [
        'name' => 'Global Site Settings',
        'table' => 'settings',
        'icon' => 'fas fa-cogs text-secondary',
        'desc' => 'Helpline, Admissions Contact, Social Handles & Key Stats',
        'expected' => 14,
        'manage_url' => 'manage_settings.php'
    ],
    'enquiries' => [
        'name' => 'Student Enquiries & Leads',
        'table' => 'enquiries',
        'icon' => 'fas fa-user-graduate text-success',
        'desc' => 'Admissions, Contact & Lead Applications submitted by candidates',
        'expected' => null, // Dynamic
        'manage_url' => 'manage_enquiries.php'
    ],
    'complaints' => [
        'name' => 'Grievances & Redressals',
        'table' => 'complaints',
        'icon' => 'fas fa-clipboard-check text-warning',
        'desc' => 'Student & Staff Grievance submissions & tracking status',
        'expected' => null, // Dynamic
        'manage_url' => 'manage_enquiries.php'
    ],
    'users' => [
        'name' => 'Admin User Accounts',
        'table' => 'users',
        'icon' => 'fas fa-user-shield text-danger',
        'desc' => 'Central CMS Admin authentication & credentials',
        'expected' => 1,
        'manage_url' => 'index.php'
    ]
];
?>

<!-- ═══════════════════════════════════════════════════════
     HEADER: 1-CLICK DB SYNC HERO BANNER
═══════════════════════════════════════════════════════ -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #0e1e38 0%, #1e245a 55%, #7a0b0d 100%);">
    <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-12 col-lg-8">
            <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                <i class="fas fa-database me-1"></i> Live Database Synchronizer &amp; Health Engine
            </span>
            <h2 class="h3 fw-bold text-white mb-2">1-Click Database Master Synchronization</h2>
            <p class="text-white-50 mb-0 small" style="max-width: 680px; line-height: 1.6;">
                Instantly synchronize all database tables, verify schemas, seed 1,000+ faculty, 267 syllabus schemes, 26 constituent colleges, 95 degree courses, 71 gallery photos, and settings so your Admin CMS view and Live Website are 100% in sync with zero missing data.
            </p>
        </div>
        <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
            <button type="button" class="btn btn-warning btn-lg fw-bold px-4 py-3 text-dark shadow rounded-pill" id="masterSyncBtn" onclick="triggerMasterSync('all', true)">
                <i class="fas fa-sync-alt fa-spin-hover me-2 text-danger"></i> ⚡ 1-Click DB Sync Now
            </button>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     CONNECTION DIAGNOSTIC METRICS STRIP
═══════════════════════════════════════════════════════ -->
<div class="row g-3 mb-4">
    <!-- Status -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100" style="border-left: 4px solid #059669 !important;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem;">DB Connection</span>
                <span class="badge bg-success-subtle text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Connected</span>
            </div>
            <div class="h5 fw-bold text-navy mb-0"><?php echo strtoupper($dbStatus['driver']); ?> Engine</div>
            <small class="text-muted" style="font-size: 0.75rem;">UTF8MB4 Unicode Support</small>
        </div>
    </div>

    <!-- Host & Database -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100" style="border-left: 4px solid #2563eb !important;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem;">Target Database</span>
                <i class="fas fa-server text-primary"></i>
            </div>
            <div class="h5 fw-bold text-navy mb-0 text-truncate" title="<?php echo sanitize($dbStatus['dbname']); ?>"><?php echo sanitize($dbStatus['dbname']); ?></div>
            <small class="text-muted" style="font-size: 0.75rem;">Host: <?php echo sanitize($dbStatus['host']); ?></small>
        </div>
    </div>

    <!-- Total Tables -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100" style="border-left: 4px solid #d97706 !important;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem;">Database Tables</span>
                <i class="fas fa-table text-warning"></i>
            </div>
            <div class="h5 fw-bold text-navy mb-0"><?php echo $dbStatus['tables_count']; ?> Tables Active</div>
            <small class="text-muted" style="font-size: 0.75rem;">Fully Schema Aligned</small>
        </div>
    </div>

    <!-- Total Records -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100" style="border-left: 4px solid #7a0b0d !important;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem;">Total DB Records</span>
                <i class="fas fa-layer-group text-danger"></i>
            </div>
            <div class="h5 fw-bold text-navy mb-0" id="totalRowsBadge"><?php echo number_format($dbStatus['total_rows']); ?> Rows</div>
            <small class="text-muted" style="font-size: 0.75rem;">Live Dynamic Data</small>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     SYNC PROGRESS / STATUS ALERT BOX (AJAX Interactive)
═══════════════════════════════════════════════════════ -->
<div id="syncProgressAlert" class="alert alert-info border-0 shadow-sm rounded-4 d-none mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;">
            <span class="visually-hidden">Syncing...</span>
        </div>
        <div class="flex-grow-1">
            <h6 class="fw-bold mb-1" id="syncProgressTitle">Synchronizing Database Tables...</h6>
            <p class="mb-0 small text-muted" id="syncProgressDesc">Please wait while schemas are migrated and master records are populated into MySQL.</p>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     MODULE-BY-MODULE SYNCHRONIZATION MATRIX
═══════════════════════════════════════════════════════ -->
<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-header bg-white border-bottom p-3 p-md-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
            <h5 class="fw-bold text-navy mb-1"><i class="fas fa-th-list text-danger me-2"></i> Database Table Health &amp; Sync Status</h5>
            <small class="text-muted">Review current live database counts vs reference master counts. Click "Sync" for individual or all modules.</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <form method="POST" action="manage_dbsync.php" class="d-inline">
                <input type="hidden" name="action" value="sync">
                <input type="hidden" name="target" value="all">
                <input type="hidden" name="force" value="1">
                <button type="submit" class="btn btn-sm btn-outline-danger fw-bold rounded-pill px-3">
                    <i class="fas fa-redo me-1"></i> Force Full Refresh
                </button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Module Name</th>
                    <th>Database Table</th>
                    <th class="text-center">Current DB Count</th>
                    <th class="text-center">Master Target</th>
                    <th>Health Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($syncModules as $key => $mod): 
                    $currCount = $tables[$mod['table']] ?? 0;
                    $expected = $mod['expected'];
                    $isHealthy = ($expected === null) ? true : ($currCount >= $expected * 0.7);
                    $isEmpty = ($currCount === 0);
                ?>
                <tr id="row-<?php echo $key; ?>">
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 bg-light p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; flex-shrink: 0;">
                                <i class="<?php echo $mod['icon']; ?>"></i>
                            </div>
                            <div>
                                <strong class="text-navy d-block" style="font-size: 0.95rem;"><?php echo $mod['name']; ?></strong>
                                <small class="text-muted" style="font-size: 0.78rem;"><?php echo $mod['desc']; ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <code class="text-dark bg-light px-2 py-1 rounded small">`<?php echo $mod['table']; ?>`</code>
                    </td>
                    <td class="text-center">
                        <span class="fw-bold h6 mb-0 text-navy count-badge-<?php echo $key; ?>">
                            <?php echo number_format($currCount); ?>
                        </span>
                    </td>
                    <td class="text-center text-muted small">
                        <?php echo $expected ? number_format($expected) . '+' : 'Dynamic'; ?>
                    </td>
                    <td>
                        <?php if ($isEmpty && $expected !== null): ?>
                            <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-1 rounded-pill status-badge-<?php echo $key; ?>">
                                <i class="fas fa-exclamation-triangle me-1"></i> Empty / Missing
                            </span>
                        <?php elseif ($isHealthy): ?>
                            <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill status-badge-<?php echo $key; ?>">
                                <i class="fas fa-check-circle me-1"></i> Synced &amp; Active
                            </span>
                        <?php else: ?>
                            <span class="badge bg-warning-subtle text-warning fw-bold px-3 py-1 rounded-pill status-badge-<?php echo $key; ?>">
                                <i class="fas fa-info-circle me-1"></i> Partial (Sync Recommended)
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end pe-4">
                        <div class="d-inline-flex gap-2">
                            <?php if (!empty($mod['manage_url'])): ?>
                                <a href="<?php echo $mod['manage_url']; ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-2 px-md-3 small">
                                    <i class="fas fa-eye me-1"></i> <span class="d-none d-md-inline">View</span>
                                </a>
                            <?php endif; ?>
                            <?php if ($key !== 'enquiries' && $key !== 'complaints'): ?>
                                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 fw-semibold small" onclick="triggerMasterSync('<?php echo $key; ?>', true)">
                                    <i class="fas fa-sync-alt me-1"></i> Sync
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     LIVE SERVER (GODADDY / CPANEL) DEPLOYMENT GUIDE
══════════════════════════════════════════════════════════ -->
<div class="card border-0 shadow-sm rounded-4 bg-white p-4">
    <h5 class="fw-bold text-navy mb-3">
        <i class="fas fa-question-circle text-primary me-2"></i> How Live Server Database Synchronization Works
    </h5>
    <div class="row g-4">
        <div class="col-12 col-md-4">
            <div class="p-3 bg-light rounded-4 h-100 border">
                <div class="fw-bold text-navy mb-1"><i class="fas fa-upload text-danger me-2"></i> Step 1: Upload Files</div>
                <p class="small text-muted mb-0">
                    Upload all project files (including <code>srku_db.sql</code>, <code>config/</code>, <code>includes/</code>, <code>assets/</code>) to your GoDaddy cPanel <code>public_html/</code> directory.
                </p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="p-3 bg-light rounded-4 h-100 border">
                <div class="fw-bold text-navy mb-1"><i class="fas fa-key text-warning me-2"></i> Step 2: Configure DB in config.php</div>
                <p class="small text-muted mb-0">
                    In <code>config/config.php</code>, update <code>DB_USER</code>, <code>DB_PASS</code>, and <code>DB_NAME</code> with your cPanel MySQL database credentials.
                </p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="p-3 bg-light rounded-4 h-100 border">
                <div class="fw-bold text-navy mb-1"><i class="fas fa-bolt text-success me-2"></i> Step 3: Click 1-Click DB Sync</div>
                <p class="small text-muted mb-0">
                    Log in to <code>admin/</code>, navigate to <strong>DB Sync &amp; Health</strong>, and click <strong>1-Click DB Sync Now</strong>. All tables and 1,500+ records are instantly imported and connected.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function triggerMasterSync(target, force) {
    const alertBox = document.getElementById('syncProgressAlert');
    const title = document.getElementById('syncProgressTitle');
    const desc = document.getElementById('syncProgressDesc');
    const masterBtn = document.getElementById('masterSyncBtn');

    alertBox.classList.remove('d-none', 'alert-success', 'alert-danger');
    alertBox.classList.add('alert-info');
    title.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Synchronizing ' + (target === 'all' ? 'All Database Tables' : target) + '...';
    desc.innerText = 'Applying schema migrations and populating master records. Please do not close this window.';
    
    if (masterBtn) masterBtn.disabled = true;

    fetch('manage_dbsync.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'ajax_sync=1&target=' + encodeURIComponent(target) + '&force=' + (force ? '1' : '0')
    })
    .then(response => response.json())
    .then(data => {
        if (masterBtn) masterBtn.disabled = false;
        
        if (data.success) {
            alertBox.classList.remove('alert-info');
            alertBox.classList.add('alert-success');
            title.innerHTML = '<i class="fas fa-check-circle text-success me-2"></i> Database Synchronization Completed Successfully!';
            
            let summaryText = '<strong>Summary:</strong> ';
            if (data.messages && data.messages.length > 0) {
                summaryText += data.messages.join(' | ');
            } else {
                summaryText += 'All modules verified and updated.';
            }
            desc.innerHTML = summaryText;

            // Update UI count badges dynamically
            if (data.counts) {
                for (const [modKey, count] of Object.entries(data.counts)) {
                    const badge = document.querySelector('.count-badge-' + modKey);
                    if (badge) badge.innerText = Number(count).toLocaleString();

                    const statusBadge = document.querySelector('.status-badge-' + modKey);
                    if (statusBadge) {
                        statusBadge.className = 'badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill status-badge-' + modKey;
                        statusBadge.innerHTML = '<i class="fas fa-check-circle me-1"></i> Synced & Active';
                    }
                }
            }

            if (data.status_info && data.status_info.total_rows) {
                const totalEl = document.getElementById('totalRowsBadge');
                if (totalEl) totalEl.innerText = Number(data.status_info.total_rows).toLocaleString() + ' Rows';
            }
        } else {
            alertBox.classList.remove('alert-info');
            alertBox.classList.add('alert-danger');
            title.innerHTML = '<i class="fas fa-times-circle text-danger me-2"></i> Synchronization Error';
            desc.innerText = data.error || 'An error occurred during synchronization.';
        }
    })
    .catch(err => {
        if (masterBtn) masterBtn.disabled = false;
        alertBox.classList.remove('alert-info');
        alertBox.classList.add('alert-danger');
        title.innerHTML = '<i class="fas fa-times-circle text-danger me-2"></i> Connection Error';
        desc.innerText = 'Failed to communicate with server. Error: ' + err.message;
    });
}
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
