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
            'allied'     => 'department-of-paramedical-sciences',
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

