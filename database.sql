-- SRKU Database Schema
CREATE DATABASE IF NOT EXISTS `srku_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `srku_db`;

-- Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin Default User (admin / admin123)
INSERT INTO `users` (`username`, `password`, `email`) VALUES
('admin', '$2y$10$wN9aJ3BskhQ3r.h4gqJdJ.J7X7oO7H8w8O2h1j3k4l5m6n7o8p9q', 'admin@srku.edu.in')
ON DUPLICATE KEY UPDATE `username`=`username`;

-- Dynamic Pages Table
CREATE TABLE IF NOT EXISTS `pages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(191) NOT NULL UNIQUE,
  `content` LONGTEXT,
  `meta_description` TEXT,
  `status` ENUM('published','draft') DEFAULT 'published',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Pages
INSERT INTO `pages` (`title`, `slug`, `content`, `meta_description`) VALUES
('Why SRK University', 'why-srk', '<h2>Why Choose Sarvepalli Radhakrishnan University?</h2><p>Sarvepalli Radhakrishnan University (SRKU) is a premier technical and academic ecosystem designed for global industry leadership.</p>', 'Why SRKU University Bhopal'),
('Vision & Mission', 'vision-mission', '<h2>Our Vision</h2><p>To emerge as a world-class university committed to value-based technical and higher education.</p><h2>Our Mission</h2><p>Providing high-quality education, state-of-the-art research facilities, and industry exposure.</p>', 'SRKU Vision and Mission Statement');

-- Courses & Programs Table
CREATE TABLE IF NOT EXISTS `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `department` VARCHAR(100) NOT NULL,
  `course_name` VARCHAR(255) NOT NULL,
  `duration` VARCHAR(50),
  `eligibility` TEXT,
  `fees` VARCHAR(100),
  `status` ENUM('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `courses` (`department`, `course_name`, `duration`, `eligibility`, `fees`) VALUES
('Department of Engineering', 'B.Tech Computer Science Engineering', '4 Years', '10+2 with Physics, Math (50%)', '₹65,000 / Year'),
('Department of Engineering', 'M.Tech Mechanical Engineering', '2 Years', 'B.E./B.Tech (50%)', '₹55,000 / Year'),
('Faculty of Pharmacy', 'Bachelor of Pharmacy (B.Pharm)', '4 Years', '10+2 with PCB/PCM (50%)', '₹80,000 / Year'),
('Faculty of Computer Application', 'Master of Computer Applications (MCA)', '2 Years', 'BCA / B.Sc CS (50%)', '₹50,000 / Year'),
('Department of Management', 'Master of Business Administration (MBA)', '2 Years', 'Graduation in any stream (50%)', '₹60,000 / Year');

-- Banners Table
CREATE TABLE IF NOT EXISTS `banners` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `subtitle` TEXT,
  `image_url` VARCHAR(255),
  `btn_text` VARCHAR(50),
  `btn_link` VARCHAR(255),
  `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `banners` (`title`, `subtitle`, `image_url`, `btn_text`, `btn_link`, `sort_order`) VALUES
('Welcome to SRK University Bhopal', 'Premier Technical and Academic Ecosystem for Global Leadership', 'assets/images/banner1.jpg', 'Apply Now', '#apply-modal', 1),
('Excellence in Research & Placements', '94% Placement Record with 120+ Recruiting Partners', 'assets/images/banner2.jpg', 'Explore Courses', 'courses.php', 2);

-- News & Updates Table
CREATE TABLE IF NOT EXISTS `news` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT,
  `category` VARCHAR(50) DEFAULT 'Announcement',
  `publish_date` DATE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `news` (`title`, `content`, `category`, `publish_date`) VALUES
('Admissions Open for Academic Session 2026-27', 'Applications are invited for UG, PG, Diploma, and Ph.D. programs.', 'Admission', '2026-08-01'),
('National Campus Placement Drive 2026', 'Top MNCs visiting campus for engineering and management graduates.', 'Placement', '2026-08-05');

-- Enquiries Table
CREATE TABLE IF NOT EXISTS `enquiries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `course` VARCHAR(100),
  `message` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Site Settings Table
CREATE TABLE IF NOT EXISTS `settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('helpline', '0755 - 4911204'),
('email', 'exam@srku.edu.in'),
('address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026'),
('ticker_text', 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for UG, PG & PhD Courses');
