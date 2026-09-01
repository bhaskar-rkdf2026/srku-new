<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? $_GET['doc'] ?? '');
$fileParam = sanitize($_GET['file'] ?? '');

$documentsRegistry = [
    'prospectus' => [
        'title' => 'University Prospectus 2026-27',
        'category' => 'Admission',
        'subtitle' => 'Official Academic Prospectus, Disciplines, Infrastructure & Campus Life',
        'pdf_path' => 'assets/uploads/2026/07/Prospectus.pdf',
        'description' => 'Official university prospectus containing detailed information regarding academic departments, undergraduate, postgraduate and doctoral programmes, campus facilities, faculty profiles, and student amenities for the academic session 2026-27.',
        'highlights' => [
            'Overview of 25+ Constituent Colleges, Institutes and University Faculties.',
            'Undergraduate, Postgraduate, Diploma and Doctoral degree offerings.',
            'Modern laboratory infrastructure, Central Computing Facility and 750+ Bed Teaching Hospital.',
            'Scholarships, campus placement records, and student development initiatives.'
        ]
    ],
    'admission-process-guidelines' => [
        'title' => 'Admission Process Guidelines 2026-27',
        'category' => 'Admission',
        'subtitle' => 'Step-by-Step Admission Procedure, Verification Norms & Schedule',
        'pdf_path' => 'assets/uploads/2026/07/Admission-ProcessGuidelines.pdf',
        'description' => 'Comprehensive institutional guidelines outlining the eligibility verification, document scrutiny, counseling schedule, merit list criteria, and fee payment instructions for candidates taking admission at SRKU.',
        'highlights' => [
            'Guidelines for online and offline candidate registration.',
            'Verification checklist for qualifying marks-sheets and category certificates.',
            'Seat allotment procedure and fee deposition timelines.',
            'Orientation and academic commencement instructions.'
        ]
    ],
    'fee-refund-policy' => [
        'title' => 'Fee Refund Policy',
        'category' => 'Admission',
        'subtitle' => 'University Fee Cancellation & Refund Regulations Compliant with UGC Norms',
        'pdf_path' => 'assets/uploads/2026/07/Fee-Refund-Policy-2024-25.pdf',
        'description' => 'Official policy governing the procedure, timelines, deductions, and processing of fee refunds for candidates seeking cancellation or withdrawal of admission as per UGC and statutory council regulations.',
        'highlights' => [
            'Standardized refund slabs based on formal withdrawal application submission dates.',
            'Deduction rules and processing mechanism through banking channels.',
            'Refund procedure for caution money and hostel/transport deposits.',
            'Grievance redressal channel for admission cancellation requests.'
        ]
    ],
    'officers-of-university' => [
        'title' => 'Officers of the University',
        'category' => 'Administration',
        'subtitle' => 'Statutory Officers, Leadership & Administrative Authorities',
        'pdf_path' => 'assets/uploads/2026/07/OfficersofUniversity.pdf',
        'description' => 'Official gazetted directory of statutory officers of Sarvepalli Radhakrishnan University including the Chancellor, Vice-Chancellor, Registrar, Chief Finance Officer, Deans, and Examination Controller.',
        'highlights' => [
            'Statutory administrative framework and executive hierarchy.',
            'Profiles and designations of apex university officers.',
            'Official contact channels and administrative responsibilities.',
            'Compliance with State University Act and Ordinances.'
        ]
    ],
    'governing-body' => [
        'title' => 'Governing Body',
        'category' => 'Administration',
        'subtitle' => 'Constitution, Apex Governance & Members of University Governing Body',
        'pdf_path' => 'assets/uploads/2026/07/Governing-Body.pdf',
        'description' => 'Official constitution and list of distinguished members constituting the Governing Body of Sarvepalli Radhakrishnan University, responsible for strategic policy formulation and institutional stewardship.',
        'highlights' => [
            'Apex decision-making authority of the University.',
            'Distinguished academicians, administrators, and industry experts.',
            'Approval of university budgets, development plans, and expansions.',
            'Institutional vision and academic governance.'
        ]
    ],
    'board-of-management' => [
        'title' => 'Board of Management',
        'category' => 'Administration',
        'subtitle' => 'Executive Governance, Appointments & Administrative Affairs',
        'pdf_path' => 'assets/uploads/2026/07/Board-of-Management.pdf',
        'description' => 'Official documentation outlining the composition and executive powers of the Board of Management, overseeing overall administration, faculty recruitment, infrastructure creation, and operational governance.',
        'highlights' => [
            'Executive body responsible for administrative operations and management.',
            'Review and sanction of academic appointments and cadre approvals.',
            'Establishment of departments, centers, and infrastructure expansion.',
            'Execution of statutory regulations and ordinances.'
        ]
    ],
    'finance-committee' => [
        'title' => 'Finance Committee',
        'category' => 'Administration',
        'subtitle' => 'Financial Oversight, Annual Budgeting & Audit Control',
        'pdf_path' => 'assets/uploads/2026/07/Finance-Committee.pdf',
        'description' => 'Constitution and membership of the University Finance Committee, entrusted with annual financial planning, budget allocations, expenditure monitoring, and internal financial audits.',
        'highlights' => [
            'Scrutiny of annual budget estimates and capital allocations.',
            'Monitoring of institutional financial health, grants, and audit reports.',
            'Resource allocation for laboratory modernization and research seed grants.',
            'Compliance with statutory accounting and financial norms.'
        ]
    ],
    'academic-councils' => [
        'title' => 'Academic Council',
        'category' => 'Administration',
        'subtitle' => 'Apex Academic Authority, Curriculum Standards & Examination Framework',
        'pdf_path' => 'assets/uploads/2026/07/ACADEMIC-COUNCIL-20.pdf.pdf',
        'description' => 'Official listing of members constituting the Academic Council of SRKU, responsible for maintaining high academic standards, curriculum revisions, pedagogical innovations, and examination regulations.',
        'highlights' => [
            'Formulation and approval of academic regulations and degree schemes.',
            'Curriculum development in alignment with NEP 2020 guidelines.',
            'Approval of new faculties, courses, and interdisciplinary programmes.',
            'Evaluation standards, credit frameworks, and grading systems.'
        ]
    ],
    'board-of-studies' => [
        'title' => 'Board of Studies',
        'category' => 'Administration',
        'subtitle' => 'Departmental Academic Panels, Course Syllabus & Curriculum Panels',
        'pdf_path' => 'assets/uploads/2026/07/BoardofStudies.pdf',
        'description' => 'Department-wise committees of the Board of Studies (BOS) comprising subject experts and senior faculty responsible for designing, updating, and evaluating course curricula across disciplines.',
        'highlights' => [
            'Periodic syllabus revision aligned with emerging industrial requirements.',
            'Design of practical experiments, project modules, and internship structures.',
            'Prescription of textbook references, e-learning resources, and research papers.',
            'Continuous evaluation schemes and question paper frameworks.'
        ]
    ],
    'internal-complaint-committee' => [
        'title' => 'Internal Complaint Committee (ICC)',
        'category' => 'Administration',
        'subtitle' => 'Grievance Redressal, Gender Sensitization & Women Safety at Workplace',
        'pdf_path' => 'assets/uploads/2026/07/Internal-Complaint-Committee.pdf',
        'description' => 'Official constitution, mandate, and contact details of the Internal Complaint Committee established in compliance with POSH Act regulations to ensure a secure, respectful, and gender-inclusive campus environment.',
        'highlights' => [
            'Prevention, prohibition, and redressal of sexual harassment and discrimination.',
            'Confidential and time-bound inquiry mechanism for registered grievances.',
            'Regular gender-sensitization workshops, awareness drives, and counseling support.',
            'Zero tolerance towards harassment across campus facilities and hostels.'
        ]
    ],
    'academic-leadership' => [
        'title' => 'Academic Leadership',
        'category' => 'Administration',
        'subtitle' => 'Deans of Faculties, Institute Principals & Departmental Heads',
        'pdf_path' => 'assets/uploads/2026/07/AcademicLeadership.pdf',
        'description' => 'Official directory of Deans, Directors, and Principals steering academic excellence across Engineering, Medical, Dental, Pharmacy, Nursing, Law, Agriculture, Management, and Science faculties.',
        'highlights' => [
            'Leadership profiles of constituent college heads and faculty deans.',
            'Directorial oversight of research centers, hospital administration, and labs.',
            'Industry collaboration, corporate liaison, and global partnerships.',
            'Mentorship of doctoral research scholars and faculty development.'
        ]
    ],
    'phd-admission-policy' => [
        'title' => 'Ph.D. Admission Policy & Ordinance',
        'category' => 'Research',
        'subtitle' => 'UGC Minimum Standards for the Award of Ph.D. Degree Ordinance',
        'pdf_path' => 'assets/uploads/pdf/phd-admission-policy.pdf',
        'description' => 'Official university ordinance governing Doctor of Philosophy (Ph.D.) admissions, eligibility standards, coursework structure, Research Advisory Committee (RAC) evaluations, and thesis submission.',
        'highlights' => [
            'Eligibility norms compliant with UGC / AICTE and Apex Regulatory Councils.',
            'Doctoral Entrance Test (DET) guidelines and interview evaluation criteria.',
            'Mandatory Pre-Ph.D. coursework, research ethics, and publication mandates.',
            'Research synopsis approval, progress review, and dissertation examination.'
        ]
    ],
    'research-development-cell' => [
        'title' => 'Research & Development Cell (RDC)',
        'category' => 'Research',
        'subtitle' => 'Research Promotion, Project Grants, Publications & Innovations',
        'pdf_path' => 'assets/uploads/2026/07/researchdevelopmentcell.pdf',
        'description' => 'Documentation outlining the objectives, organizational hierarchy, and operational framework of the University Research & Development Cell fostering high-impact research, external grants, and technology innovation.',
        'highlights' => [
            'Coordination of sponsored research projects with DST, SERB, ICMR, and AICTE.',
            'Facilitation of multidisciplinary research groups and innovation clusters.',
            'Research seed grants for young faculty and doctoral scholars.',
            'Incentive schemes for SCI/Scopus indexed journal publications and patents.'
        ]
    ],
    'university-research-policy' => [
        'title' => 'University Research Policy',
        'category' => 'Research',
        'subtitle' => 'Institutional Guidelines for Ethics, Publications, IPR & Seed Funding',
        'pdf_path' => 'assets/uploads/2026/07/university_research_policy.pdf',
        'description' => 'Comprehensive policy governing research standards, ethical clearances, intellectual property management, patent filings, research incentives, and collaborative research initiatives at SRKU.',
        'highlights' => [
            'Code of ethics in scientific research and academic publishing.',
            'Intellectual Property Rights (IPR) filing support and patent commercialization.',
            'Financial incentives for high-impact research publications and books.',
            'Guidelines for collaborative research with national and international bodies.'
        ]
    ],
    'central-facilities-research' => [
        'title' => 'Central Facilities for Research & Development',
        'category' => 'Research',
        'subtitle' => 'Advanced Instrumentation, Central Computing & Laboratory Infrastructure',
        'pdf_path' => 'assets/uploads/2026/07/Central-Facilities-for-Research-and-Development.pdf',
        'description' => 'Overview of high-end analytical equipment, computational clusters, central research labs, animal house, and specialized instrumentation accessible to university researchers and doctoral scholars.',
        'highlights' => [
            'Advanced analytical instrumentation across Pharmacy, Medical, and Science labs.',
            'High-performance computing laboratory and simulation software tools.',
            'CPCSEA approved Animal House and Central Biosafety facilities.',
            'Open access facility usage guidelines for scholars and faculty.'
        ]
    ],
    'ethics-board' => [
        'title' => 'Ethics Board to Maintain Research Integrity',
        'category' => 'Research',
        'subtitle' => 'Institutional Ethics Committee, Bioethics & Research Integrity Guidelines',
        'pdf_path' => 'assets/uploads/2026/07/Constitution-of-Ethics-Board.pdf',
        'description' => 'Constitution and code of practice of the Institutional Ethics Board monitoring research integrity, ethical clearance for human and animal trials, and anti-plagiarism compliance across all disciplines.',
        'highlights' => [
            'Ethical scrutiny of biomedical, clinical, and pharmacological research proposals.',
            'Strict adherence to ICMR, CPCSEA, and global bioethics guidelines.',
            'Plagiarism checking protocol for dissertations, papers, and synopsis.',
            'Promoting transparent, responsible, and ethical conduct in scientific inquiry.'
        ]
    ],
    'consultancy-projects' => [
        'title' => 'Consultancy Projects & Guidelines',
        'category' => 'Research',
        'subtitle' => 'Industry Consultancy, Technical Solutions & Technology Transfer',
        'pdf_path' => 'assets/uploads/2026/07/consultancy-projects.pdf',
        'description' => 'Framework for faculty and departments offering specialized industrial consultancy, testing services, corporate training, and technical advisory to government and private sector organizations.',
        'highlights' => [
            'Revenue sharing, institutional overheads, and project administration norms.',
            'Material testing, drug formulation analysis, and software development services.',
            'Corporate customized training and skill development programs.',
            'MoUs with leading industrial firms and technology corporations.'
        ]
    ],
    'phd-scholars-pursuing' => [
        'title' => 'Ph.D. Scholars Currently Enrolled',
        'category' => 'Research',
        'subtitle' => 'Official Registry of Active Doctoral Research Scholars across Disciplines',
        'pdf_path' => 'assets/uploads/pdf/phd-scholars-pursuing.pdf',
        'description' => 'Official university registry and public disclosure of active doctoral research scholars pursuing Ph.D. programmes along with their department, guide details, and registration session.',
        'highlights' => [
            'Public compliance record as per UGC minimum standard disclosure mandates.',
            'Discipline-wise distribution of currently enrolled doctoral scholars.',
            'Details of approved research supervisors and recognized guides.',
            'Research progress monitoring and Departmental Research Committee tracking.'
        ]
    ],
    'phd-scholars-completed' => [
        'title' => 'Ph.D. Awarded Scholars List',
        'category' => 'Research',
        'subtitle' => 'Official Register of Conferred Doctor of Philosophy (Ph.D.) Degrees',
        'pdf_path' => 'assets/uploads/pdf/phd-scholars-completed.pdf',
        'description' => 'Official historical record of doctoral research scholars awarded Ph.D. degrees by Sarvepalli Radhakrishnan University across Engineering, Pharmacy, Management, Sciences, and Healthcare.',
        'highlights' => []
    ],
    'nirf-2026' => [
        'title' => 'NIRF 2026 Data Report',
        'category' => 'Accreditation',
        'subtitle' => 'National Institutional Ranking Framework (NIRF) Disclosure 2026',
        'pdf_path' => 'assets/uploads/2026/07/NIRF-2026.pdf',
        'description' => 'Official National Institutional Ranking Framework (NIRF) data submission report and institutional disclosures of Sarvepalli Radhakrishnan University.',
        'highlights' => []
    ],
    'recognition-approval' => [
        'title' => 'Recognition & Statutory Approvals',
        'category' => 'Accreditation',
        'subtitle' => 'UGC, AICTE, PCI, INC, BCI, AYUSH & Statutory Council Approvals',
        'pdf_path' => 'assets/uploads/2026/07/Recognition-Approval.pdf',
        'description' => 'Statutory university approvals, gazetted recognitions, and council accreditations validating degree conferment authority and academic compliance.',
        'highlights' => []
    ],
    'institutional-development-plan' => [
        'title' => 'Institutional Development Plan (IDP)',
        'category' => 'Committees',
        'subtitle' => 'Strategic Institutional Growth, Academic Expansion & Excellence Roadmap',
        'pdf_path' => 'assets/uploads/2026/07/Institutional-Development-Plan.pdf',
        'description' => 'Official Institutional Development Plan delineating long-term academic excellence, infrastructure augmentation, and skill development goals.',
        'highlights' => []
    ],
    'council-of-technical-education' => [
        'title' => 'Council of Technical Education (EOA Report)',
        'category' => 'Committees',
        'subtitle' => 'AICTE Extension of Approval (EOA) Compliance & Sanctioned Intakes',
        'pdf_path' => 'assets/uploads/2026/07/EOA_Report_2020-21-1.pdf',
        'description' => 'Official AICTE Extension of Approval (EOA) record specifying approved technical, engineering, and management programs and approved student intakes.',
        'highlights' => []
    ],
    'student-grievance-committee' => [
        'title' => 'Student Grievance Redressal Committee',
        'category' => 'Act & Statutes',
        'subtitle' => 'Institutional Student Grievance Redressal Committee & Regulations',
        'pdf_path' => 'assets/uploads/2026/07/Student_Grievance_Committee.pdf',
        'description' => 'Official constitution, composition, and redressal procedure of the Student Grievance Redressal Committee (SGRC) as per UGC norms.',
        'highlights' => []
    ],
    'anti-ragging' => [
        'title' => 'Anti-Ragging Regulations & Committee',
        'category' => 'Act & Statutes',
        'subtitle' => 'Zero Tolerance Policy, Anti-Ragging Squad & Student Welfare Mandate',
        'pdf_path' => 'assets/uploads/2026/07/AntiRagging.pdf',
        'description' => 'Strict anti-ragging policies, monitoring squads, helpline numbers, and statutory regulations compliant with UGC and Supreme Court mandates.',
        'highlights' => []
    ],
    'sc-st-grievance-committee' => [
        'title' => 'SC / ST Grievance Committee',
        'category' => 'Act & Statutes',
        'subtitle' => 'Prevention of Caste Discrimination & SC/ST Cell Oversight',
        'pdf_path' => 'assets/uploads/2026/07/SC_ST_Grievance_committee.pdf',
        'description' => 'Constitution and functional guidelines of the SC/ST Grievance Committee ensuring equal opportunity and prevention of atrocities.',
        'highlights' => []
    ],
    'obc-minority' => [
        'title' => 'OBC & Minority Cell Committee',
        'category' => 'Act & Statutes',
        'subtitle' => 'Welfare, Equal Opportunity & Support for OBC & Minority Students',
        'pdf_path' => 'assets/uploads/2026/07/OBC-Minority.pdf',
        'description' => 'Official cell constituted to oversee welfare schemes, scholarships, and academic support for OBC and Minority community students.',
        'highlights' => []
    ],
    'women-grievance-committee' => [
        'title' => 'Women Grievance Committee',
        'category' => 'Act & Statutes',
        'subtitle' => 'Women Empowerment, Safety & Internal Complaint Redressal',
        'pdf_path' => 'assets/uploads/2026/07/women-grievance-committee.pdf',
        'description' => 'Institutional cell dedicated to promoting gender equality, addressing grievances, and ensuring women safety across campus.',
        'highlights' => []
    ],
    'equal-opportunity-cell' => [
        'title' => 'Equal Opportunity Cell',
        'category' => 'Act & Statutes',
        'subtitle' => 'Inclusive Campus Environment, Accessibility & Student Support',
        'pdf_path' => 'assets/uploads/2026/07/EqualOppurtunityCell.pdf',
        'description' => 'Mandate and operations of the Equal Opportunity Cell facilitating holistic support for persons with disabilities and marginalized groups.',
        'highlights' => []
    ],
    'university-ordinance' => [
        'title' => 'University Ordinance',
        'category' => 'University Ordinance',
        'subtitle' => 'Statutory Ordinances, Academic Regulations & Examination Acts',
        'pdf_path' => 'assets/uploads/2026/07/university-ordinance.pdf',
        'description' => 'Official gazetted University Ordinances governing degree curricula, admissions, evaluation standards, and faculty administration.',
        'highlights' => []
    ],
    'ordinance-93-100' => [
        'title' => 'Subsequent Ordinance (93 to 100)',
        'category' => 'University Ordinance',
        'subtitle' => 'Gazette Notifications for Specialized Academic Ordinances 93-100',
        'pdf_path' => 'assets/uploads/2026/07/ordinance-93-100.pdf',
        'description' => 'Official subsequent gazetted ordinances covering specialized technical, healthcare, and multidisciplinary degree provisions.',
        'highlights' => []
    ],
    'details-of-academic-programmes' => [
        'title' => 'Details of Academic Programmes',
        'category' => 'Academics',
        'subtitle' => 'Undergraduate, Postgraduate, Diploma & Doctoral Programmes Directory',
        'pdf_path' => 'assets/uploads/2026/07/Details-of-Academic-Programmes.pdf',
        'description' => 'Comprehensive academic programme directory detailing course nomenclature, duration, intake capacity, and eligibility parameters across faculties.',
        'highlights' => []
    ],
    'statutes-ordinances-academics-examination' => [
        'title' => 'Statutes & Ordinances Pertaining to Academics & Examination',
        'category' => 'Academics',
        'subtitle' => 'Academic Framework, Evaluation Standards, Grading & Conduct of Examinations',
        'pdf_path' => 'assets/uploads/2026/07/statutes-ordinances-pertaining-to-academics-examination.pdf',
        'description' => 'Official university statutes and ordinances regulating academic curricula, grading systems, continuous evaluation, and terminal examination protocols.',
        'highlights' => []
    ],
    'constituent-units-departments' => [
        'title' => 'Schools, Departments & Centres Directory',
        'category' => 'Academics',
        'subtitle' => 'Directory of Constituent Institutes, Academic Schools & Specialist Centres',
        'pdf_path' => 'assets/uploads/2026/07/Constituent-unitsDepartment.pdf',
        'description' => 'Official institutional directory of constituent colleges, departments, specialized research centres, and hospital units functioning under SRKU.',
        'highlights' => []
    ],
    'department-wise-faculty-details' => [
        'title' => 'Faculty & Academic Staff Details',
        'category' => 'Academics',
        'subtitle' => 'Discipline-Wise Directory of Professors, Associate Professors & Assistant Professors',
        'pdf_path' => 'assets/uploads/2026/07/department-wise-faculty-details.pdf',
        'description' => 'Official faculty directory showcasing qualified teaching faculty, designations, academic credentials, and department allocations.',
        'highlights' => []
    ],
    'iqac' => [
        'title' => 'Internal Quality Assurance Cell (IQAC)',
        'category' => 'Academics',
        'subtitle' => 'Quality Enhancement Initiatives, Academic Audits & Compliance Framework',
        'pdf_path' => 'assets/uploads/2026/07/IQAC.pdf',
        'description' => 'Official constitution, quality policies, and academic audit guidelines of the University Internal Quality Assurance Cell (IQAC).',
        'highlights' => []
    ],
    'university-library' => [
        'title' => 'University Central Library & Learning Resource Centre',
        'category' => 'Academics',
        'subtitle' => 'Learning Resources, E-Journals, Digital Library & Book Bank Facilities',
        'pdf_path' => 'assets/uploads/2026/07/UniversityLibrary.pdf',
        'description' => 'Overview of central library resources, print volumes, national & international e-journal subscriptions, DELNET access, and reading room services.',
        'highlights' => []
    ]
];

