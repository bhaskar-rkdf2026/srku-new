<?php
// Core Dependencies & Auth Check before any output
require_once __DIR__ . '/../includes/functions.php';
checkAdminLogin();

$pdo = getDBConnection();
$uploadDir = dirname(__DIR__) . '/assets/uploads/gallery/webp/';
if (!is_dir($uploadDir)) {
    @mkdir($uploadDir, 0777, true);
}

// Ensure gallery table and is_featured column exist in database
if ($pdo) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `gallery` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `title` varchar(255) NOT NULL,
            `category` varchar(100) DEFAULT 'Campus',
            `image_url` varchar(255) NOT NULL,
            `is_featured` tinyint(1) NOT NULL DEFAULT 0,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $pdo->exec("ALTER TABLE `gallery` ADD COLUMN IF NOT EXISTS `is_featured` tinyint(1) NOT NULL DEFAULT 0");
    } catch (Exception $e) {
        try {
            $pdo->exec("ALTER TABLE `gallery` ADD `is_featured` tinyint(1) NOT NULL DEFAULT 0");
        } catch (Exception $e2) {}
    }
}

$tab = sanitize($_GET['tab'] ?? 'all');

$categories = [
    'Campus'  => ['label' => 'Campus & Architecture', 'icon' => 'fa-university', 'badge' => 'bg-danger'],
    'Gym'     => ['label' => 'Gymnasium & Fitness', 'icon' => 'fa-dumbbell', 'badge' => 'bg-warning text-dark'],
    'Sports'  => ['label' => 'Sports Arena & Courts', 'icon' => 'fa-running', 'badge' => 'bg-success'],
    'Medical' => ['label' => 'Medical & Hospitals', 'icon' => 'fa-hospital-alt', 'badge' => 'bg-info text-dark']
];

