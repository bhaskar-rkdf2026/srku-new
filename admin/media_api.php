<?php
/**
 * Global Media Library API for Admin Panel
 * Handles media discovery, AJAX upload, and deletion across assets/uploads and assets/images
 */
ob_start();
require_once __DIR__ . '/../includes/functions.php';

// Security check: Must be logged in as Admin
if (!isAdminLoggedIn()) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized. Admin session required.']);
    exit;
}

header('Content-Type: application/json');
$action = $_GET['action'] ?? $_POST['action'] ?? 'list';

/**
 * Scan directory recursively for images
 */
function scanMediaImages($dir, $baseDir) {
    $images = [];
    if (!is_dir($dir)) return $images;
    
    $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    $items = scandir($dir);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..' || $item === '.git') continue;
        $path = $dir . '/' . $item;
        
        if (is_dir($path)) {
            // Avoid scanning non-media folders
            if (in_array($item, ['css', 'js', 'fonts', 'elementor', 'google-fonts', 'webp_backup'])) continue;
            $images = array_merge($images, scanMediaImages($path, $baseDir));
        } else {
            $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExts)) continue;
            
            $relPath = str_replace('\\', '/', substr($path, strlen($baseDir)));
            $relPath = ltrim($relPath, '/');
            
            // Categorize folder
            $folderLabel = 'Media Uploads';
            $folderKey = 'uploads';
            
            if (strpos($relPath, 'assets/images/constituent-logos') !== false) {
                $folderLabel = 'Constituent Logos';
                $folderKey = 'constituent-logos';
            } elseif (strpos($relPath, 'assets/images/rkdf-ist') !== false) {
                $folderLabel = 'RKDF-IST Campus';
                $folderKey = 'rkdf-ist';
            } elseif (strpos($relPath, 'assets/images') !== false) {
                $folderLabel = 'Core Theme & Logos';
                $folderKey = 'theme-images';
            } elseif (strpos($relPath, 'assets/uploads/constituent-units') !== false) {
                $folderLabel = 'Constituent Units';
                $folderKey = 'constituent-units';
            } elseif (strpos($relPath, 'assets/uploads/gallery') !== false) {
                $folderLabel = 'Campus Gallery';
                $folderKey = 'gallery';
            } elseif (strpos($relPath, 'assets/uploads/leaders') !== false) {
                $folderLabel = 'Leadership Profiles';
                $folderKey = 'leaders';
            } elseif (strpos($relPath, 'assets/uploads/2026/updated-docs') !== false) {
                $folderLabel = 'Official Approvals (2026)';
                $folderKey = 'approvals-2026';
            } elseif (strpos($relPath, 'assets/uploads/2026') !== false) {
                $folderLabel = 'Uploads 2026';
                $folderKey = 'uploads-2026';
            } elseif (strpos($relPath, 'assets/uploads/2025') !== false) {
                $folderLabel = 'Uploads 2025';
                $folderKey = 'uploads-2025';
            } elseif (strpos($relPath, 'assets/uploads/2024') !== false) {
                $folderLabel = 'Uploads 2024';
                $folderKey = 'uploads-2024';
            } elseif (strpos($relPath, 'assets/uploads/2023') !== false) {
                $folderLabel = 'Uploads 2023';
                $folderKey = 'uploads-2023';
            }
            
            $bytes = @filesize($path) ?: 0;
            $formattedSize = ($bytes > 1048576) ? round($bytes / 1048576, 2) . ' MB' : round($bytes / 1024, 1) . ' KB';
            $mtime = @filemtime($path) ?: time();
            
            // Dimensions
            $dims = 'Vector';
            if ($ext !== 'svg') {
                $imgInfo = @getimagesize($path);
                if ($imgInfo && isset($imgInfo[0], $imgInfo[1])) {
                    $dims = "{$imgInfo[0]} × {$imgInfo[1]}";
                }
            }
            
            $images[] = [
                'id' => md5($relPath),
                'name' => $item,
                'path' => $relPath,
                'url' => BASE_URL . $relPath,
                'ext' => $ext,
                'bytes' => $bytes,
                'size' => $formattedSize,
                'dimensions' => $dims,
                'folder' => $folderLabel,
                'folder_key' => $folderKey,
                'mtime' => $mtime,
                'date' => date('M d, Y', $mtime)
            ];
        }
    }
    return $images;
}