// Match by slug or fallback
$doc = null;
if (!empty($slug) && isset($documentsRegistry[$slug])) {
    $doc = $documentsRegistry[$slug];
} elseif (!empty($fileParam)) {
    foreach ($documentsRegistry as $k => $item) {
        if (basename($item['pdf_path']) === basename($fileParam) || $item['pdf_path'] === $fileParam) {
            $doc = $item;
            $slug = $k;
            break;
        }
    }
    if (!$doc) {
        // Fallback for custom or direct PDF paths
        $fileName = basename($fileParam);
        $cleanTitle = ucwords(str_replace(['-', '_', '.pdf'], ' ', $fileName));
        $doc = [
            'title' => $cleanTitle,
            'category' => 'University Document',
            'subtitle' => 'Official University Publication & Information Document',
            'pdf_path' => $fileParam,
            'description' => 'Official published document of Sarvepalli Radhakrishnan University (SRKU), Bhopal for student and faculty reference.',
            'highlights' => [
                'Official publication approved by university authorities.',
                'Prescribed format, guidelines, and compliance records.',
                'Available for public reference and direct download.'
            ]
        ];
    }
}

if (!$doc) {
    // Default to first document
    $doc = reset($documentsRegistry);
    $slug = key($documentsRegistry);
}

$pageTitle = sanitize($doc['title']) . " | Official University Document & PDF | SRKU Bhopal";
$pageDesc = sanitize($doc['description']);
$pageKeywords = sanitize($doc['title']) . ", SRKU PDF, Official Document SRKU Bhopal, " . sanitize($doc['category']);
$activeNav = strtolower($doc['category']);
require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner Header -->
<?php renderPageBanner('document-view', $doc['title'], $doc['subtitle']); ?>

