<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();
$error = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM accreditations WHERE id = :id");
        $stmt->execute([':id' => $delId]);
        setFlashMsg('success', 'Accreditation / Regulatory approval removed successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error removing approval: ' . $e->getMessage());
    }
    header("Location: manage_accreditations.php");
    exit;
}

// Handle Status Toggle
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $toggleId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("UPDATE accreditations SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = :id");
        $stmt->execute([':id' => $toggleId]);
        setFlashMsg('success', 'Approval status updated successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error updating status: ' . $e->getMessage());
    }
    header("Location: manage_accreditations.php");
    exit;
}

// Handle Add / Edit Form Submission
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['save_accreditation'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $code = trim($_POST['code'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $domain = trim($_POST['domain'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $status = in_array($_POST['status'] ?? '', ['active', 'inactive']) ? $_POST['status'] : 'active';

    if (empty($code) || empty($name)) {
        $error = 'Please enter both Council Code and Council Full Name.';
    } else {
        try {
            if ($id > 0) {
                $stmt = $pdo->prepare("UPDATE accreditations SET code = :c, name = :n, domain = :d, description = :desc, sort_order = :so, status = :st WHERE id = :id");
                $stmt->execute([
                    ':c' => $code,
                    ':n' => $name,
                    ':d' => $domain,
                    ':desc' => $description,
                    ':so' => $sortOrder,
                    ':st' => $status,
                    ':id' => $id
                ]);
                setFlashMsg('success', 'Accreditation record updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO accreditations (code, name, domain, description, sort_order, status) VALUES (:c, :n, :d, :desc, :so, :st)");
                $stmt->execute([
                    ':c' => $code,
                    ':n' => $name,
                    ':d' => $domain,
                    ':desc' => $description,
                    ':so' => $sortOrder,
                    ':st' => $status
                ]);
                setFlashMsg('success', 'New accreditation added successfully.');
            }
            header("Location: manage_accreditations.php");
            exit;
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Fetch single record for editing
$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $editId = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM accreditations WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    $editItem = $stmt->fetch();
}

$accreditations = [];
try {
    $stmt = $pdo->query("SELECT * FROM accreditations ORDER BY sort_order ASC, id ASC");
    $accreditations = $stmt->fetchAll();
} catch (Exception $e) {
    $error = 'Unable to fetch accreditations: ' . $e->getMessage();
}
?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-certificate text-danger me-2"></i> Statutory Accreditations &amp; Approvals</h3>
        <p class="text-muted small mb-0">Manage university apex recognitions: UGC, AICTE, NMC, PCI, INC, BCI, NDC, NCISM, NCH &amp; MPPURC.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL; ?>accreditation.php" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-external-link-alt me-1"></i> Live Accreditations Page
        </a>
        <a href="manage_accreditations.php#entry-form" class="btn btn-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-plus me-1"></i> Add Approval
        </a>
    </div>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row g-4 mb-5">
    
    <!-- Left Column: Add / Edit Form -->
    <div class="col-12 col-lg-5" id="entry-form">
        <div class="card border-0 shadow-sm rounded-4 p-4 sticky-lg-top" style="top: 80px; z-index: 10;">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h5 class="fw-bold text-navy mb-0">
                    <i class="fas <?php echo $editItem ? 'fa-edit text-primary' : 'fa-plus-circle text-success'; ?> me-2"></i>
                    <?php echo $editItem ? 'Edit Accreditation' : 'Add New Statutory Approval'; ?>
                </h5>
                <?php if ($editItem): ?>
                    <a href="manage_accreditations.php" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0">Cancel</a>
                <?php endif; ?>
            </div>

            <form action="manage_accreditations.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $editItem['id'] ?? 0; ?>">

                <div class="row g-2 mb-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold small text-dark">Council Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control form-control-sm text-uppercase" required
                               value="<?php echo htmlspecialchars($editItem['code'] ?? ''); ?>"
                               placeholder="e.g. UGC, AICTE">
                    </div>
                    <div class="col-md-7">
                        <label class="form-label fw-bold small text-dark">Domain / Scope</label>
                        <input type="text" name="domain" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($editItem['domain'] ?? ''); ?>"
                               placeholder="e.g. Govt. of India, Medical">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Council Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-sm" required
                           value="<?php echo htmlspecialchars($editItem['name'] ?? ''); ?>"
                           placeholder="e.g. University Grants Commission">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Approval Scope Description</label>
                    <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="Details of statutory recognition and degree awarding mandate..."><?php echo htmlspecialchars($editItem['description'] ?? ''); ?></textarea>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-dark">Display Order</label>
                        <input type="number" name="sort_order" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($editItem['sort_order'] ?? 0); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-dark">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="active" <?php echo (($editItem['status'] ?? 'active') === 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo (($editItem['status'] ?? '') === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <button type="submit" name="save_accreditation" class="btn btn-danger btn-sm w-100 rounded-pill py-2 fw-bold">
                    <i class="fas fa-save me-1"></i> <?php echo $editItem ? 'Update Accreditation' : 'Save Accreditation'; ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: Accreditations List -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold text-navy mb-3">Statutory Regulatory Approvals (<?php echo count($accreditations); ?>)</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 20%;">Council</th>
                            <th style="width: 45%;">Name &amp; Scope</th>
                            <th style="width: 12%;">Status</th>
                            <th style="width: 18%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($accreditations)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No accreditations found. Add your first approval on the left.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($accreditations as $idx => $ap): ?>
                                <tr>
                                    <td class="text-muted fw-bold"><?php echo $ap['sort_order'] ?: ($idx + 1); ?></td>
                                    <td>
                                        <div class="fw-bold text-navy fs-6"><?php echo htmlspecialchars($ap['code'] ?? ''); ?></div>
                                        <span class="badge bg-light text-muted border rounded-pill small" style="font-size: 0.72rem;">
                                            <?php echo htmlspecialchars($ap['domain'] ?? ''); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?php echo htmlspecialchars($ap['name'] ?? ''); ?></div>
                                        <small class="text-muted d-block text-truncate" style="max-width: 280px; font-size: 0.78rem;">
                                            <?php echo htmlspecialchars($ap['description'] ?? ''); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <a href="manage_accreditations.php?action=toggle&id=<?php echo $ap['id']; ?>" class="badge rounded-pill text-decoration-none <?php echo $ap['status'] === 'active' ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo ucfirst($ap['status']); ?>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <a href="manage_accreditations.php?action=edit&id=<?php echo $ap['id']; ?>#entry-form" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="manage_accreditations.php?action=delete&id=<?php echo $ap['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 ms-1" onclick="return confirm('Are you sure you want to delete this approval?');" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
