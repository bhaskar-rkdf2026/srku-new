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
        return $res !== false ? $res : $default;
    } catch (Exception $e) {
        return $default;
    }
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
        $idVal = is_numeric($slug) ? (int)$slug : 0;
        $stmt = $pdo->prepare("SELECT * FROM departments WHERE slug = :s OR id = :idval LIMIT 1");
        $stmt->execute([':s' => $slug, ':idval' => $idVal]);
        $res = $stmt->fetch();
        if ($res) return $res;

        // Fallback: search by partial slug or name
        $cleanTerm = str_replace(['department-of-', 'faculty-of-', '-srk-university', '-srk-bhopal', '-'], ' ', $slug);
        $cleanTerm = trim($cleanTerm);
        if (!empty($cleanTerm)) {
            $stmt = $pdo->prepare("SELECT * FROM departments WHERE name LIKE :term OR slug LIKE :sterm LIMIT 1");
            $stmt->execute([':term' => '%' . $cleanTerm . '%', ':sterm' => '%' . $slug . '%']);
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
            $sql .= " AND (course_name LIKE :kw1 OR department LIKE :kw2 OR description LIKE :kw3)";
            $params[':kw1'] = '%' . $search . '%';
            $params[':kw2'] = '%' . $search . '%';
            $params[':kw3'] = '%' . $search . '%';
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

// Fetch banners
function getBanners() {
    try {
        $pdo = getDBConnection();
        return $pdo->query("SELECT * FROM banners ORDER BY sort_order ASC, id ASC")->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

// Fetch gallery images
function getGalleryImages($category = null) {
    try {
        $pdo = getDBConnection();
        if (!empty($category)) {
            $stmt = $pdo->prepare("SELECT * FROM gallery WHERE category = :c ORDER BY id DESC");
            $stmt->execute([':c' => $category]);
            return $stmt->fetchAll();
        }
        return $pdo->query("SELECT * FROM gallery ORDER BY id DESC")->fetchAll();
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
        return ['success' => true, 'message' => 'Your complaint has been registered successfully. Our grievance cell will review it and contact you shortly.'];
    } catch (Exception $ex) {
        return ['success' => false, 'error' => 'Failed to register complaint: ' . $ex->getMessage()];
    }
}
