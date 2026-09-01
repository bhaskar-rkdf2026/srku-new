<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

$stats = getSyllabusQuickStats();

// -------------------------------------------------------------
// POST HANDLERS: ADD / EDIT / TOGGLE STATUS
// -------------------------------------------------------------

// Toggle Status (AJAX or GET)
if (isset($_GET['action']) && $_GET['action'] === 'toggle_status' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("UPDATE syllabi SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'Document status updated successfully.');
    header("Location: manage_syllabus.php" . (isset($_GET['cat']) ? '?cat=' . urlencode($_GET['cat']) : ''));
    exit;
}

// Delete Document
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT file_path, title FROM syllabi WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $doc = $stmt->fetch();

    if ($doc) {
        $delStmt = $pdo->prepare("DELETE FROM syllabi WHERE id = :id");
        $delStmt->execute([':id' => $id]);
        setFlashMsg('success', 'Document "' . htmlspecialchars($doc['title']) . '" deleted successfully.');
    } else {
        setFlashMsg('danger', 'Document not found.');
    }
    header("Location: manage_syllabus.php" . (isset($_GET['cat']) ? '?cat=' . urlencode($_GET['cat']) : ''));
    exit;
}

// Save (Add / Update)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['save_syllabus'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = sanitize($_POST['title'] ?? '');
    $categorySlug = sanitize($_POST['category_slug'] ?? '');
    $categoryTitle = sanitize($_POST['category_title'] ?? '');
    $type = sanitize($_POST['type'] ?? 'Syllabus');
    $status = sanitize($_POST['status'] ?? 'active');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $existingFilePath = sanitize($_POST['existing_file_path'] ?? '');

    // Map known category titles if empty
    if (empty($categoryTitle)) {
        $meta = getSyllabusCategoryMeta($categorySlug);
        $categoryTitle = ucwords(str_replace('-', ' ', $categorySlug));
    }
    if (empty($categorySlug)) {
        $categorySlug = generateSlug($categoryTitle);
    }

    $uploadedPath = $existingFilePath;
    $uploadedFilename = basename($existingFilePath);
    $fileSize = 0;

    // Handle PDF File Upload
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['pdf_file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($ext !== 'pdf') {
            setFlashMsg('danger', 'Only official PDF documents (.pdf) are allowed.');
            header("Location: manage_syllabus.php");
            exit;
        }

        $cleanOrigName = preg_replace('/[^A-Za-z0-9._-]/', '_', $file['name']);
        $uploadSubdir = 'assets/pdf/syllabus/' . $categorySlug;
        $targetDir = dirname(__DIR__) . '/' . $uploadSubdir;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . '/' . $cleanOrigName;
        // Avoid overwriting if different file
        if (file_exists($targetFile)) {
            $nameWithoutExt = pathinfo($cleanOrigName, PATHINFO_FILENAME);
            $cleanOrigName = $nameWithoutExt . '_' . time() . '.pdf';
            $targetFile = $targetDir . '/' . $cleanOrigName;
        }

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $uploadedPath = $uploadSubdir . '/' . $cleanOrigName;
            $uploadedFilename = $cleanOrigName;
            $fileSize = filesize($targetFile);

            // Keep junction or uploads directory in sync
            $altTarget = dirname(__DIR__) . '/assets/uploads/syllabus/' . $categorySlug . '/' . $cleanOrigName;
            if (!file_exists($altTarget)) {
                @copy($targetFile, $altTarget);
            }
        } else {
            setFlashMsg('danger', 'Failed to upload PDF file to server.');
            header("Location: manage_syllabus.php");
            exit;
        }
    } elseif (empty($uploadedPath)) {
        setFlashMsg('danger', 'Please upload a PDF file or provide a valid PDF file path.');
        header("Location: manage_syllabus.php");
        exit;
    }

    // Measure existing file size if not set
    if ($fileSize === 0 && !empty($uploadedPath)) {
        $fullPath = dirname(__DIR__) . '/' . ltrim($uploadedPath, '/');
        if (file_exists($fullPath)) {
            $fileSize = filesize($fullPath);
        }
    }

    $meta = getSyllabusCategoryMeta($categorySlug);
    $department = $meta['dept'] ?? 'Academic Studies';

    if ($id > 0) {
        $stmt = $pdo->prepare("
            UPDATE syllabi 
            SET title = :title, category_slug = :cslug, category_title = :ctitle, department = :dept, 
                type = :type, file_path = :fpath, filename = :fname, file_size = :fsize, status = :status, 
                sort_order = :sorder 
            WHERE id = :id
        ");
        $stmt->execute([
            ':title' => $title,
            ':cslug' => $categorySlug,
            ':ctitle' => $categoryTitle,
            ':dept' => $department,
            ':type' => $type,
            ':fpath' => $uploadedPath,
            ':fname' => $uploadedFilename,
            ':fsize' => $fileSize,
            ':status' => $status,
            ':sorder' => $sortOrder,
            ':id' => $id
        ]);
        setFlashMsg('success', 'Syllabus/Scheme document "' . htmlspecialchars($title) . '" updated successfully.');
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO syllabi (category_slug, category_title, department, title, type, file_path, filename, file_size, status, sort_order) 
            VALUES (:cslug, :ctitle, :dept, :title, :type, :fpath, :fname, :fsize, :status, :sorder)
        ");
        $stmt->execute([
            ':cslug' => $categorySlug,
            ':ctitle' => $categoryTitle,
            ':dept' => $department,
            ':title' => $title,
            ':type' => $type,
            ':fpath' => $uploadedPath,
            ':fname' => $uploadedFilename,
            ':fsize' => $fileSize,
            ':status' => $status,
            ':sorder' => $sortOrder
        ]);
        setFlashMsg('success', 'New document "' . htmlspecialchars($title) . '" added successfully.');
    }

    header("Location: manage_syllabus.php?cat=" . urlencode($categorySlug));
    exit;
}