// Handle POST actions BEFORE header rendering to avoid headers-already-sent / 500 error
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    try {
        // 1. Toggle Homepage Featured Status
        if ($action === 'toggle_featured' && $pdo) {
            $photoId = (int)($_POST['id'] ?? 0);
            if ($photoId > 0) {
                $stmt = $pdo->prepare("UPDATE gallery SET is_featured = CASE WHEN is_featured = 1 THEN 0 ELSE 1 END WHERE id = :id");
                $stmt->execute([':id' => $photoId]);
                
                $chk = $pdo->prepare("SELECT is_featured FROM gallery WHERE id = :id");
                $chk->execute([':id' => $photoId]);
                $newState = (int)$chk->fetchColumn();
                
                if ($newState === 1) {
                    setFlashMsg('success', 'Photo pinned to Homepage (Campus Life Section).');
                } else {
                    setFlashMsg('info', 'Photo removed from Homepage selection.');
                }
            }
            header("Location: manage_gallery.php?tab=" . urlencode($tab));
            exit;
        }

        // 2. Bulk Select Latest 10 Photos as Featured
        if ($action === 'bulk_featured_select_10' && $pdo) {
            $pdo->exec("UPDATE gallery SET is_featured = 0");
            $pdo->exec("UPDATE gallery SET is_featured = 1 ORDER BY id DESC LIMIT 10");
            setFlashMsg('success', 'Selected the latest 10 gallery photos for Homepage display.');
            header("Location: manage_gallery.php?tab=featured");
            exit;
        }

        // 3. Bulk Clear All Homepage Selections
        if ($action === 'bulk_featured_clear' && $pdo) {
            $pdo->exec("UPDATE gallery SET is_featured = 0");
            setFlashMsg('info', 'All homepage selections cleared. Homepage will automatically display the latest 10 gallery photos.');
            header("Location: manage_gallery.php?tab=" . urlencode($tab));
            exit;
        }

        // 4. Quick Category Move
        if ($action === 'change_category' && $pdo) {
            $photoId = (int)($_POST['id'] ?? 0);
            $newCat = sanitize($_POST['category'] ?? 'Campus');
            if ($photoId > 0) {
                $stmt = $pdo->prepare("UPDATE gallery SET category = :cat WHERE id = :id");
                $stmt->execute([':cat' => $newCat, ':id' => $photoId]);
                setFlashMsg('success', 'Photo category updated successfully.');
            }
            header("Location: manage_gallery.php?tab=" . urlencode($tab));
            exit;
        }

        // 5. Bulk Import from WebP Uploads Directory
        if ($action === 'sync_webp' && $pdo) {
            $files = is_dir($uploadDir) ? glob($uploadDir . '*.webp') : [];
            $added = 0;
            if (!empty($files)) {
                $checkStmt = $pdo->prepare("SELECT id FROM gallery WHERE image_url LIKE :url LIMIT 1");
                $insertStmt = $pdo->prepare("INSERT INTO gallery (title, category, image_url, is_featured) VALUES (:title, :cat, :url, 0)");
                foreach ($files as $f) {
                    $bn = basename($f);
                    $relUrl = 'assets/uploads/gallery/webp/' . $bn;
                    $checkStmt->execute([':url' => "%$bn%"]);
                    if (!$checkStmt->fetch()) {
                        $cat = 'Campus';
                        if (strpos($bn, 'gym') !== false || in_array($bn, ['dsc06520.webp','dsc06574.webp','dsc06575.webp','dsc06576.webp','dsc06577.webp','dsc06586.webp','dsc06587.webp','dsc06588.webp','dsc06600.webp','dsc06603.webp','dsc06605.webp','dsc06607.webp','dsc06609.webp','dsc06611.webp','dsc06612.webp','dsc06614.webp','dsc06615.webp','dsc06617.webp','dsc06618.webp','dsc06619.webp','dsc06622.webp','dsc06623.webp'])) {
                            $cat = 'Gym';
                        } elseif (strpos($bn, 'sport') !== false || in_array($bn, ['dsc06517.webp','dsc06525.webp','dsc06527.webp','dsc06528.webp','dsc06533.webp','dsc06534.webp','dsc06537.webp','dsc06538.webp','dsc06539.webp','dsc06540.webp','dsc06541.webp','dsc06542.webp','dsc06547.webp','dsc06548.webp','dsc06554.webp','dsc06578.webp','dsc06579.webp','dsc06580.webp','dsc06582.webp','dsc06583.webp'])) {
                            $cat = 'Sports';
                        } elseif (strpos($bn, 'med') !== false || strpos($bn, 'hosp') !== false || in_array($bn, ['dsc06740.webp','dsc06754.webp','dsc06767.webp','dsc06769.webp','dsc06772.webp','dsc06839.webp','dsc06842.webp','dsc06847.webp','dsc06857.webp'])) {
                            $cat = 'Medical';
                        }
                        $insertStmt->execute([
                            ':title' => 'SRKU Campus & Infrastructure Photo',
                            ':cat' => $cat,
                            ':url' => $relUrl
                        ]);
                        $added++;
                    }
                }
            }
            setFlashMsg('success', "Imported {$added} new photos into Gallery Database successfully.");
            header("Location: manage_gallery.php?tab=all");
            exit;
        }

        // 6. Add or Edit Photo
        if (($action === 'add' || $action === 'edit') && $pdo) {
            $id = (int)($_POST['id'] ?? 0);
            $title = trim(sanitize($_POST['title'] ?? 'SRKU Campus Photo'));
            $category = trim(sanitize($_POST['category'] ?? $tab));
            if ($category === 'all' || $category === 'featured') $category = 'Campus';
            $imageUrl = trim($_POST['image_url'] ?? '');
            $isFeatured = isset($_POST['is_featured']) ? 1 : 0;

            // Handle Image File Upload with WebP conversion
            if (isset($_FILES['gallery_file']) && $_FILES['gallery_file']['error'] === UPLOAD_ERR_OK) {
                $tmp = $_FILES['gallery_file']['tmp_name'];
                $origName = basename($_FILES['gallery_file']['name']);
                $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                $baseClean = 'gallery_' . time() . '_' . rand(100, 999);

                $destWebpName = $baseClean . '.webp';
                $destPath = $uploadDir . $destWebpName;

                $converted = false;
                if (extension_loaded('gd')) {
                    $img = null;
                    if ($ext === 'jpg' || $ext === 'jpeg') $img = @imagecreatefromjpeg($tmp);
                    elseif ($ext === 'png') $img = @imagecreatefrompng($tmp);
                    elseif ($ext === 'webp') $img = @imagecreatefromwebp($tmp);

                    if ($img) {
                        $origW = imagesx($img);
                        $origH = imagesy($img);
                        $maxDim = 1920;
                        if ($origW > $maxDim || $origH > $maxDim) {
                            if ($origW >= $origH) {
                                $newW = $maxDim;
                                $newH = (int)round(($origH / $origW) * $maxDim);
                            } else {
                                $newH = $maxDim;
                                $newW = (int)round(($origW / $origH) * $maxDim);
                            }
                        } else {
                            $newW = $origW;
                            $newH = $origH;
                        }
                        $target = imagecreatetruecolor($newW, $newH);
                        imagecopyresampled($target, $img, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
                        if (imagewebp($target, $destPath, 82)) {
                            $imageUrl = 'assets/uploads/gallery/webp/' . $destWebpName;
                            $converted = true;
                        }
                        imagedestroy($target);
                        imagedestroy($img);
                    }
                }

                if (!$converted) {
                    $destDirect = $uploadDir . $destWebpName;
                    if (move_uploaded_file($tmp, $destDirect)) {
                        $imageUrl = 'assets/uploads/gallery/webp/' . $destWebpName;
                    }
                }
            }

            if (empty($imageUrl)) {
                setFlashMsg('danger', 'Please select or upload an image.');
            } else {
                if ($action === 'add') {
                    $stmt = $pdo->prepare("INSERT INTO gallery (title, category, image_url, is_featured) VALUES (:title, :cat, :url, :feat)");
                    $stmt->execute([':title' => $title, ':cat' => $category, ':url' => $imageUrl, ':feat' => $isFeatured]);
                    setFlashMsg('success', "New photo added to '{$category}' successfully.");
                } elseif ($action === 'edit' && $id > 0) {
                    $stmt = $pdo->prepare("UPDATE gallery SET title = :title, category = :cat, image_url = :url, is_featured = :feat WHERE id = :id");
                    $stmt->execute([':title' => $title, ':cat' => $category, ':url' => $imageUrl, ':feat' => $isFeatured, ':id' => $id]);
                    setFlashMsg('success', 'Gallery photo updated successfully.');
                }
                header("Location: manage_gallery.php?tab=" . urlencode($tab));
                exit;
            }
        }
    } catch (Exception $e) {
        setFlashMsg('danger', 'Database Error: ' . $e->getMessage());
        header("Location: manage_gallery.php?tab=" . urlencode($tab));
        exit;
    }
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && $pdo) {
    try {
        $delId = (int)($_GET['id'] ?? 0);
        if ($delId > 0) {
            $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = :id");
            $stmt->execute([':id' => $delId]);
            setFlashMsg('success', 'Gallery photo deleted successfully.');
        }
    } catch (Exception $e) {
        setFlashMsg('danger', 'Delete Error: ' . $e->getMessage());
    }
    header("Location: manage_gallery.php?tab=" . urlencode($tab));
    exit;
}

