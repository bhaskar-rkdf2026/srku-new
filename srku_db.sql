-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2026 at 09:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srku_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'admin',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Super Admin', 'admin@srku.edu.in', '$2y$10$w6D9t5XgKx0W8E3uYjPj0.7U8zQ5Wv3yN9k2X9Z8L7M6N5O4P3Q2', 'admin', '2026-08-07 11:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` int(11) NOT NULL,
  `applicant_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `course_interested` varchar(150) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT '#',
  `tag` varchar(50) DEFAULT 'LATEST',
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `link`, `tag`, `status`, `created_at`) VALUES
(5, 'Admissions Open 2026-27 across Engineering, Pharmacy, Nursing, Management & Agriculture.', 'admissions.php', 'ADMISSION', 1, '2026-08-07 12:36:08'),
(6, 'NIRF 2026 Institutional Ranking Data Submission Available for Public Review.', 'uploads/pdf/NIRF-2026.pdf', 'NIRF', 1, '2026-08-07 12:36:08'),
(7, 'AICTE Pragati & Saksham Scholarship Application Open. Apply Online.', 'notices.php', 'SCHOLARSHIP', 1, '2026-08-07 12:36:08'),
(8, 'Ph.D. Entrance Examination 2026 Guidelines and Syllabus Released.', 'notices.php', 'RESEARCH', 1, '2026-08-07 12:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `btn_text` varchar(50) DEFAULT NULL,
  `btn_link` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `page_slug` varchar(100) DEFAULT 'home'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `image_url`, `btn_text`, `btn_link`, `sort_order`, `page_slug`) VALUES
(1, 'Welcome to SRK University, Bhopal', 'UGC-Recognized Premier University in MP offering Engineering, Pharmacy, Medicine & Management', 'assets/images/banner1.jpg', 'Apply Now', 'contact.php#apply', 1, 'home'),
(2, 'Excellence in Research & 94% Placements', '42+ High-Tech Labs with 120+ Top Recruiter Partnerships', 'assets/images/banner2.jpg', 'Explore Courses', 'courses.php', 2, 'home'),
(3, 'State-of-the-Art Multi-Disciplinary Campus', 'Spread over lush green campus with 750+ Bed Teaching Hospital & Sports Complex', 'assets/images/banner3.jpg', 'Campus Tour', 'facilities.php', 3, 'home');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `author` varchar(100) NOT NULL DEFAULT 'SRKU Editorial Board',
  `category` varchar(100) NOT NULL DEFAULT 'Campus Life',
  `short_description` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `author`, `category`, `short_description`, `content`, `image_url`, `publish_date`, `views`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tarang 2026: Annual Inter-University Cultural & Sports Extravaganza', 'tarang-annual-fest-2026', 'Student Affairs Committee', 'Campus Life', 'A grand 3-day carnival bringing together over 5,000 students across central India for national-level music, dance, hackathons, and athletic tournaments.', '<p>Sarvepalli Radhakrishnan University (SRKU) celebrated its flagship annual inter-university cultural and athletic fest, <strong>Tarang 2026</strong>, with unprecedented zeal and grandeur on the lush green Bhopal campus. Spanning over three high-octane days, the mega event witnessed enthusiastic participation from more than 45 colleges and universities across India.</p>\n<h3>Electrifying Events & Competitions</h3>\n<p>The cultural fest featured a diverse array of competitive events covering fine arts, classical dance, battle of the bands, street plays (Nukkad Natak), fashion parade, and a 24-hour national hackathon organized by the Department of Computer Science & Engineering.</p>\n<ul>\n    <li><strong>National Hackathon 2026:</strong> Over 120 tech teams developed AI-driven sustainable solutions for rural agriculture and healthcare robotics.</li>\n    <li><strong>Battle of Bands:</strong> High-voltage rock and classical fusion performances judged by national celebrity musicians.</li>\n    <li><strong>Sports Championships:</strong> Inter-collegiate tournaments in Cricket, Basketball, Football, Volleyball, and Badminton.</li>\n</ul>\n<p>The fest concluded with a mega celebrity concert, laser show, and an award distribution ceremony where outstanding student performers were awarded trophies and cash prizes worth ₹5 Lakhs.</p>', 'assets/uploads/2026/07/001.webp', '2026-08-15', 7, 'published', '2026-08-24 09:42:38', '2026-08-25 07:23:51'),
(2, 'International Conference on Emerging Horizons in AI, Machine Learning & Drug Discovery', 'international-conference-ai-drug-discovery', 'Faculty of Engineering & Pharmacy', 'Research & Tech', 'Renowned scientists, pharmacologists, and AI researchers from 12 countries convened at SRKU to explore computational biotechnology and automated healthcare diagnostics.', '<p>The Faculty of Engineering & Technology and Sri Sai College of Pharmacy at SRKU successfully hosted a two-day <strong>International Conference on Artificial Intelligence and Bio-Pharmaceutical Innovation (ICABPI 2026)</strong> in hybrid mode.</p>\n<h3>Highlights of the Research Summit</h3>\n<p>The conference brought together distinguished keynote speakers from premier global institutions, including IITs, AIIMS, and top pharmaceutical R&D labs from the USA, Germany, and Japan.</p>\n<blockquote>\"The convergence of generative AI algorithms and molecular docking is drastically reducing drug discovery cycles from 10 years to mere months,\" remarked the keynote speaker during the inaugural address.</blockquote>\n<p>Over 140 peer-reviewed research papers were presented by Ph.D. scholars, faculty members, and industrial researchers. All accepted manuscripts will be published in Scopus-indexed and UGC-CARE approved journals.</p>', 'assets/uploads/2026/07/002.webp', '2026-08-10', 1, 'published', '2026-08-24 09:42:38', '2026-08-25 07:23:55'),
(3, 'National Campus Placement Drive 2026: Record Offers & Highest Package of ₹12 LPA', 'national-campus-placement-drive-2026', 'Central Training & Placement Cell', 'Placements', 'Over 500 marquee recruiters including TCS, Wipro, Infosys, Sun Pharma, Cipla, and Tech Mahindra recruited graduating batches across technical and medical streams.', '<p>The Training and Placement Cell (T&P) at Sarvepalli Radhakrishnan University announced record-shattering outcomes for the 2026 graduating batch. With over 85 corporate recruiters visiting the campus in Phase-I alone, more than 820 job offers were extended to students across engineering, management, pharmacy, paramedical, and agriculture disciplines.</p>\n<h3>Key Placement Highlights 2026</h3>\n<ul>\n    <li><strong>Highest Package:</strong> ₹12.00 LPA secured by B.Tech CSE students in AI Product Engineering.</li>\n    <li><strong>Average Package:</strong> Significant 28% year-on-year jump reaching ₹5.20 LPA.</li>\n    <li><strong>Top Recruiting Partners:</strong> TCS, Infosys, Wipro, Cipla, Lupin, Sun Pharma, HCL Technologies, ICICI Bank, and Byju’s.</li>\n</ul>\n<p>SRKU’s dedicated corporate relations division provides rigorous pre-placement grooming including mock interviews, coding bootcamps, resume review clinics, and soft-skill development modules starting from the 3rd year.</p>', 'assets/uploads/2026/07/003.webp', '2026-08-05', 1, 'published', '2026-08-24 09:42:38', '2026-08-25 07:23:59'),
(4, 'Admissions Open 2026-27: Comprehensive Career Guide to 95+ Degree Programs', 'admissions-open-academic-session-2026-27', 'Office of Academic Admissions', 'Admissions', 'Explore premier academic pathways across Engineering, Medical, Dental, Ayurveda, Homoeopathy, Law, Nursing, Agriculture, and Management with merit scholarships.', '<p>Sarvepalli Radhakrishnan University (SRKU), Bhopal announces the commencement of online and campus admissions for the upcoming academic session <strong>2026-27</strong>. Applications are invited for over 95 multidisciplinary undergraduate, postgraduate, integrated, diploma, and doctoral (Ph.D.) programs.</p>\n<h3>Why Choose SRK University?</h3>\n<p>Recognized by UGC under Section 2(f) of the UGC Act 1956 and approved by statutory national councils (NMC, DCI, NCISM, NCH, AICTE, PCI, BCI, INC), the university offers modern experiential education backed by:</p>\n<ul>\n    <li>750-Bed Teaching Multi-Specialty Hospital for live medical internships.</li>\n    <li>42+ State-of-the-Art Research Laboratories & High-Performance Computing Centers.</li>\n    <li>Merit Scholarships for meritorious students, sports champions, and reserved category candidates.</li>\n    <li>On-campus hostel accommodations, gymnasiums, sports arenas, and university-wide bus transportation.</li>\n</ul>\n<p>Interested candidates can apply online directly through the university website or visit the central counseling center at the Bhopal campus.</p>', 'assets/uploads/2026/07/004.webp', '2026-08-01', 0, 'published', '2026-08-24 09:42:38', '2026-08-24 09:42:38'),
(5, 'Modern Advancements in Ayurvedic & Integrative Medicine: SRKU Hospital Insights', 'advancements-ayurvedic-integrative-medicine', 'SRK College of Ayurveda Hospital', 'Medical & Health', 'How ancient Ayurvedic wisdom and modern clinical diagnostics combine to deliver holistic wellness and effective chronic disease management.', '<p>The Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre is leading the paradigm shift towards evidence-based integrative healthcare in Central India. Combining ancient Panchakarma therapies with state-of-the-art diagnostic imaging and pathology labs, the 100-bed Ayurvedic hospital treats over 200 patients daily.</p>\n<h3>Specialized Treatment Wings</h3>\n<ul>\n    <li><strong>Kayachikitsa (Internal Medicine):</strong> Holistic management of metabolic, joint, and chronic lifestyle disorders.</li>\n    <li><strong>Panchakarma Center:</strong> Specialized detoxification treatments including Vamana, Virechana, Basti, Nasya, and Raktamokshana.</li>\n    <li><strong>Shalya Tantra:</strong> Advanced Kshara Sutra therapy for anorectal ailments with zero recurrence.</li>\n</ul>\n<p>Students of BAMS and MD Ayurveda receive direct hands-on clinical rotations under senior Ayurvedic doctors and clinical researchers.</p>', 'assets/uploads/2026/07/001.webp', '2026-07-25', 0, 'published', '2026-08-24 09:42:38', '2026-08-24 09:42:38'),
(6, 'Sustainable Smart Agriculture & Drone Technology in Precision Farming', 'sustainable-smart-agriculture-drone-technology', 'Faculty of Agriculture', 'Agriculture & Bio', 'SRKU Faculty of Agriculture integrates IoT soil sensors, automated drip irrigation, and aerial drone surveillance across its 50-acre experiential farm.', '<p>The Faculty of Agriculture at SRKU is transforming traditional agricultural education into high-tech sustainable agri-business. With 50+ acres of dedicated experimental farms, polyhouses, and vermicompost units, students gain firsthand experience in organic cultivation, seed technology, and drone-assisted crop monitoring.</p>\n<h3>Key Training Verticals</h3>\n<ul>\n    <li><strong>Precision Spraying:</strong> Agricultural drones for micro-nutrient spraying and pest infestation scanning.</li>\n    <li><strong>Hydroponics & Greenhouses:</strong> Soil-less vegetable cultivation and climate-controlled floriculture.</li>\n    <li><strong>Soil Health Laboratories:</strong> Rapid testing of NPK ratios and organic carbon levels for local farmers.</li>\n</ul>\n<p>Graduates from B.Sc. (Hons) Agriculture secure prestigious roles in NABARD, IFFCO, agrochemical multinationals, and state agricultural departments.</p>', 'assets/uploads/2026/07/002.webp', '2026-07-18', 3, 'published', '2026-08-24 09:42:38', '2026-08-25 10:14:10');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `father_name` varchar(150) DEFAULT NULL,
  `enrollment_number` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `institute_name` varchar(255) DEFAULT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `year_semester` varchar(100) DEFAULT NULL,
  `complaint_type` varchar(100) NOT NULL DEFAULT 'General',
  `complaint_details` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `name`, `father_name`, `enrollment_number`, `email`, `phone`, `institute_name`, `course_name`, `year_semester`, `complaint_type`, `complaint_details`, `status`, `created_at`) VALUES
(1, 'Megha RKDF', 'test', '123343456576788', 'megha.rkdf2026@gmail.com', '5345435656', 'test', 'fghfgjh', 'hjkj', 'Ragging / Harassment', 'ghkfyjgyuikhjkhjkjhkjhkjkhj', 'New', '2026-08-24 09:36:17'),
(3, 'Megha RKDF', 'test', '123343456576788', 'megha.rkdf2026@gmail.com', '5345435656', 'test', 'fghfgjh', 'hjkj', 'Ragging / Harassment', 'ghkfyjgyuikhjkhjkjhkjhkjkhj', 'New', '2026-08-24 09:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `department` varchar(150) DEFAULT NULL,
  `dept_slug` varchar(100) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `course_name` varchar(150) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `level` varchar(50) DEFAULT 'UG',
  `degree_level` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `eligibility` text NOT NULL,
  `fees` varchar(100) DEFAULT NULL,
  `specializations` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `career_scope` text DEFAULT NULL,
  `syllabus_url` varchar(255) DEFAULT NULL,
  `scheme_url` varchar(255) DEFAULT NULL,
  `fees_per_year` varchar(50) DEFAULT 'As per university norms',
  `status` varchar(20) DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `department`, `dept_slug`, `faculty_id`, `course_name`, `slug`, `level`, `degree_level`, `duration`, `eligibility`, `fees`, `specializations`, `description`, `career_scope`, `syllabus_url`, `scheme_url`, `fees_per_year`, `status`, `created_at`) VALUES
