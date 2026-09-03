<?php
require_once __DIR__ . '/../config/db.php';

// Sanitize user inputs
function sanitize($data) {
    if ($data === null) return '';
    return htmlspecialchars(trim((string)$data), ENT_QUOTES, 'UTF-8');
}

// Generate clean URL slug from title
function generateSlug($string) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', (string)$string)));
    return rtrim($slug, '-');
}

// Fetch site setting by key
function getSetting($key, $default = '') {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = :k LIMIT 1");
        $stmt->execute([':k' => $key]);
        $res = $stmt->fetchColumn();
        return ($res !== false && trim((string)$res) !== '') ? $res : $default;
    } catch (Exception $e) {
        return $default;
    }
}

/**
 * Normalizes a relative or bare filename to the correct relative path in the workspace.
 */
function normalizeMediaPath($path, $default = '') {
    $path = trim((string)$path);
    if (empty($path)) {
        $path = trim((string)$default);
    }
    if (empty($path)) {
        return '';
    }
    $baseDir = dirname(__DIR__);

    // If it's a full URL containing localhost, staging, or server domain, extract the asset path
    if (preg_match('/^https?:\/\//i', $path) || strpos($path, '//') === 0) {
        $parsedPath = parse_url($path, PHP_URL_PATH);
        if ($parsedPath) {
            $trimmed = ltrim($parsedPath, '/');
            $trimmed = preg_replace('/^(new-staging|srku-new|srku)\//i', '', $trimmed);
            if (is_file($baseDir . '/' . $trimmed)) {
                return $trimmed;
            }
            $cleanPath = basename($trimmed);
        } else {
            return $path;
        }
    } else {
        $cleanPath = ltrim(str_replace('\\', '/', $path), '/');
    }

    // 1. Direct path exists
    if (is_file($baseDir . '/' . $cleanPath)) {
        return $cleanPath;
    }

    // 1b. Check if cleanPath is missing 'assets/' prefix
    if (strpos($cleanPath, 'uploads/') === 0 && is_file($baseDir . '/assets/' . $cleanPath)) {
        return 'assets/' . $cleanPath;
    }
    // 1c. Support singular / plural constituent-unit(s) folder
    $altUnitPath = str_replace('constituent-unit/', 'constituent-units/', $cleanPath);
    if (is_file($baseDir . '/' . $altUnitPath)) {
        return $altUnitPath;
    }
    if (is_file($baseDir . '/assets/' . $altUnitPath)) {
        return 'assets/' . $altUnitPath;
    }

    // 2. Search common folders
    $candidateDirs = [
        'assets/uploads/constituent-units/',
        'assets/images/',
        'assets/uploads/2026/08/',
        'assets/uploads/2026/07/',
        'assets/uploads/2026/06/',
        'assets/uploads/2024/06/',
        'assets/uploads/',
        'assets/upload/2026/06/',
        'assets/upload/2024/06/',
        'assets/upload/',
        'assets/gallery/webp/',
        'assets/gallery/',
        'assets/img/',
        'assets/',
        'wp-content/uploads/'
    ];

    $filename = basename($cleanPath);
    foreach ($candidateDirs as $dir) {
        if (is_file($baseDir . '/' . $dir . $filename)) {
            return $dir . $filename;
        }
        if (is_file($baseDir . '/' . $dir . $cleanPath)) {
            return $dir . $cleanPath;
        }
    }

    // 3. Recursive search in assets folder
    $found = glob($baseDir . '/assets/**/' . $filename);
    if (!empty($found) && is_file($found[0])) {
        $rel = str_replace(str_replace('\\', '/', $baseDir) . '/', '', str_replace('\\', '/', $found[0]));
        return $rel;
    }

    // 4. Default fallback if original path not found
    if (!empty($default) && $default !== $path) {
        return normalizeMediaPath($default, '');
    }

    return $cleanPath;
}

/**
 * Resolves any media path (bare filename, relative path, or full URL) into a fully working URL.
 */
function resolveMediaUrl($path, $default = '') {
    $normalized = normalizeMediaPath($path, $default);
    if (empty($normalized)) {
        return '';
    }
    if (preg_match('/^https?:\/\//i', $normalized) || strpos($normalized, '//') === 0) {
        return $normalized;
    }
    return BASE_URL . $normalized;
}

/**
 * Returns all available video files in the website assets directory.
 */
function getAvailableVideos() {
    $baseDir = dirname(__DIR__);
    $videos = [];
    $patterns = [
        $baseDir . '/assets/images/*.{mp4,webm,mov,ogg}',
        $baseDir . '/assets/uploads/**/*.{mp4,webm,mov,ogg}',
        $baseDir . '/assets/upload/**/*.{mp4,webm,mov,ogg}',
        $baseDir . '/assets/*.{mp4,webm,mov,ogg}'
    ];

    $matched = [];
    foreach ($patterns as $pattern) {
        $found = glob($pattern, GLOB_BRACE);
        if ($found) {
            foreach ($found as $f) {
                if (is_file($f)) {
                    $matched[realpath($f)] = $f;
                }
            }
        }
    }

    foreach ($matched as $f) {
        $rel = str_replace(str_replace('\\', '/', $baseDir) . '/', '', str_replace('\\', '/', $f));
        $size = filesize($f);
        $sizeStr = ($size > 1048576) ? round($size / 1048576, 1) . ' MB' : round($size / 1024, 1) . ' KB';
        $basename = basename($f);
        
        $label = $basename;
        if (stripos($basename, 'concept2') !== false || stripos($basename, 'SRK-Hero') !== false) {
            $label = 'Campus Aerial & Buildings (High Definition 1080p)';
        } elseif (stripos($basename, 'drone') !== false) {
            $label = 'Campus Drone Tour HD';
        } elseif (stripos($basename, 'C0036') !== false) {
            $label = 'Campus Cinematic 4K';
        } elseif (stripos($basename, 'hero_video') !== false) {
            $label = 'Custom Uploaded Video (' . $basename . ')';
        }

        $videos[] = [
            'path' => $rel,
            'name' => $basename,
            'size' => $sizeStr,
            'label' => $label
        ];
    }

    return $videos;
}

