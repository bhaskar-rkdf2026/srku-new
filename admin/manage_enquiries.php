<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Export to CSV
if (isset($_GET['action']) && $_GET['action'] === 'export') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=srku_leads_' . date('Y-m-d') . '.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Candidate Name', 'Email', 'Phone', 'Course/Department', 'Status', 'Details/Message', 'Date Submitted']);
    $rows = $pdo->query("SELECT id, name, email, phone, course, status, message, created_at FROM enquiries ORDER BY id DESC")->fetchAll();
    foreach ($rows as $r) {
        fputcsv($output, [$r['id'], $r['name'], $r['email'], $r['phone'], $r['course'], $r['status'] ?? 'New', $r['message'], $r['created_at']]);
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
    header("Location: manage_enquiries.php");
    exit;
}

// Delete Lead
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', "Lead #$id deleted successfully.");
    header("Location: manage_enquiries.php");
    exit;
}

// Filters & Search
$search = sanitize($_GET['q'] ?? '');
$filterStatus = sanitize($_GET['status'] ?? '');

$query = "SELECT * FROM enquiries WHERE 1=1";
$params = [];

if ($search) {
    $query .= " AND (name LIKE :q OR email LIKE :q OR phone LIKE :q OR course LIKE :q OR message LIKE :q)";
    $params[':q'] = "%$search%";
}
if ($filterStatus) {
    $query .= " AND status = :st";
    $params[':st'] = $filterStatus;
}
$query .= " ORDER BY id DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$enquiries = $stmt->fetchAll();

// Lead Metrics
$totalCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();
$newCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'New' OR status IS NULL")->fetchColumn();
$contactedCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'Contacted'")->fetchColumn();
$enrolledCount = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'Enrolled'")->fetchColumn();
?>

<!-- Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1">Student Enquiries &amp; Admission Leads</h3>
        <p class="text-muted small mb-0">Manage and track candidate admissions, contact requests, and job applications across the website.</p>
    </div>
    <div>
        <a href="manage_enquiries.php?action=export" class="btn btn-success fw-bold shadow-sm">
            <i class="fas fa-file-excel me-1"></i> Export All Leads (CSV)
        </a>
    </div>
</div>

<!-- Metrics Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-4 bg-white border-start border-4 border-primary">
            <small class="text-muted text-uppercase fw-bold" style="font-size:0.7rem;">Total Leads</small>
            <h3 class="fw-bold text-navy mb-0"><?php echo $totalCount; ?></h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-4 bg-white border-start border-4 border-warning">
            <small class="text-muted text-uppercase fw-bold" style="font-size:0.7rem;">New / Unread</small>
            <h3 class="fw-bold text-warning mb-0"><?php echo $newCount; ?></h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-4 bg-white border-start border-4 border-info">
            <small class="text-muted text-uppercase fw-bold" style="font-size:0.7rem;">Contacted</small>
            <h3 class="fw-bold text-info mb-0"><?php echo $contactedCount; ?></h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-4 bg-white border-start border-4 border-success">
            <small class="text-muted text-uppercase fw-bold" style="font-size:0.7rem;">Enrolled</small>
            <h3 class="fw-bold text-success mb-0"><?php echo $enrolledCount; ?></h3>
        </div>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="manage_enquiries.php" class="row g-2 align-items-center">
        <div class="col-12 col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="q" value="<?php echo sanitize($search); ?>" class="form-control" placeholder="Search by name, email, phone, course...">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <select name="status" class="form-select">
                <option value="">-- All Statuses --</option>
                <option value="New" <?php echo $filterStatus === 'New' ? 'selected' : ''; ?>>New Leads</option>
                <option value="Contacted" <?php echo $filterStatus === 'Contacted' ? 'selected' : ''; ?>>Contacted</option>
                <option value="Enrolled" <?php echo $filterStatus === 'Enrolled' ? 'selected' : ''; ?>>Enrolled</option>
                <option value="Closed" <?php echo $filterStatus === 'Closed' ? 'selected' : ''; ?>>Closed</option>
            </select>
        </div>
        <div class="col-6 col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-bold flex-grow-1"><i class="fas fa-filter me-1"></i> Filter</button>
            <?php if ($search || $filterStatus): ?>
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
                    <th style="width:60px;">#ID</th>
                    <th>Candidate Profile</th>
                    <th>Course / Stream</th>
                    <th>Lead Status</th>
                    <th>Details &amp; Source</th>
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
                    ?>
                        <tr>
                            <td class="fw-bold text-muted">#<?php echo $eq['id']; ?></td>
                            <td>
                                <strong class="text-navy d-block fs-6"><?php echo sanitize($eq['name']); ?></strong>
                                <small class="text-muted d-block"><i class="fas fa-envelope me-1 text-danger"></i><?php echo sanitize($eq['email']); ?></small>
                                <small class="text-muted d-block"><i class="fas fa-phone me-1 text-success"></i><?php echo sanitize($eq['phone']); ?></small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1"><?php echo sanitize($eq['course']); ?></span>
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
                                <p class="small text-secondary mb-0 text-truncate" style="max-width: 220px;" title="<?php echo htmlspecialchars($eq['message'] ?? ''); ?>">
                                    <?php echo nl2br(sanitize(substr($eq['message'] ?? '', 0, 100))); ?>
                                </p>
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
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Email Address</small>
                                                        <a href="mailto:<?php echo sanitize($eq['email']); ?>"><?php echo sanitize($eq['email']); ?></a>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Mobile Number</small>
                                                        <a href="tel:<?php echo sanitize($eq['phone']); ?>"><?php echo sanitize($eq['phone']); ?></a>
                                                    </div>
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Course / Program of Interest</small>
                                                        <strong class="text-danger"><?php echo sanitize($eq['course']); ?></strong>
                                                    </div>
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Full Message &amp; Source Details</small>
                                                        <div class="p-3 bg-light rounded-3 border text-dark mt-1" style="white-space:pre-wrap; font-size:0.9rem;">
                                                            <?php echo sanitize($eq['message'] ?: 'No message details provided.'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <small class="text-muted d-block">Received At</small>
                                                        <span><?php echo sanitize($eq['created_at']); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light rounded-bottom-4">
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
                            No enquiries or leads found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
