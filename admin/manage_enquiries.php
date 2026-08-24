<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Ensure all columns exist in `enquiries`
try {
    $cols = $pdo->query("SHOW COLUMNS FROM `enquiries`")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('father_name', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `father_name` VARCHAR(150) AFTER `name`");
    if (!in_array('city', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `city` VARCHAR(100) AFTER `course`");
    if (!in_array('state', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `state` VARCHAR(100) AFTER `city`");
    if (!in_array('source', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `source` VARCHAR(150) AFTER `state`");
    if (!in_array('status', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `status` VARCHAR(50) DEFAULT 'New' AFTER `message`");
} catch (Exception $e) {}

// Filters & Search
$search = sanitize($_GET['q'] ?? '');
$filterStatus = sanitize($_GET['status'] ?? '');
$filterType = sanitize($_GET['type'] ?? '');

// Export to CSV
if (isset($_GET['action']) && $_GET['action'] === 'export') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=srku_admissions_leads_' . date('Y-m-d') . '.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Candidate Name', "Father's Name", 'Email', 'Phone', 'Course/Department', 'City', 'State', 'Source / Form', 'Status', 'Details / Message', 'Date Submitted']);
    
    $exportQuery = "SELECT id, name, father_name, email, phone, course, city, state, source, status, message, created_at FROM enquiries ORDER BY id DESC";
    $rows = $pdo->query($exportQuery)->fetchAll();
    foreach ($rows as $r) {
        fputcsv($output, [
            $r['id'],
            $r['name'],
            $r['father_name'] ?? '',
            $r['email'],
            $r['phone'],
            $r['course'],
            $r['city'] ?? '',
            $r['state'] ?? '',
            $r['source'] ?? 'Website Form',
            $r['status'] ?? 'New',
            $r['message'],
            $r['created_at']
        ]);
    }
    exit;
}

// Update Status
if (isset($_POST['update_status'])) {
    $id = (int)$_POST['id'];
    $status = sanitize($_POST['status'] ?? 'New');
    $stmt = $pdo->prepare("UPDATE enquiries SET status = :st WHERE id = :id");
    $stmt->execute([':st' => $status, ':id' => $id]);
    setFlashMsg('success', "Lead #$id status updated to $status.");
    header("Location: manage_enquiries.php" . ($filterType ? "?type=" . urlencode($filterType) : ''));
    exit;
}

// Delete Lead
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', "Lead #$id deleted successfully.");
    header("Location: manage_enquiries.php" . ($filterType ? "?type=" . urlencode($filterType) : ''));
    exit;
}

// Build Query
$query = "SELECT * FROM enquiries WHERE 1=1";
$params = [];

if ($search) {
    $query .= " AND (name LIKE :q OR email LIKE :q OR phone LIKE :q OR course LIKE :q OR message LIKE :q OR city LIKE :q OR state LIKE :q OR father_name LIKE :q)";
    $params[':q'] = "%$search%";
}
if ($filterStatus) {
    $query .= " AND status = :st";
    $params[':st'] = $filterStatus;
}
if ($filterType === 'admission') {
    $query .= " AND (source LIKE '%Admission%' OR message LIKE '%Admission%' OR (course != '' AND source NOT LIKE '%Grievance%'))";
} elseif ($filterType === 'contact') {
    $query .= " AND (source LIKE '%Contact%' OR message LIKE '%Contact%')";
} elseif ($filterType === 'grievance') {
    $query .= " AND (source LIKE '%Grievance%' OR message LIKE '%Grievance%')";
} elseif ($filterType === 'department') {
    $query .= " AND (source LIKE '%Department%' OR source LIKE '%Constituent%')";
} elseif ($filterType === 'career') {
    $query .= " AND (source LIKE '%Career%' OR message LIKE '%Career%')";
}

$query .= " ORDER BY id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$enquiries = $stmt->fetchAll();

// Lead Metrics
$totalCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();
$newCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'New' OR status IS NULL")->fetchColumn();
$admissionCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE (source LIKE '%Admission%' OR message LIKE '%Admission%') AND source NOT LIKE '%Grievance%'")->fetchColumn();
$grievanceCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE source LIKE '%Grievance%' OR message LIKE '%Grievance%'")->fetchColumn();
$contactCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE source LIKE '%Contact%' OR message LIKE '%Contact%'")->fetchColumn();
$contactedCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'Contacted'")->fetchColumn();
$enrolledCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'Enrolled'")->fetchColumn();
?>

<!-- Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-user-graduate text-danger me-2"></i> Admissions, Contacts &amp; Grievances</h3>
        <p class="text-muted small mb-0">Track and manage student admission applications, grievance complaints, and contact requests submitted across the portal.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="manage_enquiries.php?action=export" class="btn btn-success fw-bold shadow-sm d-flex align-items-center gap-1">
            <i class="fas fa-file-excel"></i> <span>Export Leads (CSV)</span>
        </a>
    </div>
</div>

<!-- Metrics Cards -->
<div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-2 g-md-3 mb-4">
    <div class="col">
        <div class="card p-3 border-0 shadow-sm rounded-4 bg-white border-start border-4 border-primary h-100">
            <small class="text-muted text-uppercase fw-bold text-truncate d-block" style="font-size:0.68rem;">Total Submissions</small>
            <h4 class="fw-bold text-navy mb-0 mt-1"><?php echo $totalCount; ?></h4>
        </div>
    </div>
    <div class="col">
        <div class="card p-3 border-0 shadow-sm rounded-4 bg-white border-start border-4 border-warning h-100">
            <small class="text-muted text-uppercase fw-bold text-truncate d-block" style="font-size:0.68rem;">New / Unread</small>
            <h4 class="fw-bold text-warning mb-0 mt-1"><?php echo $newCount; ?></h4>
        </div>
    </div>
    <div class="col">
        <div class="card p-3 border-0 shadow-sm rounded-4 bg-white border-start border-4 border-danger h-100">
            <small class="text-muted text-uppercase fw-bold text-truncate d-block" style="font-size:0.68rem;">Admission Forms</small>
            <h4 class="fw-bold text-danger mb-0 mt-1"><?php echo $admissionCount; ?></h4>
        </div>
    </div>
    <div class="col">
        <div class="card p-3 border-0 shadow-sm rounded-4 bg-white border-start border-4 border-info h-100">
            <small class="text-muted text-uppercase fw-bold text-truncate d-block" style="font-size:0.68rem;">Grievances</small>
            <h4 class="fw-bold text-info mb-0 mt-1"><?php echo $grievanceCount; ?></h4>
        </div>
    </div>
    <div class="col">
        <div class="card p-3 border-0 shadow-sm rounded-4 bg-white border-start border-4 border-success h-100">
            <small class="text-muted text-uppercase fw-bold text-truncate d-block" style="font-size:0.68rem;">Enrolled / Converted</small>
            <h4 class="fw-bold text-success mb-0 mt-1"><?php echo $enrolledCount; ?></h4>
        </div>
    </div>
</div>

<!-- Source Type Filter Tabs -->
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="manage_enquiries.php" class="btn btn-sm <?php echo empty($filterType) ? 'btn-navy fw-bold' : 'btn-light border text-dark'; ?> rounded-pill px-3 py-1">
        All Submissions (<?php echo $totalCount; ?>)
    </a>
    <a href="manage_enquiries.php?type=admission" class="btn btn-sm <?php echo $filterType === 'admission' ? 'btn-danger fw-bold' : 'btn-light border text-dark'; ?> rounded-pill px-3 py-1">
        <i class="fas fa-file-signature me-1"></i> Admission Forms (<?php echo $admissionCount; ?>)
    </a>
    <a href="manage_enquiries.php?type=grievance" class="btn btn-sm <?php echo $filterType === 'grievance' ? 'btn-info text-white fw-bold' : 'btn-light border text-dark'; ?> rounded-pill px-3 py-1">
        <i class="fas fa-balance-scale me-1"></i> Grievances (<?php echo $grievanceCount; ?>)
    </a>
    <a href="manage_enquiries.php?type=contact" class="btn btn-sm <?php echo $filterType === 'contact' ? 'btn-primary fw-bold' : 'btn-light border text-dark'; ?> rounded-pill px-3 py-1">
        <i class="fas fa-envelope-open-text me-1"></i> Contact Queries
    </a>
    <a href="manage_enquiries.php?type=department" class="btn btn-sm <?php echo $filterType === 'department' ? 'btn-warning text-dark fw-bold' : 'btn-light border text-dark'; ?> rounded-pill px-3 py-1">
        <i class="fas fa-university me-1"></i> Department Leads
    </a>
    <a href="manage_enquiries.php?type=career" class="btn btn-sm <?php echo $filterType === 'career' ? 'btn-secondary fw-bold' : 'btn-light border text-dark'; ?> rounded-pill px-3 py-1">
        <i class="fas fa-briefcase me-1"></i> Career Leads
    </a>
</div>

<!-- Search & Status Filter Bar -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="manage_enquiries.php" class="row g-2 align-items-center">
        <?php if ($filterType): ?>
            <input type="hidden" name="type" value="<?php echo sanitize($filterType); ?>">
        <?php endif; ?>
        <div class="col-12 col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="q" value="<?php echo sanitize($search); ?>" class="form-control" placeholder="Search by name, father's name, email, phone, city, course...">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <select name="status" class="form-select">
                <option value="">-- All Lead Statuses --</option>
                <option value="New" <?php echo $filterStatus === 'New' ? 'selected' : ''; ?>>🟡 New Leads</option>
                <option value="Contacted" <?php echo $filterStatus === 'Contacted' ? 'selected' : ''; ?>>🔵 Contacted</option>
                <option value="Enrolled" <?php echo $filterStatus === 'Enrolled' ? 'selected' : ''; ?>>🟢 Enrolled</option>
                <option value="Closed" <?php echo $filterStatus === 'Closed' ? 'selected' : ''; ?>>⚫ Closed</option>
            </select>
        </div>
        <div class="col-6 col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-bold flex-grow-1"><i class="fas fa-filter me-1"></i> Filter</button>
            <?php if ($search || $filterStatus || $filterType): ?>
                <a href="manage_enquiries.php" class="btn btn-outline-secondary"><i class="fas fa-redo"></i> Reset</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Leads Table -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:55px;">#ID</th>
                    <th>Candidate Details</th>
                    <th>Course / Program</th>
                    <th>Origin / Source</th>
                    <th>Status</th>
                    <th>Date Received</th>
                    <th class="text-end text-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($enquiries)): ?>
                    <?php foreach ($enquiries as $eq): 
                        $st = $eq['status'] ?? 'New';
                        $badgeClass = 'bg-secondary';
                        if ($st === 'New') $badgeClass = 'bg-warning text-dark';
                        elseif ($st === 'Contacted') $badgeClass = 'bg-info text-white';
                        elseif ($st === 'Enrolled') $badgeClass = 'bg-success text-white';
                        elseif ($st === 'Closed') $badgeClass = 'bg-dark text-white';
                        
                        $cleanPhone = preg_replace('/[^0-9]/', '', $eq['phone']);
                        $src = $eq['source'] ?? '';
                        if (empty($src) && !empty($eq['message'])) {
                            if (preg_match('/^\[(.*?)\]/', $eq['message'], $m)) {
                                $src = $m[1];
                            }
                        }
                        if (empty($src)) $src = 'Website Form';
                    ?>
                        <tr>
                            <td class="fw-bold text-muted">#<?php echo $eq['id']; ?></td>
                            <td>
                                <strong class="text-navy d-block fs-6"><?php echo sanitize($eq['name']); ?></strong>
                                <?php if (!empty($eq['father_name'])): ?>
                                    <small class="text-muted d-block"><i class="fas fa-user-friends me-1 text-secondary"></i>S/o / D/o: <?php echo sanitize($eq['father_name']); ?></small>
                                <?php endif; ?>
                                <small class="text-muted d-block"><i class="fas fa-envelope me-1 text-danger"></i><?php echo sanitize($eq['email']); ?></small>
                                <small class="text-muted d-block"><i class="fas fa-phone me-1 text-success"></i><?php echo sanitize($eq['phone']); ?></small>
                                <?php if (!empty($eq['city']) || !empty($eq['state'])): ?>
                                    <small class="text-secondary d-block"><i class="fas fa-map-marker-alt me-1 text-warning"></i><?php echo implode(', ', array_filter([$eq['city'] ?? '', $eq['state'] ?? ''])); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1"><?php echo sanitize($eq['course'] ?: 'General Enquiry'); ?></span>
                            </td>
                            <td>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 small" style="font-size:0.75rem;">
                                    <?php echo sanitize($src); ?>
                                </span>
                            </td>
                            <td>
                                <form action="manage_enquiries.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $eq['id']; ?>">
                                    <select name="status" class="form-select form-select-sm fw-bold border-<?php echo $badgeClass; ?>" onchange="this.form.submit()" style="width:125px;">
                                        <option value="New" <?php echo $st === 'New' ? 'selected' : ''; ?>>🟡 New</option>
                                        <option value="Contacted" <?php echo $st === 'Contacted' ? 'selected' : ''; ?>>🔵 Contacted</option>
                                        <option value="Enrolled" <?php echo $st === 'Enrolled' ? 'selected' : ''; ?>>🟢 Enrolled</option>
                                        <option value="Closed" <?php echo $st === 'Closed' ? 'selected' : ''; ?>>⚫ Closed</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td>
                                <small class="text-muted d-block"><?php echo date('M d, Y', strtotime($eq['created_at'])); ?></small>
                                <small class="text-muted text-nowrap" style="font-size:0.75rem;"><?php echo date('h:i A', strtotime($eq['created_at'])); ?></small>
                            </td>
                            <td class="text-end text-nowrap">
                                <div class="action-btn-group">
                                    <!-- WhatsApp Direct -->
                                    <?php if ($cleanPhone): ?>
                                        <a href="https://api.whatsapp.com/send?phone=91<?php echo $cleanPhone; ?>&text=Hello%20<?php echo urlencode($eq['name']); ?>,%20greetings%20from%20SRK%20University%20Admissions." target="_blank" class="btn btn-sm btn-outline-success" title="WhatsApp Candidate">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <a href="tel:<?php echo $cleanPhone; ?>" class="btn btn-sm btn-outline-primary" title="Call Candidate">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <!-- View Details Modal Trigger -->
                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#leadModal<?php echo $eq['id']; ?>" title="View Full Details">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Delete -->
                                    <a href="manage_enquiries.php?action=delete&id=<?php echo $eq['id']; ?>" onclick="return confirm('Delete enquiry lead #<?php echo $eq['id']; ?>?');" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>

                                <!-- Lead Modal -->
                                <div class="modal fade" id="leadModal<?php echo $eq['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered text-start">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header bg-navy text-white rounded-top-4">
                                                <h5 class="modal-title h6 fw-bold mb-0">Lead Details #<?php echo $eq['id']; ?> — <?php echo sanitize($eq['name']); ?></h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row g-3 mb-3">
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Candidate Name</small>
                                                        <strong class="text-navy"><?php echo sanitize($eq['name']); ?></strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Status</small>
                                                        <span class="badge <?php echo $badgeClass; ?>"><?php echo $st; ?></span>
                                                    </div>
                                                    <?php if (!empty($eq['father_name'])): ?>
                                                        <div class="col-12">
                                                            <small class="text-muted d-block">Father's Name</small>
                                                            <strong class="text-dark"><?php echo sanitize($eq['father_name']); ?></strong>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Email Address</small>
                                                        <a href="mailto:<?php echo sanitize($eq['email']); ?>"><?php echo sanitize($eq['email']); ?></a>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Mobile Number</small>
                                                        <a href="tel:<?php echo sanitize($eq['phone']); ?>"><?php echo sanitize($eq['phone']); ?></a>
                                                    </div>
                                                    <?php if (!empty($eq['city']) || !empty($eq['state'])): ?>
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">City</small>
                                                            <strong><?php echo sanitize($eq['city'] ?: 'N/A'); ?></strong>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-muted d-block">State</small>
                                                            <strong><?php echo sanitize($eq['state'] ?: 'N/A'); ?></strong>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Course / Program of Interest</small>
                                                        <strong class="text-danger"><?php echo sanitize($eq['course'] ?: 'General Enquiry'); ?></strong>
                                                    </div>
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Origin / Source Page</small>
                                                        <span class="badge bg-light text-dark border"><?php echo sanitize($src); ?></span>
                                                    </div>
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Full Message &amp; Query Details</small>
                                                        <div class="p-3 bg-light rounded-3 border text-dark mt-1" style="white-space:pre-wrap; font-size:0.9rem;">
                                                            <?php echo sanitize($eq['message'] ?: 'No additional message details provided.'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Received Timestamp</small>
                                                        <span><?php echo sanitize($eq['created_at']); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light rounded-bottom-4 justify-content-between">
                                                <div>
                                                    <?php if ($cleanPhone): ?>
                                                        <a href="https://api.whatsapp.com/send?phone=91<?php echo $cleanPhone; ?>&text=Hello%20<?php echo urlencode($eq['name']); ?>,%20greetings%20from%20SRK%20University%20Admissions." target="_blank" class="btn btn-sm btn-success">
                                                            <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                                        </a>
                                                        <a href="tel:<?php echo $cleanPhone; ?>" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-phone me-1"></i> Call
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x text-muted opacity-50 mb-3 d-block"></i>
                            No enquiries or leads found matching your criteria.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