// Fetch all active departments
function getDepartments($activeOnly = true) {
    try {
        $pdo = getDBConnection();
        $sql = "SELECT * FROM departments";
        if ($activeOnly) $sql .= " WHERE status = 'active'";
        $sql .= " ORDER BY name ASC";
        return $pdo->query($sql)->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

// Fetch single department by slug or name
function getDepartmentBySlug($slug) {
    try {
        $pdo = getDBConnection();
        $slug = trim((string)$slug);
        if (empty($slug)) return false;

        $idVal = is_numeric($slug) ? (int)$slug : 0;
        // 1. Exact match by slug or ID
        $stmt = $pdo->prepare("SELECT * FROM departments WHERE slug = :s OR id = :idval LIMIT 1");
        $stmt->execute([':s' => $slug, ':idval' => $idVal]);
        $res = $stmt->fetch();
        if ($res) return $res;

        // 2. Direct Slug Keyword Map for all constituents
        $keyMap = [
            'homoeopath' => 'rkdf-homoeopathic-medical-college',
            'dental'     => 'rkdf-dental-college',
            'ayurved'    => 'sarvepalli-radhakrishnan-college-of-ayurveda',
            'nursing'    => 'rkdf-college-of-nursing',
            'medical'    => 'rkdf-medical-college',
            'paramedic'  => 'department-of-paramedical-sciences',
            'allied'     => 'allied-sciences',
            'agricultur' => 'faculty-of-agriculture',
            'law'        => 'sarvepalli-radhakrishnan-college-of-law',
            'science-tech' => 'rkdf-institute-of-science-and-technology',
            'ist'        => 'rkdf-institute-of-science-and-technology',
            'mca'        => 'rkdf-institute-science-technology-mca',
            'business'   => 'rkdf-institute-of-business-management',
            'rkdf-college-of-pharmacy' => 'rkdf-college-of-pharmacy',
            'pharm'      => 'rkdf-college-of-pharmacy',
            'commerce'   => 'faculty-of-commerce',
            'arts'       => 'faculty-of-arts',
            'science'    => 'faculty-of-science',
            'computer'   => 'faculty-of-computer-application',
            'library'    => 'faculty-of-library-science',
            'yoga'       => 'faculty-of-yoga',
            'fashion'    => 'faculty-of-fashion-technology-design',
        ];

        foreach ($keyMap as $k => $mappedSlug) {
            if (stripos($slug, $k) !== false) {
                $stmt = $pdo->prepare("SELECT * FROM departments WHERE slug = :ms LIMIT 1");
                $stmt->execute([':ms' => $mappedSlug]);
                $matched = $stmt->fetch();
                if ($matched) return $matched;
            }
        }

        // 3. Fallback tokenized search
        $cleanTerm = preg_replace('/[^a-zA-Z0-9]+/', ' ', $slug);
        $tokens = array_filter(explode(' ', $cleanTerm), fn($t) => strlen($t) > 3 && !in_array($t, ['department', 'faculty', 'college', 'institute', 'hospital', 'research', 'center', 'centre', 'university', 'srku']));
        
        foreach ($tokens as $tok) {
            $stmt = $pdo->prepare("SELECT * FROM departments WHERE name LIKE :t OR slug LIKE :t LIMIT 1");
            $stmt->execute([':t' => '%' . $tok . '%']);
            $res = $stmt->fetch();
            if ($res) return $res;
        }

        return false;
    } catch (Exception $e) {
        return false;
    }
}

// Fetch courses with optional filters
function getCourses($deptSlug = null, $level = null, $search = null, $limit = null) {
    try {
        $pdo = getDBConnection();
        $sql = "SELECT * FROM courses WHERE status = 'active'";
        $params = [];

        if (!empty($deptSlug)) {
            $sql .= " AND (dept_slug = :dept OR department LIKE :dept_name)";
            $params[':dept'] = $deptSlug;
            $params[':dept_name'] = '%' . $deptSlug . '%';
        }

        if (!empty($level)) {
            $sql .= " AND level = :lvl";
            $params[':lvl'] = $level;
        }

        if (!empty($search)) {
            $sql .= " AND (course_name LIKE :kw1 OR department LIKE :kw2 OR description LIKE :kw3 OR specializations LIKE :kw4 OR eligibility LIKE :kw5)";
            $params[':kw1'] = '%' . $search . '%';
            $params[':kw2'] = '%' . $search . '%';
            $params[':kw3'] = '%' . $search . '%';
            $params[':kw4'] = '%' . $search . '%';
            $params[':kw5'] = '%' . $search . '%';
        }

        $sql .= " ORDER BY department ASC, course_name ASC";
        if (!empty($limit)) {
            $sql .= " LIMIT " . (int)$limit;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

// Fetch single course by slug, id or fuzzy title
function getCourseBySlug($slug) {
    try {
        $pdo = getDBConnection();
        $idVal = is_numeric($slug) ? (int)$slug : 0;
        $stmt = $pdo->prepare("SELECT * FROM courses WHERE slug = :s OR id = :idval LIMIT 1");
        $stmt->execute([':s' => $slug, ':idval' => $idVal]);
        $res = $stmt->fetch();
        if ($res) return $res;

        // Strip known stop words & normalize stems (pharma -> pharm)
        $cleanTerm = str_replace(['srk-university', 'faculty-of', 'department-of', 'srk-bhopal'], '', $slug);
        $cleanTerm = str_replace('pharma', 'pharm', $cleanTerm);
        $cleanTerm = trim(preg_replace('/-+/', ' ', $cleanTerm));
        
        // Search by words in slug (e.g. "b tech", "b pharm", "mba", "mca", "b sc nursing")
        $parts = explode(' ', $cleanTerm);
        $firstTwo = implode(' ', array_slice($parts, 0, 2));
        
        if (!empty($firstTwo)) {
            $stmt = $pdo->prepare("SELECT * FROM courses WHERE course_name LIKE :kw1 OR slug LIKE :kw2 LIMIT 1");
            $stmt->execute([':kw1' => '%' . $firstTwo . '%', ':kw2' => '%' . str_replace(' ', '-', $firstTwo) . '%']);
            $res = $stmt->fetch();
            if ($res) return $res;
        }

        if (!empty($parts[0]) && strlen($parts[0]) >= 2) {
            $stmt = $pdo->prepare("SELECT * FROM courses WHERE course_name LIKE :kw1 OR slug LIKE :kw2 LIMIT 1");
            $stmt->execute([':kw1' => '%' . $parts[0] . '%', ':kw2' => '%' . $parts[0] . '%']);
            $res = $stmt->fetch();
            if ($res) return $res;
        }

        return false;
    } catch (Exception $e) {
        return false;
    }
}

// Fetch dynamic CMS page by slug
function getPageBySlug($slug) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = :s AND status = 'published' LIMIT 1");
        $stmt->execute([':s' => $slug]);
        return $stmt->fetch();
    } catch (Exception $e) {
        return false;
    }
}

// Fetch blogs from dedicated blogs table
function getBlogs($category = null, $limit = 12, $search = '') {
    try {
        $pdo = getDBConnection();
        $sql = "SELECT * FROM blogs WHERE status = 'published'";
        $params = [];
        if (!empty($category) && $category !== 'all') {
            $sql .= " AND category = :c";
            $params[':c'] = $category;
        }
        if (!empty($search)) {
            $sql .= " AND (title LIKE :s OR content LIKE :s OR short_description LIKE :s)";
            $params[':s'] = "%$search%";
        }
        $sql .= " ORDER BY publish_date DESC, id DESC";
        if (!empty($limit)) {
            $sql .= " LIMIT " . (int)$limit;
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

// Fetch single blog by slug or ID with view count update
function getBlogBySlug($slug) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM blogs WHERE (slug = :s OR id = :id) AND status = 'published' LIMIT 1");
        $idVal = is_numeric($slug) ? (int)$slug : 0;
        $stmt->execute([':s' => $slug, ':id' => $idVal]);
        $blog = $stmt->fetch();
        if ($blog) {
            // increment view count
            try {
                $pdo->prepare("UPDATE blogs SET views = views + 1 WHERE id = :id")->execute([':id' => $blog['id']]);
            } catch (Exception $e2) {}
            return $blog;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

// Fetch news items
function getNews($category = null, $limit = 6, $tickerOnly = false) {
    try {
        $pdo = getDBConnection();
        $sql = "SELECT * FROM news WHERE 1=1";
        $params = [];
        if ($tickerOnly) {
            $sql .= " AND is_ticker = 1";
        }
        if (!empty($category)) {
            $sql .= " AND category = :c";
            $params[':c'] = $category;
        }
        $sql .= " ORDER BY publish_date DESC, id DESC";
        if (!empty($limit)) {
            $sql .= " LIMIT " . (int)$limit;
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

// Fetch single news by slug or ID
function getNewsBySlug($slug) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM news WHERE slug = :s OR id = :id LIMIT 1");
        $idVal = is_numeric($slug) ? (int)$slug : 0;
        $stmt->execute([':s' => $slug, ':id' => $idVal]);
        return $stmt->fetch();
    } catch (Exception $e) {
        return false;
    }
}

// Fetch banners
function getBanners() {
    try {
        $pdo = getDBConnection();
        return $pdo->query("SELECT * FROM banners ORDER BY sort_order ASC, id ASC")->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

// Fetch gallery images (with DB support & smart fallback)
function getGalleryImages($category = null, $limit = null) {
    try {
        $pdo = getDBConnection();
        $rows = [];
        if ($pdo) {
            $sql = "SELECT * FROM gallery";
            $params = [];
            if (!empty($category) && strtolower($category) !== 'all') {
                $sql .= " WHERE LOWER(TRIM(category)) = LOWER(TRIM(:c))";
                $params[':c'] = $category;
            }
            $sql .= " ORDER BY id DESC";
            if (!empty($limit) && is_numeric($limit)) {
                $sql .= " LIMIT " . (int)$limit;
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // If DB has 10+ photos, return them
        if (count($rows) >= 10) {
            return $rows;
        }

        // Auto-scan Fallback: If DB table is empty or has fewer than 10 photos, read all 71 webp gallery files
        $uploadDir = dirname(__DIR__) . '/assets/uploads/gallery/webp/';
        if (is_dir($uploadDir)) {
            $files = glob($uploadDir . '*.webp');
            if (!empty($files) && count($files) > count($rows)) {
                $fallback = [];
                $id = 1;
                foreach ($files as $f) {
                    $bn = basename($f);
                    $cat = 'Campus';
                    if (strpos($bn, 'gym') !== false || in_array($bn, ['dsc06520.webp','dsc06574.webp','dsc06575.webp','dsc06576.webp','dsc06577.webp','dsc06586.webp','dsc06587.webp','dsc06588.webp','dsc06600.webp','dsc06603.webp','dsc06605.webp','dsc06607.webp','dsc06609.webp','dsc06611.webp','dsc06612.webp','dsc06614.webp','dsc06615.webp','dsc06617.webp','dsc06618.webp','dsc06619.webp','dsc06622.webp','dsc06623.webp'])) {
                        $cat = 'Gym';
                    } elseif (strpos($bn, 'sport') !== false || in_array($bn, ['dsc06517.webp','dsc06525.webp','dsc06527.webp','dsc06528.webp','dsc06533.webp','dsc06534.webp','dsc06537.webp','dsc06538.webp','dsc06539.webp','dsc06540.webp','dsc06541.webp','dsc06542.webp','dsc06547.webp','dsc06548.webp','dsc06554.webp','dsc06578.webp','dsc06579.webp','dsc06580.webp','dsc06582.webp','dsc06583.webp'])) {
                        $cat = 'Sports';
                    } elseif (strpos($bn, 'med') !== false || strpos($bn, 'hosp') !== false || in_array($bn, ['dsc06740.webp','dsc06754.webp','dsc06767.webp','dsc06769.webp','dsc06772.webp','dsc06839.webp','dsc06842.webp','dsc06847.webp','dsc06857.webp'])) {
                        $cat = 'Medical';
                    }
                    
                    if (empty($category) || strtolower($category) === 'all' || strtolower($category) === strtolower($cat)) {
                        $fallback[] = [
                            'id' => $id++,
                            'title' => 'SRKU Campus & Infrastructure Photo',
                            'category' => $cat,
                            'image_url' => 'assets/uploads/gallery/webp/' . $bn,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                    }
                }
                if (!empty($limit) && is_numeric($limit)) {
                    $fallback = array_slice($fallback, 0, (int)$limit);
                }
                return $fallback;
            }
        }

        return $rows;
    } catch (Exception $e) {
        return [];
    }
}

// Admin session security check
function checkAdminLogin() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: " . BASE_URL . "admin/login.php");
        exit;
    }
}

// Flash message helpers
function setFlashMsg($type, $msg) {
    $_SESSION['flash_type'] = $type;
    $_SESSION['flash_msg'] = $msg;
}

function displayFlashMsg() {
    if (isset($_SESSION['flash_msg'])) {
        $type = $_SESSION['flash_type'] ?? 'info';
        $msg = $_SESSION['flash_msg'];
        unset($_SESSION['flash_type'], $_SESSION['flash_msg']);
        echo "<div class='alert alert-{$type} alert-dismissible fade show' role='alert'>
                {$msg}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
}

// Fetch Dynamic Page Banner from banners or pages table
function getPageBanner($pageSlug, $defaultTitle = '', $defaultSubtitle = '', $defaultImg = '') {
    try {
        $pdo = getDBConnection();
        // 1. Check custom banners table first
        $stmt = $pdo->prepare("SELECT * FROM banners WHERE (page_slug = :s OR page_slug = :clean) ORDER BY sort_order ASC, id DESC LIMIT 1");
        $cleanSlug = str_replace(['page.php?slug=', '.php', '/'], '', $pageSlug);
        $stmt->execute([':s' => $pageSlug, ':clean' => $cleanSlug]);
        $b = $stmt->fetch();
        if ($b && (!empty($b['title']) || !empty($b['image_url']))) {
            return [
                'title' => !empty($b['title']) ? $b['title'] : $defaultTitle,
                'subtitle' => !empty($b['subtitle']) ? $b['subtitle'] : $defaultSubtitle,
                'image' => !empty($b['image_url']) ? $b['image_url'] : $defaultImg,
                'btn_text' => $b['btn_text'] ?? '',
                'btn_link' => $b['btn_link'] ?? ''
            ];
        }

        // 2. Check pages table
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = :s LIMIT 1");
        $stmt->execute([':s' => $cleanSlug]);
        $p = $stmt->fetch();
        if ($p) {
            return [
                'title' => !empty($p['banner_title']) ? $p['banner_title'] : (!empty($p['title']) ? $p['title'] : $defaultTitle),
                'subtitle' => !empty($p['banner_subtitle']) ? $p['banner_subtitle'] : $defaultSubtitle,
                'image' => !empty($p['banner_img']) ? $p['banner_img'] : $defaultImg,
                'btn_text' => '',
                'btn_link' => ''
            ];
        }

        return [
            'title' => $defaultTitle,
            'subtitle' => $defaultSubtitle,
            'image' => $defaultImg,
            'btn_text' => '',
            'btn_link' => ''
        ];
    } catch (Exception $e) {
        return [
            'title' => $defaultTitle,
            'subtitle' => $defaultSubtitle,
            'image' => $defaultImg,
            'btn_text' => '',
            'btn_link' => ''
        ];
    }
}

// Render dynamic top banner for any page
function renderPageBanner($pageSlug, $defaultTitle, $defaultSubtitle = '', $defaultImg = '') {
    $banner = getPageBanner($pageSlug, $defaultTitle, $defaultSubtitle, $defaultImg);
    $bgStyle = !empty($banner['image']) 
        ? "background: linear-gradient(rgba(14, 30, 56, 0.78), rgba(122, 29, 29, 0.82)), url('" . BASE_URL . $banner['image'] . "') center/cover no-repeat;" 
        : "background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));";
    ?>
    <div class="py-5 text-center text-white page-top-banner position-relative" style="<?php echo $bgStyle; ?>">
        <div class="container-xl py-3 position-relative z-2">
            <h1 class="fw-bold display-5 mb-2"><?php echo sanitize($banner['title']); ?></h1>
            <?php if (!empty($banner['subtitle'])): ?>
                <p class="text-warning fw-semibold lead mb-0"><?php echo sanitize($banner['subtitle']); ?></p>
            <?php endif; ?>
            <?php if (!empty($banner['btn_text']) && !empty($banner['btn_link'])): ?>
                <div class="mt-3">
                    <a href="<?php echo sanitize($banner['btn_link']); ?>" class="btn btn-warning fw-bold px-4 rounded-pill shadow-sm"><?php echo sanitize($banner['btn_text']); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

// Save and validate student enquiry or lead with source tagging
function saveEnquiryLead($name, $email, $phone, $course = '', $message = '', $source = '', $fatherName = '', $city = '', $state = '') {
    $name = trim((string)$name);
    $email = trim((string)$email);
    $phone = trim((string)$phone);
    $course = trim((string)$course);
    $message = trim((string)$message);
    $fatherName = trim((string)$fatherName);
    $city = trim((string)$city);
    $state = trim((string)$state);

    // Validation
    if (strlen($name) < 2) {
        return ['success' => false, 'error' => 'Please enter a valid full name (minimum 2 characters).'];
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'error' => 'Please enter a valid email address (e.g. name@domain.com).'];
    }
    $cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
    if (strlen($cleanPhone) < 7 || strlen($cleanPhone) > 16) {
        return ['success' => false, 'error' => 'Please enter a valid mobile / contact number.'];
    }

    $fullMsg = $message;
    if ($source) {
        $fullMsg = "[" . $source . "]\n" . ($message ?: 'Seat Inquiry / Direct Admission Application');
    }

    try {
        $pdo = getDBConnection();
        
        // Ensure columns exist
        $cols = $pdo->query("SHOW COLUMNS FROM `enquiries`")->fetchAll(PDO::FETCH_COLUMN);
        if (!in_array('father_name', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `father_name` VARCHAR(150) AFTER `name`");
        if (!in_array('city', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `city` VARCHAR(100) AFTER `course`");
        if (!in_array('state', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `state` VARCHAR(100) AFTER `city`");
        if (!in_array('source', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `source` VARCHAR(150) AFTER `state`");
        if (!in_array('status', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `status` VARCHAR(50) DEFAULT 'New' AFTER `message`");

        $stmt = $pdo->prepare("INSERT INTO enquiries (name, father_name, email, phone, course, city, state, source, message, status, created_at) VALUES (:n, :fn, :e, :p, :c, :city, :state, :src, :m, 'New', CURRENT_TIMESTAMP)");
        $stmt->execute([
            ':n' => $name,
            ':fn' => $fatherName ?: null,
            ':e' => $email ?: 'not-provided@srku.edu.in',
            ':p' => $phone,
            ':c' => $course ?: 'General Admission Enquiry',
            ':city' => $city ?: null,
            ':state' => $state ?: null,
            ':src' => $source ?: 'Website',
            ':m' => $fullMsg
        ]);
        return ['success' => true, 'message' => 'Thank you! Your admission inquiry has been submitted successfully. Our counselor will contact you shortly.'];
    } catch (Exception $ex) {
        // Fallback simple insert if any column discrepancy
        try {
            $stmt = $pdo->prepare("INSERT INTO enquiries (name, email, phone, course, message, status) VALUES (:n, :e, :p, :c, :m, 'New')");
            $stmt->execute([
                ':n' => $name,
                ':e' => $email ?: 'lead@srku.edu.in',
                ':p' => $phone,
                ':c' => $course ?: 'General Admission Enquiry',
                ':m' => $fullMsg
            ]);
            return ['success' => true, 'message' => 'Thank you! Your inquiry has been submitted successfully. Our counselor will contact you shortly.'];
        } catch (Exception $e2) {
            return ['success' => false, 'error' => 'Unable to submit inquiry at this moment. Please call our helpline directly at 0755-4700983.'];
        }
    }
}

// Save and validate a student grievance / complaint
function saveComplaint($name, $fatherName, $enrollmentNumber, $email, $phone, $instituteName, $courseName, $yearSemester, $complaintType, $complaintDetails) {
    $name = trim((string)$name);
    $fatherName = trim((string)$fatherName);
    $enrollmentNumber = trim((string)$enrollmentNumber);
    $email = trim((string)$email);
    $phone = trim((string)$phone);
    $instituteName = trim((string)$instituteName);
    $courseName = trim((string)$courseName);
    $yearSemester = trim((string)$yearSemester);
    $complaintType = trim((string)$complaintType);
    $complaintDetails = trim((string)$complaintDetails);

    if (strlen($name) < 2) {
        return ['success' => false, 'error' => 'Please enter a valid full name (minimum 2 characters).'];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'error' => 'Please enter a valid email address (e.g. name@domain.com).'];
    }
    $cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
    if (strlen($cleanPhone) < 10 || strlen($cleanPhone) > 15) {
        return ['success' => false, 'error' => 'Please enter a valid 10-digit mobile number.'];
    }
    if (strlen($complaintDetails) < 10) {
        return ['success' => false, 'error' => 'Please describe your complaint in at least 10 characters.'];
    }

    try {
        $pdo = getDBConnection();
        // Ensure complaints table exists
        $pdo->exec("CREATE TABLE IF NOT EXISTS complaints (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            father_name VARCHAR(150) NULL,
            enrollment_number VARCHAR(100) NULL,
            email VARCHAR(150) NOT NULL,
            phone VARCHAR(50) NOT NULL,
            institute_name VARCHAR(255) NULL,
            course_name VARCHAR(255) NULL,
            year_semester VARCHAR(100) NULL,
            complaint_type VARCHAR(100) NOT NULL DEFAULT 'General',
            complaint_details TEXT NOT NULL,
            status VARCHAR(50) NOT NULL DEFAULT 'New',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $stmt = $pdo->prepare("INSERT INTO complaints (name, father_name, enrollment_number, email, phone, institute_name, course_name, year_semester, complaint_type, complaint_details, status, created_at) VALUES (:n, :fn, :en, :e, :p, :inst, :course, :ys, :ct, :cd, 'New', CURRENT_TIMESTAMP)");
        $stmt->execute([
            ':n' => $name,
            ':fn' => $fatherName ?: null,
            ':en' => $enrollmentNumber ?: null,
            ':e' => $email,
            ':p' => $phone,
            ':inst' => $instituteName ?: null,
            ':course' => $courseName ?: null,
            ':ys' => $yearSemester ?: null,
            ':ct' => $complaintType ?: 'General',
            ':cd' => $complaintDetails
        ]);

        // Also sync into unified enquiries for Admin Admissions & Enquiries dashboard
        try {
            $grievanceMsg = "[Student Grievance - " . ($complaintType ?: 'General') . "]\nEnrollment: " . ($enrollmentNumber ?: 'N/A') . "\nInstitute: " . ($instituteName ?: 'N/A') . "\nCourse: " . ($courseName ?: 'N/A') . "\nYear/Sem: " . ($yearSemester ?: 'N/A') . "\n\nDetails:\n" . $complaintDetails;
            
            $stmtEnq = $pdo->prepare("INSERT INTO enquiries (name, father_name, email, phone, course, source, message, status, created_at) VALUES (:n, :fn, :e, :p, :c, 'Student Grievance Redressal Portal', :m, 'New', CURRENT_TIMESTAMP)");
            $stmtEnq->execute([
                ':n' => $name,
                ':fn' => $fatherName ?: null,
                ':e' => $email,
                ':p' => $phone,
                ':c' => $courseName ?: ($complaintType ? "Grievance: $complaintType" : 'Student Grievance'),
                ':m' => $grievanceMsg
            ]);
        } catch (Exception $e2) {}

        return ['success' => true, 'message' => 'Your complaint has been registered successfully. Our grievance cell will review it and contact you shortly.'];
    } catch (Exception $ex) {
        return ['success' => false, 'error' => 'Failed to register complaint: ' . $ex->getMessage()];
    }
}

// Faculty list retrieval with optional filtering
function getFacultyList($deptSlug = '', $search = '', $designation = '', $limit = 0, $offset = 0) {
    try {
        $pdo = getDBConnection();
        $sql = "SELECT * FROM faculty WHERE status = 'active'";
        $params = [];

        if (!empty($deptSlug)) {
            $sql .= " AND (dept_slug = :dept OR department_name LIKE :deptLike)";
            $params[':dept'] = $deptSlug;
            $params[':deptLike'] = "%" . $deptSlug . "%";
        }
        if (!empty($designation)) {
            $sql .= " AND designation LIKE :desig";
            $params[':desig'] = "%" . $designation . "%";
        }
        if (!empty($search)) {
            $sql .= " AND (name LIKE :s OR department_name LIKE :s OR qualification LIKE :s OR designation LIKE :s)";
            $params[':s'] = "%" . $search . "%";
        }

        $sql .= " ORDER BY 
            CASE 
                WHEN designation LIKE '%Dean%' OR designation LIKE '%Principal%' OR designation LIKE '%Director%' THEN 1
                WHEN designation LIKE '%HOD%' OR designation LIKE '%Head%' THEN 2
                WHEN designation LIKE '%Professor%' AND designation NOT LIKE '%Associate%' AND designation NOT LIKE '%Assistant%' THEN 3
                WHEN designation LIKE '%Associate Professor%' OR designation LIKE '%Reader%' THEN 4
                WHEN designation LIKE '%Assistant Professor%' OR designation LIKE '%Lecturer%' THEN 5
                ELSE 6
            END, id ASC";

        if ($limit > 0) {
            $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

// Faculty distinct departments
function getFacultyDepartments() {
    try {
        $pdo = getDBConnection();
        return $pdo->query("SELECT department_name, dept_slug, COUNT(*) as count FROM faculty WHERE status = 'active' GROUP BY department_name, dept_slug ORDER BY department_name ASC")->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

// Faculty statistics
function getFacultyStats() {
    try {
        $pdo = getDBConnection();
        $total = $pdo->query("SELECT COUNT(*) FROM faculty WHERE status = 'active'")->fetchColumn();
        $depts = $pdo->query("SELECT COUNT(DISTINCT department_name) FROM faculty WHERE status = 'active'")->fetchColumn();
        $professors = $pdo->query("SELECT COUNT(*) FROM faculty WHERE status = 'active' AND (designation LIKE '%Professor%' OR designation LIKE '%Dean%' OR designation LIKE '%Principal%')")->fetchColumn();
        $phdHolders = $pdo->query("SELECT COUNT(*) FROM faculty WHERE status = 'active' AND (qualification LIKE '%PhD%' OR qualification LIKE '%P.hd%' OR qualification LIKE '%MD%' OR qualification LIKE '%MS%' OR qualification LIKE '%MDS%')")->fetchColumn();
        return [
            'total' => (int)$total,
            'departments' => (int)$depts,
            'professors' => (int)$professors,
            'phd_md_count' => (int)$phdHolders
        ];
    } catch (Exception $e) {
        return ['total' => 0, 'departments' => 0, 'professors' => 0, 'phd_md_count' => 0];
    }
}

// -------------------------------------------------------------
// DYNAMIC SYLLABUS & EXAMINATION SCHEME FUNCTIONS
// -------------------------------------------------------------

/**
 * Returns icon and department metadata for a given category slug
 */
function getSyllabusCategoryMeta($slug) {
    static $meta = [
        'ba-llb' => ['icon' => 'fas fa-gavel', 'dept' => 'Law & Legal Studies', 'color' => '#8b0000'],
        'bjmc' => ['icon' => 'fas fa-newspaper', 'dept' => 'Journalism & Mass Communication', 'color' => '#d9534f'],
        'llb' => ['icon' => 'fas fa-balance-scale', 'dept' => 'Law & Legal Studies', 'color' => '#8b0000'],
        'llm' => ['icon' => 'fas fa-graduation-cap', 'dept' => 'Law & Legal Studies', 'color' => '#8b0000'],
        'b-pharmacy' => ['icon' => 'fas fa-pills', 'dept' => 'Pharmacy', 'color' => '#0284c7'],
        'd-pharmacy' => ['icon' => 'fas fa-capsules', 'dept' => 'Pharmacy', 'color' => '#0284c7'],
        'm-pharma' => ['icon' => 'fas fa-prescription', 'dept' => 'Pharmacy', 'color' => '#0284c7'],
        'nursing' => ['icon' => 'fas fa-user-nurse', 'dept' => 'Nursing Sciences', 'color' => '#059669'],
        'polytechnic-engineering' => ['icon' => 'fas fa-tools', 'dept' => 'Engineering & Technology', 'color' => '#d97706'],
        'agriculture-courses' => ['icon' => 'fas fa-seedling', 'dept' => 'Agricultural Sciences', 'color' => '#16a34a'],
        'paramedical' => ['icon' => 'fas fa-stethoscope', 'dept' => 'Paramedical Sciences', 'color' => '#dc2626'],
        'be-btech' => ['icon' => 'fas fa-laptop-code', 'dept' => 'Engineering & Technology', 'color' => '#2563eb'],
        'm-tech' => ['icon' => 'fas fa-microchip', 'dept' => 'Engineering & Technology', 'color' => '#4f46e5'],
        'mba' => ['icon' => 'fas fa-briefcase', 'dept' => 'Management Studies', 'color' => '#7c3aed'],
        'bca' => ['icon' => 'fas fa-desktop', 'dept' => 'Computer Applications', 'color' => '#0d9488'],
        'mca' => ['icon' => 'fas fa-network-wired', 'dept' => 'Computer Applications', 'color' => '#0891b2'],
        'library-course' => ['icon' => 'fas fa-book-reader', 'dept' => 'Library & Information Science', 'color' => '#b45309'],
        'computer-science' => ['icon' => 'fas fa-code', 'dept' => 'Computer Science & IT', 'color' => '#475569'],
        'allied-courses' => ['icon' => 'fas fa-atom', 'dept' => 'Allied Sciences & Humanities', 'color' => '#9333ea'],
    ];
    return $meta[$slug] ?? ['icon' => 'fas fa-book-open', 'dept' => 'Academic Studies', 'color' => '#7a0b0d'];
}

/**
 * Fetch dynamic syllabus data organized by categories for frontend and admin
 */
function getDynamicSyllabusData($onlyActive = true) {
    try {
        $pdo = getDBConnection();
        $where = $onlyActive ? "WHERE status = 'active'" : "";
        $stmt = $pdo->query("SELECT * FROM syllabi $where ORDER BY sort_order ASC, id ASC");
        $rows = $stmt->fetchAll();

        if (empty($rows)) {
            // Fallback to static file if table is empty
            if (file_exists(__DIR__ . '/syllabus_data.php')) {
                require __DIR__ . '/syllabus_data.php';
                if (isset($syllabusCategories)) return $syllabusCategories;
            }
            return [];
        }

        $categories = [];
        foreach ($rows as $row) {
            $slug = $row['category_slug'];
            if (!isset($categories[$slug])) {
                $meta = getSyllabusCategoryMeta($slug);
                $categories[$slug] = [
                    'slug' => $slug,
                    'title' => $row['category_title'],
                    'dept' => !empty($row['department']) ? $row['department'] : $meta['dept'],
                    'icon' => $meta['icon'],
                    'color' => $meta['color'],
                    'total_pdfs' => 0,
                    'items' => []
                ];
            }

            $categories[$slug]['items'][] = [
                'id' => (int)$row['id'],
                'title' => $row['title'],
                'type' => $row['type'],
                'filename' => $row['filename'] ?: basename($row['file_path']),
                'local_url' => $row['file_path'],
                'original_url' => $row['original_url'],
                'file_size' => (int)$row['file_size'],
                'status' => $row['status'],
                'sort_order' => (int)$row['sort_order'],
                'exists' => file_exists(dirname(__DIR__) . '/' . ltrim($row['file_path'], '/'))
            ];
            $categories[$slug]['total_pdfs']++;
        }

        return $categories;
    } catch (Exception $e) {
        if (file_exists(__DIR__ . '/syllabus_data.php')) {
            require __DIR__ . '/syllabus_data.php';
            if (isset($syllabusCategories)) return $syllabusCategories;
        }
        return [];
    }
}

/**
 * Get quick count stats for syllabus
 */
function getSyllabusQuickStats() {
    try {
        $pdo = getDBConnection();
        $total = (int)$pdo->query("SELECT COUNT(*) FROM syllabi")->fetchColumn();
        $active = (int)$pdo->query("SELECT COUNT(*) FROM syllabi WHERE status = 'active'")->fetchColumn();
        $schemes = (int)$pdo->query("SELECT COUNT(*) FROM syllabi WHERE type LIKE '%Scheme%'")->fetchColumn();
        $syllabi = (int)$pdo->query("SELECT COUNT(*) FROM syllabi WHERE type LIKE '%Syllabus%'")->fetchColumn();
        $categories = (int)$pdo->query("SELECT COUNT(DISTINCT category_slug) FROM syllabi")->fetchColumn();
        return [
            'total' => $total,
            'active' => $active,
            'schemes' => $schemes,
            'syllabi' => $syllabi,
            'categories' => $categories
        ];
    } catch (Exception $e) {
        return ['total' => 267, 'active' => 267, 'schemes' => 110, 'syllabi' => 157, 'categories' => 19];
    }
}

// -------------------------------------------------------------
// MASTER DATABASE SYNCHRONIZATION & HEALTH ENGINE (1-CLICK SYNC)
// -------------------------------------------------------------

/**
 * Returns diagnostic metadata and health status for the active database connection
 */
function getDatabaseStatusInfo() {
    try {
        $pdo = getDBConnection();
        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        
        $tableCounts = [];
        $totalRows = 0;
        foreach ($tables as $t) {
            try {
                $c = (int)$pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
                $tableCounts[$t] = $c;
                $totalRows += $c;
            } catch (Exception $ex) {
                $tableCounts[$t] = 0;
            }
        }

        return [
            'connected' => true,
            'driver' => $driver,
            'host' => defined('DB_HOST') ? DB_HOST : 'localhost',
            'dbname' => defined('DB_NAME') ? DB_NAME : 'srku_db',
            'tables_count' => count($tables),
            'tables' => $tableCounts,
            'total_rows' => $totalRows,
            'error' => null
        ];
    } catch (Exception $e) {
        return [
            'connected' => false,
            'driver' => 'unknown',
            'host' => defined('DB_HOST') ? DB_HOST : 'localhost',
            'dbname' => defined('DB_NAME') ? DB_NAME : 'srku_db',
            'tables_count' => 0,
            'tables' => [],
            'total_rows' => 0,
            'error' => $e->getMessage()
        ];
    }
}

/**
 * 1-Click Master Database Synchronizer: Migrates schema and populates master DB data
 *
 * @param string $target 'all', 'departments', 'courses', 'faculty', 'syllabi', 'gallery', 'blogs', 'news', 'banners', 'pages', 'settings'
 * @param bool $force If true, truncates/refreshes the table with master data
 * @return array Result report with status and row counts
 */
function syncDatabaseMasterData($target = 'all', $force = false) {
    $report = [
        'success' => true,
        'target' => $target,
        'counts' => [],
        'messages' => [],
        'timestamp' => date('Y-m-d H:i:s')
    ];

    try {
        $pdo = getDBConnection();
        $baseDir = dirname(__DIR__);
        $sqlMasterFile = $baseDir . '/srku_db.sql';
        $masterSql = file_exists($sqlMasterFile) ? file_get_contents($sqlMasterFile) : '';

        // 1. Ensure all schemas and columns are fully created & aligned
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `users` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(50) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                `email` VARCHAR(100),
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `pages` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `slug` VARCHAR(191) NOT NULL UNIQUE,
                `content` LONGTEXT,
                `meta_description` TEXT,
                `banner_title` VARCHAR(255) DEFAULT NULL,
                `banner_subtitle` VARCHAR(255) DEFAULT NULL,
                `banner_img` VARCHAR(255) DEFAULT NULL,
                `status` ENUM('published','draft') DEFAULT 'published',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `departments` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `category` VARCHAR(100) DEFAULT 'General',
                `slug` VARCHAR(191) NOT NULL UNIQUE,
                `icon` VARCHAR(100) DEFAULT 'fas fa-graduation-cap',
                `image` VARCHAR(255) DEFAULT NULL,
                `banner_img` VARCHAR(255),
                `description` LONGTEXT,
                `dean_name` VARCHAR(150),
                `dean_designation` VARCHAR(150) DEFAULT 'Dean & Principal',
                `dean_photo` VARCHAR(255) DEFAULT NULL,
                `dean_message` LONGTEXT DEFAULT NULL,
                `contact_no` VARCHAR(100) DEFAULT '0755-4700983, 7024144981',
                `approvals` VARCHAR(255) DEFAULT 'UGC',
                `established_year` VARCHAR(10),
                `status` ENUM('active','inactive') DEFAULT 'active'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `courses` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `department` VARCHAR(150) NOT NULL,
                `dept_slug` VARCHAR(100),
                `faculty_id` INT DEFAULT NULL,
                `course_name` VARCHAR(255) NOT NULL,
                `slug` VARCHAR(191),
                `level` VARCHAR(50) DEFAULT 'UG',
                `degree_level` VARCHAR(50) DEFAULT NULL,
                `duration` VARCHAR(50),
                `eligibility` TEXT,
                `fees` VARCHAR(100),
                `specializations` TEXT,
                `description` LONGTEXT,
                `career_scope` TEXT,
                `syllabus_url` VARCHAR(255),
                `scheme_url` VARCHAR(255),
                `fees_per_year` VARCHAR(50) DEFAULT 'As per university norms',
                `status` VARCHAR(20) DEFAULT 'active',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `faculty` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `department_name` VARCHAR(255) NOT NULL,
                `dept_slug` VARCHAR(191) NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `designation` VARCHAR(150) NOT NULL,
                `qualification` VARCHAR(255) DEFAULT NULL,
                `experience` VARCHAR(100) DEFAULT NULL,
                `status` ENUM('active','inactive') DEFAULT 'active',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `syllabi` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `category_slug` VARCHAR(100) NOT NULL,
                `category_title` VARCHAR(150) NOT NULL,
                `department` VARCHAR(150) DEFAULT NULL,
                `title` VARCHAR(255) NOT NULL,
                `type` VARCHAR(50) DEFAULT 'Syllabus',
                `file_path` VARCHAR(255) NOT NULL,
                `filename` VARCHAR(255) DEFAULT NULL,
                `original_url` TEXT DEFAULT NULL,
                `file_size` INT DEFAULT 0,
                `status` ENUM('active','inactive') DEFAULT 'active',
                `sort_order` INT DEFAULT 0,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_category` (`category_slug`),
                INDEX `idx_status` (`status`),
                INDEX `idx_type` (`type`),
                INDEX `idx_order` (`sort_order`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `gallery` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `category` VARCHAR(50) DEFAULT 'Campus',
                `image_url` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `blogs` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `slug` VARCHAR(191) NOT NULL UNIQUE,
                `author` VARCHAR(100) NOT NULL DEFAULT 'SRKU Editorial Board',
                `category` VARCHAR(100) NOT NULL DEFAULT 'Campus Life',
                `short_description` TEXT DEFAULT NULL,
                `content` LONGTEXT NOT NULL,
                `image_url` VARCHAR(255) DEFAULT NULL,
                `publish_date` DATE DEFAULT NULL,
                `views` INT DEFAULT 0,
                `status` VARCHAR(20) NOT NULL DEFAULT 'published',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `news` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `slug` VARCHAR(191),
                `content` LONGTEXT,
                `category` VARCHAR(50) DEFAULT 'Announcement',
                `publish_date` DATE,
                `image_url` VARCHAR(255),
                `is_ticker` TINYINT(1) DEFAULT 0,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `banners` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `page_slug` VARCHAR(100) DEFAULT 'home',
                `title` VARCHAR(255) NOT NULL,
                `subtitle` TEXT,
                `image_url` VARCHAR(255),
                `btn_text` VARCHAR(50),
                `btn_link` VARCHAR(255),
                `sort_order` INT DEFAULT 0
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `settings` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `setting_key` VARCHAR(100) NOT NULL UNIQUE,
                `setting_value` TEXT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `enquiries` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `father_name` VARCHAR(150),
                `email` VARCHAR(100) NOT NULL,
                `phone` VARCHAR(20) NOT NULL,
                `course` VARCHAR(150),
                `city` VARCHAR(100),
                `state` VARCHAR(100),
                `source` VARCHAR(150),
                `message` TEXT,
                `status` VARCHAR(50) DEFAULT 'New',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `complaints` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(150) NOT NULL,
                `father_name` VARCHAR(150) NULL,
                `enrollment_number` VARCHAR(100) NULL,
                `email` VARCHAR(150) NOT NULL,
                `phone` VARCHAR(50) NOT NULL,
                `institute_name` VARCHAR(255) NULL,
                `course_name` VARCHAR(255) NULL,
                `year_semester` VARCHAR(100) NULL,
                `complaint_type` VARCHAR(100) NOT NULL DEFAULT 'General',
                `complaint_details` TEXT NOT NULL,
                `status` VARCHAR(50) NOT NULL DEFAULT 'New',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // Schema migrations for legacy/existing tables
        try {
            $bcols = $pdo->query("SHOW COLUMNS FROM `banners`")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('page_slug', $bcols)) $pdo->exec("ALTER TABLE `banners` ADD `page_slug` VARCHAR(100) DEFAULT 'home' AFTER `id`");

            $pcols = $pdo->query("SHOW COLUMNS FROM `pages`")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('banner_title', $pcols)) $pdo->exec("ALTER TABLE `pages` ADD `banner_title` VARCHAR(255) DEFAULT NULL");
            if (!in_array('banner_subtitle', $pcols)) $pdo->exec("ALTER TABLE `pages` ADD `banner_subtitle` VARCHAR(255) DEFAULT NULL");
            if (!in_array('banner_img', $pcols)) $pdo->exec("ALTER TABLE `pages` ADD `banner_img` VARCHAR(255) DEFAULT NULL");

            $ccols = $pdo->query("SHOW COLUMNS FROM `courses`")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('faculty_id', $ccols)) $pdo->exec("ALTER TABLE `courses` ADD `faculty_id` INT NULL AFTER `dept_slug`");
            if (!in_array('degree_level', $ccols)) $pdo->exec("ALTER TABLE `courses` ADD `degree_level` VARCHAR(50) NULL AFTER `level`");
            if (!in_array('fees_per_year', $ccols)) $pdo->exec("ALTER TABLE `courses` ADD `fees_per_year` VARCHAR(50) DEFAULT 'As per university norms' AFTER `scheme_url`");
            if (!in_array('created_at', $ccols)) $pdo->exec("ALTER TABLE `courses` ADD `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER `status`");

            $dcols = $pdo->query("SHOW COLUMNS FROM `departments`")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('category', $dcols)) $pdo->exec("ALTER TABLE `departments` ADD `category` VARCHAR(100) DEFAULT 'General' AFTER `name`");
            if (!in_array('image', $dcols)) $pdo->exec("ALTER TABLE `departments` ADD `image` VARCHAR(255) DEFAULT NULL AFTER `icon`");
            if (!in_array('dean_designation', $dcols)) $pdo->exec("ALTER TABLE `departments` ADD `dean_designation` VARCHAR(150) DEFAULT 'Dean & Principal' AFTER `dean_name`");
            if (!in_array('dean_photo', $dcols)) $pdo->exec("ALTER TABLE `departments` ADD `dean_photo` VARCHAR(255) DEFAULT NULL AFTER `dean_designation`");
            if (!in_array('dean_message', $dcols)) $pdo->exec("ALTER TABLE `departments` ADD `dean_message` LONGTEXT DEFAULT NULL AFTER `dean_photo`");
            if (!in_array('contact_no', $dcols)) $pdo->exec("ALTER TABLE `departments` ADD `contact_no` VARCHAR(100) DEFAULT '0755-4700983, 7024144981' AFTER `dean_name`");
            if (!in_array('approvals', $dcols)) $pdo->exec("ALTER TABLE `departments` ADD `approvals` VARCHAR(255) DEFAULT 'UGC' AFTER `contact_no`");
        } catch (Exception $e) {}

        // 2. SYLLABI (267 items from syllabus_data.php)
        if ($target === 'all' || $target === 'syllabi') {
            $currSylCount = (int)$pdo->query("SELECT COUNT(*) FROM `syllabi`")->fetchColumn();
            if ($currSylCount < 250 || $force) {
                $syllabiFile = $baseDir . '/includes/syllabus_data.php';
                if (file_exists($syllabiFile)) {
                    require $syllabiFile;
                    if (isset($syllabusCategories) && is_array($syllabusCategories)) {
                        $pdo->exec("TRUNCATE TABLE `syllabi`");
                        $insSyl = $pdo->prepare("INSERT INTO `syllabi` (`category_slug`, `category_title`, `department`, `title`, `type`, `file_path`, `filename`, `original_url`, `file_size`, `status`, `sort_order`) VALUES (:cat_slug, :cat_title, :dept, :title, :type, :file_path, :filename, :original_url, :file_size, :status, :sort_order)");
                        
                        $sylCount = 0;
                        $order = 1;
                        foreach ($syllabusCategories as $catSlug => $cat) {
                            $catTitle = $cat['title'] ?? ucfirst(str_replace('-', ' ', $catSlug));
                            $dept = $cat['dept'] ?? 'General';
                            if (!empty($cat['items'])) {
                                foreach ($cat['items'] as $item) {
                                    $insSyl->execute([
                                        ':cat_slug' => $catSlug,
                                        ':cat_title' => $catTitle,
                                        ':dept' => $dept,
                                        ':title' => $item['title'],
                                        ':type' => $item['type'] ?? 'Syllabus',
                                        ':file_path' => $item['local_url'] ?? '',
                                        ':filename' => $item['filename'] ?? basename($item['local_url'] ?? ''),
                                        ':original_url' => $item['original_url'] ?? '',
                                        ':file_size' => (int)($item['file_size'] ?? 0),
                                        ':status' => 'active',
                                        ':sort_order' => $order++
                                    ]);
                                    $sylCount++;
                                }
                            }
                        }
                        $report['counts']['syllabi'] = $sylCount;
                        $report['messages'][] = "Syllabus & Schemes synchronized ($sylCount items).";
                    }
                }
            } else {
                $report['counts']['syllabi'] = $currSylCount;
            }
        }

        // 3. FACULTY (1,074 entries from master SQL)
        if ($target === 'all' || $target === 'faculty') {
            $currFacCount = (int)$pdo->query("SELECT COUNT(*) FROM `faculty`")->fetchColumn();
            if ($currFacCount < 500 || $force) {
                if ($masterSql && preg_match_all('/INSERT INTO `faculty`[^\;]+;/s', $masterSql, $matches)) {
                    $pdo->exec("TRUNCATE TABLE `faculty`");
                    foreach ($matches[0] as $stmt) {
                        $pdo->exec($stmt);
                    }
                    $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `faculty`")->fetchColumn();
                    $report['counts']['faculty'] = $newCount;
                    $report['messages'][] = "Faculty Directory synchronized ($newCount members).";
                }
            } else {
                $report['counts']['faculty'] = $currFacCount;
            }
        }

        // 4. DEPARTMENTS (All 26 Constituent Colleges & Units)
        if ($target === 'all' || $target === 'departments') {
            $currDeptCount = (int)$pdo->query("SELECT COUNT(*) FROM `departments`")->fetchColumn();
            if ($currDeptCount < 20 || $force) {
                if ($masterSql && preg_match('/INSERT INTO `departments`[^\;]+;/s', $masterSql, $m)) {
                    $pdo->exec("TRUNCATE TABLE `departments`");
                    $pdo->exec($m[0]);
                    $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `departments`")->fetchColumn();
                    $report['counts']['departments'] = $newCount;
                    $report['messages'][] = "Constituent Units & Departments synchronized ($newCount colleges).";
                }
            } else {
                $report['counts']['departments'] = $currDeptCount;
            }

            // Auto-link constituent unit images from assets/uploads/constituent-units/{slug}.webp
            $allDepts = $pdo->query("SELECT id, slug, image, banner_img FROM `departments`")->fetchAll(PDO::FETCH_ASSOC);
            $syncStmt = $pdo->prepare("UPDATE `departments` SET image = :img, banner_img = :bimg WHERE id = :id");
            foreach ($allDepts as $ad) {
                $candPath = 'assets/uploads/constituent-units/' . $ad['slug'] . '.webp';
                if (file_exists($baseDir . '/' . $candPath)) {
                    $currImg = $ad['image'] ?? '';
                    $currBanner = $ad['banner_img'] ?? '';
                    if (empty($currImg) || strpos($currImg, '001.webp') !== false || strpos($currImg, 'dept_') !== false || empty($currBanner)) {
                        $syncStmt->execute([
                            ':img' => $candPath,
                            ':bimg' => $candPath,
                            ':id' => $ad['id']
                        ]);
                    }
                }
            }
        }

        // 5. COURSES (All 95 Academic Degree & Diploma Programs)
        if ($target === 'all' || $target === 'courses') {
            $currCourseCount = (int)$pdo->query("SELECT COUNT(*) FROM `courses`")->fetchColumn();
            if ($currCourseCount < 50 || $force) {
                if ($masterSql && preg_match_all('/INSERT INTO `courses`[^\;]+;/s', $masterSql, $m2)) {
                    $pdo->exec("TRUNCATE TABLE `courses`");
                    foreach ($m2[0] as $stmt) {
                        $pdo->exec($stmt);
                    }
                    $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `courses`")->fetchColumn();
                    $report['counts']['courses'] = $newCount;
                    $report['messages'][] = "Courses & Academic Catalog synchronized ($newCount courses).";
                }
            } else {
                $report['counts']['courses'] = $currCourseCount;
            }
        }

        // 6. GALLERY (All 71 WebP Photos)
        if ($target === 'all' || $target === 'gallery') {
            $currGalCount = (int)$pdo->query("SELECT COUNT(*) FROM `gallery`")->fetchColumn();
            if ($currGalCount < 70 || $force) {
                $pdo->exec("TRUNCATE TABLE `gallery`");
                $webpDir = $baseDir . '/assets/uploads/gallery/webp/';
                if (is_dir($webpDir)) {
                    $files = glob($webpDir . '*.webp');
                    $insGal = $pdo->prepare("INSERT INTO `gallery` (`title`, `category`, `image_url`) VALUES (:t, :c, :img)");
                    $gCount = 0;
                    foreach ($files as $f) {
                        $bn = basename($f);
                        $cat = 'Campus';
                        if (strpos($bn, 'gym') !== false || in_array($bn, ['dsc06520.webp','dsc06574.webp','dsc06575.webp','dsc06576.webp','dsc06577.webp','dsc06586.webp','dsc06587.webp','dsc06588.webp','dsc06600.webp','dsc06603.webp','dsc06605.webp','dsc06607.webp','dsc06609.webp','dsc06611.webp','dsc06612.webp','dsc06614.webp','dsc06615.webp','dsc06617.webp','dsc06618.webp','dsc06619.webp','dsc06622.webp','dsc06623.webp'])) {
                            $cat = 'Gym';
                        } elseif (strpos($bn, 'sport') !== false || in_array($bn, ['dsc06517.webp','dsc06525.webp','dsc06527.webp','dsc06528.webp','dsc06533.webp','dsc06534.webp','dsc06537.webp','dsc06538.webp','dsc06539.webp','dsc06540.webp','dsc06541.webp','dsc06542.webp','dsc06547.webp','dsc06548.webp','dsc06554.webp','dsc06578.webp','dsc06579.webp','dsc06580.webp','dsc06582.webp','dsc06583.webp'])) {
                            $cat = 'Sports';
                        } elseif (strpos($bn, 'med') !== false || strpos($bn, 'hosp') !== false || in_array($bn, ['dsc06740.webp','dsc06754.webp','dsc06767.webp','dsc06769.webp','dsc06772.webp','dsc06839.webp','dsc06842.webp','dsc06847.webp','dsc06857.webp'])) {
                            $cat = 'Medical';
                        }
                        $insGal->execute([
                            ':t' => 'SRKU Campus & Infrastructure Photo',
                            ':c' => $cat,
                            ':img' => 'assets/uploads/gallery/webp/' . $bn
                        ]);
                        $gCount++;
                    }
                    $report['counts']['gallery'] = $gCount;
                    $report['messages'][] = "Photo Gallery synchronized ($gCount photos).";
                }
            } else {
                $report['counts']['gallery'] = $currGalCount;
            }
        }

        // 7. BLOGS (6 Master Articles)
        if ($target === 'all' || $target === 'blogs') {
            $currBlogCount = (int)$pdo->query("SELECT COUNT(*) FROM `blogs`")->fetchColumn();
            if ($currBlogCount == 0 || $force) {
                $pdo->exec("TRUNCATE TABLE `blogs`");
                $blogsMaster = [
                    [
                        'Tarang 2026: Annual Inter-University Cultural & Sports Extravaganza',
                        'tarang-annual-fest-2026',
                        'Student Affairs Committee',
                        'Campus Life',
                        'A grand 3-day carnival bringing together over 5,000 students across central India for national-level music, dance, hackathons, and athletic tournaments.',
                        '<p>Sarvepalli Radhakrishnan University (SRKU) celebrated its flagship annual inter-university cultural and athletic fest, <strong>Tarang 2026</strong>, with unprecedented zeal and grandeur on the lush green Bhopal campus. Spanning over three high-octane days, the mega event witnessed enthusiastic participation from more than 45 colleges and universities across India.</p><h3>Electrifying Events & Competitions</h3><p>The cultural fest featured a diverse array of competitive events covering fine arts, classical dance, battle of the bands, street plays (Nukkad Natak), fashion parade, and a 24-hour national hackathon organized by the Department of Computer Science & Engineering.</p><ul><li><strong>National Hackathon 2026:</strong> Over 120 tech teams developed AI-driven sustainable solutions for rural agriculture and healthcare robotics.</li><li><strong>Battle of Bands:</strong> High-voltage rock and classical fusion performances judged by national celebrity musicians.</li><li><strong>Sports Championships:</strong> Inter-collegiate tournaments in Cricket, Basketball, Football, Volleyball, and Badminton.</li></ul><p>The fest concluded with a mega celebrity concert, laser show, and an award distribution ceremony where outstanding student performers were awarded trophies and cash prizes worth ₹5 Lakhs.</p>',
                        'assets/uploads/2026/07/001.webp',
                        '2026-08-15',
                        7
                    ],
                    [
                        'International Conference on Emerging Horizons in AI, Machine Learning & Drug Discovery',
                        'international-conference-ai-drug-discovery',
                        'Faculty of Engineering & Pharmacy',
                        'Research & Tech',
                        'Renowned scientists, pharmacologists, and AI researchers from 12 countries convened at SRKU to explore computational biotechnology and automated healthcare diagnostics.',
                        '<p>The Faculty of Engineering & Technology and Sri Sai College of Pharmacy at SRKU successfully hosted a two-day <strong>International Conference on Artificial Intelligence and Bio-Pharmaceutical Innovation (ICABPI 2026)</strong> in hybrid mode.</p><h3>Highlights of the Research Summit</h3><p>The conference brought together distinguished keynote speakers from premier global institutions, including IITs, AIIMS, and top pharmaceutical R&D labs from the USA, Germany, and Japan.</p><blockquote>\"The convergence of generative AI algorithms and molecular docking is drastically reducing drug discovery cycles from 10 years to mere months,\" remarked the keynote speaker during the inaugural address.</blockquote><p>Over 140 peer-reviewed research papers were presented by Ph.D. scholars, faculty members, and industrial researchers. All accepted manuscripts will be published in Scopus-indexed and UGC-CARE approved journals.</p>',
                        'assets/uploads/2026/07/002.webp',
                        '2026-08-10',
                        1
                    ],
                    [
                        'National Campus Placement Drive 2026: Record Offers & Highest Package of ₹12 LPA',
                        'national-campus-placement-drive-2026',
                        'Central Training & Placement Cell',
                        'Placements',
                        'Over 500 marquee recruiters including TCS, Wipro, Infosys, Sun Pharma, Cipla, and Tech Mahindra recruited graduating batches across technical and medical streams.',
                        '<p>The Training and Placement Cell (T&P) at Sarvepalli Radhakrishnan University announced record-shattering outcomes for the 2026 graduating batch. With over 85 corporate recruiters visiting the campus in Phase-I alone, more than 820 job offers were extended to students across engineering, management, pharmacy, paramedical, and agriculture disciplines.</p><h3>Key Placement Highlights 2026</h3><ul><li><strong>Highest Package:</strong> ₹12.00 LPA secured by B.Tech CSE students in AI Product Engineering.</li><li><strong>Average Package:</strong> Significant 28% year-on-year jump reaching ₹5.20 LPA.</li><li><strong>Top Recruiting Partners:</strong> TCS, Infosys, Wipro, Cipla, Lupin, Sun Pharma, HCL Technologies, ICICI Bank, and Byju’s.</li></ul><p>SRKU’s dedicated corporate relations division provides rigorous pre-placement grooming including mock interviews, coding bootcamps, resume review clinics, and soft-skill development modules starting from the 3rd year.</p>',
                        'assets/uploads/2026/07/003.webp',
                        '2026-08-05',
                        1
                    ],
                    [
                        'Admissions Open 2026-27: Comprehensive Career Guide to 95+ Degree Programs',
                        'admissions-open-academic-session-2026-27',
                        'Office of Academic Admissions',
                        'Admissions',
                        'Explore premier academic pathways across Engineering, Medical, Dental, Ayurveda, Homoeopathy, Law, Nursing, Agriculture, and Management with merit scholarships.',
                        '<p>Sarvepalli Radhakrishnan University (SRKU), Bhopal announces the commencement of online and campus admissions for the upcoming academic session <strong>2026-27</strong>. Applications are invited for over 95 multidisciplinary undergraduate, postgraduate, integrated, diploma, and doctoral (Ph.D.) programs.</p><h3>Why Choose SRK University?</h3><p>Recognized by UGC under Section 2(f) of the UGC Act 1956 and approved by statutory national councils (NMC, DCI, NCISM, NCH, AICTE, PCI, BCI, INC), the university offers modern experiential education backed by:</p><ul><li>750-Bed Teaching Multi-Specialty Hospital for live medical internships.</li><li>42+ State-of-the-Art Research Laboratories & High-Performance Computing Centers.</li><li>Merit Scholarships for meritorious students, sports champions, and reserved category candidates.</li><li>On-campus hostel accommodations, gymnasiums, sports arenas, and university-wide bus transportation.</li></ul><p>Interested candidates can apply online directly through the university website or visit the central counseling center at the Bhopal campus.</p>',
                        'assets/uploads/2026/07/004.webp',
                        '2026-08-01',
                        0
                    ],
                    [
                        'Modern Advancements in Ayurvedic & Integrative Medicine: SRKU Hospital Insights',
                        'advancements-ayurvedic-integrative-medicine',
                        'SRK College of Ayurveda Hospital',
                        'Medical & Health',
                        'How ancient Ayurvedic wisdom and modern clinical diagnostics combine to deliver holistic wellness and effective chronic disease management.',
                        '<p>The Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre is leading the paradigm shift towards evidence-based integrative healthcare in Central India. Combining ancient Panchakarma therapies with state-of-the-art diagnostic imaging and pathology labs, the 100-bed Ayurvedic hospital treats over 200 patients daily.</p><h3>Specialized Treatment Wings</h3><ul><li><strong>Kayachikitsa (Internal Medicine):</strong> Holistic management of metabolic, joint, and chronic lifestyle disorders.</li><li><strong>Panchakarma Center:</strong> Specialized detoxification treatments including Vamana, Virechana, Basti, Nasya, and Raktamokshana.</li><li><strong>Shalya Tantra:</strong> Advanced Kshara Sutra therapy for anorectal ailments with zero recurrence.</li></ul><p>Students of BAMS and MD Ayurveda receive direct hands-on clinical rotations under senior Ayurvedic doctors and clinical researchers.</p>',
                        'assets/uploads/2026/07/001.webp',
                        '2026-07-25',
                        0
                    ],
                    [
                        'Sustainable Smart Agriculture & Drone Technology in Precision Farming',
                        'sustainable-smart-agriculture-drone-technology',
                        'Faculty of Agriculture',
                        'Agriculture & Bio',
                        'SRKU Faculty of Agriculture integrates IoT soil sensors, automated drip irrigation, and aerial drone surveillance across its 50-acre experiential farm.',
                        '<p>The Faculty of Agriculture at SRKU is transforming traditional agricultural education into high-tech sustainable agri-business. With 50+ acres of dedicated experimental farms, polyhouses, and vermicompost units, students gain firsthand experience in organic cultivation, seed technology, and drone-assisted crop monitoring.</p><h3>Key Training Verticals</h3><ul><li><strong>Precision Spraying:</strong> Agricultural drones for micro-nutrient spraying and pest infestation scanning.</li><li><strong>Hydroponics & Greenhouses:</strong> Soil-less vegetable cultivation and climate-controlled floriculture.</li><li><strong>Soil Health Laboratories:</strong> Rapid testing of NPK ratios and organic carbon levels for local farmers.</li></ul><p>Graduates from B.Sc. (Hons) Agriculture secure prestigious roles in NABARD, IFFCO, agrochemical multinationals, and state agricultural departments.</p>',
                        'assets/uploads/2026/07/002.webp',
                        '2026-07-18',
                        3
                    ]
                ];
                $insBlog = $pdo->prepare("INSERT INTO `blogs` (`title`, `slug`, `author`, `category`, `short_description`, `content`, `image_url`, `publish_date`, `views`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'published')");
                foreach ($blogsMaster as $b) {
                    $insBlog->execute($b);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `blogs`")->fetchColumn();
                $report['counts']['blogs'] = $newCount;
                $report['messages'][] = "Blogs & Research Articles synchronized ($newCount articles).";
            } else {
                $report['counts']['blogs'] = $currBlogCount;
            }
        }

        // 8. NEWS & NOTICES
        if ($target === 'all' || $target === 'news') {
            $currNewsCount = (int)$pdo->query("SELECT COUNT(*) FROM `news`")->fetchColumn();
            if ($currNewsCount == 0 || $force) {
                $pdo->exec("TRUNCATE TABLE `news`");
                $newsMaster = [
                    ['Admissions Open for Academic Session 2026-27', 'admissions-open-2026', 'Applications are invited for UG, PG, Diploma, and Ph.D. programs across Engineering, Pharmacy, Nursing, Management, Agriculture, Law, and Medicine.', 'Admission', '2026-08-01', 'assets/images/news1.jpg', 1],
                    ['National Campus Placement Drive 2026 - Highest Package 12 LPA', 'placement-drive-2026', 'Top tier recruiters including TCS, Wipro, Infosys, Cipla, and Sun Pharma participated in the annual mega placement drive.', 'Placement', '2026-08-05', 'assets/images/news2.jpg', 1],
                    ['International Conference on Advanced Research in Pharmaceuticals & AI', 'intl-conference-2026', 'SRKU hosted delegates from 12 countries to discuss AI in drug discovery and sustainable energy.', 'Event', '2026-08-10', 'assets/images/news3.jpg', 0],
                    ['Tarang 2026 - Annual Inter-University Sports & Cultural Fest Announced', 'tarang-annual-fest-2026', 'Three days of vibrant cultural performances, sports tournaments, and tech competitions.', 'Campus Life', '2026-08-15', 'assets/images/news4.jpg', 0]
                ];
                $insNews = $pdo->prepare("INSERT INTO `news` (`title`, `slug`, `content`, `category`, `publish_date`, `image_url`, `is_ticker`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                foreach ($newsMaster as $n) {
                    $insNews->execute($n);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `news`")->fetchColumn();
                $report['counts']['news'] = $newCount;
                $report['messages'][] = "News & Notices synchronized ($newCount items).";
            } else {
                $report['counts']['news'] = $currNewsCount;
            }
        }

        // 9. BANNERS & SLIDERS
        if ($target === 'all' || $target === 'banners') {
            $currBannerCount = (int)$pdo->query("SELECT COUNT(*) FROM `banners`")->fetchColumn();
            if ($currBannerCount == 0 || $force) {
                $pdo->exec("TRUNCATE TABLE `banners`");
                $bannersMaster = [
                    ['home', 'Welcome to SRK University, Bhopal', 'UGC-Recognized Premier University in MP offering Engineering, Pharmacy, Medicine & Management', 'assets/images/banner1.jpg', 'Apply Now', 'admission-enquiry.php', 1],
                    ['home', 'Excellence in Research & 94% Placements', '42+ High-Tech Labs with 120+ Top Recruiter Partnerships', 'assets/images/banner2.jpg', 'Explore Courses', 'courses.php', 2],
                    ['home', 'State-of-the-Art Multi-Disciplinary Campus', 'Spread over lush green campus with 750+ Bed Teaching Hospital & Sports Complex', 'assets/images/banner3.jpg', 'Campus Tour', 'facilities.php', 3]
                ];
                $insBanner = $pdo->prepare("INSERT INTO `banners` (`page_slug`, `title`, `subtitle`, `image_url`, `btn_text`, `btn_link`, `sort_order`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                foreach ($bannersMaster as $b) {
                    $insBanner->execute($b);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `banners`")->fetchColumn();
                $report['counts']['banners'] = $newCount;
                $report['messages'][] = "Banners & Sliders synchronized ($newCount banners).";
            } else {
                $report['counts']['banners'] = $currBannerCount;
            }
        }

        // 10. DYNAMIC PAGES
        if ($target === 'all' || $target === 'pages') {
            $currPagesCount = (int)$pdo->query("SELECT COUNT(*) FROM `pages`")->fetchColumn();
            if ($currPagesCount == 0 || $force) {
                $pdo->exec("TRUNCATE TABLE `pages`");
                $pagesMaster = [
                    [
                        'Why SRK University',
                        'why-srk',
                        '<div class="why-srk-content"><h2 class="text-maroon fw-bold mb-4">Why Choose Sarvepalli Radhakrishnan University, Bhopal?</h2><p class="lead text-dark">Sarvepalli Radhakrishnan University (SRKU) is Central India\'s premier academic and research powerhouse, established by Madhya Pradesh Niji Vishwavidyalaya Act and recognized by the University Grants Commission (UGC) under Section 2(f).</p><div class="row g-4 my-4"><div class="col-md-6"><div class="p-4 bg-light rounded-4 border-start border-4 border-danger h-100"><h4 class="text-navy fw-bold"><i class="fas fa-microscope text-danger me-2"></i> 42+ Modern Laboratories</h4><p class="text-muted mb-0">High-end computing labs, pharmaceutical analysis suites, robotic testbeds, agricultural experimental farms, and clinical simulation centers.</p></div></div><div class="col-md-6"><div class="p-4 bg-light rounded-4 border-start border-4 border-danger h-100"><h4 class="text-navy fw-bold"><i class="fas fa-briefcase text-danger me-2"></i> 94% Placement Record</h4><p class="text-muted mb-0">Strong industry linkages with 120+ MNC recruiting partners delivering highest package of 12 LPA and consistent corporate placements.</p></div></div><div class="col-md-6"><div class="p-4 bg-light rounded-4 border-start border-4 border-danger h-100"><h4 class="text-navy fw-bold"><i class="fas fa-user-graduate text-danger me-2"></i> Multi-Disciplinary Ecosystem</h4><p class="text-muted mb-0">Over 90+ degree programs spanning Engineering, Pharmacy, Medicine, Nursing, Management, Law, Agriculture, and Paramedical Sciences.</p></div></div><div class="col-md-6"><div class="p-4 bg-light rounded-4 border-start border-4 border-danger h-100"><h4 class="text-navy fw-bold"><i class="fas fa-hospital-user text-danger me-2"></i> 750+ Bed Teaching Hospital</h4><p class="text-muted mb-0">On-campus super-specialty hospital providing live hands-on clinical exposure for medical, nursing, and paramedical students.</p></div></div></div></div>',
                        'Why Choose Sarvepalli Radhakrishnan University Bhopal - 42+ Labs, 94% Placement Record, UGC Recognized',
                        'Why Choose Sarvepalli Radhakrishnan University',
                        'Academic Excellence, Innovative Research & Industry-Ready Placements',
                        'assets/uploads/2026/07/001.webp'
                    ],
                    [
                        'Vision & Mission',
                        'vision-mission',
                        '<div class="vision-mission-content"><div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-light"><div class="d-flex align-items-center gap-3 mb-3"><div class="bg-danger-subtle text-danger rounded-circle p-3"><i class="fas fa-eye fa-2x"></i></div><h2 class="text-maroon fw-bold mb-0">Our Vision</h2></div><p class="text-dark lead mb-0">"To emerge as a premier global university dedicated to value-based technical, medical, and higher education, pioneering groundbreaking research, fostering innovation, and empowering students with ethical leadership to transform society."</p></div><div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-light"><div class="d-flex align-items-center gap-3 mb-3"><div class="bg-danger-subtle text-danger rounded-circle p-3"><i class="fas fa-bullseye fa-2x"></i></div><h2 class="text-navy fw-bold mb-0">Our Mission</h2></div><ul class="list-unstyled d-flex flex-column gap-3 mb-0 text-dark" style="font-size:1.05rem;"><li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Quality Education:</strong> Imparting experiential and industry-relevant education that nurtures critical thinking, technical proficiency, and creative innovation.</li><li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Research & Development:</strong> Fostering an interdisciplinary research ecosystem to address national and global societal challenges.</li><li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Industry Integration:</strong> Collaborating with leading global corporations and research institutions for curriculum alignment and student career advancement.</li><li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Ethical Character:</strong> Inculcating moral integrity, environmental sustainability, social responsibility, and national values in future leaders.</li></ul></div></div>',
                        'Vision and Mission of Sarvepalli Radhakrishnan University Bhopal',
                        'Our Vision & Strategic Mission',
                        'Pioneering Groundbreaking Research, Experiential Learning & Ethical Leadership',
                        'assets/uploads/2026/07/002.webp'
                    ],
                    [
                        'Statutory Accreditations & Approvals',
                        'accreditation',
                        '<div class="accreditation-content"><h2 class="text-maroon fw-bold mb-3">Statutory Approvals & Accreditations</h2><p class="lead text-muted mb-4">Sarvepalli Radhakrishnan University is established by Madhya Pradesh Act No. 17 of 2015 and duly recognized by the University Grants Commission (UGC) under section 2(f) of the UGC Act, 1956.</p></div>',
                        'Statutory Approvals and Accreditations - UGC, AICTE, PCI, INC, BCI, NMC',
                        'Accreditation & Statutory Approvals',
                        'Recognized by UGC, AICTE, PCI, INC, BCI, NMC, DCI & NCISM',
                        'assets/uploads/2026/07/003.webp'
                    ],
                    [
                        'Board of Management',
                        'board-of-management',
                        '<div class="board-content"><h2 class="text-maroon fw-bold mb-4">Board of Management & University Leadership</h2><p class="text-muted mb-4">The governance of Sarvepalli Radhakrishnan University is overseen by visionary academicians, eminent scientists, and administrators committed to institutional excellence.</p></div>',
                        'Board of Management and Key Governance Officers of SRKU Bhopal',
                        'Board of Management & Leadership',
                        'Eminent Academicians, Scientists & Visionary Leadership',
                        'assets/uploads/2026/07/004.webp'
                    ],
                    [
                        'Constituent Units & Colleges',
                        'constituent-unit',
                        '<div class="units-content"><h2 class="text-maroon fw-bold mb-4">Constituent Colleges & Schools of SRKU</h2><p class="lead text-muted mb-4">The university houses dedicated constituent institutes offering specialized degree and research programs with world-class faculty and facilities.</p></div>',
                        'Constituent Colleges and Schools of Sarvepalli Radhakrishnan University',
                        'Constituent Colleges & Schools',
                        '26 Recognized Academic Units Offering 90+ Degree Programmes',
                        'assets/uploads/2026/07/001.webp'
                    ],
                    [
                        'Admission Guidelines',
                        'admission',
                        '<div class="admission-content"><h2 class="text-maroon fw-bold mb-3">Admission Guidelines 2026-27</h2><p class="lead text-muted mb-4">Admissions at Sarvepalli Radhakrishnan University are transparent, merit-based, and aligned with statutory regulatory norms.</p></div>',
                        'SRKU Admission Process, Guidelines and Eligibility 2026-27',
                        'Admission Guidelines 2026-27',
                        'Simple, Transparent & Merit-Based Admissions Across All Streams',
                        'assets/uploads/2026/07/002.webp'
                    ]
                ];
                $insPage = $pdo->prepare("INSERT INTO `pages` (`title`, `slug`, `content`, `meta_description`, `banner_title`, `banner_subtitle`, `banner_img`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, 'published')");
                foreach ($pagesMaster as $p) {
                    $insPage->execute($p);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `pages`")->fetchColumn();
                $report['counts']['pages'] = $newCount;
                $report['messages'][] = "Dynamic Pages synchronized ($newCount pages).";
            } else {
                $report['counts']['pages'] = $currPagesCount;
            }
        }

        // 11. SETTINGS & SITE CONFIGURATIONS
        if ($target === 'all' || $target === 'settings') {
            $defaultSettings = [
                'site_title' => 'Sarvepalli Radhakrishnan University (SRKU), Bhopal',
                'helpline' => '0755 - 4911204',
                'email' => 'exam@srku.edu.in',
                'admissions_phone' => '+91 755 4911204 / 94250 12345',
                'address' => 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026',
                'ticker_text' => 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for UG, PG & PhD Programs in Engineering, Pharmacy, Management & Medicine | 94% Placement Record',
                'highest_package' => '12 LPA',
                'placement_record' => '94%',
                'recruiting_partners' => '120+',
                'total_labs' => '42+',
                'facebook_url' => 'https://facebook.com/srku.bhopal',
                'instagram_url' => 'https://instagram.com/srku.bhopal',
                'youtube_url' => 'https://youtube.com/@srkuniversity',
                'linkedin_url' => 'https://linkedin.com/school/srk-university'
            ];
            $insSetting = $pdo->prepare("INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES (:k, :v) ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`)");
            $sCount = 0;
            foreach ($defaultSettings as $sk => $sv) {
                $insSetting->execute([':k' => $sk, ':v' => $sv]);
                $sCount++;
            }
            $report['counts']['settings'] = (int)$pdo->query("SELECT COUNT(*) FROM `settings`")->fetchColumn();
            $report['messages'][] = "Global University Settings synchronized ($sCount settings verified).";
        }

        // 12. ADMIN USERS
        if ($target === 'all' || $target === 'users') {
            $adminCount = (int)$pdo->query("SELECT COUNT(*) FROM `users` WHERE username = 'admin'")->fetchColumn();
            if ($adminCount == 0) {
                $passHash = password_hash('admin123', PASSWORD_DEFAULT);
                $insUser = $pdo->prepare("INSERT INTO `users` (`username`, `password`, `email`) VALUES ('admin', :p, 'admin@srku.edu.in')");
                $insUser->execute([':p' => $passHash]);
                $report['messages'][] = "Default Admin User initialized (admin / admin123).";
            }
            $report['counts']['users'] = (int)$pdo->query("SELECT COUNT(*) FROM `users`")->fetchColumn();
        }

        return $report;
    } catch (Exception $e) {
        return [
            'success' => false,
            'target' => $target,
            'counts' => [],
            'error' => $e->getMessage(),
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
}