<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm border mb-0">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-navy text-decoration-none"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><span class="text-muted"><?php echo sanitize($doc['category']); ?></span></li>
                <li class="breadcrumb-item active text-danger fw-bold" aria-current="page"><?php echo sanitize($doc['title']); ?></li>
            </ol>
        </nav>

        <!-- Top Action Callout Banner -->
        <div class="card p-4 p-lg-5 border-0 shadow rounded-4 text-white mb-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #7A0B0D 0%, #16233f 100%);">
            <div class="row align-items-center g-4 position-relative z-2">
                <div class="col-12 col-lg-8">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="fas fa-file-pdf me-1"></i> <?php echo sanitize($doc['category']); ?> Official Document
                    </span>
                    <h2 class="h2 fw-bold text-white mb-3"><?php echo sanitize($doc['title']); ?></h2>
                    <p class="text-white-50 mb-4" style="line-height: 1.7; font-size: 0.98rem;">
                        <?php echo sanitize($doc['description']); ?>
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" download class="btn btn-warning text-dark fw-bold px-4 py-3 rounded-pill shadow">
                            <i class="fas fa-download me-2"></i> Download Official PDF
                        </a>
                        <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" target="_blank" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill">
                            <i class="fas fa-external-link-alt me-2"></i> View PDF Fullscreen
                        </a>
                        <a href="#pdf-viewer" class="btn btn-light text-navy fw-bold px-4 py-3 rounded-pill">
                            <i class="fas fa-eye me-2"></i> In-Page Preview
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-4 rounded-4 bg-white text-navy shadow-sm">
                        <h6 class="fw-bold text-navy mb-3"><i class="fas fa-info-circle text-danger me-2"></i> Document Information</h6>
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Type:</span>
                                <strong class="text-navy">Official PDF File</strong>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Category:</span>
                                <strong class="text-navy"><?php echo sanitize($doc['category']); ?></strong>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Compliance:</span>
                                <strong class="text-success">UGC / Regulatory Norms</strong>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Status:</span>
                                <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold">Active &amp; Verified</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 g-lg-5 mb-5">
            
            <!-- Left Column: Interactive PDF Viewer -->
            <div class="col-12 col-lg-8">
                
                <!-- PDF Preview Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-4" id="pdf-viewer">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <div>
                            <span class="section-subtitle"><i class="fas fa-file-pdf text-danger me-1"></i> DOCUMENT VIEWER</span>
                            <h3 class="h4 fw-bold text-navy mb-0"><?php echo sanitize($doc['title']); ?></h3>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" download class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
                                <i class="fas fa-download me-1"></i> Download PDF
                            </a>
                            <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" target="_blank" class="btn btn-sm btn-outline-navy rounded-pill px-3 fw-bold">
                                <i class="fas fa-external-link-alt me-1"></i> Fullscreen
                            </a>
                        </div>
                    </div>

                    <div class="ratio ratio-4x3 border rounded-4 overflow-hidden shadow-sm bg-light" style="min-height: 600px;">
                        <iframe src="<?php echo BASE_URL . $doc['pdf_path']; ?>#toolbar=1" class="w-100 h-100" style="border:none;" title="<?php echo sanitize($doc['title']); ?>">
                            <p class="p-4 text-center text-muted">
                                Your browser does not support embedded PDF viewing. 
                                <a href="<?php echo BASE_URL . $doc['pdf_path']; ?>" target="_blank" class="btn btn-danger btn-sm ms-2">Click here to download and view the PDF.</a>
                            </p>
                        </iframe>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar: Contact Desk & Related Documents -->
            <div class="col-12 col-lg-4">
                
                <!-- University Office Card -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-university text-danger me-2"></i> University Desk</h5>
                    <p class="text-muted small mb-3">
                        For questions, authentication, or queries regarding university regulations, circulars, or admissions:
                    </p>
                    <div class="p-3 rounded-3 bg-light border small text-muted mb-3">
                        <strong class="text-navy d-block mb-1">Sarvepalli Radhakrishnan University</strong>
                        NH-12, Hoshangabad Road, Misrod,<br>
                        Bhopal, Madhya Pradesh - 462026
                    </div>
                    <div class="d-flex flex-column gap-2 small">
                        <a href="tel:7024144981" class="text-decoration-none text-navy fw-semibold p-2 rounded-3 bg-light border d-flex align-items-center">
                            <i class="fas fa-phone-alt text-danger me-2"></i> University Helpline: 7024144981
                        </a>
                        <a href="mailto:info@srku.edu.in" class="text-decoration-none text-navy fw-semibold p-2 rounded-3 bg-light border d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-2"></i> info@srku.edu.in
                        </a>
                    </div>
                </div>

                <!-- Related Documents in this category -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-folder-open text-warning me-2"></i> Related Documents</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                        <?php 
                        $count = 0;
                        foreach ($documentsRegistry as $k => $item): 
                            if ($k === $slug) continue;
                            if ($item['category'] === $doc['category'] || $count < 4):
                                $count++;
                        ?>
                            <li>
                                <a href="<?php echo BASE_URL; ?>document/<?php echo urlencode($k); ?>" class="text-navy text-decoration-none p-2 rounded-3 bg-light border d-flex align-items-center justify-content-between hover-text-danger">
                                    <span class="fw-semibold text-truncate me-2"><i class="fas fa-file-pdf text-danger me-2"></i> <?php echo sanitize($item['title']); ?></span>
                                    <i class="fas fa-chevron-right text-muted flex-shrink-0"></i>
                                </a>
                            </li>
                        <?php 
                            endif;
                            if ($count >= 5) break;
                        endforeach; 
                        ?>
                    </ul>
                </div>

                <!-- Online Quick Pre-Registration / Contact -->
                <div class="card p-4 border-0 shadow rounded-4 text-white text-center" style="background: linear-gradient(135deg, var(--srku-maroon), var(--srku-navy));">
                    <i class="fas fa-graduation-cap fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold text-white mb-2">Admissions 2026-27</h5>
                    <p class="text-white-50 small mb-3">Apply online for undergraduate, postgraduate, diploma, and Ph.D. programmes.</p>
                    <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn btn-warning text-dark fw-bold rounded-pill w-100 py-2">
                        <i class="fas fa-paper-plane me-1"></i> Apply Online Now
                    </a>
                </div>

            </div>

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
