<?php
require_once __DIR__ . '/config.php';

function getDBConnection() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    try {
        // Try connecting to existing MySQL database
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $e) {
        // Try creating MySQL DB if missing on local server
        try {
            $rootDsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
            $rootPdo = new PDO($rootDsn, DB_USER, DB_PASS);
            $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $ex) {
            // Fallback to SQLite if MySQL is not available
            $sqlitePath = __DIR__ . '/../database.sqlite';
            $pdo = new PDO("sqlite:" . $sqlitePath, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
    }

    // Auto setup schema & seed data
    autoInitializeTables($pdo);

    return $pdo;
}

function autoInitializeTables($pdo) {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

    if ($driver === 'sqlite') {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                email TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS pages (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                slug TEXT UNIQUE NOT NULL,
                content TEXT,
                meta_description TEXT,
                status TEXT DEFAULT 'published',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS departments (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                slug TEXT UNIQUE NOT NULL,
                icon TEXT,
                banner_img TEXT,
                description TEXT,
                dean_name TEXT,
                established_year TEXT,
                status TEXT DEFAULT 'active'
            );
            CREATE TABLE IF NOT EXISTS courses (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                department TEXT NOT NULL,
                dept_slug TEXT,
                course_name TEXT NOT NULL,
                slug TEXT,
                level TEXT DEFAULT 'UG',
                duration TEXT,
                eligibility TEXT,
                fees TEXT,
                description TEXT,
                career_scope TEXT,
                status TEXT DEFAULT 'active'
            );
            CREATE TABLE IF NOT EXISTS banners (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                subtitle TEXT,
                image_url TEXT,
                btn_text TEXT,
                btn_link TEXT,
                sort_order INTEGER DEFAULT 0
            );
            CREATE TABLE IF NOT EXISTS news (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                slug TEXT,
                content TEXT,
                category TEXT DEFAULT 'Announcement',
                publish_date DATE,
                image_url TEXT,
                is_ticker INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS enquiries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                phone TEXT NOT NULL,
                course TEXT,
                message TEXT,
                status TEXT DEFAULT 'New',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS gallery (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                category TEXT DEFAULT 'Campus',
                image_url TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                setting_key TEXT UNIQUE NOT NULL,
                setting_value TEXT
            );
        ");
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
                `status` ENUM('published','draft') DEFAULT 'published',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `departments` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `category` VARCHAR(100) DEFAULT 'General',
                `slug` VARCHAR(191) NOT NULL UNIQUE,
                `icon` VARCHAR(100) DEFAULT 'fas fa-graduation-cap',
                `banner_img` VARCHAR(255),
                `description` LONGTEXT,
                `dean_name` VARCHAR(150),
                `contact_no` VARCHAR(100) DEFAULT '0755-4700983, 7024144981',
                `approvals` VARCHAR(255) DEFAULT 'UGC',
                `established_year` VARCHAR(10),
                `status` ENUM('active','inactive') DEFAULT 'active'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `courses` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `department` VARCHAR(150) NOT NULL,
                `dept_slug` VARCHAR(100),
                `course_name` VARCHAR(255) NOT NULL,
                `slug` VARCHAR(191),
                `level` VARCHAR(50) DEFAULT 'UG',
                `duration` VARCHAR(50),
                `eligibility` TEXT,
                `fees` VARCHAR(100),
                `specializations` TEXT,
                `description` LONGTEXT,
                `career_scope` TEXT,
                `syllabus_url` VARCHAR(255),
                `scheme_url` VARCHAR(255),
                `status` VARCHAR(20) DEFAULT 'active'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `banners` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `subtitle` TEXT,
                `image_url` VARCHAR(255),
                `btn_text` VARCHAR(50),
                `btn_link` VARCHAR(255),
                `sort_order` INT DEFAULT 0
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

            CREATE TABLE IF NOT EXISTS `gallery` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `category` VARCHAR(50) DEFAULT 'Campus',
                `image_url` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `settings` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `setting_key` VARCHAR(100) NOT NULL UNIQUE,
                `setting_value` TEXT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // Schema migrations for MySQL if table previously existed with older columns
        try {
            $deptCols = $pdo->query("SHOW COLUMNS FROM `departments`")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('category', $deptCols)) $pdo->exec("ALTER TABLE `departments` ADD `category` VARCHAR(100) DEFAULT 'General' AFTER `name`");
            if (!in_array('contact_no', $deptCols)) $pdo->exec("ALTER TABLE `departments` ADD `contact_no` VARCHAR(100) DEFAULT '0755-4700983, 7024144981' AFTER `dean_name`");
            if (!in_array('approvals', $deptCols)) $pdo->exec("ALTER TABLE `departments` ADD `approvals` VARCHAR(255) DEFAULT 'UGC' AFTER `contact_no`");

            $cols = $pdo->query("SHOW COLUMNS FROM `courses`")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('department', $cols)) $pdo->exec("ALTER TABLE `courses` ADD `department` VARCHAR(150) AFTER `id`");
            if (!in_array('dept_slug', $cols)) $pdo->exec("ALTER TABLE `courses` ADD `dept_slug` VARCHAR(100) AFTER `department`");
            if (!in_array('slug', $cols)) $pdo->exec("ALTER TABLE `courses` ADD `slug` VARCHAR(191) AFTER `course_name`");
            if (!in_array('level', $cols)) $pdo->exec("ALTER TABLE `courses` ADD `level` VARCHAR(50) DEFAULT 'UG' AFTER `slug`");
            if (!in_array('fees', $cols)) $pdo->exec("ALTER TABLE `courses` ADD `fees` VARCHAR(100) AFTER `eligibility`");
            if (!in_array('specializations', $cols)) $pdo->exec("ALTER TABLE `courses` ADD `specializations` TEXT AFTER `fees`");
            if (!in_array('description', $cols)) $pdo->exec("ALTER TABLE `courses` ADD `description` LONGTEXT AFTER `specializations`");
            if (!in_array('career_scope', $cols)) $pdo->exec("ALTER TABLE `courses` ADD `career_scope` TEXT AFTER `description`");
            if (!in_array('syllabus_url', $cols)) $pdo->exec("ALTER TABLE `courses` ADD `syllabus_url` VARCHAR(255) AFTER `career_scope`");
            if (!in_array('scheme_url', $cols)) $pdo->exec("ALTER TABLE `courses` ADD `scheme_url` VARCHAR(255) AFTER `syllabus_url`");
        } catch (Exception $e) {}

        try {
            $cols = $pdo->query("SHOW COLUMNS FROM `news`")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('slug', $cols)) $pdo->exec("ALTER TABLE `news` ADD `slug` VARCHAR(191) AFTER `title`");
            if (!in_array('image_url', $cols)) $pdo->exec("ALTER TABLE `news` ADD `image_url` VARCHAR(255) AFTER `publish_date`");
            if (!in_array('is_ticker', $cols)) $pdo->exec("ALTER TABLE `news` ADD `is_ticker` TINYINT(1) DEFAULT 0 AFTER `image_url`");
        } catch (Exception $e) {}

        try {
            $cols = $pdo->query("SHOW COLUMNS FROM `enquiries`")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('father_name', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `father_name` VARCHAR(150) AFTER `name`");
            if (!in_array('city', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `city` VARCHAR(100) AFTER `course`");
            if (!in_array('state', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `state` VARCHAR(100) AFTER `city`");
            if (!in_array('source', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `source` VARCHAR(150) AFTER `state`");
            if (!in_array('status', $cols)) $pdo->exec("ALTER TABLE `enquiries` ADD `status` VARCHAR(50) DEFAULT 'New' AFTER `message`");
        } catch (Exception $e) {}
    }

    // Seed default admin user (admin / admin123)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $insertAdmin = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (:u, :p, :e)");
        $insertAdmin->execute([
            ':u' => 'admin',
            ':p' => $defaultPassword,
            ':e' => 'admin@srku.edu.in'
        ]);
    }

    // Seed default settings
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
    foreach ($defaultSettings as $key => $val) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM settings WHERE setting_key = :k");
        $stmt->execute([':k' => $key]);
        if ($stmt->fetchColumn() == 0) {
            $ins = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v)");
            $ins->execute([':k' => $key, ':v' => $val]);
        }
    }

    // Seed Departments (All 18 Constituent Colleges & Departments from new.srku.edu.in)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM departments");
    $stmt->execute();
    if ($stmt->fetchColumn() <= 5) {
        $pdo->exec("DELETE FROM departments");
        $departments = [
            ['RKDF Institute of Science and Technology (1995)', 'rkdf-institute-of-science-and-technology', 'fas fa-microchip', 'assets/images/dept_engg.jpg', 'Faculty of Engineering offers AICTE approved B.Tech, M.Tech and Polytechnic programs with cutting-edge computing, AI/ML, Robotics, IoT and Mechanical labs.', '', '1995'],
            ['Department of Pharmacy (RKDF College)', 'rkdf-college-of-pharmacy', 'fas fa-pills', 'assets/images/dept_pharma.jpg', 'PCI & AICTE approved pharmacy institute offering B.Pharm, M.Pharm, and Pharm.D with advanced pharmacology and formulation development labs.', '', '1995'],
            ['Sri Sai College of Pharmacy', 'sri-sai-college-of-pharmacy-srk-bhopal', 'fas fa-capsules', 'assets/images/dept_pharma2.jpg', 'Premier institute specializing in pharmaceutical education, clinical research, drug design, and industrial training.', '', '2019'],
            ['Dr. APJ Abdul Kalam College of Pharmacy', 'dr-apj-abdul-kalam-college-of-pharmacy-srk-bhopal', 'fas fa-flask', 'assets/images/dept_pharma3.jpg', 'Dedicated institute fostering advanced research in nanomedicine, pharmacognosy, and pharmaceutical biotechnology.', '', '2018'],
            ['Sarvepalli Radhakrishnan College of Pharmacy', 'sarvepalli-radhakrishnan-college-of-pharmacy', 'fas fa-prescription-bottle', 'assets/images/dept_pharma4.jpg', 'Flagship pharmaceutical institution committed to clinical practice, hospital pharmacy, and doctoral research.', '', '2018'],
            ['Sarvepalli Radhakrishnan Institute of Pharmaceutical Science', 'sarvepalli-radhakrishnan-institute-of-pharmaceutical-science', 'fas fa-flask', 'assets/images/dept_pharma.jpg', 'Advanced pharmaceutical science institute fostering formulation design and pharmacology.', '', '2023'],
            ['R.N. Kapoor Memorial Institute of Pharmaceutical Sciences', 'r-n-kapoor-memorial-institute-of-pharmaceutical-sciences-srk-university', 'fas fa-tablets', 'assets/images/dept_pharma5.jpg', 'Excellence in pharmacy diploma, undergraduate, and postgraduate pharmaceutical chemistry studies.', '', '2023'],
            ['RKDF College of Nursing', 'rkdf-college-of-nursing', 'fas fa-user-nurse', 'assets/images/dept_nursing.jpg', 'INC recognized center providing B.Sc Nursing, Post Basic B.Sc, M.Sc Nursing, and NPCC programs with 500+ bed hospital training.', '', '2003'],
            ['Faculty of Agriculture', 'faculty-of-agriculture', 'fas fa-seedling', 'assets/images/dept_agri.jpg', 'ICAR aligned B.Sc (Hons) and M.Sc Agriculture programs with 50+ acres of experimental farms, polyhouses, and agronomy research labs.', '', '2016'],
            ['Sarvepalli Radhakrishnan College of Law', 'sarvepalli-radhakrishnan-college-of-law', 'fas fa-balance-scale', 'assets/images/dept_law.jpg', 'BCI approved LL.B, BA LL.B (Hons), and LL.M degrees with moot court hall, legal aid clinic, and judicial mentoring.', '', '2019'],
            ['RKDF Medical College, Hospital & Research Center', 'rkdf-medical-college', 'fas fa-stethoscope', 'assets/images/dept_med.jpg', 'NMC recognized medical and dental sciences providing MBBS, MD, MS, BDS, and MDS programs with multi-specialty clinical hospital.', '', '2014'],
            ['Department of Paramedical Sciences', 'department-of-paramedical-sciences', 'fas fa-heartbeat', 'assets/images/dept_para.jpg', 'Comprehensive paramedical education in BPT, MPT, BMLT, DMLT, X-Ray Radiography, and Optometry with hospital internships.', '', '2015']
        ];
        $insDept = $pdo->prepare("INSERT INTO departments (name, slug, icon, banner_img, description, dean_name, established_year) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($departments as $d) {
            $insDept->execute($d);
        }
    }

    // Seed Complete Course Catalog (40+ Courses across all faculties)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM courses");
    $stmt->execute();
    if ($stmt->fetchColumn() <= 5) {
        $pdo->exec("DELETE FROM courses");
        $courses = [
            // Engineering
            ['Department of Engineering', 'department-of-engineering', 'B.Tech in Computer Science & Engineering', 'b-tech-computer-science', 'UG', '4 Years', '10+2 with Physics, Mathematics & Chemistry (Min 50%)', '₹65,000 / Year', 'Comprehensive degree covering Data Structures, AI, Cloud Computing, Cyber Security, and Software Engineering.', 'Software Engineer, Data Analyst, Cloud Architect, Full Stack Developer'],
            ['Department of Engineering', 'department-of-engineering', 'B.Tech in Artificial Intelligence & Data Science', 'b-tech-ai-ds', 'UG', '4 Years', '10+2 with PCM (Min 50%)', '₹70,000 / Year', 'Cutting-edge program focusing on Machine Learning, Deep Learning, Big Data Analytics, and NLP.', 'AI Engineer, Data Scientist, ML Ops Specialist'],
            ['Department of Engineering', 'department-of-engineering', 'B.Tech in Mechanical Engineering', 'b-tech-mechanical', 'UG', '4 Years', '10+2 with PCM (Min 50%)', '₹55,000 / Year', 'Industry 4.0 aligned program with CAD/CAM, Robotics, Thermal Engineering, and Automobile Systems.', 'Design Engineer, Automobile Specialist, Production Manager'],
            ['Department of Engineering', 'department-of-engineering', 'B.Tech in Civil Engineering', 'b-tech-civil', 'UG', '4 Years', '10+2 with PCM (Min 50%)', '₹55,000 / Year', 'Structural design, construction technology, geoinformatics, and smart city infrastructure.', 'Structural Engineer, Project Manager, Site Engineer'],
            ['Department of Engineering', 'department-of-engineering', 'B.Tech in Electrical & Electronics Engineering', 'b-tech-eee', 'UG', '4 Years', '10+2 with PCM (Min 50%)', '₹55,000 / Year', 'Power systems, renewable energy, embedded systems, and IoT control engineering.', 'Electrical Consultant, Power Grid Engineer, IoT Specialist'],
            ['Department of Engineering', 'department-of-engineering', 'M.Tech in Computer Science & Engineering', 'm-tech-cse', 'PG', '2 Years', 'B.E. / B.Tech in CSE / IT (Min 50%)', '₹60,000 / Year', 'Advanced research degree in High-Performance Computing, Distributed Systems, and AI Architectures.', 'Research Scientist, Principal Engineer, Academician'],
            ['Department of Engineering', 'department-of-engineering', 'Diploma in Engineering (Polytechnic)', 'diploma-engineering', 'Diploma', '3 Years', '10th Standard pass from recognized board with Science & Math', '₹35,000 / Year', 'Hands-on practical engineering diploma in CSE, Mechanical, Civil, and Electrical streams.', 'Junior Engineer, Technical Officer, Plant Supervisor'],

            // Pharmacy
            ['Department of Pharmacy (RKDF College)', 'department-of-pharmacy', 'Bachelor of Pharmacy (B.Pharm)', 'b-pharm', 'UG', '4 Years', '10+2 with Physics, Chemistry & Biology/Maths (Min 50%)', '₹80,000 / Year', 'PCI approved degree covering Pharmacology, Pharmaceutics, Pharmacognosy, and Medicinal Chemistry.', 'Drug Inspector, Pharmacist, Clinical Research Associate, R&D Executive'],
            ['Department of Pharmacy (RKDF College)', 'department-of-pharmacy', 'Diploma in Pharmacy (D.Pharm)', 'd-pharm', 'Diploma', '2 Years', '10+2 with PCB / PCM (Min 45%)', '₹50,000 / Year', 'Foundational pharmacy course leading to Registered Pharmacist license with PCI.', 'Registered Retail/Hospital Pharmacist, Medical Representative'],
            ['Department of Pharmacy (RKDF College)', 'department-of-pharmacy', 'Master of Pharmacy (M.Pharm Pharmaceutics)', 'm-pharm-pharmaceutics', 'PG', '2 Years', 'B.Pharm from PCI recognized university (Min 55%)', '₹90,000 / Year', 'Advanced drug delivery systems, formulation research, and regulatory affairs.', 'Formulation Scientist, QA/QC Manager, Regulatory Affairs Specialist'],
            ['Department of Pharmacy (RKDF College)', 'department-of-pharmacy', 'Master of Pharmacy (M.Pharm Pharmacology)', 'm-pharm-pharmacology', 'PG', '2 Years', 'B.Pharm from PCI recognized university (Min 55%)', '₹90,000 / Year', 'In-depth molecular pharmacology, clinical toxicology, and pre-clinical drug evaluation.', 'Clinical Research Scientist, Toxicologist, Drug Safety Associate'],

            // Computer Applications
            ['Department of Computer Application', 'department-of-computer-application', 'Master of Computer Applications (MCA)', 'mca', 'PG', '2 Years', 'BCA / B.Sc (CS/IT) / Any Bachelor Degree with Math at 10+2 or Graduation', '₹50,000 / Year', 'Industry-ready curriculum in Full-Stack Web Development, Cloud Computing, DevOps, and Enterprise App Design.', 'Senior Software Engineer, System Architect, Database Administrator'],
            ['Department of Computer Application', 'department-of-computer-application', 'Bachelor of Computer Applications (BCA)', 'bca', 'UG', '3 Years', '10+2 in any stream with Mathematics / Computer', '₹40,000 / Year', 'Modern computing degree covering Python, Java, Web Technologies, Database Management, and Mobile Apps.', 'Software Developer, Web Designer, Technical Support Engineer'],
            ['Department of Computer Application', 'department-of-computer-application', 'PGDCA (Post Graduate Diploma in Computer Applications)', 'pgdca', 'Diploma', '1 Year', 'Graduation in any discipline from recognized university', '₹25,000 / Year', 'Professional diploma providing IT skills, office automation, database concepts, and coding basics.', 'IT Assistant, Computer Operator, Data Entry Executive'],

            // Management & Business
            ['Department of Management', 'department-of-management', 'Master of Business Administration (MBA)', 'mba', 'PG', '2 Years', 'Graduation in any stream (Min 50%)', '₹60,000 / Year', 'Dual specialization in Marketing, Finance, Human Resource, Business Analytics, and International Business.', 'Business Manager, Marketing Executive, Financial Analyst, HR Manager'],
            ['Department of Management', 'department-of-management', 'Bachelor of Business Administration (BBA)', 'bba', 'UG', '3 Years', '10+2 in any stream (Min 45%)', '₹40,000 / Year', 'Core business administration curriculum with real-world case studies, entrepreneurship, and management internships.', 'Management Trainee, Sales Officer, Business Development Executive'],

            // Nursing
            ['RKDF College of Nursing', 'rkdf-college-of-nursing', 'B.Sc. Nursing', 'b-sc-nursing', 'UG', '4 Years', '10+2 with PCB and English (Min 45% aggregate)', '₹85,000 / Year', 'INC recognized nursing program with extensive multi-specialty clinical hospital rotations and patient care training.', 'Nursing Officer, ICU Specialist, Staff Nurse (Govt & Private Hospitals)'],
            ['RKDF College of Nursing', 'rkdf-college-of-nursing', 'Post Basic B.Sc. Nursing', 'post-basic-b-sc-nursing', 'UG', '2 Years', 'GNM Pass + Registered Nurse / Midwife with State Nursing Council', '₹60,000 / Year', 'Upgradation degree for registered GNM nurses to obtain a Bachelor of Nursing qualification.', 'Senior Nursing Officer, Hospital Nursing Supervisor'],
            ['RKDF College of Nursing', 'rkdf-college-of-nursing', 'M.Sc. Nursing', 'm-sc-nursing', 'PG', '2 Years', 'B.Sc Nursing / PB B.Sc Nursing with Min 1 Year Experience', '₹95,000 / Year', 'Specializations in Medical-Surgical, Pediatric, Obstetric & Gynecological, Psychiatric Nursing.', 'Nursing Superintendent, Clinical Specialist, Nursing College Faculty'],
            ['RKDF College of Nursing', 'rkdf-college-of-nursing', 'Nurse Practitioner in Critical Care (NPCC)', 'npcc', 'PG', '2 Years', 'B.Sc Nursing with 2 years clinical experience in critical care', '₹1,00,000 / Year', 'Postgraduate residency program training advanced critical care nurse practitioners.', 'Critical Care Nurse Practitioner, Trauma ICU Specialist'],

            // Agriculture
            ['Faculty of Agriculture', 'faculty-of-agriculture', 'B.Sc. (Hons.) Agriculture', 'b-sc-agriculture', 'UG', '4 Years', '10+2 with PCB / PCM / Agriculture (Min 50%)', '₹60,000 / Year', 'ICAR aligned degree in Agronomy, Soil Science, Horticulture, Plant Breeding, and Agro-Economics.', 'Agriculture Field Officer (IBPS AFO), Farm Manager, Seed Technologist'],
            ['Faculty of Agriculture', 'faculty-of-agriculture', 'M.Sc. Agriculture (Agronomy)', 'm-sc-agri-agronomy', 'PG', '2 Years', 'B.Sc. Agriculture / Horticulture (Min 55%)', '₹65,000 / Year', 'Specialized agronomy research in crop physiology, sustainable agriculture, and nutrient management.', 'Agricultural Scientist, Agronomist, Research Associate'],
            ['Faculty of Agriculture', 'faculty-of-agriculture', 'Diploma in Agriculture', 'diploma-in-agriculture', 'Diploma', '2 Years', '10th Standard Pass from recognized board', '₹30,000 / Year', 'Practical training in organic farming, crop protection, and nursery management.', 'Agriculture Assistant, Fertilizer Specialist, Nursery Supervisor'],

            // Law
            ['Faculty of Law & SRK College of Law', 'faculty-of-law', 'Bachelor of Laws (LL.B.)', 'll-b', 'UG', '3 Years', 'Graduation in any stream (Min 45% for Gen, 40% for SC/ST)', '₹45,000 / Year', 'BCI approved law degree with moot court practice, criminal law, constitutional law, and legal drafting.', 'Advocate, Legal Advisor, Corporate Counsel, Public Prosecutor'],
            ['Faculty of Law & SRK College of Law', 'faculty-of-law', 'BA LL.B. (Integrated)', 'ba-ll-b', 'UG', '5 Years', '10+2 in any stream (Min 45%)', '₹50,000 / Year', 'Five-year integrated dual degree combining Arts humanities with professional law curriculum.', 'Litigation Advocate, Corporate Law Associate, Judiciary Aspirant'],
            ['Faculty of Law & SRK College of Law', 'faculty-of-law', 'Master of Laws (LL.M.)', 'll-m', 'PG', '2 Years', 'LL.B. / Integrated Law degree (Min 50%)', '₹55,000 / Year', 'Advanced jurisprudence, corporate law, intellectual property rights, and cyber laws.', 'Legal Consultant, Law Professor, Judicial Officer'],

            // Paramedical & Allied Health
            ['Faculty of Paramedical & Allied Health Care Sciences', 'faculty-of-paramedical-sciences', 'Bachelor of Physiotherapy (BPT)', 'bpt', 'UG', '4.5 Years', '10+2 with PCB (Min 50%)', '₹70,000 / Year', 'Comprehensive physiotherapy degree with clinical training in orthopedics, neurology, and sports rehabilitation.', 'Physiotherapist, Sports Rehab Consultant, Clinic Owner'],
            ['Faculty of Paramedical & Allied Health Care Sciences', 'faculty-of-paramedical-sciences', 'Master of Physiotherapy (MPT)', 'mpt', 'PG', '2 Years', 'BPT degree from recognized university', '₹80,000 / Year', 'Specializations in Ortho, Neuro, Cardiopulmonary, and Sports Physiotherapy.', 'Senior Physiotherapy Consultant, Rehabilitation Specialist'],
            ['Faculty of Paramedical & Allied Health Care Sciences', 'faculty-of-paramedical-sciences', 'BMLT (Bachelor in Medical Laboratory Technology)', 'bmlt', 'UG', '3 Years', '10+2 with PCB (Min 45%)', '₹50,000 / Year', 'Clinical pathology, biochemistry, microbiology, hematology, and diagnostic laboratory skills.', 'Chief Lab Technologist, Diagnostic Lab Manager'],
            ['Faculty of Paramedical & Allied Health Care Sciences', 'faculty-of-paramedical-sciences', 'DMLT (Diploma in Medical Laboratory Technology)', 'dmlt', 'Diploma', '2 Years', '10+2 with Science stream', '₹35,000 / Year', 'Foundational diagnostic laboratory techniques and clinical specimen analysis.', 'Medical Lab Technician, Phlebotomist'],
            ['Faculty of Paramedical & Allied Health Care Sciences', 'faculty-of-paramedical-sciences', 'Diploma in X-Ray Radiographer', 'diploma-x-ray', 'Diploma', '2 Years', '10+2 with Science', '₹35,000 / Year', 'Radiographic imaging, CT scan, MRI operations, and radiation safety protocols.', 'Radiology Technician, CT/MRI Assistant'],
            ['Faculty of Paramedical & Allied Health Care Sciences', 'faculty-of-paramedical-sciences', 'Diploma in Optometric Refraction', 'diploma-optometry', 'Diploma', '2 Years', '10+2 with Science', '₹35,000 / Year', 'Vision testing, refractive corrections, optical dispensing, and eye clinic management.', 'Optometrist Assistant, Vision Care Specialist'],

            // Medicine & Dental
            ['Faculty of Medicine & Dental Sciences', 'faculty-of-medicine', 'MBBS (Bachelor of Medicine & Bachelor of Surgery)', 'mbbs', 'UG', '5.5 Years', 'NEET UG Qualified + 10+2 with PCB (Min 50%)', 'As per Regulatory Authority', 'Premier medical program with comprehensive clinical rotations in 750+ bed teaching hospital.', 'Medical Practitioner, Resident Doctor, Civil Surgeon'],
            ['Faculty of Medicine & Dental Sciences', 'faculty-of-medicine', 'MD / MS (Doctor of Medicine / Master of Surgery)', 'md-ms', 'PG', '3 Years', 'NEET PG Qualified + MBBS with 1 Year Internship', 'As per Regulatory Authority', 'Postgraduate medical specializations in General Medicine, Surgery, Pediatrics, OBGY, Radiology.', 'Specialist Doctor, Medical Consultant, Surgeon'],
            ['Faculty of Medicine & Dental Sciences', 'faculty-of-medicine', 'MD (Homoeopathy)', 'md-homoeopathy', 'PG', '3 Years', 'BHMS from recognized university + AIAPGET', '₹1,20,000 / Year', 'Postgraduate homeopathic research and clinical practice in Materia Medica and Repertory.', 'Senior Homeopathic Consultant, Research Officer'],

            // Allied Science & Humanities
            ['Faculty of Allied Science & Humanities', 'faculty-of-allied-science-and-humanities', 'M.Sc. Yoga Science', 'm-sc-yoga', 'PG', '2 Years', 'Graduation in any stream', '₹30,000 / Year', 'Therapeutic yoga, yogic anatomy, pranayama, meditation, and holistic health management.', 'Yoga Therapist, Corporate Wellness Consultant, Yoga Instructor'],
            ['Faculty of Allied Science & Humanities', 'faculty-of-allied-science-and-humanities', 'PG Diploma in Yoga', 'pg-diploma-yoga', 'Diploma', '1 Year', 'Graduation in any discipline', '₹20,000 / Year', 'Practical yogic philosophy, asanas, and stress management techniques.', 'Certified Yoga Teacher, Wellness Coach'],
            ['Faculty of Allied Science & Humanities', 'faculty-of-allied-science-and-humanities', 'M.Sc. Fashion Design', 'm-sc-fashion-design', 'PG', '2 Years', 'Graduation in Fashion / Textile / Any stream', '₹45,000 / Year', 'Apparel manufacturing, textile science, CAD fashion illustration, and luxury brand management.', 'Fashion Designer, Textile Stylist, Apparel Merchandiser'],
            ['Faculty of Allied Science & Humanities', 'faculty-of-allied-science-and-humanities', 'Master of Journalism (MJ)', 'mj-journalism', 'PG', '2 Years', 'Graduation in any stream', '₹35,000 / Year', 'Broadcast journalism, digital media production, investigative reporting, and public relations.', 'News Anchor, Media Reporter, Content Producer, PR Manager']
        ];

        $insCourse = $pdo->prepare("INSERT INTO courses (department, dept_slug, course_name, slug, level, duration, eligibility, fees, description, career_scope) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($courses as $c) {
            $insCourse->execute($c);
        }
    }

    // Seed Dynamic CMS Pages
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pages");
    $stmt->execute();
    if ($stmt->fetchColumn() <= 2) {
        $pdo->exec("DELETE FROM pages");
        $pages = [
            [
                'Why SRK University',
                'why-srk',
                '<div class="why-srk-content">
                    <h2 class="text-maroon fw-bold mb-4">Why Choose Sarvepalli Radhakrishnan University, Bhopal?</h2>
                    <p class="lead text-dark">Sarvepalli Radhakrishnan University (SRKU) is Central India\'s premier academic and research powerhouse, established by Madhya Pradesh Niji Vishwavidyalaya Act and recognized by the University Grants Commission (UGC) under Section 2(f).</p>
                    
                    <div class="row g-4 my-4">
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 border-start border-4 border-danger h-100">
                                <h4 class="text-navy fw-bold"><i class="fas fa-microscope text-danger me-2"></i> 42+ Modern Laboratories</h4>
                                <p class="text-muted mb-0">High-end computing labs, pharmaceutical analysis suites, robotic testbeds, agricultural experimental farms, and clinical simulation centers.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 border-start border-4 border-danger h-100">
                                <h4 class="text-navy fw-bold"><i class="fas fa-briefcase text-danger me-2"></i> 94% Placement Record</h4>
                                <p class="text-muted mb-0">Strong industry linkages with 120+ MNC recruiting partners delivering highest package of 12 LPA and consistent corporate placements.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 border-start border-4 border-danger h-100">
                                <h4 class="text-navy fw-bold"><i class="fas fa-user-graduate text-danger me-2"></i> Multi-Disciplinary Ecosystem</h4>
                                <p class="text-muted mb-0">Over 50+ degree programs spanning Engineering, Pharmacy, Medicine, Nursing, Management, Law, Agriculture, and Paramedical Sciences.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded-4 border-start border-4 border-danger h-100">
                                <h4 class="text-navy fw-bold"><i class="fas fa-hospital-user text-danger me-2"></i> 750+ Bed Teaching Hospital</h4>
                                <p class="text-muted mb-0">On-campus super-specialty hospital providing live hands-on clinical exposure for medical, nursing, and paramedical students.</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-navy fw-bold mt-5 mb-3">Academic Excellence & Approvals</h3>
                    <p class="text-muted">All programs at SRKU are approved by respective apex statutory bodies including AICTE, Pharmacy Council of India (PCI), Indian Nursing Council (INC), Bar Council of India (BCI), and National Medical Commission (NMC).</p>
                </div>',
                'Why Choose Sarvepalli Radhakrishnan University Bhopal - 42+ Labs, 94% Placement Record, UGC Recognized'
            ],
            [
                'Vision & Mission',
                'vision-mission',
                '<div class="vision-mission-content">
                    <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-light">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-danger-subtle text-danger rounded-circle p-3"><i class="fas fa-eye fa-2x"></i></div>
                            <h2 class="text-maroon fw-bold mb-0">Our Vision</h2>
                        </div>
                        <p class="text-dark lead mb-0">"To emerge as a premier global university dedicated to value-based technical, medical, and higher education, pioneering groundbreaking research, fostering innovation, and empowering students with ethical leadership to transform society."</p>
                    </div>

                    <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-light">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-danger-subtle text-danger rounded-circle p-3"><i class="fas fa-bullseye fa-2x"></i></div>
                            <h2 class="text-navy fw-bold mb-0">Our Mission</h2>
                        </div>
                        <ul class="list-unstyled d-flex flex-column gap-3 mb-0 text-dark" style="font-size:1.05rem;">
                            <li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Quality Education:</strong> Imparting experiential and industry-relevant education that nurtures critical thinking, technical proficiency, and creative innovation.</li>
                            <li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Research & Development:</strong> Fostering an interdisciplinary research ecosystem to address national and global societal challenges.</li>
                            <li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Industry Integration:</strong> Collaborating with leading global corporations and research institutions for curriculum alignment and student career advancement.</li>
                            <li><i class="fas fa-check-circle text-danger me-2"></i> <strong>Ethical Character:</strong> Inculcating moral integrity, environmental sustainability, social responsibility, and national values in future leaders.</li>
                        </ul>
                    </div>
                </div>',
                'Vision and Mission of Sarvepalli Radhakrishnan University Bhopal'
            ],
            [
                'Accreditation & Approvals',
                'accreditation',
                '<div class="accreditation-content">
                    <h2 class="text-maroon fw-bold mb-3">Statutory Approvals & Accreditations</h2>
                    <p class="lead text-muted mb-4">Sarvepalli Radhakrishnan University is established by Madhya Pradesh Act No. 17 of 2015 and duly recognized by the University Grants Commission (UGC) under section 2(f) of the UGC Act, 1956.</p>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Regulatory Body</th>
                                    <th>Scope of Recognition</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>University Grants Commission (UGC)</strong></td>
                                    <td>Statutory University Recognition under Section 2(f)</td>
                                    <td><span class="badge bg-success">Recognized</span></td>
                                </tr>
                                <tr>
                                    <td><strong>All India Council for Technical Education (AICTE)</strong></td>
                                    <td>Engineering, Technology, Management & MCA Programs</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Pharmacy Council of India (PCI)</strong></td>
                                    <td>B.Pharm, D.Pharm, M.Pharm Programs</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Indian Nursing Council (INC) & MPNRC</strong></td>
                                    <td>B.Sc Nursing, PB B.Sc, M.Sc Nursing, NPCC</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Bar Council of India (BCI)</strong></td>
                                    <td>LL.B, BA LL.B Integrated, LL.M Programs</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                </tr>
                                <tr>
                                    <td><strong>National Medical Commission (NMC)</strong></td>
                                    <td>MBBS, MD, MS Programs</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>',
                'Statutory Approvals and Accreditations - UGC, AICTE, PCI, INC, BCI, NMC'
            ],
            [
                'Board of Management',
                'board-of-management',
                '<div class="board-content">
                    <h2 class="text-maroon fw-bold mb-4">Board of Management & University Leadership</h2>
                    <p class="text-muted mb-4">The governance of Sarvepalli Radhakrishnan University is overseen by visionary academicians, eminent scientists, and administrators committed to institutional excellence.</p>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                                <h4 class="text-navy fw-bold mb-1">Hon\'ble Chancellor</h4>
                                <p class="text-danger fw-semibold mb-2">Sarvepalli Radhakrishnan University</p>
                                <p class="text-muted small">Providing strategic direction and inspirational leadership to establish SRKU as a global benchmark in technical and medical education.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                                <h4 class="text-navy fw-bold mb-1">Vice-Chancellor</h4>
                                <p class="text-danger fw-semibold mb-2">Sarvepalli Radhakrishnan University</p>
                                <p class="text-muted small">Leading academic affairs, curriculum innovation, national accreditations, and cutting-edge research programs.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                                <h4 class="text-navy fw-bold mb-1">Registrar</h4>
                                <p class="text-danger fw-semibold mb-2">Office of Administration</p>
                                <p class="text-muted small">Custodian of university records, administrative operations, statutory compliance, and university governance.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                                <h4 class="text-navy fw-bold mb-1">Controller of Examinations</h4>
                                <p class="text-danger fw-semibold mb-2">Examination Cell</p>
                                <p class="text-muted small">Ensuring transparent, timely, and credible conduct of university semester examinations and degree awards.</p>
                            </div>
                        </div>
                    </div>
                </div>',
                'Board of Management and Key Governance Officers of SRKU Bhopal'
            ],
            [
                'Constituent Units & Colleges',
                'constituent-unit',
                '<div class="units-content">
                    <h2 class="text-maroon fw-bold mb-4">Constituent Colleges & Schools of SRKU</h2>
                    <p class="lead text-muted mb-4">The university houses dedicated constituent institutes offering specialized degree and research programs with world-class faculty and facilities.</p>
                    
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-4">
                            <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                                <h5 class="text-navy fw-bold">Faculty of Engineering</h5>
                                <p class="text-muted small mb-0">B.Tech, M.Tech & Diploma in CSE, AI/DS, Mechanical, Civil & Electrical.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                                <h5 class="text-navy fw-bold">Sri Sai College of Pharmacy</h5>
                                <p class="text-muted small mb-0">B.Pharm, D.Pharm & M.Pharm with PCI approved research labs.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                                <h5 class="text-navy fw-bold">RKDF College of Nursing</h5>
                                <p class="text-muted small mb-0">B.Sc Nursing, Post Basic, M.Sc & NPCC programs with clinical hospital training.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                                <h5 class="text-navy fw-bold">Faculty of Management</h5>
                                <p class="text-muted small mb-0">MBA, BBA with specialized dual concentrations in analytics and finance.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                                <h5 class="text-navy fw-bold">Faculty of Agriculture</h5>
                                <p class="text-muted small mb-0">B.Sc (Hons) & M.Sc Agriculture with 50+ acres of experimental research farm.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card p-4 border-0 shadow-sm rounded-4 h-100">
                                <h5 class="text-navy fw-bold">Faculty of Law</h5>
                                <p class="text-muted small mb-0">LL.B, BA LL.B (Hons) & LL.M with modern moot court hall.</p>
                            </div>
                        </div>
                    </div>
                </div>',
                'Constituent Colleges and Schools of Sarvepalli Radhakrishnan University'
            ],
            [
                'Admission Guidelines',
                'admission',
                '<div class="admission-content">
                    <h2 class="text-maroon fw-bold mb-3">Admission Guidelines 2026-27</h2>
                    <p class="lead text-muted mb-4">Admissions at Sarvepalli Radhakrishnan University are transparent, merit-based, and aligned with statutory regulatory norms.</p>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card p-4 bg-light rounded-4 border h-100">
                                <h4 class="text-navy fw-bold"><i class="fas fa-clipboard-list text-danger me-2"></i> How to Apply</h4>
                                <ol class="text-dark small ps-3 mb-0" style="line-height:2;">
                                    <li>Submit the online enquiry or application form on this website.</li>
                                    <li>Counseling & document verification by the Admission Cell.</li>
                                    <li>Seat allocation as per merit and eligibility criteria.</li>
                                    <li>Fee payment and enrollment confirmation.</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-4 bg-light rounded-4 border h-100">
                                <h4 class="text-navy fw-bold"><i class="fas fa-phone-volume text-danger me-2"></i> Admission Helpline</h4>
                                <p class="text-muted small mb-2">Our counselors are available Monday to Saturday (9 AM - 6 PM) to assist you:</p>
                                <p class="mb-1 fw-bold text-dark"><i class="fas fa-phone text-danger me-2"></i> 0755 - 4911204</p>
                                <p class="mb-0 fw-bold text-dark"><i class="fas fa-envelope text-danger me-2"></i> exam@srku.edu.in</p>
                            </div>
                        </div>
                    </div>
                </div>',
                'SRKU Admission Process, Guidelines and Eligibility 2026-27'
            ]
        ];
        $insPage = $pdo->prepare("INSERT INTO pages (title, slug, content, meta_description) VALUES (?, ?, ?, ?)");
        foreach ($pages as $p) {
            $insPage->execute($p);
        }
    }

    // Seed News & Ticker
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM news");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $newsItems = [
            ['Admissions Open for Academic Session 2026-27', 'admissions-open-2026', 'Applications are invited for UG, PG, Diploma, and Ph.D. programs across Engineering, Pharmacy, Nursing, Management, Agriculture, Law, and Medicine.', 'Admission', '2026-08-01', 'assets/images/news1.jpg', 1],
            ['National Campus Placement Drive 2026 - Highest Package 12 LPA', 'placement-drive-2026', 'Top tier recruiters including TCS, Wipro, Infosys, Cipla, and Sun Pharma participated in the annual mega placement drive.', 'Placement', '2026-08-05', 'assets/images/news2.jpg', 1],
            ['International Conference on Advanced Research in Pharmaceuticals & AI', 'intl-conference-2026', 'SRKU hosted delegates from 12 countries to discuss AI in drug discovery and sustainable energy.', 'Event', '2026-08-10', 'assets/images/news3.jpg', 0],
            ['Tarang 2026 - Annual Inter-University Sports & Cultural Fest Announced', 'tarang-annual-fest-2026', 'Three days of vibrant cultural performances, sports tournaments, and tech competitions.', 'Campus Life', '2026-08-15', 'assets/images/news4.jpg', 0]
        ];
        $insNews = $pdo->prepare("INSERT INTO news (title, slug, content, category, publish_date, image_url, is_ticker) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($newsItems as $n) {
            $insNews->execute($n);
        }
    }

    // Seed Banners
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM banners");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $banners = [
            ['Welcome to SRK University, Bhopal', 'UGC-Recognized Premier University in MP offering Engineering, Pharmacy, Medicine & Management', 'assets/images/banner1.jpg', 'Apply Now', 'contact.php#apply', 1],
            ['Excellence in Research & 94% Placements', '42+ High-Tech Labs with 120+ Top Recruiter Partnerships', 'assets/images/banner2.jpg', 'Explore Courses', 'courses.php', 2],
            ['State-of-the-Art Multi-Disciplinary Campus', 'Spread over lush green campus with 750+ Bed Teaching Hospital & Sports Complex', 'assets/images/banner3.jpg', 'Campus Tour', 'facilities.php', 3]
        ];
        $insBanner = $pdo->prepare("INSERT INTO banners (title, subtitle, image_url, btn_text, btn_link, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($banners as $b) {
            $insBanner->execute($b);
        }
    }
}
