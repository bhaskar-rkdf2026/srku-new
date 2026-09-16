<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();
$error = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM facilities WHERE id = :id");
        $stmt->execute([':id' => $delId]);
        setFlashMsg('success', 'Campus facility removed successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error removing facility: ' . $e->getMessage());
    }
    header("Location: manage_facilities.php");
    exit;
}

// Handle Status Toggle
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $toggleId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("UPDATE facilities SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = :id");
        $stmt->execute([':id' => $toggleId]);
        setFlashMsg('success', 'Facility status updated successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error updating status: ' . $e->getMessage());
    }
    header("Location: manage_facilities.php");
    exit;
}

// Handle Add / Edit Form Submission
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['save_facility'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = trim($_POST['title'] ?? '');
    $slug = !empty($_POST['slug']) ? generateSlug($_POST['slug']) : generateSlug($title);
    $icon = trim($_POST['icon'] ?? 'fa-building');
    $tagline = trim($_POST['tagline'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $keyHighlights = trim($_POST['key_highlights'] ?? '');
    $imageUrl = trim($_POST['image_url'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $status = in_array($_POST['status'] ?? '', ['active', 'inactive']) ? $_POST['status'] : 'active';

    // Handle Image Upload
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $uploadDir = __DIR__ . '/../assets/uploads/facilities/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($_FILES['image_file']['name'], PATHINFO_FILENAME));
            $fn = $cleanName . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadDir . $fn)) {
                $imageUrl = 'assets/uploads/facilities/' . $fn;
            }
        }
    }

    if (empty($title)) {
        $error = 'Please enter the Facility Title.';
    } else {
        try {
            if ($id > 0) {
                $stmt = $pdo->prepare("UPDATE facilities SET title = :t, slug = :sl, icon = :ic, tagline = :tag, description = :d, key_highlights = :kh, image_url = :img, sort_order = :so, status = :st WHERE id = :id");
                $stmt->execute([
                    ':t' => $title,
                    ':sl' => $slug,
                    ':ic' => $icon,
                    ':tag' => $tagline,
                    ':d' => $description,
                    ':kh' => $keyHighlights,
                    ':img' => $imageUrl,
                    ':so' => $sortOrder,
                    ':st' => $status,
                    ':id' => $id
                ]);
                setFlashMsg('success', 'Campus facility updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO facilities (title, slug, icon, tagline, description, key_highlights, image_url, sort_order, status) VALUES (:t, :sl, :ic, :tag, :d, :kh, :img, :so, :st)");
                $stmt->execute([
                    ':t' => $title,
                    ':sl' => $slug,
                    ':ic' => $icon,
                    ':tag' => $tagline,
                    ':d' => $description,
                    ':kh' => $keyHighlights,
                    ':img' => $imageUrl,
                    ':so' => $sortOrder,
                    ':st' => $status
                ]);
                setFlashMsg('success', 'New campus facility added successfully.');
            }
            header("Location: manage_facilities.php");
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
    $stmt = $pdo->prepare("SELECT * FROM facilities WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    $editItem = $stmt->fetch();
}

$facilities = [];
try {
    $stmt = $pdo->query("SELECT * FROM facilities ORDER BY sort_order ASC, id ASC");
    $facilities = $stmt->fetchAll();
} catch (Exception $e) {
    $error = 'Unable to fetch facilities: ' . $e->getMessage();
}
?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-building text-danger me-2"></i> Campus Facilities &amp; Infrastructure</h3>
        <p class="text-muted small mb-0">Manage state-of-the-art campus amenities, laboratories, libraries, auditoriums, hostels, and sports complex.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL; ?>facilities.php" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-external-link-alt me-1"></i> Live Facilities Page
        </a>
        <a href="manage_facilities.php#entry-form" class="btn btn-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-plus me-1"></i> Add Facility
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
                    <?php echo $editItem ? 'Edit Campus Facility' : 'Add New Campus Facility'; ?>
                </h5>
                <?php if ($editItem): ?>
                    <a href="manage_facilities.php" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0">Cancel</a>
                <?php endif; ?>
            </div>

            <form action="manage_facilities.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $editItem['id'] ?? 0; ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Facility Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-sm" required
                           value="<?php echo htmlspecialchars($editItem['title'] ?? ''); ?>"
                           placeholder="e.g. 42+ Research Laboratories">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-dark">FontAwesome Icon Class</label>
                        <input type="text" name="icon" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($editItem['icon'] ?? 'fa-microscope'); ?>"
                               placeholder="e.g. fa-microscope, fa-book-reader">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-dark">Display Order</label>
                        <input type="number" name="sort_order" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($editItem['sort_order'] ?? 0); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Tagline / Short Subtitle</label>
                    <input type="text" name="tagline" class="form-control form-control-sm"
                           value="<?php echo htmlspecialchars($editItem['tagline'] ?? ''); ?>"
                           placeholder="e.g. Cutting-edge research & industrial grade simulation setups">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Description</label>
                    <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="Provide full description of the amenity..."><?php echo htmlspecialchars($editItem['description'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Image URL / Path</label>
                    <input type="text" name="image_url" class="form-control form-control-sm mb-1"
                           value="<?php echo htmlspecialchars($editItem['image_url'] ?? ''); ?>"
                           placeholder="e.g. assets/uploads/2026/07/lab-and-research.webp">
                    <label class="form-label small text-muted mb-1">OR Upload Facility Photo:</label>
                    <input type="file" name="image_file" class="form-control form-control-sm" accept="image/*">
                    <?php if (!empty($editItem['image_url'])): ?>
                        <div class="mt-2">
                            <img src="<?php echo htmlspecialchars(strpos($editItem['image_url'], 'http') === 0 ? $editItem['image_url'] : BASE_URL . $editItem['image_url']); ?>" alt="Current Facility" style="height: 60px; object-fit: cover; border-radius: 6px;" class="border">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="active" <?php echo (($editItem['status'] ?? 'active') === 'active') ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo (($editItem['status'] ?? '') === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>

                <button type="submit" name="save_facility" class="btn btn-danger btn-sm w-100 rounded-pill py-2 fw-bold">
                    <i class="fas fa-save me-1"></i> <?php echo $editItem ? 'Update Facility' : 'Save Facility'; ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: Facilities List -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold text-navy mb-3">Existing Campus Facilities (<?php echo count($facilities); ?>)</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 12%;">Media</th>
                            <th style="width: 45%;">Facility Details</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 23%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($facilities)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No facilities found. Add your first facility on the left.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($facilities as $idx => $fac): ?>
                                <tr>
                                    <td class="text-muted fw-bold"><?php echo $fac['sort_order'] ?: ($idx + 1); ?></td>
                                    <td>
                                        <?php if (!empty($fac['image_url'])): ?>
                                            <img src="<?php echo htmlspecialchars(strpos($fac['image_url'], 'http') === 0 ? $fac['image_url'] : BASE_URL . $fac['image_url']); ?>" alt="<?php echo htmlspecialchars($fac['title']); ?>" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px;" class="border">
                                        <?php else: ?>
                                            <div class="bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                <i class="fas <?php echo htmlspecialchars($fac['icon'] ?? 'fa-building'); ?>"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-navy">
                                            <i class="fas <?php echo htmlspecialchars($fac['icon'] ?? 'fa-building'); ?> text-danger me-1"></i>
                                            <?php echo htmlspecialchars($fac['title']); ?>
                                        </div>
                                        <small class="text-muted d-block text-truncate" style="max-width: 320px; font-size: 0.78rem;">
                                            <?php echo htmlspecialchars($fac['description']); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <a href="manage_facilities.php?action=toggle&id=<?php echo $fac['id']; ?>" class="badge rounded-pill text-decoration-none <?php echo $fac['status'] === 'active' ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo ucfirst($fac['status']); ?>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <a href="manage_facilities.php?action=edit&id=<?php echo $fac['id']; ?>#entry-form" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="manage_facilities.php?action=delete&id=<?php echo $fac['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 ms-1" onclick="return confirm('Are you sure you want to delete this facility?');" title="Delete">
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
