-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2026 at 01:09 PM
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
(3, 'State-of-the-Art Multi-Disciplinary Campus', 'Spread over lush green campus with 750+ Bed Teaching Hospital & Sports Complex', 'assets/images/banner3.jpg', 'Campus Tour', 'facilities.php', 3, 'home'),
(4, 'About Sarvepalli Radhakrishnan University', 'Excellence in Higher Education, Research Innovation &amp;amp; Value-Based Leadership', 'assets/uploads/2026/07/campus-1.webp', '', '', 0, 'about'),
(5, 'Academic Departments & Institutes', '20 Specialized Faculties Delivering World-Class Degrees in Central India', 'assets/uploads/2026/07/dept_engg.jpg', NULL, NULL, 0, 'departments'),
(6, 'Academic Programmes & Degrees', 'Undergraduate (UG), Postgraduate (PG), Diploma & Doctoral Research Programs', 'assets/uploads/2026/07/library.webp', NULL, NULL, 0, 'courses'),
(7, 'Academic Curriculum & Syllabus', 'Semester-Wise Scheme of Examination, Course Structures & Learning Outcomes', 'assets/uploads/2026/07/lab-and-research.webp', NULL, NULL, 0, 'syllabus'),
(8, 'Training & Corporate Placements', '94% Placement Record • 12 LPA Highest Package • 120+ Corporate Recruiters', 'assets/uploads/2026/07/campus-1.webp', NULL, NULL, 0, 'placements'),
(9, 'World-Class Campus Facilities', 'Lush Green Sprawling Campus Spread Over Expansive Acres in Bhopal', 'assets/uploads/2026/07/hostel.webp', NULL, NULL, 0, 'facilities'),
(10, 'Research & Innovation Cell', 'Fostering Groundbreaking Discoveries, Patents & Interdisciplinary Science', 'assets/uploads/2026/07/lab-and-research.webp', NULL, NULL, 0, 'research-innovation'),
(11, 'SRKU Incubation & Startup Centre', 'Nurturing Student Entrepreneurs, Ideation & Commercial Venture Creation', 'assets/uploads/2026/07/campus-1.webp', NULL, NULL, 0, 'incubation-center'),
(12, 'Student Life & Campus Culture', 'Vibrant, Diverse, Inclusive & Energetic Campus Community', 'assets/uploads/2026/07/Gallary-slider-01.webp', NULL, NULL, 0, 'student-life'),
(13, 'Campus Photo & Event Gallery', 'Glimpses of Academic Life, Cultural Fests, Sports & World-Class Infrastructure', 'assets/uploads/2026/07/Gallary-slider-03.webp', NULL, NULL, 0, 'gallery'),
(14, 'SRKU Global Alumni Network', '15,000+ Alumni Leading Innovations Across Top Global MNCs & Research Centers', 'assets/uploads/2026/07/graduates.webp', NULL, NULL, 0, 'alumni'),
(15, 'Faculty & Staff Recruitment', 'Join Central India\'s Premier Academic Ecosystem as an Educator, Researcher or Leader', 'assets/uploads/2026/07/campus-1.webp', NULL, NULL, 0, 'career'),
(16, 'Campus News, Articles & Updates', 'Latest Announcements, Research Highlights & Student Achievements', 'assets/uploads/2026/07/Gallary-slider-07.webp', NULL, NULL, 0, 'blogs'),
(17, 'Contact & Admission Office', 'We are here to assist you with admissions, examinations & campus queries', 'assets/uploads/2026/07/campus-1.webp', NULL, NULL, 0, 'contact');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `department` varchar(100) NOT NULL,
  `dept_slug` varchar(100) DEFAULT NULL,
  `course_name` varchar(255) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `level` varchar(50) DEFAULT 'UG',
  `duration` varchar(50) DEFAULT NULL,
  `eligibility` text DEFAULT NULL,
  `fees` varchar(100) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `career_scope` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `department`, `dept_slug`, `course_name`, `slug`, `level`, `duration`, `eligibility`, `fees`, `description`, `career_scope`, `status`) VALUES