switch ($action) {
    // ══════════════════════════════════════════════════════════
    // 1. LIST ALL MEDIA ASSETS
    // ══════════════════════════════════════════════════════════
    case 'list':
        $rootDir = realpath(__DIR__ . '/../');
        $uploadsDir = realpath(__DIR__ . '/../assets/uploads/');
        $imagesDir = realpath(__DIR__ . '/../assets/images/');
        
        $allImages = [];
        if ($uploadsDir) $allImages = array_merge($allImages, scanMediaImages($uploadsDir, $rootDir));
        if ($imagesDir) $allImages = array_merge($allImages, scanMediaImages($imagesDir, $rootDir));
        
        // Remove duplicates if any
        $uniqueImages = [];
        foreach ($allImages as $img) {
            $uniqueImages[$img['path']] = $img;
        }
        $allImages = array_values($uniqueImages);
        
        // Sort by newest modified first
        usort($allImages, function($a, $b) {
            return $b['mtime'] - $a['mtime'];
        });
        
        // Collect available folders for filter dropdown
        $folders = [];
        foreach ($allImages as $img) {
            $folders[$img['folder_key']] = $img['folder'];
        }
        
        echo json_encode([
            'success' => true,
            'total' => count($allImages),
            'folders' => $folders,
            'images' => $allImages,
            'base_url' => BASE_URL
        ]);
        exit;

    // ══════════════════════════════════════════════════════════
    // 2. AJAX UPLOAD NEW IMAGE(S)
    // ══════════════════════════════════════════════════════════
    case 'upload':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }
        
        $files = $_FILES['media_files'] ?? $_FILES['file'] ?? $_FILES['media_file'] ?? null;
        if (!$files) {
            echo json_encode(['success' => false, 'message' => 'No files uploaded.']);
            exit;
        }
        
        $currentYear = date('Y');
        $currentMonth = date('m');
        $targetSubdir = "assets/uploads/{$currentYear}/{$currentMonth}/";
        $targetFullDir = __DIR__ . '/../' . $targetSubdir;
        
        if (!is_dir($targetFullDir)) {
            mkdir($targetFullDir, 0777, true);
        }
        
        $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
        $uploaded = [];
        $errors = [];
        
        // Standardize file array (supports single & multiple)
        $fileList = [];
        if (is_array($files['name'])) {
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $fileList[] = [
                        'name' => $files['name'][$i],
                        'tmp_name' => $files['tmp_name'][$i],
                        'size' => $files['size'][$i],
                        'error' => $files['error'][$i]
                    ];
                }
            }
        } else {
            if ($files['error'] === UPLOAD_ERR_OK) {
                $fileList[] = $files;
            } else {
                $errors[] = "Upload failed with error code: " . $files['error'];
            }
        }
        
        foreach ($fileList as $f) {
            $origName = basename($f['name']);
            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
            
            if (!in_array($ext, $allowedExts)) {
                $errors[] = "File '{$origName}' has invalid extension. Allowed: " . implode(', ', $allowedExts);
                continue;
            }
            
            $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($origName, PATHINFO_FILENAME));
            $finalName = time() . '_' . substr(md5(uniqid()), 0, 6) . '_' . $cleanName . '.' . $ext;
            $destPath = $targetFullDir . $finalName;
            
            if (move_uploaded_file($f['tmp_name'], $destPath)) {
                $relPath = $targetSubdir . $finalName;
                $bytes = filesize($destPath);
                $formattedSize = ($bytes > 1048576) ? round($bytes / 1048576, 2) . ' MB' : round($bytes / 1024, 1) . ' KB';
                
                $dims = 'Vector';
                if ($ext !== 'svg') {
                    $imgInfo = @getimagesize($destPath);
                    if ($imgInfo && isset($imgInfo[0], $imgInfo[1])) {
                        $dims = "{$imgInfo[0]} × {$imgInfo[1]}";
                    }
                }
                
                $uploaded[] = [
                    'id' => md5($relPath),
                    'name' => $finalName,
                    'path' => $relPath,
                    'url' => BASE_URL . $relPath,
                    'ext' => $ext,
                    'bytes' => $bytes,
                    'size' => $formattedSize,
                    'dimensions' => $dims,
                    'folder' => "Uploads {$currentYear}",
                    'folder_key' => "uploads-{$currentYear}",
                    'mtime' => time(),
                    'date' => date('M d, Y')
                ];
            } else {
                $errors[] = "Failed to save file '{$origName}' to upload directory.";
            }
        }
        
        if (!empty($uploaded)) {
            echo json_encode([
                'success' => true,
                'message' => count($uploaded) . ' image(s) uploaded successfully.',
                'uploaded' => $uploaded,
                'errors' => $errors
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => !empty($errors) ? implode('; ', $errors) : 'No files were uploaded.'
            ]);
        }
        exit;

    // ══════════════════════════════════════════════════════════
    // 3. DELETE IMAGE (Restricted to assets/uploads/)
    // ══════════════════════════════════════════════════════════
    case 'delete':
        $fileToDelete = sanitize($_POST['file'] ?? $_GET['file'] ?? '');
        if (empty($fileToDelete)) {
            echo json_encode(['success' => false, 'message' => 'No file specified for deletion.']);
            exit;
        }
        
        $fullPath = realpath(__DIR__ . '/../' . $fileToDelete);
        $baseUploadDir = realpath(__DIR__ . '/../assets/uploads/');
        
        // Security check: only allow deleting files within assets/uploads/ (protect core theme assets)
        if ($fullPath && $baseUploadDir && strpos($fullPath, $baseUploadDir) === 0 && file_exists($fullPath)) {
            if (@unlink($fullPath)) {
                echo json_encode(['success' => true, 'message' => 'Image permanently deleted.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Permission denied: Failed to delete image.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file path or core system image cannot be deleted.']);
        }
        exit;

    default:
        echo json_encode(['success' => false, 'message' => 'Unknown action.']);
        exit;
}