// Auto-seed if gallery table has fewer than 10 photos
try {
    $currentDbCount = (int)($pdo ? $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn() : 0);
    if ($pdo && $currentDbCount < 10) {
        $files = is_dir($uploadDir) ? glob($uploadDir . '*.webp') : [];
        if (!empty($files)) {
            $checkStmt = $pdo->prepare("SELECT id FROM gallery WHERE image_url LIKE :url LIMIT 1");
            $insertStmt = $pdo->prepare("INSERT INTO gallery (title, category, image_url, is_featured) VALUES (:title, :cat, :url, 0)");
            foreach ($files as $f) {
                $bn = basename($f);
                $relUrl = 'assets/uploads/gallery/webp/' . $bn;
                $checkStmt->execute([':url' => "%$bn%"]);
                if (!$checkStmt->fetch()) {
                    $cat = 'Campus';
                    if (strpos($bn, 'gym') !== false || in_array($bn, ['dsc06520.webp','dsc06574.webp','dsc06575.webp','dsc06576.webp','dsc06577.webp','dsc06586.webp','dsc06587.webp','dsc06588.webp','dsc06600.webp','dsc06603.webp','dsc06605.webp','dsc06607.webp','dsc06609.webp','dsc06611.webp','dsc06612.webp','dsc06614.webp','dsc06615.webp','dsc06617.webp','dsc06618.webp','dsc06619.webp','dsc06622.webp','dsc06623.webp'])) {
                        $cat = 'Gym';
                    } elseif (strpos($bn, 'sport') !== false || in_array($bn, ['dsc06517.webp','dsc06525.webp','dsc06527.webp','dsc06528.webp','dsc06533.webp','dsc06534.webp','dsc06537.webp','dsc06538.webp','dsc06539.webp','dsc06540.webp','dsc06541.webp','dsc06542.webp','dsc06547.webp','dsc06548.webp','dsc06554.webp','dsc06578.webp','dsc06579.webp','dsc06580.webp','dsc06582.webp','dsc06583.webp'])) {
                        $cat = 'Sports';
                    } elseif (strpos($bn, 'med') !== false || strpos($bn, 'hosp') !== false || in_array($bn, ['dsc06740.webp','dsc06754.webp','dsc06767.webp','dsc06769.webp','dsc06772.webp','dsc06839.webp','dsc06842.webp','dsc06847.webp','dsc06857.webp'])) {
                        $cat = 'Medical';
                    }
                    $insertStmt->execute([
                        ':title' => 'SRKU Campus & Infrastructure Photo',
                        ':cat' => $cat,
                        ':url' => $relUrl
                    ]);
                }
            }
        }
    }
} catch (Exception $e) {}

