<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();
$error = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM exam_timetables WHERE id = :id");
        $stmt->execute([':id' => $delId]);
        setFlashMsg('success', 'Exam time table removed successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error removing time table: ' . $e->getMessage());
    }
    header("Location: manage_timetables.php");
    exit;
}

// Handle Status Toggle
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $toggleId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("UPDATE exam_timetables SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = :id");
        $stmt->execute([':id' => $toggleId]);
        setFlashMsg('success', 'Exam time table status updated successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error updating status: ' . $e->getMessage());
    }
    header("Location: manage_timetables.php");
    exit;
}

// Handle Add / Edit Form Submission
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['save_timetable'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $category = trim($_POST['category'] ?? 'Engineering & Polytechnic');
    $courseTitle = trim($_POST['course_title'] ?? '');
    $details = trim($_POST['details'] ?? '');
    $fileUrl = trim($_POST['file_url'] ?? '');
    $filename = trim($_POST['filename'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $status = in_array($_POST['status'] ?? '', ['active', 'inactive']) ? $_POST['status'] : 'active';

    // Handle PDF Upload
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['pdf'];
        $ext = strtolower(pathinfo($_FILES['pdf_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $uploadDir = __DIR__ . '/../assets/uploads/time-table/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($_FILES['pdf_file']['name'], PATHINFO_FILENAME));
            $fn = $cleanName . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $uploadDir . $fn)) {
                $fileUrl = 'assets/uploads/time-table/' . $fn;
                $filename = $fn;
            }
        }
    }

    if (empty($filename) && !empty($fileUrl)) {
        $filename = basename($fileUrl);
    }

    if (empty($courseTitle)) {
        $error = 'Please enter the Course / Program Title.';
    } else {
        try {
            if ($id > 0) {
                $stmt = $pdo->prepare("UPDATE exam_timetables SET category = :cat, course_title = :c, details = :d, file_url = :u, filename = :fn, sort_order = :so, status = :st WHERE id = :id");
                $stmt->execute([
                    ':cat' => $category,
                    ':c' => $courseTitle,
                    ':d' => $details,
                    ':u' => $fileUrl,
                    ':fn' => $filename,
                    ':so' => $sortOrder,
                    ':st' => $status,
                    ':id' => $id
                ]);
                setFlashMsg('success', 'Exam time table updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO exam_timetables (category, course_title, details, file_url, filename, sort_order, status) VALUES (:cat, :c, :d, :u, :fn, :so, :st)");
                $stmt->execute([
                    ':cat' => $category,
                    ':c' => $courseTitle,
                    ':d' => $details,
                    ':u' => $fileUrl,
                    ':fn' => $filename,
                    ':so' => $sortOrder,
                    ':st' => $status
                ]);
                setFlashMsg('success', 'New exam time table published successfully.');
            }
            header("Location: manage_timetables.php");
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
    $stmt = $pdo->prepare("SELECT * FROM exam_timetables WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    $editItem = $stmt->fetch();
}

// Filter and Search parameters
$selectedCat = $_GET['filter_cat'] ?? '';
$searchQuery = trim($_GET['q'] ?? '');

$sql = "SELECT * FROM exam_timetables WHERE 1=1";
$params = [];
if (!empty($selectedCat)) {
    $sql .= " AND category = :cat";
    $params[':cat'] = $selectedCat;
}
if (!empty($searchQuery)) {
    $sql .= " AND (course_title LIKE :q OR details LIKE :q)";
    $params[':q'] = '%' . $searchQuery . '%';
}
$sql .= " ORDER BY sort_order ASC, id DESC";

$timetables = [];
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $timetables = $stmt->fetchAll();
} catch (Exception $e) {
    $error = 'Unable to fetch timetables: ' . $e->getMessage();
}

$categoriesList = [
    'Engineering & Polytechnic',
    'Agriculture & Allied Sciences',
    'Management & Computer Application',
    'Nursing & Paramedical',
    'Medical, Dental & Ayush',
    'Law',
    'Pharmacy'
];

// Merge any other categories currently in database
try {
    $dbCats = $pdo->query("SELECT DISTINCT category FROM exam_timetables WHERE category IS NOT NULL AND category != ''")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($dbCats as $dc) {
        if (!in_array($dc, $categoriesList)) {
            $categoriesList[] = $dc;
        }
    }
} catch (Exception $e) {}
?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-calendar-alt text-danger me-2"></i> Examination Time Tables &amp; Date Sheets</h3>
        <p class="text-muted small mb-0">Publish, modify, and archive semester examination date sheets, schedules, and downloadable PDFs.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL; ?>exam-time-table.php" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-external-link-alt me-1"></i> Live Time Tables Page
        </a>
        <a href="manage_timetables.php#entry-form" class="btn btn-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-plus me-1"></i> Add Date Sheet
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
    <div class="col-12 col-lg-4" id="entry-form">
        <div class="card border-0 shadow-sm rounded-4 p-4 sticky-lg-top" style="top: 80px; z-index: 10;">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h5 class="fw-bold text-navy mb-0">
                    <i class="fas <?php echo $editItem ? 'fa-edit text-primary' : 'fa-plus-circle text-success'; ?> me-2"></i>
                    <?php echo $editItem ? 'Edit Date Sheet' : 'Add New Date Sheet'; ?>
                </h5>
                <?php if ($editItem): ?>
                    <a href="manage_timetables.php" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0">Cancel</a>
                <?php endif; ?>
            </div>

            <form action="manage_timetables.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $editItem['id'] ?? 0; ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Faculty / Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select form-select-sm" required>
                        <?php foreach ($categoriesList as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo (($editItem['category'] ?? '') === $cat) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Course / Program Title <span class="text-danger">*</span></label>
                    <input type="text" name="course_title" class="form-control form-control-sm" required
                           value="<?php echo htmlspecialchars($editItem['course_title'] ?? ''); ?>"
                           placeholder="e.g. B.Tech / B.E. (All Branches)">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Semester / Exam Details</label>
                    <textarea name="details" class="form-control form-control-sm" rows="2" placeholder="e.g. Regular & Ex Semester Examinations | EE, EEE, ME, CS"><?php echo htmlspecialchars($editItem['details'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">PDF Document URL / Path</label>
                    <input type="text" name="file_url" class="form-control form-control-sm mb-1"
                           value="<?php echo htmlspecialchars($editItem['file_url'] ?? ''); ?>"
                           placeholder="e.g. assets/uploads/timetables/btech-sem2.pdf or https://...">
                    <label class="form-label small text-muted mb-1">OR Upload New PDF File:</label>
                    <input type="file" name="pdf_file" class="form-control form-control-sm" accept=".pdf">
                    <?php if (!empty($editItem['file_url'])): ?>
                        <div class="mt-1">
                            <a href="<?php echo htmlspecialchars(strpos($editItem['file_url'], 'http') === 0 ? $editItem['file_url'] : BASE_URL . $editItem['file_url']); ?>" target="_blank" class="small text-danger">
                                <i class="fas fa-file-pdf me-1"></i> Current PDF Link (<?php echo htmlspecialchars($editItem['filename'] ?? ''); ?>)
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold small text-dark">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($editItem['sort_order'] ?? 0); ?>">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold small text-dark">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="active" <?php echo (($editItem['status'] ?? 'active') === 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo (($editItem['status'] ?? '') === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <button type="submit" name="save_timetable" class="btn btn-danger btn-sm w-100 rounded-pill py-2 fw-bold">
                    <i class="fas fa-save me-1"></i> <?php echo $editItem ? 'Update Date Sheet' : 'Save & Publish Date Sheet'; ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: Timetables List -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            
            <!-- Filters & Search Bar -->
            <form action="manage_timetables.php" method="GET" class="row g-2 mb-3">
                <div class="col-md-5">
                    <select name="filter_cat" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">-- All Categories (<?php echo count($timetables); ?>) --</option>
                        <?php foreach ($categoriesList as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo ($selectedCat === $cat) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Search course or semester..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-navy w-100 rounded-pill"><i class="fas fa-search"></i></button>
                    <?php if (!empty($selectedCat) || !empty($searchQuery)): ?>
                        <a href="manage_timetables.php" class="btn btn-sm btn-outline-secondary rounded-pill" title="Reset Filters"><i class="fas fa-times"></i></a>
                    <?php endif; ?>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 42%;">Course &amp; Details</th>
                            <th style="width: 25%;">Faculty / Category</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 18%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($timetables)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                                    No examination timetables found matching your search.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($timetables as $idx => $t): ?>
                                <tr>
                                    <td class="text-muted fw-bold"><?php echo $idx + 1; ?></td>
                                    <td>
                                        <div class="fw-bold text-navy"><?php echo htmlspecialchars($t['course_title'] ?? ''); ?></div>
                                        <small class="text-muted d-block" style="font-size: 0.78rem;">
                                            <?php echo htmlspecialchars($t['details'] ?? ''); ?>
                                        </small>
                                        <?php if (!empty($t['file_url'])): ?>
                                            <a href="<?php echo htmlspecialchars(strpos($t['file_url'], 'http') === 0 ? $t['file_url'] : BASE_URL . $t['file_url']); ?>" target="_blank" class="small text-danger fw-semibold" style="font-size: 0.75rem;">
                                                <i class="fas fa-file-pdf me-1"></i> View PDF (<?php echo htmlspecialchars($t['filename'] ?? ''); ?>)
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-navy border rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                            <?php echo htmlspecialchars($t['category']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="manage_timetables.php?action=toggle&id=<?php echo $t['id']; ?>" class="badge rounded-pill text-decoration-none <?php echo $t['status'] === 'active' ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo ucfirst($t['status']); ?>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <a href="manage_timetables.php?action=edit&id=<?php echo $t['id']; ?>#entry-form" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="manage_timetables.php?action=delete&id=<?php echo $t['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 ms-1" onclick="return confirm('Are you sure you want to delete this examination time table?');" title="Delete">
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
