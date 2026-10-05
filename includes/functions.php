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

    // If it's a full URL
    if (preg_match('/^https?:\/\//i', $path) || strpos($path, '//') === 0) {
        $host = strtolower(parse_url($path, PHP_URL_HOST) ?? '');
        // Preserve Vimeo, YouTube, and external media platforms directly
        if (
            strpos($host, 'vimeo.com') !== false || 
            strpos($host, 'youtube.com') !== false || 
            strpos($host, 'youtu.be') !== false || 
            strpos($host, 'dailymotion.com') !== false
        ) {
            return $path;
        }

        $parsedPath = parse_url($path, PHP_URL_PATH);
        if ($parsedPath) {
            $trimmed = ltrim($parsedPath, '/');
            $trimmed = preg_replace('/^(new-staging|srku-new|srku)\//i', '', $trimmed);
            if (is_file($baseDir . '/' . $trimmed)) {
                return $trimmed;
            }
            if (!empty($host) && !in_array($host, ['localhost', '127.0.0.1'])) {
                return $path;
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
 * Parses any video string into structured provider data (Vimeo, YouTube, Direct MP4).
 */
function parseVideoUrl($url) {
    $url = trim((string)$url);
    if (empty($url)) {
        return [
            'type'        => 'none',
            'id'          => '',
            'src'         => '',
            'embed_url'   => '',
            'preview_url' => '',
            'provider'    => 'None',
            'is_external' => false
        ];
    }

    // Vimeo Match
    if (preg_match('/(?:vimeo\.com\/(?:video\/|channels\/(?:\w+\/)?|groups\/[^\/]+\/videos\/|album\/\d+\/video\/|))(\d+)/i', $url, $m)) {
        $id = $m[1];
        return [
            'type'        => 'vimeo',
            'id'          => $id,
            'src'         => $url,
            'embed_url'   => "https://player.vimeo.com/video/{$id}?background=1&autoplay=1&loop=1&byline=0&title=0&muted=1&autopause=0&controls=0&dnt=1",
            'preview_url' => "https://player.vimeo.com/video/{$id}?autoplay=1&muted=1&loop=1&autopause=0",
            'provider'    => 'Vimeo',
            'is_external' => true
        ];
    }

    // YouTube Match
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([^"&?\/ ]{11})/i', $url, $m)) {
        $id = $m[1];
        return [
            'type'        => 'youtube',
            'id'          => $id,
            'src'         => $url,
            'embed_url'   => "https://www.youtube.com/embed/{$id}?autoplay=1&mute=1&loop=1&playlist={$id}&controls=0&showinfo=0&rel=0&modestbranding=1&enablejsapi=1&iv_load_policy=3",
            'preview_url' => "https://www.youtube.com/embed/{$id}?autoplay=1&mute=1&loop=1&controls=1",
            'provider'    => 'YouTube',
            'is_external' => true
        ];
    }

    // Direct / Local Video
    $resolved = resolveMediaUrl($url, 'assets/images/concept2-hero.mp4');
    return [
        'type'        => 'local',
        'id'          => '',
        'src'         => $resolved,
        'embed_url'   => $resolved,
        'preview_url' => $resolved,
        'provider'    => 'Local Video File',
        'is_external' => false
    ];
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

// Fetch Gallery Images for Homepage (Campus Life Section)
// Returns admin-selected featured photos (up to 10), or falls back to latest 10 photos
function getHomeGalleryImages($limit = 10) {
    try {
        $pdo = getDBConnection();
        if ($pdo) {
            // 1. Check if admin explicitly selected photos (is_featured = 1)
            $stmt = $pdo->prepare("SELECT * FROM gallery WHERE is_featured = 1 ORDER BY id DESC LIMIT :lim");
            $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            $featured = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($featured) && count($featured) > 0) {
                return $featured;
            }

            // 2. If no photos are selected, fallback to latest 10 photos from gallery
            $stmt = $pdo->prepare("SELECT * FROM gallery ORDER BY id DESC LIMIT :lim");
            $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            $latest = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($latest) && count($latest) > 0) {
                return $latest;
            }
        }
    } catch (Exception $e) {}

    // 3. Fallback to directory scan if DB is empty
    return getGalleryImages('Campus', $limit);
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
/**
 * Detects engineering branch or discipline specialization from curriculum document title.
 */
function detectBranchFromTitle($title, $categorySlug = '') {
    $t = strtolower($title);

    if ($categorySlug === 'be-btech' || $categorySlug === 'polytechnic-engineering') {
        if (preg_match('/\b(all\s*branch|all\s*branches|all\s*braches|1st\s*year|ist\s*year|ist\s*years|i\s*&\s*ii\s*nd|ii\s*&\s*ii|i-st|bos\s*2025)\b/i', $t)) {
            return ['slug' => '1st-year', 'name' => '1st Year (All Branches)', 'short' => '1st Year'];
        }
        if (preg_match('/\b(cse|cs|computer\s*science)\b/i', $t)) {
            return ['slug' => 'cse', 'name' => 'Computer Science (CS/CSE)', 'short' => 'CS / CSE'];
        }
        if (preg_match('/\b(it|information\s*technology)\b/i', $t)) {
            return ['slug' => 'it', 'name' => 'Information Technology (IT)', 'short' => 'IT'];
        }
        if (preg_match('/\b(ce|civil)\b/i', $t)) {
            return ['slug' => 'civil', 'name' => 'Civil Engineering (CE)', 'short' => 'Civil'];
        }
        if (preg_match('/\b(me|mech|mechanical)\b/i', $t)) {
            return ['slug' => 'mech', 'name' => 'Mechanical Engineering (ME)', 'short' => 'Mechanical'];
        }
        if (preg_match('/\b(eee)\b/i', $t)) {
            return ['slug' => 'eee', 'name' => 'Electrical & Electronics (EEE)', 'short' => 'EEE'];
        }
        if (preg_match('/\b(ee|electrical)\b/i', $t)) {
            return ['slug' => 'ee', 'name' => 'Electrical Engineering (EE)', 'short' => 'EE'];
        }
        if (preg_match('/\b(ei|electronics\s*&\s*instrumentation)\b/i', $t)) {
            return ['slug' => 'ei', 'name' => 'Electronics & Instrumentation (EI)', 'short' => 'EI'];
        }
        if (preg_match('/\b(ec|ece|electronics\s*&\s*communication|electronics)\b/i', $t)) {
            return ['slug' => 'ec', 'name' => 'Electronics & Comm. (EC/ECE)', 'short' => 'EC / ECE'];
        }
        if (preg_match('/\b(ie)\b/i', $t)) {
            return ['slug' => 'ie', 'name' => 'Industrial Engineering (IE)', 'short' => 'IE'];
        }
        return ['slug' => 'general', 'name' => 'General / Core', 'short' => 'General'];
    }

    if ($categorySlug === 'm-tech') {
        if (preg_match('/\b(cse|cs|software|information)\b/i', $t)) {
            return ['slug' => 'cse', 'name' => 'Computer Science / Software Engg', 'short' => 'CSE / SE'];
        }
        if (preg_match('/\b(vlsi|embedded|dc|digital\s*comm)\b/i', $t)) {
            return ['slug' => 'vlsi-ec', 'name' => 'VLSI / Digital Comm (EC)', 'short' => 'VLSI / DC'];
        }
        if (preg_match('/\b(power|ps|ee|eee)\b/i', $t)) {
            return ['slug' => 'power-ee', 'name' => 'Power Systems / Electrical (EE)', 'short' => 'Power Systems'];
        }
        if (preg_match('/\b(thermal|prod|production|me|mech)\b/i', $t)) {
            return ['slug' => 'thermal-me', 'name' => 'Thermal / Production (ME)', 'short' => 'Thermal / ME'];
        }
        if (preg_match('/\b(struct|structure|ce|civil)\b/i', $t)) {
            return ['slug' => 'struct-ce', 'name' => 'Structural Engg (Civil)', 'short' => 'Structural'];
        }
        return ['slug' => 'general', 'name' => 'General M.Tech', 'short' => 'General'];
    }

    if ($categorySlug === 'mba') {
        if (preg_match('/\b(part\s*time|pt)\b/i', $t)) {
            return ['slug' => 'part-time', 'name' => 'MBA (Part Time)', 'short' => 'Part Time'];
        }
        if (preg_match('/\b(full\s*time|ft)\b/i', $t)) {
            return ['slug' => 'full-time', 'name' => 'MBA (Full Time)', 'short' => 'Full Time'];
        }
        if (preg_match('/\b(finance|banking|financial)\b/i', $t)) {
            return ['slug' => 'finance', 'name' => 'Finance & Banking', 'short' => 'Finance'];
        }
        if (preg_match('/\b(hr|human\s*resource)\b/i', $t)) {
            return ['slug' => 'hr', 'name' => 'Human Resource (HR)', 'short' => 'HR'];
        }
        if (preg_match('/\b(marketing)\b/i', $t)) {
            return ['slug' => 'marketing', 'name' => 'Marketing Management', 'short' => 'Marketing'];
        }
        if (preg_match('/\b(hospital|health)\b/i', $t)) {
            return ['slug' => 'hospital', 'name' => 'Hospital Administration', 'short' => 'Hospital Admin'];
        }
        return ['slug' => 'general', 'name' => 'Regular / Dual Specialization', 'short' => 'Regular'];
    }

    if ($categorySlug === 'paramedical') {
        if (preg_match('/\b(bpt|mpt|physio|physiotherapy)\b/i', $t)) {
            return ['slug' => 'physiotherapy', 'name' => 'Physiotherapy (BPT / MPT)', 'short' => 'Physiotherapy'];
        }
        if (preg_match('/\b(dmlt|bmlt|mlt|lab|laboratory)\b/i', $t)) {
            return ['slug' => 'mlt', 'name' => 'Medical Lab Tech (DMLT / BMLT)', 'short' => 'MLT / DMLT'];
        }
        if (preg_match('/\b(x-ray|radiology|imaging|ct)\b/i', $t)) {
            return ['slug' => 'radiology', 'name' => 'Radiology & X-Ray', 'short' => 'Radiology'];
        }
        if (preg_match('/\b(optometry|eye|ophthalmic)\b/i', $t)) {
            return ['slug' => 'optometry', 'name' => 'Optometry', 'short' => 'Optometry'];
        }
        if (preg_match('/\b(dialysis)\b/i', $t)) {
            return ['slug' => 'dialysis', 'name' => 'Dialysis Tech', 'short' => 'Dialysis'];
        }
        return ['slug' => 'general', 'name' => 'Paramedical Core', 'short' => 'General'];
    }

    return ['slug' => 'all', 'name' => 'General', 'short' => 'General'];
}

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
                    'branches' => [],
                    'items' => []
                ];
            }

            $branchInfo = detectBranchFromTitle($row['title'], $slug);
            if (!isset($categories[$slug]['branches'][$branchInfo['slug']])) {
                $categories[$slug]['branches'][$branchInfo['slug']] = [
                    'slug' => $branchInfo['slug'],
                    'name' => $branchInfo['name'],
                    'short' => $branchInfo['short'],
                    'count' => 0
                ];
            }
            $categories[$slug]['branches'][$branchInfo['slug']]['count']++;

            $categories[$slug]['items'][] = [
                'id' => (int)$row['id'],
                'title' => $row['title'],
                'type' => $row['type'],
                'branch_slug' => $branchInfo['slug'],
                'branch_name' => $branchInfo['name'],
                'branch_short' => $branchInfo['short'],
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

        // SQLite-safe SQL statement executor
        // MySQL uses backslash escapes (\') but SQLite uses doubled single quotes ('')
        $executeSqlStatement = function($stmt) use ($pdo, $driver) {
            if ($driver === 'sqlite') {
                $stmt = str_replace(["\\'", '\\"'], ["''", '""'], $stmt);
            }
            $pdo->exec($stmt);
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
                        $executeSqlStatement($stmt);
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
                    $executeSqlStatement($m[0]);
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
                        $executeSqlStatement($stmt);
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
                // ── CORE SITE ──────────────────────────────────────────────
                'site_title'           => 'Sarvepalli Radhakrishnan University (SRKU), Bhopal',
                'helpline'             => '0755 - 4911204',
                'email'                => 'exam@srku.edu.in',
                'admissions_phone'     => '+91 755 4911204 / 94250 12345',
                'address'              => 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026',
                'facebook_url'         => 'https://facebook.com/srku.bhopal',
                'instagram_url'        => 'https://instagram.com/srku.bhopal',
                'youtube_url'          => 'https://youtube.com/@srkuniversity',
                'linkedin_url'         => 'https://linkedin.com/school/srk-university',

                // ── HEADER ─────────────────────────────────────────────────
                'header_logo_url'            => 'assets/uploads/2026/07/SRK-logo.webp',
                'header_topbar_phone'        => '0755 - 4911204',
                'header_topbar_email'        => 'exam@srku.edu.in',
                'header_topbar_erp_link'     => 'https://erp.srku.edu.in/',
                'header_topbar_aicte_link'   => 'https://sarswati.aicte.gov.in/',
                'header_topbar_webmail_link' => 'http://email.godaddy.com/',
                'header_cta_text'            => 'Contact Us',
                'header_cta_link'            => 'contact.php',
                'header_custom_head_code'    => '',

                // ── FOOTER ─────────────────────────────────────────────────
                'footer_address'         => 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026',
                'footer_phone'           => '0755 - 4911204',
                'footer_email'           => 'exam@srku.edu.in',
                'footer_about_heading'   => 'Sarvepalli Radhakrishnan University',
                'footer_about_text'      => 'SRK University Bhopal is a premier educational institution recognized by UGC, AICTE, NMC, PCI, INC, BCI, DCI & NCISM offering 95+ programmes in Engineering, Medicine, Pharmacy, Management & Law.',
                'footer_ugc_text'        => 'Recognized under Section 2(f) of UGC Act 1956',
                'footer_copyright_text'  => '© ' . date('Y') . ' Sarvepalli Radhakrishnan University, Bhopal. All Rights Reserved.',
                'footer_custom_scripts'  => '',
                'enable_whatsapp_float'  => '1',
                'whatsapp_float_number'  => '917554911204',
                'whatsapp_float_msg'     => 'Hello SRKU, I am interested in Admission Details for 2026-27.',
                'enable_enquiry_tab'     => '1',
                'enquiry_tab_text'       => 'Admissions 2026-27',
                'enquiry_tab_link'       => '#apply',
                'enable_back_to_top'     => '1',

                // ── TICKER ─────────────────────────────────────────────────
                'ticker_text' => 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for UG, PG & PhD Programs in Engineering, Pharmacy, Management & Medicine | 94% Placement Record',

                // ── STATS ──────────────────────────────────────────────────
                'highest_package'      => '12 LPA',
                'placement_record'     => '94%',
                'recruiting_partners'  => '120+',
                'total_labs'           => '42+',
                'total_alumni'         => '15,000+',
                'stat_students'        => '20,000+',
                'stat_faculty'         => '600+',
                'stat_alumni'          => '1,10,000+',
                'stat_programs'        => '120+',
                'stat_papers'          => '1,400+',
                'stat_partners'        => '42+',
                'stat_placements'      => '35,000+',
                'stat_years'           => '31st Year',
                'stat_units'           => '14',
                'stat_campus_acres'    => '100+ Acres',
                'stat_hospital_beds'   => '750+',
                'stat_patents'         => '160+',
                'stat_highest_pkg'     => '12 LPA',
                'stat_placement_pct'   => '94%',
                'stat_recruiters'      => '120+',
                'stat_teaching_days'   => '180+',
                'stat_days_semester'   => '90',
                'stat_min_attendance'  => '75%',

                // ── HOMEPAGE - HERO ────────────────────────────────────────
                'hero_title'         => 'SRK University, Bhopal',
                'hero_subtitle'      => 'UGC-Recognized University in MP',
                'hero_desc'          => 'Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership. If you are looking for the best placement university in MP, our rigorous research, multi-disciplinary collaboration, and industry-aligned pedagogy deliver unmatched career growth.',
                'hero_video_url'     => 'assets/images/concept2-hero.mp4',
                'hero_fallback_image'=> 'assets/uploads/2026/08/srku-rkdf-building.jpeg',

                // ── HOMEPAGE - WELCOME SECTION ─────────────────────────────
                'welcome_subtitle' => 'WELCOME TO SRK UNIVERSITY',
                'welcome_title'    => 'Committed Towards Your Better Future Through Academic Excellence',
                'welcome_body_1'   => 'The SRK University is a multidisciplinary university known for its high standards in teaching and research, and attracts eminent scholars to its faculty across the academic spectrum.',
                'welcome_body_2'   => 'The group was established in 1995 under the flagship of the RKDF Group. Ever since its inception, a strong commitment to excellence in teaching and research has made the group a role-model and path-setter for other institutions. Its rich academic tradition has always attracted the most talented students, who later go on to make important contributions to society.',
                'welcome_photo'    => 'assets/uploads/2026/08/welcome-srku-campus.jpeg',

                // ── HOMEPAGE - CHANCELLOR SECTION ──────────────────────────
                'chancellor_name'    => 'Mrs. Janak Kapoor',
                'chancellor_title'   => 'Chancellor',
                'chancellor_photo'   => 'assets/uploads/2026/08/chancellor.jpeg',
                'chancellor_heading' => 'A Legacy of Excellence, A Vision for Tomorrow',
                'chancellor_msg'     => 'It is a matter of great joy that the notification for the establishment of Sarvepalli Radhakrishnan University, Bhopal, has been issued by the State Government.',
                'chancellor_msg2'    => 'In order to maintain quality in the field of higher education in the state, it is an important responsibility of private universities, alongside government universities, to bring about change in research and exploration. It is hoped that Sarvepalli Radhakrishnan University will, in the future, deliver unprecedented performance on quality standards and establish itself as the state\'s foremost institution of education.',

                // ── HOMEPAGE / VC MESSAGE PAGE - VICE CHANCELLOR ───────────
                'vc_name'          => 'Dr. Priyanka Jaiswal',
                'vc_title'         => 'Vice Chancellor',
                'vc_photo'         => 'assets/uploads/2026/07/ruchichaubey.webp',
                'vc_email'         => 'vc@srku.edu.in',
                'vc_heading'       => 'Empowering Minds for a Knowledge Economy',
                'vc_salutation'    => 'Dear Students, Scholars, Faculty Colleagues, and Visitors,',
                'vc_msg'           => 'It is my distinct honor and privilege to welcome you to Sarvepalli Radhakrishnan University (SRKU), Bhopal. As Vice Chancellor, my primary commitment is to create an inspiring, inclusive, and forward-looking academic ecosystem where intellectual rigor meets societal responsibility.',
                'vc_msg2'          => 'Higher education today is experiencing unprecedented transformation. The rapid advancements in Artificial Intelligence, medical biotechnology, renewable energy, smart manufacturing, and digital jurisprudence require universities to reinvent their pedagogical frameworks. At SRKU, our curriculum is strictly benchmarked with National Education Policy (NEP) guidelines and continuously updated in consultation with apex academic bodies and Fortune 500 industry leaders.',
                'vc_msg3'          => 'Our 1,000+ distinguished faculty members—including experienced professors, medical surgeons, scientists, and legal scholars—serve not just as teachers, but as dedicated mentors who nurture the unique talents of each individual student. Through continuous faculty development and active research initiatives, we maintain the highest standards of academic delivery.',
                'vc_msg4'          => 'To all our learners: SRKU is your canvas. Strive for excellence, question conventional thinking, embrace multidisciplinary perspectives, and lead with empathy. Together, let us contribute meaningfully to the advancement of knowledge, human welfare, and the nation.',
                'vc_goals'         => "Choice Based Credit System (CBCS)\nIndustry-Integrated Curriculum & Internships\nInterdisciplinary Research Publications\nGlobal Academic Partnerships & MOUs",
                'vc_full_page_msg' => '',

                // ── WHY SRKU PAGE ──────────────────────────────────────────
                'why_srku_empower_title'  => 'Empowering Minds. Inspiring Innovation. Building Future Leaders.',
                'why_srku_empower_desc'   => 'At SRK University, education is more than earning a degree—it\'s about developing the knowledge, skills, and confidence to succeed in a rapidly changing world. Our multidisciplinary learning environment combines academic excellence, practical exposure, innovation, and industry engagement to prepare students for meaningful careers and lifelong success.',
                'why_srku_reason_1_title' => 'Multidisciplinary Education',
                'why_srku_reason_1_desc'  => 'We offer over 50 diverse programmes spanning Medical, Dental, Nursing, Engineering, Management, Law, Commerce, Agriculture, Science, and Humanities. Students choose courses aligned with their aspirations and the National Education Policy 2020.',
                'why_srku_reason_2_title' => 'State-of-the-Art Infrastructure',
                'why_srku_reason_2_desc'  => 'Our lush green campus spans a cosmopolitan setting with modern laboratories, interactive learning spaces, high-tech medical facilities, and libraries equipped with the latest technology and resources.',
                'why_srku_reason_3_title' => 'NAAC-Graded Excellence',
                'why_srku_reason_3_desc'  => 'SRK University is NAAC-accredited, ensuring quality education meets international standards. Our commitment to continuous improvement and academic rigor sets us apart from other private universities in Bhopal.',
                'why_srku_reason_4_title' => 'Industry & Research Partnerships',
                'why_srku_reason_4_desc'  => 'We foster strong collaborations with leading industries for internships, placements, and research initiatives, ensuring students gain hands-on experience and are job-ready upon graduation.',
                'why_srku_reason_5_title' => 'Diverse Student Community',
                'why_srku_reason_5_desc'  => 'Our campus welcomes students from all corners of India, creating a multicultural environment that enriches learning and promotes cross-cultural understanding.',
                'why_srku_reason_6_title' => 'Holistic Student Development',
                'why_srku_reason_6_desc'  => 'At SRK University, students grow beyond academics through sports, cultural activities, leadership programmes, innovation, and community engagement, building confidence, teamwork, and essential life skills for future success.',

                // ── STUDENT LIFE PAGE ──────────────────────────────────────
                'student_fest_icon'    => 'fas fa-guitar',
                'student_fest_title'   => 'Tarang — Annual Cultural Fest',
                'student_fest_desc'    => 'Three days of star-studded musical concerts, fashion shows, dance competitions, and theatrical performances with 10,000+ attendees.',
                'student_sports_icon'  => 'fas fa-trophy',
                'student_sports_title' => 'Inter-University Sports Meet',
                'student_sports_desc'  => 'Annual tournaments across Cricket, Football, Basketball, Volleyball, Badminton, Table Tennis, and Track & Field athletics.',
                'student_nss_icon'     => 'fas fa-hands-helping',
                'student_nss_title'    => 'NSS & Community Service',
                'student_nss_desc'     => 'Active National Service Scheme units organizing blood donation camps, free health checkups, tree plantation, and rural literacy drives.',
            ];
            // INSERT IGNORE = only seed if key doesn't exist yet.
            // Admin-edited values in DB are NEVER overwritten by sync.
            if ($driver === 'sqlite') {
                $insSetting = $pdo->prepare("INSERT OR IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES (:k, :v)");
            } else {
                $insSetting = $pdo->prepare("INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES (:k, :v)");
            }
            $sCount = 0;
            foreach ($defaultSettings as $sk => $sv) {
                $insSetting->execute([':k' => $sk, ':v' => $sv]);
                $sCount++;
            }

            // Force-correct specific settings that may have wrong values from old syncs.
            // These use UPDATE (not INSERT IGNORE) so they always apply the right value.
            $correctSettings = [
                'vc_name'  => 'Dr. Priyanka Jaiswal',
                'vc_title' => 'Vice Chancellor',
                'vc_email' => 'vc@srku.edu.in',
            ];
            foreach ($correctSettings as $ck => $cv) {
                $pdo->prepare("UPDATE `settings` SET `setting_value` = ? WHERE `setting_key` = ?")->execute([$cv, $ck]);
            }

            $report['counts']['settings'] = (int)$pdo->query("SELECT COUNT(*) FROM `settings`")->fetchColumn();
            $report['messages'][] = "Global University Settings synchronized ($sCount settings verified). VC name corrected.";
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
                    ['Mrs. Janak Kapoor', 'Chancellor', 'leadership', 'Member', 'Chancellor, Sarvepalli Radhakrishnan University', 'Leading policy governance, university growth, philanthropic outreach, and community engagement.', 'fa-user-tie', 'assets/uploads/2026/08/chancellor.jpeg', 2],
                    ['Dr. Priyanka Jaiswal', 'Vice Chancellor', 'leadership', 'Member', 'Vice Chancellor & Senior Academician', 'Eminent academic leader spearheading multidisciplinary innovation, research partnerships, and academic excellence at SRKU.', 'fa-user-graduate', NULL, 3],
                    ['Shri. Ratnesh Jain', 'Member (Sponsoring Body)', 'sponsoring', 'Member', 'Nominee, Sponsoring Body (RKDF Education Society)', 'Distinguished representative contributing to strategic resource planning, institutional expansion, and university development.', 'fa-briefcase', 'assets/uploads/2026/08/shri-ratnesh-jain.jpeg', 4],
                    ['Dr. Amarjeet Singh', 'Member (Sponsoring Body)', 'sponsoring', 'Member', 'Nominee, Sponsoring Body (RKDF Education Society)', 'Senior educationist and policy strategist supporting institutional accreditation, statutory governance, and regulatory compliance.', 'fa-user-check', 'assets/uploads/2026/08/dr-amarjeet-singh.jpeg', 5],
                    ['Dr. Aparna Paliwal', 'Member', 'academic', 'Member', 'Eminent Academician & Professor', 'Senior professor advising the university on outcome-based education, curriculum restructuring, and pedagogical innovations.', 'fa-book-reader', 'assets/uploads/2026/08/dr-aparna-paliwal.jpeg', 6],
                    ['Dr. Vikram Singh', 'Member', 'academic', 'Member', 'Academic & Research Expert', 'Guiding scientific research publications, doctoral review committees, and inter-institutional academic collaborations.', 'fa-microscope', 'assets/uploads/2026/08/dr-vikram-singh.jpeg', 7],
                    ['Mr. Santosh Negi', 'Member', 'administration', 'Member', 'Administrative & Corporate Affairs Expert', 'Providing strategic direction for university operations, corporate liaisons, industry partnerships, and campus affairs.', 'fa-chart-line', 'assets/uploads/2026/08/mr-santosh-negi.jpeg', 8],
                    ['Dr. Neha Dubey', 'Member', 'academic', 'Member', 'Faculty Representative & Academician', 'Representing faculty governance, faculty development initiatives, and interdisciplinary student academic programs.', 'fa-chalkboard-teacher', 'assets/uploads/2026/08/dr-neha-dubey.jpeg', 9],
                    ['Dr. S.S. Pawar', 'Member Secretary & Registrar', 'administration', 'Member Secretary', 'Executive Head of Administration & Registrar', 'Custodian of university records, statutory council affairs, legal regulatory compliance, and university secretariat.', 'fa-id-card', 'assets/uploads/2026/08/dr-ss-pawar.jpeg', 10]
                ];
                $insBoard = $pdo->prepare("INSERT INTO `board_members` (`name`, `designation`, `category`, `role`, `representation`, `bio`, `icon`, `photo`, `sort_order`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')");
                foreach ($boardMembersMaster as $bm) {
                    $insBoard->execute($bm);
                }
                $newCount = (int)$pdo->query("SELECT COUNT(*) FROM `board_members`")->fetchColumn();
                $report['counts']['board_members'] = $newCount;
                $report['messages'][] = "Board of Management synchronized ($newCount members).";
            } else {
                // Ensure existing VC & Chancellor in board_members have valid photos & details
                try {
                    $pdo->prepare("UPDATE `board_members` SET `name` = 'Dr. Priyanka Jaiswal', `photo` = NULL, `representation` = 'Vice Chancellor & Senior Academician' WHERE (`designation` LIKE '%Vice Chancellor%' OR `representation` LIKE '%Vice Chancellor%') AND `photo` LIKE '%ruchichaubey%'")->execute();
                    $pdo->prepare("UPDATE `board_members` SET `photo` = 'assets/uploads/2026/08/chancellor.jpeg' WHERE (`name` LIKE '%Janak%' OR `designation` = 'Chancellor') AND (`photo` IS NULL OR `photo` = '' OR `photo` LIKE '%mrs-janak%')")->execute();
                } catch (Exception $e) {}
                $report['counts']['board_members'] = $currBoardCount;
            }
        }

        // 14. EXAM TIME TABLES
        if ($target === 'all' || $target === 'exam_timetables') {
            $currTimeCount = (int)$pdo->query("SELECT COUNT(*) FROM `exam_timetables`")->fetchColumn();
            if ($currTimeCount == 0 || $force) {
                $cleanTable('exam_timetables');
                $timetablesMaster = [
                    ['Engineering & Polytechnic', 'B.E. VII Sem (reg.& supply)', 'B.E VII Sem (reg.& supply)', 'assets/uploads/time-table/b.e.VII-semester-(regular)(batch-2021-2022).pdf', 'b.e.VII-semester-(regular)(batch-2021-2022).pdf', 1],
                    ['Engineering & Polytechnic', 'M.Tech III semester', 'M.TECH III semester', 'assets/uploads/time-table/M.tech-III-semester(regular).pdf', 'M.tech-III-semester(regular).pdf', 2],
                    ['Management & Computer Application', 'MBA III semester', 'MBA III semester', 'assets/uploads/time-table/MBA-Full-Time-III-semester.pdf', 'MBA-Full-Time-III-semester.pdf', 3],
                    ['Engineering & Polytechnic', 'Diploma V semester regular', 'Diploma V semester regular', 'assets/uploads/time-table/diploma-V-semester(regular)(batch-2022-2023).pdf', 'diploma-V-semester(regular)(batch-2022-2023).pdf', 4],
                    ['Management & Computer Application', 'MCA III semester', 'MCA III semester', 'assets/uploads/time-table/MCA-III-semester.pdf', 'MCA-III-semester.pdf', 5],
                    ['Pharmacy', 'B.Pharm', 'B.PHARMA', 'assets/uploads/time-table/b.pharmacy-VII-semester.pdf', 'b.pharmacy-VII-semester.pdf', 6],
                    ['Agriculture & Allied Sciences', 'Diploma in Agriculture.) VI Semester', 'Diploma (AG.) VI Semester', 'assets/uploads/time-table/Diploma(ag)VI-semester.pdf', 'Diploma(ag)VI-semester.pdf', 7],
                    ['Agriculture & Allied Sciences', 'B.Sc. (Ag.) VIII semester', 'B.Sc. (Ag.) VIII semester', 'assets/uploads/time-table/B.sc-agri-VIII-semester.pdf', 'B.sc-agri-VIII-semester.pdf', 8],
                    ['Agriculture & Allied Sciences', 'M.Sc (AG) III semester', 'M.Sc (AG) III semester', 'assets/uploads/time-table/M.Sc.agriculture(agronomy).pdf', 'M.Sc.agriculture(agronomy).pdf', 9],
                    ['Pharmacy', 'M.Pharm', 'M.PHARMA', 'assets/uploads/time-table/M.pharmacy-III-semester.pdf', 'M.pharmacy-III-semester.pdf', 10],
                    ['Law', 'LL.B.. All Semester Regular', 'L.L.B. All Semester Regular', 'assets/uploads/time-table/LLB-All-semester-regular.pdf', 'LLB-All-semester-regular.pdf', 11],
                    ['Law', 'B.A. LL.B.. semester IX', 'B.A.L.LB. semester IX', 'assets/uploads/time-table/B.A.L.LB.-semester IX.pdf', 'B.A.L.LB.-semester IX.pdf', 12],
                    ['Law', 'LL.M. III semetser', 'LLM III semetser', 'assets/uploads/time-table/LLM-I-&-II-semetser.pdf', 'LLM-I-&-II-semetser.pdf', 13],
                    ['Engineering & Polytechnic', 'PG III SEMester', 'PG III SEMester', 'assets/uploads/time-table/Post-graduation-courses-III-semester(regular).pdf', 'Post-graduation-courses-III-semester(regular).pdf', 14],
                    ['Engineering & Polytechnic', 'B.E. / B.Tech vii semester 2021-2022', 'be / b.tech vii semester 2021-2022', 'assets/uploads/time-table/beb.tech vii sem 2021-2022.pdf', 'beb.tech vii sem 2021-2022.pdf', 15],
                    ['Engineering & Polytechnic', 'B.Tech V semester 2022-2023', 'b.tech V semester 2022-2023', 'assets/uploads/time-table/b.tech III sem 2023-2024.pdf', 'b.tech III sem 2023-2024.pdf', 16],
                    ['Engineering & Polytechnic', 'B.Tech III semester 2023-2024', 'b.tech III semester 2023-2024', 'assets/uploads/time-table/b.tech III sem 2023-2024.pdf', 'b.tech III sem 2023-2024.pdf', 17],
                    ['Engineering & Polytechnic', 'B.E. VIII semester 2020-2021', 'b.e VIII semester 2020-2021', 'assets/uploads/time-table/b.e VIII sem 2020-2021.pdf', 'b.e VIII sem 2020-2021.pdf', 18],
                    ['Engineering & Polytechnic', 'B.Tech VI semester 2021-2022', 'b.tech VI semester 2021-2022', 'assets/uploads/time-table/b.tech VI sem 2021-2022.pdf', 'b.tech VI sem 2021-2022.pdf', 19],
                    ['Engineering & Polytechnic', 'B.Tech IV semester 2022-2023', 'b.tech IV semester 2022-2023', 'assets/uploads/time-table/b.tech IV sem 2022-2023.pdf', 'b.tech IV sem 2022-2023.pdf', 20],
                    ['Engineering & Polytechnic', 'B.Tech II semester 2023-2024', 'b.tech II semester 2023-2024', 'assets/uploads/time-table/b.tech II sem 2023-2024.pdf', 'b.tech II sem 2023-2024.pdf', 21],
                    ['Nursing & Paramedical', 'B.Sc. Nursing 5th semester', 'B.Sc. nursing 5th semester IIIRD YEAR BATCH 2021-2022', 'assets/uploads/time-table/bsc. nursing 5th semester.pdf', 'bsc. nursing 5th semester.pdf', 22],
                    ['Medical, Dental & Ayush', 'MBBS. III (part -1) jan 2025', 'm.b.b.s. III (part -1) jan 2025 M.B.B.S. III (Part -1) JANUARY 2025', 'assets/uploads/time-table/mbbs-III-part-I-jan-2025.pdf', 'mbbs-III-part-I-jan-2025.pdf', 23],
                    ['Medical, Dental & Ayush', 'BAMS SECOND PROFESSIONAL (2021-2022 BATCH)', 'BAMS SECOND PROFESSIONAL (2021-2022 BATCH) BAMS SECOND PROFESSIONAL (2021-2022 BATCH)', 'assets/uploads/time-table/BAMS-SECOND-PROFESSIONAL-2021-22-BACTH.pdf', 'BAMS-SECOND-PROFESSIONAL-2021-22-BACTH.pdf', 24],
                    ['Nursing & Paramedical', 'MPT, BPT, BMLT II YEARS BATCH (2022-2023)', 'MPT, bpt, bmlt II YEARS BATCH (2022-2023) MPT, BPT, BMLT II YEARS BATCH 2022-23', 'assets/uploads/time-table/MPT-II-YEAR-BATCH-2022-2023.pdf', 'MPT-II-YEAR-BATCH-2022-2023.pdf', 25],
                    ['Medical, Dental & Ayush', 'MBBS III PART-1 JANUARY 2025', 'MBBS III PART-1 JANUARY 2025 THEORY EXAMINATION', 'assets/uploads/time-table/MBBS-III-PART-I-JAN-2024-2025.pdf', 'MBBS-III-PART-I-JAN-2024-2025.pdf', 26],
                    ['Nursing & Paramedical', 'D-MLT, D-opto,             D-xray - II YEAR BATCH (2022 -2023)', 'D-MLT, D-opto,             D-xray - II YEAR BATCH (2022 -2023) D-MLT, D-OPTO, D-XRAY - II YEAR BATCH (2022 -2023) , FEB 2025', 'assets/uploads/time-table/DMLT-II-BATCH-2022-23.pdf', 'DMLT-II-BATCH-2022-23.pdf', 27],
                    ['Agriculture & Allied Sciences', 'Allied Pg I Semester', 'allied pg i semester Regular Batch 2023-24 M.Com , M.A.(History), M.A.(Hindi), M.A.(Sociology), M.A.(English), M.S.W. , M.A.(psychology), M.A.(Economics)', 'assets/uploads/time-table/ALLIED-PG-I-SEM.pdf', 'ALLIED-PG-I-SEM.pdf', 28],
                    ['Agriculture & Allied Sciences', 'Allied Pg I Semester', 'allied pg i semester M.Sc.(Maths), M.Sc.(Physics), M.Sc.(Chemistry), M.Sc.(Microbiology), M.Sc.(Botany), M.Sc.(Zoology), M.Sc.(Biotechnology) M.Sc.(Computer Science / Information Technology)', 'assets/uploads/time-table/ALLIED-PG-I-SEM-MCOM.pdf', 'ALLIED-PG-I-SEM-MCOM.pdf', 29],
                    ['Agriculture & Allied Sciences', 'BJMC i semester', 'bjmc i semester Bjmc I Semester(2024-2025 Batch)', 'assets/uploads/time-table/BJMC-I-SEM.pdf', 'BJMC-I-SEM.pdf', 30],
                    ['Management & Computer Application', 'Allied Ug - Iii Year', 'allied ug - iii year B.Sc. Biochenology , Microbiology BCA -IIIyear (2022-2023 Batch)', 'assets/uploads/time-table/Allied-UG-III-years.pdf', 'Allied-UG-III-years.pdf', 31],
                    ['Agriculture & Allied Sciences', 'Allied Ug - Iii Year', 'allied ug - iii year B.Sc. Maths, Computer, Biology (2022-2023 Batch)', 'assets/uploads/time-table/Allied-III-years-computer.pdf', 'Allied-III-years-computer.pdf', 32],
                    ['Agriculture & Allied Sciences', 'Allied Ug - Iii Year', 'allied ug - iii year B.Com (2022-2023 Batch)', 'assets/uploads/time-table/Allied-UG-III-Bcom.pdf', 'Allied-UG-III-Bcom.pdf', 33],
                    ['Agriculture & Allied Sciences', 'Allied Ug - Ii Year', 'allied ug - ii year B.Sc. Maths, Computer , Biology II year (2023-2024 Batch)', 'assets/uploads/time-table/Allied-UG-II-year.pdf', 'Allied-UG-II-year.pdf', 34],
                    ['Management & Computer Application', 'Allied Ug - Ii Year', 'allied ug - ii year BBA , BCA, B.com IIyear (2023-2024 Batch)', 'assets/uploads/time-table/Allied-UG-BBA-BCA-Bcom-II-Year.pdf', 'Allied-UG-BBA-BCA-Bcom-II-Year.pdf', 35],
                    ['Nursing & Paramedical', 'paramedical Diploma Course', 'paramedical Diploma Course DMLT , D. OPTO, D. XRAY II Year (Regular & lateral 2022-23 Batch)', 'assets/uploads/time-table/DMLT-II-BATCH-2022-23.pdf', 'DMLT-II-BATCH-2022-23.pdf', 36],
                    ['Agriculture & Allied Sciences', 'Allied Ug - I Year', 'allied ug - i year B.Sc. Maths, Computer , Biology I year (2024 - 2025 Batch)', 'assets/uploads/time-table/BscMaths-Computer-Biology.pdf', 'BscMaths-Computer-Biology.pdf', 37],
                    ['Agriculture & Allied Sciences', 'Allied Ug - I Year', 'allied ug - i year B.Sc.Bio-Tecgnology , Micobiology I year (2024-2025 Batch)', 'assets/uploads/time-table/Bsc-biotechnology-Microbiology.pdf', 'Bsc-biotechnology-Microbiology.pdf', 38],
                    ['Management & Computer Application', 'Allied Ug - I Year', 'allied ug - i year B.B.A. B.A. B.com I year (2024-2025 Batch)', 'assets/uploads/time-table/BBA-BA-Bcom.pdf', 'BBA-BA-Bcom.pdf', 39],
                    ['Agriculture & Allied Sciences', 'Allied Ug & Pg - I Year', 'allied ug & pg - i year B. LIB , M. LIB I year (2024-2025 Batch)', 'assets/uploads/time-table/Blib-Mlib.pdf', 'Blib-Mlib.pdf', 40],
                    ['Management & Computer Application', 'Allied Ug - I Year', 'allied ug - i year B.C.A. I year (2024-2025 Batch)', 'assets/uploads/time-table/BCA.pdf', 'BCA.pdf', 41],
                    ['Pharmacy', 'B.Pharm i-iiisem', 'b.pharmacy i-iiisem B.Pharmacy I & III Semester (Regular & Lateral 2024-2025 Batch)', 'assets/uploads/time-table/BPharamacy-I-III-sem.pdf', 'BPharamacy-I-III-sem.pdf', 42],
                    ['Agriculture & Allied Sciences', 'B.sc. (Ag), m.sc.(horticulture)', 'B.sc. (Ag), m.sc.(horticulture) B.Sc. (Ag), M.Sc.(Horticulture) 2025 Batch', 'assets/uploads/time-table/BSC-AG-MSC-HORTICULTURE-I-SEM.pdf', 'BSC-AG-MSC-HORTICULTURE-I-SEM.pdf', 43],
                    ['Engineering & Polytechnic', 'B.Tech i semester', 'B.tech i semester B.Tech I Semester (Regular 2024-25 Batch)', 'assets/uploads/time-table/B-TECH-I-SEM-REGULAR.pdf', 'B-TECH-I-SEM-REGULAR.pdf', 44],
                    ['Engineering & Polytechnic', 'B.Tech iii semester', 'b.tech iii semester B.Tech III Semester Lateral (2024-25 Batch)', 'assets/uploads/time-table/B-TECH-III-SEM-LATERAL.pdf', 'B-TECH-III-SEM-LATERAL.pdf', 45],
                    ['Agriculture & Allied Sciences', 'Diploma in Agriculture) i semester', 'Diploma (Ag) i semester Diploma (AG) I Semester 2Year & 3Years', 'assets/uploads/time-table/DIPLOMA-AG-I-SEM-2-3-YEARS.pdf', 'DIPLOMA-AG-I-SEM-2-3-YEARS.pdf', 46],
                    ['Law', 'diploma all Branches i semester', 'diploma all Branches i semester Diploma all Branches I Semester (2024-25 Batch)', 'assets/uploads/time-table/DIPLOMA-ALL-BRANCHES-I-SEM.pdf', 'DIPLOMA-ALL-BRANCHES-I-SEM.pdf', 47],
                    ['Engineering & Polytechnic', 'Diploma Engg. Iii Semester', 'diploma engg. iii semester Diploma Engg. III Semester Lateral (2024-25 Batch)', 'assets/uploads/time-table/DIPLOMA-ENGG-III-SEM-LATERAL.pdf', 'DIPLOMA-ENGG-III-SEM-LATERAL.pdf', 48],
                    ['Law', 'B.a. LL.B. , LL.B. I semester', 'B.a. LLb , llb I semester B.a. LLb , LLB I Semester Regular(2024-25 Batch)', 'assets/uploads/time-table/LLB-BALLB-ISEM.pdf', 'LLB-BALLB-ISEM.pdf', 49],
                    ['Law', 'LL.M. i semester', 'llm i semester LLM I Semester Regular (2024-25 Batch)', 'assets/uploads/time-table/LLM-I-SEM.pdf', 'LLM-I-SEM.pdf', 50],
                    ['Management & Computer Application', 'MBA i semester', 'Mba i semester M.B.A. I Semester Regular(2024-25 Batch)', 'assets/uploads/time-table/MBA-I-SEM.pdf', 'MBA-I-SEM.pdf', 51],
                    ['Management & Computer Application', 'MCA i Semester', 'mca i Semester M.C.A. I Semester Regular(2024-25 Batch)', 'assets/uploads/time-table/MCA-I-SEM.pdf', 'MCA-I-SEM.pdf', 52],
                    ['Pharmacy', 'M.Pharm i sem', 'M.Pharma i sem Pharmaceutics, Pharmacology, Pharmaceutics-Chemistry, Pharmacognosy (2024-25 Batch)', 'assets/uploads/time-table/M-PHARMA-I-SEM.pdf', 'M-PHARMA-I-SEM.pdf', 53],
                    ['Engineering & Polytechnic', 'M.Tech i sem', 'm.tech i sem PE, STR, TII, CS, IT, SE, VLSI, DC, MW (Regular 2024 Batch)', 'assets/uploads/time-table/Mtech-I-semEx-24-25.pdf', 'Mtech-I-semEx-24-25.pdf', 54],
                    ['Management & Computer Application', 'PGDCA, DCA i sem', 'pgdca, dca i sem Pgdca , Dca I Sem (2024 Batch)', 'assets/uploads/time-table/PGDCA-DCA-ISEM.pdf', 'PGDCA-DCA-ISEM.pdf', 55],
                    ['Agriculture & Allied Sciences', 'allied M.A. i semester', 'allied M.A. i semester M.A. I Semester (Sanskrit Literature Batch 2024-25 )', 'assets/uploads/time-table/Allied-i-sem-MA-sanskrit.pdf', 'Allied-i-sem-MA-sanskrit.pdf', 56],
                    ['Nursing & Paramedical', 'B.Sc. Nursing 4th year', 'B.sc. Nursing 4th year B.sc. Nursing 4th year (2020-21 Batch)', 'assets/uploads/time-table/nursing.pdf', 'nursing.pdf', 57],
                    ['Agriculture & Allied Sciences', 'allied M.A. i semester', 'allied M.A. i semester M.A. I Semester (Political Science Batch 2024-25 )', 'assets/uploads/time-table/Allied-pg-i-Sem-PoliticalScience.pdf', 'Allied-pg-i-Sem-PoliticalScience.pdf', 58],
                    ['Medical, Dental & Ayush', 'BDS iii years (2021 -2022)', 'BDS iii years (2021 -2022) Revised Examination Feb. 2025', 'assets/uploads/time-table/BDS_iii_year.pdf', 'BDS_iii_year.pdf', 59],
                    ['Nursing & Paramedical', 'BMLT DMLT ii year', 'bmlt dmlt ii year II YEAR (2022-2023 Batch)', 'assets/uploads/time-table/Bmlt-Dmlt-II-Year.pdf', 'Bmlt-Dmlt-II-Year.pdf', 60],
                    ['Medical, Dental & Ayush', 'BHMS III Year', 'bhms III Year Batch 2021-2022 Regular & Ex.', 'assets/uploads/time-table/Bhms-III-YEAR(Batch2021-22-regular)-Ex.pdf', 'Bhms-III-YEAR(Batch2021-22-regular)-Ex.pdf', 61],
                    ['Medical, Dental & Ayush', 'MBBS III Part 1', 'mbbs III Part 1 Supplementary Examination 2025', 'assets/uploads/time-table/MBBS-III-part-1-Ex.pdf', 'MBBS-III-part-1-Ex.pdf', 62],
                    ['Nursing & Paramedical', 'B.Sc. Nursing 5th Semester', 'B sc Nursing 5th Semester IIIRd Year 2021-2022', 'assets/uploads/time-table/Bsc-Nursing-5th-sem.pdf', 'Bsc-Nursing-5th-sem.pdf', 63],
                    ['Nursing & Paramedical', 'Post Basic B.Sc. Nursing', 'post basic nursing IInd Year (Batch 2022-2023)(supply)', 'assets/uploads/time-table/Bsc-Nursing-5th-sem.pdf', 'Bsc-Nursing-5th-sem.pdf', 64],
                    ['Medical, Dental & Ayush', 'BHMS', 'bhms IV Year (2020-2021 Batch)', 'assets/uploads/time-table/Bhms-IVYear-20-21Batch.pdf', 'Bhms-IVYear-20-21Batch.pdf', 65],
                    ['Medical, Dental & Ayush', 'MD (Homoeopathy))', 'MD (hom) Part-II (2021-2022 Batch)', 'assets/uploads/time-table/Md-hom-part-II-21-22.pdf', 'Md-hom-part-II-21-22.pdf', 66],
                    ['Medical, Dental & Ayush', 'MD (Homoeopathy))', 'MD (Hom) Part-I (2023-2024 Batch)', 'assets/uploads/time-table/Md-hom-part-I-23-24.pdf', 'Md-hom-part-I-23-24.pdf', 67],
                    ['Management & Computer Application', 'MCA', 'MCA III Semester Ex. Batch 2023-24 IV Semester Regular 2023-24', 'assets/uploads/time-table/mca-23-24-III-sem.pdf', 'mca-23-24-III-sem.pdf', 68],
                    ['Pharmacy', 'D.Pharm', 'D. Pharmacy I Year 2023-2024', 'assets/uploads/time-table/D-Pharmacy-I-Year2024-25.pdf', 'D-Pharmacy-I-Year2024-25.pdf', 69],
                    ['Pharmacy', 'D.Pharm', 'D. Pharmacy II Year 2023-24', 'assets/uploads/time-table/DPharmacyIIYear2023-24.pdf', 'DPharmacyIIYear2023-24.pdf', 70],
                    ['Pharmacy', 'B.Pharm', 'B. Pharmacy VII Semester Ex. 2021-22 & Lat. 2022-23, V Semester Ex. 2022-23 & Lat. 2023-24, III Semester 2023-24', 'assets/uploads/time-table/B-PharmacyVIISemEx.pdf', 'B-PharmacyVIISemEx.pdf', 71],
                    ['Pharmacy', 'B.Pharm', 'B. Pharmacy VIII Semester Regular 2021-22 & Lateral 2022-23, VI semester Regular 2022-23, & Lateral 2023-24, IV Semester 2023-24', 'assets/uploads/time-table/B-Pharmacy-VIIIsem.pdf', 'B-Pharmacy-VIIIsem.pdf', 72],
                    ['Pharmacy', 'M.Pharm', 'M. Pharmacy III semester for all specialization Ex. 2023-24', 'assets/uploads/time-table/M-Pharmacy-IIISemAllSpecialization.pdf', 'M-Pharmacy-IIISemAllSpecialization.pdf', 73],
                    ['Law', 'LL.B.', 'LLB V Semester Ex. 2022-23 , III Semester Ex. 2023-24 , Vi Semester Regular 2022-23', 'assets/uploads/time-table/LLB-VSem.pdf', 'LLB-VSem.pdf', 74],
                    ['Law', 'BA LL.B.', 'BA LLB IX semester Ex. 2020-21, VII semester Ex. 2021-22 , V semester Ex. 2022-23 , III semester Ex. 2023-24', 'assets/uploads/time-table/BALLBIXSem.pdf', 'BALLBIXSem.pdf', 75],
                    ['Law', 'BA LL.B.', 'BA LLB X semester Regular 2022-23 , VIII semester Regular 2021-2022 , VI semester 2022-23 , IV semester Regular 2023-24', 'assets/uploads/time-table/BALLBXSem22-23.pdf', 'BALLBXSem22-23.pdf', 76],
                    ['Engineering & Polytechnic', 'Diploma CE,ME', 'Diploma CE,ME VI Semester Regular 2022-23 & Lateral 2023-24 IV Semester Regular 2023-24', 'assets/uploads/time-table/DiplomaCE-ME-IVSemeseter.pdf', 'DiplomaCE-ME-IVSemeseter.pdf', 77],
                    ['Engineering & Polytechnic', 'Diploma CE,ME', 'Diploma CE,ME V semester Ex. 2022-23 & Lateral 2023-24 III semester Ex. 2023-24', 'assets/uploads/time-table/Diploma-CE-ME-V-SemesterEx.pdf', 'Diploma-CE-ME-V-SemesterEx.pdf', 78],
                    ['Engineering & Polytechnic', 'B.E.. B.Tech', 'B.E. B.Tech III Semester Ex. 2023-24 EE, EEE, CE, EC, EI, CS, IT, ME', 'assets/uploads/time-table/Be-Btech-IIISemesterEx.pdf', 'Be-Btech-IIISemesterEx.pdf', 79],
                    ['Engineering & Polytechnic', 'B.E.. B.Tech', 'B.E. B.Tech IV Semester Regular 2023-24 EE , EEE , CE , EC , EI, CS, IT , ME', 'assets/uploads/time-table/Be-Betch-IVSemester.pdf', 'Be-Betch-IVSemester.pdf', 80],
                    ['Engineering & Polytechnic', 'B.E.. B.Tech', 'B.E. B.Tech V Semester Ex. 2022-23 & Lat. 2023-24, EE, EEE, Ce, EC, EI, CS, IT, ME', 'assets/uploads/time-table/Be-Btech-V-Semester.pdf', 'Be-Btech-V-Semester.pdf', 81],
                    ['Engineering & Polytechnic', 'B.E.. B.Tech', 'B.E. B.Tech VI Semester Regula 2022-23 Lateral 2023-24 EE, EEE, CE, EC, EI, CS, IT, ME', 'assets/uploads/time-table/Be-Btech-VIsemester.pdf', 'Be-Btech-VIsemester.pdf', 82],
                    ['Engineering & Polytechnic', 'B.E.. B.Tech', 'B.E. B.Tech VIII Semester Regular 2021-22 & Lateral 2022-23', 'assets/uploads/time-table/Be-Btech-VIIIsemester.pdf', 'Be-Btech-VIIIsemester.pdf', 83],
                    ['Engineering & Polytechnic', 'M.Tech', 'M. Tech III Semester Ex. 2023-24 for PE, STR, TH, CS, IT, SE, VLSI, DC, MW', 'assets/uploads/time-table/Mtech.pdf', 'Mtech.pdf', 84],
                    ['Agriculture & Allied Sciences', 'Allied Post Graduation Courses', 'Allied Post Graduation Courses III semester Ex. 2023-24 M. Com, M.S.W.', 'assets/uploads/time-table/alliedcourses-IIISemesterMcom.pdf', 'alliedcourses-IIISemesterMcom.pdf', 85],
                    ['Agriculture & Allied Sciences', 'Allied Post Graduation Courses', 'Allied Post Graduation Courses III Semester Ex. 2023-24 M.A. Sociology, M.A. English, M.A. Hindi, M.A. History, M.A. Psychology, M.A. Political Science', 'assets/uploads/time-table/allied-courses-IIIsemester-MA.pdf', 'allied-courses-IIIsemester-MA.pdf', 86],
                    ['Agriculture & Allied Sciences', 'Allied Post Graduation Courses', 'Allied Post Graduation Courses III semester Ex. 2023-24 M.Sc. I.T. / Computer Science, M.Sc. Botany, M.Sc. Zoology, M.Sc. Biotechnology, M.Sc. Math\'s, M.Sc. Physics, M.Sc. Chemistry, M.Sc. Microbiology', 'assets/uploads/time-table/allied-courses-computerScience.pdf', 'allied-courses-computerScience.pdf', 87],
                    ['Agriculture & Allied Sciences', 'Allied Post Graduation Courses', 'Allied Post Graduation Courses IV Semester Regular 2023-24 M. Com. M.S.W. , M.A. Geography, M.A. Economics', 'assets/uploads/time-table/alliedCoursesVIsemesterMcom.pdf', 'alliedCoursesVIsemesterMcom.pdf', 88],
                    ['Agriculture & Allied Sciences', 'Allied Post Graduation Courses', 'Allied Post Graduation Courses IV Semester Regular 2023-24 M.A. Sociology, M.A. English , M.A. Hindi, M.A. History, M.A. Psychology, M.A. Political Science', 'assets/uploads/time-table/alliedcourseVIsemester-MA.pdf', 'alliedcourseVIsemester-MA.pdf', 89],
                    ['Agriculture & Allied Sciences', 'Allied Post Graduation Courses', 'Allied Post Graduation Courses IV semester 2023-24M.Sc. (I.T.)/Computer Science, M.Sc. Botany , M.Sc. Zoology M.Sc. Biotechnology M.Sc. Maths , M.Sc. Physics , M.Sc. Chemistry, M.Sc. Microbiology', 'assets/uploads/time-table/alliedCoursesVIsemestercomputerscience.pdf', 'alliedCoursesVIsemestercomputerscience.pdf', 90],
                    ['Management & Computer Application', 'PGDCA', 'PGDCA II semester regular 2024-25 , DCA II semester Regular 2024-25 , I semester Ex. 2024-25 , DCA I semester Ex. 2024-25', 'assets/uploads/time-table/pgdca-ii-semester.pdf', 'pgdca-ii-semester.pdf', 91],
                    ['Management & Computer Application', 'MBA FT', 'MBA FT Dual Specialization IV semester Regular 2023-24', 'assets/uploads/time-table/mbaftdaulspecialization.pdf', 'mbaftdaulspecialization.pdf', 92],
                    ['Management & Computer Application', 'MBA FT', 'MBA FT Hospital Management IV semester Regular 2023-24', 'assets/uploads/time-table/mbahospitalmanagement.pdf', 'mbahospitalmanagement.pdf', 93],
                    ['Agriculture & Allied Sciences', 'B.Sc. (Hons) Agriculture', 'B.Sc. Agriculture VIII semester 2021-22 , B.Sc. Hons. Agriculture II Year IV Semester', 'assets/uploads/time-table/diploma-ag-VI-IVsem.pdf', 'diploma-ag-VI-IVsem.pdf', 94],
                    ['Agriculture & Allied Sciences', 'Diploma AGriculture', 'Diploma AGriculture Diploma AgricultureVI Semester 2022-23 IV Semester 2023-24', 'assets/uploads/time-table/diploma-ag-VI-IVsem.pdf', 'diploma-ag-VI-IVsem.pdf', 95],
                    ['Law', 'LL.M.', 'LLM IV Semester Regular 2023-24 III semester (Ex.)2023-24', 'assets/uploads/time-table/LLMIIIsemester.pdf', 'LLMIIIsemester.pdf', 96],
                    ['Agriculture & Allied Sciences', 'Allied Post Graduation Course', 'Allied Post Graduation Course II Semester for Political Science & I Semester for Political Science Ex./Supply', 'assets/uploads/time-table/Alied-pg-regular-and-supply24-25.pdf', 'Alied-pg-regular-and-supply24-25.pdf', 97],
                    ['Agriculture & Allied Sciences', 'BJMC', 'BJMC II Semester Regular 2024-25', 'assets/uploads/time-table/BJMC-II-Semester-Regular24-25.pdf', 'BJMC-II-Semester-Regular24-25.pdf', 98],
                    ['Pharmacy', 'B.Pharm', 'b Pharmacy I Semester Ex. 2024-25 II Semester Regular 2024-25 III Semester Lat Ex 2024-25 IV Semester Lateral & Regular 2024-25', 'assets/uploads/time-table/Bpharma-Isem-24-25.pdf', 'Bpharma-Isem-24-25.pdf', 99],
                    ['Agriculture & Allied Sciences', 'B.Sc. (Hons) Agriculture', 'B sc Agriculture II Semester Regular 2024-25', 'assets/uploads/time-table/Bsc-Agri-II.pdf', 'Bsc-Agri-II.pdf', 100],
                    ['Nursing & Paramedical', 'B.Sc. Nursing', 'B.sc. Nursing V Semester III Year 2022-23 Batch', 'assets/uploads/time-table/bsc-nursing-5-IIIyear.pdf', 'bsc-nursing-5-IIIyear.pdf', 101],
                    ['Engineering & Polytechnic', 'B.Tech', 'b. tech Ex. I Semester 2024-25 For EE, EEE, CE, EC, EI, CS, IT, ME', 'assets/uploads/time-table/bTech-I-ex.pdf', 'bTech-I-ex.pdf', 102],
                    ['Engineering & Polytechnic', 'B.Tech', 'b. tech Regular II Semester 2024-25 For EE, EEE, CE, EC, EI, CS, IT, ME', 'assets/uploads/time-table/Btech-II-24-25.pdf', 'Btech-II-24-25.pdf', 103],
                    ['Engineering & Polytechnic', 'B.Tech', 'b. tech Lateral Ex. III Semester 2024-25 For EE, EEE, CE, EC, EI, CS, IT, ME', 'assets/uploads/time-table/Btech-III-sem-ex-24-25.pdf', 'Btech-III-sem-ex-24-25.pdf', 104],
                    ['Engineering & Polytechnic', 'B.Tech', 'b. tech Lateral & Regular IV Semester 2024-25 For EE, EEE, CE, EC, EI, CS, IT, ME', 'assets/uploads/time-table/BTech-IV_SEM_Lateral_reg24-25.pdf', 'BTech-IV_SEM_Lateral_reg24-25.pdf', 105],
                    ['Agriculture & Allied Sciences', 'Diploma in Agriculture', 'Diploma in agriculture Regular II Semester 2024-25 Batch', 'assets/uploads/time-table/diploma-agri-IISem-24-25.pdf', 'diploma-agri-IISem-24-25.pdf', 106],
                    ['Engineering & Polytechnic', 'Diploma in Engineering.', 'Diploma in engg. I Semester Batch 2024-25', 'assets/uploads/time-table/diploma-engg-ex.pdf', 'diploma-engg-ex.pdf', 107],
                    ['Engineering & Polytechnic', 'Diploma in Engineering.', 'Diploma in engg. Lateral III Semester 2024-25', 'assets/uploads/time-table/Diploma-eng-IIIsem-lateral24-25.pdf', 'Diploma-eng-IIIsem-lateral24-25.pdf', 108],
                    ['Engineering & Polytechnic', 'Diploma in Engineering.', 'Diploma in engg. II Semester Regular 2024-25 Batch', 'assets/uploads/time-table/diploma-IISem-24-25.pdf', 'diploma-IISem-24-25.pdf', 109],
                    ['Engineering & Polytechnic', 'Diploma in Engineering.', 'Diploma in engg. IV Semester Lateral & Regular 2024-25 Batch', 'assets/uploads/time-table/Diploma-IV-sem-lateralRegular-24-25.pdf', 'Diploma-IV-sem-lateralRegular-24-25.pdf', 110],
                    ['Law', 'Law Courses', 'Law Courses LLB II semester Regular LLB I Semester Ex. BA-LLB II Semester Regular BA-LLB I Semester Ex. 2024-25', 'assets/uploads/time-table/LLB-IISem-Regular24-25.pdf', 'LLB-IISem-Regular24-25.pdf', 111],
                    ['Law', 'LL.M.', 'LLM II Semester Regular 2024-25 Batch.', 'assets/uploads/time-table/LLM_II_sem-Regular24-25.pdf', 'LLM_II_sem-Regular24-25.pdf', 112],
                    ['Management & Computer Application', 'MBA.', 'M.B.A. II Semester Regular 2024-25 Batch Ex. 2023-24 Batch', 'assets/uploads/time-table/MBA-II-ex.pdf', 'MBA-II-ex.pdf', 113],
                    ['Management & Computer Application', 'MCA.', 'M.c.a. I Semester Ex. 2024-25 Batch. II Semester Regular 2024-25', 'assets/uploads/time-table/MCA-I-semEx-24-25.pdf', 'MCA-I-semEx-24-25.pdf', 114],
                    ['Pharmacy', 'M.Pharm', 'M Pharma I Semester Pharmaceutics 2024-25 Ex. I Semester Pharmaceutics Chemistry Batch 204-25 Ex. I Semester Pharmacology Batch 204-25 Ex. I Semester Pharmacognosy Batch 204-25 Ex. I Semester Quality Assurance MQA Batch 204-25 Ex.', 'assets/uploads/time-table/M-pharma-I.pdf', 'M-pharma-I.pdf', 115],
                    ['Nursing & Paramedical', 'B.Sc. Nursing', 'B.Sc. Nursing B.Sc. Nursing 1St. Semester 1St. Year Batch 2024-25', 'assets/uploads/time-table/Bsc-nursing.pdf', 'Bsc-nursing.pdf', 116],
                    ['Medical, Dental & Ayush', 'MBBS', 'MBBS MBBS Second Professional Years CBME Batch 2023-2024', 'assets/uploads/time-table/MBBS-IIYear.pdf', 'MBBS-IIYear.pdf', 117],
                    ['Nursing & Paramedical', 'Paramedical', 'Paramedical ISt. Years Batch (2023-2024) Diploma in Naturopathy Diploma in Pharmacy (Ayurvedic) Diploma in Pharmacy (Homoeopathy) Diploma in Ophthalmic Assistant', 'assets/uploads/time-table/paramedical.pdf', 'paramedical.pdf', 118],
                    ['Nursing & Paramedical', 'Paramedical', 'Paramedical ISt. Years Batch (2023-2024) Bachelor in Human Nutrition DMLT D-OPTO D-XRAY Diploma in Dialysis Technician', 'assets/uploads/time-table/human-nutrition.pdf', 'human-nutrition.pdf', 119],
                    ['Nursing & Paramedical', 'Paramedical', 'Paramedical ISt. Years Batch (2023-2024) MPT MMLT BPT BMLT', 'assets/uploads/time-table/MPT.pdf', 'MPT.pdf', 120],
                    ['Medical, Dental & Ayush', 'BHMS', 'bmhs ISt. Year Regular Batch 2023- 2024', 'assets/uploads/time-table/BMHS-I-YEAR-REGULAR.pdf', 'BMHS-I-YEAR-REGULAR.pdf', 121],
                    ['Nursing & Paramedical', 'BHMS', 'bmhs IINd. Year Regular Batch 2022-2023', 'assets/uploads/time-table/MPT.pdf', 'MPT.pdf', 122],
                    ['Nursing & Paramedical', 'BPT', 'BPT IV Year Batch 2021-22', 'assets/uploads/time-table/BPT-IV-Year-Batch-2021-22.pdf', 'BPT-IV-Year-Batch-2021-22.pdf', 123],
                    ['Medical, Dental & Ayush', 'BDS', 'BDS I Year Batch 2024-2025 II Year Batch 2023-2024 III Year Batch 2022-2023', 'assets/uploads/time-table/bds.pdf', 'bds.pdf', 124],
                    ['Medical, Dental & Ayush', 'MDS', 'MDS I Part Batch 2024-2025', 'assets/uploads/time-table/MDS-24-25.pdf', 'MDS-24-25.pdf', 125],
                    ['Medical, Dental & Ayush', 'MDS', 'MDS II Part Batch 2022-2023', 'assets/uploads/time-table/MDS.pdf', 'MDS.pdf', 126],
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

        // 19. DYNAMIC GLOBAL SEO & META INVENTORY
        if ($target === 'all' || $target === 'seo_metadata') {
            $seoSyncRes = syncSeoPagesInventory($pdo, $force);
            $newSeoCount = (int)$pdo->query("SELECT COUNT(*) FROM `seo_metadata`")->fetchColumn();
            $report['counts']['seo_metadata'] = $newSeoCount;
            $report['messages'][] = "Dynamic SEO & Meta Inventory synchronized ({$newSeoCount} active site routes indexed).";
        }

        // 20. AUTOMATIC PRODUCTION SQL EXPORT (srku_db.sql)
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
    $targetFile = $baseDir . '/srku_db_new.sql';

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

        // Also keep srku_db.sql in sync for backward compatibility
        $oldSqlFile = $baseDir . '/srku_db.sql';
        file_put_contents($oldSqlFile, $out);

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

/**
 * ══════════════════════════════════════════════════════════════════════════════
 * DYNAMIC GLOBAL SEO & META MANAGER ENGINE
 * ══════════════════════════════════════════════════════════════════════════════
 */

/**
 * Automatically inventories all website portal routes, CMS pages, dynamic course & department pages,
 * syllabi categories, and static modules into the seo_metadata table without overwriting customized values.
 */
function syncSeoPagesInventory($pdo = null, $force = false) {
    if (!$pdo) {
        $pdo = getDBConnection();
    }

    $existingStmt = $pdo->prepare("SELECT id, meta_title, meta_description, focus_keywords, canonical_url, robots_tag, og_title, og_description, og_image, twitter_card, schema_json FROM seo_metadata WHERE page_identifier = :pi LIMIT 1");
    $insertStmt = $pdo->prepare("INSERT INTO seo_metadata (page_identifier, page_name, page_category, meta_title, meta_description, focus_keywords, canonical_url, robots_tag, og_title, og_description, og_image, twitter_card, schema_json) VALUES (:pi, :pn, :pc, :mt, :md, :fk, :cu, :rt, :ot, :od, :oi, :tc, :sj)");
    $updateStmt = $pdo->prepare("UPDATE seo_metadata SET page_name = :pn, page_category = :pc WHERE page_identifier = :pi");

    $siteName = defined('SITE_NAME') ? SITE_NAME : 'Sarvepalli Radhakrishnan University (SRKU)';
    $baseUrl = defined('BASE_URL') ? BASE_URL : 'https://srku.edu.in/';

    $pagesCatalog = [
        // 1. PORTAL PAGES
        [
            'identifier' => 'index.php',
            'name' => 'Home Page',
            'category' => 'Portal Pages',
            'title' => 'Sarvepalli Radhakrishnan University (SRKU), Bhopal | Official Portal',
            'desc' => 'Sarvepalli Radhakrishnan University (SRKU) Bhopal is a premier multidisciplinary private university in Madhya Pradesh offering UGC, AICTE, NMC, PCI, BCI approved programmes.',
            'keywords' => 'SRK University, Sarvepalli Radhakrishnan University, SRKU Bhopal, Admissions 2026-27, UGC Approved University MP, AICTE Approved Engineering College, NMC Approved Medical College Bhopal',
            'canonical' => $baseUrl
        ],
        [
            'identifier' => 'about.php',
            'name' => 'About SRK University',
            'category' => 'Portal Pages',
            'title' => 'About Us | Sarvepalli Radhakrishnan University (SRKU), Bhopal',
            'desc' => 'Discover Sarvepalli Radhakrishnan University (SRKU) Bhopal - our legacy, accreditations, educational leadership, sprawling 100+ acre campus, and academic excellence.',
            'keywords' => 'About SRKU Bhopal, Sarvepalli Radhakrishnan University history, RKDF Group university, UGC approved university MP, private university Bhopal',
            'canonical' => $baseUrl . 'about.php'
        ],
        [
            'identifier' => 'founder-story.php',
            'name' => "Founder's Vision & Story",
            'category' => 'Portal Pages',
            'title' => 'Founder Patron Story - Dr. Sunil Kapoor | SRKU Bhopal',
            'desc' => 'Learn about the visionary journey of Founder Patron Dr. Sunil Kapoor and his lifelong dedication to affordable healthcare, quality education, and nation-building.',
            'keywords' => 'Dr Sunil Kapoor SRKU, RKDF founder, Sunil Kapoor visionary educationist Bhopal, SRKU leadership',
            'canonical' => $baseUrl . 'founder-story.php'
        ],
        [
            'identifier' => 'chancellor-message.php',
            'name' => "Chancellor's Message",
            'category' => 'Portal Pages',
            'title' => 'Chancellor Desk - Mrs. Janak Kapoor | SRK University Bhopal',
            'desc' => 'Official message and welcome from Mrs. Janak Kapoor, Honorable Chancellor of Sarvepalli Radhakrishnan University (SRKU) Bhopal.',
            'keywords' => 'Chancellor SRKU, Janak Kapoor Chancellor SRKU, Chancellor message SRK University Bhopal',
            'canonical' => $baseUrl . 'chancellor-message.php'
        ],
        [
            'identifier' => 'vice-chancellor-message.php',
            'name' => "Vice Chancellor's Message",
            'category' => 'Portal Pages',
            'title' => 'Vice Chancellor Desk - Dr. Priyanka Jaiswal | SRKU Bhopal',
            'desc' => 'Official message from Dr. Priyanka Jaiswal, Vice Chancellor of Sarvepalli Radhakrishnan University (SRKU) Bhopal.',
            'keywords' => 'Vice Chancellor SRKU, Dr Priyanka Jaiswal VC SRKU, Vice chancellor address SRKU Bhopal',
            'canonical' => $baseUrl . 'vice-chancellor-message.php'
        ],
        [
            'identifier' => 'vision-mission.php',
            'name' => 'Vision, Mission & Core Values',
            'category' => 'Portal Pages',
            'title' => 'Vision, Mission & Core Values | Sarvepalli Radhakrishnan University',
            'desc' => 'Our vision is to emerge as a world-class university providing students transformative learning in science, technology, medicine, and management.',
            'keywords' => 'SRKU vision mission, SRKU core values, educational motto Learn about Education that helps Society',
            'canonical' => $baseUrl . 'vision-mission.php'
        ],
        [
            'identifier' => 'why-srk.php',
            'name' => 'Why Choose SRK University',
            'category' => 'Portal Pages',
            'title' => 'Why Choose SRKU? | Top Private University in Bhopal, MP',
            'desc' => 'Explore why over 20,000 students choose SRKU Bhopal for top placements, 600+ faculty, 42+ labs, 750-bed hospital, and global corporate tie-ups.',
            'keywords' => 'Why SRKU, Best private university Bhopal, SRKU placement statistics, top campus Bhopal MP',
            'canonical' => $baseUrl . 'why-srk.php'
        ],
        [
            'identifier' => 'board-members.php',
            'name' => 'Board of Governance',
            'category' => 'Portal Pages',
            'title' => 'Board of Governance & Leadership | SRKU Bhopal',
            'desc' => 'Meet the executive governing body and visionary leaders directing Sarvepalli Radhakrishnan University Bhopal.',
            'keywords' => 'SRKU board members, governance Sarvepalli Radhakrishnan University, leadership team Bhopal',
            'canonical' => $baseUrl . 'board-members.php'
        ],
        [
            'identifier' => 'board-of-management.php',
            'name' => 'Board of Management',
            'category' => 'Portal Pages',
            'title' => 'Board of Management | Sarvepalli Radhakrishnan University',
            'desc' => 'Official Board of Management members of SRKU Bhopal responsible for academic governance and strategic direction.',
            'keywords' => 'SRKU Board of Management, academic council Bhopal, SRKU administrators',
            'canonical' => $baseUrl . 'board-of-management.php'
        ],
        [
            'identifier' => 'admission-enquiry.php',
            'name' => 'Admissions & Online Enquiry 2026-27',
            'category' => 'Portal Pages',
            'title' => 'Admissions Open 2026-27 | Apply Online | SRKU Bhopal',
            'desc' => 'Apply online for Undergraduate, Postgraduate, Diploma, and PhD programs at Sarvepalli Radhakrishnan University Bhopal for the academic session 2026-27.',
            'keywords' => 'SRKU admission 2026, admission form SRKU Bhopal, apply online SRK University, engineering admission Bhopal, pharmacy admission MP, medical admission Bhopal',
            'canonical' => $baseUrl . 'admission-enquiry.php'
        ],
        [
            'identifier' => 'contact.php',
            'name' => 'Contact Us & Campus Location',
            'category' => 'Portal Pages',
            'title' => 'Contact Us | Sarvepalli Radhakrishnan University Bhopal',
            'desc' => 'Get in touch with SRKU Bhopal. Helpline numbers, admission enquiry desk, registrar email, and NH-12 Misrod campus address.',
            'keywords' => 'SRKU contact number, SRKU Bhopal address, SRKU helpline, exam department email Bhopal',
            'canonical' => $baseUrl . 'contact.php'
        ],
        [
            'identifier' => 'placements.php',
            'name' => 'Training & Placements',
            'category' => 'Portal Pages',
            'title' => 'Placement Record & Recruiting Partners | SRKU Bhopal',
            'desc' => 'SRKU Bhopal placement highlights: 94% placement record, 12 LPA highest package, and top recruiters like TCS, Infosys, Wipro, and Cipla.',
            'keywords' => 'SRKU placements, highest package SRKU Bhopal, recruiting companies RKDF, campus placement 2026',
            'canonical' => $baseUrl . 'placements.php'
        ],
        [
            'identifier' => 'facilities.php',
            'name' => 'Campus Facilities & Infrastructure',
            'category' => 'Portal Pages',
            'title' => 'Campus Infrastructure & Facilities | SRKU Bhopal',
            'desc' => 'Explore world-class facilities at SRKU Bhopal including modern digital classrooms, 750-bed teaching hospital, sports complex, high-speed Wi-Fi, and transport.',
            'keywords' => 'SRKU campus facilities, university hospital Bhopal, smart classrooms, sports ground SRKU',
            'canonical' => $baseUrl . 'facilities.php'
        ],
        [
            'identifier' => 'accreditation.php',
            'name' => 'Accreditations & Approvals',
            'category' => 'Portal Pages',
            'title' => 'Accreditations & Statutory Recognitions | UGC, AICTE, NMC | SRKU',
            'desc' => 'SRKU Bhopal is recognized under UGC 2(f) and approved by apex councils including AICTE, NMC, PCI, BCI, INC, DCI, NCISM, NCH, and AIU.',
            'keywords' => 'UGC approved university MP, AICTE approval SRKU, NMC recognized medical college Bhopal, PCI approval pharmacy',
            'canonical' => $baseUrl . 'accreditation.php'
        ],
        [
            'identifier' => 'gallery.php',
            'name' => 'Photo & Video Gallery',
            'category' => 'Portal Pages',
            'title' => 'Campus Photo & Video Gallery | SRKU Bhopal',
            'desc' => 'Visual glimpse into campus life, student events, convocation ceremonies, state-of-the-art laboratories, and sports meets at SRKU Bhopal.',
            'keywords' => 'SRKU campus photos, SRKU videos, convocation ceremony photos, annual fest photos Bhopal',
            'canonical' => $baseUrl . 'gallery.php'
        ],
        [
            'identifier' => 'news.php',
            'name' => 'News, Notices & Circulars',
            'category' => 'Portal Pages',
            'title' => 'Latest News, Circulars & Announcements | SRKU Bhopal',
            'desc' => 'Stay updated with recent university announcements, exam notices, academic schedules, events, and workshops at SRKU Bhopal.',
            'keywords' => 'SRKU notices, exam circulars, university news Bhopal, latest events Sarvepalli Radhakrishnan University',
            'canonical' => $baseUrl . 'news.php'
        ],
        [
            'identifier' => 'blogs.php',
            'name' => 'Blogs & Knowledge Hub',
            'category' => 'Portal Pages',
            'title' => 'Articles & Knowledge Hub | SRKU Bhopal',
            'desc' => 'Insights, career guidance, student stories, and academic research articles published by faculty and students at SRKU Bhopal.',
            'keywords' => 'SRKU blog, career guidance articles, student campus stories, academic insights Bhopal',
            'canonical' => $baseUrl . 'blogs.php'
        ],
        [
            'identifier' => 'research-innovation.php',
            'name' => 'Research & Innovation',
            'category' => 'Portal Pages',
            'title' => 'Research, Publications & Patents | SRKU Bhopal',
            'desc' => 'Advancing knowledge with 1,400+ research papers, 160+ published patents, and active R&D collaborations across science, healthcare, and engineering.',
            'keywords' => 'SRKU research, published patents university Bhopal, journal publications, R&D centre MP',
            'canonical' => $baseUrl . 'research-innovation.php'
        ],
        [
            'identifier' => 'incubation-center.php',
            'name' => 'Incubation & Startup Centre',
            'category' => 'Portal Pages',
            'title' => 'SRKU Innovation & Incubation Centre | Startup Hub Bhopal',
            'desc' => 'SRKU Incubation Centre nurtures student entrepreneurship, patent filing, prototype development, and seed funding support for tech and healthcare startups.',
            'keywords' => 'SRKU incubation centre, startup cell Bhopal, student entrepreneurship, patent support MP',
            'canonical' => $baseUrl . 'incubation-center.php'
        ],
        [
            'identifier' => 'alumni.php',
            'name' => 'Alumni Association',
            'category' => 'Portal Pages',
            'title' => 'Global Alumni Network & Association | SRKU Bhopal',
            'desc' => 'Join our thriving network of 1,10,000+ SRKU alumni working in top multinational corporations, healthcare institutions, and public service across the globe.',
            'keywords' => 'SRKU alumni association, alumni network Bhopal, notable alumni RKDF group',
            'canonical' => $baseUrl . 'alumni.php'
        ],
        [
            'identifier' => 'career.php',
            'name' => 'Careers & Faculty Recruitment',
            'category' => 'Portal Pages',
            'title' => 'Careers & Faculty Recruitment 2026 | SRKU Bhopal',
            'desc' => 'Join the academic team at SRKU Bhopal. Explore open faculty, research associate, and administrative positions across various faculties.',
            'keywords' => 'SRKU jobs, faculty recruitment Bhopal, professor vacancy MP, university careers',
            'canonical' => $baseUrl . 'career.php'
        ],
        [
            'identifier' => 'grievance.php',
            'name' => 'Online Grievance Redressal',
            'category' => 'Portal Pages',
            'title' => 'Online Grievance Redressal Portal | SRKU Bhopal',
            'desc' => 'Submit academic, administrative, or student grievances directly to the internal university grievance redressal cell for prompt resolution.',
            'keywords' => 'SRKU grievance cell, student complaint redressal, online grievance form Bhopal',
            'canonical' => $baseUrl . 'grievance.php'
        ],
        [
            'identifier' => 'student-life.php',
            'name' => 'Student Life & Clubs',
            'category' => 'Portal Pages',
            'title' => 'Student Life, Clubs & Cultural Activities | SRKU Bhopal',
            'desc' => 'Discover vibrant student life at SRKU with cultural fests, tech symposiums, sports leagues, social clubs, and hobby societies.',
            'keywords' => 'Student life SRKU, cultural fest Bhopal, college clubs, youth festival',
            'canonical' => $baseUrl . 'student-life.php'
        ],
        [
            'identifier' => 'hostel.php',
            'name' => 'Hostel & Accommodation',
            'category' => 'Portal Pages',
            'title' => 'Hostel Facilities & Student Accommodation | SRKU Bhopal',
            'desc' => 'Comfortable, secure on-campus residential hostels for boys and girls with 24/7 security, nutritious dining, Wi-Fi, and recreation rooms.',
            'keywords' => 'SRKU hostel fees, boys hostel Bhopal, girls hostel SRKU, university accommodation',
            'canonical' => $baseUrl . 'hostel.php'
        ],
        [
            'identifier' => 'sitemap.php',
            'name' => 'HTML Website Sitemap',
            'category' => 'Portal Pages',
            'title' => 'Complete Website Sitemap | SRKU Bhopal',
            'desc' => 'Complete hierarchical sitemap of Sarvepalli Radhakrishnan University Bhopal pages, courses, departments, exams, and student services.',
            'keywords' => 'SRKU sitemap, all website links, navigation map',
            'canonical' => $baseUrl . 'sitemap.php'
        ],
        [
            'identifier' => 'phd-admission.php',
            'name' => 'PhD Admissions & Research',
            'category' => 'Portal Pages',
            'title' => 'PhD Admissions 2026-27 | Doctoral Research Programs | SRKU',
            'desc' => 'Admissions open for PhD programs in Engineering, Pharmacy, Management, Science, Computer Applications, and Healthcare at SRKU Bhopal.',
            'keywords' => 'PhD admission Bhopal, PhD in Engineering MP, PhD in Pharmacy, doctoral entrance test SRKU',
            'canonical' => $baseUrl . 'phd-admission.php'
        ],
        [
            'identifier' => 'phd-entrance-form.php',
            'name' => 'PhD Entrance Registration Form',
            'category' => 'Portal Pages',
            'title' => 'PhD Entrance Exam Registration Form | SRKU Bhopal',
            'desc' => 'Online application form for SRKU PhD Entrance Examination and fellowship registration.',
            'keywords' => 'PhD entrance form, doctoral registration, research entrance exam Bhopal',
            'canonical' => $baseUrl . 'phd-entrance-form.php'
        ],
        [
            'identifier' => 'phd-application-form.php',
            'name' => 'PhD Application Form',
            'category' => 'Portal Pages',
            'title' => 'Doctoral Application Form | PhD Programs | SRKU Bhopal',
            'desc' => 'Official doctoral candidate registration and synopsis submission application form for SRKU Bhopal.',
            'keywords' => 'PhD application form, synopsis format SRKU, doctoral candidate form',
            'canonical' => $baseUrl . 'phd-application-form.php'
        ],

        // 2. CORE & DATABASE PAGES
        [
            'identifier' => 'courses.php',
            'name' => 'All Courses & Degree Programs Catalog',
            'category' => 'Core & Database',
            'title' => 'All Academic Courses & Degree Programs | SRKU Bhopal',
            'desc' => 'Browse 120+ UG, PG, Diploma, and Doctoral courses in Engineering, Pharmacy, Management, Medicine, Nursing, Law, and Agriculture at SRKU Bhopal.',
            'keywords' => 'SRKU courses, degree programs Bhopal, engineering branches, pharmacy courses, MBA admission Bhopal',
            'canonical' => $baseUrl . 'courses.php'
        ],
        [
            'identifier' => 'departments.php',
            'name' => 'Constituent Units & Colleges',
            'category' => 'Core & Database',
            'title' => 'Constituent Institutes & Colleges | SRKU Bhopal',
            'desc' => 'Explore constituent colleges of SRKU including RKDF Institute of Science & Technology, Faculty of Pharmacy, Medical College, and Law Institute.',
            'keywords' => 'SRKU constituent colleges, RKDF institutes, engineering college Bhopal, pharmacy institute',
            'canonical' => $baseUrl . 'departments.php'
        ],
        [
            'identifier' => 'faculties.php',
            'name' => 'Faculty Directory',
            'category' => 'Core & Database',
            'title' => 'Faculty Directory & Academic Staff | SRKU Bhopal',
            'desc' => 'Directory of 600+ distinguished professors, deans, and researchers guiding students at Sarvepalli Radhakrishnan University Bhopal.',
            'keywords' => 'SRKU faculty list, professors Bhopal, faculty directory Sarvepalli Radhakrishnan University',
            'canonical' => $baseUrl . 'faculties.php'
        ],
        [
            'identifier' => 'document-viewer.php',
            'name' => 'Official Document & PDF Viewer',
            'category' => 'Core & Database',
            'title' => 'Official University Document & PDF Viewer | SRKU Bhopal',
            'desc' => 'Read verified statutory approvals, ordinances, and academic circulars in the official SRKU document viewer.',
            'keywords' => 'SRKU documents, university approval letter, syllabus pdf viewer',
            'canonical' => $baseUrl . 'document-viewer.php'
        ],

        // 3. ACADEMIC & EXAM PAGES
        [
            'identifier' => 'exam-time-table.php',
            'name' => 'Exam Time Tables & Schedules',
            'category' => 'Academic & Exam',
            'title' => 'Examination Time Tables & Schedules | SRKU Bhopal',
            'desc' => 'Download official examination time tables, semester schedules, and date sheets for all courses at SRKU Bhopal.',
            'keywords' => 'SRKU exam time table, date sheet 2026, semester exam schedule Bhopal, exam notifications',
            'canonical' => $baseUrl . 'exam-time-table.php'
        ],
        [
            'identifier' => 'exam-rules.php',
            'name' => 'Exam Rules, Ordinances & Forms',
            'category' => 'Academic & Exam',
            'title' => 'Exam Rules, Ordinances & Revaluation Forms | SRKU Bhopal',
            'desc' => 'Academic examination statutes, ordinances, degree application forms, and revaluation guidelines of SRKU Bhopal.',
            'keywords' => 'SRKU exam rules, degree application form, revaluation rules Bhopal, examination statutes',
            'canonical' => $baseUrl . 'exam-rules.php'
        ],
        [
            'identifier' => 'academic-calendar.php',
            'name' => 'University Academic Calendar',
            'category' => 'Academic & Exam',
            'title' => 'University Academic Calendar 2026-27 | SRKU Bhopal',
            'desc' => 'Download official odd and even semester academic calendars, teaching days, and vacation schedules of SRKU Bhopal.',
            'keywords' => 'SRKU academic calendar 2026, odd semester calendar, even semester dates, teaching days schedule',
            'canonical' => $baseUrl . 'academic-calendar.php'
        ],
        [
            'identifier' => 'syllabus.php',
            'name' => 'Syllabus & Schemes Repository',
            'category' => 'Academic & Exam',
            'title' => 'Download Course Syllabus & Schemes | SRKU Bhopal',
            'desc' => 'Download official semester-wise curriculum syllabus and evaluation schemes for Engineering, Pharmacy, Management, and Science programs.',
            'keywords' => 'SRKU syllabus, scheme of examination, course curriculum pdf, semester scheme Bhopal',
            'canonical' => $baseUrl . 'syllabus.php'
        ],

        // 4. STATIC SHOWCASE PAGES
        [
            'identifier' => 'rkdf-ist-student-feedback.php',
            'name' => 'RKDF-IST Student Feedback Portal',
            'category' => 'Static Showcase',
            'title' => 'Student Academic Feedback | RKDF-IST | SRKU',
            'desc' => 'Submit course feedback and faculty evaluations for RKDF Institute of Science & Technology.',
            'keywords' => 'RKDF-IST student feedback, academic evaluation form',
            'canonical' => $baseUrl . 'rkdf-ist-student-feedback.php'
        ],
        [
            'identifier' => 'rkdf-ist-parent-feedback.php',
            'name' => 'RKDF-IST Parent Feedback Portal',
            'category' => 'Static Showcase',
            'title' => 'Parent Feedback & Suggestions | RKDF-IST | SRKU',
            'desc' => 'Parent feedback portal for institutional development and student progress tracking at RKDF-IST.',
            'keywords' => 'RKDF-IST parent feedback, parents portal Bhopal',
            'canonical' => $baseUrl . 'rkdf-ist-parent-feedback.php'
        ],
        [
            'identifier' => 'rkdf-ist-teacher-feedback.php',
            'name' => 'RKDF-IST Teacher Feedback Portal',
            'category' => 'Static Showcase',
            'title' => 'Faculty Curriculum Feedback | RKDF-IST | SRKU',
            'desc' => 'Internal teacher and academician curriculum feedback portal for continuous quality enhancement.',
            'keywords' => 'Teacher feedback form, faculty curriculum feedback RKDF-IST',
            'canonical' => $baseUrl . 'rkdf-ist-teacher-feedback.php'
        ],
        [
            'identifier' => 'rkdf-ist-grievance.php',
            'name' => 'RKDF-IST Grievance Portal',
            'category' => 'Static Showcase',
            'title' => 'Student & Staff Grievance Portal | RKDF-IST | SRKU',
            'desc' => 'Dedicated grievance submission and tracking system for RKDF Institute of Science & Technology.',
            'keywords' => 'RKDF IST grievance, student redressal cell',
            'canonical' => $baseUrl . 'rkdf-ist-grievance.php'
        ]
    ];

    // Auto-discover Dynamic Constituent Units / Departments
    try {
        $depts = $pdo->query("SELECT id, name, slug, description FROM departments WHERE status = 'active' ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($depts as $dept) {
            $deptSlug = !empty($dept['slug']) ? $dept['slug'] : generateSlug($dept['name']);
            $deptName = $dept['name'];
            $deptDesc = !empty($dept['description']) ? mb_substr(strip_tags($dept['description']), 0, 160) : "Learn more about {$deptName} at Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
            
            // Standard department route
            $pagesCatalog[] = [
                'identifier' => 'department-detail.php?slug=' . $deptSlug,
                'name' => 'Constituent Unit: ' . $deptName,
                'category' => 'Core & Database',
                'title' => "{$deptName} | Sarvepalli Radhakrishnan University Bhopal",
                'desc' => $deptDesc,
                'keywords' => "{$deptName}, SRKU constituent college, {$deptName} admission, Bhopal MP",
                'canonical' => $baseUrl . 'department-detail.php?slug=' . $deptSlug
            ];

            // Constituent-unit route alias
            $pagesCatalog[] = [
                'identifier' => 'constituent-unit.php?slug=' . $deptSlug,
                'name' => 'Unit Profile: ' . $deptName,
                'category' => 'Core & Database',
                'title' => "{$deptName} Profile | SRKU Bhopal",
                'desc' => $deptDesc,
                'keywords' => "{$deptName}, SRKU constituent college, {$deptName} admission, Bhopal MP",
                'canonical' => $baseUrl . 'constituent-unit.php?slug=' . $deptSlug
            ];
        }
    } catch (Exception $e) {}

    // Auto-discover Dynamic CMS Generic Pages
    try {
        $cmsPages = $pdo->query("SELECT id, title, slug, meta_description, content FROM pages WHERE status = 'published' ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cmsPages as $cp) {
            $pageIdentifier = 'page.php?id=' . $cp['id'];
            $pTitle = $cp['title'];
            $pDesc = !empty($cp['meta_description']) ? $cp['meta_description'] : (!empty($cp['content']) ? mb_substr(strip_tags($cp['content']), 0, 160) : "{$pTitle} - Official page of Sarvepalli Radhakrishnan University (SRKU) Bhopal.");
            
            $pagesCatalog[] = [
                'identifier' => $pageIdentifier,
                'name' => 'CMS: ' . $pTitle,
                'category' => 'CMS Generic',
                'title' => "{$pTitle} | Sarvepalli Radhakrishnan University",
                'desc' => $pDesc,
                'keywords' => "{$pTitle}, SRKU Bhopal, Sarvepalli Radhakrishnan University",
                'canonical' => $baseUrl . $pageIdentifier
            ];
        }
    } catch (Exception $e) {}

    // Auto-discover Syllabus Categories
    try {
        $syllabusCats = $pdo->query("SELECT DISTINCT category_slug, category_title FROM syllabi WHERE status = 'active' ORDER BY category_title ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($syllabusCats as $sc) {
            if (empty($sc['category_slug'])) continue;
            $sylIdentifier = 'syllabus.php?category=' . $sc['category_slug'];
            $catTitle = !empty($sc['category_title']) ? $sc['category_title'] : ucfirst($sc['category_slug']);
            
            $pagesCatalog[] = [
                'identifier' => $sylIdentifier,
                'name' => 'Syllabus: ' . $catTitle,
                'category' => 'Academic & Exam',
                'title' => "{$catTitle} Syllabus & Schemes | SRKU Bhopal",
                'desc' => "Download latest official syllabus, course scheme, and examination regulations for {$catTitle} programs at SRKU Bhopal.",
                'keywords' => "{$catTitle} syllabus, {$catTitle} course scheme, SRKU syllabus download",
                'canonical' => $baseUrl . $sylIdentifier
            ];
        }
    } catch (Exception $e) {}

    // Auto-discover All Active Courses (100% full catalog coverage)
    try {
        $courses = $pdo->query("SELECT id, course_name, slug, department, description FROM courses WHERE status = 'active' ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($courses as $c) {
            $cIdentifier = !empty($c['slug']) ? ('course-detail.php?slug=' . $c['slug']) : ('course-detail.php?id=' . $c['id']);
            $cName = $c['course_name'];
            $cDept = $c['department'] ?? 'SRKU';
            $cDesc = !empty($c['description']) ? mb_substr(strip_tags($c['description']), 0, 160) : "Apply for {$cName} under {$cDept} at Sarvepalli Radhakrishnan University Bhopal.";
            
            $pagesCatalog[] = [
                'identifier' => $cIdentifier,
                'name' => 'Course: ' . $cName,
                'category' => 'Core & Database',
                'title' => "{$cName} Admission, Fees & Eligibility | SRKU Bhopal",
                'desc' => $cDesc,
                'keywords' => "{$cName}, {$cName} admission Bhopal, {$cName} eligibility fees, SRKU courses",
                'canonical' => $baseUrl . $cIdentifier
            ];
        }
    } catch (Exception $e) {}

    // Auto-discover Published Blogs & Articles
    try {
        $blogs = $pdo->query("SELECT id, title, slug, short_description FROM blogs WHERE status = 'published' ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($blogs as $b) {
            $bSlug = !empty($b['slug']) ? $b['slug'] : generateSlug($b['title']);
            $bIdentifier = 'blog-detail.php?slug=' . $bSlug;
            $bTitle = $b['title'];
            $bDesc = !empty($b['short_description']) ? mb_substr(strip_tags($b['short_description']), 0, 160) : "Read '{$bTitle}' on Sarvepalli Radhakrishnan University (SRKU) official blog.";
            
            $pagesCatalog[] = [
                'identifier' => $bIdentifier,
                'name' => 'Blog: ' . $bTitle,
                'category' => 'Portal Pages',
                'title' => "{$bTitle} | SRKU Blog",
                'desc' => $bDesc,
                'keywords' => "{$bTitle}, SRKU blog, educational articles Bhopal",
                'canonical' => $baseUrl . $bIdentifier
            ];
        }
    } catch (Exception $e) {}

    // Auto-discover Published News & Notices
    try {
        $newsItems = $pdo->query("SELECT id, title, slug, content FROM news ORDER BY id ASC LIMIT 50")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($newsItems as $n) {
            $nSlug = !empty($n['slug']) ? $n['slug'] : ('news-detail.php?id=' . $n['id']);
            $nIdentifier = !empty($n['slug']) ? ('news-detail.php?slug=' . $n['slug']) : ('news-detail.php?id=' . $n['id']);
            $nTitle = $n['title'];
            $nDesc = !empty($n['content']) ? mb_substr(strip_tags($n['content']), 0, 160) : "Notice: {$nTitle} - Sarvepalli Radhakrishnan University Bhopal.";
            
            $pagesCatalog[] = [
                'identifier' => $nIdentifier,
                'name' => 'News: ' . $nTitle,
                'category' => 'Portal Pages',
                'title' => "{$nTitle} | SRKU Circulars",
                'desc' => $nDesc,
                'keywords' => "{$nTitle}, SRKU notice, university announcement",
                'canonical' => $baseUrl . $nIdentifier
            ];
        }
    } catch (Exception $e) {}

    // Process & Synchronize into Database
    $added = 0;
    $existing = 0;

    foreach ($pagesCatalog as $page) {
        $pi = $page['identifier'];
        $existingStmt->execute([':pi' => $pi]);
        $row = $existingStmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            // New entry - insert default metadata
            $insertStmt->execute([
                ':pi' => $pi,
                ':pn' => $page['name'],
                ':pc' => $page['category'],
                ':mt' => $page['title'],
                ':md' => $page['desc'],
                ':fk' => $page['keywords'],
                ':cu' => $page['canonical'],
                ':rt' => 'inherit',
                ':ot' => $page['title'],
                ':od' => $page['desc'],
                ':oi' => 'assets/uploads/2026/07/SRK-logo.webp',
                ':tc' => 'summary_large_image',
                ':sj' => null
            ]);
            $added++;
        } else {
            // Update page name / category classification without touching custom meta
            $updateStmt->execute([
                ':pn' => $page['name'],
                ':pc' => $page['category'],
                ':pi' => $pi
            ]);
            $existing++;
        }
    }

    $totalCount = (int)$pdo->query("SELECT COUNT(*) FROM seo_metadata")->fetchColumn();

    return [
        'success' => true,
        'added' => $added,
        'existing' => $existing,
        'total' => $totalCount
    ];
}

/**
 * Resolves SEO metadata for any requested page or route,
 * taking into account global indexing directives, page-specific overrides, and fallbacks.
 */
function getSeoMetadata($pageIdentifier = null, $fallbackTitle = '', $fallbackDesc = '', $fallbackKeywords = '', $fallbackImage = '') {
    $currentScriptName = basename($_SERVER['PHP_SELF'] ?? 'index.php');
    $currentQueryString = $_SERVER['QUERY_STRING'] ?? '';

    if (empty($pageIdentifier)) {
        if (!empty($currentQueryString)) {
            $pageIdentifier = $currentScriptName . '?' . $currentQueryString;
        } else {
            $pageIdentifier = $currentScriptName;
        }
    }

    $globalRobots = getSetting('global_robots_indexing', 'index, follow');
    $globalMode = getSetting('global_seo_mode', 'live');

    $seoRow = null;
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM seo_metadata WHERE page_identifier = :pi LIMIT 1");
        $stmt->execute([':pi' => $pageIdentifier]);
        $seoRow = $stmt->fetch(PDO::FETCH_ASSOC);

        // If not found with exact query string, try base script
        if (!$seoRow && strpos($pageIdentifier, '?') !== false) {
            $baseScript = strtok($pageIdentifier, '?');
            $stmt = $pdo->prepare("SELECT * FROM seo_metadata WHERE page_identifier = :pi LIMIT 1");
            $stmt->execute([':pi' => $baseScript]);
            $seoRow = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {}

    // Title Resolution
    $title = !empty($seoRow['meta_title']) ? $seoRow['meta_title'] : $fallbackTitle;
    if (empty($title)) {
        $title = "Sarvepalli Radhakrishnan University (SRKU), Bhopal | Official Portal";
    }

    // Description Resolution
    $desc = !empty($seoRow['meta_description']) ? $seoRow['meta_description'] : $fallbackDesc;
    if (empty($desc)) {
        $desc = 'Sarvepalli Radhakrishnan University (SRKU) Bhopal is a premier multidisciplinary private university in Madhya Pradesh recognized under Section 2(f) of UGC Act 1956, offering UGC, AICTE, NMC, PCI, BCI approved programmes.';
    }

    // Keywords Resolution
    $keywords = !empty($seoRow['focus_keywords']) ? $seoRow['focus_keywords'] : $fallbackKeywords;
    if (empty($keywords)) {
        $keywords = "SRK University, Sarvepalli Radhakrishnan University, SRKU Bhopal, Admissions 2026-27, UGC Approved University MP, AICTE Approved Engineering College, NMC Approved Medical College Bhopal";
    }

    // Canonical URL Resolution
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $reqUri = $_SERVER['REQUEST_URI'] ?? '/';
    $currentFullUrl = "$protocol://$host$reqUri";
    $canonical = !empty($seoRow['canonical_url']) ? $seoRow['canonical_url'] : $currentFullUrl;

    // Robots Tag Resolution (Inherit Global vs Custom Override)
    $pageRobots = $seoRow['robots_tag'] ?? 'inherit';
    if ($pageRobots === 'inherit' || empty($pageRobots)) {
        $effectiveRobots = $globalRobots;
    } else {
        $effectiveRobots = $pageRobots;
    }

    if ($effectiveRobots === 'index, follow') {
        $effectiveRobots = 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1';
    }

    // OpenGraph & Social Cards
    $ogTitle = !empty($seoRow['og_title']) ? $seoRow['og_title'] : $title;
    $ogDesc = !empty($seoRow['og_description']) ? $seoRow['og_description'] : $desc;
    $ogImage = !empty($seoRow['og_image']) ? $seoRow['og_image'] : $fallbackImage;
    if (empty($ogImage)) {
        $ogImage = 'assets/uploads/2026/07/SRK-logo.webp';
    }
    $twitterCard = !empty($seoRow['twitter_card']) ? $seoRow['twitter_card'] : 'summary_large_image';
    $schemaJson = !empty($seoRow['schema_json']) ? trim($seoRow['schema_json']) : '';

    return [
        'title' => $title,
        'description' => $desc,
        'keywords' => $keywords,
        'canonical' => $canonical,
        'robots' => $effectiveRobots,
        'page_robots' => $pageRobots,
        'global_robots' => $globalRobots,
        'global_mode' => $globalMode,
        'og_title' => $ogTitle,
        'og_description' => $ogDesc,
        'og_image' => $ogImage,
        'twitter_card' => $twitterCard,
        'schema_json' => $schemaJson,
        'has_custom_record' => !empty($seoRow)
    ];
}

/**
 * Returns summary counts for the SEO Manager dashboard tabs and cards
 */
function getSeoSummaryStats($pdo = null) {
    if (!$pdo) {
        $pdo = getDBConnection();
    }

    // Ensure inventory is populated
    $total = (int)$pdo->query("SELECT COUNT(*) FROM seo_metadata")->fetchColumn();
    if ($total == 0) {
        syncSeoPagesInventory($pdo);
        $total = (int)$pdo->query("SELECT COUNT(*) FROM seo_metadata")->fetchColumn();
    }

    $portalCount = (int)$pdo->query("SELECT COUNT(*) FROM seo_metadata WHERE page_category = 'Portal Pages'")->fetchColumn();
    $coreCount = (int)$pdo->query("SELECT COUNT(*) FROM seo_metadata WHERE page_category = 'Core & Database'")->fetchColumn();
    $cmsCount = (int)$pdo->query("SELECT COUNT(*) FROM seo_metadata WHERE page_category = 'CMS Generic'")->fetchColumn();
    $examCount = (int)$pdo->query("SELECT COUNT(*) FROM seo_metadata WHERE page_category = 'Academic & Exam'")->fetchColumn();
    $staticCount = (int)$pdo->query("SELECT COUNT(*) FROM seo_metadata WHERE page_category = 'Static Showcase'")->fetchColumn();

    $globalRobots = getSetting('global_robots_indexing', 'noindex, nofollow');
    $isLive = (strpos($globalRobots, 'index, follow') !== false || strpos($globalRobots, 'index') !== false) && strpos($globalRobots, 'noindex') === false;

    return [
        'total' => $total,
        'portal' => $portalCount,
        'core' => $coreCount,
        'cms' => $cmsCount,
        'exam' => $examCount,
        'static' => $staticCount,
        'global_robots' => $globalRobots,
        'is_live' => $isLive
    ];
}

/**
 * Saves or updates SEO metadata for a specific route
 */
function savePageSeoMetadata($data, $pdo = null) {
    if (!$pdo) {
        $pdo = getDBConnection();
    }

    $id = isset($data['id']) ? (int)$data['id'] : 0;
    $identifier = trim($data['page_identifier'] ?? '');
    $name = trim($data['page_name'] ?? '');
    $category = trim($data['page_category'] ?? 'Portal Pages');
    $title = trim($data['meta_title'] ?? '');
    $desc = trim($data['meta_description'] ?? '');
    $keywords = trim($data['focus_keywords'] ?? '');
    $canonical = trim($data['canonical_url'] ?? '');
    $robots = trim($data['robots_tag'] ?? 'inherit');
    $ogTitle = trim($data['og_title'] ?? '');
    $ogDesc = trim($data['og_description'] ?? '');
    $ogImage = trim($data['og_image'] ?? '');
    $twitterCard = trim($data['twitter_card'] ?? 'summary_large_image');
    $schemaJson = trim($data['schema_json'] ?? '');

    if (empty($identifier)) {
        return ['success' => false, 'error' => 'Page route/identifier is required.'];
    }

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE seo_metadata SET 
            page_name = :pn,
            page_category = :pc,
            meta_title = :mt,
            meta_description = :md,
            focus_keywords = :fk,
            canonical_url = :cu,
            robots_tag = :rt,
            og_title = :ot,
            og_description = :od,
            og_image = :oi,
            twitter_card = :tc,
            schema_json = :sj
            WHERE id = :id");
        $stmt->execute([
            ':pn' => $name,
            ':pc' => $category,
            ':mt' => $title,
            ':md' => $desc,
            ':fk' => $keywords,
            ':cu' => $canonical,
            ':rt' => $robots,
            ':ot' => $ogTitle,
            ':od' => $ogDesc,
            ':oi' => $ogImage,
            ':tc' => $twitterCard,
            ':sj' => $schemaJson,
            ':id' => $id
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO seo_metadata (page_identifier, page_name, page_category, meta_title, meta_description, focus_keywords, canonical_url, robots_tag, og_title, og_description, og_image, twitter_card, schema_json) 
            VALUES (:pi, :pn, :pc, :mt, :md, :fk, :cu, :rt, :ot, :od, :oi, :tc, :sj)");
        $stmt->execute([
            ':pi' => $identifier,
            ':pn' => $name,
            ':pc' => $category,
            ':mt' => $title,
            ':md' => $desc,
            ':fk' => $keywords,
            ':cu' => $canonical,
            ':rt' => $robots,
            ':ot' => $ogTitle,
            ':od' => $ogDesc,
            ':oi' => $ogImage,
            ':tc' => $twitterCard,
            ':sj' => $schemaJson
        ]);
        $id = (int)$pdo->lastInsertId();
    }

    return ['success' => true, 'id' => $id];
}

