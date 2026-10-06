<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// -------------------------------------------------------------
// POST / GET ACTION HANDLERS
// -------------------------------------------------------------

// 1. Toggle Status
if (isset($_GET['action']) && $_GET['action'] === 'toggle_status' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("UPDATE documents SET status = CASE WHEN status = 'published' THEN 'draft' ELSE 'published' END, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'Document status updated successfully.');
    header("Location: manage_documents.php" . (isset($_GET['cat']) ? '?cat=' . urlencode($_GET['cat']) : ''));
    exit;
}

// 2. Delete Document
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT title FROM documents WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $doc = $stmt->fetch();

    if ($doc) {
        $delStmt = $pdo->prepare("DELETE FROM documents WHERE id = :id");
        $delStmt->execute([':id' => $id]);
        setFlashMsg('success', 'Document "' . htmlspecialchars($doc['title']) . '" deleted successfully.');
    } else {
        setFlashMsg('danger', 'Document not found.');
    }
    header("Location: manage_documents.php" . (isset($_GET['cat']) ? '?cat=' . urlencode($_GET['cat']) : ''));
    exit;
}

// 3. Save Document (Add / Edit)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['save_document'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = sanitize($_POST['title'] ?? '');
    $slug = sanitize($_POST['slug'] ?? '');
    $category = sanitize($_POST['category'] ?? 'General');
    $subtitle = sanitize($_POST['subtitle'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $status = sanitize($_POST['status'] ?? 'published');
    $displayOrder = (int)($_POST['display_order'] ?? 0);
    $existingPdfPath = sanitize($_POST['existing_pdf_path'] ?? '');

    if (empty($slug)) {
        $slug = generateSlug($title);
    } else {
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9_-]/', '-', $slug), '-'));
    }

    $finalPdfPath = $existingPdfPath;

    // Handle PDF File Upload
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['pdf_file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($ext !== 'pdf') {
            setFlashMsg('danger', 'Only official PDF documents (.pdf) are allowed.');
            header("Location: manage_documents.php");
            exit;
        }

        $cleanOrigName = preg_replace('/[^A-Za-z0-9._-]/', '_', $file['name']);
        $uploadSubdir = 'assets/uploads/pdf';
        $targetDir = dirname(__DIR__) . '/' . $uploadSubdir;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . '/' . $cleanOrigName;
        if (file_exists($targetFile)) {
            $nameWithoutExt = pathinfo($cleanOrigName, PATHINFO_FILENAME);
            $cleanOrigName = $nameWithoutExt . '_' . time() . '.pdf';
            $targetFile = $targetDir . '/' . $cleanOrigName;
        }

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $finalPdfPath = $uploadSubdir . '/' . $cleanOrigName;
        }
    } elseif (!empty($_POST['custom_pdf_path'])) {
        $finalPdfPath = sanitize($_POST['custom_pdf_path']);
    }

    // Process Highlights (textarea lines -> JSON array)
    $rawHighlights = $_POST['highlights'] ?? '';
    $highlightsArr = [];
    if (!empty($rawHighlights)) {
        $lines = explode("\n", str_replace("\r", "", $rawHighlights));
        foreach ($lines as $line) {
            $t = trim($line);
            if (!empty($t)) {
                $highlightsArr[] = $t;
            }
        }
    }
    $highlightsJson = json_encode($highlightsArr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    if (empty($title) || empty($finalPdfPath)) {
        setFlashMsg('danger', 'Document Title and PDF Path are required.');
        header("Location: manage_documents.php");
        exit;
    }

    try {
        if ($id > 0) {
            // Update
            $updateStmt = $pdo->prepare("UPDATE documents SET 
                title = :title, 
                slug = :slug, 
                category = :category, 
                subtitle = :subtitle, 
                pdf_path = :pdf_path, 
                description = :description, 
                highlights = :highlights, 
                status = :status, 
                display_order = :display_order,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = :id");
            $updateStmt->execute([
                ':title' => $title,
                ':slug' => $slug,
                ':category' => $category,
                ':subtitle' => $subtitle,
                ':pdf_path' => $finalPdfPath,
                ':description' => $description,
                ':highlights' => $highlightsJson,
                ':status' => $status,
                ':display_order' => $displayOrder,
                ':id' => $id
            ]);
            setFlashMsg('success', 'Document "' . htmlspecialchars($title) . '" updated successfully!');
        } else {
            // Insert
            $insertStmt = $pdo->prepare("INSERT INTO documents 
                (title, slug, category, subtitle, pdf_path, description, highlights, status, display_order) 
                VALUES (:title, :slug, :category, :subtitle, :pdf_path, :description, :highlights, :status, :display_order)");
            $insertStmt->execute([
                ':title' => $title,
                ':slug' => $slug,
                ':category' => $category,
                ':subtitle' => $subtitle,
                ':pdf_path' => $finalPdfPath,
                ':description' => $description,
                ':highlights' => $highlightsJson,
                ':status' => $status,
                ':display_order' => $displayOrder
            ]);
            setFlashMsg('success', 'New statutory document "' . htmlspecialchars($title) . '" added successfully!');
        }
    } catch (PDOException $e) {
        if (stripos($e->getMessage(), 'UNIQUE') !== false || stripos($e->getMessage(), 'Duplicate') !== false) {
            setFlashMsg('danger', 'Error: A document with slug "' . htmlspecialchars($slug) . '" already exists. Please choose a unique slug.');
        } else {
            setFlashMsg('danger', 'Database Error: ' . htmlspecialchars($e->getMessage()));
        }
    }

    header("Location: manage_documents.php" . (!empty($category) ? '?cat=' . urlencode($category) : ''));
    exit;
}

// -------------------------------------------------------------
// FETCH DATA FOR LISTING & FILTERS
// -------------------------------------------------------------
$selectedCat = sanitize($_GET['cat'] ?? '');
$searchQuery = sanitize($_GET['q'] ?? '');

// Categories
$categories = $pdo->query("SELECT DISTINCT category, COUNT(*) as count FROM documents GROUP BY category ORDER BY category ASC")->fetchAll(PDO::FETCH_ASSOC);

// Total counts
$totalDocs = (int)$pdo->query("SELECT COUNT(*) FROM documents")->fetchColumn();
$publishedDocs = (int)$pdo->query("SELECT COUNT(*) FROM documents WHERE status = 'published'")->fetchColumn();
$draftDocs = (int)$pdo->query("SELECT COUNT(*) FROM documents WHERE status = 'draft'")->fetchColumn();
$totalCats = count($categories);

// Main Query
$sql = "SELECT * FROM documents WHERE 1=1";
$params = [];

if (!empty($selectedCat)) {
    $sql .= " AND category = :cat";
    $params[':cat'] = $selectedCat;
}

if (!empty($searchQuery)) {
    $sql .= " AND (title LIKE :q OR slug LIKE :q OR subtitle LIKE :q OR description LIKE :q)";
    $params[':q'] = '%' . $searchQuery . '%';
}

$sql .= " ORDER BY display_order ASC, id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-file-pdf text-danger me-2"></i> Statutory Documents Manager</h3>
        <p class="text-muted small mb-0">Manage all 81+ official PDF document viewers (<code>/document/&lt;slug&gt;</code>), circulars, statutory policies &amp; compliance records.</p>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-primary fw-bold px-3 shadow-sm rounded-pill d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#documentModal" onclick="openAddModal()">
            <i class="fas fa-plus-circle"></i> <span>Add New Document</span>
        </button>
        <a href="<?php echo BASE_URL; ?>document/board-of-management" target="_blank" class="btn btn-outline-secondary px-3 rounded-pill d-inline-flex align-items-center gap-2">
            <i class="fas fa-external-link-alt"></i> <span>Live Viewer</span>
        </a>
    </div>
</div>

<!-- STATS COUNTER CARDS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-3 bg-white border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Total Documents</div>
                    <div class="h3 fw-bold text-navy mb-0"><?php echo $totalDocs; ?></div>
                </div>
                <div class="bg-primary-subtle text-primary p-3 rounded-circle"><i class="fas fa-file-pdf fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-3 bg-white border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Published</div>
                    <div class="h3 fw-bold text-success mb-0"><?php echo $publishedDocs; ?></div>
                </div>
                <div class="bg-success-subtle text-success p-3 rounded-circle"><i class="fas fa-check-circle fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-3 bg-white border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Categories</div>
                    <div class="h3 fw-bold text-warning mb-0"><?php echo $totalCats; ?></div>
                </div>
                <div class="bg-warning-subtle text-warning p-3 rounded-circle"><i class="fas fa-folder fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-3 bg-white border-start border-4 border-secondary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Drafts / Inactive</div>
                    <div class="h3 fw-bold text-secondary mb-0"><?php echo $draftDocs; ?></div>
                </div>
                <div class="bg-light text-secondary p-3 rounded-circle"><i class="fas fa-edit fa-lg"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- CATEGORY FILTER PILLS & SEARCH BAR -->
<div class="card border-0 shadow-sm rounded-3 p-3 bg-white mb-4">
    <div class="row g-3 align-items-center">
        <!-- Search Input -->
        <div class="col-12 col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" id="docSearchInput" class="form-control bg-light border-start-0" placeholder="Filter by title, slug, keywords..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                <?php if (!empty($searchQuery)): ?>
                    <a href="manage_documents.php<?php echo !empty($selectedCat) ? '?cat=' . urlencode($selectedCat) : ''; ?>" class="btn btn-light"><i class="fas fa-times"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Category Dropdown / Quick Links -->
        <div class="col-12 col-md-8">
            <div class="d-flex flex-wrap gap-2 justify-content-md-end align-items-center">
                <span class="small text-muted fw-bold me-1">Category:</span>
                <a href="manage_documents.php" class="btn btn-sm rounded-pill <?php echo empty($selectedCat) ? 'btn-navy text-white fw-bold' : 'btn-outline-secondary'; ?>">
                    All (<?php echo $totalDocs; ?>)
                </a>
                <?php foreach ($categories as $catItem): ?>
                    <a href="manage_documents.php?cat=<?php echo urlencode($catItem['category']); ?>" class="btn btn-sm rounded-pill <?php echo $selectedCat === $catItem['category'] ? 'btn-danger text-white fw-bold' : 'btn-outline-secondary'; ?>">
                        <?php echo htmlspecialchars($catItem['category']); ?> (<?php echo $catItem['count']; ?>)
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- DOCUMENTS TABLE LIST -->
<div class="card border-0 shadow-sm rounded-3 bg-white overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="documentsTable">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th>Document Title &amp; Details</th>
                    <th>Category</th>
                    <th>PDF File Link</th>
                    <th class="text-center" style="width: 110px;">Status</th>
                    <th class="text-end" style="width: 170px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($documents)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 text-secondary opacity-50"></i>
                            <p class="mb-0">No documents found matching the filter criteria.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php 
                    $index = 1;
                    foreach ($documents as $item): 
                        $hlArr = [];
                        if (!empty($item['highlights'])) {
                            $decoded = json_decode($item['highlights'], true);
                            if (is_array($decoded)) {
                                $hlArr = $decoded;
                            }
                        }
                        $hlText = implode("\n", $hlArr);
                    ?>
                        <tr class="doc-row" 
                            data-title="<?php echo htmlspecialchars(strtolower($item['title'])); ?>" 
                            data-slug="<?php echo htmlspecialchars(strtolower($item['slug'])); ?>" 
                            data-cat="<?php echo htmlspecialchars(strtolower($item['category'])); ?>" 
                            data-desc="<?php echo htmlspecialchars(strtolower($item['description'] ?? '')); ?>">
                            
                            <td class="text-center text-muted small fw-semibold">
                                <?php echo $item['display_order'] ?: $index; ?>
                            </td>

                            <td>
                                <div class="fw-bold text-navy d-flex align-items-center gap-2">
                                    <span><?php echo htmlspecialchars($item['title']); ?></span>
                                </div>
                                <?php if (!empty($item['subtitle'])): ?>
                                    <div class="text-muted small text-truncate" style="max-width: 420px; font-size: 0.82rem;">
                                        <?php echo htmlspecialchars($item['subtitle']); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="mt-1 d-flex align-items-center gap-2">
                                    <code class="text-secondary small" style="font-size: 0.75rem;">/document/<?php echo htmlspecialchars($item['slug']); ?></code>
                                    <?php if (!empty($hlArr)): ?>
                                        <span class="badge bg-light text-secondary border small" style="font-size: 0.7rem;">
                                            <i class="fas fa-list-ul me-1"></i> <?php echo count($hlArr); ?> highlights
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1 rounded-pill small">
                                    <?php echo htmlspecialchars($item['category']); ?>
                                </span>
                            </td>

                            <td>
                                <a href="<?php echo BASE_URL . $item['pdf_path']; ?>" target="_blank" class="text-decoration-none small text-danger fw-semibold d-inline-flex align-items-center gap-1">
                                    <i class="fas fa-file-pdf"></i>
                                    <span class="text-truncate" style="max-width: 180px;"><?php echo basename($item['pdf_path']); ?></span>
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="manage_documents.php?action=toggle_status&id=<?php echo $item['id']; ?><?php echo !empty($selectedCat) ? '&cat=' . urlencode($selectedCat) : ''; ?>" 
                                   class="text-decoration-none" 
                                   title="Click to toggle status">
                                    <?php if ($item['status'] === 'published'): ?>
                                        <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold">Published</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-pill fw-semibold">Draft</span>
                                    <?php endif; ?>
                                </a>
                            </td>

                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo BASE_URL; ?>document/<?php echo $item['slug']; ?>" target="_blank" class="btn btn-outline-secondary" title="View Live Page">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-primary" title="Edit Document" 
                                            onclick='openEditModal(<?php echo json_encode($item, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>, <?php echo json_encode($hlText); ?>)'>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="manage_documents.php?action=delete&id=<?php echo $item['id']; ?><?php echo !empty($selectedCat) ? '&cat=' . urlencode($selectedCat) : ''; ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('Are you sure you want to delete \'<?php echo addslashes($item['title']); ?>\'?');" 
                                       title="Delete Document">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php 
                    $index++;
                    endforeach; 
                    ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ======================================================== -->
<!-- ADD / EDIT DOCUMENT MODAL -->
<!-- ======================================================== -->
<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="manage_documents.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="save_document" value="1">
                <input type="hidden" name="id" id="docId" value="0">
                <input type="hidden" name="existing_pdf_path" id="docExistingPdfPath" value="">

                <div class="modal-header bg-navy text-white rounded-top-4 py-3 px-4">
                    <h5 class="modal-title fw-bold" id="documentModalLabel">
                        <i class="fas fa-file-pdf text-danger me-2"></i> <span id="modalActionText">Add New Document</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Title -->
                        <div class="col-md-8">
                            <label class="form-label text-dark fw-bold small mb-1">Document Title *</label>
                            <input type="text" name="title" id="docTitle" class="form-control" placeholder="e.g. Board of Management" required onkeyup="syncSlug(this.value)">
                        </div>

                        <!-- Slug -->
                        <div class="col-md-4">
                            <label class="form-label text-dark fw-bold small mb-1">URL Slug *</label>
                            <input type="text" name="slug" id="docSlug" class="form-control" placeholder="board-of-management" required>
                            <div class="form-text small" style="font-size:0.75rem;">URL: <code>/document/&lt;slug&gt;</code></div>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-bold small mb-1">Category *</label>
                            <input type="text" name="category" id="docCategory" class="form-control" list="categoryOptions" placeholder="Select or type category" required>
                            <datalist id="categoryOptions">
                                <?php foreach ($categories as $catItem): ?>
                                    <option value="<?php echo htmlspecialchars($catItem['category']); ?>">
                                <?php endforeach; ?>
                                <option value="About H.E.I.">
                                <option value="Mandatory Disclosures">
                                <option value="All Committee">
                                <option value="Anti-Ragging">
                                <option value="Statutory Approvals">
                                <option value="Academic Documents">
                            </datalist>
                        </div>

                        <!-- Display Order & Status -->
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-bold small mb-1">Display Order</label>
                            <input type="number" name="display_order" id="docOrder" class="form-control" value="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-bold small mb-1">Status</label>
                            <select name="status" id="docStatus" class="form-select">
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>

                        <!-- Subtitle -->
                        <div class="col-12">
                            <label class="form-label text-dark fw-bold small mb-1">Document Subtitle / Banner Tagline</label>
                            <input type="text" name="subtitle" id="docSubtitle" class="form-control" placeholder="e.g. Statutory Governing & Executive Body of the University">
                        </div>

                        <!-- PDF Upload & Path -->
                        <div class="col-12">
                            <div class="p-3 bg-light rounded-3 border">
                                <label class="form-label text-navy fw-bold small mb-1">
                                    <i class="fas fa-file-pdf text-danger me-1"></i> Official PDF Document
                                </label>
                                
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Upload New PDF File:</label>
                                        <input type="file" name="pdf_file" class="form-control form-control-sm" accept="application/pdf">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">OR Enter Existing Path / URL:</label>
                                        <input type="text" name="custom_pdf_path" id="docCustomPdfPath" class="form-control form-control-sm" placeholder="assets/uploads/pdf/document.pdf">
                                    </div>
                                </div>
                                <div id="currentPdfIndicator" class="mt-2 small text-muted d-none">
                                    Current File: <span id="currentPdfText" class="text-danger fw-semibold"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label text-dark fw-bold small mb-1">Document Description &amp; Overview</label>
                            <textarea name="description" id="docDesc" class="form-control" rows="3" placeholder="Official description shown in the header callout banner..."></textarea>
                        </div>

                        <!-- Highlights -->
                        <div class="col-12">
                            <label class="form-label text-dark fw-bold small mb-1">
                                <i class="fas fa-list-check text-success me-1"></i> Key Highlights (One per line)
                            </label>
                            <textarea name="highlights" id="docHighlights" class="form-control" rows="4" placeholder="Highlight 1&#10;Highlight 2&#10;Highlight 3"></textarea>
                            <div class="form-text small" style="font-size:0.75rem;">Enter key bullets to appear in the "Key Document Highlights" section. Each new line will become a bullet point.</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light px-4 py-3 rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger fw-bold px-4 rounded-pill shadow-sm">
                        <i class="fas fa-save me-1"></i> Save Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Live Search Filtering
document.getElementById('docSearchInput')?.addEventListener('keyup', function() {
    const val = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll('.doc-row');
    rows.forEach(row => {
        const title = row.getAttribute('data-title') || '';
        const slug = row.getAttribute('data-slug') || '';
        const cat = row.getAttribute('data-cat') || '';
        const desc = row.getAttribute('data-desc') || '';
        if (title.includes(val) || slug.includes(val) || cat.includes(val) || desc.includes(val)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function syncSlug(title) {
    const slugInput = document.getElementById('docSlug');
    const docId = document.getElementById('docId').value;
    if (docId === '0' || !slugInput.dataset.manualEdit) {
        slugInput.value = title.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
}

document.getElementById('docSlug')?.addEventListener('input', function() {
    this.dataset.manualEdit = 'true';
});

function openAddModal() {
    document.getElementById('modalActionText').textContent = 'Add New Document';
    document.getElementById('docId').value = '0';
    document.getElementById('docExistingPdfPath').value = '';
    document.getElementById('docTitle').value = '';
    document.getElementById('docSlug').value = '';
    document.getElementById('docSlug').dataset.manualEdit = '';
    document.getElementById('docCategory').value = '<?php echo addslashes($selectedCat ?: "General"); ?>';
    document.getElementById('docSubtitle').value = '';
    document.getElementById('docCustomPdfPath').value = '';
    document.getElementById('docDesc').value = '';
    document.getElementById('docHighlights').value = '';
    document.getElementById('docOrder').value = '<?php echo $totalDocs + 1; ?>';
    document.getElementById('docStatus').value = 'published';
    document.getElementById('currentPdfIndicator').classList.add('d-none');
}

function openEditModal(doc, highlightsText) {
    document.getElementById('modalActionText').textContent = 'Edit Document: ' + doc.title;
    document.getElementById('docId').value = doc.id;
    document.getElementById('docExistingPdfPath').value = doc.pdf_path || '';
    document.getElementById('docTitle').value = doc.title || '';
    document.getElementById('docSlug').value = doc.slug || '';
    document.getElementById('docSlug').dataset.manualEdit = 'true';
    document.getElementById('docCategory').value = doc.category || 'General';
    document.getElementById('docSubtitle').value = doc.subtitle || '';
    document.getElementById('docCustomPdfPath').value = doc.pdf_path || '';
    document.getElementById('docDesc').value = doc.description || '';
    document.getElementById('docHighlights').value = highlightsText || '';
    document.getElementById('docOrder').value = doc.display_order || 0;
    document.getElementById('docStatus').value = doc.status || 'published';

    if (doc.pdf_path) {
        document.getElementById('currentPdfIndicator').classList.remove('d-none');
        document.getElementById('currentPdfText').textContent = doc.pdf_path;
    } else {
        document.getElementById('currentPdfIndicator').classList.add('d-none');
    }

    const modal = new bootstrap.Modal(document.getElementById('documentModal'));
    modal.show();
}
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