(77, 'RKDF Institute of Science and Technology (1995)', 'rkdf-institute-of-science-and-technology', NULL, 'Diploma in Engineering (Polytechnic)', 'diploma-engineering-polytechnic', 'Diploma', '', '3 Years', 'As per AICTE / Regulatory Body Norms', '', 'Civil Engineering, Mechanical Engineering, Electrical Engineering, Electronics & Instrumentation Engineering', 'Hands-on polytechnic engineering diploma with intensive lab workshops, industrial apprenticeships, and live machinery handling in Civil, Mechanical, Electrical, and Electronics & Instrumentation streams.', 'Junior Engineer, CAD Technician, Plant Supervisor, Site Supervisor, Technical Assistant', 'assets/uploads/syllabus/DIPLOMA-ALL-BRANCH-I-II-SEM-SYLLABUS-REG2019-BATCH-ONWARDS.pdf', 'assets/uploads/syllabus/DIPLOMA-ALL-BRANCH-I-II-SEM-SCHEME-REG2019-BATCH-ONWARDS.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(78, 'RKDF Institute of Science and Technology (1995)', 'rkdf-institute-of-science-and-technology', NULL, 'B.Tech. (Bachelor of Technology)', 'b-tech-engineering', 'UG', '', '4 Years', 'As per AICTE / Regulatory Body Norms', '', 'Civil Engineering, Computer Science & Engineering, Electrical Engineering, Electrical & Electronics Engineering, Electronics & Communication Engineering, Electronics & Instrumentation Engineering, Electronics Engineering, AI & ML Engineering, Mechanical Engineering', 'Flagship AICTE approved B.Tech degree offering multiple high-demand engineering disciplines. Backed by state-of-the-art computing labs, robotics suites, advanced workshops, and 94% placement record.', 'Software Engineer, AI/ML Specialist, Systems Architect, Mechanical Design Engineer, Civil Project Manager, Electrical Engineer, IoT Developer', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(79, 'RKDF Institute of Science and Technology (1995)', 'rkdf-institute-of-science-and-technology', NULL, 'M.Tech. / M.E. (Master of Technology)', 'm-tech-engineering', 'PG', '', '2 Years', 'As per AICTE / Regulatory Body Norms', '', 'Computer Science & Engineering, Digital Communication, Information Technology, Microwave & Millimeter Engg., Power Electronics, Thermal Engineering, AI & DS Engineering, Structural Engineering, VLSI Design', 'Advanced postgraduate research engineering program across multiple specialized disciplines including AI & Data Science, VLSI Design, Power Electronics, and Structural Engineering.', 'Principal R&D Engineer, VLSI Design Engineer, AI Architect, Structural Consultant, University Faculty, Technical Lead', 'assets/uploads/syllabus/computer-science-2020-complete.pdf', 'assets/uploads/syllabus/MTECH-SYLLABUS_COMPLETE.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(80, 'RKDF Institute of Science and Technology (1995)', 'rkdf-institute-of-science-and-technology', NULL, 'Master of Computer Applications (MCA)', 'mca-rkdf-ist', 'PG', '', '2 Years', 'As per AICTE / Regulatory Body Norms', '', 'Full-Stack Web Development, Cloud Computing, AI & Machine Learning, DevOps, Cyber Security', 'Industry-aligned MCA degree focusing on software architectures, enterprise Java/Python development, cloud microservices, and mobile computing.', 'Senior Software Developer, Cloud Architect, Full Stack Developer, Database Administrator, Systems Analyst', 'assets/uploads/syllabus/MCA-I-Sem-Syllabus-2020.pdf', 'assets/uploads/syllabus/MCA-I-Sem-Scheme-2020.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(81, 'RKDF Institute of Science and Technology (1995)', 'rkdf-institute-of-science-and-technology', NULL, 'Master of Business Administration (MBA)', 'mba-rkdf-ist', 'PG', '', '2 Years', 'As per AICTE / Regulatory Body Norms', '', 'Marketing, Finance, Human Resource Management, Information Technology, Operations Management', 'AICTE approved MBA with corporate internships, live business consulting projects, and dual specialization options.', 'Business Manager, Marketing Strategist, Financial Analyst, HR Manager, Management Consultant', 'assets/uploads/syllabus/scheme-and-syllabus-complete.pdf', 'assets/uploads/syllabus/MBA-syllabus-Dual-Specialization-2017-2018.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(82, 'RKDF Institute of Science and Technology (1995)', 'rkdf-institute-of-science-and-technology', NULL, 'Doctorate (Ph.D. in Engineering & Technology)', 'phd-engineering', 'Doctorate', '', '3-5 Years', 'As per AICTE / Regulatory Body Norms', '', 'Computer Science, AI/ML, VLSI & Embedded Systems, Renewable Energy, Thermal Engineering, Structural Mechanics', 'Doctoral research program providing full access to research laboratories, patent filing support, and doctoral mentorship.', 'Research Scientist, Senior Professor, Chief Technology Officer, Corporate R&D Head', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(83, 'RKDF IST-MCA (1999)', 'rkdf-institute-science-technology-mca', NULL, 'Master of Computer Applications (MCA)', 'mca-ist-1999', 'PG', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Enterprise Applications, Distributed Systems, Cloud Computing, Cyber Security', 'Dedicated MCA program with extensive alumni network and excellence in global IT companies.', 'Software Lead, IT Consultant, Systems Architect, Cyber Security Specialist', 'assets/uploads/syllabus/MCA-I-Sem-Syllabus-2020.pdf', 'assets/uploads/syllabus/MCA-I-Sem-Scheme-2020.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(84, 'RKDF Institute of Management (2003)', 'rkdf-institute-of-management', NULL, 'MBA (Full Time)', 'mba-full-time-rkdf-management', 'PG', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Marketing, Finance, Human Resource (HR), Production & Operation, Rural, Retail, International Business (IB), Supply Chain, Event, Information Technology (IT), Hospital Administration', 'Flagship Full Time MBA program offering multiple high-demand specializations with industry live cases, corporate mentors, and placement assistance.', 'Marketing Director, Financial Controller, HR Business Partner, Supply Chain Manager, Hospital Administrator, Retail Head, Event Director', 'assets/uploads/syllabus/scheme-and-syllabus-complete.pdf', 'assets/uploads/syllabus/MBA-syllabus-Dual-Specialization-2017-2018.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(85, 'RKDF Institute of Management (2003)', 'rkdf-institute-of-management', NULL, 'Ph.D. in Management Studies', 'phd-management', 'Doctorate', '', '3-5 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Marketing Analytics, Strategic HR, Financial Derivatives, Global Supply Chain, Healthcare Management', 'Doctoral program focusing on contemporary management challenges, empirical business research, and academic leadership.', 'Management Professor, Senior Consultant, Research Director, Policy Advisor', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(86, 'RKDF Institute of Business Management (2006)', 'rkdf-institute-of-business-management', NULL, 'Master of Business Administration (MBA - Business Management)', 'mba-business-management', 'PG', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Business Analytics, Marketing, Finance, HR, Operations', 'Executive-oriented MBA focusing on strategic decision making, business analytics, and global trade practices.', 'Business Strategist, Operations Manager, Corporate Analyst, Project Leader', 'assets/uploads/syllabus/scheme-and-syllabus-complete.pdf', 'assets/uploads/syllabus/MBA-syllabus-Dual-Specialization-2017-2018.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(87, 'Department of Management', 'department-of-management', NULL, 'MBA in Logistics & Supply Chain Management', 'mba-logistics-supply-chain', 'PG', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Freight Logistics, Port & Shipping Management, Warehouse Automation, Procurement & Global Sourcing, Inventory Analytics', 'Specialized postgraduate degree addressing the global demand in supply chain optimization, international freight, e-commerce fulfillment, and logistics analytics.', 'Logistics Manager, Supply Chain Director, Procurement Specialist, Freight Forwarding Executive, Warehouse Operations Head', 'assets/uploads/syllabus/scheme-and-syllabus-complete.pdf', 'assets/uploads/syllabus/MBA-syllabus-Dual-Specialization-2017-2018.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(88, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy', NULL, 'Diploma in Pharmacy (D. Pharmacy)', 'd-pharmacy-rkdf-1995', 'Diploma', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Pharmacognosy, Pharmaceutical Chemistry, Hospital & Clinical Pharmacy', 'PCI approved foundational pharmacy diploma preparing students for state pharmacy council registration as Registered Pharmacists.', 'Registered Pharmacist, Retail Pharmacy Owner, Hospital Pharmacist, Medical Representative', 'assets/uploads/syllabus/1st-year-D.Pharm-syllabus.pdf', 'assets/uploads/syllabus/1st-year-D.Pharm-sch_syll.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(89, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy', NULL, 'Bachelor of Pharmacy (B.Pharmacy)', 'b-pharmacy-rkdf-1995', 'UG', '', '4 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Medicinal Chemistry, Novel Drug Delivery, Pharmacology & Toxicology, Pharmacognosy, Pharmaceutical Biotechnology', 'Flagship PCI & AICTE approved B.Pharm program with sophisticated formulation, analytical, and pharmacology laboratories.', 'Drug Inspector, QC/QA Chemist, Formulation Scientist, Regulatory Affairs Associate, Clinical Research Associate', 'assets/uploads/syllabus/Syllabus_B_Pharm-semester-I.pdf', 'assets/uploads/syllabus/Schemes_B_Pharm-1.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(90, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy', NULL, 'Master of Pharmacy (M.Pharmacy)', 'm-pharmacy-rkdf-1995', 'PG', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Pharmacognosy, Pharmaceutical Chemistry, Industrial Pharmacy', 'Postgraduate research program in 5 key pharmaceutical disciplines with advanced chromatographic (HPLC, UV-Vis) and animal simulation facilities.', 'Senior Formulation Scientist, QA/QC Manager, Pharmacovigilance Associate, Research Scientist, Professor', 'assets/uploads/syllabus/PHARMACEUTICAL-CHEMISTRY-I-SEMESTER-1.pdf', 'assets/uploads/syllabus/complete-scheme.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(91, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy', NULL, 'Doctorate (Ph.D. in Pharmaceutical Sciences)', 'phd-pharmacy', 'Doctorate', '', '3-5 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Nanomedicine, Targeted Drug Delivery, Phytochemistry, Molecular Pharmacology, Synthetic Chemistry', 'Doctoral research program fostering innovation in novel therapeutics, drug delivery systems, and pharmaceutical patents.', 'Principal Scientist, R&D Director, Pharmacy College Principal, Senior Research Fellow', 'assets/uploads/syllabus/1st-year-D.Pharm-syllabus.pdf', 'assets/uploads/syllabus/1st-year-D.Pharm-sch_syll.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(92, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy', NULL, 'Diploma in Pharmacy (D.Pharmacy)', 'd-pharmacy-sr-2018', 'Diploma', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Pharmacognosy, Drug Store & Business Management', 'PCI recognized pharmacy diploma focusing on patient counseling, dispensing, and community healthcare.', 'Registered Pharmacist, Drug Store Manager, Dispensary Chemist', 'assets/uploads/syllabus/1st-year-D.Pharm-syllabus.pdf', 'assets/uploads/syllabus/1st-year-D.Pharm-sch_syll.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(93, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy', NULL, 'Bachelor of Pharmacy (B.Pharmacy)', 'b-pharmacy-sr-2018', 'UG', '', '4 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutical Engineering, Pharmacology, Clinical Pharmacy, Medicinal Chemistry', 'Comprehensive degree preparing pharmacy graduates for global pharmaceutical manufacturing and healthcare sectors.', 'Production Officer, QA Associate, Pharmacist, Clinical Trial Coordinator', 'assets/uploads/syllabus/Syllabus_B_Pharm-semester-I.pdf', 'assets/uploads/syllabus/Schemes_B_Pharm-1.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(94, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy', NULL, 'Master of Pharmacy (M.Pharmacy)', 'm-pharmacy-sr-2018', 'PG', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Pharmacognosy, Pharmaceutical Analysis, Pharmaceutical Chemistry', 'Postgraduate research in diverse disciplines including advanced Pharmaceutical Analysis, modern analytical method validation, and formulation kinetics.', 'Analytical Method Developer, Quality Assurance Specialist, Clinical Research Scientist', 'assets/uploads/syllabus/PHARMACEUTICAL-CHEMISTRY-I-SEMESTER-1.pdf', 'assets/uploads/syllabus/complete-scheme.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(95, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-srk-bhopal', NULL, 'Diploma in Pharmacy (D.Pharmacy - APJ Kalam)', 'd-pharmacy-apj-2018', 'Diploma', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Pharmacognosy, Biochemistry', 'PCI approved D.Pharm program focusing on pharmaceutical skills and practical laboratory work.', 'Licensed Pharmacist, Hospital Dispensary Officer', 'assets/uploads/syllabus/1st-year-D.Pharm-syllabus.pdf', 'assets/uploads/syllabus/1st-year-D.Pharm-sch_syll.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(96, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-srk-bhopal', NULL, 'Bachelor of Pharmacy (B.Pharmacy - APJ Kalam)', 'b-pharmacy-apj-2018', 'UG', '', '4 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Medicinal Chemistry, Pharmacology, Pharmacognosy, Pharmaceutics', 'Undergraduate pharmacy curriculum providing hands-on synthesis, formulation design, and clinical pharmacology training.', 'Pharmaceutical Executive, Drug Analyst, Regulatory Associate', 'assets/uploads/syllabus/Syllabus_B_Pharm-semester-I.pdf', 'assets/uploads/syllabus/Schemes_B_Pharm-1.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(97, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-srk-bhopal', NULL, 'Master of Pharmacy (M.Pharmacy) - Including DRA', 'm-pharmacy-apj-2018', 'PG', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Pharmacognosy, Pharmaceutical Chemistry, DRA (Drug Regulatory Affairs)', 'Specialized postgraduate degree featuring Drug Regulatory Affairs (DRA), dossier submissions (CTD/eCTD), USFDA/EMA compliance, and advanced drug chemistry.', 'Drug Regulatory Affairs Manager, Compliance Specialist, R&D Chemist, QA Lead', 'assets/uploads/syllabus/PHARMACEUTICAL-CHEMISTRY-I-SEMESTER-1.pdf', 'assets/uploads/syllabus/complete-scheme.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(98, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-srk-bhopal', NULL, 'Diploma in Pharmacy (D.Pharmacy - Sri Sai)', 'd-pharmacy-sri-sai-2019', 'Diploma', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Hospital Pharmacy', 'PCI recognized diploma in pharmacy with rigorous practical dispensing and community healthcare exposure.', 'Registered Pharmacist, Medical Store Executive', 'assets/uploads/syllabus/1st-year-D.Pharm-syllabus.pdf', 'assets/uploads/syllabus/1st-year-D.Pharm-sch_syll.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(99, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-srk-bhopal', NULL, 'Bachelor of Pharmacy (B.Pharmacy - Sri Sai)', 'b-pharmacy-sri-sai-2019', 'UG', '', '4 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Pharmaceutical Chemistry, Quality Assurance', 'Four-year undergraduate degree fostering deep pharmaceutical expertise, research ethics, and industrial readiness.', 'Formulation Chemist, Quality Control Specialist, Clinical Data Coordinator', 'assets/uploads/syllabus/Syllabus_B_Pharm-semester-I.pdf', 'assets/uploads/syllabus/Schemes_B_Pharm-1.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(100, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-srk-bhopal', NULL, 'Master of Pharmacy (M.Pharmacy) - Including Quality Assurance', 'm-pharmacy-sri-sai-2019', 'PG', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Quality Assurance, Pharmaceutical Chemistry, Pharmacognosy', 'Postgraduate pharmacy program with dedicated specialization in Quality Assurance (QA), validation, cGMP guidelines, and GLP audit protocols.', 'Quality Assurance Head, Quality Auditor, Senior Formulation Scientist, Regulatory Analyst', 'assets/uploads/syllabus/PHARMACEUTICAL-CHEMISTRY-I-SEMESTER-1.pdf', 'assets/uploads/syllabus/complete-scheme.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(101, 'Sarvepalli Radhakrishnan Institute of Pharmaceutical Sciences (2023)', 'sarvepalli-radhakrishnan-institute-of-pharmaceutical-science', NULL, 'Diploma in Pharmacy (D.Pharmacy)', 'd-pharmacy-ips-2023', 'Diploma', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Pharmacognosy', 'Modern pharmacy diploma preparing certified healthcare professionals.', 'Registered Pharmacist, Clinical Dispenser', 'assets/uploads/syllabus/1st-year-D.Pharm-syllabus.pdf', 'assets/uploads/syllabus/1st-year-D.Pharm-sch_syll.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(102, 'Sarvepalli Radhakrishnan Institute of Pharmaceutical Sciences (2023)', 'sarvepalli-radhakrishnan-institute-of-pharmaceutical-science', NULL, 'Bachelor of Pharmacy (B.Pharmacy)', 'b-pharmacy-ips-2023', 'UG', '', '4 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Pharmaceutical Chemistry', 'State-of-the-art B.Pharm degree delivering world-class pharmaceutical education.', 'Drug Manufacturing Chemist, Quality Control Associate', 'assets/uploads/syllabus/Syllabus_B_Pharm-semester-I.pdf', 'assets/uploads/syllabus/Schemes_B_Pharm-1.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(103, 'R. N. Kapoor Memorial Institute of Pharmaceutical Sciences (2023)', 'r-n-kapoor-memorial-institute-of-pharmaceutical-sciences-srk-university', NULL, 'Diploma in Pharmacy (D.Pharmacy)', 'd-pharmacy-rn-kapoor-2023', 'Diploma', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Hospital Pharmacy', 'Offering PCI approved D.Pharmacy with advanced laboratory facilities.', 'Registered Pharmacist, Retail Pharmacy Specialist', 'assets/uploads/syllabus/1st-year-D.Pharm-syllabus.pdf', 'assets/uploads/syllabus/1st-year-D.Pharm-sch_syll.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(104, 'R. N. Kapoor Memorial Institute of Pharmaceutical Sciences (2023)', 'r-n-kapoor-memorial-institute-of-pharmaceutical-sciences-srk-university', NULL, 'Bachelor of Pharmacy (B.Pharmacy - RN Kapoor)', 'b-pharmacy-rn-kapoor-2023', 'UG', '', '4 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmacology, Pharmaceutics, Pharmacognosy, Pharmaceutical Chemistry', 'Undergraduate pharmacy degree fostering clinical practice, industrial skills, and drug analysis.', 'Pharmaceutical Executive, Quality Chemist, Medical Representative', 'assets/uploads/syllabus/Syllabus_B_Pharm-semester-I.pdf', 'assets/uploads/syllabus/Schemes_B_Pharm-1.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(105, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing', NULL, 'B.Sc. (Nursing)', 'b-sc-nursing', 'UG', '', '4 1/2 Years', 'As per INC / MPNRC / Regulatory Body Norms', '', 'Medical Surgical Nursing, Child Health, Community Health, Midwifery & Obstetrical Nursing, Mental Health', 'INC recognized B.Sc. Nursing degree with direct clinical bedside rotations in 750+ bed multispecialty hospital.', 'Nursing Officer, ICU Staff Nurse, Clinical Instructor, Military Nursing Service (MNS)', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(106, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing', NULL, 'Post Basic B.Sc. (Nursing)', 'post-basic-b-sc-nursing', 'UG', '', '2 Years', 'As per INC / MPNRC / Regulatory Body Norms', '', 'Advanced Clinical Nursing, Nursing Administration, Community Health Nursing', 'Two-year upgradation degree allowing practicing GNM nurses to achieve Bachelor degree qualification and career promotions.', 'Senior Nursing Officer, Ward Incharge, Nursing Supervisor, Clinical Preceptor', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(107, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing', NULL, 'General Nursing and Midwifery (GNM)', 'gnm-nursing', 'Diploma', '', '3 Years', 'As per INC / MPNRC / Regulatory Body Norms', '', 'Fundamentals of Nursing, Community Health, Midwifery & Gynecological Nursing', 'Three-year diploma preparing compassionate healthcare professionals for emergency departments, trauma centers, and rural health clinics.', 'Staff Nurse, Community Health Worker, Emergency Ward Nurse', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(108, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing', NULL, 'M.Sc. Nursing - 5 Specializations', 'm-sc-nursing', 'PG', '', '2 Years', 'As per INC / MPNRC / Regulatory Body Norms', '', 'Obstetrics & Gynecology, Psychiatric Nursing, Child Health (Pediatric), Community Health, Medical Surgical', 'Postgraduate nursing master program across 5 clinical specialties with advanced simulation labs and clinical research projects.', 'Nursing Superintendent, Clinical Nurse Specialist, Associate Professor, Healthcare Administrator', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(109, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing', NULL, 'Nurse Practitioner in Critical Care (NPCC)', 'npcc-nursing', 'PG', '', '2 Years', 'As per INC / MPNRC / Regulatory Body Norms', '', 'Advanced Critical Care, Invasive Monitoring, Emergency Resuscitation, Pharmacotherapeutics in ICU', 'Prestigious INC recognized postgraduate residency training advanced critical care nurse practitioners for adult and pediatric ICUs.', 'Critical Care Nurse Practitioner, Trauma ICU Specialist, Senior Clinical Fellow', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(110, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing', NULL, 'Doctorate (Ph.D. in Nursing)', 'phd-nursing', 'Doctorate', '', '3-5 Years', 'As per INC / MPNRC / Regulatory Body Norms', '', 'Clinical Nursing Research, Health Systems Leadership, Evidence-Based Nursing Practice', 'Doctoral degree for advanced scholarly research in patient care innovations, nursing ethics, and public health policies.', 'Professor & Head, Principal, Director of Nursing, Healthcare Policy Advisor', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(111, 'RKDF Medical College, Hospital & Research Center (2014)', 'rkdf-medical-college', NULL, 'MBBS (Bachelor of Medicine & Bachelor of Surgery)', 'mbbs-medical', 'UG', '', '4 1/2 Years + 1 Year', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Anatomy, Physiology, Biochemistry, Pathology, Pharmacology, Microbiology, Forensic Medicine, Community Medicine, Ophthalmology, ENT, Medicine, Surgery, OBGY, Pediatrics', 'NMC recognized premier MBBS medical program. Students receive rigorous clinical rotations across outpatient and inpatient wards in the 750+ bed multispecialty hospital.', 'Medical Practitioner, Resident Medical Officer (RMO), Civil Surgeon, Specialist Doctor (post PG)', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(112, 'RKDF Medical College, Hospital & Research Center (2014)', 'rkdf-medical-college', NULL, 'MD / MS (Doctor of Medicine / Master of Surgery) - 18 Specializations', 'md-ms-medical', 'PG', '', '3 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Pathology, Forensic Medicine, Microbiology, Anatomy, Physiology, Community Medicine, Pharmacology, Biochemistry, Ophthalmology, Orthopedics, General Medicine, Obstetrics & Gynecology, General Surgery, Radio-Diagnosis, Pediatrics, Otorhinolaryngology (ENT), Dermatology Venereology & Leprosy, Anaesthesiology, Emergency Medicine', 'Three-year postgraduate residency across 18 medical and surgical branches offering hands-on surgical experience, diagnostic imaging, and intensive care management.', 'Specialist Consultant Physician, General Surgeon, Orthopedic Surgeon, Radiologist, Pediatrician, Medical College Professor', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(113, 'Sarvepalli Radhakrishnan College of Ayurveda, Hospital & Research Center (2021)', 'sarvepalli-radhakrishnan-college-of-ayurveda', NULL, 'BAMS (Bachelor of Ayurvedic Medicine & Surgery)', 'bams-ayurveda', 'UG', '', '4 1/2 Years + 1 Year', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Samhita & Siddhanta, Rachana Sharir, Kriya Sharir, Dravyaguna Vijnana, Rasashastra, Roganidan, Kayachikitsa, Panchakarma, Shalya Tantra, Shalakya Tantra, Prasuti & Stri Roga, Kaumarbhritya', 'NCISM recognized degree with internship integrating traditional Ayurvedic healthcare wisdom with modern diagnostic science, backed by on-campus Ayurvedic hospital.', 'Ayurvedic Medical Officer, Panchakarma Specialist, Clinical Researcher, Wellness Consultant', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(114, 'RKDF Homoeopathic Medical College Hospital & Research Center (2000)', 'rkdf-homoeopathic-medical-college', NULL, 'BHMS (Bachelor of Homoeopathic Medicine & Surgery)', 'bhms-homoeopathy', 'UG', '', '4 1/2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Organon of Medicine, Homoeopathic Pharmacy, Homoeopathic Materia Medica, Repertory, Practice of Medicine, Surgery, Obstetrics & Gynecology', 'NCH recognized undergraduate degree with clinical training in constitutional prescribing, case taking, and homeopathic dispensary management.', 'Homoeopathic Physician, Medical Officer, Clinical Consultant, Dispensary Incharge', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(115, 'RKDF Homoeopathic Medical College Hospital & Research Center (2000)', 'rkdf-homoeopathic-medical-college', NULL, 'MD (Homoeopathy)', 'md-homoeopathy', 'PG', '', '3 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'MD (Materia Medica), MD (Repertory), MD (Organon of Medicine), MD (Homoeopathic Pharmacy), MD (Practice of Medicine), MD (Pediatrics)', 'Three-year specialized postgraduate residency in diverse disciplines fostering advanced clinical research, chronic disease management, and pediatric homeopathy.', 'Senior Homoeopathic Consultant, Research Officer (CCRH), Professor, Medical Superintendent', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(116, 'RKDF Dental College & Research Center (2003)', 'rkdf-dental-college', NULL, 'BDS (Bachelor of Dental Surgery)', 'bds-dental', 'UG', '', '5 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Oral Anatomy, Dental Materials, Oral Pathology, Conservative Dentistry, Oral & Maxillofacial Surgery, Orthodontics, Periodontics, Prosthodontics, Pedodontics', 'DCI approved BDS degree with rotatory clinical internship with state-of-the-art dental chairs, phantom simulation labs, and digital dental radiography.', 'Dental Surgeon, Private Dental Practitioner, Public Health Dentist, Clinical Consultant', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(117, 'RKDF Dental College & Research Center (2003)', 'rkdf-dental-college', NULL, 'MDS (Master of Dental Surgery)', 'mds-dental', 'PG', '', '3 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Conservative Dentistry & Endodontics, Orthodontics & Dentofacial Orthodontics, Pedodontics & Preventive Dentistry, Prosthodontics & Crown & Bridge, Oral Medicine & Radiology, Oral Pathology & Micro Biology, Oral & Maxillofacial Surgery, Periodontology & Implantology', 'Three-year advanced clinical postgraduate dental residency across specialized disciplines including dental implants, maxillofacial trauma surgery, and fixed prosthodontics.', 'Consultant Orthodontist, Oral & Maxillofacial Surgeon, Endodontist, Periodontist, Dental Professor', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(118, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law', NULL, 'BA. LL.B. (Hons.) Integrated', 'ba-ll-b-hons', 'UG', '', '5 Years', 'As per BCI / UGC / Regulatory Body Norms', '', 'Constitutional Law, Criminal Jurisprudence, Corporate Law, Intellectual Property, Moot Court Advocacy', 'BCI approved integrated professional law degree integrating Arts humanities with legal practice, moot court competitions, and High Court / Supreme Court internships.', 'Litigation Advocate, Corporate Counsel, Legal Advisor, Civil Judge Aspirant, Public Prosecutor', 'assets/uploads/syllabus/LLB-SYLLABUS.pdf', 'assets/uploads/syllabus/LLB_MARKS_SCHEME.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(119, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law', NULL, 'LL.B. (Bachelor of Laws)', 'll-b-law', 'UG', '', '3 Years', 'As per BCI / UGC / Regulatory Body Norms', '', 'Constitutional Law, Law of Crimes, Law of Torts, Family Law, Property Law, Civil Procedure Code, Criminal Procedure Code', 'BCI recognized professional law degree for graduates aiming for the legal bar, corporate advisory, and judicial services.', 'Advocate, Legal Consultant, Corporate Legal Officer, Arbitrator', 'assets/uploads/syllabus/LLB-SYLLABUS.pdf', 'assets/uploads/syllabus/LLB_MARKS_SCHEME.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(120, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law', NULL, 'LL.M. (Master of Laws)', 'll-m-law', 'PG', '', '2 Years', 'As per BCI / UGC / Regulatory Body Norms', '', 'Constitution & Public Law, Criminal Law, Business Law, International Law, International Trade Law, Labour Law, Taxation Banking & Insurance Law, Cyber Law, Medico Legal Law', 'Two-year postgraduate law degree offering specialized branches with comparative jurisprudence, cyber law, and medico-legal research.', 'Legal Consultant, Law Professor, Judicial Officer, Corporate Legal Head, Human Rights Advocate', 'assets/uploads/syllabus/FINAL-LLM-SYLLABUS.pdf', 'assets/uploads/syllabus/LLM-MARKS-SCHEME.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(121, 'Faculty of Agriculture', 'faculty-of-agriculture', NULL, 'B.Sc. (Hons.) Agriculture', 'b-sc-hons-agriculture', 'UG', '', '4 Years', 'As per ICAR / UGC / Regulatory Body Norms', '', 'Agronomy, Soil Science, Horticulture, Plant Pathology, Entomology, Agricultural Economics, Genetics & Plant Breeding', 'ICAR aligned undergraduate degree with 50+ acres of experimental farms, polyhouses, weather monitoring stations, and Rural Agricultural Work Experience (RAWE).', 'Agriculture Field Officer (IBPS AFO), Farm Manager, Seed Certification Officer, Soil Chemist, Agripreneur', 'assets/uploads/syllabus/SRKU-AG-SYLLABUS.pdf', 'assets/uploads/syllabus/BSc-AG-1st-8thsem.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(122, 'Faculty of Agriculture', 'faculty-of-agriculture', NULL, 'Diploma in Agriculture', 'diploma-in-agriculture', 'Diploma', '', '2 Years / 3 Years', 'As per ICAR / UGC / Regulatory Body Norms', '', 'Organic Farming, Nursery Management, Crop Protection, Irrigation Technology, Fertilizer Application', 'Practical diploma in agricultural techniques, crop management, farm machinery handling, and modern irrigation methods.', 'Agricultural Assistant, Nursery Supervisor, Fertilizer Field Officer, Farm Technician', 'assets/uploads/syllabus/4-th-sem-DIPLOMA-syllabus.pdf', 'assets/uploads/syllabus/1st-sem-DIPLOMA-MAIL.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(123, 'Faculty of Agriculture', 'faculty-of-agriculture', NULL, 'M.Sc. Agriculture', 'm-sc-agriculture', 'PG', '', '2 Years', 'As per ICAR / UGC / Regulatory Body Norms', '', 'Agriculture Economics, Horticulture, Plant Breeding & Genetics, Agriculture Chemistry & Soil Science, Agriculture Extension, Agriculture Zoology & Entomology, Agronomy', 'Two-year postgraduate research degree across specialized agricultural disciplines with dedicated research plots and soil testing labs.', 'Agricultural Research Scientist, Agronomist, Plant Breeder, Subject Matter Specialist (KVK), Assistant Professor', 'assets/uploads/syllabus/Agriculture-Scheme-and-syllabus-only.pdf', 'assets/uploads/syllabus/Agriculture-Scheme-and-syllabus-only.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(124, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Diploma in Medical Lab Technology (DMLT)', 'dmlt-paramedical', 'Diploma', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Clinical Biochemistry, Hematology, Blood Banking, Medical Microbiology, Clinical Pathology', 'Two-year comprehensive paramedical diploma providing diagnostic specimen testing, automated analyzer handling, and lab quality control.', 'Medical Lab Technician, Phlebotomist, Diagnostic Lab Assistant', 'assets/uploads/syllabus/DMLT-SYLLABUS.pdf', 'assets/uploads/syllabus/DMLT-SYLLABUS.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(125, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Diploma in Optometric Refraction', 'diploma-optometric-refraction', 'Diploma', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Refraction Testing, Optical Dispensing, Contact Lens Fitting, Ocular Anatomy', 'Two-year diploma preparing optometric assistants for vision screening, lens prescription, and ophthalmic equipment handling.', 'Optometric Assistant, Optical Dispensary Incharge, Eye Clinic Technician', 'assets/uploads/syllabus/DIPLOMA-IN-OPTOMETRIC-REFRACTION.pdf', 'assets/uploads/syllabus/DIPLOMA-IN-OPTOMETRIC-REFRACTION.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(126, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Diploma in X-Ray Technician Radiographer', 'diploma-x-ray-radiographer', 'Diploma', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Radiographic Imaging, Radiation Safety, Darkroom Techniques, CT/MRI Support', 'Two-year technical diploma in medical radiography, diagnostic imaging protocols, and radiation protection.', 'X-Ray Technician, Radiographer, Diagnostic Imaging Assistant', 'assets/uploads/syllabus/Diploma-in-X-ray-syllabus.pdf', 'assets/uploads/syllabus/Diploma-in-X-ray-syllabus.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(127, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Diploma in Human Nutrition', 'diploma-human-nutrition', 'Diploma', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Nutritional Biochemistry, Dietary Planning, Community Nutrition, Food Hygiene', 'Two-year diploma in clinical dietetics, therapeutic nutrition, and community health wellness.', 'Nutrition Assistant, Diet Counselor, Healthcare Center Dietitian', 'assets/uploads/syllabus/DIPLOMA-IN-HUMAN-NUTRITION-syllabus.pdf', 'assets/uploads/syllabus/Scheme-for-BACHELOR-OF-HUMAN-HUTRITION.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(128, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Diploma in Dialysis Technician', 'diploma-dialysis-technician', 'Diploma', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Hemodialysis Machine Operation, Dialyzer Reprocessing, Renal Patient Care, Vascular Access Care', 'Two-year specialized diploma for renal care and hemodialysis machine maintenance in super-specialty hospital units.', 'Dialysis Technician, Renal Unit Coordinator, ICU Dialysis Specialist', 'assets/uploads/syllabus/DIPLOMA-IN-DIALYSIS-TECHNICIAN.pdf', 'assets/uploads/syllabus/DIPLOMA-IN-DIALYSIS-TECHNICIAN.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(129, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'D. Pharma (Homoeopathy)', 'd-pharma-homoeopathy', 'Diploma', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Homeopathic Pharmacy, Potentization, Dispensing Techniques, Pharmacognosy', 'Two-year pharmacy diploma in homeopathic drug compounding, dispensing, and storage regulations.', 'Homeopathic Pharmacist, Dispensary Chemist, Herbal Manufacturing Assistant', 'assets/uploads/syllabus/DIPLOMA-IN-HOMOEOPATHIC-PHARMACY.pdf', 'assets/uploads/syllabus/DIPLOMA-IN-HOMOEOPATHIC-PHARMACY.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(130, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'D. Pharma (Ayurvedic)', 'd-pharma-ayurvedic', 'Diploma', '', '2 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Ayurvedic Pharmacology, Rasashastra, Bhaishajya Kalpana, Herbal Processing', 'Two-year diploma in Ayurvedic formulations, herbal drug quality control, and pharmacy operations.', 'Ayurvedic Pharmacist, Herbal Formulations Assistant, Pharmacy Incharge', 'assets/uploads/syllabus/DIPLOMA-IN-AYURVEDIC-PHARMACY.pdf', 'assets/uploads/syllabus/DIPLOMA-IN-AYURVEDIC-PHARMACY.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(131, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Diploma in Blood Transfusion', 'diploma-blood-transfusion', 'Diploma', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Blood Banking, Immunohematology, Component Separation, Donor Screening, Cross-Matching', 'Two-year diploma in blood bank technologies, component separation (platelets, plasma, RBCs), and transfusion safety.', 'Blood Bank Technician, Transfusion Officer, Immunohematology Associate', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(132, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Diploma in Naturopathy', 'diploma-naturopathy', 'Diploma', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Hydrotherapy, Mud Therapy, Fasting Therapy, Chromotherapy, Diet Therapy', 'Two-year diploma covering drugless natural healing methods, detox therapies, and holistic health coaching.', 'Naturopathy Therapist, Wellness Center Incharge, Spa & Detox Consultant', 'assets/uploads/syllabus/DIPLOMA-IN-NATUROPATHY.pdf', 'assets/uploads/syllabus/DIPLOMA-IN-NATUROPATHY.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(133, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Diploma in Ophthalmic Assistant', 'diploma-ophthalmic-assistant', 'Diploma', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Ocular Examination, Perimetry, Tonometry, Surgical Assistance in Eye OT', 'Two-year clinical diploma for ophthalmic hospital support, patient vision assessment, and surgical assistance.', 'Ophthalmic Assistant, Eye OT Assistant, Vision Care Specialist', 'assets/uploads/syllabus/DIPLOMA-IN-OPHTHALMIC-ASSISTANT.pdf', 'assets/uploads/syllabus/DIPLOMA-IN-OPHTHALMIC-ASSISTANT.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(134, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Diploma in Anesthesia Technician', 'diploma-anesthesia-technician', 'Diploma', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Anesthesia Workstation Setup, Gas Delivery Systems, Patient Monitoring, Resuscitation Gear', 'Two-year specialized diploma for operation theatre anesthesia preparation, intraoperative monitoring, and critical recovery care.', 'Anesthesia Technician, OT Anesthesia Assistant, Surgical Support Specialist', 'assets/uploads/syllabus/diploma-in-anesthisia-technician.pdf', 'assets/uploads/syllabus/diploma-in-anesthisia-technician.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(135, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Diploma in Yoga (Paramedical)', 'diploma-yoga-paramedical', 'Diploma', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Asanas, Pranayama, Kriyas, Yogic Anatomy, Stress Management', 'Two-year diploma combining yogic theory and practical therapeutic routines for lifestyle wellness.', 'Yoga Instructor, Wellness Trainer, Rehabilitation Center Coach', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(136, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Bachelor in Medical Lab. Technology (BMLT)', 'bmlt-paramedical', 'UG', '', '3 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Clinical Pathology, Molecular Biology, Clinical Biochemistry, Histotechnology, Medical Microbiology', 'Three-year comprehensive bachelor degree with clinical pathology hospital rotations, hematology profiling, and diagnostic analyzer operations.', 'Senior Medical Lab Technologist, Pathology Lab Incharge, Diagnostic Scientific Officer', 'assets/uploads/syllabus/BMLT-SYLLABUS.pdf', 'assets/uploads/syllabus/BACHELOR-OF-MEDICAL-LAB-TECHNICIAN24-25.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(137, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Bachelor of Physiotherapy (BPT)', 'bpt-physiotherapy', 'UG', '', '4 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Orthopedic Physiotherapy, Neurological Physiotherapy, Cardio-Respiratory Rehab, Sports Physiotherapy, Electrotherapy & Biomechanics', 'Four-year undergraduate physiotherapy degree providing extensive hands-on clinical training in musculoskeletal rehabilitation, sports injuries, and neurological recovery.', 'Consultant Physiotherapist, Sports Rehab Specialist, Rehabilitation Hospital Incharge, Clinic Owner', 'assets/uploads/syllabus/BACHELOR-OF-PHYSIOTHERAPY.pdf', 'assets/uploads/syllabus/BACHELOR-OF-PHYSIOTHERAPY.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(138, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Bachelor of Human Nutrition', 'bachelor-human-nutrition', 'UG', '', '3 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Clinical Dietetics, Nutritional Biochemistry, Food Service Management, Public Health Nutrition', 'Three-year degree in therapeutic meal planning, metabolic nutrition, sports dietetics, and clinical nutrition support.', 'Clinical Dietitian, Nutrition Consultant, Hospital Dietetic Incharge, Food Quality Officer', 'assets/uploads/syllabus/DIPLOMA-IN-HUMAN-NUTRITION-syllabus.pdf', 'assets/uploads/syllabus/Scheme-for-BACHELOR-OF-HUMAN-HUTRITION.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(139, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Master of Physiotherapy (MPT) - 4 Specializations', 'mpt-physiotherapy', 'PG', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'MPT (Obstetrics & Gynecology), MPT (Cardiothoracic), MPT (Orthopedics), MPT (Sports)', 'Two-year postgraduate physical therapy program offering 4 super-specializations with super-specialty hospital rotations and research dissertations.', 'Senior Physiotherapy Consultant, Sports Team Lead Physiotherapist, Orthopedic Rehab Specialist, Professor', 'assets/uploads/syllabus/MPT-for-all-branch.pdf', 'assets/uploads/syllabus/MPT-for-all-branch.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(140, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Master in Medical Lab. Technology (MMLT)', 'mmlt-paramedical', 'PG', '', '2 Years', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'MMLT (Hematology), MMLT (Microbiology), MMLT (Biochemistry), MMLT (Histopathology)', 'Two-year postgraduate research and clinical diagnostics degree across specialized pathology branches.', 'Chief Laboratory Technologist, Research Scientist, Diagnostic Laboratory Director, Academician', 'assets/uploads/syllabus/BMLT-SYLLABUS.pdf', 'assets/uploads/syllabus/BACHELOR-OF-MEDICAL-LAB-TECHNICIAN24-25.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(141, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Certificate Courses (O.T. Technician / Health Inspector)', 'certificate-paramedical', 'Diploma', '', '1 Year', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', '', 'Operation Theatre Management, Sterilization Protocols, Public Health & Sanitation, Vector Control', 'One-year certified skill programs for OT surgical assistance, instrument sterilization, and municipal health inspection.', 'OT Technician, Health Inspector, Sanitary Inspector, Infection Control Assistant', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(142, 'Faculty of Science', 'faculty-of-science', NULL, 'Bachelor of Science (B.Sc.)', 'b-sc-pure-sciences', 'UG', '', '3 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Physics, Chemistry, Mathematics, Botany, Zoology, Computer Science', 'Three-year foundational science degree with state-of-the-art physics, chemistry, and biology research laboratories.', 'Scientific Assistant, Laboratory Chemist, Quality Control Analyst, Research Trainee', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(143, 'Faculty of Science', 'faculty-of-science', NULL, 'Master of Science (M.Sc.)', 'm-sc-pure-sciences', 'PG', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'M.Sc. Chemistry, M.Sc. Physics, M.Sc. Mathematics, M.Sc. Botany, M.Sc. Zoology', 'Two-year postgraduate research degree with thesis dissertations, analytical instrumentation, and advanced lab training.', 'Research Associate, Junior Scientist, College Lecturer, R&D Chemist', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(144, 'Faculty of Arts', 'faculty-of-arts', NULL, 'Bachelor of Arts (B.A.)', 'b-a-liberal-arts', 'UG', '', '3 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'History, Political Science, Sociology, Economics, English Literature, Hindi Literature', 'Comprehensive liberal arts degree with focus on critical thinking, civil services preparation, and public administration.', 'Civil Services Aspirant, Content Specialist, Administrative Officer, NGO Project Associate', 'assets/uploads/syllabus/BA-Scheme-and-Syllabus-2017-onwards.pdf', 'assets/uploads/syllabus/BA-Scheme-and-Syllabus-2017-onwards.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(145, 'Faculty of Arts', 'faculty-of-arts', NULL, 'Master of Arts (M.A.)', 'm-a-humanities', 'PG', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'M.A. History, M.A. Political Science, M.A. Sociology, M.A. Economics, M.A. English', 'Postgraduate research in humanities, social policy, and international relations.', 'Social Researcher, Academician, Policy Analyst, Editor', 'assets/uploads/syllabus/BA-Scheme-and-Syllabus-2017-onwards.pdf', 'assets/uploads/syllabus/BA-Scheme-and-Syllabus-2017-onwards.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(146, 'Faculty of Arts', 'faculty-of-arts', NULL, 'Master of Social Work (MSW)', 'msw-social-work', 'PG', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Community Development, Medical & Psychiatric Social Work, Urban & Rural Welfare, CSR Project Management', 'Two-year professional master degree with field fieldwork, NGO leadership, and CSR project administration.', 'CSR Manager, NGO Project Director, Medical Social Worker, Child Welfare Officer', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(147, 'Faculty of Arts', 'faculty-of-arts', NULL, 'Bachelor of Journalism (B. Journalism)', 'b-journalism', 'UG', '', '3 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Print Journalism, Electronic Media, Digital Reporting, Camera & Editing, Media Ethics', 'Three-year media journalism degree with live newsroom studio training, reporting, and digital journalism.', 'News Reporter, Content Writer, Video Journalist, PR Executive', 'assets/uploads/syllabus/Srk-University-BJMC-syllabus-scheme.pdf', 'assets/uploads/syllabus/Srk-University-BJMC-syllabus-scheme.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55');
INSERT INTO `courses` (`id`, `department`, `dept_slug`, `faculty_id`, `course_name`, `slug`, `level`, `degree_level`, `duration`, `eligibility`, `fees`, `specializations`, `description`, `career_scope`, `syllabus_url`, `scheme_url`, `fees_per_year`, `status`, `created_at`) VALUES
(148, 'Faculty of Arts', 'faculty-of-arts', NULL, 'Master of Journalism (M. Journalism)', 'm-journalism', 'PG', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Investigative Journalism, Broadcast Production, Digital Media Strategy, Media Management', 'Advanced media production, corporate communications, and digital broadcasting.', 'News Anchor, Senior Media Editor, Communications Director, PR Head', 'assets/uploads/syllabus/Srk-University-BJMC-syllabus-scheme.pdf', 'assets/uploads/syllabus/Srk-University-BJMC-syllabus-scheme.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(149, 'Faculty of Arts', 'faculty-of-arts', NULL, 'B.A. (Animation & Design)', 'ba-animation-design', 'UG', '', '3 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', '2D & 3D Animation, VFX, Character Design, Motion Graphics, UI/UX Design, Gaming Art', 'Modern creative design degree with high-end graphic workstations, rendering suites, and animation software training.', '3D Animator, VFX Artist, Game Asset Designer, Motion Graphics Artist, UI/UX Designer', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(150, 'Faculty of Commerce', 'faculty-of-commerce', NULL, 'Bachelor of Commerce (B.Com.)', 'b-com-commerce', 'UG', '', '3 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Financial Accounting, Corporate Law, Business Taxation, Auditing, E-Commerce', 'Core three-year commerce program covering accounting, taxation, auditing, and corporate banking.', 'Accountant, Tax Consultant, Audit Associate, Banking Executive', 'assets/uploads/syllabus/bcom-I-II-III.pdf', 'assets/uploads/syllabus/bcom-I-II-III.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(151, 'Faculty of Commerce', 'faculty-of-commerce', NULL, 'Master of Commerce (M.Com.)', 'm-com-commerce', 'PG', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Advanced Accounting, Financial Management, International Business, Direct & Indirect Taxes', 'Postgraduate commerce education with deep analytical focus on corporate finance, investment analysis, and GST practices.', 'Senior Accountant, Financial Analyst, Tax Advisor, Commerce Faculty', 'assets/uploads/syllabus/bcom-I-II-III.pdf', 'assets/uploads/syllabus/bcom-I-II-III.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(152, 'Faculty of Computer Application', 'faculty-of-computer-application', NULL, 'Diploma in Computer Applications (DCA)', 'dca-computer-application', 'Diploma', '', '1 Year', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Computer Fundamentals, MS Office, DBMS, Internet & Web Basics, C Programming', 'One-year practical diploma in office computing, basic programming, and internet technology.', 'Computer Operator, Data Entry Executive, IT Assistant', 'assets/uploads/syllabus/DcaSyllabus.pdf', 'assets/uploads/syllabus/DcaSyllabus.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(153, 'Faculty of Computer Application', 'faculty-of-computer-application', NULL, 'Post Graduate Diploma in Computer Applications (PGDCA)', 'pgdca-computer-application', 'Diploma', '', '1 Year', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Object Oriented Programming, Database Management Systems (RDBMS), Web Development, Operating Systems', 'One-year postgraduate technical diploma for graduates seeking entry into the software and IT industry.', 'Software Assistant, Database Operator, IT Support Specialist', 'assets/uploads/syllabus/pgdcaSyllabus-Scheme.pdf', 'assets/uploads/syllabus/pgdcaSyllabus-Scheme.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(154, 'Faculty of Computer Application', 'faculty-of-computer-application', NULL, 'Bachelor of Computer Applications (BCA)', 'bca-computer-application', 'UG', '', '3 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Python, Java, Full Stack Web Development, Cloud Computing, Database Architecture, Mobile App Development', 'Three-year professional computing degree covering software coding, web development, cloud computing, and database management.', 'Software Developer, Web Designer, Mobile App Developer, Technical Support Engineer', 'assets/uploads/syllabus/BcaSchemeSyllabus.pdf', 'assets/uploads/syllabus/BcaSchemeSyllabus.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(155, 'Faculty of Library & Information Science', 'faculty-of-library-science', NULL, 'Bachelor of Library & Information Science (B.Lib.)', 'b-lib-library-science', 'UG', '', '1 Year', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Library Classification, Cataloguing, Reference Services, Digital Library Automation', 'One-year professional bachelor degree in modern library management, digital metadata, and indexing.', 'Librarian, Library Assistant, Information Officer, Documentation Incharge', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(156, 'Faculty of Library & Information Science', 'faculty-of-library-science', NULL, 'Master of Library & Information Science (M.Lib.)', 'm-lib-library-science', 'PG', '', '1 Year', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Information Storage & Retrieval, Digital Archiving, Library Software (KohA/DSpace), Research Metrics', 'Advanced postgraduate degree for automated digital libraries, academic repository management, and knowledge systems.', 'Chief Librarian, Knowledge Manager, Information Scientist, University Library Officer', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(157, 'Faculty of Yoga', 'faculty-of-yoga', NULL, 'Bachelor of Science in Yoga (B.Sc. Yoga)', 'b-sc-yoga-science', 'UG', '', '3 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Foundations of Yoga, Patanjali Yoga Sutras, Anatomy & Physiology, Yoga Therapy, Pranayama & Meditation', 'Three-year undergraduate yoga degree in authentic yogic sciences, therapeutic routines, and lifestyle wellness.', 'Yoga Instructor, Wellness Consultant, Corporate Yoga Trainer, Fitness Specialist', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(158, 'Faculty of Yoga', 'faculty-of-yoga', NULL, 'Master of Science in Yoga (M.Sc. Yoga)', 'm-sc-yoga-science', 'PG', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Therapeutic Yoga Applications, Yoga Psychology, Research Methodologies in Yoga, Advanced Asanas & Kriyas', 'Two-year postgraduate research and clinical yoga therapy degree with holistic disease management protocols.', 'Yoga Therapist, Holistic Health Consultant, Yoga Professor, Wellness Center Director', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(159, 'Faculty of Yoga', 'faculty-of-yoga', NULL, 'Post Graduate Diploma in Yoga Therapy (PGDYT)', 'pgdyt-yoga-therapy', 'Diploma', '', '1 Year', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Disease-Specific Yoga Therapy, Stress Management, Naturopathic Diet, Meditation Practices', 'One-year postgraduate diploma for clinical therapists in non-invasive rehabilitation and stress management.', 'Certified Yoga Therapist, Rehabilitation Coach, Wellness Counselor', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(160, 'Faculty of Fashion Technology & Design', 'faculty-of-fashion-technology-design', NULL, 'Diploma in Fashion Technology & Design', 'diploma-fashion-technology-design', 'Diploma', '', '1 Year', 'As per AICTE / Regulatory Body Norms', '', 'Garment Construction, Pattern Making, Fashion Illustration, Textile Science', 'One-year practical diploma in apparel styling, pattern drafting, stitching, and fashion sketching.', 'Fashion Assistant, Boutique Associate, Apparel Merchandiser', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(161, 'Faculty of Fashion Technology & Design', 'faculty-of-fashion-technology-design', NULL, 'Bachelor of Science in Fashion Design (B.Sc. Fashion Design)', 'b-sc-fashion-design', 'UG', '', '3 Years', 'As per AICTE / Regulatory Body Norms', '', 'Apparel Design, Textile Chemistry, Fashion CAD, Surface Ornamentation, Fashion Merchandising, Portfolio Design', 'Three-year undergraduate fashion degree with drafting workshops, CAD labs, fashion runway shows, and textile mill internships.', 'Fashion Designer, Textile Stylist, Visual Merchandiser, Costume Designer, Fashion Entrepreneur', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(162, 'Faculty of Fashion Technology & Design', 'faculty-of-fashion-technology-design', NULL, 'Master of Science in Fashion Design (M.Sc. Fashion Design)', 'm-sc-fashion-design', 'PG', '', '2 Years', 'As per AICTE / Regulatory Body Norms', '', 'Haute Couture, Sustainable Fashion, Luxury Brand Management, Advanced CAD Illustration, Global Trend Forecasting', 'Two-year postgraduate fashion design degree fostering luxury brand creation, sustainable fashion, and creative directorship.', 'Creative Director, Senior Fashion Stylist, Luxury Brand Manager, Fashion Trend Forecaster', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(163, 'RKDF Institute of Science and Technology (1995)', 'rkdf-institute-of-science-and-technology', NULL, 'B.Tech. (Lateral Entry)', 'b-tech-lateral-entry', 'UG', '', '3 Years', 'As per AICTE / Regulatory Body Norms', '', 'Civil, CSE, EE, EEE, ECE, AI & ML, Mechanical Engineering', 'Direct lateral entry into 2nd year (3rd semester) of B.Tech program for polytechnic diploma and B.Sc. graduates.', 'Software Engineer, Systems Engineer, Design Engineer', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(164, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy', NULL, 'B. Pharmacy Lateral Entry (Direct 2nd Year)', 'b-pharmacy-lateral-entry', 'UG', '', '3 Years', 'As per PCI / AICTE / Regulatory Body Norms', '', 'Pharmaceutics, Pharmacology, Medicinal Chemistry, Pharmacognosy', 'Direct admission into 2nd year (3rd semester) of Bachelor of Pharmacy for registered D.Pharm candidates.', 'Formulation Scientist, Drug Inspector, Quality Chemist', 'assets/uploads/syllabus/Syllabus_B_Pharm-semester-I.pdf', 'assets/uploads/syllabus/Schemes_B_Pharm-1.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(165, 'RKDF Institute of Science and Technology (1995)', 'rkdf-institute-of-science-and-technology', NULL, 'Diploma in Engineering (Polytechnic - Lateral Entry)', 'polytechnic-lateral-entry', 'Diploma', '', '2 Years', 'As per AICTE / Regulatory Body Norms', '', 'Civil, Mechanical, Electrical, Electronics & Instrumentation', 'Direct lateral entry into 2nd year of Polytechnic Diploma for 10+2 PCM or ITI passed students.', 'Junior Engineer, Plant Supervisor, Site Technician', 'assets/uploads/syllabus/DIPLOMA-ALL-BRANCH-I-II-SEM-SYLLABUS-REG2019-BATCH-ONWARDS.pdf', 'assets/uploads/syllabus/DIPLOMA-ALL-BRANCH-I-II-SEM-SCHEME-REG2019-BATCH-ONWARDS.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(166, 'Faculty of Agriculture', 'faculty-of-agriculture', NULL, 'Diploma in Agriculture Lateral Entry', 'diploma-agriculture-lateral-entry', 'Diploma', '', '2 Years', 'As per ICAR / UGC / Regulatory Body Norms', '', 'Crop Production, Horticulture, Soil Health Management', 'Direct 2nd year lateral admission for 10+2 Agriculture students into Agriculture Polytechnic.', 'Agricultural Field Assistant, Nursery Technician', 'assets/uploads/syllabus/4-th-sem-DIPLOMA-syllabus.pdf', 'assets/uploads/syllabus/1st-sem-DIPLOMA-MAIL.pdf', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(167, 'Faculty of Arts', 'faculty-of-arts', NULL, 'NSS & NCC Courses (National Service Scheme & National Cadet Corps)', 'nss-ncc-courses', 'Diploma', '', '2 Years', 'As per AICTE / UGC / Regulatory Body Norms', '', 'Discipline & Leadership, Drill & Parade, Social Outreach & Disaster Relief, Annual Training Camps', 'Authorized NSS and NCC wings providing leadership training, national integration camps, social service projects, and B/C certificate examinations giving edge in Defence and Police recruitment.', 'Defence Services (Army/Navy/Air Force), Paramilitary Forces, Police Services, Civil Administration', '#', '#', 'As per university norms', 'active', '2026-08-22 16:29:55'),
(168, 'RKDF Medical College, Hospital & Research Center (2014)', 'rkdf-medical-college-hospital-research-center-2014', NULL, 'M.Sc. (Medical) - Anatomy, Physiology, Biochemistry, Pharmacology, Microbiology', 'm-sc-medical', 'Postgraduate', 'PG', '3 Years', 'As per PCI / AICTE / Regulatory Body Norms', NULL, 'Medical Anatomy, Medical Physiology, Medical Biochemistry, Medical Pharmacology, Medical Microbiology', 'M.Sc. Medical is an advanced postgraduate programme designed for healthcare professionals, clinical scientists, and educators in foundational medical sciences.', NULL, '#', '#', 'As per Regulatory Norms', 'active', '2026-08-24 12:29:29'),
(169, 'Department of Management', 'department-of-management', NULL, 'Bachelor of Business Administration (BBA)', 'bachelor-of-business-administration-bba', 'Undergraduate', 'UG', '3 Years', 'As per AICTE / UGC / Regulatory Body Norms', NULL, 'Marketing, Human Resource, Finance, International Business, Banking & Insurance', 'BBA programme delivers comprehensive managerial competencies, financial acumen, strategic marketing, and corporate operational skills.', NULL, 'assets/uploads/syllabus/bba-syllabus-scheme.pdf', 'assets/uploads/syllabus/bba-syllabus-scheme.pdf', 'As per Regulatory Norms', 'active', '2026-08-24 12:29:29'),
(170, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Certificate in O.T. Technician', 'certificate-in-ot-technician', 'Certificate', 'Diploma / Certificate', '1 Year', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', NULL, 'Operation Theatre Management, Surgical Instrumentation, Sterilization & Aseptic Techniques', 'Certificate in Operation Theatre Technology trains candidates in surgical room preparation, equipment maintenance, and assistance to surgeons.', NULL, 'assets/uploads/syllabus/Certificate-in-O.T.Technician-Scheme-Syllabus.pdf', 'assets/uploads/syllabus/Certificate-in-O.T.Technician-Scheme-Syllabus.pdf', 'As per Regulatory Norms', 'active', '2026-08-24 12:29:29'),
(171, 'Department of Paramedical Sciences', 'department-of-paramedical-sciences', NULL, 'Certificate in Health Inspector (Sanitary Inspector)', 'certificate-in-health-inspector', 'Certificate', 'Diploma / Certificate', '1 Year', 'As per NMC / DCI / NCISM / NCH / Regulatory Norms', NULL, 'Public Health, Sanitation, Epidemic Prevention, Community Health Surveillance', 'Certificate in Health Inspector qualifies students for community health monitoring, public hygiene maintenance, and municipal surveillance.', NULL, 'assets/uploads/syllabus/Certificate-in-Health-Inspector-Scheme-Syllabus.pdf', 'assets/uploads/syllabus/Certificate-in-Health-Inspector-Scheme-Syllabus.pdf', 'As per Regulatory Norms', 'active', '2026-08-24 12:29:29');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'General',
  `slug` varchar(191) NOT NULL,
  `icon` varchar(100) DEFAULT 'fas fa-graduation-cap',
  `image` varchar(255) DEFAULT NULL,
  `banner_img` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `dean_name` varchar(150) DEFAULT NULL,
  `dean_designation` varchar(150) DEFAULT 'Dean & Principal',
  `dean_photo` varchar(255) DEFAULT NULL,
  `dean_message` text DEFAULT NULL,
  `contact_no` varchar(100) DEFAULT '0755-4700983, 7024144981',
  `approvals` varchar(255) DEFAULT 'UGC',
  `established_year` varchar(10) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `category`, `slug`, `icon`, `image`, `banner_img`, `description`, `dean_name`, `dean_designation`, `dean_photo`, `dean_message`, `contact_no`, `approvals`, `established_year`, `status`) VALUES
(47, 'RKDF Institute of Science and Technology (1995)', 'Engineering & Technology', 'rkdf-institute-of-science-and-technology', 'fas fa-microchip', 'assets/uploads/constituent-units/rkdf-institute-of-science-and-technology.webp', 'assets/uploads/constituent-units/rkdf-institute-of-science-and-technology.webp', 'RKDF Institute of Science and Technology is a pioneer technical institution offering AICTE approved Diploma Polytechnic, B.Tech in multiple disciplines, M.Tech/M.E. in multiple specialized fields, MCA, MBA, and Ph.D. programs with cutting-edge computing, AI/ML, IoT, robotics, and advanced mechanical laboratories.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'AICTE, UGC', '1995', 'active'),
(48, 'RKDF IST-MCA (1999)', 'Computer Applications & IT', 'rkdf-institute-science-technology-mca', 'fas fa-laptop-code', 'assets/uploads/constituent-units/rkdf-institute-science-technology-mca.webp', 'assets/uploads/constituent-units/rkdf-institute-science-technology-mca.webp', 'RKDF IST-MCA is dedicated to advanced postgraduate computing education, enterprise software development, cloud infrastructure, AI systems, and cyber security.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'AICTE, UGC', '1999', 'active'),
(49, 'RKDF Institute of Management (2003)', 'Management & Commerce', 'rkdf-institute-of-management', 'fas fa-chart-line', 'assets/uploads/constituent-units/rkdf-institute-of-management.webp', 'assets/uploads/constituent-units/rkdf-institute-of-management.webp', 'RKDF Institute of Management is a premier business school delivering Full-Time MBA with diverse super-specializations including Marketing, Finance, HR, Supply Chain, Hospital Administration, Retail, and Event Management, along with doctoral Ph.D. research.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'AICTE, UGC', '2003', 'active'),
(50, 'RKDF Institute of Business Management (2006)', 'Management & Commerce', 'rkdf-institute-of-business-management', 'fas fa-briefcase', 'assets/uploads/constituent-units/rkdf-institute-of-business-management.webp', 'assets/uploads/constituent-units/rkdf-institute-of-business-management.webp', 'RKDF Institute of Business Management delivers postgraduate MBA programs focused on leadership development, business analytics, corporate consulting, and entrepreneurship.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'AICTE, UGC', '2006', 'active'),
(51, 'Department of Management', 'Management & Commerce', 'department-of-management', 'fas fa-dolly-flatbed', 'assets/uploads/constituent-units/department-of-management.webp', 'assets/uploads/constituent-units/department-of-management.webp', 'Department of Management specializes in advanced Master of Business Administration programs including MBA in Logistics & Supply Chain Management with global industry partnerships.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'AICTE, UGC', '2015', 'active'),
(52, 'RKDF College of Pharmacy (1995)', 'Pharmacy', 'rkdf-college-of-pharmacy', 'fas fa-pills', 'assets/uploads/constituent-units/rkdf-college-of-pharmacy.webp', 'assets/uploads/constituent-units/rkdf-college-of-pharmacy.webp', 'RKDF College of Pharmacy is a premier PCI approved institution offering D.Pharmacy, B.Pharmacy, M.Pharmacy across multiple disciplines (Pharmaceutics, Pharmacology, Pharmacognosy, Pharmaceutical Chemistry, Industrial Pharmacy), and doctoral Ph.D. research.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'PCI, AICTE, UGC', '1995', 'active'),
(53, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'Pharmacy', 'sarvepalli-radhakrishnan-college-of-pharmacy', 'fas fa-prescription-bottle-alt', 'assets/uploads/constituent-units/sarvepalli-radhakrishnan-college-of-pharmacy.webp', 'assets/uploads/constituent-units/sarvepalli-radhakrishnan-college-of-pharmacy.webp', 'Sarvepalli Radhakrishnan College of Pharmacy is dedicated to high-standard pharmaceutical education, offering D.Pharmacy, B.Pharmacy, and M.Pharmacy in Pharmaceutics, Pharmacology, Pharmacognosy, Pharmaceutical Analysis, and Pharmaceutical Chemistry.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'PCI, UGC', '2018', 'active'),
(54, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'Pharmacy', 'dr-apj-abdul-kalam-college-of-pharmacy-srk-bhopal', 'fas fa-flask', 'assets/uploads/constituent-units/dr-apj-abdul-kalam-college-of-pharmacy-srk-bhopal.webp', 'assets/uploads/constituent-units/dr-apj-abdul-kalam-college-of-pharmacy-srk-bhopal.webp', 'Dr. APJ Abdul Kalam College of Pharmacy provides PCI recognized D.Pharmacy, B.Pharmacy, and M.Pharmacy in Pharmaceutics, Pharmacology, Pharmacognosy, Pharmaceutical Chemistry, and Drug Regulatory Affairs (DRA).', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'PCI, UGC', '2018', 'active'),
(55, 'Sri Sai College of Pharmacy (2019)', 'Pharmacy', 'sri-sai-college-of-pharmacy-srk-bhopal', 'fas fa-capsules', 'assets/uploads/constituent-units/sri-sai-college-of-pharmacy-srk-bhopal.webp', 'assets/uploads/constituent-units/sri-sai-college-of-pharmacy-srk-bhopal.webp', 'Sri Sai College of Pharmacy offers PCI approved D.Pharmacy, B.Pharmacy, and M.Pharmacy in Pharmaceutics, Pharmacology, Quality Assurance, Pharmaceutical Chemistry, and Pharmacognosy.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'PCI, UGC', '2019', 'active'),
(56, 'Sarvepalli Radhakrishnan Institute of Pharmaceutical Sciences (2023)', 'Pharmacy', 'sarvepalli-radhakrishnan-institute-of-pharmaceutical-science', 'fas fa-tablets', 'assets/uploads/constituent-units/sarvepalli-radhakrishnan-institute-of-pharmaceutical-science.webp', 'assets/uploads/constituent-units/sarvepalli-radhakrishnan-institute-of-pharmaceutical-science.webp', 'Sarvepalli Radhakrishnan Institute of Pharmaceutical Sciences offers modern D.Pharmacy and B.Pharmacy degree programs equipped with sophisticated analytical instruments and formulation labs.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'PCI, UGC', '2023', 'active'),
(57, 'R. N. Kapoor Memorial Institute of Pharmaceutical Sciences (2023)', 'Pharmacy', 'r-n-kapoor-memorial-institute-of-pharmaceutical-sciences-srk-university', 'fas fa-mortar-pestle', 'assets/uploads/constituent-units/r-n-kapoor-memorial-institute-of-pharmaceutical-sciences-srk-university.webp', 'assets/uploads/constituent-units/r-n-kapoor-memorial-institute-of-pharmaceutical-sciences-srk-university.webp', 'R. N. Kapoor Memorial Institute of Pharmaceutical Sciences delivers top-tier D.Pharmacy and B.Pharmacy programs fostering clinical and community pharmacy practice.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'PCI, UGC', '2023', 'active'),
(58, 'RKDF College of Nursing (2003)', 'Nursing & Healthcare', 'rkdf-college-of-nursing', 'fas fa-user-nurse', 'assets/uploads/constituent-units/rkdf-college-of-nursing.webp', 'assets/uploads/constituent-units/rkdf-college-of-nursing.webp', 'RKDF College of Nursing is an INC and MPNRC recognized center offering B.Sc Nursing, Post Basic B.Sc Nursing, GNM, M.Sc Nursing across diverse clinical specialties, NPCC (Nurse Practitioner in Critical Care), and Ph.D. with comprehensive training in on-campus 750+ bed hospital.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'INC, MPNRC, UGC', '2003', 'active'),
(59, 'RKDF Medical College, Hospital & Research Center (2014)', 'Medical & Dental Sciences', 'rkdf-medical-college', 'fas fa-hospital', 'assets/uploads/constituent-units/rkdf-medical-college.webp', 'assets/uploads/constituent-units/rkdf-medical-college.webp', 'RKDF Medical College, Hospital & Research Center is recognized by NMC and offers MBBS and MD/MS in clinical & non-clinical specializations with a 750+ bed multispecialty teaching hospital on campus.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'NMC, UGC', '2014', 'active'),
(60, 'Sarvepalli Radhakrishnan College of Ayurveda, Hospital & Research Center (2021)', 'Ayush & Medical', 'sarvepalli-radhakrishnan-college-of-ayurveda', 'fas fa-leaf', 'assets/uploads/constituent-units/sarvepalli-radhakrishnan-college-of-ayurveda.webp', 'assets/uploads/constituent-units/sarvepalli-radhakrishnan-college-of-ayurveda.webp', 'Sarvepalli Radhakrishnan College of Ayurveda offers NCISM approved BAMS (Bachelor of Ayurvedic Medicine and Surgery) backed by an Ayurvedic teaching hospital, herbal botanical garden, and Panchakarma therapy suites.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'NCISM, Ayush, UGC', '2021', 'active'),
(61, 'RKDF Homoeopathic Medical College Hospital & Research Center (2000)', 'Ayush & Medical', 'rkdf-homoeopathic-medical-college', 'fas fa-notes-medical', 'assets/uploads/constituent-units/rkdf-homoeopathic-medical-college.webp', 'assets/uploads/constituent-units/rkdf-homoeopathic-medical-college.webp', 'RKDF Homoeopathic Medical College Hospital & Research Center is recognized by NCH and offers BHMS and MD (Homoeopathy) in specialized tracks with full clinical hospital exposure.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'NCH, Ayush, UGC', '2000', 'active'),
(62, 'RKDF Dental College & Research Center (2003)', 'Medical & Dental Sciences', 'rkdf-dental-college', 'fas fa-tooth', 'assets/uploads/constituent-units/rkdf-dental-college.webp', 'assets/uploads/constituent-units/rkdf-dental-college.webp', 'RKDF Dental College & Research Center is a DCI approved premier dental institution offering BDS and MDS across clinical disciplines with high-tech dental operatory units and oral surgery suites.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'DCI, UGC', '2003', 'active'),
(63, 'Sarvepalli Radhakrishnan College of Law (2019)', 'Law & Jurisprudence', 'sarvepalli-radhakrishnan-college-of-law', 'fas fa-balance-scale', 'assets/uploads/constituent-units/sarvepalli-radhakrishnan-college-of-law.webp', 'assets/uploads/constituent-units/sarvepalli-radhakrishnan-college-of-law.webp', 'Sarvepalli Radhakrishnan College of Law is approved by the Bar Council of India (BCI) and delivers BA. LL.B. (Hons.), LL.B., and LL.M. across specialized streams with moot court competitions and legal aid clinics.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'BCI, UGC', '2019', 'active'),
(64, 'Faculty of Agriculture', 'Agriculture & Life Sciences', 'faculty-of-agriculture', 'fas fa-seedling', 'assets/uploads/constituent-units/faculty-of-agriculture.webp', 'assets/uploads/constituent-units/faculty-of-agriculture.webp', 'Faculty of Agriculture offers ICAR-aligned B.Sc. (Hons.) Agriculture, Diploma in Agriculture, and M.Sc. Agriculture across multiple disciplines with 50+ acres of experimental crop fields, polyhouses, and soil testing labs.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'ICAR, UGC', '2016', 'active'),
(65, 'Department of Paramedical Sciences', 'Paramedical & Healthcare', 'department-of-paramedical-sciences', 'fas fa-heartbeat', 'assets/uploads/constituent-units/department-of-paramedical-sciences.webp', 'assets/uploads/constituent-units/department-of-paramedical-sciences.webp', 'Department of Paramedical Sciences provides specialized Diploma programs, UG degrees (BMLT, BPT, B.Sc Human Nutrition), PG degrees (MPT in specialized tracks, MMLT in specialized tracks), and Certificate courses with extensive practical clinical rotations in teaching hospital.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'MP Paramedical Council, UGC', '2015', 'active'),
(66, 'Faculty of Science', 'Allied Sciences', 'faculty-of-science', 'fas fa-atom', 'assets/uploads/constituent-units/faculty-of-science.webp', 'assets/uploads/constituent-units/faculty-of-science.webp', 'Faculty of Science offers comprehensive undergraduate B.Sc. and postgraduate M.Sc. programs in Physics, Chemistry, Mathematics, Botany, and Zoology with modern research laboratories.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'UGC', '2015', 'active'),
(67, 'Faculty of Arts', 'Allied Sciences', 'faculty-of-arts', 'fas fa-palette', 'assets/uploads/constituent-units/faculty-of-arts.webp', 'assets/uploads/constituent-units/faculty-of-arts.webp', 'Faculty of Arts delivers B.A., M.A., MSW (Master of Social Work), B. Journalism, M. Journalism, and B.A. in Animation & Design with dynamic media studios and community projects.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'UGC', '2015', 'active'),
(68, 'Faculty of Commerce', 'Allied Sciences', 'faculty-of-commerce', 'fas fa-calculator', 'assets/uploads/constituent-units/faculty-of-commerce.webp', 'assets/uploads/constituent-units/faculty-of-commerce.webp', 'Faculty of Commerce offers B.Com. and M.Com. degrees focusing on corporate accounting, taxation, auditing, and financial analytics.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'UGC', '2015', 'active'),
(69, 'Faculty of Computer Application', 'Computer Applications & IT', 'faculty-of-computer-application', 'fas fa-code', 'assets/uploads/constituent-units/faculty-of-computer-application.webp', 'assets/uploads/constituent-units/faculty-of-computer-application.webp', 'Faculty of Computer Application delivers DCA, PGDCA, and BCA degrees with hands-on coding in modern computing labs.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'UGC', '2015', 'active'),
(70, 'Faculty of Library & Information Science', 'Allied Sciences', 'faculty-of-library-science', 'fas fa-book-reader', 'assets/uploads/constituent-units/faculty-of-library-science.webp', 'assets/uploads/constituent-units/faculty-of-library-science.webp', 'Faculty of Library & Information Science offers professional B.Lib. and M.Lib. degrees with modern digital archiving and metadata systems.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'UGC', '2015', 'active'),
(71, 'Faculty of Yoga', 'Allied Sciences', 'faculty-of-yoga', 'fas fa-spa', 'assets/uploads/constituent-units/faculty-of-yoga.webp', 'assets/uploads/constituent-units/faculty-of-yoga.webp', 'Faculty of Yoga delivers holistic education through B.Sc. Yoga, M.Sc. Yoga, and PGDYT (Post Graduate Diploma in Yoga Therapy) programs.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'UGC, Ayush', '2015', 'active'),
(72, 'Faculty of Fashion Technology & Design', 'Allied Sciences', 'faculty-of-fashion-technology-design', 'fas fa-tshirt', 'assets/uploads/constituent-units/faculty-of-fashion-technology-design.webp', 'assets/uploads/constituent-units/faculty-of-fashion-technology-design.webp', 'Faculty of Fashion Technology & Design delivers Diploma, B.Sc., and M.Sc. in Fashion Design with state-of-the-art apparel drafting, garment manufacturing, and textile studios.', NULL, 'Dean & Principal', NULL, NULL, '0755-4700983, 7024144981', 'UGC', '2016', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `father_name` varchar(150) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `course` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `source` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `name`, `father_name`, `email`, `phone`, `course`, `city`, `state`, `source`, `message`, `status`, `created_at`) VALUES
(1, 'Megha RKDF', NULL, 'megha.rkdf2026@gmail.com', '7024144981', 'B.Tech. (Bachelor of Technology)', NULL, NULL, 'Course Detail Page - B.Tech. (Bachelor of Technology)', '[Course Detail Page - B.Tech. (Bachelor of Technology)]\nTESTING admission seat counseling inquiry for lateral entry', 'New', '2026-08-22 11:37:37'),
(2, 'Amit Sharma', NULL, 'amit.sharma@example.com', '9876543210', 'B.Tech in Computer Science & Engineering', NULL, NULL, 'Department Page - RKDF Institute of Science and Technology (1995)', '[Department Page - RKDF Institute of Science and Technology (1995)]\nQuery about CSE admission eligibility', 'New', '2026-08-22 11:37:37'),
(3, 'Megha RKDF', NULL, 'megha.rkdf2026@gmail.com', '12435678890909', 'Bachelor in Medical Lab. Technology (BMLT)', NULL, NULL, 'Department Page - Department of Paramedical Sciences', '[Department Page - Department of Paramedical Sciences]\nSeat Inquiry / Direct Admission Application', 'New', '2026-08-24 09:21:30'),
(6, 'Megha RKDF', 'test', 'megha.rkdf2026@gmail.com', '1213344354', 'Bachelor of Library & Information Science (B.Lib.)', 'bhopal', 'madhya pradesh', 'Quick Sticky Admission Popup', '[Quick Sticky Admission Popup]\ntest', 'New', '2026-08-24 09:33:24'),
(7, 'Megha RKDF', 'test', 'megha.rkdf2026@gmail.com', '5345435656', 'fghfgjh', NULL, NULL, 'Student Grievance Redressal Portal', '[Student Grievance - Ragging / Harassment]\nEnrollment: 123343456576788\nInstitute: test\nCourse: fghfgjh\nYear/Sem: hjkj\n\nDetails:\nghkfyjgyuikhjkhjkjhkjhkjkhj', 'New', '2026-08-24 09:36:17'),
(9, 'Megha RKDF', 'test', 'megha.rkdf2026@gmail.com', '5345435656', 'fghfgjh', NULL, NULL, 'Student Grievance Redressal Portal', '[Student Grievance - Ragging / Harassment]\nEnrollment: 123343456576788\nInstitute: test\nCourse: fghfgjh\nYear/Sem: hjkj\n\nDetails:\nghkfyjgyuikhjkhjkjhkjhkjkhj', 'New', '2026-08-24 09:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `icon` varchar(50) DEFAULT 'fa-university',
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `slug`, `icon`, `description`, `image`, `status`, `created_at`) VALUES
(1, 'Faculty of Engineering & Technology', 'engineering', 'fa-cogs', 'Offers cutting-edge programs in Computer Science, AI, Mechanical, Civil, Electrical & Electronics Engineering.', NULL, 1, '2026-08-07 11:44:15'),
(2, 'Faculty of Pharmacy', 'pharmacy', 'fa-pills', 'PCI-approved D.Pharm, B.Pharm, and M.Pharm programs with modern pharmaceutical labs.', NULL, 1, '2026-08-07 11:44:15'),
(3, 'Faculty of Management Studies', 'management', 'fa-chart-line', 'Industry-focused BBA, MBA, and Ph.D. programs with real-world case studies & corporate mentorship.', NULL, 1, '2026-08-07 11:44:15'),
(4, 'Faculty of Agricultural Sciences', 'agriculture', 'fa-seedling', 'ICAR-aligned B.Sc. (Hons) Agriculture with experimental research farms.', NULL, 1, '2026-08-07 11:44:15'),
(5, 'Faculty of Nursing & Paramedical', 'nursing', 'fa-user-nurse', 'INC-recognized B.Sc Nursing, GNM, and Diploma programs backed by teaching hospital facilities.', NULL, 1, '2026-08-07 11:44:15'),
(6, 'Faculty of Science & Humanities', 'science', 'fa-flask', 'Comprehensive Undergraduate & Postgraduate degrees in Physics, Chemistry, Mathematics, Biotech & Arts.', NULL, 1, '2026-08-07 11:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `dept_slug` varchar(191) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(150) NOT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `department_name`, `dept_slug`, `name`, `designation`, `qualification`, `experience`, `status`, `created_at`) VALUES
(1, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Rakesh Kumar Pandey', 'Principal / Professor', 'MD Ayurved Samhitta & Siddhanta', '15 Years', 'active', '2026-08-24 06:10:02'),
(2, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Ashwini Suhas Utpat', 'Reader', 'MD Ayurved Samhitta & Siddhanta', '7 Years', 'active', '2026-08-24 06:10:02'),
(3, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Aarti Rai', 'Lecturer', 'MD Samhitta & Siddhanta', '2 Years', 'active', '2026-08-24 06:10:02'),
(4, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Ms. Priyanka Malviya', 'Lecturer', 'M.Sc Bio Statics', '4 Years', 'active', '2026-08-24 06:10:02'),
(5, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Chetan Sharma', 'Lecturer', 'MD Ayurved Samhitta & Siddhanta', '1 Years', 'active', '2026-08-24 06:10:02'),
(6, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Jitendra Dhanware', 'Lecturer', 'Ph.D Sanskrit', '3 Years', 'active', '2026-08-24 06:10:02'),
(7, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Mrs Yogita Naidu', 'Lecturer', 'M.Sc Yoga', '3 Years', 'active', '2026-08-24 06:10:02'),
(8, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Mrunalini Shivankar', 'Professor', 'MD Shalya Tantra', '14 Years', 'active', '2026-08-24 06:10:02'),
(9, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Priyanka Selke', 'Professor', 'MD Rachana Sharir', '6 Years', 'active', '2026-08-24 06:10:02'),
(10, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Reetesh Rathore', 'Lecturer', 'MD Rachana Sharir', '3.5 Years', 'active', '2026-08-24 06:10:02'),
(11, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Devdatta Trilokchandra Khodraged', 'Professor', 'MD Samhitta & Siddhanta', '14 Years', 'active', '2026-08-24 06:10:02'),
(12, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Anand Sharadrao Umale', 'Reader', 'MD Kriya Sharir', '8 Years', 'active', '2026-08-24 06:10:02'),
(13, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Sumit Mukundrao', 'Lecturer', 'MD Kriya Sharir', '3 Years', 'active', '2026-08-24 06:10:02'),
(14, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Urmila Mourya', 'Lecturer', 'MD Kriya Sharir', '2 Years', 'active', '2026-08-24 06:10:02'),
(15, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Pratibha Lokhade', 'Lecturer', 'MD Kriya Sharir', '1 Month', 'active', '2026-08-24 06:10:02'),
(16, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Vikrant Patil', 'Professor', 'MD Dravyaguna', '12 Years', 'active', '2026-08-24 06:10:02'),
(17, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Sujeet Ranjane', 'Reader', 'MD Dravyaguna', '7 Years', 'active', '2026-08-24 06:10:02'),
(18, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Deepti Goswami', 'Lecturer', 'MD Dravyaguna', '2 Years', 'active', '2026-08-24 06:10:02'),
(19, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Swati Bonde', 'Lecturer', 'MD Dravyaguna', '1 Month', 'active', '2026-08-24 06:10:02'),
(20, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Seema Badhe', 'Professor', 'MD Rashashatra & Bhaisjya Kalpana', '11 Years', 'active', '2026-08-24 06:10:02'),
(21, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Remya R G', 'Reader', 'MD Rashashatra & Bhaisjya Kalpana', '7 Years', 'active', '2026-08-24 06:10:02'),
(22, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Deepak Govardhandas Chand', 'Professor', 'MD Rog Nidan', '13 Years', 'active', '2026-08-24 06:10:02'),
(23, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Pooja Soni', 'Lecturer', 'MD Rog Nidan', '1 Years', 'active', '2026-08-24 06:10:02'),
(24, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Tripathi Nisha Omprakash', 'Lecturer', 'MD Rog Nidan', '2 Years', 'active', '2026-08-24 06:10:02'),
(25, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Yogeshwar Ashok Tikle', 'Professor', 'MD Swasthvirtta', '12 Years', 'active', '2026-08-24 06:10:02'),
(26, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Girish Govindrao Shirke', 'Professor', 'MD Swasthvirtta', '11 Years', 'active', '2026-08-24 06:10:02'),
(27, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Gayatri Keshav Halmare', 'Lecturer', 'MD Swasthvirtta', '3 Years', 'active', '2026-08-24 06:10:02'),
(28, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr. Namita Patel', 'Lecturer', 'MD Swasthvirtta', '2 Years', 'active', '2026-08-24 06:10:02'),
(29, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Rajesh Subhas Harode', 'Professor', 'MD Rashashatra & Bhaisjya Kalpana', '11 Years', 'active', '2026-08-24 06:10:02'),
(30, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Bhavana Anant Rao Atram', 'Reader', 'MD Kaya Chikitsa', '9 Years', 'active', '2026-08-24 06:10:02'),
(31, 'Sarvepalli Radhakrishnan College of Ayurveda Hospital & Research Centre', 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-centre', 'Dr Priti Wamanrao', 'Lecturer', 'MD Agad Tantra', '4.5 Years', 'active', '2026-08-24 06:10:02'),
(32, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. M.C. PRASANT', 'Dean', 'MDS', '23 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(33, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. KAPIL LAHOTI', 'Professor', 'MDS', '13 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(34, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. ANJALI PAWAN KUMAR', 'Reader', 'MDS', '7 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(35, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PRASHANT B TAMGADGE', 'Reader', 'MDS', '6 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(36, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. RICHA PATHAK', 'Reader', 'MDS', '5 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(37, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. MAHANTESH SHIRGANVI', 'Reader', 'MDS', '7 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(38, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. EKLAVYA SHARMA', 'Reader', 'MDS', '7 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(39, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. ABHINAV DUBEY', 'Reader', 'MDS', '8 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(40, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PUJA SANKLA', 'Lecturer', 'MDS', '2 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(41, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. AMIT AHIRWAL', 'Lecturer', 'MDS', '1 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(42, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SARDAR SINGH YADAV', 'Lecturer', 'MDS', '2 Years 1 Months', 'active', '2026-08-24 06:10:02'),
(43, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. D. SRILAKSHMI', 'Lecturer', 'MDS', '8 Months 11 Days', 'active', '2026-08-24 06:10:02'),
(44, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. AMIT KUMAR', 'Lecturer', 'MDS', '5 Months 4 Days', 'active', '2026-08-24 06:10:02'),
(45, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. RAHUL TIWARI', 'Lecturer', 'MDS', '1 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(46, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SANJEEV KAILASH SHARMA', 'Lecturer', 'MDS', '1 Month', 'active', '2026-08-24 06:10:02'),
(47, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PRIYA SHARMA', 'Lecturer', 'MDS', '1 Month', 'active', '2026-08-24 06:10:02'),
(48, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. AAMIR BASHIR', 'Lecturer', 'MDS', '12 Days', 'active', '2026-08-24 06:10:02'),
(49, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. TOHID ALI', 'Tutor', 'BDS', '8 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(50, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. BHAVIKA A BHAVSAR', 'Professor & HOD', 'MDS', '17 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(51, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. DEEPALI SHIRIVASTAVA', 'Professor', 'MDS', '11 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(52, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. NEETU KHARAT', 'Professor', 'MDS', '11 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(53, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. DIVYA SAXENA', 'Reader', 'MDS', '6 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(54, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SASHIKANTH V S', 'Reader', 'MDS', '8 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(55, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. AMIT CHHAPARWAL', 'Reader', 'MDS', '6 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(56, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SHANTWANA SINGH', 'Lecturer', 'MDS', '2 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(57, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. RONAK B. MODI', 'Lecturer', 'MDS', '2 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(58, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. ABHINAV NAINAI', 'Lecturer', 'MDS', '1 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(59, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. V HARIKRISHNA', 'Lecturer', 'MDS', '1 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(60, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. NIKHIL RAJ', 'Lecturer', 'MDS', '1 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(61, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. FARHA ANSARI', 'Lecturer', 'MDS', '4 Months', 'active', '2026-08-24 06:10:02'),
(62, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. VINAYAK VAVAL', 'Lecturer', 'MDS', '4 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(63, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PIYUSHI TIWARI', 'Lecturer', 'MDS', '3 Months 18 Days', 'active', '2026-08-24 06:10:02'),
(64, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SANJAY ANTONY', 'Tutor', 'BDS', '20 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(65, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. ANKITA SHRIVASTAVA', 'Tutor', 'BDS', '6 Years 24 Days', 'active', '2026-08-24 06:10:02'),
(66, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. L.M. RANGANATH', 'Professor & HOD', 'MDS', '23 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(67, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PRATIBHA RAWAT', 'Professor', 'MDS', '10 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(68, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PRASHANT MISHRA', 'Reader', 'MDS', '7 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(69, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. MEENAKSHI SINGH TOMAR', 'Reader', 'MDS', '8 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(70, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. KAPIL CHOUDHARY', 'Reader', 'MDS', '5 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(71, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. ATUL BHANDARI', 'Reader', 'MDS', '12 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(72, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. BEBINEETA NINGTHOUJAM', 'Lecturer', 'MDS', '1 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(73, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PRIYANKA MALL', 'Lecturer', 'MDS', '1 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(74, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. ROMA ARUBAM', 'Lecturer', 'MDS', '1 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(75, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. DIPAL MAWANI POPATBHAI', 'Lecturer', 'MDS', '1 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(76, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SUGANDH SHRIVASTAVA', 'Lecturer', 'MDS', '5 Months', 'active', '2026-08-24 06:10:02'),
(77, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. RASHMITA MAJHI', 'Lecturer', 'MDS', '2 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(78, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PATEL KUSHAL MAHESH KUMAR', 'Lecturer', 'MDS', '3 Months', 'active', '2026-08-24 06:10:02'),
(79, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. GAURAV VAISHNAV', 'Lecturer', 'MDS', '3 Months', 'active', '2026-08-24 06:10:02'),
(80, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. AMRITA VAISHNAV', 'Tutor', 'BDS', '8 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(81, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. YOGESH GUPTA', 'Professor & HOD', 'MDS', '20 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(82, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. ANSHUJ THETAY', 'Professor', 'MDS', '14 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(83, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SEEMA LAHOTI', 'Professor', 'MDS', '13 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(84, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. VARUNJEET CHAUDHARY', 'Professor', 'MDS', '9 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(85, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. DEEPAK TOMAR', 'Reader', 'MDS', '8 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(86, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. JAS KIRAT SINGH', 'Reader', 'MDS', '6 Years 17 Days', 'active', '2026-08-24 06:10:02'),
(88, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. JAINA DUBEY', 'Lecturer', 'MDS', '1 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(89, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. AKASH G KUDMATHE', 'Lecturer', 'MDS', '1 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(90, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. THIYAM NICKY CHANDRA SINGH', 'Lecturer', 'MDS', '1 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(91, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. RAHUL KUMAR ANAND', 'Lecturer', 'MDS', '5 Months 3 Days', 'active', '2026-08-24 06:10:02'),
(92, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SAMEER PATHAN', 'Lecturer', 'MDS', '3 Months 19 Days', 'active', '2026-08-24 06:10:02'),
(93, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PRIYANKA RAI', 'Lecturer', 'MDS', '5 Months 2 Days', 'active', '2026-08-24 06:10:02'),
(94, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SHIVANAND B. BAGEWADI', 'Dean & HOD', 'MDS', '18 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(95, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. VIKRAM SINGH', 'Professor', 'MDS', '12 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(96, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PRATIKSHA HADA', 'Professor', 'MDS', '10 Years', 'active', '2026-08-24 06:10:02'),
(97, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SAKSHI SHARMA', 'Reader', 'MDS', '5 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(98, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SAHIL KOHLI', 'Reader', 'MDS', '6 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(99, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SHIVAM DUBEY', 'Lecturer', 'MDS', '4 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(100, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. VIKAS BATRA', 'Lecturer', 'MDS', '5 Months', 'active', '2026-08-24 06:10:02'),
(101, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'Dr. Rashi Pandey', 'Tutor', 'BDS', '1 Month', 'active', '2026-08-24 06:10:02'),
(102, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. GAURAV GUPTA', 'Reader', 'MDS', '8 Years 15 Days', 'active', '2026-08-24 06:10:02'),
(103, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. BHANUPRIYA THAKUR', 'Reader', 'MDS', '6 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(104, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. ANKITA SINGH', 'Lecturer', 'MDS', '1 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(105, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SARVESH BANSAL', 'Lecturer', 'MDS', '1 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(106, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SABIYATA KHAJURIA', 'Lecturer', 'MDS', '1 Year 6 Months', 'active', '2026-08-24 06:10:02'),
(107, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SUMAN KRITI', 'Lecturer', 'MDS', '3 Months 5 Days', 'active', '2026-08-24 06:10:02'),
(108, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. ANANT KUMAR', 'Lecturer', 'MDS', '3 Months', 'active', '2026-08-24 06:10:02'),
(109, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. DEEPAK VISWANATH', 'Professor & HOD', 'MDS', '17 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(110, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. DIPTI BHAGAT', 'Professor', 'MDS', '11 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(111, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. POOJA TRIPATHI', 'Reader', 'MDS', '7 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(112, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. NEHA SINGH', 'Reader', 'MDS', '5 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(113, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. DIVYA SURIYANSHI', 'Lecturer', 'MDS', '5 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(114, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SHIVANGI VERMA', 'Lecturer', 'MDS', '3 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(115, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR MONIKA PANDEY', 'Lecturer', 'MDS', '2 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(116, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SHUBHRATA SHRIVASTAVA', 'Lecturer', 'MDS', '1 Year 5 Months', 'active', '2026-08-24 06:10:02'),
(117, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. KIRAN DODANI', 'Professor & HOD', 'MDS', '13 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(118, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. AMIT NASHA', 'Reader', 'MDS', '5 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(119, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. ANKUR SINGH RAJPOOT', 'Reader', 'MDS', '5 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(120, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. DHANVENDRA SINGH', 'Lecturer', 'MDS', '18 Months', 'active', '2026-08-24 06:10:02'),
(121, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. KAJAL N MAHAJAN', 'Lecturer', 'MDS', '10 Months 28 Days', 'active', '2026-08-24 06:10:02'),
(122, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. DIVYA AGRAWAL', 'Lecturer', 'MDS', '5 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(123, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. RAJKUMAR KELVIN', 'Lecturer', 'MDS', '1 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(124, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PALLAVI GOSWAMI', 'Lecturer', 'MDS', '10 Months 28 Days', 'active', '2026-08-24 06:10:02'),
(125, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SANKET SHINDE', 'Lecturer', 'MDS', '1 Month', 'active', '2026-08-24 06:10:02'),
(126, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. GULREZ ALAM', 'Tutor', 'BDS', '11 Months', 'active', '2026-08-24 06:10:02'),
(127, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. MONIKA SONI', 'Tutor', 'BDS', '8 Months 11 Days', 'active', '2026-08-24 06:10:02'),
(128, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. APARNA PALIWAL', 'Professor & HOD', 'MDS', '14 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(129, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. NIDHI CHOUDAHA', 'Professor', 'MDS', '11 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(130, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SHWETA CHAUHAN', 'Professor', 'MDS', '9 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(131, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. PREETI RAJPUT', 'Reader', 'MDS', '6 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(132, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. SARIM AHMAD', 'Lecturer', 'MDS', '1 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(133, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. GEETIKA LOHANI', 'Tutor', 'BDS', '4 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(134, 'RKDF Dental College & Research Centre', 'rkdf-dental-college-research-centre', 'DR. IQRA ARSHI', 'Tutor', 'BDS', '3 Years', 'active', '2026-08-24 06:10:02'),
(135, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Mudita Jain', 'Professor & HOD', 'MBBS, MS', '11 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(136, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Manjari Goel', 'Professor', 'MBBS, MS', '12 Years', 'active', '2026-08-24 06:10:02'),
(137, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vandna Agrawal', 'Associate Professor', 'MBBS, MS', '11 Years', 'active', '2026-08-24 06:10:02'),
(138, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Mita Mujamdar', 'Associate Professor', 'MBBS, MS', '19 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(139, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sarika Gupta', 'Associate Professor', 'MBBS, MS', '12 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(140, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Divya Sharma', 'Associate Professor', 'MBBS, MS', '7 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(141, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rajat Saran', 'Professor & HOD', 'MBBS, MS', '22 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(142, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sachin Samaiya', 'Professor', 'MBBS, MS', '16 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(143, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Akella Suryanarayana Rao', 'Professor', 'MBBS, MS', '1 Year 2 Months', 'active', '2026-08-24 06:10:02'),
(144, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Garima Choudhary', 'Jr. Resident', 'MBBS, MS', '9 Months', 'active', '2026-08-24 06:10:02'),
(145, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Deependra Sahu', 'Jr. Resident', 'MBBS, MS', '3 Months', 'active', '2026-08-24 06:10:02'),
(146, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rima Biswas', 'Jr. Resident', 'MBBS, MS', '10 Months', 'active', '2026-08-24 06:10:02'),
(147, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Deepa Patel', 'Jr. Resident', 'MBBS, MS', '2 Months', 'active', '2026-08-24 06:10:02'),
(148, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Mrinalini Pathak', 'Jr. Resident', 'MBBS, MS', '3 Months', 'active', '2026-08-24 06:10:02'),
(149, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Avinash Patwari', 'Jr. Resident', 'MBBS, MS', '4 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(150, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ranjeeta Raikwar', 'Sr. Resident', 'MBBS, MS', '4 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(151, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pragiya Updhayay', 'Sr. Resident', 'MBBS, MS', '6 Years', 'active', '2026-08-24 06:10:02'),
(152, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rajput Pritisingh N', 'Sr. Resident', 'MBBS, MS', '4 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(153, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sonal Waghela', 'Assistant Professor', 'MBBS, MS', '7 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(154, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Neelima Tikkas', 'Assistant Professor', 'MBBS, MS', '8 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(155, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shaifali Mahajan', 'Assistant Professor', 'MBBS, MS', '4 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(156, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Seema Khurrum', 'Assistant Professor', 'MBBS, MS', '6 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(157, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rajpura Siddhartha B', 'Assistant Professor', 'MBBS, MS', '4 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(158, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vaghela Rajnikant Vinobhai', 'Sr. Resident', 'MBBS, MS', '3 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(159, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Tarun Pratap Singh', 'Assistant Professor', 'MBBS, MS', '4 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(160, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pradeep Tiwari', 'Assistant Professor', 'MBBS, MS', '4 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(161, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ankit Dadheech', 'Assistant Professor', 'MBBS, MS', '11 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(162, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Bhavin Agrawal', 'Assistant Professor', 'MBBS, MS', '5 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(163, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Dhruv Lashkare', 'Assistant Professor', 'MBBS, MS', '7 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(164, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. A.V.N. Sai Harsha', 'Senior Resident', 'MBBS, MS', '3 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(165, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Mukesh Kumar Dendor', 'Senior Resident', 'MBBS, MS', '3 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(166, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kuldip Jamanbhai Chovatiya', 'Senior Resident', 'MBBS, MS', '3 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(167, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Santosh Ashokbhai Hingu', 'Senior Resident', 'MBBS, MS', '3 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(168, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sargam Prakash', 'Jr. Resident', 'MBBS, MS', '7 Months', 'active', '2026-08-24 06:10:02'),
(169, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vishu Trivedi', 'Jr. Resident', 'MBBS, MS', '8 Months', 'active', '2026-08-24 06:10:02'),
(170, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rajendra Sharma', 'Jr. Resident', 'MBBS, MS', '8 Months', 'active', '2026-08-24 06:10:02'),
(171, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Abhishek Singh', 'Jr. Resident', 'MBBS, MS', '7 Months', 'active', '2026-08-24 06:10:02'),
(172, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rakesh Kumar', 'Jr. Resident', 'MBBS, MS', '5 Months', 'active', '2026-08-24 06:10:02'),
(173, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ayush Patel', 'Jr. Resident', 'MBBS, MS', '5 Months', 'active', '2026-08-24 06:10:02'),
(174, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Prakash Chand Agarwal', 'Professor & HOD', 'MBBS, MS', '20 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(175, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vasudha Damle', 'Professor', 'MBBS, MS', '15 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(176, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Mihika Dube', 'Assistant Professor', 'MBBS, MS', '12 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(177, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Akshita Ramesh Jindal', 'Assistant Professor', 'MBBS, MS', '3 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(178, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Desai Pritesh Jatinbhai', 'Assistant Professor', 'MBBS, MS', '4 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(179, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Praveen Kumar Khuntia', 'Sr. Resident', 'MBBS, MS', '3 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(180, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kavita Sahu', 'Sr. Resident', 'MBBS, MS', '3 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(181, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Nitika Tomar', 'Jr. Resident', 'MBBS, MS', '7 Months', 'active', '2026-08-24 06:10:02'),
(182, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Rajat Singh Yadav', 'Jr. Resident', 'MBBS, MS', '6 Months', 'active', '2026-08-24 06:10:02'),
(183, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Sabiha Rahman', 'Jr. Resident', 'MBBS, MS', '8 Months 12 Days', 'active', '2026-08-24 06:10:02'),
(184, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Yashaswini Srivastava', 'Jr. Resident', 'MBBS, MS', '6 Months 18 Days', 'active', '2026-08-24 06:10:02'),
(185, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rakesh Kumar', 'Professor & HOD', 'MBBS, MS', '17 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(186, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Dalli Sekhar Reddy', 'Professor', 'MBBS, MS', '8 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(187, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ronak S Shukla', 'Assistant Professor', 'MBBS, MS', '4 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(188, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Modh Datt Shaileshkumar', 'Assistant Professor', 'MBBS, MS', '4 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(189, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Madhu Agnihotri', 'Sr. Resident', 'MBBS, MS', '11 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(190, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Nisha Sagar Agrawal', 'Sr. Resident', 'MBBS, MS', '3 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(191, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Anwar A L', 'Jr. Resident', 'MBBS, MS', '8 Months 12 Days', 'active', '2026-08-24 06:10:02'),
(192, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Lakshay Madhra', 'Jr. Resident', 'MBBS, MS', '7 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(193, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Syed Karimulla', 'Jr. Resident', 'MBBS, MS', '4 Months 5 Days', 'active', '2026-08-24 06:10:02'),
(194, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shreenath Agrawal', 'Professor & HOD', 'MBBS, MD', '36 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(195, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sheetal Songir', 'Professor', 'MBBS, MD', '22 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(196, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Gaurav Singh Tomar', 'Associate Professor', 'MBBS, MD', '19 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(197, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Bhuvneshwar Minj', 'Associate Professor', 'MBBS, MD', '24 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(198, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Anju Verma', 'Associate Professor', 'MBBS, MD', '16 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(199, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vibha Mishra', 'Assistant Professor', 'MBBS, MD', '11 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(200, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rakesh Singh Baghel', 'Assistant Professor', 'MBBS, MD', '17 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(201, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kruti Jadav', 'Assistant Professor', 'MBBS, MD', '4 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(202, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Varchaswa Pandey', 'Assistant Professor', 'MBBS, MD', '11 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(203, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Arvind Meena', 'Assistant Professor', 'MBBS, MD', '5 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(204, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Anshul Taran', 'Sr. Resident', 'MBBS, MD', '6 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(205, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Radhika Pathak', 'Assistant Professor', 'MBBS, MD', '5 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(206, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sunil Raghuwanshi', 'Sr. Resident', 'MBBS, MD', '12 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(207, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Devendra Kumar Gavhade', 'Sr. Resident', 'MBBS, MD', '10 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(208, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Parth Bhatt', 'Sr. Resident', 'MBBS, MD', '4 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(209, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Aarzoo Verma', 'Junior Resident', 'MBBS, MD', '8 Months', 'active', '2026-08-24 06:10:02'),
(210, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Dhanvi Mishra', 'Junior Resident', 'MBBS, MD', '7 Months', 'active', '2026-08-24 06:10:02'),
(211, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Dheeraj Pathak', 'Junior Resident', 'MBBS, MD', '7 Months', 'active', '2026-08-24 06:10:02'),
(212, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Madhvi Verma', 'Junior Resident', 'MBBS, MD', '8 Months', 'active', '2026-08-24 06:10:02'),
(213, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Mudit Sharma', 'Junior Resident', 'MBBS, MD', '8 Months', 'active', '2026-08-24 06:10:02'),
(214, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Richa Rana', 'Junior Resident', 'MBBS, MD', '5 Months', 'active', '2026-08-24 06:10:02'),
(215, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shaik Ghouse Basha', 'Junior Resident', 'MBBS, MD', '7 Months', 'active', '2026-08-24 06:10:02'),
(216, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Surya Prakash Pathak', 'Junior Resident', 'MBBS, MD', '8 Months 12 Days', 'active', '2026-08-24 06:10:02'),
(217, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Santosh Raikwar', 'Professor & HOD', 'MBBS, MD', '26 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(218, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. P.D. Mahant', 'Professor', 'MBBS, MD', '18 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(219, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sumit Kumar Verma', 'Associate Professor', 'MBBS, MD', '12 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(220, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shruti Kapoor', 'Assistant Professor', 'MBBS, MD', '11 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(221, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kalyani C. Raghuwanshi', 'Assistant Professor', 'MBBS, MD', '8 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(222, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Suryakant Singh', 'Assistant Professor', 'MBBS, MD', '9 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(223, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Divya Bharatkumar Desai', 'Assistant Professor', 'MBBS, MD', '4 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(224, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Saurabh Kumar Mishra', 'Assistant Professor', 'MBBS, MD', '6 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(225, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rajan Kamlesh Kumar Patel', 'Sr. Resident', 'MBBS, MD', '3 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(226, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Davra Sanket Kumar Vinubhai', 'Sr. Resident', 'MBBS, MD', '3 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(227, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Tanushree Amal Poddar', 'Sr. Resident', 'MBBS, MD', '3 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(228, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ravi Shrotriya', 'Junior Resident', 'MBBS, MD', '3 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(229, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Yashasvi Agrawal', 'Junior Resident', 'MBBS, MD', '1 Year 8 Months', 'active', '2026-08-24 06:10:02'),
(230, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vivekanand Gajbhiye', 'Professor & HOD', 'MBBS, MD', '24 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(231, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Savita H. Gadekar', 'Professor', 'MBBS, MD', '32 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(232, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Nilesh Rakate', 'Associate Professor', 'MBBS, MD', '15 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(233, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shruti Gosawami', 'Associate Professor', 'MBBS, MD', '9 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(234, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Gaganan Patil', 'Assistant Professor', 'MBBS, MD', '4 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(235, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Jaipal Chilumu', 'Assistant Professor', 'MBBS, MD', '9 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(236, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pallavi Ranjan Anand', 'Assistant Professor', 'MBBS, MD', '3 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(237, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Priyanka Singh', 'Assistant Professor', 'MBBS, MD', '4 Years', 'active', '2026-08-24 06:10:02'),
(238, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rajkumar Meena', 'Tutor', 'MBBS, MD', '2 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(239, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Saurabh Kumar PG', 'Tutor', 'MBBS, MD', '6 Months', 'active', '2026-08-24 06:10:02'),
(240, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ayushi Manya Jain', 'Tutor', 'MBBS, MD', '6 Months', 'active', '2026-08-24 06:10:02'),
(241, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Aman Tiwari', 'Tutor', 'MBBS, MD', '3 Months', 'active', '2026-08-24 06:10:02'),
(242, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vivek Patel', 'Tutor', 'MBBS, MD', '3 Months', 'active', '2026-08-24 06:10:02'),
(243, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Manish Narvariya', 'Senior Resident', 'MBBS, MD', '3 Months', 'active', '2026-08-24 06:10:02'),
(244, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vaibhav Gupta', 'Junior Resident', 'MBBS, MD', '7 Months', 'active', '2026-08-24 06:10:02'),
(245, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rahul Singh Sikarwar', 'Senior Resident', 'MBBS, MD', '3 Months', 'active', '2026-08-24 06:10:02'),
(246, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Asish Jha', 'Senior Resident', 'MBBS, MD', '3 Months', 'active', '2026-08-24 06:10:02'),
(247, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Naveen Bankey', 'Professor', 'MBBS, MD', '10 Years 2 Months', 'active', '2026-08-24 06:10:02');
INSERT INTO `faculty` (`id`, `department_name`, `dept_slug`, `name`, `designation`, `qualification`, `experience`, `status`, `created_at`) VALUES
(248, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sudhanshu Shekhar Mishra', 'Professor', 'MBBS, MD', '25 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(249, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rajendrakumar Y. Thorat', 'Professor', 'MBBS, MD', '17 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(250, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ganaraja B.', 'Professor', 'MBBS, MD', '34 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(251, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Satish Pawar', 'Associate Professor', 'MBBS, MD', '18 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(252, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Gayathri B.H.', 'Assistant Professor', 'MBBS, MD', '7 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(253, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Anuradha Pawar', 'Assistant Professor', 'MBBS, MD', '7 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(254, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Saumitra Pandey', 'Assistant Professor', 'MBBS, MD', '5 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(255, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shivam Kumar', 'Tutor', 'MBBS', '1 Year 7 Months', 'active', '2026-08-24 06:10:02'),
(256, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Diksha Rathore', 'Tutor', 'MBBS', '1 Year 7 Months', 'active', '2026-08-24 06:10:02'),
(257, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Mohit Gupta', 'Tutor', 'MBBS', '3 Years', 'active', '2026-08-24 06:10:02'),
(258, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Disha Soni', 'Tutor', 'MBBS', '11 Months', 'active', '2026-08-24 06:10:02'),
(259, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pradeep Sankle', 'Tutor', 'MBBS', '3 Months', 'active', '2026-08-24 06:10:02'),
(260, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Umakant Soni', 'Tutor', 'MBBS', '11 Months', 'active', '2026-08-24 06:10:02'),
(261, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vikas Khedekar', 'Tutor', 'MBBS', '2 Months 28 Days', 'active', '2026-08-24 06:10:02'),
(262, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Bhavna Gour', 'Senior Resident', 'BDS, M.Sc', '5 Months 18 Days', 'active', '2026-08-24 06:10:02'),
(263, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Priti Janrao Kamble', 'Senior Resident', 'MBBS, MD', '6 Months 18 Days', 'active', '2026-08-24 06:10:02'),
(264, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Swati Aagrawal', 'Professor', 'MBBS, MD', '17 Years 14 Months', 'active', '2026-08-24 06:10:02'),
(265, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Madhav Govindrao Kalekar', 'Professor', 'MBBS, MD', '46 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(266, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Namita Rao', 'Professor', 'MBBS, MD', '34 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(267, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Gayatri Yadav', 'Associate Professor', 'MBBS, MD', '14 Years 12 Months', 'active', '2026-08-24 06:10:02'),
(268, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sunita Turankar', 'Associate Professor', 'MBBS, MD', '7 Years 20 Months', 'active', '2026-08-24 06:10:02'),
(269, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ashok Kumar Mehra', 'Assistant Professor', 'MBBS, MD', '2 Years 17 Days', 'active', '2026-08-24 06:10:02'),
(270, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Varaprasad Kalapureddy', 'Assistant Professor', 'MBBS, MD', '2 Months 17 Days', 'active', '2026-08-24 06:10:02'),
(271, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Madhumati Landge', 'Assistant Professor', 'MBBS, MD', '3 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(272, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Saman Amin', 'Tutor', 'MBBS, MD', '1 Year 8 Months', 'active', '2026-08-24 06:10:02'),
(273, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shubham Kumar', 'Tutor', 'MBBS, MD', '9 Months 9 Days', 'active', '2026-08-24 06:10:02'),
(274, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sunil Singh Tomar', 'Tutor', 'MBBS, MD', '5 Months 27 Days', 'active', '2026-08-24 06:10:02'),
(275, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Manish Meena', 'Tutor', 'MBBS, MD', '1 Year 9 Months', 'active', '2026-08-24 06:10:02'),
(276, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Animesh Singh', 'Tutor', 'MBBS, MD', '2 Months 25 Days', 'active', '2026-08-24 06:10:02'),
(277, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Hemant Chauhan', 'Tutor', 'MBBS, MD', '3 Months 3 Days', 'active', '2026-08-24 06:10:02'),
(278, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pratibha Mansorya', 'Tutor', 'MBBS, MD', '2 Months 26 Days', 'active', '2026-08-24 06:10:02'),
(279, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Himanshu Jain', 'Tutor', 'MBBS, MD', '3 Months 2 Days', 'active', '2026-08-24 06:10:02'),
(280, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Reena Verma', 'Professor & HOD', 'MBBS, MD', '22 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(281, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Dinesh Kumar Jain', 'Professor', 'MBBS, MD', '45 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(282, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Mustafa Raja', 'Professor', 'MBBS, MD', '14 Years 19 Months', 'active', '2026-08-24 06:10:02'),
(283, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pushp Raj Gour', 'Associate Professor', 'MBBS, MD', '10 Years 15 Months', 'active', '2026-08-24 06:10:02'),
(284, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. T. Madhu Chaithanya', 'Associate Professor', 'MBBS, MD', '8 Years 23 Months', 'active', '2026-08-24 06:10:02'),
(285, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Patel Dishaben', 'Assistant Professor', 'MBBS, MD', '4 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(286, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Bhargav Ramesh Darji', 'Assistant Professor', 'MBBS, MD', '8 Years 14 Months', 'active', '2026-08-24 06:10:02'),
(287, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sagar Meena', 'Tutor', 'MBBS, MD', '3 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(288, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sudeep Jain', 'Tutor', 'MBBS, MD', '7 Months 23 Days', 'active', '2026-08-24 06:10:02'),
(289, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vivek Kumar Singh', 'Tutor', 'MBBS, MD', '1 Year 7 Months', 'active', '2026-08-24 06:10:02'),
(290, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Jitendra Silawat', 'Tutor', 'MBBS, MD', '11 Months', 'active', '2026-08-24 06:10:02'),
(291, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Deepika Soni', 'Tutor', 'MBBS, MD', '9 Months 18 Days', 'active', '2026-08-24 06:10:02'),
(292, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Goyal Anjali', 'Senior Resident', 'MBBS, MD', '5 Months 18 Days', 'active', '2026-08-24 06:10:02'),
(293, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kishanbhai Patel', 'Senior Resident', 'MBBS, MD', '3 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(294, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kaushal Joshi', 'Senior Resident', 'MBBS, MD', '3 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(295, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Deepti Gupta', 'Professor & HOD', 'MBBS, MD', '10 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(296, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Deepankar Parmar', 'Professor', 'MBBS, MD', '15 Years 21 Months', 'active', '2026-08-24 06:10:02'),
(297, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Arun Bakshi', 'Professor', 'MBBS, MD', '39 Years 18 Months', 'active', '2026-08-24 06:10:02'),
(298, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. S.V. Srikar', 'Professor', 'MBBS, MD', '11 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(299, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kashmir Ali', 'Associate Professor', 'MBBS, MD', '8 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(300, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Neha Raghuwanshi', 'Assistant Professor', 'MBBS, MD', '1 Year 10 Months', 'active', '2026-08-24 06:10:02'),
(301, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Himani Parmar', 'Assistant Professor', 'MBBS, MD', '5 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(302, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Urvashi Hirpara', 'Assistant Professor', 'MBBS, MD', '4 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(303, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sumit Goswami', 'Assistant Professor', 'MBBS, MD', '11 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(304, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Namrata Kumari', 'Tutor', 'MBBS', '1 Year 6 Months', 'active', '2026-08-24 06:10:02'),
(305, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Amrita Chauda', 'Tutor', 'MBBS', '7 Months 32 Days', 'active', '2026-08-24 06:10:02'),
(306, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Irum Sheikh', 'Tutor', 'MBBS', '7 Months 30 Days', 'active', '2026-08-24 06:10:02'),
(307, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Nikita Pandey', 'Tutor', 'MBBS', '7 Months', 'active', '2026-08-24 06:10:02'),
(308, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Shreya Jaiswal', 'Tutor', 'MBBS', '7 Months', 'active', '2026-08-24 06:10:02'),
(309, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Shubham Sahu', 'Tutor', 'MBBS', '11 Months 42 Days', 'active', '2026-08-24 06:10:02'),
(310, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Vishal Mohnani', 'Tutor', 'MBBS', '11 Months 40 Days', 'active', '2026-08-24 06:10:02'),
(311, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Priya Venkatrao Kaurwad', 'Senior Resident', 'MBBS, MD', '4 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(312, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Amit Gupta', 'Senior Resident', 'MBBS, MD', '5 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(313, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Payal Bhatt', 'Senior Resident', 'MBBS, MD', '6 Months 7 Days', 'active', '2026-08-24 06:10:02'),
(314, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Apoorva Tripathi', 'Professor & HOD', 'MBBS, MD', '22 Years', 'active', '2026-08-24 06:10:02'),
(315, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Hemant Gadekar', 'Professor', 'MBBS, MD', '24 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(316, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vikas Jain', 'Professor', 'MBBS, MD', '13 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(317, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Disha Sharma', 'Assistant Professor', 'MBBS, MD', '9 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(318, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Monika Gupta', 'Assistant Professor', 'MBBS, MD', '3 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(319, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sweta Kumari', 'Assistant Professor', 'MBBS, MD', '7 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(320, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kaveri Saini', 'Assistant Professor', 'MBBS, MD', '4 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(321, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Gaya Prasad Gour', 'Tutor', 'MBBS, MD', '3 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(322, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Mudit Bohare', 'Tutor', 'MBBS, MD', '8 Months', 'active', '2026-08-24 06:10:02'),
(323, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Shilpa Singh', 'Tutor', 'MBBS, MD', '6 Months', 'active', '2026-08-24 06:10:02'),
(324, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. A. Divya Jain', 'Tutor', 'MBBS, MD', '11 Months', 'active', '2026-08-24 06:10:02'),
(325, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Ajay Solanki', 'Tutor', 'MBBS, MD', '11 Months', 'active', '2026-08-24 06:10:02'),
(326, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Gourav Gaur', 'Tutor', 'MBBS, MD', '3 Months', 'active', '2026-08-24 06:10:02'),
(327, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ravi Shrivastava', 'Tutor', 'MBBS, MD', '3 Months', 'active', '2026-08-24 06:10:02'),
(328, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Trilok Singh Mourya', 'Tutor', 'MBBS, MD', '3 Months', 'active', '2026-08-24 06:10:02'),
(329, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. B.K. Athawal', 'Professor', 'MBBS, MD', '31 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(330, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Dayal Daya Brajeshwar', 'Professor', 'MBBS, MD', '34 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(331, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Prashantha Bhagavath', 'Professor', 'MBBS, MD', '12 Years 12 Months', 'active', '2026-08-24 06:10:02'),
(332, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Lokesh Kumar Mittal', 'Tutor', 'MBBS, MD', '1 Year 11 Months', 'active', '2026-08-24 06:10:02'),
(333, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Nikhil Kumar', 'Tutor', 'MBBS, MD', '8 Months', 'active', '2026-08-24 06:10:02'),
(334, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Sujay Kumar', 'Tutor', 'MBBS, MD', '7 Months', 'active', '2026-08-24 06:10:02'),
(335, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vipin Kumar Singh', 'Tutor', 'MBBS, MD', '6 Months', 'active', '2026-08-24 06:10:02'),
(336, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Hemraj Malviya', 'Tutor', 'MBBS, MD', '1 Year 1 Month', 'active', '2026-08-24 06:10:02'),
(337, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Himank Agarwal', 'Tutor', 'MBBS, MD', '1 Year 3 Months', 'active', '2026-08-24 06:10:02'),
(338, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ajay Mahore', 'Tutor', 'MBBS, MD', '3 Months', 'active', '2026-08-24 06:10:02'),
(339, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Diwakar Singh', 'Tutor', 'MBBS, MD', '4 Months', 'active', '2026-08-24 06:10:02'),
(340, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shivam Kumar Soni', 'Tutor', 'MBBS, MD', '3 Months', 'active', '2026-08-24 06:10:02'),
(341, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Subodh Mishra', 'Professor & HOD', 'MBBS, MD', '21 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(342, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ganga Ram Mahor', 'Professor', 'MBBS, MD', '23 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(343, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Swati Jain', 'Professor', 'MBBS, MD', '18 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(344, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vijay K. Agrawal', 'Professor', 'MBBS, MD', '25 Years 12 Months', 'active', '2026-08-24 06:10:02'),
(345, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vidya Mahendra Surwade', 'Professor', 'MBBS, MD', '18 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(346, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kamlesh Nigam', 'Associate Professor', 'MBBS, MD', '12 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(347, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Santosh K. Patel', 'Associate Professor', 'MBBS, MD', '8 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(348, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Gaurang Parmar', 'Assistant Professor', 'MBBS, MD', '5 Months', 'active', '2026-08-24 06:10:02'),
(349, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sahil R. Parmar', 'Assistant Professor', 'MBBS, MD', '6 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(350, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Mr. Ashish Pandey', 'Statistician-Cum-Tutor', 'MBBS, MD', '3 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(351, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Ankush Sharma', 'Tutor', 'MBBS, MD', '4 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(352, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Arvind Kirade', 'Tutor', 'MBBS, MD', '5 Months', 'active', '2026-08-24 06:10:02'),
(353, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Maya Dawar', 'Tutor', 'MBBS, MD', '6 Months', 'active', '2026-08-24 06:10:02'),
(354, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Pradeep Varma', 'Tutor', 'MBBS, MD', '7 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(355, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Rana Pratap Singh Rajput', 'Tutor', 'MBBS, MD', '6 Months', 'active', '2026-08-24 06:10:02'),
(356, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Surya Pratap Dixit', 'Tutor', 'MBBS, MD', '7 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(357, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Tapish Shivhare', 'Tutor', 'MBBS, MD', '6 Months', 'active', '2026-08-24 06:10:02'),
(358, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Abhimanyu Sharma', 'Tutor', 'MBBS, MD', '11 Months 4 Days', 'active', '2026-08-24 06:10:02'),
(359, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Himankshi Gyanchandant', 'Tutor', 'MBBS, MD', '11 Months 5 Days', 'active', '2026-08-24 06:10:02'),
(360, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Meenal Dua', 'Tutor', 'MBBS, MD', '3 Months 2 Days', 'active', '2026-08-24 06:10:02'),
(361, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'DR. TRIPTA SOLANKI', 'CMO', 'MBBS, MD', '11 Months 11 Days', 'active', '2026-08-24 06:10:02'),
(362, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Anant Kumar Lilhare', 'Senior Resident', 'MBBS, MD', '3 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(363, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Jitendra Kumar Jain', 'Professor & HOD', 'MBBS, MS', '18 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(364, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sudeep Pathak', 'Associate Professor', 'MBBS, MS', '8 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(365, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Archana Saxena', 'Associate Professor', 'MBBS, MS', '8 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(366, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vasant Shrivastava', 'Associate Professor', 'MBBS, MS', '10 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(367, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Anand Jat', 'Associate Professor', 'MBBS, MS', '9 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(368, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Mritunjay Kumar', 'Associate Professor', 'MBBS, MS', '10 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(369, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sumit Bhatnagar', 'Assistant Professor', 'MBBS, MS', '6 Years 10 Days', 'active', '2026-08-24 06:10:02'),
(370, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Virendra Singh Patel', 'Assistant Professor', 'MBBS, MS', '6 Months 21 Days', 'active', '2026-08-24 06:10:02'),
(371, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shah Jay', 'Assistant Professor', 'MBBS, MS', '1 Year 8 Months', 'active', '2026-08-24 06:10:02'),
(372, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ranjana Mandal', 'Assistant Professor', 'MBBS, MS', '4 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(373, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shyam Govindrao Dawana', 'Assistant Professor', 'MBBS, MS', '7 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(374, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Deepak Narayanrao Gore', 'Assistant Professor', 'MBBS, MS', '2 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(375, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shrimali Kuldipbhai M.', 'Assistant Professor', 'MBBS, MS', '4 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(376, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Harsh Pathak', 'Assistant Professor', 'MBBS, MS', '5 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(377, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Harshilkumar J. Shah', 'Assistant Professor', 'MBBS, MS', '5 Years 12 Months', 'active', '2026-08-24 06:10:02'),
(378, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Suyash Bhadoriya', 'Assistant Professor', 'MBBS, MS', '6 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(379, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Patel Akashbhai Kanaiyalal', 'Assistant Professor', 'MBBS, MS', '6 Months', 'active', '2026-08-24 06:10:02'),
(380, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Atul Shridhar Kalushe', 'Sr. Resident', 'MBBS, MS', '8 Months', 'active', '2026-08-24 06:10:02'),
(381, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'DR. AVADHESH KUMAR SHARMA', 'Sr. Resident', 'MBBS, MS', '1 Year 8 Months', 'active', '2026-08-24 06:10:02'),
(382, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sumit Ramesh Gotmare', 'Sr. Resident', 'MBBS, MS', '3 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(383, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Parv Modi', 'Sr. Resident', 'MBBS, MS', '3 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(384, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Aditya Raghuwanshi', 'Jr. Resident', 'MBBS, MS', '1 Year 8 Months', 'active', '2026-08-24 06:10:02'),
(385, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Avneesh Singhai', 'Jr. Resident', 'MBBS, MS', '14 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(386, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Dabhi Harpalsinh Sureshkumar', 'Jr. Resident', 'MBBS, MS', '1 Year 7 Months', 'active', '2026-08-24 06:10:02'),
(387, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'DR. SANJAY GAUR', 'Jr. Resident', 'MBBS, MS', '1 Year 7 Months', 'active', '2026-08-24 06:10:02'),
(388, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Harjot Singh Arora', 'Jr. Resident', 'MBBS, MS', '1 Year 7 Months', 'active', '2026-08-24 06:10:02'),
(389, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'DR. RAKESH MENARIYA', 'Jr. Resident', 'MBBS, MS', '3 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(390, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'DR. VAISHALI PANDEY', 'Jr. Resident', 'MBBS, MS', '7 Months', 'active', '2026-08-24 06:10:02'),
(391, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vijay Khatarkar', 'Jr. Resident', 'MBBS, MS', '6 Months', 'active', '2026-08-24 06:10:02'),
(392, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vikas Singh Para', 'Jr. Resident', 'MBBS, MS', '7 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(393, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Aditya Singhai', 'Jr. Resident', 'MBBS, MS', '7 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(394, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Akash Wardiya', 'Jr. Resident', 'MBBS, MS', '7 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(395, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Umesh Patel', 'Professor & HOD', 'MBBS, MS', '22 Years 12 Months', 'active', '2026-08-24 06:10:02'),
(396, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ashtha Tiwari', 'Professor', 'MBBS, MS', '17 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(397, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sunita Lakhwani', 'Professor', 'MBBS, MS', '15 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(398, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kasi Bandaru', 'Associate Professor', 'MBBS, MS', '13 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(399, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pritesh Khatwar', 'Assistant Professor', 'MBBS, MS', '7 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(400, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Tarun Solanki', 'Assistant Professor', 'MBBS, MS', '6 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(401, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Abhishek Sharma', 'Assistant Professor', 'MBBS, MS', '5 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(402, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Mohd. Rehan N. Ansari', 'Assistant Professor', 'MBBS, MS', '4 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(403, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Avesh Saini', 'Assistant Professor', 'MBBS, MS', '3 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(404, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kirti Narayan', 'Senior Resident', 'MBBS, MS', '6 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(405, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Surendra Vyas', 'Senior Resident', 'MBBS, MS', '3 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(406, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Swapneel S. Jadhav', 'Senior Resident', 'MBBS, MS', '4 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(407, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rajshri Rajendra Prasad', 'Senior Resident', 'MBBS, MS', '2 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(408, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Jai Prakash Churasia', 'Senior Resident', 'MBBS, MS', '5 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(409, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Aachal Sadani', 'Jr. Resident', 'MBBS, MS', '5 Months', 'active', '2026-08-24 06:10:02'),
(410, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Akshara Satyavana', 'Jr. Resident', 'MBBS, MS', '6 Months', 'active', '2026-08-24 06:10:02'),
(411, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Deepak Pandey', 'Jr. Resident', 'MBBS, MS', '7 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(412, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Kratika Neema', 'Jr. Resident', 'MBBS, MS', '5 Months', 'active', '2026-08-24 06:10:02'),
(413, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Mayank Patle', 'Jr. Resident', 'MBBS, MS', '7 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(414, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Tinku Vishwas', 'Jr. Resident', 'MBBS, MS', '3 Months', 'active', '2026-08-24 06:10:02'),
(415, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Nidhi Choudhary', 'Associate Professor', 'MBBS, MS', '12 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(416, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ajay Singh Raghuvansi', 'Assistant Professor', 'MBBS, MS', '8 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(417, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Nidhi Rana', 'Sr. Resident', 'MBBS, MS', '7 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(418, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Mansi Tiwari', 'Jr. Resident', 'MBBS, MS', '1 Year 8 Months', 'active', '2026-08-24 06:10:02'),
(419, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Shubhangi Jain', 'Jr. Resident', 'MBBS, MS', '3 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(420, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Tarun Choudhary', 'Jr. Resident', 'MBBS, MS', '1 Year 8 Months', 'active', '2026-08-24 06:10:02'),
(421, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Hritu Singh', 'Professor', 'MBBS, MS', '10 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(422, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ravindra Bhumanna Narod', 'Associate Professor', 'MBBS, MS', '10 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(423, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sanjeet Diwan', 'Assistant Professor', 'MBBS, MS', '7 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(424, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Anjali Sahay', 'Professor', 'MBBS, MS', '20 Years', 'active', '2026-08-24 06:10:02'),
(425, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sanjay B. Kalsariya', 'Sr. Resident', 'MBBS, MS', '4 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(426, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Akash Soni', 'Jr. Resident', 'MBBS, MS', '4 Months', 'active', '2026-08-24 06:10:02'),
(427, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Puniee Sharma', 'Jr. Resident', 'MBBS, MS', '4 Months 11 Days', 'active', '2026-08-24 06:10:02'),
(428, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Rahul Dhakad', 'Jr. Resident', 'MBBS, MS', '5 Months 20 Days', 'active', '2026-08-24 06:10:02'),
(429, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ramkrishna V. Ghubde', 'Professor', 'MBBS, MS', '7 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(430, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Asari Amit Jitendrabhai', 'Associate Professor', 'MBBS, MS', '5 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(431, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vijay Kumar Sharma', 'Assistant Professor', 'MBBS, MS', '7 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(432, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vivek Arora', 'Senior Resident', 'MBBS, MS', '4 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(433, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Govind Dhakad', 'Jr. Resident', 'MBBS, MS', '8 Months 12 Days', 'active', '2026-08-24 06:10:02'),
(434, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Adesh Bunkar', 'Jr. Resident', 'MBBS, MS', '3 Months 16 Days', 'active', '2026-08-24 06:10:02'),
(435, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Ajaydeep Gurjar', 'Jr. Resident', 'MBBS, MS', '4 Months', 'active', '2026-08-24 06:10:02'),
(436, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rajesh Lonare', 'Professor & HOD', 'MBBS, MS', '23 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(437, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ranjeet Choudhary', 'Professor', 'MBBS, MS', '27 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(438, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sunil Kumar Maini', 'Professor', 'MBBS, MS', '24 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(439, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pradeep K. Saxena', 'Professor', 'MBBS, MS', '19 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(440, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Jahangir Gulab Sayyad', 'Professor', 'MBBS, MS', '18 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(441, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Prakash Jai', 'Associate Professor', 'MBBS, MS', '7 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(442, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Krishna Kumar Singh', 'Associate Professor', 'MBBS, MS', '12 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(443, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Manish Maran', 'Assistant Professor', 'MBBS, MS', '13 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(444, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pramod Kumar Sharma', 'Assistant Professor', 'MBBS, MS', '10 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(445, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Alekh Jain', 'Assistant Professor', 'MBBS, MS', '10 Years 10 Months', 'active', '2026-08-24 06:10:02'),
(446, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rahul Agrawal', 'Assistant Professor', 'MBBS, MS', '13 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(447, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pramod K. Jain', 'Assistant Professor', 'MBBS, MS', '8 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(448, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Aman Agarwal', 'Assistant Professor', 'MBBS, MS', '8 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(449, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sneha Ninama', 'Assistant Professor', 'MBBS, MS', '10 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(450, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kakadiya Pragnesh Dilipbhai', 'Assistant Professor', 'MBBS, MS', '1 Year 7 Months', 'active', '2026-08-24 06:10:02'),
(451, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Parth H Rana', 'Assistant Professor', 'MBBS, MS', '4 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(452, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ketan Popatbhai Prajapati', 'Senior Resident', 'MBBS, MS', '4 Years 11 Months', 'active', '2026-08-24 06:10:02'),
(453, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Agrawal Akash', 'Senior Resident', 'MBBS, MS', '4 Years 9 Months', 'active', '2026-08-24 06:10:02'),
(454, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Beladiya Jatin Babubhai', 'Senior Resident', 'MBBS, MS', '4 Years 8 Months', 'active', '2026-08-24 06:10:02'),
(455, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Agrawal Parth S.', 'Senior Resident', 'MBBS, MS', '4 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(456, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shruti Devendra', 'Senior Resident', 'MBBS, MS', '3 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(457, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Jitendra Yede', 'Senior Resident', 'MBBS, MS', '6 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(458, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Snehal Kawale', 'Senior Resident', 'MBBS, MS', '6 Months', 'active', '2026-08-24 06:10:02'),
(459, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Sonam Manohar Devlekar', 'Senior Resident', 'MBBS, MS', '5 Months', 'active', '2026-08-24 06:10:02'),
(460, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Jayshree Mishra', 'Junior Resident', 'MBBS, MS', '7 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(461, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Abhijeet Singhai', 'Junior Resident', 'MBBS, MS', '6 Months 20 Days', 'active', '2026-08-24 06:10:02'),
(462, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Anoop Surender', 'Junior Resident', 'MBBS, MS', '5 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(463, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Ashlesha Tiwari', 'Junior Resident', 'MBBS, MS', '8 Months 12 Days', 'active', '2026-08-24 06:10:02'),
(464, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Gaurav Pandey', 'Junior Resident', 'MBBS, MS', '4 Months 10 Days', 'active', '2026-08-24 06:10:02'),
(465, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Jitendra Choudhary', 'Junior Resident', 'MBBS, MS', '5 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(466, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Monika Shakya', 'Junior Resident', 'MBBS, MS', '3 Months 10 Days', 'active', '2026-08-24 06:10:02'),
(467, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Neelesh Kumar Pandey', 'Junior Resident', 'MBBS, MS', '4 Months', 'active', '2026-08-24 06:10:02'),
(468, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Pradeep Vaishnava', 'Junior Resident', 'MBBS, MS', '5 Months 15 Days', 'active', '2026-08-24 06:10:02'),
(469, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Rizwan Khan', 'Junior Resident', 'MBBS, MS', '8 Months 12 Days', 'active', '2026-08-24 06:10:02'),
(470, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Vijay Singh Baghel', 'Professor', 'MBBS, MS', '28 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(471, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Gunjan Badwaik', 'Associate Professor', 'MBBS, MS', '12 Years 7 Months', 'active', '2026-08-24 06:10:02'),
(472, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kamlesh Agrawal', 'Assistant Professor', 'MBBS, MS', '5 Years 2 Months', 'active', '2026-08-24 06:10:02'),
(473, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Priyank Jain', 'Senior Resident', 'MBBS, MS', '14 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(474, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ritesh Ashok Raut', 'Senior Resident', 'MBBS, MS', '3 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(475, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Rahul R. Shenoy', 'Senior Resident', 'MBBS, MS', '3 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(476, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Jitesh K. Bhandarkar', 'Senior Resident', 'MBBS, MS', '3 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(477, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Akshay Jagtap', 'Senior Resident', 'MBBS, MS', '3 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(478, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Patel Darshitkumar S.', 'Senior Resident', 'MBBS, MS', '3 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(479, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Ronik Bharat Dhodheja', 'Senior Resident', 'MBBS, MS', '3 Years 3 Months', 'active', '2026-08-24 06:10:02'),
(480, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Shrikrushna Vasant Chavan', 'Senior Resident', 'MBBS, MS', '4 Years 1 Month', 'active', '2026-08-24 06:10:02'),
(481, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Pranoti Uttam Jadhao', 'Senior Resident', 'MBBS, MS', '1 Year 6 Months', 'active', '2026-08-24 06:10:02'),
(482, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Chetan Chovatiya', 'Sr. Resident', 'MBBS, MS', '4 Years 5 Months', 'active', '2026-08-24 06:10:02'),
(483, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Kschitiz Agrawal', 'Senior Resident', 'MBBS, MS', '3 Years 6 Months', 'active', '2026-08-24 06:10:02'),
(484, 'RKDF Medical College Hospital & Research Centre', 'rkdf-medical-college-hospital-research-centre', 'Dr. Krishna B. Bhalala', 'Senior Resident', 'MBBS, MS', '3 Years 4 Months', 'active', '2026-08-24 06:10:02'),
(485, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Dr. Archana Selvan', 'Principal', 'PhD Nursing & M.Sc Nursing', '40 Years', 'active', '2026-08-24 06:10:02'),
(486, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Dr. Neha Dubey', 'Vice Principal', 'PhD Nursing & M.Sc Nursing', '15 Years', 'active', '2026-08-24 06:10:02'),
(487, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Dr. Bharti Batra', 'Professor', 'PhD Nursing & M.Sc Nursing', '33 Years', 'active', '2026-08-24 06:10:02');
INSERT INTO `faculty` (`id`, `department_name`, `dept_slug`, `name`, `designation`, `qualification`, `experience`, `status`, `created_at`) VALUES
(488, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Anupama Khanegembam', 'Professor', 'M.Sc Nursing', '12 Years', 'active', '2026-08-24 06:10:02'),
(489, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Durga Harne', 'Associate Professor', 'M.Sc Nursing', '8 Years', 'active', '2026-08-24 06:10:02'),
(490, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mrs. Neha Bharti', 'Associate Professor', 'M.Sc Nursing', '8 Years', 'active', '2026-08-24 06:10:02'),
(491, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Sharon Master', 'Associate Professor', 'M.Sc Nursing', '8 Years', 'active', '2026-08-24 06:10:02'),
(492, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Rincy Jacob', 'Associate Professor', 'M.Sc Nursing', '11 Years', 'active', '2026-08-24 06:10:02'),
(493, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Jyoti Gupta', 'Associate Professor', 'M.Sc Nursing', '8 Years', 'active', '2026-08-24 06:10:02'),
(494, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Firoz Khan', 'Assistant Professor', 'M.Sc Nursing', '11 Years', 'active', '2026-08-24 06:10:02'),
(495, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Ambika Gupta', 'Assistant Professor', 'M.Sc Nursing', '9 Years', 'active', '2026-08-24 06:10:02'),
(496, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Yaminee Khooke', 'Assistant Professor', 'M.Sc Nursing', '2 Years', 'active', '2026-08-24 06:10:02'),
(497, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Pravesh Shukla', 'Assistant Professor', 'M.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(498, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Mradula Patel', 'Assistant Professor', 'M.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(499, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Laxmi Verma', 'Assistant Professor', 'M.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(500, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Sarita Rajak', 'Assistant Lecturer', 'M.Sc Nursing', '2 Years', 'active', '2026-08-24 06:10:02'),
(501, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Savita Malviya', 'Assistant Lecturer', 'M.Sc Nursing', '2.5 Years', 'active', '2026-08-24 06:10:02'),
(502, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Neha Vishwakarma', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(503, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Anisha', 'Nursing Tutor', 'B.Sc Nursing', '4 Years', 'active', '2026-08-24 06:10:02'),
(504, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Aditi Mishra', 'Nursing Tutor', 'B.Sc Nursing', '4 Years', 'active', '2026-08-24 06:10:02'),
(505, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Sumitra', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(506, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Monika Vishwakarma', 'Nursing Tutor', 'B.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(507, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Sweety Phalke', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(508, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Ayush Thomas', 'Nursing Tutor', 'B.Sc Nursing', '1.5 Years', 'active', '2026-08-24 06:10:02'),
(509, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Nisha Mishra', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(510, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Yogeeta', 'Nursing Tutor', 'B.Sc Nursing', '4 Years', 'active', '2026-08-24 06:10:02'),
(511, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ma. Laxmi Dhote', 'Nursing Tutor', 'B.Sc Nursing', '4 Years', 'active', '2026-08-24 06:10:02'),
(512, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Sonali Uprale', 'Nursing Tutor', 'B.Sc Nursing', '2.5 Years', 'active', '2026-08-24 06:10:02'),
(513, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Kirti Karosiya', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(514, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Nilesh', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(515, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Amit Kumar', 'Nursing Tutor', 'B.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(516, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Surya Radhakrishan', 'Nursing Tutor', 'B.Sc Nursing', '2.5 Years', 'active', '2026-08-24 06:10:02'),
(517, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Omprakash', 'Nursing Tutor', 'B.Sc Nursing', '2.5 Years', 'active', '2026-08-24 06:10:02'),
(518, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Beenu Vishwakarma', 'Nursing Tutor', 'B.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(519, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Dolly Patoniya', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(520, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Jyotsana Kallet', 'Nursing Tutor', 'B.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(521, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Yogeshwari Sujane', 'Nursing Tutor', 'B.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(522, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Roshni Vishwakarma', 'Nursing Tutor', 'B.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(523, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Rehnumma Anjum', 'Nursing Tutor', 'B.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(524, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Surbhi Sahu', 'Nursing Tutor', 'B.Sc Nursing', '9 Years', 'active', '2026-08-24 06:10:02'),
(525, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Leena Dongre', 'Nursing Tutor', 'B.Sc Nursing', '2.3 Years', 'active', '2026-08-24 06:10:02'),
(526, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Anjali Soni', 'Nursing Tutor', 'B.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(527, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Avantika Soni', 'Nursing Tutor', 'B.Sc Nursing', '2.3 Years', 'active', '2026-08-24 06:10:02'),
(528, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Akansha Chourasiya', 'Nursing Tutor', 'B.Sc Nursing', '5 Years', 'active', '2026-08-24 06:10:02'),
(529, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Illiyash', 'Nursing Tutor', 'B.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(530, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Ritu Vishwakarma', 'Nursing Tutor', 'B.Sc Nursing', '1.5 Years', 'active', '2026-08-24 06:10:02'),
(531, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Prachi Mehto', 'Nursing Tutor', 'B.Sc Nursing', '8 Months', 'active', '2026-08-24 06:10:02'),
(532, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Soniya Kanojiya', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(533, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Gemeshwari Nagotra', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(534, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Priya Yadav', 'Nursing Tutor', 'B.Sc Nursing', '5 Years', 'active', '2026-08-24 06:10:02'),
(535, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Varsha Koli', 'Nursing Tutor', 'B.Sc Nursing', '1.9 Years', 'active', '2026-08-24 06:10:02'),
(536, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Rakhee Arya', 'Nursing Tutor', 'B.Sc Nursing', '1.9 Years', 'active', '2026-08-24 06:10:02'),
(537, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Khushboo Bhawarkar', 'Nursing Tutor', 'B.Sc Nursing', '2.5 Years', 'active', '2026-08-24 06:10:02'),
(538, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Shakshi Teotia', 'Nursing Tutor', 'B.Sc Nursing', '2.5 Years', 'active', '2026-08-24 06:10:02'),
(539, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Komal Ahirwar', 'Nursing Tutor', 'B.Sc Nursing', '2.5 Years', 'active', '2026-08-24 06:10:02'),
(540, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Anjana Kushwaha', 'Nursing Tutor', 'B.Sc Nursing', '1.8 Years', 'active', '2026-08-24 06:10:02'),
(541, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Abha Tiwari', 'Nursing Tutor', 'B.Sc Nursing', '1.8 Years', 'active', '2026-08-24 06:10:02'),
(542, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Anand', 'Nursing Tutor', 'B.Sc Nursing', '1.6 Years', 'active', '2026-08-24 06:10:02'),
(543, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Suman Mishra', 'Nursing Tutor', 'B.Sc Nursing', '3.5 Years', 'active', '2026-08-24 06:10:02'),
(544, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Sushant Kumar', 'Nursing Tutor', 'B.Sc Nursing', '1.5 Years', 'active', '2026-08-24 06:10:02'),
(545, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Rahul Kumar', 'Nursing Tutor', 'B.Sc Nursing', '2.5 Years', 'active', '2026-08-24 06:10:02'),
(546, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Pradeep Chouhan', 'Nursing Tutor', 'B.Sc Nursing', '1.5 Years', 'active', '2026-08-24 06:10:02'),
(547, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Abhishek Sharma', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(548, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Sunanda Dhurve', 'Nursing Tutor', 'B.Sc Nursing', '1.5 Years', 'active', '2026-08-24 06:10:02'),
(549, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Vaishali Meshram', 'Nursing Tutor', 'B.Sc Nursing', '1.5 Years', 'active', '2026-08-24 06:10:02'),
(550, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Sonam Mishra', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(551, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Pratigya Singh', 'Nursing Tutor', 'B.Sc Nursing', '2 Years', 'active', '2026-08-24 06:10:02'),
(552, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Priya Sahu', 'Nursing Tutor', 'B.Sc Nursing', '1.5 Years', 'active', '2026-08-24 06:10:02'),
(553, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Sonali Kashyap', 'Nursing Tutor', 'B.Sc Nursing', '3 Years', 'active', '2026-08-24 06:10:02'),
(554, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Deepika Chourasiya', 'Nursing Tutor', 'B.Sc Nursing', '4.5 Years', 'active', '2026-08-24 06:10:02'),
(555, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Roshni Pandit', 'Nursing Tutor', 'B.Sc Nursing', '1.5 Years', 'active', '2026-08-24 06:10:02'),
(556, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Surbhi Panthi', 'Nursing Tutor', 'B.Sc Nursing', '1.2 Years', 'active', '2026-08-24 06:10:02'),
(557, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr. Anil Pandit', 'Nursing Tutor', 'B.Sc Nursing', '1.8 Years', 'active', '2026-08-24 06:10:02'),
(558, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Ranoo', 'Nursing Tutor', 'B.Sc Nursing', '4 Years', 'active', '2026-08-24 06:10:02'),
(559, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Acharya Omdevi', 'Nursing Tutor', 'B.Sc Nursing', '2 Years', 'active', '2026-08-24 06:10:02'),
(560, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Priya Bobde', 'Nursing Tutor', 'B.Sc Nursing', '2 Years', 'active', '2026-08-24 06:10:02'),
(561, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Vaishali Lokhande', 'Nursing Tutor', 'B.Sc Nursing', '2.2 Years', 'active', '2026-08-24 06:10:02'),
(562, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Mr Rishab', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(563, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Bharti Sahu', 'Nursing Tutor', 'Post Basic B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(564, 'RKDF College of Nursing (2003)', 'rkdf-college-of-nursing-2003-', 'Ms. Roshani Sahu', 'Nursing Tutor', 'B.Sc Nursing', '1 Year', 'active', '2026-08-24 06:10:02'),
(565, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Dr Nishi Prakash Jain', 'Principal', 'M.Pharm, PhD', '19 Years', 'active', '2026-08-24 06:10:02'),
(566, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Amrita Bhaiji', 'Associate Professor', 'M.Pharm', '7 Years', 'active', '2026-08-24 06:10:02'),
(567, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Ankita Chourasiya', 'Assistant Professor', 'M.Pharm', '3 Years', 'active', '2026-08-24 06:10:02'),
(568, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Balveer Singh Kirar', 'Associate Professor', 'M.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(569, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Devendra Chouhan', 'Associate Professor', 'M.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(570, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Devendra Bakoriya', 'Assistant Professor', 'M.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(571, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Devendra Mahale', 'Assistant Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(572, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Diksharaja Bundela', 'Assistant Professor', 'M.Pharm', '3 Years', 'active', '2026-08-24 06:10:02'),
(573, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Govind Nagar', 'Assistant Professor', 'M.Pharm', '11 Years', 'active', '2026-08-24 06:10:02'),
(574, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Kanchan Makode', 'Assistant Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(575, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Karan Kumar', 'Assistant Professor', 'M.Pharm', '3 Years', 'active', '2026-08-24 06:10:02'),
(576, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Ketki Mandawar', 'Associate Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(577, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Kinza Khan', 'Assistant Professor', 'M.Pharm', '1 Year', 'active', '2026-08-24 06:10:02'),
(578, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Dr Manisha Tandon', 'Professor', 'M.Pharm, PhD', '18 Years', 'active', '2026-08-24 06:10:02'),
(579, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Neha Jain', 'Associate Professor', 'M.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(580, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Parvej Ali', 'Assistant Professor', 'M.Pharm', '1 Year', 'active', '2026-08-24 06:10:02'),
(581, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Pawan Kumar Ahirwar', 'Assistant Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(582, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Prashant Bakoriya', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(583, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Praveen Kumar', 'Assistant Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(584, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Pushpendra Singh', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(585, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Rajshree Nema', 'Assistant Professor', 'M.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(586, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Rishabh Shukla', 'Associate Professor', 'M.Pharm', '8 Years', 'active', '2026-08-24 06:10:02'),
(587, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Rishiraj Dwedi', 'Assistant Professor', 'M.Pharm', '8 Years', 'active', '2026-08-24 06:10:02'),
(588, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Rohit Soni', 'Assistant Professor', 'M.Pharm', '8 Years', 'active', '2026-08-24 06:10:02'),
(589, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Safdar Hasan Qureshi', 'Associate Professor', 'M.Pharm', '8 Years', 'active', '2026-08-24 06:10:02'),
(590, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Sakti Rani Chourasiya', 'Associate Professor', 'M.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(591, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Sandeep Patel', 'Associate Professor', 'M.Pharm', '7 Years', 'active', '2026-08-24 06:10:02'),
(592, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Vandna Athiya', 'Assistant Professor', 'M.Pharm', '1 Year', 'active', '2026-08-24 06:10:02'),
(593, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Vibha Devi', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(594, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Vibha Pathak', 'Assistant Professor', 'M.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(595, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Vikash Soni', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(596, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Vivek Patel', 'Associate Professor', 'M.Pharm', '11 Years', 'active', '2026-08-24 06:10:02'),
(597, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Vivek Shrivastava', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(598, 'RKDF College of Pharmacy (1995)', 'rkdf-college-of-pharmacy-1995-', 'Yogesh Singh Thakur', 'Assistant Professor', 'M.Pharm', '3 Years', 'active', '2026-08-24 06:10:02'),
(599, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Dr. Prashant Soni', 'Principal', 'MPH, Ph.D', '15 Years', 'active', '2026-08-24 06:10:02'),
(600, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Supyar Singh', 'Associate Professor', 'M.Pharm', '7 Years', 'active', '2026-08-24 06:10:02'),
(601, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Paridhi Thakur', 'Associate Professor', 'M.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(602, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Mohammad Danish Ishtiyak', 'Assistant Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(603, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Sonika Uprale', 'Assistant Professor', 'M.Pharm', '4.5 Years', 'active', '2026-08-24 06:10:02'),
(604, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Amit Nagar', 'Assistant Professor', 'M.Pharm', '7 Years', 'active', '2026-08-24 06:10:02'),
(605, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Papiya Ghosh', 'Assistant Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(606, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Ashish Meithil', 'Assistant Professor', 'M.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(607, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Prity Singh', 'Assistant Professor', 'M.Pharm', '8 Months', 'active', '2026-08-24 06:10:02'),
(608, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Satyam Kauray', 'Assistant Professor', 'M.Pharm', '1 Year', 'active', '2026-08-24 06:10:02'),
(609, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Kuldeep Jhariya', 'Assistant Professor', 'M.Pharm', '3 Years', 'active', '2026-08-24 06:10:02'),
(610, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Arvind Nagar', 'Assistant Professor', 'M.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(611, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Shalini Singh', 'Assistant Professor', 'B.Pharm', '1 Year', 'active', '2026-08-24 06:10:02'),
(612, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Atul Sahu', 'Assistant Professor', 'M.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(613, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Trilok Chand', 'Assistant Professor', 'M.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(614, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Rohit Selkari', 'Assistant Professor', 'M.Pharm', '3 Years', 'active', '2026-08-24 06:10:02'),
(615, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Antim Shobha Chandrashekhar', 'Assistant Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(616, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Nitesh Kumar', 'Assistant Professor', 'M.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(617, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Rakesh Kaushal', 'Assistant Professor', 'M.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(618, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Bhagwan Das Gour', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(619, 'Dr. APJ Abdul Kalam College of Pharmacy (2018)', 'dr-apj-abdul-kalam-college-of-pharmacy-2018-', 'Shubha Jain', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(620, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Dr. Rishikesh Sharma', 'Principal', 'PhD, M.Pharm', '18.3 Years', 'active', '2026-08-24 06:10:02'),
(621, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Dr. Atul Kumar Kathiriya', 'Professor', 'PhD, M.Pharm', '18.2 Years', 'active', '2026-08-24 06:10:02'),
(622, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Narendra Bhumarkar', 'Assistant Professor', 'M.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(623, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Vikram Singh Bais', 'Assistant Professor', 'M.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(624, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Ankita Yadav', 'Assistant Professor', 'M.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(625, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Faimida Jahan', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(626, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Harikishor Barange', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(627, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Shubham Saxena', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(628, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Anjali Khateek', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(629, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Ashish Kumar Pal', 'Assistant Professor', 'M.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(630, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Abhishek Rajak', 'Assistant Professor', 'B.Pharm', '6 Months', 'active', '2026-08-24 06:10:02'),
(631, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Prema Dadore', 'Assistant Professor', 'M.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(632, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Akhilesh Jagdev', 'Assistant Professor', 'B.Pharm', '4 Years', 'active', '2026-08-24 06:10:02'),
(633, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Preeti Devedi', 'Assistant Professor', 'M.Pharm', '6 Months', 'active', '2026-08-24 06:10:02'),
(634, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Praful M Sahare', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(635, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Indrajit Shah', 'Assistant Professor', 'B.Pharm', '6 Months', 'active', '2026-08-24 06:10:02'),
(636, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Sheetal Nagar', 'Assistant Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(637, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Ved Sindhu', 'Assistant Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(638, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Sujata Thakur', 'Assistant Professor', 'B.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(639, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Ayush Laskan', 'Assistant Professor', 'B.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(640, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Heena Adey', 'Assistant Professor', 'B.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(641, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Babita Banke', 'Assistant Professor', 'M.Pharm', '5 Years', 'active', '2026-08-24 06:10:02'),
(642, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Durgesh Thakre', 'Assistant Professor', 'M.Pharm', '4 Months', 'active', '2026-08-24 06:10:02'),
(643, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Arvind Prajapati', 'Assistant Professor', 'B.Pharm', '6 Months', 'active', '2026-08-24 06:10:02'),
(644, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Arun Dhote', 'Assistant Professor', 'M.Pharm', '2 Years', 'active', '2026-08-24 06:10:02'),
(645, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Poonam Sahu', 'Assistant Professor', 'B.Pharm', '4 Months', 'active', '2026-08-24 06:10:02'),
(646, 'Sarvepalli Radhakrishnan College of Pharmacy (2018)', 'sarvepalli-radhakrishnan-college-of-pharmacy-2018-', 'Bhupesh Singh Shahi', 'Assistant Professor', 'M.Pharm', '6 Years', 'active', '2026-08-24 06:10:02'),
(647, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Dr. Ruchi Chaubey', 'Principal', 'Ph.D', '18 Years', 'active', '2026-08-24 06:10:02'),
(648, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Sourabh Soni', 'Assistant Professor', 'M.Pharmacy', '3 Years', 'active', '2026-08-24 06:10:02'),
(649, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Jatin Soni', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(650, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Priyanka Narvare', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(651, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Akshay Chandravamnshi', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(652, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Vandana Pali', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(653, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Sudipta Dakua', 'Assistant Professor', 'M.Pharmacy', '3 Years', 'active', '2026-08-24 06:10:02'),
(654, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Rajni Rawat', 'Assistant Professor', 'M.Pharmacy', '7 Years', 'active', '2026-08-24 06:10:02'),
(655, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Gajendra Solanki', 'Assistant Professor', 'M.Pharmacy', '6 Years', 'active', '2026-08-24 06:10:02'),
(656, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Md Shabhaj Siddique', 'Assistant Professor', 'M.Pharmacy', '3 Years', 'active', '2026-08-24 06:10:02'),
(657, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Praveen Padlak', 'Assistant Professor', 'M.Pharmacy', '7 Years', 'active', '2026-08-24 06:10:02'),
(658, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Rashmita Sharma', 'Assistant Professor', 'M.Pharmacy', '3 Years', 'active', '2026-08-24 06:10:02'),
(659, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Neelesh Vishwakarma', 'Assistant Professor', 'M.Pharmacy', '4 Years', 'active', '2026-08-24 06:10:02'),
(660, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Abhay Kushwaha', 'Assistant Professor', 'M.Pharmacy', '4 Years', 'active', '2026-08-24 06:10:02'),
(661, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Anand Patel', 'Assistant Professor', 'M.Pharmacy', '3 Years', 'active', '2026-08-24 06:10:02'),
(662, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Sunil Kushwaha', 'Assistant Professor', 'M.Pharmacy', '4 Years', 'active', '2026-08-24 06:10:02'),
(663, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Priya Yadav', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(664, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Ankita Domde', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(665, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Rajkumar Jaishwal', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(666, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Ekta Vijay Kunte', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(667, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Deepak Kumar Singh', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(668, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Naphis Ahmad', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(669, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Sourabh Rathore', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(670, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Ashish Chandravanshi', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(671, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Aruna Kushwaha', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(672, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Sheikh Mohammad', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(673, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Himanshu Malviya', 'Assistant Professor', 'M.Pharmacy', '1 Year', 'active', '2026-08-24 06:10:02'),
(674, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Mukesh Parmar', 'Lecturer', 'B.Pharmacy', '2 Years', 'active', '2026-08-24 06:10:02'),
(675, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Ramanuj Koul', 'Lecturer', 'B.Pharmacy', '2 Years', 'active', '2026-08-24 06:10:02'),
(676, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Anshul Jain', 'Lecturer', 'B.Pharmacy', '4 Years', 'active', '2026-08-24 06:10:02'),
(677, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Hemlata Pawar', 'Lecturer', 'B.Pharmacy', '3 Years', 'active', '2026-08-24 06:10:02'),
(678, 'Sri Sai College of Pharmacy (2019)', 'sri-sai-college-of-pharmacy-2019-', 'Balram Nagesh', 'Lecturer', 'B.Pharmacy', '4 Years', 'active', '2026-08-24 06:10:02'),
(679, 'RKDF Polytechnic Pharmacy', 'rkdf-polytechnic-pharmacy', 'Dr. Pratyush Jain', 'Principal', 'Ph.D', '12 Years', 'active', '2026-08-24 06:10:02'),
(680, 'RKDF Polytechnic Pharmacy', 'rkdf-polytechnic-pharmacy', 'Mr. Viren Rupareal', 'Assistant Professor', 'M.Pharmacy', '4 Years', 'active', '2026-08-24 06:10:02'),
(681, 'RKDF Polytechnic Pharmacy', 'rkdf-polytechnic-pharmacy', 'Mr. Shubham Thakur', 'Assistant Professor', 'M.Pharmacy', '4 Years', 'active', '2026-08-24 06:10:02'),
(682, 'RKDF Polytechnic Pharmacy', 'rkdf-polytechnic-pharmacy', 'Mrs. Seema Sahu', 'Assistant Professor', 'M.Pharmacy', '2 Years', 'active', '2026-08-24 06:10:02'),
(683, 'RKDF Polytechnic Pharmacy', 'rkdf-polytechnic-pharmacy', 'Mr. Vinit Katre', 'Lecturer', 'B.Pharmacy', '4 Years', 'active', '2026-08-24 06:10:02'),
(684, 'RKDF Polytechnic Pharmacy', 'rkdf-polytechnic-pharmacy', 'Mr. Ravikant Kurmi', 'Lecturer', 'B.Pharmacy', '5 Years', 'active', '2026-08-24 06:10:02'),
(685, 'RKDF Polytechnic Pharmacy', 'rkdf-polytechnic-pharmacy', 'Mr. Rahul K. Gupta', 'Lecturer', 'B.Pharmacy', '2 Years', 'active', '2026-08-24 06:10:02'),
(686, 'RKDF Polytechnic Pharmacy', 'rkdf-polytechnic-pharmacy', 'Mrs. Neha Sharma', 'Lecturer', 'B.Pharmacy', '6 Years', 'active', '2026-08-24 06:10:02'),
(687, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Raghuveer Singh', 'Assistant Professor', 'LLB, LLM', '4 Years', 'active', '2026-08-24 06:10:02'),
(688, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Anand Chack', 'Assistant Professor', 'BALLB, LLM', '4 Years', 'active', '2026-08-24 06:10:02'),
(689, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Pragya Singh', 'Assistant Professor', 'BALLB, LLM, PhD', '6 Years', 'active', '2026-08-24 06:10:02'),
(690, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Pavitra Lalji', 'Assistant Professor', 'BALLB, LLM', '4 Years', 'active', '2026-08-24 06:10:02'),
(691, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Preeti Pushpad', 'Assistant Professor', 'LLB, LLM', '2 Years', 'active', '2026-08-24 06:10:02'),
(692, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Asha Majhi', 'Assistant Professor', 'LLB, LLM', '12 Years', 'active', '2026-08-24 06:10:02'),
(693, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Subhash Panchal', 'Assistant Professor', 'BALLB, LLM', '4 Years', 'active', '2026-08-24 06:10:02'),
(694, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Bhishm Dehariya', 'Assistant Professor', 'BALLB, LLM', '6 Years', 'active', '2026-08-24 06:10:02'),
(695, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Akash K Upadhyay', 'Assistant Professor', 'LLB, LLM', '6 Years', 'active', '2026-08-24 06:10:02'),
(696, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Rohit Swarnkar', 'Associate Professor', 'LLB, LLM, PhD', '19 Years', 'active', '2026-08-24 06:10:02'),
(697, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Shailendra Singh', 'Assistant Professor', 'BALLB, LLM, NET', '5 Years', 'active', '2026-08-24 06:10:02'),
(698, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Prakhar Sharma', 'Assistant Professor', 'BALLB, LLM', '4 Years', 'active', '2026-08-24 06:10:02'),
(699, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Prachi Thakre', 'Assistant Professor', 'BALLB, LLM', '4 Years', 'active', '2026-08-24 06:10:02'),
(700, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Ragini Soni', 'Assistant Professor', 'LLB, LLM', '7 Years', 'active', '2026-08-24 06:10:02'),
(701, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Surbhi Singh', 'Associate Professor', 'MA, PhD', '8 Years', 'active', '2026-08-24 06:10:02'),
(702, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'K Samy', 'Associate Professor', 'PhD English', '24 Years', 'active', '2026-08-24 06:10:02'),
(703, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Alka Tiwai', 'Associate Professor', 'PhD Hindi', '15 Years', 'active', '2026-08-24 06:10:02'),
(704, 'Sarvepalli Radhakrishnan College of Law (2019)', 'sarvepalli-radhakrishnan-college-of-law-2019-', 'Shailendra Arya', 'Associate Professor', 'MA, LLM', '8 Years', 'active', '2026-08-24 06:10:02'),
(1002, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Rajbala Dubey', 'Professor', 'MD (HOM.)', '25 Years 1 Month', 'active', '2026-08-24 06:10:03'),
(1003, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Renu Gupta', 'Professor', 'MD (HOM.)', '16 Years 3 Months', 'active', '2026-08-24 06:10:03'),
(1004, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Pooja Sonker', 'Reader', 'MD (HOM.)', '11 Years 4 Months', 'active', '2026-08-24 06:10:03'),
(1005, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Sandesh Pawar', 'Reader', 'MD (HOM.)', '5 Years 6 Months', 'active', '2026-08-24 06:10:03'),
(1006, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Rajendra Dubey', 'Lecturer', 'BHMS', '12 Years 8 Months', 'active', '2026-08-24 06:10:03'),
(1007, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Baviskar Ujwala Somanath', 'Lecturer', 'MD (HOM.)', '3 Years 4 Months', 'active', '2026-08-24 06:10:03'),
(1008, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Anil Kumar Shrivastava', 'Professor', 'MD (HOM.)', '34 Years 8 Months', 'active', '2026-08-24 06:10:03'),
(1009, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Malti Nagar', 'Professor', 'MD (HOM.)', '7 Years 6 Months', 'active', '2026-08-24 06:10:03'),
(1010, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Indu Yaduvanshi', 'Reader', 'MD (HOM.)', '4 Years', 'active', '2026-08-24 06:10:03'),
(1011, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Kalpana Bopche', 'Lecturer', 'BHMS', '12 Years 3 Months', 'active', '2026-08-24 06:10:03'),
(1012, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Garima Singh', 'Lecturer', 'MD (HOM.)', '8 Months', 'active', '2026-08-24 06:10:03'),
(1013, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Kriti Srivastava', 'Lecturer', 'MD (HOM.)', '1 Month', 'active', '2026-08-24 06:10:03'),
(1014, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Devenndra Dhote', 'Professor', 'MD (HOM.)', '23 Years 3 Months', 'active', '2026-08-24 06:10:03'),
(1015, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Sumit Modh', 'Professor', 'MD (HOM.)', '18 Years 2 Months', 'active', '2026-08-24 06:10:03'),
(1016, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Kiran Singh', 'Lecturer', 'MD (HOM.)', '2 Years 10 Months', 'active', '2026-08-24 06:10:03'),
(1017, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Vishal Kumar Singh', 'Lecturer', 'MD (HOM.)', '2 Years 11 Months', 'active', '2026-08-24 06:10:03'),
(1018, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Anamika Mishra', 'Lecturer', 'MD (HOM.)', '1 Month', 'active', '2026-08-24 06:10:03'),
(1019, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Chanchal Kumar Jain', 'Professor', 'MD (HOM.)', '22 Years 10 Months', 'active', '2026-08-24 06:10:03'),
(1020, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Mayur Gajre', 'Reader', 'MD (HOM.)', '5 Years 7 Months', 'active', '2026-08-24 06:10:03'),
(1021, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Taksande Takshashila', 'Reader', 'MD (HOM.)', '1 Year 4 Months', 'active', '2026-08-24 06:10:03'),
(1022, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Shaikh Gaushia', 'Lecturer', 'MD (HOM.)', '1 Year 4 Months', 'active', '2026-08-24 06:10:03'),
(1023, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Gunjan Panday', 'Lecturer', 'MD (HOM.)', '6 Months', 'active', '2026-08-24 06:10:03'),
(1024, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Ruchita Gupta', 'Lecturer', 'MD (HOM.)', '6 Months', 'active', '2026-08-24 06:10:03'),
(1025, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Sachin Kumar Dadore', 'Lecturer', 'MD (HOM.)', '7 Months', 'active', '2026-08-24 06:10:03'),
(1026, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Nisha Singh', 'Lecturer', 'MD (HOM.)', '6 Months', 'active', '2026-08-24 06:10:03'),
(1027, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Harish Kumar Tuli', 'Professor', 'MD (HOM.)', '17 Years 1 Month', 'active', '2026-08-24 06:10:03'),
(1028, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Anshu Sharma', 'Lecturer', 'MD (HOM.)', '2 Years 6 Months', 'active', '2026-08-24 06:10:03'),
(1029, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Rajeev Gupta', 'Professor', 'BHMS', '23 Years 4 Months', 'active', '2026-08-24 06:10:03'),
(1030, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Meenakshi Chopra', 'Reader', 'BHMS', '11 Years 9 Months', 'active', '2026-08-24 06:10:03'),
(1031, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Khurshid Aalam', 'Professor', 'BHMS', '17 Years 6 Months', 'active', '2026-08-24 06:10:03'),
(1032, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Rajee Jain', 'Reader', 'MD (HOM.)', '10 Years 10 Months', 'active', '2026-08-24 06:10:03'),
(1033, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Susheela N. Choudhary', 'Professor & Principal', 'MD (HOM.)', '17 Years 10 Months', 'active', '2026-08-24 06:10:03'),
(1034, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Amita Goyanar', 'Lecturer', 'MD (HOM.)', '4 Years', 'active', '2026-08-24 06:10:03'),
(1035, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. A.D. Khan', 'Professor', 'MD (HOM.)', '24 Years 1 Month', 'active', '2026-08-24 06:10:03'),
(1036, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Amit Chaturvedi', 'Reader', 'MD (HOM.)', '12 Years 11 Months', 'active', '2026-08-24 06:10:03'),
(1037, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Ishrat Azam', 'Professor', 'MD (HOM.)', '12 Years 11 Months', 'active', '2026-08-24 06:10:03'),
(1038, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Sudheer Bheem Gupta', 'Lecturer', 'MD (HOM.)', '3 Months', 'active', '2026-08-24 06:10:03'),
(1039, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Shashindra Kumar Sharma', 'Professor', 'MD (HOM.)', '23 Years 4 Months', 'active', '2026-08-24 06:10:03'),
(1040, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Bharat Kumar Choudhary', 'Professor', 'MD (HOM.)', '11 Years 4 Months', 'active', '2026-08-24 06:10:03'),
(1041, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Piyusha Mundhada', 'Reader', 'MD (HOM.)', '7 Years 7 Months', 'active', '2026-08-24 06:10:03'),
(1042, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Nitin Goyal', 'Lecturer', 'MD (HOM.)', '6 Months', 'active', '2026-08-24 06:10:03'),
(1043, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Neha Patel', 'Lecturer', 'MD (HOM.)', '2 Years 2 Months', 'active', '2026-08-24 06:10:03');
INSERT INTO `faculty` (`id`, `department_name`, `dept_slug`, `name`, `designation`, `qualification`, `experience`, `status`, `created_at`) VALUES
(1044, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Shendre Trupti Prabhakar', 'Lecturer', 'MD (HOM.)', '3 Years 3 Months', 'active', '2026-08-24 06:10:03'),
(1045, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Arvind Gupta', 'Reader', 'BHMS', '15 Years 5 Months', 'active', '2026-08-24 06:10:03'),
(1046, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Anushree Nandi', 'Lecturer', 'MD (HOM.)', '1 Month', 'active', '2026-08-24 06:10:03'),
(1047, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Bhagyalaxmi', 'Reader', 'MD (HOM.)', '5 Years 9 Months', 'active', '2026-08-24 06:10:03'),
(1048, 'RKDF Homoeopathic Medical College Hospital & Research Centre (2000)', 'rkdf-homoeopathic-medical-college-hospital-research-centre-2000-', 'Dr. Angad Pyarelal Gupta', 'Lecturer', 'MD (HOM.)', '3 Months', 'active', '2026-08-24 06:10:03'),
(1049, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Mr. Nasir Mirza', 'Assistant Professor', '', NULL, 'active', '2026-08-26 07:51:01'),
(1050, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Ms. Neha Bhargava', 'Professor', '', NULL, 'active', '2026-08-26 07:51:01'),
(1051, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Mr. Anirban Mitra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1052, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Mr. Vivek Patel', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1053, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Mr. Shravan Kumar Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1054, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Mr. Sourabh Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1055, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Mr. Pratik Vyas', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1056, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Mr. Rupal Khatri', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1057, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Mr. Vipin Vinchurkar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1058, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Dr. Pragya Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1059, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Ms. Varsha Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1060, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Ms. Nikita Nikita', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1061, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Mr. Shivnath Raghuwanshi', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1062, 'RKDF Institute of Business Management', 'rkdf-institute-of-business-management-2006-', 'Ms. Jaanvi Satankar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1063, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Mr. Shiv Tiwari', 'Assistant Professor', '', NULL, 'active', '2026-08-26 07:51:01'),
(1064, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Dr. Narbada Prasad Gour', 'Professor', '', NULL, 'active', '2026-08-26 07:51:01'),
(1065, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Dr. Natarajan Subburaj', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1066, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Dr. R. Pattabiraman', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1067, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Ms. Priyanka Bar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1068, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Mr. Singh Gyan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1069, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Ms. Jyoti Dwivedi', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1070, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Mr. Sumit Sahu', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1071, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Mr. Prashant Patel', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1072, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Ms. Divya Tiwari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1073, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Mr. Jitendra Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1074, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Mr. Deepak Kumar Dhakad', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1075, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Ms. Ankita Agnihotri', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1076, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Ms. Reena Jamliya', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1077, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Ms. Shaivya Saraf', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1078, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Dr. Peeyush Upadhyay', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1079, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Mr. Shubham Gour', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1080, 'RKDF Institute of Management', 'rkdf-institute-of-management-2003-', 'Dr. Sushil Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1081, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Dr. Varsha Namdeo', 'Professor', '', NULL, 'active', '2026-08-26 07:51:01'),
(1082, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Rambabu Baretha', 'Assistant Professor', '', NULL, 'active', '2026-08-26 07:51:01'),
(1083, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Ms. Kirti Davande', 'Associate Professor', '', NULL, 'active', '2026-08-26 07:51:01'),
(1084, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Dr. Yasmeen Kosar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1085, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Raj Meena', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1086, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Narendra Kumar Jain', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1087, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Nagendra Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1088, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Jitendra Bansal', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1089, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Girjesh Shakya', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1090, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Deepak Gupta', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1091, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Prashant Gehlot', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1092, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Pravin Verma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1093, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Ms. Bhavna Chouksey', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1094, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Rahgvendra Sahu', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1095, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Harsh Gour', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1096, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Ms. Deepa Patel', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1097, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Rahul Gour', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1098, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Nisha Raghuwanshi', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1099, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Jayrambhai Punjabhai Suthar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1100, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Sayed Ansari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1101, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Tushar Tushar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1102, 'RKDF Institute of Science and Technology - MCA', 'rkdf-institute-of-science-and-technology---mca-1999-', 'Mr. Nitesh Kumar Deshmukh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1103, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ritesh Khatarkar', 'Assistant Professor', '', NULL, 'active', '2026-08-26 07:51:01'),
(1104, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Himanshu Shekhar', 'Professor', '', NULL, 'active', '2026-08-26 07:51:01'),
(1105, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Chinmay Bhatt', 'Associate Professor', '', NULL, 'active', '2026-08-26 07:51:01'),
(1106, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Daya Shankar Pandey', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1107, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Santosh Singh Negi', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1108, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Vijay Kumar Eda', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1109, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Deep Mala', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1110, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Ritesh Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1111, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Ravindra Gupta', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1112, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mrs. Rajani B Gupta', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1113, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Amritansh Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1114, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kuldeep Bharti', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1115, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Sachin Bhatt', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1116, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Akshay Kumar Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1117, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Miss Trapti Mala Mishra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1118, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Nitin Kumar Pithwa', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1119, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Hemendra Nandan Hemendra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1120, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ajay Vishwakarma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1121, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vishal Diwakar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1122, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Anil Singh Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1123, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rahul Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1124, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sanjay Deshmukh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1125, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vivek Shukla', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1126, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vijay Bahadur Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1127, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Bharti Chourasia', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1128, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Jyoti Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1129, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Miss Ayushee Bhardwaj', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1130, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Namrata Jain', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1131, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Jamshed Ahmad', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1132, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Akhilesh Kushwaha', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1133, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Shyam Sunder Pawar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1134, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Bhanu Pandole', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1135, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Mohd Akhtar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1136, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ajay Sisodia', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1137, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Gourav Sonare', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1138, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Abhijeet Patil', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1139, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Nidhi Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1140, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rakesh Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1141, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Prabhat Datt Mishra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1142, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ashutosh Patel', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1143, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Mohd Hanzala', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1144, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Shrikant Sudhanshu', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1145, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Binod Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1146, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Mahendra Chouda', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1147, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Shalini Lakhera', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1148, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rohit Sahu', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1149, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Lucky Sahu', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1150, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Mohini Mehra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1151, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Irshad Mansury', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1152, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Durga Mahalle', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1153, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Kulandai Samy', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1154, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Deepak Bharti', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1155, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Manjusha Morey', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1156, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Alka Dubey', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1157, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Abhijit Palit', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1158, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Jagveer Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1159, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sujeet Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1160, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Amit Rajan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1161, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Indrajeet Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1162, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Subhash Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1163, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kiran Chaudhari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1164, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Arvind Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1165, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sanjeev Acharya', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1166, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Deepak Mehra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1167, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Prajwal Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1168, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Aditya Dubey', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1169, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sudeep Das', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1170, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Anand Raj', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1171, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Prasun Singh Baghel', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1172, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Deepak Bhatia', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1173, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ajaykumar Mourya', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1174, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. MD Dilnawaz Hanzala', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1175, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Akash Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1176, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Yogesh Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1177, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rati Ranjan Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1178, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rahul Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1179, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Sonam Gupta', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1180, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Krishna Kant Goswami', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1181, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ashish Tripathi', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1182, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kanchan Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1183, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Bablu Gope', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1184, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Harihara Subramaniam Sankaran', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1185, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Muthusamy Sivakkumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1186, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Garima Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1187, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Varsha Jaish', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1188, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Manoj Kumar Chopra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1189, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Shubham Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1190, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Chhatrapal Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1191, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vishva Raj Joshi', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1192, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ravi Ranjan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1193, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Ekta Deshmukh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1194, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Abhinav Swarup', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1195, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Surbhi Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1196, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rajeev Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1197, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vishal Gour', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1198, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sanjeev Prakash Shrivastava', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1199, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Satyadev Singh Baghel', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1200, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kuldeep Gunwan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1201, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ajay Wankhere', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1202, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Megha Mishra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1203, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Mohammad Hasir', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1204, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Rashi Chaurasia', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1205, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Mohammad Parwez Alam', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1206, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Prachi Gupta', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1207, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Lagan Tiwari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1208, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Vandana Malve', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1209, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Pradeep Bhimraj Mendhekar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1210, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Manish Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1211, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kumar Nitesh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1212, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Suman Kumar Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1213, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Kanishka Sisodiya', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1214, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Tanvi Tomar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1215, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Pramod Dhurve', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1216, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Harshit Upadhyay', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1217, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ashutosh Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1218, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Allwyn Lakra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1219, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Archana Gupta', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1220, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Chitransh Verma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1221, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Surendra Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1222, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Jitendra Doulatram Jitendra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1223, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Nitish Bharadwoj', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1224, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kuldeep Khadeepure', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1225, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Sonam Shrivas', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1226, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Shubham Singh Thakur', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1227, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Nilesh Diwakar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1228, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Harsh Mishra', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1229, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ravindra Limaye', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1230, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Anoop Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1231, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Niresh Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1232, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rafi Ahmad', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1233, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Gopal Panda', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1234, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Richa Gupta', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1235, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Amit Pandey', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1236, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Girdhar Gopal Ladha', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1237, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vivek Kumar Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1238, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kamal Niwaria', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1239, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Aditya Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1240, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ravi Shankar Batham', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1241, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ajit Kumar Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1242, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rahul Bhangre', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1243, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vijay Patel', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1244, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Mukul Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1245, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vivek Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1246, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sourabh Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1247, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Aman Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1248, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Amar Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1249, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Harshita Agrawal', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1250, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Rupali Dehariya', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1251, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Deepti Patil', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1252, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Divya Pachori', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1253, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Nikhil Swarnkar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1254, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rahul Udeniya', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1255, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Prasant Vyas', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1256, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Priyanka Suresh Ganorkar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1257, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Mahendra Kumar Jhariya', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1258, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Chhotan Mahto', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1259, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Yogita Dubey', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1260, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ankur Khare', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1261, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sunil Kuril', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1262, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ravinra Raghuwanshi', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1263, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Arun Kumar Sing', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1264, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Shivam Dutt Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1265, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Zeeshan Ahmed', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1266, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sippu Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1267, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Pankaj Kumar Bharti', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1268, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Nirmal Singh Chouhan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1269, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Abrar Ahmed Ansari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1270, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Hardik Tayal', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1271, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Nitin Vishwakarma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1272, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Aamratash Shukla', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1273, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Neha Bhavasar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1274, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Miss Nidhi Gupta', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1275, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Lavlesh Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1276, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. MD Naim', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1277, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Afreen Sultana', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1278, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Rohit Swarnkar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1279, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Bhagyshri Khorgade', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1280, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Tanay Shah', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1281, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Amit Ramaiya', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1282, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Lav Kumar Sinha', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1283, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vikash Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1284, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Jyoti Tomar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1285, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Beauti Jain', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1286, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sonu Kirar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1287, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Gireesh Kamal Gautam', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1288, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rajendra Singh Dangi', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1289, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Amit Srivas', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1290, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Sweta Pathak', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1291, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Niharika Pare', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1292, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Abhay Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1293, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Shekh Sajid Khan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1294, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vivek Kumar Pippal', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1295, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sachin Khasdev', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1296, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Laxman Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1297, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Swapnil Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1298, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Palak Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1299, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sonal Kumar Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1300, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Rajrani Rani', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1301, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ajay Singh Patel', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1302, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Rudra Singh Chauhan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1303, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ankit Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1304, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Tanvi Deopujari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1305, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Lalit Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1306, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Piyush Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1307, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Pankaj Patidar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1308, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Jitendra Kumar Sah', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1309, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Ratnesh Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1310, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Prabhat Priyanshu', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1311, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Atul Kumar Gupta', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1312, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Krishn Kumar Khade', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1313, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Nayna Bhargava', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1314, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Manmohan Prajapati', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01');
INSERT INTO `faculty` (`id`, `department_name`, `dept_slug`, `name`, `designation`, `qualification`, `experience`, `status`, `created_at`) VALUES
(1315, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Priya Pandey', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1316, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Bhola Prasad Nai', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1317, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kapil Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1318, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mrs. Bindhya Pachori', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1319, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Lakhan Singh Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1320, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vijay Kumar Ingle', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1321, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mrs. Chandani Kalondia', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1322, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Prince Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1323, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. MD Asif Hussain', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1324, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Madhurendra Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1325, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Abhinav Prakash', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1326, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Shivam Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1327, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Rukmini Kumari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1328, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Onkar Nath Sabran', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1329, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Miss Varsha Tembhurne', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1330, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Dimapl Raikwar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1331, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kumar Rajeev Rajan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1332, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Chetan Manohar Patil', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1333, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Raj V Thaneeghaivel', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1334, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Abhay Yadave Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1335, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rahul Ranjan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1336, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kamlesh Kolhe', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1337, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Miss Sujata Kumari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1338, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Mithlesh Kumar Patel', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1339, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Mohit Sahu', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1340, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rupesh Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1341, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Satayam Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1342, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Neeraj Parashar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1343, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Animesh Dube', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1344, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Pradeep Chandra Nainwal', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1345, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Anusha Dube', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1346, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Maheshwari Sharma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1347, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Miss Priyadarshni Kumari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1348, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Kundan Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1349, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Miss Sangeeta Kumari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1350, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rakesh Kumar Singh', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1351, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Elangovan Kaliyamurthy', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1352, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Miss Puja Kumari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1353, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Shahil Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1354, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Anmol Dilip Mojad', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1355, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Yogesh Tiwari', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1356, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Abhilash Singh Role', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1357, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Arpn Samanta', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1358, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Shilp Sharan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1359, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rakesh Umre', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1360, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Sidharth Gagan', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1361, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mrs. Khushboo Bhatt', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1362, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Poonam Khatarkar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1363, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Dr. Greeni Greeni', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1364, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Shailendra Singh Yadav', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1365, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Hemant Mali', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1366, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Anant Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1367, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rahul Kumar', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1368, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Arun Mewada', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1369, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vishnu Vishnu', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1370, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Ms. Raksha Sahu', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1371, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Vipin Verma', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01'),
(1372, 'RKDF Institute of Science and Technology', 'rkdf-institute-of-science-and-technology-1995-', 'Mr. Rishitkumar Sureshkumar Goswami', 'Faculty Member', '', NULL, 'active', '2026-08-26 07:51:01');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'Campus',
  `image_url` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `category`, `image_url`, `created_at`) VALUES
(147, '', 'Campus', 'assets/uploads/gallery/webp/anf01537.webp', '2026-08-26 12:42:52'),
(148, '', 'Campus', 'assets/uploads/gallery/webp/anf01541.webp', '2026-08-26 12:42:52'),
(149, '', 'Campus', 'assets/uploads/gallery/webp/anf01545.webp', '2026-08-26 12:42:52'),
(150, '', 'Campus', 'assets/uploads/gallery/webp/dsc06364.webp', '2026-08-26 12:42:52'),
(151, '', 'Campus', 'assets/uploads/gallery/webp/dsc06366.webp', '2026-08-26 12:42:52'),
(152, '', 'Campus', 'assets/uploads/gallery/webp/dsc06367.webp', '2026-08-26 12:42:52'),
(153, '', 'Campus', 'assets/uploads/gallery/webp/dsc06368.webp', '2026-08-26 12:42:52'),
(154, '', 'Campus', 'assets/uploads/gallery/webp/dsc06373.webp', '2026-08-26 12:42:52'),
(155, '', 'Campus', 'assets/uploads/gallery/webp/dsc06380.webp', '2026-08-26 12:42:52'),
(156, '', 'Campus', 'assets/uploads/gallery/webp/dsc06381.webp', '2026-08-26 12:42:52'),
(157, '', 'Campus', 'assets/uploads/gallery/webp/dsc06383.webp', '2026-08-26 12:42:52'),
(158, '', 'Campus', 'assets/uploads/gallery/webp/dsc06384.webp', '2026-08-26 12:42:52'),
(159, '', 'Campus', 'assets/uploads/gallery/webp/dsc06387.webp', '2026-08-26 12:42:52'),
(160, '', 'Campus', 'assets/uploads/gallery/webp/dsc06388.webp', '2026-08-26 12:42:52'),
(161, '', 'Campus', 'assets/uploads/gallery/webp/dsc06492.webp', '2026-08-26 12:42:52'),
(162, '', 'Campus', 'assets/uploads/gallery/webp/dsc06493.webp', '2026-08-26 12:42:52'),
(163, '', 'Campus', 'assets/uploads/gallery/webp/dsc06495.webp', '2026-08-26 12:42:52'),
(164, '', 'Campus', 'assets/uploads/gallery/webp/dsc08499.webp', '2026-08-26 12:42:52'),
(165, '', 'Campus', 'assets/uploads/gallery/webp/dsc08529.webp', '2026-08-26 12:42:52'),
(166, '', 'Campus', 'assets/uploads/gallery/webp/dsc08530.webp', '2026-08-26 12:42:52'),
(167, '', 'Gym', 'assets/uploads/gallery/webp/dsc06520.webp', '2026-08-26 12:42:52'),
(168, '', 'Gym', 'assets/uploads/gallery/webp/dsc06574.webp', '2026-08-26 12:42:52'),
(169, '', 'Gym', 'assets/uploads/gallery/webp/dsc06575.webp', '2026-08-26 12:42:52'),
(170, '', 'Gym', 'assets/uploads/gallery/webp/dsc06576.webp', '2026-08-26 12:42:52'),
(171, '', 'Gym', 'assets/uploads/gallery/webp/dsc06577.webp', '2026-08-26 12:42:52'),
(172, '', 'Gym', 'assets/uploads/gallery/webp/dsc06586.webp', '2026-08-26 12:42:52'),
(173, '', 'Gym', 'assets/uploads/gallery/webp/dsc06587.webp', '2026-08-26 12:42:52'),
(174, '', 'Gym', 'assets/uploads/gallery/webp/dsc06588.webp', '2026-08-26 12:42:52'),
(175, '', 'Gym', 'assets/uploads/gallery/webp/dsc06600.webp', '2026-08-26 12:42:52'),
(176, '', 'Gym', 'assets/uploads/gallery/webp/dsc06603.webp', '2026-08-26 12:42:52'),
(177, '', 'Gym', 'assets/uploads/gallery/webp/dsc06605.webp', '2026-08-26 12:42:52'),
(178, '', 'Gym', 'assets/uploads/gallery/webp/dsc06607.webp', '2026-08-26 12:42:52'),
(179, '', 'Gym', 'assets/uploads/gallery/webp/dsc06609.webp', '2026-08-26 12:42:52'),
(180, '', 'Gym', 'assets/uploads/gallery/webp/dsc06611.webp', '2026-08-26 12:42:52'),
(181, '', 'Gym', 'assets/uploads/gallery/webp/dsc06612.webp', '2026-08-26 12:42:52'),
(182, '', 'Gym', 'assets/uploads/gallery/webp/dsc06614.webp', '2026-08-26 12:42:52'),
(183, '', 'Gym', 'assets/uploads/gallery/webp/dsc06615.webp', '2026-08-26 12:42:52'),
(184, '', 'Gym', 'assets/uploads/gallery/webp/dsc06617.webp', '2026-08-26 12:42:52'),
(185, '', 'Gym', 'assets/uploads/gallery/webp/dsc06618.webp', '2026-08-26 12:42:52'),
(186, '', 'Gym', 'assets/uploads/gallery/webp/dsc06619.webp', '2026-08-26 12:42:52'),
(187, '', 'Gym', 'assets/uploads/gallery/webp/dsc06622.webp', '2026-08-26 12:42:52'),
(188, '', 'Gym', 'assets/uploads/gallery/webp/dsc06623.webp', '2026-08-26 12:42:52'),
(189, '', 'Sports', 'assets/uploads/gallery/webp/dsc06517.webp', '2026-08-26 12:42:52'),
(190, '', 'Sports', 'assets/uploads/gallery/webp/dsc06525.webp', '2026-08-26 12:42:52'),
(191, '', 'Sports', 'assets/uploads/gallery/webp/dsc06527.webp', '2026-08-26 12:42:52'),
(192, '', 'Sports', 'assets/uploads/gallery/webp/dsc06528.webp', '2026-08-26 12:42:52'),
(193, '', 'Sports', 'assets/uploads/gallery/webp/dsc06533.webp', '2026-08-26 12:42:52'),
(194, '', 'Sports', 'assets/uploads/gallery/webp/dsc06534.webp', '2026-08-26 12:42:52'),
(195, '', 'Sports', 'assets/uploads/gallery/webp/dsc06537.webp', '2026-08-26 12:42:52'),
(196, '', 'Sports', 'assets/uploads/gallery/webp/dsc06538.webp', '2026-08-26 12:42:52'),
(197, '', 'Sports', 'assets/uploads/gallery/webp/dsc06539.webp', '2026-08-26 12:42:52'),
(198, '', 'Sports', 'assets/uploads/gallery/webp/dsc06540.webp', '2026-08-26 12:42:52'),
(199, '', 'Sports', 'assets/uploads/gallery/webp/dsc06541.webp', '2026-08-26 12:42:52'),
(200, '', 'Sports', 'assets/uploads/gallery/webp/dsc06542.webp', '2026-08-26 12:42:52'),
(201, '', 'Sports', 'assets/uploads/gallery/webp/dsc06547.webp', '2026-08-26 12:42:52'),
(202, '', 'Sports', 'assets/uploads/gallery/webp/dsc06548.webp', '2026-08-26 12:42:52'),
(203, '', 'Sports', 'assets/uploads/gallery/webp/dsc06554.webp', '2026-08-26 12:42:52'),
(204, '', 'Sports', 'assets/uploads/gallery/webp/dsc06578.webp', '2026-08-26 12:42:52'),
(205, '', 'Sports', 'assets/uploads/gallery/webp/dsc06579.webp', '2026-08-26 12:42:52'),
(206, '', 'Sports', 'assets/uploads/gallery/webp/dsc06580.webp', '2026-08-26 12:42:52'),
(207, '', 'Sports', 'assets/uploads/gallery/webp/dsc06582.webp', '2026-08-26 12:42:52'),
(208, '', 'Sports', 'assets/uploads/gallery/webp/dsc06583.webp', '2026-08-26 12:42:52'),
(209, '', 'Medical', 'assets/uploads/gallery/webp/dsc06740.webp', '2026-08-26 12:42:52'),
(210, '', 'Medical', 'assets/uploads/gallery/webp/dsc06754.webp', '2026-08-26 12:42:52'),
(211, '', 'Medical', 'assets/uploads/gallery/webp/dsc06767.webp', '2026-08-26 12:42:52'),
(212, '', 'Medical', 'assets/uploads/gallery/webp/dsc06769.webp', '2026-08-26 12:42:52'),
(213, '', 'Medical', 'assets/uploads/gallery/webp/dsc06772.webp', '2026-08-26 12:42:52'),
(214, '', 'Medical', 'assets/uploads/gallery/webp/dsc06839.webp', '2026-08-26 12:42:52'),
(215, '', 'Medical', 'assets/uploads/gallery/webp/dsc06842.webp', '2026-08-26 12:42:52'),
(216, '', 'Medical', 'assets/uploads/gallery/webp/dsc06847.webp', '2026-08-26 12:42:52'),
(217, '', 'Medical', 'assets/uploads/gallery/webp/dsc06857.webp', '2026-08-26 12:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `hero_sliders`
--

CREATE TABLE `hero_sliders` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `badge_text` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `btn_text` varchar(50) DEFAULT 'Apply Now',
  `btn_link` varchar(255) DEFAULT 'admissions.php',
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_sliders`
--

INSERT INTO `hero_sliders` (`id`, `title`, `subtitle`, `badge_text`, `image_url`, `btn_text`, `btn_link`, `sort_order`, `status`, `created_at`) VALUES
(3, 'Best Private University in Bhopal — Engineering the Future', 'Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership.', 'UGC-Recognized University in MP', 'https://srku.edu.in/new-staging/wp-content/uploads/2026/07/campus-1.webp', 'Apply Now 2026-27', 'admissions.php', 1, 1, '2026-08-07 12:36:08'),
(4, 'Empowering Future Innovators & Industry Leaders', 'Rigorous research, multi-disciplinary collaboration, 42+ high-tech labs, and 94% placement record.', '42+ High-Tech Labs', 'https://srku.edu.in/new-staging/wp-content/uploads/2026/06/New-Project.webp', 'Explore Programmes', 'courses.php', 2, 1, '2026-08-07 12:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `category` varchar(50) DEFAULT 'Announcement',
  `publish_date` date DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_ticker` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `content`, `category`, `publish_date`, `image_url`, `is_ticker`, `created_at`) VALUES
(1, 'Admissions Open for Academic Session 2026-27', 'admissions-open-2026', 'Applications are invited for UG, PG, Diploma, and Ph.D. programs across Engineering, Pharmacy, Nursing, Management, Agriculture, Law, and Medicine.', 'Admission', '2026-08-01', 'assets/images/news1.jpg', 1, '2026-08-22 05:30:35'),
(2, 'National Campus Placement Drive 2026 - Highest Package 12 LPA', 'placement-drive-2026', 'Top tier recruiters including TCS, Wipro, Infosys, Cipla, and Sun Pharma participated in the annual mega placement drive.', 'Placement', '2026-08-05', 'assets/images/news2.jpg', 1, '2026-08-22 05:30:35'),
(3, 'International Conference on Advanced Research in Pharmaceuticals & AI', 'intl-conference-2026', 'SRKU hosted delegates from 12 countries to discuss AI in drug discovery and sustainable energy.', 'Event', '2026-08-10', 'assets/images/news3.jpg', 0, '2026-08-22 05:30:35'),
(4, 'Tarang 2026 - Annual Inter-University Sports &amp; Cultural Fest Announced', 'tarang-annual-fest-2026', '<p>Three days of vibrant cultural performances, sports tournaments, and tech competitions.</p>', 'Campus Life', '2026-08-15', 'assets/images/news4.jpg', 0, '2026-08-22 05:30:35');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'General Notice',
  `file_path` varchar(255) DEFAULT NULL,
  `external_url` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT curdate(),
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `category`, `file_path`, `external_url`, `publish_date`, `status`, `created_at`) VALUES
(5, 'NIRF 2026 Official Institutional Report', 'Accreditation', NULL, 'uploads/pdf/NIRF-2026.pdf', '2026-07-01', 1, '2026-08-07 12:36:08'),
(6, 'Institutional Development Plan (IDP) 2026-2030', 'Governance', NULL, 'uploads/pdf/Institutional-Development-Plan.pdf', '2026-06-15', 1, '2026-08-07 12:36:08'),
(7, 'AICTE Extension of Approval (EOA) Report 2020-21', 'Approval', NULL, 'uploads/pdf/EOA_Report_2020-21-1.pdf', '2026-05-20', 1, '2026-08-07 12:36:08'),
(8, 'Student Grievance Redressal Committee Order', 'Committees', NULL, 'uploads/pdf/Student_Grievance_Committee.pdf', '2026-04-10', 1, '2026-08-07 12:36:08'),
(9, 'Anti-Ragging Regulations & Directives', 'Committees', NULL, 'uploads/pdf/AntiRagging.pdf', '2026-04-05', 1, '2026-08-07 12:36:08'),
(10, 'SC/ST Grievance Redressal Cell Committee', 'Committees', NULL, 'uploads/pdf/SC_ST_Grievance_committee.pdf', '2026-03-28', 1, '2026-08-07 12:36:08'),
(11, 'OBC & Minority Cell Regulations', 'Committees', NULL, 'uploads/pdf/OBC-Minority.pdf', '2026-03-15', 1, '2026-08-07 12:36:08'),
(12, 'Women Grievance & Sexual Harassment Cell Order', 'Committees', NULL, 'uploads/pdf/women-grievance-committee.pdf', '2026-03-01', 1, '2026-08-07 12:36:08'),
(13, 'Equal Opportunity Cell Guidelines', 'Committees', NULL, 'uploads/pdf/EqualOppurtunityCell.pdf', '2026-02-20', 1, '2026-08-07 12:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `content` longtext DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `banner_title` varchar(255) DEFAULT NULL,
  `banner_subtitle` varchar(255) DEFAULT NULL,
  `banner_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_description`, `status`, `created_at`, `banner_title`, `banner_subtitle`, `banner_img`) VALUES
(1, 'Why SRK University', 'why-srk', '<div class=\"why-srk-content\">\r\n                    <h2 class=\"text-maroon fw-bold mb-4\">Why Choose Sarvepalli Radhakrishnan University, Bhopal?</h2>\r\n                    <p class=\"lead text-dark\">Sarvepalli Radhakrishnan University (SRKU) is Central India\'s premier academic and research powerhouse, established by Madhya Pradesh Niji Vishwavidyalaya Act and recognized by the University Grants Commission (UGC) under Section 2(f).</p>\r\n                    \r\n                    <div class=\"row g-4 my-4\">\r\n                        <div class=\"col-md-6\">\r\n                            <div class=\"p-4 bg-light rounded-4 border-start border-4 border-danger h-100\">\r\n                                <h4 class=\"text-navy fw-bold\"><i class=\"fas fa-microscope text-danger me-2\"></i> 42+ Modern Laboratories</h4>\r\n                                <p class=\"text-muted mb-0\">High-end computing labs, pharmaceutical analysis suites, robotic testbeds, agricultural experimental farms, and clinical simulation centers.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <div class=\"p-4 bg-light rounded-4 border-start border-4 border-danger h-100\">\r\n                                <h4 class=\"text-navy fw-bold\"><i class=\"fas fa-briefcase text-danger me-2\"></i> 94% Placement Record</h4>\r\n                                <p class=\"text-muted mb-0\">Strong industry linkages with 120+ MNC recruiting partners delivering highest package of 12 LPA and consistent corporate placements.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <div class=\"p-4 bg-light rounded-4 border-start border-4 border-danger h-100\">\r\n                                <h4 class=\"text-navy fw-bold\"><i class=\"fas fa-user-graduate text-danger me-2\"></i> Multi-Disciplinary Ecosystem</h4>\r\n                                <p class=\"text-muted mb-0\">Over 50+ degree programs spanning Engineering, Pharmacy, Medicine, Nursing, Management, Law, Agriculture, and Paramedical Sciences.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <div class=\"p-4 bg-light rounded-4 border-start border-4 border-danger h-100\">\r\n                                <h4 class=\"text-navy fw-bold\"><i class=\"fas fa-hospital-user text-danger me-2\"></i> 750+ Bed Teaching Hospital</h4>\r\n                                <p class=\"text-muted mb-0\">On-campus super-specialty hospital providing live hands-on clinical exposure for medical, nursing, and paramedical students.</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n\r\n                    <h3 class=\"text-navy fw-bold mt-5 mb-3\">Academic Excellence & Approvals</h3>\r\n                    <p class=\"text-muted\">All programs at SRKU are approved by respective apex statutory bodies including AICTE, Pharmacy Council of India (PCI), Indian Nursing Council (INC), Bar Council of India (BCI), and National Medical Commission (NMC).</p>\r\n                </div>', 'Why Choose Sarvepalli Radhakrishnan University Bhopal - 42+ Labs, 94% Placement Record, UGC Recognized', 'published', '2026-08-22 05:30:35', NULL, NULL, NULL),
(2, 'Vision & Mission', 'vision-mission', '<div class=\"vision-mission-content\">\r\n                    <div class=\"card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-light\">\r\n                        <div class=\"d-flex align-items-center gap-3 mb-3\">\r\n                            <div class=\"bg-danger-subtle text-danger rounded-circle p-3\"><i class=\"fas fa-eye fa-2x\"></i></div>\r\n                            <h2 class=\"text-maroon fw-bold mb-0\">Our Vision</h2>\r\n                        </div>\r\n                        <p class=\"text-dark lead mb-0\">\"To emerge as a premier global university dedicated to value-based technical, medical, and higher education, pioneering groundbreaking research, fostering innovation, and empowering students with ethical leadership to transform society.\"</p>\r\n                    </div>\r\n\r\n                    <div class=\"card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4 bg-light\">\r\n                        <div class=\"d-flex align-items-center gap-3 mb-3\">\r\n                            <div class=\"bg-danger-subtle text-danger rounded-circle p-3\"><i class=\"fas fa-bullseye fa-2x\"></i></div>\r\n                            <h2 class=\"text-navy fw-bold mb-0\">Our Mission</h2>\r\n                        </div>\r\n                        <ul class=\"list-unstyled d-flex flex-column gap-3 mb-0 text-dark\" style=\"font-size:1.05rem;\">\r\n                            <li><i class=\"fas fa-check-circle text-danger me-2\"></i> <strong>Quality Education:</strong> Imparting experiential and industry-relevant education that nurtures critical thinking, technical proficiency, and creative innovation.</li>\r\n                            <li><i class=\"fas fa-check-circle text-danger me-2\"></i> <strong>Research & Development:</strong> Fostering an interdisciplinary research ecosystem to address national and global societal challenges.</li>\r\n                            <li><i class=\"fas fa-check-circle text-danger me-2\"></i> <strong>Industry Integration:</strong> Collaborating with leading global corporations and research institutions for curriculum alignment and student career advancement.</li>\r\n                            <li><i class=\"fas fa-check-circle text-danger me-2\"></i> <strong>Ethical Character:</strong> Inculcating moral integrity, environmental sustainability, social responsibility, and national values in future leaders.</li>\r\n                        </ul>\r\n                    </div>\r\n                </div>', 'Vision and Mission of Sarvepalli Radhakrishnan University Bhopal', 'published', '2026-08-22 05:30:35', NULL, NULL, NULL),
(3, 'Accreditation & Approvals', 'accreditation', '<div class=\"accreditation-content\">\r\n                    <h2 class=\"text-maroon fw-bold mb-3\">Statutory Approvals & Accreditations</h2>\r\n                    <p class=\"lead text-muted mb-4\">Sarvepalli Radhakrishnan University is established by Madhya Pradesh Act No. 17 of 2015 and duly recognized by the University Grants Commission (UGC) under section 2(f) of the UGC Act, 1956.</p>\r\n                    \r\n                    <div class=\"table-responsive\">\r\n                        <table class=\"table table-bordered table-striped align-middle\">\r\n                            <thead class=\"table-dark\">\r\n                                <tr>\r\n                                    <th>Regulatory Body</th>\r\n                                    <th>Scope of Recognition</th>\r\n                                    <th>Status</th>\r\n                                </tr>\r\n                            </thead>\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td><strong>University Grants Commission (UGC)</strong></td>\r\n                                    <td>Statutory University Recognition under Section 2(f)</td>\r\n                                    <td><span class=\"badge bg-success\">Recognized</span></td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td><strong>All India Council for Technical Education (AICTE)</strong></td>\r\n                                    <td>Engineering, Technology, Management & MCA Programs</td>\r\n                                    <td><span class=\"badge bg-success\">Approved</span></td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td><strong>Pharmacy Council of India (PCI)</strong></td>\r\n                                    <td>B.Pharm, D.Pharm, M.Pharm Programs</td>\r\n                                    <td><span class=\"badge bg-success\">Approved</span></td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td><strong>Indian Nursing Council (INC) & MPNRC</strong></td>\r\n                                    <td>B.Sc Nursing, PB B.Sc, M.Sc Nursing, NPCC</td>\r\n                                    <td><span class=\"badge bg-success\">Approved</span></td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td><strong>Bar Council of India (BCI)</strong></td>\r\n                                    <td>LL.B, BA LL.B Integrated, LL.M Programs</td>\r\n                                    <td><span class=\"badge bg-success\">Approved</span></td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td><strong>National Medical Commission (NMC)</strong></td>\r\n                                    <td>MBBS, MD, MS Programs</td>\r\n                                    <td><span class=\"badge bg-success\">Approved</span></td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>\r\n                    </div>\r\n                </div>', 'Statutory Approvals and Accreditations - UGC, AICTE, PCI, INC, BCI, NMC', 'published', '2026-08-22 05:30:35', NULL, NULL, NULL),
(4, 'Board of Management', 'board-of-management', '<div class=\"board-content\">\r\n                    <h2 class=\"text-maroon fw-bold mb-4\">Board of Management & University Leadership</h2>\r\n                    <p class=\"text-muted mb-4\">The governance of Sarvepalli Radhakrishnan University is overseen by visionary academicians, eminent scientists, and administrators committed to institutional excellence.</p>\r\n                    \r\n                    <div class=\"row g-4\">\r\n                        <div class=\"col-md-6\">\r\n                            <div class=\"card p-4 border-0 shadow-sm rounded-4 h-100\">\r\n                                <h4 class=\"text-navy fw-bold mb-1\">Hon\'ble Chancellor</h4>\r\n                                <p class=\"text-danger fw-semibold mb-2\">Sarvepalli Radhakrishnan University</p>\r\n                                <p class=\"text-muted small\">Providing strategic direction and inspirational leadership to establish SRKU as a global benchmark in technical and medical education.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <div class=\"card p-4 border-0 shadow-sm rounded-4 h-100\">\r\n                                <h4 class=\"text-navy fw-bold mb-1\">Vice-Chancellor</h4>\r\n                                <p class=\"text-danger fw-semibold mb-2\">Sarvepalli Radhakrishnan University</p>\r\n                                <p class=\"text-muted small\">Leading academic affairs, curriculum innovation, national accreditations, and cutting-edge research programs.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <div class=\"card p-4 border-0 shadow-sm rounded-4 h-100\">\r\n                                <h4 class=\"text-navy fw-bold mb-1\">Registrar</h4>\r\n                                <p class=\"text-danger fw-semibold mb-2\">Office of Administration</p>\r\n                                <p class=\"text-muted small\">Custodian of university records, administrative operations, statutory compliance, and university governance.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <div class=\"card p-4 border-0 shadow-sm rounded-4 h-100\">\r\n                                <h4 class=\"text-navy fw-bold mb-1\">Controller of Examinations</h4>\r\n                                <p class=\"text-danger fw-semibold mb-2\">Examination Cell</p>\r\n                                <p class=\"text-muted small\">Ensuring transparent, timely, and credible conduct of university semester examinations and degree awards.</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>', 'Board of Management and Key Governance Officers of SRKU Bhopal', 'published', '2026-08-22 05:30:35', NULL, NULL, NULL),
(5, 'Constituent Units & Colleges', 'constituent-unit', '<div class=\"units-content\">\r\n                    <h2 class=\"text-maroon fw-bold mb-4\">Constituent Colleges & Schools of SRKU</h2>\r\n                    <p class=\"lead text-muted mb-4\">The university houses dedicated constituent institutes offering specialized degree and research programs with world-class faculty and facilities.</p>\r\n                    \r\n                    <div class=\"row g-4\">\r\n                        <div class=\"col-md-6 col-lg-4\">\r\n                            <div class=\"card p-4 border-0 shadow-sm rounded-4 h-100\">\r\n                                <h5 class=\"text-navy fw-bold\">Faculty of Engineering</h5>\r\n                                <p class=\"text-muted small mb-0\">B.Tech, M.Tech & Diploma in CSE, AI/DS, Mechanical, Civil & Electrical.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6 col-lg-4\">\r\n                            <div class=\"card p-4 border-0 shadow-sm rounded-4 h-100\">\r\n                                <h5 class=\"text-navy fw-bold\">Sri Sai College of Pharmacy</h5>\r\n                                <p class=\"text-muted small mb-0\">B.Pharm, D.Pharm & M.Pharm with PCI approved research labs.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6 col-lg-4\">\r\n                            <div class=\"card p-4 border-0 shadow-sm rounded-4 h-100\">\r\n                                <h5 class=\"text-navy fw-bold\">RKDF College of Nursing</h5>\r\n                                <p class=\"text-muted small mb-0\">B.Sc Nursing, Post Basic, M.Sc & NPCC programs with clinical hospital training.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6 col-lg-4\">\r\n                            <div class=\"card p-4 border-0 shadow-sm rounded-4 h-100\">\r\n                                <h5 class=\"text-navy fw-bold\">Faculty of Management</h5>\r\n                                <p class=\"text-muted small mb-0\">MBA, BBA with specialized dual concentrations in analytics and finance.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6 col-lg-4\">\r\n                            <div class=\"card p-4 border-0 shadow-sm rounded-4 h-100\">\r\n                                <h5 class=\"text-navy fw-bold\">Faculty of Agriculture</h5>\r\n                                <p class=\"text-muted small mb-0\">B.Sc (Hons) & M.Sc Agriculture with 50+ acres of experimental research farm.</p>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6 col-lg-4\">\r\n                            <div class=\"card p-4 border-0 shadow-sm rounded-4 h-100\">\r\n                                <h5 class=\"text-navy fw-bold\">Faculty of Law</h5>\r\n                                <p class=\"text-muted small mb-0\">LL.B, BA LL.B (Hons) & LL.M with modern moot court hall.</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>', 'Constituent Colleges and Schools of Sarvepalli Radhakrishnan University', 'published', '2026-08-22 05:30:35', NULL, NULL, NULL),
(6, 'Admission Guidelines', 'admission', '<div class=\"admission-content\">\r\n                    <h2 class=\"text-maroon fw-bold mb-3\">Admission Guidelines 2026-27</h2>\r\n                    <p class=\"lead text-muted mb-4\">Admissions at Sarvepalli Radhakrishnan University are transparent, merit-based, and aligned with statutory regulatory norms.</p>\r\n                    \r\n                    <div class=\"row g-4\">\r\n                        <div class=\"col-md-6\">\r\n                            <div class=\"card p-4 bg-light rounded-4 border h-100\">\r\n                                <h4 class=\"text-navy fw-bold\"><i class=\"fas fa-clipboard-list text-danger me-2\"></i> How to Apply</h4>\r\n                                <ol class=\"text-dark small ps-3 mb-0\" style=\"line-height:2;\">\r\n                                    <li>Submit the online enquiry or application form on this website.</li>\r\n                                    <li>Counseling & document verification by the Admission Cell.</li>\r\n                                    <li>Seat allocation as per merit and eligibility criteria.</li>\r\n                                    <li>Fee payment and enrollment confirmation.</li>\r\n                                </ol>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"col-md-6\">\r\n                            <div class=\"card p-4 bg-light rounded-4 border h-100\">\r\n                                <h4 class=\"text-navy fw-bold\"><i class=\"fas fa-phone-volume text-danger me-2\"></i> Admission Helpline</h4>\r\n                                <p class=\"text-muted small mb-2\">Our counselors are available Monday to Saturday (9 AM - 6 PM) to assist you:</p>\r\n                                <p class=\"mb-1 fw-bold text-dark\"><i class=\"fas fa-phone text-danger me-2\"></i> 0755 - 4911204</p>\r\n                                <p class=\"mb-0 fw-bold text-dark\"><i class=\"fas fa-envelope text-danger me-2\"></i> exam@srku.edu.in</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>', 'SRKU Admission Process, Guidelines and Eligibility 2026-27', 'published', '2026-08-22 05:30:35', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `placements`
--

CREATE TABLE `placements` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `package_offered` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `placements`
--

INSERT INTO `placements` (`id`, `company_name`, `logo_url`, `package_offered`, `sort_order`, `status`, `created_at`) VALUES
(1, 'TCS - Tata Consultancy Services', 'https://upload.wikimedia.org/wikipedia/commons/b/b1/Tata_Consultancy_Services_Logo.svg', '7.5 LPA', 1, 1, '2026-08-07 11:44:15'),
(2, 'Infosys', 'https://upload.wikimedia.org/wikipedia/commons/9/95/Infosys_logo.svg', '6.8 LPA', 2, 1, '2026-08-07 11:44:15'),
(3, 'Wipro', 'https://upload.wikimedia.org/wikipedia/commons/a/a0/Wipro_Primary_Logo_Color_RGB.svg', '6.5 LPA', 3, 1, '2026-08-07 11:44:15'),
(4, 'HCL Tech', 'https://upload.wikimedia.org/wikipedia/commons/a/a6/HCLTech_logo.svg', '7.0 LPA', 4, 1, '2026-08-07 11:44:15'),
(5, 'Axis Bank', 'https://upload.wikimedia.org/wikipedia/commons/1/1a/Axis_Bank_logo.svg', '5.5 LPA', 5, 1, '2026-08-07 11:44:15'),
(6, 'Reliance Industries', 'https://upload.wikimedia.org/wikipedia/en/9/99/Reliance_Industries_Logo.svg', '8.2 LPA', 6, 1, '2026-08-07 11:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'site_title', 'Sarvepalli Radhakrishnan University (SRKU), Bhopal'),
(2, 'helpline', '0755 - 4911204'),
(3, 'email', 'exam@srku.edu.in'),
(4, 'admissions_phone', '+91 755 4911204 / 94250 12345'),
(5, 'address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026'),
(6, 'ticker_text', ''),
(7, 'highest_package', '12 LPA'),
(8, 'placement_record', '94%'),
(9, 'recruiting_partners', '120+'),
(10, 'total_labs', '42+'),
(11, 'facebook_url', 'https://facebook.com/srku.bhopal'),
(12, 'instagram_url', 'https://instagram.com/srku.bhopal'),
(13, 'youtube_url', 'https://youtube.com/@srkuniversity'),
(14, 'linkedin_url', 'https://linkedin.com/school/srk-university'),
(15, 'hero_video_url', 'assets/images/concept2-hero.mp4'),
(16, 'hero_fallback_image', 'assets/uploads/2026/08/srku-rkdf-building.jpeg'),
(19, 'hero_title', 'SRK University, Bhopal'),
(20, 'hero_subtitle', 'UGC-Recognized University in MP'),
(21, 'hero_desc', ''),
(30, 'total_alumni', '15,000+'),
(33, 'chancellor_name', 'Mrs. Janak Kapoor'),
(34, 'chancellor_title', 'Chancellor'),
(35, 'chancellor_msg', ''),
(36, 'vc_name', 'Ms. Priyanka Jaiswal'),
(37, 'vc_title', 'Vice Chancellor'),
(38, 'vc_msg', ''),
(67, 'welcome_subtitle', 'WELCOME TO SRK UNIVERSITYyyyyy'),
(68, 'welcome_title', 'Committed Towards Your Better Future Through Academic Excellence'),
(69, 'welcome_body_1', 'The SRK University is a multidisciplinary university known for its high standards in teaching and research, and attracts eminent scholars to its faculty across the academic spectrum.'),
(70, 'welcome_body_2', 'The group was established in 1995 under the flagship of the RKDF Group. Ever since its inception, a strong commitment to excellence in teaching and research has made the group a role-model and path-setter for other institutions.'),
(71, 'welcome_photo', 'assets/uploads/2026/08/welcome-srku-campus.jpeg'),
(74, 'chancellor_photo', 'assets/uploads/2026/08/chancellor.jpeg'),
(75, 'chancellor_heading', 'A Legacy of Excellence, A Vision for Tomorrow'),
(77, 'chancellor_msg2', ''),
(78, 'chancellor_full_page_msg', ''),
(81, 'vc_photo', 'assets/uploads/2026/07/ruchichaubey.webp'),
(82, 'vc_heading', 'Pioneering Excellence, Empowering Future Leaders'),
(84, 'vc_msg2', ''),
(85, 'vc_full_page_msg', '');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'site_name', 'Sarvepalli Radhakrishnan University', '2026-08-07 11:44:15'),
(2, 'site_title', 'Sarvepalli Radhakrishnan University, Bhopal - Premier Technical & Academic Ecosystem', '2026-08-07 11:44:15'),
(3, 'helpline_phone', '0755 - 4911204', '2026-08-07 11:44:15'),
(4, 'contact_email', 'exam@srku.edu.in', '2026-08-07 11:44:15'),
(5, 'admissions_email', 'admissions@srku.edu.in', '2026-08-07 11:44:15'),
(6, 'top_announcement', 'Admissions Open 2026-27 | UGC Recognized & AICTE Approved University', '2026-08-07 11:44:15'),
(7, 'address', 'NH-12, Hoshangabad Road, Misrod, Bhopal, Madhya Pradesh 462026', '2026-08-07 11:44:15'),
(8, 'facebook_url', 'https://facebook.com/srkuniversity', '2026-08-07 11:44:15'),
(9, 'twitter_url', 'https://twitter.com/srkuniversity', '2026-08-07 11:44:15'),
(10, 'linkedin_url', 'https://linkedin.com/school/srkuniversity', '2026-08-07 11:44:15'),
(11, 'instagram_url', 'https://instagram.com/srkuniversity', '2026-08-07 11:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'admin', '$2y$10$75Fr8Qso/t9GZ8SCEKvTiev3jqv2DmbBfdFziMbpTRN.kaJ92.bL6', 'admin@srku.edu.in', '2026-08-22 05:30:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_dept` (`dept_slug`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `idx_designation` (`designation`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_sliders`
--
ALTER TABLE `hero_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `placements`
--
ALTER TABLE `placements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1373;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `hero_sliders`
--
ALTER TABLE `hero_sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `placements`
--
ALTER TABLE `placements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
