<?php
require_once __DIR__ . '/../config/db.php';

// Sanitize user inputs
function sanitize($data) {
    if ($data === null) return '';
    return htmlspecialchars(trim((string)$data), ENT_QUOTES, 'UTF-8', false);
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

// Fetch JSON setting as array
function getJsonSetting($key, $default = []) {
    $val = getSetting($key, '');
    if (empty($val)) return $default;
    $decoded = json_decode($val, true);
    return is_array($decoded) ? $decoded : $default;
}

// Fetch Board of Management members
function getBoardMembers($status = 'active') {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM board_members WHERE status = :st ORDER BY sort_order ASC, id ASC");
        $stmt->execute([':st' => $status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}

// Fetch Exam Timetables
function getExamTimetables($category = '', $search = '', $status = 'active') {
    try {
        $pdo = getDBConnection();
        $sql = "SELECT * FROM exam_timetables WHERE 1=1";
        $params = [];
        if (!empty($status)) {
            $sql .= " AND status = :st";
            $params[':st'] = $status;
        }
        if (!empty($category)) {
            $sql .= " AND category = :cat";
            $params[':cat'] = $category;
        }
        if (!empty($search)) {
            $sql .= " AND (course_title LIKE :s OR details LIKE :s)";
            $params[':s'] = '%' . $search . '%';
        }
        $sql .= " ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}

// Fetch Campus Facilities
function getCampusFacilities($status = 'active') {
    try {
        $pdo = getDBConnection();
        $sql = "SELECT * FROM facilities";
        $params = [];
        if (!empty($status)) {
            $sql .= " WHERE status = :st";
            $params[':st'] = $status;
        }
        $sql .= " ORDER BY sort_order ASC, id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}

// Fetch Accreditations & Approvals
function getAccreditations($status = 'active') {
    try {
        $pdo = getDBConnection();
        $sql = "SELECT * FROM accreditations";
        $params = [];
        if (!empty($status)) {
            $sql .= " WHERE status = :st";
            $params[':st'] = $status;
        }
        $sql .= " ORDER BY sort_order ASC, id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}

// Fetch Incubation Center Advisory / Team Members
function getIncubationMembers($status = 'active') {
    try {
        $pdo = getDBConnection();
        $sql = "SELECT * FROM incubation_members";
        $params = [];
        if (!empty($status)) {
            $sql .= " WHERE status = :st";
            $params[':st'] = $status;
        }
        $sql .= " ORDER BY sort_order ASC, id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}

// Fetch Corporate Placement Partners
function getPlacementCompanies($status = 1) {
    try {
        $pdo = getDBConnection();
        $sql = "SELECT * FROM placements";
        $params = [];
        if ($status !== null && $status !== '') {
            $sql .= " WHERE status = :st";
            $params[':st'] = $status;
        }
        $sql .= " ORDER BY sort_order ASC, id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}


// Standardized University Statistics
function getUniversityStats() {
    return [
        'students'    => getSetting('stat_students', '20,000+'),
        'faculty'     => getSetting('stat_faculty', '600+'),
        'alumni'      => getSetting('stat_alumni', '1,10,000+'),
        'programs'    => getSetting('stat_programs', '120+'),
        'papers'      => getSetting('stat_papers', '1,400+'),
        'partners'    => getSetting('stat_partners', '42+'),
        'placements'  => getSetting('stat_placements', '35,000+'),
        'years'       => getSetting('stat_years', '31st Year'),
        'units'       => getSetting('stat_units', '14'),
        'acres'       => getSetting('stat_campus_acres', '100+ Acres'),
        'hospital_beds' => getSetting('stat_hospital_beds', '750+'),
        'patents'     => getSetting('stat_patents', '160+'),
        'labs'        => getSetting('total_labs', '42+'),
        'highest_pkg' => getSetting('highest_package', '12 LPA'),
        'placement_pct' => getSetting('placement_record', '94%'),
        'recruiters'  => getSetting('recruiting_partners', '120+'),
        'teaching_days' => getSetting('stat_teaching_days', '180+'),
        'days_semester' => getSetting('stat_days_semester', '90'),
        'min_attendance' => getSetting('stat_min_attendance', '75%'),
    ];
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
function saveEnquiryLead($name, $email, $phone, $course = '', $message = '', $source = '', $fatherName = '', $city = '', $state = '', $college = '') {
    $name = trim((string)$name);
    $email = trim((string)$email);
    $phone = trim((string)$phone);
    $course = trim((string)$course);
    $message = trim((string)$message);
    $fatherName = trim((string)$fatherName);
    $city = trim((string)$city);
    $state = trim((string)$state);
    $college = trim((string)$college);

    // Strict Validation
    // 1. Name validation: Alphabets, spaces, dots and apostrophes only (no numbers)
    if (strlen($name) < 2) {
        return ['success' => false, 'error' => 'Please enter a valid full name (minimum 2 characters).'];
    }
    if (!preg_match("/^[a-zA-Z\s\.\'-]{2,80}$/", $name)) {
        return ['success' => false, 'error' => 'Full Name must contain only alphabets and spaces (no numbers or special characters allowed).'];
    }

    // 2. Father\'s name validation (if provided)
    if (!empty($fatherName) && !preg_match("/^[a-zA-Z\s\.\'-]{2,80}$/", $fatherName)) {
        return ['success' => false, 'error' => "Father's Name must contain only alphabets and spaces (no numbers allowed)."];
    }

    // 3. Email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'error' => 'Please enter a valid email address (e.g. name@domain.com).'];
    }

    // 4. Mobile Number validation: Exactly 10 digits, starts with 6, 7, 8, or 9
    $cleanPhone = preg_replace('/\D/', '', $phone);
    // Strip leading country code 91 if 12 digits, or leading 0 if 11 digits
    if (strlen($cleanPhone) === 12 && substr($cleanPhone, 0, 2) === '91') {
        $cleanPhone = substr($cleanPhone, 2);
    } elseif (strlen($cleanPhone) === 11 && substr($cleanPhone, 0, 1) === '0') {
        $cleanPhone = substr($cleanPhone, 1);
    }

    if (strlen($cleanPhone) !== 10) {
        return ['success' => false, 'error' => 'Mobile number must be exactly 10 digits (digits only).'];
    }
    if (!preg_match('/^[6-9]\d{9}$/', $cleanPhone)) {
        return ['success' => false, 'error' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8 or 9.'];
    }
    $phone = $cleanPhone;

    // 5. City & State validation (if provided)
    if (!empty($city) && !preg_match("/^[a-zA-Z\s\.\'-]{2,60}$/", $city)) {
        return ['success' => false, 'error' => 'City name must contain only alphabets and spaces (no numbers allowed).'];
    }
    if (!empty($state) && !preg_match("/^[a-zA-Z\s\.\'-]{2,60}$/", $state)) {
        return ['success' => false, 'error' => 'State name must contain only alphabets and spaces (no numbers allowed).'];
    }

    $fullMsg = $message;
    $detailsParts = [];
    if ($source) $detailsParts[] = "[$source]";
    if ($college) $detailsParts[] = "College/Institute: $college";
    if ($course) $detailsParts[] = "Course: $course";
    if (!empty($detailsParts)) {
        $prefix = implode(" | ", $detailsParts) . "\n";
        $fullMsg = $prefix . ($message ?: 'Seat Inquiry / Direct Admission Application');
    }

    try {
        $pdo = getDBConnection();
        runUniversalDatabaseMigrations($pdo);

        $stmt = $pdo->prepare("INSERT INTO enquiries (name, father_name, college, email, phone, course, city, state, source, message, status, created_at) VALUES (:n, :fn, :col, :e, :p, :c, :city, :state, :src, :m, 'New', CURRENT_TIMESTAMP)");
        $stmt->execute([
            ':n' => $name,
            ':fn' => $fatherName ?: null,
            ':col' => $college ?: null,
            ':e' => $email ?: 'not-provided@srku.edu.in',
            ':p' => $phone,
            ':c' => $course ?: ($college ? "Admission Enquiry ($college)" : 'General Admission Enquiry'),
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
                ':c' => $course ?: ($college ? "Admission Enquiry ($college)" : 'General Admission Enquiry'),
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

    // 1. Name validation
    if (strlen($name) < 2) {
        return ['success' => false, 'error' => 'Please enter a valid full name (minimum 2 characters).'];
    }
    if (!preg_match("/^[a-zA-Z\s\.\'-]{2,80}$/", $name)) {
        return ['success' => false, 'error' => 'Name must contain only alphabets and spaces (no numbers or symbols allowed).'];
    }

    // 2. Father\'s name validation (if provided)
    if (!empty($fatherName) && !preg_match("/^[a-zA-Z\s\.\'-]{2,80}$/", $fatherName)) {
        return ['success' => false, 'error' => "Father's Name must contain only alphabets and spaces (no numbers allowed)."];
    }

    // 3. Email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'error' => 'Please enter a valid email address (e.g. name@domain.com).'];
    }

    // 4. Mobile validation: Exactly 10 digits starting with 6-9
    $cleanPhone = preg_replace('/\D/', '', $phone);
    if (strlen($cleanPhone) === 12 && substr($cleanPhone, 0, 2) === '91') {
        $cleanPhone = substr($cleanPhone, 2);
    } elseif (strlen($cleanPhone) === 11 && substr($cleanPhone, 0, 1) === '0') {
        $cleanPhone = substr($cleanPhone, 1);
    }

    if (strlen($cleanPhone) !== 10) {
        return ['success' => false, 'error' => 'Mobile number must be exactly 10 digits (digits only).'];
    }
    if (!preg_match('/^[6-9]\d{9}$/', $cleanPhone)) {
        return ['success' => false, 'error' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8 or 9.'];
    }
    $phone = $cleanPhone;

    // 5. Complaint details
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
        
        if ($driver === 'sqlite') {
            $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")->fetchAll(PDO::FETCH_COLUMN);
        } else {
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        }
        
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
            'dbname' => defined('DB_NAME') ? DB_NAME : 'srku_db_new',
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
            'dbname' => defined('DB_NAME') ? DB_NAME : 'srku_db_new',
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
        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        $baseDir = dirname(__DIR__);
        $sqlCandidates = [
            $baseDir . '/srku_db_new.sql',
            $baseDir . '/srku_db.sql',
            $baseDir . '/database.sql'
        ];
        $masterSql = '';
        foreach ($sqlCandidates as $cand) {
            if (file_exists($cand) && filesize($cand) > 1000) {
                $masterSql = file_get_contents($cand);
                break;
            }
        }

        // Safe table cleanup helper for both MySQL (TRUNCATE) and SQLite (DELETE FROM)
        $cleanTable = function($tbl) use ($pdo, $driver) {
            if ($driver === 'sqlite') {
                $pdo->exec("DELETE FROM `{$tbl}`");
                try { $pdo->exec("DELETE FROM sqlite_sequence WHERE name='{$tbl}'"); } catch (Exception $e) {}
            } else {
                $pdo->exec("TRUNCATE TABLE `{$tbl}`");
            }
        };

        // 1. Ensure all schemas and columns are fully created & aligned
        if ($driver === 'sqlite') {
            autoInitializeTables($pdo);
        } else {
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

                CREATE TABLE IF NOT EXISTS `board_members` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(255) NOT NULL,
                    `designation` VARCHAR(255) NOT NULL,
                    `category` VARCHAR(50) DEFAULT 'Executive Leadership',
                    `role` VARCHAR(100) DEFAULT 'Member',
                    `representation` VARCHAR(255) DEFAULT NULL,
                    `bio` TEXT,
                    `icon` VARCHAR(100) DEFAULT 'fa-user-tie',
                    `photo` VARCHAR(255),
                    `sort_order` INT DEFAULT 0,
                    `status` ENUM('active','inactive') DEFAULT 'active',
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

                CREATE TABLE IF NOT EXISTS `exam_timetables` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `category` VARCHAR(100) NOT NULL DEFAULT 'General',
                    `course_title` VARCHAR(255) NOT NULL,
                    `details` TEXT,
                    `file_url` VARCHAR(255) NOT NULL,
                    `filename` VARCHAR(255),
                    `sort_order` INT DEFAULT 0,
                    `status` ENUM('active','inactive') DEFAULT 'active',
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

                CREATE TABLE IF NOT EXISTS `facilities` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `title` VARCHAR(255) NOT NULL,
                    `icon` VARCHAR(100) DEFAULT 'fa-building',
                    `image` VARCHAR(255) NOT NULL,
                    `description` TEXT,
                    `sort_order` INT DEFAULT 0,
                    `status` ENUM('active','inactive') DEFAULT 'active',
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

                CREATE TABLE IF NOT EXISTS `accreditations` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `code` VARCHAR(50) NOT NULL,
                    `name` VARCHAR(255) NOT NULL,
                    `domain` VARCHAR(150) DEFAULT NULL,
                    `description` TEXT,
                    `sort_order` INT DEFAULT 0,
                    `status` ENUM('active','inactive') DEFAULT 'active',
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

                CREATE TABLE IF NOT EXISTS `incubation_members` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(150) NOT NULL,
                    `role` VARCHAR(150) NOT NULL,
                    `highlight` TINYINT(1) DEFAULT 0,
                    `sort_order` INT DEFAULT 0,
                    `status` ENUM('active','inactive') DEFAULT 'active',
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

                CREATE TABLE IF NOT EXISTS `placements` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `company_name` VARCHAR(100) NOT NULL,
                    `logo_url` VARCHAR(255),
                    `package_offered` VARCHAR(50) DEFAULT NULL,
                    `sort_order` INT DEFAULT 0,
                    `status` TINYINT(1) DEFAULT 1,
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        }

        // Run universal schema migrations for both MySQL & SQLite
        runUniversalDatabaseMigrations($pdo);

        // 2. SYLLABI (267 items from syllabus_data.php)
        if ($target === 'all' || $target === 'syllabi') {
            $currSylCount = (int)$pdo->query("SELECT COUNT(*) FROM `syllabi`")->fetchColumn();
            if ($currSylCount < 250 || $force) {
                $syllabiFile = $baseDir . '/includes/syllabus_data.php';
                if (file_exists($syllabiFile)) {
                    require $syllabiFile;
                    if (isset($syllabusCategories) && is_array($syllabusCategories)) {
                        $cleanTable('syllabi');
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
                    $cleanTable('faculty');
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
                    $cleanTable('departments');
                    $pdo->exec($m[0]);
                    $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `departments`")->fetchColumn();
                    $report['counts']['departments'] = $newCount;
                    $report['messages'][] = "Constituent Units & Departments synchronized ($newCount colleges).";
                }
            } else {
                $report['counts']['departments'] = $currDeptCount;
            }

            // Auto-link constituent unit images from assets/uploads/constituent-units/{slug}.webp
            try {
                ensureDbTableColumn($pdo, 'departments', 'image', "VARCHAR(255) DEFAULT NULL", "TEXT DEFAULT NULL", 'icon');
                ensureDbTableColumn($pdo, 'departments', 'banner_img', "VARCHAR(255) DEFAULT NULL", "TEXT DEFAULT NULL", 'image');

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
            } catch (Exception $e) {}
        }

        // 5. COURSES (All 95 Academic Degree & Diploma Programs)
        if ($target === 'all' || $target === 'courses') {
            $currCourseCount = (int)$pdo->query("SELECT COUNT(*) FROM `courses`")->fetchColumn();
            if ($currCourseCount < 50 || $force) {
                if ($masterSql && preg_match_all('/INSERT INTO `courses`[^\;]+;/s', $masterSql, $m2)) {
                    $cleanTable('courses');
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
                $cleanTable('gallery');
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
                $cleanTable('blogs');
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
                $cleanTable('news');
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
                $cleanTable('banners');
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
                $cleanTable('pages');
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
                    ],
                    [
                        'Sports Facilities',
                        'sports-facilities',
                        '<p>Official documentation and facilities guide for Sports and Athletics at Sarvepalli Radhakrishnan University (SRKU), Bhopal.</p>',
                        'Overview of world-class outdoor and indoor sports facilities, athletic tracks, cricket ground, football arena, basketball courts, and fitness centers at SRK University.',
                        'Sports Facilities & Athletic Complex',
                        'Sports Infrastructure, Athletic Complexes & University Gymnasium',
                        'assets/uploads/2025/10/new-update/sports-Facilities.pdf'
                    ],
                    [
                        'NCC & NSS',
                        'ncc-nss',
                        '<p>Official records of National Cadet Corps (NCC) and National Service Scheme (NSS) at SRK University, Bhopal.</p>',
                        'Details of the active NCC battalions and NSS units at SRKU promoting leadership, community service, discipline, and defense career preparedness.',
                        'NCC & NSS Activities',
                        'National Cadet Corps & National Service Scheme Activities & Units',
                        'assets/uploads/2025/10/new-update/NCC-NSS-Details.pdf'
                    ],
                    [
                        'Hostel Details',
                        'hostel-details',
                        '<p>Official accommodation, dining, and hostel fee details for students at Sarvepalli Radhakrishnan University, Bhopal.</p>',
                        'Comprehensive documentation of on-campus boys and girls hostels featuring furnished rooms, 24x7 security, dining mess, and resident warden support.',
                        'Hostel Accommodation & Campus Residence',
                        'On-Campus Student Residential Facilities, Dining, Security & Amenities',
                        'assets/uploads/2025/10/new-update/Hostel-Details.pdf'
                    ],
                    [
                        'Placement Cell',
                        'placement-cell',
                        '<p>Official reports, company recruitment tie-ups, and placement statistics for Sarvepalli Radhakrishnan University (SRKU), Bhopal.</p>',
                        'Official overview of the University Training & Placement Cell coordinating corporate tie-ups, internships, and campus recruitment drives.',
                        'Training & Placement Cell',
                        'Corporate Relations, Soft Skill Training, Internships & Campus Recruitment',
                        'assets/uploads/2025/10/new-update/placement-cell.pdf'
                    ],
                    [
                        'Student Grievance Committee',
                        'student-grievance-committee',
                        '<p>Constitution, committee members, and procedure of the Student Grievance Redressal Committee at SRKU Bhopal.</p>',
                        'Official constitution, composition, and redressal procedure of the Student Grievance Redressal Committee (SGRC) as per UGC norms.',
                        'Student Grievance Redressal Committee',
                        'Institutional Student Grievance Redressal Mechanism & Regulations',
                        'assets/uploads/2025/10/new-update/student-grievance-committee.pdf'
                    ],
                    [
                        'Ombudsman',
                        'ombudsman',
                        '<p>Statutory notification of the appointment of Ombudsman at Sarvepalli Radhakrishnan University, Bhopal.</p>',
                        'Official appointment, jurisdiction, and contact details of the University Ombudsman appointed under UGC grievance redressal regulations.',
                        'University Ombudsman',
                        'Statutory University Ombudsman for Student Grievance Adjudication',
                        'assets/uploads/2025/10/new-update/ombudsman.pdf'
                    ],
                    [
                        'Health Facility',
                        'health-facility',
                        '<p>Healthcare and medical infrastructure facilities provided for students and faculty at SRK University Bhopal.</p>',
                        'Comprehensive overview of health facilities, emergency medical care, qualified physicians, pharmacy, and hospital association at SRKU.',
                        'Health Facility & Medical Care',
                        '24x7 Campus Medical Care, On-Site Hospital & Emergency Services',
                        'assets/uploads/2025/10/new-update/Health-facility.pdf'
                    ],
                    [
                        'Internal Complaint Committee',
                        'internal-complaint-committee',
                        '<p>Official constitution and members of the Internal Complaints Committee (ICC) at Sarvepalli Radhakrishnan University Bhopal.</p>',
                        'Official constitution and inquiry procedure of the Internal Complaints Committee (ICC) constituted under the POSH Act 2013.',
                        'Internal Complaint Committee (ICC)',
                        'Gender Sensitization, POSH Compliance & Safe Campus Redressal',
                        'assets/uploads/2025/10/new-update/InternalComplaint-Committee.pdf'
                    ],
                    [
                        'Anti Ragging Committee',
                        'anti-ragging',
                        '<p>Zero-tolerance anti-ragging measures and committee members at Sarvepalli Radhakrishnan University Bhopal.</p>',
                        'Statutory committee composition, flying monitoring squads, 24x7 helpline numbers, and UGC mandated declarations against ragging.',
                        'Anti-Ragging Committee & Squads',
                        'Strict Zero-Tolerance Anti-Ragging Guidelines & Monitoring Squads',
                        'assets/uploads/2025/10/new-update/AntiRaggingCommittee.pdf'
                    ],
                    [
                        'Equal Opportunity Cell',
                        'equal-opportunity-cell',
                        '<p>Mandate, committee details, and activities of the Equal Opportunity Cell at SRK University Bhopal.</p>',
                        'Official mandate and operations of the Equal Opportunity Cell facilitating holistic support and non-discrimination for all students.',
                        'Equal Opportunity Cell',
                        'Inclusive Campus Framework, Accessibility & Equal Development',
                        'assets/uploads/2025/10/new-update/EqualOpportunityCell.pdf'
                    ],
                    [
                        'Socio Economically Disadvantaged Groups Cell (SEDG)',
                        'sedg-cell',
                        '<p>Constitution and functions of the Socio Economically Disadvantaged Groups Cell (SEDG) at SRK University Bhopal.</p>',
                        'Institutional framework of the SEDG Cell constituted in alignment with NEP 2020 and UGC guidelines to empower disadvantaged students.',
                        'SEDG Cell',
                        'UGC NEP-2020 Aligned SEDG Cell for Equity & Holistic Support',
                        'assets/uploads/2025/10/new-update/Socio-Economically-Disadvantaged-Groups-Cell-(SEDG).pdf'
                    ],
                    [
                        'Facilities For Differently Abled Students',
                        'differently-abled-facilities',
                        '<p>Campus accessibility infrastructure and assistive facilities for differently-abled students at Sarvepalli Radhakrishnan University Bhopal.</p>',
                        'Documentation of barrier-free campus infrastructure including wheelchair ramps, accessible elevators, and assistive tools for differently-abled students.',
                        'Facilities For Differently Abled Students',
                        'Barrier-Free Built Environment, Assistive Infrastructure & Ramps',
                        'assets/uploads/2025/10/new-update/FACILITIES-FOR-DIFFERENTLY-ABLED-STUDENTS.pdf'
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
            if ($driver === 'sqlite') {
                $insSetting = $pdo->prepare("INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES (:k, :v) ON CONFLICT(`setting_key`) DO UPDATE SET `setting_value` = excluded.`setting_value`");
            } else {
                $insSetting = $pdo->prepare("INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES (:k, :v) ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`)");
            }
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

        // 13. BOARD OF MANAGEMENT
        if ($target === 'all' || $target === 'board_members') {
            $currBoardCount = (int)$pdo->query("SELECT COUNT(*) FROM `board_members`")->fetchColumn();
            if ($currBoardCount == 0 || $force) {
                $cleanTable('board_members');
                $boardMembersMaster = [
                    ['Dr. Sunil Kapoor', 'Chairman & Chief Patron', 'leadership', 'Member', 'Founder & Visionary, RKDF Education Society', 'Guiding the RKDF group and SRK University since 1995 with an inspiring mission of affordable, benchmarked multidisciplinary higher education.', 'fa-crown', 'assets/uploads/2026/08/dr-sunil-kapoor.jpeg', 1],
                    ['Mrs. Janak Kapoor', 'Chancellor', 'leadership', 'Member', 'Chancellor, Sarvepalli Radhakrishnan University', 'Leading policy governance, university growth, philanthropic outreach, and community engagement.', 'fa-user-tie', 'assets/uploads/2026/08/mrs-janak-kapoor.jpeg', 2],
                    ['Prof. (Dr.) Brijendra Singh', 'Vice Chancellor', 'leadership', 'Member', 'Vice Chancellor & Senior Academician', 'Eminent professor leading academic reforms, research partnerships, and university administration.', 'fa-user-graduate', 'assets/uploads/2026/08/dr-brijendra-singh.jpeg', 3],
                    ['Director', 'Registrar', 'administration', 'Member Secretary', 'Registrar & Head of Administrative Affairs', 'Overseeing regulatory compliance, university records, state council liaisons, and human resources.', 'fa-clipboard-check', NULL, 4],
                    ['Dr. P. K. Singhal', 'Dean & Eminent Educationist', 'academics', 'Member', 'Nominee, Sponsoring Body', 'Pioneering technical engineering research and higher education accreditation frameworks.', 'fa-award', 'assets/uploads/2026/08/dr-pk-singhal.jpeg', 5],
                    ['Prof. (Dr.) S. K. Jain', 'Director & Senior Scientist', 'academics', 'Member', 'Prominent Academic Leader', 'Leading pharmacy research, industrial collaborations, and clinical development initiatives.', 'fa-flask', 'assets/uploads/2026/08/dr-sk-jain.jpeg', 6],
                    ['Dr. Archana Kapoor', 'Director', 'governance', 'Member', 'RKDF Trust Nominee', 'Promoting community health, paramedical education, and women empowerment initiatives.', 'fa-heart', 'assets/uploads/2026/08/dr-archana-kapoor.jpeg', 7],
                    ['Prof. R. C. Gupta', 'Eminent Technologist', 'industry', 'Member', 'Industry Representative', 'Veteran technocrat connecting university curricula with global industry standards and innovations.', 'fa-laptop-code', 'assets/uploads/2026/08/prof-rc-gupta.jpeg', 8],
                    ['Prof. (Dr.) Vandana Sharma', 'Professor & Head', 'academics', 'Member', 'University Faculty Nominee', 'Leading postgraduate medical sciences, nursing programs, and hospital clinical training.', 'fa-stethoscope', 'assets/uploads/2026/08/dr-vandana-sharma.jpeg', 9],
                    ['Er. Alok Verma', 'Chief Financial Officer', 'administration', 'Special Invitee', 'Finance Officer, SRKU', 'Directing financial governance, institutional planning, budget compliance, and auditing.', 'fa-coins', 'assets/uploads/2026/08/er-alok-verma.jpeg', 10]
                ];
                $insBoard = $pdo->prepare("INSERT INTO `board_members` (`name`, `designation`, `category`, `role`, `representation`, `bio`, `icon`, `photo`, `sort_order`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')");
                foreach ($boardMembersMaster as $bm) {
                    $insBoard->execute($bm);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `board_members`")->fetchColumn();
                $report['counts']['board_members'] = $newCount;
                $report['messages'][] = "Board of Management synchronized ($newCount members).";
            } else {
                $report['counts']['board_members'] = $currBoardCount;
            }
        }

        // 14. EXAM TIME TABLES
        if ($target === 'all' || $target === 'exam_timetables') {
            $currTimeCount = (int)$pdo->query("SELECT COUNT(*) FROM `exam_timetables`")->fetchColumn();
            if ($currTimeCount == 0 || $force) {
                $cleanTable('exam_timetables');
                $timetablesMaster = [
                    ['Engineering & Polytechnic', 'B.Tech / B.E. (All Branches)', 'Regular & Ex Semester Examinations | EE, EEE, CE, EC, EI, CS, IT, ME', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/Btech-II-24-25.pdf', 'Btech-II-24-25.pdf', 1],
                    ['Engineering & Polytechnic', 'Polytechnic Diploma in Engineering', 'All Branches | Civil, Mechanical, Electrical, Computer Science', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/Diploma-24-25.pdf', 'Diploma-24-25.pdf', 2],
                    ['Engineering & Polytechnic', 'M.Tech / ME (All Specializations)', 'VLSI, CSE, Power Systems, Thermal & Structural Engineering', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/Mtech-24-25.pdf', 'Mtech-24-25.pdf', 3],
                    ['Pharmacy & Medical', 'B.Pharm (Bachelor of Pharmacy)', 'PCI Approved 4-Year Degree | All Semester Examinations', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/B-Pharm-24-25.pdf', 'B-Pharm-24-25.pdf', 4],
                    ['Pharmacy & Medical', 'D.Pharm (Diploma in Pharmacy)', 'First & Second Year Annual Examination Schedule', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/D-Pharm-24-25.pdf', 'D-Pharm-24-25.pdf', 5],
                    ['Pharmacy & Medical', 'M.Pharm (Pharmaceutics / Pharmacology)', 'Master of Pharmacy Final & Pre-Final Semester Schedules', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/M-Pharm-24-25.pdf', 'M-Pharm-24-25.pdf', 6],
                    ['Pharmacy & Medical', 'MBBS / BDS Professional Examinations', 'Clinical & Pre-Clinical Theory and Practical Rosters', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/MBBS-24-25.pdf', 'MBBS-24-25.pdf', 7],
                    ['Nursing & Paramedical', 'B.Sc. Nursing & Post Basic B.Sc. Nursing', 'INC Approved Degree Examination Schedules', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/BSc-Nursing-24-25.pdf', 'BSc-Nursing-24-25.pdf', 8],
                    ['Nursing & Paramedical', 'GNM (General Nursing & Midwifery)', 'State Nursing Council Annual Examinations', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/GNM-24-25.pdf', 'GNM-24-25.pdf', 9],
                    ['Nursing & Paramedical', 'BPT & MPT (Physiotherapy)', 'Bachelor & Master of Physiotherapy Clinical Schedules', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/BPT-24-25.pdf', 'BPT-24-25.pdf', 10],
                    ['Management & Commerce', 'MBA (Master of Business Administration)', 'Dual Specialization: Finance, Marketing, HR, Business Analytics', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/MBA-24-25.pdf', 'MBA-24-25.pdf', 11],
                    ['Management & Commerce', 'BBA & B.Com (Honours)', 'Undergraduate Management & Commerce Semester Schedule', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/BBA-BCom-24-25.pdf', 'BBA-BCom-24-25.pdf', 12],
                    ['Law & Legal Studies', 'LL.B. (3 Years)', 'BCI Approved Professional Law Degree Examination', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/LLB-24-25.pdf', 'LLB-24-25.pdf', 13],
                    ['Law & Legal Studies', 'B.A. LL.B. (5 Years Integrated)', 'Integrated Honours Law Program Date Sheets', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/BALLB-24-25.pdf', 'BALLB-24-25.pdf', 14],
                    ['Agriculture & Sciences', 'B.Sc. (Hons) Agriculture', 'ICAR Aligned 4-Year Degree Semester Schedule', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/Agriculture-24-25.pdf', 'Agriculture-24-25.pdf', 15],
                    ['Agriculture & Sciences', 'M.Sc. (All Disciplines)', 'Agronomy, Horticulture, Chemistry, Physics, Mathematics', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/MSc-24-25.pdf', 'MSc-24-25.pdf', 16],
                    ['Computer Applications', 'BCA & MCA', 'Cloud Computing, AI, Full Stack Web Development', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/BCA-MCA-24-25.pdf', 'BCA-MCA-24-25.pdf', 17],
                    ['Ayurveda & Homoeopathy', 'BAMS & BHMS', 'NCISM / NCH Professional Annual Examinations', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/AYUSH-24-25.pdf', 'AYUSH-24-25.pdf', 18],
                    ['Doctoral Studies', 'Ph.D. Coursework Examinations', 'Research Methodology & Subject Specific Examinations', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/PhD-24-25.pdf', 'PhD-24-25.pdf', 19],
                    ['Special Notifications', 'Special ATKT / Remedial Examinations', 'Supplementary Exams for UG and PG Programmes', 'https://www.srku.edu.in/wp-content/uploads/2025/Time-Table/05/ATKT-24-25.pdf', 'ATKT-24-25.pdf', 20]
                ];
                $insTime = $pdo->prepare("INSERT INTO `exam_timetables` (`category`, `course_title`, `details`, `file_url`, `filename`, `sort_order`, `status`) VALUES (?, ?, ?, ?, ?, ?, 'active')");
                foreach ($timetablesMaster as $tm) {
                    $insTime->execute($tm);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `exam_timetables`")->fetchColumn();
                $report['counts']['exam_timetables'] = $newCount;
                $report['messages'][] = "Exam Timetables & Schedules synchronized ($newCount schedules).";
            } else {
                $report['counts']['exam_timetables'] = $currTimeCount;
            }
        }

        // 15. CAMPUS FACILITIES
        if ($target === 'all' || $target === 'facilities') {
            $currFacCount = (int)$pdo->query("SELECT COUNT(*) FROM `facilities`")->fetchColumn();
            if ($currFacCount == 0 || $force) {
                $cleanTable('facilities');
                $facilitiesMaster = [
                    ['42+ Research Laboratories', 'fa-microscope', 'assets/uploads/2026/07/lab-and-research.webp', 'Equipped with high-performance computing clusters, robotics simulation kits, automated HPLC drug testing systems, and agronomy research suites.', 1],
                    ['RKDF Medical Hospital (750+ Beds)', 'fa-hospital', 'assets/uploads/2026/07/001.webp', 'On-campus teaching super-specialty hospital featuring ICUs, trauma care, pathology labs, and emergency medicine for direct clinical training.', 2],
                    ['Central Library & Digital Knowledge Hub', 'fa-book-reader', 'assets/uploads/2026/07/Library-pic.webp', 'Over 1,00,000 physical volumes, subscriptions to IEEE/Springer digital journals, high-speed Wi-Fi, and air-conditioned reading halls.', 3],
                    ['Air-Conditioned Auditoriums & Convention Center', 'fa-theater-masks', 'assets/uploads/2026/07/Auditorium-01.webp', 'Multiple acoustically tuned seminar halls and a grand 1,500-seater main auditorium for national fests, conferences, and convocation ceremonies.', 4],
                    ['Sports Complex & Gymnasium', 'fa-dumbbell', 'assets/uploads/2026/07/gymnasium.webp', 'Olympic-size running tracks, cricket grounds, indoor badminton stadium, basketball courts, and fully equipped modern fitness gymnasium.', 5],
                    ['Safe Campus Transport Fleet', 'fa-bus', 'assets/uploads/2026/07/Transportation.webp', 'A modern fleet of 60+ university buses connecting all corners of Bhopal, Mandideep, Sehore, Hoshangabad, and Raisen with GPS tracking.', 6]
                ];
                $insFac = $pdo->prepare("INSERT INTO `facilities` (`title`, `icon`, `image`, `description`, `sort_order`, `status`) VALUES (?, ?, ?, ?, ?, 'active')");
                foreach ($facilitiesMaster as $fm) {
                    $insFac->execute($fm);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `facilities`")->fetchColumn();
                $report['counts']['facilities'] = $newCount;
                $report['messages'][] = "Campus Facilities synchronized ($newCount facilities).";
            } else {
                $report['counts']['facilities'] = $currFacCount;
            }
        }

        // 16. ACCREDITATIONS & STATUTORY APPROVALS
        if ($target === 'all' || $target === 'accreditations') {
            $currAccCount = (int)$pdo->query("SELECT COUNT(*) FROM `accreditations`")->fetchColumn();
            if ($currAccCount == 0 || $force) {
                $cleanTable('accreditations');
                $accredMaster = [
                    ['UGC', 'University Grants Commission', 'Govt. of India', 'Statutory recognition under Section 2(f) of the UGC Act 1956, Government of India, empowering degree-granting authority.', 1],
                    ['AICTE', 'All India Council for Technical Education', 'Technical & Engineering', 'Statutory regulatory approval for Bachelor of Technology, Master of Technology, MCA, and Management programs.', 2],
                    ['PCI', 'Pharmacy Council of India', 'Pharmacy Education', 'Apex accreditation for B.Pharm, D.Pharm, and M.Pharm professional pharmaceutical education.', 3],
                    ['INC', 'Indian Nursing Council', 'Healthcare & Nursing', 'National regulatory approval for B.Sc. Nursing, Post Basic B.Sc. Nursing, and GNM programs.', 4],
                    ['BCI', 'Bar Council of India', 'Legal Studies', 'Statutory recognition for LL.B. (3 Years) and B.A. LL.B. (5 Years Integrated) professional law education.', 5],
                    ['NMC', 'National Medical Commission', 'Medical Sciences', 'Apex regulatory recognition for MBBS and postgraduate clinical rotations at RKDF Medical College Hospital.', 6],
                    ['DCI', 'Dental Council of India', 'Dental Surgery', 'Statutory approval for BDS (Bachelor of Dental Surgery) and specialized oral healthcare training.', 7],
                    ['NCISM', 'National Commission for Indian System of Medicine', 'Ayurvedic Medicine', 'Apex regulatory approval for BAMS and traditional Indian medicine healthcare programs.', 8],
                    ['NCH', 'National Commission for Homoeopathy', 'Homoeopathic Medicine', 'National council recognition for BHMS professional homoeopathic medical education.', 9],
                    ['MPPURC', 'M.P. Private University Regulatory Commission', 'State Regulatory Body', 'Constitutional oversight, fee regulation, and academic quality assurance under MP Act No. 17 of 2007.', 10],
                    ['AIU & ISO', 'Association of Indian Universities & ISO 9001:2015', 'Quality Benchmarking', 'Equivalent recognition across all Indian and overseas universities for higher education and government service.', 11]
                ];
                $insAcc = $pdo->prepare("INSERT INTO `accreditations` (`code`, `name`, `domain`, `description`, `sort_order`, `status`) VALUES (?, ?, ?, ?, ?, 'active')");
                foreach ($accredMaster as $am) {
                    $insAcc->execute($am);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `accreditations`")->fetchColumn();
                $report['counts']['accreditations'] = $newCount;
                $report['messages'][] = "Statutory Accreditations synchronized ($newCount recognitions).";
            } else {
                $report['counts']['accreditations'] = $currAccCount;
            }
        }

        // 17. INCUBATION CENTRE COMMITTEE
        if ($target === 'all' || $target === 'incubation_members') {
            $currIncCount = (int)$pdo->query("SELECT COUNT(*) FROM `incubation_members`")->fetchColumn();
            if ($currIncCount == 0 || $force) {
                $cleanTable('incubation_members');
                $incMaster = [
                    ['Dr. Sushil Singh', 'Centre Co-ordinator', 1, 1],
                    ['Director', 'Member', 0, 2],
                    ['Dr. K. S. Thakur', 'Advisory Member', 0, 3],
                    ['Dr. P. K. Singhal', 'Advisory Member', 0, 4],
                    ['Dr. Archana Kapoor', 'Advisory Member', 0, 5],
                    ['Dr. Manoj Mishra', 'Technical Expert', 0, 6],
                    ['Dr. Rakesh Patel', 'Patent & IPR Mentor', 0, 7],
                    ['Prof. Alok Sharma', 'Startup Mentor', 0, 8],
                    ['Dr. Vandana Sharma', 'Healthcare Innovation Mentor', 0, 9],
                    ['Prof. Vikas Gupta', 'Agri-Tech Advisor', 0, 10],
                    ['Er. Rohit Jain', 'Industry Liaison Officer', 0, 11],
                    ['Dr. Neha Saxena', 'Bio-Tech Mentor', 0, 12],
                    ['Prof. Amit Verma', 'Fintech & IT Advisor', 0, 13],
                    ['Er. Sanjay Mehra', 'Student Incubation Mentor', 0, 14]
                ];
                $insInc = $pdo->prepare("INSERT INTO `incubation_members` (`name`, `role`, `highlight`, `sort_order`, `status`) VALUES (?, ?, ?, ?, 'active')");
                foreach ($incMaster as $im) {
                    $insInc->execute($im);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `incubation_members`")->fetchColumn();
                $report['counts']['incubation_members'] = $newCount;
                $report['messages'][] = "Incubation Committee synchronized ($newCount members).";
            } else {
                $report['counts']['incubation_members'] = $currIncCount;
            }
        }

        // 18. CORPORATE PLACEMENT PARTNERS
        if ($target === 'all' || $target === 'placements') {
            $currPlcCount = (int)$pdo->query("SELECT COUNT(*) FROM `placements`")->fetchColumn();
            if ($currPlcCount == 0 || $force) {
                $cleanTable('placements');
                $plcMaster = [
                    ['TCS - Tata Consultancy Services', 'https://upload.wikimedia.org/wikipedia/commons/b/b1/Tata_Consultancy_Services_Logo.svg', '7.5 LPA', 1],
                    ['Infosys', 'https://upload.wikimedia.org/wikipedia/commons/9/95/Infosys_logo.svg', '6.8 LPA', 2],
                    ['Wipro Technologies', 'https://upload.wikimedia.org/wikipedia/commons/a/a0/Wipro_Primary_Logo_Color_RGB.svg', '6.5 LPA', 3],
                    ['Cipla Pharmaceuticals', 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Cipla_logo.svg', '8.0 LPA', 4],
                    ['Sun Pharmaceutical Industries', 'https://upload.wikimedia.org/wikipedia/commons/1/18/Sun_Pharma_Logo.svg', '8.2 LPA', 5],
                    ['HCL Technologies', 'https://upload.wikimedia.org/wikipedia/commons/9/95/HCL_Technologies_logo.svg', '7.0 LPA', 6]
                ];
                $insPlc = $pdo->prepare("INSERT INTO `placements` (`company_name`, `logo_url`, `package_offered`, `sort_order`, `status`) VALUES (?, ?, ?, ?, 1)");
                foreach ($plcMaster as $pm) {
                    $insPlc->execute($pm);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `placements`")->fetchColumn();
                $report['counts']['placements'] = $newCount;
                $report['messages'][] = "Placement Partners synchronized ($newCount companies).";
            } else {
                $report['counts']['placements'] = $currPlcCount;
            }
        }

        // 19. AUTOMATIC PRODUCTION SQL EXPORT (srku_db.sql)
        if ($driver !== 'sqlite') {
            $sqlExport = exportLiveDatabaseSqlFile();
            if (!empty($sqlExport['success'])) {
                $sizeKb = round(($sqlExport['size'] ?? 0) / 1024);
                $report['messages'][] = "Live database backup exported to '{$sqlExport['filename']}' ({$sizeKb} KB, {$sqlExport['total_rows']} rows across {$sqlExport['tables']} tables).";
            }
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

/**
 * Exports all active production tables and master data cleanly into srku_db.sql (and srku_db_new.sql)
 *
 * @return array Report with status, file path, size and table counts
 */
function exportLiveDatabaseSqlFile() {
    $baseDir = dirname(__DIR__);
    $targetFile = $baseDir . '/srku_db.sql';

    try {
        $pdo = getDBConnection();
        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

        if ($driver === 'sqlite') {
            return ['success' => false, 'error' => 'Live SQL export is only applicable for MySQL/MariaDB database.'];
        }

        // Tables to export in proper foreign-key friendly order
        $tablesToExport = [
            'users',
            'settings',
            'pages',
            'departments',
            'courses',
            'faculty',
            'syllabi',
            'gallery',
            'blogs',
            'news',
            'banners',
            'board_members',
            'exam_timetables',
            'facilities',
            'accreditations',
            'incubation_members',
            'placements',
            'enquiries',
            'complaints'
        ];

        $out = "-- ========================================================\n";
        $out .= "-- Sarvepalli Radhakrishnan University (SRKU) Database Dump\n";
        $out .= "-- Automated Live Synchronization & Production Export\n";
        $out .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $out .= "-- Host: " . (defined('DB_HOST') ? DB_HOST : 'localhost') . "\n";
        $out .= "-- Database: " . (defined('DB_NAME') ? DB_NAME : 'srku_db_new') . "\n";
        $out .= "-- ========================================================\n\n";
        $out .= "SET FOREIGN_KEY_CHECKS = 0;\n";
        $out .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $out .= "SET time_zone = \"+05:30\";\n";
        $out .= "SET NAMES utf8mb4;\n\n";

        $exportedTables = 0;
        $totalRowsExported = 0;

        foreach ($tablesToExport as $table) {
            // Check if table exists
            $exists = $pdo->query("SHOW TABLES LIKE " . $pdo->quote($table))->fetchColumn();
            if (!$exists) {
                continue;
            }

            $out .= "-- --------------------------------------------------------\n";
            $out .= "-- Table structure for `$table`\n";
            $out .= "-- --------------------------------------------------------\n";
            $out .= "DROP TABLE IF EXISTS `$table`;\n";

            $createRow = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
            if (!empty($createRow['Create Table'])) {
                $out .= $createRow['Create Table'] . ";\n\n";
            }

            // Export rows
            $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
            $rowCount = count($rows);
            if ($rowCount > 0) {
                $out .= "-- Dumping data for table `$table` ($rowCount rows)\n";
                $cols = array_keys($rows[0]);
                $colList = implode('`, `', $cols);

                // Chunk rows to prevent huge single queries
                $chunks = array_chunk($rows, 100);
                foreach ($chunks as $chunk) {
                    $out .= "INSERT INTO `$table` (`$colList`) VALUES\n";
                    $valsArray = [];
                    foreach ($chunk as $r) {
                        $vFormatted = array_map(function($val) use ($pdo) {
                            if ($val === null) return 'NULL';
                            return $pdo->quote($val);
                        }, array_values($r));
                        $valsArray[] = '(' . implode(', ', $vFormatted) . ')';
                    }
                    $out .= implode(",\n", $valsArray) . ";\n";
                }
                $out .= "\n";
                $totalRowsExported += $rowCount;
            }
            $exportedTables++;
        }

        $out .= "SET FOREIGN_KEY_CHECKS = 1;\n";

        file_put_contents($targetFile, $out);

        // Also update srku_db_new.sql if it exists
        $newSqlFile = $baseDir . '/srku_db_new.sql';
        if (file_exists($newSqlFile)) {
            file_put_contents($newSqlFile, $out);
        }

        return [
            'success' => true,
            'file' => $targetFile,
            'filename' => basename($targetFile),
            'size' => filesize($targetFile),
            'tables' => $exportedTables,
            'total_rows' => $totalRowsExported,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