// Dynamically discover all existing categories from the DB
try {
    if ($pdo) {
        $dbCatRows = $pdo->query("SELECT DISTINCT category FROM gallery WHERE category IS NOT NULL AND category != ''")->fetchAll(PDO::FETCH_COLUMN);
        foreach ($dbCatRows as $dCat) {
            $dCat = trim($dCat);
            if ($dCat && !isset($categories[$dCat])) {
                $categories[$dCat] = ['label' => ucfirst($dCat), 'icon' => 'fa-images', 'badge' => 'bg-secondary'];
            }
        }
    }
} catch (Exception $e) {}

// Fetch Category Counts & Featured Count
$counts = [];
$totalCount = 0;
$featuredCount = 0;
try {
    $totalCount = (int)($pdo ? $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn() : 0);
    $featuredCount = (int)($pdo ? $pdo->query("SELECT COUNT(*) FROM gallery WHERE is_featured = 1")->fetchColumn() : 0);
    foreach ($categories as $k => $c) {
        $stmt = $pdo ? $pdo->prepare("SELECT COUNT(*) FROM gallery WHERE LOWER(category) = LOWER(:cat)") : null;
        if ($stmt) {
            $stmt->execute([':cat' => $k]);
            $counts[$k] = (int)$stmt->fetchColumn();
        } else {
            $counts[$k] = 0;
        }
    }
} catch (Exception $e) {
    $totalCount = 0;
    $featuredCount = 0;
}
$counts['all'] = $totalCount;

// Query Photos for Active Tab
$searchQuery = sanitize($_GET['q'] ?? '');
$photos = [];

