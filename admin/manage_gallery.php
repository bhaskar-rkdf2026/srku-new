<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

$uploadDir = __DIR__ . '/../assets/uploads/gallery/webp/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Active Management Tab
$tab = sanitize($_GET['tab'] ?? 'Campus');

$categories = [
    'Campus'  => ['label' => 'Campus & Architecture', 'icon' => 'fa-university', 'badge' => 'bg-danger'],
    'Gym'     => ['label' => 'Gymnasium & Fitness', 'icon' => 'fa-dumbbell', 'badge' => 'bg-warning text-dark'],
    'Sports'  => ['label' => 'Sports Arena & Courts', 'icon' => 'fa-running', 'badge' => 'bg-success'],
    'Medical' => ['label' => 'Medical & Hospitals', 'icon' => 'fa-hospital-alt', 'badge' => 'bg-info text-dark']
];

// Handle Add / Edit / Category Move
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    // Quick Category Move
    if ($action === 'change_category') {
        $photoId = (int)($_POST['id'] ?? 0);
        $newCat = sanitize($_POST['category'] ?? 'Campus');
        if ($photoId > 0 && isset($categories[$newCat])) {
            $stmt = $pdo->prepare("UPDATE gallery SET category = :cat WHERE id = :id");
            $stmt->execute([':cat' => $newCat, ':id' => $photoId]);
            setFlashMsg('success', 'Photo category updated successfully.');
        }
        header("Location: manage_gallery.php?tab=" . urlencode($tab));
        exit;
    }

    // Add or Edit Photo
    if ($action === 'add' || $action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim(sanitize($_POST['title'] ?? ''));
        $category = trim(sanitize($_POST['category'] ?? $tab));
        if ($category === 'all') $category = 'Campus';
        $imageUrl = trim($_POST['image_url'] ?? '');

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
                $stmt = $pdo->prepare("INSERT INTO gallery (title, category, image_url, created_at) VALUES (:title, :cat, :url, NOW())");
                $stmt->execute([':title' => $title, ':cat' => $category, ':url' => $imageUrl]);
                setFlashMsg('success', "New photo added to '{$categories[$category]['label']}' successfully.");
            } elseif ($action === 'edit' && $id > 0) {
                $stmt = $pdo->prepare("UPDATE gallery SET title = :title, category = :cat, image_url = :url WHERE id = :id");
                $stmt->execute([':title' => $title, ':cat' => $category, ':url' => $imageUrl, ':id' => $id]);
                setFlashMsg('success', 'Gallery photo updated successfully.');
            }
            header("Location: manage_gallery.php?tab=" . urlencode($category));
            exit;
        }
    }
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $delId = (int)($_GET['id'] ?? 0);
    if ($delId > 0) {
        $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = :id");
        $stmt->execute([':id' => $delId]);
        setFlashMsg('success', 'Gallery photo deleted successfully.');
    }
    header("Location: manage_gallery.php?tab=" . urlencode($tab));
    exit;
}

// Fetch Category Counts
$counts = [];
foreach ($categories as $k => $c) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM gallery WHERE category = :cat");
    $stmt->execute([':cat' => $k]);
    $counts[$k] = (int)$stmt->fetchColumn();
}
$totalCount = (int)$pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
$counts['all'] = $totalCount;

// Query Photos for Active Tab
$searchQuery = sanitize($_GET['q'] ?? '');

$sql = "SELECT * FROM gallery WHERE 1=1";
$params = [];

if ($tab !== 'all' && isset($categories[$tab])) {
    $sql .= " AND category = :cat";
    $params[':cat'] = $tab;
}
if (!empty($searchQuery)) {
    $sql .= " AND image_url LIKE :q";
    $params[':q'] = "%{$searchQuery}%";
}
$sql .= " ORDER BY id ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$photos = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-images text-danger me-2"></i> Category-Wise Gallery Management</h3>
        <p class="text-muted small mb-0">Organize and manage university facility images across Campus, Gym, Sports Arena, and Hospitals.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL; ?>gallery.php<?php echo ($tab !== 'all') ? '?category=' . urlencode($tab) : ''; ?>" target="_blank" class="btn btn-sm btn-outline-danger px-3 rounded-pill shadow-sm">
            <i class="fas fa-external-link-alt me-1"></i> View Live Gallery
        </a>
    </div>