// -------------------------------------------------------------
// FILTERING & DATA FETCHING
// -------------------------------------------------------------

// Fetch distinct categories for filter dropdown
$distinctCats = $pdo->query("
    SELECT category_slug, category_title, COUNT(*) as count, 
           SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_count
    FROM syllabi 
    GROUP BY category_slug, category_title 
    ORDER BY category_title ASC
")->fetchAll();

$filterCat = isset($_GET['cat']) ? trim($_GET['cat']) : '';
$filterType = isset($_GET['type']) ? trim($_GET['type']) : '';
$filterStatus = isset($_GET['status']) ? trim($_GET['status']) : '';
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

$whereClauses = [];
$queryParams = [];

if (!empty($filterCat)) {
    $whereClauses[] = "category_slug = :cat";
    $queryParams[':cat'] = $filterCat;
}
if (!empty($filterType)) {
    $whereClauses[] = "type = :type";
    $queryParams[':type'] = $filterType;
}
if (!empty($filterStatus)) {
    $whereClauses[] = "status = :status";
    $queryParams[':status'] = $filterStatus;
}
if (!empty($searchQuery)) {
    $whereClauses[] = "(title LIKE :q OR filename LIKE :q OR category_title LIKE :q)";
    $queryParams[':q'] = '%' . $searchQuery . '%';
}

$whereSql = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";
$stmt = $pdo->prepare("SELECT * FROM syllabi $whereSql ORDER BY category_title ASC, sort_order ASC, id ASC");
$stmt->execute($queryParams);
$documents = $stmt->fetchAll();
?>

<!-- Page Header & Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-lg-8">
        <div class="d-flex align-items-center gap-3">
            <div class="p-3 bg-danger-subtle text-danger rounded-4">
                <i class="fas fa-file-pdf fa-2x"></i>
            </div>
            <div>
                <h3 class="h4 fw-bold text-navy mb-1">Manage Syllabus &amp; Schemes of Examination</h3>
                <p class="text-secondary small mb-0">Add, edit, upload, or remove academic curriculum and semester scheme PDFs across all 19 constituent disciplines.</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4 text-lg-end d-flex align-items-center justify-content-lg-end gap-2 flex-wrap">
        <button type="button" class="btn btn-danger btn-sm rounded-3 px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#addSyllabusModal">
            <i class="fas fa-plus-circle me-1"></i> Add New Syllabus / Scheme
        </button>
        <a href="<?php echo BASE_URL; ?>syllabus" target="_blank" class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-2 fw-semibold" title="Preview Public Page">
            <i class="fas fa-external-link-alt me-1"></i> View Live Portal
        </a>
    </div>
</div>

<!-- Stats Counter Badges -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-danger">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Total Documents</span>
                    <h3 class="h4 fw-bold text-navy mb-0 mt-1"><?php echo number_format($stats['total']); ?></h3>
                </div>
                <div class="rounded-circle bg-danger-subtle text-danger p-3">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-success">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Active on Portal</span>
                    <h3 class="h4 fw-bold text-success mb-0 mt-1"><?php echo number_format($stats['active']); ?></h3>
                </div>
                <div class="rounded-circle bg-success-subtle text-success p-3">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-primary">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Exam Schemes</span>
                    <h3 class="h4 fw-bold text-primary mb-0 mt-1"><?php echo number_format($stats['schemes']); ?></h3>
                </div>
                <div class="rounded-circle bg-primary-subtle text-primary p-3">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-4 border-warning">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold text-uppercase">Disciplines / Branches</span>
                    <h3 class="h4 fw-bold text-navy mb-0 mt-1"><?php echo number_format($stats['categories']); ?></h3>
                </div>
                <div class="rounded-circle bg-warning-subtle text-warning p-3">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters & Search Toolbar -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="manage_syllabus.php" class="row g-2 align-items-center">
        <!-- Search -->
        <div class="col-12 col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-search"></i></span>
                <input type="text" name="q" class="form-control bg-light border-start-0" placeholder="Search by title, filename, branch..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            </div>
        </div>
        <!-- Discipline Filter -->
        <div class="col-6 col-md-3">
            <select name="cat" class="form-select" onchange="this.form.submit()">
                <option value="">All Disciplines (<?php echo count($distinctCats); ?>)</option>
                <?php foreach ($distinctCats as $c): ?>
                    <option value="<?php echo $c['category_slug']; ?>" <?php echo ($filterCat === $c['category_slug']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($c['category_title']); ?> (<?php echo $c['count']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Type Filter -->
        <div class="col-6 col-md-2">
            <select name="type" class="form-select" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="Syllabus" <?php echo ($filterType === 'Syllabus') ? 'selected' : ''; ?>>Syllabus</option>
                <option value="Scheme" <?php echo ($filterType === 'Scheme') ? 'selected' : ''; ?>>Scheme</option>
                <option value="Scheme &amp; Syllabus" <?php echo ($filterType === 'Scheme & Syllabus') ? 'selected' : ''; ?>>Scheme &amp; Syllabus</option>
            </select>
        </div>
        <!-- Status Filter -->
        <div class="col-6 col-md-2">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="active" <?php echo ($filterStatus === 'active') ? 'selected' : ''; ?>>Active Only</option>
                <option value="inactive" <?php echo ($filterStatus === 'inactive') ? 'selected' : ''; ?>>Inactive Only</option>
            </select>
        </div>
        <!-- Buttons -->
        <div class="col-6 col-md-1 d-flex gap-1">
            <button type="submit" class="btn btn-dark w-100" title="Apply Filters"><i class="fas fa-filter"></i></button>
            <?php if (!empty($filterCat) || !empty($filterType) || !empty($filterStatus) || !empty($searchQuery)): ?>
                <a href="manage_syllabus.php" class="btn btn-outline-secondary" title="Reset All"><i class="fas fa-redo-alt"></i></a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Documents List Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="h6 fw-bold text-navy mb-0">
            <i class="fas fa-table text-danger me-2"></i> Documents (<?php echo count($documents); ?>)
            <?php if (!empty($filterCat)): ?>
                <span class="badge bg-danger-subtle text-danger ms-2"><?php echo htmlspecialchars($filterCat); ?></span>
            <?php endif; ?>
        </h5>
        <span class="text-muted small">Showing records matching your criteria</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="syllabusTable">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="width: 170px;">Discipline / Branch</th>
                    <th>Document Title</th>
                    <th style="width: 130px;">Type</th>
                    <th style="width: 100px;">File Status</th>
                    <th style="width: 90px;">Visibility</th>
                    <th style="width: 140px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($documents)): ?>
                    <?php foreach ($documents as $idx => $doc): 
                        $docHref = BASE_URL . ltrim($doc['file_path'], '/');
                        $decodedDiskPath = dirname(__DIR__) . '/' . ltrim(urldecode($doc['file_path']), '/');
                        $rawDiskPath = dirname(__DIR__) . '/' . ltrim($doc['file_path'], '/');
                        $fileExists = file_exists($decodedDiskPath) || file_exists($rawDiskPath);
                        $typeBadge = 'bg-danger-subtle text-danger';
                        if (strtolower($doc['type']) === 'scheme') {
                            $typeBadge = 'bg-primary-subtle text-primary';
                        } elseif (stripos($doc['type'], '&') !== false) {
                            $typeBadge = 'bg-success-subtle text-success';
                        }
                    ?>
                        <tr>
                            <td class="text-muted small font-monospace"><?php echo $doc['id']; ?></td>
                            <td>
                                <span class="badge bg-light text-navy border px-2 py-1 small fw-semibold text-truncate d-inline-block" style="max-width: 160px;" title="<?php echo htmlspecialchars($doc['category_title']); ?>">
                                    <?php echo htmlspecialchars($doc['category_title']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-navy" style="font-size: 0.93rem;">
                                    <?php echo htmlspecialchars($doc['title']); ?>
                                </div>
                                <div class="small text-muted font-monospace text-truncate" style="max-width: 320px;" title="<?php echo htmlspecialchars($doc['filename']); ?>">
                                    <i class="far fa-file-pdf text-danger me-1"></i> <?php echo htmlspecialchars($doc['filename']); ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge <?php echo $typeBadge; ?> rounded-pill px-2 py-1 small">
                                    <?php echo htmlspecialchars($doc['type']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($fileExists): ?>
                                    <span class="badge bg-success-subtle text-success small" title="PDF verified on disk">
                                        <i class="fas fa-check-circle me-1"></i> On Disk
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger small" title="PDF file missing from server path">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Missing
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="manage_syllabus.php?action=toggle_status&id=<?php echo $doc['id']; ?><?php echo !empty($filterCat) ? '&cat=' . urlencode($filterCat) : ''; ?>" 
                                   class="badge <?php echo ($doc['status'] === 'active') ? 'bg-success text-white' : 'bg-secondary text-white'; ?> text-decoration-none px-2 py-1 small" 
                                   title="Click to toggle visibility">
                                    <?php echo ucfirst($doc['status']); ?>
                                </a>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <!-- View PDF -->
                                    <a href="<?php echo $docHref; ?>" target="_blank" class="btn btn-outline-secondary" title="View Document">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- Edit Document -->
                                    <button type="button" class="btn btn-outline-primary edit-syllabus-btn" 
                                            data-id="<?php echo $doc['id']; ?>"
                                            data-title="<?php echo htmlspecialchars($doc['title'], ENT_QUOTES); ?>"
                                            data-cslug="<?php echo htmlspecialchars($doc['category_slug'], ENT_QUOTES); ?>"
                                            data-ctitle="<?php echo htmlspecialchars($doc['category_title'], ENT_QUOTES); ?>"
                                            data-type="<?php echo htmlspecialchars($doc['type'], ENT_QUOTES); ?>"
                                            data-path="<?php echo htmlspecialchars($doc['file_path'], ENT_QUOTES); ?>"
                                            data-status="<?php echo htmlspecialchars($doc['status'], ENT_QUOTES); ?>"
                                            data-order="<?php echo (int)$doc['sort_order']; ?>"
                                            title="Edit Document">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Delete Document -->
                                    <a href="manage_syllabus.php?action=delete&id=<?php echo $doc['id']; ?><?php echo !empty($filterCat) ? '&cat=' . urlencode($filterCat) : ''; ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('Are you sure you want to permanently delete: <?php echo addslashes($doc['title']); ?>?');" 
                                       title="Delete Document">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 text-secondary opacity-50"></i>
                            <h5 class="fw-bold">No Syllabus Documents Found</h5>
                            <p class="small mb-3">No files matched your selected search or filter criteria.</p>
                            <a href="manage_syllabus.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                <i class="fas fa-redo-alt me-1"></i> Clear Filters
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================================= -->
<!-- ADD / EDIT SYLLABUS MODAL -->
<!-- ============================================================= -->
<div class="modal fade" id="addSyllabusModal" tabindex="-1" aria-labelledby="addSyllabusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form method="POST" action="manage_syllabus.php" enctype="multipart/form-data" id="syllabusForm">
                <input type="hidden" name="save_syllabus" value="1">
                <input type="hidden" name="id" id="form_doc_id" value="0">
                <input type="hidden" name="existing_file_path" id="form_existing_file_path" value="">

                <div class="modal-header bg-navy text-white py-3 px-4">
                    <h5 class="modal-title h6 fw-bold" id="addSyllabusModalLabel">
                        <i class="fas fa-file-pdf text-danger me-2"></i> <span id="modalHeaderTitle">Add New Syllabus / Scheme Document</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Discipline / Category Select -->
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-navy">Academic Discipline / Category <span class="text-danger">*</span></label>
                            <select name="category_slug" id="form_category_slug" class="form-select" required onchange="handleCategoryChange(this)">
                                <option value="">-- Choose Discipline --</option>
                                <?php foreach ($distinctCats as $c): ?>
                                    <option value="<?php echo $c['category_slug']; ?>" data-title="<?php echo htmlspecialchars($c['category_title']); ?>">
                                        <?php echo htmlspecialchars($c['category_title']); ?>
                                    </option>
                                <?php endforeach; ?>
                                <option value="custom">+ Add Custom Discipline</option>
                            </select>
                        </div>

                        <!-- Custom Discipline Name (Conditional) -->
                        <div class="col-12 col-md-6" id="customCatDiv" style="display: none;">
                            <label class="form-label small fw-bold text-navy">New Discipline Title <span class="text-danger">*</span></label>
                            <input type="text" name="category_title" id="form_category_title" class="form-control" placeholder="e.g. Master of Data Science">
                        </div>

                        <!-- Document Type -->
                        <div class="col-12 col-md-6" id="docTypeDiv">
                            <label class="form-label small fw-bold text-navy">Document Type <span class="text-danger">*</span></label>
                            <select name="type" id="form_type" class="form-select" required>
                                <option value="Syllabus">Syllabus</option>
                                <option value="Scheme">Scheme of Examination</option>
                                <option value="Scheme &amp; Syllabus">Scheme &amp; Syllabus</option>
                            </select>
                        </div>

                        <!-- Document Title -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-navy">Document Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="form_title" class="form-control" placeholder="e.g. B.Tech Computer Science V Semester Scheme &amp; Syllabus" required>
                            <span class="form-text small text-muted">A clear, descriptive title displayed to students on the public syllabus portal.</span>
                        </div>

                        <!-- PDF Upload Option -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-navy">Upload PDF File <span class="text-danger" id="fileRequiredStar">*</span></label>
                            <input type="file" name="pdf_file" id="form_pdf_file" class="form-control" accept=".pdf,application/pdf">
                            <div id="currentFileNotice" class="mt-2 text-muted small font-monospace d-none">
                                <i class="fas fa-link text-primary me-1"></i> Current file: <span id="currentFilePathDisplay"></span>
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-navy">Visibility Status</label>
                            <select name="status" id="form_status" class="form-select">
                                <option value="active">Active (Visible on Website)</option>
                                <option value="inactive">Inactive (Draft / Hidden)</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-navy">Display Sort Order</label>
                            <input type="number" name="sort_order" id="form_sort_order" class="form-control" value="0" min="0">
                            <span class="form-text small text-muted">Lower number appears first within the discipline.</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light px-4 py-3 border-top">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold">
                        <i class="fas fa-save me-1"></i> <span id="submitBtnText">Save Document</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Page Script for Edit Modal & Dynamic Behavior -->
<script>
function handleCategoryChange(select) {
    const customDiv = document.getElementById('customCatDiv');
    const docTypeDiv = document.getElementById('docTypeDiv');
    const titleInput = document.getElementById('form_category_title');
    
    if (select.value === 'custom') {
        customDiv.style.display = 'block';
        titleInput.required = true;
        titleInput.value = '';
    } else {
        customDiv.style.display = 'none';
        titleInput.required = false;
        const selectedOption = select.options[select.selectedIndex];
        titleInput.value = selectedOption.getAttribute('data-title') || '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle Edit Button Click
    const editButtons = document.querySelectorAll('.edit-syllabus-btn');
    const modal = new bootstrap.Modal(document.getElementById('addSyllabusModal'));

    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('form_doc_id').value = this.dataset.id;
            document.getElementById('form_title').value = this.dataset.title;
            document.getElementById('form_type').value = this.dataset.type;
            document.getElementById('form_existing_file_path').value = this.dataset.path;
            document.getElementById('form_status').value = this.dataset.status;
            document.getElementById('form_sort_order').value = this.dataset.order;

            // Set Category
            const catSelect = document.getElementById('form_category_slug');
            catSelect.value = this.dataset.cslug;
            document.getElementById('form_category_title').value = this.dataset.ctitle;
            handleCategoryChange(catSelect);

            // Notice current file
            const fileNotice = document.getElementById('currentFileNotice');
            const fileDisplay = document.getElementById('currentFilePathDisplay');
            if (this.dataset.path) {
                fileNotice.classList.remove('d-none');
                fileDisplay.textContent = this.dataset.path;
                document.getElementById('fileRequiredStar').classList.add('d-none');
                document.getElementById('form_pdf_file').required = false;
            }

            // Modal Header & Button text
            document.getElementById('modalHeaderTitle').textContent = 'Edit Syllabus / Scheme Document (ID #' + this.dataset.id + ')';
            document.getElementById('submitBtnText').textContent = 'Update Document';

            modal.show();
        });
    });

    // Reset modal on add click
    const addModal = document.getElementById('addSyllabusModal');
    addModal.addEventListener('hidden.bs.modal', function () {
        document.getElementById('syllabusForm').reset();
        document.getElementById('form_doc_id').value = '0';
        document.getElementById('form_existing_file_path').value = '';
        document.getElementById('currentFileNotice').classList.add('d-none');
        document.getElementById('fileRequiredStar').classList.remove('d-none');
        document.getElementById('modalHeaderTitle').textContent = 'Add New Syllabus / Scheme Document';
        document.getElementById('submitBtnText').textContent = 'Save Document';
        document.getElementById('customCatDiv').style.display = 'none';
    });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