try {
    if ($pdo) {
        $sql = "SELECT * FROM gallery WHERE 1=1";
        $params = [];

        if ($tab === 'featured') {
            $sql .= " AND is_featured = 1";
        } elseif ($tab !== 'all' && isset($categories[$tab])) {
            $sql .= " AND LOWER(category) = LOWER(:cat)";
            $params[':cat'] = $tab;
        }
        if (!empty($searchQuery)) {
            $sql .= " AND (image_url LIKE :q OR title LIKE :q OR category LIKE :q)";
            $params[':q'] = "%{$searchQuery}%";
        }
        $sql .= " ORDER BY is_featured DESC, id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    $photos = [];
}

// Include Admin Header (HTML Output starts here)
require_once __DIR__ . '/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-images text-danger me-2"></i> Category-Wise Gallery Management</h3>
        <p class="text-muted small mb-0">Manage university facility photos and select which 10 images are featured on the <strong>Homepage Campus Life</strong> section.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <form action="manage_gallery.php?tab=<?php echo urlencode($tab); ?>" method="POST" class="d-inline" onsubmit="return confirm('Scan and sync all WebP photos from server uploads folder into database?');">
            <input type="hidden" name="action" value="sync_webp">
            <button type="submit" class="btn btn-sm btn-outline-success px-3 rounded-pill shadow-sm">
                <i class="fas fa-sync-alt me-1"></i> Sync Server Photos
            </button>
        </form>
        <a href="<?php echo BASE_URL; ?>#campus-life" target="_blank" class="btn btn-sm btn-outline-primary px-3 rounded-pill shadow-sm">
            <i class="fas fa-home me-1"></i> View Homepage Section
        </a>
        <a href="<?php echo BASE_URL; ?>gallery.php<?php echo ($tab !== 'all' && $tab !== 'featured') ? '?category=' . urlencode($tab) : ''; ?>" target="_blank" class="btn btn-sm btn-outline-danger px-3 rounded-pill shadow-sm">
            <i class="fas fa-external-link-alt me-1"></i> View Live Gallery
        </a>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     HOMEPAGE "CAMPUS LIFE" GALLERY SELECTION STATUS CALLOUT
     ══════════════════════════════════════════════════════════ -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 text-white" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-left: 5px solid #eab308 !important;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-warning text-dark rounded-circle p-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                <i class="fas fa-star fs-5"></i>
            </div>
            <div>
                <h6 class="fw-bold text-white mb-1">
                    Homepage "Campus Life" Gallery (10 Images Grid)
                </h6>
                <p class="small text-white-50 mb-0">
                    <?php if ($featuredCount > 0): ?>
                        Currently showing <strong class="text-warning"><?php echo min($featuredCount, 10); ?> custom selected photo(s)</strong> on the Homepage.
                        <?php if ($featuredCount > 10): ?>
                            <span class="badge bg-warning text-dark ms-1">Note: Latest 10 of <?php echo $featuredCount; ?> selected will show.</span>
                        <?php endif; ?>
                    <?php else: ?>
                        No photos explicitly pinned. Homepage is automatically displaying the <strong class="text-info">Latest 10 Gallery Photos</strong>.
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <form action="manage_gallery.php?tab=<?php echo urlencode($tab); ?>" method="POST" onsubmit="return confirm('Pin the latest 10 gallery photos to the homepage?');">
                <input type="hidden" name="action" value="bulk_featured_select_10">
                <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold px-3 rounded-pill">
                    <i class="fas fa-check-double me-1"></i> Select Latest 10 for Home
                </button>
            </form>
            <?php if ($featuredCount > 0): ?>
                <form action="manage_gallery.php?tab=<?php echo urlencode($tab); ?>" method="POST" onsubmit="return confirm('Clear all homepage photo selections and return to auto latest 10?');">
                    <input type="hidden" name="action" value="bulk_featured_clear">
                    <button type="submit" class="btn btn-sm btn-outline-light px-3 rounded-pill">
                        <i class="fas fa-undo me-1"></i> Reset to Auto
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Category Tabs Header -->
<div class="card border-0 shadow-sm rounded-4 p-2 mb-4 bg-white">
    <div class="srku-filter-row">
        <a href="manage_gallery.php?tab=all" class="srku-filter-btn <?php echo $tab === 'all' ? 'active' : ''; ?>">
            <i class="fas fa-th-large"></i> All Photos
            <span class="badge <?php echo $tab === 'all' ? 'bg-white text-danger' : 'bg-secondary-subtle text-dark'; ?> rounded-pill ms-1"><?php echo $counts['all']; ?></span>
        </a>
        
        <!-- Homepage Featured Filter Tab -->
        <a href="manage_gallery.php?tab=featured" class="srku-filter-btn <?php echo $tab === 'featured' ? 'active' : ''; ?>" style="<?php echo $tab === 'featured' ? 'background: #ca8a04; color: #fff;' : ''; ?>">
            <i class="fas fa-star text-warning"></i> ⭐ Homepage Selected (<?php echo min($featuredCount, 10); ?>/10)
            <span class="badge <?php echo $tab === 'featured' ? 'bg-white text-dark' : 'bg-warning text-dark'; ?> rounded-pill ms-1"><?php echo $featuredCount; ?></span>
        </a>

        <?php foreach ($categories as $catKey => $catInfo): ?>
            <a href="manage_gallery.php?tab=<?php echo $catKey; ?>" class="srku-filter-btn <?php echo $tab === $catKey ? 'active' : ''; ?>">
                <i class="fas <?php echo $catInfo['icon']; ?>"></i> <?php echo $catInfo['label']; ?>
                <span class="badge <?php echo $tab === $catKey ? 'bg-white text-danger' : 'bg-secondary-subtle text-dark'; ?> rounded-pill ms-1"><?php echo $counts[$catKey] ?? 0; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Simple Add Photo Form -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 80px;">
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                <h5 class="fw-bold text-navy mb-0">
                    <i class="fas fa-plus-circle text-danger me-2"></i> Upload / Add Photo
                </h5>
                <?php if ($tab !== 'all' && $tab !== 'featured' && isset($categories[$tab])): ?>
                    <span class="badge bg-danger-subtle text-danger small"><?php echo $categories[$tab]['label']; ?></span>
                <?php endif; ?>
            </div>

            <form action="manage_gallery.php?tab=<?php echo urlencode($tab); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark mb-1">Target Category Tab</label>
                    <select name="category" class="form-select form-select-sm" required>
                        <?php foreach ($categories as $catKey => $catData): ?>
                            <option value="<?php echo $catKey; ?>" <?php echo ($tab === $catKey) ? 'selected' : ''; ?>>
                                <?php echo $catData['label']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark mb-1">Select Image File (Auto-WebP Compression)</label>
                    <input type="file" name="gallery_file" class="form-control form-control-sm" accept="image/*">
                    <small class="text-muted" style="font-size: 0.73rem;">Photos are automatically compressed to high-performance WebP.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark mb-1">OR Choose from Site Media Gallery</label>
                    <input type="text" name="image_url" class="form-control form-control-sm media-picker-input" 
                           placeholder="assets/uploads/gallery/webp/dsc06520.webp">
                </div>

                <!-- Featured on Homepage Toggle -->
                <div class="form-check form-switch p-3 bg-light rounded-3 border mb-3">
                    <input class="form-check-input ms-0 me-2" type="checkbox" name="is_featured" value="1" id="isFeaturedCheck" <?php echo ($tab === 'featured') ? 'checked' : ''; ?>>
                    <label class="form-check-label small fw-bold text-navy" for="isFeaturedCheck">
                        <i class="fas fa-star text-warning me-1"></i> Feature on Homepage (Campus Life)
                    </label>
                    <small class="d-block text-muted" style="font-size: 0.72rem;">Show this photo in the 10-image Campus Life grid on the home page.</small>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm w-100">
                        <i class="fas fa-upload me-1"></i> Add Photo to Gallery
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Photos Grid for Selected Tab -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            
            <!-- Category Tab Title & Search -->
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold text-navy mb-0">
                        <i class="fas <?php echo ($tab === 'featured') ? 'fa-star text-warning' : (($tab !== 'all' && isset($categories[$tab])) ? $categories[$tab]['icon'] : 'fa-th-large text-danger'); ?> me-2"></i>
                        <?php 
                        if ($tab === 'featured') {
                            echo 'Photos Selected for Homepage (Campus Life)';
                        } elseif ($tab !== 'all' && isset($categories[$tab])) {
                            echo $categories[$tab]['label'];
                        } else {
                            echo 'All Photos in Gallery';
                        }
                        ?>
                        <span class="badge bg-danger-subtle text-danger fs-6 rounded-pill ms-2"><?php echo count($photos); ?> Photos</span>
                    </h5>
                </div>
                <div>
                    <form action="manage_gallery.php" method="GET" class="d-flex gap-1">
                        <input type="hidden" name="tab" value="<?php echo sanitize($tab); ?>">
                        <div class="input-group input-group-sm" style="max-width: 220px;">
                            <input type="text" name="q" class="form-control" placeholder="Search filename..." value="<?php echo sanitize($searchQuery); ?>">
                            <button class="btn btn-dark" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                        <?php if (!empty($searchQuery)): ?>
                            <a href="manage_gallery.php?tab=<?php echo urlencode($tab); ?>" class="btn btn-sm btn-outline-secondary" title="Reset"><i class="fas fa-undo"></i></a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- Photos Cards Grid -->
            <?php if (empty($photos)): ?>
                <div class="text-center py-5 text-muted bg-light rounded-4 my-3">
                    <i class="fas fa-images fa-3x mb-3 text-secondary"></i>
                    <h6 class="fw-bold text-navy">
                        <?php echo ($tab === 'featured') ? 'No photos currently pinned to homepage.' : 'No photos found in this category.'; ?>
                    </h6>
                    <p class="small mb-0">
                        <?php if ($tab === 'featured'): ?>
                            Click <strong>"Pin to Homepage"</strong> on any photo below, or click <strong>"Select Latest 10 for Home"</strong>.
                        <?php else: ?>
                            Upload a new photo using the form on the left or click "Sync Server Photos".
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-3 g-3">
                    <?php foreach ($photos as $i => $row): 
                        $imgSrc = $row['image_url'] ?? ($row['image'] ?? ($row['file_path'] ?? ($row['img'] ?? ($row['photo'] ?? ''))));
                        $resolved = resolveMediaUrl($imgSrc, 'assets/uploads/2026/07/001.webp');
                        $currentCat = trim($row['category'] ?? 'Campus') ?: 'Campus';
                        $catMeta = $categories[$currentCat] ?? ['label' => ucfirst($currentCat), 'badge' => 'bg-secondary text-white'];
                        $isFeat = (int)($row['is_featured'] ?? 0);
                    ?>
                        <div class="col">
                            <div class="card h-100 border rounded-4 shadow-sm overflow-hidden bg-white <?php echo $isFeat ? 'border-warning shadow' : ''; ?>" style="<?php echo $isFeat ? 'border-width: 2px !important;' : ''; ?>">
                                
                                <div class="position-relative" style="height: 180px; background: #0f172a;">
                                    <img src="<?php echo $resolved; ?>" alt="Gallery Image" class="w-100 h-100 object-fit-cover" loading="lazy" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/campus-1.webp';">
                                    
                                    <!-- Category Badge -->
                                    <span class="position-absolute top-0 start-0 m-2 badge <?php echo $catMeta['badge']; ?> small shadow-sm">
                                        <?php echo $catMeta['label']; ?>
                                    </span>

                                    <!-- Featured on Homepage Gold Star Badge -->
                                    <?php if ($isFeat): ?>
                                        <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark shadow-sm fw-bold">
                                            <i class="fas fa-star text-danger me-1"></i> On Homepage
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="p-3 bg-white d-flex flex-column gap-2">
                                    
                                    <!-- 1-Click Toggle for Homepage Feature -->
                                    <form action="manage_gallery.php?tab=<?php echo urlencode($tab); ?>" method="POST">
                                        <input type="hidden" name="action" value="toggle_featured">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <?php if ($isFeat): ?>
                                            <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold w-100 py-1 shadow-xs" title="Click to remove from Homepage">
                                                <i class="fas fa-check-circle text-success me-1"></i> Featured on Home <small class="fw-normal text-muted">(Click to remove)</small>
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100 py-1" title="Click to display this photo in Homepage Campus Life">
                                                <i class="far fa-star text-warning me-1"></i> Pin to Homepage
                                            </button>
                                        <?php endif; ?>
                                    </form>

                                    <!-- Quick Change Category Dropdown -->
                                    <form action="manage_gallery.php?tab=<?php echo urlencode($tab); ?>" method="POST" class="mb-0">
                                        <input type="hidden" name="action" value="change_category">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <select name="category" class="form-select form-select-sm" style="font-size: 0.78rem;" onchange="this.form.submit()" title="Move to another category tab">
                                            <?php foreach ($categories as $ck => $cv): ?>
                                                <option value="<?php echo $ck; ?>" <?php echo (strcasecmp($currentCat, $ck) === 0) ? 'selected' : ''; ?>>
                                                    Move to: <?php echo $cv['label']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>

                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-auto">
                                        <a href="<?php echo $resolved; ?>" target="_blank" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 0.75rem;" title="View Fullsize">
                                            <i class="fas fa-expand-alt me-1"></i> Preview
                                        </a>
                                        <a href="manage_gallery.php?tab=<?php echo urlencode($tab); ?>&action=delete&id=<?php echo $row['id']; ?>" class="btn btn-xs btn-outline-danger px-2 py-1" style="font-size: 0.75rem;" onclick="return confirm('Delete this image from gallery?')" title="Delete">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