(79, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'B.A.', 'b-a-srk-university-faculty-of-allied-science-humanities', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The B.A. at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'B.A. graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(80, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'B.Com.', 'b-com-srk-university-faculty-of-allied-science-humanities', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The B.Com. at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'B.Com. graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(81, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'B.Lib.', 'b-lib-srk-university-faculty-of-allied-science-humanities', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The B.Lib. at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'B.Lib. graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(82, 'Faculty of Pharmacy', 'faculty-of-pharmacy', 'B.Pharma', 'b-pharma-srk-university-faculty-of-pharmacy', 'UG', '4 Years', '10+2 with Physics and Chemistry along with Mathematics or Biology (PCB/PCM) with minimum 50% marks.', '₹70,000 / Year', 'The B.Pharma at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'B.Pharma graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(83, 'Faculty of Agriculture', 'faculty-of-agriculture', 'B.Sc. Agriculture (Hons.)', 'b-sc-agriculture-hons-srk-university-faculty-of-agriculture', 'UG', '4 Years', '10+2 with Science (PCB/PCM) or Agriculture subject with minimum 50% marks.', '₹50,000 / Year', 'The B.Sc. Agriculture (Hons.) at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'B.Sc. Agriculture (Hons.) graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(84, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'B.Sc. Fashion Design', 'b-sc-fashion-design-srk-university-faculty-of-allied-science-humanities', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The B.Sc. Fashion Design at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'B.Sc. Fashion Design graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(85, 'Faculty of Nursing', 'faculty-of-nursing', 'B.Sc. Nursing', 'b-sc-nursing-srk-university-faculty-of-nursing', 'UG', '4 Years', '10+2 with Physics, Chemistry and Biology (PCB) and English with minimum 45% marks.', '₹60,000 / Year', 'The B.Sc. Nursing at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'B.Sc. Nursing graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(86, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'B.Sc.', 'b-sc-srk-university-faculty-of-allied-science-humanities', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The B.Sc. at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'B.Sc. graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(87, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'B.Sc. Yoga', 'b-sc-yoga-srk-university-faculty-of-allied-science-humanities', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The B.Sc. Yoga at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'B.Sc. Yoga graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(88, 'Faculty of Engineering', 'faculty-of-engineering', 'B.Tech', 'b-tech-srk-university-faculty-of-engineering', 'UG', '4 Years', '10+2 with Physics, Mathematics and Chemistry/Computer Science with minimum 50% marks (45% for SC/ST/OBC).', '₹65,000 / Year', 'The B.Tech at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'B.Tech graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(89, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'BA Animation', 'ba-animation-srk-university-faculty-of-allied-science-humanities', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The BA Animation at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'BA Animation graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(90, 'Faculty of Law', 'faculty-of-law', 'BA LL.B. (Hons.)', 'ba-ll-b-hons-srk-university-faculty-of-law', 'UG', '5 Years', 'Graduation in any discipline for 3-yr LL.B / 10+2 for 5-yr Integrated Law with min 45% marks.', 'As per AFRC / University Norms', 'The BA LL.B. (Hons.) at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'BA LL.B. (Hons.) graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(91, 'Faculty of Ayurveda', 'faculty-of-ayurveda', 'BAMS', 'bams-srk-university-faculty-of-ayurveda', 'UG', '5 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The BAMS at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'BAMS graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(92, 'Faculty of Computer Application', 'faculty-of-computer-application', 'BCA', 'bca-srk-university-faculty-of-computer-application', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', '₹45,000 / Year', 'The BCA at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'BCA graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(93, 'Faculty of Dental Sciences', 'faculty-of-dental-sciences', 'BDS', 'bds-srk-university-faculty-of-dental-sciences', 'UG', '5 Years', '10+2 with PCB (min 50%) and NEET qualified as per NMC / DCI norms.', 'As per AFRC / University Norms', 'The BDS at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'BDS graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(94, 'Faculty of Homoeopathy', 'faculty-of-homoeopathy', 'BHMS', 'bhms-srk-university-faculty-of-homoeopathy', 'UG', '5 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The BHMS at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'BHMS graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(95, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'BJMC', 'bjmc-srk-university-faculty-of-allied-science-humanities', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The BJMC at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'BJMC graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(96, 'Faculty of Paramedical Sciences', 'faculty-of-paramedical-sciences', 'BMLT', 'bmlt-srk-university-faculty-of-paramedical-sciences', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The BMLT at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'BMLT graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(97, 'Faculty of Paramedical Sciences', 'faculty-of-paramedical-sciences', 'BPT', 'bpt-srk-university-faculty-of-paramedical-sciences', 'UG', '5 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The BPT at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'BPT graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(98, 'Faculty of Paramedical Sciences', 'faculty-of-paramedical-sciences', 'D.Pharma (Ayurved)', 'd-pharma-ayurved-srk-university-faculty-of-paramedical-sciences', 'Diploma', '2 Years', '10th / 10+2 with minimum 45% marks in Science/Relevant stream.', 'As per AFRC / University Norms', 'The D.Pharma (Ayurved) at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'D.Pharma (Ayurved) graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(99, 'Faculty of Paramedical Sciences', 'faculty-of-paramedical-sciences', 'D.Pharma (Homeopathy)', 'd-pharma-homeopathy-srk-university-faculty-of-paramedical-sciences', 'Diploma', '2 Years', '10th / 10+2 with minimum 45% marks in Science/Relevant stream.', 'As per AFRC / University Norms', 'The D.Pharma (Homeopathy) at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'D.Pharma (Homeopathy) graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(100, 'Department of Pharmacy', 'department-of-pharmacy', 'D.Pharma', 'd-pharma-srk-university', 'Diploma', '2 Years', '10th / 10+2 with minimum 45% marks in Science/Relevant stream.', 'As per AFRC / University Norms', 'The D.Pharma at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'D.Pharma graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(101, 'Faculty of Computer Application', 'faculty-of-computer-application', 'DCA', 'dca-srk-university-faculty-of-computer-application', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The DCA at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'DCA graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(102, 'Faculty of Agriculture', 'faculty-of-agriculture', 'Diploma in Agriculture', 'diploma-in-agriculture-srk-university-faculty-of-agriculture', 'Diploma', '1 Year / 2 Years', '10th / 10+2 with minimum 45% marks in Science/Relevant stream.', '₹50,000 / Year', 'The Diploma in Agriculture at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'Diploma in Agriculture graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(103, 'Faculty of Engineering', 'faculty-of-engineering', 'Diploma in Engineering', 'diploma-in-engineering-srk-university-faculty-of-engineering', 'Diploma', '1 Year / 2 Years', '10th / 10+2 with minimum 45% marks in Science/Relevant stream.', 'As per AFRC / University Norms', 'The Diploma in Engineering at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'Diploma in Engineering graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(104, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'Diploma in Fashion Design', 'diploma-in-fashion-design-srk-university-faculty-of-allied-science-humanities', 'Diploma', '1 Year / 2 Years', '10th / 10+2 with minimum 45% marks in Science/Relevant stream.', 'As per AFRC / University Norms', 'The Diploma in Fashion Design at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'Diploma in Fashion Design graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(105, 'Faculty of Paramedical Sciences', 'faculty-of-paramedical-sciences', 'Diploma Optometric Refraction', 'diploma-optometric-refraction-srk-university-faculty-of-paramedical-sciences', 'Diploma', '1 Year / 2 Years', '10th / 10+2 with minimum 45% marks in Science/Relevant stream.', 'As per AFRC / University Norms', 'The Diploma Optometric Refraction at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'Diploma Optometric Refraction graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(106, 'Faculty of Paramedical Sciences', 'faculty-of-paramedical-sciences', 'Diploma X-Ray (Radiographer)', 'diploma-x-ray-radiographer-srk-university-faculty-of-paramedical-sciences', 'Diploma', '1 Year / 2 Years', '10th / 10+2 with minimum 45% marks in Science/Relevant stream.', 'As per AFRC / University Norms', 'The Diploma X-Ray (Radiographer) at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'Diploma X-Ray (Radiographer) graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(107, 'Faculty of Paramedical Sciences', 'faculty-of-paramedical-sciences', 'DMLT', 'dmlt-srk-university-faculty-of-paramedical-sciences', 'Diploma', '1 Year / 2 Years', '10th / 10+2 with minimum 45% marks in Science/Relevant stream.', 'As per AFRC / University Norms', 'The DMLT at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'DMLT graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(108, 'Faculty of Law', 'faculty-of-law', 'LL.B.', 'll-b-srk-university-faculty-of-law', 'UG', '3 Years', 'Graduation in any discipline for 3-yr LL.B / 10+2 for 5-yr Integrated Law with min 45% marks.', 'As per AFRC / University Norms', 'The LL.B. at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'LL.B. graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(109, 'Faculty of Law', 'faculty-of-law', 'LL.M.', 'll-m-srk-university-faculty-of-law', 'UG', '2 Years', 'Graduation in any discipline for 3-yr LL.B / 10+2 for 5-yr Integrated Law with min 45% marks.', 'As per AFRC / University Norms', 'The LL.M. at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'LL.M. graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(110, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'M.A.', 'm-a-srk-university-faculty-of-allied-science-humanities', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The M.A. at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'M.A. graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(111, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'M.Com.', 'm-com-srk-university-faculty-of-allied-science-humanities', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The M.Com. at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'M.Com. graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(112, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'M.Lib.', 'm-lib-srk-university-faculty-of-allied-science-humanities', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The M.Lib. at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'M.Lib. graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(113, 'Department of Pharmacy', 'department-of-pharmacy', 'M.Pharma', 'm-pharma-srk-university', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The M.Pharma at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'M.Pharma graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(114, 'Faculty of Agriculture', 'faculty-of-agriculture', 'M.Sc. Agriculture', 'm-sc-agriculture-srk-university-faculty-of-agriculture', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', '₹50,000 / Year', 'The M.Sc. Agriculture at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'M.Sc. Agriculture graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(115, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'M.Sc. Fashion Design', 'm-sc-fashion-design-srk-university-faculty-of-allied-science-humanities', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The M.Sc. Fashion Design at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'M.Sc. Fashion Design graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(116, 'Faculty of Nursing', 'faculty-of-nursing', 'M.Sc. Nursing', 'm-sc-nursing-srk-university-faculty-of-nursing', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', '₹60,000 / Year', 'The M.Sc. Nursing at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'M.Sc. Nursing graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(117, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'M.Sc.', 'm-sc-srk-university-faculty-of-allied-science-humanities', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The M.Sc. at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'M.Sc. graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(118, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'M.Sc. Yoga', 'm-sc-yoga-srk-university-faculty-of-allied-science-humanities', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The M.Sc. Yoga at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'M.Sc. Yoga graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(119, 'Faculty of Engineering', 'faculty-of-engineering', 'M.Tech', 'm-tech-srk-university-faculty-of-engineering', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The M.Tech at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'M.Tech graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(120, 'Faculty of Management', 'faculty-of-management', 'MBA', 'mba-srk-university-faculty-of-management', 'UG', '2 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', '₹55,000 / Year', 'The MBA at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'MBA graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(121, 'Faculty of Medicine', 'faculty-of-medicine', 'MBBS', 'mbbs-srk-university-faculty-of-medicine', 'UG', '5 Years', '10+2 with PCB (min 50%) and NEET qualified as per NMC / DCI norms.', 'As per AFRC / University Norms', 'The MBBS at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'MBBS graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(122, 'Faculty of Computer Application', 'faculty-of-computer-application', 'MCA- (Faculty of Computer Application)', 'mca-srk-university-faculty-of-computer-application', 'UG', '2 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', '₹45,000 / Year', 'The MCA- (Faculty of Computer Application) at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'MCA- (Faculty of Computer Application) graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(123, 'Faculty of Homoeopathy', 'faculty-of-homoeopathy', 'MD (Homoeopathy)', 'md-homoeopathy-srk-university-faculty-of-homoeopathy', 'PG', '3 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The MD (Homoeopathy) at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'MD (Homoeopathy) graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(124, 'Faculty of Medicine', 'faculty-of-medicine', 'MD', 'md-srk-university-faculty-of-medicine', 'PG', '3 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The MD at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'MD graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(125, 'Faculty of Dental Sciences', 'faculty-of-dental-sciences', 'MDS', 'mds-srk-university-faculty-of-dental-sciences', 'PG', '3 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The MDS at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'MDS graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(126, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'MJ', 'mj-srk-university-faculty-of-allied-science-humanities', 'UG', '3 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The MJ at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'MJ graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(127, 'Faculty of Paramedical Sciences', 'faculty-of-paramedical-sciences', 'MMLT', 'mmlt-srk-university-faculty-of-paramedical-sciences', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The MMLT at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'MMLT graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(128, 'Faculty of Paramedical Sciences', 'faculty-of-paramedical-sciences', 'MPT', 'mpt-srk-university-faculty-of-paramedical-sciences', 'PG', '2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The MPT at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'MPT graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(129, 'Faculty of Medicine', 'faculty-of-medicine', 'MS', 'ms-srk-university-faculty-of-medicine', 'PG', '3 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The MS at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'MS graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(130, 'Faculty of Nursing', 'faculty-of-nursing', 'NPCC', 'npcc-srk-university-faculty-of-nursing', 'UG', '3 Years', '10+2 with Physics, Chemistry and Biology (PCB) and English with minimum 45% marks.', '₹60,000 / Year', 'The NPCC at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'NPCC graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(131, 'Faculty of Paramedical Sciences', 'faculty-of-paramedical-sciences', 'O.T. Technician', 'o-t-technician-srk-university-faculty-of-paramedical-sciences', 'Diploma', '3 Years', '10th / 10+2 with minimum 45% marks in Science/Relevant stream.', 'As per AFRC / University Norms', 'The O.T. Technician at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'O.T. Technician graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(132, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-humanities', 'PG Diploma in Yoga', 'pg-diploma-in-yoga-srk-university-faculty-of-allied-science-humanities', 'UG', '1 Year / 2 Years', '10+2 with minimum 45-50% marks in relevant qualifying examination from a recognized board.', 'As per AFRC / University Norms', 'The PG Diploma in Yoga at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'PG Diploma in Yoga graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(133, 'Faculty of Computer Application', 'faculty-of-computer-application', 'PGDCA', 'pgdca-srk-university-faculty-of-computer-application', 'PG', '1 Year / 2 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', 'As per AFRC / University Norms', 'The PGDCA at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'PGDCA graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active'),
(134, 'Faculty of Nursing', 'faculty-of-nursing', 'Post Basic B.Sc. Nursing', 'post-basic-b-sc-nursing-srk-university-faculty-of-nursing', 'PG', '4 Years', 'Graduation in relevant discipline with minimum 50% aggregate marks from a recognized University.', '₹60,000 / Year', 'The Post Basic B.Sc. Nursing at Sarvepalli Radhakrishnan University is designed in close consultation with leading industry experts and academic councils, focusing on theoretical foundations, cutting-edge practical training, and interdisciplinary research.', 'Post Basic B.Sc. Nursing graduates possess high demand across national and multinational corporations, research organizations, hospitals, and public sector undertakings.', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `icon` varchar(100) DEFAULT 'fas fa-graduation-cap',
  `banner_img` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `dean_name` varchar(150) DEFAULT NULL,
  `established_year` varchar(10) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `slug`, `icon`, `banner_img`, `description`, `dean_name`, `established_year`, `status`) VALUES
(15, 'Department of Engineering', 'department-of-engineering', 'fas fa-cogs', 'assets/images/dept_engg.jpg', 'Faculty of Engineering offers AICTE approved B.Tech, M.Tech and Polytechnic programs with cutting-edge computing, AI/ML, Robotics, IoT and Mechanical labs.', 'Dr. R. K. Sharma', '2015', 'active'),
(16, 'Department of Pharmacy (RKDF College)', 'department-of-pharmacy', 'fas fa-pills', 'assets/images/dept_pharma.jpg', 'PCI & AICTE approved pharmacy institute offering B.Pharm, M.Pharm, and Pharm.D with advanced pharmacology and formulation development labs.', 'Dr. S. K. Jain', '2015', 'active'),
(17, 'Department of Pharmacy (RKDF Polytechnic)', 'rkdf-polytechnic-pharmacy', 'fas fa-pills', 'assets/images/dept_pharma.jpg', 'Dedicated polytechnic pharmacy institution delivering high quality D.Pharm programs.', 'Dr. S. K. Jain', '2015', 'active'),
(18, 'Sri Sai College of Pharmacy', 'sri-sai-college-of-pharmacy-srk-bhopal', 'fas fa-capsules', 'assets/images/dept_pharma2.jpg', 'Premier institute specializing in pharmaceutical education, clinical research, drug design, and industrial training.', 'Dr. Neha Verma', '2016', 'active'),
(19, 'Dr. APJ Abdul Kalam College of Pharmacy', 'dr-apj-abdul-kalam-college-of-pharmacy-srk-bhopal', 'fas fa-flask', 'assets/images/dept_pharma3.jpg', 'Dedicated institute fostering advanced research in nanomedicine, pharmacognosy, and pharmaceutical biotechnology.', 'Dr. A. K. Patel', '2017', 'active'),
(20, 'Sarvepalli Radhakrishnan College of Pharmacy', 'sarvepalli-radhakrishnan-college-of-pharmacy', 'fas fa-prescription-bottle', 'assets/images/dept_pharma4.jpg', 'Flagship pharmaceutical institution committed to clinical practice, hospital pharmacy, and doctoral research.', 'Dr. Manoj Gupta', '2015', 'active'),
(21, 'Sarvepalli Radhakrishnan Institute of Pharmaceutical Science', 'sarvepalli-radhakrishnan-institute-of-pharmaceutical-science', 'fas fa-flask', 'assets/images/dept_pharma.jpg', 'Advanced pharmaceutical science institute fostering formulation design and pharmacology.', 'Dr. Manoj Gupta', '2016', 'active'),
(22, 'R.N. Kapoor Memorial Institute of Pharmaceutical Sciences', 'r-n-kapoor-memorial-institute-of-pharmaceutical-sciences-srk-university', 'fas fa-tablets', 'assets/images/dept_pharma5.jpg', 'Excellence in pharmacy diploma, undergraduate, and postgraduate pharmaceutical chemistry studies.', 'Dr. Pooja Mishra', '2018', 'active'),
(23, 'Department of Computer Application', 'department-of-computer-application', 'fas fa-laptop-code', 'assets/images/dept_ca.jpg', 'Delivering MCA, BCA, and PGDCA programs focused on Full-stack web development, Cloud Computing, Cyber Security, and AI.', 'Prof. Amit Saxena', '2015', 'active'),
(24, 'Faculty of Computer Application', 'faculty-of-computer-application', 'fas fa-laptop-code', 'assets/images/dept_ca.jpg', 'Delivering MCA, BCA, and PGDCA programs focused on Full-stack web development, Cloud Computing, Cyber Security, and AI.', 'Prof. Amit Saxena', '2015', 'active'),
(25, 'Department of Management', 'department-of-management', 'fas fa-chart-line', 'assets/images/dept_mgmt.jpg', 'Top-ranked business school offering MBA and BBA with dual specializations in Finance, Marketing, HR, Business Analytics, and Supply Chain.', 'Dr. V. K. Tiwari', '2015', 'active'),
(26, 'Department of Business Management', 'department-of-business-management', 'fas fa-briefcase', 'assets/images/dept_mgmt.jpg', 'Leading management academy offering specialized MBA, BBA, and management development programs.', 'Dr. V. K. Tiwari', '2016', 'active'),
(27, 'RKDF College of Nursing', 'rkdf-college-of-nursing', 'fas fa-user-md', 'assets/images/dept_nursing.jpg', 'INC recognized center providing B.Sc Nursing, Post Basic B.Sc, M.Sc Nursing, and NPCC programs with 500+ bed hospital training.', 'Prof. Mary Joseph', '2016', 'active'),
(28, 'Faculty of Agriculture', 'faculty-of-agriculture', 'fas fa-seedling', 'assets/images/dept_agri.jpg', 'ICAR aligned B.Sc (Hons) and M.Sc Agriculture programs with 50+ acres of experimental farms, polyhouses, and agronomy research labs.', 'Dr. R. P. Singh', '2016', 'active'),
(29, 'Faculty of Law', 'faculty-of-law', 'fas fa-balance-scale', 'assets/images/dept_law.jpg', 'BCI approved LL.B, BA LL.B (Hons), and LL.M degrees with moot court hall, legal aid clinic, and judicial mentoring.', 'Adv. Dr. S. K. Dubey', '2015', 'active'),
(30, 'SRK College of Law', 'srk-college-of-law', 'fas fa-balance-scale', 'assets/images/dept_law.jpg', 'Premier law college offering 3-year LL.B and 5-year integrated BA LL.B degrees.', 'Adv. Dr. S. K. Dubey', '2015', 'active'),
(31, 'Faculty of Medicine & Dental Sciences', 'faculty-of-medicine', 'fas fa-stethoscope', 'assets/images/dept_med.jpg', 'NMC recognized medical and dental sciences providing MBBS, MD, MS, BDS, and MDS programs with multi-specialty clinical hospital.', 'Dr. H. K. Trivedi', '2015', 'active'),
(32, 'Faculty of Paramedical & Allied Health Care Sciences', 'faculty-of-paramedical-sciences', 'fas fa-heartbeat', 'assets/images/dept_para.jpg', 'Comprehensive paramedical education in BPT, MPT, BMLT, DMLT, X-Ray Radiography, and Optometry with hospital internships.', 'Dr. Archana Sen', '2016', 'active'),
(33, 'Department of Allied & Healthcare Sciences', 'department-of-allied-health-care-sciences', 'fas fa-heartbeat', 'assets/images/dept_para.jpg', 'Specialized allied health courses in Medical Lab Technology, Radiology, Dialysis, and Physiotherapy.', 'Dr. Archana Sen', '2016', 'active'),
(34, 'Faculty of Allied Science & Humanities', 'faculty-of-allied-science-and-humanities', 'fas fa-atom', 'assets/images/dept_science.jpg', 'Undergraduate and Postgraduate programs in B.Sc, M.Sc, Yoga Science, Fashion Design, Journalism (MJ), and Humanities.', 'Dr. Ramesh Chandra', '2015', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `course` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `name`, `email`, `phone`, `course`, `message`, `status`, `created_at`) VALUES
(1, 'Amit Verma', 'amit.test@example.com', '9893012345', 'B.Tech AI & Data Science', '[Admissions 2026 Portal]\nInterested in admissions and hostel facilities.', 'New', '2026-08-21 09:43:51');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT 'Campus',
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `content` text DEFAULT NULL,
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
(1, 'Admissions Open for Academic Session 2026-27', 'admissions-open-2026', 'Applications are invited for UG, PG, Diploma, and Ph.D. programs across Engineering, Pharmacy, Nursing, Management, Agriculture, Law, and Medicine.', 'Admission', '2026-08-01', 'assets/images/news1.jpg', 1, '2026-08-21 07:26:13'),
(2, 'National Campus Placement Drive 2026 - Highest Package 12 LPA', 'placement-drive-2026', 'Top tier recruiters including TCS, Wipro, Infosys, Cipla, and Sun Pharma participated in the annual mega placement drive.', 'Placement', '2026-08-05', 'assets/images/news2.jpg', 1, '2026-08-21 07:26:13'),
(3, 'International Conference on Advanced Research in Pharmaceuticals & AI', 'intl-conference-2026', 'SRKU hosted delegates from 12 countries to discuss AI in drug discovery and sustainable energy.', 'Event', '2026-08-10', 'assets/images/news3.jpg', 0, '2026-08-21 07:26:13'),
(4, 'Tarang 2026 - Annual Inter-University Sports & Cultural Fest Announced', 'tarang-annual-fest-2026', 'Three days of vibrant cultural performances, sports tournaments, and tech competitions.', 'Campus Life', '2026-08-15', 'assets/images/news4.jpg', 0, '2026-08-21 07:26:13');

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
(21, 'Why SRK University', 'why-srk', '\n<div class=\"row g-4 mb-4\">\n    <div class=\"col-md-6\">\n        <div class=\"p-4 rounded-4 bg-light border h-100\">\n            <h4 class=\"text-navy fw-bold mb-3\"><i class=\"fas fa-certificate text-danger me-2\"></i> UGC Recognized & Statutory Approvals</h4>\n            <p class=\"text-muted\">Established under MP Niji Vishwavidyalaya Adhiniyam and recognized under Section 2(f) of the UGC Act 1956. Approved by AICTE, PCI, INC, BCI, and NMC with unmatched credibility across India and globally.</p>\n        </div>\n    </div>\n    <div class=\"col-md-6\">\n        <div class=\"p-4 rounded-4 bg-light border h-100\">\n            <h4 class=\"text-navy fw-bold mb-3\"><i class=\"fas fa-flask text-danger me-2\"></i> 42+ High-Tech Advanced Labs</h4>\n            <p class=\"text-muted\">Equipped with sophisticated computing centers, pharmaceutical testing laboratories, advanced robotic testbeds, and simulation software ensuring practical real-world training.</p>\n        </div>\n    </div>\n    <div class=\"col-md-6\">\n        <div class=\"p-4 rounded-4 bg-light border h-100\">\n            <h4 class=\"text-navy fw-bold mb-3\"><i class=\"fas fa-briefcase text-danger me-2\"></i> 94% Placement Record</h4>\n            <p class=\"text-muted\">Dedicated Corporate Relations Cell facilitating recruitment drives with 120+ top MNCs including TCS, Infosys, Amazon, Cipla, Sun Pharma, and L&T with packages up to 12 LPA.</p>\n        </div>\n    </div>\n    <div class=\"col-md-6\">\n        <div class=\"p-4 rounded-4 bg-light border h-100\">\n            <h4 class=\"text-navy fw-bold mb-3\"><i class=\"fas fa-hospital text-danger me-2\"></i> 750+ Bed On-Campus Teaching Hospital</h4>\n            <p class=\"text-muted\">Hands-on clinical exposure for medical, nursing, dental, and paramedical students within the university hospital ecosystem providing round-the-clock healthcare services.</p>\n        </div>\n    </div>\n</div>\n<h3 class=\"text-navy fw-bold mt-4 mb-3\">Holistic Campus Ecosystem</h3>\n<p>SRK University offers a dynamic learning environment that blends rigorous academics with vibrant campus life, athletic excellence, entrepreneurship incubation, and community engagement. Over 15,000+ proud alumni represent SRKU across top global organizations and research institutions.</p>\n', 'Discover why SRK University Bhopal is the top placement university in MP with UGC recognition, 42+ labs, and 94% placements.', 'published', '2026-08-21 09:11:29', 'Why Choose SRK University?', 'Pioneering Industry-Driven Pedagogy, World-Class Labs & Global Careers', 'assets/uploads/2026/07/campus-1.webp'),
(22, 'Vision & Mission', 'vision-mission', '\n<div class=\"row g-4 mb-4\">\n    <div class=\"col-md-6\">\n        <div class=\"p-4 rounded-4 bg-light border-start border-4 border-danger h-100\">\n            <h3 class=\"text-navy fw-bold mb-3\"><i class=\"fas fa-eye text-danger me-2\"></i> Our Vision</h3>\n            <p class=\"text-dark\" style=\"line-height: 1.8;\">To emerge as a premier global institution of higher education and advanced research, fostering transformative learning, innovation, and value-based professional leadership for sustainable societal development.</p>\n        </div>\n    </div>\n    <div class=\"col-md-6\">\n        <div class=\"p-4 rounded-4 bg-light border-start border-4 border-warning h-100\">\n            <h3 class=\"text-navy fw-bold mb-3\"><i class=\"fas fa-bullseye text-warning me-2\"></i> Our Mission</h3>\n            <ul class=\"text-dark mb-0 ps-3\" style=\"line-height: 1.8;\">\n                <li>Deliver high-impact multidisciplinary academic programs aligned with global industry demands.</li>\n                <li>Conduct cutting-edge scientific, clinical, and technological research solving real-world challenges.</li>\n                <li>Nurture entrepreneurial mindsets, ethical values, and holistic personality development.</li>\n                <li>Provide accessible, inclusive, and affordable quality higher education to diverse communities.</li>\n            </ul>\n        </div>\n    </div>\n</div>\n<h3 class=\"text-navy fw-bold mt-4 mb-3\">Core Institutional Values</h3>\n<div class=\"d-flex flex-wrap gap-2\">\n    <span class=\"badge bg-navy px-3 py-2 fs-6\">Academic Rigor</span>\n    <span class=\"badge bg-danger px-3 py-2 fs-6\">Innovation & Research</span>\n    <span class=\"badge bg-warning text-dark px-3 py-2 fs-6\">Ethical Leadership</span>\n    <span class=\"badge bg-success px-3 py-2 fs-6\">Social Responsibility</span>\n    <span class=\"badge bg-secondary px-3 py-2 fs-6\">Student-Centricity</span>\n</div>\n', 'Vision and Mission statement of Sarvepalli Radhakrishnan University Bhopal.', 'published', '2026-08-21 09:11:29', 'Vision & Mission Statement', 'Our Institutional Charter, Core Values & Strategic Academic Roadmap', 'assets/uploads/2026/07/library.webp'),
(23, 'Vision & Mission (Original Slug)', 'srk-university-vision-and-mission', '\n<div class=\"row g-4 mb-4\">\n    <div class=\"col-md-6\">\n        <div class=\"p-4 rounded-4 bg-light border-start border-4 border-danger h-100\">\n            <h3 class=\"text-navy fw-bold mb-3\"><i class=\"fas fa-eye text-danger me-2\"></i> Our Vision</h3>\n            <p class=\"text-dark\" style=\"line-height: 1.8;\">To emerge as a premier global institution of higher education and advanced research, fostering transformative learning, innovation, and value-based professional leadership for sustainable societal development.</p>\n        </div>\n    </div>\n    <div class=\"col-md-6\">\n        <div class=\"p-4 rounded-4 bg-light border-start border-4 border-warning h-100\">\n            <h3 class=\"text-navy fw-bold mb-3\"><i class=\"fas fa-bullseye text-warning me-2\"></i> Our Mission</h3>\n            <ul class=\"text-dark mb-0 ps-3\" style=\"line-height: 1.8;\">\n                <li>Deliver high-impact multidisciplinary academic programs aligned with global industry demands.</li>\n                <li>Conduct cutting-edge scientific, clinical, and technological research solving real-world challenges.</li>\n                <li>Nurture entrepreneurial mindsets, ethical values, and holistic personality development.</li>\n                <li>Provide accessible, inclusive, and affordable quality higher education to diverse communities.</li>\n            </ul>\n        </div>\n    </div>\n</div>\n', 'Vision and Mission statement of Sarvepalli Radhakrishnan University Bhopal.', 'published', '2026-08-21 09:11:29', 'Vision & Mission Statement', 'Institutional Charter, Core Values & Strategic Academic Roadmap', 'assets/uploads/2026/07/library.webp'),
(24, 'Accreditation & Statutory Approvals', 'accreditation', '\n<h3 class=\"text-navy fw-bold mb-3\">Statutory Recognitions & Approvals</h3>\n<p class=\"lead text-muted\">Sarvepalli Radhakrishnan University is established by Madhya Pradesh Legislative Act and recognized by all apex regulatory bodies in India.</p>\n<div class=\"row g-3 my-4\">\n    <div class=\"col-md-4\"><div class=\"p-3 border rounded-3 text-center bg-light\"><strong>UGC</strong><br><small class=\"text-muted\">Section 2(f) Recognized</small></div></div>\n    <div class=\"col-md-4\"><div class=\"p-3 border rounded-3 text-center bg-light\"><strong>AICTE</strong><br><small class=\"text-muted\">Engineering & Management</small></div></div>\n    <div class=\"col-md-4\"><div class=\"p-3 border rounded-3 text-center bg-light\"><strong>PCI</strong><br><small class=\"text-muted\">Pharmacy Programs</small></div></div>\n    <div class=\"col-md-4\"><div class=\"p-3 border rounded-3 text-center bg-light\"><strong>INC & MPNRC</strong><br><small class=\"text-muted\">Nursing Degree Programs</small></div></div>\n    <div class=\"col-md-4\"><div class=\"p-3 border rounded-3 text-center bg-light\"><strong>BCI</strong><br><small class=\"text-muted\">Bar Council of India</small></div></div>\n    <div class=\"col-md-4\"><div class=\"p-3 border rounded-3 text-center bg-light\"><strong>NMC / AYUSH</strong><br><small class=\"text-muted\">Medical & Ayurvedic Councils</small></div></div>\n</div>\n<h4 class=\"text-navy fw-bold mt-4 mb-2\">Statutory Documents & Disclosure Reports</h4>\n<ul class=\"list-group list-group-flush mb-4\">\n    <li class=\"list-group-item d-flex justify-content-between align-items-center\"><i class=\"fas fa-file-pdf text-danger me-2\"></i> NIRF 2026 Institutional Ranking Report <a href=\"assets/uploads/2026/07/NIRF-2026.pdf\" target=\"_blank\" class=\"btn btn-sm btn-outline-danger\">Download PDF</a></li>\n    <li class=\"list-group-item d-flex justify-content-between align-items-center\"><i class=\"fas fa-file-pdf text-danger me-2\"></i> Institutional Development Plan (IDP) <a href=\"assets/uploads/2026/07/IDP.pdf\" target=\"_blank\" class=\"btn btn-sm btn-outline-danger\">Download PDF</a></li>\n    <li class=\"list-group-item d-flex justify-content-between align-items-center\"><i class=\"fas fa-file-pdf text-danger me-2\"></i> Council Of Technical Education (EOA Report) <a href=\"assets/uploads/2026/07/EOA-Report.pdf\" target=\"_blank\" class=\"btn btn-sm btn-outline-danger\">Download PDF</a></li>\n</ul>\n', 'Statutory recognitions, UGC approvals, AICTE EOA reports, and accreditations of SRKU.', 'published', '2026-08-21 09:11:29', 'Accreditation & Approvals', 'Recognized by UGC, AICTE, PCI, INC, BCI, NMC & Statutory Councils', 'assets/uploads/2026/07/campus-1.webp'),
(25, 'Board of Management & Leadership', 'board-of-management', '\n<div class=\"row g-4 mb-4\">\n    <div class=\"col-md-6\">\n        <div class=\"p-4 rounded-4 bg-light border text-center\">\n            <img src=\"assets/uploads/2026/07/ruchichaubey.webp\" class=\"rounded-circle mb-3\" style=\"width:120px; height:120px; object-fit:cover; border:3px solid var(--srku-gold);\" alt=\"Chancellor\">\n            <h4 class=\"text-navy fw-bold mb-1\">Dr. Sunil Kapoor</h4>\n            <div class=\"text-danger fw-semibold mb-2\">Founder Chairman & Chancellor</div>\n            <p class=\"text-muted small\">\"Empowering the next generation with cutting-edge academic pedagogy, research infrastructure, and human values.\"</p>\n        </div>\n    </div>\n    <div class=\"col-md-6\">\n        <div class=\"p-4 rounded-4 bg-light border text-center\">\n            <img src=\"assets/uploads/2026/07/001.webp\" class=\"rounded-circle mb-3\" style=\"width:120px; height:120px; object-fit:cover; border:3px solid var(--srku-gold);\" alt=\"Vice Chancellor\">\n            <h4 class=\"text-navy fw-bold mb-1\">Prof. (Dr.) Brijendra Singh</h4>\n            <div class=\"text-danger fw-semibold mb-2\">Vice Chancellor</div>\n            <p class=\"text-muted small\">\"Fostering multidisciplinary excellence, academic innovation, and industry alignment across all faculties.\"</p>\n        </div>\n    </div>\n</div>\n<h4 class=\"text-navy fw-bold mt-4 mb-3\">Statutory Governance Bodies</h4>\n<p class=\"text-muted\">SRK University operates through apex statutory committees ensuring transparency and regulatory adherence:</p>\n<div class=\"row g-2\">\n    <div class=\"col-md-6\"><a href=\"assets/uploads/2026/07/Governing-Body.pdf\" target=\"_blank\" class=\"btn btn-light border w-100 text-start py-2\"><i class=\"fas fa-file-pdf text-danger me-2\"></i> Governing Body Constitution</a></div>\n    <div class=\"col-md-6\"><a href=\"assets/uploads/2026/07/Board-of-Management.pdf\" target=\"_blank\" class=\"btn btn-light border w-100 text-start py-2\"><i class=\"fas fa-file-pdf text-danger me-2\"></i> Board of Management Members</a></div>\n    <div class=\"col-md-6\"><a href=\"assets/uploads/2026/07/Academic-Council.pdf\" target=\"_blank\" class=\"btn btn-light border w-100 text-start py-2\"><i class=\"fas fa-file-pdf text-danger me-2\"></i> Academic Council Members</a></div>\n    <div class=\"col-md-6\"><a href=\"assets/uploads/2026/07/Finance-Committee.pdf\" target=\"_blank\" class=\"btn btn-light border w-100 text-start py-2\"><i class=\"fas fa-file-pdf text-danger me-2\"></i> Finance Committee</a></div>\n</div>\n', 'Board of management and leadership members of Sarvepalli Radhakrishnan University.', 'published', '2026-08-21 09:11:29', 'Board of Management', 'Academic Governance, University Leadership & Deans Council', 'assets/uploads/2026/07/campus-1.webp'),
(26, 'Constituent Units & Colleges', 'constituent-unit', '\n<p class=\"lead text-muted mb-4\">SRK University encompasses 20 constituent institutes and faculties delivering industry-ready degree programs in Engineering, Medicine, Pharmacy, Law, Agriculture, Management, Nursing, Paramedical, and Science.</p>\n<div class=\"d-flex gap-3 mb-4\">\n    <a href=\"departments.php\" class=\"btn btn-danger\"><i class=\"fas fa-th-large me-1\"></i> View All 20 Constituent Faculties</a>\n    <a href=\"courses.php\" class=\"btn btn-outline-danger\"><i class=\"fas fa-graduation-cap me-1\"></i> Browse 56+ Programmes</a>\n</div>\n', 'Comprehensive directory of constituent colleges and faculties at SRK University.', 'published', '2026-08-21 09:11:29', 'Constituent Units & Colleges', '20 Specialized Constituent Colleges Offering 56+ Degree Programs', 'assets/uploads/2026/07/dept_engg.jpg'),
(27, 'Admission Guidelines 2026-27', 'admission', '\n<div class=\"row g-4 mb-4\">\n    <div class=\"col-md-4\">\n        <div class=\"p-3 bg-light rounded-3 text-center border\">\n            <span class=\"badge bg-danger rounded-circle p-3 fs-5 mb-2\">1</span>\n            <h5 class=\"fw-bold text-navy\">Apply Online</h5>\n            <p class=\"small text-muted mb-0\">Fill the admission registration form with your personal and academic credentials.</p>\n        </div>\n    </div>\n    <div class=\"col-md-4\">\n        <div class=\"p-3 bg-light rounded-3 text-center border\">\n            <span class=\"badge bg-danger rounded-circle p-3 fs-5 mb-2\">2</span>\n            <h5 class=\"fw-bold text-navy\">Document Verification</h5>\n            <p class=\"small text-muted mb-0\">Submit marksheets, identity verification, and entrance scorecards for verification.</p>\n        </div>\n    </div>\n    <div class=\"col-md-4\">\n        <div class=\"p-3 bg-light rounded-3 text-center border\">\n            <span class=\"badge bg-danger rounded-circle p-3 fs-5 mb-2\">3</span>\n            <h5 class=\"fw-bold text-navy\">Seat Confirmation</h5>\n            <p class=\"small text-muted mb-0\">Pay admission fees, receive allotment letter, and commence your academic orientation.</p>\n        </div>\n    </div>\n</div>\n<div class=\"text-center my-4\">\n    <a href=\"contact.php#apply\" class=\"btn btn-danger px-5 py-2 fw-bold rounded-pill\"><i class=\"fas fa-paper-plane me-1\"></i> Start Online Application Now</a>\n</div>\n', 'Admission criteria, eligibility, application process for SRK University Bhopal.', 'published', '2026-08-21 09:11:29', 'Admission Guidelines 2026-27', 'Online Application Process, Eligibility, Scholarships & Fee Schedule', 'assets/uploads/2026/07/campus-1.webp');

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
(1, 'helpline', '0755 - 4911204'),
(2, 'email', 'exam@srku.edu.in'),
(3, 'address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026'),
(4, 'ticker_text', 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for UG, PG & PhD Courses'),
(5, 'site_title', 'Sarvepalli Radhakrishnan University (SRKU), Bhopal'),
(6, 'admissions_phone', '+91 755 4911204 / 94250 12345'),
(7, 'highest_package', '12 LPA'),
(8, 'placement_record', '94%'),
(9, 'recruiting_partners', '120+'),
(10, 'total_labs', '42+'),
(11, 'facebook_url', 'https://facebook.com/srku.bhopal'),
(12, 'instagram_url', 'https://instagram.com/srku.bhopal'),
(13, 'youtube_url', 'https://youtube.com/@srkuniversity'),
(14, 'linkedin_url', 'https://linkedin.com/school/srk-university');

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
(1, 'admin', '$2y$10$H05AUFwdUNtpDFL0H8RknOU/j7WSj2yitQaL8FuRQ69WpKONoLyqa', 'admin@srku.edu.in', '2026-08-07 10:32:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
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
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
