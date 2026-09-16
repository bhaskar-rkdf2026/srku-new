<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();
$error = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM placements WHERE id = :id");
        $stmt->execute([':id' => $delId]);
        setFlashMsg('success', 'Corporate recruiter removed successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error removing recruiter: ' . $e->getMessage());
    }
    header("Location: manage_placements.php");
    exit;
}

// Handle Status Toggle
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $toggleId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("UPDATE placements SET status = CASE WHEN status = 1 THEN 0 ELSE 1 END WHERE id = :id");
        $stmt->execute([':id' => $toggleId]);
        setFlashMsg('success', 'Placement partner status updated successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error updating status: ' . $e->getMessage());
    }
    header("Location: manage_placements.php");
    exit;
}

// Handle Add / Edit Form Submission
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['save_placement'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $companyName = trim($_POST['company_name'] ?? '');
    $packageOffered = trim($_POST['package_offered'] ?? '');
    $logoUrl = trim($_POST['logo_url'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;

    // Handle Logo Upload
    if (isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
        $ext = strtolower(pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $uploadDir = __DIR__ . '/../assets/uploads/placements/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($_FILES['logo_file']['name'], PATHINFO_FILENAME));
            $fn = $cleanName . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $uploadDir . $fn)) {
                $logoUrl = 'assets/uploads/placements/' . $fn;
            }
        }
    }

    if (empty($companyName)) {
        $error = 'Please enter the Corporate Recruiter / Company Name.';
    } else {
        try {
            if ($id > 0) {
                $stmt = $pdo->prepare("UPDATE placements SET company_name = :c, logo_url = :l, package_offered = :p, sort_order = :so, status = :st WHERE id = :id");
                $stmt->execute([
                    ':c' => $companyName,
                    ':l' => $logoUrl,
                    ':p' => $packageOffered,
                    ':so' => $sortOrder,
                    ':st' => $status,
                    ':id' => $id
                ]);
                setFlashMsg('success', 'Corporate recruiter updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO placements (company_name, logo_url, package_offered, sort_order, status) VALUES (:c, :l, :p, :so, :st)");
                $stmt->execute([
                    ':c' => $companyName,
                    ':l' => $logoUrl,
                    ':p' => $packageOffered,
                    ':so' => $sortOrder,
                    ':st' => $status
                ]);
                setFlashMsg('success', 'New corporate partner added successfully.');
            }
            header("Location: manage_placements.php");
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
    $stmt = $pdo->prepare("SELECT * FROM placements WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    $editItem = $stmt->fetch();
}

$companies = [];
try {
    $stmt = $pdo->query("SELECT * FROM placements ORDER BY sort_order ASC, id ASC");
    $companies = $stmt->fetchAll();
} catch (Exception $e) {
    $error = 'Unable to fetch placements: ' . $e->getMessage();
}
?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-handshake text-danger me-2"></i> Corporate Placement Partners &amp; Recruiters</h3>
        <p class="text-muted small mb-0">Manage 120+ hiring conglomerates, recruiter logos, salary packages offered, and marquee ticker partners.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL; ?>placements.php" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-external-link-alt me-1"></i> Live Placements Page
        </a>
        <a href="manage_placements.php#entry-form" class="btn btn-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-plus me-1"></i> Add Partner
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
                    <?php echo $editItem ? 'Edit Recruiter' : 'Add Corporate Hiring Partner'; ?>
                </h5>
                <?php if ($editItem): ?>
                    <a href="manage_placements.php" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0">Cancel</a>
                <?php endif; ?>
            </div>

            <form action="manage_placements.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $editItem['id'] ?? 0; ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Company / Organization Name <span class="text-danger">*</span></label>
                    <input type="text" name="company_name" class="form-control form-control-sm" required
                           value="<?php echo htmlspecialchars($editItem['company_name'] ?? ''); ?>"
                           placeholder="e.g. Tata Consultancy Services (TCS)">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-dark">Package Offered</label>
                        <input type="text" name="package_offered" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($editItem['package_offered'] ?? ''); ?>"
                               placeholder="e.g. 7.5 LPA, 12 LPA">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-dark">Display Order</label>
                        <input type="number" name="sort_order" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($editItem['sort_order'] ?? 0); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Logo Image URL / Path</label>
                    <input type="text" name="logo_url" class="form-control form-control-sm mb-1"
                           value="<?php echo htmlspecialchars($editItem['logo_url'] ?? ''); ?>"
                           placeholder="e.g. assets/uploads/2026/07/1.webp or https://...">
                    <label class="form-label small text-muted mb-1">OR Upload Recruiter Logo:</label>
                    <input type="file" name="logo_file" class="form-control form-control-sm" accept="image/*,.svg">
                    <?php if (!empty($editItem['logo_url'])): ?>
                        <div class="mt-2 p-2 bg-light rounded text-center border">
                            <img src="<?php echo htmlspecialchars(strpos($editItem['logo_url'], 'http') === 0 ? $editItem['logo_url'] : BASE_URL . $editItem['logo_url']); ?>" alt="Current Logo" style="max-height: 40px; max-width: 140px; object-fit: contain;">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="1" <?php echo (($editItem['status'] ?? 1) == 1) ? 'selected' : ''; ?>>Active (Visible on Website)</option>
                        <option value="0" <?php echo (($editItem['status'] ?? 1) == 0) ? 'selected' : ''; ?>>Inactive (Hidden)</option>
                    </select>
                </div>

                <button type="submit" name="save_placement" class="btn btn-danger btn-sm w-100 rounded-pill py-2 fw-bold">
                    <i class="fas fa-save me-1"></i> <?php echo $editItem ? 'Update Recruiter' : 'Save Recruiter'; ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: Recruiters List -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold text-navy mb-3">Corporate Recruitment Partners (<?php echo count($companies); ?>)</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 18%;">Logo</th>
                            <th style="width: 40%;">Company Name</th>
                            <th style="width: 15%;">Package</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 12%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($companies)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No recruiters found. Add your first hiring partner on the left.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($companies as $idx => $c): ?>
                                <tr>
                                    <td class="text-muted fw-bold"><?php echo $c['sort_order'] ?: ($idx + 1); ?></td>
                                    <td>
                                        <?php if (!empty($c['logo_url'])): ?>
                                            <div class="p-1 bg-white border rounded text-center" style="width: 70px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                                <img src="<?php echo htmlspecialchars(strpos($c['logo_url'], 'http') === 0 ? $c['logo_url'] : BASE_URL . $c['logo_url']); ?>" alt="<?php echo htmlspecialchars($c['company_name']); ?>" style="max-height: 30px; max-width: 60px; object-fit: contain;">
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">No Logo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-navy"><?php echo htmlspecialchars($c['company_name']); ?></div>
                                    </td>
                                    <td>
                                        <?php if (!empty($c['package_offered'])): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fw-semibold">
                                                <?php echo htmlspecialchars($c['package_offered']); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="manage_placements.php?action=toggle&id=<?php echo $c['id']; ?>" class="badge rounded-pill text-decoration-none <?php echo $c['status'] == 1 ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo $c['status'] == 1 ? 'Active' : 'Inactive'; ?>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <a href="manage_placements.php?action=edit&id=<?php echo $c['id']; ?>#entry-form" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="manage_placements.php?action=delete&id=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 ms-1" onclick="return confirm('Are you sure you want to delete this partner?');" title="Delete">
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
