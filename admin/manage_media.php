<?php
require_once __DIR__ . '/header.php';

$uploadDir = __DIR__ . '/../assets/uploads/';
$currentYear = date('Y');
$currentMonth = date('m');
$targetSubdir = "assets/uploads/{$currentYear}/{$currentMonth}/";
$targetFullDir = __DIR__ . '/../' . $targetSubdir;

if (!is_dir($targetFullDir)) {
    mkdir($targetFullDir, 0777, true);
}

// Handle File Upload
$uploadedFileInfo = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media_file'])) {
    $file = $_FILES['media_file'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $origName = basename($file['name']);
        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'pdf', 'mp4', 'doc', 'docx'];

        if (in_array($ext, $allowedExts)) {
            // Clean filename
            $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($origName, PATHINFO_FILENAME));
            $finalName = time() . '_' . $cleanName . '.' . $ext;
            $destPath = $targetFullDir . $finalName;

            if (move_uploaded_file($file['tmp_name'], $destPath)) {
                $relUrl = $targetSubdir . $finalName;
                $fullUrl = BASE_URL . $relUrl;
                setFlashMsg('success', "File uploaded successfully!");
                $uploadedFileInfo = [
                    'filename' => $finalName,
                    'relative_url' => $relUrl,
                    'full_url' => $fullUrl,
                    'ext' => $ext
                ];
            } else {
                setFlashMsg('danger', "Failed to move uploaded file.");
            }
        } else {
            setFlashMsg('danger', "Invalid file type. Allowed: " . implode(', ', $allowedExts));
        }
    } else {
        setFlashMsg('danger', "File upload error code: " . $file['error']);
    }
    header("Location: manage_media.php?uploaded=1");
    exit;
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['file'])) {
    $fileToDelete = sanitize($_GET['file']);
    $fullPath = realpath(__DIR__ . '/../' . $fileToDelete);
    $baseUploadDir = realpath(__DIR__ . '/../assets/uploads/');

    // Security check: ensure path is within assets/uploads/
    if ($fullPath && strpos($fullPath, $baseUploadDir) === 0 && file_exists($fullPath)) {
        unlink($fullPath);
        setFlashMsg('success', "File deleted successfully.");
    } else {
        setFlashMsg('danger', "Invalid file path or file does not exist.");
    }
    header("Location: manage_media.php");
    exit;
}

// Scan all uploads recursively
function scanAllUploads($dir, $baseDir) {
    $results = [];
    if (!is_dir($dir)) return $results;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            $results = array_merge($results, scanAllUploads($path, $baseDir));
        } else {
            $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
            $relPath = str_replace('\\', '/', substr($path, strlen($baseDir)));
            $relPath = ltrim($relPath, '/');
            $results[] = [
                'name' => $item,
                'path' => $relPath,
                'full_url' => BASE_URL . $relPath,
                'size' => filesize($path),
                'mtime' => filemtime($path),
                'ext' => $ext
            ];
        }
    }
    return $results;
}

$allFiles = scanAllUploads(realpath(__DIR__ . '/../assets/uploads/'), realpath(__DIR__ . '/../'));
// Sort by newest first
usort($allFiles, function($a, $b) {
    return $b['mtime'] - $a['mtime'];
});

$searchTerm = sanitize($_GET['q'] ?? '');
if ($searchTerm) {
    $allFiles = array_filter($allFiles, function($f) use ($searchTerm) {
        return stripos($f['name'], $searchTerm) !== false || stripos($f['path'], $searchTerm) !== false;
    });
}
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-photo-video text-danger me-2"></i> Media Library &amp; Image Uploader</h3>
        <p class="text-muted small mb-0">Upload images, banners, and documents. Instantly copy their public URLs to use in pages, banners, or headers.</p>
    </div>
    <div class="badge bg-navy px-3 py-2 fs-6">
        Total Files: <?php echo count($allFiles); ?>
    </div>
</div>

<!-- SECTION 1: Direct File Upload Box -->
<div class="admin-form-section">
    <div class="admin-form-section-title">
        <i class="fas fa-cloud-upload-alt text-danger"></i> Section 1: Upload New Image / Media Asset
    </div>
    <form action="manage_media.php" method="POST" enctype="multipart/form-data" class="row g-3 align-items-center">
        <div class="col-12 col-md-8">
            <div class="input-group">
                <input type="file" name="media_file" class="form-control py-2" accept=".jpg,.jpeg,.png,.webp,.svg,.gif,.pdf,.mp4" required>
                <button type="submit" class="btn btn-danger px-4 fw-bold">
                    <i class="fas fa-upload me-1"></i> Upload File
                </button>
            </div>
            <small class="text-muted mt-1 d-block">
                Supported formats: <strong>WebP, JPG, PNG, SVG, GIF, PDF, MP4</strong> (Max size: 25MB). Auto-saved to <code>assets/uploads/<?php echo $currentYear; ?>/<?php echo $currentMonth; ?>/</code>.
            </small>
        </div>
        <div class="col-12 col-md-4">
            <div class="p-3 bg-light rounded-3 border text-center">
                <i class="fas fa-link text-primary me-1"></i> Full public URL will be generated instantly after upload.
            </div>
        </div>
    </form>