</div>

<!-- Category Tabs Header -->
<div class="card border-0 shadow-sm rounded-4 p-2 mb-4 bg-white">
    <div class="srku-filter-row">
        <?php foreach ($categories as $catKey => $catInfo): ?>
            <a href="manage_gallery.php?tab=<?php echo $catKey; ?>" class="srku-filter-btn <?php echo $tab === $catKey ? 'active' : ''; ?>">
                <i class="fas <?php echo $catInfo['icon']; ?>"></i> <?php echo $catInfo['label']; ?>
                <span class="badge <?php echo $tab === $catKey ? 'bg-white text-danger' : 'bg-secondary-subtle text-dark'; ?> rounded-pill ms-1"><?php echo $counts[$catKey]; ?></span>
            </a>
        <?php endforeach; ?>
        <a href="manage_gallery.php?tab=all" class="srku-filter-btn <?php echo $tab === 'all' ? 'active' : ''; ?>">
            <i class="fas fa-th-large"></i> All Photos
            <span class="badge <?php echo $tab === 'all' ? 'bg-white text-danger' : 'bg-secondary-subtle text-dark'; ?> rounded-pill ms-1"><?php echo $counts['all']; ?></span>
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Simple Add Photo Form (No caption required) -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 80px;">
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                <h5 class="fw-bold text-navy mb-0">
                    <i class="fas fa-plus-circle text-danger me-2"></i> Upload Photo
                </h5>
                <?php if ($tab !== 'all' && isset($categories[$tab])): ?>
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
                    <label class="form-label small fw-bold text-dark mb-1">OR Server Image Path</label>
                    <input type="text" name="image_url" class="form-control form-control-sm" 
                           placeholder="assets/uploads/gallery/webp/dsc06520.webp">
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm w-100">
                        <i class="fas fa-upload me-1"></i> Add Photo to Category
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
                        <i class="fas <?php echo ($tab !== 'all' && isset($categories[$tab])) ? $categories[$tab]['icon'] : 'fa-th-large'; ?> text-danger me-2"></i>
                        <?php echo ($tab !== 'all' && isset($categories[$tab])) ? $categories[$tab]['label'] : 'All Photos in Gallery'; ?>
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
                    <h6 class="fw-bold text-navy">No photos found in this category.</h6>
                    <p class="small mb-0">Upload a new photo using the form on the left.</p>
                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-3 g-3">
                    <?php foreach ($photos as $i => $row): 
                        $resolved = resolveMediaUrl($row['image_url']);
                        $currentCat = $row['category'] ?? 'Campus';
                        $catMeta = $categories[$currentCat] ?? ['label' => $currentCat, 'badge' => 'bg-secondary'];
                    ?>
                        <div class="col">
                            <div class="card h-100 border rounded-4 shadow-sm overflow-hidden bg-white">
                                <div class="position-relative" style="height: 180px; background: #0f172a;">
                                    <img src="<?php echo $resolved; ?>" alt="Gallery Image" class="w-100 h-100 object-fit-cover" loading="lazy">
                                    <span class="position-absolute top-0 start-0 m-2 badge <?php echo $catMeta['badge']; ?> small shadow-sm">
                                        <?php echo $catMeta['label']; ?>
                                    </span>
                                </div>
                                
                                <div class="p-3 bg-white">
                                    <!-- Quick Change Category Dropdown -->
                                    <form action="manage_gallery.php?tab=<?php echo urlencode($tab); ?>" method="POST" class="mb-2">
                                        <input type="hidden" name="action" value="change_category">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <select name="category" class="form-select form-select-sm" style="font-size: 0.78rem;" onchange="this.form.submit()" title="Move to another category tab">
                                            <?php foreach ($categories as $ck => $cv): ?>
                                                <option value="<?php echo $ck; ?>" <?php echo $currentCat === $ck ? 'selected' : ''; ?>>
                                                    Move to: <?php echo $cv['label']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>

                                    <div class="d-flex justify-content-between align-items-center pt-1 border-top">
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