</div>

<!-- SECTION 2: Media Search & Filter -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="manage_media.php" class="row g-2 align-items-center">
        <div class="col-12 col-md-8">
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="q" value="<?php echo sanitize($searchTerm); ?>" class="form-control" placeholder="Search media files by name or folder...">
            </div>
        </div>
        <div class="col-12 col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-bold flex-grow-1"><i class="fas fa-search me-1"></i> Search Media</button>
            <?php if ($searchTerm): ?>
                <a href="manage_media.php" class="btn btn-outline-secondary"><i class="fas fa-redo"></i> Reset</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- SECTION 3: Uploaded Files Gallery & URL Copy Grid -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-navy mb-0">All Uploaded Media Assets</h5>
        <small class="text-muted">Click <strong>Copy URL</strong> to instantly use the image anywhere.</small>
    </div>

    <?php if (!empty($allFiles)): ?>
        <div class="row g-3">
            <?php foreach ($allFiles as $idx => $f): 
                $isImg = in_array($f['ext'], ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                $formattedSize = round($f['size'] / 1024, 1) . ' KB';
                if ($f['size'] > 1024 * 1024) {
                    $formattedSize = round($f['size'] / (1024 * 1024), 2) . ' MB';
                }
            ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 border rounded-3 p-2 bg-light shadow-sm position-relative">
                        <!-- Thumbnail Preview -->
                        <div class="d-flex align-items-center justify-content-center bg-white rounded-2 mb-2 overflow-hidden border" style="height: 140px;">
                            <?php if ($isImg): ?>
                                <img src="<?php echo BASE_URL . $f['path']; ?>" alt="<?php echo sanitize($f['name']); ?>" style="max-height:100%; max-width:100%; object-fit:contain;" loading="lazy">
                            <?php elseif ($f['ext'] === 'pdf'): ?>
                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                            <?php elseif ($f['ext'] === 'mp4'): ?>
                                <i class="fas fa-file-video fa-4x text-primary"></i>
                            <?php else: ?>
                                <i class="fas fa-file-alt fa-4x text-secondary"></i>
                            <?php endif; ?>
                        </div>

                        <!-- Info -->
                        <div class="px-1 mb-2">
                            <strong class="d-block text-truncate small text-navy" title="<?php echo sanitize($f['name']); ?>"><?php echo sanitize($f['name']); ?></strong>
                            <div class="d-flex justify-content-between text-muted" style="font-size:0.75rem;">
                                <span><?php echo strtoupper($f['ext']); ?> • <?php echo $formattedSize; ?></span>
                                <span><?php echo date('M d, Y', $f['mtime']); ?></span>
                            </div>
                        </div>

                        <!-- URL Box & Copy -->
                        <div class="mb-2">
                            <label class="text-muted" style="font-size:0.7rem; font-weight:700;">PUBLIC URL:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="urlInput<?php echo $idx; ?>" class="form-control form-control-sm text-truncate bg-white" value="<?php echo $f['full_url']; ?>" readonly style="font-size:0.75rem;">
                                <button class="btn btn-outline-primary btn-sm" type="button" onclick="copyMediaUrl('urlInput<?php echo $idx; ?>', this)" title="Copy Full URL">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="text-muted" style="font-size:0.7rem; font-weight:700;">RELATIVE PATH:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="relInput<?php echo $idx; ?>" class="form-control form-control-sm text-truncate bg-white" value="<?php echo $f['path']; ?>" readonly style="font-size:0.75rem;">
                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="copyMediaUrl('relInput<?php echo $idx; ?>', this)" title="Copy Relative Path">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-auto">
                            <a href="<?php echo BASE_URL . $f['path']; ?>" target="_blank" class="btn btn-xs btn-outline-info text-decoration-none" style="font-size:0.75rem; padding: 2px 8px;">
                                <i class="fas fa-external-link-alt me-1"></i> Preview
                            </a>
                            <a href="manage_media.php?action=delete&file=<?php echo urlencode($f['path']); ?>" onclick="return confirm('Permanently delete <?php echo sanitize($f['name']); ?>?');" class="btn btn-xs btn-outline-danger" style="font-size:0.75rem; padding: 2px 8px;">
                                <i class="fas fa-trash me-1"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center text-muted py-5">
            <i class="fas fa-images fa-3x opacity-50 mb-3 d-block"></i>
            <p>No media files found matching your search.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Copy to Clipboard Toast Script -->
<script>
function copyMediaUrl(inputId, btn) {
    const input = document.getElementById(inputId);
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        const origHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check text-success"></i> Copied!';
        btn.classList.add('btn-success', 'text-white');
        setTimeout(() => {
            btn.innerHTML = origHtml;
            btn.classList.remove('btn-success', 'text-white');
        }, 2000);
    });
}
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
